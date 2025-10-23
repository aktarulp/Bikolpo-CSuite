# 📧 Mail Configuration Guide

## Current Issue
The contact form is not sending emails because the mail driver is set to `log` instead of a real email service.

## 🔧 Configuration Options

### Option 1: Gmail SMTP (Recommended)

1. **Update your `.env` file with these settings:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-gmail@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

2. **Enable 2-Factor Authentication on Gmail**
3. **Generate an App Password:**
   - Go to Google Account settings
   - Security → 2-Step Verification → App passwords
   - Generate a new app password for "Mail"
   - Use this password in MAIL_PASSWORD

### Option 2: Mailtrap (For Development)

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@bikolpolive.com"
MAIL_FROM_NAME="Bikolpo Live"
```

### Option 3: Mailgun (For Production)

```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.mailgun.org
MAILGUN_SECRET=your-mailgun-secret
MAIL_FROM_ADDRESS="noreply@bikolpolive.com"
MAIL_FROM_NAME="Bikolpo Live"
```

## 🧪 Testing Email Configuration

After updating your `.env` file, test the email configuration:

1. **Clear config cache:**
   ```bash
   php artisan config:clear
   ```

2. **Test email sending:**
   Visit: `http://your-domain.com/test-email`

3. **Check logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

## 📝 Current Email Settings

The contact form sends emails to: `bikolpo247@gmail.com`

## 🔍 Troubleshooting

- **Check logs:** `storage/logs/laravel.log`
- **Verify SMTP settings:** Test with a simple email first
- **Check firewall:** Ensure port 587/465 is not blocked
- **Verify credentials:** Double-check username/password
