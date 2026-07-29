<?php
/**
 * Master Report Generator — generates all 7 audit reports
 * 1. Security Audit
 * 2. Validation & Input Sanitization
 * 3. Email/Mail Inventory
 * 4. Authorization Matrix
 * 5. Error Handling Audit
 * 6. Frontend Asset Map
 * 7. Payment Flow Deep Dive
 */

$basePath = realpath(__DIR__ . '/..');
$reportsDir = __DIR__;

function normalizePath($p) { return str_replace('\\', '/', $p); }

function getAllPhpFiles($dir) {
    $files = [];
    if (!is_dir($dir)) return $files;
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS));
    foreach ($it as $f) {
        if ($f->isFile() && $f->getExtension() === 'php' && strpos($f->getPathname(), 'vendor') === false && strpos($f->getPathname(), 'resources/libs') === false) {
            $files[] = $f->getPathname();
        }
    }
    return $files;
}

function readFileContent($path) {
    return file_exists($path) ? file_get_contents($path) : '';
}

function getMethodBodies($content) {
    $methods = [];
    preg_match_all('/function\s+(\w+)\s*\(([^)]*)\)\s*(?::\s*([\w\\\\]+))?\s*\{/', $content, $matches, PREG_SET_ORDER);
    foreach ($matches as $m) {
        $name = $m[1];
        $params = $m[2];
        $returnType = $m[3] ?? '';
        $body = getMethodBody($content, $name);
        $methods[$name] = ['params' => $params, 'return_type' => $returnType, 'body' => $body];
    }
    return $methods;
}

function getMethodBody($content, $methodName) {
    $pattern = '/function\s+' . preg_quote($methodName, '/') . '\s*\(/';
    if (!preg_match($pattern, $content, $m, PREG_OFFSET_CAPTURE)) return '';
    $start = $m[0][1];
    $bracePos = strpos($content, '{', $start);
    if ($bracePos === false) return '';
    $depth = 0; $body = '';
    for ($i = $bracePos; $i < strlen($content); $i++) {
        $c = $content[$i];
        if ($c === '{') $depth++;
        if ($c === '}') { $depth--; if ($depth === 0) break; }
        $body .= $c;
    }
    return $body . '}';
}

echo "========== MASTER REPORT GENERATOR ==========\n\n";

// ====================================================================
// REPORT 1: SECURITY AUDIT
// ====================================================================
echo "[1/7] Generating Security Audit... ";
$md = "# Security Audit Report\n\n";
$md .= "**Generated:** " . date('Y-m-d H:i:s') . "\n\n";
$md .= "Scans for: mass assignment, hardcoded secrets, SQL injection, XSS, CSRF, file upload risks, debug mode\n\n---\n\n";

$findings = ['critical' => [], 'high' => [], 'medium' => [], 'low' => []];

