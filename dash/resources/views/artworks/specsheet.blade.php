<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customization Artwork Spec Sheet - Slot #{{ $slot->id }}</title>
    <style>
        @page { margin: 15px 20px; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #1e293b; margin: 0; padding: 0; }
        .header { border-bottom: 2px solid #0f172a; padding-bottom: 6px; margin-bottom: 12px; }
        .title { font-size: 18px; font-weight: bold; color: #0f172a; text-transform: uppercase; }
        .subtitle { font-size: 10px; color: #64748b; margin-top: 2px; }
        
        .main-table { width: 100%; border-collapse: collapse; }
        .main-td { vertical-align: top; padding: 0; }

        .specs-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .specs-table th, .specs-table td { border: 1px solid #cbd5e1; padding: 5px 8px; text-align: left; font-size: 10px; }
        .specs-table th { background-color: #f1f5f9; font-weight: bold; width: 35%; color: #334155; }

        .section-title { font-size: 12px; font-weight: bold; color: #0f172a; margin-bottom: 6px; border-bottom: 1px solid #e2e8f0; padding-bottom: 2px; text-transform: uppercase; }
        .badge { display: inline-block; padding: 2px 6px; font-size: 9px; font-weight: bold; color: #fff; background-color: #0f172a; border-radius: 3px; }
        .color-box { display: inline-block; width: 12px; height: 12px; border: 1px solid #000; vertical-align: middle; margin-right: 3px; }

        .views-grid { width: 100%; border-collapse: collapse; }
        .view-cell { width: 50%; text-align: center; vertical-align: top; padding: 4px; }
        .view-box { border: 1px solid #cbd5e1; border-radius: 4px; padding: 4px; background: #fafafa; }
        .view-title { font-size: 9px; font-weight: bold; text-transform: uppercase; color: #475569; margin-bottom: 3px; background: #e2e8f0; padding: 2px; border-radius: 2px; }
        .mockup-img { max-height: 180px; max-width: 100%; width: auto; height: auto; display: block; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">SAALUVESA - Customization Artwork Spec Sheet</div>
        <div class="subtitle">Order ID: #{{ $slot->order_id }} | Slot ID: #{{ $slot->id }} | Date: {{ now()->format('Y-m-d H:i:s') }}</div>
    </div>

    <table class="main-table">
        <tr>
            <!-- Left Column: Product & Customization Specs -->
            <td class="main-td" style="width: 40%; padding-right: 12px;">
                <div class="section-title">Product Information</div>
                <table class="specs-table">
                    <tr><th>Garment Name</th><td><strong>{{ $slot->product_name }}</strong></td></tr>
                    <tr><th>Garment Size</th><td>{{ $slot->size_value ?? 'N/A' }}</td></tr>
                    <tr><th>Garment Color</th><td>{{ $slot->color_value ?? 'N/A' }}</td></tr>
                    <tr><th>Quantity</th><td>{{ $slot->quantity }}</td></tr>
                    <tr><th>Customer Name</th><td>{{ $slot->order_name ?? 'Valued Customer' }}</td></tr>
                </table>

                <div class="section-title" style="margin-top: 10px;">Customization Specs</div>
                <table class="specs-table">
                    <tr><th>Method</th><td><span class="badge">{{ strtoupper($slot->customization_method ?: $slot->customization_type ?: 'CUSTOM PRINT') }}</span></td></tr>
                    <tr><th>Position</th><td>{{ strtoupper(str_replace('_', ' ', $slot->customization_position ?: 'FRONT')) }}</td></tr>
                    @if($slot->custom_text)
                        <tr><th>Custom Text</th><td><strong>{{ $slot->custom_text }}</strong></td></tr>
                        <tr>
                            <th>Text Color</th>
                            <td>
                                <span class="color-box" style="background-color: {{ $slot->custom_text_color ?: '#1e3a8a' }};"></span>
                                {{ $slot->custom_text_color ?: '#1e3a8a' }}
                            </td>
                        </tr>
                    @endif
                    @if($slot->custom_logo_url)
                        <tr><th>Custom Logo</th><td><a href="{{ $slot->custom_logo_url }}" target="_blank" style="color: #0d6efd;">View Original Logo Asset</a></td></tr>
                    @endif
                </table>
            </td>

            <!-- Right Column: 2x2 Grid of All 4 Mockup Views -->
            <td class="main-td" style="width: 60%;">
                <div class="section-title">Customized Mockup Previews</div>
                @if(!empty($mockupViews) && count($mockupViews) > 0)
                    @php
                        $viewsList = array_chunk($mockupViews, 2, true);
                    @endphp
                    <table class="views-grid">
                        @foreach($viewsList as $row)
                            <tr>
                                @foreach($row as $vKey => $vB64)
                                    <td class="view-cell">
                                        <div class="view-box">
                                            <div class="view-title">{{ strtoupper($vKey) }} VIEW</div>
                                            <img src="{{ $vB64 }}" class="mockup-img" alt="{{ ucfirst($vKey) }} View">
                                        </div>
                                    </td>
                                @endforeach
                                @if(count($row) < 2)
                                    <td class="view-cell"></td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                @elseif($mockupBase64)
                    <div class="view-box" style="text-align: center;">
                        <img src="{{ $mockupBase64 }}" class="mockup-img" alt="Main View">
                    </div>
                @else
                    <div style="padding: 20px; color: #64748b; text-align: center; border: 1px dashed #cbd5e1; border-radius: 4px;">
                        No Mockup Image Available
                    </div>
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
