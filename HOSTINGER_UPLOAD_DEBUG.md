# Hostinger Teacher Photo Upload Debug Guide

## Problem
Teacher photos are still uploading to `/public_html/storage/app/public/teachers/photos/` instead of `/public_html/uploads/teachers/` on Hostinger.

## Root Cause
The TeacherController might not be using the updated code or there might be caching issues.

## Solution Steps

### 1. Verify Updated Files on Hostinger
Make sure these files are uploaded to Hostinger with the latest changes:
- `app/Http/Controllers/TeacherController.php`
- `app/Models/Teacher.php`

### 2. Clear Laravel Cache on Hostinger
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 3. Check Upload Directory
```bash
# Create uploads directory if it doesn't exist
mkdir -p public/uploads/teachers
chmod 755 public/uploads/teachers
```

### 4. Test Upload with Debug Logging
The updated TeacherController now includes debug logging. Check the Laravel logs after uploading a teacher photo:

```bash
tail -f storage/logs/laravel.log
```

Look for log entries like:
```
Teacher photo uploaded: {"file":"1234567890_photo.jpg","path":"/path/to/public/uploads/teachers/1234567890_photo.jpg","exists":true}
```

### 5. Manual Verification
After uploading a teacher photo, check:
1. **File Location**: Look in `/public_html/uploads/teachers/` for the new file
2. **Database**: Check the `teachers` table - `photo` column should contain `teachers/filename.jpg`
3. **URL Generation**: The photo URL should be `https://yourdomain.com/uploads/teachers/filename.jpg`

### 6. Force Direct Upload Method
If the issue persists, you can force the upload method by adding this to the TeacherController:

```php
// Force direct upload (add this at the top of store/update methods)
if ($request->hasFile('photo')) {
    $uploadDir = public_path('uploads/teachers/');
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $fileName = time() . '_' . $request->file('photo')->getClientOriginalName();
    $request->file('photo')->move($uploadDir, $fileName);
    $data['photo'] = 'teachers/' . $fileName;
    
    // Skip any other photo handling
    return;
}
```

### 7. Check for Conflicting Code
Search for any remaining references to the old storage method:
```bash
grep -r "store.*teachers.*photos" app/
grep -r "Storage::disk.*public" app/Http/Controllers/TeacherController.php
```

### 8. Environment-Specific Fix
If the issue persists, you can add environment detection:

```php
// In TeacherController store/update methods
if ($request->hasFile('photo')) {
    // Force direct upload for Hostinger
    $uploadDir = public_path('uploads/teachers/');
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $fileName = time() . '_' . $request->file('photo')->getClientOriginalName();
    $request->file('photo')->move($uploadDir, $fileName);
    $data['photo'] = 'teachers/' . $fileName;
    
    \Log::info('FORCED DIRECT UPLOAD', [
        'file' => $fileName,
        'path' => $uploadDir . $fileName,
        'exists' => file_exists($uploadDir . $fileName)
    ]);
}
```

## Expected Behavior After Fix
- ✅ Photos upload to `/public_html/uploads/teachers/`
- ✅ Database stores `teachers/filename.jpg`
- ✅ Photo URLs generate as `https://yourdomain.com/uploads/teachers/filename.jpg`
- ✅ Photos load correctly in all teacher views

## Debug Commands
```bash
# Check if uploads directory exists
ls -la public/uploads/teachers/

# Check recent Laravel logs
tail -n 50 storage/logs/laravel.log

# Check database photo paths
php artisan tinker
>>> App\Models\Teacher::whereNotNull('photo')->get(['full_name', 'photo']);
```