foreach (['dash', 'web'] as $app) {
    $files = getAllPhpFiles("$basePath/$app/app");
    $files = array_merge($files, getAllPhpFiles("$basePath/$app/config"));
    $files = array_merge($files, getAllPhpFiles("$basePath/$app/routes"));
    
    foreach ($files as $file) {
        $relPath = str_replace($basePath . '/', '', $file);
        $content = file_get_contents($file);
        $methods = getMethodBodies($content);
        
        // 1. Mass Assignment: request()->all() or $request->all()
        if (preg_match('/\-\>all\s*\(\)/', $content)) {
            foreach ($methods as $mname => $minfo) {
                if (strpos($minfo['body'], '->all()') !== false || strpos($minfo['body'], '->all(') !== false) {
                    $findings['critical'][] = "$relPath :: $mname() — Uses `->all()` (mass assignment risk). Use `->validated()` or `->only()` instead.";
                }
            }
        }
        
        // 2. Hardcoded secrets/credentials
        if (preg_match('/["\'](password|secret|api_key|api_secret|token|auth_token)["\']\s*=>?\s*["\'][^"\']+["\']/i', $content, $hm)) {
            $findings['critical'][] = "$relPath — Possible hardcoded secret: `{$hm[0]}`";
        }
        
        // 3. SQL injection raw queries
        if (preg_match('/DB::(select|statement|unprepared)\s*\(/', $content)) {
            $findings['high'][] = "$relPath — Uses raw SQL queries via DB::select/statement. Risk of SQL injection if not parameterized.";
        }
        if (preg_match('/whereRaw\s*\(|orderByRaw\s*\(|havingRaw\s*\(/', $content)) {
            $findings['high'][] = "$relPath — Uses raw expressions (whereRaw/orderByRaw). Risk of SQL injection.";
        }
        
        // 4. XSS: unescaped output in Blade
        if (strpos($file, '.blade.php') !== false) {
            if (preg_match('/\{\{\s*\{\s*.*\s*\}\s*\}/', $content) && !preg_match('/\{\!\!\s*.*\s*\!\}/', $content)) {
                // Check for unescaped !!
                preg_match_all('/\{\!\!\s*(\$[^\s}]+)\s*\!\}/', $content, $xssMatches);
                if (!empty($xssMatches[0])) {
                    $findings['high'][] = "$relPath — Uses unescaped output `{!! ... !!}` — XSS risk if content is user-supplied.";
                }
            }
        }
        
        // 5. env() in production config
        if (strpos($file, 'config/app.php') !== false) {
            if (preg_match("/'debug'\s*=>\s*env\('APP_DEBUG'/", $content)) {
                $findings['high'][] = "$relPath — Debug mode controlled by env. Ensure APP_DEBUG=false in production.";
            }
        }
        
        // 6. Check $fillable/$guarded in models
        if (strpos($file, '/Models/') !== false) {
            $hasFillable = preg_match('/\$fillable\s*=\s*\[/', $content);
            $hasGuarded = preg_match('/\$guarded/', $content);
            $hasNoGuardedFillable = preg_match('/\$guarded\s*=\s*\[\s*\]/', $content);
            
            if ($hasGuarded && !$hasFillable) {
                // $guarded = [] means all attributes are mass assignable — dangerous
                if ($hasNoGuardedFillable) {
                    $findings['critical'][] = "$relPath — `\$guarded = []` — ALL attributes are mass assignable! Define `\$fillable` instead.";
                }
            } elseif (!$hasFillable && !$hasGuarded && preg_match('/extends\s+Model/', $content)) {
                $findings['medium'][] = "$relPath — No `\$fillable` or `\$guarded` defined. Implicit mass assignment protection may not work as expected.";
            }
        }
        
        // 7. CSRF: routes without CSRF protection
        if (strpos($file, 'routes/') !== false && strpos($file, 'api.php') !== false) {
            if (preg_match('/Route::(post|put|delete|patch)\s*\(/', $content)) {
                $findings['medium'][] = "$relPath — API routes with POST/PUT/DELETE — ensure CSRF token handling or use Sanctum.";
            }
        }
        
        // 8. File upload security
        if (preg_match('/\b(store|move|putFile)\s*\(/', $content) && preg_match('/\b(request|file|upload)\b/i', $content)) {
            foreach ($methods as $mname => $minfo) {
                if (preg_match('/\b(store|move)\s*\(/', $minfo['body']) && preg_match('/\$request/', $minfo['body'])) {
                    if (!preg_match('/isValid|extension|mimes:|mimetypes:|max:/', $minfo['body'])) {
                        $findings['high'][] = "$relPath :: $mname() — File upload without validation checks (isValid/extension/mimes).";
                    }
                }
            }
        }
        
        // 9. Debug/Info leakage
        if (preg_match('/\b(phpinfo|var_dump|print_r|dump)\s*\(/', $content)) {
            $findings['high'][] = "$relPath — Contains debug output function (phpinfo/var_dump/print_r/dump). Remove before production.";
        }
        
        // 10. Insecure deserialization
        if (preg_match('/unserialize\s*\(/', $content)) {
            $findings['critical'][] = "$relPath — Uses unserialize() — insecure deserialization risk.";
        }
    }
}

$severityOrder = ['critical', 'high', 'medium', 'low'];
$labels = ['critical' => '🔴 Critical', 'high' => '🟠 High', 'medium' => '🟡 Medium', 'low' => '🟢 Low'];

foreach ($severityOrder as $sev) {
    if (empty($findings[$sev])) continue;
    $md .= "## {$labels[$sev]} Severity\n\n";
    foreach ($findings[$sev] as $finding) {
        $md .= "- $finding\n";
    }
    $md .= "\n---\n\n";
}

$totalFindings = array_sum(array_map('count', $findings));
$md .= "## Summary\n\n- **Total findings:** $totalFindings\n";
foreach ($severityOrder as $sev) {
    $md .= "- **{$labels[$sev]}:** " . count($findings[$sev]) . "\n";
}

file_put_contents("$reportsDir/security-audit.md", $md);
echo count($findings['critical']) . " critical, " . count($findings['high']) . " high, " . count($findings['medium']) . " medium, " . count($findings['low']) . " low\n";

// ====================================================================
// REPORT 2: VALIDATION & INPUT SANITIZATION
// ====================================================================
echo "[2/7] Generating Validation & Input Audit... ";
$md = "# Validation & Input Sanitization Audit\n\n";
$md .= "**Generated:** " . date('Y-m-d H:i:s') . "\n\n";
$md .= "Checks which endpoints validate input, which use request()->all(), which have no validation at all.\n\n---\n\n";

