# Uploads Directory

This directory stores all user-uploaded files.

## Structure

- **Not tracked by Git** - Only this README and .gitignore are committed
- **Auto-created subdirectories** by Laravel application

## Subdirectories Created by Application

When the application runs, these subdirectories will be created:

- `student-photos/` - Student profile photos
- `questions/` - Question images/attachments  
- `partners/` - Partner-related uploads

## Permissions

This directory must be writable by the web server:

```bash
# Set on deployment
chmod -R 775 uploads
```

## Deployment

On Hostinger, run:

```bash
php artisan storage:setup-uploads
```

This will automatically create all required subdirectories with correct permissions.
