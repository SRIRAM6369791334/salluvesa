<?php

use App\Http\Controllers\AreaAssignController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BannerImagesController;
use App\Http\Controllers\BankDetailController;
use App\Http\Controllers\BulkOrderController;
// use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CancelProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompoStockController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DeliveryPersonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexContrller;
use App\Http\Controllers\MilkOrdersController;
use App\Http\Controllers\MilkRefundController;
use App\Http\Controllers\MilkSlotController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfferImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderSummeryController;
use App\Http\Controllers\packingCompleteController;
use App\Http\Controllers\PackingDeliveryController;
use App\Http\Controllers\PackingDispatchController;
use App\Http\Controllers\PackingOrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOrdersController;
use App\Http\Controllers\ProductRefundController;
use App\Http\Controllers\ProductReturnController;
use App\Http\Controllers\ProductSlotController;
use App\Http\Controllers\ProductThumController;
use App\Http\Controllers\ProductVarientControllet;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TodayDealsController;
use App\Http\Controllers\TopCustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderAssetsController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, "root"])->name("pages.home")->middleware("auth");
    // Route::get('/logout',[LoginController::class,"logout"]);

    // Customer Page
    Route::resource("customers", UserController::class)->only(["index", "store"]);
    Route::get("customers/{customerId}", [UserController::class, "edit"])->name("customers.edit");
    Route::post("updateUser/{userId}", [UserController::class, "update"])->name("customers.update");
    Route::post("destroyUser/{userId}", [UserController::class, "destroy"])->name("customers.destroy");
    Route::post("getProductsOptions", [UserController::class, "getProductsOptions"]);
    Route::post("getProductsverentOptions", [UserController::class, "getProductsverentOptions"]);
    Route::post("getProductsverentqty", [UserController::class, "getProductsverentqty"]);
    Route::post("getcustomersummery", [UserController::class, "getcustomersummery"])->name("customers.getcustomersummery");
    Route::post("addaddressvalue", [UserController::class, "addaddressvalue"])->name("customers.addaddressvalue");
    Route::get('Getcitys/{custid}', [UserController::class, "Getcity"])->name("customers.Getcity");

    Route::get('/get-address-details', [UserController::class, 'getAddressDetails']);
    Route::get('/get-address-details1', [UserController::class, 'getAddressDetails1']);
    // Delivery Persons Page
    Route::resource("deliveryPersons", DeliveryPersonController::class)->only(["index", "store"]);
    Route::post("updateDeliveryPerson/{id}", [DeliveryPersonController::class, "update"])->name("deliveryPersons.update");
    Route::post("destroyDeliveryPerson/{id}", [DeliveryPersonController::class, "destroy"])->name("deliveryPersons.destroy");



    // Categories Page
    Route::resource("categories", CategoryController::class)->only(["index", "store"]);
    Route::post("updateCategories/{id}", [CategoryController::class, "update"])->name("categories.update");
    Route::post("destroyCategories/{id}", [CategoryController::class, "destroy"])->name("categories.destroy");
    Route::post("validateCategoryName", [CategoryController::class, "validateCategoryName"]);

    // Sub-Categories Page
    Route::resource("subcategories", SubCategoryController::class)->only(["index", "store"]);
    Route::post("updateSubCategories/{id}", [SubCategoryController::class, "update"]);
    Route::post("destroySubCategories/{id}", [SubCategoryController::class, "destroy"]);
    Route::post("validateSubCategoryName", [SubCategoryController::class, "validateSubCategoryName"]);


    // Products page
    Route::resource('products', ProductController::class)->only(["index", "store"]);
    Route::post("updateProducts/{id}", [ProductController::class, "update"])->name("products.update");
    Route::post("destroyProducts/{id}", [ProductController::class, "destroy"])->name("products.destroy");
    Route::post("productImageUpload", [ProductController::class, "productImageUpload"])->name("products.productImageUpload");
    Route::post("getProductDetail", [ProductController::class, "getProductDetail"])->name("products.getProductDetail");
    Route::post("getproductfilter", [ProductController::class, "getproductfilter"])->name("products.getProductDetail");
    Route::get('getsubcategory/{id}', [ProductController::class, 'Getsubproo']);

    // Area Page
    Route::resource('areas', AreaController::class)->only(["index", "store"]);

    Route::post("updateArea/{id}", [AreaController::class, "update"])->name("areas.update");
    Route::post("destroyArea/{id}", [AreaController::class, "destroy"])->name("areas.destroy");
    Route::post("assignDeliveryPerson", [AreaAssignController::class, "assignDeliveryPerson"]);
    Route::post("deleteDeliveryPerson", [AreaAssignController::class, "deleteDeliveryPerson"]);
    Route::post("fetchAreaDeliveryPartners/{areaId}", [AreaAssignController::class, "fetchAreaDeliveryPartners"]);
    Route::post("deleteAreaDeliveryPartners/{areaId}", [AreaAssignController::class, "deleteAreaDeliveryPartners"]);
    Route::post("checkAreaValidation", [AreaController::class, "checkAreaValidation"]);
    Route::post("getPincodeAreas", [AreaController::class, "getPincodeAreas"]);



    //   varient thumb image

    Route::post('destroyVarientThumpImages/{id}', [ProductController::class, "destroyVarientThumpImages"]);
    Route::get('/getthump/{productid}', [ProductController::class, 'getthump']);




    // Banner Image Page;
    Route::resource('bannerImages', BannerImagesController::class)->only(["index", "store"]);
    Route::post("updateBannerImages/{id}", [BannerImagesController::class, "update"])->name("bannerImages.update");
    Route::post("destroyBannerImages/{id}", [BannerImagesController::class, "destroy"])->name("bannerImages.destroy");
    Route::post("updateOrder", [BannerImagesController::class, "updateOrder"]);


    // web banner image
    Route::post('bannerwebImages', [BannerImagesController::class, "addbanner"])->name("bannerImages.addbanner");
    Route::post('updatewebBannerImages/{id}', [BannerImagesController::class, "updateimage"])->name("bannerwebImages.updateimage");
    Route::post("destroywebBannerImages/{id}", [BannerImagesController::class, "destroyweb"])->name("bannerImages.destroyweb");

    // Designs Page
    Route::resource('designs', \App\Http\Controllers\DesignsController::class)->only(["index", "store"]);
    Route::post("updateDesigns/{id}", [\App\Http\Controllers\DesignsController::class, "update"])->name("designs.update");
    Route::post("destroyDesigns/{id}", [\App\Http\Controllers\DesignsController::class, "destroy"])->name("designs.destroy");

    // Samples Page
    Route::resource('all-samples', \App\Http\Controllers\SamplesController::class)->names('samples')->only(["index", "store"]);
    Route::post("updateSamples/{id}", [\App\Http\Controllers\SamplesController::class, "update"])->name("samples.update");
    Route::post("destroySamples/{id}", [\App\Http\Controllers\SamplesController::class, "destroy"])->name("samples.destroy");




    // Milk orders  Page
    Route::resource('milkOrders', MilkOrdersController::class)->only(["index", "store"]);
    Route::post("getAreaAssignedDelvieryPerson/{areaId}", [MilkOrdersController::class, "getAreaAssignedDelvieryPerson"]);
    Route::post("milkOrderDeliveryAssign", [MilkOrdersController::class, "milkOrderDeliveryAssign"]);


    // MIlk slots functionalities
    Route::get('milkOrders/{orderId}', [MilkSlotController::class, "getMilkSlots"]);
    Route::post("cancelMilkSlot", [MilkSlotController::class, "cancelMilkSlot"]);


    //MIlk order Create
    Route::post("createMilkSubscription", [ProductController::class, "createMilkSubscription"]);
    // Milk Order Payment Success create slot
    Route::post("createMilkSlot", [ProductController::class, "createMilkSlot"]);


    //Products order Create
    Route::post("createProductSubscription", [ProductController::class, "createProductSubscription"]);
    // Milk Order Payment Success create slot
    Route::post("createProductSlot", [ProductController::class, "createProductSlot"]);


    // Product slots functionalities
    Route::get('productOrders/{orderId}', [ProductSlotController::class, "getProductSlots"]);
    Route::get('ordersummerys/{orderId}', [ProductSlotController::class, "getProductSlotss"]);
    Route::post("cancelProductSlot", [ProductSlotController::class, "cancelProductSlot"]);

    // Products Orders Page
    Route::resource('productOrders', ProductOrdersController::class)->only(["index", "store"]);

    Route::post("productOrderDeliveryAssign", [ProductOrdersController::class, "productOrderDeliveryAssign"]);
    Route::get("viewProductInvoice/{orderId?}", [ProductController::class, "viewProductInvoice"]);
    Route::get("export/commercial-invoice", [ProductController::class, "exportCommercialInvoice"]);
    Route::get("export/packing-list", [ProductController::class, "exportPackingList"]);
    Route::get("export/order-products/{orderId?}", [ProductController::class, "getOrderProductsForExport"]);
    Route::post("export/save-form-data", [ProductController::class, "saveExportFormData"]);
    Route::get("export/get-form-data/{orderId?}", [ProductController::class, "getExportFormData"]);
    Route::get("viewProducts", [ProductOrdersController::class, "index"]);
    Route::get("viewProductdetail/{orderId?}", [ProductController::class, "viewProductInvoice"]);
    Route::post("updatestatus", [ProductController::class, "upadetstatus"]);
    Route::post("pickupstatus", [ProductController::class, "pickupstatus"]);
    Route::post("updaterefund", [ProductController::class, "updaterefund"]);


    // packing details


    Route::resource("productpacking", PackingOrderController::class)->only(["index"]);
    Route::post("updatestatupacking", [PackingOrderController::class, "updatepacking"])->name("productpacking.updatedispach");

    Route::post("updaterefund1", [PackingOrderController::class, "updaterefund1"]);

    // dispatch details

    Route::resource("productdispatch", PackingDispatchController::class)->only(["index"]);
    Route::post("updatestatusdispatch", [PackingDispatchController::class, "updatedispach"])->name("productdispatch.updatedispach");
    Route::post("updaterefund2", [PackingDispatchController::class, "updaterefund2"]);

    // Delivery details

    Route::resource("productdelivery", PackingDeliveryController::class)->only(["index"]);
    Route::Post("updatestatusdelivery", [PackingDeliveryController::class, "updatedelive"])->name("productdelivery.updatedelive");
    Route::Post("collectstatusdelivery", [PackingDeliveryController::class, "collectdelive"])->name("productdelivery.collectdelive");


    Route::resource("productcomplete", packingCompleteController::class)->only(["index"]);

    //order summery

    // product return

    Route::resource('productreturn', ProductReturnController::class)->only(['index']);
    Route::post("updatereturnpro", [ProductReturnController::class, "update"])->name("productreturn.update");
    Route::post("collectreturn", [ProductReturnController::class, "updateed"])->name("productreturn.updateed");

    Route::resource("ordersummery", OrderSummeryController::class)->only(["index"]);
    Route::post("getoversummery", [OrderSummeryController::class, "getoversummery"])->name("ordersummery.getoversummery");


    //MIlk Refund Page
    Route::resource("milkRefunds", MilkRefundController::class)->only(["index", "store"]);
    Route::post("getMilkRefundDatas", [MilkRefundController::class, "getRefundDatas"]);
    Route::post("refundMilkSlot", [MilkRefundController::class, "refundMilkSlot"]);

    //Product Refund Page
    Route::resource("productRefunds", ProductRefundController::class)->only(["index", "store"]);
    Route::post("getProductRefundDatas", [ProductRefundController::class, "getRefundDatas"]);
    Route::post("refundProductSlot", [ProductRefundController::class, "refundProductSlot"]);
    Route::resource("cancelproduct", CancelProductController::class)->only(["index", "store"]);
    Route::post("cancelProductrequ", [CancelProductController::class, "cancelProductrequ"]);

    //Reports
    Route::get("incomeReports", [ReportsController::class, "incomeReports"])->name("incomeReports");
    Route::post("getIncomeReports", [ReportsController::class, "getIncomeReports"]);



    // Product Stock
    Route::resource("stocks", StockController::class)->only(["index", "store"]);
    // Route::post("updateStack", [StockController::class, "update"])->name("stacks.update");
    Route::post("reduceStock", [StockController::class, "reduceStock"])->name("stacks.reduceStock");
    Route::get('lowstock', [StockController::class, "lowstock"])->name("lowstock");
    Route::post("updateStack", [StockController::class, "update1"])->name("lowstock.update1");
    Route::get("highselling", [StockController::class, "highselling"])->name("highselling");


    // combo Stock

    Route::resource("combostock", CompoStockController::class)->only(["index"]);
    Route::post("updateStack1", [CompoStockController::class, "update"])->name("combostock.update");
    Route::post("reduceStock1", [CompoStockController::class, "reduceStock1"])->name("combostock.reduceStock1");

    // Coupon code
    Route::resource("coupons", CouponController::class)->only(["index", "store"]);
    // Route::post("coupons", [CouponController::class, "addcoupon"])->name("coupons.addcoupon");
    Route::post("updatecoupon/{id}", [CouponController::class, "update"])->name("coupons.update");
    Route::post("destroycoupon/{id}", [CouponController::class, "destroy"])->name("coupons.destroy");

    // offer images

    Route::resource('offerImages', OfferImageController::class)->only(["index", "store"]);
    Route::post("offerImagess", [OfferImageController::class, "offerImagess"])->name("offerImages.offerImagess");
    Route::post("updateOfferImages/{id}", [OfferImageController::class, "update"])->name("offerImages.update");
    Route::post("destroyOfferImages/{id}", [OfferImageController::class, "destroy"])->name("offerImages.destroy");

    // user create
    Route::resource('users', DashboardUserController::class)->only(["index", "store"]);
    Route::post("userss", [DashboardUserController::class, "userss"])->name("users.userss");
    Route::post("updateuser/{id}", [DashboardUserController::class, "update"])->name("users.update");
    Route::post("destroyusers/{id}", [DashboardUserController::class, 'destroy'])->name("users.destroy");
    Route::post("updatepass/{id}", [DashboardUserController::class, "update1"])->name("users.update1");

    // notifications
    Route::resource('review', NotificationController::class)->only(["index", "store"]);
    Route::post("reviews", [NotificationController::class, "notifications"])->name("notification.notifications");
    Route::post("updatenotifi/{id}", [NotificationController::class, "update"])->name("notification.update");
    Route::post("destroynotifi/{id}", [NotificationController::class, "destroy"])->name("notification.destroy");
    Route::get('/getproductsbycategory/{id}', [NotificationController::class, 'getProductsByCategory']);

    // Product Varient

    Route::resource('productvarient', ProductVarientControllet::class)->only(["index", "store"]);
    Route::post('addproductvarient', [ProductVarientControllet::class, "addproductvarient"])->name("productvarient.addproductvarient");
    Route::post('updateProductsvarient/{id}', [ProductVarientControllet::class, 'update'])->name("productvarient.update");
    Route::post('destroyvarient/{id}', [ProductVarientControllet::class, "destroy"])->name("productvarient.destroy");
    Route::get('Getproduct/{custid}', [ProductVarientControllet::class, "Getproduct"])->name("productvarient.Getproduct");
    Route::get('Getsubcategory/{custid}', [ProductVarientControllet::class, "Getsubcategory"])->name("productvarient.Getsubcategory");
    Route::post("getproductverfilter", [ProductVarientControllet::class, "getproductverfilter"])->name("productvarient.getproductverfilter");

    // product Thump
    Route::resource('productthump', ProductThumController::class)->only(["index", "store"]);
    Route::post('ThumImages', [ProductThumController::class, "ThumImages"])->name(("productthump.ThumImages"));
    Route::post('updatethumImages/{id}', [ProductThumController::class, "update"])->name("productthump.update");
    Route::post("destroyThumpImages/{id}", [ProductThumController::class, "destroy"])->name("productthump.destroy");

    // top customer

    Route::resource('topcustomer', TopCustomerController::class)->only(["index"]);

    Route::post('updatePasss/{userId}', [UserController::class, 'updatePass'])->name('updatePass');


    //TODAY DEALS
    Route::resource("todaydeals", TodayDealsController::class)->only(["index", "store"]);
    Route::post("updatetodaydeals/{id}", [TodayDealsController::class, "update"]);
    Route::post("destroytodaydeals/{id}", [TodayDealsController::class, "destroy"]);
    Route::post("validateSubCategoryName", [SubCategoryController::class, "validateSubCategoryName"]);

    // CANCEL REQUESTS
    Route::get('cancelrequests', [ProductSlotController::class, 'cancelrequests']);
    Route::post('/approverequest', [ProductSlotController::class, 'approverequest']);

    // RETURN REQUESTS
    Route::get('returnrequests', [ProductSlotController::class, 'returnrequests']);
    Route::post('/reject-return-request', [ProductSlotController::class, 'rejectReturnRequests']);

    // NEW ROUTES

    Route::POST('/orders/fetchtotalorders', [ProductOrdersController::class, 'fetchTotalOrders']);

    // Bank Details
    Route::get('/bank-details', [BankDetailController::class, 'index'])->name('bank-details.index');
    Route::post('/bank-details', [BankDetailController::class, 'store'])->name('bank-details.store');
    Route::post('/bank-details/update/{id}', [BankDetailController::class, 'update'])->name('bank-details.update');
    Route::post('/bank-details/destroy/{id}', [BankDetailController::class, 'destroy'])->name('bank-details.destroy');

    // Global Settings
    Route::get('/settings', [\App\Http\Controllers\AppSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/update', [\App\Http\Controllers\AppSettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/size-chart/update', [\App\Http\Controllers\AppSettingsController::class, 'updateSizeChart'])->name('settings.sizechart.update');
    Route::post('/settings/checkout/update', [\App\Http\Controllers\AppSettingsController::class, 'updateCheckoutSettings'])->name('settings.checkout.update');
    // Bulk Orders
    Route::get('bulk-orders', [BulkOrderController::class, 'index'])->name('bulk-orders.index');
    Route::post('bulk-orders/update-status', [BulkOrderController::class, 'updateStatus'])->name('bulk-orders.update-status');
    Route::get('/currency-test', [\App\Http\Controllers\CurrencyController::class, 'index']);
    Route::get('/currency/convert', [\App\Http\Controllers\CurrencyController::class, 'convert']);
    Route::post('/currency/switch', [\App\Http\Controllers\CurrencyController::class, 'switchCurrency'])->name('currency.switch');
    Route::get('/currency/switch/{currency}', [\App\Http\Controllers\CurrencyController::class, 'switchCurrencyByGet'])->name('currency.switch.get');

    // Design Assets Download
    Route::get('/order-assets/zip/{orderId}', [OrderAssetsController::class, 'downloadZip'])->name('order-assets.zip');
    Route::get('/order-assets/file', [OrderAssetsController::class, 'downloadFile'])->name('order-assets.file');
    Route::get('/admin/orders/slot/{slotId}/download-customization-zip', [ProductOrdersController::class, 'downloadCustomizationZip'])->name('admin.orders.download-zip');
    Route::get('/admin/orders/slot/{slotId}/specsheet-pdf', [ProductOrdersController::class, 'downloadSpecSheetPdf'])->name('admin.orders.specsheet-pdf');
    Route::get('/admin/orders/{orderId}/download-order-zip', [ProductOrdersController::class, 'downloadOrderCustomizationZip'])->name('admin.orders.download-order-zip');

    // Language Translation
    Route::get('lang/{locale}', [HomeController::class, 'lang'])->name('lang.switch');
});



