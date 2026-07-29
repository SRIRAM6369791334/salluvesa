<?php

namespace App\Http\Controllers;

use App\Models\BulkOrder;
use App\Mail\BulkOrderApproved;
use App\Mail\BulkOrderRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BulkOrderController extends Controller
{
    public function index()
    {
        $bulkOrders = BulkOrder::with('product')->orderBy('created_at', 'desc')->get()->map(function($order) {
            $order->custom_image_url = $order->custom_image ? asset('images/' . $order->custom_image) : null;
            $order->requested_on = \Carbon\Carbon::parse($order->created_at)->format('d-M-Y H:i A');
            return $order;
        });
        return view('pages.bulk_orders', compact('bulkOrders'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bulk_orders,id',
            'status' => 'required|in:1,2',
            'admin_notes' => 'required_if:status,2',
        ]);

        try {
            $bulkOrder = BulkOrder::findOrFail($request->id);
            $bulkOrder->status = $request->status;
            
            if ($request->status == 2) {
                $bulkOrder->admin_notes = $request->admin_notes;
            } else {
                $bulkOrder->admin_notes = null;
            }
            
            $bulkOrder->save();

            // Send Email
            if ($request->status == 1) {
                Mail::to($bulkOrder->email)->send(new BulkOrderApproved($bulkOrder));
            } else {
                Mail::to($bulkOrder->email)->send(new BulkOrderRejected($bulkOrder));
            }

            $bulkOrders = BulkOrder::with('product')->orderBy('created_at', 'desc')->get()->map(function($order) {
                $order->custom_image_url = $order->custom_image ? asset('images/' . $order->custom_image) : null;
                $order->requested_on = \Carbon\Carbon::parse($order->created_at)->format('d-M-Y H:i A');
                return $order;
            });

            return response()->json([
                'success' => true,
                'message' => 'Status updated and email sent successfully!',
                'bulkOrders' => $bulkOrders
            ]);
        } catch (\Exception $e) {
            Log::error('Bulk Order Status Update Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
}
