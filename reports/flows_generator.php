<?php
/**
 * Flows Report Generator
 * Maps request flows: URL → Route → Controller → Service → Model → DB
 */

$basePath = realpath(__DIR__ . '/..');
$outputFile = __DIR__ . '/flows-report.md';

function normalizePath($p) { return str_replace('\\', '/', $p); }

/**
 * Parse a route file to extract URL → Controller@Method mappings
 */
function parseRoutes($content, $app) {
    $flows = [];
    $currentMiddleware = '';
    
    // Find all route definitions
    $lines = explode("\n", $content);
    $inGroup = false;
    $groupMiddleware = '';
    $groupPrefix = '';
    
    foreach ($lines as $line) {
        $line = trim($line);
        
        // Track middleware groups
        if (preg_match("/Route::middleware\(\[?['\"](\w+)['\"]\]?\)->group\(function\s*\(\)\s*\{/", $line, $m)) {
            $groupMiddleware = $m[1];
            $inGroup = true;
        }
        if (preg_match("/Route::group\(\[.*'middleware'\s*=>\s*\[?'?(\w+)'?\]?.*\].*function\s*\(\)/", $line, $m)) {
            $groupMiddleware = $m[1];
            $inGroup = true;
        }
        if (preg_match("/Route::prefix\('([^']+)'\)->group\(function\s*\(\)/", $line, $m)) {
            $groupPrefix = $m[1];
        }
        
        // End of group
        if ($line === '});') {
            $inGroup = false;
            $groupMiddleware = '';
            $groupPrefix = '';
        }
        
        // Match various route formats
        $routeMatch = null;
        
        // Route::get/post/put/delete/any('path', [Controller::class, 'method'])
        if (preg_match("/Route::(\w+)\s*\(\s*['\"]([^'\"]+)['\"](?:\s*,\s*\[?([\w\\\\]+)::class\s*,\s*['\"]([\w]+)['\"]\]?)?/", $line, $m)) {
            $routeMatch = [
                'method' => strtoupper($m[1]),
                'url' => $m[2],
                'controller' => isset($m[3]) ? basename(str_replace('\\', '/', $m[3])) : '',
                'action' => $m[4] ?? '',
                'middleware' => $groupMiddleware,
                'prefix' => $groupPrefix,
            ];
        }
        
        // Route::resource('path', Controller::class)
        if (preg_match("/Route::resource\s*\(\s*['\"]([^'\"]+)['\"]\s*,\s*([\w\\\\]+)::class/", $line, $m)) {
            $resource = $m[1];
            $controller = basename(str_replace('\\', '/', $m[2]));
            
            // Check for ->only() or ->except()
            $only = [];
            if (preg_match("/->only\(\[([^\]]+)\]\)/", $line, $onlyMatch)) {
                $only = array_map('trim', explode(',', $onlyMatch[1]));
                foreach ($only as $o) {
                    $o = trim($o, "'\" ");
                    $verbMap = ['index' => 'GET', 'create' => 'GET', 'store' => 'POST', 'show' => 'GET', 'edit' => 'GET', 'update' => 'PUT/POST', 'destroy' => 'DELETE/POST'];
                    $urlMap = ['index' => $resource, 'create' => "$resource/create", 'store' => $resource, 'show' => "$resource/{id}", 'edit' => "$resource/{id}/edit", 'update' => "$resource/{id}", 'destroy' => "$resource/{id}"];
                    $routeMatch = [
                        'method' => $verbMap[$o] ?? 'GET',
                        'url' => $urlMap[$o] ?? $resource,
                        'controller' => $controller,
                        'action' => $o,
                        'middleware' => $groupMiddleware,
                        'prefix' => $groupPrefix,
                        'resource' => true,
                    ];
                    $flows[] = $routeMatch;
                }
                continue;
            }
            
            // Default resource routes (7 actions)
            $resourceActions = [
                ['GET', $resource, 'index'],
                ['GET', "$resource/create", 'create'],
                ['POST', $resource, 'store'],
                ['GET', "$resource/{id}", 'show'],
                ['GET', "$resource/{id}/edit", 'edit'],
                ['PUT/POST', "$resource/{id}", 'update'],
                ['DELETE/POST', "$resource/{id}", 'destroy'],
            ];
            foreach ($resourceActions as $ra) {
                $flows[] = [
                    'method' => $ra[0],
                    'url' => $ra[1],
                    'controller' => $controller,
                    'action' => $ra[2],
                    'middleware' => $groupMiddleware,
                    'prefix' => $groupPrefix,
                    'resource' => true,
                ];
            }
            continue;
        }
        
        if ($routeMatch) {
            $flows[] = $routeMatch;
        }
    }
    
    return $flows;
}

