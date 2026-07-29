<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Saaluvesa</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #333333;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            font-size: 14px;
            color: #666666;
            line-height: 1.8;
            margin-bottom: 25px;
        }
        .features {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 25px;
            margin: 30px 0;
        }
        .feature-item {
            display: flex;
            align-items: start;
            margin-bottom: 15px;
        }
        .feature-item:last-child {
            margin-bottom: 0;
        }
        .feature-icon {
            font-size: 20px;
            margin-right: 12px;
            flex-shrink: 0;
        }
        .feature-text {
            font-size: 14px;
            color: #555555;
            line-height: 1.5;
        }
        .feature-text strong {
            color: #333333;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            margin: 20px 0;
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .divider {
            border: 0;
            height: 1px;
            background: #e9ecef;
            margin: 30px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #999999;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 5px 0;
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
            <h1>🎉 Welcome to Saaluvesa!</h1>
            <p>Your account has been successfully created</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Hello {{ $user->name }}!
            </div>
            
            <div class="message">
                We're thrilled to have you join the <span class="brand">Saaluvesa</span> family! 
                Your registration was successful, and you're now ready to explore our premium collection 
                of products and services.
            </div>
            
            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon">🛍️</div>
                    <div class="feature-text">
                        <strong>Browse Products:</strong> Explore our extensive catalog of high-quality products 
                        tailored to your needs.
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">📦</div>
                    <div class="feature-text">
                        <strong>Easy Ordering:</strong> Enjoy a seamless shopping experience with secure 
                        checkout and multiple payment options.
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🎁</div>
                    <div class="feature-text">
                        <strong>Request Samples:</strong> Not sure? Request product samples before making 
                        your final purchase decision.
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🚚</div>
                    <div class="feature-text">
                        <strong>Order Tracking:</strong> Track your orders in real-time from your account 
                        dashboard.
                    </div>
                </div>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="cta-button">Start Shopping Now</a>
            </div>
            
            <hr class="divider">
            
            <div class="message">
                <strong>Account Details:</strong><br>
                Email: <span style="color: #667eea;">{{ $user->email }}</span><br>
                Phone: {{ $user->phone_number }}
            </div>
            
            <div class="message">
                If you have any questions or need assistance, our support team is here to help. 
                Feel free to reach out anytime!
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} <span class="brand">Saaluvesa</span>. All rights reserved.</p>
            <p>This is an automated email. Please do not reply to this message.</p>
        </div>
    </div>
</body>
</html>
