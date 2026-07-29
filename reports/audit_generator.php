<?php
/**
 * Full File & Function Audit Generator v2
 * Scans dash/ and web/ apps, extracts functions/methods, generates markdown report
 */

$basePath = realpath(__DIR__ . '/..');
$outputFile = __DIR__ . '/file-function-report.md';

$apps = ['dash', 'web'];

function normalizePath($p) { return str_replace('\\', '/', $p); }

function getFileType($path) {
    $path = normalizePath($path);
    if (strpos($path, 'Http/Controllers') !== false) return 'Controller';
    if (strpos($path, 'Models') !== false) return 'Model';
    if (strpos($path, 'Middleware') !== false) return 'Middleware';
    if (strpos($path, 'Services') !== false) return 'Service';
    if (strpos($path, 'routes/') !== false) return 'Routes';
    if (strpos($path, 'Mail') !== false) return 'Mailable';
    if (strpos($path, 'Exports') !== false) return 'Export';
    if (strpos($path, 'Providers') !== false) return 'Provider';
    if (strpos($path, 'Exceptions') !== false) return 'Exception Handler';
    if (strpos($path, 'Console/Commands') !== false) return 'Console Command';
    if (strpos($path, 'Console') !== false) return 'Console';
    if (strpos($path, 'Helpers') !== false) return 'Helper';
    if (strpos($path, 'database/migrations') !== false) return 'Migration';
    if (strpos($path, 'database/seeders') !== false) return 'Seeder';
    if (strpos($path, 'database/factories') !== false) return 'Factory';
    if (strpos($path, 'resources/views') !== false) return 'Blade View';
    if (strpos($path, 'resources/lang') !== false) return 'Language File';
    if (strpos($path, 'resources/js/pages') !== false) return 'JavaScript';
    if (strpos($path, 'resources/js') !== false && basename($path) !== 'app.js') return 'JavaScript';
    if (strpos($path, 'resources/js/app.js') !== false) return 'JavaScript';
    if (strpos($path, 'resources/libs') !== false) return 'Library (3rd Party)';
    if (strpos($path, 'config/') !== false) return 'Config';
    return 'Other';
}

function extractFunctions($content, $path) {
    $functions = [];
    $path = normalizePath($path);
    $fileType = getFileType($path);
    
    // Blade views - no PHP functions
    if ($fileType === 'Blade View') return [];
    if ($fileType === 'Language File') return [];
    if ($fileType === 'Library (3rd Party)') return [];
    if ($fileType === 'Config') {
        // Config files - no user-defined functions but note the array key
        return [];
    }
    
    // Extract functions/methods
    preg_match_all('/(?:public|private|protected|static|function)\s+(?:static\s+)?(?:function\s+)?(&?\s*[\w_]+)\s*\(/', $content, $matches);
    if (!empty($matches[1])) {
        foreach ($matches[1] as $fn) {
            $fn = trim(str_replace('&', '', $fn));
            if (in_array($fn, ['function', 'if', 'foreach', 'while', 'for', 'switch', 'isset', 'empty', 'array', 'array_map', 'array_filter', 'array_walk', 'collect', 'config', 'view', 'redirect', 'response', 'auth', 'session', 'cache', 'event', 'logger', 'abort', 'count', 'in_array', 'strpos', 'substr', 'explode', 'implode', 'json_decode', 'json_encode', 'file_get_contents', 'file_put_contents', 'preg_match', 'preg_replace', 'method_exists', 'property_exists', 'class_exists', 'interface_exists', 'trait_exists', 'function_exists', 'is_null', 'is_array', 'is_string', 'is_int', 'is_numeric', 'is_object', 'is_bool', 'is_callable', 'is_dir', 'is_file', 'is_readable', 'is_writable', 'is_uploaded_file', 'move_uploaded_file', 'mkdir', 'rmdir', 'unlink', 'copy', 'rename', 'chmod', 'chown', 'chgrp', 'touch', 'file_exists', 'filesize', 'filemtime'])) continue;
            if (strpos($fn, '$') !== false) continue;
            if (in_array($fn, ['then', 'catch', 'finally', 'map', 'each', 'filter', 'reduce', 'sort', 'keys', 'values', 'merge', 'unique', 'where', 'first', 'last', 'find', 'get', 'pluck', 'sum', 'avg', 'min', 'max', 'count', 'toArray', 'toJson', 'jsonSerialize'])) continue;
            $functions[] = $fn;
        }
    }
    
    // Also check for uses of Laravel traits that add methods
    preg_match_all('/use\s+(\w+(?:\\\w+)*)\s*;/', $content, $traitMatches);
    if (!empty($traitMatches[1])) {
        foreach ($traitMatches[1] as $trait) {
            $shortTrait = basename(str_replace('\\', '/', $trait));
            $traitMethods = getTraitMethods($shortTrait);
            foreach ($traitMethods as $tm) {
                $functions[] = $tm;
            }
        }
    }
    
    // For routes files, extract route names
    if (strpos($path, 'routes/') !== false) {
        $routeFuncs = [];
        preg_match_all('/Route::(\w+)\s*\(/', $content, $routeMatches);
        if (!empty($routeMatches[1])) {
            foreach ($routeMatches[1] as $r) {
                $routeFuncs[] = '[Route] ' . $r;
            }
        }
        $functions = array_merge($functions, $routeFuncs);
    }
    
    return array_unique($functions);
}

