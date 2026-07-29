# Full File & Function Audit Report

**Generated:** 2026-07-27 14:00:53

**Project:** Saaluvesa Enterprises Private Limited

---

## Application: Admin Dashboard (dash/)

### AJAX

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/resources/views\ajaxPages\area_names.blade.php` | Blade View | [Admin] Blade template: area_names.blade.php | — |
| `dash/resources/views\ajaxPages\assignedDeliveryPersons.blade.php` | Blade View | [Admin] Blade template: assignedDeliveryPersons.blade.php | — |
| `dash/resources/views\ajaxPages\delivery_option.blade.php` | Blade View | [Admin] Blade template: delivery_option.blade.php | — |
| `dash/resources/views\ajaxPages\milk_order_delivery_person.blade.php` | Blade View | [Admin] Blade template: milk_order_delivery_person.blade.php | — |
| `dash/resources/views\ajaxPages\product_options.blade.php` | Blade View | [Admin] Blade template: product_options.blade.php | — |
| `dash/resources/views\ajaxPages\productvar_options.blade.php` | Blade View | [Admin] Blade template: productvar_options.blade.php | — |
| `dash/resources/views\ajaxPages\productvar_qty.blade.php` | Blade View | [Admin] Blade template: productvar_qty.blade.php | — |
| `dash/resources/views\ajaxPages\render_income_report.blade.php` | Blade View | [Admin] Blade template: render_income_report.blade.php | — |

### Auth

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\Auth\ConfirmPasswordController.php` | Controller | [Admin] HTTP controller for Auth features | `__construct()` — Constructor: initializes class dependencies |
| `dash/app\Http\Controllers\Auth\ForgotPasswordController.php` | Controller | [Admin] HTTP controller for Auth features | `showLinkRequestForm [Trait]()` — Inherited from trait: showLinkRequestForm<br>`sendResetLinkEmail [Trait]()` — Inherited from trait: sendResetLinkEmail<br>`sendResetLinkResponse [Trait]()` — Inherited from trait: sendResetLinkResponse<br>`sendResetLinkFailedResponse [Trait]()` — Inherited from trait: sendResetLinkFailedResponse |
| `dash/app\Http\Controllers\Auth\LoginController.php` | Controller | [Admin] HTTP controller for Auth features | `__construct()` — Constructor: initializes class dependencies<br>`logout()` — Logout logic<br>`showLoginForm [Trait]()` — Inherited from trait: showLoginForm<br>`login [Trait]()` — Inherited from trait: login<br>`username [Trait]()` — Inherited from trait: username<br>`validateLogin [Trait]()` — Inherited from trait: validateLogin<br>`attemptLogin [Trait]()` — Inherited from trait: attemptLogin<br>`sendLoginResponse [Trait]()` — Inherited from trait: sendLoginResponse<br>`authenticated [Trait]()` — Inherited from trait: authenticated<br>`logout [Trait]()` — Inherited from trait: logout<br>`loggedOut [Trait]()` — Inherited from trait: loggedOut |
| `dash/app\Http\Controllers\Auth\RegisterController.php` | Controller | [Admin] HTTP controller for Auth features | `__construct()` — Constructor: initializes class dependencies<br>`validator()` — [NEEDS REVIEW]<br>`create()` — Show form to create new record<br>`showRegistrationForm [Trait]()` — Inherited from trait: showRegistrationForm<br>`register [Trait]()` — Inherited from trait: register |
| `dash/app\Http\Controllers\Auth\ResetPasswordController.php` | Controller | [Admin] HTTP controller for Auth features | `showResetForm [Trait]()` — Inherited from trait: showResetForm<br>`reset [Trait]()` — Inherited from trait: reset<br>`resetPassword [Trait]()` — Inherited from trait: resetPassword<br>`sendResetResponse [Trait]()` — Inherited from trait: sendResetResponse<br>`sendResetFailedResponse [Trait]()` — Inherited from trait: sendResetFailedResponse |
| `dash/app\Http\Controllers\Auth\VerificationController.php` | Controller | [Admin] HTTP controller for Auth features | `__construct()` — Constructor: initializes class dependencies<br>`show [Trait]()` — Inherited from trait: show<br>`verify [Trait]()` — Inherited from trait: verify<br>`resend [Trait]()` — Inherited from trait: resend |
| `dash/app\Http\Controllers\DashboardUserController.php` | Controller | [Admin] HTTP controller for Auth features | `index()` — Display list/overview page<br>`userss()` — Dashboard users listing<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB<br>`update1()` — Alternative update method |
| `dash/resources/views\auth\login.blade.php` | Blade View | [Admin] Blade template: login.blade.php | — |
| `dash/resources/views\auth\passwords\confirm.blade.php` | Blade View | [Admin] Blade template: confirm.blade.php | — |
| `dash/resources/views\auth\passwords\email.blade.php` | Blade View | [Admin] Blade template: email.blade.php | — |
| `dash/resources/views\auth\passwords\reset.blade.php` | Blade View | [Admin] Blade template: reset.blade.php | — |
| `dash/resources/views\auth\register.blade.php` | Blade View | [Admin] Blade template: register.blade.php | — |
| `dash/resources/views\auth\verify.blade.php` | Blade View | [Admin] Blade template: verify.blade.php | — |
| `dash/resources/views\pages\dashboard_user.blade.php` | Blade View | [Admin] Blade template: dashboard_user.blade.php | — |

### Bank Details

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\BankDetailController.php` | Controller | [Admin] HTTP controller for Bank Details features | `index()` — Display list/overview page<br>`store()` — Validate & save new record to DB<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB |

### Banners

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\BannerImagesController.php` | Controller | [Admin] HTTP controller for Banners features | `index()` — Display list/overview page<br>`create()` — Show form to create new record<br>`store()` — Validate & save new record to DB<br>`show()` — Display single record details<br>`edit()` — Show form to edit existing record<br>`update()` — Validate & update existing record in DB<br>`updateimage()` — Update image record for banner/product<br>`destroy()` — Delete record from DB<br>`destroyweb()` — Delete record from web-facing table<br>`updateOrder()` — [NEEDS REVIEW]<br>`addbanner()` — Process add banner form submission |
| `dash/app\Http\Controllers\OfferImageController.php` | Controller | [Admin] HTTP controller for Banners features | `index()` — Display list/overview page<br>`offerImagess()` — [NEEDS REVIEW]<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB |
| `dash/resources/views\pages\offer_images.blade.php` | Blade View | [Admin] Blade template: offer_images.blade.php | — |

### Categories

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\CategoryController.php` | Controller | [Admin] HTTP controller for Categories features | `index()` — Display list/overview page<br>`create()` — Show form to create new record<br>`store()` — Validate & save new record to DB<br>`show()` — Display single record details<br>`edit()` — Show form to edit existing record<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB<br>`validateCategoryName()` — [NEEDS REVIEW] |
| `dash/app\Http\Controllers\SubCategoryController.php` | Controller | [Admin] HTTP controller for Categories features | `index()` — Display list/overview page<br>`store()` — Validate & save new record to DB<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB |
| `dash/resources/views\pages\categories.blade.php` | Blade View | [Admin] Blade template: categories.blade.php | — |
| `dash/resources/views\pages\subcategory.blade.php` | Blade View | [Admin] Blade template: subcategory.blade.php | — |

### Components

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/resources/views\components\breadcrumb.blade.php` | Blade View | [Admin] Blade template: breadcrumb.blade.php | — |
| `dash/resources/views\components\export_doc_modal.blade.php` | Blade View | [Admin] Blade template: export_doc_modal.blade.php | — |

### Config

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/config\app.php` | Config | [Admin] Configuration: app settings | — |
| `dash/config\auth.php` | Config | [Admin] Configuration: auth settings | — |
| `dash/config\broadcasting.php` | Config | [Admin] Configuration: broadcasting settings | — |
| `dash/config\cache.php` | Config | [Admin] Configuration: cache settings | — |
| `dash/config\cors.php` | Config | [Admin] Configuration: cors settings | — |
| `dash/config\database.php` | Config | [Admin] Configuration: database settings | — |
| `dash/config\dompdf.php` | Config | [Admin] Configuration: dompdf settings | — |
| `dash/config\excel.php` | Config | [Admin] Configuration: excel settings | — |
| `dash/config\filesystems.php` | Config | [Admin] Configuration: filesystems settings | — |
| `dash/config\hashing.php` | Config | [Admin] Configuration: hashing settings | — |
| `dash/config\logging.php` | Config | [Admin] Configuration: logging settings | — |
| `dash/config\mail.php` | Config | [Admin] Configuration: mail settings | — |
| `dash/config\queue.php` | Config | [Admin] Configuration: queue settings | — |
| `dash/config\sanctum.php` | Config | [Admin] Configuration: sanctum settings | — |
| `dash/config\services.php` | Config | [Admin] Configuration: services settings | — |
| `dash/config\session.php` | Config | [Admin] Configuration: session settings | — |
| `dash/config\snappy.php` | Config | [Admin] Configuration: snappy settings | — |
| `dash/config\telescope.php` | Config | [Admin] Configuration: telescope settings | — |
| `dash/config\view.php` | Config | [Admin] Configuration: view settings | — |

### Console

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Console\Kernel.php` | Console | [Admin] Console kernel | `schedule()` — Define scheduled tasks for cron<br>`commands()` — Register Artisan commands |

### Coupons

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\CouponController.php` | Controller | [Admin] HTTP controller for Coupons features | `index()` — Display list/overview page<br>`addcoupon()` — Process add coupon form submission<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB |
| `dash/resources/views\pages\coupons.blade.php` | Blade View | [Admin] Blade template: coupons.blade.php | — |

### Currency

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\CurrencyController.php` | Controller | [Admin] HTTP controller for Currency features | `__construct()` — Constructor: initializes class dependencies<br>`index()` — Display list/overview page<br>`switchCurrency()` — [NEEDS REVIEW]<br>`switchCurrencyByGet()` — [NEEDS REVIEW]<br>`performSwitch()` — [NEEDS REVIEW]<br>`convert()` — Convert amount between currencies |

### Custom Products

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\CustomProductController.php` | Controller | [Admin] HTTP controller for Custom Products features | `index()` — Display list/overview page<br>`store()` — Validate & save new record to DB<br>`edit()` — Show form to edit existing record<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB<br>`duplicate()` — Duplicate a record<br>`getDesignerData()` — [NEEDS REVIEW] |
| `dash/resources/views\pages\custom_products.blade.php` | Blade View | [Admin] Blade template: custom_products.blade.php | — |

### Dashboard

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\HomeController.php` | Controller | [Admin] HTTP controller for Dashboard features | `__construct()` — Constructor: initializes class dependencies<br>`index()` — Display list/overview page<br>`root()` — Root dashboard route<br>`lang()` — Switch application language<br>`updateProfile()` — [NEEDS REVIEW]<br>`updatePassword()` — [NEEDS REVIEW] |
| `dash/app\Http\Controllers\IndexContrller.php` | Controller | [Admin] HTTP controller for Dashboard features | `index()` — Display list/overview page<br>`create()` — Show form to create new record<br>`store()` — Validate & save new record to DB<br>`show()` — Display single record details<br>`edit()` — Show form to edit existing record<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB |

### Database

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/database\factories\UserFactory.php` | Factory | [Admin] UserFactory.php file | `definition()` — Define model factory default values<br>`unverified()` — Factory state: unverified |
| `dash/database\seeders\DatabaseSeeder.php` | Seeder | [Admin] DatabaseSeeder.php file | `run()` — [NEEDS REVIEW] |

### Delivery

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\AreaAssignController.php` | Controller | [Admin] HTTP controller for Delivery features | `assignDeliveryPerson()` — Delivery tracking logic<br>`deleteDeliveryPerson()` — Delivery tracking logic<br>`fetchAreaDeliveryPartners()` — Delivery tracking logic<br>`deleteAreaDeliveryPartners()` — Delivery tracking logic |
| `dash/app\Http\Controllers\DeliveryPersonController.php` | Controller | [Admin] HTTP controller for Delivery features | `index()` — Display list/overview page<br>`create()` — Show form to create new record<br>`store()` — Validate & save new record to DB<br>`show()` — Display single record details<br>`edit()` — Show form to edit existing record<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB |
| `dash/resources/views\pages\delivery_person.blade.php` | Blade View | [Admin] Blade template: delivery_person.blade.php | — |

### Designs

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\DesignsController.php` | Controller | [Admin] HTTP controller for Designs features | `index()` — Display list/overview page<br>`store()` — Validate & save new record to DB<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB |
| `dash/resources/views\pages\designs.blade.php` | Blade View | [Admin] Blade template: designs.blade.php | — |

### Emails

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/resources/views\emails\bulk_order_approved.blade.php` | Blade View | [Admin] Blade template: bulk_order_approved.blade.php | — |
| `dash/resources/views\emails\bulk_order_rejected.blade.php` | Blade View | [Admin] Blade template: bulk_order_rejected.blade.php | — |
| `dash/resources/views\emails\order_status_updated.blade.php` | Blade View | [Admin] Blade template: order_status_updated.blade.php | — |

### Exceptions

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Exceptions\Handler.php` | Exception Handler | [Admin] Exception handler | `register()` — Register services into service container |

### Helpers

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Helpers\currency_helpers.php` | Helper | [Admin] Global helper functions | `format_currency()` — Format number as currency string |
| `dash/app\Helpers\validation_helpers.php` | Helper | [Admin] Global helper functions | `successResponse()` — [NEEDS REVIEW]<br>`successResponseWithData()` — [NEEDS REVIEW]<br>`errorResponse()` — [NEEDS REVIEW] |

