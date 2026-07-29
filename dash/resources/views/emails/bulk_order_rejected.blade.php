<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Update Regarding Your Bulk Order</title>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px; }
        .header { background: #f44336; color: white; padding: 10px; text-align: center; border-radius: 8px 8px 0 0; }
        .reason-box { background: #fff5f5; border-left: 4px solid #f44336; padding: 15px; margin: 15px 0; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #777; margin-top: 20px; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Status Update: Bulk Order Request</h2>
        </div>
        <div class="content">
            <p>Hi {{ $bulkOrder->name }},</p>
            <p>Thank you for reaching out to us for a bulk order. We have reviewed your request for <strong>#{{ $bulkOrder->id }}</strong>.</p>
            <p>Unfortunately, we are unable to proceed with your request at this time due to the following reason:</p>
            
            <div class="reason-box">
                <strong>Admin's Note:</strong><br>
                {{ $bulkOrder->admin_notes }}
            </div>

            <p>You can review this feedback and submit a new request if applicable. If you have any questions regarding this decision, please feel free to contact us.</p>
        </div>
        <div class="footer">
            <p>Regards,<br>Team Saaluvesa Enterprises Private Limited</p>
        </div>
    </div>
</body>
</html>
