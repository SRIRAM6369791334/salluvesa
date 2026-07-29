<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductChildImage;
use App\Models\ProductVarient;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductVarientControllet extends Controller
{
    public $productvarientSuccessMessage = "Product varient Added Successfully";
    public function index()
    {
        $productvarient = ProductVarient::select('product_varient.*', 'products.product_name', 'products.category_id', 'categories.category_name')
            ->join('products', 'product_varient.product_id', "=", 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->get();



        $products = Product::all();
        $categories = Category::all();
        $subcategories = SubCategory::all();



        return view("pages.product_varient", compact('productvarient', 'products', 'categories', 'subcategories'));
    }

    public function addproductvarient(Request $request)
    {
        $validated = $request->validate([
            'categoryid' => "required",
            'subcategoryid' => "required",
            'product_id' => "required",
            'mrp_price' => "required",
            'offer_price' => "required",
            'product_qty' => "required",
            'low_stock' => "required",
            'product_gst' => 'nullable',
        ]);


        $subcate = $request->subcategoryid;
        $subcatedisplay = SubCategory::where('id', $subcate)->first();
        $displayname = $subcatedisplay->subcategory_name;


        $product_size = $request->add_prod_size_select;
        $product_color = $request->add_product_color_value;


        $productver =  ProductVarient::create([
            ...$validated,
            "subcatename" => $displayname,
            "size_value" => $product_size,
            "color_value" => $product_color,
        ]);
        $product =  Product::find($validated["product_id"]);
        $categoryId = $product->category_id;
        $subacategoryid = $product->subcategory_id;
        $proname = $product->product_name;


        foreach ($request->product_image2 as $key => $productCode) {
            $path =  $productCode->store("product_images1", "public");
            $product1 = ProductChildImage::create(["product_id" => $product->id, "product_child_image" => $path, "variant_id" => $productver->id]);
        }



        DB::table('productstocks')->insert([
            "productid" => $request->product_id,
            "category_id" =>  $categoryId,
            "subcategory_id" => $subacategoryid,
            "pro_ver_id" => $productver->id,
            "productname" => $proname,
            "overallstock" =>  $request->product_qty,
            "availablestock" => $request->product_qty,
            "salestock" => 0,
            "low_stocks" => $request->low_stock,
            "last_stockupdate_date" => date("Y-m-d"),
        ]);


        $productvarient = ProductVarient::select('product_varient.*', 'products.product_name', 'products.category_id', 'categories.category_name')
            ->join('products', 'product_varient.product_id', "=", 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->get();



        $products = Product::all();
        $categories = Category::all();


        return response()->json([
            "message" => $this->productvarientSuccessMessage,
            "productvarient" => $productvarient
        ]);
    }

    public function update(Request $request, $id)
    {
        $productvarient = ProductVarient::findOrFail($id);

        $validated = $request->validate([
            'categoryid' => "required",
            'subcategoryid' => "required",
            'product_id' => "required",

            'mrp_price' => "required",
            'offer_price' => "required",
            'product_qty' => "required",
            'low_stock' => "required",
            'product_gst' => 'nullable',




        ]);
        $hotDealsValue = $request->has('hot_deals') ? $request->input('hot_deals') : 0;

        $productvarient->update([
            'categoryid' => $validated["categoryid"],
            'subcategoryid' => $validated["subcategoryid"],
            'product_id' => $validated["product_id"],
            'varient' => $request->input('varient'),
            'value' => $request->input(key: 'value'),
            'mrp_price' => $validated["mrp_price"],
            'offer_price' => $validated["offer_price"],
            'product_qty' => $validated["product_qty"],
            'low_stock' => $validated["low_stock"],
            'hot_deals' => $hotDealsValue,
            'product_gst' => $validated["product_gst"],
            'size_value' => $request->input('edit_prod_size_select'),
            'color_value' => $request->input('edit_product_color_value'),
        ]);


        $product = Product::find($validated['product_id']);
        $categoryId = $product->category_id;
        $subaCategoryId = $product->subcategory_id;
        $proname = $product->product_name;

        // Update product stock based on the changes made to the product variant
        DB::table('productstocks')
            ->where('pro_ver_id', $productvarient->id)
            ->update([
                'productid' => $validated['product_id'],
                'category_id' => $categoryId,
                'subcategory_id' => $subaCategoryId,
                'productname' => $proname,
                'overallstock' => $request->product_qty,
                'availablestock' => $request->product_qty,
                'low_stocks' => $request->low_stock,
                'last_stockupdate_date' => now(),
            ]);






        //  ====  update image =



        if ($request->hasFile('product_image1')) {
            foreach ($request->file('product_image1') as $key => $img) {
                if ($img->isFile()) {
                    // Store in 'images' folder instead of 'product_images1'
                    $path = $img->store("product_images1", "public");

                    // Check if an existing child image exists for this variant and product
                    $existingImage = ProductChildImage::where('variant_id', $productvarient->id)
                        ->where('product_id', $product->id)
                        ->skip($key)->first(); // match index if order matters

                    if ($existingImage) {
                        // Delete old file
                        if (File::exists(public_path('product_images1/' . $existingImage->product_child_image))) {
                            File::delete(public_path('product_images1/' . $existingImage->product_child_image));
                        }

                        // Update database with new path
                        $existingImage->update([
                            'product_child_image' => $path
                        ]);
                    } else {
                        // Create new record if not exists
                        ProductChildImage::create([
                            'variant_id' => $productvarient->id,
                            'product_id' => $product->id,
                            'product_child_image' => $path
                        ]);
                    }
                }
            }
        }









        $productvarient = ProductVarient::select('product_varient.*', 'products.product_name', 'products.category_id', 'categories.category_name')
            ->join('products', 'product_varient.product_id', "=", 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->get();

        return response()->json([
            "message" => $this->productvarientSuccessMessage,
            "productvarient" => $productvarient
        ]);
    }

    public function destroy($id)
    {
        try {
            // Start transaction to ensure atomicity
            DB::beginTransaction();

            // Find the variant and its product_id
            $variant = ProductVarient::find($id);

            if (!$variant) {
                DB::rollBack();
                return response()->json([
                    "message" => "Product Variant Not Found",
                ], 404);
            }

            $productId = $variant->product_id;

            // Count how many variants this product currently has
            $variantCount = ProductVarient::where('product_id', $productId)->count();

            // Delete the variant
            $variant->delete();

            // Delete productstocks rows related to this variant
            DB::table('productstocks')->where('pro_ver_id', $id)->delete();

            $productDeleted = false;

            // If this was the only variant, delete the product as well
            if ($variantCount <= 1) {
                // Optionally delete any product-related data here (images, meta, etc.)
                Product::where('id', $productId)->delete();
                $productDeleted = true;

                // If you have product-specific tables referencing product_id, delete them here too.
                // e.g. DB::table('product_images')->where('product_id', $productId)->delete();
            }

            // Get remaining variants for the product (will be empty if product deleted)
            $productvarient = ProductVarient::select('product_varient.*', 'products.product_name', 'products.category_id', 'categories.category_name')
                ->join('products', 'product_varient.product_id', "=", 'products.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where('product_varient.product_id', $productId)
                ->get();

            DB::commit();

            return response()->json([
                "message" => $productDeleted ? "Product Variant and Product Deleted Successfully" : "Product Variant Deleted Successfully",
                "product_deleted" => $productDeleted,
                "productvarient" => $productvarient
            ]);
        } catch (Exception   $e) {
            DB::rollBack();
            // Log the exception in your real app: \Log::error($e);
            return response()->json([
                "message" => "Something went wrong while deleting the variant.",
                "error" => $e->getMessage()
            ], 500);
        }
    }



    public function Getsubcategory($id)
    {
        $product = Product::where('subcategory_id', $id)->get();
        return response()->json($product);
    }
    public function Getproduct($id)
    {
        $product = Product::where('category_id', $id)->get();
        return response()->json($product);
    }

    public function getproductverfilter(Request $request)
    {

        $catId =  $request->category_id;
        $productId = $request->product_id;



        $productvarient = ProductVarient::select('product_varient.*', 'products.product_name', 'products.category_id', 'categories.category_name')
            ->join('products', 'product_varient.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->when($request->filled('category_id'), function ($query) use ($catId) {
                $query->where('products.category_id', $catId);
            })
            ->when($request->filled('product_id'), function ($query) use ($productId) {
                $query->where('products.id', $productId);
            })
            // Add more conditions as needed
            ->get();

        $data = [
            'productvarient' => $productvarient,
            'i' => 1,
        ];

        return $data;
    }
}
