<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Sample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart page.
     */
    public function index()
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
        return view('pages.cart', compact('cartItems'));
    }

    /**
     * Add a sample or product to the cart.
     */
    public function addToCart(Request $request)
    {
        \Log::info('Cart Add Started', [
            'type'      => $request->type,
            'id'        => $request->id,
            'design_id' => $request->design_id,
            'body'      => $request->all(),
        ]);

        $request->validate([
            'id'        => 'nullable|integer',          // not required for custom type
            'type'      => 'required|string|in:sample,own,custom',
            'quantity'  => 'nullable|integer|min:1',
            'size'      => 'nullable|string',
            'color'     => 'nullable|string',
            'design_id' => 'required_if:type,custom|integer|exists:customproduct_designs,id',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add items to your cart.'
            ], 401);
        }

        $user = Auth::user();
        $userId = $user->user_id;
        $sessionId = session()->getId();

        $productId = $request->id;
        $type = $request->type;
        $quantity = $request->quantity ?? 1;

        if ($type === 'custom') {
            // Custom design product
            $design = \App\Models\CustomproductDesign::findOrFail($request->design_id);
            
            // Verify ownership (user or session)
            if ($design->user_id) {
                if (!$user || $design->user_id != $user->user_id) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized access to this design.'], 403);
                }
            } else {
                // Design is a guest design — if user is logged in, claim it
                if ($user) {
                    $design->user_id = $user->user_id;
                    $design->session_id = null;
                    $design->save();
                } elseif ($design->session_id !== $sessionId) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized access to this design.'], 403);
                }
            }

            $customProduct = $design->customproduct;
            $productId = $customProduct->id;
            $productName = $customProduct->name . ' (Custom Design)';
            $productImage = $design->preview_image_front;
            
            // Use the comprehensive price natively calculated by the frontend Design Engine
            $extraPrice = $request->input('extra_price', 0);
            $price = $customProduct->base_price + $extraPrice; 
            
        } elseif ($type === 'sample') {
            $product = \App\Models\Sample::findOrFail($productId);
            $productName = $product->title;
            $productImage = $product->image;
            $price = $product->price;
        } elseif ($type === 'own') {
            $product = \App\Models\Design::findOrFail($productId);
            $productName = $product->title;
            $productImage = $product->image;
            $price = $product->price;
        } else {
            $product = \App\Models\Product::findOrFail($productId);
            $productName = $product->product_name;
            $productImage = $product->product_image;
            $price = $product->product_mrp_price;
        }

        // Validate stock availability
        $availableStock = null;
        if ($type === 'sample') {
            $availableStock = $product->stocks;
        } elseif ($type === 'own') {
            $availableStock = $product->stocks;
        } elseif ($type === 'custom') {
            $availableStock = null; // custom is made to order
        } else {
            $availableStock = $product->product_quantity;
        }

        if ($availableStock !== null && $availableStock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock. Only ' . $availableStock . ' items available.'
            ], 422);
        }

        // Check if item already exists in cart for this user/session
        $cartItem = Cart::query();
        if ($userId) {
            $cartItem->where('user_id', $userId);
        } else {
            $cartItem->where('session_id', $sessionId);
        }
        
        $cartItem->where('product_id', $productId)
            ->where('product_type', $type)
            ->where('product_size', $request->size)
            ->where('product_color', $request->color);

        // For custom products, also check design_id
        if ($type === 'custom') {
            $cartItem->where('design_id', $request->design_id);
        }

        $cartItem = $cartItem->first();

        // App Settings Validation
        $appSetting = get_app_setting($type);
        if ($appSetting) {
            $checkQty = $quantity + ($cartItem ? $cartItem->product_quantity : 0);
            if ($checkQty < $appSetting->min_quantity) {
                return response()->json(['success' => false, 'message' => "Minimum {$appSetting->min_quantity} units required for this selection."], 422);
            }
            if ($appSetting->max_quantity && $checkQty > $appSetting->max_quantity) {
                return response()->json(['success' => false, 'message' => "Maximum {$appSetting->max_quantity} units allowed for this selection."], 422);
            }
        }

        if ($cartItem) {
            $cartItem->increment('product_quantity', $quantity);
        } else {
            Cart::create([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'product_id' => $productId,
                'product_type' => $type,
                'product_name' => $productName,
                'product_image' => $productImage,
                'price' => $price,
                'extra_price' => isset($extraPrice) ? $extraPrice : 0,
                'product_quantity' => $quantity,
                'product_size' => $request->size,
                'product_color' => $request->color,
                'design_id' => $type === 'custom' ? $request->design_id : null,
                'roster_data' => $type === 'custom' ? $request->roster_data : null,
            ]);
        }

        $cartCount = Cart::where(function($q) use ($userId, $sessionId) {
            if ($userId) $q->where('user_id', $userId);
            else $q->where('session_id', $sessionId);
        })->count();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $productName . ' added to your order!',
                'cart_count' => $cartCount
            ]);
        }

        return redirect()->route('cart.index')->with('success', $productName . ' added to your order!');
    }

    /**
     * Remove item from cart.
     */
    public function removeItem($id)
    {
        $user = Auth::user();
        $sessionId = session()->getId();

        $cartItem = Cart::where('id', $id);

        if ($user) {
            $cartItem->where('user_id', $user->user_id);
        } else {
            $cartItem->where('session_id', $sessionId);
        }

        $cartItem = $cartItem->firstOrFail();
        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.'
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $sessionId = session()->getId();

        $cartItem = Cart::where('id', $id);

        if ($user) {
            $cartItem->where('user_id', $user->user_id);
        } else {
            $cartItem->where('session_id', $sessionId);
        }

        $cartItem = $cartItem->firstOrFail();

        // Validate stock
        $type = $cartItem->product_type;
        $product = null;
        $availableStock = null;
        
        if ($type === 'sample') {
            $product = \App\Models\Sample::find($cartItem->product_id);
            $availableStock = $product ? $product->stocks : null;
        } elseif ($type === 'own') {
            $product = \App\Models\Design::find($cartItem->product_id);
            $availableStock = $product ? $product->stocks : null;
        } elseif ($type === 'custom') {
            $availableStock = null; // custom is made to order
        } else {
            $product = \App\Models\Product::find($cartItem->product_id);
            $availableStock = $product ? $product->product_quantity : null;
        }

        if ($availableStock !== null && $availableStock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock. Only ' . $availableStock . ' items available.'
            ], 422);
        }

        // App Settings Validation
        $appSetting = get_app_setting($type);
        if ($appSetting) {
            if ($request->quantity < $appSetting->min_quantity) {
                return response()->json(['success' => false, 'message' => "This product require a minimum of {$appSetting->min_quantity} units."], 422);
            }
            if ($appSetting->max_quantity && $request->quantity > $appSetting->max_quantity) {
                return response()->json(['success' => false, 'message' => "This product allow a maximum of {$appSetting->max_quantity} units."], 422);
            }
        }

        $cartItem->update(['product_quantity' => $request->quantity]);

        // Calculate updated totals for all items in the cart
        $query = Cart::query();
        if ($user) {
            $query->where('user_id', $user->user_id);
        } else {
            $query->where('session_id', $sessionId);
        }
        $allCartItems = $query->get();
        $cartTotal = $allCartItems->sum(function($item) {
            return $item->price * $item->product_quantity;
        });

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully.',
            'new_quantity' => $request->quantity,
            'item_subtotal' => format_currency($cartItem->price * $request->quantity),
            'cart_total' => format_currency($cartTotal)
        ]);
    }
}
