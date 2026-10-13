<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$user = \App\Models\User::where('email', 'sriramsri1234321@gmail.com')->first();
if ($user) {
    echo "User ID (PK): " . $user->id . "\n";
    echo "User user_id (Custom): " . $user->user_id . "\n";
    
    $addresses = \App\Models\UserAddress::where('user_id', $user->id)->orWhere('user_id', $user->user_id)->get();
    echo "Addresses found: " . count($addresses) . "\n";
    foreach($addresses as $addr) {
        echo "Address ID: " . $addr->id . " | user_id column: " . $addr->user_id . "\n";
        echo json_encode($addr->toArray()) . "\n";
    }
}