### Inventory

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\CompoStockController.php` | Controller | [Admin] HTTP controller for Inventory features | `index()` — Display list/overview page<br>`update()` — Validate & update existing record in DB<br>`reduceStock1()` — [NEEDS REVIEW] |
| `dash/app\Http\Controllers\StockController.php` | Controller | [Admin] HTTP controller for Inventory features | `index()` — Display list/overview page<br>`update()` — Validate & update existing record in DB<br>`reduceStock()` — [NEEDS REVIEW]<br>`lowstock()` — Get low stock products list<br>`update1()` — Alternative update method<br>`highselling()` — Get high selling products list |
| `dash/resources/views\pages\combostock.blade.php` | Blade View | [Admin] Blade template: combostock.blade.php | — |
| `dash/resources/views\pages\lowstock.blade.php` | Blade View | [Admin] Blade template: lowstock.blade.php | — |
| `dash/resources/views\pages\stocks.blade.php` | Blade View | [Admin] Blade template: stocks.blade.php | — |

### Layouts

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/resources/views\layouts\app.blade.php` | Blade View | [Admin] Blade template: app.blade.php | — |
| `dash/resources/views\layouts\body.blade.php` | Blade View | [Admin] Blade template: body.blade.php | — |
| `dash/resources/views\layouts\footer.blade.php` | Blade View | [Admin] Blade template: footer.blade.php | — |
| `dash/resources/views\layouts\head-css.blade.php` | Blade View | [Admin] Blade template: head-css.blade.php | — |
| `dash/resources/views\layouts\horizontal.blade.php` | Blade View | [Admin] Blade template: horizontal.blade.php | — |
| `dash/resources/views\layouts\main.blade.php` | Blade View | [Admin] Blade template: main.blade.php | — |
| `dash/resources/views\layouts\master-layouts.blade.php` | Blade View | [Admin] Blade template: master-layouts.blade.php | — |
| `dash/resources/views\layouts\master-without_nav.blade.php` | Blade View | [Admin] Blade template: master-without_nav.blade.php | — |
| `dash/resources/views\layouts\master.blade.php` | Blade View | [Admin] Blade template: master.blade.php | — |
| `dash/resources/views\layouts\menu.blade.php` | Blade View | [Admin] Blade template: menu.blade.php | — |
| `dash/resources/views\layouts\page-title.blade.php` | Blade View | [Admin] Blade template: page-title.blade.php | — |
| `dash/resources/views\layouts\right-sidebar.blade.php` | Blade View | [Admin] Blade template: right-sidebar.blade.php | — |
| `dash/resources/views\layouts\sidebar.blade.php` | Blade View | [Admin] Blade template: sidebar.blade.php | — |
| `dash/resources/views\layouts\title-meta.blade.php` | Blade View | [Admin] Blade template: title-meta.blade.php | — |
| `dash/resources/views\layouts\topbar.blade.php` | Blade View | [Admin] Blade template: topbar.blade.php | — |

### Locations

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\AreaController.php` | Controller | [Admin] HTTP controller for Locations features | `index()` — Display list/overview page<br>`create()` — Show form to create new record<br>`store()` — Validate & save new record to DB<br>`show()` — Display single record details<br>`edit()` — Show form to edit existing record<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB<br>`checkAreaValidation()` — [NEEDS REVIEW]<br>`getPincodeAreas()` — [NEEDS REVIEW] |

### Mail

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Mail\BulkOrderApproved.php` | Mailable | [Admin] Email mailable | `__construct()` — Constructor: initializes class dependencies<br>`build()` — Build email content |
| `dash/app\Mail\BulkOrderRejected.php` | Mailable | [Admin] Email mailable | `__construct()` — Constructor: initializes class dependencies<br>`build()` — Build email content |
| `dash/app\Mail\OrderStatusUpdated.php` | Mailable | [Admin] Email mailable | `__construct()` — Constructor: initializes class dependencies<br>`build()` — Build email content |

### Middleware

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Middleware\Authenticate.php` | Middleware | [Admin] HTTP middleware | `redirectTo()` — [NEEDS REVIEW] |
| `dash/app\Http\Middleware\EncryptCookies.php` | Middleware | [Admin] EncryptCookies.php file | — |
| `dash/app\Http\Middleware\Localization.php` | Middleware | [Admin] HTTP middleware | `handle()` — Process incoming HTTP request |
| `dash/app\Http\Middleware\PreventRequestsDuringMaintenance.php` | Middleware | [Admin] PreventRequestsDuringMaintenance.php file | — |
| `dash/app\Http\Middleware\RedirectIfAuthenticated.php` | Middleware | [Admin] HTTP middleware | `handle()` — Process incoming HTTP request |
| `dash/app\Http\Middleware\SetCurrency.php` | Middleware | [Admin] HTTP middleware | `handle()` — Process incoming HTTP request |
| `dash/app\Http\Middleware\TrimStrings.php` | Middleware | [Admin] TrimStrings.php file | — |
| `dash/app\Http\Middleware\TrustHosts.php` | Middleware | [Admin] HTTP middleware | `hosts()` — [NEEDS REVIEW] |
| `dash/app\Http\Middleware\TrustProxies.php` | Middleware | [Admin] TrustProxies.php file | — |
| `dash/app\Http\Middleware\VerifyCsrfToken.php` | Middleware | [Admin] VerifyCsrfToken.php file | — |

### Migrations

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/database\migrations\2023_05_17_130506_create_districts_table.php` | Migration | [Admin] 2023_05_17_130506_create_districts_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `dash/database\migrations\2024_02_13_150932_create_sub_categories_table.php` | Migration | [Admin] 2024_02_13_150932_create_sub_categories_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `dash/database\migrations\2024_02_27_115933_create_today_deals_table.php` | Migration | [Admin] 2024_02_27_115933_create_today_deals_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `dash/database\migrations\2025_07_14_131318_create_shippings_table.php` | Migration | [Admin] 2025_07_14_131318_create_shippings_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `dash/database\migrations\2026_02_19_120000_create_bank_details_table.php` | Migration | [Admin] 2026_02_19_120000_create_bank_details_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `dash/database\migrations\2026_02_23_095448_add_extra_fields_to_bank_details_table.php` | Migration | [Admin] 2026_02_23_095448_add_extra_fields_to_bank_details_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `dash/database\migrations\2026_02_23_101947_create_app_settings_table.php` | Migration | [Admin] 2026_02_23_101947_create_app_settings_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `dash/database\migrations\2026_02_23_111236_add_approval_columns_to_bulk_orders_table.php` | Migration | [Admin] 2026_02_23_111236_add_approval_columns_to_bulk_orders_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `dash/database\migrations\2026_02_24_101646_add_description_to_bank_details_table.php` | Migration | [Admin] 2026_02_24_101646_add_description_to_bank_details_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `dash/database\migrations\2026_02_24_123311_create_invoices_table.php` | Migration | [Admin] 2026_02_24_123311_create_invoices_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `dash/database\migrations\2026_02_27_065836_create_order_export_data_table.php` | Migration | [Admin] 2026_02_27_065836_create_order_export_data_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `dash/database\migrations\2026_03_20_000000_create_exchange_rates_table.php` | Migration | [Admin] 2026_03_20_000000_create_exchange_rates_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `dash/database\migrations\2026_04_01_123602_add_gsm_and_colors_to_samples.php` | Migration | [Admin] 2026_04_01_123602_add_gsm_and_colors_to_samples.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `dash/database\migrations\2026_04_01_130000_add_printing_and_bank_fields_to_orders.php` | Migration | [Admin] 2026_04_01_130000_add_printing_and_bank_fields_to_orders.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |

### Milk

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\MilkOrdersController.php` | Controller | [Admin] HTTP controller for Milk features | `index()` — Display list/overview page<br>`getMilkSlots()` — [NEEDS REVIEW]<br>`cancelMilkSlot()` — Order cancellation logic<br>`getAreaAssignedDelvieryPerson()` — [NEEDS REVIEW]<br>`milkOrderDeliveryAssign()` — Delivery tracking logic |
| `dash/app\Http\Controllers\MilkRefundController.php` | Controller | [Admin] HTTP controller for Milk features | `index()` — Display list/overview page<br>`getRefundDatas()` — Refund processing logic<br>`refundMilkSlot()` — Refund processing logic |
| `dash/app\Http\Controllers\MilkSlotController.php` | Controller | [Admin] HTTP controller for Milk features | `getMilkSlots()` — [NEEDS REVIEW]<br>`cancelMilkSlot()` — Order cancellation logic |
| `dash/resources/views\pages\milk_orders.blade.php` | Blade View | [Admin] Blade template: milk_orders.blade.php | — |
| `dash/resources/views\pages\milk_refunds.blade.php` | Blade View | [Admin] Blade template: milk_refunds.blade.php | — |
| `dash/resources/views\pages\milk_slots.blade.php` | Blade View | [Admin] Blade template: milk_slots.blade.php | — |

### Models

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Models\AddressType.php` | Model | [Admin] Eloquent model for AddressType table | `user()` — Eloquent relationship to related model |
| `dash/app\Models\AllIndiaPincode.php` | Model | [Admin] AllIndiaPincode.php file | — |
| `dash/app\Models\AppAlert.php` | Model | [Admin] Eloquent model for AppAlert table | `user()` — Eloquent relationship to related model<br>`getCreatedAtAttribute()` — Accessor: computed attribute |
| `dash/app\Models\AppNotification.php` | Model | [Admin] Eloquent model for AppNotification table | `user()` — Eloquent relationship to related model<br>`getCreatedAtAttribute()` — Accessor: computed attribute |
| `dash/app\Models\AppSetting.php` | Model | [Admin] AppSetting.php file | — |
| `dash/app\Models\Area.php` | Model | [Admin] Eloquent model for Area table | `areaAssigns()` — Eloquent relationship to related model |
| `dash/app\Models\AreaAssign.php` | Model | [Admin] Eloquent model for AreaAssign table | `area()` — Eloquent relationship to related model<br>`deliveryPerson()` — Eloquent relationship to related model |
| `dash/app\Models\BankDetail.php` | Model | [Admin] BankDetail.php file | — |
| `dash/app\Models\BannerImage.php` | Model | [Admin] BannerImage.php file | — |
| `dash/app\Models\BulkOrder.php` | Model | [Admin] Eloquent model for BulkOrder table | `product()` — Eloquent relationship to related model |
| `dash/app\Models\Cart.php` | Model | [Admin] Eloquent model for Cart table | `product()` — Eloquent relationship to related model |
| `dash/app\Models\Category.php` | Model | [Admin] Eloquent model for Category table | `products()` — Eloquent relationship to related model |
| `dash/app\Models\City.php` | Model | [Admin] City.php file | — |
| `dash/app\Models\Coupon.php` | Model | [Admin] Coupon.php file | — |
| `dash/app\Models\CustomProduct.php` | Model | [Admin] Eloquent model for CustomProduct table | `colors()` — Eloquent relationship to related model |
| `dash/app\Models\DashboardUser.php` | Model | [Admin] DashboardUser.php file | — |
| `dash/app\Models\DeliveryPerson.php` | Model | [Admin] Eloquent model for DeliveryPerson table | `areaAssigns()` — Eloquent relationship to related model<br>`milkOrders()` — Eloquent relationship to related model<br>`productOrders()` — Eloquent relationship to related model |
| `dash/app\Models\Design.php` | Model | [Admin] Design.php file | — |
| `dash/app\Models\District.php` | Model | [Admin] District.php file | — |
| `dash/app\Models\ExchangeRate.php` | Model | [Admin] ExchangeRate.php file | — |
| `dash/app\Models\GenderType.php` | Model | [Admin] GenderType.php file | — |
| `dash/app\Models\Invoice.php` | Model | [Admin] Invoice.php file | — |
| `dash/app\Models\MailOtp.php` | Model | [Admin] Eloquent model for MailOtp table | `scopeValid()` — Query scope: Valid filter |
| `dash/app\Models\MilkOrder.php` | Model | [Admin] Eloquent model for MilkOrder table | `product()` — Eloquent relationship to related model<br>`customer()` — [NEEDS REVIEW]<br>`area()` — Eloquent relationship to related model<br>`transactionLog()` — [NEEDS REVIEW]<br>`getDateOrderedOnAttribute()` — Accessor: computed attribute<br>`orderAddress()` — [NEEDS REVIEW] |
| `dash/app\Models\MilkOrderUserAddress.php` | Model | [Admin] Eloquent model for MilkOrderUserAddress table | `milkOrder()` — Eloquent relationship to related model<br>`area()` — Eloquent relationship to related model |
| `dash/app\Models\MilkRefund.php` | Model | [Admin] Eloquent model for MilkRefund table | `milk_order()` — [NEEDS REVIEW] |
| `dash/app\Models\MilkSlot.php` | Model | [Admin] Eloquent model for MilkSlot table | `order()` — Eloquent relationship to related model |
| `dash/app\Models\MilkTransactionLog.php` | Model | [Admin] Eloquent model for MilkTransactionLog table | `milkOrder()` — Eloquent relationship to related model |
| `dash/app\Models\Notification.php` | Model | [Admin] Notification.php file | — |
| `dash/app\Models\OfferImage.php` | Model | [Admin] OfferImage.php file | — |
| `dash/app\Models\OrderExportData.php` | Model | [Admin] OrderExportData.php file | — |
| `dash/app\Models\Otp.php` | Model | [Admin] Eloquent model for Otp table | `scopeValid()` — Query scope: Valid filter |
| `dash/app\Models\PlanType.php` | Model | [Admin] PlanType.php file | — |
| `dash/app\Models\Product.php` | Model | [Admin] Eloquent model for Product table | `category()` — Eloquent relationship to related model<br>`Subcategory()` — Eloquent relationship to related model<br>`productvari()` — [NEEDS REVIEW]<br>`childImages()` — Eloquent relationship to related model |
| `dash/app\Models\ProductChildImage.php` | Model | [Admin] Eloquent model for ProductChildImage table | `product()` — Eloquent relationship to related model<br>`variant()` — [NEEDS REVIEW] |
| `dash/app\Models\ProductColor.php` | Model | [Admin] Eloquent model for ProductColor table | `customProduct()` — Eloquent relationship to related model<br>`images()` — Eloquent relationship to related model<br>`getColorName()` — [NEEDS REVIEW]<br>`getNamesByCodes()` — [NEEDS REVIEW] |
| `dash/app\Models\ProductColorImage.php` | Model | [Admin] Eloquent model for ProductColorImage table | `productColor()` — Eloquent relationship to related model |
| `dash/app\Models\ProductOrder.php` | Model | [Admin] Eloquent model for ProductOrder table | `product()` — Eloquent relationship to related model<br>`customer()` — [NEEDS REVIEW]<br>`area()` — Eloquent relationship to related model<br>`transactionLog()` — [NEEDS REVIEW]<br>`getDateOrderedOnAttribute()` — Accessor: computed attribute<br>`orderAddress()` — [NEEDS REVIEW]<br>`useraddress()` — [NEEDS REVIEW]<br>`state()` — [NEEDS REVIEW]<br>`getTotalItemsAttribute()` — Accessor: computed attribute<br>`getTotalQuantityAttribute()` — Accessor: computed attribute |
| `dash/app\Models\ProductOrderUserAddress.php` | Model | [Admin] Eloquent model for ProductOrderUserAddress table | `productOrder()` — Eloquent relationship to related model<br>`area()` — Eloquent relationship to related model<br>`state()` — [NEEDS REVIEW] |
| `dash/app\Models\ProductRefund.php` | Model | [Admin] Eloquent model for ProductRefund table | `product_order()` — [NEEDS REVIEW]<br>`product()` — Eloquent relationship to related model<br>`productverient()` — Eloquent relationship to related model<br>`product_slot()` — [NEEDS REVIEW] |
| `dash/app\Models\ProductSlot.php` | Model | [Admin] Eloquent model for ProductSlot table | `productOrder()` — Eloquent relationship to related model<br>`order()` — Eloquent relationship to related model<br>`product()` — Eloquent relationship to related model<br>`productVarient()` — Eloquent relationship to related model<br>`productorderAddress()` — [NEEDS REVIEW]<br>`state()` — [NEEDS REVIEW] |
| `dash/app\Models\ProductStock.php` | Model | [Admin] Eloquent model for ProductStock table | `category()` — Eloquent relationship to related model<br>`Productvarient()` — Eloquent relationship to related model |
| `dash/app\Models\ProductTracking.php` | Model | [Admin] ProductTracking.php file | — |
| `dash/app\Models\ProductTransactionLog.php` | Model | [Admin] ProductTransactionLog.php file | — |
| `dash/app\Models\ProductVarient.php` | Model | [Admin] Eloquent model for ProductVarient table | `category()` — Eloquent relationship to related model |
| `dash/app\Models\ProductVerient.php` | Model | [Admin] ProductVerient.php file | — |
| `dash/app\Models\Sample.php` | Model | [Admin] Sample.php file | — |
| `dash/app\Models\Shipping.php` | Model | [Admin] Shipping.php file | — |
| `dash/app\Models\SizeChart.php` | Model | [Admin] SizeChart.php file | — |
| `dash/app\Models\State.php` | Model | [Admin] State.php file | — |
| `dash/app\Models\SubCategory.php` | Model | [Admin] Eloquent model for SubCategory table | `category()` — Eloquent relationship to related model |
| `dash/app\Models\Test.php` | Model | [Admin] Test.php file | — |
| `dash/app\Models\TodayDeals.php` | Model | [Admin] TodayDeals.php file | — |
| `dash/app\Models\User.php` | Model | [Admin] Eloquent model for User table | `milkOrder()` — Eloquent relationship to related model<br>`area()` — Eloquent relationship to related model<br>`user_addresses()` — [NEEDS REVIEW]<br>`defaultAddress()` — [NEEDS REVIEW]<br>`latestAddress()` — [NEEDS REVIEW] |
| `dash/app\Models\UserAddress.php` | Model | [Admin] Eloquent model for UserAddress table | `user()` — Eloquent relationship to related model<br>`area()` — Eloquent relationship to related model |

