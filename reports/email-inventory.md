# Email & Mail Inventory Report

**Generated:** 2026-07-27 15:06:21

All mailables, their triggers, Blade templates, and delivery status.

---

## All Mailables

| App | Class | Subject | Template | From | Queued? | Public Props |
|-----|-------|---------|----------|------|---------|-------------|
| dash | `BulkOrderApproved` | Approval: Your Bulk Order Request # | `emails.bulk_order_approved` |  | ✅ Yes | $bulkOrder |
| dash | `BulkOrderRejected` | Update: Your Bulk Order Request # | `emails.bulk_order_rejected` |  | ✅ Yes | $bulkOrder |
| dash | `OrderStatusUpdated` | Order Status Update | `emails.order_status_updated` |  | ❌ No (sync) | $order, $status |
| web | `AdminOrderNotification` |  | `` |  | ❌ No (sync) | $order, $user, $orderDetails, $currencySymbol, $exchangeRate |
| web | `BulkOrderInquiryMail` |  | `` |  | ✅ Yes | $data, $isAdmin |
| web | `BulkOrderUserMail` |  | `` |  | ❌ No (sync) | $data |
| web | `ContactFormNotification` |  | `` |  | ✅ Yes | $contactMessage |
| web | `ForgotPasswordOTP` |  | `` |  | ❌ No (sync) | $user, $otp |
| web | `OrderSuccess` |  | `` |  | ❌ No (sync) | $order, $user, $orderDetails, $currencySymbol, $exchangeRate |
| web | `RegistrationSuccess` |  | `` |  | ❌ No (sync) | $user |

## Trigger Points (Where each mailable is dispatched)

Searching controllers for Mail::/->mail() calls...

### `BulkOrderApproved`

| App | File | Method | How Sent |
|-----|------|--------|----------|
| dash | `dash/app/Http/Controllers\BulkOrderController.php` | `updateStatus()` | Mail::to() |

### `BulkOrderRejected`

| App | File | Method | How Sent |
|-----|------|--------|----------|
| dash | `dash/app/Http/Controllers\BulkOrderController.php` | `updateStatus()` | Mail::to() |

### `OrderStatusUpdated`

| App | File | Method | How Sent |
|-----|------|--------|----------|
| dash | `dash/app/Http/Controllers\PackingDeliveryController.php` | `updatedelive()` | Mail::to() |
| dash | `dash/app/Http/Controllers\PackingDispatchController.php` | `updatedispach()` | Mail::to() |
| dash | `dash/app/Http/Controllers\PackingOrderController.php` | `updatepacking()` | Mail::to() |
| dash | `dash/app/Http/Controllers\ProductController.php` | `upadetstatus()` | Mail::to() |

### `AdminOrderNotification`

| App | File | Method | How Sent |
|-----|------|--------|----------|
| web | `web/app/Http/Controllers\OrderController.php` | `processRazorpayOrder()` | Mail::to() |
| web | `web/app/Http/Controllers\OrderController.php` | `processPayPalOrder()` | Mail::to() |
| web | `web/app/Http/Controllers\OrderController.php` | `processDirectOrder()` | Mail::to() |
| web | `web/app/Http/Controllers\PayPalOrderProcessor.php` | `processPayPalOrder()` | Mail::to() |

### `BulkOrderInquiryMail`

| App | File | Method | How Sent |
|-----|------|--------|----------|
| web | `web/app/Http/Controllers\BulkOrderController.php` | `store()` | Mail::to() |

### `BulkOrderUserMail`

| App | File | Method | How Sent |
|-----|------|--------|----------|
| web | `web/app/Http/Controllers\BulkOrderController.php` | `store()` | Mail::to() |

### `ContactFormNotification`

| App | File | Method | How Sent |
|-----|------|--------|----------|
| web | `web/app/Http/Controllers\ContactController.php` | `store()` | Mail::later() |

### `ForgotPasswordOTP`

| App | File | Method | How Sent |
|-----|------|--------|----------|
| web | `web/app/Http/Controllers\AuthController.php` | `sendOTP()` | Mail::to() |

### `OrderSuccess`

| App | File | Method | How Sent |
|-----|------|--------|----------|
| dash | `dash/app/Http/Controllers\ProductController.php` | `update()` | Mail::to() |
| web | `web/app/Http/Controllers\OrderController.php` | `processRazorpayOrder()` | Mail::to() |
| web | `web/app/Http/Controllers\OrderController.php` | `processPayPalOrder()` | Mail::to() |
| web | `web/app/Http/Controllers\OrderController.php` | `processDirectOrder()` | Mail::to() |
| web | `web/app/Http/Controllers\PayPalOrderProcessor.php` | `processPayPalOrder()` | Mail::to() |

### `RegistrationSuccess`

| App | File | Method | How Sent |
|-----|------|--------|----------|
| web | `web/app/Http/Controllers\AuthController.php` | `register()` | Mail::to() |

