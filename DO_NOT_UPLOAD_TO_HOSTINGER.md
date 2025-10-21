# ❌ DO NOT Upload These to Hostinger

## 📋 Complete List of Files/Folders to EXCLUDE

### 🚫 Folders to EXCLUDE

```
❌ node_modules/          - Dev dependencies (HUGE, not needed)
❌ tests/                  - Test files (not needed in production)
❌ .vite/                  - Vite cache (build artifacts)
❌ docs/                   - Documentation files
❌ .git/                   - Git version control
```

### 🚫 Files to EXCLUDE

```
❌ .env                    - Create separately on server with production values
❌ .env - Copy.example     - Example file only
❌ .gitignore              - Git config
❌ .gitattributes          - Git config
❌ .editorconfig           - Editor config
❌ package.json            - NPM dependencies (not needed, already built)
❌ package-lock.json       - NPM lock file
❌ composer.json           - Optional (but harmless to include)
❌ composer.lock           - Optional (but harmless to include)
❌ postcss.config.js       - Build config (not needed)
❌ tailwind.config.js      - Build config (not needed)
❌ vite.config.js          - Build config (not needed)
```

---

## ✅ MUST Upload These

### ✅ Folders to UPLOAD

```
✅ app/                    - Laravel application code
✅ bootstrap/              - Laravel bootstrap
✅ ckeditor/               - CKEditor (if in root, or in public/)
✅ config/                 - Configuration files
✅ css/                    - Static CSS files
✅ database/               - Migrations and seeders
✅ fonts/                  - Font files
✅ images/                 - Static images
✅ js/                     - Static JavaScript
✅ public/                 - Public files (build/, index.php, .htaccess)
✅ resources/              - Views and source files
✅ routes/                 - Route definitions
✅ storage/                - Logs, cache, sessions (with proper permissions)
✅ uploads/                - User uploaded files directory
✅ vendor/                 - Composer dependencies (PHP packages)
```

### ✅ Files to UPLOAD

```
✅ .htaccess               - Security and URL rewriting (IMPORTANT!)
✅ index.php               - Application entry point (REQUIRED!)
✅ artisan                 - Laravel CLI
✅ robots.txt              - SEO
✅ sitemap.xml             - SEO
```

---

## 📊 Size Comparison

**If you include everything:** ~500-800 MB  
**If you exclude properly:** ~50-100 MB (5-10x smaller!)

**Biggest space savers:**
- `node_modules/` alone can be 200-500 MB!
- `.git/` can be 50-100 MB

---

## 🎯 Quick Upload Checklist

Before uploading, run these commands:

### 1. Build Assets
```bash
npm run build
```

### 2. Install Production Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### 3. Clean Up (Optional)
```bash
# Remove development files
Remove-Item -Path "node_modules" -Recurse -Force
Remove-Item -Path "tests" -Recurse -Force
Remove-Item -Path ".git" -Recurse -Force
Remove-Item -Path "docs" -Recurse -Force
```

---

## 📦 Recommended Upload Methods

### Method 1: Selective FTP Upload

**Upload these folders:**
- app, bootstrap, config, database, public, resources, routes, storage, uploads, vendor
- css, fonts, images, js (if in root)
- ckeditor (if exists)

**Upload these files:**
- .htaccess, index.php, artisan, robots.txt, sitemap.xml

**Skip everything else!**

### Method 2: Zip and Upload (Fastest)

Create a deployment package:

```powershell
# Create deployment folder
New-Item -ItemType Directory -Force -Path "deploy"

# Copy required files
$folders = @('app','bootstrap','config','database','public','resources','routes','storage','uploads','vendor','css','fonts','images','js')
foreach($f in $folders) {
    Copy-Item -Path $f -Destination "deploy\$f" -Recurse -Force
}

# Copy required files
Copy-Item -Path ".htaccess","index.php","artisan","robots.txt","sitemap.xml" -Destination "deploy\"

# Zip it
Compress-Archive -Path "deploy\*" -DestinationPath "hostinger-deploy.zip"
```

Then:
1. Upload `hostinger-deploy.zip` to Hostinger
2. Extract via File Manager
3. Move contents to `public_html/`
4. Delete zip file

---

## ⚠️ Special Notes

### .env File
**DO NOT upload your local .env!**

Instead:
1. Create new `.env` on Hostinger
2. Copy contents from `.env - Copy.example`
3. Update with production values:
   - Database credentials
   - APP_URL
   - APP_ENV=production
   - APP_DEBUG=false

### Storage Folder
Upload the folder structure, but files inside will be generated:
- `storage/framework/` (cache, sessions, views)
- `storage/logs/` (log files)

Set permissions: `chmod -R 775 storage`

### Vendor Folder
**MUST upload!** Contains all PHP dependencies.

If you skip it, you'll need to run `composer install` on the server (which may not be available on shared hosting).

---

## 🎉 Final Summary

### ❌ Never Upload (Save 500+ MB)
- node_modules/, tests/, .git/, docs/, .vite/
- .env, package files, config files (.gitignore, etc.)

### ✅ Always Upload
- All Laravel folders (app, bootstrap, config, etc.)
- All public assets (css, fonts, images, js)
- Entry files (.htaccess, index.php)
- Dependencies (vendor/)

**Upload size:** ~50-100 MB (fast upload!)

---

**Ready to deploy? Just exclude the files listed above!** 🚀

