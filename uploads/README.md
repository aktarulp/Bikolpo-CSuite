# Uploads Directory

This directory stores all uploaded files (images, documents, etc.) directly in the public folder.

## Directory Structure

- `student-photos/` - Student profile photos
- `questions/` - Question images
- `partners/` - Partner logos

## Why This Approach?

This configuration is designed for shared hosting environments (like Hostinger) where symbolic links are not supported. By storing files directly in the `public/uploads` directory, they are immediately accessible via `/uploads/` URLs without requiring `php artisan storage:link`.

## Auto-Setup

The subdirectories will be automatically created when files are uploaded through the application.