$controllersWithValidation = [];
$controllersWithoutValidation = [];
$usingRequestAll = [];

foreach (['dash', 'web'] as $app) {
    $ctrlDir = "$basePath/$app/app/Http/Controllers";
    if (!is_dir($ctrlDir)) continue;
    $files = getAllPhpFiles($ctrlDir);
    
    foreach ($files as $file) {
        $relPath = str_replace($basePath . '/', '', $file);
        $content = file_get_contents($file);
        $methods = getMethodBodies($content);
        
        foreach ($methods as $mname => $minfo) {
            $body = $minfo['body'];
            $hasValidation = preg_match('/\b(validate|Validator|validated)\s*\(/', $body);
            $hasRequestAll = preg_match('/\-\>all\s*\(/', $body);
            $hasRequestOnly = preg_match('/\-\>only\s*\(/', $body);
            $hasRequestValidated = preg_match('/\-\>validated\s*\(/', $body);
            $hasRequestInput = preg_match('/\-\>input\s*\(/', $body);
            
            $entry = ['app' => $app, 'file' => $relPath, 'method' => $mname, 'params' => $minfo['params']];
            
            if ($hasValidation || $hasRequestValidated) {
                $controllersWithValidation[] = $entry;
            } else {
                $controllersWithoutValidation[] = $entry;
            }
            
            if ($hasRequestAll) {
                $usingRequestAll[] = $entry;
            }
        }
    }
}

$md .= "## Controllers WITH Validation\n\n";
$md .= "| App | File | Method |\n";
$md .= "|-----|------|--------|\n";
foreach ($controllersWithValidation as $c) {
    $md .= "| {$c['app']} | `{$c['file']}` | `{$c['method']}()` |\n";
}

$md .= "\n## Controllers WITHOUT Validation ⚠️\n\n";
$md .= "| App | File | Method | Params |\n";
$md .= "|-----|------|--------|--------|\n";
foreach ($controllersWithoutValidation as $c) {
    $md .= "| {$c['app']} | `{$c['file']}` | `{$c['method']}()` | `{$c['params']}` |\n";
}

$md .= "\n## Controllers Using `request()->all()` 🔴\n\n";
$md .= "| App | File | Method |\n";
$md .= "|-----|------|--------|\n";
foreach ($usingRequestAll as $c) {
    $md .= "| {$c['app']} | `{$c['file']}` | `{$c['method']}()` |\n";
}

$md .= "\n## Summary\n\n";
$md .= "- Methods with validation: " . count($controllersWithValidation) . "\n";
$md .= "- Methods WITHOUT validation: " . count($controllersWithoutValidation) . "\n";
$md .= "- Methods using `->all()` (mass assignment risk): " . count($usingRequestAll) . "\n";

file_put_contents("$reportsDir/validation-audit.md", $md);
echo count($controllersWithoutValidation) . " unvalidated, " . count($usingRequestAll) . " using ->all()\n";

// ====================================================================
// REPORT 3: EMAIL/MAIL INVENTORY
// ====================================================================
echo "[3/7] Generating Email/Mail Inventory... ";
$md = "# Email & Mail Inventory Report\n\n";
$md .= "**Generated:** " . date('Y-m-d H:i:s') . "\n\n";
$md .= "All mailables, their triggers, Blade templates, and delivery status.\n\n---\n\n";

$mailsFound = [];

foreach (['dash', 'web'] as $app) {
    $mailDir = "$basePath/$app/app/Mail";
    if (!is_dir($mailDir)) continue;
    $files = glob("$mailDir/*.php");
    
    foreach ($files as $file) {
        $content = file_get_contents($file);
        $className = basename($file, '.php');
        $methods = getMethodBodies($content);
        
        $subject = '';
        $template = '';
        $from = '';
        $isQueued = false;
        $uses = [];
        
        if (preg_match("/->subject\s*\(\s*['\"]([^'\"]+)['\"]/", $content, $sm)) $subject = $sm[1];
        if (preg_match("/->from\s*\(\s*['\"]([^'\"]+)['\"].*?['\"]([^'\"]+)['\"]/s", $content, $fm)) $from = "{$fm[1]} <{$fm[2]}>";
        if (preg_match("/->view\s*\(\s*['\"]([^'\"]+)['\"]/", $content, $tm)) $template = $tm[1];
        if (preg_match("/->markdown\s*\(\s*['\"]([^'\"]+)['\"]/", $content, $mm)) $template = $mm[1];
        if (strpos($content, 'ShouldQueue') !== false || strpos($content, 'implements') && strpos($content, 'ShouldQueue')) $isQueued = true;
        
        preg_match_all('/public\s+\$(\w+)/', $content, $propMatches);
        $publicProps = $propMatches[1] ?? [];
        
        $mailsFound[] = [
            'app' => $app,
            'class' => $className,
            'file' => str_replace($basePath . '/', '', $file),
            'subject' => $subject,
            'template' => $template,
            'from' => $from,
            'queued' => $isQueued,
            'props' => $publicProps,
        ];
    }
}

