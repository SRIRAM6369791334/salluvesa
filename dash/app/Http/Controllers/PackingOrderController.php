<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatusUpdated;
use App\Models\ProductOrder;
use App\Models\ProductRefund;
use App\Models\ProductTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

require_once __DIR__ . "/sendsms.php";

class PackingOrderController extends Controller
{
    public function index()
    {
        // ->whereIn("payment_status", [1, 2])
        $productPackings =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->where("delivery_status", 1)->where("is_cancelled", "!=", 1)->get();

        return view("pages.product_packing", compact("productPackings"));
    }

    // update status
    public function updatepacking(Request $request)
    {
        try {
            $order_id = $request->order_id;
            $status = $request->select_status;
            $custometid = $request->user_id;
            $numbercus = $request->phone_number;
            $tracking_id = $request->tracking_id;

            DB::table('product_orders')
                ->where('order_id', $order_id)
                ->update([
                    "delivery_status" => $status,
                    'tracking_id' => $tracking_id
                ]);

            DB::table('product_slots')
                ->where('order_id', $order_id)
                ->update([
                    "delivery_status" => $status
                ]);

            $productPackings = new ProductTracking();
            $productPackings->order_id = $order_id;
            $productPackings->delivery_status = $status;
            $productPackings->user_id = $custometid;
            $productPackings->save();

            $productPackings =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->where("payment_status", 1)->where("delivery_status", 1)->get();

            $order = ProductOrder::with("customer")->where("order_id", $order_id)->first();

            if ($order && $order->customer && $order->customer->email) {
                Mail::to($order->customer->email)->send(new OrderStatusUpdated($order, $status));
            }

            return response()->json([
                "message" => "Status update successfully",
                "productPackings" => $productPackings
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

    public function updaterefund1(Request $request)
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


        $productPackings =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->where("payment_status", 1)->where("delivery_status", 1)->where("is_cancelled", "!=", 1)->get();

        return response()->json([
            "message" => "Status update successfully",
            "productPackings" => $productPackings
        ]);
    }
}
