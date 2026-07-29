<?php

namespace App\Http\Controllers;

// OrderwiseController.php

use App\Models\ProductSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\OrderReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function orderwisereport()
    {
        $filter = 'this_month';
        $initialResults = $this->getFilteredOrderDataFromDates($filter);
        return view('pages.orderwisereport', compact('filter', 'initialResults'));
    }

    public function filterorderWiseReport(Request $request)
    {
        $results = $this->getFilteredOrderData($request);
        return response()->json($results);
    }

    public function exportExcel(Request $request)
    {
        $results = $this->getFilteredOrderData($request);
        return Excel::download(new OrderReportExport($results['orders']), 'OrderWiseReport.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $results = $this->getFilteredOrderData($request);
        $pdf = Pdf::loadView('exports.orderwise', ['results' => $results['orders']]);
        return $pdf->download('OrderWiseReport.pdf');
    }

    private function getFilteredOrderData(Request $request)
    {
        $filter = $request->input('filter', 'this_month');
        $from = $request->input('from');
        $to = $request->input('to');

        return $this->getFilteredOrderDataFromDates($filter, $from, $to);
    }

    private function getFilteredOrderDataFromDates($filter, $from = null, $to = null)
    {
        $now = Carbon::now();
        $query = DB::table('product_orders')
            ->leftJoin('users', 'users.id', '=', 'product_orders.user_id')
            ->leftJoin('product_order_user_addresses', 'product_order_user_addresses.order_id', '=', 'product_orders.order_id')
            ->select(
                'product_orders.id',
                'product_orders.order_id',
                'product_orders.date_ordered_on',
                'product_orders.grand_total_amount',
                'product_orders.payment_status',
                'product_orders.payment_method',
                'product_orders.order_type',
                'users.name as user_name',
                'product_order_user_addresses.address_username',
                'product_order_user_addresses.country',
                'users.phone_number',
                DB::raw('(SELECT COUNT(*) FROM product_slots WHERE product_slots.order_id = product_orders.order_id OR product_slots.order_id = CAST(product_orders.id AS CHAR)) as total_items'),
                DB::raw('(SELECT SUM(quantity) FROM product_slots WHERE product_slots.order_id = product_orders.order_id OR product_slots.order_id = CAST(product_orders.id AS CHAR)) as total_quantity')
            );
        
        // Map customer_name dynamically in next step or use COALESCE
        $query->addSelect(DB::raw('COALESCE(product_order_user_addresses.address_username, users.name, "N/A") as customer_name'));

        // Apply date filters
        if ($filter === 'this_month') {
            $query->whereBetween('date_ordered_on', [
                $now->copy()->startOfMonth()->toDateString(),
                $now->copy()->endOfMonth()->toDateString()
            ]);
        } elseif ($filter === 'last_month') {
            $query->whereBetween('date_ordered_on', [
                $now->copy()->subMonth()->startOfMonth()->toDateString(),
                $now->copy()->subMonth()->endOfMonth()->toDateString()
            ]);
        } elseif ($filter === 'this_week') {
            $query->whereBetween('date_ordered_on', [
                $now->copy()->startOfWeek()->toDateString(),
                $now->copy()->endOfWeek()->toDateString()
            ]);
        } elseif ($filter === 'custom' && $from && $to) {
            $query->whereBetween('date_ordered_on', [
                Carbon::parse($from)->startOfDay()->toDateTimeString(),
                Carbon::parse($to)->endOfDay()->toDateTimeString()
            ]);
        }

        $orders = $query->orderByDesc('date_ordered_on')->get();

        foreach ($orders as $order) {
            $hasCustom = \Illuminate\Support\Facades\DB::table('product_slots')
                ->where(function($q) use ($order) {
                    $q->where('order_id', $order->order_id)
                      ->orWhere('order_id', (string)$order->id);
                })
                ->whereNotNull('design_id')
                ->exists();
            $order->has_custom_design = $hasCustom;
        }

        $summary = [
            'total_orders' => $orders->count(),
            'total_value' => $orders->sum('grand_total_amount')
        ];

        return [
            'orders' => $orders,
            'summary' => $summary
        ];
    }
    public function showInvoice($orderId)
    {
        try {
            $order = ProductOrder::with(['customer', 'orderAddress.state'])
                ->where('order_id', $orderId)
                ->orWhere('id', $orderId)
                ->first();
            if (!$order) {
                return back()->with('error', 'Order not found.');
            }

            // Fetch all product slots for the given order with relationships
            $products = ProductSlot::with([
                'product',
                'productVarient',
                'productOrder.customer.user_addresses',
                'productOrder.orderAddress',
                'productOrder.orderAddress.state'
            ])->whereIn('order_id', [$order->id, (string)$order->order_id])
              ->where(function($q) { $q->where('is_cancelled', '!=', 1)->orWhereNull('is_cancelled'); })
              ->get();

            return view('invoicePages.product_orders_invoice', compact('products'));
        } catch (\Throwable $th) {
            // Optional: Log or handle error
            return back()->with('error', 'Something went wrong while generating the invoice.');
        }
    }
}