### Notifications

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\NotificationController.php` | Controller | [Admin] HTTP controller for Notifications features | `index()` — Display list/overview page<br>`notifications()` — Eloquent relationship to related model<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB<br>`getProductsByCategory()` — [NEEDS REVIEW] |
| `dash/resources/views\pages\notification.blade.php` | Blade View | [Admin] Blade template: notification.blade.php | — |

### Orders

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\BulkOrderController.php` | Controller | [Admin] HTTP controller for Orders features | `index()` — Display list/overview page<br>`updateStatus()` — [NEEDS REVIEW] |
| `dash/app\Http\Controllers\CancelProductController.php` | Controller | [Admin] HTTP controller for Orders features | `index()` — Display list/overview page<br>`cancelProductrequ()` — Order cancellation logic |
| `dash/app\Http\Controllers\OrderAssetsController.php` | Controller | [Admin] HTTP controller for Orders features | `downloadZip()` — File download logic<br>`downloadFile()` — File download logic |
| `dash/app\Http\Controllers\OrderController.php` | Controller | [Admin] HTTP controller for Orders features | `orderwisereport()` — Report generation<br>`filterorderWiseReport()` — Report generation<br>`exportExcel()` — Data export logic<br>`exportPDF()` — Data export logic<br>`getFilteredOrderData()` — [NEEDS REVIEW]<br>`getFilteredOrderDataFromDates()` — [NEEDS REVIEW]<br>`showInvoice()` — Invoice generation logic |
| `dash/app\Http\Controllers\OrderSummeryController.php` | Controller | [Admin] HTTP controller for Orders features | `index()` — Display list/overview page<br>`getoversummery()` — [NEEDS REVIEW] |
| `dash/app\Http\Controllers\PackingDeliveryController.php` | Controller | [Admin] HTTP controller for Orders features | `index()` — Display list/overview page<br>`updatedelive()` — [NEEDS REVIEW]<br>`collectdelive()` — [NEEDS REVIEW] |
| `dash/app\Http\Controllers\PackingDispatchController.php` | Controller | [Admin] HTTP controller for Orders features | `index()` — Display list/overview page<br>`updatedispach()` — [NEEDS REVIEW]<br>`updaterefund2()` — Refund processing logic |
| `dash/app\Http\Controllers\PackingOrderController.php` | Controller | [Admin] HTTP controller for Orders features | `index()` — Display list/overview page<br>`updatepacking()` — Packing order logic<br>`updaterefund1()` — Refund processing logic |
| `dash/app\Http\Controllers\ProductOrdersController.php` | Controller | [Admin] HTTP controller for Orders features | `index()` — Display list/overview page<br>`orderStat()` — [NEEDS REVIEW]<br>`create()` — Show form to create new record<br>`store()` — Validate & save new record to DB<br>`show()` — Display single record details<br>`edit()` — Show form to edit existing record<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB<br>`productOrderDeliveryAssign()` — Delivery tracking logic<br>`fetchTotalOrders()` — [NEEDS REVIEW] |
| `dash/app\Http\Controllers\ProductRefundController.php` | Controller | [Admin] HTTP controller for Orders features | `index()` — Display list/overview page<br>`getRefundDatas()` — Refund processing logic<br>`refundProductSlot()` — Refund processing logic |
| `dash/app\Http\Controllers\ProductReturnController.php` | Controller | [Admin] HTTP controller for Orders features | `index()` — Display list/overview page<br>`update()` — Validate & update existing record in DB<br>`updateed()` — [NEEDS REVIEW] |
| `dash/app\Http\Controllers\packingCompleteController.php` | Controller | [Admin] HTTP controller for Orders features | `index()` — Display list/overview page |
| `dash/resources/views\pages\cancelproduct.blade.php` | Blade View | [Admin] Blade template: cancelproduct.blade.php | — |
| `dash/resources/views\pages\order_summery.blade.php` | Blade View | [Admin] Blade template: order_summery.blade.php | — |
| `dash/resources/views\pages\orderslot.blade.php` | Blade View | [Admin] Blade template: orderslot.blade.php | — |
| `dash/resources/views\pages\product_delivered.blade.php` | Blade View | [Admin] Blade template: product_delivered.blade.php | — |
| `dash/resources/views\pages\product_delivery.blade.php` | Blade View | [Admin] Blade template: product_delivery.blade.php | — |
| `dash/resources/views\pages\product_dispatch.blade.php` | Blade View | [Admin] Blade template: product_dispatch.blade.php | — |
| `dash/resources/views\pages\product_orders.blade.php` | Blade View | [Admin] Blade template: product_orders.blade.php | — |
| `dash/resources/views\pages\product_orders1.blade.php` | Blade View | [Admin] Blade template: product_orders1.blade.php | — |
| `dash/resources/views\pages\product_packing.blade.php` | Blade View | [Admin] Blade template: product_packing.blade.php | — |
| `dash/resources/views\pages\product_refunds.blade.php` | Blade View | [Admin] Blade template: product_refunds.blade.php | — |
| `dash/resources/views\pages\refunds.blade.php` | Blade View | [Admin] Blade template: refunds.blade.php | — |
| `dash/resources/views\pages\return_product.blade.php` | Blade View | [Admin] Blade template: return_product.blade.php | — |

