# 🆘 Hostinger 404 Error - Troubleshooting

## ❌ Error You're Seeing

```
Failed to load resource: the server responded with a status of 404 ()
app-DNtJnXI7.js:1 Failed to load resource: the server responded with a status of 404 ()
```

---

## 🔍 Root Cause

**Vite compiled assets are missing or inaccessible** on your Hostinger server.

---

## ✅ Solutions (Try in Order)

### Solution 1: Verify `public/build/` Was Uploaded

#### Check if these files exist on Hostinger:

```
public_html/
├── public/
│   └── build/
│       ├── manifest.json
│       └── assets/
│           ├── app-DNtJnXI7.js          ← This file is missing!
│           ├── app-B6XsSezd.css
│           └── [font files...]
```

#### Fix:
1. **Via File Manager:** Upload the ENTIRE `public/build/` folder to `public_html/public/`
2. **Via Git:** Make sure you committed `public/build/` before pushing

---

### Solution 2: Check File Permissions

#### On Hostinger (via SSH or File Manager):

```bash
# Via SSH
chmod -R 755 public/build
chmod 644 public/build/manifest.json
chmod 644 public/build/assets/*
```

#### Via File Manager:
- Right-click `public` folder → Permissions → **755**
- Right-click `public/build` folder → Permissions → **755**
- Right-click files in `build/assets/` → Permissions → **644**

---

### Solution 3: Verify Correct Directory Structure

Your Hostinger `public_html/` should look like this:

```
public_html/
├── .htaccess                    ← Root .htaccess
├── index.php                    ← Root index.php
├── app/
├── bootstrap/
├── config/
├── public/
│   ├── .htaccess               ← Public .htaccess
│   ├── index.php               ← Public index.php (redirects to root)
│   └── build/                  ← MUST EXIST!
│       ├── manifest.json
│       └── assets/
│           ├── app-DNtJnXI7.js
│           ├── app-B6XsSezd.css
│           └── ...
├── vendor/
├── resources/
└── ...
```

---

### Solution 4: Clear Laravel Caches

```bash
# Via SSH
cd /home/username/public_html
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### Solution 5: Verify `.env` Configuration

Check your `.env` file on Hostinger:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com    ← Make sure this matches!

# Make sure it's NOT pointing to Vite dev server
VITE_DEV_SERVER_URL=              ← Should be EMPTY
```

---

### Solution 6: Test Asset Loading Directly

Try accessing the asset directly in your browser:

```
https://yourdomain.com/public/build/manifest.json
https://yourdomain.com/public/build/assets/app-DNtJnXI7.js
```

**Expected:**
- ✅ Should download/display the files

**If you get 404:**
- ❌ Files are missing or in wrong location

---

## 🚀 Quick Fix Script

Create this file on Hostinger as `verify-assets.php`:

```php
<?php
// verify-assets.php - Upload this to public_html/

echo "<h2>Asset Verification</h2>";

$paths = [
    'public/build/manifest.json',
    'public/build/assets/app-DNtJnXI7.js',
    'public/build/assets/app-B6XsSezd.css',
];

foreach ($paths as $path) {
    $fullPath = __DIR__ . '/' . $path;
    if (file_exists($fullPath)) {
        $size = filesize($fullPath);
        $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
        echo "✅ {$path} - {$size} bytes - Permissions: {$perms}<br>";
    } else {
        echo "❌ {$path} - MISSING!<br>";
    }
}

echo "<br><h3>Expected manifest.json content:</h3>";
if (file_exists(__DIR__ . '/public/build/manifest.json')) {
    echo "<pre>" . file_get_contents(__DIR__ . '/public/build/manifest.json') . "</pre>";
} else {
    echo "Manifest not found!";
}
?>
```

Access: `https://yourdomain.com/verify-assets.php`

---

## 📋 Upload Checklist

Before uploading to Hostinger, verify locally:

```powershell
# Check if build exists
Test-Path "public/build/manifest.json"
# Should return: True

# Check file count
(Get-ChildItem "public/build" -Recurse -File).Count
# Should return: 20 (1 manifest + 19 assets)

# Build assets if missing
npm run build
```

---

## 🔄 Re-upload Process (Clean Start)

### Step 1: Build Locally
```bash
npm run build
```

### Step 2: Verify Build
```bash
ls -la public/build/
ls -la public/build/assets/
```

### Step 3: Upload via Git
```bash
git add public/build/
git commit -m "Add built assets"
git push origin main
```

### Step 4: Pull on Hostinger
```bash
cd /home/username/public_html
git pull origin main
```

### Step 5: Set Permissions
```bash
chmod -R 755 public/build
find public/build -type f -exec chmod 644 {} \;
```

### Step 6: Clear Caches
```bash
php artisan optimize:clear
php artisan config:cache
```

---

## 🎯 Prevention

Add to `.gitignore` to ensure build is committed:

```gitignore
# Build output - We'll commit this for easy deployment
# /public/build      ← Should be COMMENTED OUT or REMOVED
```

Then commit:
```bash
git add public/build/
git add .gitignore
git commit -m "Include build assets in Git"
git push origin main
```

---

## ✅ Verification Steps

After fixing:

1. ✅ Access: `https://yourdomain.com/public/build/manifest.json`
   - Should show JSON manifest
   
2. ✅ Access: `https://yourdomain.com/public/build/assets/app-DNtJnXI7.js`
   - Should show JavaScript code
   
3. ✅ Check browser console on your site
   - Should NOT show 404 errors
   
4. ✅ Check page source
   - Should see: `<script type="module" src="/public/build/assets/app-DNtJnXI7.js"></script>`

---

## 🆘 Still Not Working?

### Check Apache Configuration

Hostinger File Manager → `.htaccess` in root → Verify:

```apache
# Make sure this rule is NOT blocking /public/build/
RewriteCond %{REQUEST_URI} ^/(vendor|app|bootstrap|config|database|resources|routes|storage|tests)/
# ↑ Notice "public" is NOT in this list!
```

### Check Error Logs

- Hostinger Control Panel → Error Logs
- Look for permission denied or file not found errors

### Contact Hostinger Support

If assets still 404, ask them to verify:
- ✅ `mod_rewrite` is enabled
- ✅ `.htaccess` is allowed
- ✅ File permissions are correct

---

**Most Common Solution:** Missing `public/build/` folder on server. Upload it! 🚀

