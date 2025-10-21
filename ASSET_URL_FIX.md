# 🔧 Asset URL Fix - Vite 404 Error

## ✅ Files Exist and Are Accessible

You confirmed:
- ✅ `https://yourdomain.com/public/build/manifest.json` - Accessible
- ✅ `https://yourdomain.com/public/build/assets/app-DNtJnXI7.js` - Accessible

But browser console shows 404. This means **the HTML is referencing wrong URLs**.

---

## 🔍 Diagnose the Issue

### Check Your Page Source

1. Go to your Hostinger site
2. **Right-click → View Page Source**
3. Search for `app-DNtJnXI7.js`
4. Find the `<script>` tag

**What do you see?**

### ✅ Scenario A: Missing `/public/` prefix

```html
<!-- ❌ WRONG - Missing /public/ -->
<script type="module" src="/build/assets/app-DNtJnXI7.js"></script>

<!-- ✅ CORRECT - Should be: -->
<script type="module" src="/public/build/assets/app-DNtJnXI7.js"></script>
```

**Fix:** Update `config/vite.php` to add `/public` prefix.

---

### ✅ Scenario B: Absolute URL without `/public/`

```html
<!-- ❌ WRONG -->
<script type="module" src="http://yourdomain.com/build/assets/app-DNtJnXI7.js"></script>

<!-- ✅ CORRECT -->
<script type="module" src="http://yourdomain.com/public/build/assets/app-DNtJnXI7.js"></script>
```

**Fix:** Set `ASSET_URL` in `.env`.

---

### ✅ Scenario C: Mixed Content (HTTP vs HTTPS)

```html
<!-- ❌ WRONG - Using HTTP on HTTPS site -->
<script type="module" src="http://yourdomain.com/public/build/assets/app-DNtJnXI7.js"></script>

<!-- ✅ CORRECT -->
<script type="module" src="https://yourdomain.com/public/build/assets/app-DNtJnXI7.js"></script>
```

**Fix:** Update `APP_URL` in `.env` to use `https://`.

---

## 🛠️ Solution 1: Configure Vite to Include `/public/` Prefix

### Update `vite.config.js`:

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
        outDir: 'public/build',
    },
    // Add this for Hostinger
    base: '/public/',
});
```

**Then rebuild:**
```bash
npm run build
```

---

## 🛠️ Solution 2: Set ASSET_URL in `.env` (Hostinger)

Edit `.env` on Hostinger:

```env
APP_URL=https://yourdomain.com
ASSET_URL=https://yourdomain.com/public
```

Then clear cache:
```bash
php artisan config:clear
php artisan config:cache
```

---

## 🛠️ Solution 3: Create Custom Vite Config for Production

**File:** `config/vite.php` (create if doesn't exist)

```php
<?php

return [
    'build_path' => env('VITE_BUILD_PATH', 'build'),
    'dev_url' => env('VITE_DEV_URL', null),
    'manifest' => env('VITE_MANIFEST_PATH', 'public/build/manifest.json'),
    
    // Add base URL for assets
    'base_url' => env('VITE_BASE_URL', '/public/'),
];
```

---

## 🛠️ Solution 4: Override Asset URL Helper

**Create:** `app/Helpers/AssetHelper.php`

```php
<?php

if (!function_exists('vite_asset')) {
    function vite_asset($path)
    {
        // Force /public/ prefix on production
        if (app()->environment('production')) {
            $manifestPath = public_path('build/manifest.json');
            
            if (!file_exists($manifestPath)) {
                return asset($path);
            }
            
            $manifest = json_decode(file_get_contents($manifestPath), true);
            
            // Look up the file in manifest
            if (isset($manifest[$path])) {
                return asset('public/build/' . $manifest[$path]['file']);
            }
        }
        
        return asset($path);
    }
}
```

**Add to `composer.json`:**

```json
"autoload": {
    "files": [
        "app/Helpers/StorageHelper.php",
        "app/Helpers/AssetHelper.php"
    ]
}
```

Run:
```bash
composer dump-autoload
```

---

## 🎯 Quick Test Script

Upload `check-asset-urls.php` (I created it above) to Hostinger and access it:

```
https://yourdomain.com/check-asset-urls.php
```

This will show **exactly** what URLs Laravel/Vite is generating!

---

## ⚡ Most Likely Fix (Try This First)

### On Hostinger `.env`:

```env
# Change this:
APP_URL=http://yourdomain.com

# To this (with https):
APP_URL=https://yourdomain.com

# Add this:
ASSET_URL="${APP_URL}/public"
```

### Clear cache:

```bash
php artisan config:clear
php artisan config:cache
php artisan view:clear
```

### Refresh your browser:

```
Ctrl + Shift + R (hard refresh)
```

---

## 📊 Debug Checklist

- [ ] Files exist: `public/build/manifest.json` ✅
- [ ] Files accessible via direct URL ✅
- [ ] Check page source - what path is in `<script src="???">` ?
- [ ] `.env` has correct `APP_URL` (with https://)
- [ ] `.env` has `ASSET_URL` set to `${APP_URL}/public`
- [ ] Cache cleared: `php artisan config:clear`
- [ ] Browser cache cleared: Ctrl + Shift + R

---

## 🆘 Tell Me What You See

**In the page source, what does the script tag look like?**

```html
<script type="module" src="____________"></script>
```

**Copy the exact `src="..."` value** and I'll give you the specific fix!

