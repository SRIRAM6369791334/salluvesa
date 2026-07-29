# Error Handling & Exception Audit

**Generated:** 2026-07-27 15:06:21

Audits try-catch coverage, exception handling, logging practices.

---

## Exception Handler

**File:** `dash/app/Exceptions/Handler.php`

**Method:** `register()`

```php
{
        $this->reportable(function (Throwable $e) {
            //
        });
    }
```


## Controllers WITH Try-Catch (handled)

| App | File | Method |
|-----|------|--------|
| dash | `dash/app/Http/Controllers\BulkOrderController.php` | `updateStatus()` |
| dash | `dash/app/Http/Controllers\CurrencyController.php` | `index()` |
| dash | `dash/app/Http/Controllers\CurrencyController.php` | `convert()` |
| dash | `dash/app/Http/Controllers\CustomProductController.php` | `update()` |
| dash | `dash/app/Http/Controllers\OrderController.php` | `showInvoice()` |
| dash | `dash/app/Http/Controllers\PackingDeliveryController.php` | `updatedelive()` |
| dash | `dash/app/Http/Controllers\PackingDeliveryController.php` | `collectdelive()` |
| dash | `dash/app/Http/Controllers\PackingDispatchController.php` | `updatedispach()` |
| dash | `dash/app/Http/Controllers\PackingOrderController.php` | `updatepacking()` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `exportCommercialInvoice()` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `exportPackingList()` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `upadetstatus()` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `fetchTotalOrders()` |
| dash | `dash/app/Http/Controllers\ProductVarientControllet.php` | `destroy()` |
| web | `web/app/Http/Controllers\AuthController.php` | `register()` |
| web | `web/app/Http/Controllers\AuthController.php` | `sendOTP()` |
| web | `web/app/Http/Controllers\BulkOrderController.php` | `store()` |
| web | `web/app/Http/Controllers\ContactController.php` | `store()` |
| web | `web/app/Http/Controllers\CurrencyController.php` | `index()` |
| web | `web/app/Http/Controllers\CurrencyController.php` | `convert()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `store()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `saveOrganizedImage()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `saveBase64Image()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `uploadUserImage()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `uploadExport()` |
| web | `web/app/Http/Controllers\OrderController.php` | `processRazorpayOrder()` |
| web | `web/app/Http/Controllers\OrderController.php` | `captureDesignSnapshot()` |
| web | `web/app/Http/Controllers\OrderController.php` | `processPayPalOrder()` |
| web | `web/app/Http/Controllers\OrderController.php` | `processDirectOrder()` |
| web | `web/app/Http/Controllers\OrderController.php` | `createRazorpayOrder()` |
| web | `web/app/Http/Controllers\OrderController.php` | `getDetails()` |
| web | `web/app/Http/Controllers\OrderController.php` | `createPayPalPayment()` |
| web | `web/app/Http/Controllers\OrderController.php` | `uploadPaymentProof()` |
| web | `web/app/Http/Controllers\PayPalOrderProcessor.php` | `processPayPalOrder()` |

## Destructive Controllers WITHOUT Try-Catch ⚠️

| App | File | Method |
|-----|------|--------|
| dash | `dash/app/Http/Controllers\AppSettingsController.php` | `update()` |
| dash | `dash/app/Http/Controllers\AreaController.php` | `store()` |
| dash | `dash/app/Http/Controllers\AreaController.php` | `update()` |
| dash | `dash/app/Http/Controllers\AreaController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\BankDetailController.php` | `store()` |
| dash | `dash/app/Http/Controllers\BankDetailController.php` | `update()` |
| dash | `dash/app/Http/Controllers\BankDetailController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\BannerImagesController.php` | `store()` |
| dash | `dash/app/Http/Controllers\BannerImagesController.php` | `update()` |
| dash | `dash/app/Http/Controllers\BannerImagesController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\CategoryController.php` | `store()` |
| dash | `dash/app/Http/Controllers\CategoryController.php` | `update()` |
| dash | `dash/app/Http/Controllers\CategoryController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\CompoStockController.php` | `update()` |
| dash | `dash/app/Http/Controllers\CouponController.php` | `update()` |
| dash | `dash/app/Http/Controllers\CouponController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\CustomProductController.php` | `store()` |
| dash | `dash/app/Http/Controllers\CustomProductController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\DashboardUserController.php` | `update()` |
| dash | `dash/app/Http/Controllers\DashboardUserController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\DeliveryPersonController.php` | `store()` |
| dash | `dash/app/Http/Controllers\DeliveryPersonController.php` | `update()` |
| dash | `dash/app/Http/Controllers\DeliveryPersonController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\DesignsController.php` | `store()` |
| dash | `dash/app/Http/Controllers\DesignsController.php` | `update()` |
| dash | `dash/app/Http/Controllers\DesignsController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\IndexContrller.php` | `store()` |
| dash | `dash/app/Http/Controllers\IndexContrller.php` | `update()` |
| dash | `dash/app/Http/Controllers\IndexContrller.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\NotificationController.php` | `update()` |
| dash | `dash/app/Http/Controllers\NotificationController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\OfferImageController.php` | `update()` |
| dash | `dash/app/Http/Controllers\OfferImageController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `store()` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `update()` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `store()` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `update()` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\ProductReturnController.php` | `update()` |
| dash | `dash/app/Http/Controllers\ProductThumController.php` | `update()` |
| dash | `dash/app/Http/Controllers\ProductThumController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\ProductVarientControllet.php` | `update()` |
| dash | `dash/app/Http/Controllers\SamplesController.php` | `store()` |
| dash | `dash/app/Http/Controllers\SamplesController.php` | `update()` |
| dash | `dash/app/Http/Controllers\SamplesController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\StockController.php` | `update()` |
| dash | `dash/app/Http/Controllers\SubCategoryController.php` | `store()` |
| dash | `dash/app/Http/Controllers\SubCategoryController.php` | `update()` |
| dash | `dash/app/Http/Controllers\SubCategoryController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\TodayDealsController.php` | `store()` |
| dash | `dash/app/Http/Controllers\TodayDealsController.php` | `update()` |
| dash | `dash/app/Http/Controllers\TodayDealsController.php` | `destroy()` |
| dash | `dash/app/Http/Controllers\UserController.php` | `store()` |
| dash | `dash/app/Http/Controllers\UserController.php` | `update()` |
| dash | `dash/app/Http/Controllers\UserController.php` | `destroy()` |
| web | `web/app/Http/Controllers\AuthController.php` | `login()` |
| web | `web/app/Http/Controllers\AuthController.php` | `resetPassword()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `update()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `destroy()` |
| web | `web/app/Http/Controllers\OrderController.php` | `placeOrder()` |
| web | `web/app/Http/Controllers\UserAddressController.php` | `store()` |
| web | `web/app/Http/Controllers\UserAddressController.php` | `update()` |
| web | `web/app/Http/Controllers\UserAddressController.php` | `destroy()` |

## Controllers Using Logging

| App | File | Method |
|-----|------|--------|
| dash | `dash/app/Http/Controllers\BulkOrderController.php` | `updateStatus()` |
| dash | `dash/app/Http/Controllers\OrderAssetsController.php` | `downloadZip()` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `exportCommercialInvoice()` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `exportPackingList()` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `fetchTotalOrders()` |
| dash | `dash/app/Http/Controllers\ProductVarientControllet.php` | `destroy()` |
| web | `web/app/Http/Controllers\AuthController.php` | `register()` |
| web | `web/app/Http/Controllers\AuthController.php` | `sendOTP()` |
| web | `web/app/Http/Controllers\BulkOrderController.php` | `store()` |
| web | `web/app/Http/Controllers\CartController.php` | `addToCart()` |
| web | `web/app/Http/Controllers\ContactController.php` | `store()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `store()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `saveOrganizedImage()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `saveBase64Image()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `uploadUserImage()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `uploadExport()` |
| web | `web/app/Http/Controllers\OrderAssetsController.php` | `downloadZip()` |
| web | `web/app/Http/Controllers\OrderController.php` | `placeOrder()` |
| web | `web/app/Http/Controllers\OrderController.php` | `processRazorpayOrder()` |
| web | `web/app/Http/Controllers\OrderController.php` | `captureDesignSnapshot()` |
| web | `web/app/Http/Controllers\OrderController.php` | `processPayPalOrder()` |
| web | `web/app/Http/Controllers\OrderController.php` | `processDirectOrder()` |
| web | `web/app/Http/Controllers\OrderController.php` | `createOrderFullDetail()` |
| web | `web/app/Http/Controllers\OrderController.php` | `createPayPalPayment()` |
| web | `web/app/Http/Controllers\OrderController.php` | `uploadPaymentProof()` |
| web | `web/app/Http/Controllers\PayPalOrderProcessor.php` | `processPayPalOrder()` |

## Summary

- Controllers with try-catch: 34
- Destructive methods WITHOUT try-catch: 64
- Methods with logging: 26