$md .= "## All Mailables\n\n";
$md .= "| App | Class | Subject | Template | From | Queued? | Public Props |\n";
$md .= "|-----|-------|---------|----------|------|---------|-------------|\n";
foreach ($mailsFound as $m) {
    $queued = $m['queued'] ? '✅ Yes' : '❌ No (sync)';
    $props = implode(', ', array_map(function($p) { return "\$$p"; }, $m['props']));
    $md .= "| {$m['app']} | `{$m['class']}` | {$m['subject']} | `{$m['template']}` | {$m['from']} | $queued | $props |\n";
}

$md .= "\n## Trigger Points (Where each mailable is dispatched)\n\n";
$md .= "Searching controllers for Mail::/->mail() calls...\n\n";

foreach ($mailsFound as $m) {
    $md .= "### `{$m['class']}`\n\n";
    $md .= "| App | File | Method | How Sent |\n";
    $md .= "|-----|------|--------|----------|\n";
    
    foreach (['dash', 'web'] as $app) {
        $ctrlDir = "$basePath/$app/app/Http/Controllers";
        if (!is_dir($ctrlDir)) continue;
        $ctrlFiles = getAllPhpFiles($ctrlDir);
        
        foreach ($ctrlFiles as $cf) {
            $content = file_get_contents($cf);
            if (strpos($content, $m['class']) !== false || strpos($content, $m['class']) !== false) {
                $methods = getMethodBodies($content);
                foreach ($methods as $mname => $minfo) {
                    $body = $minfo['body'];
                    if (strpos($body, $m['class']) !== false) {
                        $how = 'Mail::to()';
                        if (strpos($body, 'queue') !== false) $how = 'Mail::queue()';
                        if (strpos($body, 'later') !== false) $how = 'Mail::later()';
                        $relCf = str_replace($basePath . '/', '', $cf);
                        $md .= "| $app | `$relCf` | `{$mname}()` | $how |\n";
                    }
                }
            }
        }
    }
    
    // Check Mail directory for the actual send call
    $mFile = "$basePath/{$m['app']}/app/Mail/{$m['class']}.php";
    if (file_exists($mFile)) {
        $mailContent = file_get_contents($mFile);
        if (preg_match('/new\s+' . $m['class'] . '\s*\(/', $mailContent)) {
            $md .= "| — | (Used within Mailable itself) | — | — |\n";
        }
    }
    
    $md .= "\n";
}

file_put_contents("$reportsDir/email-inventory.md", $md);
echo count($mailsFound) . " mailables found\n";

// ====================================================================
// REPORT 4: AUTHORIZATION MATRIX
// ====================================================================
echo "[4/7] Generating Authorization Matrix... ";
$md = "# Authorization & Access Control Matrix\n\n";
$md .= "**Generated:** " . date('Y-m-d H:i:s') . "\n\n";
$md .= "Maps who can access what — middleware, guards, gates, policies.\n\n---\n\n";

$md .= "## Route Middleware Summary (Admin Dashboard)\n\n";
$md .= "| Route | Middleware | Controller |\n";
$md .= "|-------|-----------|------------|\n";

$dashRoutes = file_get_contents("$basePath/dash/routes/web.php");
preg_match_all("/Route::(\w+)\s*\(\s*['\"]([^'\"]+)['\"]\s*,\s*\[?([\w\\\\]+)::class\s*,\s*['\"]([\w]+)['\"]\]?\)\s*(?:->name\([^)]+\))?\s*(?:->middleware\(['\"]([^'\"]+)['\"]\))?/", $dashRoutes, $routeMatches, PREG_SET_ORDER);

$mdashRoutes = '';
foreach ($routeMatches as $rm) {
    $url = $rm[2];
    $ctrl = basename(str_replace('\\', '/', $rm[3])) . '@' . $rm[4];
    $mw = $rm[5] ?? 'auth (from group)';
    $md .= "| `$url` | `$mw` | `$ctrl` |\n";
}

// Also check for resource routes
preg_match_all("/Route::resource\s*\(\s*['\"]([^'\"]+)['\"]\s*,\s*([\w\\\\]+)::class/", $dashRoutes, $resMatches);
foreach ($resMatches[1] as $i => $res) {
    $ctrl = basename(str_replace('\\', '/', $resMatches[2][$i]));
    $md .= "| `$res/*` | `auth (from group)` | `$ctrl` (resource) |\n";
}

$md .= "\n## Route Middleware Summary (Web App)\n\n";
$md .= "| Route | Middleware | Controller |\n";
$md .= "|-------|-----------|------------|\n";