/**
 * Read a controller file and extract:
 * - What models it uses (imports)
 * - What services it calls
 * - What methods exist with their params
 */
function analyzeController($filePath) {
    if (!file_exists($filePath)) return null;
    
    $content = file_get_contents($filePath);
    $info = [
        'imports' => [],
        'methods' => [],
        'calls_services' => [],
        'calls_models' => [],
    ];
    
    // Extract use statements
    preg_match_all('/^use\s+([^;]+);/m', $content, $useMatches);
    foreach ($useMatches[1] as $use) {
        $shortName = basename(str_replace('\\', '/', $use));
        if (strpos($use, 'Models') !== false) {
            $info['calls_models'][] = $shortName;
        }
        if (strpos($use, 'Services') !== false) {
            $info['calls_services'][] = $shortName;
        }
        if (strpos($use, 'Mail') !== false) {
            $info['calls_mail'][] = $shortName;
        }
        if (strpos($use, 'Exports') !== false) {
            $info['calls_exports'][] = $shortName;
        }
        $info['imports'][] = $shortName;
    }
    
    // Extract method signatures and body calls
    preg_match_all('/function\s+(\w+)\s*\(([^)]*)\)\s*(?::\s*([\w\\\\]+))?\s*\{/', $content, $methodMatches, PREG_SET_ORDER);
    foreach ($methodMatches as $mm) {
        $methodName = $mm[1];
        $params = trim($mm[2]);
        $returnType = isset($mm[3]) ? trim($mm[3]) : '';
        
        // Get method body (simplified - just get what we need)
        $methodBody = getMethodBody($content, $methodName);
        
        // Check what models/services this method calls
        $usedModels = [];
        $usedServices = [];
        $usedMails = [];
        $usedExports = [];
        $usedFacades = [];
        $dbOperations = [];
        
        foreach ($info['calls_models'] as $model) {
            if (strpos($methodBody, $model) !== false) {
                $usedModels[] = $model;
            }
        }
        foreach ($info['calls_services'] as $svc) {
            if (strpos($methodBody, $svc) !== false) {
                $usedServices[] = $svc;
            }
        }
        if (isset($info['calls_mail'])) {
            foreach ($info['calls_mail'] as $mail) {
                if (strpos($methodBody, $mail) !== false) {
                    $usedMails[] = $mail;
                }
            }
        }
        if (isset($info['calls_exports'])) {
            foreach ($info['calls_exports'] as $exp) {
                if (strpos($methodBody, $exp) !== false) {
                    $usedExports[] = $exp;
                }
            }
        }
        
        // Check for DB operations
        if (preg_match('/\b(DB::|DB::table|\->save\(|\->update\(|\->delete\(|\->create\(|\->insert\(|\->where\()/', $methodBody)) {
            $dbOperations[] = 'DB query/update';
        }
        if (preg_match('/\b(get|first|find|all|paginate|pluck|value)\(/', $methodBody)) {
            $dbOperations[] = 'DB read';
        }
        if (preg_match('/\b(dispatch|Mail::|Notification::|Event::)/', $methodBody)) {
            $usedFacades[] = 'Queue/Mail/Event';
        }
        if (preg_match('/\b(Session::|session\(|Cache::|cache\()/', $methodBody)) {
            $usedFacades[] = 'Session/Cache';
        }
        if (preg_match('/\b(Excel::|Maatwebsite)/', $methodBody)) {
            $usedExports[] = 'Excel';
        }
        if (preg_match('/\b(PDF::|PDF|Snappy|DomPDF|Barryvdh)/', $methodBody)) {
            $usedExports[] = 'PDF';
        }
        
        $info['methods'][$methodName] = [
            'params' => $params,
            'return_type' => $returnType,
            'models' => array_unique($usedModels),
            'services' => array_unique($usedServices),
            'mails' => array_unique($usedMails),
            'exports' => array_unique($usedExports),
            'facades' => array_unique($usedFacades),
            'db_ops' => array_unique($dbOperations),
        ];
    }
    
    return $info;
}