### Other

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\Controller.php` | Controller | [Admin] Controller.php file | — |
| `dash/app\Http\Kernel.php` | Other | [Admin] Kernel.php file | — |
| `dash/resources/js\app.js` | JavaScript | [Admin] app.js file | `initLanguage()` — [NEEDS REVIEW]<br>`setLanguage()` — [NEEDS REVIEW]<br>`getLanguage()` — [NEEDS REVIEW]<br>`initMetisMenu()` — [NEEDS REVIEW]<br>`initCounterNumber()` — [NEEDS REVIEW]<br>`updateCount()` — [NEEDS REVIEW]<br>`initLeftMenuCollapse()` — [NEEDS REVIEW]<br>`initActiveMenu()` — [NEEDS REVIEW]<br>`initMenuItemScroll()` — [NEEDS REVIEW]<br>`initHoriMenuActive()` — [NEEDS REVIEW]<br>`initFullScreen()` — [NEEDS REVIEW]<br>`exitHandler()` — [NEEDS REVIEW]<br>`initDropdownMenu()` — [NEEDS REVIEW]<br>`updateMenu()` — [NEEDS REVIEW]<br>`initComponents()` — [NEEDS REVIEW]<br>`fadeOutEffect()` — [NEEDS REVIEW]<br>`initPreloader()` — [NEEDS REVIEW]<br>`initSettings()` — [NEEDS REVIEW]<br>`changeDirection()` — [NEEDS REVIEW]<br>`updateRadio()` — [NEEDS REVIEW]<br>`layoutSetting()` — [NEEDS REVIEW]<br>`initCheckAll()` — [NEEDS REVIEW]<br>`init()` — [NEEDS REVIEW] |
| `dash/resources/js\pages\alert.init.js` | JavaScript | [Admin] alert.init.js file | `alert()` — [NEEDS REVIEW] |
| `dash/resources/js\pages\apexcharts.init.js` | JavaScript | [Admin] apexcharts.init.js file | `getChartColorsArray()` — [NEEDS REVIEW]<br>`generateData()` — [NEEDS REVIEW] |
| `dash/resources/js\pages\calendar.init.js` | JavaScript | [Admin] calendar.init.js file | `addNewEvent()` — [NEEDS REVIEW]<br>`getInitialView()` — [NEEDS REVIEW] |
| `dash/resources/js\pages\chartjs.init.js` | JavaScript | [Admin] chartjs.init.js file | `getChartColorsArray()` — [NEEDS REVIEW] |
| `dash/resources/js\pages\chartjs.js` | JavaScript | [Admin] chartjs.js file | `r()` — [NEEDS REVIEW]<br>`o()` — [NEEDS REVIEW]<br>`getRgba()` — [NEEDS REVIEW]<br>`getHsla()` — [NEEDS REVIEW]<br>`getHwb()` — [NEEDS REVIEW]<br>`getRgb()` — [NEEDS REVIEW]<br>`getHsl()` — [NEEDS REVIEW]<br>`getAlpha()` — [NEEDS REVIEW]<br>`hexString()` — [NEEDS REVIEW]<br>`rgbString()` — [NEEDS REVIEW]<br>`rgbaString()` — [NEEDS REVIEW]<br>`percentString()` — [NEEDS REVIEW]<br>`percentaString()` — [NEEDS REVIEW]<br>`hslString()` — [NEEDS REVIEW]<br>`hslaString()` — [NEEDS REVIEW]<br>`hwbString()` — [NEEDS REVIEW]<br>`keyword()` — [NEEDS REVIEW]<br>`scale()` — [NEEDS REVIEW]<br>`hexDouble()` — [NEEDS REVIEW]<br>`rgb2hsl()` — [NEEDS REVIEW]<br>`rgb2hsv()` — [NEEDS REVIEW]<br>`rgb2hwb()` — [NEEDS REVIEW]<br>`rgb2cmyk()` — [NEEDS REVIEW]<br>`rgb2keyword()` — [NEEDS REVIEW]<br>`rgb2xyz()` — [NEEDS REVIEW]<br>`rgb2lab()` — [NEEDS REVIEW]<br>`rgb2lch()` — [NEEDS REVIEW]<br>`hsl2rgb()` — [NEEDS REVIEW]<br>`hsl2hsv()` — [NEEDS REVIEW]<br>`hsl2hwb()` — [NEEDS REVIEW]<br>`hsl2cmyk()` — [NEEDS REVIEW]<br>`hsl2keyword()` — [NEEDS REVIEW]<br>`hsv2rgb()` — [NEEDS REVIEW]<br>`hsv2hsl()` — [NEEDS REVIEW]<br>`hsv2hwb()` — [NEEDS REVIEW]<br>`hsv2cmyk()` — [NEEDS REVIEW]<br>`hsv2keyword()` — [NEEDS REVIEW]<br>`hwb2rgb()` — [NEEDS REVIEW]<br>`hwb2hsl()` — [NEEDS REVIEW]<br>`hwb2hsv()` — [NEEDS REVIEW]<br>`hwb2cmyk()` — [NEEDS REVIEW]<br>`hwb2keyword()` — [NEEDS REVIEW]<br>`cmyk2rgb()` — [NEEDS REVIEW]<br>`cmyk2hsl()` — [NEEDS REVIEW]<br>`cmyk2hsv()` — [NEEDS REVIEW]<br>`cmyk2hwb()` — [NEEDS REVIEW]<br>`cmyk2keyword()` — [NEEDS REVIEW]<br>`xyz2rgb()` — [NEEDS REVIEW]<br>`xyz2lab()` — [NEEDS REVIEW]<br>`xyz2lch()` — [NEEDS REVIEW]<br>`lab2xyz()` — [NEEDS REVIEW]<br>`lab2lch()` — [NEEDS REVIEW]<br>`lab2rgb()` — [NEEDS REVIEW]<br>`lch2lab()` — [NEEDS REVIEW]<br>`lch2xyz()` — [NEEDS REVIEW]<br>`lch2rgb()` — [NEEDS REVIEW]<br>`keyword2rgb()` — [NEEDS REVIEW]<br>`keyword2hsl()` — [NEEDS REVIEW]<br>`keyword2hsv()` — [NEEDS REVIEW]<br>`keyword2hwb()` — [NEEDS REVIEW]<br>`keyword2cmyk()` — [NEEDS REVIEW]<br>`keyword2lab()` — [NEEDS REVIEW]<br>`keyword2xyz()` — [NEEDS REVIEW]<br>`hooks()` — [NEEDS REVIEW]<br>`setHookCallback()` — [NEEDS REVIEW]<br>`isArray()` — [NEEDS REVIEW]<br>`isObject()` — [NEEDS REVIEW]<br>`isObjectEmpty()` — [NEEDS REVIEW]<br>`isUndefined()` — [NEEDS REVIEW]<br>`isNumber()` — [NEEDS REVIEW]<br>`isDate()` — [NEEDS REVIEW]<br>`hasOwnProp()` — [NEEDS REVIEW]<br>`extend()` — [NEEDS REVIEW]<br>`createUTC()` — [NEEDS REVIEW]<br>`defaultParsingFlags()` — [NEEDS REVIEW]<br>`getParsingFlags()` — [NEEDS REVIEW]<br>`isValid()` — [NEEDS REVIEW]<br>`createInvalid()` — [NEEDS REVIEW]<br>`copyConfig()` — [NEEDS REVIEW]<br>`Moment()` — [NEEDS REVIEW]<br>`isMoment()` — [NEEDS REVIEW]<br>`absFloor()` — [NEEDS REVIEW]<br>`toInt()` — [NEEDS REVIEW]<br>`compareArrays()` — [NEEDS REVIEW]<br>`warn()` — [NEEDS REVIEW]<br>`deprecate()` — [NEEDS REVIEW]<br>`deprecateSimple()` — [NEEDS REVIEW]<br>`isFunction()` — [NEEDS REVIEW]<br>`set()` — [NEEDS REVIEW]<br>`mergeConfigs()` — [NEEDS REVIEW]<br>`Locale()` — [NEEDS REVIEW]<br>`calendar()` — [NEEDS REVIEW]<br>`longDateFormat()` — [NEEDS REVIEW]<br>`invalidDate()` — [NEEDS REVIEW]<br>`ordinal()` — [NEEDS REVIEW]<br>`relativeTime()` — [NEEDS REVIEW]<br>`pastFuture()` — [NEEDS REVIEW]<br>`addUnitAlias()` — [NEEDS REVIEW]<br>`normalizeUnits()` — [NEEDS REVIEW]<br>`normalizeObjectUnits()` — [NEEDS REVIEW]<br>`addUnitPriority()` — [NEEDS REVIEW]<br>`getPrioritizedUnits()` — [NEEDS REVIEW]<br>`zeroFill()` — [NEEDS REVIEW]<br>`addFormatToken()` — [NEEDS REVIEW]<br>`removeFormattingTokens()` — [NEEDS REVIEW]<br>`makeFormatFunction()` — [NEEDS REVIEW]<br>`formatMoment()` — [NEEDS REVIEW]<br>`expandFormat()` — [NEEDS REVIEW]<br>`replaceLongDateFormatTokens()` — [NEEDS REVIEW]<br>`addRegexToken()` — [NEEDS REVIEW]<br>`getParseRegexForToken()` — [NEEDS REVIEW]<br>`unescapeFormat()` — [NEEDS REVIEW]<br>`regexEscape()` — [NEEDS REVIEW]<br>`addParseToken()` — [NEEDS REVIEW]<br>`addWeekParseToken()` — [NEEDS REVIEW]<br>`addTimeToArrayFromToken()` — [NEEDS REVIEW]<br>`daysInYear()` — [NEEDS REVIEW]<br>`isLeapYear()` — [NEEDS REVIEW]<br>`getIsLeapYear()` — [NEEDS REVIEW]<br>`makeGetSet()` — [NEEDS REVIEW]<br>`stringGet()` — [NEEDS REVIEW]<br>`stringSet()` — [NEEDS REVIEW]<br>`mod()` — [NEEDS REVIEW]<br>`daysInMonth()` — [NEEDS REVIEW]<br>`localeMonths()` — [NEEDS REVIEW]<br>`localeMonthsShort()` — [NEEDS REVIEW]<br>`handleStrictParse()` — [NEEDS REVIEW]<br>`localeMonthsParse()` — [NEEDS REVIEW]<br>`setMonth()` — [NEEDS REVIEW]<br>`getSetMonth()` — [NEEDS REVIEW]<br>`getDaysInMonth()` — [NEEDS REVIEW]<br>`monthsShortRegex()` — [NEEDS REVIEW]<br>`monthsRegex()` — [NEEDS REVIEW]<br>`computeMonthsParse()` — [NEEDS REVIEW]<br>`cmpLenRev()` — [NEEDS REVIEW]<br>`createDate()` — [NEEDS REVIEW]<br>`createUTCDate()` — [NEEDS REVIEW]<br>`firstWeekOffset()` — [NEEDS REVIEW]<br>`dayOfYearFromWeeks()` — [NEEDS REVIEW]<br>`weekOfYear()` — [NEEDS REVIEW]<br>`weeksInYear()` — [NEEDS REVIEW]<br>`localeWeek()` — [NEEDS REVIEW]<br>`localeFirstDayOfWeek()` — [NEEDS REVIEW]<br>`localeFirstDayOfYear()` — [NEEDS REVIEW]<br>`getSetWeek()` — [NEEDS REVIEW]<br>`getSetISOWeek()` — [NEEDS REVIEW]<br>`parseWeekday()` — [NEEDS REVIEW]<br>`parseIsoWeekday()` — [NEEDS REVIEW]<br>`localeWeekdays()` — [NEEDS REVIEW]<br>`localeWeekdaysShort()` — [NEEDS REVIEW]<br>`localeWeekdaysMin()` — [NEEDS REVIEW]<br>`localeWeekdaysParse()` — [NEEDS REVIEW]<br>`getSetDayOfWeek()` — [NEEDS REVIEW]<br>`getSetLocaleDayOfWeek()` — [NEEDS REVIEW]<br>`getSetISODayOfWeek()` — [NEEDS REVIEW]<br>`weekdaysRegex()` — [NEEDS REVIEW]<br>`weekdaysShortRegex()` — [NEEDS REVIEW]<br>`weekdaysMinRegex()` — [NEEDS REVIEW]<br>`computeWeekdaysParse()` — [NEEDS REVIEW]<br>`hFormat()` — [NEEDS REVIEW]<br>`kFormat()` — [NEEDS REVIEW]<br>`meridiem()` — [NEEDS REVIEW]<br>`matchMeridiem()` — [NEEDS REVIEW]<br>`localeIsPM()` — [NEEDS REVIEW]<br>`localeMeridiem()` — [NEEDS REVIEW]<br>`normalizeLocale()` — [NEEDS REVIEW]<br>`chooseLocale()` — [NEEDS REVIEW]<br>`loadLocale()` — [NEEDS REVIEW]<br>`getSetGlobalLocale()` — [NEEDS REVIEW]<br>`defineLocale()` — [NEEDS REVIEW]<br>`updateLocale()` — [NEEDS REVIEW]<br>`getLocale()` — [NEEDS REVIEW]<br>`listLocales()` — [NEEDS REVIEW]<br>`checkOverflow()` — [NEEDS REVIEW]<br>`defaults()` — [NEEDS REVIEW]<br>`currentDateArray()` — [NEEDS REVIEW]<br>`configFromArray()` — [NEEDS REVIEW]<br>`dayOfYearFromWeekInfo()` — [NEEDS REVIEW]<br>`configFromISO()` — [NEEDS REVIEW]<br>`extractFromRFC2822Strings()` — [NEEDS REVIEW]<br>`untruncateYear()` — [NEEDS REVIEW]<br>`preprocessRFC2822()` — [NEEDS REVIEW]<br>`checkWeekday()` — [NEEDS REVIEW]<br>`calculateOffset()` — [NEEDS REVIEW]<br>`configFromRFC2822()` — [NEEDS REVIEW]<br>`configFromString()` — [NEEDS REVIEW]<br>`configFromStringAndFormat()` — [NEEDS REVIEW]<br>`meridiemFixWrap()` — [NEEDS REVIEW]<br>`configFromStringAndArray()` — [NEEDS REVIEW]<br>`configFromObject()` — [NEEDS REVIEW]<br>`createFromConfig()` — [NEEDS REVIEW]<br>`prepareConfig()` — [NEEDS REVIEW]<br>`configFromInput()` — [NEEDS REVIEW]<br>`createLocalOrUTC()` — [NEEDS REVIEW]<br>`createLocal()` — [NEEDS REVIEW]<br>`pickBy()` — [NEEDS REVIEW]<br>`isDurationValid()` — [NEEDS REVIEW]<br>`Duration()` — [NEEDS REVIEW]<br>`isDuration()` — [NEEDS REVIEW]<br>`absRound()` — [NEEDS REVIEW]<br>`offset()` — [NEEDS REVIEW]<br>`offsetFromString()` — [NEEDS REVIEW]<br>`cloneWithOffset()` — [NEEDS REVIEW]<br>`getDateOffset()` — [NEEDS REVIEW]<br>`getSetOffset()` — [NEEDS REVIEW]<br>`getSetZone()` — [NEEDS REVIEW]<br>`setOffsetToUTC()` — [NEEDS REVIEW]<br>`setOffsetToLocal()` — [NEEDS REVIEW]<br>`setOffsetToParsedOffset()` — [NEEDS REVIEW]<br>`hasAlignedHourOffset()` — [NEEDS REVIEW]<br>`isDaylightSavingTime()` — [NEEDS REVIEW]<br>`isDaylightSavingTimeShifted()` — [NEEDS REVIEW]<br>`isLocal()` — [NEEDS REVIEW]<br>`isUtcOffset()` — [NEEDS REVIEW]<br>`isUtc()` — [NEEDS REVIEW]<br>`createDuration()` — [NEEDS REVIEW]<br>`parseIso()` — [NEEDS REVIEW]<br>`positiveMomentsDifference()` — [NEEDS REVIEW]<br>`momentsDifference()` — [NEEDS REVIEW]<br>`createAdder()` — [NEEDS REVIEW]<br>`addSubtract()` — [NEEDS REVIEW]<br>`getCalendarFormat()` — [NEEDS REVIEW]<br>`clone()` — [NEEDS REVIEW]<br>`isAfter()` — [NEEDS REVIEW]<br>`isBefore()` — [NEEDS REVIEW]<br>`isBetween()` — [NEEDS REVIEW]<br>`isSame()` — [NEEDS REVIEW]<br>`isSameOrAfter()` — [NEEDS REVIEW]<br>`isSameOrBefore()` — [NEEDS REVIEW]<br>`diff()` — [NEEDS REVIEW]<br>`monthDiff()` — [NEEDS REVIEW]<br>`toString()` — [NEEDS REVIEW]<br>`toISOString()` — [NEEDS REVIEW]<br>`inspect()` — [NEEDS REVIEW]<br>`format()` — [NEEDS REVIEW]<br>`from()` — [NEEDS REVIEW]<br>`fromNow()` — [NEEDS REVIEW]<br>`to()` — [NEEDS REVIEW]<br>`toNow()` — [NEEDS REVIEW]<br>`locale()` — [NEEDS REVIEW]<br>`localeData()` — [NEEDS REVIEW]<br>`startOf()` — [NEEDS REVIEW]<br>`endOf()` — [NEEDS REVIEW]<br>`valueOf()` — [NEEDS REVIEW]<br>`unix()` — [NEEDS REVIEW]<br>`toDate()` — [NEEDS REVIEW]<br>`toObject()` — [NEEDS REVIEW]<br>`toJSON()` — [NEEDS REVIEW]<br>`parsingFlags()` — [NEEDS REVIEW]<br>`invalidAt()` — [NEEDS REVIEW]<br>`creationData()` — [NEEDS REVIEW]<br>`addWeekYearFormatToken()` — [NEEDS REVIEW]<br>`getSetWeekYear()` — [NEEDS REVIEW]<br>`getSetISOWeekYear()` — [NEEDS REVIEW]<br>`getISOWeeksInYear()` — [NEEDS REVIEW]<br>`getWeeksInYear()` — [NEEDS REVIEW]<br>`getSetWeekYearHelper()` — [NEEDS REVIEW]<br>`setWeekAll()` — [NEEDS REVIEW]<br>`getSetQuarter()` — [NEEDS REVIEW]<br>`getSetDayOfYear()` — [NEEDS REVIEW]<br>`parseMs()` — [NEEDS REVIEW]<br>`getZoneAbbr()` — [NEEDS REVIEW]<br>`getZoneName()` — [NEEDS REVIEW]<br>`createUnix()` — [NEEDS REVIEW]<br>`createInZone()` — [NEEDS REVIEW]<br>`preParsePostFormat()` — [NEEDS REVIEW]<br>`listMonthsImpl()` — [NEEDS REVIEW]<br>`listWeekdaysImpl()` — [NEEDS REVIEW]<br>`listMonths()` — [NEEDS REVIEW]<br>`listMonthsShort()` — [NEEDS REVIEW]<br>`listWeekdays()` — [NEEDS REVIEW]<br>`listWeekdaysShort()` — [NEEDS REVIEW]<br>`listWeekdaysMin()` — [NEEDS REVIEW]<br>`abs()` — [NEEDS REVIEW]<br>`absCeil()` — [NEEDS REVIEW]<br>`bubble()` — [NEEDS REVIEW]<br>`daysToMonths()` — [NEEDS REVIEW]<br>`monthsToDays()` — [NEEDS REVIEW]<br>`as()` — [NEEDS REVIEW]<br>`makeAs()` — [NEEDS REVIEW]<br>`makeGetter()` — [NEEDS REVIEW]<br>`weeks()` — [NEEDS REVIEW]<br>`substituteTimeAgo()` — [NEEDS REVIEW]<br>`getSetRelativeTimeRounding()` — [NEEDS REVIEW]<br>`getSetRelativeTimeThreshold()` — [NEEDS REVIEW]<br>`humanize()` — [NEEDS REVIEW]<br>`sign()` — [NEEDS REVIEW]<br>`computeMinSampleSize()` — [NEEDS REVIEW]<br>`computeFitCategoryTraits()` — [NEEDS REVIEW]<br>`computeFlexCategoryTraits()` — [NEEDS REVIEW]<br>`lineEnabled()` — [NEEDS REVIEW]<br>`capControlPoint()` — [NEEDS REVIEW]<br>`initConfig()` — [NEEDS REVIEW]<br>`updateConfig()` — [NEEDS REVIEW]<br>`positionIsHorizontal()` — [NEEDS REVIEW]<br>`listenArrayEvents()` — [NEEDS REVIEW]<br>`unlistenArrayEvents()` — [NEEDS REVIEW]<br>`interpolate()` — [NEEDS REVIEW]<br>`parseMaxStyle()` — [NEEDS REVIEW]<br>`isConstrainedValue()` — [NEEDS REVIEW]<br>`getConstraintDimension()` — [NEEDS REVIEW]<br>`getRelativePosition()` — [NEEDS REVIEW]<br>`parseVisibleItems()` — [NEEDS REVIEW]<br>`getIntersectItems()` — [NEEDS REVIEW]<br>`getNearestItems()` — [NEEDS REVIEW]<br>`getDistanceMetricForAxis()` — [NEEDS REVIEW]<br>`indexMode()` — [NEEDS REVIEW]<br>`filterByPosition()` — [NEEDS REVIEW]<br>`sortByWeight()` — [NEEDS REVIEW]<br>`getMinimumBoxSize()` — [NEEDS REVIEW]<br>`fitBox()` — [NEEDS REVIEW]<br>`finalFitVerticalBox()` — [NEEDS REVIEW]<br>`placeBox()` — [NEEDS REVIEW]<br>`labelsFromTicks()` — [NEEDS REVIEW]<br>`getLineValue()` — [NEEDS REVIEW]<br>`computeTextSize()` — [NEEDS REVIEW]<br>`parseFontOptions()` — [NEEDS REVIEW]<br>`parseLineHeight()` — [NEEDS REVIEW]<br>`mergeOpacity()` — [NEEDS REVIEW]<br>`pushOrConcat()` — [NEEDS REVIEW]<br>`splitNewlines()` — [NEEDS REVIEW]<br>`createTooltipItem()` — [NEEDS REVIEW]<br>`getBaseModel()` — [NEEDS REVIEW]<br>`getTooltipSize()` — [NEEDS REVIEW]<br>`determineAlignment()` — [NEEDS REVIEW]<br>`getBackgroundPoint()` — [NEEDS REVIEW]<br>`getBeforeAfterBodyLines()` — [NEEDS REVIEW]<br>`xRange()` — [NEEDS REVIEW]<br>`yRange()` — [NEEDS REVIEW]<br>`isVertical()` — [NEEDS REVIEW]<br>`getBarBounds()` — [NEEDS REVIEW]<br>`cornerAt()` — [NEEDS REVIEW]<br>`readUsedSize()` — [NEEDS REVIEW]<br>`initCanvas()` — [NEEDS REVIEW]<br>`addEventListener()` — [NEEDS REVIEW]<br>`removeEventListener()` — [NEEDS REVIEW]<br>`createEvent()` — [NEEDS REVIEW]<br>`fromNativeEvent()` — [NEEDS REVIEW]<br>`throttled()` — [NEEDS REVIEW]<br>`createResizer()` — [NEEDS REVIEW]<br>`watchForRender()` — [NEEDS REVIEW]<br>`unwatchForRender()` — [NEEDS REVIEW]<br>`addResizeListener()` — [NEEDS REVIEW]<br>`removeResizeListener()` — [NEEDS REVIEW]<br>`injectCSS()` — [NEEDS REVIEW]<br>`decodeFill()` — [NEEDS REVIEW]<br>`computeBoundary()` — [NEEDS REVIEW]<br>`resolveTarget()` — [NEEDS REVIEW]<br>`createMapper()` — [NEEDS REVIEW]<br>`isDrawable()` — [NEEDS REVIEW]<br>`drawArea()` — [NEEDS REVIEW]<br>`doFill()` — [NEEDS REVIEW]<br>`getBoxWidth()` — [NEEDS REVIEW]<br>`createNewLegendAndAttach()` — [NEEDS REVIEW]<br>`createNewTitleBlockAndAttach()` — [NEEDS REVIEW]<br>`IDMatches()` — [NEEDS REVIEW]<br>`generateTicks()` — [NEEDS REVIEW]<br>`getValueCount()` — [NEEDS REVIEW]<br>`getPointLabelFontOptions()` — [NEEDS REVIEW]<br>`measureLabelSize()` — [NEEDS REVIEW]<br>`determineLimits()` — [NEEDS REVIEW]<br>`fitWithPointLabels()` — [NEEDS REVIEW]<br>`fit()` — [NEEDS REVIEW]<br>`getTextAlignForAngle()` — [NEEDS REVIEW]<br>`fillText()` — [NEEDS REVIEW]<br>`adjustPointPositionForLabelHeight()` — [NEEDS REVIEW]<br>`drawPointLabels()` — [NEEDS REVIEW]<br>`drawRadiusLine()` — [NEEDS REVIEW]<br>`numberOrZero()` — [NEEDS REVIEW]<br>`sorter()` — [NEEDS REVIEW]<br>`arrayUnique()` — [NEEDS REVIEW]<br>`buildLookupTable()` — [NEEDS REVIEW]<br>`lookup()` — [NEEDS REVIEW]<br>`momentify()` — [NEEDS REVIEW]<br>`parse()` — [NEEDS REVIEW]<br>`determineStepSize()` — [NEEDS REVIEW]<br>`determineUnitForAutoTicks()` — [NEEDS REVIEW]<br>`determineUnitForFormatting()` — [NEEDS REVIEW]<br>`determineMajorUnit()` — [NEEDS REVIEW]<br>`generate()` — [NEEDS REVIEW]<br>`computeOffsets()` — [NEEDS REVIEW]<br>`ticksFromTimestamps()` — [NEEDS REVIEW]<br>`determineLabelFormat()` — [NEEDS REVIEW] |
| `dash/resources/js\pages\coming-soon.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\contacts-list.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\dashboard.init.js` | JavaScript | [Admin] dashboard.init.js file | `getChartColorsArray()` — [NEEDS REVIEW] |
| `dash/resources/js\pages\ecommerce-choices.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\ecommerce-customers.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\ecommerce-orders.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\ecommerce-product-detail.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\ecommerce-shops.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\email-editor.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\fontawesome.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\form-advanced.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\form-editor.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\form-mask.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\form-validation.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\form-wizard.init.js` | JavaScript | [Admin] form-wizard.init.js file | `showTab()` — [NEEDS REVIEW]<br>`nextPrev()` — [NEEDS REVIEW]<br>`fixStepIndicator()` — [NEEDS REVIEW] |
| `dash/resources/js\pages\gmaps.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\gridjs.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\invoice-list.init.js` | JavaScript | [Admin] invoice-list.init.js file | `showTab()` — [NEEDS REVIEW]<br>`nextPrev()` — [NEEDS REVIEW]<br>`fixStepIndicator()` — [NEEDS REVIEW] |
| `dash/resources/js\pages\leaflet-map.init.js` | JavaScript | [Admin] leaflet-map.init.js file | `getColor()` — [NEEDS REVIEW]<br>`style()` — [NEEDS REVIEW] |
| `dash/resources/js\pages\leaflet-us-states.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\lightbox.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\materialdesign.init.js` | JavaScript | [Admin] materialdesign.init.js file | `isNew()` — [NEEDS REVIEW]<br>`isDeprecated()` — [NEEDS REVIEW]<br>`copyText()` — [NEEDS REVIEW]<br>`getIconItem()` — [NEEDS REVIEW] |
| `dash/resources/js\pages\modal.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\notification.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\product-filter-range.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\rangeslider.init.js` | JavaScript | [Admin] rangeslider.init.js file | `crossUpdate()` — [NEEDS REVIEW]<br>`setLockedValues()` — [NEEDS REVIEW] |
| `dash/resources/js\pages\rating.init.js` | JavaScript | [Admin] rating.init.js file | `rateCallback()` — [NEEDS REVIEW] |
| `dash/resources/js\pages\sweet-alerts.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\timeline.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/js\pages\two-step-verification.init.js` | JavaScript | [Admin] two-step-verification.init.js file | `moveToNext()` — [NEEDS REVIEW] |
| `dash/resources/js\pages\vector-maps.init.js` | JavaScript | [Admin] JavaScript initialization/utility | — |
| `dash/resources/views\apps-calendar.blade.php` | Blade View | [Admin] Blade template: apps-calendar.blade.php | — |
| `dash/resources/views\apps-chat.blade.php` | Blade View | [Admin] Blade template: apps-chat.blade.php | — |
| `dash/resources/views\auth-confirm-mail.blade.php` | Blade View | [Admin] Blade template: auth-confirm-mail.blade.php | — |
| `dash/resources/views\auth-email-verification.blade.php` | Blade View | [Admin] Blade template: auth-email-verification.blade.php | — |
| `dash/resources/views\auth-lock-screen.blade.php` | Blade View | [Admin] Blade template: auth-lock-screen.blade.php | — |
| `dash/resources/views\auth-login.blade.php` | Blade View | [Admin] Blade template: auth-login.blade.php | — |
| `dash/resources/views\auth-logout.blade.php` | Blade View | [Admin] Blade template: auth-logout.blade.php | — |
| `dash/resources/views\auth-recoverpw.blade.php` | Blade View | [Admin] Blade template: auth-recoverpw.blade.php | — |
| `dash/resources/views\auth-register.blade.php` | Blade View | [Admin] Blade template: auth-register.blade.php | — |
| `dash/resources/views\auth-two-step-verification.blade.php` | Blade View | [Admin] Blade template: auth-two-step-verification.blade.php | — |
| `dash/resources/views\charts-apex.blade.php` | Blade View | [Admin] Blade template: charts-apex.blade.php | — |
| `dash/resources/views\charts-chartjs.blade.php` | Blade View | [Admin] Blade template: charts-chartjs.blade.php | — |
| `dash/resources/views\contacts-grid.blade.php` | Blade View | [Admin] Blade template: contacts-grid.blade.php | — |
| `dash/resources/views\contacts-list.blade.php` | Blade View | [Admin] Blade template: contacts-list.blade.php | — |
| `dash/resources/views\contacts-profile.blade.php` | Blade View | [Admin] Blade template: contacts-profile.blade.php | — |
| `dash/resources/views\ecommerce-add-product.blade.php` | Blade View | [Admin] Blade template: ecommerce-add-product.blade.php | — |
| `dash/resources/views\ecommerce-cart.blade.php` | Blade View | [Admin] Blade template: ecommerce-cart.blade.php | — |
| `dash/resources/views\ecommerce-checkout.blade.php` | Blade View | [Admin] Blade template: ecommerce-checkout.blade.php | — |
| `dash/resources/views\ecommerce-customers.blade.php` | Blade View | [Admin] Blade template: ecommerce-customers.blade.php | — |
| `dash/resources/views\ecommerce-orders.blade.php` | Blade View | [Admin] Blade template: ecommerce-orders.blade.php | — |
| `dash/resources/views\ecommerce-product-detail.blade.php` | Blade View | [Admin] Blade template: ecommerce-product-detail.blade.php | — |
| `dash/resources/views\ecommerce-products.blade.php` | Blade View | [Admin] Blade template: ecommerce-products.blade.php | — |
| `dash/resources/views\ecommerce-shops.blade.php` | Blade View | [Admin] Blade template: ecommerce-shops.blade.php | — |
| `dash/resources/views\email-inbox.blade.php` | Blade View | [Admin] Blade template: email-inbox.blade.php | — |
| `dash/resources/views\email-read.blade.php` | Blade View | [Admin] Blade template: email-read.blade.php | — |
| `dash/resources/views\extended-lightbox.blade.php` | Blade View | [Admin] Blade template: extended-lightbox.blade.php | — |
| `dash/resources/views\extended-notifications.blade.php` | Blade View | [Admin] Blade template: extended-notifications.blade.php | — |
| `dash/resources/views\extended-rangeslider.blade.php` | Blade View | [Admin] Blade template: extended-rangeslider.blade.php | — |
| `dash/resources/views\extended-rating.blade.php` | Blade View | [Admin] Blade template: extended-rating.blade.php | — |
| `dash/resources/views\extended-sweet-alert.blade.php` | Blade View | [Admin] Blade template: extended-sweet-alert.blade.php | — |
| `dash/resources/views\form-advanced.blade.php` | Blade View | [Admin] Blade template: form-advanced.blade.php | — |
| `dash/resources/views\form-editors.blade.php` | Blade View | [Admin] Blade template: form-editors.blade.php | — |
| `dash/resources/views\form-elements.blade.php` | Blade View | [Admin] Blade template: form-elements.blade.php | — |
| `dash/resources/views\form-mask.blade.php` | Blade View | [Admin] Blade template: form-mask.blade.php | — |
| `dash/resources/views\form-uploads.blade.php` | Blade View | [Admin] Blade template: form-uploads.blade.php | — |
| `dash/resources/views\form-validation.blade.php` | Blade View | [Admin] Blade template: form-validation.blade.php | — |
| `dash/resources/views\form-wizard.blade.php` | Blade View | [Admin] Blade template: form-wizard.blade.php | — |
| `dash/resources/views\icons-boxicons.blade.php` | Blade View | [Admin] Blade template: icons-boxicons.blade.php | — |
| `dash/resources/views\icons-dripicons.blade.php` | Blade View | [Admin] Blade template: icons-dripicons.blade.php | — |
| `dash/resources/views\icons-feather.blade.php` | Blade View | [Admin] Blade template: icons-feather.blade.php | — |
| `dash/resources/views\icons-fontawesome.blade.php` | Blade View | [Admin] Blade template: icons-fontawesome.blade.php | — |
| `dash/resources/views\icons-materialdesign.blade.php` | Blade View | [Admin] Blade template: icons-materialdesign.blade.php | — |
| `dash/resources/views\index.blade.php` | Blade View | [Admin] Blade template: index.blade.php | — |
| `dash/resources/views\invoicePages\export_commercial_invoice.blade.php` | Blade View | [Admin] Blade template: export_commercial_invoice.blade.php | — |
| `dash/resources/views\invoicePages\export_packing_list.blade.php` | Blade View | [Admin] Blade template: export_packing_list.blade.php | — |
| `dash/resources/views\invoicePages\product_orders_invoice.blade.php` | Blade View | [Admin] Blade template: product_orders_invoice.blade.php | — |
| `dash/resources/views\invoices-detail.blade.php` | Blade View | [Admin] Blade template: invoices-detail.blade.php | — |
| `dash/resources/views\invoices-list.blade.php` | Blade View | [Admin] Blade template: invoices-list.blade.php | — |
| `dash/resources/views\layouts-vertical.blade.php` | Blade View | [Admin] Blade template: layouts-vertical.blade.php | — |
| `dash/resources/views\maps-google.blade.php` | Blade View | [Admin] Blade template: maps-google.blade.php | — |
| `dash/resources/views\maps-leaflet.blade.php` | Blade View | [Admin] Blade template: maps-leaflet.blade.php | — |
| `dash/resources/views\maps-vector.blade.php` | Blade View | [Admin] Blade template: maps-vector.blade.php | — |
| `dash/resources/views\pages-404.blade.php` | Blade View | [Admin] Blade template: pages-404.blade.php | — |
| `dash/resources/views\pages-500.blade.php` | Blade View | [Admin] Blade template: pages-500.blade.php | — |
| `dash/resources/views\pages-comingsoon.blade.php` | Blade View | [Admin] Blade template: pages-comingsoon.blade.php | — |
| `dash/resources/views\pages-faqs.blade.php` | Blade View | [Admin] Blade template: pages-faqs.blade.php | — |
| `dash/resources/views\pages-maintenance.blade.php` | Blade View | [Admin] Blade template: pages-maintenance.blade.php | — |
| `dash/resources/views\pages-pricing.blade.php` | Blade View | [Admin] Blade template: pages-pricing.blade.php | — |
| `dash/resources/views\pages-starter.blade.php` | Blade View | [Admin] Blade template: pages-starter.blade.php | — |
| `dash/resources/views\pages-timeline.blade.php` | Blade View | [Admin] Blade template: pages-timeline.blade.php | — |
| `dash/resources/views\pages\areas.blade.php` | Blade View | [Admin] Blade template: areas.blade.php | — |
| `dash/resources/views\pages\bank_details.blade.php` | Blade View | [Admin] Blade template: bank_details.blade.php | — |
| `dash/resources/views\pages\banner_images.blade.php` | Blade View | [Admin] Blade template: banner_images.blade.php | — |
| `dash/resources/views\pages\bulk_orders.blade.php` | Blade View | [Admin] Blade template: bulk_orders.blade.php | — |
| `dash/resources/views\tables-advanced.blade.php` | Blade View | [Admin] Blade template: tables-advanced.blade.php | — |
| `dash/resources/views\tables-basic.blade.php` | Blade View | [Admin] Blade template: tables-basic.blade.php | — |
| `dash/resources/views\ui-alerts.blade.php` | Blade View | [Admin] Blade template: ui-alerts.blade.php | — |
| `dash/resources/views\ui-buttons.blade.php` | Blade View | [Admin] Blade template: ui-buttons.blade.php | — |
| `dash/resources/views\ui-cards.blade.php` | Blade View | [Admin] Blade template: ui-cards.blade.php | — |
| `dash/resources/views\ui-carousel.blade.php` | Blade View | [Admin] Blade template: ui-carousel.blade.php | — |
| `dash/resources/views\ui-colors.blade.php` | Blade View | [Admin] Blade template: ui-colors.blade.php | — |
| `dash/resources/views\ui-dropdowns.blade.php` | Blade View | [Admin] Blade template: ui-dropdowns.blade.php | — |
| `dash/resources/views\ui-general.blade.php` | Blade View | [Admin] Blade template: ui-general.blade.php | — |
| `dash/resources/views\ui-grid.blade.php` | Blade View | [Admin] Blade template: ui-grid.blade.php | — |
| `dash/resources/views\ui-images.blade.php` | Blade View | [Admin] Blade template: ui-images.blade.php | — |
| `dash/resources/views\ui-modals.blade.php` | Blade View | [Admin] Blade template: ui-modals.blade.php | — |
| `dash/resources/views\ui-offcanvas.blade.php` | Blade View | [Admin] Blade template: ui-offcanvas.blade.php | — |
| `dash/resources/views\ui-placeholders.blade.php` | Blade View | [Admin] Blade template: ui-placeholders.blade.php | — |
| `dash/resources/views\ui-progressbars.blade.php` | Blade View | [Admin] Blade template: ui-progressbars.blade.php | — |
| `dash/resources/views\ui-tabs-accordions.blade.php` | Blade View | [Admin] Blade template: ui-tabs-accordions.blade.php | — |
| `dash/resources/views\ui-typography.blade.php` | Blade View | [Admin] Blade template: ui-typography.blade.php | — |
| `dash/resources/views\ui-video.blade.php` | Blade View | [Admin] Blade template: ui-video.blade.php | — |

### Products

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\ProductController.php` | Controller | [Admin] HTTP controller for Products features | `index()` — Display list/overview page<br>`destroyVarientThumpImages()` — [NEEDS REVIEW]<br>`create()` — Show form to create new record<br>`store()` — Validate & save new record to DB<br>`show()` — Display single record details<br>`edit()` — Show form to edit existing record<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB<br>`productImageUpload()` — File upload logic<br>`getProductDetail()` — [NEEDS REVIEW]<br>`createMilkSubscription()` — [NEEDS REVIEW]<br>`addMilkOrderDeliveryAddress()` — Delivery tracking logic<br>`addProductOrderDeliveryAddress()` — Delivery tracking logic<br>`assignDeliverPersonMilkOrder()` — Delivery tracking logic<br>`createProductSubscription()` — [NEEDS REVIEW]<br>`assignDeliverProductOrder()` — Delivery tracking logic<br>`createMilkSlot()` — [NEEDS REVIEW]<br>`createProductSlot()` — [NEEDS REVIEW]<br>`viewProductInvoice()` — Invoice generation logic<br>`exportCommercialInvoice()` — Invoice generation logic<br>`exportPackingList()` — Packing order logic<br>`getOrderProductsForExport()` — Data export logic<br>`upadetstatus()` — [NEEDS REVIEW]<br>`pickupstatus()` — [NEEDS REVIEW]<br>`getproductfilter()` — [NEEDS REVIEW]<br>`updaterefund()` — Refund processing logic<br>`Getsubproo()` — [NEEDS REVIEW]<br>`getthump()` — [NEEDS REVIEW]<br>`saveExportFormData()` — Data export logic<br>`getExportFormData()` — Data export logic |
| `dash/app\Http\Controllers\ProductSlotController.php` | Controller | [Admin] HTTP controller for Products features | `getProductSlots()` — [NEEDS REVIEW]<br>`getProductSlotss()` — [NEEDS REVIEW]<br>`cancelProductSlot()` — Order cancellation logic<br>`cancelrequests()` — Order cancellation logic<br>`approverequest()` — [NEEDS REVIEW]<br>`returnrequests()` — Product return logic<br>`approveReturnRequest()` — Product return logic<br>`rejectReturnRequests()` — Product return logic |
| `dash/app\Http\Controllers\ProductThumController.php` | Controller | [Admin] HTTP controller for Products features | `index()` — Display list/overview page<br>`ThumImages()` — [NEEDS REVIEW]<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB |
| `dash/app\Http\Controllers\ProductVarientControllet.php` | Controller | [Admin] HTTP controller for Products features | `index()` — Display list/overview page<br>`addproductvarient()` — [NEEDS REVIEW]<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB<br>`Getsubcategory()` — [NEEDS REVIEW]<br>`Getproduct()` — [NEEDS REVIEW]<br>`getproductverfilter()` — [NEEDS REVIEW] |
| `dash/app\Http\Controllers\TodayDealsController.php` | Controller | [Admin] HTTP controller for Products features | `index()` — Display list/overview page<br>`store()` — Validate & save new record to DB<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB |
| `dash/resources/views\pages\product_slots.blade.php` | Blade View | [Admin] Blade template: product_slots.blade.php | — |
| `dash/resources/views\pages\product_varient.blade.php` | Blade View | [Admin] Blade template: product_varient.blade.php | — |
| `dash/resources/views\pages\products.blade.php` | Blade View | [Admin] Blade template: products.blade.php | — |
| `dash/resources/views\pages\productthum.blade.php` | Blade View | [Admin] Blade template: productthum.blade.php | — |
| `dash/resources/views\pages\reviews.blade.php` | Blade View | [Admin] Blade template: reviews.blade.php | — |
| `dash/resources/views\pages\todaydeals.blade.php` | Blade View | [Admin] Blade template: todaydeals.blade.php | — |

