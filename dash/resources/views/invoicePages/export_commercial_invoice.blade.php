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

        .editable-empty-row { border: 1px dashed #ccc; padding: 2px; }
        .no-print-dropdown::-ms-expand { display: none; }
        @media print {
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

@php
    $headerUnitLabel = 'Grams';
    foreach($products as $pCheck) {
        $pIdCheck = str_starts_with((string)($order->order_id ?? ''), 'B-') || str_starts_with((string)($order->order_id ?? ''), 'ORD-SAA-BULK-') ? 'bulk' : $pCheck->id;
        $uCheck = strtolower($invoiceData['product_weight_unit_'.$pIdCheck] ?? 'g');
        if (in_array($uCheck, ['kg', 'kilograms', 'kilogram'])) {
            $headerUnitLabel = 'Kilograms';
            break;
        } elseif (in_array($uCheck, ['t', 'tons', 'ton', 'tonnes'])) {
            $headerUnitLabel = 'Tons';
            break;
        }
    }
@endphp
<table>
    <tr class="bg-light text-center">
        <th style="width: 5%;">{{ $labels['no'] ?? 'No.' }}</th>
        <th style="width: 30%;">{{ $labels['item_description'] ?? 'Item Description' }}</th>
        <th style="width: 15%;">{{ $labels['hs_code'] ?? 'HS Code' }}</th>
        <th style="width: 10%;">{{ $labels['country_of_origin'] ?? 'Country of Origin' }}</th>
        <th style="width: 10%;">{{ $labels['qty_uom'] ?? 'Qty UOM' }}</th>
        <th style="width: 10%;">{{ $labels['unit_value'] ?? 'Unit Value' }}</th>
        <th style="width: 10%;">{{ $labels['sub_total_value'] ?? 'Sub-Total Value' }}</th>
        <th style="width: 10%;">Unit Net Weight In {{ $headerUnitLabel }}</th>
    </tr>
    @php
        $totalVal = 0;
        $totalQty = 0;
        $totalWeightSum = 0;

        $currencyService = app(\App\Services\CurrencyService::class);
        $supported = $currencyService->getSupportedCurrencies();

        $targetCurrency = strtoupper($invoiceData['currency_code'] ?? 'INR');
        $currencySymbol = $supported[$targetCurrency]['symbol'] ?? ($targetCurrency === 'INR' ? '₹' : ($targetCurrency . ' '));
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
            $rawWeight = (float)($invoiceData['product_weight_'.$pId] ?? 0);
            $weightUnit = strtolower($invoiceData['product_weight_unit_'.$pId] ?? 'g');

            if ($weightUnit === 'kg' || $weightUnit === 'kilograms' || $weightUnit === 'kilogram') {
                $weightInGrams = $rawWeight * 1000;
                $cleanNum = rtrim(rtrim(number_format($rawWeight, 2, '.', ''), '0'), '.');
                $formattedUnitWeight = $cleanNum . ' kg';
            } elseif ($weightUnit === 't' || $weightUnit === 'tons' || $weightUnit === 'ton' || $weightUnit === 'tonnes') {
                $weightInGrams = $rawWeight * 1000000;
                $cleanNum = rtrim(rtrim(number_format($rawWeight, 4, '.', ''), '0'), '.');
                $formattedUnitWeight = $cleanNum . ' t';
            } else {
                $weightInGrams = $rawWeight;
                $cleanNum = rtrim(rtrim(number_format($rawWeight, 2, '.', ''), '0'), '.');
                $formattedUnitWeight = $cleanNum . ' g';
            }

            $totalWeightSum += ($weightInGrams * $product->quantity);
        @endphp
        <tr>
            <td align="center">{{ $index + 1 }}</td>
            <td>{{ $productName }}{{ $qtyDesc }}{{ $variantDesc }}</td>
            <td align="center">{{ $invoiceData['hs_code'] ?? '84433210' }}</td>
            <td align="center">{{ $invoiceData['country_of_origin'] ?? 'India' }}</td>
            <td align="center">{{ $product->quantity }} PCS</td>
            <td align="right">{{ $currencySymbol }}{{ number_format($price, 2) }}</td>
            <td align="right">{{ $currencySymbol }}{{ number_format($itemTotal, 2) }}</td>
            <td align="center">{{ $formattedUnitWeight }}</td>
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
                @php
                    $taxRows = [];
                    $totalTaxVal = 0;
                    if (!empty($invoiceData['taxes']) && is_array($invoiceData['taxes'])) {
                        foreach($invoiceData['taxes'] as $tax) {
                            $tName = trim($tax['name'] ?? '');
                            $tPct = (float)($tax['percent'] ?? 0);
                            if ($tName !== '' && $tPct > 0) {
                                $tAmt = ($totalVal * $tPct) / 100;
                                $taxRows[] = [
                                    'name' => $tName,
                                    'percent' => $tPct,
                                    'amount' => $tAmt
                                ];
                                $totalTaxVal += $tAmt;
                            }
                        }
                    }
                    $finalTotalAmount = $totalVal + $totalTaxVal;
                @endphp
                <tr>
                    <td class="bg-light bold text-right">{{ $labels['total_goods_value'] ?? 'Total Goods Value' }}</td>
                    <td class="text-right">{{ $currencySymbol }}{{ number_format($totalVal, 2) }}</td>
                </tr>
                @foreach($taxRows as $tRow)
                <tr>
                    <td class="bg-light bold text-right">{{ $tRow['name'] }} ({{ number_format($tRow['percent'], 2) }}%)</td>
                    <td class="text-right">{{ $currencySymbol }}{{ number_format($tRow['amount'], 2) }}</td>
                </tr>
                @endforeach
                @if(count($taxRows) > 0)
                <tr>
                    <td class="bg-light bold text-right">Final Total Amount</td>
                    <td class="text-right bold">{{ $currencySymbol }}{{ number_format($finalTotalAmount, 2) }}</td>
                </tr>
                @endif
                @php
                    $selectedGrossUnit = strtoupper($invoiceData['gross_weight_unit'] ?? 'GRAMS');
                    if ($selectedGrossUnit === 'KILOGRAMS' || $selectedGrossUnit === 'KG') {
                        $totalGrossFormatted = rtrim(rtrim(number_format($totalWeightSum / 1000, 2, '.', ''), '0'), '.');
                    } elseif ($selectedGrossUnit === 'TONNES' || $selectedGrossUnit === 'TONS' || $selectedGrossUnit === 'T') {
                        $totalGrossFormatted = rtrim(rtrim(number_format($totalWeightSum / 1000000, 4, '.', ''), '0'), '.');
                    } else {
                        $totalGrossFormatted = rtrim(rtrim(number_format($totalWeightSum, 2, '.', ''), '0'), '.');
                    }
                @endphp
                <tr>
                    <td class="bg-light bold text-right">
                        {{ $labels['total_weight'] ?? 'TOTAL GROSS WEIGHT' }}<br>
                        <select id="weight_unit" style="border:none; appearance:none; -webkit-appearance:none; font-weight:bold; background:transparent; outline:none; text-align:right; font-size:11px;" class="no-print-dropdown">
                            <option value="GRAMS" {{ (!isset($invoiceData['gross_weight_unit']) || $invoiceData['gross_weight_unit'] == 'GRAMS') ? 'selected' : '' }}>GRAMS</option>
                            <option value="KILOGRAMS" {{ (isset($invoiceData['gross_weight_unit']) && $invoiceData['gross_weight_unit'] == 'KILOGRAMS') ? 'selected' : '' }}>KILOGRAMS</option>
                            <option value="TONNES" {{ (isset($invoiceData['gross_weight_unit']) && $invoiceData['gross_weight_unit'] == 'TONNES') ? 'selected' : '' }}>TONNES</option>
                        </select>
                    </td>
                    <td id="total_gross_weight_cell" class="text-right" data-total-grams="{{ $totalWeightSum }}">{{ $totalGrossFormatted }}</td>
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

    document.addEventListener('DOMContentLoaded', function() {
        const unitSelect = document.getElementById('weight_unit');
        if (unitSelect) {
            unitSelect.addEventListener('change', function() {
                const unit = this.value;
                const cell = document.getElementById('total_gross_weight_cell');
                if (!cell) return;
                const totalGrams = parseFloat(cell.getAttribute('data-total-grams') || '0');
                if (unit === 'KILOGRAMS') {
                    const val = (totalGrams / 1000).toFixed(2);
                    cell.innerText = val.replace(/\.?0+$/, '');
                } else if (unit === 'TONNES') {
                    const val = (totalGrams / 1000000).toFixed(4);
                    cell.innerText = val.replace(/\.?0+$/, '');
                } else {
                    const val = totalGrams.toFixed(2);
                    cell.innerText = val.replace(/\.?0+$/, '');
                }
            });
        }
    });
</script>
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}
</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>
