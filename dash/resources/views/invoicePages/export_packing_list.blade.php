<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Packing List</title>
    <style>
        @font-face {
            font-family: 'NotoSans';
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/NotoSans.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'NotoSans';
            font-style: normal;
            font-weight: bold;
            src: url('{{ storage_path('fonts/NotoSans-Bold.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'NotoSansTamil';
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/NotoSansTamil.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'NotoSansTamil';
            font-style: normal;
            font-weight: bold;
            src: url('{{ storage_path('fonts/NotoSansTamil-Bold.ttf') }}') format('truetype');
        }
        body { font-family: 'NotoSans', 'NotoSansTamil', Arial, sans-serif; font-size: 11px; color: #000; margin: 0 auto; max-width: 800px; padding: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 5px; table-layout: fixed; }
        th, td { border: 1px solid #000; padding: 2px; vertical-align: top; }
        .no-border td, .no-border th { border: none; }
        .bold { font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bg-light { background-color: #f9f9f9; }
        .header-title { font-size: 18px; font-weight: bold; text-align: center; border: none; padding-bottom: 20px; }
        .min-width-label { width: 130px; display: inline-block; font-weight: bold; }

        /* Print and Toolbar Styles */
        .no-print-bar {
            background: #1a252f;
            color: #ffffff;
            padding: 12px 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            z-index: 99999;
            margin-bottom: 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .no-print-bar button {
            background: #25d366;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 13px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(37,211,102,0.3);
            transition: all 0.2s ease;
        }
        .no-print-bar button:hover {
            background: #128c7e;
            transform: translateY(-1px);
        }
        .no-print-bar .instructions {
            font-size: 12px;
            color: #e2e8f0;
            line-height: 1.5;
        }
        .editable-empty-row { border: 1px dashed #ccc; padding: 2px; }
        .no-print-dropdown::-ms-expand { display: none; }
        @media print {
            .no-print-bar {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 10px !important;
                max-width: 100% !important;
            }
            .editable-empty-row { border: none !important; }
            .editable-empty-row:empty { display: none !important; }
        }
    </style>
</head>
<body>

<div class="no-print-bar">
    <div class="instructions">
        <strong>💡 Chrome தமிழ் PDF அச்சிடும் வழிமுறை:</strong><br>
        1. பக்கத்தில் எங்கு வேண்டுமானாலும் Right-Click செய்து <strong>"Translate to தமிழ்"</strong> (தமிழ் மொழியாக்கம்) செய்யவும்.<br>
        2. பக்கம் தமிழில் மாறியவுடன், வலதுபுறம் உள்ள <strong>"📥 Direct Download"</strong> பொத்தானை அழுத்தவும். அது உடனடியாக தமிழ் PDF-ஐ டவுன்லோட் செய்யும்.
    </div>
    <div style="display: flex; gap: 10px;">
        <div id="google_translate_element"></div>
        <button onclick="downloadPDF()" style="background: #007bff; box-shadow: 0 2px 5px rgba(0,123,255,0.3);">📥 Direct Download</button>
        <button onclick="window.print()" style="background: #6c757d; box-shadow: 0 2px 5px rgba(108,117,125,0.3);">🖨️ Native Print</button>
    </div>
</div>

<table class="no-border" style="margin-bottom: 10px;">
    <tr>
        <td colspan="4" class="header-title">PACKING LIST</td>
    </tr>
    <tr>
        <td colspan="4" style="padding-bottom: 15px; border: none;">
            <table class="no-border" style="width: 100%; margin: 0;">
                <tr>
                    <td style="width: 20%; vertical-align: middle; padding: 0;">
                        @php
                            $path = public_path('assets/images/logo2.jpeg');
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_exists($path) ? file_get_contents($path) : '';
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        @endphp
                        <img src="{{ $base64 }}" alt="Saaluvesa Logo" style="max-width: 150px; height: auto;">
                    </td>
                    <td style="width: 80%; vertical-align: top; padding: 0; padding-left: 10px;">
                        <h4 style="margin: 0 0 5px 0; font-size: 14px; text-transform: uppercase;">Saaluvesa Enterprises Private Limited</h4>
                        <p style="margin: 0; line-height: 1.4; font-size: 11px;">
                            Dr.No.18/76, Thiru.Ve.Ka. St, Punjai Puliampatti, SATHYAMANGALAM, ERODE, TAMIL NADU. -638459<br>
                            <strong>C.I.N :</strong> U46900TZ2025PTC36041 &nbsp;|&nbsp; <strong>ROC COIMBATORE - REG. NO :</strong> 036041<br>
                            <strong>GST -</strong> 33ABRCS3304A1ZR &nbsp;|&nbsp; <strong>Import Export code -</strong> ABRCS3304A &nbsp;|&nbsp; <strong>ICEGATE ID -</strong> ABRCS3304APIE000
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="border: none; padding: 0;">
            <div contenteditable="true" style="width: 100%; min-height: 25px; margin-bottom: 5px;" class="editable-empty-row">{{ $invoiceData['additional_company_details'] ?? '' }}</div>
        </td>
    </tr>
    <tr>
        <td style="width: 50%; font-size: 14px; font-weight: bold;" colspan="2"></td>
        <td style="width: 25%; text-align: right;"><strong>Page:</strong></td>
        <td style="width: 25%; border-bottom: 1px solid #000; padding-left:5px;"> 1 of 1</td>
    </tr>
    <tr>
        <td style="width: 25%;"></td>
        <td style="width: 25%;"></td>
        <td colspan="2" style="text-align: right;">
            <p><b>Date:</b> {{ strtoupper(date('d-F-Y')) }}</p>
            <p><b>Invoice Number:</b> {{ $invoiceData['invoice_number'] ?? 'INV-123' }}</p>
            <p><b>SHIPMENT DATE:</b> <span contenteditable="true" class="editable-empty-row" style="min-width: 80px; display:inline-block;">{{ !empty($invoiceData['shipment_date']) ? strtoupper(\Carbon\Carbon::parse($invoiceData['shipment_date'])->format('d-F-Y')) : strtoupper(date('d-F-Y')) }}</span></p>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;"><strong>Invoice No:</strong></td>
        <td style="border-bottom: 1px solid #000; padding-left:5px;"> {{ $order->order_id ?? 'N/A' }}</td>
        <td style="text-align: right;"><strong>Invoice Date:</strong></td>
        <td style="border-bottom: 1px solid #000; padding-left:5px;"> {{ strtoupper(date('d-F-Y')) }}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td style="text-align: right;"><strong>File Number:</strong></td>
        <td style="border-bottom: 1px solid #000; padding-left:5px;"> {{ $invoiceData['file_number'] ?? 'N/A' }}</td>
    </tr>
</table>

<table>
    <tr>
        <th style="width: 33%;" class="bg-light text-center">SHIPPER</th>
        <th style="width: 33%;" class="bg-light text-center">CONSIGNEE</th>
        <th style="width: 34%;" class="bg-light text-center">BILL TO</th>
    </tr>
    <tr>
        <td style="height: 100px;">
            <strong>{{ $invoiceData['sender_name'] ?? 'Saaluvesa Enterprises Private Limited' }}</strong><br>
            {{ $invoiceData['sender_address'] ?? 'N/A' }}
        </td>
        <td>
            @if(isset($invoiceData['receiver_name']))
                <strong>{{ $invoiceData['receiver_name'] }}</strong><br>
                {!! nl2br(e($invoiceData['receiver_address'] ?? '')) !!}
            @else
                <strong>{{ $order?->orderAddress?->address_username ?? ($order?->customer?->name ?? 'N/A') }}</strong><br>
                {{ $order?->orderAddress?->address_line_one ?? '' }}, {{ $order?->orderAddress?->city ?? '' }},<br>
                {{ $order?->orderAddress?->state?->state_name ?? '' }} - {{ $order?->orderAddress?->pincode ?? '' }}
            @endif
        </td>
        <td>
            @if(isset($invoiceData['receiver_name']))
                <strong>{{ $invoiceData['receiver_name'] }}</strong><br>
                {!! nl2br(e($invoiceData['receiver_address'] ?? '')) !!}
            @else
                <strong>{{ $order?->orderAddress?->address_username ?? ($order?->customer?->name ?? 'N/A') }}</strong><br>
                {{ $order?->orderAddress?->address_line_one ?? '' }}, {{ $order?->orderAddress?->city ?? '' }},<br>
                {{ $order?->orderAddress?->state?->state_name ?? '' }} - {{ $order?->orderAddress?->pincode ?? '' }}
            @endif
        </td>
    </tr>
</table>

<table>
    <tr>
        <th colspan="2" class="bg-light text-center">SHIPMENT INFORMATION</th>
    </tr>
    <tr>
        <td style="width:50%; padding:0;">
            <table class="no-border" style="width:100%; margin:0;">
                <tr><td style="border-right:1px solid #000; border-bottom:1px solid #000;"><span class="min-width-label">Letter of Credit No:</span> {{ $invoiceData['lc_no'] ?? 'N/A' }}</td></tr>
                <tr><td style="border-right:1px solid #000; border-bottom:1px solid #000;"><span class="min-width-label">Customer PO No:</span> {{ $invoiceData['customer_po_no'] ?? 'N/A' }}</td></tr>
                <tr><td style="border-right:1px solid #000; border-bottom:1px solid #000;"><span class="min-width-label">PO Date:</span> {{ (!empty($invoiceData['po_date'])) ? strtoupper(\Carbon\Carbon::parse($invoiceData['po_date'])->format('d-F-Y')) : 'N/A' }}</td></tr>
                <tr><td style="border-right:1px solid #000; border-bottom:1px solid #000;"><span class="min-width-label">Currency:</span> {{ $invoiceData['currency_code'] ?? 'INR' }}</td></tr>
                <tr><td style="border-right:1px solid #000; border-bottom:1px solid #000;"><span class="min-width-label">Ref No:</span> {{ $invoiceData['shipment_ref_no'] ?? 'N/A' }}</td></tr>
                <tr><td style="border-right:1px solid #000; border-bottom:1px solid #000;"><span class="min-width-label">Payment Terms:</span> {{ $invoiceData['payment_method'] ?? 'Bank Transfer' }}</td></tr>
                <tr><td style="border-right:1px solid #000; border-bottom:1px solid #000;"><span class="min-width-label">Incoterms Desc.:</span> {{ $invoiceData['incoterms'] ?? 'DAP' }}</td></tr>
                <tr><td style="border-right:1px solid #000;"><span class="min-width-label">AWB/BL No:</span> {{ $invoiceData['awb_bl_no'] ?? 'N/A' }}</td></tr>
            </table>
        </td>
        <td style="width:50%; padding:0;">
            <table class="no-border" style="width:100%; margin:0;">
                <tr><td style="border-bottom:1px solid #000;"><span class="min-width-label">Mode of Transportation:</span> {{ $invoiceData['mode_of_transportation'] ?? 'Air' }}</td></tr>
                <tr><td style="border-bottom:1px solid #000;"><span class="min-width-label">Transportation Terms:</span> {{ $invoiceData['transportation_terms'] ?? 'EXW' }}</td></tr>
                <tr><td style="border-bottom:1px solid #000;"><span class="min-width-label">Number of Packages:</span> {{ $invoiceData['number_of_packages'] ?? '1' }}</td></tr>
                <tr><td style="border-bottom:1px solid #000;"><span class="min-width-label">Gross Weight(Kg):</span> {{ $invoiceData['total_weight'] ?? '0.00' }}</td></tr>
                <tr><td style="height: 104px;"></td></tr> <!-- Filler to match height -->
            </table>
        </td>
    </tr>
</table>

<table>
    <tr class="bg-light text-center">
        <th style="width: 5%;">NOs</th>
        <th style="width: 10%;">QUANTITY</th>
        <th style="width: 45%;">DESCRIPTION</th>
        <th style="width: 15%;">HSN CODE</th>
        <th style="width: 15%;">NET WEIGHT IN GRAMS</th>
        <th style="width: 10%;">UNIT</th>
    </tr>
    @php 
        $totalWeight = 0;
        foreach($products as $p) {
            $pId = str_starts_with((string)($order->order_id ?? ''), 'B-') || str_starts_with((string)($order->order_id ?? ''), 'ORD-SAA-BULK-') ? 'bulk' : $p->id;
            $prodWeight = (float)($invoiceData['product_weight_'.$pId] ?? 0);
            $totalWeight += ($prodWeight * $p->quantity);
        }
    @endphp
    @foreach($products as $index => $product)
    @php
        $pId = str_starts_with((string)($order->order_id ?? ''), 'B-') || str_starts_with((string)($order->order_id ?? ''), 'ORD-SAA-BULK-') ? 'bulk' : $product->id;
        $prodWeight = (float)($invoiceData['product_weight_'.$pId] ?? 0);
    @endphp
    <tr>
        <td align="center">{{ $index + 1 }}</td>
        <td align="center">{{ $product->quantity }}</td>
        <td>
            <strong>{{ $product->product_name ?? ($product->product->product_name ?? 'N/A') }}</strong><br>
            <small>
                {{ $product->productVarient->product_quantity ?? '' }}
                {{ !empty($product->size_value) ? ' - Size: '.$product->size_value : '' }}
                {{ !empty($product->color_value) ? ' Color: '.\App\Models\ProductColor::getNamesByCodes($product->color_value) : '' }}
            </small>
        </td>
        <td align="center">{{ $invoiceData['hs_code'] ?? '84433210' }}</td>
        <td align="center">{{ number_format($prodWeight, 2) }}</td>
        <td align="center">PCS</td>
    </tr>
    @endforeach
    <!-- Empty rows -->
    @for($i = count($products); $i < 3; $i++)
    <tr><td><br></td><td></td><td></td><td></td><td></td><td></td></tr>
    @endfor
</table>

<table class="no-border" style="width: 60%; float: right;">
    <tr>
        <td colspan="4" class="text-right"><strong>TOTAL:</strong></td>
    </tr>
    <tr class="bg-light text-center">
        <th style="border: 1px solid #000; width: 25%;">NO.<br>PKGS</th>
        <td style="text-align: right; font-weight: bold; border: 1px solid #000;">
            TOTAL GROSS WEIGHT <br>
            <select id="weight_unit" style="border:none; appearance:none; -webkit-appearance:none; font-weight:bold; background:transparent; outline:none; text-align:right; font-size:12px;" class="no-print-dropdown">
                <option value="GRAMS" {{ (!isset($invoiceData['gross_weight_unit']) || $invoiceData['gross_weight_unit'] == 'GRAMS') ? 'selected' : '' }}>GRAMS</option>
                <option value="KILOGRAMS" {{ (isset($invoiceData['gross_weight_unit']) && $invoiceData['gross_weight_unit'] == 'KILOGRAMS') ? 'selected' : '' }}>KILOGRAMS</option>
                <option value="TONNES" {{ (isset($invoiceData['gross_weight_unit']) && $invoiceData['gross_weight_unit'] == 'TONNES') ? 'selected' : '' }}>TONNES</option>
            </select>
        </td>
        <th style="border: 1px solid #000; width: 25%;">NET WEIGHT<br>LBS</th>
        <th style="border: 1px solid #000; width: 25%;">NET WEIGHT<br>KGS</th>
    </tr>
    <tr>
        <td style="border: 1px solid #000; text-align: center;">{{ $invoiceData['number_of_packages'] ?? '1' }}</td>
        <td style="border: 1px solid #000; text-align: center;">{{ $totalWeight }}</td>
        <td style="border: 1px solid #000; text-align: center;"></td>
        <td style="border: 1px solid #000; text-align: center;">{{ $totalWeight }}</td>
    </tr>
</table>
<div style="clear: both; margin-top: 15px;">
    <div style="margin-bottom: 10px;">
        <strong>PACKAGE DESCRIPTION:</strong>
        <div contenteditable="true" style="min-height: 20px; width: 60%;" class="editable-empty-row">{{ $invoiceData['package_description'] ?? '' }}</div>
    </div>
    <table class="no-border" style="width: 100%;">
        <tr>
            <td style="width: 100px;"><strong>Signature:</strong></td>
            <td style="border-bottom: 1px solid #000; width: 300px;"></td>
            <td></td>
        </tr>
        <tr><td><br></td><td></td><td></td></tr>
        <tr>
            <td><strong>Name:</strong></td>
            <td style="border-bottom: 1px solid #000; padding-left:5px;">{{ $invoiceData['signatory_name'] ?? 'Saaluvesa Enterprises Private Limited' }}</td>
            <td></td>
        </tr>
        <tr><td><br></td><td></td><td></td></tr>
        <tr>
            <td><strong>Designation/Title:</strong></td>
            <td style="border-bottom: 1px solid #000; padding-left:5px;">{{ $invoiceData['signatory_designation'] ?? 'Manager' }}</td>
            <td></td>
        </tr>
    </table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function downloadPDF() {
        const toolbar = document.querySelector('.no-print-bar');
        
        const opt = {
            margin:       [5, 5, 5, 5],
            filename:     'Packing_List_{{ $order->order_id ?? "N/A" }}.pdf',
            image:        { type: 'jpeg', quality: 1.0 },
            html2canvas:  { 
                scale: 2, 
                useCORS: true,
                logging: false,
                letterRendering: true
            },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        const element = document.body;
        
        if (toolbar) {
            toolbar.style.display = 'none';
        }
        
        html2pdf().set(opt).from(element).save().then(() => {
            if (toolbar) {
                toolbar.style.display = 'flex';
            }
        }).catch((err) => {
            console.error('PDF Generation Error:', err);
            if (toolbar) {
                toolbar.style.display = 'flex';
            }
        });
    }
</script>
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}
</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>
