<?php

namespace App\Http\Controllers;

use App\Models\MilkOrder;
use App\Models\ProductOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function  incomeReports()
    {

        $milkOrders = MilkOrder::where("payment_status", 1)
            ->with("product", "customer.area", "transactionLog")
            ->get()->map(function ($item) {
                $item->date_ordered_on = Carbon::parse($item->date_ordered_on)->format('d-M-Y');
                return $item;
            });

        return view("pages.income_reports", compact("milkOrders"));
    }


    public function getIncomeReports(Request $request)
    {
        $fromDate =  $request->from_date;
        $toDate =   $request->to_date;

        $productOrders = [];
        $productOrders = ProductOrder::whereIn("payment_status", [1, 2, 3])
                ->whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
                ->with("product", "customer.area", "transactionLog")->get()->map(function ($item) {
                    $item->date_ordered_on = Carbon::parse($item->date_ordered_on)->format('d-M-Y');
                    return $item;
                });

        // if ($productType == "all") {
        //     $milkOrders = MilkOrder::where("payment_status", 1)
        //         ->whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
        //         ->with("product", "customer.area", "transactionLog")
        //         ->get()->map(function ($item) {
        //             $item->date_ordered_on = Carbon::parse($item->date_ordered_on)->format('d-M-Y');
        //             return $item;
        //         });

        //     $productOrders = ProductOrder::where("payment_status", 1)
        //         ->whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
        //         ->with("product", "customer.area", "transactionLog")->get()->map(function ($item) {
        //             $item->date_ordered_on = Carbon::parse($item->date_ordered_on)->format('d-M-Y');
        //             return $item;
        //         });
        // } else if ($productType == env("MILK_PRODUCT")) {
        //     $milkOrders = MilkOrder::where("payment_status", 1)
        //         ->whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
        //         ->with("product", "customer.area", "transactionLog")
        //         ->get()->map(function ($item) {
        //             $item->date_ordered_on = Carbon::parse($item->date_ordered_on)->format('d-M-Y');
        //             return $item;
        //         });

        //     $productOrders = [];
        // } else {
        //     $milkOrders = [];

        //     $productOrders = ProductOrder::where("payment_status", 1)
        //         ->whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
        //         ->with("product", "customer.area", "transactionLog")->get()->map(function ($item) {
        //             $item->date_ordered_on = Carbon::parse($item->date_ordered_on)->format('d-M-Y');
        //             return $item;
        //         });
        // }


        return response()->json([
            "view" => view("ajaxPages.render_income_report", compact("productOrders"))->render()
        ]);
    }
}
