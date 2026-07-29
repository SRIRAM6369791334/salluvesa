<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Notification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 700px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 26px;
            font-weight: 600;
        }
        .header .order-id {
            font-size: 18px;
            font-weight: 600;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 10px;
        }
        .content {
            padding: 30px;
        }
        .alert-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 25px;
            font-size: 14px;
            color: #856404;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 25px 0;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        .info-item {
            font-size: 13px;
        }
        .info-label {
            color: #666666;
            font-weight: 500;
            margin-bottom: 5px;
        }
        .info-value {
            color: #333333;
            font-weight: 600;
            font-size: 14px;
        }
        .section-title {
            color: #333;
            font-size: 16px;
            font-weight: 600;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #f5576c;
        }
        .customer-info {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .customer-info h3 {
            margin: 0 0 10px 0;
            color: #2196F3;
            font-size: 15px;
        }
        .customer-detail {
            font-size: 13px;
            color: #014361;
            margin: 5px 0;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 13px;
        }
        .products-table thead {
            background-color: #f8f9fa;
        }
        .products-table th {
            padding: 10px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #666666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e9ecef;
        }
        .products-table td {
            padding: 12px 10px;
            font-size: 13px;
            color: #333333;
            border-bottom: 1px solid #e9ecef;
        }
        .product-name {
            font-weight: 600;
            color: #333333;
        }
        .product-details {
            font-size: 11px;
            color: #999999;
            margin-top: 3px;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .total-amount {
            font-size: 16px;
            color: #f5576c;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-paid {
            background-color: #d4edda;
            color: #155724;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-cod {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .action-box {
            background-color: #f8f9fa;
            border: 2px dashed #f5576c;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
            border-radius: 8px;
        }
        .action-box p {
            margin: 0 0 10px 0;
            color: #666;
            font-size: 13px;
        }
        .action-button {
            display: inline-block;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            margin-top: 5px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #999999;
            border-top: 1px solid #e9ecef;
        }
        .brand {
            font-weight: 600;
            color: #f5576c;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🔔 New Order Received!</h1>
            <div class="order-id">{{ $order->order_id }}</div>
        </div>
        
        <div class="content">
            <div class="alert-box">
                <strong>⚡ Action Required:</strong> A new order has been placed and requires your attention. Please review and process this order promptly.
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Order Date</div>
                    <div class="info-value">{{ $order->date_ordered_on->format('M d, Y h:i A') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Order Type</div>
                    <div class="info-value">
                        @if($order->order_type == 0)
                            Regular Order
                        @elseif($order->order_type == 1)
                            Sample Order
                        @elseif($order->order_type == 2)
                            Own Design Order
                        @else
                            Other
                        @endif
                    </div>
                </div>
              
                <div class="info-item">
                    <div class="info-label">Payment Status</div>
                    <div class="info-value">
                        @if($order->payment_status == 1)
                            <span class="status-badge status-paid">✓ Paid</span>
                        @elseif($order->payment_status == 2)
                            <span class="status-badge status-cod">COD</span>
                        @elseif($order->payment_status == 3)
                            <span class="status-badge status-pending">Manual Payment Pending</span>
                        @else
                            <span class="status-badge status-pending">Pending</span>
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Customer Currency</div>
                    <div class="info-value">{{ $order->selected_currency ?? 'USD' }} ({{ $currencySymbol }})</div>
                </div>
            </div>

            <div class="section-title">👤 Customer Information</div>
            <div class="customer-info">
                <h3>{{ $user->name }}</h3>
                <div class="customer-detail"><strong>Email:</strong> {{ $user->email }}</div>
                <div class="customer-detail"><strong>Phone:</strong> {{ $user->phone_number }}</div>
                <div class="customer-detail"><strong>User ID:</strong> {{ $user->user_id }}</div>
            </div>

            <div class="section-title">📦 Order Items</div>
            <table class="products-table">
                <thead>
                    <tr>
                        <th style="width: 35%;">Product</th>
                        <th style="width: 10%;">Qty</th>
                        <th style="width: 15%;">Price</th>
                        <th style="width: 25%;">Design Assets</th>
                        <th style="width: 15%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderDetails as $item)
                    @php
                        $designId = is_array($item) ? ($item['design_id'] ?? null) : ($item->design_id ?? null);
                        $assets = $designId ? \Illuminate\Support\Facades\DB::table('design_layers')->where('design_id', $designId)->whereNotNull('source_path')->get() : collect([]);
                    @endphp
                    <tr>
                        <td>
                            <div class="product-name">
                                @if(is_array($item) || is_object($item))
                                    {{ $item['product_name'] ?? $item->product_name ?? 'Product' }}
                                @else
                                    Product
                                @endif
                            </div>
                            <div class="product-details">
                                @if(is_array($item) || is_object($item))
                                    @if(isset($item['product_size']) || (is_object($item) && isset($item->product_size)))
                                        Size: {{ $item['product_size'] ?? $item->product_size ?? 'N/A' }}
                                    @endif
                                    @if(isset($item['product_color']) || (is_object($item) && isset($item->product_color)))
                                        | Color: {{ $item['product_color'] ?? $item->product_color ?? 'N/A' }}
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td style="text-align: center;">
                            @if(is_array($item) || is_object($item))
                                {{ $item['product_quantity'] ?? $item->product_quantity ?? 1 }}
                            @else
                                1
                            @endif
                        </td>
                        <td>
                            {{ $currencySymbol }} {{ is_array($item) || is_object($item) ? number_format(($item['price'] ?? $item->price ?? 0) * $exchangeRate, 2) : '0.00' }}
                        </td>
                        <td>
                            @if($designId)
                                @if($assets->isNotEmpty())
                                    <div style="font-size: 11px;">
                                        @foreach($assets as $asset)
                                            <a href="{{ url('/order-assets/file?path=' . $asset->source_path) }}" 
                                               style="color: #f5576c; text-decoration: underline; display: block; margin-bottom: 2px;">
                                                📥 {{ $asset->layer_name }}
                                            </a>
                                        @endforeach
                                        <a href="{{ url('/order-assets/zip/' . $order->order_id) }}" 
                                           style="color: #ffffff; background: #f5576c; padding: 4px 8px; border-radius: 4px; text-decoration: none; display: inline-block; margin-top: 5px; font-weight: bold; font-size: 11px;">
                                            📦 Download All (ZIP)
                                        </a>
                                    </div>
                                @else
                                    <span style="font-size: 11px; color: #999;">Regular Proof Only</span>
                                @endif
                            @else
                                <span style="font-size: 11px; color: #ccc;">-</span>
                            @endif
                        </td>
                        <td>
                            {{ $currencySymbol }} {{ is_array($item) || is_object($item) ? number_format(($item['price'] ?? $item->price ?? 0) * ($item['product_quantity'] ?? $item->product_quantity ?? 1) * $exchangeRate, 2) : '0.00' }}
                        </td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="4" style="text-align: right;">Grand Total:</td>
                        <td class="total-amount">{{ $currencySymbol }} {{ number_format($order->converted_amount ?? $order->grand_total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            @if($order->payment_status == 3)
            <div class="alert-box" style="background-color: #fff3cd; border-left-color: #ffc107;">
                <strong>💰 Manual Payment:</strong> This order is awaiting manual payment verification. Please check your bank account for the payment before processing.
            </div>
            @endif

            <div class="action-box">
                <p><strong>Process this order in your admin panel</strong></p>
                <a href="{{ url('/myaccount') }}" class="action-button">View Order Details</a>
            </div>

            <div style="font-size: 12px; color: #666; margin-top: 20px;">
                <strong>Quick Actions:</strong><br>
                • Verify payment status<br>
                • Check product availability<br>
                • Update order status<br>
                • Prepare for shipping
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} <span class="brand">Saaluvesa</span> Admin Panel</p>
            <p>This is an automated notification. Please take necessary action.</p>
        </div>
    </div>
</body>
</html>