function getTraitMethods($traitName) {
    $map = [
        'AuthenticatesUsers' => ['showLoginForm [Trait]', 'login [Trait]', 'username [Trait]', 'validateLogin [Trait]', 'attemptLogin [Trait]', 'sendLoginResponse [Trait]', 'authenticated [Trait]', 'logout [Trait]', 'loggedOut [Trait]'],
        'RegistersUsers' => ['showRegistrationForm [Trait]', 'register [Trait]'],
        'SendsPasswordResetEmails' => ['showLinkRequestForm [Trait]', 'sendResetLinkEmail [Trait]', 'sendResetLinkResponse [Trait]', 'sendResetLinkFailedResponse [Trait]'],
        'ResetsPasswords' => ['showResetForm [Trait]', 'reset [Trait]', 'resetPassword [Trait]', 'sendResetResponse [Trait]', 'sendResetFailedResponse [Trait]'],
        'RedirectsUsers' => ['redirectPath [Trait]'],
        'ThrottlesLogins' => ['hasTooManyLoginAttempts [Trait]', 'incrementLoginAttempts [Trait]', 'sendLockoutResponse [Trait]', 'clearLoginAttempts [Trait]', 'limiter [Trait]', 'maxAttempts [Trait]', 'decayMinutes [Trait]'],
        'VerifiesEmails' => ['show [Trait]', 'verify [Trait]', 'resend [Trait]'],
        'ConfirmPasswords' => ['showConfirmForm [Trait]', 'confirm [Trait]'],
        'InteractsWithQueue' => ['job [Trait]', 'queue [Trait]', 'connection [Trait]', 'delay [Trait]', 'maxExceptions [Trait]', 'retryUntil [Trait]', 'tags [Trait]', 'backoff [Trait]'],
    ];
    return $map[$traitName] ?? [];
}