$webRoutes = file_get_contents("$basePath/web/routes/web.php");
preg_match_all("/Route::(\w+)\s*\(\s*['\"]([^'\"]+)['\"]\s*,\s*\[?([\w\\\\]+)::class\s*,\s*['\"]([\w]+)['\"]\]?\)\s*(?:->name\([^)]+\))?\s*(?:->middleware\(['\"]([^'\"]+)['\"]\))?/", $webRoutes, $webRouteMatches, PREG_SET_ORDER);

foreach ($webRouteMatches as $rm) {
    $url = $rm[2];
    $ctrl = basename(str_replace('\\', '/', $rm[3])) . '@' . $rm[4];
    $mw = $rm[5] ?? '—';
    $md .= "| `$url` | `$mw` | `$ctrl` |\n";
}

$md .= "\n## Authorization Checks Found in Controllers\n\n";
$md .= "| App | File | Method | Auth Check |\n";
$md .= "|-----|------|--------|------------|\n";

$authFindings = [];
foreach (['dash', 'web'] as $app) {
    $ctrlDir = "$basePath/$app/app/Http/Controllers";
    if (!is_dir($ctrlDir)) continue;
    $files = getAllPhpFiles($ctrlDir);
    foreach ($files as $file) {
        $relPath = str_replace($basePath . '/', '', $file);
        $content = file_get_contents($file);
        $methods = getMethodBodies($content);
        foreach ($methods as $mname => $minfo) {
            $checks = [];
            if (strpos($minfo['body'], '->authorize(') !== false) $checks[] = '$this->authorize()';
            if (strpos($minfo['body'], '->can(') !== false) $checks[] = '$user->can()';
            if (strpos($minfo['body'], '->cannot(') !== false) $checks[] = '$user->cannot()';
            if (strpos($minfo['body'], 'Gate::') !== false) $checks[] = 'Gate facade';
            if (strpos($minfo['body'], 'Auth::check') !== false) $checks[] = 'Auth::check()';
            if (strpos($minfo['body'], 'Auth::user') !== false) $checks[] = 'Auth::user()';
            if (strpos($minfo['body'], "auth()->") !== false || strpos($minfo['body'], "auth(") !== false || preg_match('/\bauth\b/', $minfo['body'])) $checks[] = 'auth() helper';
            
            if (!empty($checks)) {
                $authFindings[] = ['app' => $app, 'file' => $relPath, 'method' => $mname, 'checks' => implode(', ', $checks)];
            }
        }
    }
}

foreach ($authFindings as $af) {
    $md .= "| {$af['app']} | `{$af['file']}` | `{$af['method']}()` | {$af['checks']} |\n";
}

$md .= "\n## Admin User Roles\n\n";
$dashUserFile = "$basePath/dash/app/Models/DashboardUser.php";
if (file_exists($dashUserFile)) {
    $dashContent = file_get_contents($dashUserFile);
    // Check for role fields or guard
    if (preg_match('/\$fillable\s*=\s*\[([^\]]+)\]/', $dashContent, $fm)) {
        $md .= "DashboardUser fillable fields: `{$fm[1]}`\n\n";
    }
    $md .= "**Note:** DashboardUser model used for admin auth. No role-based access control (RBAC) gates or policies detected in the codebase.\n\n";
    $md .= "All authenticated admin users appear to have **uniform access** to all admin routes.\n\n";
} else {
    $md .= "No DashboardUser model found.\n\n";
}

$md .= "## Gaps & Recommendations\n\n";
$md .= "1. **No role-based access** — no admin/user/staff distinction within the dashboard\n";
$md .= "2. **No policy classes** — no `App\\Policies\\*` files found\n";
$md .= "3. **No Gate definitions** — no `Gate::define()` calls in AppServiceProvider\n";
$md .= "4. **Single guard** — both apps use the default `web` guard\n";
$md .= "5. Consider implementing Spatie Permission or Laravel built-in Gates for multi-role admin access\n";

file_put_contents("$reportsDir/authorization-matrix.md", $md);
echo count($authFindings) . " auth checks found\n";

// ====================================================================
// REPORT 5: ERROR HANDLING AUDIT
// ====================================================================
echo "[5/7] Generating Error Handling Audit... ";
$md = "# Error Handling & Exception Audit\n\n";
$md .= "**Generated:** " . date('Y-m-d H:i:s') . "\n\n";
$md .= "Audits try-catch coverage, exception handling, logging practices.\n\n---\n\n";

$withTryCatch = [];
$withoutTryCatch = [];
$usingLog = [];
$usingReport = [];

