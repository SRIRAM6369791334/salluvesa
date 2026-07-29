# Authorization & Access Control Matrix

**Generated:** 2026-07-27 15:06:21

Maps who can access what — middleware, guards, gates, policies.

---

## Route Middleware Summary (Admin Dashboard)

| Route | Middleware | Controller |
|-------|-----------|------------|
| `/` | `auth` | `HomeController@root` |
| `/logout` | `auth (from group)` | `LoginController@logout` |
| `customers/{customerId}` | `auth (from group)` | `UserController@edit` |
| `updateUser/{userId}` | `auth (from group)` | `UserController@update` |
| `destroyUser/{userId}` | `auth (from group)` | `UserController@destroy` |
| `getProductsOptions` | `auth (from group)` | `UserController@getProductsOptions` |
| `getProductsverentOptions` | `auth (from group)` | `UserController@getProductsverentOptions` |
| `getProductsverentqty` | `auth (from group)` | `UserController@getProductsverentqty` |
| `getcustomersummery` | `auth (from group)` | `UserController@getcustomersummery` |
| `addaddressvalue` | `auth (from group)` | `UserController@addaddressvalue` |
| `Getcitys/{custid}` | `auth (from group)` | `UserController@Getcity` |
| `/get-address-details` | `auth (from group)` | `UserController@getAddressDetails` |
| `/get-address-details1` | `auth (from group)` | `UserController@getAddressDetails1` |
| `updateDeliveryPerson/{id}` | `auth (from group)` | `DeliveryPersonController@update` |
| `destroyDeliveryPerson/{id}` | `auth (from group)` | `DeliveryPersonController@destroy` |
| `updateCategories/{id}` | `auth (from group)` | `CategoryController@update` |
| `destroyCategories/{id}` | `auth (from group)` | `CategoryController@destroy` |
| `validateCategoryName` | `auth (from group)` | `CategoryController@validateCategoryName` |
| `updateSubCategories/{id}` | `auth (from group)` | `SubCategoryController@update` |
| `destroySubCategories/{id}` | `auth (from group)` | `SubCategoryController@destroy` |
| `validateSubCategoryName` | `auth (from group)` | `SubCategoryController@validateSubCategoryName` |
| `updateProducts/{id}` | `auth (from group)` | `ProductController@update` |
| `destroyProducts/{id}` | `auth (from group)` | `ProductController@destroy` |
| `productImageUpload` | `auth (from group)` | `ProductController@productImageUpload` |
| `getProductDetail` | `auth (from group)` | `ProductController@getProductDetail` |
| `getproductfilter` | `auth (from group)` | `ProductController@getproductfilter` |
| `getsubcategory/{id}` | `auth (from group)` | `ProductController@Getsubproo` |
| `updateArea/{id}` | `auth (from group)` | `AreaController@update` |
| `destroyArea/{id}` | `auth (from group)` | `AreaController@destroy` |
| `assignDeliveryPerson` | `auth (from group)` | `AreaAssignController@assignDeliveryPerson` |
| `deleteDeliveryPerson` | `auth (from group)` | `AreaAssignController@deleteDeliveryPerson` |
| `fetchAreaDeliveryPartners/{areaId}` | `auth (from group)` | `AreaAssignController@fetchAreaDeliveryPartners` |
| `deleteAreaDeliveryPartners/{areaId}` | `auth (from group)` | `AreaAssignController@deleteAreaDeliveryPartners` |
| `checkAreaValidation` | `auth (from group)` | `AreaController@checkAreaValidation` |
| `getPincodeAreas` | `auth (from group)` | `AreaController@getPincodeAreas` |
| `destroyVarientThumpImages/{id}` | `auth (from group)` | `ProductController@destroyVarientThumpImages` |
| `/getthump/{productid}` | `auth (from group)` | `ProductController@getthump` |
| `updateBannerImages/{id}` | `auth (from group)` | `BannerImagesController@update` |
| `destroyBannerImages/{id}` | `auth (from group)` | `BannerImagesController@destroy` |
| `updateOrder` | `auth (from group)` | `BannerImagesController@updateOrder` |
| `bannerwebImages` | `auth (from group)` | `BannerImagesController@addbanner` |
| `updatewebBannerImages/{id}` | `auth (from group)` | `BannerImagesController@updateimage` |
| `destroywebBannerImages/{id}` | `auth (from group)` | `BannerImagesController@destroyweb` |
| `updateDesigns/{id}` | `auth (from group)` | `DesignsController@update` |
| `destroyDesigns/{id}` | `auth (from group)` | `DesignsController@destroy` |
| `updateSamples/{id}` | `auth (from group)` | `SamplesController@update` |
| `destroySamples/{id}` | `auth (from group)` | `SamplesController@destroy` |
| `getAreaAssignedDelvieryPerson/{areaId}` | `auth (from group)` | `MilkOrdersController@getAreaAssignedDelvieryPerson` |
| `milkOrderDeliveryAssign` | `auth (from group)` | `MilkOrdersController@milkOrderDeliveryAssign` |
| `milkOrders/{orderId}` | `auth (from group)` | `MilkSlotController@getMilkSlots` |
| `cancelMilkSlot` | `auth (from group)` | `MilkSlotController@cancelMilkSlot` |
| `createMilkSubscription` | `auth (from group)` | `ProductController@createMilkSubscription` |
| `createMilkSlot` | `auth (from group)` | `ProductController@createMilkSlot` |
| `createProductSubscription` | `auth (from group)` | `ProductController@createProductSubscription` |
| `createProductSlot` | `auth (from group)` | `ProductController@createProductSlot` |
| `productOrders/{orderId}` | `auth (from group)` | `ProductSlotController@getProductSlots` |
| `ordersummerys/{orderId}` | `auth (from group)` | `ProductSlotController@getProductSlotss` |
| `cancelProductSlot` | `auth (from group)` | `ProductSlotController@cancelProductSlot` |
| `productOrderDeliveryAssign` | `auth (from group)` | `ProductOrdersController@productOrderDeliveryAssign` |
| `viewProductInvoice/{orderId?}` | `auth (from group)` | `ProductController@viewProductInvoice` |
| `export/commercial-invoice` | `auth (from group)` | `ProductController@exportCommercialInvoice` |
| `export/packing-list` | `auth (from group)` | `ProductController@exportPackingList` |
| `export/order-products/{orderId?}` | `auth (from group)` | `ProductController@getOrderProductsForExport` |
| `export/save-form-data` | `auth (from group)` | `ProductController@saveExportFormData` |
| `export/get-form-data/{orderId?}` | `auth (from group)` | `ProductController@getExportFormData` |
| `viewProducts` | `auth (from group)` | `ProductOrdersController@index` |
| `viewProductdetail/{orderId?}` | `auth (from group)` | `ProductController@viewProductInvoice` |
| `updatestatus` | `auth (from group)` | `ProductController@upadetstatus` |
| `pickupstatus` | `auth (from group)` | `ProductController@pickupstatus` |
| `updaterefund` | `auth (from group)` | `ProductController@updaterefund` |
| `updatestatupacking` | `auth (from group)` | `PackingOrderController@updatepacking` |
| `updaterefund1` | `auth (from group)` | `PackingOrderController@updaterefund1` |
| `updatestatusdispatch` | `auth (from group)` | `PackingDispatchController@updatedispach` |
| `updaterefund2` | `auth (from group)` | `PackingDispatchController@updaterefund2` |
| `updatestatusdelivery` | `auth (from group)` | `PackingDeliveryController@updatedelive` |
| `collectstatusdelivery` | `auth (from group)` | `PackingDeliveryController@collectdelive` |
| `updatereturnpro` | `auth (from group)` | `ProductReturnController@update` |
| `collectreturn` | `auth (from group)` | `ProductReturnController@updateed` |
| `getoversummery` | `auth (from group)` | `OrderSummeryController@getoversummery` |
| `getMilkRefundDatas` | `auth (from group)` | `MilkRefundController@getRefundDatas` |
| `refundMilkSlot` | `auth (from group)` | `MilkRefundController@refundMilkSlot` |
| `getProductRefundDatas` | `auth (from group)` | `ProductRefundController@getRefundDatas` |
| `refundProductSlot` | `auth (from group)` | `ProductRefundController@refundProductSlot` |
| `cancelProductrequ` | `auth (from group)` | `CancelProductController@cancelProductrequ` |
| `incomeReports` | `auth (from group)` | `ReportsController@incomeReports` |
| `getIncomeReports` | `auth (from group)` | `ReportsController@getIncomeReports` |
| `updateStack` | `auth (from group)` | `StockController@update` |
| `reduceStock` | `auth (from group)` | `StockController@reduceStock` |
| `lowstock` | `auth (from group)` | `StockController@lowstock` |
| `updateStack` | `auth (from group)` | `StockController@update1` |
| `highselling` | `auth (from group)` | `StockController@highselling` |
| `updateStack1` | `auth (from group)` | `CompoStockController@update` |
| `reduceStock1` | `auth (from group)` | `CompoStockController@reduceStock1` |
| `coupons` | `auth (from group)` | `CouponController@addcoupon` |
| `updatecoupon/{id}` | `auth (from group)` | `CouponController@update` |
| `destroycoupon/{id}` | `auth (from group)` | `CouponController@destroy` |
| `offerImagess` | `auth (from group)` | `OfferImageController@offerImagess` |
| `updateOfferImages/{id}` | `auth (from group)` | `OfferImageController@update` |
| `destroyOfferImages/{id}` | `auth (from group)` | `OfferImageController@destroy` |
| `userss` | `auth (from group)` | `DashboardUserController@userss` |
| `updateuser/{id}` | `auth (from group)` | `DashboardUserController@update` |
| `destroyusers/{id}` | `auth (from group)` | `DashboardUserController@destroy` |
| `updatepass/{id}` | `auth (from group)` | `DashboardUserController@update1` |
| `reviews` | `auth (from group)` | `NotificationController@notifications` |
| `updatenotifi/{id}` | `auth (from group)` | `NotificationController@update` |
| `destroynotifi/{id}` | `auth (from group)` | `NotificationController@destroy` |
| `/getproductsbycategory/{id}` | `auth (from group)` | `NotificationController@getProductsByCategory` |
| `addproductvarient` | `auth (from group)` | `ProductVarientControllet@addproductvarient` |
| `updateProductsvarient/{id}` | `auth (from group)` | `ProductVarientControllet@update` |
| `destroyvarient/{id}` | `auth (from group)` | `ProductVarientControllet@destroy` |
| `Getproduct/{custid}` | `auth (from group)` | `ProductVarientControllet@Getproduct` |
| `Getsubcategory/{custid}` | `auth (from group)` | `ProductVarientControllet@Getsubcategory` |
| `getproductverfilter` | `auth (from group)` | `ProductVarientControllet@getproductverfilter` |
| `ThumImages` | `auth (from group)` | `ProductThumController@ThumImages` |
| `updatethumImages/{id}` | `auth (from group)` | `ProductThumController@update` |
| `destroyThumpImages/{id}` | `auth (from group)` | `ProductThumController@destroy` |
| `updatePasss/{userId}` | `auth (from group)` | `UserController@updatePass` |
| `updatetodaydeals/{id}` | `auth (from group)` | `TodayDealsController@update` |
| `destroytodaydeals/{id}` | `auth (from group)` | `TodayDealsController@destroy` |
| `validateSubCategoryName` | `auth (from group)` | `SubCategoryController@validateSubCategoryName` |
| `cancelrequests` | `auth (from group)` | `ProductSlotController@cancelrequests` |
| `/approverequest` | `auth (from group)` | `ProductSlotController@approverequest` |
| `returnrequests` | `auth (from group)` | `ProductSlotController@returnrequests` |
| `/reject-return-request` | `auth (from group)` | `ProductSlotController@rejectReturnRequests` |
| `/orders/fetchtotalorders` | `auth (from group)` | `ProductOrdersController@fetchTotalOrders` |
| `/bank-details` | `auth (from group)` | `BankDetailController@index` |
| `/bank-details` | `auth (from group)` | `BankDetailController@store` |
| `/bank-details/update/{id}` | `auth (from group)` | `BankDetailController@update` |
| `/bank-details/destroy/{id}` | `auth (from group)` | `BankDetailController@destroy` |
| `/settings` | `auth (from group)` | `AppSettingsController@index` |
| `/settings/update` | `auth (from group)` | `AppSettingsController@update` |
| `/settings/size-chart/update` | `auth (from group)` | `AppSettingsController@updateSizeChart` |
| `/settings/checkout/update` | `auth (from group)` | `AppSettingsController@updateCheckoutSettings` |
| `bulk-orders` | `auth (from group)` | `BulkOrderController@index` |
| `bulk-orders/update-status` | `auth (from group)` | `BulkOrderController@updateStatus` |
| `/currency-test` | `auth (from group)` | `CurrencyController@index` |
| `/currency/convert` | `auth (from group)` | `CurrencyController@convert` |
| `/currency/switch` | `auth (from group)` | `CurrencyController@switchCurrency` |
| `/currency/switch/{currency}` | `auth (from group)` | `CurrencyController@switchCurrencyByGet` |
| `/order-assets/zip/{orderId}` | `auth (from group)` | `OrderAssetsController@downloadZip` |
| `/order-assets/file` | `auth (from group)` | `OrderAssetsController@downloadFile` |
| `lang/{locale}` | `auth (from group)` | `HomeController@lang` |
| `/orderwisereport` | `auth (from group)` | `OrderController@orderwisereport` |
| `/order-wise-report/filter` | `auth (from group)` | `OrderController@filterorderWiseReport` |
| `/oreport/export/excel` | `auth (from group)` | `OrderController@exportExcel` |
| `/oreport/export/pdf` | `auth (from group)` | `OrderController@exportPDF` |
| `/shipping` | `auth (from group)` | `ShippingController@getship` |
| `/insertshipping` | `auth (from group)` | `ShippingController@addshipping` |
| `/updateship` | `auth (from group)` | `ShippingController@updateship` |
| `/destroyshipping/{id}` | `auth (from group)` | `ShippingController@destroyshipping` |
| `/custom-products` | `auth (from group)` | `CustomProductController@index` |
| `/custom-products/designer-data/{id}` | `auth (from group)` | `CustomProductController@getDesignerData` |
| `/custom-products/destroy/{id}` | `auth (from group)` | `CustomProductController@destroy` |
| `/custom-products/duplicate/{id}` | `auth (from group)` | `CustomProductController@duplicate` |
| `/custom-products/store` | `auth (from group)` | `CustomProductController@store` |
| `/custom-products/edit/{id}` | `auth (from group)` | `CustomProductController@edit` |
| `/custom-products/update/{id}` | `auth (from group)` | `CustomProductController@update` |
| `/` | `auth (from group)` | `HomeController@root` |
| `/update-profile` | `auth (from group)` | `HomeController@updateProfile` |
| `/update-password/{id}` | `auth (from group)` | `HomeController@updatePassword` |
| `{any}` | `auth (from group)` | `HomeController@index` |
| `index/{locale}` | `auth (from group)` | `HomeController@lang` |
| `/invoice/{orderId}` | `auth (from group)` | `OrderController@showInvoice` |
| `customers/*` | `auth (from group)` | `UserController` (resource) |
| `deliveryPersons/*` | `auth (from group)` | `DeliveryPersonController` (resource) |
| `categories/*` | `auth (from group)` | `CategoryController` (resource) |
| `subcategories/*` | `auth (from group)` | `SubCategoryController` (resource) |
| `products/*` | `auth (from group)` | `ProductController` (resource) |
| `areas/*` | `auth (from group)` | `AreaController` (resource) |
| `bannerImages/*` | `auth (from group)` | `BannerImagesController` (resource) |
| `designs/*` | `auth (from group)` | `DesignsController` (resource) |
| `all-samples/*` | `auth (from group)` | `SamplesController` (resource) |
| `milkOrders/*` | `auth (from group)` | `MilkOrdersController` (resource) |
| `productOrders/*` | `auth (from group)` | `ProductOrdersController` (resource) |
| `productpacking/*` | `auth (from group)` | `PackingOrderController` (resource) |
| `productdispatch/*` | `auth (from group)` | `PackingDispatchController` (resource) |
| `productdelivery/*` | `auth (from group)` | `PackingDeliveryController` (resource) |
| `productcomplete/*` | `auth (from group)` | `packingCompleteController` (resource) |
| `productreturn/*` | `auth (from group)` | `ProductReturnController` (resource) |
| `ordersummery/*` | `auth (from group)` | `OrderSummeryController` (resource) |
| `milkRefunds/*` | `auth (from group)` | `MilkRefundController` (resource) |
| `productRefunds/*` | `auth (from group)` | `ProductRefundController` (resource) |
| `cancelproduct/*` | `auth (from group)` | `CancelProductController` (resource) |
| `stocks/*` | `auth (from group)` | `StockController` (resource) |
| `combostock/*` | `auth (from group)` | `CompoStockController` (resource) |
| `coupons/*` | `auth (from group)` | `CouponController` (resource) |
| `offerImages/*` | `auth (from group)` | `OfferImageController` (resource) |
| `users/*` | `auth (from group)` | `DashboardUserController` (resource) |
| `review/*` | `auth (from group)` | `NotificationController` (resource) |
| `productvarient/*` | `auth (from group)` | `ProductVarientControllet` (resource) |
| `productthump/*` | `auth (from group)` | `ProductThumController` (resource) |
| `topcustomer/*` | `auth (from group)` | `TopCustomerController` (resource) |
| `todaydeals/*` | `auth (from group)` | `TodayDealsController` (resource) |

