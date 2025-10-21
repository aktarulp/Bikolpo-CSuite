# Storage Directory

This directory is used by Laravel for file storage, logs, and cached data.

## Structure

```
storage/
├── app/           - Application files
│   ├── private/   - Private files (not web accessible)
│   └── public/    - Public files (should be linked to public/storage)
├── framework/     - Framework cache and compiled files
│   ├── cache/     - Application cache
│   ├── sessions/  - Session files (if using file driver)
│   ├── testing/   - Testing cache
│   └── views/     - Compiled Blade views
└── logs/          - Application logs
```

## Permissions

This directory must be writable by the web server:

```bash
# Set on deployment
chmod -R 775 storage
chmod -R 664 storage/logs/*.log
```

## Deployment Note

- **Directory structure is committed to Git**
- **Contents (logs, cache, session files) are NOT committed**
- Each subdirectory has a `.gitignore` file to preserve structure

## On Hostinger

After deployment, ensure permissions are correct:

```bash
cd /home/username/public_html
chmod -R 775 storage bootstrap/cache uploads
```