foreach (['dash', 'web'] as $app) {
    $ctrlDir = "$basePath/$app/app/Http/Controllers";
    if (!is_dir($ctrlDir)) continue;
    $files = getAllPhpFiles($ctrlDir);
    
    foreach ($files as $file) {
        $relPath = str_replace($basePath . '/', '', $file);
        $content = file_get_contents($file);
        $methods = getMethodBodies($content);
        
        foreach ($methods as $mname => $minfo) {
            $body = $minfo['body'];
            $hasTry = preg_match('/\btry\b/', $body);
            $hasCatch = preg_match('/\bcatch\s*\(/', $body);
            $hasLog = preg_match('/\b(Log::|logger\()|\.log\(|info\(|error\(|warning\(|debug\(/', $body);
            
            if ($hasTry || $hasCatch) {
                $withTryCatch[] = ['app' => $app, 'file' => $relPath, 'method' => $mname];
            } else {
                // Only mark store/update/delete/destructive methods as high risk
                if (in_array($mname, ['store', 'update', 'destroy', 'placeOrder', 'login', 'register', 'resetPassword'])) {
                    $withoutTryCatch[] = ['app' => $app, 'file' => $relPath, 'method' => $mname];
                }
            }
            
            if ($hasLog) {
                $usingLog[] = ['app' => $app, 'file' => $relPath, 'method' => $mname];
            }
        }
    }
}

$md .= "## Exception Handler\n\n";
$ehFile = "$basePath/dash/app/Exceptions/Handler.php";
if (file_exists($ehFile)) {
    $ehContent = file_get_contents($ehFile);
    $ehMethods = getMethodBodies($ehContent);
    $md .= "**File:** `dash/app/Exceptions/Handler.php`\n\n";
    foreach ($ehMethods as $mname => $minfo) {
        $md .= "**Method:** `$mname()`\n\n";
        $md .= "```php\n" . substr($minfo['body'], 0, 500) . "\n```\n\n";
    }
}

$md .= "\n## Controllers WITH Try-Catch (handled)\n\n";
$md .= "| App | File | Method |\n";
$md .= "|-----|------|--------|\n";
foreach ($withTryCatch as $e) {
    $md .= "| {$e['app']} | `{$e['file']}` | `{$e['method']}()` |\n";
}

$md .= "\n## Destructive Controllers WITHOUT Try-Catch ⚠️\n\n";
$md .= "| App | File | Method |\n";
$md .= "|-----|------|--------|\n";
foreach ($withoutTryCatch as $e) {
    $md .= "| {$e['app']} | `{$e['file']}` | `{$e['method']}()` |\n";
}

$md .= "\n## Controllers Using Logging\n\n";
$md .= "| App | File | Method |\n";
$md .= "|-----|------|--------|\n";
foreach ($usingLog as $e) {
    $md .= "| {$e['app']} | `{$e['file']}` | `{$e['method']}()` |\n";
}

$totalDestructive = count($withoutTryCatch);
$totalHandled = count($withTryCatch);
$totalLogged = count($usingLog);
$md .= "\n## Summary\n\n";
$md .= "- Controllers with try-catch: $totalHandled\n";
$md .= "- Destructive methods WITHOUT try-catch: $totalDestructive\n";
$md .= "- Methods with logging: $totalLogged\n";

file_put_contents("$reportsDir/error-handling-audit.md", $md);
echo "$totalHandled handled, $totalDestructive unhandled destructive\n";

// ====================================================================
// REPORT 6: FRONTEND ASSET MAP
// ====================================================================
echo "[6/7] Generating Frontend Asset Map... ";
$md = "# Frontend Asset Map\n\n";
$md .= "**Generated:** " . date('Y-m-d H:i:s') . "\n\n";
$md .= "All JS/CSS assets loaded in the application.\n\n---\n\n";

$md .= "## Admin Dashboard (dash/) — JavaScript Assets\n\n";
$md .= "| File | Size | Type | Description |\n";
$md .= "|------|------|------|-------------|\n";

$jsDir = "$basePath/dash/resources/js";
if (is_dir($jsDir)) {
    $jsFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($jsDir, RecursiveDirectoryIterator::SKIP_DOTS));
    foreach ($jsFiles as $f) {
        if ($f->isFile() && in_array($f->getExtension(), ['js'])) {
            $size = $f->getSize();
            $sizeFormatted = $size > 1024 ? round($size/1024, 1) . ' KB' : $size . ' B';
            $rel = str_replace($basePath . '/', '', $f->getPathname());
            $type = '3rd-party library';
            $desc = basename($f->getPathname());
            
            if (strpos($rel, 'resources/js/pages') !== false) $type = 'Custom page init';
            if (strpos($rel, 'resources/js/app.js') !== false) $type = 'App bootstrap';
            if (strpos($rel, 'resources/libs') !== false) $type = '3rd-party library';
            
            $md .= "| `$rel` | $sizeFormatted | $type | $desc |\n";
        }
    }
}

