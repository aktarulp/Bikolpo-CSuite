# Hostinger Photo Loading Fix Guide

## Problem
Teacher photos load correctly in local environment but not on Hostinger hosting.

## Root Causes
1. **Hostinger Shared Hosting Limitation**: Hostinger shared hosting doesn't support symbolic links (`storage:link`)
2. **URL Generation Inconsistency**: Different views use different methods to generate photo URLs
3. **File Access Issues**: Photos stored in `storage/app/public` are not accessible without symbolic links
4. **Environment Detection**: Application needs to detect shared hosting and use alternative file paths

## Solutions Applied

### 1. Shared Hosting Detection & Dual Storage
- **Added**: Automatic detection of shared hosting (no symbolic links)
- **Implemented**: Dual file storage - saves to both `storage/app/public` and `public/uploads/teachers`
- **Result**: Photos work on both local (with symbolic links) and shared hosting (without links)

### 2. Smart URL Generation
- **Updated**: Teacher model automatically detects environment and uses appropriate URL
- **Local Environment**: Uses `asset('storage/')` when symbolic link exists
- **Shared Hosting**: Uses `asset('uploads/teachers/')` when no symbolic link
- **Result**: Seamless photo loading across all environments

## Steps to Fix on Hostinger

### Step 1: Upload Modified Files
Upload the updated files to your Hostinger server:
- `app/Models/Teacher.php`
- `app/Http/Controllers/TeacherController.php`
- `resources/views/partner/teachers/index.blade.php`

### Step 2: Create Uploads Directory
```bash
# Create the uploads directory for photos
mkdir -p public/uploads/teachers
chmod 755 public/uploads/teachers
```

### Step 3: Set File Permissions
```bash
# Set correct permissions for storage and uploads directories
chmod -R 755 storage/
chmod -R 755 public/uploads/
```

### Step 4: Verify Environment Configuration
Check your `.env` file on Hostinger:
```env
APP_URL=https://yourdomain.com
FILESYSTEM_DISK=public
```

### Step 5: Test Photo Upload
1. Create a new teacher with a photo
2. Check if photo appears in both locations:
   - `storage/app/public/teachers/photos/`
   - `public/uploads/teachers/`

### Step 6: Migrate Existing Photos (if any)
If you have existing teacher photos, copy them to the uploads directory:
```bash
# Copy existing photos to public/uploads/teachers/
cp storage/app/public/teachers/photos/* public/uploads/teachers/
```

## Files Modified

### 1. `app/Models/Teacher.php`
- **Smart URL Detection**: Automatically detects if symbolic link exists
- **Dual Path Support**: Uses `storage/` for local, `uploads/teachers/` for shared hosting
- **Fallback Handling**: Graceful fallback to default avatar if photo missing

### 2. `app/Http/Controllers/TeacherController.php`
- **Dual Storage**: Saves photos to both `storage/app/public` and `public/uploads/teachers`
- **Environment Detection**: Only copies to public/uploads on shared hosting
- **Cleanup**: Properly deletes old photos from both locations

### 3. `resources/views/partner/teachers/index.blade.php`
- **Consistent Usage**: Uses `{{ $teacher->photo_url }}` for all photo displays
- **Error Handling**: Includes `onerror` fallback for missing images

## Testing

### Local Testing
1. Clear cache: `php artisan cache:clear`
2. Clear config: `php artisan config:clear`
3. Test photo loading in all teacher views

### Hostinger Testing
1. Upload modified files
2. Run `php artisan storage:link`
3. Set correct permissions
4. Test photo loading
5. Run diagnostic script if issues persist

## How It Works

### Automatic Environment Detection
The system automatically detects the hosting environment:

```php
// In Teacher model
if (!is_link(public_path('storage'))) {
    // Shared hosting - use public/uploads
    return asset('uploads/teachers/' . basename($this->photo));
} else {
    // Local/VPS with symbolic links - use storage
    return asset('storage/' . $this->photo);
}
```

### Dual File Storage
When uploading photos, the system:
1. **Always saves** to `storage/app/public/teachers/photos/` (Laravel standard)
2. **Conditionally copies** to `public/uploads/teachers/` (for shared hosting)
3. **Detects environment** by checking if symbolic link exists

### URL Generation Logic
- **Local Development**: Uses `asset('storage/')` (with symbolic link)
- **Shared Hosting**: Uses `asset('uploads/teachers/')` (direct file access)
- **Fallback**: Uses default avatar if photo missing

## Verification Steps

1. **Check Storage Link**: Verify `public/storage` points to `storage/app/public`
2. **Test File Access**: Try accessing a photo URL directly in browser
3. **Check Permissions**: Ensure files are readable by web server
4. **Verify URLs**: Check that generated URLs are correct

## Fallback Solution

If all else fails, you can use the fallback method in the Teacher model:
```php
// In your view, use:
{{ $teacher->getPhotoUrlWithFallback() }}
```

This method tries multiple URL generation approaches to find one that works in your environment.

## Debug Information

The `debug_photos.php` script will provide detailed information about:
- Storage configuration
- File permissions
- URL generation
- File existence
- Storage link status

Run this script on Hostinger to identify the specific issue.
