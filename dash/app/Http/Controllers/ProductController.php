<?php

namespace App\Http\Controllers;

use App\Models\AreaAssign;
use App\Models\Category;
use App\Models\DeliveryPerson;
use App\Models\MilkOrder;
use App\Models\MilkOrderUserAddress;
use App\Models\MilkSlot;
use App\Models\MilkTransactionLog;
use App\Models\Product;
use App\Models\ProductChildImage;
use App\Models\ProductOrder;
use App\Models\ProductOrderUserAddress;
use App\Models\ProductRefund;
use App\Models\ProductSlot;
use App\Models\ProductStock;
use App\Models\ProductTracking;
use App\Models\ProductTransactionLog;
use App\Models\ProductVarient;
use App\Models\ProductVerient;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserAddress;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;

require_once("sendsms.php");

class ProductController extends Controller
{

    public $productOrderSuccessMessage = "Product Added Successfully";

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products =  Product::with(['category', 'Subcategory'])->get();
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view("pages.products", compact("products", "categories", "subcategories"));
    }


    public function destroyVarientThumpImages(string $id)
    {
        ProductChildImage::find($id)->delete();

        return successResponse("Deleted Successfully");
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */

    // DO NOT TRY TO OPTIMIZE OR CHANGE ANYTHING IN THIS BELOW STORE FUNCTION
    // IF YOU DO THAT THE CODE WILL FAIL FOR SURE
    // TIME WASTED 3 DAYS
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => "required",
            'subcategory_id' => "required",
            'product_name' => "required",
            'product_image' => "required|mimes:png,jpg,webp,jpeg",
            'product_description' => "required",

        ]);

        // Get display names
        $subcategory = SubCategory::find($request->subcategory_id);
        $category = Category::find($request->category_id);
        $displayname = $subcategory->subcategory_name ?? '';
        $catedisplayname = $category->category_name ?? '';

        // Create slug/unique name
        $prod_unique_name = strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $validated['product_name']));
        $prod_unique_name = str_replace(' ', '-', $prod_unique_name);

        // Upload main image
        $productImage = $request->file("product_image");
        $path = $productImage->store("product_images", "public");

        // Upload size chart
        $sizechartImage = $request->file("add_size_chart_image");
        $sizeChartPath = $sizechartImage->store("size_chart_images", "public");

        // Create product
        $product = Product::create([
            ...$validated,
            "product_image" => $path,
            "cate_name" => $catedisplayname,
            "subcate_name" => $displayname,
            "prod_unique_name" => $prod_unique_name,
            "size_chart_image" => $sizeChartPath,
            "product_specification" => $request->product_specification,
        ]);

        // Handle variants
        $imageArray = $request->file('product_image1'); // Flat array of all thumb images
        $thumpArray = $request->product_image_count;    // Array of count per variant
        $imageIndex = 0; // Pointer for product_image1

        foreach ($request->Varient_image as $key => $variantFile) {
            // Store variant image
            $vpath = $variantFile->store("varient_images", "public");

            // Create product variant
            $variant = ProductVarient::create([
                'categoryid' => $product->category_id,
                'subcategoryid' => $product->subcategory_id,
                'subcatename' => $displayname,
                'product_id' => $product->id,
                'varient_img' => $vpath,
                'offer_price' => $request->product_offer_price[$key],
                'mrp_price' => $request->product_mrp_price[$key],
                'product_qty' => $request->product_quantity[$key],
                'low_stock' => $request->low_stock[$key],
                'product_gst' => $request->product_gst[$key] ?? 0,
                'size_value' => $request->prod_size_value[$key],
                'color_value' => $request->varient_color[$key],
            ]);

            // Insert stock info
            DB::table('productstocks')->insert([
                "productid" => $product->id,
                "category_id" => $validated["category_id"],
                "subcategory_id" => $validated["subcategory_id"],
                "pro_ver_id" => $variant->id,
                "productname" => $validated["product_name"],
                "overallstock" => $request->product_quantity[$key],
                "availablestock" => $request->product_quantity[$key],
                "salestock" => 0,
                "low_stocks" => $request->low_stock[$key],
                "last_stockupdate_date" => now()->format("Y-m-d"),
            ]);

            // Handle variant thumb images
            $thumbCount = intval($thumpArray[$key]);

            for ($i = 0; $i < $thumbCount; $i++) {
                if (isset($imageArray[$imageIndex])) {
                    $thumbImage = $imageArray[$imageIndex];
                    $thumbPath = $thumbImage->store("product_images1", "public");

                    ProductChildImage::create([
                        "product_id" => $product->id,
                        "variant_id" => $variant->id,
                        "product_child_image" => $thumbPath,
                    ]);

                    $imageIndex++;
                }
            }
        }

        $products = Product::with(['category', 'Subcategory'])->get();

        return response()->json([
            "message" => "Product created successfully!",
            "products" => $products
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validation
        $validated = $request->validate([
            'category_id' => "required",
            'subcategory_id' => "required",
            'product_name' => "required",
            'product_description' => "required",
            'product_specification' => "required",
            'product_image' => $request->hasFile('product_image') ? 'required|mimes:png,jpg,webp,jpeg' : '',
        ]);

        // Get category and subcategory names
        $category = Category::find($validated['category_id']);
        $subcategory = Subcategory::find($validated['subcategory_id']);

        $catName = $category ? $category->category_name : null;
        $subcatName = $subcategory ? $subcategory->subcategory_name : null;

        // Prepare data to update
        $updateData = [
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'],
            'product_name' => $validated['product_name'],
            'product_description' => $validated['product_description'],
            'product_specification' => $validated['product_specification'],
            'cate_name' => $catName,
            'subcate_name' => $subcatName,
        ];

        // Handle image update
        if ($request->hasFile("product_image")) {
            $productImage = $request->file("product_image");
            $path = $productImage->store("product_images", "public");

            // Delete old image if exists
            if ($product->product_image && File::exists(public_path("storage/" . $product->product_image))) {
                File::delete(public_path("storage/" . $product->product_image));
            }

            $updateData['product_image'] = $path;
        }

        // Update the product
        $product->update($updateData);

        $products = Product::with(['category', 'Subcategory'])->get();

        return response()->json([
            "message" => $this->productOrderSuccessMessage,
            "products" => $products
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (File::exists(public_path("images/") . $product->product_image)) {
            File::delete(public_path("images/" . $product->product_image));
            $product->delete();


            ProductVerient::where("product_id", $id)?->delete();

            DB::table('productstocks')->where("productid", $id)->delete();

            $products =  Product::with(['category', 'Subcategory'])->get();
            return response()->json([
                "message" => "Product Deleted Successfully",
                "products" => $products
            ]);
        }

        return redirect("products")->with("error", "Product Deleted Failed");
    }


    public function productImageUpload(Request $request)
    {
        return response($request->hasFile("addProductImage"));
    }

    public function getProductDetail(Request $request)
    {
        $productId = $request->product_id;
        if (!$productId) {
            abort(404);
        }

        $product = Product::with(['category', 'Subcategory'])->findOrFail($productId);
        return response($product);
    }


    public function createMilkSubscription(Request $request)
    {
        $planType = $request->plan_type;
        $userId = $request->user_id;
        $productId = $request->product_id;
        $quantity = $request->quantity;
        $user = User::query()->where("user_id", $userId)->first();
        $lastId = MilkOrder::max('id');
        $orderId = sprintf('HG-ORD-%06d', $lastId + 1);

        if ($planType == "1") {
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            $dates = [];
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $dates[] = $date->toDateString();
            }
            $noOfdays = count($dates);
            $dates = json_encode($dates);
            MilkOrder::query()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'order_id' => $orderId,
                'from_date' => $request->from_date,
                'to_date' => $endDate,
                'date_to_delivery' => $dates,
                'date_ordered_on' => now(),
                'no_of_days' => $noOfdays,
                "payment_status" => 1,
                'plan_type' => $planType,
                'user_id' => $userId,
            ]);

            $this->createMilkSlot($orderId);

            $totalAmount = Product::findOrFail($productId)->product_mrp_price * $quantity * $noOfdays;

            MilkTransactionLog::create([
                'order_id' => $orderId,
                'order_date' => now(),
                'order_amount' => $totalAmount,
                'amount_credited' => $totalAmount,
                'user_id' => $userId
            ]);

            $this->assignDeliverPersonMilkOrder($orderId, $user);
            $this->addMilkOrderDeliveryAddress($orderId, $user);

            return successResponse("Order Created Successfully");
        }
        if ($planType == "2") {
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->from_date);
            $dates = [];
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $dates[] = $date->toDateString();
            }
            $noOfdays = count($dates);
            $dates = json_encode($dates);
            MilkOrder::query()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'order_id' => $orderId,
                'from_date' => $startDate,
                'to_date' => $endDate,
                'date_to_delivery' => $dates,
                'date_ordered_on' => now(),
                'no_of_days' => $noOfdays,
                "payment_status" => 1,
                'plan_type' => $planType,
                'user_id' => $userId,

            ]);
            $this->createMilkSlot($orderId);
            $totalAmount = Product::findOrFail($productId)->product_mrp_price * $quantity * $noOfdays;
            MilkTransactionLog::create([
                'order_id' => $orderId,
                'order_date' => now(),
                'order_amount' => $totalAmount,
                'amount_credited' => $totalAmount,
                'user_id' => $userId
            ]);


            $this->assignDeliverPersonMilkOrder($orderId, $user);
            $this->addMilkOrderDeliveryAddress($orderId, $user);

            return successResponse("Order Created Successfully");
        }
        if ($planType == "3") {
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            $dates = $request->selected_dates;
            $noOfdays = count($dates);
            $dates = json_encode($dates);
            MilkOrder::query()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'order_id' => $orderId,
                'from_date' => $startDate,
                'to_date' => $endDate,
                'date_to_delivery' => $dates,
                'date_ordered_on' => now(),
                'no_of_days' => $noOfdays,
                "payment_status" => 1,
                'plan_type' => $planType,
                'user_id' => $userId,
            ]);
            $this->createMilkSlot($orderId);

            $totalAmount = Product::findOrFail($productId)->product_mrp_price * $quantity * $noOfdays;

            MilkTransactionLog::create([
                'order_id' => $orderId,
                'order_date' => now(),
                'order_amount' => $totalAmount,
                'amount_credited' => $totalAmount,
                'user_id' => $userId
            ]);

            $this->assignDeliverPersonMilkOrder($orderId, $user);
            $this->addMilkOrderDeliveryAddress($orderId, $user);

            return successResponse("Order Created Successfully");
        }
    }

    // addMilkOrderDeliveryAddress($orderId, $user)
    public function addMilkOrderDeliveryAddress($orderId, $user)
    {
        $defaultUserAddress =  $user->defaultAddress->toArray();
        MilkOrderUserAddress::create([
            ...$defaultUserAddress,
            "order_id" => $orderId,
        ]);
    }


    public function addProductOrderDeliveryAddress($orderId, $user)
    {
        $defaultUserAddress =  $user->defaultAddress->toArray();
        ProductOrderUserAddress::create([
            ...$defaultUserAddress,
            "order_id" => $orderId,
        ]);
    }

    // Milk Product Assign Deiver Person
    public function assignDeliverPersonMilkOrder($orderId, $user)
    {
        $userDefaultAddressId  = $user->user_default_address_id;
        $userDefaultAddress =  UserAddress::query()->findOrFail($userDefaultAddressId);

        $areaId = $userDefaultAddress["area_id"];
        $deliveryPerson = DeliveryPerson::with(['areaAssigns', 'milkOrders'])
            ->whereHas('areaAssigns', function ($query) use ($areaId) {
                $query->where('area_id', $areaId);
            })
            ->withCount('milkOrders')
            ->orderBy('milk_orders_count', 'asc')
            ->first();
        if ($deliveryPerson) {
            $milkOrder =   MilkOrder::query()->where("order_id", $orderId)->first();
            $milkSlot =  MilkSlot::query()->where("order_id", $orderId);
            $milkOrder->update([
                "delivery_person_id" => $deliveryPerson->delivery_person_id,
                "is_delivery_assigned" => 1
            ]);
            $milkSlot->update([
                "deliver_person_id" => $deliveryPerson->delivery_person_id
            ]);
        }
    }

    // createProductSubscription

    public function createProductSubscription(Request $request)
    {
        $userId = $request->user_id;
        $selettype = $request->selecttype;


        $user = User::query()->where("user_id", $userId)->first();
        $lastId = ProductOrder::max('id');
        $orderId = sprintf('HG-ORD-PR-%06d', $lastId + 1);

        ProductOrder::query()->create([
            'order_id' => $orderId,
            'date_ordered_on' => now(),
            'user_id' => $userId,
            "payment_status" => 1,
        ]);

        $this->createProductSlot($orderId, $selettype, $request);

        $this->assignDeliverProductOrder($orderId, $user);
        $this->addProductOrderDeliveryAddress($orderId, $user);
        return successResponse("Order Created Successfully");
    }


    // Product  Order Assign Deiver Person
    public function assignDeliverProductOrder($orderId, $user)
    {
        $userDefaultAddressId  = $user->user_default_address_id;
        $userDefaultAddress =  UserAddress::query()->findOrFail($userDefaultAddressId);

        $areaId = $userDefaultAddress["area_id"];
        $deliveryPerson = DeliveryPerson::with(['areaAssigns', 'productOrders'])
            ->whereHas('areaAssigns', function ($query) use ($areaId) {
                $query->where('area_id', $areaId);
            })
            ->withCount('productOrders')
            ->orderBy('product_orders_count', 'asc')
            ->first();
        if ($deliveryPerson) {
            $productOrder =   ProductOrder::query()->where("order_id", $orderId)->first();
            $productSlot =  ProductSlot::query()->where("order_id", $orderId);
            $productOrder->update([
                "delivery_person_id" => $deliveryPerson->delivery_person_id,
                "is_delivery_assigned" => 1
            ]);
            $productSlot->update([
                "deliver_person_id" => $deliveryPerson->delivery_person_id
            ]);
        }
    }


    public function createMilkSlot($orderId)
    {
        $order = MilkOrder::query()->where("order_id", $orderId)->first();
        $orderedDates = json_decode($order->date_to_delivery);
        $order->update(["payment_status" => 1]);
        $slots = [];
        if (!$orderedDates && !count($orderedDates)) {
            return errorResponse("Order Not Fount", 404);
        }
        $slots = array_map(function ($orderedDate) use ($orderId) {
            return [
                'delivery_date' => $orderedDate,
                'order_id' => $orderId,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $orderedDates);

        MilkSlot::insert($slots);
    }



    public function createProductSlot($orderId, $selettype, $request)
    {

        $order = ProductOrder::query()->where("order_id", $orderId)->first();

        if ($selettype == "2") {

            $order->update(["payment_status" => 1, "delivery_status" => 4]);
        } else {
            $order->update(["payment_status" => 1]);
        }


        $productId = $request->product_id; // Assuming product_id is a single value
        $productvarid = $request->productvar_id;
        $quantity = $request->product_quantity;
        $delvieryDate  = Carbon::parse($request->from_date);
        $userId = $request->user_id;

        $slots = [];
        $totalAmount = 0;

        if ($selettype == "2") {
            foreach ($productvarid as $key => $value) {
                $totalAmount += (ProductVarient::findOrFail($value)->offer_price * $quantity[$key]);

                $slots[] = [
                    'delivery_date' => $delvieryDate,
                    'order_id' => $orderId,
                    "product_id" => $productId[$key],
                    "product_varient_id" => $value,
                    "quantity" => $quantity[$key],
                    "delivery_status" => 4,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            // dd( $totalAmount);
            $prooder = ProductOrder::where('order_id', $orderId)->update([
                "total_amount" => $totalAmount
            ]);




            ProductSlot::insert($slots);

            foreach ($slots as $slot) {
                $productVarientId = $slot['product_varient_id'];
                $quantity = $slot['quantity'];

                // Get the current stock information for the product
                $productStock = ProductStock::where('pro_ver_id', $productVarientId)->first();
                $productVarient = ProductVarient::where('id', $productVarientId)->first();

                // Update available_stock and sale_stock based on the quantity
                $availableStock = $productStock->availablestock - $quantity;
                $saleStock = $productStock->salestock + $quantity;

                // Update the ProductStock table
                ProductStock::where('pro_ver_id', $productVarientId)->update([
                    'availablestock' => $availableStock,
                    'salestock' => $saleStock,
                ]);
                $productVarientAvailQty = $productVarient->product_qty - $quantity;
                ProductVarient::where('id', $productVarientId)->update([
                    'product_qty' => $productVarientAvailQty,
                ]);
            }
        } else {
            foreach ($productvarid as $key => $value) {
                $totalAmount += (ProductVarient::findOrFail($value)->offer_price * $quantity[$key]);


                $slots[] = [
                    'delivery_date' => $delvieryDate,
                    'order_id' => $orderId,
                    "product_id" => $productId[$key],
                    "product_varient_id" => $value,
                    "quantity" => $quantity[$key],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            $prooder = ProductOrder::where('order_id', $orderId)->update([
                "total_amount" => $totalAmount
            ]);


            ProductSlot::insert($slots);


            foreach ($slots as $slot) {
                $productVarientId = $slot['product_varient_id'];
                $quantity = $slot['quantity'];

                // Get the current stock information for the product
                $productStock = ProductStock::where('pro_ver_id', $productVarientId)->first();
                $productVarient = ProductVarient::where('id', $productVarientId)->first();

                // Update available_stock and sale_stock based on the quantity
                $availableStock = $productStock->availablestock - $quantity;
                $saleStock = $productStock->salestock + $quantity;

                // Update the ProductStock table
                ProductStock::where('pro_ver_id', $productVarientId)->update([
                    'availablestock' => $availableStock,
                    'salestock' => $saleStock,
                ]);
                $productVarientAvailQty = $productVarient->product_qty - $quantity;
                ProductVarient::where('id', $productVarientId)->update([
                    'product_qty' => $productVarientAvailQty,
                ]);
            }
        }





        ProductTransactionLog::create([
            'order_id' => $orderId,
            'order_date' => now(),
            'order_amount' => $totalAmount,
            'amount_credited' => $totalAmount,
            'user_id' => $userId
        ]);
    }

    public function viewProductInvoice($orderId = null)
    {
        if (str_starts_with((string)$orderId, 'B-') || str_starts_with((string)$orderId, 'ORD-SAA-BULK-')) {
            if (str_starts_with((string)$orderId, 'B-')) {
                $bulkId = str_replace('B-', '', $orderId);
                $bulkOrder = \App\Models\BulkOrder::with('product')->find($bulkId);
            } else {
                $bulkOrder = \App\Models\BulkOrder::where('order_id', $orderId)->with('product')->first();
            }
            if (!$bulkOrder) {
                return "Bulk order not found.";
            }

            $order = new \stdClass();
            $order->id = 0;
            $order->order_id = $orderId;
            $order->created_at = $bulkOrder->created_at;
            $order->payment_method = 'N/A';
            $order->payment_status = null;
            $order->discount_amount = 0;
            
            $order->customer = new \stdClass();
            $order->customer->name = $bulkOrder->name;
            $order->customer->mobile = 'N/A';
            $order->customer->email = $bulkOrder->email;
            $order->customer->user_addresses = collect([]);

            $order->orderAddress = new \stdClass();
            $order->orderAddress->address_username = $bulkOrder->name;
            $order->orderAddress->address_line_one = 'N/A';
            $order->orderAddress->address_line_two = '';
            $order->orderAddress->city = '';
            $order->orderAddress->pincode = '';
            $order->orderAddress->address_phone_number = 'N/A';
            $order->orderAddress->state = new \stdClass();
            $order->orderAddress->state->state_name = '';

            $item = new \stdClass();
            $item->productOrder = clone $order;
            $item->product = clone $order;
            $item->product->product_name = 'Bulk Order - ' . str_replace('_', ' ', $bulkOrder->product_type);
            $item->productVarient = clone $item->product;
            $item->productVarient->varient = 5;
            $item->productVarient->offer_price = 0;
            $item->productVarient->product_quantity = '';
            $item->quantity = $bulkOrder->quantity;
            $item->product_rate = 0;
            $item->shipping = 0;
            $item->discount = 0;
            $item->order_id = $orderId;
            $item->delivery_date = $bulkOrder->created_at;
            
            $products = collect([$item]);
        } else {
            $order = ProductOrder::where('order_id', $orderId)->orWhere('id', $orderId)->first();
            if (!$order) {
                return "Order not found.";
            }
            
            $products = ProductSlot::query()->whereIn("order_id", [$order->id, (string)$order->order_id])
                ->where(function($q) { $q->where('is_cancelled', '!=', 1)->orWhereNull('is_cancelled'); })
                ->with("productVarient", "productOrder.customer.user_addresses", "productOrder.orderAddress", "product.productvari", 'productOrder.orderAddress.state')
                ->get();
        }

        return view("invoicePages.product_orders_invoice", compact("products"));
    }

    public function exportCommercialInvoice(Request $request)
    {
        $orderId = $request->input('order_id');
        $invoiceType = $request->input('type', 'commercial'); // 'commercial' or 'proforma'
        $invoiceData = $request->except(['order_id', 'type', 'download', 'view']);

        $locale = \Illuminate\Support\Facades\Session::get('lang', 'en');

        // Static labels for Commercial Invoice
        $labels = [
            'commercial_invoice'          => 'COMMERCIAL INVOICE',
            'proforma_invoice'            => 'PROFORMA INVOICE',
            'date'                        => 'Date',
            'invoice_number'              => 'Invoice Number',
            'air_waybill_number'          => 'Air Waybill Number',
            'general_information'         => 'General Information',
            'sender_details'              => 'Sender Details',
            'shipment_details'            => 'Shipment Details',
            'name'                        => 'Name',
            'address'                     => 'Address',
            'contact_number'              => 'Contact Number',
            'email'                       => 'Email',
            'tax_id_no'                   => 'Tax ID No.',
            'shipment_ref_no'             => 'Shipment Reference No.',
            'reason_for_export'           => 'Reason for Export',
            'type_of_export'              => 'Type of Export',
            'export_license_no'           => 'Export License No.',
            'import_license_no'           => 'Import License No.',
            'incoterms'                   => 'INCOTERMS',
            'currency_code'               => 'Currency Code',
            'payment_method'              => 'Payment Method',
            'printing_method'             => 'Printing Method',
            'receiver_details'            => 'Receiver Details',
            'importer_of_record_details'  => 'Importer of Record Details',
            'no'                          => 'No.',
            'item_description'            => 'Item Description',
            'hs_code'                     => 'HS Code',
            'country_of_origin'           => 'Country of Origin',
            'qty_uom'                     => 'Qty UOM',
            'unit_value'                  => 'Unit Value',
            'sub_total_value'             => 'Sub-Total Value',
            'unit_net_weight'             => 'Unit Net Weight',
            'other_info'                  => 'OTHER INFORMATION AND COMPLIANCE DETAILS',
            'no_of_packages'              => 'No. of Packages',
            'total_goods_value'           => 'Total Goods Value',
            'total_weight'                => 'Total Weight',
            'certify_text'                => 'I/We certify the information on this invoice is true and correct and that the contents of this shipment are as stated above.',
            'signature'                   => 'Signature',
            'designation_title'           => 'Designation/Title',
        ];

        if ($locale && $locale !== 'en') {
            try {
                $tr = new \Stichoza\GoogleTranslate\GoogleTranslate($locale);
                $tr->setSource('en');
                // Translate dynamic invoice data
                foreach ($invoiceData as $key => $value) {
                    if (is_string($value) && !empty(trim($value))) {
                        $invoiceData[$key] = $tr->translate($value);
                    }
                }
                // Translate static labels
                foreach ($labels as $key => $value) {
                    $labels[$key] = $tr->translate($value);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Translation failed: " . $e->getMessage());
            }
        }

        if (str_starts_with($orderId, 'B-') || str_starts_with($orderId, 'ORD-SAA-BULK-')) {
            if (str_starts_with($orderId, 'B-')) {
                $bulkId = str_replace('B-', '', $orderId);
                $bulkOrder = \App\Models\BulkOrder::with('product')->find($bulkId);
            } else {
                $bulkOrder = \App\Models\BulkOrder::where('order_id', $orderId)->with('product')->first();
            }
            if (!$bulkOrder) {
                return back()->with('error', 'Bulk order not found.');
            }
            
            $order = new \stdClass();
            $order->id = 0;
            $order->order_id = $orderId;
            $order->created_at = $bulkOrder->created_at;
            $order->customer = new \stdClass();
            $order->customer->name = $bulkOrder->name;
            $order->customer->mobile = 'N/A';
            $order->customer->email = $bulkOrder->email;
            
            $order->orderAddress = new \stdClass();
            $order->orderAddress->address_line_one = 'N/A';
            $order->orderAddress->address_line_two = '';
            $order->orderAddress->city = '';
            $order->orderAddress->pincode = '';
            $order->orderAddress->state = new \stdClass();
            $order->orderAddress->state->state_name = '';
            
            $item = new \stdClass();
            $item->product = $bulkOrder->product ?? (object) ['product_name' => 'Bulk Order - ' . str_replace('_', ' ', $bulkOrder->product_type)];
            $item->productVarient = (object) ['offer_price' => 0, 'product_quantity' => ''];
            $item->quantity = $bulkOrder->quantity;
            $products = collect([$item]);
        } else {
            $order = ProductOrder::query()->with(['customer', 'orderAddress.state'])->where("order_id", $orderId)->orWhere('id', $orderId)->first();
            if (!$order) {
                return back()->with('error', 'Order not found.');
            }
            if ($order->user_id && !$order->customer) {
                $order->customer = \App\Models\User::where('user_id', $order->user_id)->first();
            }
            
            $products = ProductSlot::query()->whereIn("order_id", [$order->id, (string)$order->order_id])
                ->where(function($q) { $q->where('is_cancelled', '!=', 1)->orWhereNull('is_cancelled'); })
                ->with("productVarient", "productOrder.customer.user_addresses", "productOrder.orderAddress", "product.productvari", 'productOrder.orderAddress.state', 'product.category')
                ->get();
                
            if ($products->isEmpty()) {
                return back()->with('error', 'No valid products found for this order.');
            }
        }

        // Generate Invoice Number on the fly
        $prefix = ($invoiceType === 'proforma') ? 'PRO-' : 'INV-';
        $datePart = \Carbon\Carbon::parse($order->created_at)->format('Ym');
        $incrementPart = str_pad($order->id, 4, '0', STR_PAD_LEFT);
        $invoiceNumber = $prefix . $datePart . '-' . $incrementPart;

        return view('invoicePages.export_commercial_invoice', compact('products', 'order', 'invoiceData', 'invoiceType', 'invoiceNumber', 'labels'));
    }

    public function exportPackingList(Request $request)
    {
        $orderId = $request->input('order_id');
        $invoiceData = $request->except(['order_id']);

        $locale = \Illuminate\Support\Facades\Session::get('lang', 'en');

        // Static labels for Packing List
        $labels = [
            'packing_list'        => 'PACKING LIST',
            'date'                => 'Date',
            'invoice_number'      => 'Invoice Number',
            'air_waybill_number'  => 'Air Waybill Number',
            'sender_details'      => 'Sender Details',
            'receiver_details'    => 'Receiver Details',
            'name'                => 'Name',
            'address'             => 'Address',
            'contact_number'      => 'Contact Number',
            'email'               => 'Email',
            'tax_id_no'           => 'Tax ID No.',
            'no'                  => 'No.',
            'item_description'    => 'Item Description',
            'hs_code'             => 'HS Code',
            'country_of_origin'   => 'Country of Origin',
            'qty'                 => 'Qty',
            'uom'                 => 'UOM',
            'net_weight'          => 'Net Weight',
            'gross_weight'        => 'Gross Weight',
            'no_of_packages'      => 'No. of Packages',
            'total_weight'        => 'Total Weight',
            'certify_text'        => 'I/We certify the information on this packing list is true and correct.',
            'signature'           => 'Signature',
            'designation_title'   => 'Designation/Title',
        ];

        if ($locale && $locale !== 'en') {
            try {
                $tr = new \Stichoza\GoogleTranslate\GoogleTranslate($locale);
                $tr->setSource('en');
                foreach ($invoiceData as $key => $value) {
                    if (is_string($value) && !empty(trim($value))) {
                        $invoiceData[$key] = $tr->translate($value);
                    }
                }
                foreach ($labels as $key => $value) {
                    $labels[$key] = $tr->translate($value);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Translation failed: " . $e->getMessage());
            }
        }

        if (str_starts_with($orderId, 'B-') || str_starts_with($orderId, 'ORD-SAA-BULK-')) {
            if (str_starts_with($orderId, 'B-')) {
                $bulkId = str_replace('B-', '', $orderId);
                $bulkOrder = \App\Models\BulkOrder::with('product')->find($bulkId);
            } else {
                $bulkOrder = \App\Models\BulkOrder::where('order_id', $orderId)->with('product')->first();
            }
            if (!$bulkOrder) {
                return back()->with('error', 'Bulk order not found.');
            }
            
            $order = new \stdClass();
            $order->order_id = $orderId;
            $order->customer = clone $order;
            $order->customer->name = $bulkOrder->name;
            $order->customer->mobile = 'N/A';
            $order->customer->email = $bulkOrder->email;
            
            $order->orderAddress = new \stdClass();
            $order->orderAddress->address_line_one = 'N/A';
            $order->orderAddress->address_line_two = '';
            $order->orderAddress->city = '';
            $order->orderAddress->pincode = '';
            $order->orderAddress->state = new \stdClass();
            $order->orderAddress->state->state_name = '';
            
            $item = new \stdClass();
            $item->product = $bulkOrder->product ?? (object) ['product_name' => 'Bulk Order - ' . str_replace('_', ' ', $bulkOrder->product_type)];
            $item->productVarient = (object) ['offer_price' => 0, 'product_quantity' => ''];
            $item->quantity = $bulkOrder->quantity;
            $products = collect([$item]);
        } else {
            $order = ProductOrder::query()->with(['customer', 'orderAddress.state'])->where("order_id", $orderId)->orWhere('id', $orderId)->first();
            if (!$order) {
                return back()->with('error', 'Order not found.');
            }
            if ($order->user_id && !$order->customer) {
                $order->customer = \App\Models\User::where('user_id', $order->user_id)->first();
            }
            
            $products = ProductSlot::query()->whereIn("order_id", [$order->id, (string)$order->order_id])
                ->where(function($q) { $q->where('is_cancelled', '!=', 1)->orWhereNull('is_cancelled'); })
                ->with("productVarient", "productOrder.customer.user_addresses", "productOrder.orderAddress", "product.productvari", 'productOrder.orderAddress.state')
                ->get();
                
            if ($products->isEmpty()) {
                return back()->with('error', 'No valid products found for this order.');
            }
        }

        return view('invoicePages.export_packing_list', compact('products', 'order', 'invoiceData', 'labels'));
    }



    public function getOrderProductsForExport($orderId = null)
    {
        if (str_starts_with((string)$orderId, 'B-') || str_starts_with((string)$orderId, 'ORD-SAA-BULK-')) {
            if (str_starts_with((string)$orderId, 'B-')) {
                $bulkId = str_replace('B-', '', $orderId);
                $bulkOrder = \App\Models\BulkOrder::with('product')->find($bulkId);
            } else {
                $bulkOrder = \App\Models\BulkOrder::where('order_id', $orderId)->with('product')->first();
            }
            if (!$bulkOrder) {
                return response()->json([]);
            }
            
            return response()->json([
                [
                    'id' => 'bulk',
                    'name' => 'Bulk Order - ' . str_replace('_', ' ', $bulkOrder->product_type)
                ]
            ]);
        } else {
            $order = \App\Models\ProductOrder::where('order_id', $orderId)->orWhere('id', $orderId)->first();
            if (!$order) {
                return response()->json([]);
            }
            
            $products = \App\Models\ProductSlot::query()->whereIn("order_id", [$order->id, (string)$order->order_id])
                ->where(function($q) { $q->where('is_cancelled', '!=', 1)->orWhereNull('is_cancelled'); })
                ->with("product")
                ->get();
                
            $result = [];
            foreach($products as $p) {
                $name = $p->product_name ?? ($p->product->product_name ?? 'Item');
                $result[] = [
                    'id' => $p->id,
                    'name' => $name
                ];
            }
            return response()->json($result);
        }
    }

    public function upadetstatus(Request $request)
    {
        try {
            $order_id = $request->order_id;
            $status = $request->select_status;
            $custometid = $request->user_id;
            $numbercus = $request->phone_number;

            $sid = DB::table('product_tracking')
                ->where('order_id', $order_id)
                ->first();

            DB::table('product_orders')
                ->where('order_id', $order_id)
                ->update([
                    "delivery_status" => $status
                ]);

            DB::table('product_slots')
                ->where('order_id', $order_id)
                ->update([
                    "delivery_status" => $status
                ]);

            $productOrders =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->where("payment_status", 'Paid')->get();

            $order = ProductOrder::with("customer")->where("order_id", $order_id)->first();

            if ($order && $order->customer && $order->customer->email) {
                Mail::to($order->customer->email)->send(new OrderStatusUpdated($order, $status));
            }

            return response()->json([
                "message" => "Status update successfully",
                "productOrders" => $productOrders
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                "message" => "Error: " . $e->getMessage(),
                "file" => $e->getFile(),
                "line" => $e->getLine(),
                "trace" => $e->getTraceAsString()
            ], 500);
        }
    }

    // update status
    // public function upadetstatus(Request $request)
    // {

    //     $order_id = $request->order_id;
    //     $status = $request->select_status;
    //     $custometid = $request->user_id;
    //     $numbercus = $request->phone_number;

    //     //LOGGING INTO SHIPROCKET

    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/auth/login',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => '{"email": "thiruvenkatesh.sts@gmail.com","password": "Thiru@123"}',
    //         CURLOPT_HTTPHEADER => array(
    //             'Content-Type: application/json'
    //         ),
    //     ));
    //     $SR_login_Response = curl_exec($curl);
    //     curl_close($curl);
    //     $SR_login_Response_out = json_decode($SR_login_Response);
    //     $token = $SR_login_Response_out->{'token'};

    //     $sid = DB::table('product_tracking')
    //         ->where('order_id', $order_id)
    //         ->first();


    //     // GENERATING AWB CODE FOR ORDER TRACKING

    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/assign/awb',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => '{
    //             "shipment_id": "' . $sid->shiprocket_shipment_id . '",
    //             "courier_id": ""
    //         }',
    //         CURLOPT_HTTPHEADER => array(
    //             'Content-Type: application/json',
    //             'Authorization: Bearer' . $token,
    //         ),
    //     ));

    //     $altresponse = curl_exec($curl);
    //     $SR_login_Response_out6 = json_decode($altresponse);

    //     if (isset($SR_login_Response_out6->response->data->awb_code)) {
    //         $awb_code = $SR_login_Response_out6->response->data->awb_code;
    //     } else {
    //         $awb_code = 0;
    //     }

    //     curl_close($curl);

    //     // GENERATING TRACKING URL USING AWB CODE
    //     $shipmentId = $sid->shiprocket_shipment_id;

    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         // CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/track?order_id=$'.$shipmentId,
    //         CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/courier/track/shipment/$shipmentId",
    //         // CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/courier/track/awb/$shipmentId",
    //         // CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/track/shipment/221028486',
    //         // CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/orders/cancel/shipment/awbs',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'GET',
    //         CURLOPT_HEADER => 'Content-Type: application/json',
    //         CURLOPT_HTTPHEADER => array(
    //             'Authorization: Bearer' . $token,
    //         ),
    //     ));

    //     $response = curl_exec($curl);
    //     curl_close($curl);
    //     $SR_login_Response_out1 = json_decode($response, true);

    //     DB::table('product_orders')
    //         ->where('order_id', $order_id)
    //         ->update([
    //             "delivery_status" => $status
    //         ]);

    //     DB::table('product_slots')
    //         ->where('order_id', $order_id)
    //         ->update([
    //             "delivery_status" => $status
    //         ]);

    //     $trackurl = $SR_login_Response_out1['tracking_data']['track_url'];
    //     DB::table('product_tracking')->where('order_id', $order_id)->update(['awb_code' => $awb_code, 'tracking_url' => $trackurl]);

    //     // $productOrders = new ProductTracking();
    //     // $productOrders->order_id = $order_id;
    //     // $productOrders->delivery_status = $status;
    //     // $productOrders->user_id = $custometid;

    //     // $productOrders->save();


    //     $productOrders =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->where("payment_status", 1)->get();


    //     return response()->json([
    //         "message" => "Status update successfully",
    //         "productOrders" => $productOrders
    //     ]);
    // }

    public function pickupstatus(Request $request)
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/auth/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"email": "thiruvenkatesh.sts@gmail.com","password": "Thiru@123"}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $SR_login_Response = curl_exec($curl);
        curl_close($curl);
        $SR_login_Response_out = json_decode($SR_login_Response);
        $token = $SR_login_Response_out->{'token'};
        $order_id = $request->order_id;

        $ship = DB::table("product_tracking")->where('order_id', $order_id)->first();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/generate/pickup',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "shipment_id": [' . $ship->shiprocket_shipment_id . ']
                
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer' . $token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $productOrders =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->where("payment_status", 1)->get();


        return response()->json([
            "message" => "Status failed successfully",
            "productOrders" => $productOrders
        ]);
    }

    public function getproductfilter(Request $request)
    {
        $selectvalue = $request->category_id;


        $products =  Product::with(['category', 'Subcategory'])->where('category_id', $selectvalue)->get();

        $data = [
            'products' => $products,
            'i' => 1,
        ];

        return $data;
    }

    // product refund

    public function updaterefund(Request $request)
    {

        $order_id = $request->order_id;

        $custometid = $request->user_id;

        DB::table('product_orders')
            ->where('order_id', $order_id)
            ->update([
                "is_cancelled" => 1
            ]);

        DB::table('product_slots')
            ->where('order_id', $order_id)
            ->update([
                "is_cancelled" => 1
            ]);

        $productSlot = DB::table('product_slots')
            ->where('order_id', $order_id)
            ->first();



        $productSlotId = $productSlot ? $productSlot->id : null;

        ProductRefund::create([
            'order_id' => $order_id,
            'slot_id' => $productSlotId,
            'cancelled_by' => "Admin",
            'refund_status' => 0
        ]);

        $order =  DB::table('product_slots')
            ->where('order_id', $order_id)
            ->get();



        foreach ($order as $ord) {

            $getstock =  DB::table('productstocks')->where("productid", $ord->product_id)->where('pro_ver_id', $ord->product_varient_id)->first();

            DB::table('productstocks')->where("productid", $ord->product_id)->where('pro_ver_id', $ord->product_varient_id)->update([
                "overallstock" => $getstock->overallstock + $ord->quantity,
                "availablestock" => $getstock->availablestock + $ord->quantity,
                "salestock" => $getstock->salestock - $ord->quantity,


            ]);
        }


        $productOrders =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->where("payment_status", 1)->where("delivery_status", 0)->where("is_cancelled", "!=", 1)->get();

        return response()->json([
            "message" => "Status update successfully",
            "productOrders" => $productOrders
        ]);
    }

    public function Getsubproo($id)
    {
        $ff = SubCategory::where('category_name', $id)->get();
        return response()->json($ff);
    }

    public function getthump($product_id)
    {
        $thump = ProductChildImage::where('variant_id', $product_id)->get();

        // @dd($thump);
        return response()->json($thump);
    }

    public function saveExportFormData(Request $request)
    {
        $orderId = $request->input('order_id');
        if (!$orderId) {
            return response()->json(['success' => false, 'message' => 'Order ID is required'], 400);
        }

        $formData = $request->except(['_token']);

        \App\Models\OrderExportData::updateOrCreate(
            ['order_id' => $orderId],
            ['form_data' => $formData]
        );

        return response()->json(['success' => true, 'message' => 'Data saved successfully']);
    }

    public function getExportFormData($orderId)
    {
        $exportData = \App\Models\OrderExportData::where('order_id', $orderId)->first();
        if ($exportData) {
            return response()->json(['success' => true, 'data' => $exportData->form_data]);
        }
        return response()->json(['success' => false, 'data' => null]);
    }
}
