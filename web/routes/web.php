<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BulkOrderController;
use App\Models\Design;

Route::get('/bulk-order', [BulkOrderController::class, 'index'])->name('bulk.order');
Route::post('/bulk-order', [BulkOrderController::class, 'store'])->name('bulk.order.post');

Route::get('/lang/{locale}', [App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');

Route::get('/sample', [SampleController::class, 'index']);

Route::get('/product-details/{id}', [App\Http\Controllers\ShopController::class, 'show'])->name('product.details');

// Redundant static routes removed

Route::get('/wishlist', function () {
    return view('pages.wishlist');
});

Route::get('/contact', function () {
    return view('pages.contact');
});
Route::post('/contact/submit', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.submit');

// Guest-only pages (redirect to home if already logged in)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password/send-otp', [AuthController::class, 'sendOTP'])->name('password.send_otp');
Route::post('/forgot-password/verify-otp', [AuthController::class, 'verifyOTP'])->name('password.verify_otp');
Route::post('/forgot-password/reset', [AuthController::class, 'resetPassword'])->name('password.reset_submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/myaccount', [AccountController::class, 'index'])->name('myaccount');
    
    // Address Management
    Route::post('/addresses', [UserAddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{id}', [UserAddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [UserAddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{id}/set-default', [UserAddressController::class, 'setDefault'])->name('addresses.set_default');

    // Cart & Checkout
    Route::post('/create-razorpay-order', [OrderController::class, 'createRazorpayOrder'])->name('razorpay.create');
    Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/order/details/{orderId}', [OrderController::class, 'getDetails'])->name('order.details');
    
    // PayPal Payment Routes
    Route::post('/create-paypal-payment', [OrderController::class, 'createPayPalPayment'])->name('paypal.create');
    Route::get('/paypal/execute', [OrderController::class, 'executePayPalPayment'])->name('paypal.execute');
    Route::get('/paypal/cancel', [OrderController::class, 'cancelPayPalPayment'])->name('paypal.cancel');
    
    Route::get('/bank-details', [OrderController::class, 'showBankDetails'])->name('bank.details');
    Route::post('/order/upload-proof', [OrderController::class, 'uploadPaymentProof'])->name('order.upload_proof');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    // Profile & Settings
    Route::post('/update-profile', [AccountController::class, 'updateProfile'])->name('profile.update');
    Route::post('/change-password', [AccountController::class, 'changePassword'])->name('password.change');

    // Design Assets Download
    Route::get('/order-assets/zip/{orderId}', [\App\Http\Controllers\OrderAssetsController::class, 'downloadZip'])->name('order-assets.zip');
    Route::get('/order-assets/file', [\App\Http\Controllers\OrderAssetsController::class, 'downloadFile'])->name('order-assets.file');
});

// Cart management (Public/Guest access enabled)
Route::group(['middleware' => ['web']], function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
});

// Custom Product Design Routes
Route::prefix('api')->group(function () {
    // Public routes
    Route::get('/customproducts', [App\Http\Controllers\CustomProductController::class, 'index']);
    Route::get('/customproducts/{id}', [App\Http\Controllers\CustomProductController::class, 'show']);
    Route::get('/customproducts/{id}/designer-data', [App\Http\Controllers\CustomProductController::class, 'getDesignerData']);
    Route::get('/customproducts/{id}/designer-data-v2', [App\Http\Controllers\CustomProductController::class, 'getDesignerDataFixed']);
    
    // Design routes (Public/Guest access allowed for saving)
    Route::post('/designs/init', [App\Http\Controllers\CustomDesignController::class, 'init'])->name('designs.init');
    Route::post('/designs/save', [App\Http\Controllers\CustomDesignController::class, 'store'])->name('designs.save');
    Route::put('/designs/{id}', [App\Http\Controllers\CustomDesignController::class, 'update'])->name('designs.update');
    Route::post('/designs/upload-user-image', [App\Http\Controllers\CustomDesignController::class, 'uploadUserImage'])->name('designs.upload_user_image');
    Route::post('/designs/export-image', [App\Http\Controllers\CustomDesignController::class, 'uploadExport'])->name('designs.export_image');
    Route::get('/designs/{id}', [App\Http\Controllers\CustomDesignController::class, 'show'])->name('designs.show');
    Route::get('/my-designs', [App\Http\Controllers\CustomDesignController::class, 'myDesigns'])->name('designs.my_designs');
    
    // Authenticated only routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/designs/my/all', [App\Http\Controllers\CustomDesignController::class, 'myDesigns'])->name('designs.my');
        Route::delete('/designs/{id}', [App\Http\Controllers\CustomDesignController::class, 'destroy'])->name('designs.delete');
    });
});

