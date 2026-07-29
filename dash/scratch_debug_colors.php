<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ProductColor;

$colors = ProductColor::limit(10)->get();
foreach ($colors as $color) {
    echo "ID: {$color->id}, Name: {$color->color_name}, Code: [{$color->color_code}]\n";
}
