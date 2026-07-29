# Application Flows Report

**Generated:** 2026-07-27 15:01:57

Maps request lifecycle: **URL → Route → Middleware → Controller → Method → (Service/Model/Mail) → DB → Response**

---

## Business Process Flows

### 1. Customer Order Placement (Web App)

```
User browses products
  → GET /shop ⇒ ShopController@index ⇒ Product::all()
  → GET /product-details/{id} ⇒ ShopController@show ⇒ Product::find()
  → GET /categories ⇒ CategoriesController@index ⇒ Category::all()
User adds to cart
  → POST /cart/add ⇒ CartController@addToCart ⇒ Cart::create()
  → GET /cart ⇒ CartController@index ⇒ Cart::with('product')
  → PUT /cart/update/{id} ⇒ CartController@updateQuantity
  → DELETE /cart/remove/{id} ⇒ CartController@removeItem
User checks out
  → GET /checkout ⇒ OrderController@checkout (auth)
  → GET /bank-details ⇒ OrderController@showBankDetails
  → POST /order/place ⇒ OrderController@placeOrder
      → Validates request
      → Creates ProductOrder record
      → Creates ProductOrderDetail records
      → Creates ProductOrderUserAddress record
      → Clears cart
      → Mails: OrderSuccess to customer
      → Mails: AdminOrderNotification to admin
  → POST /create-paypal-payment ⇒ OrderController@createPayPalPayment
      → Calls PayPalService::createPayment()
  → GET /paypal/execute ⇒ OrderController@executePayPalPayment
      → Calls PayPalService::executePayment()
  → GET /order/success ⇒ OrderController@success
  → POST /order/upload-proof ⇒ OrderController@uploadPaymentProof
```

### 2. Custom Product Designer Flow (Web App)

```
User browses customizable products
  → GET /api/customproducts ⇒ CustomProductController@index
  → GET /api/customproducts/{id} ⇒ CustomProductController@show
  → GET /api/customproducts/{id}/designer-data ⇒ CustomProductController@getDesignerData
User designs a product
  → POST /api/designs/init ⇒ CustomDesignController@init
      → Creates CustomproductDesign record
  → POST /api/designs/save ⇒ CustomDesignController@store
  → PUT /api/designs/{id} ⇒ CustomDesignController@update
  → POST /api/designs/upload-user-image ⇒ CustomDesignController@uploadUserImage
  → POST /api/designs/export-image ⇒ CustomDesignController@uploadExport
User adds custom product to cart
  → POST /cart/add ⇒ CartController@addToCart
      → Cart record links to customproduct_designs via design_id
User completes order
  → Same as Order Placement flow above
```

### 3. Order Fulfillment Flow (Admin Dashboard)

```
New order received (from web app)
  → Admin views pending orders
  → GET /productOrders ⇒ ProductOrdersController@index
Admin packs order
  → GET /productpacking ⇒ PackingOrderController@index
  → POST /updatestatupacking ⇒ PackingOrderController@updatepacking
      → Updates ProductOrder status to 'packing'
Admin dispatches order
  → GET /productdispatch ⇒ PackingDispatchController@index
  → POST /updatestatusdispatch ⇒ PackingDispatchController@updatedispach
      → Updates ProductOrder status to 'dispatch'
Admin marks delivered
  → GET /productdelivery ⇒ PackingDeliveryController@index
  → POST /updatestatusdelivery ⇒ PackingDeliveryController@updatedelive
      → Updates ProductOrder status to 'delivered'
Order complete
  → GET /productcomplete ⇒ packingCompleteController@index
Admin can also:
  → Assign delivery person: POST /productOrderDeliveryAssign
  → View invoice: GET /viewProductInvoice/{orderId}
  → Process refund: POST /updaterefund
  → Handle returns: GET /productreturn
```

### 4. User Registration & Auth Flow

**Web App (Customer):**
```
  → GET /register ⇒ AuthController@showRegister
  → POST /register ⇒ AuthController@register
      → Creates User record
      → Mails: RegistrationSuccess
  → GET /login ⇒ AuthController@showLogin
  → POST /login ⇒ AuthController@login
  → POST /logout ⇒ AuthController@logout
  → GET /forgot-password ⇒ AuthController@showForgotPassword
  → POST /forgot-password/send-otp ⇒ AuthController@sendOTP
      → Creates OTP record, mails ForgotPasswordOTP
  → POST /forgot-password/verify-otp ⇒ AuthController@verifyOTP
  → POST /forgot-password/reset ⇒ AuthController@resetPassword
```

**Admin Dashboard:**
```
  → Standard Laravel Auth::routes();
  → LoginController (AuthenticatesUsers trait)
  → RegisterController (RegistersUsers trait)
  → ForgotPasswordController (SendsPasswordResetEmails)
  → ResetPasswordController (ResetsPasswords)
  → DashboardUserController for admin user CRUD
```

### 5. Milk Subscription Flow