function getMethodBody($content, $methodName) {
    // Find the method and extract until the matching closing brace
    $pattern = '/function\s+' . preg_quote($methodName, '/') . '\s*\(/';
    if (!preg_match($pattern, $content, $m, PREG_OFFSET_CAPTURE)) return '';
    
    $start = $m[0][1];
    // Find opening {
    $bracePos = strpos($content, '{', $start);
    if ($bracePos === false) return '';
    
    // Extract balanced braces
    $depth = 0;
    $body = '';
    for ($i = $bracePos; $i < strlen($content); $i++) {
        $char = $content[$i];
        if ($char === '{') $depth++;
        if ($char === '}') $depth--;
        if ($depth === 0) break;
        $body .= $char;
    }
    
    return $body;
}

echo "Generating flows report...\n";

// Parse both route files
$apps = [
    'dash' => [
        'name' => 'Admin Dashboard',
        'routes' => ["$basePath/dash/routes/web.php"],
    ],
    'web' => [
        'name' => 'Customer Web App',
        'routes' => ["$basePath/web/routes/web.php"],
    ],
];

$allFlows = [];
$flowDetails = [];

foreach ($apps as $appKey => $appInfo) {
    echo "Processing $appKey routes...\n";
    
    foreach ($appInfo['routes'] as $routeFile) {
        if (!file_exists($routeFile)) continue;
        $content = file_get_contents($routeFile);
        $routes = parseRoutes($content, $appKey);
        
        foreach ($routes as $route) {
            $controllerFile = "$basePath/$appKey/app/Http/Controllers/{$route['controller']}.php";
            if (!file_exists($controllerFile)) {
                // Try with subdirectory - Auth subfolder etc.
                $altPaths = [
                    "$basePath/$appKey/app/Http/Controllers/Auth/{$route['controller']}.php",
                ];
                foreach ($altPaths as $ap) {
                    if (file_exists($ap)) {
                        $controllerFile = $ap;
                        break;
                    }
                }
            }
            
            $analysis = null;
            if (file_exists($controllerFile)) {
                $analysis = analyzeController($controllerFile);
            }
            
            $key = $route['url'] . '|' . $route['method'];
            $allFlows[$appKey][$key] = [
                'method' => $route['method'],
                'url' => $route['url'],
                'controller' => $route['controller'],
                'action' => $route['action'],
                'middleware' => $route['middleware'],
                'analysis' => $analysis,
            ];
        }
    }
}

// --- Generate Markdown ---
$md = "# Application Flows Report\n\n";
$md .= "**Generated:** " . date('Y-m-d H:i:s') . "\n\n";
$md .= "Maps request lifecycle: **URL → Route → Middleware → Controller → Method → (Service/Model/Mail) → DB → Response**\n\n";
$md .= "---\n\n";

// ========= BUSINESS PROCESS FLOWS =========
$md .= "## Business Process Flows\n\n";

// Order Placement Flow (web)
$md .= "### 1. Customer Order Placement (Web App)\n\n";
$md .= "```\n";
$md .= "User browses products\n";
$md .= "  → GET /shop ⇒ ShopController@index ⇒ Product::all()\n";
$md .= "  → GET /product-details/{id} ⇒ ShopController@show ⇒ Product::find($id)\n";
$md .= "  → GET /categories ⇒ CategoriesController@index ⇒ Category::all()\n";
$md .= "User adds to cart\n";
$md .= "  → POST /cart/add ⇒ CartController@addToCart ⇒ Cart::create()\n";
$md .= "  → GET /cart ⇒ CartController@index ⇒ Cart::with('product')\n";
$md .= "  → PUT /cart/update/{id} ⇒ CartController@updateQuantity\n";
$md .= "  → DELETE /cart/remove/{id} ⇒ CartController@removeItem\n";
$md .= "User checks out\n";
$md .= "  → GET /checkout ⇒ OrderController@checkout (auth)\n";
$md .= "  → GET /bank-details ⇒ OrderController@showBankDetails\n";
$md .= "  → POST /order/place ⇒ OrderController@placeOrder\n";
$md .= "      → Validates request\n";
$md .= "      → Creates ProductOrder record\n";
$md .= "      → Creates ProductOrderDetail records\n";
$md .= "      → Creates ProductOrderUserAddress record\n";
$md .= "      → Clears cart\n";
$md .= "      → Mails: OrderSuccess to customer\n";
$md .= "      → Mails: AdminOrderNotification to admin\n";
$md .= "  → POST /create-paypal-payment ⇒ OrderController@createPayPalPayment\n";
$md .= "      → Calls PayPalService::createPayment()\n";
$md .= "  → GET /paypal/execute ⇒ OrderController@executePayPalPayment\n";
$md .= "      → Calls PayPalService::executePayment()\n";
$md .= "  → GET /order/success ⇒ OrderController@success\n";
$md .= "  → POST /order/upload-proof ⇒ OrderController@uploadPaymentProof\n";
$md .= "```\n\n";

