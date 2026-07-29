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
            ]);

            // 2. Create ProductOrderDetail & Deduct Stock
            foreach ($cartItems as $item) {
                \App\Models\ProductOrderDetail::create([
                    'order_id' => $order->id,
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
                ]);

                $this->decrementStock($item['product_id'], $item['product_type'], $item['product_quantity']);
            }

            // 3. Create SampleOrderFullDetail
            $this->createOrderFullDetail($order, $user, $address, $totalAmount, 'paypal', $request->paypal_order_id, $payerID, $cartItems);

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

    private function generateOrderId()
    {
        $prefix = 'ORD-SAA-';
        $latestOrder = \App\Models\ProductOrder::where('order_id', 'LIKE', $prefix . '%')
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
}