```
Customer places milk subscription (via web app)
  → Creates MilkOrder record with plan_type
Admin manages:
  → GET /milkOrders ⇒ MilkOrdersController@index
  → POST /milkOrderDeliveryAssign ⇒ assign delivery person
  → POST /getAreaAssignedDelvieryPerson/{areaId}
  → GET /milkOrders/{orderId} ⇒ MilkSlotController@getMilkSlots
  → POST /createMilkSubscription ⇒ ProductController@createMilkSubscription
  → POST /createMilkSlot ⇒ ProductController@createMilkSlot
  → POST /cancelMilkSlot ⇒ MilkSlotController@cancelMilkSlot
Milk Refunds:
  → GET /milkRefunds ⇒ MilkRefundController@index
  → POST /getMilkRefundDatas ⇒ get refund data
  → POST /refundMilkSlot ⇒ process refund
```

### 6. Inventory & Stock Management Flow

```
Admin views stock:
  → GET /stocks ⇒ StockController@index
  → GET /lowstock ⇒ StockController@lowstock (low stock alerts)
  → GET /highselling ⇒ StockController@highselling (top sellers)
  → GET /combostock ⇒ CompoStockController@index
Stock operations:
  → POST /reduceStock ⇒ StockController@reduceStock
  → POST /reduceStock1 ⇒ CompoStockController@reduceStock1
  → POST /updateStack ⇒ StockController@update1
Database tables: product_stocks, products, product_varients
```

### 7. Reports & Analytics Flow

```
Income Reports:
  → GET /incomeReports ⇒ ReportsController@incomeReports
  → POST /getIncomeReports ⇒ ReportsController@getIncomeReports
Order-wise Reports:
  → GET /orderwisereport ⇒ OrderController@orderwisereport
  → GET /order-wise-report/filter ⇒ OrderController@filterorderWiseReport
  → GET /oreport/export/excel ⇒ OrderReportExport (Excel)
  → GET /oreport/export/pdf ⇒ PDF export
Top Customers:
  → GET /topcustomer ⇒ TopCustomerController@index
```

---

## Request Flow Maps

### Admin Dashboard (dash/)

