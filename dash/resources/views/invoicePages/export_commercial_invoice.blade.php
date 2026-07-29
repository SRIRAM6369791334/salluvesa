<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Commercial Invoice</title>
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
        .bg-light { background-color:none; }
        .header-title { font-size: 18px; font-weight: bold; text-align: center; border: none; padding-bottom: 20px; text-transform: uppercase; }
        .layout-table { border: none; }
        .layout-table td { border: none; padding: 0; }
        .inner-box { border: 1px solid #000; padding: 10px; height: 100%; box-sizing: border-box; }
        .spacer { height: 10px; }
        .min-width-label { width: 140px; display: inline-block; font-weight: bold; }

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
        <td colspan="3" class="header-title">{{ $invoiceType === 'proforma' ? ($labels['proforma_invoice'] ?? 'PROFORMA INVOICE') : ($labels['commercial_invoice'] ?? 'COMMERCIAL INVOICE') }}</td>
    </tr>
    <tr>
        <td colspan="3" style="padding-bottom: 15px; border: none;">
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
        <td colspan="3" style="border: none; padding: 0;">
            <div contenteditable="true" style="width: 100%; min-height: 25px; margin-bottom: 5px;" class="editable-empty-row"></div>
        </td>
    </tr>
    <tr>
        <td style="width: 33%;"><strong>{{ $labels['date'] ?? 'Date' }}:</strong> {{ strtoupper(date('d-F-Y')) }}</td>
        <td style="width: 33%; text-align: center;"><strong>{{ $labels['invoice_number'] ?? 'Invoice Number' }}:</strong> {{ $invoiceNumber ?? ($order->order_id ?? 'N/A') }}</td>
        <td style="width: 34%; text-align: right;"><strong>{{ $labels['air_waybill_number'] ?? 'Air Waybill Number' }}:</strong> {{ $invoiceData['awb_bl_no'] ?? 'N/A' }}</td>
    </tr>
</table>

<table>
    <tr>
        <th colspan="2" class="bg-light text-center">{{ $labels['general_information'] ?? 'General Information' }}</th>
    </tr>
    <tr>
        <td style="width: 50%; padding:0;">
            <table class="no-border" style="margin:0; width: 100%;">
                <tr><th class="bg-light text-center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;">{{ $labels['sender_details'] ?? 'Sender Details' }}</th></tr>
                <tr><td style="border-right: 1px solid #000;"><span class="min-width-label">{{ $labels['name'] ?? 'Name' }}:</span> {{ $invoiceData['sender_name'] ?? 'Saaluvesa Enterprises Private Limited' }}</td></tr>
                <tr><td style="border-right: 1px solid #000;"><span class="min-width-label">{{ $labels['address'] ?? 'Address' }}:</span> {{ $invoiceData['sender_address'] ?? 'N/A' }}</td></tr>
                <tr><td style="border-right: 1px solid #000;"><span class="min-width-label">{{ $labels['contact_number'] ?? 'Contact Number' }}:</span> {{ $invoiceData['sender_contact'] ?? 'N/A' }}</td></tr>
                <tr><td style="border-right: 1px solid #000;"><span class="min-width-label">{{ $labels['email'] ?? 'Email' }}:</span> {{ $invoiceData['sender_email'] ?? 'N/A' }}</td></tr>
                <tr><td style="border-right: 1px solid #000;"><span class="min-width-label">{{ $labels['tax_id_no'] ?? 'Tax ID No.' }}:</span> {{ $invoiceData['sender_tax_id'] ?? 'N/A' }}</td></tr>
            </table>
        </td>
        <td style="width: 50%; padding:0;">
            <table class="no-border" style="margin:0; width: 100%;">
                <tr><th class="bg-light text-center" style="border-bottom: 1px solid #000;">{{ $labels['shipment_details'] ?? 'Shipment Details' }}</th></tr>
                <tr><td><span class="min-width-label">SHIPMENT DATE:</span> <span contenteditable="true" style="min-width: 100px; display: inline-block; font-weight:bold;">{{ !empty($invoiceData['shipment_date']) ? strtoupper(\Carbon\Carbon::parse($invoiceData['shipment_date'])->format('d-F-Y')) : strtoupper(date('d-F-Y')) }}</span></td></tr>
                <tr><td><span class="min-width-label">{{ $labels['shipment_ref_no'] ?? 'Shipment Reference No.' }}:</span> {{ $invoiceData['shipment_ref_no'] ?? 'N/A' }}</td></tr>
                <tr><td><span class="min-width-label">{{ $labels['reason_for_export'] ?? 'Reason for Export' }}:</span> {{ $invoiceData['reason_for_export'] ?? 'Commercial' }}</td></tr>
                <tr><td><span class="min-width-label">{{ $labels['type_of_export'] ?? 'Type of Export' }}:</span> {{ $invoiceData['type_of_export'] ?? 'Permanent' }}</td></tr>
                <tr><td><span class="min-width-label">{{ $labels['export_license_no'] ?? 'Export License No.' }}:</span> {{ $invoiceData['export_license_no'] ?? 'N/A' }}</td></tr>
                <tr><td><span class="min-width-label">{{ $labels['import_license_no'] ?? 'Import License No.' }}:</span> {{ $invoiceData['import_license_no'] ?? 'N/A' }}</td></tr>
                <tr><td><span class="min-width-label">{{ $labels['incoterms'] ?? 'INCOTERMS' }}:</span> {{ $invoiceData['incoterms'] ?? 'DAP' }}</td></tr>
                <tr><td><span class="min-width-label">{{ $labels['currency_code'] ?? 'Currency Code' }}:</span> {{ $invoiceData['currency_code'] ?? 'INR' }}</td></tr>
                <tr><td><span class="min-width-label">{{ $labels['payment_method'] ?? 'Payment Method' }}:</span> {{ $invoiceData['payment_method'] ?? 'Bank Transfer' }}</td></tr>
            </table>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td style="width: 50%; padding: 0;">
            <table class="no-border" style="margin:0; width: 100%;">
                <tr><th class="bg-light text-center" style="border-bottom: 1px solid #000; border-right: 1px solid #000;">{{ $labels['receiver_details'] ?? 'Receiver Details' }}</th></tr>
                <tr><td style="border-right: 1px solid #000;"><span class="min-width-label">{{ $labels['name'] ?? 'Name' }}:</span> {{ $invoiceData['receiver_name'] ?? ($order?->orderAddress?->address_username ?? ($order?->customer?->name ?? 'N/A')) }}</td></tr>
                <tr><td style="border-right: 1px solid #000;"><span class="min-width-label">{{ $labels['address'] ?? 'Address' }}:</span>
                    @if(isset($invoiceData['receiver_address']))
                        {!! nl2br(e($invoiceData['receiver_address'])) !!}
                    @else
                        {{ $order?->orderAddress?->address_line_one ?? '' }},
                        {{ $order?->orderAddress?->city ?? '' }},
                        {{ $order?->orderAddress?->state?->state_name ?? '' }} -
                        {{ $order?->orderAddress?->pincode ?? '' }}
                        @if(isset($order?->orderAddress?->country))
                            <br>{{ $order?->orderAddress?->country }}
                        @endif
                    @endif
                </td></tr>
                <tr><td style="border-right: 1px solid #000;"><span class="min-width-label">{{ $labels['contact_number'] ?? 'Contact Number' }}:</span> {{ $invoiceData['receiver_contact'] ?? ($order->orderAddress->address_phone_number ?? ($order->customer->phone_number ?? ($order->customer->mobile ?? 'N/A'))) }}</td></tr>
                <tr><td style="border-right: 1px solid #000;"><span class="min-width-label">{{ $labels['email'] ?? 'Email' }}:</span> {{ !empty($invoiceData['receiver_email']) ? $invoiceData['receiver_email'] : ($order->customer->email ?? 'N/A') }}</td></tr>
                <tr><td style="border-right: 1px solid #000;"><span class="min-width-label">{{ $labels['tax_id_no'] ?? 'Tax ID No.' }}:</span> {{ $invoiceData['receiver_tax_id'] ?? 'N/A' }}</td></tr>
            </table>
        </td>
        <td style="width: 50%; padding: 0;">
            <table class="no-border" style="margin:0; width: 100%;">
                <tr><th class="bg-light text-center" style="border-bottom: 1px solid #000;">{{ $labels['importer_of_record_details'] ?? 'Importer of Record Details' }}</th></tr>
                <tr><td><span class="min-width-label">{{ $labels['name'] ?? 'Name' }}:</span> {{ $invoiceData['importer_name'] ?? 'N/A' }}</td></tr>
                <tr><td><span class="min-width-label">{{ $labels['address'] ?? 'Address' }}:</span> {{$invoiceData['importer_address'] ?? 'N/A' }}</td></tr>
                <tr><td><span class="min-width-label">{{ $labels['contact_number'] ?? 'Contact Number' }}:</span> {{ $invoiceData['importer_contact'] ?? 'N/A' }}</td></tr>
                <tr><td><span class="min-width-label">{{ $labels['email'] ?? 'Email' }}:</span> {{ $invoiceData['importer_email'] ?? 'N/A' }}</td></tr>
                <tr><td><span class="min-width-label">{{ $labels['tax_id_no'] ?? 'Tax ID No.' }}:</span> {{ $invoiceData['importer_tax_id'] ?? 'N/A' }}</td></tr>
            </table>
        </td>
    </tr>
</table>

<table>
    <tr class="bg-light text-center">
        <th style="width: 5%;">{{ $labels['no'] ?? 'No.' }}</th>
        <th style="width: 30%;">{{ $labels['item_description'] ?? 'Item Description' }}</th>
        <th style="width: 15%;">{{ $labels['hs_code'] ?? 'HS Code' }}</th>
        <th style="width: 10%;">{{ $labels['country_of_origin'] ?? 'Country of Origin' }}</th>
        <th style="width: 10%;">{{ $labels['qty_uom'] ?? 'Qty UOM' }}</th>
        <th style="width: 10%;">{{ $labels['unit_value'] ?? 'Unit Value' }}</th>
        <th style="width: 10%;">{{ $labels['sub_total_value'] ?? 'Sub-Total Value' }}</th>
        <th style="width: 10%;">{{ $labels['unit_net_weight'] ?? 'UNIT NET WEIGHT IN GRAMS' }}</th>
    </tr>
    @php
        $totalVal = 0;
        $totalQty = 0;
        $totalWeightSum = 0;

        $currencyService = app(\App\Services\CurrencyService::class);
        $supported = $currencyService->getSupportedCurrencies();

        $targetCurrency = strtoupper($invoiceData['currency_code'] ?? 'USD');
        $currencySymbol = $supported[$targetCurrency]['symbol'] ?? '$';
        $baseCurrency = 'INR';
    @endphp
    @foreach($products as $index => $product)
        @php
            $rawPrice = $product->product_rate ?? ($product->productVarient->offer_price ?? 0);
            try {
                $price = $currencyService->convert($baseCurrency, $targetCurrency, $rawPrice);
            } catch (\Exception $e) {
                $price = $rawPrice;
            }
            $itemTotal = $price * $product->quantity;
            $totalVal += $itemTotal;
            $totalQty += $product->quantity;
            $productName = $product->product_name ?? ($product->product->product_name ?? 'N/A');
            $qtyDesc = !empty($product->productVarient->product_quantity) ? ' ('.$product->productVarient->product_quantity.')' : '';
            $variantDesc = !empty($product->size_value) ? ' - Size: '.$product->size_value : '';
            $variantDesc .= !empty($product->color_value) ? ' Color: '.\App\Models\ProductColor::getNamesByCodes($product->color_value) : '';
            $pId = str_starts_with((string)($order->order_id ?? ''), 'B-') || str_starts_with((string)($order->order_id ?? ''), 'ORD-SAA-BULK-') ? 'bulk' : $product->id;
            $prodWeight = (float)($invoiceData['product_weight_'.$pId] ?? 0);
            $totalWeightSum += ($prodWeight * $product->quantity);
        @endphp
        <tr>
            <td align="center">{{ $index + 1 }}</td>
            <td>{{ $productName }}{{ $qtyDesc }}{{ $variantDesc }}</td>
            <td align="center">{{ $invoiceData['hs_code'] ?? '84433210' }}</td>
            <td align="center">{{ $invoiceData['country_of_origin'] ?? 'India' }}</td>
            <td align="center">{{ $product->quantity }} PCS</td>
            <td align="right">{{ $currencySymbol }}{{ number_format($price, 2) }}</td>
            <td align="right">{{ $currencySymbol }}{{ number_format($itemTotal, 2) }}</td>
            <td align="center">{{ number_format($prodWeight, 2) }}</td>
        </tr>
    @endforeach
    <!-- Empty rows for filling -->
    @for($i = count($products); $i < 3; $i++)
    <tr><td><br></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
    @endfor
</table>

<table class="no-border">
    <tr>
        <td style="width: 60%; vertical-align: top;">
            <strong>{{ $labels['other_info'] ?? 'OTHER INFORMATION AND COMPLIANCE DETAILS' }}:</strong><br>
            <div style="border: 1px solid #000; height: 60px; margin-top: 5px; padding: 5px;">{{ $invoiceData['comments'] ?? '' }}</div>
        </td>
        <td style="width: 40%; vertical-align: bottom;">
            <table style="margin-bottom: 0;">
                <tr>
                    <td class="bg-light bold text-right" style="width: 50%;">{{ $labels['no_of_packages'] ?? 'No. of Packages' }}</td>
                    <td style="width: 50%;" class="text-right">{{ $invoiceData['number_of_packages'] ?? '1' }}</td>
                </tr>
                <tr>
                    <td class="bg-light bold text-right">{{ $labels['total_goods_value'] ?? 'Total Goods Value' }}</td>
                    <td class="text-right">{{ $currencySymbol }}{{ number_format($totalVal, 2) }}</td>
                </tr>
                <tr>
                    <td class="bg-light bold text-right">
                        {{ $labels['total_weight'] ?? 'TOTAL GROSS WEIGHT' }}<br>
                        <select id="weight_unit" style="border:none; appearance:none; -webkit-appearance:none; font-weight:bold; background:transparent; outline:none; text-align:right; font-size:11px;" class="no-print-dropdown">
                            <option value="GRAMS" {{ (!isset($invoiceData['gross_weight_unit']) || $invoiceData['gross_weight_unit'] == 'GRAMS') ? 'selected' : '' }}>GRAMS</option>
                            <option value="KILOGRAMS" {{ (isset($invoiceData['gross_weight_unit']) && $invoiceData['gross_weight_unit'] == 'KILOGRAMS') ? 'selected' : '' }}>KILOGRAMS</option>
                            <option value="TONNES" {{ (isset($invoiceData['gross_weight_unit']) && $invoiceData['gross_weight_unit'] == 'TONNES') ? 'selected' : '' }}>TONNES</option>
                        </select>
                    </td>
                    <td class="text-right">{{ number_format($totalWeightSum, 2) }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div style="margin-top: 30px;">
    <p>{{ $labels['certify_text'] ?? 'I/We certify the information on this invoice is true and correct and that the contents of this shipment are as stated above.' }}</p>
    <br><br>

    <table class="no-border" style="width: 100%;">
        <tr>
            <td style="width: 100px;"><strong>{{ $labels['signature'] ?? 'Signature' }}:</strong></td>
            <td style="border-bottom: 1px solid #000; width: 300px;"></td>
            <td></td>
        </tr>
        <tr><td><br></td><td></td><td></td></tr>
        <tr>
            <td><strong>{{ $labels['name'] ?? 'Name' }}:</strong></td>
            <td style="border-bottom: 1px solid #000; padding-left:5px;">{{ $invoiceData['signatory_name'] ?? 'Saaluvesa Enterprises Private Limited' }}</td>
            <td></td>
        </tr>
        <tr><td><br></td><td></td><td></td></tr>
        <tr>
            <td><strong>{{ $labels['designation_title'] ?? 'Designation/Title' }}:</strong></td>
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
            filename:     'Commercial_Invoice_{{ $invoiceNumber ?? ($order->order_id ?? "N/A") }}.pdf',
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
</script>
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}
</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>
