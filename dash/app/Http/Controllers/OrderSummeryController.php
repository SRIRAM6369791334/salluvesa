<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderSummeryController extends Controller
{
    public function index()
    {

        $ordersummerys =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->whereIn("payment_status", [1, 2, 3])->get();

        return view("pages.order_summery", compact("ordersummerys"));
    }



    public function getoversummery(Request $request)
    {

        $selectvalue = $request->delivery_status;
        $fromDate = Carbon::parse($request->input('frdate'))->subDay()->format('Y-m-d');
        $toDate = Carbon::parse($request->input('todate'))->addDay()->format('Y-m-d');


        $ordersummerys = ProductOrder::query()->with("product", "orderAddress.area", "customer")->whereIn("payment_status", [1, 2, 3])->where('delivery_status', $selectvalue)->whereBetween('date_ordered_on', [$fromDate, $toDate])
            ->get();



        $data = [
            'ordersummerys' => $ordersummerys,
            'i' => 1,
        ];


        return $data;
    }
}
