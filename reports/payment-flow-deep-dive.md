# Payment Flow Deep Dive

**Generated:** 2026-07-27 15:06:21

Full analysis of payment processing, PayPal integration, bank transfer flow, and refund logic.

---

## Payment Flow Overview

```
Customer places order
       │
       ├──→ Payment Method: PayPal
       │       POST /create-paypal-payment → OrderController@createPayPalPayment
       │         → PayPalService::createPayment()
       │       GET /paypal/execute → OrderController@executePayPalPayment
       │         → PayPalService::executePayment()
       │       GET /paypal/cancel → OrderController@cancelPayPalPayment
       │
       └──→ Payment Method: Bank Transfer
               GET /bank-details → OrderController@showBankDetails
               POST /order/upload-proof → OrderController@uploadPaymentProof
               (Admin verifies manually then updates order status)
```

## PayPalService

**File:** `web/app/Services/PayPalService.php`

### `__construct()`

**Params:** ``

**Returns:** ``

```php
{
        $this->mode = config('services.paypal.mode', 'sandbox');
        $config = config('services.paypal.' . $this->mode);
        
        $this->clientId = $config['client_id'];
        $this->secret = $config['secret'];
        $this->baseUrl = $this->mode === 'sandbox' 
            ? 'https://api-m.sandbox.paypal.com' 
            : 'https://api-m.paypal.com';
    }
```

### `getAccessToken()`

**Params:** ``

**Returns:** ``

```php
{
        $response = Http::withBasicAuth($this->clientId, $this->secret)
            ->asForm()
            ->post($this->baseUrl . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        Log::error('PayPal OAuth failed', ['response' => $response->json()]);
        throw new \Exception('Failed to get PayPal access token');
    }
```

### `createOrder()`

**Params:** `$amount, $currency = 'USD', $returnUrl, $cancelUrl`

**Returns:** ``

```php
{
        $accessToken = $this->getAccessToken();

        $orderData = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => $currency,
                    'value' => number_format($amount, 2, '.', '')
                ]
            ]],
            'application_context' => [
                'return_url' => $returnUrl,
                'cancel_url' => $cancelUrl,
                'brand_name' => 'Saaluvesa Enterprises',
                'user_action' => 'PAY_NOW'
            ]
        ];

        $response = Http::withToken($accessToken)
            ->post($this->baseUrl . '/v2/checkout/orders', $orderData);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('PayPal create order failed', ['response' => $response->json()]);
        
        $errorMsg = 'Failed to create PayPal order';
        $jsonData = $response->json();
        
        if (isset($jsonData['message'])) {
            $errorMsg .= ': ' . $jsonData['message'];
        }
        
        if (isset($jsonData['details']) && is_array($jsonData['details'])) {
            $details = collect($jsonData['details'])->map(function($d) {
                return ($d['issue'] ?? 'Unknown') . ': ' . ($d['description'] ?? 'No description');
            })->implode('; ');
            $errorMsg .= ' Details: ' . $details;
        }

        throw new \Exception($errorMsg);
    }
```

### `captureOrder()`

**Params:** `$orderId`

**Returns:** ``

```php
{
        $accessToken = $this->getAccessToken();

        // PayPal V2 capture expects a JSON object {} in the body if content-type is set
        // Using withBody explicitly sends the string "{}" to avoid PHP [] vs {} encoding issues
        $response = Http::withToken($accessToken)
            ->withHeaders([
                'PayPal-Request-Id' => Str::uuid()->toString(),
                'Prefer' => 'return=representation'
            ])
            ->withBody('{}', 'application/json')
            ->post($this->baseUrl . "/v2/checkout/orders/{$orderId}/capture");

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('PayPal capture failed', ['response' => $response->json()]);
        
        $errorMsg = 'Failed to capture PayPal payment';
        $jsonData = $response->json();
        
        if (isset($jsonData['message'])) {
            $errorMsg .= ': ' . $jsonData['message'];
        }
        
        if (isset($jsonData['details']) && is_array($jsonData['details'])) {
            $details = collect($jsonData['details'])->map(function($d) {
                return ($d['issue'] ?? 'Unknown') . ': ' . ($d['description'] ?? 'No description');
            })->implode('; ');
            $errorMsg .= ' Details: ' . $details;
        }

        throw new \Exception($errorMsg);
    }
```

### `getOrderDetails()`

**Params:** `$orderId`

**Returns:** ``

```php
{
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->get($this->baseUrl . "/v2/checkout/orders/{$orderId}");

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('PayPal get order failed', ['response' => $response->json()]);
        throw new \Exception('Failed to get PayPal order details');
    }
```

**API Credentials Referenced:** clientId, client_id

## OrderController Payment Methods

### `createPayPalPayment()`

**Params:** `Request $request`

```php
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
```

### `executePayPalPayment()`

**Params:** `Request $request`

```php
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
```

### `cancelPayPalPayment()`

**Params:** ``

```php
{
        session()->forget('checkout_data');
        return redirect()->route('checkout')->with('error', 'Payment cancelled');
    }
```

### `createRazorpayOrder()`

**Params:** `Request $request`

```php
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
```

### `placeOrder()`

**Params:** `Request $request`

```php
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
```

### `checkout()`

**Params:** ``

```php
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
```

### `uploadPaymentProof()`

**Params:** `Request $request`

```php
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
```

### `showBankDetails()`

**Params:** `Request $request`

```php
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
```

## Currency & Multi-Currency Support

**File:** `web/app/Services/CurrencyService.php`

- `getSupportedCurrencies()` — 
- `convert()` — 
- `getRate()` — 
- `fetchRateFromApi()` — 
- `updateRates()` — 
- `updateDatabaseRate()` — 

## Exchange Rates

**Command:** `php artisan UpdateExchangeRates` — Updates exchange rates from external API

**Table:** `exchange_rates` — stores currency conversion rates


## Payment Security Analysis

| Check | Status | Notes |
|-------|--------|-------|
| PayPal credentials in .env | ⚠️ Check .env | Ensure not hardcoded in config/services.php |
| Webhook/IPN verification | 🔍 Needs review | Check if PayPal IPN is verified |
| Order amount re-verification | 🔍 Needs review | Server should re-calculate totals, not trust client |
| Payment proof validation | 🔍 Needs review | Uploaded proof images should be validated for type/size |
| Refund authorization | ⚠️ Check | Ensure only authorized admin can process refunds |
| CSRF on payment routes | ✅ | Uses web middleware with CSRF |

## Refund Flow

```
Admin processes refund:
  → POST /updaterefund → ProductController@updaterefund
  → POST /updaterefund1 → PackingOrderController@updaterefund1
  → POST /updaterefund2 → PackingDispatchController@updaterefund2
  → POST /refundMilkSlot → MilkRefundController@refundMilkSlot
  → POST /refundProductSlot → ProductRefundController@refundProductSlot
  
Refund tables:
  - product_refunds (product orders)
  - milk_refunds (milk subscriptions)
  - product_transaction_logs (transaction audit trail)
  - milk_transaction_logs (transaction audit trail)
```