| Method | URL | Middleware | Controller@Method | Models Used | Services/Mail | DB Ops |
|--------|-----|-----------|-------------------|-------------|---------------|--------|
| POST | `/approverequest` | auth | `ProductSlotController@approverequest` |  |  | DB query/update, DB read |
| POST | `/bank-details/destroy/{id}` | auth | `BankDetailController@destroy` | BankDetail |  | DB query/update |
| POST | `/bank-details/update/{id}` | auth | `BankDetailController@update` | BankDetail |  | DB query/update, DB read |
| GET | `/bank-details` | auth | `BankDetailController@index` | BankDetail |  | DB read |
| POST | `/bank-details` | auth | `BankDetailController@store` | BankDetail |  | DB read |
| GET | `/currency-test` | auth | `CurrencyController@index` |  |  |  |
| GET | `/currency/convert` | auth | `CurrencyController@convert` |  |  |  |
| GET | `/currency/switch/{currency}` | auth | `CurrencyController@switchCurrencyByGet` |  |  |  |
| POST | `/currency/switch` | auth | `CurrencyController@switchCurrency` |  |  |  |
| GET | `/custom-products/designer-data/{id}` | auth | `CustomProductController@getDesignerData` | CustomProduct |  | DB read |
| DELETE | `/custom-products/destroy/{id}` | auth | `CustomProductController@destroy` | CustomProduct |  | DB query/update, DB read |
| POST | `/custom-products/duplicate/{id}` | auth | `CustomProductController@duplicate` | CustomProduct |  | DB query/update, DB read |
| GET | `/custom-products/edit/{id}` | auth | `CustomProductController@edit` | CustomProduct |  | DB read |
| POST | `/custom-products/store` | auth | `CustomProductController@store` | CustomProduct, ProductColor, ProductColorImage |  | DB query/update, DB read |
| POST | `/custom-products/update/{id}` | auth | `CustomProductController@update` | CustomProduct, ProductColor, ProductColorImage |  | DB query/update, DB read |
| GET | `/custom-products` | auth | `CustomProductController@index` | CustomProduct |  | DB read |
| POST | `/destroyshipping/{id}` | auth | `ShippingController@destroyshipping` | Shipping |  | DB query/update, DB read |
| GET | `/get-address-details1` | auth | `UserController@getAddressDetails1` | AllIndiaPincode, City, State |  | DB read |
| GET | `/get-address-details` | auth | `UserController@getAddressDetails` | AllIndiaPincode, City, State |  | DB read |
| GET | `/getproductsbycategory/{id}` | auth | `NotificationController@getProductsByCategory` | Product |  | DB read |
| GET | `/getthump/{productid}` | auth | `ProductController@getthump` | Product, ProductChildImage |  | DB read |
| POST | `/insertshipping` | auth | `ShippingController@addshipping` | Shipping |  | DB query/update |
| GET | `/invoice/{orderId}` | auth | `OrderController@showInvoice` | ProductSlot |  | DB query/update, DB read |
| GET | `/logout` | auth | `LoginController@logout` |  |  |  |
| GET | `/order-assets/file` | auth | `OrderAssetsController@downloadFile` |  |  |  |
| GET | `/order-assets/zip/{orderId}` | auth | `OrderAssetsController@downloadZip` | ProductOrder, ProductSlot |  | DB query/update, DB read |
| GET | `/order-wise-report/filter` | auth | `OrderController@filterorderWiseReport` |  |  |  |
| POST | `/orders/fetchtotalorders` | auth | `ProductOrdersController@fetchTotalOrders` | ProductOrder |  |  |
| GET | `/orderwisereport` | auth | `OrderController@orderwisereport` |  |  |  |
| GET | `/oreport/export/excel` | auth | `OrderController@exportExcel` |  | OrderReportExport, Excel |  |
| GET | `/oreport/export/pdf` | auth | `OrderController@exportPDF` |  |  |  |
| POST | `/reject-return-request` | auth | `ProductSlotController@rejectReturnRequests` |  |  | DB query/update, DB read |
| POST | `/settings/checkout/update` | auth | `AppSettingsController@updateCheckoutSettings` |  |  | DB query/update |
| POST | `/settings/size-chart/update` | auth | `AppSettingsController@updateSizeChart` | SizeChart |  | DB query/update, DB read |
| POST | `/settings/update` | auth | `AppSettingsController@update` | AppSetting |  | DB query/update, DB read |
| GET | `/settings` | auth | `AppSettingsController@index` | AppSetting, SizeChart |  | DB query/update, DB read |
| GET | `/shipping` | auth | `ShippingController@getship` | Shipping |  | DB read |
| POST | `/update-password/{id}` | auth | `HomeController@updatePassword` |  |  |  |
| POST | `/update-profile` | auth | `HomeController@updateProfile` | User |  | DB query/update, DB read |
| POST | `/updateship` | auth | `ShippingController@updateship` | Shipping |  | DB query/update, DB read |
| GET | `/` | auth | `HomeController@root` | Area, BannerImage, Category, DeliveryPerson, MilkOrder, Product, ProductOrder, ProductRefund, User |  | DB query/update, DB read |
| GET | `/Getcitys/{custid}` | auth | `UserController@Getcity` | City |  | DB read |
| GET | `/Getproduct/{custid}` | auth | `ProductVarientControllet@Getproduct` | Product |  | DB read |
| GET | `/Getsubcategory/{custid}` | auth | `ProductVarientControllet@Getsubcategory` | Product |  | DB read |
| POST | `/ThumImages` | auth | `ProductThumController@ThumImages` | Product, ProductChildImage |  | DB read |
| POST | `/addaddressvalue` | auth | `UserController@addaddressvalue` | User, UserAddress |  | DB read |
| POST | `/addproductvarient` | auth | `ProductVarientControllet@addproductvarient` | Category, Product, ProductChildImage, ProductVarient, SubCategory |  | DB query/update, DB read |
| GET | `/all-samples` | auth | `SamplesController@index` | Sample |  | DB read |
| POST | `/all-samples` | auth | `SamplesController@store` | Sample |  | DB read |
| GET | `/areas` | auth | `AreaController@index` | Area |  | DB read |
| POST | `/areas` | auth | `AreaController@store` | Area |  | DB read |
| POST | `/assignDeliveryPerson` | auth | `AreaAssignController@assignDeliveryPerson` | Area, AreaAssign |  | DB read |
| GET | `/bannerImages` | auth | `BannerImagesController@index` | BannerImage |  | DB read |
| POST | `/bannerImages` | auth | `BannerImagesController@store` | BannerImage |  | DB read |
| POST | `/bannerwebImages` | auth | `BannerImagesController@addbanner` | BannerImage |  | DB read |
| POST | `/bulk-orders/update-status` | auth | `BulkOrderController@updateStatus` | BulkOrder | BulkOrderApproved, BulkOrderRejected, Mail | DB query/update, DB read |
| GET | `/bulk-orders` | auth | `BulkOrderController@index` | BulkOrder |  | DB read |
| POST | `/cancelMilkSlot` | auth | `MilkSlotController@cancelMilkSlot` | MilkRefund, MilkSlot |  | DB query/update, DB read |
| POST | `/cancelProductSlot` | auth | `ProductSlotController@cancelProductSlot` | ProductOrder, ProductRefund, ProductSlot, ProductVarient |  | DB query/update, DB read |
| POST | `/cancelProductrequ` | auth | `CancelProductController@cancelProductrequ` | ProductOrder, ProductRefund, ProductSlot, ProductVarient |  | DB query/update, DB read |
| GET | `/cancelproduct` | auth | `CancelProductController@index` | ProductSlot |  | DB read |
| POST | `/cancelproduct` | auth | `CancelProductController@store` |  |  |  |
| GET | `/cancelrequests` | auth | `ProductSlotController@cancelrequests` |  |  | DB query/update, DB read |
| GET | `/categories` | auth | `CategoryController@index` | Category |  | DB read |
| POST | `/categories` | auth | `CategoryController@store` | Category |  | DB read |
| POST | `/checkAreaValidation` | auth | `AreaController@checkAreaValidation` | Area |  |  |
| POST | `/collectreturn` | auth | `ProductReturnController@updateed` | ProductOrder, ProductTracking |  | DB query/update, DB read |
| POST | `/collectstatusdelivery` | auth | `PackingDeliveryController@collectdelive` | ProductOrder, ProductTracking |  | DB query/update, DB read |
| GET | `/combostock` | auth | `CompoStockController@index` | ProductStock |  | DB read |
| GET | `/coupons` | auth | `CouponController@index` | Coupon |  | DB read |
| POST | `/coupons` | auth | `CouponController@addcoupon` | Coupon |  | DB read |
| POST | `/createMilkSlot` | auth | `ProductController@createMilkSlot` | MilkOrder, MilkSlot |  | DB query/update, DB read |
| POST | `/createMilkSubscription` | auth | `ProductController@createMilkSubscription` | MilkOrder, MilkSlot, MilkTransactionLog, Product, User |  | DB read |
| POST | `/createProductSlot` | auth | `ProductController@createProductSlot` | Product, ProductOrder, ProductSlot, ProductStock, ProductTransactionLog, ProductVarient |  | DB query/update, DB read |
| POST | `/createProductSubscription` | auth | `ProductController@createProductSubscription` | Product, ProductOrder, ProductSlot, User |  | DB read |
| GET | `/customers/{customerId}` | auth | `UserController@edit` | Area, GenderType, User |  | DB read |
| GET | `/customers` | auth | `UserController@index` | Category, City, Product, State, User |  | DB read |
| POST | `/customers` | auth | `UserController@store` | User, UserAddress |  | DB query/update, DB read |
| POST | `/deleteAreaDeliveryPartners/{areaId}` | auth | `AreaAssignController@deleteAreaDeliveryPartners` | Area, AreaAssign, DeliveryPerson |  | DB read |
| POST | `/deleteDeliveryPerson` | auth | `AreaAssignController@deleteDeliveryPerson` | Area, AreaAssign |  | DB read |
| GET | `/deliveryPersons` | auth | `DeliveryPersonController@index` | DeliveryPerson |  | DB read |
| POST | `/deliveryPersons` | auth | `DeliveryPersonController@store` | DeliveryPerson |  | DB read |
| GET | `/designs` | auth | `DesignsController@index` | Design |  | DB read |
| POST | `/designs` | auth | `DesignsController@store` | Design |  | DB read |
| POST | `/destroyArea/{id}` | auth | `AreaController@destroy` | Area |  | DB read |
| POST | `/destroyBannerImages/{id}` | auth | `BannerImagesController@destroy` | BannerImage |  | DB query/update, DB read |
| POST | `/destroyCategories/{id}` | auth | `CategoryController@destroy` | Category |  | DB query/update, DB read |
| POST | `/destroyDeliveryPerson/{id}` | auth | `DeliveryPersonController@destroy` | DeliveryPerson |  | DB query/update, DB read |
| POST | `/destroyDesigns/{id}` | auth | `DesignsController@destroy` | Design |  | DB query/update, DB read |
| POST | `/destroyOfferImages/{id}` | auth | `OfferImageController@destroy` | OfferImage |  | DB query/update, DB read |
| POST | `/destroyProducts/{id}` | auth | `ProductController@destroy` | Product, ProductVerient |  | DB query/update, DB read |
| POST | `/destroySamples/{id}` | auth | `SamplesController@destroy` | Sample |  | DB query/update, DB read |
| POST | `/destroySubCategories/{id}` | auth | `SubCategoryController@destroy` | Category, SubCategory |  | DB query/update, DB read |
| POST | `/destroyThumpImages/{id}` | auth | `ProductThumController@destroy` | Product, ProductChildImage |  | DB query/update, DB read |
| POST | `/destroyUser/{userId}` | auth | `UserController@destroy` | User, UserAddress |  | DB read |
| POST | `/destroyVarientThumpImages/{id}` | auth | `ProductController@destroyVarientThumpImages` | Product, ProductChildImage |  | DB read |
| POST | `/destroycoupon/{id}` | auth | `CouponController@destroy` | Coupon |  | DB read |
| POST | `/destroynotifi/{id}` | auth | `NotificationController@destroy` | Notification |  | DB read |
| POST | `/destroytodaydeals/{id}` | auth | `TodayDealsController@destroy` | TodayDeals |  | DB query/update, DB read |
| POST | `/destroyusers/{id}` | auth | `DashboardUserController@destroy` | DashboardUser |  | DB read |
| POST | `/destroyvarient/{id}` | auth | `ProductVarientControllet@destroy` | Product, ProductVarient |  | DB query/update, DB read |
| POST | `/destroywebBannerImages/{id}` | auth | `BannerImagesController@destroyweb` | BannerImage |  | DB query/update, DB read |
| GET | `/export/commercial-invoice` | auth | `ProductController@exportCommercialInvoice` | Product, ProductOrder, ProductSlot, User |  | DB query/update, DB read |
| GET | `/export/get-form-data/{orderId?}` | auth | `ProductController@getExportFormData` |  |  | DB read |
| GET | `/export/order-products/{orderId?}` | auth | `ProductController@getOrderProductsForExport` | Product, ProductOrder, ProductSlot |  | DB query/update, DB read |
| GET | `/export/packing-list` | auth | `ProductController@exportPackingList` | Product, ProductOrder, ProductSlot, User |  | DB query/update, DB read |
| POST | `/export/save-form-data` | auth | `ProductController@saveExportFormData` |  |  |  |
| POST | `/fetchAreaDeliveryPartners/{areaId}` | auth | `AreaAssignController@fetchAreaDeliveryPartners` | DeliveryPerson |  | DB read |
| POST | `/getAreaAssignedDelvieryPerson/{areaId}` | auth | `MilkOrdersController@getAreaAssignedDelvieryPerson` | AreaAssign |  | DB read |
| POST | `/getIncomeReports` | auth | `ReportsController@getIncomeReports` | MilkOrder, ProductOrder |  | DB read |
| POST | `/getMilkRefundDatas` | auth | `MilkRefundController@getRefundDatas` | MilkRefund, MilkSlot |  | DB read |
| POST | `/getPincodeAreas` | auth | `AreaController@getPincodeAreas` | AllIndiaPincode |  | DB read |
| POST | `/getProductDetail` | auth | `ProductController@getProductDetail` | Product |  |  |
| POST | `/getProductRefundDatas` | auth | `ProductRefundController@getRefundDatas` | ProductRefund |  | DB read |
| POST | `/getProductsOptions` | auth | `UserController@getProductsOptions` | Product |  | DB read |
| POST | `/getProductsverentOptions` | auth | `UserController@getProductsverentOptions` | Product, ProductVarient |  | DB read |
| POST | `/getProductsverentqty` | auth | `UserController@getProductsverentqty` | Product, ProductVarient |  | DB read |
| POST | `/getcustomersummery` | auth | `UserController@getcustomersummery` | User |  | DB read |
| POST | `/getoversummery` | auth | `OrderSummeryController@getoversummery` | ProductOrder |  | DB read |
| POST | `/getproductfilter` | auth | `ProductController@getproductfilter` | Product |  | DB read |
| POST | `/getproductverfilter` | auth | `ProductVarientControllet@getproductverfilter` | Product, ProductVarient |  | DB query/update, DB read |
| GET | `/getsubcategory/{id}` | auth | `ProductController@Getsubproo` | Category, SubCategory |  | DB read |
| GET | `/highselling` | auth | `StockController@highselling` | Product, ProductStock |  | DB read |
| GET | `/incomeReports` | auth | `ReportsController@incomeReports` | MilkOrder |  | DB read |
| GET | `/index/{locale}` | auth | `HomeController@lang` |  |  |  |
| GET | `/lang/{locale}` | auth | `HomeController@lang` |  |  |  |
| GET | `/lowstock` | auth | `StockController@lowstock` | Product, ProductStock |  | DB query/update, DB read |
| POST | `/milkOrderDeliveryAssign` | auth | `MilkOrdersController@milkOrderDeliveryAssign` | MilkOrder, MilkSlot |  | DB query/update, DB read |
| GET | `/milkOrders/{orderId}` | auth | `MilkSlotController@getMilkSlots` | MilkSlot |  | DB read |
| GET | `/milkOrders` | auth | `MilkOrdersController@index` | MilkOrder |  | DB read |
| POST | `/milkOrders` | auth | `MilkOrdersController@store` |  |  |  |
| GET | `/milkRefunds` | auth | `MilkRefundController@index` | MilkRefund |  | DB read |
| POST | `/milkRefunds` | auth | `MilkRefundController@store` |  |  |  |
| POST | `/offerImagess` | auth | `OfferImageController@offerImagess` | OfferImage |  | DB read |
| GET | `/offerImages` | auth | `OfferImageController@index` | OfferImage |  | DB read |
| POST | `/offerImages` | auth | `OfferImageController@store` |  |  |  |
| GET | `/ordersummerys/{orderId}` | auth | `ProductSlotController@getProductSlotss` | ProductSlot |  | DB read |
| GET | `/ordersummery` | auth | `OrderSummeryController@index` | ProductOrder |  | DB read |
| POST | `/pickupstatus` | auth | `ProductController@pickupstatus` | Product, ProductOrder |  | DB query/update, DB read |
| POST | `/productImageUpload` | auth | `ProductController@productImageUpload` | Product |  |  |
| POST | `/productOrderDeliveryAssign` | auth | `ProductOrdersController@productOrderDeliveryAssign` | ProductOrder, ProductSlot |  | DB query/update, DB read |
| GET | `/productOrders/{orderId}` | auth | `ProductSlotController@getProductSlots` | ProductSlot |  | DB read |
| GET | `/productOrders` | auth | `ProductOrdersController@index` | ProductOrder |  | DB read |
| POST | `/productOrders` | auth | `ProductOrdersController@store` |  |  |  |
| GET | `/productRefunds` | auth | `ProductRefundController@index` | ProductRefund |  | DB read |
| POST | `/productRefunds` | auth | `ProductRefundController@store` |  |  |  |
| GET | `/productcomplete` | auth | `packingCompleteController@index` | ProductOrder |  | DB read |
| GET | `/productdelivery` | auth | `PackingDeliveryController@index` | ProductOrder |  | DB read |
| GET | `/productdispatch` | auth | `PackingDispatchController@index` | ProductOrder |  | DB read |
| GET | `/productpacking` | auth | `PackingOrderController@index` | ProductOrder |  | DB read |
| GET | `/productreturn` | auth | `ProductReturnController@index` | ProductOrder |  | DB read |
| GET | `/products` | auth | `ProductController@index` | Category, Product, SubCategory |  | DB read |
| POST | `/products` | auth | `ProductController@store` | Category, Product, ProductChildImage, ProductVarient, SubCategory |  | DB query/update, DB read |
| GET | `/productthump` | auth | `ProductThumController@index` | Product, ProductChildImage |  | DB read |
| POST | `/productthump` | auth | `ProductThumController@store` |  |  |  |
| GET | `/productvarient` | auth | `ProductVarientControllet@index` | Category, Product, ProductVarient, SubCategory |  | DB read |
| POST | `/productvarient` | auth | `ProductVarientControllet@store` |  |  |  |
| POST | `/reduceStock1` | auth | `CompoStockController@reduceStock1` | ProductStock, ProductVarient |  | DB read |
| POST | `/reduceStock` | auth | `StockController@reduceStock` | Product, ProductStock, ProductVarient |  | DB query/update, DB read |
| POST | `/refundMilkSlot` | auth | `MilkRefundController@refundMilkSlot` | MilkRefund |  | DB read |
| POST | `/refundProductSlot` | auth | `ProductRefundController@refundProductSlot` | ProductRefund |  | DB read |
| GET | `/returnrequests` | auth | `ProductSlotController@returnrequests` |  |  | DB query/update, DB read |
| POST | `/reviews` | auth | `NotificationController@notifications` | AppNotification, Notification |  | DB read |
| GET | `/review` | auth | `NotificationController@index` | Category, Notification, Product |  | DB read |
| POST | `/review` | auth | `NotificationController@store` |  |  |  |
| GET | `/stocks` | auth | `StockController@index` | Product, ProductStock |  | DB read |
| POST | `/stocks` | auth | `StockController@store` |  |  |  |
| GET | `/subcategories` | auth | `SubCategoryController@index` | Category, SubCategory |  | DB read |
| POST | `/subcategories` | auth | `SubCategoryController@store` | Category, SubCategory |  | DB read |
| GET | `/todaydeals` | auth | `TodayDealsController@index` | Product, ProductVarient, TodayDeals |  | DB read |
| POST | `/todaydeals` | auth | `TodayDealsController@store` | Product, ProductVarient, TodayDeals |  | DB read |
| GET | `/topcustomer` | auth | `TopCustomerController@index` | ProductOrder |  | DB read |
| POST | `/updateArea/{id}` | auth | `AreaController@update` | Area |  | DB query/update, DB read |
| POST | `/updateBannerImages/{id}` | auth | `BannerImagesController@update` | BannerImage |  | DB query/update, DB read |
| POST | `/updateCategories/{id}` | auth | `CategoryController@update` | Category |  | DB query/update, DB read |
| POST | `/updateDeliveryPerson/{id}` | auth | `DeliveryPersonController@update` | DeliveryPerson |  | DB query/update, DB read |
| POST | `/updateDesigns/{id}` | auth | `DesignsController@update` | Design |  | DB query/update, DB read |
| POST | `/updateOfferImages/{id}` | auth | `OfferImageController@update` | OfferImage |  | DB query/update, DB read |
| POST | `/updateOrder` | auth | `BannerImagesController@updateOrder` | BannerImage |  |  |
| POST | `/updatePasss/{userId}` | auth | `UserController@updatePass` | User |  | DB query/update, DB read |
| POST | `/updateProducts/{id}` | auth | `ProductController@update` | Category, Product |  | DB query/update, DB read |
| POST | `/updateProductsvarient/{id}` | auth | `ProductVarientControllet@update` | Category, Product, ProductChildImage, ProductVarient |  | DB query/update, DB read |
| POST | `/updateSamples/{id}` | auth | `SamplesController@update` | Sample |  | DB query/update, DB read |
| POST | `/updateStack1` | auth | `CompoStockController@update` | ProductStock, ProductVarient |  | DB read |
| POST | `/updateStack` | auth | `StockController@update1` | Product, ProductStock, ProductVarient |  | DB read |
| POST | `/updateSubCategories/{id}` | auth | `SubCategoryController@update` | Category, SubCategory |  | DB query/update, DB read |
| POST | `/updateUser/{userId}` | auth | `UserController@update` | User, UserAddress |  | DB query/update, DB read |
| POST | `/updatecoupon/{id}` | auth | `CouponController@update` | Coupon |  | DB query/update, DB read |
| POST | `/updatenotifi/{id}` | auth | `NotificationController@update` | AppNotification, Notification |  | DB query/update, DB read |
| POST | `/updatepass/{id}` | auth | `DashboardUserController@update1` | DashboardUser |  | DB query/update, DB read |
| POST | `/updaterefund1` | auth | `PackingOrderController@updaterefund1` | ProductOrder, ProductRefund |  | DB query/update, DB read |
| POST | `/updaterefund2` | auth | `PackingDispatchController@updaterefund2` | ProductOrder, ProductRefund |  | DB query/update, DB read |
| POST | `/updaterefund` | auth | `ProductController@updaterefund` | Product, ProductOrder, ProductRefund |  | DB query/update, DB read |
| POST | `/updatereturnpro` | auth | `ProductReturnController@update` | ProductOrder, ProductTracking |  | DB query/update, DB read |
| POST | `/updatestatupacking` | auth | `PackingOrderController@updatepacking` | ProductOrder, ProductTracking | OrderStatusUpdated, Mail | DB query/update, DB read |
| POST | `/updatestatusdelivery` | auth | `PackingDeliveryController@updatedelive` | ProductOrder, ProductTracking | OrderStatusUpdated, Mail | DB query/update, DB read |
| POST | `/updatestatusdispatch` | auth | `PackingDispatchController@updatedispach` | ProductOrder, ProductTracking | OrderStatusUpdated, Mail | DB query/update, DB read |
| POST | `/updatestatus` | auth | `ProductController@upadetstatus` | Product, ProductOrder | Mail, OrderStatusUpdated | DB query/update, DB read |
| POST | `/updatethumImages/{id}` | auth | `ProductThumController@update` | Product, ProductChildImage |  | DB query/update, DB read |
| POST | `/updatetodaydeals/{id}` | auth | `TodayDealsController@update` | Product, ProductVarient, TodayDeals |  | DB query/update, DB read |
| POST | `/updateuser/{id}` | auth | `DashboardUserController@update` | DashboardUser |  | DB query/update, DB read |
| POST | `/updatewebBannerImages/{id}` | auth | `BannerImagesController@updateimage` | BannerImage |  | DB query/update, DB read |
| POST | `/userss` | auth | `DashboardUserController@userss` | DashboardUser |  | DB read |
| GET | `/users` | auth | `DashboardUserController@index` | DashboardUser |  | DB read |
| POST | `/users` | auth | `DashboardUserController@store` |  |  |  |
| POST | `/validateCategoryName` | auth | `CategoryController@validateCategoryName` |  |  |  |
| POST | `/validateSubCategoryName` | auth | `SubCategoryController@validateSubCategoryName` |  |  |  |
| GET | `/viewProductInvoice/{orderId?}` | auth | `ProductController@viewProductInvoice` | Product, ProductOrder, ProductSlot |  | DB query/update, DB read |
| GET | `/viewProductdetail/{orderId?}` | auth | `ProductController@viewProductInvoice` | Product, ProductOrder, ProductSlot |  | DB query/update, DB read |
| GET | `/viewProducts` | auth | `ProductOrdersController@index` | ProductOrder |  | DB read |
| GET | `/{any}` | auth | `HomeController@index` |  |  |  |