function guessPurpose($functionName, $content, $path) {
    $lower = strtolower($functionName);
    $fileType = getFileType(normalizePath($path));
    
    // Trait methods
    if (strpos($functionName, '[Trait]') !== false) {
        $base = trim(str_replace('[Trait]', '', $functionName));
        return "Inherited from trait: $base";
    }
    
    // Route annotations
    if (strpos($functionName, '[Route]') === 0) {
        $verb = trim(substr($functionName, 7));
        return "Registers $verb HTTP route(s)";
    }
    
    // Common Laravel patterns
    if ($lower === '__construct') return 'Constructor: initializes class dependencies';
    if ($lower === 'index') return 'Display list/overview page';
    if ($lower === 'create') return 'Show form to create new record';
    if ($lower === 'store') return 'Validate & save new record to DB';
    if ($lower === 'show') return 'Display single record details';
    if ($lower === 'edit') return 'Show form to edit existing record';
    if ($lower === 'update') return 'Validate & update existing record in DB';
    if ($lower === 'destroy') return 'Delete record from DB';
    if ($lower === 'boot') return 'Boot method: register events/policies';
    if ($lower === 'register') return 'Register services into service container';
    if ($lower === 'handle') return 'Process incoming HTTP request';
    if ($lower === 'map') return 'Define route group mappings';
    if ($lower === 'render') return 'Render exception as HTTP response';
    if ($lower === 'report') return 'Log or report exception';
    if ($lower === 'schedule') return 'Define scheduled tasks for cron';
    if ($lower === 'commands') return 'Register Artisan commands';
    if ($lower === 'mapwebroutes') return 'Map web route group';
    if ($lower === 'mapapiroutes') return 'Map API route group';
    if ($lower === 'mapadminroutes') return 'Map admin route group';
    
    // Model relationships
    $relationshipPatterns = ['belongsto', 'hasmany', 'hasone', 'belongstomany', 'hasmanythrough', 'morph', 'belongstomany'];
    foreach ($relationshipPatterns as $pat) {
        if (strpos($lower, $pat) !== false) return 'Eloquent relationship definition';
    }
    
    // Common model relationship method names (single word)
    $knownRelations = [
        'user', 'users', 'category', 'categories', 'product', 'products', 
        'order', 'orders', 'address', 'addresses', 'cart', 'carts',
        'subcategory', 'subcategories', 'varient', 'varients', 'variation',
        'color', 'colors', 'image', 'images', 'childimages', 'imagesproduct',
        'stock', 'stocks', 'shipping', 'slots', 'slot', 'coupon',
        'banner', 'banners', 'offerimage', 'offerimages',
        'deliveryperson', 'deliverypersons', 'areaassigns',
        'milkorders', 'productorders', 'area', 'district', 'city',
        'bankdetail', 'bankdetails', 'exchangerate', 'exchangerates',
        'sizechart', 'sizecharts', 'todaydeal', 'todaydeals',
        'notification', 'notifications', 'appnotification',
        'appalert', 'appsetting', 'appsettings', 'contactmessage',
        'productorder', 'productorderuseraddress',
        'milkorder', 'milkorderuseraddress',
        'sample', 'samples', 'sampleorderfulldetail',
        'design', 'designs', 'designlayer', 'designlayers',
        'customproduct', 'customproductdesign',
        'bulkorder', 'bulkorders', 'checkoutsetting',
        'plan', 'plantype', 'gendertype',
        'addresstype', 'allindiapincode',
        'invoice', 'invoices', 'orderreport', 'productwisereport',
        'productverient', 'productvarient', 'productvarients',
        'productcolor', 'productcolors', 'productcolorimage',
        'productchildimage', 'productstock', 'productslot',
        'productorderdetail', 'productrefund', 'producttracking',
        'producttransactionlog',
    ];
    if (in_array($lower, $knownRelations)) return 'Eloquent relationship to related model';
    if (in_array($lower, ['areaassign', 'areaassigns', 'deliveryperson', 'deliverypersons'])) return 'Eloquent relationship';
    if (preg_match('/^(milk)?(order|orders)$/', $lower)) return 'Eloquent relationship';
    
    // Scopes
    if (strpos($lower, 'scope') === 0) return 'Query scope: ' . substr($functionName, 5) . ' filter';
    if (strpos($lower, 'scope') !== false) return 'Query scope definition';
    
    // Accessors/Mutators
    if (preg_match('/^get\w+Attribute$/', $functionName)) return 'Accessor: computed attribute';
    if (preg_match('/^set\w+Attribute$/', $functionName)) return 'Mutator: attribute setter';
    
    // Route model binding  
    if ($lower === 'getroutekeyname') return 'Return route key name for binding';
    
    // Mailable
    if ($lower === 'build') return 'Build email content';
    if ($lower === 'envelope') return 'Define email envelope';
    if ($lower === 'content') return 'Define email content view';
    if ($lower === 'attachments') return 'Define email attachments';
    
    // Notifications
    if ($lower === 'via') return 'Define notification channels';
    if (strpos($lower, 'tomail') === 0) return 'Format for mail channel';
    if ($lower === 'toarray') return 'Format for array/db channel';
    
    // Export
    if ($lower === 'collection') return 'Return collection for export';
    if ($lower === 'headings') return 'Return spreadsheet headings';
    if ($lower === 'query') return 'Return query for export';
    if ($lower === 'map' && $fileType === 'Export') return 'Map data row';
    if ($lower === 'registerevents') return 'Register export events';
    
    // Factory
    if ($lower === 'definition') return 'Define model factory default values';
    if ($lower === 'unverified') return 'Factory state: unverified';
    
    // Specific known methods from codebase
    $knownMethods = [
        'addproduct' => 'Process add product form submission',
        'addcoupon' => 'Process add coupon form submission',
        'addbanner' => 'Process add banner form submission',
        'productlist' => 'Fetch product list data',
        'productslists' => 'Fetch products list for display',
        'recordpayment' => 'Record payment transaction for order',
        'searchproduct' => 'Search products by keyword',
        'filterproduct' => 'Filter products by criteria',
        'validateCategoryName' => 'Validate category name uniqueness',
        'validateProductName' => 'Validate product name uniqueness',
        'assignDeliveryPerson' => 'Assign delivery person to order/area',
        'deleteDeliveryPerson' => 'Remove delivery person assignment',
        'fetchAreaDeliveryPartners' => 'Get delivery partners for an area',
        'deleteAreaDeliveryPartners' => 'Remove delivery partner from area',
        'switchCurrency' => 'Switch active currency in session',
        'switchCurrencyByGet' => 'Switch currency via GET parameter',
        'performSwitch' => 'Execute currency switch logic',
        'convert' => 'Convert amount between currencies',
        'format_currency' => 'Format number as currency string',
        'successResponse' => 'Return JSON success response',
        'successResponseWithData' => 'Return JSON success with data payload',
        'errorResponse' => 'Return JSON error response',
        'reduceStock' => 'Reduce product stock quantity',
        'reduceStock1' => 'Reduce stock variant 2',
        'lowstock' => 'Get low stock products list',
        'highselling' => 'Get high selling products list',
        'updateimage' => 'Update image record for banner/product',
        'destroyweb' => 'Delete record from web-facing table',
        'updateOrder' => 'Update sort order of records',
        'offerImagess' => 'Offer images listing page',
        'userss' => 'Dashboard users listing',
        'update1' => 'Alternative update method',
        'duplicate' => 'Duplicate a record',
        'getDesignerData' => 'Get designer canvas data',
        'generateInvoice' => 'Generate PDF invoice for order',
        'updateProfile' => 'Update admin user profile',
        'updatePassword' => 'Update admin user password',
        'lang' => 'Switch application language',
        'root' => 'Root dashboard route',
    ];
    if (isset($knownMethods[$lower])) return $knownMethods[$lower];
    
    // Payment/Order specific
    if (strpos($lower, 'payment') !== false) return 'Payment processing logic';
    if (strpos($lower, 'invoice') !== false) return 'Invoice generation logic';
    if (strpos($lower, 'ship') !== false) return 'Shipping/tracking logic';
    if (strpos($lower, 'refund') !== false) return 'Refund processing logic';
    if (strpos($lower, 'cancel') !== false) return 'Order cancellation logic';
    if (strpos($lower, 'return') !== false) return 'Product return logic';
    if (strpos($lower, 'dispatch') !== false) return 'Order dispatch logic';
    if (strpos($lower, 'deliver') !== false) return 'Delivery tracking logic';
    if (strpos($lower, 'complete') !== false) return 'Order completion logic';
    if (strpos($lower, 'pack') !== false) return 'Packing order logic';
    if (strpos($lower, 'bulk') !== false) return 'Bulk order processing';
    if (strpos($lower, 'otp') !== false) return 'OTP generation/verification';
    if (strpos($lower, 'send') !== false) return 'Send notification/email/sms';
    if (strpos($lower, 'notify') !== false) return 'Send notification';
    if (strpos($lower, 'login') !== false) return 'Login/authentication logic';
    if (strpos($lower, 'register') !== false) return 'Registration logic';
    if (strpos($lower, 'forgot') !== false || strpos($lower, 'reset') !== false) return 'Password reset flow';
    if (strpos($lower, 'verify') !== false) return 'Verification logic';
    if (strpos($lower, 'logout') !== false) return 'Logout logic';
    if (strpos($lower, 'wishlist') !== false) return 'Wishlist management';
    if (strpos($lower, 'search') !== false) return 'Search/filter logic';
    if (strpos($lower, 'import') !== false) return 'Data import logic';
    if (strpos($lower, 'export') !== false) return 'Data export logic';
    if (strpos($lower, 'report') !== false) return 'Report generation';
    if (strpos($lower, 'print') !== false) return 'Print/preview logic';
    if (strpos($lower, 'download') !== false) return 'File download logic';
    if (strpos($lower, 'upload') !== false) return 'File upload logic';
    if (strpos($lower, 'translate') !== false) return 'Translation/Google API call';
    
    return '[NEEDS REVIEW]';
}

