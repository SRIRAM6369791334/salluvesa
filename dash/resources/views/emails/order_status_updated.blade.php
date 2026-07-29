<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Status Update</title>
</head>

<body>
    <p>Hi {{ $order->customer->first_name }},</p>

    @if($status == '1')
        <p><strong>Your order {{ $order->order_id }} is now being packed.</strong></p>
        <p>We’ll notify you once it is dispatched.</p>
    @elseif($status == '2')
        <p><strong>Your order {{ $order->order_id }} has been dispatched.</strong></p>
        <p>It is on the way!</p>
    @elseif($status == '3')
        <p><strong>Your order {{ $order->order_id }} is out for delivery.</strong></p>
        <p>Please keep your phone available for the delivery agent.</p>
    @elseif($status == '4')
        <p><strong>Your order {{ $order->order_id }} has been delivered.</strong></p>
        <p>Thank you for shopping with us!</p>
    @else
        <p>Your order status has been updated to: {{ ucfirst($status) }}.</p>
    @endif

    <p>Regards,<br>Team Saaluvesa</p>
</body>

</html>