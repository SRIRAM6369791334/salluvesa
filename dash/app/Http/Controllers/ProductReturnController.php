<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use App\Models\ProductTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductReturnController extends Controller
{
    public function index(){
        $productReturns =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->whereIn("payment_status", [1, 2]) ->where("delivery_status", 6)->where("is_cancelled", "!=", 1)->get();

        return view("pages.return_product", compact("productReturns"));
    }
    public function update(Request $request){
        $order_id = $request->order_id;
        $status = $request->select_status;
        $custometid = $request->user_id;
        $numcusdata = $request->phone_number;

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

        $productReturns = new ProductTracking();
        $productReturns->order_id = $order_id;
        $productReturns->delivery_status = $status;
        $productReturns->user_id = $custometid;

        $productReturns->save();

        // if($status == 4){
        //     $url = 'http://sms.saitechnosolutions.net/sendsms/?token=65ab66d7e425fb1c47b11765760709ae&credit=$credit&sender=$sender&message=$message&number=' . $numcusdata ;
        //     $token = '65ab66d7e425fb1c47b11765760709ae';
        //     $credit = '2';
        //     $sender = 'HOMGRO';
        //     $message = "Your order with Order ID: $order_id from Yesbe is delivered successfully. - Team Yesbe";
        //     $number = $numcusdata ;


        //     $sendsms = new SendSms($url, $token);
        //     $messageId = $sendsms->sendmessage($credit, $sender, $message, $number);
        //     $sendsms->checkdlr($messageId);
        //     $sendsms->availablecredit($credit);
        // }

        $productReturns =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->where("payment_status", 1)->where("delivery_status", 6)->where("is_cancelled", "!=", 1)->get();

        return response()->json([
            "message" => "Status update successfully",
                "productReturns" => $productReturns
        ]);
    }


    public function updateed(Request $request){
        $order_id = $request->order_id;
        $status = $request->select_status;
        $custometid = $request->user_id;
        $numcusdata = $request->phone_number;


        if($status == 3){
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

        $productReturns = new ProductTracking();
        $productReturns->order_id = $order_id;
        $productReturns->delivery_status = $status;
        $productReturns->user_id = $custometid;

        $productReturns->save();
        $productReturns =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->whereIn("payment_status", [1, 2])->where("delivery_status", 6)->where("is_cancelled", "!=", 1)->get();

        return response()->json([
            "message" => "Status update successfully",
                "productReturns" => $productReturns
        ]);
        }else{
            DB::table('product_orders')
            ->where('order_id', $order_id)
            ->update([
                "delivery_status" => $status,
                "payment_status" => 3
            ]);

        DB::table('product_slots')
            ->where('order_id', $order_id)
            ->update([
                "delivery_status" => $status
            ]);

        $productReturns = new ProductTracking();
        $productReturns->order_id = $order_id;
        $productReturns->delivery_status = $status;
        $productReturns->user_id = $custometid;

        $productReturns->save();
        // $url = 'http://sms.saitechnosolutions.net/sendsms/?token=65ab66d7e425fb1c47b11765760709ae&credit=$credit&sender=$sender&message=$message&number=' . $numcusdata ;
        // $token = '65ab66d7e425fb1c47b11765760709ae';
        // $credit = '2';
        // $sender = 'HOMGRO';
        // $message = "Your order with Order ID: $order_id from Yesbe is delivered successfully. - Team Yesbe";
        // $number = $numcusdata ;


        // $sendsms = new SendSms($url, $token);
        // $messageId = $sendsms->sendmessage($credit, $sender, $message, $number);
        // $sendsms->checkdlr($messageId);
        // $sendsms->availablecredit($credit);

        $productReturns =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->whereIn("payment_status", [1, 2])->where("delivery_status", 6)->where("is_cancelled", "!=", 1)->get();

        return response()->json([
            "message" => "Status update successfully",
                "productReturns" => $productReturns
        ]);

        }





    }
}