function getModuleName($path) {
    $path = normalizePath($path);
    
    if (strpos($path, 'Http/Controllers/Auth') !== false) return 'Auth';
    if (strpos($path, 'Http/Controllers') !== false) {
        $name = basename($path, '.php');
        $map = [
            'UserController' => 'Users',
            'ProductController' => 'Products',
            'CategoryController' => 'Categories',
            'SubCategoryController' => 'Categories',
            'OrderController' => 'Orders',
            'ProductOrdersController' => 'Orders',
            'CartController' => 'Cart/Checkout',
            'CouponController' => 'Coupons',
            'BannerImagesController' => 'Banners',
            'OfferImageController' => 'Banners',
            'ShippingController' => 'Shipping',
            'ReportsController' => 'Reports',
            'StockController' => 'Inventory',
            'CompoStockController' => 'Inventory',
            'ProductVarientControllet' => 'Products',
            'ProductSlotController' => 'Products',
            'ProductThumController' => 'Products',
            'ProductReturnController' => 'Orders',
            'ProductRefundController' => 'Orders',
            'RefundController' => 'Orders',
            'BulkOrderController' => 'Orders',
            'MilkOrdersController' => 'Milk',
            'MilkSlotController' => 'Milk',
            'MilkRefundController' => 'Milk',
            'SamplesController' => 'Samples',
            'SampleController' => 'Samples',
            'DesignsController' => 'Designs',
            'DesignController' => 'Designs',
            'CustomProductController' => 'Custom Products',
            'CustomDesignController' => 'Designs',
            'DeliveryPersonController' => 'Delivery',
            'AreaController' => 'Locations',
            'AreaAssignController' => 'Delivery',
            'NotificationController' => 'Notifications',
            'AppSettingsController' => 'Settings',
            'BankDetailController' => 'Bank Details',
            'CurrencyController' => 'Currency',
            'HomeController' => 'Dashboard',
            'IndexContrller' => 'Dashboard',
            'DashboardUserController' => 'Auth',
            'TopCustomerController' => 'Reports',
            'TodayDealsController' => 'Products',
            'PackingOrderController' => 'Orders',
            'PackingDispatchController' => 'Orders',
            'PackingDeliveryController' => 'Orders',
            'packingCompleteController' => 'Orders',
            'CancelProductController' => 'Orders',
            'OrderSummeryController' => 'Orders',
            'OrderAssetsController' => 'Orders',
            'TestController' => 'Utility',
            'LanguageController' => 'Localization',
            'AccountController' => 'Users',
            'AuthController' => 'Auth',
            'ShopController' => 'Shop',
            'ContactController' => 'Contact',
            'CategoriesController' => 'Categories',
            'PayPalOrderProcessor' => 'Payments',
            'sendsms' => 'SMS',
        ];
        return $map[$name] ?? 'Other';
    }
    
    if (strpos($path, '/Models/') !== false) {
        $name = basename($path, '.php');
        return 'Models';
    }
    
    if (strpos($path, 'routes/') !== false) return 'Routes';
    if (strpos($path, 'resources/views') !== false) {
        if (strpos($path, 'auth/') !== false) return 'Auth';
        if (strpos($path, 'emails/') !== false) return 'Emails';
        if (strpos($path, 'layouts/') !== false) return 'Layouts';
        if (strpos($path, 'components/') !== false) return 'Components';
        if (strpos($path, 'ajaxPages/') !== false) return 'AJAX';
        if (strpos($path, 'exports/') !== false) return 'Reports';
        if (strpos($path, 'pages/') !== false) {
            $name = basename($path, '.blade.php');
            $map = [
                'index' => 'Dashboard',
                'home' => 'Dashboard',
                'products' => 'Products',
                'product_varient' => 'Products',
                'productthum' => 'Products',
                'categories' => 'Categories',
                'subcategory' => 'Categories',
                'customer' => 'Users',
                'customer_edit' => 'Users',
                'myaccount' => 'Users',
                'product_orders' => 'Orders',
                'product_orders1' => 'Orders',
                'order_summery' => 'Orders',
                'orderslot' => 'Orders',
                'product_packing' => 'Orders',
                'product_dispatch' => 'Orders',
                'product_delivery' => 'Orders',
                'product_delivered' => 'Orders',
                'cancelproduct' => 'Orders',
                'return_product' => 'Orders',
                'refunds' => 'Orders',
                'product_refunds' => 'Orders',
                'coupons' => 'Coupons',
                'shippings' => 'Shipping',
                'stocks' => 'Inventory',
                'lowstock' => 'Inventory',
                'combostock' => 'Inventory',
                'samples' => 'Samples',
                'sample' => 'Samples',
                'designs' => 'Designs',
                'custom_products' => 'Custom Products',
                'custom-designer' => 'Designs',
                'customize-products' => 'Custom Products',
                'own-design' => 'Designs',
                'delivery_person' => 'Delivery',
                'offer_images' => 'Banners',
                'notification' => 'Notifications',
                'settings' => 'Settings',
                'income_reports' => 'Reports',
                'orderwisereport' => 'Reports',
                'topcustomer' => 'Reports',
                'highselling' => 'Reports',
                'todaydeals' => 'Products',
                'reviews' => 'Products',
                'product_slots' => 'Products',
                'milk_orders' => 'Milk',
                'milk_slots' => 'Milk',
                'milk_refunds' => 'Milk',
                'dashboard_user' => 'Auth',
                'dashboard' => 'Dashboard',
                'cart' => 'Cart/Checkout',
                'checkout' => 'Cart/Checkout',
                'shop' => 'Shop',
                'login' => 'Auth',
                'register' => 'Auth',
                'forgot-password' => 'Auth',
                'product-details' => 'Shop',
                'bulkorder' => 'Orders',
                'bank-details' => 'Bank Details',
                'contact' => 'Contact',
                'about' => 'Content Pages',
                'privacy-policy' => 'Content Pages',
                'refund-policy' => 'Content Pages',
                'shipping-policy' => 'Content Pages',
                'terms-and-conditions' => 'Content Pages',
                'ordersuccess' => 'Orders',
                'paypal-execute' => 'Payments',
                'wishlist' => 'Shop',
                'welcome' => 'Dashboard',
            ];
            return $map[$name] ?? 'Other';
        }
        return 'Other';
    }
    if (strpos($path, '/config/') !== false) return 'Config';
    if (strpos($path, 'database/migrations') !== false) return 'Migrations';
    if (strpos($path, 'database/seeders') !== false) return 'Database';
    if (strpos($path, 'database/factories') !== false) return 'Database';
    if (strpos($path, 'resources/lang') !== false) return 'Localization';
    if (strpos($path, 'Http/Middleware') !== false) return 'Middleware';
    if (strpos($path, 'Services') !== false) return 'Services';
    if (strpos($path, 'Mail') !== false) return 'Mail';
    if (strpos($path, 'Exports') !== false) return 'Reports';
    if (strpos($path, 'Providers') !== false) return 'Providers';
    if (strpos($path, 'Exceptions') !== false) return 'Exceptions';
    if (strpos($path, 'Console') !== false) return 'Console';
    if (strpos($path, 'Helpers') !== false) return 'Helpers';
    
    return 'Other';
}

