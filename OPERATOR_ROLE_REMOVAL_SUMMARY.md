# Operator Role Removal - Impact Analysis

## Files That Reference "Operator" Role

### 1. **Controllers**

#### `app/Http/Controllers/OperatorDashboardController.php`
- **Status**: Can be DELETED (entire file)
- **Purpose**: Handles operator dashboard
- **Action**: Delete this file as operators no longer exist

#### `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
- **Lines**: 63-64, 98-100
- **Purpose**: Redirects to operator dashboard after login
- **Action**: Remove operator redirect logic
- **Impact**: Users with operator role will fail to login

#### `app/Http/Controllers/UserManagementController.php`
- **Line**: 138
- **Purpose**: Validates user_type includes 'operator'
- **Action**: Change validation to: `'user_type' => 'required|in:teacher,student'`
- **Impact**: Cannot create users with operator type

### 2. **Models**

#### `app/Models/User.php`
- **Lines**: 191-199, 211-212, 219-220, 238-240, 279, 303-307
- **Purpose**: Various operator role checks
- **Action**: Remove `isOperatorRole()` method and all operator references
- **Impact**: Role checking logic simplified

#### `app/Models/Role.php`
- **Line**: 158-159
- **Purpose**: Partner admin can manage operator roles
- **Action**: Update comment to remove operator reference
- **Impact**: Documentation only

### 3. **Middleware**

#### `app/Http/Middleware/CheckRole.php`
- **Lines**: 37-39, 65-66
- **Purpose**: Role matching and redirect for operators
- **Action**: Remove operator role variations and redirect logic
- **Impact**: Operator role checks removed

### 4. **Views**

#### `resources/views/operator/dashboard.blade.php`
- **Status**: Can be DELETED (entire file)
- **Purpose**: Operator dashboard view
- **Action**: Delete this file

#### `resources/views/layouts/operator-layout.blade.php`
- **Status**: Can be DELETED (entire file)
- **Purpose**: Operator layout
- **Action**: Delete this file

#### `resources/views/partner/settings/create-user.blade.php`
- **Lines**: 87-88, 424, 529, 611
- **Purpose**: Default user type fallback to 'operator'
- **Action**: Change default to 'teacher' or remove fallback
- **Impact**: Form behavior changes

#### `resources/views/auth/login.blade.php`
- **Line**: 260
- **Purpose**: Comment mentioning operator
- **Action**: Remove operator from comment
- **Impact**: Documentation only

### 5. **Config**

#### `config/permissions.php`
- **Lines**: 216-220
- **Purpose**: Operator role permissions definition
- **Action**: Remove entire Operator section
- **Impact**: Permission seeding will skip operator

### 6. **Commands**

#### `app/Console/Commands/AssignRolesToUsers.php`
- **Lines**: 120-121
- **Purpose**: Maps operator/staff to Operator role
- **Action**: Remove operator and staff mappings
- **Impact**: Migration command won't assign operator role

### 7. **Routes**

#### `routes/web.php`
- **Search for**: `operator.dashboard` route
- **Action**: Remove operator routes if they exist
- **Impact**: Operator routes will 404

## Recommended Actions

### Priority 1: Critical (Breaks Login)
1. ✅ Update `AuthenticatedSessionController` - Remove operator redirects
2. ✅ Update `CheckRole` middleware - Remove operator role checks
3. ✅ Update `UserManagementController` - Remove operator from validation

### Priority 2: Cleanup (Remove Dead Code)
4. ✅ Delete `OperatorDashboardController.php`
5. ✅ Delete `resources/views/operator/` directory
6. ✅ Delete `resources/views/layouts/operator-layout.blade.php`
7. ✅ Remove operator from `config/permissions.php`

### Priority 3: Model Cleanup
8. ✅ Remove `isOperatorRole()` from User model
9. ✅ Remove operator references from User model methods
10. ✅ Update Role model comments

### Priority 4: View Updates
11. ✅ Update `create-user.blade.php` - Change default from operator
12. ✅ Update login view comment

### Priority 5: Command Updates
13. ✅ Update `AssignRolesToUsers` command

## Database Cleanup

After code changes, you should also:

```sql
-- Check if any users still have operator role
SELECT COUNT(*) FROM users WHERE role = 'operator';

-- If none, you can delete the operator role
DELETE FROM roles WHERE name = 'operator';

-- Check role_permissions
DELETE FROM role_permissions WHERE role_id = (SELECT id FROM roles WHERE name = 'operator');
```

## Testing After Removal

1. ✅ Test login with different roles (partner, teacher, student)
2. ✅ Test user creation form
3. ✅ Verify no 404 errors for operator routes
4. ✅ Check that role dropdowns don't show operator
5. ✅ Verify permission system works without operator

## Status: 📋 READY FOR IMPLEMENTATION

All operator references have been identified and documented. Follow the priority order above to safely remove the operator role from the system.
