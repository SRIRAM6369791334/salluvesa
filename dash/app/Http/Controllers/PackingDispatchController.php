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

class PackingDispatchController extends Controller
{
    public function index()
    {
        // ->whereIn("payment_status", [1, 2])
        $productDispaths =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->where("delivery_status", 2)->where("is_cancelled", "!=", 1)->get();

        return view("pages.product_dispatch", compact("productDispaths"));
    }
    // update status
    public function updatedispach(Request $request)
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
                    "delivery_status" => $status
                ]);

            DB::table('product_slots')
                ->where('order_id', $order_id)
                ->update([
                    "delivery_status" => $status
                ]);

            $productDispaths = new ProductTracking();
            $productDispaths->order_id = $order_id;
            $productDispaths->delivery_status = $status;
            $productDispaths->user_id = $custometid;
            $productDispaths->save();

            $order = ProductOrder::with("customer")->where("order_id", $order_id)->first();

            if ($order && $order->customer && $order->customer->email) {
                Mail::to($order->customer->email)->send(new OrderStatusUpdated($order, $status));
            }

            $productDispaths =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->where("payment_status", 1)->where("delivery_status", 2)->where("is_cancelled", "!=", 1)->get();

            return response()->json([
                "message" => "Status update successfully",
                "productDispaths" => $productDispaths
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

    public function updaterefund2(Request $request)
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


        $productDispaths =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->where("payment_status", 1)->where("delivery_status", 2)->get();

        return response()->json([
            "message" => "Status update successfully",
            "productDispaths" => $productDispaths
        ]);
    }
}
