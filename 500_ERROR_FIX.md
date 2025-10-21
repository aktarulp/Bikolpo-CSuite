# 🚨 500 Internal Server Error - Fix Guide

## 🔍 What's Happening

```
GET https://bikolpolive.com/partner 
net::ERR_HTTP_RESPONSE_CODE_FAILURE 500 (Internal Server Error)
```

This means **Laravel is crashing** before it can even serve the page.

---

## ⚡ Quick Fixes (Try in Order)

### Fix 1: Check .env File Exists

**Most common cause!** The `.env` file might be missing.

```bash
# Via SSH
cd /home/username/public_html
ls -la .env

# If missing, create it
cp .env.example .env
nano .env  # Edit with your production settings

# Generate app key
php artisan key:generate
```

**Via File Manager:**
1. Check if `.env` exists in `public_html/`
2. If missing, upload your local `.env` or create from `.env.example`
3. Edit and set production values

---

### Fix 2: Set Correct File Permissions

```bash
# Via SSH
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 775 uploads
chmod 644 .env
```

**Via File Manager:**
- `storage/` → **775** (and all subdirectories)
- `bootstrap/cache/` → **775**
- `uploads/` → **775**
- `.env` → **644**

---

### Fix 3: Clear All Caches

```bash
# Via SSH
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Then rebuild
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### Fix 4: Check APP_KEY

Your `.env` MUST have an APP_KEY:

```env
APP_KEY=base64:YOUR_LONG_KEY_HERE
```

If empty:
```bash
php artisan key:generate
```

---

### Fix 5: Check Database Connection

Edit `.env` on Hostinger:

```env
DB_CONNECTION=mysql
DB_HOST=localhost         # Usually localhost on Hostinger
DB_PORT=3306
DB_DATABASE=your_db_name  # Get from cPanel
DB_USERNAME=your_db_user  # Get from cPanel
DB_PASSWORD=your_db_pass  # Get from cPanel
```

**Verify database exists** in cPanel → MySQL Databases

---

### Fix 6: Check PHP Version

Laravel 11 requires **PHP 8.1+**

**In cPanel:**
1. Go to **Select PHP Version** or **MultiPHP Manager**
2. Select **PHP 8.1** or higher
3. Enable required extensions:
   - mbstring
   - xml
   - pdo
   - openssl
   - json
   - tokenizer
   - fileinfo
   - bcmath

---

## 🔍 Diagnostic Tool

**I created `diagnose.php` for you!**

Upload it to `public_html/` and access:
```
https://bikolpolive.com/diagnose.php
```

This will show:
- ✅ All missing files/folders
- ✅ Permission issues
- ✅ .env configuration problems
- ✅ PHP extension issues
- ✅ Database connection status
- ✅ Actual Laravel error logs

---

## 📋 Common 500 Error Causes

| Cause | How to Check | How to Fix |
|-------|-------------|------------|
| **Missing .env** | `ls .env` | `cp .env.example .env` |
| **Empty APP_KEY** | Check `.env` | `php artisan key:generate` |
| **Wrong permissions** | `ls -la storage` | `chmod -R 775 storage` |
| **Cache issues** | - | `php artisan config:clear` |
| **Database error** | Check credentials | Update `.env` DB settings |
| **Missing vendor/** | `ls vendor` | `composer install --no-dev` |
| **PHP version** | `php -v` | Update in cPanel |
| **Missing extensions** | `php -m` | Enable in cPanel |

---

## 🆘 Check Error Logs

### Method 1: Via File Manager
Navigate to: `storage/logs/laravel.log`

### Method 2: Via SSH
```bash
tail -f storage/logs/laravel.log
```

### Method 3: Via cPanel
**Error Logs** section → View latest errors

Look for error messages starting with:
- `RuntimeException`
- `FatalErrorException`
- `QueryException`
- etc.

---

## 🛠️ Complete Setup Script

If starting fresh on Hostinger:

```bash
# 1. Navigate to directory
cd /home/username/public_html

# 2. Create .env from example
cp .env.example .env

# 3. Edit .env with production values
nano .env
# Set: APP_ENV=production
# Set: APP_DEBUG=false
# Set: APP_URL=https://bikolpolive.com
# Set: DB_* values from cPanel

# 4. Generate app key
php artisan key:generate

# 5. Set permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 775 uploads
chmod 644 .env
find storage -type f -exec chmod 664 {} \;
find bootstrap/cache -type f -exec chmod 664 {} \;

# 6. Setup uploads
php artisan storage:setup-uploads

# 7. Clear and cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Run migrations
php artisan migrate --force

# 9. Test
php artisan route:list
```

---

## ✅ Verification Checklist

After fixing, verify:

- [ ] `.env` file exists with correct values
- [ ] `APP_KEY` is set and not empty
- [ ] `storage/` permissions are 775
- [ ] `bootstrap/cache/` permissions are 775
- [ ] Database credentials are correct
- [ ] Database exists in cPanel
- [ ] PHP version is 8.1+
- [ ] All required PHP extensions enabled
- [ ] `vendor/` folder exists
- [ ] `index.php` exists in root
- [ ] `.htaccess` exists in root
- [ ] Caches cleared and rebuilt
- [ ] No errors in `storage/logs/laravel.log`

---

## 🎯 Most Likely Causes (in order of frequency)

1. **Missing or incorrect .env file** (90% of 500 errors)
2. **Storage folder permissions** (5%)
3. **Database connection error** (3%)
4. **Missing APP_KEY** (1%)
5. **PHP version mismatch** (1%)

---

## 📞 Get Exact Error

**Upload `diagnose.php` and access it immediately!**

```
https://bikolpolive.com/diagnose.php
```

It will tell you **exactly** what's wrong in plain English! 🎯

---

**After fixing, DELETE diagnose.php for security!**