echo "Starting audit scan v2...\n";
$allFiles = [];

// Scan both apps
foreach ($apps as $app) {
    $appPath = $basePath . '/' . $app;
    echo "Scanning $app...\n";
    
    $directories = [
        "$appPath/app",
        "$appPath/resources/views",
        "$appPath/resources/js",
        "$appPath/routes",
        "$appPath/config",
        "$appPath/database",
    ];
    
    foreach ($directories as $dir) {
        if (!is_dir($dir)) continue;
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $fullPath = $file->getPathname();
                $ext = $file->getExtension();
                
                // Skip libraries/vendor
                if (strpos($fullPath, 'resources/libs') !== false) continue;
                if (strpos($fullPath, 'vendor') !== false) continue;
                if (strpos($fullPath, 'node_modules') !== false) continue;
                
                if (in_array($ext, ['php', 'js'])) {
                    $relPath = str_replace($basePath . '/', '', $fullPath);
                    $allFiles[] = [
                        'path' => $relPath,
                        'fullpath' => $fullPath,
                        'app' => $app,
                    ];
                }
            }
        }
    }
}

echo "Found " . count($allFiles) . " files. Processing...\n";

// Group by module
$moduleGroups = [];

foreach ($allFiles as $fileInfo) {
    $path = $fileInfo['path'];
    $fullpath = $fileInfo['fullpath'];
    $app = $fileInfo['app'];
    
    $content = file_get_contents($fullpath);
    $fileType = getFileType($path);
    $module = getModuleName($path);
    
    $functions = extractFunctions($content, $path);
    $functionDetails = [];
    foreach ($functions as $fn) {
        $purpose = guessPurpose($fn, $content, $path);
        $functionDetails[] = ['name' => $fn, 'purpose' => $purpose];
    }
    
    // Brief file summary
    $summary = '';
    $prefix = $app === 'dash' ? '[Admin] ' : '[Web] ';
    
    if (empty($functions)) {
        if ($fileType === 'Config') {
            $configKey = basename($path, '.php');
            $summary = $prefix . "Configuration: $configKey settings";
        } elseif ($fileType === 'Blade View') {
            $viewName = basename($path);
            $summary = $prefix . "Blade template: $viewName";
        } elseif ($fileType === 'Language File') {
            $lang = basename(dirname($path));
            $summary = $prefix . "Translation strings for $lang locale";
        } elseif ($fileType === 'Migration') {
            $summary = $prefix . 'Database migration: ' . basename($path);
        } elseif ($fileType === 'Library (3rd Party)') {
            $summary = 'Third-party library file';
        } elseif ($fileType === 'JavaScript') {
            $summary = $prefix . 'JavaScript initialization/utility';
        } elseif ($fileType === 'Seeder') {
            $summary = $prefix . 'Database seeder';
        } elseif ($fileType === 'Factory') {
            $summary = $prefix . 'Model factory';
        } else {
            $summary = $prefix . basename($path) . ' file';
        }
    } else {
        if ($fileType === 'Controller') {
            $summary = $prefix . 'HTTP controller for ' . $module . ' features';
        } elseif ($fileType === 'Model') {
            $modelName = basename($path, '.php');
            $summary = $prefix . 'Eloquent model for ' . $modelName . ' table';
        } elseif ($fileType === 'Middleware') {
            $summary = $prefix . 'HTTP middleware';
        } elseif ($fileType === 'Service') {
            $summary = $prefix . 'Business logic service';
        } elseif ($fileType === 'Mailable') {
            $summary = $prefix . 'Email mailable';
        } elseif ($fileType === 'Export') {
            $summary = $prefix . 'Spreadsheet export class';
        } elseif ($fileType === 'Routes') {
            $summary = $prefix . 'Route definitions';
        } elseif ($fileType === 'Console Command') {
            $summary = $prefix . 'Artisan command';
        } elseif ($fileType === 'Console') {
            $summary = $prefix . 'Console kernel';
        } elseif ($fileType === 'Helper') {
            $summary = $prefix . 'Global helper functions';
        } elseif ($fileType === 'Exception Handler') {
            $summary = $prefix . 'Exception handler';
        } elseif ($fileType === 'Provider') {
            $summary = $prefix . 'Service provider';
        } else {
            $summary = $prefix . basename($path) . ' file';
        }
    }
    
    $moduleGroups[$app][$module][] = [
        'path' => $path,
        'type' => $fileType,
        'summary' => $summary,
        'functions' => $functionDetails,
    ];
}

