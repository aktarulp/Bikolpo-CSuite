<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Registration Verification - CSuite</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #1f2937;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 20px;
            min-height: 100vh;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }
        
        /* Header Section */
        .header {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .logo {
            font-size: 28px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }
        
        .tagline {
            color: #ecfdf5;
            font-size: 16px;
            font-weight: 500;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }
        
        /* Main Content */
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 16px;
        }
        
        .intro-text {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 32px;
            line-height: 1.7;
        }
        
        /* OTP Section */
        .otp-section {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 2px solid #bbf7d0;
            border-radius: 16px;
            padding: 32px;
            text-align: center;
            margin: 32px 0;
            position: relative;
            overflow: hidden;
        }
        
        .otp-section::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, #10b981, #34d399, #6ee7b7);
            border-radius: 16px;
            z-index: -1;
            opacity: 0.3;
        }
        
        .otp-title {
            font-size: 18px;
            font-weight: 600;
            color: #065f46;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .otp-code {
            font-size: 48px;
            font-weight: 800;
            color: #047857;
            letter-spacing: 8px;
            margin: 20px 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-family: 'Courier New', monospace;
        }
        
        .otp-subtitle {
            color: #059669;
            font-size: 14px;
            font-weight: 500;
        }
        
        /* Instructions Section */
        .instructions {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            margin: 24px 0;
        }
        
        .instructions h4 {
            color: #1e40af;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .instructions ol {
            list-style: none;
            counter-reset: step-counter;
        }
        
        .instructions li {
            counter-increment: step-counter;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
            position: relative;
            padding-left: 48px;
        }
        
        .instructions li:last-child {
            border-bottom: none;
        }
        
        .instructions li::before {
            content: counter(step-counter);
            position: absolute;
            left: 0;
            top: 12px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
        }
        
        /* Warning Section */
        .warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #f59e0b;
            border-radius: 12px;
            padding: 24px;
            margin: 24px 0;
            position: relative;
        }
        
        .warning::before {
            content: '⚠️';
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 20px;
        }
        
        .warning h4 {
            color: #92400e;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 16px;
            margin-left: 32px;
        }
        
        .warning ul {
            margin-left: 32px;
        }
        
        .warning li {
            color: #92400e;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        /* Support Section */
        .support-section {
            text-align: center;
            margin: 32px 0;
        }
        
        .support-text {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 24px;
        }
        
        .support-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .support-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            padding: 14px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .support-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .support-btn.whatsapp {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        
        .support-btn.email {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }
        
        /* Footer */
        .footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 32px 30px;
            text-align: center;
        }
        
        .company-info {
            margin-bottom: 24px;
        }
        
        .company-name {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }
        
        .company-tagline {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 16px;
        }
        
        .contact-info {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .disclaimer {
            color: #9ca3af;
            font-size: 12px;
            line-height: 1.5;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        
        /* Responsive Design */
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 12px;
            }
            
            .header, .content, .footer {
                padding: 24px 20px;
            }
            
            .otp-code {
                font-size: 36px;
                letter-spacing: 6px;
            }
            
            .support-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .support-btn {
                width: 100%;
                max-width: 280px;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header Section -->
        <div class="header">
            <div class="logo">CSuite</div>
            <div class="tagline">Your Smart Exam Partner</div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="greeting">Hello {{ $name }},</div>
            
            <div class="intro-text">
                Welcome to <strong>CSuite</strong>! We're excited to have you join our partner network. 
                To complete your registration and unlock access to our comprehensive exam management platform, 
                please use the verification code below:
            </div>

            <!-- OTP Section -->
            <div class="otp-section">
                <div class="otp-title">Verification Code</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-subtitle">Enter this code to verify your email address</div>
            </div>

            <!-- Instructions Section -->
            <div class="instructions">
                <h4>📋 How to Complete Your Registration</h4>
                <ol>
                    <li>Copy the 6-digit verification code above</li>
                    <li>Return to the registration page in your browser</li>
                    <li>Paste the code in the verification field</li>
                    <li>Click "Verify & Complete Registration" to proceed</li>
                </ol>
            </div>

            <!-- Warning Section -->
            <div class="warning">
                <h4>Important Security Notice</h4>
                <ul>
                    <li>This verification code expires in <strong>10 minutes</strong></li>
                    <li>Never share this code with anyone - our team will never ask for it</li>
                    <li>If you didn't request this code, please ignore this email and contact support</li>
                </ul>
            </div>

            <!-- Support Section -->
            <div class="support-section">
                <div class="support-text">
                    Need help or have questions? Our support team is here to assist you:
                </div>
                
                <div class="support-buttons">
                    <a href="https://wa.me/8801610800060" class="support-btn whatsapp">
                        📱 WhatsApp Support
                    </a>
                    <a href="mailto:bikolpo247@gmail.com" class="support-btn email">
                        ✉️ Email Support
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="company-info">
                <div class="company-name">CSuite</div>
                <div class="company-tagline">Empowering Education Through Technology</div>
            </div>
            
            <div class="contact-info">
                <div>🏢 উদ্ভাস কোচিং এর নিচ তলা, কলেজ রোড, আলমনগর, রংপুর</div>
                <div>📞 +880 1610800060 | ✉️ bikolpo247@gmail.com</div>
            </div>
            
            <div class="disclaimer">
                This email was sent to you as part of the CSuite partner registration process. 
                If you have any concerns about this email or your account, please contact our support team immediately. 
                © 2024 CSuite. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
