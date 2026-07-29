<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 700px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 26px;
            font-weight: 600;
        }
        .header .submission-id {
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .alert-box {
            background-color: #d1ecf1;
            border-left: 4px solid #0c5460;
            padding: 15px;
            margin-bottom: 25px;
            font-size: 14px;
            color: #0c5460;
        }
        .info-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .info-title {
            color: #667eea;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        .info-row {
            display: flex;
            margin-bottom: 12px;
            font-size: 14px;
        }
        .info-label {
            color: #666666;
            font-weight: 600;
            min-width: 120px;
        }
        .info-value {
            color: #333333;
            flex: 1;
        }
        .message-box {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .message-box h3 {
            color: #333;
            font-size: 15px;
            margin: 0 0 10px 0;
        }
        .message-content {
            color: #555;
            font-size: 14px;
            line-height: 1.6;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .technical-info {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            font-size: 12px;
            color: #666;
        }
        .technical-info div {
            margin-bottom: 5px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #999999;
            border-top: 1px solid #e9ecef;
        }
        .brand {
            font-weight: 600;
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>📬 New Contact Form Submission</h1>
            <div class="submission-id">Submission ID: #{{ $contactMessage->id }}</div>
        </div>
        
        <div class="content">
            <div class="alert-box">
                <strong>🔔 Action Required:</strong> A new contact form submission has been received and requires your attention.
            </div>

            <div class="info-section">
                <div class="info-title">👤 Customer Information</div>
                <div class="info-row">
                    <div class="info-label">Name:</div>
                    <div class="info-value"><strong>{{ $contactMessage->name }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">
                        <a href="mailto:{{ $contactMessage->email }}" style="color: #667eea; text-decoration: none;">
                            {{ $contactMessage->email }}
                        </a>
                    </div>
                </div>
                @if($contactMessage->phone)
                <div class="info-row">
                    <div class="info-label">Phone:</div>
                    <div class="info-value">
                        <a href="tel:{{ $contactMessage->phone }}" style="color: #667eea; text-decoration: none;">
                            {{ $contactMessage->phone }}
                        </a>
                    </div>
                </div>
                @endif
                @if($contactMessage->country)
                <div class="info-row">
                    <div class="info-label">Country:</div>
                    <div class="info-value">{{ $contactMessage->country }}</div>
                </div>
                @endif
                <div class="info-row">
                    <div class="info-label">Subject:</div>
                    <div class="info-value"><strong>{{ $contactMessage->subject }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Submitted:</div>
                    <div class="info-value">{{ $contactMessage->created_at->format('M d, Y h:i A') }}</div>
                </div>
            </div>

            <div class="message-box">
                <h3>💬 Message:</h3>
                <div class="message-content">{{ $contactMessage->message }}</div>
            </div>

            <div class="technical-info">
                <strong>Technical Details:</strong>
                <div><strong>IP Address:</strong> {{ $contactMessage->ip_address ?? 'N/A' }}</div>
                <div><strong>User Agent:</strong> {{ $contactMessage->user_agent ?? 'N/A' }}</div>
                <div><strong>Status:</strong> {{ $contactMessage->status ?? 'New' }}</div>
            </div>

            <div style="font-size: 12px; color: #666; margin-top: 20px;">
                <strong>Next Steps:</strong><br>
                • Review the message and determine priority<br>
                • Reply to the customer via email: <a href="mailto:{{ $contactMessage->email }}" style="color: #667eea;">{{ $contactMessage->email }}</a><br>
                • Update submission status in your admin panel
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} <span class="brand">Saaluvesa</span> - Contact Form Notification</p>
            <p>This is an automated notification. Please respond directly to the customer's email address.</p>
        </div>
    </div>
</body>
</html>
