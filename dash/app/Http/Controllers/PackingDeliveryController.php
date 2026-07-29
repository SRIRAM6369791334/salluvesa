<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatusUpdated;
use App\Models\ProductOrder;
use App\Models\ProductTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

require_once __DIR__ . "/sendsms.php";

class PackingDeliveryController extends Controller
{
    public function index()
    {
        // ->whereIn("payment_status", [1, 2])
        $productDeliverys =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->where("delivery_status", 3)->get();
        // dd($productDeliverys);

        return view("pages.product_delivery", compact("productDeliverys"));
    }
    public function updatedelive(Request $request)
    {
        try {
            $order_id = $request->order_id;
            $status = $request->select_status;
            $custometid = $request->user_id;
            $numbercus = $request->phone_number;

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

            $productDeliverys = new ProductTracking();
            $productDeliverys->order_id = $order_id;
            $productDeliverys->delivery_status = $status;
            $productDeliverys->user_id = $custometid;
            $productDeliverys->save();

            $order = ProductOrder::with("customer")->where("order_id", $order_id)->first();

            if ($order && $order->customer && $order->customer->email) {
                Mail::to($order->customer->email)->send(new OrderStatusUpdated($order, $status));
            }

            $productDeliverys =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->where("payment_status", 1)->where("delivery_status", 3)->get();

            return response()->json([
                "message" => "Status update successfully",
                "productDeliverys" => $productDeliverys
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


    public function collectdelive(Request $request)
    {
        try {
            $order_id = $request->order_id;
            $status = $request->select_status;
            $custometid = $request->user_id;
            $numbercus = $request->phone_number;

            if ($status == 6) {
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

                $productTracking = new ProductTracking();
                $productTracking->order_id = $order_id;
                $productTracking->delivery_status = $status;
                $productTracking->user_id = $custometid;
                $productTracking->save();

                $productDeliverys =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->whereIn("payment_status", [1, 2])->where("delivery_status", 3)->get();

                return response()->json([
                    "message" => "Status update successfully",
                    "productDeliverys" => $productDeliverys
                ]);
            } else {
                DB::table('product_orders')
                    ->where('order_id', $order_id)
                    ->update([
                        "delivery_status" => $status,
                        "payment_status" => 3,
                    ]);

                DB::table('product_slots')
                    ->where('order_id', $order_id)
                    ->update([
                        "delivery_status" => $status
                    ]);

                $productTracking = new ProductTracking();
                $productTracking->order_id = $order_id;
                $productTracking->delivery_status = $status;
                $productTracking->user_id = $custometid;
                $productTracking->save();

                $productDeliverys =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->whereIn("payment_status", [1, 2])->where("delivery_status", 3)->get();

                return response()->json([
                    "message" => "Status update successfully",
                    "productDeliverys" => $productDeliverys
                ]);
            }
        } catch (\Throwable $e) {
            return response()->json([
                "message" => "Error: " . $e->getMessage(),
                "file" => $e->getFile(),
                "line" => $e->getLine(),
                "trace" => $e->getTraceAsString()
            ], 500);
        }
    }
}
