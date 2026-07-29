<?php

namespace App\Providers;

use App\Models\MilkOrder;
use App\Models\MilkRefund;
use App\Models\ProductOrder;
use App\Models\ProductRefund;
use App\Models\ProductSlot;
use App\Models\ProductStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer("layouts.sidebar", function ($view) {
            $milkOrderPendingCount  = MilkOrder::query()->where("is_delivery_assigned", "0")->count();
            $productOrderPendingCount  = ProductOrder::query()->whereIn("payment_status", [1, 2, 3])->where("delivery_status", 1)->where('is_cancelled','!=', 1)->count();
            $milkRefundPendingCount  = MilkRefund::query()->where("refund_status", 0)->count();
            $productRefundPendingCount  = ProductRefund::query()->where("refund_status", 0)->count();
            $productOrderDispatchCount  = ProductOrder::query()->whereIn("payment_status", [1, 2, 3])->where("delivery_status", 2)->where('is_cancelled','!=', 1)->count();
            $productOrderDeliveryCount  = ProductOrder::query()->whereIn("payment_status", [1, 2, 3])->where("delivery_status", 3)->where('is_cancelled','!=', 1)->count();
            $productOrdercompleteCount  = ProductOrder::query()->whereIn("payment_status", [1, 2, 3])->where("delivery_status", 4)->where('is_cancelled','!=', 1)->count();
            $productOrderBIllingCount  = ProductOrder::query()->whereIn("payment_status", [1, 2, 3])->where("delivery_status", 0)->where('is_cancelled','!=', 1)->count();
            $cancelreq = ProductOrder::query()->where('is_cancelled', 2)->count();
            $returnreqcount = DB::table('product_tracking')->where('return_requested',1)->count();
            $productreturn = ProductOrder::query()->where("payment_status", 1)->where("delivery_status", 6)->count();




            $view->with("milkOrderPendingCount", $milkOrderPendingCount);
            $view->with("productOrderPendingCount", $productOrderPendingCount);
            $view->with("productOrderBIllingCount", $productOrderBIllingCount);
            $view->with("milkRefundPendingCount", $milkRefundPendingCount);
            $view->with("productRefundPendingCount", $productRefundPendingCount);
            $view->with("productOrderDispatchCount", $productOrderDispatchCount);
            $view->with("productOrderDeliveryCount", $productOrderDeliveryCount);
            $view->with("productOrdercompleteCount",$productOrdercompleteCount);
            $view->with("cancelreq",$cancelreq);
            $view->with("returnreqcount",$returnreqcount);
            $view->with("productreturn",$productreturn);

        });

        View::composer("layouts.topbar", function ($view) {
            // $stockscount = ProductStock::select('productstocks.*', 'categories.category_name')
            // ->join('categories', 'productstocks.category_id', '=', 'categories.id')
            // ->where('availablestock', '<', 6)
            // ->count();

            $stockscount  = ProductStock::select('productstocks.*', 'categories.category_name', 'product_varient.varient', 'product_varient.value', 'product_varient.low_stock')
            ->join('categories', 'productstocks.category_id', '=', 'categories.id')
            ->join('product_varient', 'productstocks.pro_ver_id', '=', 'product_varient.id')
            ->where('productstocks.availablestock', '<', DB::raw('product_varient.low_stock'))
            ->count();

        // Update availablestock to be equal to low_stock


            $view->with("stockscount", $stockscount);
        });
    }
}