$md .= "### 2. Custom Product Designer Flow (Web App)\n\n";
$md .= "```\n";
$md .= "User browses customizable products\n";
$md .= "  → GET /api/customproducts ⇒ CustomProductController@index\n";
$md .= "  → GET /api/customproducts/{id} ⇒ CustomProductController@show\n";
$md .= "  → GET /api/customproducts/{id}/designer-data ⇒ CustomProductController@getDesignerData\n";
$md .= "User designs a product\n";
$md .= "  → POST /api/designs/init ⇒ CustomDesignController@init\n";
$md .= "      → Creates CustomproductDesign record\n";
$md .= "  → POST /api/designs/save ⇒ CustomDesignController@store\n";
$md .= "  → PUT /api/designs/{id} ⇒ CustomDesignController@update\n";
$md .= "  → POST /api/designs/upload-user-image ⇒ CustomDesignController@uploadUserImage\n";
$md .= "  → POST /api/designs/export-image ⇒ CustomDesignController@uploadExport\n";
$md .= "User adds custom product to cart\n";
$md .= "  → POST /cart/add ⇒ CartController@addToCart\n";
$md .= "      → Cart record links to customproduct_designs via design_id\n";
$md .= "User completes order\n";
$md .= "  → Same as Order Placement flow above\n";
$md .= "```\n\n";

$md .= "### 3. Order Fulfillment Flow (Admin Dashboard)\n\n";
$md .= "```\n";
$md .= "New order received (from web app)\n";
$md .= "  → Admin views pending orders\n";
$md .= "  → GET /productOrders ⇒ ProductOrdersController@index\n";
$md .= "Admin packs order\n";
$md .= "  → GET /productpacking ⇒ PackingOrderController@index\n";
$md .= "  → POST /updatestatupacking ⇒ PackingOrderController@updatepacking\n";
$md .= "      → Updates ProductOrder status to 'packing'\n";
$md .= "Admin dispatches order\n";
$md .= "  → GET /productdispatch ⇒ PackingDispatchController@index\n";
$md .= "  → POST /updatestatusdispatch ⇒ PackingDispatchController@updatedispach\n";
$md .= "      → Updates ProductOrder status to 'dispatch'\n";
$md .= "Admin marks delivered\n";
$md .= "  → GET /productdelivery ⇒ PackingDeliveryController@index\n";
$md .= "  → POST /updatestatusdelivery ⇒ PackingDeliveryController@updatedelive\n";
$md .= "      → Updates ProductOrder status to 'delivered'\n";
$md .= "Order complete\n";
$md .= "  → GET /productcomplete ⇒ packingCompleteController@index\n";
$md .= "Admin can also:\n";
$md .= "  → Assign delivery person: POST /productOrderDeliveryAssign\n";
$md .= "  → View invoice: GET /viewProductInvoice/{orderId}\n";
$md .= "  → Process refund: POST /updaterefund\n";
$md .= "  → Handle returns: GET /productreturn\n";
$md .= "```\n\n";

$md .= "### 4. User Registration & Auth Flow\n\n";
$md .= "**Web App (Customer):**\n";
$md .= "```\n";
$md .= "  → GET /register ⇒ AuthController@showRegister\n";
$md .= "  → POST /register ⇒ AuthController@register\n";
$md .= "      → Creates User record\n";
$md .= "      → Mails: RegistrationSuccess\n";
$md .= "  → GET /login ⇒ AuthController@showLogin\n";
$md .= "  → POST /login ⇒ AuthController@login\n";
$md .= "  → POST /logout ⇒ AuthController@logout\n";
$md .= "  → GET /forgot-password ⇒ AuthController@showForgotPassword\n";
$md .= "  → POST /forgot-password/send-otp ⇒ AuthController@sendOTP\n";
$md .= "      → Creates OTP record, mails ForgotPasswordOTP\n";
$md .= "  → POST /forgot-password/verify-otp ⇒ AuthController@verifyOTP\n";
$md .= "  → POST /forgot-password/reset ⇒ AuthController@resetPassword\n";
$md .= "```\n\n";
$md .= "**Admin Dashboard:**\n";
$md .= "```\n";
$md .= "  → Standard Laravel Auth::routes();\n";
$md .= "  → LoginController (AuthenticatesUsers trait)\n";
$md .= "  → RegisterController (RegistersUsers trait)\n";
$md .= "  → ForgotPasswordController (SendsPasswordResetEmails)\n";
$md .= "  → ResetPasswordController (ResetsPasswords)\n";
$md .= "  → DashboardUserController for admin user CRUD\n";
$md .= "```\n\n";