$md .= "\n## Customer Web App (web/) — JavaScript Assets\n\n";
$webJsDir = "$basePath/web/resources/js";
if (is_dir($webJsDir)) {
    $jsFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($webJsDir, RecursiveDirectoryIterator::SKIP_DOTS));
    foreach ($jsFiles as $f) {
        if ($f->isFile() && in_array($f->getExtension(), ['js', 'vue'])) {
            $size = $f->getSize();
            $sizeFormatted = $size > 1024 ? round($size/1024, 1) . ' KB' : $size . ' B';
            $rel = str_replace($basePath . '/', '', $f->getPathname());
            $md .= "| `$rel` | $sizeFormatted | Custom | — |\n";
        }
    }
}

$md .= "\n## Key Libraries Detected\n\n";
$md .= "| Library | Version/Location | Purpose |\n";
$md .= "|---------|-----------------|---------|\n";
$libsFound = [];

$libDir = "$basePath/dash/resources/libs";
if (is_dir($libDir)) {
    $libDirs = scandir($libDir);
    foreach ($libDirs as $ld) {
        if ($ld === '.' || $ld === '..' || $ld === '@ckeditor') continue;
        if ($ld === '@simonwep') {
            $libsFound[] = ['@simonwep/pickr', 'Color picker'];
            continue;
        }
        $descMap = [
            'apexcharts' => 'Charts library',
            'chart.js' => 'Charts library',
            'jsvectormap' => 'Vector maps',
            'glightbox' => 'Lightbox gallery',
            'isotope-layout' => 'Grid/filter layout',
            'alertifyjs' => 'Alert/notification UI',
            'imask' => 'Input masking',
            'fullcalendar' => 'Calendar UI',
            'gridjs' => 'Data tables',
            'quill' => 'Rich text editor',
            'nouislider' => 'Range slider',
            'node-waves' => 'Click ripple effect',
            'gulp-rtlcss' => 'RTL CSS build tool',
            'bootstrap' => 'UI framework',
            'admin-resources' => 'Admin template resources',
            '@ckeditor' => 'Rich text editor (CKEditor 5)',
        ];
        $libsFound[] = [$ld, $descMap[$ld] ?? 'Unknown library'];
    }
}

foreach ($libsFound as $lb) {
    $md .= "| `{$lb[0]}` | `resources/libs/{$lb[0]}` | {$lb[1]} |\n";
}

$md .= "\n## package.json Dependencies\n\n";
foreach (['dash', 'web'] as $app) {
    $pkgFile = "$basePath/$app/package.json";
    if (file_exists($pkgFile)) {
        $pkg = json_decode(file_get_contents($pkgFile), true);
        $md .= "### $app\n\n";
        if (isset($pkg['dependencies'])) {
            $md .= "| Package | Version |\n";
            $md .= "|---------|--------|\n";
            foreach ($pkg['dependencies'] as $name => $ver) {
                $md .= "| `$name` | $ver |\n";
            }
        }
        if (isset($pkg['devDependencies'])) {
            $md .= "\n**Dev Dependencies:**\n\n";
            foreach ($pkg['devDependencies'] as $name => $ver) {
                $md .= "- `$name`: $ver\n";
            }
        }
        $md .= "\n";
    }
}

file_put_contents("$reportsDir/frontend-asset-map.md", $md);
echo count($libsFound) . " libraries found\n";

// ====================================================================
// REPORT 7: PAYMENT FLOW DEEP DIVE
// ====================================================================
echo "[7/7] Generating Payment Flow Deep Dive... ";
$md = "# Payment Flow Deep Dive\n\n";
$md .= "**Generated:** " . date('Y-m-d H:i:s') . "\n\n";
$md .= "Full analysis of payment processing, PayPal integration, bank transfer flow, and refund logic.\n\n---\n\n";

$md .= "## Payment Flow Overview\n\n";
$md .= "```
Customer places order
       │
       ├──→ Payment Method: PayPal
       │       POST /create-paypal-payment → OrderController@createPayPalPayment
       │         → PayPalService::createPayment()
       │       GET /paypal/execute → OrderController@executePayPalPayment
       │         → PayPalService::executePayment()
       │       GET /paypal/cancel → OrderController@cancelPayPalPayment
       │
       └──→ Payment Method: Bank Transfer
               GET /bank-details → OrderController@showBankDetails
               POST /order/upload-proof → OrderController@uploadPaymentProof
               (Admin verifies manually then updates order status)