### Providers

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Providers\AppServiceProvider.php` | Provider | [Admin] Service provider | `register()` — Register services into service container<br>`boot()` — Boot method: register events/policies |
| `dash/app\Providers\AuthServiceProvider.php` | Provider | [Admin] Service provider | `boot()` — Boot method: register events/policies |
| `dash/app\Providers\BroadcastServiceProvider.php` | Provider | [Admin] Service provider | `boot()` — Boot method: register events/policies |
| `dash/app\Providers\EventServiceProvider.php` | Provider | [Admin] Service provider | `boot()` — Boot method: register events/policies |
| `dash/app\Providers\RouteServiceProvider.php` | Provider | [Admin] Service provider | `boot()` — Boot method: register events/policies<br>`configureRateLimiting()` — [NEEDS REVIEW] |
| `dash/app\Providers\TelescopeServiceProvider.php` | Provider | [Admin] Service provider | `register()` — Register services into service container<br>`hideSensitiveRequestDetails()` — [NEEDS REVIEW]<br>`gate()` — [NEEDS REVIEW] |

### Reports

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Exports\OrderReportExport.php` | Export | [Admin] Spreadsheet export class | `__construct()` — Constructor: initializes class dependencies |
| `dash/app\Exports\ProductWiseReportExport.php` | Export | [Admin] Spreadsheet export class | `__construct()` — Constructor: initializes class dependencies |
| `dash/app\Http\Controllers\ReportsController.php` | Controller | [Admin] HTTP controller for Reports features | `incomeReports()` — Report generation<br>`getIncomeReports()` — Report generation |
| `dash/app\Http\Controllers\TopCustomerController.php` | Controller | [Admin] HTTP controller for Reports features | `index()` — Display list/overview page |
| `dash/resources/views\exports\orderwise.blade.php` | Blade View | [Admin] Blade template: orderwise.blade.php | — |
| `dash/resources/views\exports\productwise.blade.php` | Blade View | [Admin] Blade template: productwise.blade.php | — |
| `dash/resources/views\pages\highselling.blade.php` | Blade View | [Admin] Blade template: highselling.blade.php | — |
| `dash/resources/views\pages\income_reports.blade.php` | Blade View | [Admin] Blade template: income_reports.blade.php | — |
| `dash/resources/views\pages\orderwisereport.blade.php` | Blade View | [Admin] Blade template: orderwisereport.blade.php | — |
| `dash/resources/views\pages\topcustomer.blade.php` | Blade View | [Admin] Blade template: topcustomer.blade.php | — |

