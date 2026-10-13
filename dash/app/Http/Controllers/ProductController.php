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
            
            $user = \App\Models\User::where('email', $bulkOrder->email)->first();
            $phone = $user ? $user->phone_number : 'N/A';
            $address = null;
            if ($user) {
                if ($user->user_default_address_id) {
                    $address = \App\Models\UserAddress::find($user->user_default_address_id);
                }
                if (!$address) {
                    $address = \App\Models\UserAddress::where('user_id', $user->user_id)->orWhere('user_id', $user->id)->latest()->first();
                }
            }

            $order->customer = new \stdClass();
            $order->customer->name = $bulkOrder->name;
            $order->customer->mobile = $phone;
            $order->customer->email = $bulkOrder->email;
            $order->customer->user_addresses = collect($address ? [$address] : []);

            $order->orderAddress = new \stdClass();
            $order->orderAddress->address_username = $bulkOrder->name;
            $order->orderAddress->address_line_one = $address ? $address->address_line_one : 'N/A';
            $order->orderAddress->address_line_two = $address ? $address->address_line_two : '';
            $order->orderAddress->city = $address ? $address->city : '';
            $order->orderAddress->pincode = $address ? $address->pincode : '';
            $order->orderAddress->address_phone_number = $address ? ($address->address_phone_number ?? $phone) : 'N/A';
            $order->orderAddress->state = new \stdClass();
            $order->orderAddress->state->state_name = $address ? $address->state : '';

            $item = new \stdClass();
            $item->productOrder = clone $order;
            $item->product = clone $order;
            $productName = 'Bulk Order - ' . str_replace('_', ' ', $bulkOrder->product_type);
            $productImage = $bulkOrder->custom_image;

            if ($bulkOrder->product_type === 'own_design' && $bulkOrder->product_id) {
                $design = \App\Models\Design::find($bulkOrder->product_id);
                if ($design) {
                    $productName = 'Bulk Order - ' . $design->title;
                    $productImage = $design->image;
                }
            } elseif ($bulkOrder->product_type === 'custom_design' && $bulkOrder->product_id) {
                // Models may be in web namespace if not present in dash, but let's try assuming they are accessible or fully qualified.
                // It looks like CustomproductDesign is in \App\Models\CustomproductDesign based on web, but might need to be verified if dash has it.
                // We'll use DB query to be safe if model doesn't exist in dash app.
                $custom = \Illuminate\Support\Facades\DB::table('customproduct_designs')->where('id', $bulkOrder->product_id)->first();
                if ($custom) {
                    $cProduct = \Illuminate\Support\Facades\DB::table('customproducts')->where('id', $custom->customproduct_id)->first();
                    $cName = $cProduct ? $cProduct->name : 'Custom Design';
                    $productName = 'Bulk Order - ' . $cName;
                    $productImage = $custom->thumbnail_path ?? $custom->preview_image_front;
                }
            }
            $item->product_name = $productName;
            $item->product->product_name = $productName;
            $item->productVarient = clone $item->product;
            $item->productVarient->varient = 5;
            $item->productVarient->offer_price = $bulkOrder->final_rate ?? 0;
            $item->productVarient->product_quantity = '';
            $item->product_image = $productImage;
            
            $finalQty = $bulkOrder->final_qty ?? $bulkOrder->quantity;
            $finalRate = $bulkOrder->final_rate ?? 0;
            
            $item->size_value = $bulkOrder->final_size ?: 'N/A (Bulk)';
            $item->color_value = $bulkOrder->final_color ?: 'N/A (Bulk)';
            $item->quantity = $finalQty;
            $item->product_rate = $finalRate;
            $item->product_total = $finalQty * $finalRate;
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
        $invoiceData = $request->except(['order_id', 'type', 'download', 'view', 'lang']);

        $locale = $request->input('lang') ?? \Illuminate\Support\Facades\Session::get('lang', 'en');

        $labels = $this->getExportTranslations($locale);

        if (str_starts_with((string)$orderId, 'B-') || str_starts_with((string)$orderId, 'ORD-SAA-BULK-')) {
            if (str_starts_with((string)$orderId, 'B-')) {
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
                $order = new \stdClass();
                $order->id = 1;
                $order->order_id = $orderId ?? 'ORD-EXPORT';
                $order->created_at = now();
                $order->customer = new \stdClass();
                $order->customer->name = 'Customer';
                $order->customer->email = 'info@example.com';
                $order->orderAddress = new \stdClass();
            } elseif ($order->user_id && !$order->customer) {
                $order->customer = \App\Models\User::where('user_id', $order->user_id)->first();
            }
            
            if ($order instanceof ProductOrder) {
                $products = ProductSlot::query()->whereIn("order_id", [$order->id, (string)$order->order_id])
                    ->where(function($q) { $q->where('is_cancelled', '!=', 1)->orWhereNull('is_cancelled'); })
                    ->with("productVarient", "productOrder.customer.user_addresses", "productOrder.orderAddress", "product.productvari", 'productOrder.orderAddress.state', 'product.category')
                    ->get();
            } else {
                $products = collect();
            }
        }

        // If custom products are submitted from the form, override products
        if ($request->has('custom_products') && is_array($request->input('custom_products')) && count($request->input('custom_products')) > 0) {
            $products = collect();
            foreach ($request->input('custom_products') as $pIndex => $pItem) {
                if (empty(trim($pItem['name'] ?? ''))) continue;
                $pObj = new \stdClass();
                $pObj->id = $pItem['id'] ?? ('p_' . $pIndex);
                $pObj->product_name = $pItem['name'];
                $pObj->quantity = (float)($pItem['quantity'] ?? 1);
                $pObj->product_rate = (float)($pItem['price'] ?? 0);
                $pObj->product = (object) ['product_name' => $pItem['name']];
                $pObj->productVarient = (object) ['offer_price' => (float)($pItem['price'] ?? 0), 'product_quantity' => ''];
                $products->push($pObj);
            }
        }

        if ($products->isEmpty()) {
            return back()->with('error', 'No valid products found for this order.');
        }

        // Custom Invoice Number or generate on the fly
        $customInvoiceNo = $request->input('doc_invoice_no') ?? ($request->input('invoice_number') ?? $request->input('invoice_no'));
        if (!empty(trim((string)$customInvoiceNo))) {
            $invoiceNumber = trim((string)$customInvoiceNo);
        } else {
            $prefix = ($invoiceType === 'proforma') ? 'PRO-' : 'INV-';
            $datePart = \Carbon\Carbon::parse($order->created_at ?? now())->format('Ym');
            $incrementPart = str_pad($order->id ?? 1, 4, '0', STR_PAD_LEFT);
            $invoiceNumber = $prefix . $datePart . '-' . $incrementPart;
        }

        return view('invoicePages.export_commercial_invoice', compact('products', 'order', 'invoiceData', 'invoiceType', 'invoiceNumber', 'labels'));
    }

    public function exportPackingList(Request $request)
    {
        $orderId = $request->input('order_id');
        $invoiceData = $request->except(['order_id', 'download', 'view', 'lang']);

        $locale = $request->input('lang') ?? \Illuminate\Support\Facades\Session::get('lang', 'en');

        $labels = $this->getExportTranslations($locale);

        if (str_starts_with((string)$orderId, 'B-') || str_starts_with((string)$orderId, 'ORD-SAA-BULK-')) {
            if (str_starts_with((string)$orderId, 'B-')) {
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
                $order = new \stdClass();
                $order->id = 1;
                $order->order_id = $orderId ?? 'ORD-EXPORT';
                $order->customer = new \stdClass();
                $order->customer->name = 'Customer';
                $order->customer->email = 'info@example.com';
                $order->orderAddress = new \stdClass();
            } elseif ($order->user_id && !$order->customer) {
                $order->customer = \App\Models\User::where('user_id', $order->user_id)->first();
            }
            
            if ($order instanceof ProductOrder) {
                $products = ProductSlot::query()->whereIn("order_id", [$order->id, (string)$order->order_id])
                    ->where(function($q) { $q->where('is_cancelled', '!=', 1)->orWhereNull('is_cancelled'); })
                    ->with("productVarient", "productOrder.customer.user_addresses", "productOrder.orderAddress", "product.productvari", 'productOrder.orderAddress.state')
                    ->get();
            } else {
                $products = collect();
            }
        }

        if ($request->has('custom_products') && is_array($request->input('custom_products')) && count($request->input('custom_products')) > 0) {
            $products = collect();
            foreach ($request->input('custom_products') as $pIndex => $pItem) {
                if (empty(trim($pItem['name'] ?? ''))) continue;
                $pObj = new \stdClass();
                $pObj->id = $pItem['id'] ?? ('p_' . $pIndex);
                $pObj->product_name = $pItem['name'];
                $pObj->quantity = (float)($pItem['quantity'] ?? 1);
                $pObj->product_rate = (float)($pItem['price'] ?? 0);
                $pObj->product = (object) ['product_name' => $pItem['name']];
                $pObj->productVarient = (object) ['offer_price' => (float)($pItem['price'] ?? 0), 'product_quantity' => ''];
                $products->push($pObj);
            }
        }

        if ($products->isEmpty()) {
            return back()->with('error', 'No valid products found for this order.');
        }

        // Custom Invoice Number or generate on the fly
        $customInvoiceNo = $request->input('doc_invoice_no') ?? ($request->input('invoice_number') ?? $request->input('invoice_no'));
        if (!empty(trim((string)$customInvoiceNo))) {
            $invoiceNumber = trim((string)$customInvoiceNo);
        } else {
            $datePart = \Carbon\Carbon::parse($order->created_at ?? now())->format('Ym');
            $incrementPart = str_pad($order->id ?? 1, 4, '0', STR_PAD_LEFT);
            $invoiceNumber = 'INV-' . $datePart . '-' . $incrementPart;
        }

        return view('invoicePages.export_packing_list', compact('products', 'order', 'invoiceData', 'invoiceNumber', 'labels'));
    }

    private function getExportTranslations($locale = 'en')
    {
        $translations = [
            'en' => [
                'commercial_invoice'          => 'COMMERCIAL INVOICE',
                'proforma_invoice'            => 'PROFORMA INVOICE',
                'packing_list'                => 'PACKING LIST',
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
                'shipment_date'               => 'SHIPMENT DATE',
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
                'total_weight'                => 'TOTAL GROSS WEIGHT',
                'certify_text'                => 'I/We certify the information on this invoice is true and correct and that the contents of this shipment are as stated above.',
                'signature'                   => 'Signature',
                'designation_title'           => 'Designation/Title',
            ],
            'ta' => [
                'commercial_invoice'          => 'வணிக விலைப்பட்டியல் (COMMERCIAL INVOICE)',
                'proforma_invoice'            => 'புரோஃபார்மா விலைப்பட்டியல் (PROFORMA INVOICE)',
                'packing_list'                => 'பேக்கிங் பட்டியல் (PACKING LIST)',
                'date'                        => 'தேதி (Date)',
                'invoice_number'              => 'விலைப்பட்டியல் எண் (Invoice No)',
                'air_waybill_number'          => 'ஏர் வேபில் எண் (Air Waybill No)',
                'general_information'         => 'பொதுவான தகவல்கள் (General Information)',
                'sender_details'              => 'அனுப்புநர் விபரம் (Sender Details)',
                'shipment_details'            => 'ஏற்றுமதி விபரம் (Shipment Details)',
                'name'                        => 'பெயர் (Name)',
                'address'                     => 'முகவரி (Address)',
                'contact_number'              => 'தொடர்பு எண் (Contact No)',
                'email'                       => 'மின்னஞ்சல் (Email)',
                'tax_id_no'                   => 'வரி ஐடி எண் (Tax ID No)',
                'shipment_date'               => 'ஏற்றுமதி தேதி (Shipment Date)',
                'shipment_ref_no'             => 'ஏற்றுமதி குறிப்பு எண் (Shipment Ref No)',
                'reason_for_export'           => 'ஏற்றுமதிக்கான காரணம் (Reason for Export)',
                'type_of_export'              => 'ஏற்றுமதி வகை (Type of Export)',
                'export_license_no'           => 'ஏற்றுமதி உரிம எண் (Export License No)',
                'import_license_no'           => 'இறக்குமதி உரிம எண் (Import License No)',
                'incoterms'                   => 'இன்கோடெர்ம்ஸ் (INCOTERMS)',
                'currency_code'               => 'நாணயக் குறியீடு (Currency Code)',
                'payment_method'              => 'பணம் செலுத்தும் முறை (Payment Method)',
                'printing_method'             => 'அச்சிடும் முறை (Printing Method)',
                'receiver_details'            => 'பெறுநர் விபரம் (Receiver Details)',
                'importer_of_record_details'  => 'இறக்குமதியாளர் விபரம் (Importer Details)',
                'no'                          => 'எண் (No.)',
                'item_description'            => 'பொருள் விளக்கம் (Item Description)',
                'hs_code'                     => 'HS குறியீடு (HS Code)',
                'country_of_origin'           => 'உற்பத்தி நாடு (Country of Origin)',
                'qty_uom'                     => 'அளவு (Qty UOM)',
                'unit_value'                  => 'யூனிட் விலை (Unit Value)',
                'sub_total_value'             => 'மொத்த மதிப்பு (Sub-Total Value)',
                'unit_net_weight'             => 'யூனிட் நிகர எடை (Unit Net Wt)',
                'other_info'                  => 'இதர தகவல்கள் மற்றும் சான்றிதழ் விபரங்கள் (OTHER INFORMATION AND COMPLIANCE DETAILS)',
                'no_of_packages'              => 'தொகுப்புகளின் எண்ணிக்கை (No. of Packages)',
                'total_goods_value'           => 'பொருட்களின் மொத்த மதிப்பு (Total Goods Value)',
                'total_weight'                => 'மொத்த எடை (TOTAL GROSS WEIGHT)',
                'certify_text'                => 'இந்த விலைப்பட்டியலில் உள்ள தகவல்கள் உண்மை மற்றும் துல்லியமானவை என சான்றளிக்கிறேன்.',
                'signature'                   => 'கையொப்பம் (Signature)',
                'designation_title'           => 'பதவி / பொறுப்பு (Designation/Title)',
            ],
            'de' => [
                'commercial_invoice'          => 'HANDELSRECHNUNG (COMMERCIAL INVOICE)',
                'proforma_invoice'            => 'PROFORMA-RECHNUNG (PROFORMA INVOICE)',
                'packing_list'                => 'PACKLISTE (PACKING LIST)',
                'date'                        => 'Datum',
                'invoice_number'              => 'Rechnungsnummer',
                'air_waybill_number'          => 'Luftfrachtbriefnummer',
                'general_information'         => 'Allgemeine Informationen',
                'sender_details'              => 'Absenderangaben',
                'shipment_details'            => 'Versanddetails',
                'name'                        => 'Name',
                'address'                     => 'Adresse',
                'contact_number'              => 'Kontaktnummer',
                'email'                       => 'E-Mail',
                'tax_id_no'                   => 'Steuer-ID-Nr.',
                'shipment_date'               => 'VERSANDDATUM',
                'shipment_ref_no'             => 'Sendungsreferenznummer',
                'reason_for_export'           => 'Ausfuhrgrund',
                'type_of_export'              => 'Exportart',
                'export_license_no'           => 'Ausfuhrlizenznummer',
                'import_license_no'           => 'Einfuhrlizenznummer',
                'incoterms'                   => 'INCOTERMS',
                'currency_code'               => 'Währungscode',
                'payment_method'              => 'Zahlungsmethode',
                'receiver_details'            => 'Empfängerangaben',
                'importer_of_record_details'  => 'Importeurangaben',
                'no'                          => 'Nr.',
                'item_description'            => 'Warenbezeichnung',
                'hs_code'                     => 'HS-Code',
                'country_of_origin'           => 'Ursprungsland',
                'qty_uom'                     => 'Menge / ME',
                'unit_value'                  => 'Einzelpreis',
                'sub_total_value'             => 'Zwischensumme',
                'unit_net_weight'             => 'Nettoeinzelfr.',
                'other_info'                  => 'SONSTIGE ANGABEN UND COMPLIANCE-DETAILS',
                'no_of_packages'              => 'Anzahl der Packstücke',
                'total_goods_value'           => 'Warenwert gesamt',
                'total_weight'                => 'BRUTTOGESAMTGEWICHT',
                'certify_text'                => 'Ich/Wir bestätigen, dass die Angaben auf dieser Rechnung wahrheitsgemäß und korrekt sind.',
                'signature'                   => 'Unterschrift',
                'designation_title'           => 'Bezeichnung / Titel',
            ],
            'fr' => [
                'commercial_invoice'          => 'FACTURE COMMERCIALE',
                'proforma_invoice'            => 'FACTURE PROFORMA',
                'packing_list'                => 'LISTE DE COLISAGE',
                'date'                        => 'Date',
                'invoice_number'              => 'Numéro de facture',
                'air_waybill_number'          => 'Numéro de lettre de transport aérien',
                'general_information'         => 'Informations Générales',
                'sender_details'              => 'Détails de l\'expéditeur',
                'shipment_details'            => 'Détails de l\'expédition',
                'name'                        => 'Nom',
                'address'                     => 'Adresse',
                'contact_number'              => 'Numéro de contact',
                'email'                       => 'E-mail',
                'tax_id_no'                   => 'N° d\'identification fiscale',
                'shipment_date'               => 'DATE D\'EXPÉDITION',
                'shipment_ref_no'             => 'N° de référence de l\'expédition',
                'reason_for_export'           => 'Raison de l\'exportation',
                'type_of_export'              => 'Type d\'exportation',
                'export_license_no'           => 'N° de licence d\'exportation',
                'import_license_no'           => 'N° de licence d\'importation',
                'incoterms'                   => 'INCOTERMS',
                'currency_code'               => 'Code devise',
                'payment_method'              => 'Mode de paiement',
                'receiver_details'            => 'Détails du destinataire',
                'importer_of_record_details'  => 'Détails de l\'importateur',
                'no'                          => 'N°',
                'item_description'            => 'Description de l\'article',
                'hs_code'                     => 'Code SH',
                'country_of_origin'           => 'Pays d\'origine',
                'qty_uom'                     => 'Qté UDM',
                'unit_value'                  => 'Valeur unitaire',
                'sub_total_value'             => 'Valeur sous-totale',
                'unit_net_weight'             => 'Poids net unitaire',
                'other_info'                  => 'AUTRES INFORMATIONS ET DÉTAILS DE CONFORMITÉ',
                'no_of_packages'              => 'Nombre de colis',
                'total_goods_value'           => 'Valeur totale des marchandises',
                'total_weight'                => 'POIDS BRUT TOTAL',
                'certify_text'                => 'Je/Nous certifions que les informations sur cette facture sont véridiques et exactes.',
                'signature'                   => 'Signature',
                'designation_title'           => 'Désignation / Titre',
            ],
            'es' => [
                'commercial_invoice'          => 'FACTURA COMERCIAL',
                'proforma_invoice'            => 'FACTURA PROFORMA',
                'packing_list'                => 'LISTA DE EMPAQUE',
                'date'                        => 'Fecha',
                'invoice_number'              => 'Número de Factura',
                'air_waybill_number'          => 'Número de Guía Aérea',
                'general_information'         => 'Información General',
                'sender_details'              => 'Detalles del Remitente',
                'shipment_details'            => 'Detalles del Envío',
                'name'                        => 'Nombre',
                'address'                     => 'Dirección',
                'contact_number'              => 'Número de Contacto',
                'email'                       => 'Correo Electrónico',
                'tax_id_no'                   => 'N° de Identificación Fiscal',
                'shipment_date'               => 'FECHA DE ENVÍO',
                'shipment_ref_no'             => 'N° de Referencia de Envío',
                'reason_for_export'           => 'Motivo de Exportación',
                'type_of_export'              => 'Tipo de Exportación',
                'export_license_no'           => 'N° de Licencia de Exportación',
                'import_license_no'           => 'N° de Licencia de Importación',
                'incoterms'                   => 'INCOTERMS',
                'currency_code'               => 'Código de Moneda',
                'payment_method'              => 'Método de Pago',
                'receiver_details'            => 'Detalles del Receptor',
                'importer_of_record_details'  => 'Detalles del Importador',
                'no'                          => 'N°',
                'item_description'            => 'Descripción del Artículo',
                'hs_code'                     => 'Código SA',
                'country_of_origin'           => 'País de Origen',
                'qty_uom'                     => 'Cant. UDM',
                'unit_value'                  => 'Valor Unitario',
                'sub_total_value'             => 'Valor Subtotal',
                'unit_net_weight'             => 'Peso Neto Unit.',
                'other_info'                  => 'OTRA INFORMACIÓN Y DETALLES DE CUMPLIMIENTO',
                'no_of_packages'              => 'Número de Paquetes',
                'total_goods_value'           => 'Valor Total de Mercancías',
                'total_weight'                => 'PESO BRUTO TOTAL',
                'certify_text'                => 'Certifico/Certificamos que la información en esta factura es verídica y correcta.',
                'signature'                   => 'Firma',
                'designation_title'           => 'Designación / Título',
            ],
            'ar' => [
                'commercial_invoice'          => 'الفاتورة التجارية (COMMERCIAL INVOICE)',
                'proforma_invoice'            => 'فاتورة شكلية (PROFORMA INVOICE)',
                'packing_list'                => 'قائمة التعبئة (PACKING LIST)',
                'date'                        => 'التاريخ',
                'invoice_number'              => 'رقم الفاتورة',
                'air_waybill_number'          => 'رقم بوليصة الشحن الجوي',
                'general_information'         => 'معلومات عامة',
                'sender_details'              => 'تفاصيل المرسل',
                'shipment_details'            => 'تفاصيل الشحنة',
                'name'                        => 'الاسم',
                'address'                     => 'العنوان',
                'contact_number'              => 'رقم الاتصال',
                'email'                       => 'البريد الإلكتروني',
                'tax_id_no'                   => 'الرقم الضريبي',
                'shipment_date'               => 'تاريخ الشحن',
                'shipment_ref_no'             => 'رقم مرجع الشحنة',
                'reason_for_export'           => 'سبب التصدير',
                'type_of_export'              => 'نوع التصدير',
                'export_license_no'           => 'رقم ترخيص التصدير',
                'import_license_no'           => 'رقم ترخيص الاستيراد',
                'incoterms'                   => 'شروط التجارة الدولية (INCOTERMS)',
                'currency_code'               => 'رمز العملة',
                'payment_method'              => 'طريقة الدفع',
                'receiver_details'            => 'تفاصيل المستلم',
                'importer_of_record_details'  => 'تفاصيل المستورد',
                'no'                          => 'الرقم',
                'item_description'            => 'وصف الصنف',
                'hs_code'                     => 'رمز النظام المنسق',
                'country_of_origin'           => 'بلد المنشأ',
                'qty_uom'                     => 'الكمية / الوحدة',
                'unit_value'                  => 'سعر الوحدة',
                'sub_total_value'             => 'القيمة الفرعية',
                'unit_net_weight'             => 'صافي وزن الوحدة',
                'other_info'                  => 'معلومات أخرى وتفاصيل الامتثال',
                'no_of_packages'              => 'عدد الطرود',
                'total_goods_value'           => 'إجمالي قيمة البضائع',
                'total_weight'                => 'إجمالي الوزن الإجمالي',
                'certify_text'                => 'أشهد / نشهد بأن المعلومات الواردة في هذه الفاتورة صحيحة ودقيقة.',
                'signature'                   => 'التوقيع',
                'designation_title'           => 'المسمى الوظيفي / الصفة',
            ],
        ];

        $lang = strtolower($locale);
        $base = $translations['en'];
        if (isset($translations[$lang])) {
            return array_merge($base, $translations[$lang]);
        }
        return $base;
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
                    'name' => 'Bulk Order - ' . str_replace('_', ' ', $bulkOrder->product_type),
                    'quantity' => $bulkOrder->quantity ?? 1,
                    'price' => 0
                ]
            ]);
        } else {
            $order = \App\Models\ProductOrder::where('order_id', $orderId)->orWhere('id', $orderId)->first();
            if (!$order) {
                return response()->json([]);
            }
            
            $products = \App\Models\ProductSlot::query()->whereIn("order_id", [$order->id, (string)$order->order_id])
                ->where(function($q) { $q->where('is_cancelled', '!=', 1)->orWhereNull('is_cancelled'); })
                ->with(["product", "productVarient"])
                ->get();
                
            $result = [];
            foreach($products as $p) {
                $name = $p->product_name ?? ($p->product->product_name ?? 'Item');
                $price = $p->product_rate ?? ($p->productVarient->offer_price ?? ($p->product->product_price ?? 0));
                $result[] = [
                    'id' => $p->id,
                    'name' => $name,
                    'quantity' => (float)($p->quantity ?? 1),
                    'price' => (float)$price
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
        $savedData = $exportData ? ($exportData->form_data ?? []) : [];

        $defaultData = [];
        if (str_starts_with((string)$orderId, 'B-') || str_starts_with((string)$orderId, 'ORD-SAA-BULK-')) {
            if (str_starts_with((string)$orderId, 'B-')) {
                $bulkId = str_replace('B-', '', $orderId);
                $bulkOrder = \App\Models\BulkOrder::find($bulkId);
            } else {
                $bulkOrder = \App\Models\BulkOrder::where('order_id', $orderId)->first();
            }
            if ($bulkOrder) {
                $defaultData = [
                    'receiver_name'    => $bulkOrder->name ?? '',
                    'receiver_email'   => $bulkOrder->email ?? '',
                    'receiver_address' => $bulkOrder->address ?? 'N/A',
                    'receiver_contact' => $bulkOrder->phone ?? ($bulkOrder->mobile ?? 'N/A'),
                    'receiver_tax_id'  => 'N/A',
                ];
            }
        } else {
            $order = \App\Models\ProductOrder::with(['customer', 'orderAddress.state'])->where('order_id', $orderId)->orWhere('id', $orderId)->first();
            if ($order) {
                $addr = $order->orderAddress;
                $userId = $order->user_id ?? ($addr->user_id ?? null);
                $user = $order->customer ?? ($userId ? \App\Models\User::where('user_id', $userId)->orWhere('id', $userId)->first() : null);

                $receiverName = $addr->address_username ?? ($user->name ?? '');
                $receiverEmail = $user->email ?? '';
                $receiverContact = $addr->address_phone_number ?? ($addr->address_phone ?? ($user->phone_number ?? ($user->mobile ?? '')));

                $addrParts = [];
                if (!empty($addr->address_line_one)) $addrParts[] = $addr->address_line_one;
                if (!empty($addr->address_line_two)) $addrParts[] = $addr->address_line_two;
                if (!empty($addr->landmark)) $addrParts[] = $addr->landmark;
                if (!empty($addr->city)) $addrParts[] = $addr->city;
                if (!empty($addr->state->state_name)) $addrParts[] = $addr->state->state_name;
                elseif (!empty($addr->state)) $addrParts[] = $addr->state;
                if (!empty($addr->pincode)) $addrParts[] = '- ' . $addr->pincode;
                if (!empty($addr->country)) $addrParts[] = $addr->country;

                $receiverAddress = !empty($addrParts) ? implode(", ", $addrParts) : 'N/A';

                $defaultData = [
                    'receiver_name'    => $receiverName,
                    'receiver_email'   => $receiverEmail,
                    'receiver_address' => $receiverAddress,
                    'receiver_contact' => $receiverContact,
                    'receiver_tax_id'  => $user->gst_number ?? ($user->gstin ?? ($user->tax_id ?? 'N/A')),
                ];
            }
        }

        $finalData = $defaultData;
        foreach ($savedData as $k => $v) {
            if ($v !== null && $v !== '') {
                $finalData[$k] = $v;
            } elseif (!array_key_exists($k, $finalData)) {
                $finalData[$k] = $v;
            }
        }

        return response()->json(['success' => true, 'data' => $finalData]);
    }
}