$md .= "### 5. Milk Subscription Flow\n\n";
$md .= "```\n";
$md .= "Customer places milk subscription (via web app)\n";
$md .= "  → Creates MilkOrder record with plan_type\n";
$md .= "Admin manages:\n";
$md .= "  → GET /milkOrders ⇒ MilkOrdersController@index\n";
$md .= "  → POST /milkOrderDeliveryAssign ⇒ assign delivery person\n";
$md .= "  → POST /getAreaAssignedDelvieryPerson/{areaId}\n";
$md .= "  → GET /milkOrders/{orderId} ⇒ MilkSlotController@getMilkSlots\n";
$md .= "  → POST /createMilkSubscription ⇒ ProductController@createMilkSubscription\n";
$md .= "  → POST /createMilkSlot ⇒ ProductController@createMilkSlot\n";
$md .= "  → POST /cancelMilkSlot ⇒ MilkSlotController@cancelMilkSlot\n";
$md .= "Milk Refunds:\n";
$md .= "  → GET /milkRefunds ⇒ MilkRefundController@index\n";
$md .= "  → POST /getMilkRefundDatas ⇒ get refund data\n";
$md .= "  → POST /refundMilkSlot ⇒ process refund\n";
$md .= "```\n\n";

$md .= "### 6. Inventory & Stock Management Flow\n\n";
$md .= "```\n";
$md .= "Admin views stock:\n";
$md .= "  → GET /stocks ⇒ StockController@index\n";
$md .= "  → GET /lowstock ⇒ StockController@lowstock (low stock alerts)\n";
$md .= "  → GET /highselling ⇒ StockController@highselling (top sellers)\n";
$md .= "  → GET /combostock ⇒ CompoStockController@index\n";
$md .= "Stock operations:\n";
$md .= "  → POST /reduceStock ⇒ StockController@reduceStock\n";
$md .= "  → POST /reduceStock1 ⇒ CompoStockController@reduceStock1\n";
$md .= "  → POST /updateStack ⇒ StockController@update1\n";
$md .= "Database tables: product_stocks, products, product_varients\n";
$md .= "```\n\n";

$md .= "### 7. Reports & Analytics Flow\n\n";
$md .= "```\n";
$md .= "Income Reports:\n";
$md .= "  → GET /incomeReports ⇒ ReportsController@incomeReports\n";
$md .= "  → POST /getIncomeReports ⇒ ReportsController@getIncomeReports\n";
$md .= "Order-wise Reports:\n";
$md .= "  → GET /orderwisereport ⇒ OrderController@orderwisereport\n";
$md .= "  → GET /order-wise-report/filter ⇒ OrderController@filterorderWiseReport\n";
$md .= "  → GET /oreport/export/excel ⇒ OrderReportExport (Excel)\n";
$md .= "  → GET /oreport/export/pdf ⇒ PDF export\n";
$md .= "Top Customers:\n";
$md .= "  → GET /topcustomer ⇒ TopCustomerController@index\n";
$md .= "```\n\n";

// ============ REQUEST FLOW MAPS ============
$md .= "---\n\n## Request Flow Maps\n\n";
$md .= "### Admin Dashboard (dash/)\n\n";
$md .= "| Method | URL | Middleware | Controller@Method | Models Used | Services/Mail | DB Ops |\n";
$md .= "|--------|-----|-----------|-------------------|-------------|---------------|--------|\n";