## Route Middleware Summary (Web App)

| Route | Middleware | Controller |
|-------|-----------|------------|
| `/bulk-order` | `—` | `BulkOrderController@index` |
| `/bulk-order` | `—` | `BulkOrderController@store` |
| `/lang/{locale}` | `—` | `LanguageController@switch` |
| `/` | `—` | `HomeController@index` |
| `/home` | `—` | `HomeController@index` |
| `/shop` | `—` | `ShopController@index` |
| `/sample` | `—` | `SampleController@index` |
| `/product-details/{id}` | `—` | `ShopController@show` |
| `/contact/submit` | `—` | `ContactController@store` |
| `/login` | `—` | `AuthController@showLogin` |
| `/register` | `—` | `AuthController@showRegister` |
| `/forgot-password` | `—` | `AuthController@showForgotPassword` |
| `/login` | `—` | `AuthController@login` |
| `/register` | `—` | `AuthController@register` |
| `/forgot-password/send-otp` | `—` | `AuthController@sendOTP` |
| `/forgot-password/verify-otp` | `—` | `AuthController@verifyOTP` |
| `/forgot-password/reset` | `—` | `AuthController@resetPassword` |
| `/logout` | `—` | `AuthController@logout` |
| `/myaccount` | `—` | `AccountController@index` |
| `/addresses` | `—` | `UserAddressController@store` |
| `/addresses/{id}` | `—` | `UserAddressController@update` |
| `/addresses/{id}` | `—` | `UserAddressController@destroy` |
| `/addresses/{id}/set-default` | `—` | `UserAddressController@setDefault` |
| `/create-razorpay-order` | `—` | `OrderController@createRazorpayOrder` |
| `/order/place` | `—` | `OrderController@placeOrder` |
| `/order/success` | `—` | `OrderController@success` |
| `/order/details/{orderId}` | `—` | `OrderController@getDetails` |
| `/create-paypal-payment` | `—` | `OrderController@createPayPalPayment` |
| `/paypal/execute` | `—` | `OrderController@executePayPalPayment` |
| `/paypal/cancel` | `—` | `OrderController@cancelPayPalPayment` |
| `/bank-details` | `—` | `OrderController@showBankDetails` |
| `/order/upload-proof` | `—` | `OrderController@uploadPaymentProof` |
| `/checkout` | `—` | `OrderController@checkout` |
| `/update-profile` | `—` | `AccountController@updateProfile` |
| `/change-password` | `—` | `AccountController@changePassword` |
| `/order-assets/zip/{orderId}` | `—` | `OrderAssetsController@downloadZip` |
| `/order-assets/file` | `—` | `OrderAssetsController@downloadFile` |
| `/cart` | `—` | `CartController@index` |
| `/cart/add` | `—` | `CartController@addToCart` |
| `/cart/update/{id}` | `—` | `CartController@updateQuantity` |
| `/cart/remove/{id}` | `—` | `CartController@removeItem` |
| `/customproducts` | `—` | `CustomProductController@index` |
| `/customproducts/{id}` | `—` | `CustomProductController@show` |
| `/customproducts/{id}/designer-data` | `—` | `CustomProductController@getDesignerData` |
| `/customproducts/{id}/designer-data-v2` | `—` | `CustomProductController@getDesignerDataFixed` |
| `/designs/init` | `—` | `CustomDesignController@init` |
| `/designs/save` | `—` | `CustomDesignController@store` |
| `/designs/{id}` | `—` | `CustomDesignController@update` |
| `/designs/upload-user-image` | `—` | `CustomDesignController@uploadUserImage` |
| `/designs/export-image` | `—` | `CustomDesignController@uploadExport` |
| `/designs/{id}` | `—` | `CustomDesignController@show` |
| `/my-designs` | `—` | `CustomDesignController@myDesigns` |
| `/designs/my/all` | `—` | `CustomDesignController@myDesigns` |
| `/designs/{id}` | `—` | `CustomDesignController@destroy` |
| `/own-design` | `—` | `DesignController@index` |
| `/customize-products` | `—` | `CustomProductController@picker` |
| `/categories` | `—` | `CategoriesController@index` |
| `/currency-test` | `—` | `CurrencyController@index` |
| `/currency/convert` | `—` | `CurrencyController@convert` |
| `/currency/switch` | `—` | `CurrencyController@switchCurrency` |
| `/currency/switch/{currency}` | `—` | `CurrencyController@switchCurrencyByGet` |

