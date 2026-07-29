<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use Illuminate\Http\Request;

class packingCompleteController extends Controller
{
    public function index()
    {

        $productcompletes =  ProductOrder::query()->with("product", "orderAddress.area", "customer")->whereIn("payment_status", [1,3]) ->where("delivery_status", 4)->get();



        return view("pages.product_delivered", compact("productcompletes"));
    }
}
