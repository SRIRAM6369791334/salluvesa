<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatusUpdated;
use App\Models\ProductOrder;
use App\Models\ProductSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProductOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // ->with( 'product', 'orderAddress.area', 'customer' )->whereIn( 'payment_status', [ 1, 2 ] )
        $productOrders =  ProductOrder::query()->with('product', 'orderAddress.area', 'customer', 'useraddress')->where('is_cancelled', '!=', 1)->where('delivery_status', 0)->orderBy('id', 'desc')->get();

        return view('pages.product_orders', compact('productOrders'));
    }


    public function orderStat()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/auth/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"email": "blokert5320@gmail.com","password": "Gokulnath@123"}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $SR_login_Response = curl_exec($curl);
        curl_close($curl);
        $SR_login_Response_out = json_decode($SR_login_Response);
        $token = $SR_login_Response_out->{'token'};

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer' . $token,
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $altresponse = json_decode($response);
        // $channelOrderId = $altresponse[ 'data' ][ 0 ][ 'channel_order_id' ];
        // $channelOrders = $altresponse->data[ 0 ];
        if (isset($altresponse->data) && is_array($altresponse->data)) {
            foreach ($altresponse->data as $index => $channelOrder) {
                $channel_order_id = $channelOrder->channel_order_id;
                $channel_customer_name =  $channelOrder->customer_name;
                $channel_customer_email = $channelOrder->customer_email;
                $channel_customer_phone = $channelOrder->customer_phone;
                $channel_total = $channelOrder->total;
                $channel_status = $channelOrder->status;
                $channel_status_code = $channelOrder->status_code;
                $channel_delivered_date = $channelOrder->delivered_date;
                // Add 7 days to the delivered date using strtotime
                $prod = DB::table('product_slots')->where('order_id', $channel_order_id)->first();
                $prodid = DB::table('products')->where('id', $prod->product_id)->first();
                // $return_approval_timestamp = strtotime( $channel_delivered_date . + $prodid->approval_days );
                $return_approval_timestamp = strtotime($channel_delivered_date . '+' . $prodid->approval_days . ' days');
                // Convert the timestamp back to a date string
                $return_approval_date = date('Y-m-d', $return_approval_timestamp);

                DB::table('product_tracking')->where('order_id', $channel_order_id)->update(['delivery_status' => $channel_status_code, 'status' => $channel_status, 'delivered_date' => $channel_delivered_date, 'return_approval_date' => $return_approval_date]);
            }
        } else {
            echo 'No orders found.';
        }
        $finale = $altresponse->data;
        // dd( $finale );

        return view('pages.product_orders1', compact('finale'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        //
    }

    public function productOrderDeliveryAssign(Request $request)
    {
        $orderId = $request->order_id;
        $deliveryPersonId =  $request->deliver_id;
        $productOrder =   ProductOrder::query()->where('order_id', $orderId)->first();
        $productSlot =  ProductSlot::query()->where('order_id', $orderId);

        if (!$productOrder) {
            return errorResponse('Order Id Not found');
        }

        $productOrder->update([
            'delivery_person_id' => $deliveryPersonId,
            'is_delivery_assigned' => 1
        ]);

        $productSlot->update([
            'deliver_person_id' => $deliveryPersonId
        ]);

        $productOrders =  ProductOrder::query()->with('product', 'orderAddress.area', 'customer')->where('payment_status', 1)->where('delivery_status', 0)->where('is_cancelled', '!=', 1)->get();

        return response()->json([
            'message' => 'Deivery Person assigned Successfully',
            'productOrders' => $productOrders
        ]);
    }

    public function fetchTotalOrders(Request $request)
    {
        try {
            $query = ProductOrder::with('customer')->orderBy('id', 'desc');

            return datatables()->eloquent($query)
                ->addColumn('sno', function ($data) {
                    static $rowNumber = 0;
                    $rowNumber++;
                    $start = request()->input('start', 0);
                    return $start + $rowNumber;
                })
                ->addColumn('orderdate', function ($data) {
                    return $data ? $data->date_ordered_on : '-';
                })
                ->addColumn('orderid', function ($data) {
                    return $data ? $data->order_id : '-';
                })
                ->addColumn('username', function ($data) {
                    return $data->orderAddress->address_username ?? ($data->customer->name ?? '-');
                })
                ->addColumn('total', function ($data) {
                    return $data ? $data->grand_total_amount : '-';
                })

                ->toJson();
            // ->rawColumns(['clientname'])
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
