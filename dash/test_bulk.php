<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$order = App\Models\BulkOrder::latest()->first();
if ($order) {
    $order->final_size = 'XL, XXL';
    $order->final_color = 'Navy Blue';
    $order->final_qty = 150;
    $order->final_rate = 350.00;
    $order->save();
    echo "Updated Order ID: " . $order->id . "\n";
    echo "Order Ref: ORD-SAA-BULK-" . str_pad($order->id, 3, '0', STR_PAD_LEFT) . "\n";
} else {
    echo "No bulk orders found.\n";
}
