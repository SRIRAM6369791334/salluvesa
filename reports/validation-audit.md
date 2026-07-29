# Validation & Input Sanitization Audit

**Generated:** 2026-07-27 15:06:21

Checks which endpoints validate input, which use request()->all(), which have no validation at all.

---

## Controllers WITH Validation

| App | File | Method |
|-----|------|--------|
| dash | `dash/app/Http/Controllers\AppSettingsController.php` | `update()` |
| dash | `dash/app/Http/Controllers\AppSettingsController.php` | `updateSizeChart()` |
| dash | `dash/app/Http/Controllers\AppSettingsController.php` | `updateCheckoutSettings()` |
| dash | `dash/app/Http/Controllers\AreaController.php` | `store()` |
| dash | `dash/app/Http/Controllers\AreaController.php` | `update()` |
| dash | `dash/app/Http/Controllers\BankDetailController.php` | `store()` |
| dash | `dash/app/Http/Controllers\BankDetailController.php` | `update()` |
| dash | `dash/app/Http/Controllers\BannerImagesController.php` | `store()` |
| dash | `dash/app/Http/Controllers\BannerImagesController.php` | `update()` |
| dash | `dash/app/Http/Controllers\BannerImagesController.php` | `updateimage()` |
| dash | `dash/app/Http/Controllers\BannerImagesController.php` | `addbanner()` |
| dash | `dash/app/Http/Controllers\BulkOrderController.php` | `updateStatus()` |
| dash | `dash/app/Http/Controllers\CategoryController.php` | `store()` |
| dash | `dash/app/Http/Controllers\CategoryController.php` | `update()` |
| dash | `dash/app/Http/Controllers\CategoryController.php` | `validateCategoryName()` |
| dash | `dash/app/Http/Controllers\CouponController.php` | `addcoupon()` |
| dash | `dash/app/Http/Controllers\CouponController.php` | `update()` |
| dash | `dash/app/Http/Controllers\CurrencyController.php` | `switchCurrency()` |
| dash | `dash/app/Http/Controllers\CurrencyController.php` | `convert()` |
| dash | `dash/app/Http/Controllers\CustomProductController.php` | `store()` |
| dash | `dash/app/Http/Controllers\CustomProductController.php` | `update()` |
| dash | `dash/app/Http/Controllers\DashboardUserController.php` | `userss()` |
| dash | `dash/app/Http/Controllers\DashboardUserController.php` | `update()` |
| dash | `dash/app/Http/Controllers\DashboardUserController.php` | `update1()` |
| dash | `dash/app/Http/Controllers\DeliveryPersonController.php` | `store()` |
| dash | `dash/app/Http/Controllers\DeliveryPersonController.php` | `update()` |
| dash | `dash/app/Http/Controllers\DesignsController.php` | `store()` |
| dash | `dash/app/Http/Controllers\DesignsController.php` | `update()` |
| dash | `dash/app/Http/Controllers\HomeController.php` | `updateProfile()` |
| dash | `dash/app/Http/Controllers\NotificationController.php` | `notifications()` |
| dash | `dash/app/Http/Controllers\NotificationController.php` | `update()` |
| dash | `dash/app/Http/Controllers\OfferImageController.php` | `offerImagess()` |
| dash | `dash/app/Http/Controllers\OfferImageController.php` | `update()` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `store()` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `update()` |
| dash | `dash/app/Http/Controllers\ProductThumController.php` | `ThumImages()` |
| dash | `dash/app/Http/Controllers\ProductThumController.php` | `update()` |
| dash | `dash/app/Http/Controllers\ProductVarientControllet.php` | `addproductvarient()` |
| dash | `dash/app/Http/Controllers\ProductVarientControllet.php` | `update()` |
| dash | `dash/app/Http/Controllers\SamplesController.php` | `store()` |
| dash | `dash/app/Http/Controllers\SamplesController.php` | `update()` |
| dash | `dash/app/Http/Controllers\SubCategoryController.php` | `store()` |
| dash | `dash/app/Http/Controllers\SubCategoryController.php` | `update()` |
| dash | `dash/app/Http/Controllers\TodayDealsController.php` | `store()` |
| dash | `dash/app/Http/Controllers\TodayDealsController.php` | `update()` |
| dash | `dash/app/Http/Controllers\UserController.php` | `store()` |
| dash | `dash/app/Http/Controllers\UserController.php` | `update()` |
| dash | `dash/app/Http/Controllers\UserController.php` | `updatePass()` |
| dash | `dash/app/Http/Controllers\UserController.php` | `addaddressvalue()` |
| web | `web/app/Http/Controllers\AccountController.php` | `updateProfile()` |
| web | `web/app/Http/Controllers\AccountController.php` | `changePassword()` |
| web | `web/app/Http/Controllers\AuthController.php` | `login()` |
| web | `web/app/Http/Controllers\AuthController.php` | `sendOTP()` |
| web | `web/app/Http/Controllers\AuthController.php` | `verifyOTP()` |
| web | `web/app/Http/Controllers\AuthController.php` | `resetPassword()` |
| web | `web/app/Http/Controllers\BulkOrderController.php` | `store()` |
| web | `web/app/Http/Controllers\CartController.php` | `addToCart()` |
| web | `web/app/Http/Controllers\CartController.php` | `updateQuantity()` |
| web | `web/app/Http/Controllers\ContactController.php` | `store()` |
| web | `web/app/Http/Controllers\CurrencyController.php` | `switchCurrency()` |
| web | `web/app/Http/Controllers\CurrencyController.php` | `convert()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `init()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `store()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `update()` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `uploadUserImage()` |
| web | `web/app/Http/Controllers\OrderController.php` | `placeOrder()` |
| web | `web/app/Http/Controllers\OrderController.php` | `createRazorpayOrder()` |
| web | `web/app/Http/Controllers\OrderController.php` | `createPayPalPayment()` |
| web | `web/app/Http/Controllers\OrderController.php` | `uploadPaymentProof()` |

## Controllers WITHOUT Validation ⚠️

| App | File | Method | Params |
|-----|------|--------|--------|
| dash | `dash/app/Http/Controllers\AppSettingsController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\AreaAssignController.php` | `assignDeliveryPerson()` | `Request $request` |
| dash | `dash/app/Http/Controllers\AreaAssignController.php` | `deleteDeliveryPerson()` | `Request $request` |
| dash | `dash/app/Http/Controllers\AreaAssignController.php` | `fetchAreaDeliveryPartners()` | `$areaId` |
| dash | `dash/app/Http/Controllers\AreaAssignController.php` | `deleteAreaDeliveryPartners()` | `$areaid` |
| dash | `dash/app/Http/Controllers\AreaController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\AreaController.php` | `create()` | `` |
| dash | `dash/app/Http/Controllers\AreaController.php` | `show()` | `string $id` |
| dash | `dash/app/Http/Controllers\AreaController.php` | `edit()` | `Area $area` |
| dash | `dash/app/Http/Controllers\AreaController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\AreaController.php` | `checkAreaValidation()` | `Request $request` |
| dash | `dash/app/Http/Controllers\AreaController.php` | `getPincodeAreas()` | `Request $request` |
| dash | `dash/app/Http/Controllers\Auth\ConfirmPasswordController.php` | `__construct()` | `` |
| dash | `dash/app/Http/Controllers\Auth\LoginController.php` | `__construct()` | `` |
| dash | `dash/app/Http/Controllers\Auth\RegisterController.php` | `__construct()` | `` |
| dash | `dash/app/Http/Controllers\Auth\RegisterController.php` | `validator()` | `array $data` |
| dash | `dash/app/Http/Controllers\Auth\RegisterController.php` | `create()` | `array $data` |
| dash | `dash/app/Http/Controllers\Auth\VerificationController.php` | `__construct()` | `` |
| dash | `dash/app/Http/Controllers\BankDetailController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\BankDetailController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\BannerImagesController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\BannerImagesController.php` | `create()` | `` |
| dash | `dash/app/Http/Controllers\BannerImagesController.php` | `show()` | ` $id ` |
| dash | `dash/app/Http/Controllers\BannerImagesController.php` | `edit()` | ` $id ` |
| dash | `dash/app/Http/Controllers\BannerImagesController.php` | `destroy()` | ` $id ` |
| dash | `dash/app/Http/Controllers\BannerImagesController.php` | `destroyweb()` | ` $id ` |
| dash | `dash/app/Http/Controllers\BannerImagesController.php` | `updateOrder()` | ` Request $request ` |
| dash | `dash/app/Http/Controllers\BulkOrderController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\CancelProductController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\CancelProductController.php` | `cancelProductrequ()` | ` Request $request ` |
| dash | `dash/app/Http/Controllers\CategoryController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\CategoryController.php` | `create()` | `` |
| dash | `dash/app/Http/Controllers\CategoryController.php` | `show()` | `string $id` |
| dash | `dash/app/Http/Controllers\CategoryController.php` | `edit()` | `string $id` |
| dash | `dash/app/Http/Controllers\CategoryController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\CompoStockController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\CompoStockController.php` | `update()` | `Request $request` |
| dash | `dash/app/Http/Controllers\CompoStockController.php` | `reduceStock1()` | `Request $request` |
| dash | `dash/app/Http/Controllers\CouponController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\CouponController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\CurrencyController.php` | `__construct()` | `CurrencyService $currencyService` |
| dash | `dash/app/Http/Controllers\CurrencyController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\CurrencyController.php` | `switchCurrencyByGet()` | `string $currency` |
| dash | `dash/app/Http/Controllers\CurrencyController.php` | `performSwitch()` | `string $currency, bool $redirect = false` |
| dash | `dash/app/Http/Controllers\CustomProductController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\CustomProductController.php` | `edit()` | `$id` |
| dash | `dash/app/Http/Controllers\CustomProductController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\CustomProductController.php` | `duplicate()` | `$id` |
| dash | `dash/app/Http/Controllers\CustomProductController.php` | `getDesignerData()` | `$id` |
| dash | `dash/app/Http/Controllers\DashboardUserController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\DashboardUserController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\DeliveryPersonController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\DeliveryPersonController.php` | `create()` | `` |
| dash | `dash/app/Http/Controllers\DeliveryPersonController.php` | `show()` | `DeliveryPerson $deliveryPerson` |
| dash | `dash/app/Http/Controllers\DeliveryPersonController.php` | `edit()` | `DeliveryPerson $deliveryPerson` |
| dash | `dash/app/Http/Controllers\DeliveryPersonController.php` | `destroy()` | `DeliveryPerson $deliveryPerson` |
| dash | `dash/app/Http/Controllers\DesignsController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\DesignsController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\HomeController.php` | `__construct()` | `` |
| dash | `dash/app/Http/Controllers\HomeController.php` | `index()` | `Request $request` |
| dash | `dash/app/Http/Controllers\HomeController.php` | `root()` | `CurrencyService $currencyService` |
| dash | `dash/app/Http/Controllers\HomeController.php` | `lang()` | `$locale` |
| dash | `dash/app/Http/Controllers\IndexContrller.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\IndexContrller.php` | `create()` | `` |
| dash | `dash/app/Http/Controllers\IndexContrller.php` | `store()` | `Request $request` |
| dash | `dash/app/Http/Controllers\IndexContrller.php` | `show()` | `` |
| dash | `dash/app/Http/Controllers\IndexContrller.php` | `edit()` | `string $id` |
| dash | `dash/app/Http/Controllers\IndexContrller.php` | `update()` | `Request $request, string $id` |
| dash | `dash/app/Http/Controllers\IndexContrller.php` | `destroy()` | `string $id` |
| dash | `dash/app/Http/Controllers\MilkOrdersController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\MilkOrdersController.php` | `getMilkSlots()` | `$orderId` |
| dash | `dash/app/Http/Controllers\MilkOrdersController.php` | `cancelMilkSlot()` | `Request $request` |
| dash | `dash/app/Http/Controllers\MilkOrdersController.php` | `getAreaAssignedDelvieryPerson()` | `$areaId` |
| dash | `dash/app/Http/Controllers\MilkOrdersController.php` | `milkOrderDeliveryAssign()` | `Request $request` |
| dash | `dash/app/Http/Controllers\MilkRefundController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\MilkRefundController.php` | `getRefundDatas()` | `Request $request` |
| dash | `dash/app/Http/Controllers\MilkRefundController.php` | `refundMilkSlot()` | `Request $request` |
| dash | `dash/app/Http/Controllers\MilkSlotController.php` | `getMilkSlots()` | `$orderId` |
| dash | `dash/app/Http/Controllers\MilkSlotController.php` | `cancelMilkSlot()` | `Request $request` |
| dash | `dash/app/Http/Controllers\NotificationController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\NotificationController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\NotificationController.php` | `getProductsByCategory()` | `$id` |
| dash | `dash/app/Http/Controllers\OfferImageController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\OfferImageController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\OrderAssetsController.php` | `downloadZip()` | `$orderId` |
| dash | `dash/app/Http/Controllers\OrderAssetsController.php` | `downloadFile()` | `Request $request` |
| dash | `dash/app/Http/Controllers\OrderController.php` | `orderwisereport()` | `` |
| dash | `dash/app/Http/Controllers\OrderController.php` | `filterorderWiseReport()` | `Request $request` |
| dash | `dash/app/Http/Controllers\OrderController.php` | `exportExcel()` | `Request $request` |
| dash | `dash/app/Http/Controllers\OrderController.php` | `exportPDF()` | `Request $request` |
| dash | `dash/app/Http/Controllers\OrderController.php` | `getFilteredOrderData()` | `Request $request` |
| dash | `dash/app/Http/Controllers\OrderController.php` | `getFilteredOrderDataFromDates()` | `$filter, $from = null, $to = null` |
| dash | `dash/app/Http/Controllers\OrderController.php` | `showInvoice()` | `$orderId` |
| dash | `dash/app/Http/Controllers\OrderSummeryController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\OrderSummeryController.php` | `getoversummery()` | `Request $request` |
| dash | `dash/app/Http/Controllers\packingCompleteController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\PackingDeliveryController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\PackingDeliveryController.php` | `updatedelive()` | `Request $request` |
| dash | `dash/app/Http/Controllers\PackingDeliveryController.php` | `collectdelive()` | `Request $request` |
| dash | `dash/app/Http/Controllers\PackingDispatchController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\PackingDispatchController.php` | `updatedispach()` | `Request $request` |
| dash | `dash/app/Http/Controllers\PackingDispatchController.php` | `updaterefund2()` | `Request $request` |
| dash | `dash/app/Http/Controllers\PackingOrderController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\PackingOrderController.php` | `updatepacking()` | `Request $request` |
| dash | `dash/app/Http/Controllers\PackingOrderController.php` | `updaterefund1()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `destroyVarientThumpImages()` | `string $id` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `create()` | `` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `show()` | `string $id` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `edit()` | `string $id` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `productImageUpload()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `getProductDetail()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `createMilkSubscription()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `addMilkOrderDeliveryAddress()` | `$orderId, $user` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `addProductOrderDeliveryAddress()` | `$orderId, $user` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `assignDeliverPersonMilkOrder()` | `$orderId, $user` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `createProductSubscription()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `assignDeliverProductOrder()` | `$orderId, $user` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `createMilkSlot()` | `$orderId` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `createProductSlot()` | `$orderId, $selettype, $request` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `viewProductInvoice()` | `$orderId = null` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `exportCommercialInvoice()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `exportPackingList()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `getOrderProductsForExport()` | `$orderId = null` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `upadetstatus()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `pickupstatus()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `getproductfilter()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `updaterefund()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `Getsubproo()` | `$id` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `getthump()` | `$product_id` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `saveExportFormData()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductController.php` | `getExportFormData()` | `$orderId` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `orderStat()` | `` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `create()` | `` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `store()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `show()` | `$id` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `edit()` | `$id` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `update()` | `Request $request, $id` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `productOrderDeliveryAssign()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductOrdersController.php` | `fetchTotalOrders()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductRefundController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\ProductRefundController.php` | `getRefundDatas()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductRefundController.php` | `refundProductSlot()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductReturnController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\ProductReturnController.php` | `update()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductReturnController.php` | `updateed()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductSlotController.php` | `getProductSlots()` | `$orderId` |
| dash | `dash/app/Http/Controllers\ProductSlotController.php` | `getProductSlotss()` | `$orderId` |
| dash | `dash/app/Http/Controllers\ProductSlotController.php` | `cancelProductSlot()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductSlotController.php` | `cancelrequests()` | `` |
| dash | `dash/app/Http/Controllers\ProductSlotController.php` | `approverequest()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductSlotController.php` | `returnrequests()` | `` |
| dash | `dash/app/Http/Controllers\ProductSlotController.php` | `approveReturnRequest()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductSlotController.php` | `rejectReturnRequests()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ProductThumController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\ProductThumController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\ProductVarientControllet.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\ProductVarientControllet.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\ProductVarientControllet.php` | `Getsubcategory()` | `$id` |
| dash | `dash/app/Http/Controllers\ProductVarientControllet.php` | `Getproduct()` | `$id` |
| dash | `dash/app/Http/Controllers\ProductVarientControllet.php` | `getproductverfilter()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ReportsController.php` | `incomeReports()` | `` |
| dash | `dash/app/Http/Controllers\ReportsController.php` | `getIncomeReports()` | `Request $request` |
| dash | `dash/app/Http/Controllers\SamplesController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\SamplesController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\sendsms.php` | `__construct()` | `$url, $token` |
| dash | `dash/app/Http/Controllers\sendsms.php` | `__destruct()` | `` |
| dash | `dash/app/Http/Controllers\sendsms.php` | `sendme()` | `$smsurl` |
| dash | `dash/app/Http/Controllers\sendsms.php` | `sendmessage()` | `$credit, $sender, $message, $number` |
| dash | `dash/app/Http/Controllers\sendsms.php` | `checkdlr()` | `$message_id` |
| dash | `dash/app/Http/Controllers\sendsms.php` | `availablecredit()` | `$credit` |
| dash | `dash/app/Http/Controllers\ShippingController.php` | `getship()` | `` |
| dash | `dash/app/Http/Controllers\ShippingController.php` | `addshipping()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ShippingController.php` | `updateship()` | `Request $request` |
| dash | `dash/app/Http/Controllers\ShippingController.php` | `destroyshipping()` | `$id` |
| dash | `dash/app/Http/Controllers\StockController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\StockController.php` | `update()` | `Request $request` |
| dash | `dash/app/Http/Controllers\StockController.php` | `reduceStock()` | `Request $request` |
| dash | `dash/app/Http/Controllers\StockController.php` | `lowstock()` | `` |
| dash | `dash/app/Http/Controllers\StockController.php` | `update1()` | `Request $request` |
| dash | `dash/app/Http/Controllers\StockController.php` | `highselling()` | `` |
| dash | `dash/app/Http/Controllers\SubCategoryController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\SubCategoryController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\TestController.php` | `test()` | `Request $request` |
| dash | `dash/app/Http/Controllers\TodayDealsController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\TodayDealsController.php` | `destroy()` | ` $id ` |
| dash | `dash/app/Http/Controllers\TopCustomerController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\UserController.php` | `index()` | `` |
| dash | `dash/app/Http/Controllers\UserController.php` | `create()` | `` |
| dash | `dash/app/Http/Controllers\UserController.php` | `show()` | `string $id` |
| dash | `dash/app/Http/Controllers\UserController.php` | `edit()` | `$customerId` |
| dash | `dash/app/Http/Controllers\UserController.php` | `destroy()` | `$id` |
| dash | `dash/app/Http/Controllers\UserController.php` | `getProductsOptions()` | `Request $request` |
| dash | `dash/app/Http/Controllers\UserController.php` | `getProductsverentOptions()` | `Request $request` |
| dash | `dash/app/Http/Controllers\UserController.php` | `getProductsverentqty()` | `Request $request` |
| dash | `dash/app/Http/Controllers\UserController.php` | `getcustomersummery()` | `Request $request` |
| dash | `dash/app/Http/Controllers\UserController.php` | `Getcity()` | `$custid` |
| dash | `dash/app/Http/Controllers\UserController.php` | `getAddressDetails()` | `Request $request` |
| dash | `dash/app/Http/Controllers\UserController.php` | `getAddressDetails1()` | `Request $request` |
| web | `web/app/Http/Controllers\AccountController.php` | `index()` | `` |
| web | `web/app/Http/Controllers\AuthController.php` | `showRegister()` | `` |
| web | `web/app/Http/Controllers\AuthController.php` | `register()` | `Request $request` |
| web | `web/app/Http/Controllers\AuthController.php` | `showLogin()` | `` |
| web | `web/app/Http/Controllers\AuthController.php` | `logout()` | `Request $request` |
| web | `web/app/Http/Controllers\AuthController.php` | `showForgotPassword()` | `` |
| web | `web/app/Http/Controllers\BulkOrderController.php` | `index()` | `` |
| web | `web/app/Http/Controllers\BulkOrderController.php` | `generateBulkOrderId()` | `` |
| web | `web/app/Http/Controllers\CartController.php` | `index()` | `` |
| web | `web/app/Http/Controllers\CartController.php` | `removeItem()` | `$id` |
| web | `web/app/Http/Controllers\CategoriesController.php` | `index()` | `` |
| web | `web/app/Http/Controllers\CurrencyController.php` | `__construct()` | `CurrencyService $currencyService` |
| web | `web/app/Http/Controllers\CurrencyController.php` | `index()` | `` |
| web | `web/app/Http/Controllers\CurrencyController.php` | `switchCurrencyByGet()` | `string $currency` |
| web | `web/app/Http/Controllers\CurrencyController.php` | `performSwitch()` | `string $currency, bool $redirect = false` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `show()` | `$id` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `myDesigns()` | `` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `saveOrganizedImage()` | `$base64String, $side, $design, $isThumb = false` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `destroy()` | `$id` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `validatePrintBoundaries()` | `$layer, $canvasWidth, $canvasHeight` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `saveBase64Image()` | `$base64String, $side` |
| web | `web/app/Http/Controllers\CustomDesignController.php` | `uploadExport()` | `Request $request` |
| web | `web/app/Http/Controllers\CustomProductController.php` | `index()` | `` |
| web | `web/app/Http/Controllers\CustomProductController.php` | `show()` | `$id` |
| web | `web/app/Http/Controllers\CustomProductController.php` | `getDesignerData()` | `$id` |
| web | `web/app/Http/Controllers\CustomProductController.php` | `getDesignerDataFixed()` | `$id` |
| web | `web/app/Http/Controllers\CustomProductController.php` | `picker()` | `` |
| web | `web/app/Http/Controllers\DesignController.php` | `index()` | `` |
| web | `web/app/Http/Controllers\HomeController.php` | `index()` | `` |
| web | `web/app/Http/Controllers\LanguageController.php` | `switch()` | `string $locale` |
| web | `web/app/Http/Controllers\OrderAssetsController.php` | `downloadZip()` | `$orderId` |
| web | `web/app/Http/Controllers\OrderAssetsController.php` | `downloadFile()` | `Request $request` |
| web | `web/app/Http/Controllers\OrderController.php` | `checkout()` | `` |
| web | `web/app/Http/Controllers\OrderController.php` | `processRazorpayOrder()` | `Request $request, $user` |
| web | `web/app/Http/Controllers\OrderController.php` | `captureDesignSnapshot()` | `$orderId, $cartItem` |
| web | `web/app/Http/Controllers\OrderController.php` | `processPayPalOrder()` | `Request $request, $user` |
| web | `web/app/Http/Controllers\OrderController.php` | `processDirectOrder()` | `Request $request, $user` |
| web | `web/app/Http/Controllers\OrderController.php` | `checkStock()` | `$productId, $type, $quantity, $productName` |
| web | `web/app/Http/Controllers\OrderController.php` | `decrementStock()` | `$productId, $type, $quantity` |
| web | `web/app/Http/Controllers\OrderController.php` | `checkQuantityLimits()` | `$cartItems` |
| web | `web/app/Http/Controllers\OrderController.php` | `createOrderFullDetail()` | `$order, $user, $address, $totalAmount, $paymentDetails, $rzpOrderId, $rzpPaymentId, $items, $printingMethod = null, $bankCountry = null` |
| web | `web/app/Http/Controllers\OrderController.php` | `createOrderUserAddress()` | `$order, $user, $address` |
| web | `web/app/Http/Controllers\OrderController.php` | `generateOrderId()` | `` |
| web | `web/app/Http/Controllers\OrderController.php` | `success()` | `Request $request` |
| web | `web/app/Http/Controllers\OrderController.php` | `showBankDetails()` | `Request $request` |
| web | `web/app/Http/Controllers\OrderController.php` | `getDetails()` | `$orderId` |
| web | `web/app/Http/Controllers\OrderController.php` | `executePayPalPayment()` | `Request $request` |
| web | `web/app/Http/Controllers\OrderController.php` | `cancelPayPalPayment()` | `` |
| web | `web/app/Http/Controllers\PayPalOrderProcessor.php` | `processPayPalOrder()` | `Request $request, $user` |
| web | `web/app/Http/Controllers\PayPalOrderProcessor.php` | `generateOrderId()` | `` |
| web | `web/app/Http/Controllers\SampleController.php` | `index()` | `` |
| web | `web/app/Http/Controllers\ShopController.php` | `index()` | `Request $request` |
| web | `web/app/Http/Controllers\ShopController.php` | `show()` | `$id` |
| web | `web/app/Http/Controllers\UserAddressController.php` | `store()` | `Request $request` |
| web | `web/app/Http/Controllers\UserAddressController.php` | `update()` | `Request $request, $id` |
| web | `web/app/Http/Controllers\UserAddressController.php` | `setDefault()` | `$id` |
| web | `web/app/Http/Controllers\UserAddressController.php` | `destroy()` | `$id` |

## Controllers Using `request()->all()` 🔴

| App | File | Method |
|-----|------|--------|
| dash | `dash/app/Http/Controllers\BankDetailController.php` | `store()` |
| dash | `dash/app/Http/Controllers\BankDetailController.php` | `update()` |
| dash | `dash/app/Http/Controllers\SamplesController.php` | `store()` |
| dash | `dash/app/Http/Controllers\SamplesController.php` | `update()` |
| web | `web/app/Http/Controllers\AuthController.php` | `register()` |
| web | `web/app/Http/Controllers\CartController.php` | `addToCart()` |
| web | `web/app/Http/Controllers\OrderController.php` | `getDetails()` |
| web | `web/app/Http/Controllers\UserAddressController.php` | `store()` |
| web | `web/app/Http/Controllers\UserAddressController.php` | `update()` |

## Summary

- Methods with validation: 69
- Methods WITHOUT validation: 259
- Methods using `->all()` (mass assignment risk): 9
