# ⚡ Quick Deploy Commands

## 📤 Push to GitHub (First Time)

```bash
# 1. Build assets
npm run build

# 2. Stage all changes
git add .

# 3. Commit
git commit -m "Restructure for Hostinger - Production ready"

# 4. Push to GitHub
git push origin main
```

---

## 🚀 Deploy to Hostinger (Via SSH)

```bash
# Navigate to web root
cd /home/username/public_html

# Clone (first time only)
git clone https://github.com/yourusername/BikolpoLive.git temp
mv temp/* .
mv temp/.htaccess .
mv temp/.gitignore .
rm -rf temp

# Create .env file
nano .env
# Paste your production config, then Ctrl+X, Y, Enter

# Set permissions
chmod -R 775 uploads storage bootstrap/cache
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

---

## 🔄 Update Deployment (After Changes)

### On Local Machine
```bash
npm run build
git add .
git commit -m "Your update message"
git push origin main
```

### On Hostinger
```bash
cd /home/username/public_html
git pull origin main
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📁 If No SSH (File Manager Only)

1. Go to GitHub → Your repository → **Code** → **Download ZIP**
2. Upload ZIP to Hostinger File Manager
3. Extract to a temporary folder
4. Move contents to `public_html/`
5. Create `.env` file manually
6. Set folder permissions to **775** for: `uploads`, `storage`, `bootstrap/cache`
7. Set file permissions to **644** for `.env`

---

## 🔐 Production .env Template

```env
APP_NAME="BikolpoLive"
APP_ENV=production
APP_KEY=base64:YOUR_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

# Generate key with: php artisan key:generate
```

---

## ✅ Deployment Checklist

After deploying:

- [ ] `.env` file created with production values
- [ ] Permissions set (775 for folders, 644 for files)
- [ ] `php artisan storage:setup-uploads` run
- [ ] Caches built (`config:cache`, `route:cache`, `view:cache`)
- [ ] Database migrated
- [ ] Test homepage loads
- [ ] Test file uploads work
- [ ] Test all major routes

---

## 🆘 Troubleshooting

### 500 Error
```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear all caches
php artisan optimize:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### File Upload Not Working
```bash
# Check permissions
ls -la uploads
ls -la storage

# Fix permissions
chmod -R 775 uploads storage bootstrap/cache
```

### .htaccess Not Working
- Make sure `.htaccess` is in `public_html/` (root)
- Enable mod_rewrite in cPanel
- Check Apache config allows `.htaccess`

---

**Your project is ready for seamless GitHub → Hostinger deployment!** 🚀

