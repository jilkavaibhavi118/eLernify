<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reply to Your Inquiry</title>
    <!-- Note: Many email clients do not support external CSS. For production, these styles should be inlined. -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
</head>

<body class="email-body">
    <div class="email-container">
        <div class="email-header">
            <h2>eLEARNIFY</h2>
        </div>
        <div class="email-content">
            <p>Hello <strong>{{ $contactMessage->name }}</strong>,</p>
            <p>Thank you for reaching out to us. We have reviewed your inquiry regarding
                <strong>"{{ $contactMessage->subject }}"</strong>.
            </p>

            <p><strong>Our Reply:</strong></p>
            <div style="background-color: #eef2ff; padding: 20px; border-radius: 8px; border: 1px solid #1266c2;">
                {{ $contactMessage->reply }}
            </div>

            <div class="email-original-message">
                <p><strong>Your Original Message:</strong></p>
                {{ $contactMessage->message }}
            </div>

            <p>If you have any more questions, feel free to visit our website or reply to this email.</p>

            <a href="{{ url('/') }}" class="email-btn">Visit eLEARNIFY</a>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} eLEARNIFY. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
