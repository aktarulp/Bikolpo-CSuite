# CKEditor 4 + MathLive Deployment Guide for Hostinger

## Files to Upload

### 1. CKEditor Installation (Required)
- **Source:** `public/ckeditor/` (entire folder)
- **Destination:** `public_html/public/ckeditor/`
- **Size:** ~5-7 MB
- **Method:** FTP or File Manager

### 2. View Files (Required)
- `resources/views/partner/questions/create-desc.blade.php`
- `resources/views/partner/questions/edit-desc.blade.php`
- `resources/views/layouts/partner-layout.blade.php`

### 3. Config File (Required)
- `public/ckeditor/config.js`

---

## Deployment Methods

### Method 1: FTP/SFTP (Recommended for Large Files)

1. **Get Hostinger FTP Credentials:**
   - Login to Hostinger
   - Go to: Hosting → Manage → FTP Accounts
   - Use existing FTP account or create new one
   - Note: Hostname, Username, Password, Port (21)

2. **Using FileZilla (Free FTP Client):**
   - Download: https://filezilla-project.org/
   - Connect using your FTP credentials
   - Local site: Navigate to your local project
   - Remote site: Navigate to `public_html/`
   - Drag & drop folders to upload

3. **Upload Steps:**
   ```
   Local                           →  Remote
   ────────────────────────────────────────────────
   public/ckeditor/                →  public_html/public/ckeditor/
   resources/views/                →  public_html/resources/views/
   ```

### Method 2: Hostinger File Manager

1. **Compress First (Faster):**
   - Zip the `ckeditor` folder locally
   - Upload `ckeditor.zip` via File Manager
   - Extract in File Manager

2. **Upload Views:**
   - Upload individual Blade files
   - Overwrite existing files

### Method 3: Git (If Using Version Control)

```bash
# On your local machine
git add .
git commit -m "Add CKEditor 4 + MathLive integration"
git push origin main

# On Hostinger (via SSH if available)
cd public_html
git pull origin main
```

---

## Post-Deployment Steps

### 1. Clear Laravel Caches

**Via SSH (if available):**
```bash
cd public_html
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

**Via Web (if no SSH):**
Create a temporary file: `public/clear-cache.php`
```php
<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Clear caches
$kernel->call('config:clear');
$kernel->call('cache:clear');
$kernel->call('view:clear');
$kernel->call('route:clear');

echo "All caches cleared!";

// Delete this file after running
unlink(__FILE__);
```

Visit: `https://your-domain.com/clear-cache.php`

### 2. Verify File Permissions

Ensure proper permissions:
```
public/ckeditor/                → 755
public/ckeditor/ckeditor.js     → 644
public/ckeditor/config.js       → 644
resources/views/                → 755
resources/views/**/*.blade.php  → 644
```

### 3. Test on Live Site

1. **Test Create Form:**
   ```
   https://your-domain.com/partner/questions/descriptive/create
   ```
   - Check if CKEditor loads
   - Check if Math button appears
   - Try adding equations

2. **Test Edit Form:**
   ```
   https://your-domain.com/partner/questions/descriptive/{id}/edit
   ```
   - Check if existing content loads
   - Check if equations render
   - Try editing and saving

3. **Check Browser Console:**
   - Press F12
   - Look for:
     ```
     MathJax loaded globally
     ✓ CKEditor ready!
     ✓ MathLive initialized
     ```

---

## Troubleshooting

### Issue 1: CKEditor Not Loading

**Check:**
1. File path is correct: `public_html/public/ckeditor/ckeditor.js`
2. File permissions: `644` for JS files
3. Clear browser cache: Ctrl + Shift + Delete
4. Check console for 404 errors

**Fix:**
```bash
# Verify file exists
ls -la public_html/public/ckeditor/ckeditor.js

# Fix permissions
chmod 755 public_html/public/ckeditor
chmod 644 public_html/public/ckeditor/*.js
```

### Issue 2: Math Button Not Showing

**Check:**
1. Browser console for errors
2. MathLive CDN is accessible
3. CSS is loaded

**Fix:**
- Hard refresh: Ctrl + F5
- Clear all caches
- Check if plugin is registered (see console logs)

### Issue 3: Equations Not Rendering

**Check:**
1. MathJax is loaded (check Network tab)
2. Internet connection (CDN access)
3. Browser console for errors

**Fix:**
- Verify CDN URLs are accessible
- Check partner-layout.blade.php is uploaded
- Clear cache

### Issue 4: 500 Server Error

**Check:**
1. Blade syntax errors
2. Laravel logs: `storage/logs/laravel.log`
3. PHP version compatibility

**Fix:**
```bash
# Check logs
tail -f storage/logs/laravel.log

# Fix permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## Verification Checklist

- [ ] CKEditor folder uploaded to `public_html/public/ckeditor/`
- [ ] View files uploaded and replaced
- [ ] Layout file uploaded
- [ ] Caches cleared on server
- [ ] File permissions set correctly
- [ ] Create form works (test equation button)
- [ ] Edit form works (existing equations load)
- [ ] Equations render properly
- [ ] No console errors
- [ ] Mobile responsive (check on phone)

---

## CDN Dependencies (Already Handled)

These load automatically from CDN (no upload needed):
- MathLive: `https://unpkg.com/mathlive`
- MathJax: `https://cdn.jsdelivr.net/npm/mathjax@3`

Ensure your server allows external CDN connections.

---

## Performance Optimization (Optional)

### Enable Gzip Compression

Add to `.htaccess` in `public_html/`:
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/x-javascript
</IfModule>
```

### Browser Caching

Add to `.htaccess`:
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType text/css "access plus 1 month"
</IfModule>
```

---

## Support

If you encounter issues:
1. Check browser console (F12)
2. Check Laravel logs: `storage/logs/laravel.log`
3. Check Hostinger error logs in File Manager
4. Test locally first to isolate server issues

---

## Quick Command Reference

**Via SSH (if available):**
```bash
# Navigate to project
cd public_html

# Clear all caches
php artisan optimize:clear

# Set permissions
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 775 storage bootstrap/cache
```

**Via FTP:**
- Upload: Drag files from local to remote
- Permissions: Right-click → File Permissions
- Extract: Use File Manager's Extract feature