## Authorization Checks Found in Controllers

| App | File | Method | Auth Check |
|-----|------|--------|------------|
| dash | `dash/app/Http/Controllers\Auth\ConfirmPasswordController.php` | `__construct()` | auth() helper |
| dash | `dash/app/Http/Controllers\Auth\VerificationController.php` | `__construct()` | auth() helper |
| dash | `dash/app/Http/Controllers\HomeController.php` | `__construct()` | auth() helper |
| dash | `dash/app/Http/Controllers\HomeController.php` | `updateProfile()` | Auth::user() |
| dash | `dash/app/Http/Controllers\ProductController.php` | `pickupstatus()` | auth() helper |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `orderStat()` | auth() helper |
| dash | `dash/app/Http/Controllers\ProductSlotController.php` | `approverequest()` | auth() helper |
| dash | `dash/app/Http/Controllers\ProductSlotController.php` | `approveReturnRequest()` | auth() helper |
| web | `web/app/Http/Controllers\AccountController.php` | `index()` | Auth::user() |
| web | `web/app/Http/Controllers\AccountController.php` | `updateProfile()` | Auth::user() |
| web | `web/app/Http/Controllers\AccountController.php` | `changePassword()` | Auth::user() |
| web | `web/app/Http/Controllers\BulkOrderController.php` | `index()` | Auth::check(), Auth::user() |
| web | `web/app/Http/Controllers\CartController.php` | `index()` | Auth::user() |
| web | `web/app/Http/Controllers\CartController.php` | `addToCart()` | Auth::check(), Auth::user() |
| web | `web/app/Http/Controllers\CartController.php` | `removeItem()` | Auth::user() |
| web | `web/app/Http/Controllers\CartController.php` | `updateQuantity()` | Auth::user() |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `init()` | Auth::check(), Auth::user() |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `store()` | Auth::check(), Auth::user() |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `show()` | Auth::check(), Auth::user() |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `myDesigns()` | Auth::check(), Auth::user() |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `update()` | Auth::check(), Auth::user() |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `destroy()` | Auth::check(), Auth::user() |
| web | `web/app/Http/Controllers\OrderController.php` | `checkout()` | Auth::user() |
| web | `web/app/Http/Controllers\OrderController.php` | `placeOrder()` | Auth::user() |
| web | `web/app/Http/Controllers\OrderController.php` | `createRazorpayOrder()` | Auth::user() |
| web | `web/app/Http/Controllers\OrderController.php` | `getDetails()` | Auth::user() |
| web | `web/app/Http/Controllers\OrderController.php` | `createPayPalPayment()` | Auth::user() |
| web | `web/app/Http/Controllers\OrderController.php` | `executePayPalPayment()` | Auth::user() |
| web | `web/app/Http/Controllers\UserAddressController.php` | `store()` | Auth::user() |
| web | `web/app/Http/Controllers\UserAddressController.php` | `update()` | Auth::user() |
| web | `web/app/Http/Controllers\UserAddressController.php` | `setDefault()` | Auth::user() |
| web | `web/app/Http/Controllers\UserAddressController.php` | `destroy()` | Auth::user() |

## Admin User Roles

DashboardUser fillable fields: `
        'name',
        'empl_num',
        'email',
        "phone_number",
        "role",
        "status",
        "enc_password",
        'password',
    `

**Note:** DashboardUser model used for admin auth. No role-based access control (RBAC) gates or policies detected in the codebase.

All authenticated admin users appear to have **uniform access** to all admin routes.

## Gaps & Recommendations

1. **No role-based access** — no admin/user/staff distinction within the dashboard
2. **No policy classes** — no `App\Policies\*` files found
3. **No Gate definitions** — no `Gate::define()` calls in AppServiceProvider
4. **Single guard** — both apps use the default `web` guard
5. Consider implementing Spatie Permission or Laravel built-in Gates for multi-role admin access
