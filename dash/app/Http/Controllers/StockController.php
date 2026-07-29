<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductVarient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $stocks = ProductStock::select('productstocks.*', 'categories.category_name', 'product_varient.varient', 'product_varient.value', 'product_varient.size_value', 'product_varient.color_value')
            ->join('categories', 'productstocks.category_id', '=', 'categories.id')
            ->join('product_varient', 'productstocks.pro_ver_id', '=', 'product_varient.id')

            ->get();


        return view('pages.stocks', compact('stocks'));
    }


    public function update(Request $request)

    {
        $stockqty = $request->stock_quantity;
        $productid = $request->productid;



        $getstockdetails = ProductStock::where('id', $productid)->first();
        $productdetails = ProductVarient::where('id', $productid)->first();

        $updatestock = ProductStock::where('id', $productid)
            ->update([
                "overallstock" => $getstockdetails->overallstock + $stockqty,
                "availablestock" => $getstockdetails->availablestock + $stockqty,
            ]);

        $updatestockproduct = ProductVarient::where('id', $productid)
            ->update([
                "product_qty" => $getstockdetails->availablestock + $stockqty,
            ]);

        $stocks = ProductStock::select('productstocks.*', 'categories.category_name')
            ->join('categories', 'productstocks.category_id', '=', 'categories.id')
            ->get();
        return response()->json(["stocks" =>  $stocks]);
    }

    public function reduceStock(Request $request)
    {
        $stockQty = (int) $request->stock_quantity;
        $productStockId = $request->productid;

        $productStock = ProductStock::where('id', $productStockId)->first();

        if (!$productStock) {
            return response()->json(['error' => 'Product stock not found.'], 404);
        }

        // Get the variant ID from stock table (assumes relation)
        $productVariant = ProductVarient::where('id', $productStock->pro_ver_id)->first();

        if (!$productVariant) {
            return response()->json(['error' => 'Product variant not found.'], 404);
        }

        // Reduce stocks (ensure not going below 0)
        $productStock->overallstock = max($productStock->overallstock - $stockQty, 0);
        $productStock->availablestock = max($productStock->availablestock - $stockQty, 0);
        $productStock->save();

        $productVariant->product_qty = max($productVariant->product_qty - $stockQty, 0);
        $productVariant->save();

        // Return updated list
        $stocks = ProductStock::select('productstocks.*', 'categories.category_name')
            ->join('categories', 'productstocks.category_id', '=', 'categories.id')
            ->get();

        return response()->json(["stocks" => $stocks]);
    }




    // public function reduceStock(Request $request)
    // {
    //     $stockqty = $request->stock_quantity;
    //     $productid = $request->productid;



    //     $getstockdetails = ProductStock::where('id',$productid)->first();
    //     $productdetails = ProductVarient::where('id',$productid)->first();

    //     $updatestock = ProductStock::
    //     where('id',$productid)
    //     ->update([
    //         "overallstock"=>$getstockdetails->overallstock - $stockqty,
    //         "availablestock"=>$getstockdetails->availablestock - $stockqty,
    //     ]);

    //     $updatestockproduct = ProductVarient::
    //     where('id',$productid)
    //     ->update([
    //         "product_qty"=>$getstockdetails->availablestock - $stockqty,
    //     ]);

    //     $stocks = ProductStock::select('productstocks.*', 'categories.category_name')
    //     ->join('categories', 'productstocks.category_id', '=', 'categories.id')
    //     ->get();
    //    return response()->json(["stocks" =>  $stocks]);



    // }

    public function lowstock()
    {
        $lowstocks = ProductStock::select('productstocks.*', 'categories.category_name', 'product_varient.varient', 'product_varient.value', 'product_varient.low_stock')
            ->join('categories', 'productstocks.category_id', '=', 'categories.id')
            ->join('product_varient', 'productstocks.pro_ver_id', '=', 'product_varient.id')
            ->where('productstocks.availablestock', '<', DB::raw('product_varient.low_stock'))
            ->get();

        // Update availablestock to be equal to low_stock
        // foreach ($lowstocks as $lowstock) {
        //     $lowstock->update(['availablestock' => $lowstock->low_stock]);
        // }





        return view("pages.lowstock", compact("lowstocks"));
    }


    // public function update1(Request $request)
    // {
    //     $stockqty = $request->stock_quantity;
    //     $productid = $request->productid;




    //     $getstockdetails = ProductStock::where('id',$productid)->first();
    //     $productdetails = ProductVarient::where('id',$productid)->first();

    //     $updatestock = ProductStock::
    //     where('id',$productid)
    //     ->update([
    //         "overallstock"=>$getstockdetails->overallstock + $stockqty,
    //         "availablestock"=>$getstockdetails->availablestock + $stockqty,
    //     ]);

    //     $updatestockproduct = ProductVarient::
    //     where('id',$productid)
    //     ->update([
    //         "product_qty"=>$getstockdetails->availablestock + $stockqty,
    //     ]);

    //     $lowstocks = ProductStock::select('productstocks.*', 'categories.category_name')
    // ->join('categories', 'productstocks.category_id', '=', 'categories.id')
    // ->where('availablestock', '<', 6)
    // ->get();

    //    return response()->json(["lowstocks" =>  $lowstocks]);



    // }

    public function update1(Request $request)
    {
        $stockQty = (int) $request->stock_quantity;
        $productStockId = $request->productid;

        $productStock = ProductStock::where('id', $productStockId)->first();

        if (!$productStock) {
            return response()->json(['error' => 'Product stock not found.'], 404);
        }

        $variantId = $productStock->pro_ver_id;

        $productVariant = ProductVarient::where('id', $variantId)->first();

        if (!$productVariant) {
            return response()->json(['error' => 'Product variant not found.'], 404);
        }

        // Update product stock values
        $productStock->overallstock += $stockQty;
        $productStock->availablestock += $stockQty;
        $productStock->save();

        // Update product variant quantity
        $productVariant->product_qty += $stockQty;
        $productVariant->save();

        // Return updated low stock list
        $lowstocks = ProductStock::select('productstocks.*', 'categories.category_name')
            ->join('categories', 'productstocks.category_id', '=', 'categories.id')
            ->where('availablestock', '<', 6)
            ->get();

        return response()->json(["lowstocks" => $lowstocks]);
    }


    public function highselling()
    {
        $highsellings = ProductStock::select('productstocks.*', 'categories.category_name', 'product_varient.varient', 'product_varient.value', "products.product_image")
            ->join('categories', 'productstocks.category_id', '=', 'categories.id')
            ->join('product_varient', 'productstocks.pro_ver_id', '=', 'product_varient.id')
            ->join('products', 'productstocks.productid', '=', 'products.id')
            ->where('salestock', '<>', '') // Assuming you want to exclude empty salestock values
            ->orderBy('salestock', 'desc') // Order by salestock in descending order
            ->get();



        return view("pages.highselling", compact("highsellings"));
    }
}