// Customization Upload Routes
Route::post('/customization/upload', [App\Http\Controllers\CustomizationUploadController::class, 'uploadLogo'])->name('customization.upload');
Route::post('/upload-customization-preview', [App\Http\Controllers\CustomizationUploadController::class, 'uploadPreview'])->name('customization.upload_preview');

Route::get('/own-design', [DesignController::class, 'index']);
Route::get('/customize-products', [App\Http\Controllers\CustomProductController::class, 'picker'])->name('customize-products.index');
Route::get('/design', function () {
    $appSetting = get_app_setting('own_custom');
    return view('pages.custom-designer', compact('appSetting'));
})->name('design.index');

Route::get('/customize/{product_id}', function ($product_id) {
    $appSetting = get_app_setting('own_custom');
    return view('pages.custom-designer', ['product_id' => $product_id, 'appSetting' => $appSetting]);
})->name('customize.design');
Route::get('/categories', [App\Http\Controllers\CategoriesController::class, 'index']);

Route::get('/privacy-policy', function () {
    return view('pages.privacy-policy');
});

Route::get('/terms-and-conditions', function () {
    return view('pages.terms-and-conditions');
});

Route::get('/refund-policy', function () {
    return view('pages.refund-policy');
});

Route::get('/shipping-policy', function () {
    return view('pages.shipping-policy');
});

// Image Proxy to resolve CORS issues for cross-origin mockups
Route::get('/proxy-image', function (Illuminate\Http\Request $request) {
    $url = $request->query('url');
    if (!$url) return abort(404);
    
    $mainUrl = rtrim(config('app.main_url') ?: env('MAIN_URL', ''), '/');
    
    // Safety check: only allow proxying from our own dashboard
    // We parse the host only to allow http/https flexibility on production
    $allowedHost = strtolower(parse_url($mainUrl, PHP_URL_HOST));
    $targetHost = strtolower(parse_url($url, PHP_URL_HOST));
    
    if ($mainUrl && $allowedHost && $targetHost !== $allowedHost && $targetHost !== 'placehold.co') {
        \Log::warning("[ImageProxy] Blocked: Host mismatch. Allowed: $allowedHost, Got: $targetHost | URL: $url");
        return response("Unauthorized proxy target: $targetHost", 403)
            ->header('Access-Control-Allow-Origin', '*');
    }

    try {
        $response = Illuminate\Support\Facades\Http::withOptions([
            'verify' => false,
            'connect_timeout' => 5,
            'timeout' => 10
        ])->get($url);

        if ($response->failed()) {
            \Log::error("[ImageProxy] Failed to fetch: " . $url . " | Status: " . $response->status());
            return response('Image not found via proxy', 404)
                ->header('Access-Control-Allow-Origin', '*');
        }

        return response($response->body())
            ->header('Content-Type', $response->header('Content-Type'))
            ->header('Cache-Control', 'public, max-age=86400')
            ->header('Access-Control-Allow-Origin', '*');

    } catch (\Exception $e) {
        \Log::error("[ImageProxy] Exception for URL $url: " . $e->getMessage());
        return response("Proxy Error: " . $e->getMessage(), 500)
            ->header('Access-Control-Allow-Origin', '*');
    }
})->name('image.proxy');

Route::get('/currency-test', [App\Http\Controllers\CurrencyController::class, 'index']);
Route::get('/currency/convert', [App\Http\Controllers\CurrencyController::class, 'convert']);
Route::post('/currency/switch', [App\Http\Controllers\CurrencyController::class, 'switchCurrency'])->name('currency.switch');
Route::get('/currency/switch/{currency}', [App\Http\Controllers\CurrencyController::class, 'switchCurrencyByGet'])->name('currency.switch.get');
