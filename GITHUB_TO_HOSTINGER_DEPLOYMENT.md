# 🚀 Deploy from GitHub to Hostinger

## ✅ Git Configuration Complete!

Your `.gitignore` has been updated to only include **deployment-ready files**.

---

## 📊 What Gets Pushed to GitHub

### ✅ Included in Git (Will Deploy)

```
✅ app/                    - Application code
✅ bootstrap/              - Laravel bootstrap
✅ ckeditor/               - CKEditor
✅ config/                 - Configuration
✅ css/                    - Static CSS
✅ database/               - Migrations & seeders
✅ fonts/                  - Fonts
✅ images/                 - Static images
✅ js/                     - Static JS
✅ public/                 - Public files
✅ public/build/           - Built assets (COMMITTED for easy deploy!)
✅ resources/              - Views
✅ routes/                 - Routes
✅ storage/ (structure)    - Folder structure only
✅ uploads/ (structure)    - Folder structure only
✅ vendor/                 - PHP dependencies (COMMITTED for shared hosting!)
✅ .htaccess               - Security & routing
✅ index.php               - Entry point
✅ artisan                 - Laravel CLI
✅ composer.json           - Dependency definition
✅ composer.lock           - Dependency lock
```

### ❌ Excluded from Git (Not Pushed)

```
❌ node_modules/           - Dev dependencies (too large)
❌ .vite/                  - Build cache
❌ .env                    - Environment config (create on server)
❌ storage/logs/*          - Log files
❌ storage/framework/*     - Cache files
❌ uploads/*               - User uploaded files
❌ .idea/, .vscode/        - IDE config
```

---

## 🎯 Key Strategy

**We're committing `vendor/` and `public/build/`** because:
1. ✅ Hostinger shared hosting may not have Composer access
2. ✅ No need to run `composer install` on server
3. ✅ No need to run `npm run build` on server
4. ✅ Just pull from Git and it works!

---

## 📋 Step-by-Step Deployment

### Step 1: Prepare for First Push

```bash
# Build assets locally
npm run build

# Install production dependencies
composer install --no-dev --optimize-autoloader

# Add all files
git add .

# Commit
git commit -m "Initial commit - Production ready"

# Push to GitHub
git push origin main
```

### Step 2: On Hostinger (First Time Setup)

#### Option A: Via SSH (if available)

```bash
# Navigate to web root
cd /home/username/public_html

# Clone repository
git clone https://github.com/yourusername/BikolpoLive.git temp
mv temp/* .
mv temp/.htaccess .
rm -rf temp

# Create .env file
nano .env
# (Paste production environment config)

# Set permissions
chmod -R 775 uploads
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod 644 .env

# Setup uploads
php artisan storage:setup-uploads

# Cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force
```

#### Option B: Via File Manager (no SSH)

1. **Download repository** from GitHub as ZIP
2. **Upload ZIP** to Hostinger File Manager
3. **Extract** to temporary folder
4. **Move contents** to `public_html/`
5. **Delete** temporary folder and ZIP
6. **Create `.env`** file via File Manager
7. **Set permissions** via File Manager (775 for folders, 644 for files)

### Step 3: Future Updates

When you make changes:

```bash
# Local: Make changes, test, then:
npm run build                          # Rebuild assets
git add .
git commit -m "Update: description"
git push origin main

# Hostinger: Pull changes
cd /home/username/public_html
git pull origin main

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔐 Environment Variables (.env)

**NEVER commit `.env` to Git!** Create it on Hostinger with production values:

```env
APP_NAME="BikolpoLive"
APP_ENV=production
APP_KEY=base64:YOUR_PRODUCTION_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_production_database
DB_USERNAME=your_production_username
DB_PASSWORD=your_production_password

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

# Other production settings...
```

---

## 📁 Directory Permissions on Hostinger

After cloning, set these permissions:

```bash
# Make writable
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 775 uploads

# Make .env secure
chmod 644 .env

# Verify .htaccess exists
ls -la .htaccess
```

---

## 🔄 Deployment Workflow

### Local Development Flow

```bash
# 1. Make changes locally
# 2. Test on Laragon (http://bikolpolive.test)
# 3. Build assets
npm run build

# 4. Commit and push
git add .
git commit -m "Feature: your changes"
git push origin main
```

### Production Update Flow

```bash
# SSH into Hostinger
cd /home/username/public_html

# Pull latest changes
git pull origin main

# Clear and cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# If database changes
php artisan migrate --force
```

---

## ⚡ Quick Deploy Commands

Save these for easy deployment:

### Initial Setup
```bash
git clone https://github.com/yourusername/BikolpoLive.git .
cp .env.example .env
nano .env  # Edit with production values
chmod -R 775 storage bootstrap/cache uploads
php artisan storage:setup-uploads
php artisan config:cache
php artisan migrate --force
```

### Update Deployment
```bash
git pull origin main
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🎯 Git Best Practices

### Before Each Push

```bash
# 1. Rebuild assets
npm run build

# 2. Test locally
php artisan serve  # or use Laragon

# 3. Check what's changed
git status

# 4. Review changes
git diff

# 5. Commit with clear message
git commit -m "Clear description of changes"

# 6. Push
git push origin main
```

### Commit Message Examples

```bash
git commit -m "Feature: Add student bulk upload"
git commit -m "Fix: Image upload permission issue"
git commit -m "Update: Partner dashboard UI"
git commit -m "Security: Update .htaccess rules"
```

---

## 🆘 Troubleshooting

### Issue: Git Pull Fails (Modified Files)

```bash
# Stash local changes
git stash

# Pull
git pull origin main

# Reapply if needed
git stash pop
```

### Issue: Vendor Folder Too Large

If GitHub rejects due to size:

**Option 1:** Use `.gitattributes` for Git LFS
**Option 2:** Exclude vendor, run composer on server:

```bash
# On Hostinger
composer install --no-dev --optimize-autoloader
```

### Issue: Public/Build Missing

```bash
# Rebuild locally
npm run build

# Commit
git add public/build
git commit -m "Add built assets"
git push
```

---

## 📊 Repository Size

**Expected size:** ~50-80 MB

**Breakdown:**
- vendor/: ~40 MB (Laravel + packages)
- public/build/: ~3 MB (CSS/JS/fonts)
- ckeditor/: ~4 MB
- Everything else: ~10 MB

---

## ✅ Verification Checklist

After deployment to Hostinger:

- [ ] Repository cloned successfully
- [ ] `.env` file created with production values
- [ ] Permissions set (775 for storage, uploads, bootstrap/cache)
- [ ] `php artisan storage:setup-uploads` run
- [ ] Caches cleared and rebuilt
- [ ] Database migrated
- [ ] Homepage loads (https://yourdomain.com)
- [ ] Assets load correctly (CSS/JS)
- [ ] File uploads work
- [ ] All routes work

---

## 🎉 Benefits of This Setup

✅ **Fast deployment** - Just `git pull` and clear cache  
✅ **No build steps** on server - Already built locally  
✅ **No Composer** needed on server - vendor/ committed  
✅ **Version controlled** - Track all changes  
✅ **Easy rollback** - `git reset` or `git checkout`  
✅ **Team ready** - Others can deploy same way  

---

**Your Git is now configured for seamless GitHub → Hostinger deployment!** 🚀

