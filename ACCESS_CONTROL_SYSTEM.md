# Access Control System Documentation

## Overview

The Access Control System provides a comprehensive interface for managing roles and permissions in the application. It allows administrators to create custom roles, assign specific permissions, and control both menu access and button-level actions.

## Features Implemented

### 1. **Access Control Dashboard** (`/partner/access-control`)
- **Visual Role Overview**: Grid layout showing all roles with permission counts
- **Permission Summary**: Grouped permissions by module for each role
- **Quick Actions**: Edit permissions, delete roles (with protection for critical roles)
- **Real-time Updates**: Dynamic permission management with AJAX

### 2. **Role Creation** (`/partner/access-control/create-role`)
- **Dynamic Permission Selection**: Organized by modules with select-all functionality
- **Visual Permission Structure**: Clear categorization of menu and button permissions
- **Validation**: Client-side and server-side validation for role names and permissions
- **Bulk Operations**: Select/deselect all permissions or by module

### 3. **Permission Management**
- **Module-based Organization**: Permissions grouped by functional areas
- **Menu vs Button Permissions**: Clear distinction between navigation and action permissions
- **Real-time Updates**: Instant permission changes without page reload
- **Conflict Prevention**: Protected roles cannot be deleted

## System Architecture

### Controller: `AccessControlController`

**Key Methods:**
- `index()` - Main dashboard with roles and permissions overview
- `createRole()` - Role creation form with permission structure
- `storeRole()` - Create new role with assigned permissions
- `updateRolePermissions()` - Update existing role permissions
- `getRolePermissions()` - Get current role permissions for editing
- `destroyRole()` - Delete role (with protection checks)
- `getPermissionStructure()` - API endpoint for JavaScript permission structure

### Views

#### 1. **Access Control Index** (`partner/access-control/index.blade.php`)
- **Responsive Grid**: Role cards with permission summaries
- **Modal Editor**: In-place permission editing with visual feedback
- **Permission Grouping**: Organized by modules with select-all functionality
- **Real-time Updates**: AJAX-powered permission changes

#### 2. **Role Creation** (`partner/access-control/create-role.blade.php`)
- **Module Organization**: Permissions grouped by functional areas
- **Visual Hierarchy**: Clear distinction between menu and button permissions
- **Bulk Selection**: Module-level and global select/deselect
- **Form Validation**: Real-time validation with error display

### JavaScript Functionality

#### Access Control Manager (`accessControlManager()`)
```javascript
// Key Features:
- loadPermissionStructure() // Load permission configuration
- editRolePermissions() // Open permission editor modal
- updateRolePermissions() // Save permission changes
- deleteRole() // Delete role with confirmation
- toggleModulePermissions() // Bulk permission selection
```

#### Role Creation Manager (`roleCreationManager()`)
```javascript
// Key Features:
- createRole() // Submit new role creation
- selectAllPermissions() // Select all available permissions
- deselectAllPermissions() // Clear all selections
- toggleModulePermissions() // Module-level selection
- isModuleFullySelected() // Check module selection status
```

## Permission Structure

### Menu Permissions
- Format: `menu-{module}` (e.g., `menu-students`, `menu-courses`)
- Controls: Sidebar navigation visibility
- Required: For accessing any module functionality

### Button Permissions
- Format: `{module}-{action}` (e.g., `students-add`, `courses-edit`)
- Controls: Individual action button visibility and functionality
- Granular: Specific to each operation within a module

### Module Organization
```
Dashboard
├── menu-dashboard
├── dashboard-view-stats
└── dashboard-export-data

Students
├── menu-students
├── students-add
├── students-edit
├── students-delete
├── students-view
├── students-export
├── students-import
├── students-assign-course
└── students-manage-grades

[... other modules]
```

## Integration Points

### 1. **Settings Page Integration**
- **Access Control Button**: Direct link to permission management
- **Create Role Button**: Quick access to role creation (permission-protected)
- **Visual Integration**: Consistent styling with existing settings interface