// Generate markdown
$md = "# Full File & Function Audit Report\n\n";
$md .= "**Generated:** " . date('Y-m-d H:i:s') . "\n\n";
$md .= "**Project:** Saaluvesa Enterprises Private Limited\n\n";
$md .= "---\n\n";

foreach ($apps as $app) {
    $appName = ($app === 'dash') ? 'Admin Dashboard (dash/)' : 'Customer-Facing Web App (web/)';
    $md .= "## Application: $appName\n\n";
    
    ksort($moduleGroups[$app]);
    
    foreach ($moduleGroups[$app] as $module => $files) {
        $md .= "### $module\n\n";
        $md .= "| File | Type | Purpose Summary | Functions |\n";
        $md .= "|------|------|----------------|-----------|\n";
        
        usort($files, function($a, $b) {
            return strcmp($a['path'], $b['path']);
        });
        
        foreach ($files as $file) {
            $relPath = $file['path'];
            $funcs = '';
            if (!empty($file['functions'])) {
                $funcParts = [];
                foreach ($file['functions'] as $f) {
                    $funcParts[] = "`{$f['name']}()` — {$f['purpose']}";
                }
                $funcs = implode('<br>', $funcParts);
            } else {
                $funcs = '—';
            }
            
            $md .= "| `$relPath` | {$file['type']} | {$file['summary']} | $funcs |\n";
        }
        $md .= "\n";
    }
}

file_put_contents($outputFile, $md);
echo "Report generated: $outputFile\n";
echo "Done!\n";