Route::get('/orderwisereport', [OrderController::class, 'orderwisereport'])->name('order.wise.report');
Route::get('/order-wise-report/filter', [OrderController::class, 'filterorderWiseReport'])->name('order.wise.report.filter');
Route::get('/oreport/export/excel', [OrderController::class, 'exportExcel'])->name('order.wise.report.export.excel');
Route::get('/oreport/export/pdf', [OrderController::class, 'exportPDF'])->name('order.wise.report.export.pdf');

Route::get('/shipping', [ShippingController::class, 'getship']);
Route::post('/insertshipping', [ShippingController::class, 'addshipping']);
Route::post('/updateship', [ShippingController::class, 'updateship']);
Route::post('/destroyshipping/{id}', [ShippingController::class, 'destroyshipping']);

// Custom Products
Route::get('/custom-products', [App\Http\Controllers\CustomProductController::class, 'index'])->name('custom-products.index');
Route::get('/custom-products/designer-data/{id}', [App\Http\Controllers\CustomProductController::class, 'getDesignerData'])->name('custom-products.designer-data');
Route::delete('/custom-products/destroy/{id}', [App\Http\Controllers\CustomProductController::class, 'destroy'])->name('custom-products.destroy');
Route::post('/custom-products/duplicate/{id}', [App\Http\Controllers\CustomProductController::class, 'duplicate'])->name('custom-products.duplicate');
Route::post('/custom-products/store', [App\Http\Controllers\CustomProductController::class, 'store'])->name('custom-products.store');
Route::get('/custom-products/edit/{id}', [App\Http\Controllers\CustomProductController::class, 'edit'])->name('custom-products.edit');
Route::post('/custom-products/update/{id}', [App\Http\Controllers\CustomProductController::class, 'update'])->name('custom-products.update');
Route::post('/custom-products/{id}/save-placement', [App\Http\Controllers\CustomProductController::class, 'savePlacement'])->name('custom-products.save-placement');


//TODAY DEALS


// Old Project Files
// Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

// //Update User Detailsphp ar
// Route::post('/update-profile', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
// Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

//hi Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

// //Language Translation
// Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
// Route::get('/invoice/{orderId}', [OrderController::class, 'showInvoice']);
