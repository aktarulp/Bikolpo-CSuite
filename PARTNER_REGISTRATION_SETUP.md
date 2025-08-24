# Partner Registration System Setup Guide

## Overview
This guide will help you set up the partner registration system with email OTP verification using your Gmail account (bikolpo247@gmail.com).

## Features Implemented
- ✅ Partner registration form with comprehensive fields
- ✅ Email OTP verification system
- ✅ Gmail SMTP configuration
- ✅ Professional email templates
- ✅ OTP expiration (10 minutes)
- ✅ Resend OTP functionality
- ✅ Auto-login after successful verification
- ✅ Session-based OTP storage

## Files Created/Modified

### 1. Controller
- `app/Http/Controllers/Auth/PartnerRegistrationController.php` - Main controller for partner registration

### 2. Views
- `resources/views/auth/partner/register.blade.php` - Registration form
- `resources/views/auth/partner/verify-otp.blade.php` - OTP verification page
- `resources/views/emails/partner-otp.blade.php` - Email template

### 3. Routes
- Updated `routes/auth.php` with new partner registration routes
- Added test email route in `routes/web.php`

### 4. Configuration
- Updated `config/mail.php` with Gmail defaults

## Setup Instructions

### Step 1: Gmail App Password Setup
1. Go to your Google Account settings: https://myaccount.google.com/
2. Navigate to Security → 2-Step Verification
3. Generate an App Password for "Mail"
4. Copy the 16-character password

### Step 2: Environment Configuration
Create or update your `.env` file with the following Gmail settings:

```env
# Gmail Configuration for OTP Emails
MAIL_MAILER=smtp
MAIL_SCHEME=tls
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=bikolpo247@gmail.com
MAIL_PASSWORD=your-16-character-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="bikolpo247@gmail.com"
MAIL_FROM_NAME="বিকল্প কম্পিউটার"
```

**Important**: Replace `your-16-character-app-password` with the actual app password from Step 1.

### Step 3: Clear Configuration Cache
Run these commands to clear any cached configurations:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Step 4: Test Email Functionality
1. Start your Laravel server: `php artisan serve`
2. Visit: `http://127.0.0.1:8000/test-email`
3. You should see "Test email sent successfully!" if everything is configured correctly

### Step 5: Test Partner Registration
1. Visit: `http://127.0.0.1:8000/partner/register`
2. Fill out the registration form
3. Check your email for the OTP
4. Complete the verification process

## Routes Available

- **Partner Registration**: `GET /partner/register`
- **Process Registration**: `POST /partner/register`
- **OTP Verification**: `GET /partner/verify-otp`
- **Verify OTP**: `POST /partner/verify-otp`
- **Resend OTP**: `POST /partner/resend-otp`
- **Partner Login**: `GET /partner/login`

## Email Template Features

- Professional design with your branding
- Clear OTP display
- Step-by-step instructions
- Support contact information
- Responsive design
- Bengali language support

## Security Features

- OTP expires after 10 minutes
- 6-digit numeric OTP
- Session-based storage
- Input validation and sanitization
- CSRF protection
- Rate limiting (can be configured)

## Troubleshooting

### Email Not Sending
1. Verify your Gmail app password is correct
2. Check if 2-Step Verification is enabled
3. Ensure your Gmail account allows "less secure app access" (if not using app password)
4. Check Laravel logs: `storage/logs/laravel.log`

### OTP Not Working
1. Check if the session is working properly
2. Verify the OTP hasn't expired (10 minutes)
3. Check browser console for JavaScript errors

### Registration Form Issues
1. Ensure all required fields are filled
2. Check validation rules in the controller
3. Verify database migrations are run

## Database Requirements

Make sure you have the following tables:
- `users` table with `role` and `phone` columns
- `partners` table with organization details

## Production Considerations

1. **Remove test route**: Delete the `/test-email` route before going live
2. **Environment variables**: Ensure all sensitive data is in environment variables
3. **Rate limiting**: Implement rate limiting for OTP requests
4. **Logging**: Monitor email sending logs for any issues
5. **Backup**: Set up email backup (e.g., using Laravel's failover mailer)

## Support

If you encounter any issues:
- Check Laravel logs: `storage/logs/laravel.log`
- Verify Gmail settings
- Test with a simple email first
- Contact support if needed

## Next Steps

After successful setup:
1. Test the complete registration flow
2. Customize email templates if needed
3. Add any additional validation rules
4. Implement rate limiting
5. Set up monitoring and logging
6. Test with real users

---

**Note**: This system uses your personal Gmail account (bikolpo247@gmail.com) for sending emails. For production use, consider using a dedicated business email or email service provider.