ksort($allFlows['dash']);
foreach ($allFlows['dash'] as $flow) {
    $url = "/{$flow['url']}";
    $url = str_replace('//', '/', $url);
    $middleware = $flow['middleware'] ?: 'auth';
    $ctrlMethod = "{$flow['controller']}@{$flow['action']}";
    
    $models = '';
    $services = '';
    $dbOps = '';
    
    if ($flow['analysis'] && isset($flow['analysis']['methods'][$flow['action']])) {
        $m = $flow['analysis']['methods'][$flow['action']];
        $models = implode(', ', $m['models']);
        $svcs = array_merge($m['services'], $m['mails'], $m['exports']);
        $services = implode(', ', $svcs);
        $dbOps = implode(', ', $m['db_ops']);
    }
    
    $md .= "| {$flow['method']} | `$url` | $middleware | `$ctrlMethod` | $models | $services | $dbOps |\n";
}

$md .= "\n### Customer Web App (web/)\n\n";
$md .= "| Method | URL | Middleware | Controller@Method | Models Used | Services/Mail | DB Ops |\n";
$md .= "|--------|-----|-----------|-------------------|-------------|---------------|--------|\n";

ksort($allFlows['web']);
foreach ($allFlows['web'] as $flow) {
    $url = "/{$flow['url']}";
    $url = str_replace('//', '/', $url);
    $middleware = $flow['middleware'] ?: ($flow['action'] === 'login' || $flow['action'] === 'register' ? 'guest' : 'web');
    $ctrlMethod = "{$flow['controller']}@{$flow['action']}";
    
    $models = '';
    $services = '';
    $dbOps = '';
    
    if ($flow['analysis'] && isset($flow['analysis']['methods'][$flow['action']])) {
        $m = $flow['analysis']['methods'][$flow['action']];
        $models = implode(', ', $m['models']);
        $svcs = array_merge($m['services'], $m['mails'], $m['exports']);
        $services = implode(', ', $svcs);
        $dbOps = implode(', ', $m['db_ops']);
    }
    
    $md .= "| {$flow['method']} | `$url` | $middleware | `$ctrlMethod` | $models | $services | $dbOps |\n";
}

$md .= "\n---\n\n## Architecture Overview\n\n";
$md .= "### Two-App Architecture\n\n";
$md .= "```
┌─────────────────────────────────────────────────────┐
│                   Web App (web/)                     │
│  Customer-facing: Shop, Cart, Checkout, Designer    │
│  DB: saaluvesa_db (shared with admin)               │
└──────────────────┬──────────────────────────────────┘
                   │ writes orders, users, carts
                   ▼
┌─────────────────────────────────────────────────────┐
│              Admin Dashboard (dash/)                 │
│  Staff-facing: Orders, Inventory, Reports, Users    │
│  DB: saaluvesa_db (shared with web)                 │
└─────────────────────────────────────────────────────┘
```\n\n";

$md .= "### Database Sharing\n\n";
$md .= "Both apps share the same MySQL database `saaluvesa_db`. Tables used by:\n\n";
$md .= "- **Both apps**: users, user_addresses, categories, sub_categories, products, product_varients, product_colors, product_color_images, carts, product_orders, product_order_user_addresses, product_stocks, designs, customproducts, customproduct_designs, banners, bulk_orders, app_settings, bank_details, exchange_rates, samples\n";
$md .= "- **Admin only**: dashboard_users, milk_orders, milk_slots, milk_refunds, product_trackings, product_refunds, product_transaction_logs, order_export_data, invoices, shipping, areas, area_assigns, delivery_people, coupons, offer_images, notifications, app_alerts, app_notifications, otps, mail_otps, today_deals, address_types, gender_types, plan_types\n";
$md .= "- **Web only**: contact_messages, design_layers, sample_order_full_details, checkout_settings, size_charts\n\n";

$md .= "### Key Middleware Chain\n\n";
$md .= "| Middleware | App | Purpose |\n";
$md .= "|-----------|-----|---------|\n";
$md .= "| `auth` | both | Ensures user is authenticated |\n";
$md .= "| `guest` | web | Redirects authenticated users away from login/register |\n";
$md .= "| `web` | both | Standard web middleware group (sessions, cookies, CSRF) |\n";
$md .= "| `SetLocale` | web | Sets app locale based on session/URL |\n";
$md .= "| `SetCurrency` | both | Sets active currency from session |\n";
$md .= "| `Localization` | dash | Localization middleware |\n";

file_put_contents($outputFile, $md);
echo "Flows report generated: $outputFile\n";
echo "Done!\n";