### 2. **Route Protection**
```php
// Example route protection
Route::middleware(['permission:menu-settings'])->group(function () {
    Route::get('/access-control', [AccessControlController::class, 'index']);
    // ... other routes
});
```

### 3. **Blade Template Integration**
```blade
@can('users-manage-roles')
    <a href="{{ route('partner.access-control.create-role') }}">Create Role</a>
@endcan
```

## Security Features

### 1. **Protected Roles**
- Critical roles ('Admin', 'Super Admin') cannot be deleted
- User assignment checks prevent deletion of roles in use
- Permission validation ensures only valid permissions are assigned

### 2. **Access Control**
- Menu permission required for access to settings
- Role management permission required for role operations
- CSRF protection on all form submissions

### 3. **Validation**
- Unique role name validation
- Permission existence validation
- User authorization checks on all operations

## Usage Workflow

### Creating a New Role
1. Navigate to Settings → Access Control
2. Click "Create Role" button
3. Enter role name and description
4. Select permissions by module or individually
5. Submit form to create role

### Editing Role Permissions
1. From Access Control dashboard, click edit icon on role card
2. Permission editor modal opens with current permissions
3. Modify permissions using checkboxes and module toggles
4. Save changes with real-time validation

### Assigning Roles to Users
1. Use existing user management system
2. Roles created through Access Control are available in user forms
3. Users inherit all permissions from assigned roles

## API Endpoints

### Role Management
- `GET /partner/access-control` - Access control dashboard
- `GET /partner/access-control/create-role` - Role creation form
- `POST /partner/access-control/roles` - Create new role
- `PUT /partner/access-control/roles/{role}/permissions` - Update role permissions
- `DELETE /partner/access-control/roles/{role}` - Delete role

### Data APIs
- `GET /partner/access-control/permission-structure` - Get permission configuration
- `GET /partner/access-control/roles/{role}/permissions` - Get role permissions

## Error Handling

### Client-side
- Form validation with real-time feedback
- AJAX error handling with user-friendly messages
- Loading states during operations

### Server-side
- Comprehensive validation rules
- Protected role deletion prevention
- Database transaction safety
- Detailed error logging

## Mobile Responsiveness

### Design Features
- **Mobile-first Approach**: Optimized for touch interfaces
- **Responsive Grid**: Adapts from 1-column (mobile) to 3-column (desktop)
- **Touch-friendly Controls**: Large tap targets and spacing
- **Modal Optimization**: Full-screen modals on mobile devices

### Accessibility
- **Keyboard Navigation**: Full keyboard support
- **Screen Reader Support**: Proper ARIA labels and descriptions
- **Color Contrast**: Meets WCAG guidelines
- **Focus Management**: Clear focus indicators

## Performance Considerations

### Optimization Features
- **AJAX Operations**: No page reloads for permission changes
- **Efficient Queries**: Optimized database queries with eager loading
- **Caching**: Permission structure caching for better performance
- **Batch Operations**: Bulk permission updates

## Future Enhancements

### Planned Features
1. **Permission Templates**: Pre-defined permission sets for common roles
2. **Role Inheritance**: Hierarchical role structures
3. **Audit Logging**: Track permission changes and role assignments
4. **Import/Export**: Backup and restore role configurations
5. **Advanced Filtering**: Search and filter roles by permissions

## Troubleshooting

### Common Issues
1. **Permissions Not Updating**: Clear permission cache
2. **Role Creation Fails**: Check unique name validation
3. **Access Denied**: Verify user has required permissions
4. **JavaScript Errors**: Check browser console for CSRF token issues

### Debug Commands
```bash
# Clear permission cache
php artisan permission:cache-reset

# Check user permissions
php artisan tinker
>>> $user = App\Models\EnhancedUser::find(1);
>>> $user->getAllPermissions();

# Verify role assignments
>>> $user->getRoleNames();
```

---

This Access Control System provides a comprehensive, user-friendly interface for managing the complex permission structure while maintaining security and performance standards.