### Customer Web App (web/)

| Method | URL | Middleware | Controller@Method | Models Used | Services/Mail | DB Ops |
|--------|-----|-----------|-------------------|-------------|---------------|--------|
| GET | `/about` | web | `@` |  |  |  |
| POST | `/addresses/{id}/set-default` | auth | `UserAddressController@setDefault` | UserAddress, User |  | DB query/update |
| DELETE | `/addresses/{id}` | auth | `UserAddressController@destroy` | UserAddress, User |  | DB query/update |
| PUT | `/addresses/{id}` | auth | `UserAddressController@update` | UserAddress, User |  | DB query/update, DB read |
| POST | `/addresses` | auth | `UserAddressController@store` | UserAddress, User |  | DB query/update, DB read |
| GET | `/bank-details` | auth | `OrderController@showBankDetails` | ProductOrder, SampleOrderFullDetail, BankDetails |  | DB read |
| GET | `/bulk-order` | web | `BulkOrderController@index` | Design, CustomproductDesign, AppSetting |  | DB read |
| POST | `/bulk-order` | web | `BulkOrderController@store` | BulkOrder, Design, CustomproductDesign, AppSetting | BulkOrderInquiryMail, BulkOrderUserMail, Mail | DB read |
| POST | `/cart/add` | web | `CartController@addToCart` | Cart, Sample |  | DB query/update, DB read |
| DELETE | `/cart/remove/{id}` | web | `CartController@removeItem` | Cart |  | DB query/update |
| PUT | `/cart/update/{id}` | web | `CartController@updateQuantity` | Cart, Sample |  | DB query/update, DB read |
| GET | `/cart` | web | `CartController@index` | Cart |  | DB query/update, DB read |
| GET | `/categories` | web | `CategoriesController@index` | Category, SubCategory |  | DB read |
| POST | `/change-password` | auth | `AccountController@changePassword` |  |  | DB query/update |
| GET | `/checkout` | auth | `OrderController@checkout` | Cart, UserAddress, BankDetails |  | DB query/update, DB read |
| POST | `/contact/submit` | web | `ContactController@store` | ContactMessage |  |  |
| GET | `/contact` | web | `@` |  |  |  |
| POST | `/create-paypal-payment` | auth | `OrderController@createPayPalPayment` | Cart | PayPalService, CurrencyService | DB read |
| POST | `/create-razorpay-order` | auth | `OrderController@createRazorpayOrder` | Cart |  | DB query/update, DB read |
| GET | `/currency-test` | web | `CurrencyController@index` |  |  |  |
| GET | `/currency/convert` | web | `CurrencyController@convert` |  |  |  |
| GET | `/currency/switch/{currency}` | web | `CurrencyController@switchCurrencyByGet` |  |  |  |
| POST | `/currency/switch` | web | `CurrencyController@switchCurrency` |  |  |  |
| GET | `/customize-products` | web | `CustomProductController@picker` | Customproduct |  | DB read |
| GET | `/customize/{product_id}` | web | `@` |  |  |  |
| GET | `/customproducts/{id}/designer-data-v2` | web | `CustomProductController@getDesignerDataFixed` | Customproduct |  | DB read |
| GET | `/customproducts/{id}/designer-data` | web | `CustomProductController@getDesignerData` |  |  |  |
| GET | `/customproducts/{id}` | web | `CustomProductController@show` | Customproduct |  | DB read |
| GET | `/customproducts` | web | `CustomProductController@index` | Customproduct |  | DB read |
| POST | `/designs/export-image` | web | `CustomDesignController@uploadExport` |  |  |  |
| POST | `/designs/init` | web | `CustomDesignController@init` | Customproduct, CustomproductDesign |  |  |
| GET | `/designs/my/all` | auth | `CustomDesignController@myDesigns` | Customproduct, CustomproductDesign |  | DB read |
| POST | `/designs/save` | web | `CustomDesignController@store` | Customproduct, CustomproductDesign, DesignLayer |  | DB query/update |
| POST | `/designs/upload-user-image` | web | `CustomDesignController@uploadUserImage` |  |  |  |
| DELETE | `/designs/{id}` | auth | `CustomDesignController@destroy` | Customproduct, CustomproductDesign |  | DB query/update, DB read |
| GET | `/designs/{id}` | web | `CustomDesignController@show` | Customproduct, CustomproductDesign |  | DB query/update, DB read |
| PUT | `/designs/{id}` | web | `CustomDesignController@update` | Customproduct, CustomproductDesign, DesignLayer |  | DB query/update |
| GET | `/design` | web | `@` |  |  |  |
| POST | `/forgot-password/reset` | web | `AuthController@resetPassword` | User |  | DB query/update, DB read |
| POST | `/forgot-password/send-otp` | web | `AuthController@sendOTP` | User | ForgotPasswordOTP, Mail | DB query/update, DB read |
| POST | `/forgot-password/verify-otp` | web | `AuthController@verifyOTP` | User |  | DB read |
| GET | `/forgot-password` | guest | `AuthController@showForgotPassword` |  |  |  |
| GET | `/home` | web | `HomeController@index` | BannerImage |  | DB read |
| GET | `/lang/{locale}` | web | `LanguageController@switch` |  |  |  |
| GET | `/login` | guest | `AuthController@showLogin` |  |  |  |
| POST | `/login` | guest | `AuthController@login` |  |  |  |
| POST | `/logout` | web | `AuthController@logout` |  |  |  |
| GET | `/my-designs` | web | `CustomDesignController@myDesigns` | Customproduct, CustomproductDesign |  | DB read |
| GET | `/myaccount` | auth | `AccountController@index` |  |  | DB read |
| GET | `/order-assets/file` | auth | `OrderAssetsController@downloadFile` |  |  |  |
| GET | `/order-assets/zip/{orderId}` | auth | `OrderAssetsController@downloadZip` | ProductOrder |  | DB query/update, DB read |
| GET | `/order/details/{orderId}` | auth | `OrderController@getDetails` | ProductOrder, SampleOrderFullDetail, BankDetails |  | DB read |
| POST | `/order/place` | auth | `OrderController@placeOrder` | Cart |  |  |
| GET | `/order/success` | auth | `OrderController@success` | ProductOrder, SampleOrderFullDetail |  | DB read |
| POST | `/order/upload-proof` | auth | `OrderController@uploadPaymentProof` | ProductOrder |  | DB query/update, DB read |
| GET | `/own-design` | web | `DesignController@index` | Design |  | DB read |
| GET | `/paypal/cancel` | auth | `OrderController@cancelPayPalPayment` |  |  |  |
| GET | `/paypal/execute` | auth | `OrderController@executePayPalPayment` |  |  |  |
| GET | `/privacy-policy` | web | `@` |  |  |  |
| GET | `/product-details/{id}` | web | `ShopController@show` | Product |  | DB read |
| GET | `/proxy-image` | web | `@` |  |  |  |
| GET | `/refund-policy` | web | `@` |  |  |  |
| GET | `/register` | guest | `AuthController@showRegister` |  |  |  |
| POST | `/register` | guest | `AuthController@register` | User, UserAddress | RegistrationSuccess, Mail | DB read |
| GET | `/sample` | web | `SampleController@index` | Sample, SizeChart |  | DB read |
| GET | `/shipping-policy` | web | `@` |  |  |  |
| GET | `/shop` | web | `ShopController@index` | Product, Category |  | DB query/update, DB read |
| GET | `/terms-and-conditions` | web | `@` |  |  |  |
| POST | `/update-profile` | auth | `AccountController@updateProfile` |  |  | DB query/update |
| GET | `/wishlist` | web | `@` |  |  |  |
| GET | `/` | web | `HomeController@index` | BannerImage |  | DB read |
| PREFIX | `/api` | web | `@` |  |  |  |

