<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bulk Order Approved</title>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px; }
        .header { background: #4CAF50; color: white; padding: 10px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #777; margin-top: 20px; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>🎉 Bulk Order Approved!</h2>
        </div>
        <div class="content">
            <p>Hi {{ $bulkOrder->name }},</p>
            <p>Great news! Your request for <strong>{{ $bulkOrder->quantity }} units</strong> of <strong>{{ $bulkOrder->product_type }}</strong> has been approved by our team.</p>
            <p><strong>Order Details:</strong></p>
            <ul>
                <li><strong>Reference ID:</strong> #{{ $bulkOrder->id }}</li>
                <li><strong>Product Type:</strong> {{ ucwords(str_replace('_', ' ', $bulkOrder->product_type)) }}</li>
                <li><strong>Quantity:</strong> {{ $bulkOrder->quantity }}</li>
            </ul>
            <p>Our sales representative will contact you shortly via <strong>{{ $bulkOrder->email }}</strong> to discuss further steps and payments.</p>
            <p>If you have any urgent questions, feel free to reply to this email.</p>
        </div>
        <div class="footer">
            <p>Regards,<br>Team Saaluvesa Enterprises Private Limited</p>
        </div>
    </div>
</body>
</html>