### Routes

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/routes\api.php` | Routes | [Admin] Route definitions | `[Route] middleware()` — Registers middleware HTTP route(s)<br>`[Route] get()` — Registers get HTTP route(s) |
| `dash/routes\channels.php` | Routes | [Admin] channels.php file | — |
| `dash/routes\console.php` | Routes | [Admin] console.php file | — |
| `dash/routes\web.php` | Routes | [Admin] Route definitions | `[Route] middleware()` — Registers middleware HTTP route(s)<br>`[Route] get()` — Registers get HTTP route(s)<br>`[Route] resource()` — Registers resource HTTP route(s)<br>`[Route] post()` — Registers post HTTP route(s)<br>`[Route] Post()` — Registers Post HTTP route(s)<br>`[Route] POST()` — Registers POST HTTP route(s)<br>`[Route] delete()` — Registers delete HTTP route(s) |

### SMS

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\sendsms.php` | Controller | [Admin] HTTP controller for SMS features | `__construct()` — Constructor: initializes class dependencies<br>`__destruct()` — [NEEDS REVIEW]<br>`sendme()` — Send notification/email/sms<br>`sendmessage()` — Send notification/email/sms<br>`checkdlr()` — [NEEDS REVIEW]<br>`availablecredit()` — [NEEDS REVIEW] |

### Samples

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\SamplesController.php` | Controller | [Admin] HTTP controller for Samples features | `index()` — Display list/overview page<br>`store()` — Validate & save new record to DB<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB |
| `dash/resources/views\pages\samples.blade.php` | Blade View | [Admin] Blade template: samples.blade.php | — |

### Services

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Services\CurrencyService.php` | Service | [Admin] Business logic service | `getSupportedCurrencies()` — [NEEDS REVIEW]<br>`convert()` — Convert amount between currencies<br>`getRate()` — [NEEDS REVIEW]<br>`fetchRateFromApi()` — [NEEDS REVIEW]<br>`updateRates()` — [NEEDS REVIEW]<br>`updateDatabaseRate()` — [NEEDS REVIEW] |

### Settings

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\AppSettingsController.php` | Controller | [Admin] HTTP controller for Settings features | `index()` — Display list/overview page<br>`update()` — Validate & update existing record in DB<br>`updateSizeChart()` — [NEEDS REVIEW]<br>`updateCheckoutSettings()` — [NEEDS REVIEW] |
| `dash/resources/views\pages\settings.blade.php` | Blade View | [Admin] Blade template: settings.blade.php | — |

### Shipping

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\ShippingController.php` | Controller | [Admin] HTTP controller for Shipping features | `getship()` — Shipping/tracking logic<br>`addshipping()` — Shipping/tracking logic<br>`updateship()` — Shipping/tracking logic<br>`destroyshipping()` — Shipping/tracking logic |
| `dash/resources/views\pages\shippings.blade.php` | Blade View | [Admin] Blade template: shippings.blade.php | — |

