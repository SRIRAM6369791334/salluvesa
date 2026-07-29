@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Laralink">
    <title>Product Order Invoice</title>
    <link rel="stylesheet" href="{{ asset('assets/css/invoice_style.css') }}">
</head>
<style>
    .tm_invoice_footer .tm_right_footer {
        width: 100% !important;
    }

    th,
    td {
        padding: 10px 15px;
        line-height: 1.55em;
        border: 1px solid;
        color: black;
    }
    
    .design-asset-link {
        display: inline-block;
        padding: 2px 7px;
        color: #fff;
        border-radius: 3px;
        text-decoration: none;
        font-size: 11px;
        margin-bottom: 5px;
    }
    
    .btn-front { background: #007bff; }
    .btn-back { background: #17a2b8; }
    .btn-zip { background: #28a745; margin-top: 10px; font-weight: bold; padding: 4px 10px; }
    
    .original-asset-item {
        font-size: 10px;
        padding: 1px 4px;
        border: 1px solid #ddd;
        border-radius: 2px;
        text-decoration: none;
        color: #333;
        background: #f9f9f9;
        margin: 2px;
    }
</style>

<body>
    <div class="tm_container">
        <div class="tm_invoice_wrap">
            <div class="tm_invoice tm_style1 tm_type1" id="tm_download_section">
                <div class="tm_invoice_in">
                    <div class="tm_invoice_head tm_top_head tm_mb15 tm_align_center">
                        <div class="tm_invoice_left">
                            <div class="tm_logo">
                                <img src="{{ asset('assets/images/Saaluvesa_log_trans.png') }}" alt="Logo">
                            </div>
                        </div>
                        <div class="tm_invoice_right tm_text_right tm_mobile_hide">
                            <div class="tm_f45 tm_text_uppercase " style="font-size: 40px">Order Details</div>
                        </div>
                        <div class="tm_shape_bg tm_accent_bg tm_mobile_hide"></div>
                    </div>

                    @if(count($products) > 0)
                        @php
                            $order = $products[0]->productOrder ?? null;
                            $customer = $order->customer ?? null;
                            $shippingAddress = $order->orderAddress ?? null;
                            $addressState = $shippingAddress->state->state_name ?? null;
                            $billingAddress = $customer?->user_addresses?->firstWhere('address_type_id', 1); // 1 = home/billing
                        @endphp

                        <div class="tm_invoice_info tm_mb25">
                            <div class="tm_card_note tm_mobile_hide"></div>
                            <div class="tm_invoice_info_list tm_white_color">
                                <p class="tm_invoice_number tm_m0">Order No: <b>{{ $products[0]->order_id }}</b></p>
                                <p class="tm_invoice_date tm_m0">Date:
                                    <b>{{ Carbon::parse($products[0]->delivery_date)->format('d-M-Y') }}</b>
                                </p>
                                @if($order && $order->printing_method)
                                    <p class="tm_invoice_date tm_m0">Printing: <b>{{ $order->printing_method }}</b></p>
                                @endif
                                @if($order && $order->bank_country)
                                    <p class="tm_invoice_date tm_m0">Bank Country: <b>{{ $order->bank_country }}</b></p>
                                @endif
                            </div>
                            <div class="tm_invoice_seperator tm_accent_bg"></div>
                        </div>


                        <div class="tm_invoice_head tm_mb10">
                            <div class="tm_invoice_left">
                                <p class="tm_mb2"><b class="tm_primary_color">Customer Address:</b></p>
                                <p>
                                    {{ $shippingAddress->address_username ?? ($order->order_name ?? ($customer->name ?? 'N/A')) }}<br>
                                    {{ $shippingAddress->address_line_one ?? $billingAddress->address_line_one ?? 'Address line 1 not available' }}<br>

                                    @if(!empty($shippingAddress?->address_line_two ?? $billingAddress?->address_line_two))
                                        {{ $shippingAddress->address_line_two ?? $billingAddress->address_line_two }}<br>
                                    @endif

                                    {{ $shippingAddress->city ?? $billingAddress->city ?? 'City' }}
                                    - {{ $addressState
            ?? $billingAddress?->state?->name
            ?? 'State' }}-
                                    {{ $shippingAddress->pincode ?? $billingAddress->pincode ?? 'Pincode' }}<br>

                                    <b>{{ $shippingAddress->address_phone_number ?? $billingAddress->address_phone_number ?? 'Phone not available'  }}</b>
                                </p>
                            </div>

                            <div class="tm_invoice_right tm_text_right">
                                <p class="tm_mb2"><b class="tm_primary_color">Office Address:</b></p>
                                <p>
                                    Saaluvesa Pvt Ltd,<br>
                                    116, Goodwill Promoters,<br>
                                    Roja Street, Porur,<br>
                                    Chennai - 600125
                                </p>
                            </div>
                        </div>

                        <div class="tm_table tm_style1" style="margin-top: 50px">
                            <div class="tm_table_responsive">
                                <table>
                                    <thead>
                                        <tr class="tm_accent_bg">
                                            <th>S.No</th>
                                            <th>Image</th>
                                            <th>Order ID</th>
                                            <th>Product Name</th>
                                            <th>Size</th>
                                            <th>Color</th>
                                            <th>Payment Status</th>
                                            <th>Payment Method</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Printing</th>
                                            <th>Custom Design</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $variantDescriptions = [1 => 'l', 2 => 'ml', 3 => 'g', 4 => 'kg', 5 => 'Nos'];
                                            $grandTotal = 0;
                                            $discount = 0;
                                            $discounttyp = '';
                                            $shipping = 0;
                                            $tax = 0;
                                            $total = 0;
                                        @endphp

                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                 <td>
                                                     @php
                                                         $previewList = [];

                                                         // Helper function for full asset URL
                                                         $formatUrl = function($path) {
                                                             if (empty($path)) return 'http://127.0.0.1:8000/img/tshirt-front.png';
                                                             if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) return $path;
                                                             $trimmed = ltrim($path, '/');
                                                             
                                                             if (\Illuminate\Support\Str::startsWith($trimmed, 'img/')) {
                                                                 return 'http://127.0.0.1:8000/' . $trimmed;
                                                             }
                                                             
                                                             // Check local Dash public directory
                                                             if (file_exists(public_path($trimmed))) {
                                                                 return asset($trimmed);
                                                             }
                                                             if (file_exists(public_path('uploads/' . $trimmed))) {
                                                                 return asset('uploads/' . $trimmed);
                                                             }
                                                             
                                                             // Check Web public directory fallback
                                                             if (\Illuminate\Support\Str::startsWith($trimmed, 'uploads/')) {
                                                                 return 'http://127.0.0.1:8000/' . $trimmed;
                                                             }
                                                             return 'http://127.0.0.1:8000/uploads/' . $trimmed;
                                                         };

                                                         // 1. Check preview_screenshot_url (Quick Custom)
                                                         if (!empty($product->preview_screenshot_url)) {
                                                             $decoded = json_decode($product->preview_screenshot_url, true);
                                                             if (is_array($decoded)) {
                                                                 $previewList = $decoded;
                                                             } else {
                                                                 $previewList = ['front' => $product->preview_screenshot_url];
                                                             }
                                                         }

                                                         // 2. Check design_id (Design Studio)
                                                         if (empty($previewList) && !empty($product->design_id)) {
                                                             $cDesign = \Illuminate\Support\Facades\DB::table('customproduct_designs')->where('id', $product->design_id)->first();
                                                             if ($cDesign) {
                                                                 if (!empty($cDesign->preview_image_front)) $previewList['front'] = $cDesign->preview_image_front;
                                                                 if (!empty($cDesign->preview_image_back)) $previewList['back'] = $cDesign->preview_image_back;
                                                                 if (!empty($cDesign->preview_image_right_shoulder)) $previewList['right'] = $cDesign->preview_image_right_shoulder;
                                                                 if (!empty($cDesign->preview_image_left_shoulder)) $previewList['left'] = $cDesign->preview_image_left_shoulder;
                                                             }
                                                         }

                                                         // 3. Fallback to product_image or product mockup images
                                                         if (empty($previewList)) {
                                                             if (!empty($product->product_image)) {
                                                                 $previewList['product'] = $product->product_image;
                                                             } elseif ($product->product) {
                                                                 if (!empty($product->product->front_mockup)) $previewList['front'] = $product->product->front_mockup;
                                                                 if (!empty($product->product->back_mockup)) $previewList['back'] = $product->product->back_mockup;
                                                             }
                                                         }
                                                     @endphp

                                                     @if(count($previewList) > 0)
                                                         <div style="display:flex; flex-wrap:wrap; gap:4px; max-width:160px;">
                                                             @foreach($previewList as $vKey => $vUrl)
                                                                 @php
                                                                     $fullVUrl = $formatUrl($vUrl);
                                                                 @endphp
                                                                 <div style="text-align:center;">
                                                                     <a href="{{ $fullVUrl }}" target="_blank" title="{{ strtoupper($vKey) }}">
                                                                         <img src="{{ $fullVUrl }}" alt="{{ $vKey }}" style="width: 55px; height: 55px; object-fit: contain; border-radius: 4px; border: 1px solid #cbd5e1; background: #ffffff; padding: 2px;" onerror="this.onerror=null; this.src='http://127.0.0.1:8000/img/logo.png';">
                                                                     </a>
                                                                     <div style="font-size:9px; font-weight:bold; color:#64748b; text-transform:uppercase;">{{ $vKey }}</div>
                                                                 </div>
                                                             @endforeach
                                                         </div>
                                                     @elseif(!empty($product->custom_logo_url))
                                                         @php $logoUrl = $formatUrl($product->custom_logo_url); @endphp
                                                         <a href="{{ $logoUrl }}" target="_blank">
                                                             <img src="{{ $logoUrl }}" alt="Logo" style="width: 60px; height: 60px; object-fit: contain; border-radius: 6px; border: 1px solid #ddd; background: #ffffff; padding: 2px;">
                                                         </a>
                                                     @else
                                                         <span class="text-muted" style="font-size: 11px;">No Image</span>
                                                     @endif
                                                 </td>
                                                 <td>{{$product->order_id ?? ''}}</td>
                                                 <td>{{ $product->product_name ?? 'N/A' }}</td>
                                                 <td>{{ $product->size_value ?? '' }}
                                                     {{ $product->productVarient ? ($variantDescriptions[$product->productVarient->varient] ?? '') : '' }}
                                                 </td>
                                                 <td>
                                                     @if(!empty($product->color_value))
                                                         @if(str_starts_with(trim($product->color_value), '#'))
                                                             @foreach(explode(',', $product->color_value) as $color)
                                                                 @php $colorName = \App\Models\ProductColor::getColorName($color); @endphp
                                                                 <span style="display:inline-block; width:16px; height:16px; background-color:{{ trim($color) }}; border:1px solid #ccc; vertical-align:middle; margin-right:5px;" title="{{ $colorName }}"></span>
                                                                 {{ $colorName }}
                                                             @endforeach
                                                         @else
                                                             <span style="font-weight: 600; color: #334155;">{{ $product->color_value }}</span>
                                                         @endif
                                                     @else
                                                         Standard
                                                     @endif
                                                 </td>

                                                 <td>
                                                     @php
                                                         $status = $product->productOrder->payment_status ?? null;
                                                     @endphp

                                                     @if($status === 1)
                                                         Paid
                                                     @elseif($status === 0)
                                                         Pending
                                                     @elseif($status === 3)
                                                         Bank Transfer
                                                     @else
                                                         N/A
                                                     @endif
                                                 </td>
                                                 <td>
                                                     @if(($product->productOrder->payment_method ?? '') == 'cod') Cash on Delivery
                                                     @elseif(($product->productOrder->payment_method ?? '') == 'paypal') PayPal
                                                     @elseif(($product->productOrder->payment_method ?? '') == 'mp') Bank Transfer
                                                     @else {{ $product->productOrder->payment_method ?? '' }} @endif
                                                 </td>
                                                 <td>${{ $product->product_rate ?? 0 }}</td>
                                                 <td>{{ $product->quantity }}</td>
                                                 <td>{{ $order->printing_method ?? 'N/A' }}</td>
                                                 <td>
                                                     @if(!empty($product->preview_screenshot_url) || !empty($product->custom_logo_url) || !empty($product->custom_text))
                                                         <div class="d-flex flex-column" style="gap: 6px; text-align: left;">
                                                             @if(!empty($product->customization_position))
                                                                 <div><span class="badge" style="background:#038edc; color:#fff; font-size:10px; padding:3px 7px; border-radius:4px; font-weight:bold;">Position: {{ $product->customization_position }}</span></div>
                                                             @endif
                                                             @if(!empty($product->custom_text))
                                                                 <div style="font-size:11px; margin-top:2px;">
                                                                     <strong>Details:</strong> 
                                                                     <span style="color: {{ $product->custom_text_color ?? '#1e293b' }}; font-weight:bold; background:#f1f5f9; padding:2px 6px; border-radius:3px; border:1px solid #cbd5e1;">
                                                                         {{ $product->custom_text }}
                                                                     </span>
                                                                 </div>
                                                             @endif

                                                             <!-- Download Buttons for Multi-View Previews & Logo -->
                                                             <div style="display:flex; flex-wrap:wrap; gap:5px; margin-top:6px;">
                                                                 @php
                                                                     $proofMap = [];
                                                                     if (!empty($product->preview_screenshot_url)) {
                                                                         $decodedMap = json_decode($product->preview_screenshot_url, true);
                                                                         if (is_array($decodedMap)) {
                                                                             $proofMap = $decodedMap;
                                                                         } else {
                                                                             $proofMap = ['front' => $product->preview_screenshot_url];
                                                                         }
                                                                     }
                                                                 @endphp

                                                                 @foreach($proofMap as $vKey => $vUrl)
                                                                     @php $proofUrl = Str::startsWith($vUrl, 'http') ? $vUrl : asset($vUrl); @endphp
                                                                     <a href="{{ $proofUrl }}" download="{{ ucfirst($vKey) }}_Proof_{{ $product->order_id }}.png" target="_blank" class="design-asset-link btn-front" style="background:#28a745; color:#fff; text-decoration:none; padding:4px 8px; font-weight:bold; border-radius:4px; font-size:11px; display:inline-flex; align-items:center; gap:3px;">
                                                                         📥 {{ strtoupper($vKey) }} PROOF
                                                                     </a>
                                                                 @endforeach

                                                                 @if(!empty($product->custom_logo_url))
                                                                     @php $logoUrl = Str::startsWith($product->custom_logo_url, 'http') ? $product->custom_logo_url : asset($product->custom_logo_url); @endphp
                                                                     <a href="{{ $logoUrl }}" download="Uploaded_Logo_{{ $product->order_id }}.png" target="_blank" class="design-asset-link btn-back" style="background:#007bff; color:#fff; text-decoration:none; padding:4px 8px; font-weight:bold; border-radius:4px; font-size:11px; display:inline-flex; align-items:center; gap:3px;">
                                                                         📥 LOGO FILE
                                                                     </a>
                                                                 @endif
                                                             </div>
                                                         </div>
                                                    @elseif(!empty($product->design_id))
                                                        @php
                                                            $customDesign = \Illuminate\Support\Facades\DB::table('customproduct_designs')
                                                                ->where('id', $product->design_id)
                                                                ->first();
                                                            
                                                            $designLayers = \Illuminate\Support\Facades\DB::table('design_layers')
                                                                ->where('design_id', $product->design_id)
                                                                ->whereNotNull('source_path')
                                                                ->get();
                                                        @endphp
                                                        @if($customDesign)
                                                            <div class="d-flex flex-column" style="gap: 10px;">
                                                                <!-- Merged Previews -->
                                                                <div style="border-bottom: 1px solid #eee; padding-bottom: 5px;">
                                                                    <small style="display:block; color: #666; font-weight: bold; margin-bottom: 3px;">Merged Proofs:</small>
                                                                     @if(!empty($customDesign->preview_image_front))
                                                                         @php $fUrl = $formatUrl($customDesign->preview_image_front); @endphp
                                                                         <a href="{{ $fUrl }}" download="Front_Proof_{{ $product->order_id }}.png" target="_blank" class="design-asset-link btn-front">
                                                                             Front Proof
                                                                         </a>
                                                                     @endif
                                                                     @if(!empty($customDesign->preview_image_back))
                                                                         @php $bUrl = $formatUrl($customDesign->preview_image_back); @endphp
                                                                         <a href="{{ $bUrl }}" download="Back_Proof_{{ $product->order_id }}.png" target="_blank" class="design-asset-link btn-back">
                                                                             Back Proof
                                                                         </a>
                                                                     @endif
                                                                     @if(!empty($customDesign->preview_image_right_shoulder))
                                                                         @php $rUrl = $formatUrl($customDesign->preview_image_right_shoulder); @endphp
                                                                         <a href="{{ $rUrl }}" download="Right_Shoulder_Proof_{{ $product->order_id }}.png" target="_blank" class="design-asset-link btn-front" style="background-color: #20c997; color: white;">
                                                                             R. Shoulder
                                                                         </a>
                                                                     @endif
                                                                     @if(!empty($customDesign->preview_image_left_shoulder))
                                                                         @php $lUrl = $formatUrl($customDesign->preview_image_left_shoulder); @endphp
                                                                         <a href="{{ $lUrl }}" download="Left_Shoulder_Proof_{{ $product->order_id }}.png" target="_blank" class="design-asset-link btn-back" style="background-color: #17a2b8; color: white;">
                                                                             L. Shoulder
                                                                         </a>
                                                                     @endif
                                                                </div>

                                                                <!-- Original Assets & Elements -->
                                                                @if($designLayers->isNotEmpty())
                                                                    <div style="padding-top: 5px;">
                                                                        @php
                                                                            $physicalAssets = $designLayers->filter(fn($l) => !str_starts_with($l->source_path, 'emoji:'));
                                                                            $vectorElements = $designLayers->filter(fn($l) => str_starts_with($l->source_path, 'emoji:'));
                                                                        @endphp

                                                                        @if($physicalAssets->isNotEmpty())
                                                                            <small style="display:block; color: #666; font-weight: bold; margin-bottom: 3px;">Original Assets:</small>
                                                                            <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                                                                @foreach($physicalAssets as $layer)
                                                                                    <a href="{{ route('order-assets.file', ['path' => $layer->source_path]) }}" download="{{ $layer->layer_name }}.png" class="original-asset-item">
                                                                                        {{ $layer->layer_name }}
                                                                                    </a>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif

                                                                        @if($vectorElements->isNotEmpty())
                                                                            <small style="display:block; color: #666; font-weight: bold; margin-top: 8px; margin-bottom: 3px;">Vector Elements:</small>
                                                                            <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                                                                @foreach($vectorElements as $layer)
                                                                                    @php $emoji = str_replace('emoji:', '', $layer->source_path); @endphp
                                                                                    <div class="original-asset-item" style="cursor: default; background: #fffde7; border-color: #ffe082;" title="Vector Element">
                                                                                        {{ $emoji }} {{ $layer->layer_name }}
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif
                                                                        
                                                                        @if($physicalAssets->isNotEmpty())
                                                                            <div style="margin-top: 10px;">
                                                                                <a href="{{ route('order-assets.zip', ['orderId' => $product->order_id]) }}" class="design-asset-link btn-zip">
                                                                                    Bulk ZIP Assets
                                                                                </a>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="badge bg-secondary">Not Found</span>
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>

                                            @php
                                                $subtotal = ($product->product_rate ?? 0) * $product->quantity;
                                                $grandTotal += $subtotal;

                                                $discount = $product->productOrder->discount_amount ?? 0;
                                                $discounttyp = $product->discount ?? 0;
                                                $shipping = $product->shipping ?? 0;
                                                $total = $product->product_total ?? 0;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tm_invoice_footer tm_border_top tm_mb15 tm_m0_md" style="margin-top: 25px">
                            <div class="tm_right_footer">
                                <table class="tm_mb15">
                                    <thead>
                                        <tr class="tm_accent_bg">
                                            <td class="  ">Sub Total</td>
                                            <td class=" ">Grand Total</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="   ">$ {{ $grandTotal }}</td>
                                            <td class="   ">$ {{ $grandTotal - $discount + $shipping }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tm_invoice_footer tm_type1">
                            <div class="tm_left_footer">
                                @php
                                    $paymentProof = $products[0]->productOrder->payment_proof ?? null;
                                @endphp
                                @if($paymentProof)
                                    <div class="tm_mb15">
                                        <p class="tm_mb2"><b class="tm_primary_color">Payment Proof:</b></p>
                                        <a href="/uploads/proof/{{ $paymentProof }}" target="_blank">
                                            <img src="/uploads/proof/{{ $paymentProof }}" alt="Payment Proof" style="max-width: 300px; border: 1px solid #ccc; border-radius: 8px; padding: 5px;">
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="tm_right_footer">
                                <div class="tm_sign " style="text-align: right;">
                                    <img src="{{ asset('assets/images/Saaluvesa_log_trans.png') }}" alt="Sign">
                                    <p class="tm_m0 tm_ternary_color" style="position: relative;left: -8%;">Signature</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div style="padding: 20px; text-align:center;">
                            <h2 style="color: red;">No products found for this order.</h2>
                        </div>
                    @endif
                </div>
            </div>

            <div class="tm_invoice_btns tm_hide_print">
                <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
                    <span class="tm_btn_icon">🖨️</span>
                    <span class="tm_btn_text">Print</span>
                </a>
                <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
                    <span class="tm_btn_icon">⬇️</span>
                    <span class="tm_btn_text">Download PDF</span>
                </button>
                @if(!empty($products[0]->order_id))
                <a href="{{ route('admin.orders.download-order-zip', $products[0]->order_id) }}" class="tm_invoice_btn" style="background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; text-decoration: none;">
                    <span class="tm_btn_icon">📦</span>
                    <span class="tm_btn_text">Download All (ZIP)</span>
                </a>
                @endif
                @foreach($products as $pSlot)
                    @if(!empty($pSlot->preview_screenshot_url) || !empty($pSlot->custom_logo_url) || !empty($pSlot->design_id))
                        <a href="{{ route('admin.orders.specsheet-pdf', $pSlot->id) }}" target="_blank" class="tm_invoice_btn" style="background-color: rgba(25, 135, 84, 0.1); color: #198754; text-decoration: none;">
                            <span class="tm_btn_icon">📑</span>
                            <span class="tm_btn_text">Item #{{ $loop->iteration }} Spec Sheet</span>
                        </a>
                        <a href="{{ route('admin.orders.download-zip', $pSlot->id) }}" class="tm_invoice_btn" style="background-color: rgba(108, 117, 125, 0.1); color: #6c757d; text-decoration: none;">
                            <span class="tm_btn_icon">📁</span>
                            <span class="tm_btn_text">Item #{{ $loop->iteration }} Slot ZIP</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/invoice/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/invoice/jspdf.min.js') }}"></script>
    <script src="{{ asset('assets/js/invoice/html2canvas.min.js') }}"></script>
    <script src="{{ asset('assets/js/invoice/main.js') }}"></script>
</body>

</html>