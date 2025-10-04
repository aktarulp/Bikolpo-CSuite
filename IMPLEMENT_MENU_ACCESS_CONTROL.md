# Implement Menu-Based Access Control - Step by Step

## ✅ Files Created

1. **`app/Services/MenuPermissionService.php`** - Core service for checking menu permissions
2. **`app/Providers/MenuServiceProvider.php`** - Service provider with Blade directives
3. **`database/seeders/MenuPermissionsSeeder.php`** - Seeds menu permissions
4. **`MENU_LAYOUT_EXAMPLE.blade.php`** - Examples of how to use in views

## 📋 Implementation Steps

### Step 1: Register the Service Provider

Add to `config/app.php`:

```php
'providers' => [
    // ... other providers
    App\Providers\MenuServiceProvider::class,
],
```

OR add to `bootstrap/providers.php`:

```php
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\MenuServiceProvider::class, // Add this
];
```

### Step 2: Run the Seeder

```bash
php artisan db:seed --class=MenuPermissionsSeeder
```

This will:
- Create menu permissions (menu-dashboard, menu-students, etc.)
- Assign all menu permissions to Partner role

### Step 3: Update Your Layout Files

Open `resources/views/layouts/partner-layout.blade.php` and wrap menu items:

**Before:**
```blade
<a href="{{ route('partner.students.index') }}">
    Students
</a>
```

**After:**
```blade
@canAccessMenu('students')
<a href="{{ route('partner.students.index') }}">
    Students
</a>
@endcanAccessMenu
```

### Step 4: Assign Permissions to Roles

Use the Access Control page or run SQL:

```sql
-- Example: Give Teacher role access to specific menus
INSERT INTO role_permissions (role_id, permission_id)
SELECT 
    (SELECT id FROM roles WHERE name = 'teacher'),
    id
FROM permissions
WHERE name IN ('menu-dashboard', 'menu-students', 'menu-courses', 'menu-exams');

-- Example: Give Student role limited access
INSERT INTO role_permissions (role_id, permission_id)
SELECT 
    (SELECT id FROM roles WHERE name = 'student'),
    id
FROM permissions
WHERE name IN ('menu-dashboard', 'menu-exams', 'menu-results');
```

## 🎯 Usage Examples

### Basic Menu Check
```blade
@canAccessMenu('dashboard')
    <a href="{{ route('partner.dashboard') }}">Dashboard</a>
@endcanAccessMenu
```

### Check Multiple Menus (OR condition)
```blade
@canAccessAnyMenu('settings', 'users', 'access-control')
    <a href="{{ route('partner.settings.index') }}">Settings</a>
@endcanAccessAnyMenu
```

### In Controller
```php
use App\Services\MenuPermissionService;

public function index(MenuPermissionService $menuService)
{
    if (!$menuService->canAccessMenu('students')) {
        abort(403, 'Access denied');
    }
    
    // ... your code
}
```

### Get All Accessible Menus
```php
$menuService = app(MenuPermissionService::class);
$accessibleMenus = $menuService->getAccessibleMenus();
// Returns: ['dashboard', 'students', 'teachers', ...]
```

### Clear Cache After Permission Changes
```php
$menuService = app(MenuPermissionService::class);
$menuService->clearUserCache($userId);
```

## 🔧 Menu Permissions List

The seeder creates these permissions:

- `menu-dashboard` - Dashboard
- `menu-students` - Students management
- `menu-teachers` - Teachers management
- `menu-courses` - Courses management
- `menu-subjects` - Subjects management
- `menu-topics` - Topics management
- `menu-batches` - Batches management
- `menu-questions` - Questions bank
- `menu-exams` - Exams management
- `menu-results` - Results viewing
- `menu-analytics` - Analytics dashboard
- `menu-reports` - Reports
- `menu-sms` - SMS management
- `menu-settings` - Settings
- `menu-users` - User management
- `menu-access-control` - Access control

## 🎨 Recommended Role Permissions

### Partner (Full Access)
All menu permissions

### Teacher
- menu-dashboard
- menu-students
- menu-courses
- menu-subjects
- menu-topics
- menu-questions
- menu-exams
- menu-results

### Student
- menu-dashboard
- menu-exams
- menu-results

## 🚀 Testing

1. **Seed permissions:**
   ```bash
   php artisan db:seed --class=MenuPermissionsSeeder
   ```

2. **Check database:**
   ```sql
   SELECT * FROM permissions WHERE name LIKE 'menu-%';
   SELECT * FROM role_permissions WHERE permission_id IN (SELECT id FROM permissions WHERE name LIKE 'menu-%');
   ```

3. **Test in browser:**
   - Login as Partner → Should see all menus
   - Login as Teacher → Should see limited menus
   - Login as Student → Should see minimal menus

4. **Clear cache if needed:**
   ```bash
   php artisan cache:clear
   ```

## ✅ Benefits

- ✅ Dynamic menu visibility based on permissions
- ✅ Cached for performance (1 hour cache)
- ✅ Easy to use Blade directives
- ✅ Centralized permission management
- ✅ Role-based access control
- ✅ Flexible and extensible

## 📝 Notes

- Permissions are cached for 1 hour per user
- Cache is automatically cleared when permissions change
- Use `@canAccessMenu` for single menu checks
- Use `@canAccessAnyMenu` for multiple menu checks (OR logic)
- All menu permissions follow `menu-{name}` pattern

## Status: ✅ READY TO IMPLEMENT

All files created. Follow the steps above to activate the menu-based access control system!
