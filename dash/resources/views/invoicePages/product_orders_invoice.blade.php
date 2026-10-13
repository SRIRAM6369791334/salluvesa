@php
    use Carbon\Carbon;
    use Illuminate\Support\Str;

    if (!function_exists('numberToWords')) {
        function numberToWords($num) {
            $num = (int)$num;
            if ($num == 0) return "Zero";
            $ones = [
                0 => "", 1 => "One", 2 => "Two", 3 => "Three", 4 => "Four", 5 => "Five", 6 => "Six",
                7 => "Seven", 8 => "Eight", 9 => "Nine", 10 => "Ten", 11 => "Eleven", 12 => "Twelve",
                13 => "Thirteen", 14 => "Fourteen", 15 => "Fifteen", 16 => "Sixteen", 17 => "Seventeen",
                18 => "Eighteen", 19 => "Nineteen"
            ];
            $tens = [
                0 => "", 1 => "Ten", 2 => "Twenty", 3 => "Thirty", 4 => "Forty", 5 => "Fifty",
                6 => "Sixty", 7 => "Seventy", 8 => "Eighty", 9 => "Ninety"
            ];
            if ($num < 20) return $ones[$num];
            if ($num < 100) return $tens[(int)($num / 10)] . ($num % 10 ? " " . $ones[$num % 10] : "");
            if ($num < 1000) return $ones[(int)($num / 100)] . " Hundred" . ($num % 100 ? " and " . numberToWords($num % 100) : "");
            if ($num < 100000) return numberToWords((int)($num / 1000)) . " Thousand" . ($num % 1000 ? " " . numberToWords($num % 1000) : "");
            if ($num < 10000000) return numberToWords((int)($num / 100000)) . " Lakh" . ($num % 100000 ? " " . numberToWords($num % 100000) : "");
            return numberToWords((int)($num / 10000000)) . " Crore" . ($num % 10000000 ? " " . numberToWords($num % 10000000) : "");
        }
    }
