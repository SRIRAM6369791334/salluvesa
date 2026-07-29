# Security Audit Report

**Generated:** 2026-07-27 15:06:21

Scans for: mass assignment, hardcoded secrets, SQL injection, XSS, CSRF, file upload risks, debug mode

---

## 🔴 Critical Severity

- dash/app\Http\Controllers\BankDetailController.php :: store() — Uses `->all()` (mass assignment risk). Use `->validated()` or `->only()` instead.
- dash/app\Http\Controllers\BankDetailController.php :: update() — Uses `->all()` (mass assignment risk). Use `->validated()` or `->only()` instead.
- dash/app\Http\Controllers\DashboardUserController.php — Possible hardcoded secret: `'password' => "required"`
- dash/app\Http\Controllers\DeliveryPersonController.php — Possible hardcoded secret: `"password" => "required"`
- dash/app\Http\Controllers\SamplesController.php :: store() — Uses `->all()` (mass assignment risk). Use `->validated()` or `->only()` instead.
- dash/app\Http\Controllers\SamplesController.php :: update() — Uses `->all()` (mass assignment risk). Use `->validated()` or `->only()` instead.
- dash/app\Http\Controllers\UserController.php — Possible hardcoded secret: `"password" => "required"`
- web/app\Http\Controllers\AccountController.php — Possible hardcoded secret: `'password' => 'required|string|min:8|confirmed'`
- web/app\Http\Controllers\AuthController.php :: register() — Uses `->all()` (mass assignment risk). Use `->validated()` or `->only()` instead.
- web/app\Http\Controllers\AuthController.php — Possible hardcoded secret: `'password' => 'required|string|min:8|confirmed'`
- web/app\Http\Controllers\CartController.php :: addToCart() — Uses `->all()` (mass assignment risk). Use `->validated()` or `->only()` instead.
- web/app\Http\Controllers\OrderController.php :: getDetails() — Uses `->all()` (mass assignment risk). Use `->validated()` or `->only()` instead.
- web/app\Http\Controllers\UserAddressController.php :: store() — Uses `->all()` (mass assignment risk). Use `->validated()` or `->only()` instead.
- web/app\Http\Controllers\UserAddressController.php :: update() — Uses `->all()` (mass assignment risk). Use `->validated()` or `->only()` instead.
- web/app\Models\User.php — Possible hardcoded secret: `'password' => 'hashed'`

---

## 🟠 High Severity

- dash/app\Http\Controllers\HomeController.php — Uses raw SQL queries via DB::select/statement. Risk of SQL injection if not parameterized.
- dash/app\Http\Controllers\ProductThumController.php :: update() — File upload without validation checks (isValid/extension/mimes).
- dash/app\Http\Controllers\ProductVarientControllet.php :: addproductvarient() — File upload without validation checks (isValid/extension/mimes).
- dash/app\Http\Controllers\ProductVarientControllet.php :: update() — File upload without validation checks (isValid/extension/mimes).

---

## Summary

- **Total findings:** 19
- **🔴 Critical:** 15
- **🟠 High:** 4
- **🟡 Medium:** 0
- **🟢 Low:** 0
