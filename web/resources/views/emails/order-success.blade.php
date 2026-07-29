<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 650px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #333333;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            font-size: 14px;
            color: #666666;
            line-height: 1.8;
            margin-bottom: 25px;
        }
        .order-summary {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .order-id {
            font-size: 16px;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 15px;
        }
        .order-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 13px;
        }
        .order-meta-label {
            color: #666666;
        }
        .order-meta-value {
            color: #333333;
            font-weight: 600;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            background-color: #ffffff;
        }
        .products-table thead {
            background-color: #f8f9fa;
        }
        .products-table th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: #666666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e9ecef;
        }
        .products-table td {
            padding: 15px 12px;
            font-size: 14px;
            color: #333333;
            border-bottom: 1px solid #e9ecef;
        }
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }
        .product-name {
            font-weight: 600;
            color: #333333;
            margin-bottom: 4px;
        }
        .product-details {
            font-size: 12px;
            color: #999999;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .total-row td {
            border-bottom: none;
            padding: 18px 12px;
        }
        .total-amount {
            font-size: 18px;
            color: #667eea;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
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
        .info-box {
            background-color: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            font-size: 13px;
            color: #014361;
        }
        .info-box strong {
            display: block;
            margin-bottom: 5px;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            margin: 20px 0;
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
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>✅ Order Confirmed!</h1>
            <p>Thank you for your purchase</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Hello {{ $user->name }}!
            </div>
            
            <div class="message">
                Great news! Your order has been successfully placed and confirmed. We're already working 
                on getting it ready for delivery.
            </div>
            
            <div class="order-summary">
                <div class="order-id">Order ID: {{ $order->order_id }}</div>
                <div class="order-meta">
                    <span class="order-meta-label">Order Date:</span>
                    <span class="order-meta-value">{{ $order->date_ordered_on->format('M d, Y') }}</span>
                </div>
                
                <div class="order-meta">
                    <span class="order-meta-label">Payment Status:</span>
                    <span class="order-meta-value">
                        @if($order->payment_status == 1)
                            <span class="status-badge status-paid">Paid</span>
                        @elseif($order->payment_status == 2)
                            <span class="status-badge status-pending">COD</span>
                        @elseif($order->payment_status == 3)
                            <span class="status-badge status-pending">Manual Payment</span>
                        @else
                            <span class="status-badge status-pending">Pending</span>
                        @endif
                    </span>
                </div>
            </div>
            
            <h3 style="color: #333; font-size: 16px; margin: 30px 0 15px 0;">Order Items</h3>
            
            <table class="products-table">
                <thead>
                    <tr>
                        <th style="width: 40%;">Product</th>
                        <th style="width: 10%;">Qty</th>
                        <th style="width: 15%;">Price</th>
                        <th style="width: 20%;">Design</th>
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
                            {{ (is_array($item) || is_object($item)) ? ($item['product_quantity'] ?? $item->product_quantity ?? 1) : 1 }}
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
                                               style="color: #667eea; text-decoration: underline; display: block; margin-bottom: 2px;">
                                                📥 {{ $asset->layer_name }}
                                            </a>
                                        @endforeach
                                        <a href="{{ url('/order-assets/zip/' . $order->order_id) }}" 
                                           style="color: #ffffff; background: #28a745; padding: 4px 8px; border-radius: 4px; text-decoration: none; display: inline-block; margin-top: 5px; font-weight: bold; font-size: 11px;">
                                            📦 All (ZIP)
                                        </a>
                                    </div>
                                @else
                                    <span style="font-size: 11px; color: #999;">Regular Proof</span>
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
            <div class="info-box">
                <strong>📋 Manual Payment Instructions:</strong>
                Please complete your payment using the bank details provided during checkout. 
                Your order will be processed once we verify the payment.
            </div>
            @endif
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/myaccount') }}" class="cta-button">Track Your Order</a>
            </div>
            
            <div class="message">
                You can track your order status anytime from your account dashboard. We'll notify you 
                when your order is shipped and on its way to you.
            </div>
            
            <div class="message">
                If you have any questions about your order, please don't hesitate to contact our support team.
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} <span class="brand">Saaluvesa</span>. All rights reserved.</p>
            <p>This is an automated email. Please do not reply to this message.</p>
        </div>
    </div>
</body>
</html>
