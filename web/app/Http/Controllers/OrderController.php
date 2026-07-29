<?php

namespace App\Http\Controllers;

use App\Mail\AdminOrderNotification;
use App\Mail\OrderSuccess;
use App\Models\Cart;
use App\Models\CustomproductDesign;
use App\Models\ProductOrder;
use App\Models\ProductOrderDetail;
use App\Models\ProductOrderUserAddress;
use App\Models\SampleOrderFullDetail;
use App\Models\UserAddress;
use App\Services\PayPalService;
use App\Services\CurrencyService;
use App\Models\BankDetails;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Show the checkout page.
     */
    public function checkout()
    {
        $user = Auth::user();
        $sessionId = session()->getId();

        $query = Cart::with('design');

        if ($user) {
            $query->where('user_id', $user->user_id);
        } else {
            $query->where('session_id', $sessionId);
        }

        $cartItems = $query->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Addresses only for logged in users
        $addresses = $user ? UserAddress::where('user_id', $user->user_id)->get() : collect([]);
        $defaultAddress = $addresses->where('is_default', 1)->first() ?? $addresses->first();

        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->product_quantity;
        });

        $bankDetails = BankDetails::all();

    $totalQuantity = $cartItems->sum('product_quantity');
    $checkoutSetting = \App\Models\CheckoutSetting::first();
    $paypalMaxQty = $checkoutSetting ? $checkoutSetting->paypal_max_quantity : 10;

    return view('pages.checkout', compact('cartItems', 'addresses', 'defaultAddress', 'subtotal', 'bankDetails', 'totalQuantity', 'paypalMaxQty'));
}

    /**
     * Handle the order placement and data snapshotting.
     */
    /**
     * Handle the order placement and data snapshotting.
     */
    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        Log::info('Order Placement Started', ['user_id' => $user->user_id, 'payment_method' => $request->payment_method]);
        
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'payment_method' => 'required|string',
            'printing_method' => 'required|string|in:CTF,DTG',
            'bank_country' => 'nullable|string',
            'paypal_order_id' => 'nullable|string',
            'paypal_payer_id' => 'nullable|string',
        ]);

        // Handle PayPal Payment flow
        if ($request->payment_method === 'paypal') {
            return $this->processPayPalOrder($request, $user);
        }

        // Handle COD / Manual Payment flow (Direct from Cart)
        return $this->processDirectOrder($request, $user);
    }

    /**
     * Process Razorpay Order (Post-Payment)
     */
    private function processRazorpayOrder(Request $request, $user)
    {
        $checkoutData = session('checkout_data');

        if (!$checkoutData) {
            return response()->json([
                'success' => false, 
                'message' => 'Session expired or invalid. Please try again.'
            ], 400);
        }

        if (!$request->razorpay_payment_id || !$request->razorpay_order_id || !$request->razorpay_signature) {
             return response()->json([
                'success' => false,
                'message' => 'Invalid payment details'
            ], 422);
        }

        // Update Razorpay Invoice ID if needed (or verify order ID matches)
        if ($checkoutData['razorpay_order_id'] !== $request->razorpay_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Order ID mismatch.'
            ], 400);
        }

        try {
            $api = new Api(config('services.razorpay.key_id'), config('services.razorpay.key_secret'));
            
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ], 500);
        }

        // Payment Verified. Create Order from Session Data.
        DB::beginTransaction();
        try {
            $cartItems = collect($checkoutData['cart_items']); // Restore collection
            $totalAmount = $checkoutData['total_amount'];
            $addressId = $checkoutData['address_id'];
            
            $address = UserAddress::findOrFail($addressId);

            // 1. Create ProductOrder
            $orderId = $this->generateOrderId();
            $firstItem = $cartItems->first();
            $orderType = 0;
            if (isset($firstItem['product_type']) && $firstItem['product_type'] === 'sample') $orderType = 1;
            elseif (isset($firstItem['product_type']) && $firstItem['product_type'] === 'own') $orderType = 2;

            // Get selected currency info
            $selectedCurrency = session('currency', 'INR');
            $currencyService = app(CurrencyService::class);
            $exchangeRate = $currencyService->getRate('INR', $selectedCurrency);
            $convertedAmount = $currencyService->convert('INR', $selectedCurrency, $totalAmount);

            $order = ProductOrder::create([
                'order_id' => $orderId,
                'user_id' => $user->user_id,
                'total_amount' => $totalAmount,
                'grand_total_amount' => $totalAmount,
                'payment_method' => 'razorpay',
                'payment_status' => 1, // Paid
                'delivery_status' => 0,
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'order_type' => $orderType,
                'date_ordered_on' => now(),
                'gst_amount' => 0,
                'discount_amount' => 0,
                'delivery_charge' => 0,
                'is_cancelled' => 0,
                'approve_staus' => 0,
                'base_currency' => 'INR',
                'base_amount' => $totalAmount,
                'selected_currency' => $selectedCurrency,
                'converted_amount' => $convertedAmount,
                'exchange_rate' => $exchangeRate,
            ]);

            // 2. Create ProductOrderDetail & Deduct Stock
            foreach ($cartItems as $item) {
                $designSnapshot = null;
                if ($item['product_type'] === 'custom' && isset($item['design_id'])) {
                    $designSnapshot = $this->captureDesignSnapshot($order->order_id, $item);
                }

                \App\Models\ProductOrderDetail::create([
                    'order_id' => $order->order_id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'product_image' => $item['product_image'],
                    'product_rate' => $item['price'],
                    'quantity' => $item['product_quantity'],
                    'product_total' => $item['price'] * $item['product_quantity'],
                    'size_value' => $item['product_size'],
                    'color_value' => $item['product_color'],
                    'delivery_status' => 0,
                    'approve_staus' => 0,
                    'design_id' => $item['design_id'] ?? null,
                    'snapshot_path' => $designSnapshot['path'] ?? null,
                    'snapshot_json' => isset($designSnapshot['json']) ? json_encode($designSnapshot['json']) : null,
                ]);

                // Update Stock
                $this->decrementStock($item['product_id'], $item['product_type'], $item['product_quantity']);
            }

            // 3. Create SampleOrderFullDetail
            $this->createOrderFullDetail($order, $user, $address, $totalAmount, 'razorpay', $request->razorpay_order_id, $request->razorpay_payment_id, $cartItems, $request->printing_method, $request->bank_country);

            // 4. Create ProductOrderUserAddress
            $this->createOrderUserAddress($order, $user, $address);

            // 5. Clear Cart
            Cart::where('user_id', $user->user_id)->delete();
            session()->forget('checkout_data');

            DB::commit();

            // Send order confirmation email
            try {
                Mail::to($user->email)->send(new OrderSuccess($order, $user, $cartItems));
            } catch (\Exception $e) {
                // Log the error but don't fail the order
                \Log::warning('Failed to send order confirmation email: ' . $e->getMessage());
            }

            // Send admin notification email
            try {
                $adminEmail = env('ADMIN_EMAIL', 'ss9819690@gmail.com');
                Mail::to($adminEmail)->send(new AdminOrderNotification($order, $user, $cartItems));
            } catch (\Exception $e) {
                // Log the error but don't fail the order
                \Log::warning('Failed to send admin notification email: ' . $e->getMessage());
            }

            Log::info('Order Placement Completed', ['order_id' => $order->order_id]);

             return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $order->order_id,
                'redirect' => route('order.success') . '?id=' . $order->order_id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to place order: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Capture a frozen snapshot of the design files and JSON
     */
    private function captureDesignSnapshot($orderId, $cartItem)
    {
        try {
            $design = CustomproductDesign::find($cartItem['design_id']);
            if (!$design) return null;

            $snapshotFolder = "order_snapshots/order_{$orderId}/item_{$cartItem['product_id']}";
            $snapshotData = [
                'path' => $snapshotFolder,
                'json' => [
                    'front' => $design->design_json_front,
                    'back' => $design->design_json_back,
                    'chest' => $design->design_json_chest,
                ]
            ];

            // Copy physical files to snapshot folder
            $sides = ['front', 'back', 'chest', 'shoulder', 'right_shoulder', 'left_shoulder'];
            foreach ($sides as $side) {
                $col = "preview_image_{$side}";
                if ($design->$col && Storage::disk('shared')->exists($design->$col)) {
                    $ext = pathinfo($design->$col, PATHINFO_EXTENSION) ?: 'png';
                    $newPath = "{$snapshotFolder}/{$side}.{$ext}";
                    Storage::disk('shared')->copy($design->$col, $newPath);
                }
            }

          // Mark design as ordered
            $design->update(['status' => 'ordered']);

            return $snapshotData;
        } catch (\Exception $e) {
            \Log::error('Snapshot Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Process PayPal Order (Post-Payment Capture)
     */
    private function processPayPalOrder(Request $request, $user)
    {
        $checkoutData = session('checkout_data');

        if (!$checkoutData) {
            return response()->json([
                'success' => false, 
                'message' => 'Session expired or invalid. Please try again.'
            ], 400);
        }

        if (!$request->paypal_order_id) {
             return response()->json([
                'success' => false,
                'message' => 'Invalid payment details'
            ], 422);
        }

        // Verify PayPal order ID matches
        if ($checkoutData['paypal_order_id'] !== $request->paypal_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Order ID mismatch.'
            ], 400);
        }

        try {
            // Capture the PayPal payment
            $paypalService = new PayPalService();
            $captureResult = $paypalService->captureOrder($request->paypal_order_id);
            
            // Extract payer ID from capture result
            $payerID = $captureResult['payer']['payer_id'] ?? null;
            $captureID = $captureResult['purchase_units'][0]['payments']['captures'][0]['id'] ?? null;

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment capture failed: ' . $e->getMessage()
            ], 500);
        }

        // Payment Captured. Create Order from Session Data.
        DB::beginTransaction();
        try {
            $cartItems = collect($checkoutData['cart_items']);
            $totalAmount = $checkoutData['total_amount'];
            $addressId = $checkoutData['address_id'];
            
            $address = UserAddress::findOrFail($addressId);

            // 1. Create ProductOrder
            $orderId = $this->generateOrderId();
            $firstItem = $cartItems->first();
            $orderType = 0;
            if (isset($firstItem['product_type']) && $firstItem['product_type'] === 'sample') $orderType = 1;
            elseif (isset($firstItem['product_type']) && $firstItem['product_type'] === 'own') $orderType = 2;

            $order = ProductOrder::create([
                'order_id' => $orderId,
                'user_id' => $user->user_id,
                'total_amount' => $totalAmount,
                'grand_total_amount' => $totalAmount,
                'payment_method' => 'paypal',
                'payment_status' => 1, // Paid
                'delivery_status' => 0,
                'paypal_payment_id' => $request->paypal_order_id,
                'paypal_payer_id' => $payerID,
                'order_type' => $orderType,
                'date_ordered_on' => now(),
                'gst_amount' => 0,
                'discount_amount' => 0,
                'delivery_charge' => 0,
                'is_cancelled' => 0,
                'approve_staus' => 0,
                'base_currency' => $checkoutData['base_currency'] ?? 'INR',
                'base_amount' => $checkoutData['total_amount'] ?? $totalAmount,
                'selected_currency' => $checkoutData['selected_currency'] ?? 'USD',
                'converted_amount' => $checkoutData['converted_amount'] ?? $totalAmount,
                'exchange_rate' => $checkoutData['exchange_rate'] ?? 1.0,
                'printing_method' => $checkoutData['printing_method'] ?? 'CTF',
                'bank_country' => $checkoutData['bank_country'] ?? null,
            ]);

            // 2. Create ProductOrderDetail & Deduct Stock
            foreach ($cartItems as $item) {
                $designSnapshot = null;
                if ($item['product_type'] === 'custom' && isset($item['design_id'])) {
                    $designSnapshot = $this->captureDesignSnapshot($order->order_id, $item);
                }

                \App\Models\ProductOrderDetail::create([
                    'order_id' => $order->order_id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'product_image' => $item['product_image'],
                    'product_rate' => $item['price'],
                    'quantity' => $item['product_quantity'],
                    'product_total' => $item['price'] * $item['product_quantity'],
                    'size_value' => $item['product_size'],
                    'color_value' => $item['product_color'],
                    'delivery_status' => 0,
                    'approve_staus' => 0,
                    'design_id' => $item['design_id'] ?? null,
                    'snapshot_path' => $designSnapshot['path'] ?? null,
                    'snapshot_json' => isset($designSnapshot['json']) ? json_encode($designSnapshot['json']) : null,
                ]);

                $this->decrementStock($item['product_id'], $item['product_type'], $item['product_quantity']);
            }

            // 3. Create SampleOrderFullDetail
            $this->createOrderFullDetail($order, $user, $address, $totalAmount, 'paypal', $request->paypal_order_id, $payerID, $cartItems, $checkoutData['printing_method'] ?? 'CTF', $checkoutData['bank_country'] ?? null);

            // 4. Create ProductOrderUserAddress
            $this->createOrderUserAddress($order, $user, $address);

            // 5. Clear Cart
            Cart::where('user_id', $user->user_id)->delete();
            session()->forget('checkout_data');

            DB::commit();

            // Send order confirmation email
            try {
                Mail::to($user->email)->send(new OrderSuccess($order, $user, $cartItems));
            } catch (\Exception $e) {
                \Log::warning('Failed to send order confirmation email: ' . $e->getMessage());
            }

            // Send admin notification email
            try {
                $adminEmail = env('ADMIN_EMAIL', 'ss9819690@gmail.com');
                Mail::to($adminEmail)->send(new AdminOrderNotification($order, $user, $cartItems));
            } catch (\Exception $e) {
                \Log::warning('Failed to send admin notification email: ' . $e->getMessage());
            }

            Log::info('Order Placement Completed', ['order_id' => $order->order_id]);

             return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $order->order_id,
                'redirect' => route('order.success') . '?id=' . $order->order_id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to place order: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Process Direct Order (COD/MP) from Cart
     */
    private function processDirectOrder(Request $request, $user)
    {
        $cartItems = Cart::where('user_id', $user->user_id)->with('design')->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Cart is empty.'], 422);
        }

        // Validate Stock
        foreach ($cartItems as $item) {
             $error = $this->checkStock($item->product_id, $item->product_type, $item->product_quantity, $item->product_name);
             if ($error) return response()->json(['success' => false, 'message' => $error], 422);
        }

        // Validate Quantity Limits
        $qtyError = $this->checkQuantityLimits($cartItems);
        if ($qtyError) return response()->json(['success' => false, 'message' => $qtyError], 422);

        $address = UserAddress::findOrFail($request->address_id);
        $totalAmount = $cartItems->sum(function($item) {
            return $item->price * $item->product_quantity;
        });

        DB::beginTransaction();
        try {
             // 1. Create ProductOrder
            $orderId = $this->generateOrderId();
            $firstItem = $cartItems->first();
            $orderType = 0;
            if ($firstItem->product_type === 'sample') $orderType = 1;
            elseif ($firstItem->product_type === 'own') $orderType = 2;

            $paymentStatus = match($request->payment_method) {
                'cod' => 2,
                'mp' => 3,
                default => 0
            };

            // Get selected currency info
            $selectedCurrency = session('currency', 'INR');
            $currencyService = app(CurrencyService::class);
            $exchangeRate = $currencyService->getRate('INR', $selectedCurrency);
            $convertedAmount = $currencyService->convert('INR', $selectedCurrency, $totalAmount);

            $order = ProductOrder::create([
                'order_id' => $orderId,
                'user_id' => $user->user_id,
                'total_amount' => $totalAmount,
                'grand_total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
                'delivery_status' => 0,
                'order_type' => $orderType,
                'date_ordered_on' => now(),
                'gst_amount' => 0,
                'discount_amount' => 0,
                'delivery_charge' => 0,
                'is_cancelled' => 0,
                'approve_staus' => 0,
                'base_currency' => 'INR',
                'base_amount' => $totalAmount,
                'selected_currency' => $selectedCurrency,
                'converted_amount' => $convertedAmount,
                'exchange_rate' => $exchangeRate,
                'printing_method' => $request->printing_method,
                'bank_country' => $request->bank_country,
            ]);

            // 2. Create Details & Deduct Stock
            foreach ($cartItems as $item) {
                $designSnapshot = null;
                if ($item->product_type === 'custom' && isset($item->design_id)) {
                    $designSnapshot = $this->captureDesignSnapshot($order->order_id, $item->toArray());
                }

                \App\Models\ProductOrderDetail::create([
                    'order_id' => $order->order_id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'product_image' => $item->product_image,
                    'product_rate' => $item->price,
                    'quantity' => $item->product_quantity,
                    'product_total' => $item->price * $item->product_quantity,
                    'size_value' => $item->product_size,
                    'color_value' => $item->product_color,
                    'delivery_status' => 0,
                    'approve_staus' => 0,
                    'design_id' => $item->design_id,
                    'snapshot_path' => $designSnapshot['path'] ?? null,
                    'snapshot_json' => isset($designSnapshot['json']) ? json_encode($designSnapshot['json']) : null,
                ]);

                $this->decrementStock($item->product_id, $item->product_type, $item->product_quantity);
            }

            // 3. Full Details
            $this->createOrderFullDetail($order, $user, $address, $totalAmount, $request->payment_method, null, null, $cartItems, $request->printing_method, $request->bank_country);

            // 4. Address
            $this->createOrderUserAddress($order, $user, $address);

            // 5. Clear Cart
            Cart::where('user_id', $user->user_id)->delete();

            DB::commit();

            // Send order confirmation email
            try {
                Mail::to($user->email)->send(new OrderSuccess($order, $user, $cartItems));
            } catch (\Exception $e) {
                // Log the error but don't fail the order
                \Log::warning('Failed to send order confirmation email: ' . $e->getMessage());
            }

            // Send admin notification email
            try {
                $adminEmail = env('ADMIN_EMAIL', 'ss9819690@gmail.com');
                Mail::to($adminEmail)->send(new AdminOrderNotification($order, $user, $cartItems));
            } catch (\Exception $e) {
                // Log the error but don't fail the order
                \Log::warning('Failed to send admin notification email: ' . $e->getMessage());
            }

             return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $order->order_id,
                'redirect' => route('order.success') . '?id=' . $order->order_id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to place order: ' . $e->getMessage()], 500);
        }
    }

    private function checkStock($productId, $type, $quantity, $productName) {
        // Samples, own designs & custom designs are made to order — unlimited stock
        if ($type === 'sample' || $type === 'custom' || $type === 'own') return null;
        
        $product = \App\Models\Design::find($productId);
        
        if (!$product) return "Product not found: $productName";
        if (isset($product->stocks) && $product->stocks < $quantity) {
            return "Insufficient stock for $productName. Only {$product->stocks} available.";
        }
        return null;
    }

    private function decrementStock($productId, $type, $quantity) {
        // Samples, own designs & custom designs are made to order — no stock to decrement
        if ($type === 'sample' || $type === 'custom' || $type === 'own') return;
        
        $product = \App\Models\Design::find($productId);
        
        if ($product && isset($product->stocks) && $product->stocks >= $quantity) {
             $product->decrement('stocks', $quantity);
        }
        
        // Update productstocks table if exists
        $stock = \App\Models\ProductStock::where('productid', $productId)->first();
        if ($stock) {
            $stock->decrement('availablestock', $quantity);
            $stock->increment('salestock', $quantity);
            $stock->update(['last_stockupdate_date' => now()]);
        }
    }

    private function checkQuantityLimits($cartItems)
    {
        foreach ($cartItems as $item) {
            $appSetting = get_app_setting($item->product_type);
            if ($appSetting) {
                if ($item->product_quantity < $appSetting->min_quantity) {
                    return "Minimum {$appSetting->min_quantity} units required for {$item->product_name}.";
                }
                if ($appSetting->max_quantity && $item->product_quantity > $appSetting->max_quantity) {
                    return "Maximum {$appSetting->max_quantity} units allowed for {$item->product_name}.";
                }
            }
        }
    }

    private function createOrderFullDetail($order, $user, $address, $totalAmount, $paymentDetails, $rzpOrderId, $rzpPaymentId, $items, $printingMethod = null, $bankCountry = null) {
         // Transform items if it's a collection of models or array of arrays
         $itemsArray = ($items instanceof \Illuminate\Support\Collection) ? $items->toArray() : $items;
 
         SampleOrderFullDetail::create([
                'order_primary_id' => $order->id,
                'order_id' => $order->order_id,
                'user_id' => $user->user_id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_phone' => $user->phone_number,
                'address_username' => $address->address_username,
                'address_phone_number' => $address->address_phone_number,
                'address_line_one' => $address->address_line_one,
                'address_line_two' => $address->address_line_two,
                'landmark' => $address->landmark,
                'city' => $address->city,
                'state' => $address->state,
                'pincode' => $address->pincode,
                'country' => $address->country,
                'address_type_name' => $address->address_type_name,
                'total_amount' => $totalAmount,
                'grand_total_amount' => $totalAmount,
                'payment_method' => $paymentDetails,
                'razorpay_order_id' => $rzpOrderId,
                'razorpay_payment_id' => $rzpPaymentId,
                'printing_method' => $printingMethod,
                'bank_country' => $bankCountry,
                'payment_status_text' => match($paymentDetails) {
                    'razorpay' => 'Paid',
                    'cod' => 'COD',
                    'mp' => 'Bank Transfer - Pending',
                    default => 'paid'
                },
                'order_items' => array_map(function($item) {
                    // If it's a custom design, attach the full "Frozen" design snapshot
                    if (isset($item['product_type']) && $item['product_type'] === 'custom' && isset($item['design'])) {
                        $item['design_snapshot'] = [
                            'front_json' => $item['design']['design_json_front'] ?? null,
                            'back_json' => $item['design']['design_json_json_back'] ?? null,
                            'preview_front' => $item['design']['preview_image_front'] ?? null,
                            'preview_back' => $item['design']['preview_image_back'] ?? null,
                            'layers' => $item['design']['layers'] ?? []
                        ];
                        // Unset the reactive model reference after snapshotting
                        unset($item['design']);
                    }
                    return $item;
                }, $itemsArray),
            ]);
        Log::info('Order Full Detail Created', ['order_id' => $order->order_id, 'items_count' => count($itemsArray)]);
    }

    private function createOrderUserAddress($order, $user, $address) {
        \App\Models\ProductOrderUserAddress::create([
                'user_id' => $user->user_id,
                'order_id' => $order->order_id,
                'address_username' => $address->address_username,
                'address_line_one' => $address->address_line_one,
                'address_line_two' => $address->address_line_two,
                'landmark' => $address->landmark,
                'city' => $address->city,
                'state' => $address->state,
                'pincode' => $address->pincode,
                'country' => $address->country,
                'address_phone_number' => $address->address_phone_number,
                'address_type_id' => $address->address_type_id,
                'address_type_name' => $address->address_type_name,
        ]);
    }

    private function generateOrderId()
    {
        $prefix = 'ORD-SAA-';
        $latestOrder = ProductOrder::where('order_id', 'LIKE', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if (!$latestOrder) {
            return $prefix . '001';
        }

        $latestOrderId = $latestOrder->order_id;
        $orderNumber = (int) str_replace($prefix, '', $latestOrderId);
        $newOrderNumber = $orderNumber + 1;

        return $prefix . str_pad($newOrderNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Show the order success page.
     */
    public function success(Request $request)
    {
        $orderId = $request->get('id');
        $order = ProductOrder::where('order_id', $orderId)->firstOrFail();
        $details = SampleOrderFullDetail::where('order_id', $orderId)->firstOrFail();

        return view('pages.ordersuccess', compact('order', 'details'));
    }

    /**
     * Show bank account details for manual payment.
     */
    public function showBankDetails(Request $request)
    {
        $orderId = $request->get('order_id');
        $order = null;
        $bankDetails = null;
        
        if ($orderId) {
            $order = ProductOrder::where('order_id', $orderId)->first();
            if ($order) {
                // Try from bank_country field first, then fallback to full details
                $country = $order->bank_country;
                if (!$country) {
                    $fullDetail = SampleOrderFullDetail::where('order_primary_id', $order->id)->first();
                    $country = $fullDetail ? $fullDetail->country : null;
                }

                if ($country) {
                    $country = trim($country);
                    $bankDetails = BankDetails::where('bank_country', 'LIKE', "%{$country}%")->first();
                }
            }
        }

        if (!$bankDetails) {
            $bankDetails = BankDetails::first();
        }
        
        return view('pages.bank-details', compact('order', 'bankDetails'));
    }

    /**
     * Create Razorpay order for payment processing.
     */
    public function createRazorpayOrder(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'printing_method' => 'required|string|in:CTF,DTG',
        ]);

        $cartItems = Cart::where('user_id', $user->user_id)->with('design')->get();
        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ], 422);
        }

        // Validate stock
        foreach ($cartItems as $item) {
            $error = $this->checkStock($item->product_id, $item->product_type, $item->product_quantity, $item->product_name);
            if ($error) return response()->json(['success' => false, 'message' => $error], 422);
        }

        // Validate Quantity Limits
        $qtyError = $this->checkQuantityLimits($cartItems);
        if ($qtyError) return response()->json(['success' => false, 'message' => $qtyError], 422);

        $totalAmount = $cartItems->sum(function($item) {
            return $item->price * $item->product_quantity;
        });

        try {
            $api = new Api(config('services.razorpay.key_id'), config('services.razorpay.key_secret'));
            
            $orderData = [
                'receipt' => 'order_rcptid_' . time() . '_' . $user->user_id,
                'amount' => $totalAmount * 100, // amount in paise
                'currency' => 'INR',
                'payment_capture' => 1 // Auto capture
            ];

            $razorpayOrder = $api->order->create($orderData);
            
            // Store checkout data in Session
            session([
                'checkout_data' => [
                    'user_id' => $user->user_id,
                    'cart_items' => $cartItems->toArray(), // store as array
                    'total_amount' => $totalAmount,
                    'address_id' => $request->address_id,
                    'razorpay_order_id' => $razorpayOrder->id,
                    'created_at' => now()
                ]
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $razorpayOrder->id,
                'amount' => $totalAmount,
                'key' => config('services.razorpay.key_id')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating order: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Get order details for AJAX request.
     */
    public function getDetails($orderId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $order = ProductOrder::with(['items', 'shippingAddress'])
            ->where('order_id', $orderId)
            ->where('user_id', $user->user_id)
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        // Get sample full details early so we can use it for country lookup
        $fullDetail = SampleOrderFullDetail::where('order_primary_id', $order->id)->first();

        // If items are empty in product_slots, try to get from sample_order_full_details
        if ($order->items->isEmpty()) {
            if ($fullDetail && isset($fullDetail->order_items)) {
                // Convert cart items format to product_slots format
                $order->items = collect($fullDetail->order_items)->map(function($item) {
                    // Build full image URL
                    $imageUrl = '';
                    if (!empty($item['product_image'])) {
                        $imageUrl = env('MAIN_URL') . 'images/' . $item['product_image'];
                    }
                    
                    return (object)[
                        'product_name' => $item['product_name'] ?? 'N/A',
                        'product_image' => $imageUrl,
                        'product_rate' => $item['price'] ?? 0,
                        'quantity' => $item['product_quantity'] ?? 1,
                        'product_total' => ($item['price'] ?? 0) * ($item['product_quantity'] ?? 1),
                        'size_value' => $item['product_size'] ?? null,
                        'color_value' => $item['product_color'] ?? null,
                    ];
                });
            }
        }

        // Add formatted strings
        // Add formatted strings to data response
        $order->formatted_date = $order->date_ordered_on ? $order->date_ordered_on->format('d M Y, h:i A') : $order->created_at->format('d M Y, h:i A');
        $order->status_text = $order->delivery_status_text;

        // Convert order to array for JSON response
        $orderData = $order->toArray();
        $orderData['formatted_date'] = $order->formatted_date;
        $orderData['status_text'] = $order->status_text;
        $orderData['status_color'] = $order->status_color;
        $orderData['payment_status_text'] = $order->payment_status_text;
        $orderData['payment_method_text'] = $order->payment_method_text;
        $orderData['order_type_text'] = $order->order_type_text;
        
        // Ensure items is an array, not a collection
        if ($order->items instanceof \Illuminate\Support\Collection) {
            $orderData['items'] = $order->items->values()->all();
        }

        // Add dynamic bank details for bank transfer context
        $bankDetails = null;
        if ($fullDetail && $fullDetail->country) {
            $country = trim($fullDetail->country);
            $bankDetails = \App\Models\BankDetails::where('bank_country', 'LIKE', "%{$country}%")->first();
        }
        if (!$bankDetails) {
            $bankDetails = \App\Models\BankDetails::first();
        }
        $orderData['bank_details'] = $bankDetails ? $bankDetails->toArray() : null;

        return response()->json([
            'success' => true,
            'order' => $orderData
        ]);
    }

    /**
     * Create PayPal Payment
     */
    public function createPayPalPayment(Request $request)
    {
        $user = Auth::user();
        $request->validate(['address_id' => 'required|exists:user_addresses,id']);

        $cartItems = Cart::where('user_id', $user->user_id)->with('design')->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Cart is empty.'], 422);
        }

        // Validate Stock
        foreach ($cartItems as $item) {
             $error = $this->checkStock($item->product_id, $item->product_type, $item->product_quantity, $item->product_name);
             if ($error) return response()->json(['success' => false, 'message' => $error], 422);
        }

        // Validate Quantity Limits
        $qtyError = $this->checkQuantityLimits($cartItems);
        if ($qtyError) return response()->json(['success' => false, 'message' => $qtyError], 422);

        $totalQuantity = $cartItems->sum('product_quantity');
        $checkoutSetting = \App\Models\CheckoutSetting::first();
        $paypalMaxQty = $checkoutSetting ? $checkoutSetting->paypal_max_quantity : 10;
        if ($totalQuantity > $paypalMaxQty) {
            return response()->json(['success' => false, 'message' => 'PayPal is only available for orders up to ' . $paypalMaxQty . ' items. Please use Bank Transfer.'], 422);
        }

        $totalAmount = $cartItems->sum(function($item) {
            return $item->price * $item->product_quantity;
        });

        try {
            $currencyService = app(\App\Services\CurrencyService::class);
            $paypalService = new PayPalService();
            
            // 1. Determine target currency safely
            $selectedCurrency = session('currency', 'INR');
            $supportedCurrencies = $currencyService->getSupportedCurrencies();
            
            // PayPal's strictly supported currency list (3-letter ISO codes)
            // Reference: https://developer.paypal.com/docs/reports/reference/paypal-supported-currencies/
            $paypalSupported = [
                'AUD', 'BRL', 'CAD', 'CNY', 'CZK', 'DKK', 'EUR', 'HKD', 
                'HUF', 'ILS', 'INR', 'JPY', 'MYR', 'MXN', 'TWD', 'NZD', 
                'NOK', 'PHP', 'PLN', 'GBP', 'RUB', 'SGD', 'SEK', 'CHF', 
                'THB', 'USD'
            ];

            Log::info('PayPal Currency Check', [
                'session_currency' => $selectedCurrency,
                'in_app_supported' => array_key_exists($selectedCurrency, $supportedCurrencies),
                'in_paypal_supported' => in_array($selectedCurrency, $paypalSupported),
            ]);

            // Fallback securely: If not in our app's supported list, or not supported by PayPal, fallback to INR
            if (!array_key_exists($selectedCurrency, $supportedCurrencies) || !in_array($selectedCurrency, $paypalSupported)) {
                Log::warning('Currency Fallback for PayPal', ['requested' => $selectedCurrency, 'fallback' => 'INR']);
                $selectedCurrency = 'INR';
            }

            // 2. Convert from base currency (INR) to selected currency
            // All product prices in the database are stored in INR
            $baseCurrency = 'INR';
            $exchangeRate = 1.0;
            $convertedAmount = $totalAmount;

            if ($baseCurrency !== $selectedCurrency) {
                $exchangeRate = $currencyService->getRate($baseCurrency, $selectedCurrency);
                $convertedAmount = round($totalAmount * $exchangeRate, 2);
            }

            Log::info('PayPal Amount Conversion', [
                'base_currency' => $baseCurrency,
                'selected_currency' => $selectedCurrency,
                'original_amount_inr' => $totalAmount,
                'exchange_rate' => $exchangeRate,
                'converted_amount' => $convertedAmount,
            ]);

            $returnUrl = route('paypal.execute');
            $cancelUrl = route('checkout');

            // 3. Create PayPal order with the converted amount in the selected currency
            $paypalOrder = $paypalService->createOrder($convertedAmount, $selectedCurrency, $returnUrl, $cancelUrl);

            // Store checkout data in session for capture verification
            $cartItemsArray = $cartItems->map(function($item) {
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'product_image' => $item->product_image,
                    'price' => $item->price,
                    'product_quantity' => $item->product_quantity,
                    'product_size' => $item->product_size,
                    'product_color' => $item->product_color,
                    'product_type' => $item->product_type,
                    'design' => $item->design ? $item->design->toArray() : null,
                ];
            })->toArray();

            session([
                'checkout_data' => [
                    'cart_items' => $cartItemsArray,
                    'total_amount' => $totalAmount, // Note: storing base amount for internal checks
                    'base_currency' => $baseCurrency,
                    'selected_currency' => $selectedCurrency,
                    'converted_amount' => $convertedAmount,
                    'exchange_rate' => $exchangeRate,
                    'address_id' => $request->address_id,
                    'printing_method' => $request->printing_method,
                    'paypal_order_id' => $paypalOrder['id'],
                ]
            ]);

            // Find approval URL
            $approvalUrl = collect($paypalOrder['links'])->firstWhere('rel', 'approve')['href'] ?? null;

            return response()->json([
                'success' => true,
                'order_id' => $paypalOrder['id'],
                'approval_url' => $approvalUrl,
                'amount' => $totalAmount
            ]);

        } catch (\Exception $e) {
            Log::error('PayPal Order Creation Failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to create PayPal payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Execute PayPal Payment (Return URL)
     */
    public function executePayPalPayment(Request $request)
    {
        $user = Auth::user();
        $paypalOrderId = $request->query('token');

        if (!$paypalOrderId) {
            return redirect()->route('checkout')->with('error', 'Invalid PayPal response');
        }

        // Redirect to a page that will trigger the capture via AJAX
        return view('pages.paypal-execute', [
            'paypal_order_id' => $paypalOrderId
        ]);
    }

    /**
     * Cancel PayPal Payment
     */
    public function cancelPayPalPayment()
    {
        session()->forget('checkout_data');
        return redirect()->route('checkout')->with('error', 'Payment cancelled');
    }

    /**
     * Upload Payment Proof for Manual Payment
     */
    public function uploadPaymentProof(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Max 5MB
        ]);

        try {
            $order = ProductOrder::where('order_id', $request->order_id)->first();
            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
            }

            if ($request->hasFile('payment_proof')) {
                $image = $request->file('payment_proof');
                $filename = 'proof_' . $order->order_id . '_' . time() . '.' . $image->getClientOriginalExtension();
                
                // Ensure directory exists in the dashboard project
                $path = env('UPLOAD_PATH') . DIRECTORY_SEPARATOR . 'proof';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $image->move($path, $filename);

                // Delete old proof if exists
                if ($order->payment_proof && file_exists($path . '/' . $order->payment_proof)) {
                    @unlink($path . '/' . $order->payment_proof);
                }

                $order->update(['payment_proof' => $filename]);

                return response()->json([
                    'success' => true,
                    'message' => 'Payment proof uploaded successfully!',
                    'proof_url' => rtrim(env('UPLOAD_URL'), '/') . '/proof/' . $filename
                ]);
            }

            return response()->json(['success' => false, 'message' => 'No file uploaded.'], 400);

        } catch (\Exception $e) {
            Log::error('Proof Upload Error', ['error' => $e->getMessage()]);
        return response()->json(['success' => false, 'message' => 'An error occurred during upload.'], 500);
        }
    }
}

