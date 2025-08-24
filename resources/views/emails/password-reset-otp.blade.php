<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
    <style>
        body {
            font-family: 'Hind Siliguri', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #dc2626;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 10px;
        }
        .otp-box {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 30px 0;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            margin: 10px 0;
        }
        .info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #dc2626;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            background-color: #dc2626;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">বিকল্প কম্পিউটার</div>
            <p>Your Smart Exam Partner</p>
        </div>

        <h2>Hello {{ $name }},</h2>
        
        <p>We received a request to reset your password for your <strong>বিকল্প কম্পিউটার</strong> account. To proceed with the password reset, please use the OTP below:</p>

        <div class="otp-box">
            <h3>Your Password Reset Code</h3>
            <div class="otp-code">{{ $otp }}</div>
            <p>Enter this code to verify your identity and reset your password</p>
        </div>

        <div class="info">
            <h4>🔐 How to reset your password:</h4>
            <ol>
                <li>Copy the 6-digit code above</li>
                <li>Go to the password reset verification page</li>
                <li>Paste the code in the OTP verification field</li>
                <li>Click "Verify OTP" to proceed</li>
                <li>Enter your new password and confirm it</li>
                <li>Click "Reset Password" to complete the process</li>
            </ol>
        </div>

        <div class="warning">
            <strong>⚠️ Important Security Information:</strong>
            <ul>
                <li>This OTP is valid for <strong>10 minutes</strong> only</li>
                <li>Do not share this code with anyone</li>
                <li>If you didn't request this password reset, please ignore this email</li>
                <li>Your current password will remain unchanged until you complete the reset process</li>
            </ul>
        </div>

        <p>If you have any questions or need assistance, please don't hesitate to contact us:</p>
        
        <div style="text-align: center; margin: 20px 0;">
            <a href="https://wa.me/8801610800060" class="btn">📱 WhatsApp Support</a>
            <a href="mailto:bikolpo247@gmail.com" class="btn">✉️ Email Support</a>
        </div>

        <div class="footer">
            <p><strong>বিকল্প কম্পিউটার</strong></p>
            <p>Your Smart Exam Partner</p>
            <p>🏠 উদ্ভাস কোচিং এর নিচ তলা, কলেজ রোড, আলমনগর, রংপুর</p>
            <p>📞 +880 1610800060 | ✉️ bikolpo247@gmail.com</p>
            <p style="margin-top: 20px; font-size: 12px; color: #999;">
                This email was sent to you as part of the password reset process. 
                If you have any concerns about this request, please contact our support team immediately.
            </p>
        </div>
    </div>
</body>
</html>