### Users

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\UserController.php` | Controller | [Admin] HTTP controller for Users features | `index()` — Display list/overview page<br>`create()` — Show form to create new record<br>`store()` — Validate & save new record to DB<br>`show()` — Display single record details<br>`edit()` — Show form to edit existing record<br>`update()` — Validate & update existing record in DB<br>`destroy()` — Delete record from DB<br>`getProductsOptions()` — [NEEDS REVIEW]<br>`getProductsverentOptions()` — [NEEDS REVIEW]<br>`getProductsverentqty()` — [NEEDS REVIEW]<br>`getcustomersummery()` — [NEEDS REVIEW]<br>`updatePass()` — [NEEDS REVIEW]<br>`addaddressvalue()` — [NEEDS REVIEW]<br>`Getcity()` — [NEEDS REVIEW]<br>`getAddressDetails()` — [NEEDS REVIEW]<br>`getAddressDetails1()` — [NEEDS REVIEW] |
| `dash/resources/views\pages\customer.blade.php` | Blade View | [Admin] Blade template: customer.blade.php | — |
| `dash/resources/views\pages\customer_edit.blade.php` | Blade View | [Admin] Blade template: customer_edit.blade.php | — |

### Utility

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `dash/app\Http\Controllers\TestController.php` | Controller | [Admin] HTTP controller for Utility features | `test()` — [NEEDS REVIEW] |

## Application: Customer-Facing Web App (web/)

### Auth

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\AuthController.php` | Controller | [Web] HTTP controller for Auth features | `showRegister()` — Registration logic<br>`register()` — Register services into service container<br>`showLogin()` — Login/authentication logic<br>`login()` — Login/authentication logic<br>`logout()` — Logout logic<br>`showForgotPassword()` — OTP generation/verification<br>`sendOTP()` — OTP generation/verification<br>`verifyOTP()` — OTP generation/verification<br>`resetPassword()` — Password reset flow |
| `web/resources/views\pages\forgot-password.blade.php` | Blade View | [Web] Blade template: forgot-password.blade.php | — |
| `web/resources/views\pages\login.blade.php` | Blade View | [Web] Blade template: login.blade.php | — |
| `web/resources/views\pages\register.blade.php` | Blade View | [Web] Blade template: register.blade.php | — |

### Bank Details

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/resources/views\pages\bank-details.blade.php` | Blade View | [Web] Blade template: bank-details.blade.php | — |

### Cart/Checkout

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\CartController.php` | Controller | [Web] HTTP controller for Cart/Checkout features | `index()` — Display list/overview page<br>`addToCart()` — [NEEDS REVIEW]<br>`removeItem()` — [NEEDS REVIEW]<br>`updateQuantity()` — [NEEDS REVIEW] |
| `web/resources/views\pages\cart.blade.php` | Blade View | [Web] Blade template: cart.blade.php | — |
| `web/resources/views\pages\checkout.blade.php` | Blade View | [Web] Blade template: checkout.blade.php | — |

### Categories

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\CategoriesController.php` | Controller | [Web] HTTP controller for Categories features | `index()` — Display list/overview page |
| `web/resources/views\pages\categories.blade.php` | Blade View | [Web] Blade template: categories.blade.php | — |

### Components

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/resources/views\components\design-preview.blade.php` | Blade View | [Web] Blade template: design-preview.blade.php | — |

### Config

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/config\app.php` | Config | [Web] Configuration: app settings | — |
| `web/config\auth.php` | Config | [Web] Configuration: auth settings | — |
| `web/config\cache.php` | Config | [Web] Configuration: cache settings | — |
| `web/config\cors.php` | Config | [Web] Configuration: cors settings | — |
| `web/config\database.php` | Config | [Web] Configuration: database settings | — |
| `web/config\filesystems.php` | Config | [Web] Configuration: filesystems settings | — |
| `web/config\logging.php` | Config | [Web] Configuration: logging settings | — |
| `web/config\mail.php` | Config | [Web] Configuration: mail settings | — |
| `web/config\queue.php` | Config | [Web] Configuration: queue settings | — |
| `web/config\services.php` | Config | [Web] Configuration: services settings | — |
| `web/config\session.php` | Config | [Web] Configuration: session settings | — |

### Console

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Console\Commands\UpdateExchangeRates.php` | Console Command | [Web] Artisan command | `handle()` — Process incoming HTTP request |

### Contact

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\ContactController.php` | Controller | [Web] HTTP controller for Contact features | `store()` — Validate & save new record to DB |
| `web/resources/views\pages\contact.blade.php` | Blade View | [Web] Blade template: contact.blade.php | — |

### Content Pages

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/resources/views\pages\about.blade.php` | Blade View | [Web] Blade template: about.blade.php | — |
| `web/resources/views\pages\privacy-policy.blade.php` | Blade View | [Web] Blade template: privacy-policy.blade.php | — |
| `web/resources/views\pages\refund-policy.blade.php` | Blade View | [Web] Blade template: refund-policy.blade.php | — |
| `web/resources/views\pages\shipping-policy.blade.php` | Blade View | [Web] Blade template: shipping-policy.blade.php | — |
| `web/resources/views\pages\terms-and-conditions.blade.php` | Blade View | [Web] Blade template: terms-and-conditions.blade.php | — |

### Currency

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\CurrencyController.php` | Controller | [Web] HTTP controller for Currency features | `__construct()` — Constructor: initializes class dependencies<br>`index()` — Display list/overview page<br>`switchCurrency()` — [NEEDS REVIEW]<br>`switchCurrencyByGet()` — [NEEDS REVIEW]<br>`performSwitch()` — [NEEDS REVIEW]<br>`convert()` — Convert amount between currencies |

### Custom Products

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\CustomProductController.php` | Controller | [Web] HTTP controller for Custom Products features | `index()` — Display list/overview page<br>`show()` — Display single record details<br>`getDesignerData()` — [NEEDS REVIEW]<br>`getDesignerDataFixed()` — [NEEDS REVIEW]<br>`picker()` — [NEEDS REVIEW] |
| `web/resources/views\pages\customize-products.blade.php` | Blade View | [Web] Blade template: customize-products.blade.php | — |

### Dashboard

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\HomeController.php` | Controller | [Web] HTTP controller for Dashboard features | `index()` — Display list/overview page |
| `web/resources/views\pages\home.blade.php` | Blade View | [Web] Blade template: home.blade.php | — |

### Database

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/database\factories\UserFactory.php` | Factory | [Web] UserFactory.php file | `definition()` — Define model factory default values<br>`unverified()` — Factory state: unverified |
| `web/database\seeders\AppSettingsSeeder.php` | Seeder | [Web] AppSettingsSeeder.php file | `run()` — [NEEDS REVIEW] |
| `web/database\seeders\CustomProductSeeder.php` | Seeder | [Web] CustomProductSeeder.php file | `run()` — [NEEDS REVIEW] |
| `web/database\seeders\CustomizerSeeder.php` | Seeder | [Web] CustomizerSeeder.php file | `run()` — [NEEDS REVIEW] |
| `web/database\seeders\DatabaseSeeder.php` | Seeder | [Web] DatabaseSeeder.php file | `run()` — [NEEDS REVIEW] |
| `web/database\seeders\ProductColorSeeder.php` | Seeder | [Web] ProductColorSeeder.php file | `run()` — [NEEDS REVIEW] |
| `web/database\seeders\SampleSeeder.php` | Seeder | [Web] SampleSeeder.php file | `run()` — [NEEDS REVIEW] |
| `web/database\seeders\ShopDataSeeder.php` | Seeder | [Web] ShopDataSeeder.php file | `run()` — [NEEDS REVIEW] |
| `web/database\seeders\SizeChartSeeder.php` | Seeder | [Web] SizeChartSeeder.php file | `run()` — [NEEDS REVIEW] |

### Designs

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\CustomDesignController.php` | Controller | [Web] HTTP controller for Designs features | `init()` — [NEEDS REVIEW]<br>`store()` — Validate & save new record to DB<br>`show()` — Display single record details<br>`myDesigns()` — [NEEDS REVIEW]<br>`update()` — Validate & update existing record in DB<br>`saveOrganizedImage()` — [NEEDS REVIEW]<br>`destroy()` — Delete record from DB<br>`validatePrintBoundaries()` — Print/preview logic<br>`saveBase64Image()` — [NEEDS REVIEW]<br>`uploadUserImage()` — File upload logic<br>`uploadExport()` — Data export logic |
| `web/app\Http\Controllers\DesignController.php` | Controller | [Web] HTTP controller for Designs features | `index()` — Display list/overview page |
| `web/resources/views\pages\custom-designer.blade.php` | Blade View | [Web] Blade template: custom-designer.blade.php | — |
| `web/resources/views\pages\own-design.blade.php` | Blade View | [Web] Blade template: own-design.blade.php | — |

### Emails

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/resources/views\emails\admin-order-notification.blade.php` | Blade View | [Web] Blade template: admin-order-notification.blade.php | — |
| `web/resources/views\emails\bulk-order-inquiry.blade.php` | Blade View | [Web] Blade template: bulk-order-inquiry.blade.php | — |
| `web/resources/views\emails\bulk-order-user-receipt.blade.php` | Blade View | [Web] Blade template: bulk-order-user-receipt.blade.php | — |
| `web/resources/views\emails\contact-form-notification.blade.php` | Blade View | [Web] Blade template: contact-form-notification.blade.php | — |
| `web/resources/views\emails\forgot-password-otp.blade.php` | Blade View | [Web] Blade template: forgot-password-otp.blade.php | — |
| `web/resources/views\emails\order-success.blade.php` | Blade View | [Web] Blade template: order-success.blade.php | — |
| `web/resources/views\emails\registration-success.blade.php` | Blade View | [Web] Blade template: registration-success.blade.php | — |

### Helpers

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Helpers\helpers.php` | Helper | [Web] Global helper functions | `gt()` — [NEEDS REVIEW]<br>`format_currency()` — Format number as currency string<br>`get_app_setting()` — [NEEDS REVIEW] |

### Layouts

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/resources/views\layouts\app.blade.php` | Blade View | [Web] Blade template: app.blade.php | — |
| `web/resources/views\layouts\footer.blade.php` | Blade View | [Web] Blade template: footer.blade.php | — |
| `web/resources/views\layouts\header.blade.php` | Blade View | [Web] Blade template: header.blade.php | — |

### Localization

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\LanguageController.php` | Controller | [Web] LanguageController.php file | — |

### Mail

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Mail\AdminOrderNotification.php` | Mailable | [Web] Email mailable | `__construct()` — Constructor: initializes class dependencies<br>`envelope()` — Define email envelope<br>`content()` — Define email content view<br>`attachments()` — Define email attachments |
| `web/app\Mail\BulkOrderInquiryMail.php` | Mailable | [Web] Email mailable | `__construct()` — Constructor: initializes class dependencies<br>`envelope()` — Define email envelope<br>`content()` — Define email content view<br>`attachments()` — Define email attachments |
| `web/app\Mail\BulkOrderUserMail.php` | Mailable | [Web] Email mailable | `__construct()` — Constructor: initializes class dependencies<br>`envelope()` — Define email envelope<br>`content()` — Define email content view<br>`attachments()` — Define email attachments |
| `web/app\Mail\ContactFormNotification.php` | Mailable | [Web] Email mailable | `__construct()` — Constructor: initializes class dependencies<br>`envelope()` — Define email envelope<br>`content()` — Define email content view<br>`attachments()` — Define email attachments |
| `web/app\Mail\ForgotPasswordOTP.php` | Mailable | [Web] Email mailable | `__construct()` — Constructor: initializes class dependencies<br>`envelope()` — Define email envelope<br>`content()` — Define email content view<br>`attachments()` — Define email attachments |
| `web/app\Mail\OrderSuccess.php` | Mailable | [Web] Email mailable | `__construct()` — Constructor: initializes class dependencies<br>`envelope()` — Define email envelope<br>`content()` — Define email content view<br>`attachments()` — Define email attachments |
| `web/app\Mail\RegistrationSuccess.php` | Mailable | [Web] Email mailable | `__construct()` — Constructor: initializes class dependencies<br>`envelope()` — Define email envelope<br>`content()` — Define email content view<br>`attachments()` — Define email attachments |

