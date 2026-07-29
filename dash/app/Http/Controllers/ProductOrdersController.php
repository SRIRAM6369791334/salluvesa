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

    /**
     * Helper to resolve local file path or HTTP download into a ZipArchive instance
     */
    private function addFileOrDownloadToZip(\ZipArchive $zip, $url, $zipEntryName)
    {
        if (empty($url)) return false;

        $parsed = parse_url($url, PHP_URL_PATH) ?: $url;
        $cleanPath = ltrim($parsed, '/');
        $filename = basename($cleanPath);
        $relPath = preg_replace('#^(uploads|storage|public)/#', '', $cleanPath);

        $candidatePaths = array_unique([
            public_path($cleanPath),
            public_path($relPath),
            public_path('uploads/' . $cleanPath),
            public_path('uploads/' . $relPath),
            public_path('uploads/' . $filename),
            base_path('../web/public/' . $cleanPath),
            base_path('../web/public/' . $relPath),
            base_path('../web/public/uploads/' . $cleanPath),
            base_path('../web/public/uploads/' . $relPath),
            base_path('../web/public/uploads/' . $filename),
            storage_path('app/public/' . $cleanPath),
            storage_path('app/' . $cleanPath)
        ]);

        foreach ($candidatePaths as $path) {
            $norm = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
            if (!empty($norm) && file_exists($norm) && !is_dir($norm)) {
                $zip->addFile($norm, $zipEntryName);
                return true;
            }
        }

        // HTTP Fallback via MAIN_URL and candidate URLs
        $mainUrl = 'http://127.0.0.1:8000/';
        $httpCandidates = array_unique([
            str_starts_with($url, 'http') ? $url : null,
            $mainUrl . $cleanPath,
            $mainUrl . $relPath,
            $mainUrl . 'uploads/' . $filename,
            $mainUrl . 'uploads/' . $cleanPath,
        ]);

        foreach ($httpCandidates as $httpUrl) {
            if (empty($httpUrl)) continue;
            try {
                $context = stream_context_create([
                    'http' => ['timeout' => 5, 'ignore_errors' => true],
                    'ssl'  => ['verify_peer' => false, 'verify_peer_name' => false]
                ]);
                $contents = @file_get_contents($httpUrl, false, $context);
                if ($contents !== false && strlen($contents) > 0) {
                    $trimmed = ltrim($contents);
                    if (str_starts_with(strtolower($trimmed), '<!doctype') || str_starts_with(strtolower($trimmed), '<html') || str_contains($trimmed, '403 Forbidden') || str_contains($trimmed, '404 Not Found')) {
                        continue;
                    }

                    $zip->addFromString($zipEntryName, $contents);
                    return true;
                }
            } catch (\Exception $e) {
                // Silence exception
            }
        }

        return false;
    }

    /**
     * Download Customization Assets ZIP for an Order Item Slot
     */
    public function downloadCustomizationZip($slotId)
    {
        $slot = ProductSlot::find($slotId);

        if (!$slot) {
            abort(404, 'Order item slot not found.');
        }

        $zipName = 'Customization_Order_' . ($slot->order_id ?: $slot->id) . '_Slot_' . $slot->id . '.zip';
        $zipPath = storage_path('app/temp/' . $zipName);

        if (!file_exists(storage_path('app/temp'))) {
            @mkdir(storage_path('app/temp'), 0777, true);
        }

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Could not create ZIP archive.');
        }

        // 1. Add Original Customer Logo (if available)
        if ($slot->custom_logo_url) {
            $ext = pathinfo(parse_url($slot->custom_logo_url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'png';
            $added = $this->addFileOrDownloadToZip($zip, $slot->custom_logo_url, '1_Original_Customer_Logo.' . $ext);
            if (!$added) {
                $zip->addFromString('1_Original_Customer_Logo_MISSING.txt', "Customer uploaded logo URL: " . $slot->custom_logo_url . "\nFile was not found on local disk or via HTTP.");
            }
        }

        // 2. Add Mockup PNGs for ALL 4 Views (Front, Back, Right, Left)
        $addedAnyMockup = false;
        if (!empty($slot->design_id)) {
            $cDesign = DB::table('customproduct_designs')->where('id', $slot->design_id)->first();
            if ($cDesign) {
                $customProd = DB::table('customproducts')->where('id', $cDesign->customproduct_id)->first();
                $sidesMap = [
                    'Front' => !empty($cDesign->preview_image_front) ? $cDesign->preview_image_front : ($customProd->front_mockup ?? 'img/tshirt-front.png'),
                    'Back' => !empty($cDesign->preview_image_back) ? $cDesign->preview_image_back : ($customProd->back_mockup ?? 'img/tshirt-back.png'),
                    'Right_Shoulder' => !empty($cDesign->preview_image_right_shoulder) ? $cDesign->preview_image_right_shoulder : ($customProd->right_shoulder_mockup ?? 'img/tshirt-right-shoulder.png'),
                    'Left_Shoulder' => !empty($cDesign->preview_image_left_shoulder) ? $cDesign->preview_image_left_shoulder : ($customProd->left_shoulder_mockup ?? 'img/tshirt-left-shoulder.png'),
                ];

                foreach ($sidesMap as $sName => $imgPath) {
                    if (!empty($imgPath)) {
                        $ok = $this->addFileOrDownloadToZip($zip, $imgPath, "2_Custom_Mockup_{$sName}.png");
                        if ($ok) $addedAnyMockup = true;
                    }
                }
            }
        }

        if (!$addedAnyMockup && !empty($slot->preview_screenshot_url)) {
            $raw = $slot->preview_screenshot_url;
            $dict = json_decode($raw, true);
            if (is_array($dict)) {
                foreach ($dict as $vKey => $vPath) {
                    if (!empty($vPath)) {
                        $ok = $this->addFileOrDownloadToZip($zip, $vPath, "2_Custom_Mockup_" . ucfirst($vKey) . ".png");
                        if ($ok) $addedAnyMockup = true;
                    }
                }
            }
        }

        if (!$addedAnyMockup) {
            $singleMockup = $slot->product_image ?: $slot->preview_screenshot_url;
            if ($singleMockup) {
                $this->addFileOrDownloadToZip($zip, $singleMockup, "2_Custom_Mockup_Front.png");
            }
        }

        // 3. Add Spec Sheet PDF to ZIP
        try {
            $pdfContent = $this->getSpecSheetPdfContent($slot);
            if ($pdfContent) {
                $zip->addFromString('3_Specsheet.pdf', $pdfContent);
            }
        } catch (\Exception $e) {}

        // 4. Add Customization Specifications TXT File
        $specsText = "=========================================================\n";
        $specsText .= "SAALUVESA - CUSTOM EMBROIDERY & PRINTING SPECIFICATIONS\n";
        $specsText .= "=========================================================\n\n";
        $specsText .= "Order ID: " . ($slot->order_id ?: $slot->id) . "\n";
        $specsText .= "Item Name: " . $slot->product_name . "\n";
        $specsText .= "Size: " . ($slot->size_value ?: 'N/A') . " | Color: " . ($slot->color_value ?: 'N/A') . "\n";
        $specsText .= "Quantity: " . $slot->quantity . "\n";
        $specsText .= "---------------------------------------------------------\n";
        $specsText .= "CUSTOMIZATION DETAILS:\n";
        $specsText .= "---------------------------------------------------------\n";
        $specsText .= "Technique / Method: " . strtoupper($slot->customization_method ?: $slot->customization_type ?: 'CUSTOM PRINT') . "\n";
        $specsText .= "Placement Position: " . strtoupper($slot->customization_position ?: 'FRONT') . "\n";
        $specsText .= "Custom Text: " . ($slot->custom_text ?: 'N/A') . "\n";
        $specsText .= "Text Color: " . ($slot->custom_text_color ?: 'Standard') . "\n";
        $specsText .= "Customization Price: $" . number_format($slot->customization_price, 2) . "\n";
        $specsText .= "=========================================================\n";

        $zip->addFromString('4_Specifications.txt', $specsText);
        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    /**
     * Download All Customization Artworks ZIP for an entire Order
     */
    public function downloadOrderCustomizationZip($orderId)
    {
        $slots = ProductSlot::where('order_id', $orderId)->get();

        if ($slots->isEmpty()) {
            $order = ProductOrder::where('order_id', $orderId)->orWhere('id', $orderId)->first();
            if ($order) {
                $slots = ProductSlot::where('order_id', $order->order_id)->orWhere('order_id', $order->id)->get();
            }
        }

        if ($slots->isEmpty()) {
            abort(404, 'No customization artworks found for this order.');
        }

        $zipName = 'Order_' . $orderId . '_All_Artworks.zip';
        $zipPath = storage_path('app/temp/' . $zipName);

        if (!file_exists(storage_path('app/temp'))) {
            @mkdir(storage_path('app/temp'), 0777, true);
        }

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Could not create ZIP archive.');
        }

        foreach ($slots as $slot) {
            $cleanName = preg_replace('/[^A-Za-z0-9_]/', '_', $slot->product_name ?: 'Item');
            $subfolder = "Slot_{$slot->id}_{$cleanName}/";

            // 1. Add Original Customer Logo
            if ($slot->custom_logo_url) {
                $ext = pathinfo(parse_url($slot->custom_logo_url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'png';
                $added = $this->addFileOrDownloadToZip($zip, $slot->custom_logo_url, $subfolder . '1_Original_Customer_Logo.' . $ext);
                if (!$added) {
                    $zip->addFromString($subfolder . '1_Original_Customer_Logo_MISSING.txt', "Customer uploaded logo URL: " . $slot->custom_logo_url . "\nFile was not found on local disk or via HTTP.");
                }
            }

            // 2. Mockup PNGs for ALL 4 Views
            $addedAnyMockup = false;
            if (!empty($slot->design_id)) {
                $cDesign = DB::table('customproduct_designs')->where('id', $slot->design_id)->first();
                if ($cDesign) {
                    $customProd = DB::table('customproducts')->where('id', $cDesign->customproduct_id)->first();
                    $sidesMap = [
                        'Front' => !empty($cDesign->preview_image_front) ? $cDesign->preview_image_front : ($customProd->front_mockup ?? 'img/tshirt-front.png'),
                        'Back' => !empty($cDesign->preview_image_back) ? $cDesign->preview_image_back : ($customProd->back_mockup ?? 'img/tshirt-back.png'),
                        'Right_Shoulder' => !empty($cDesign->preview_image_right_shoulder) ? $cDesign->preview_image_right_shoulder : ($customProd->right_shoulder_mockup ?? 'img/tshirt-right-shoulder.png'),
                        'Left_Shoulder' => !empty($cDesign->preview_image_left_shoulder) ? $cDesign->preview_image_left_shoulder : ($customProd->left_shoulder_mockup ?? 'img/tshirt-left-shoulder.png'),
                    ];

                    foreach ($sidesMap as $sName => $imgPath) {
                        if (!empty($imgPath)) {
                            $ok = $this->addFileOrDownloadToZip($zip, $imgPath, "{$subfolder}2_Custom_Mockup_{$sName}.png");
                            if ($ok) $addedAnyMockup = true;
                        }
                    }
                }
            }

            if (!$addedAnyMockup && !empty($slot->preview_screenshot_url)) {
                $raw = $slot->preview_screenshot_url;
                $dict = json_decode($raw, true);
                if (is_array($dict)) {
                    foreach ($dict as $vKey => $vPath) {
                        if (!empty($vPath)) {
                            $ok = $this->addFileOrDownloadToZip($zip, $vPath, "{$subfolder}2_Custom_Mockup_" . ucfirst($vKey) . ".png");
                            if ($ok) $addedAnyMockup = true;
                        }
                    }
                }
            }

            if (!$addedAnyMockup) {
                $singleMockup = $slot->product_image ?: $slot->preview_screenshot_url;
                if ($singleMockup) {
                    $this->addFileOrDownloadToZip($zip, $singleMockup, "{$subfolder}2_Custom_Mockup_Front.png");
                }
            }

            // 3. Add Spec Sheet PDF to ZIP
            try {
                $pdfContent = $this->getSpecSheetPdfContent($slot);
                if ($pdfContent) {
                    $zip->addFromString("{$subfolder}3_Specsheet.pdf", $pdfContent);
                }
            } catch (\Exception $e) {}

            // 4. Customization Specs TXT
            $specsText = "=========================================================\n";
            $specsText .= "SAALUVESA - CUSTOM EMBROIDERY & PRINTING SPECIFICATIONS\n";
            $specsText .= "=========================================================\n\n";
            $specsText .= "Order ID: " . ($slot->order_id ?: $slot->id) . "\n";
            $specsText .= "Item Name: " . $slot->product_name . "\n";
            $specsText .= "Size: " . ($slot->size_value ?: 'N/A') . " | Color: " . ($slot->color_value ?: 'N/A') . "\n";
            $specsText .= "Quantity: " . $slot->quantity . "\n";
            $specsText .= "---------------------------------------------------------\n";
            $specsText .= "CUSTOMIZATION DETAILS:\n";
            $specsText .= "---------------------------------------------------------\n";
            $specsText .= "Technique / Method: " . strtoupper($slot->customization_method ?: $slot->customization_type ?: 'CUSTOM PRINT') . "\n";
            $specsText .= "Placement Position: " . strtoupper($slot->customization_position ?: 'FRONT') . "\n";
            $specsText .= "Custom Text: " . ($slot->custom_text ?: 'N/A') . "\n";
            $specsText .= "Text Color: " . ($slot->custom_text_color ?: 'Standard') . "\n";
            $specsText .= "Customization Price: $" . number_format($slot->customization_price, 2) . "\n";
            $specsText .= "=========================================================\n";

            $zip->addFromString("{$subfolder}4_Specifications.txt", $specsText);
        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    /**
     * Download or view Spec Sheet PDF for an Order Item Slot
     */
    public function downloadSpecSheetPdf($slotId)
    {
        $slot = ProductSlot::find($slotId);
        if (!$slot) {
            abort(404, 'Order item slot not found.');
        }

        $pdfContent = $this->getSpecSheetPdfContent($slot);

        if ($pdfContent) {
            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="SpecSheet_Slot_' . $slot->id . '.pdf"'
            ]);
        }

        abort(500, 'Could not generate SpecSheet PDF.');
    }

    /**
     * Generate raw binary PDF content for a SpecSheet
     */
    private function getSpecSheetPdfContent($slot)
    {
        $getImageBase64 = function($url) {
            if (empty($url)) return null;
            if (\Illuminate\Support\Str::startsWith($url, 'data:image/')) return $url;

            $parsed = parse_url($url, PHP_URL_PATH) ?: $url;
            $trimmed = ltrim($parsed, '/');
            $clean = preg_replace('#^(uploads|storage|public)/#', '', $trimmed);
            $filename = basename($trimmed);

            $localPaths = [
                public_path($trimmed),
                public_path($clean),
                public_path('uploads/' . $clean),
                public_path('uploads/' . $filename),
                base_path('../web/public/' . $trimmed),
                base_path('../web/public/' . $clean),
                base_path('../web/public/uploads/' . $clean),
                base_path('../web/public/uploads/' . $filename),
                storage_path('app/public/' . $clean),
            ];

            foreach ($localPaths as $lp) {
                if (!empty($lp) && file_exists($lp) && !is_dir($lp)) {
                    $ext = pathinfo($lp, PATHINFO_EXTENSION) ?: 'png';
                    return 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($lp));
                }
            }

            $mainUrl = \Illuminate\Support\Str::startsWith($url, 'http') ? $url : 'http://127.0.0.1:8000/uploads/' . $clean;
            try {
                $ctx = stream_context_create(['http' => ['timeout' => 5, 'ignore_errors' => true], 'ssl' => ['verify_peer' => false]]);
                $content = @file_get_contents($mainUrl, false, $ctx);
                if ($content && !str_starts_with(ltrim($content), '<!doctype') && !str_starts_with(ltrim($content), '<html')) {
                    $ext = pathinfo($mainUrl, PATHINFO_EXTENSION) ?: 'png';
                    return 'data:image/' . $ext . ';base64,' . base64_encode($content);
                }
            } catch (\Exception $e) {}

            return null;
        };

        $mockupBase64 = '';
        $mockupViews = [];

        if (!empty($slot->design_id)) {
            $cDesign = DB::table('customproduct_designs')->where('id', $slot->design_id)->first();
            if ($cDesign) {
                $customProd = DB::table('customproducts')->where('id', $cDesign->customproduct_id)->first();
                $sidesMap = [
                    'front' => ['preview' => $cDesign->preview_image_front, 'base' => $customProd->front_mockup ?? 'img/tshirt-front.png'],
                    'back' => ['preview' => $cDesign->preview_image_back, 'base' => $customProd->back_mockup ?? 'img/tshirt-back.png'],
                    'right_shoulder' => ['preview' => $cDesign->preview_image_right_shoulder, 'base' => $customProd->right_shoulder_mockup ?? 'img/tshirt-right-shoulder.png'],
                    'left_shoulder' => ['preview' => $cDesign->preview_image_left_shoulder, 'base' => $customProd->left_shoulder_mockup ?? 'img/tshirt-left-shoulder.png'],
                ];

                foreach ($sidesMap as $side => $paths) {
                    $imgUrl = !empty($paths['preview']) ? $paths['preview'] : $paths['base'];
                    if (!empty($imgUrl)) {
                        $b64 = $getImageBase64($imgUrl);
                        if ($b64) $mockupViews[$side] = $b64;
                    }
                }
            }
        }

        if (empty($mockupViews) && !empty($slot->preview_screenshot_url)) {
            $raw = $slot->preview_screenshot_url;
            $dict = json_decode($raw, true);
            if (is_array($dict)) {
                foreach ($dict as $vKey => $vUrl) {
                    $b64 = $getImageBase64($vUrl);
                    if ($b64) $mockupViews[$vKey] = $b64;
                }
            } else {
                $b64 = $getImageBase64($raw);
                if ($b64) $mockupViews['front'] = $b64;
            }
        }

        $html = view('artworks.specsheet', compact('slot', 'mockupBase64', 'mockupViews'))->render();

        if (class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->setPaper('a4', 'portrait');
            return $pdf->output();
        }

        return null;
    }
}
