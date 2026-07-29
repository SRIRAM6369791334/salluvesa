<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Order Inquiry Received</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; color: #333; }
        .container { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header { background: #1C30A3; color: #ffffff; padding: 30px; text-align: center; }
        .content { padding: 40px; line-height: 1.6; }
        .success-icon { font-size: 48px; display: block; margin-bottom: 20px; }
        .footer { background: #f4f4f4; padding: 20px; text-align: center; font-size: 12px; color: #777; }
        .btn { display: inline-block; background: #1C30A3; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You!</h1>
        </div>
        <div class="content">
            <span class="success-icon">✅</span>
            <p>Dear <strong>{{ $data->name }}</strong>,</p>
            <p>We have successfully received your bulk order inquiry (Ref: #BK{{ date('Ymd') }}{{ $data->id }}).</p>
            <p>Our business team is now reviewing your requirements. We will analyze the quantity, customization details, and current stock to provide you with a competitive quote.</p>
            <p><strong>What's next?</strong></p>
            <p>One of our account managers will contact you via email or phone within 24-48 business hours to discuss the next steps.</p>
            
            <a href="{{ url('/') }}" class="btn">Return to Store</a>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Saaluvesa. All rights reserved.</p>
            <p>This is an automated confirmation of your submission.</p>
        </div>
    </div>
</body>
</html>