### Middleware

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Middleware\SetCurrency.php` | Middleware | [Web] HTTP middleware | `handle()` — Process incoming HTTP request |
| `web/app\Http\Middleware\SetLocale.php` | Middleware | [Web] HTTP middleware | `handle()` — Process incoming HTTP request |

### Migrations

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/database\migrations\2026_01_07_114636_add_title_subtitle_to_banner_images_table.php` | Migration | [Web] 2026_01_07_114636_add_title_subtitle_to_banner_images_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_01_07_143407_create_designs_table.php` | Migration | [Web] 2026_01_07_143407_create_designs_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_01_07_153616_create_samples_table.php` | Migration | [Web] 2026_01_07_153616_create_samples_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_01_07_154341_add_price_and_sizes_to_samples_table.php` | Migration | [Web] 2026_01_07_154341_add_price_and_sizes_to_samples_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_01_07_182738_create_sample_order_full_details_table.php` | Migration | [Web] 2026_01_07_182738_create_sample_order_full_details_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_01_08_171934_create_contact_messages_table.php` | Migration | [Web] 2026_01_08_171934_create_contact_messages_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_01_10_155846_create_customproducts_table.php` | Migration | [Web] 2026_01_10_155846_create_customproducts_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_01_10_155848_create_customproduct_designs_table.php` | Migration | [Web] 2026_01_10_155848_create_customproduct_designs_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_01_10_155849_create_design_layers_table.php` | Migration | [Web] 2026_01_10_155849_create_design_layers_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_01_10_155851_add_design_id_to_carts_table.php` | Migration | [Web] 2026_01_10_155851_add_design_id_to_carts_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_05_103004_normalize_print_position_in_design_layers.php` | Migration | [Web] 2026_02_05_103004_normalize_print_position_in_design_layers.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_10_152000_change_user_id_type_in_customproduct_designs_table.php` | Migration | [Web] 2026_02_10_152000_change_user_id_type_in_customproduct_designs_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_10_153748_add_defaults_to_order_tables.php` | Migration | [Web] 2026_02_10_153748_add_defaults_to_order_tables.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_12_055000_rename_razorpay_columns_to_paypal.php` | Migration | [Web] 2026_02_12_055000_rename_razorpay_columns_to_paypal.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_14_101051_add_payment_proof_to_product_orders.php` | Migration | [Web] 2026_02_14_101051_add_payment_proof_to_product_orders.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_16_120000_update_view_type_in_product_color_images_table.php` | Migration | [Web] 2026_02_16_120000_update_view_type_in_product_color_images_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_19_113518_add_extra_sides_to_customproduct_designs_table.php` | Migration | [Web] 2026_02_19_113518_add_extra_sides_to_customproduct_designs_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_19_120000_create_bank_details_table.php` | Migration | [Web] 2026_02_19_120000_create_bank_details_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_19_120542_add_extra_element_price_to_customproducts_table.php` | Migration | [Web] 2026_02_19_120542_add_extra_element_price_to_customproducts_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_19_121733_add_extra_details_to_cart_table.php` | Migration | [Web] 2026_02_19_121733_add_extra_details_to_cart_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_19_125709_add_session_id_to_carts_fix.php` | Migration | [Web] 2026_02_19_125709_add_session_id_to_carts_fix.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_19_145854_change_print_position_type_in_design_layers.php` | Migration | [Web] 2026_02_19_145854_change_print_position_type_in_design_layers.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_23_095038_add_user_type_and_gst_number_to_users_table.php` | Migration | [Web] 2026_02_23_095038_add_user_type_and_gst_number_to_users_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_23_100831_create_bulk_orders_table.php` | Migration | [Web] 2026_02_23_100831_create_bulk_orders_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_23_104539_create_app_settings_table.php` | Migration | [Web] 2026_02_23_104539_create_app_settings_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_24_103835_add_description_to_bank_details_table.php` | Migration | [Web] 2026_02_24_103835_add_description_to_bank_details_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_24_125832_add_address_username_to_addresses_tables.php` | Migration | [Web] 2026_02_24_125832_add_address_username_to_addresses_tables.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_25_122134_enhance_designs_and_orders_table.php` | Migration | [Web] 2026_02_25_122134_enhance_designs_and_orders_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_25_132830_make_customproduct_designs_columns_nullable.php` | Migration | [Web] 2026_02_25_132830_make_customproduct_designs_columns_nullable.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_25_182205_create_exchange_rates_table.php` | Migration | [Web] 2026_02_25_182205_create_exchange_rates_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_26_065723_create_size_charts_table.php` | Migration | [Web] 2026_02_26_065723_create_size_charts_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_26_115133_change_pincode_type_to_string_in_user_addresses.php` | Migration | [Web] 2026_02_26_115133_change_pincode_type_to_string_in_user_addresses.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_26_150913_add_multi_currency_columns_to_product_orders_table.php` | Migration | [Web] 2026_02_26_150913_add_multi_currency_columns_to_product_orders_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_02_27_063138_create_checkout_settings_table.php` | Migration | [Web] 2026_02_27_063138_create_checkout_settings_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_04_01_145753_add_source_path_to_design_layers.php` | Migration | [Web] 2026_04_01_145753_add_source_path_to_design_layers.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |
| `web/database\migrations\2026_06_13_112958_add_shoulder_mockups_to_customproducts_table.php` | Migration | [Web] 2026_06_13_112958_add_shoulder_mockups_to_customproducts_table.php file | `up()` — [NEEDS REVIEW]<br>`down()` — [NEEDS REVIEW] |

### Models

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Models\AppSetting.php` | Model | [Web] AppSetting.php file | — |
| `web/app\Models\BankDetails.php` | Model | [Web] BankDetails.php file | — |
| `web/app\Models\BannerImage.php` | Model | [Web] BannerImage.php file | — |
| `web/app\Models\BulkOrder.php` | Model | [Web] BulkOrder.php file | — |
| `web/app\Models\Cart.php` | Model | [Web] Eloquent model for Cart table | `design()` — Eloquent relationship to related model |
| `web/app\Models\Category.php` | Model | [Web] Eloquent model for Category table | `subCategories()` — Eloquent relationship to related model |
| `web/app\Models\CheckoutSetting.php` | Model | [Web] CheckoutSetting.php file | — |
| `web/app\Models\ContactMessage.php` | Model | [Web] ContactMessage.php file | — |
| `web/app\Models\Customproduct.php` | Model | [Web] Eloquent model for Customproduct table | `designs()` — Eloquent relationship to related model<br>`colors()` — Eloquent relationship to related model<br>`scopeActive()` — Query scope: Active filter |
| `web/app\Models\CustomproductDesign.php` | Model | [Web] Eloquent model for CustomproductDesign table | `customproduct()` — Eloquent relationship to related model<br>`color()` — Eloquent relationship to related model<br>`layers()` — [NEEDS REVIEW]<br>`user()` — Eloquent relationship to related model<br>`cartItems()` — [NEEDS REVIEW]<br>`frontLayers()` — [NEEDS REVIEW]<br>`backLayers()` — [NEEDS REVIEW]<br>`chestLayers()` — [NEEDS REVIEW]<br>`shoulderLayers()` — [NEEDS REVIEW] |
| `web/app\Models\Design.php` | Model | [Web] Design.php file | — |
| `web/app\Models\DesignLayer.php` | Model | [Web] Eloquent model for DesignLayer table | `design()` — Eloquent relationship to related model<br>`isWithinBounds()` — [NEEDS REVIEW] |
| `web/app\Models\ExchangeRate.php` | Model | [Web] ExchangeRate.php file | — |
| `web/app\Models\Product.php` | Model | [Web] Eloquent model for Product table | `category()` — Eloquent relationship to related model<br>`subcategory()` — Eloquent relationship to related model |
| `web/app\Models\ProductColor.php` | Model | [Web] Eloquent model for ProductColor table | `product()` — Eloquent relationship to related model<br>`images()` — Eloquent relationship to related model<br>`designs()` — Eloquent relationship to related model<br>`scopeActive()` — Query scope: Active filter |
| `web/app\Models\ProductColorImage.php` | Model | [Web] Eloquent model for ProductColorImage table | `color()` — Eloquent relationship to related model<br>`getImageUrlAttribute()` — Accessor: computed attribute |
| `web/app\Models\ProductOrder.php` | Model | [Web] Eloquent model for ProductOrder table | `items()` — [NEEDS REVIEW]<br>`shippingAddress()` — Shipping/tracking logic<br>`getDeliveryStatusTextAttribute()` — Accessor: computed attribute<br>`getStatusColorAttribute()` — Accessor: computed attribute<br>`getPaymentStatusTextAttribute()` — Accessor: computed attribute<br>`getPaymentMethodTextAttribute()` — Accessor: computed attribute<br>`getOrderTypeTextAttribute()` — Accessor: computed attribute |
| `web/app\Models\ProductOrderDetail.php` | Model | [Web] ProductOrderDetail.php file | — |
| `web/app\Models\ProductOrderUserAddress.php` | Model | [Web] ProductOrderUserAddress.php file | — |
| `web/app\Models\ProductStock.php` | Model | [Web] ProductStock.php file | — |
| `web/app\Models\Sample.php` | Model | [Web] Eloquent model for Sample table | `getFeaturesAttribute()` — Accessor: computed attribute<br>`getGsmAttribute()` — Accessor: computed attribute<br>`getColorsAttribute()` — Accessor: computed attribute |
| `web/app\Models\SampleOrderFullDetail.php` | Model | [Web] SampleOrderFullDetail.php file | — |
| `web/app\Models\SizeChart.php` | Model | [Web] SizeChart.php file | — |
| `web/app\Models\SubCategory.php` | Model | [Web] Eloquent model for SubCategory table | `category()` — Eloquent relationship to related model |
| `web/app\Models\User.php` | Model | [Web] Eloquent model for User table | `addresses()` — Eloquent relationship to related model<br>`cartItems()` — [NEEDS REVIEW]<br>`orders()` — Eloquent relationship to related model<br>`designs()` — Eloquent relationship to related model<br>`hasPurchasedSample()` — [NEEDS REVIEW] |
| `web/app\Models\UserAddress.php` | Model | [Web] Eloquent model for UserAddress table | `getAddressTypeNameAttribute()` — Accessor: computed attribute |

### Orders

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\BulkOrderController.php` | Controller | [Web] HTTP controller for Orders features | `index()` — Display list/overview page<br>`store()` — Validate & save new record to DB<br>`generateBulkOrderId()` — Bulk order processing |
| `web/app\Http\Controllers\OrderAssetsController.php` | Controller | [Web] HTTP controller for Orders features | `downloadZip()` — File download logic<br>`downloadFile()` — File download logic |
| `web/app\Http\Controllers\OrderController.php` | Controller | [Web] HTTP controller for Orders features | `checkout()` — [NEEDS REVIEW]<br>`placeOrder()` — [NEEDS REVIEW]<br>`processRazorpayOrder()` — [NEEDS REVIEW]<br>`captureDesignSnapshot()` — [NEEDS REVIEW]<br>`processPayPalOrder()` — [NEEDS REVIEW]<br>`processDirectOrder()` — [NEEDS REVIEW]<br>`checkStock()` — [NEEDS REVIEW]<br>`decrementStock()` — [NEEDS REVIEW]<br>`checkQuantityLimits()` — [NEEDS REVIEW]<br>`createOrderFullDetail()` — [NEEDS REVIEW]<br>`createOrderUserAddress()` — [NEEDS REVIEW]<br>`generateOrderId()` — [NEEDS REVIEW]<br>`success()` — [NEEDS REVIEW]<br>`showBankDetails()` — [NEEDS REVIEW]<br>`createRazorpayOrder()` — [NEEDS REVIEW]<br>`getDetails()` — [NEEDS REVIEW]<br>`createPayPalPayment()` — Payment processing logic<br>`executePayPalPayment()` — Payment processing logic<br>`cancelPayPalPayment()` — Payment processing logic<br>`uploadPaymentProof()` — Payment processing logic |
| `web/resources/views\pages\bulkorder.blade.php` | Blade View | [Web] Blade template: bulkorder.blade.php | — |
| `web/resources/views\pages\ordersuccess.blade.php` | Blade View | [Web] Blade template: ordersuccess.blade.php | — |

### Other

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\Controller.php` | Controller | [Web] Controller.php file | — |
| `web/app\Http\Controllers\UserAddressController.php` | Controller | [Web] HTTP controller for Other features | `store()` — Validate & save new record to DB<br>`update()` — Validate & update existing record in DB<br>`setDefault()` — [NEEDS REVIEW]<br>`destroy()` — Delete record from DB |
| `web/resources/js\app.js` | JavaScript | [Web] JavaScript initialization/utility | — |
| `web/resources/js\bootstrap.js` | JavaScript | [Web] JavaScript initialization/utility | — |
| `web/resources/views\welcome.blade.php` | Blade View | [Web] Blade template: welcome.blade.php | — |

### Payments

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\PayPalOrderProcessor.php` | Controller | [Web] HTTP controller for Payments features | `processPayPalOrder()` — [NEEDS REVIEW]<br>`generateOrderId()` — [NEEDS REVIEW] |
| `web/resources/views\pages\paypal-execute.blade.php` | Blade View | [Web] Blade template: paypal-execute.blade.php | — |

### Providers

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Providers\AppServiceProvider.php` | Provider | [Web] Service provider | `register()` — Register services into service container<br>`boot()` — Boot method: register events/policies |

### Routes

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/routes\api.php` | Routes | [Web] Route definitions | `[Route] middleware()` — Registers middleware HTTP route(s)<br>`[Route] get()` — Registers get HTTP route(s)<br>`[Route] post()` — Registers post HTTP route(s)<br>`[Route] delete()` — Registers delete HTTP route(s) |
| `web/routes\console.php` | Routes | [Web] console.php file | — |
| `web/routes\web.php` | Routes | [Web] Route definitions | `[Route] get()` — Registers get HTTP route(s)<br>`[Route] post()` — Registers post HTTP route(s)<br>`[Route] middleware()` — Registers middleware HTTP route(s)<br>`[Route] put()` — Registers put HTTP route(s)<br>`[Route] delete()` — Registers delete HTTP route(s)<br>`[Route] group()` — Registers group HTTP route(s)<br>`[Route] prefix()` — Registers prefix HTTP route(s) |

### Samples

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\SampleController.php` | Controller | [Web] HTTP controller for Samples features | `index()` — Display list/overview page |
| `web/resources/views\pages\sample.blade.php` | Blade View | [Web] Blade template: sample.blade.php | — |

### Services

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Services\CurrencyService.php` | Service | [Web] Business logic service | `getSupportedCurrencies()` — [NEEDS REVIEW]<br>`convert()` — Convert amount between currencies<br>`getRate()` — [NEEDS REVIEW]<br>`fetchRateFromApi()` — [NEEDS REVIEW]<br>`updateRates()` — [NEEDS REVIEW]<br>`updateDatabaseRate()` — [NEEDS REVIEW] |
| `web/app\Services\GoogleTranslationService.php` | Service | [Web] Business logic service | `translate()` — Translation/Google API call |
| `web/app\Services\PayPalService.php` | Service | [Web] Business logic service | `__construct()` — Constructor: initializes class dependencies<br>`getAccessToken()` — [NEEDS REVIEW]<br>`createOrder()` — [NEEDS REVIEW]<br>`captureOrder()` — [NEEDS REVIEW]<br>`getOrderDetails()` — [NEEDS REVIEW] |

### Shop

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\ShopController.php` | Controller | [Web] HTTP controller for Shop features | `index()` — Display list/overview page<br>`show()` — Display single record details |
| `web/resources/views\pages\product-details.blade.php` | Blade View | [Web] Blade template: product-details.blade.php | — |
| `web/resources/views\pages\shop.blade.php` | Blade View | [Web] Blade template: shop.blade.php | — |
| `web/resources/views\pages\wishlist.blade.php` | Blade View | [Web] Blade template: wishlist.blade.php | — |

### Users

| File | Type | Purpose Summary | Functions |
|------|------|----------------|-----------|
| `web/app\Http\Controllers\AccountController.php` | Controller | [Web] HTTP controller for Users features | `index()` — Display list/overview page<br>`updateProfile()` — [NEEDS REVIEW]<br>`changePassword()` — [NEEDS REVIEW] |
| `web/resources/views\pages\myaccount.blade.php` | Blade View | [Web] Blade template: myaccount.blade.php | — |

