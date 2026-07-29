<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Bulk Order Inquiry Notification</title>
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .email-container { max-width: 700px; margin: 40px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05); border: 1px solid #eee; }
        .header { background: linear-gradient(135deg, #1C30A3 0%, #3B5FE0 100%); color: #ffffff; padding: 40px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; letter-spacing: 0.5px; }
        .header .badge { font-size: 14px; background: rgba(255, 255, 255, 0.2); padding: 6px 15px; border-radius: 20px; display: inline-block; margin-top: 15px; font-weight: 600; }
        .content { padding: 40px; }
        .section-title { color: #1C30A3; font-size: 16px; font-weight: 700; margin-bottom: 20px; padding-bottom: 8px; border-bottom: 2px solid #EBF0FF; text-transform: uppercase; letter-spacing: 1px; }
        .info-card { background-color: #F8FAFF; border-radius: 10px; padding: 25px; margin-bottom: 30px; border: 1px solid #EBF0FF; }
        .info-row { display: flex; margin-bottom: 12px; border-bottom: 1px solid #eff2f7; padding-bottom: 8px; }
        .info-row:last-child { border-bottom: none; }
        .info-label { width: 150px; color: #666; font-size: 13px; font-weight: 600; }
        .info-value { flex: 1; color: #333; font-size: 14px; font-weight: 500; }
        .notes-box { background-color: #ffffff; border: 1px solid #eee; border-radius: 8px; padding: 15px; font-style: italic; color: #555; font-size: 13px; line-height: 1.6; }
        .cta-box { text-align: center; margin-top: 40px; border-top: 1px solid #eee; padding-top: 30px; }
        .btn { display: inline-block; background: #1C30A3; color: #ffffff; text-decoration: none; padding: 15px 35px; border-radius: 8px; font-weight: 700; font-size: 14px; transition: all 0.3s ease; }
        .footer { padding: 30px; text-align: center; font-size: 12px; color: #999; background: #fafafa; }
        .brand { font-weight: 700; color: #1C30A3; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🚀 New Bulk Order Inquiry</h1>
            <div class="badge">Reference ID: #BK{{ date('Ymd') }}{{ $data->id }}</div>
        </div>
        
        <div class="content">
            <h2 class="section-title">👤 Contact Details</h2>
            <div class="info-card">
                <div class="info-row">
                    <div class="info-label">Full Name</div>
                    <div class="info-value">{{ $data->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email Address</div>
                    <div class="info-value">{{ $data->email }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Account Type</div>
                    <div class="info-value">{{ $data->user_type == 'B2B' ? 'B2B Business' : 'Normal User' }}</div>
                </div>
            </div>

            <h2 class="section-title">📦 Inquiry Specifications</h2>
            <div class="info-card">
                <div class="info-row">
                    <div class="info-label">Quantity</div>
                    <div class="info-value"><strong>{{ $data->quantity }} Units</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Customization Type</div>
                    <div class="info-value">
                        @switch($data->product_type)
                            @case('own_design')
                                Our Catalog Design
                                @break
                            @case('custom_design')
                                User's Saved Design
                                @break
                            @case('own_custom')
                                Custom Image/Logo Upload
                                @break
                        @endswitch
                    </div>
                </div>
                @if($data->product_id)
                <div class="info-row">
                    <div class="info-label">Product Name</div>
                    <div class="info-value"><strong>{{ $data->resolved_product_name ?? 'N/A' }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Product ID</div>
                    <div class="info-value">#{{ $data->product_id }}</div>
                </div>
                @endif
            </div>
            
            @if($data->custom_image && file_exists(public_path('storage/' . $data->custom_image)))
            <h2 class="section-title">🖼️ Reference Attachment</h2>
            <div class="info-card" style="text-align: center;">
                <p style="font-size: 12px; color: #666; margin-bottom: 15px;">The following image was uploaded as a reference for this inquiry:</p>
                <img src="{{ $message->embed(public_path('storage/' . $data->custom_image)) }}" alt="Reference Image" style="max-width: 100%; border-radius: 12px; border: 1px solid #eee; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                <div style="margin-top: 15px;">
                    <a href="{{ env('MAIN_URL') . 'images/' . $data->custom_image }}" target="_blank" style="font-size: 12px; color: #1C30A3; text-decoration: underline;">Open Original File</a>
                </div>
            </div>
            @endif


            @if($data->notes)
            <h2 class="section-title">📝 Additional Notes</h2>
            <div class="notes-box">
                "{{ $data->notes }}"
            </div>
            @endif

            <div class="cta-box">
                <p style="color: #666; font-size: 13px; margin-bottom: 20px;">Please login to the admin dashboard to review and reply to this inquiry.</p>
                <a href="{{ url('/myaccount') }}" class="btn">View All Inquiries</a>
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} <span class="brand">Saaluvesa</span>. All rights reserved.</p>
            <p>This is an automated operational email. Do not reply to this address.</p>
        </div>
    </div>
</body>
</html>