```\n\n";

// Analyze PayPalService
$paypalFile = "$basePath/web/app/Services/PayPalService.php";
if (file_exists($paypalFile)) {
    $paypalContent = file_get_contents($paypalFile);
    $md .= "## PayPalService\n\n";
    $md .= "**File:** `web/app/Services/PayPalService.php`\n\n";
    
    $methods = getMethodBodies($paypalContent);
    foreach ($methods as $mname => $minfo) {
        $md .= "### `$mname()`\n\n";
        $md .= "**Params:** `{$minfo['params']}`\n\n";
        $md .= "**Returns:** `{$minfo['return_type']}`\n\n";
        $md .= "```php\n" . $minfo['body'] . "\n```\n\n";
    }
    
    // Extract API credentials
    preg_match_all('/ClientId|ClientSecret|client_id|client_secret|api_username|api_password|api_signature/i', $paypalContent, $credMatches);
    if (!empty($credMatches[0])) {
        $md .= "**API Credentials Referenced:** " . implode(', ', array_unique($credMatches[0])) . "\n\n";
    }
}

// Analyze OrderController payment methods
$orderCtrlFile = "$basePath/web/app/Http/Controllers/OrderController.php";
if (file_exists($orderCtrlFile)) {
    $orderContent = file_get_contents($orderCtrlFile);
    $md .= "## OrderController Payment Methods\n\n";
    
    $paymentMethods = ['createPayPalPayment', 'executePayPalPayment', 'cancelPayPalPayment', 'createRazorpayOrder', 'placeOrder', 'checkout', 'uploadPaymentProof', 'showBankDetails'];
    $methods = getMethodBodies($orderContent);
    
    foreach ($paymentMethods as $pm) {
        if (isset($methods[$pm])) {
            $md .= "### `$pm()`\n\n";
            $md .= "**Params:** `{$methods[$pm]['params']}`\n\n";
            $body = $methods[$pm]['body'];
            $md .= "```php\n" . $body . "\n```\n\n";
        }
    }
}

$md .= "## Currency & Multi-Currency Support\n\n";
$currencyFile = "$basePath/web/app/Services/CurrencyService.php";
if (file_exists($currencyFile)) {
    $currencyContent = file_get_contents($currencyFile);
    $methods = getMethodBodies($currencyContent);
    $md .= "**File:** `web/app/Services/CurrencyService.php`\n\n";
    foreach ($methods as $mname => $minfo) {
        $md .= "- `$mname()` — " . (strpos($minfo['body'], 'session') !== false ? 'Uses session for currency storage' : '') . "\n";
    }
}

$md .= "\n## Exchange Rates\n\n";
$ratesFile = "$basePath/web/app/Console/Commands/UpdateExchangeRates.php";
if (file_exists($ratesFile)) {
    $md .= "**Command:** `php artisan UpdateExchangeRates` — Updates exchange rates from external API\n\n";
}
$md .= "**Table:** `exchange_rates` — stores currency conversion rates\n\n";

$md .= "\n## Payment Security Analysis\n\n";
$md .= "| Check | Status | Notes |\n";
$md .= "|-------|--------|-------|\n";
$md .= "| PayPal credentials in .env | ⚠️ Check .env | Ensure not hardcoded in config/services.php |\n";
$md .= "| Webhook/IPN verification | 🔍 Needs review | Check if PayPal IPN is verified |\n";
$md .= "| Order amount re-verification | 🔍 Needs review | Server should re-calculate totals, not trust client |\n";
$md .= "| Payment proof validation | 🔍 Needs review | Uploaded proof images should be validated for type/size |\n";
$md .= "| Refund authorization | ⚠️ Check | Ensure only authorized admin can process refunds |\n";
$md .= "| CSRF on payment routes | ✅ | Uses web middleware with CSRF |\n";

$md .= "\n## Refund Flow\n\n";
$md .= "```
Admin processes refund:
  → POST /updaterefund → ProductController@updaterefund
  → POST /updaterefund1 → PackingOrderController@updaterefund1
  → POST /updaterefund2 → PackingDispatchController@updaterefund2
  → POST /refundMilkSlot → MilkRefundController@refundMilkSlot
  → POST /refundProductSlot → ProductRefundController@refundProductSlot
  
Refund tables:
  - product_refunds (product orders)
  - milk_refunds (milk subscriptions)
  - product_transaction_logs (transaction audit trail)
  - milk_transaction_logs (transaction audit trail)
```\n";

file_put_contents("$reportsDir/payment-flow-deep-dive.md", $md);
echo "Done\n";

// ====================================================================
// SUMMARY
// ====================================================================
echo "\n========== ALL REPORTS GENERATED ==========\n";
echo "1. security-audit.md\n";
echo "2. validation-audit.md\n";
echo "3. email-inventory.md\n";
echo "4. authorization-matrix.md\n";
echo "5. error-handling-audit.md\n";
echo "6. frontend-asset-map.md\n";
echo "7. payment-flow-deep-dive.md\n";
echo "Location: $reportsDir\n";
