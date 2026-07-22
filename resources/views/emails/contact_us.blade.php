<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Contact Message</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; }
        .header { border-bottom: 2px solid #2563eb; padding-bottom: 15px; margin-bottom: 20px; }
        .label { font-weight: bold; color: #475569; display: block; margin-bottom: 3px; }
        .value { padding: 8px 12px; background: #f8fafc; border-radius: 4px; border-left: 3px solid #2563eb; }
        .footer { margin-top: 30px; padding-top: 15px; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header"><h1>📩 New Contact Message</h1></div>

        <div style="margin-bottom:15px;">
            <span class="label">Name</span>
            <div class="value">{{ $name }}</div>
        </div>

        <div style="margin-bottom:15px;">
            <span class="label">Email</span>
            <div class="value"><a href="mailto:{{ $email }}">{{ $email }}</a></div>
        </div>

        <div style="margin-bottom:15px;">
            <span class="label">Message</span>
            <div class="value" style="white-space:pre-wrap;">{{ $messageContent }}</div>
        </div>

        <div class="footer">
            IP: {{ $ip }} • Sent: {{ $sentAt }}
        </div>
    </div>
</body>
</html>