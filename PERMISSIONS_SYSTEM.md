# Role-Based Access Control System Documentation

This document provides comprehensive information about the implemented role-based access control system using Spatie Laravel Permission.

## Table of Contents

1. [Overview](#overview)
2. [Installation & Setup](#installation--setup)
3. [Configuration](#configuration)
4. [Roles & Permissions](#roles--permissions)
5. [Usage Examples](#usage-examples)
6. [Extending the System](#extending-the-system)
7. [Commands](#commands)
8. [Best Practices](#best-practices)

## Overview

The system implements a comprehensive role-based access control (RBAC) that controls both sidebar menus and action buttons. It uses Spatie Laravel Permission package with custom configuration for dynamic permission management.

### Key Features

- **Menu Permissions**: Control sidebar menu visibility with `menu-{name}` permissions
- **Button Permissions**: Granular control over action buttons with `{menu}-{action}` permissions
- **Dynamic Configuration**: Easy to extend with new menus and buttons
- **Route Protection**: Middleware-based route protection
- **Controller Validation**: Built-in permission checks in controllers
- **Role Management**: Pre-defined roles with specific permission sets

## Installation & Setup

### 1. Package Installation

The Spatie Laravel Permission package has been installed and configured:

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### 2. Model Configuration

The `EnhancedUser` model has been updated to use the `HasRoles` trait:

```php
use Spatie\Permission\Traits\HasRoles;

class EnhancedUser extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;
    // ...
}
```

### 3. Middleware Registration

Permission middleware has been registered in `bootstrap/app.php`:

```php
$middleware->alias([
    'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    'spatie_role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
    // ...
]);
```

## Configuration

### Permission Configuration File

The system uses a configuration file at `config/permissions.php` that defines all menus and their associated buttons:

```php
'menus' => [
    'students' => [
        'label' => 'Students',
        'buttons' => [
            'add' => 'Add Student',
            'edit' => 'Edit Student',
            'delete' => 'Delete Student',
            'view' => 'View Student Details',
            'export' => 'Export Students',
            'import' => 'Import Students',
            'assign-course' => 'Assign Course',
            'manage-grades' => 'Manage Grades',
        ]
    ],
    // ... more menus
],
```

### Database Tables

The system uses custom table names to avoid conflicts:

- `spatie_permissions` - Stores all permissions
- `spatie_roles` - Stores all roles
- `model_has_permissions` - User-permission relationships
- `model_has_roles` - User-role relationships
- `role_has_permissions` - Role-permission relationships

## Roles & Permissions

### Pre-defined Roles

#### Admin Role
- **Description**: Full system access with all permissions
- **Permissions**: All menu and button permissions

#### Teacher Role
- **Menus**: Dashboard, Students, Courses, Exams, Questions, Results
- **Permissions**: Limited to teaching-related functions
- **Example**: Can view/manage students, create exams, manage questions

#### Student Role
- **Menus**: Dashboard, Courses, Exams, Results
- **Permissions**: Very limited, mostly view-only access
- **Example**: Can view courses and their own results

#### Operator Role
- **Menus**: Dashboard, Students, Teachers, Courses, Users, Settings, Reports
- **Permissions**: Administrative functions without full system access
- **Example**: Can manage users and generate reports

### Permission Naming Convention

- **Menu Permissions**: `menu-{menu_name}` (e.g., `menu-students`)
- **Button Permissions**: `{menu_name}-{action}` (e.g., `students-add`, `students-edit`)

## Usage Examples

### 1. Blade Templates - Sidebar Menu

```blade
@can('menu-students')
<a href="{{ route('partner.students.index') }}" class="nav-link">
    <span>Students</span>
</a>
@endcan
```

### 2. Blade Templates - Action Buttons

```blade
@can('students-add')
<a href="{{ route('partner.students.create') }}" class="btn btn-primary">
    Add Student
</a>
@endcan

@can('students-export')
<button type="button" class="btn btn-success">
    Export Students
</button>
@endcan
```

### 3. Controller Permission Checks

```php
public function create()
{
    // Check both menu and button permissions
    if (!auth()->user()->can('menu-students')) {
        abort(403, 'Access denied. You do not have permission to access students.');
    }

    if (!auth()->user()->can('students-add')) {
        abort(403, 'Access denied. You do not have permission to add students.');
    }

    return view('partner.students.create');
}
```

### 4. Route Protection with Middleware

```php
// Protect entire route group with menu permission
Route::middleware(['auth', 'permission:menu-students'])->group(function () {
    
    // Students index
    Route::get('/students', [StudentController::class, 'index'])
        ->name('partner.students.index');
    
    // Create student routes - requires add permission
    Route::middleware(['permission:students-add'])->group(function () {
        Route::get('/students/create', [StudentController::class, 'create'])
            ->name('partner.students.create');
        Route::post('/students', [StudentController::class, 'store'])
            ->name('partner.students.store');
    });
    
    // Delete student - requires delete permission
    Route::middleware(['permission:students-delete'])->group(function () {
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])
            ->name('partner.students.destroy');
    });
});
```

## Extending the System

### Adding New Menus

1. **Update Configuration**: Add new menu to `config/permissions.php`

```php
'menus' => [
    'new_module' => [
        'label' => 'New Module',
        'buttons' => [
            'add' => 'Add Item',
            'edit' => 'Edit Item',
            'delete' => 'Delete Item',
            'view' => 'View Item',
        ]
    ],
    // ... existing menus
],
```

2. **Regenerate Permissions**: Run the seeder to create new permissions

```bash
php artisan db:seed --class=RolePermissionSeeder
```

3. **Update Sidebar**: Add menu item with permission check

```blade
@can('menu-new_module')
<a href="{{ route('partner.new_module.index') }}" class="nav-link">
    New Module
</a>
@endcan
```

### Adding New Buttons to Existing Menus

1. **Update Configuration**: Add buttons to existing menu in `config/permissions.php`
2. **Regenerate Permissions**: Run the seeder
3. **Update Views**: Add button with permission check
4. **Update Routes**: Add route with appropriate middleware
5. **Update Controller**: Add method with permission validation

### Creating Custom Roles

1. **Update Configuration**: Add role to `config/permissions.php`

```php
'roles' => [
    'CustomRole' => [
        'description' => 'Custom role description',
        'permissions' => [
            'menu-students',
            'students-view',
            'students-edit',
            // ... specific permissions
        ]
    ],
    // ... existing roles
],
```

2. **Regenerate Permissions**: Run the seeder to create the role

## Commands

### Seed Permissions and Roles

```bash
php artisan db:seed --class=RolePermissionSeeder
```

### Assign Roles to Existing Users

```bash
# Assign roles based on current role field
php artisan users:assign-roles

# Force reassignment even if users already have roles
php artisan users:assign-roles --force
```

### Clear Permission Cache

```bash
php artisan permission:cache-reset
```

## Best Practices

### 1. Permission Checking Order

Always check permissions in this order:
1. Menu permission (in routes/middleware)
2. Button permission (in controllers/views)

### 2. Controller Validation

Always validate permissions at the beginning of controller methods:

```php
public function store(Request $request)
{
    // Check permissions first
    if (!auth()->user()->can('students-add')) {
        abort(403, 'Access denied.');
    }
    
    // Continue with business logic
    // ...
}
```

### 3. Route Protection

Use middleware to protect routes at the group level:

```php
Route::middleware(['permission:menu-students'])->group(function () {
    // All student-related routes
});
```

### 4. Graceful Degradation

Hide UI elements that users can't access rather than showing disabled buttons:

```blade
@can('students-delete')
    <button class="btn btn-danger">Delete</button>
@endcan
```

### 5. Error Handling

Provide meaningful error messages when access is denied:

```php
if (!auth()->user()->can('students-add')) {
    abort(403, 'You do not have permission to add students. Please contact your administrator.');
}
```

### 6. Testing Permissions

Always test with different user roles to ensure permissions work correctly:

```php
// In tests
$user->assignRole('Teacher');
$this->actingAs($user)
     ->get('/students/create')
     ->assertStatus(200);

$user->removeRole('Teacher');
$this->actingAs($user)
     ->get('/students/create')
     ->assertStatus(403);
```

## Security Considerations

1. **Never rely solely on frontend permission checks** - Always validate in controllers
2. **Use middleware for route protection** - Don't depend only on controller checks
3. **Regularly audit permissions** - Review who has access to what
4. **Log permission denials** - Monitor unauthorized access attempts
5. **Keep permissions granular** - Don't create overly broad permissions

## Troubleshooting

### Permission Not Working

1. Clear permission cache: `php artisan permission:cache-reset`
2. Check if user has the role: `$user->hasRole('RoleName')`
3. Check if role has the permission: `$role->hasPermissionTo('permission-name')`
4. Verify permission exists: `Permission::where('name', 'permission-name')->exists()`

### User Can't See Menu Items

1. Verify user has the correct role assigned
2. Check if role has the menu permission
3. Ensure `@can` directive is used correctly in blade templates
4. Clear view cache: `php artisan view:clear`

### Routes Returning 403

1. Check middleware is applied correctly
2. Verify permission name matches exactly
3. Ensure user is authenticated
4. Check if permission exists in database

---

This documentation should be updated whenever new permissions, roles, or features are added to the system.