@endphp

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INVOICE - {{ $products[0]->order_id ?? 'Details' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&family=Roboto+Mono:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1e293b;
            --header-bg: #0f172a;
            --accent: #2563eb;
            --border-color: #cbd5e1;
            --text-dark: #0f172a;
            --text-muted: #475569;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #d1d5db;
            color: var(--text-dark);
            line-height: 1.4;
            padding: 30px 10px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Invoice Sheet (A4 Dimensions Feel) */
        .invoice-sheet {
            max-width: 880px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #94a3b8;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }

        /* Top Color Accent Line */
        .top-accent-bar {
            height: 6px;
            background: linear-gradient(90deg, #1e293b 0%, #2563eb 50%, #0284c7 100%);
        }

        /* Invoice Inner Container */
        .invoice-body {
            padding: 35px 40px;
        }

        /* Header Layout */
        .invoice-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--primary);
        }

        .seller-brand img {
            max-height: 55px;
            width: auto;
            margin-bottom: 6px;
        }

        .seller-name {
            font-size: 16px;
            font-weight: 900;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: -0.2px;
        }

        .seller-details {
            font-size: 11px;
            color: var(--text-muted);
            line-height: 1.5;
            margin-top: 3px;
        }

        .invoice-title-box {
            text-align: right;
            position: relative;
        }

        .invoice-heading {
            font-size: 30px;
            font-weight: 900;
            color: var(--primary);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .invoice-sub-heading {
            font-size: 11px;
            font-weight: 700;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        /* Paid Rubber Stamp Watermark Effect */
        .paid-stamp {
            display: inline-block;
            padding: 4px 14px;
            font-size: 13px;
            font-weight: 900;
            color: #16a34a;
            border: 2px solid #16a34a;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 2px;
            transform: rotate(-5deg);
            margin-top: 4px;
            box-shadow: 0 0 0 2px #ffffff;
        }

        .pending-stamp {
            display: inline-block;
            padding: 4px 14px;
            font-size: 13px;
            font-weight: 900;
            color: #d97706;
            border: 2px solid #d97706;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 2px;
            transform: rotate(-5deg);
            margin-top: 4px;
        }

        /* Meta Grid Section */
        .invoice-meta-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr 1fr;
            gap: 20px;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .meta-column {
            font-size: 12px;
        }

        .meta-title {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .meta-value {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .meta-value-mono {
            font-family: 'Roboto Mono', monospace;
            font-weight: 700;
        }

        /* Address Grid */
        .address-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        .address-pane {
            border: 1px solid var(--border-color);
            padding: 15px;
            border-radius: 4px;
            background: #ffffff;
        }

        .address-pane-title {
            font-size: 11px;
            font-weight: 800;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 6px;
            margin-bottom: 8px;
        }

        .address-pane-body {
            font-size: 12px;
            color: var(--text-dark);
            line-height: 1.5;
        }

        /* Table Design */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th {
            background: #1e293b;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 9px 10px;
            border: 1px solid #1e293b;
        }

        .items-table td {
            padding: 10px;
            font-size: 12px;
            border: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .items-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }

        .mono {
            font-family: 'Roboto Mono', monospace;
        }

        .color-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 1px solid #94a3b8;
            vertical-align: middle;
            margin-right: 3px;
        }

        .asset-btn {
            display: inline-block;
            padding: 2px 6px;
            font-size: 9px;
            font-weight: 700;
            border-radius: 3px;
            color: #ffffff;
            background: #2563eb;
            text-decoration: none;
            margin: 1px;
        }

        /* Calculation & Words Grid */
        .calculation-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 30px;
            align-items: flex-start;
            margin-top: 15px;
        }

        .amount-words-box {
            border: 1px solid var(--border-color);
            padding: 12px 15px;
            background: #f8fafc;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .amount-words-title {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .amount-words-text {
            font-size: 12px;
            font-weight: 700;
            color: var(--primary);
            font-style: italic;
            margin-top: 2px;
        }

        .terms-box {
            font-size: 10px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .summary-table td {
            padding: 6px 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .summary-table td.lbl {
            color: var(--text-muted);
            font-weight: 500;
        }

        .summary-table td.val {
            text-align: right;
            font-weight: 700;
            color: var(--text-dark);
            font-family: 'Roboto Mono', monospace;
        }

        .summary-table tr.total-row td {
            border-top: 2px solid var(--primary);
            border-bottom: 2px solid var(--primary);
            background: #f1f5f9;
            font-size: 14px;
            font-weight: 800;
        }

        .summary-table tr.total-row td.val {
            color: #2563eb;
            font-size: 16px;
        }

        /* Signature Section */
        .signature-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 35px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
        }

        .bank-details-mini {
            font-size: 10px;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .seal-signature-box {
            text-align: center;
        }

        .seal-signature-box img {
            max-height: 40px;
            margin-bottom: 2px;
        }

        .seal-signature-title {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            border-top: 1px solid #cbd5e1;
            padding-top: 3px;
            width: 150px;
            margin: 0 auto;
        }

        /* Floating Toolbar */
        .floating-actions {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            z-index: 9999;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            background: #ffffff;
            color: var(--primary);
            border: 1px solid #94a3b8;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-action:hover {
            background: var(--primary);
            color: #ffffff;
        }

        .btn-action-primary {
            background: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }

        .btn-action-primary:hover {
            background: #1d4ed8;
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .invoice-sheet {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
            }
            .floating-actions, .tm_hide_print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <!-- Floating Action Toolbar -->
    <div class="floating-actions tm_hide_print">
        <button onclick="window.print()" class="btn-action btn-action-primary">
            <span>🖨️</span>
            <span>Print INVOICE</span>
        </button>

        @php
            $showZipButton = false;
            $orderId = $products[0]->order_id ?? '';
            $isBulkOrder = \Illuminate\Support\Str::contains($orderId, 'BULK');
            
            if ($isBulkOrder) {
                $bulkOrderRawId = str_replace('ORD-SAA-BULK-', '', $orderId);
                $bulkOrder = \App\Models\BulkOrder::find((int)$bulkOrderRawId);
                if ($bulkOrder && !empty($bulkOrder->custom_image)) {
                    $showZipButton = true;
                }
            } else {
                if (!empty($orderId)) {
                    $showZipButton = true;
                }
            }
        @endphp

        @if($showZipButton)
            <a href="{{ route('admin.orders.download-order-zip', $orderId) }}" class="btn-action">
                <span>📦</span>
                <span>Download Assets (ZIP)</span>
            </a>
        @endif

        @foreach($products as $pSlot)
            @if(!empty($pSlot->preview_screenshot_url) || !empty($pSlot->custom_logo_url) || !empty($pSlot->design_id))
                <a href="{{ route('admin.orders.specsheet-pdf', $pSlot->id) }}" target="_blank" class="btn-action">
                    <span>📑</span>
                    <span>Item #{{ $loop->iteration }} Spec Sheet</span>
                </a>
            @endif
        @endforeach
    </div>

    <!-- Authentic Invoice Sheet -->
    <div class="invoice-sheet" id="tm_download_section">
        
        <div class="top-accent-bar"></div>

        <div class="invoice-body">

            @if(count($products) > 0)
                @php
                    $order = $products[0]->productOrder ?? null;
                    $customer = $order->customer ?? null;
                    $shippingAddress = $order->orderAddress ?? null;
                    $addressState = $shippingAddress->state->state_name ?? null;
                    $billingAddress = $customer?->user_addresses?->firstWhere('address_type_id', 1);

                    $currencySymbols = [
                        'USD' => '$', 'INR' => '₹', 'EUR' => '€', 'GBP' => '£',
                        'AED' => 'د.إ', 'SAR' => 'ر.س', 'CAD' => 'C$', 'AUD' => 'A$',
                        'SGD' => 'S$', 'JPY' => '¥', 'CNY' => '¥',
                    ];
                    $selectedCurr = $order->selected_currency ?? 'INR';
                    $currencySymbol = $currencySymbols[$selectedCurr] ?? '₹';

                    $grandTotal = 0;
                    $discount = 0;
                    $shipping = 0;
                    foreach ($products as $p) {
                        $sub = ($p->product_rate ?? 0) * $p->quantity;
                        $grandTotal += $sub;
                        $discount = $p->productOrder->discount_amount ?? 0;
                        $shipping = $p->shipping ?? 0;
                    }
                    $finalAmount = max(0, $grandTotal - $discount + $shipping);
                    $paymentStatus = $products[0]->productOrder->payment_status ?? null;
                @endphp

                <!-- Company Header & Invoice Stamp Title -->
                <div class="invoice-header-row">
                    <div class="seller-brand">
                        <img src="{{ asset('assets/images/Saaluvesa_log_trans.png') }}" alt="Saaluvesa Logo">
                        <div class="seller-name">Saaluvesa Enterprises Private Limited</div>
                        <div class="seller-details">
                            Dr.No.18/76, Thiru.Ve.Ka. St, Punjai Puliampatti,<br>
                            Sathyamangalam, Erode, Tamil Nadu - 638459
                        </div>
                    </div>

                    <div class="invoice-title-box">
                        <div class="invoice-heading">INVOICE</div>
                        <!-- <div class="invoice-sub-heading">Original For Recipient</div> -->
                        
                        @if($paymentStatus === 1)
                            <div class="paid-stamp">PAID</div>
                        @elseif($paymentStatus === 3)
                            <div class="paid-stamp" style="color: #0284c7; border-color: #0284c7;">BANK TRANSFER</div>
                        @else
                            <div class="pending-stamp">PENDING</div>
                        @endif
                    </div>
                </div>

                <!-- Invoice Key Meta Grid -->
                <div class="invoice-meta-grid">
                    <div class="meta-column">
                        <div class="meta-title">Invoice Number</div>
                        <div class="meta-value meta-value-mono">INV-{{ $products[0]->order_id }}</div>
                    </div>
                    <div class="meta-column">
                        <div class="meta-title">Invoice Date</div>
                        <div class="meta-value">{{ Carbon::parse($products[0]->productOrder->created_at ?? $products[0]->created_at)->format('d-M-Y') }}</div>
                    </div>
                    <div class="meta-column">
                        <div class="meta-title">Order Reference No</div>
                        <div class="meta-value meta-value-mono">{{ $products[0]->order_id }}</div>
                    </div>
                </div>

                <!-- Addresses Section -->
                <div class="address-grid">
                    <div class="address-pane">
                        <div class="address-pane-title">Billed & Shipped To (Customer)</div>
                        <div class="address-pane-body">
                            <strong>{{ $shippingAddress->address_username ?? ($order->order_name ?? ($customer->name ?? 'N/A')) }}</strong><br>
                            {{ $shippingAddress->address_line_one ?? $billingAddress->address_line_one ?? 'Address details not provided' }}<br>
                            @if(!empty($shippingAddress?->address_line_two ?? $billingAddress?->address_line_two))
                                {{ $shippingAddress->address_line_two ?? $billingAddress->address_line_two }}<br>
                            @endif
                            {{ $shippingAddress->city ?? $billingAddress->city ?? 'City' }} - 
                            {{ $addressState ?? $billingAddress?->state?->name ?? 'State' }} - 
                            {{ $shippingAddress->pincode ?? $billingAddress->pincode ?? 'Pincode' }}<br>
                            <strong>Phone:</strong> {{ $shippingAddress->address_phone_number ?? $billingAddress->address_phone_number ?? 'N/A' }}<br>
                            @if(!empty($customer?->gst_number))
                                <strong>GST No:</strong> {{ $customer->gst_number }}
                            @endif
                        </div>
                    </div>

                    <div class="address-pane">
                        <div class="address-pane-title">Payment & Shipping Info</div>
                        <div class="address-pane-body">
                            <strong>Payment Method:</strong> 
                            @if(($order->payment_method ?? '') == 'cod') Cash on Delivery
                            @elseif(($order->payment_method ?? '') == 'paypal') PayPal
                            @elseif(($order->payment_method ?? '') == 'mp') Bank Transfer
                            @else {{ $order->payment_method ?? 'Bank Transfer' }} @endif <br>

                            @if(!empty($order->bank_country))
                                <strong>Bank Country:</strong> {{ $order->bank_country }}<br>
                            @endif
                            <strong>Currency:</strong> {{ $selectedCurr }} ({{ $currencySymbol }})<br>
                            <strong>Place of Supply:</strong> {{ $addressState ?? 'Tamil Nadu' }}
                        </div>
                    </div>
                </div>

                <!-- Accounting Itemized Table -->
                <table class="items-table">
                    <thead>
                        <tr>
                            <th style="width: 35px;" class="text-center">S.No</th>
                            <th class="text-left">Item Description</th>
                            <th style="width: 70px;" class="text-center">Size</th>
                            <th style="width: 100px;" class="text-left">Color</th>
                            <th style="width: 50px;" class="text-center">Qty</th>
                            <th style="width: 110px;" class="text-right">Rate</th>
                            <th style="width: 110px;" class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $variantDescriptions = [1 => 'l', 2 => 'ml', 3 => 'g', 4 => 'kg', 5 => 'Nos'];
                        @endphp
                        @foreach ($products as $product)
                            @php
                                $sub = ($product->product_rate ?? 0) * $product->quantity;
                            @endphp
                            <tr>
                                <td class="text-center mono" style="color: var(--text-muted);">{{ $loop->iteration }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        @php
                                            $previewList = [];
                                            $formatUrl = function($path) {
                                                $mainStoreUrl = rtrim(env('MAIN_URL', url('/')), '/') . '/';
                                                if (empty($path)) return $mainStoreUrl . 'img/tshirt-front.png';
                                                if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) return $path;
                                                $trimmed = ltrim($path, '/');
                                                if (file_exists(public_path($trimmed))) return asset($trimmed);
                                                if (file_exists(public_path('images/' . $trimmed))) return asset('images/' . $trimmed);
                                                if (file_exists(public_path('uploads/' . $trimmed))) return asset('uploads/' . $trimmed);
                                                return $mainStoreUrl . $trimmed;
                                            };

                                            if (!empty($product->preview_screenshot_url)) {
                                                $decoded = json_decode($product->preview_screenshot_url, true);
                                                if (is_array($decoded)) $previewList = $decoded;
                                                else $previewList = ['front' => $product->preview_screenshot_url];
                                            }
                                            if (empty($previewList) && !empty($product->product_image)) {
                                                $previewList['product'] = $product->product_image;
                                            }
                                        @endphp
                                        @if(count($previewList) > 0)
                                            <img src="{{ $formatUrl(reset($previewList)) }}" alt="Thumb" style="width: 36px; height: 36px; object-fit: contain; border: 1px solid var(--border-color); background: #fff; padding: 1px;">
                                        @endif
                                        <div>
                                            <strong style="color: var(--primary);">{{ $product->product_name ?? 'Custom Product' }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $product->size_value ?? '-' }}</td>
                                <td>
                                    @if(!empty($product->color_value))
                                        @if(str_starts_with(trim($product->color_value), '#'))
                                            @foreach(explode(',', $product->color_value) as $color)
                                                @php $colorName = \App\Models\ProductColor::getColorName($color); @endphp
                                                <span class="color-indicator" style="background-color:{{ trim($color) }};" title="{{ $colorName }}"></span>
                                                <span>{{ $colorName }}</span>
                                            @endforeach
                                        @else
                                            <span>{{ $product->color_value }}</span>
                                        @endif
                                    @else
                                        Standard
                                    @endif
                                </td>
                                <td class="text-center mono" style="font-weight: 700;">{{ $product->quantity }}</td>
                                <td class="text-right mono">{{ $currencySymbol }}{{ number_format($product->product_rate ?? 0, 2) }}</td>
                                <td class="text-right mono" style="font-weight: 700; color: var(--primary);">{{ $currencySymbol }}{{ number_format($sub, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Calculation Grid & Amount in Words -->
                <div class="calculation-grid">
                    <div>
                        <!-- Amount in Words -->
                        <div class="amount-words-box">
                            <div class="amount-words-title">Amount Chargeable (in words):</div>
                            <div class="amount-words-text">
                                {{ $selectedCurr }} {{ numberToWords($finalAmount) }} Only
                            </div>
                        </div>


                    </div>

                    <!-- Totals Table -->
                    <div>
                        <table class="summary-table">
                            <tr>
                                <td class="lbl">Sub Total</td>
                                <td class="val">{{ $currencySymbol }}{{ number_format($grandTotal, 2) }}</td>
                            </tr>
                            @if($discount > 0)
                                <tr>
                                    <td class="lbl">Discount</td>
                                    <td class="val" style="color: #dc2626;">-{{ $currencySymbol }}{{ number_format($discount, 2) }}</td>
                                </tr>
                            @endif
                            @if($shipping > 0)
                                <tr>
                                    <td class="lbl">Shipping Charge</td>
                                    <td class="val">+{{ $currencySymbol }}{{ number_format($shipping, 2) }}</td>
                                </tr>
                            @endif
                            <tr class="total-row">
                                <td class="lbl" style="font-weight: 800; color: var(--primary);">Total Amount</td>
                                <td class="val">{{ $currencySymbol }}{{ number_format($finalAmount, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Footer & Signature Line -->
                <div class="signature-container">
                    <div class="bank-details-mini">
                        <strong>Payment Info:</strong><br>
                        Payment Method: 
                        @if(($order->payment_method ?? '') == 'cod') Cash on Delivery
                        @elseif(($order->payment_method ?? '') == 'paypal') PayPal
                        @elseif(($order->payment_method ?? '') == 'mp') Bank Transfer
                        @else {{ $order->payment_method ?? 'N/A' }} @endif <br>
                        @if(!empty($order->bank_country))
                            Bank Country: {{ $order->bank_country }}
                        @endif
                    </div>

                    <div class="seal-signature-box">
                        <img src="{{ asset('assets/images/Saaluvesa_log_trans.png') }}" alt="Seal">
                        <div class="seal-signature-title">For Saaluvesa Pvt Ltd</div>
                    </div>
                </div>

            @else
                <div style="padding: 50px; text-align: center; color: #dc2626;">
                    <h2>No products found for this invoice.</h2>
                </div>
            @endif

        </div>

    </div>

</body>

</html>