---

## Architecture Overview

### Two-App Architecture

```
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
```

### Database Sharing

Both apps share the same MySQL database `saaluvesa_db`. Tables used by:

- **Both apps**: users, user_addresses, categories, sub_categories, products, product_varients, product_colors, product_color_images, carts, product_orders, product_order_user_addresses, product_stocks, designs, customproducts, customproduct_designs, banners, bulk_orders, app_settings, bank_details, exchange_rates, samples
- **Admin only**: dashboard_users, milk_orders, milk_slots, milk_refunds, product_trackings, product_refunds, product_transaction_logs, order_export_data, invoices, shipping, areas, area_assigns, delivery_people, coupons, offer_images, notifications, app_alerts, app_notifications, otps, mail_otps, today_deals, address_types, gender_types, plan_types
- **Web only**: contact_messages, design_layers, sample_order_full_details, checkout_settings, size_charts

### Key Middleware Chain

| Middleware | App | Purpose |
|-----------|-----|---------|
| `auth` | both | Ensures user is authenticated |
| `guest` | web | Redirects authenticated users away from login/register |
| `web` | both | Standard web middleware group (sessions, cookies, CSRF) |
| `SetLocale` | web | Sets app locale based on session/URL |
| `SetCurrency` | both | Sets active currency from session |
| `Localization` | dash | Localization middleware |
