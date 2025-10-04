<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\EnhancedUser;
use App\Models\EnhancedRole;
use App\Models\EnhancedPermission;

echo "=== Debug Permission System ===\n\n";

// Get partner user
$user = EnhancedUser::where('role', 'partner')->first();
if (!$user) {
    echo "❌ No partner user found\n";
    exit(1);
}

echo "👤 User: {$user->name} (ID: {$user->id})\n";
echo "📧 Email: {$user->email}\n";
echo "🏷️  Role: {$user->role}\n";
echo "🆔 Role ID: {$user->role_id}\n\n";

// Check user roles relationship
echo "=== User Roles (via relationship) ===\n";
$userRoles = $user->roles;
echo "Count: {$userRoles->count()}\n";
foreach ($userRoles as $role) {
    echo "- {$role->name} (ID: {$role->id}, Display: {$role->display_name})\n";
}

// Check partner role
echo "\n=== Partner Role ===\n";
$partnerRole = EnhancedRole::where('name', 'partner')->first();
if ($partnerRole) {
    echo "✅ Partner role found: {$partnerRole->display_name} (ID: {$partnerRole->id})\n";
    
    // Check role permissions
    echo "\n=== Partner Role Permissions ===\n";
    $rolePermissions = $partnerRole->permissions;
    echo "Count: {$rolePermissions->count()}\n";
    
    $menuPermissions = $rolePermissions->filter(function($perm) {
        return str_starts_with($perm->name, 'menu-');
    });
    echo "Menu permissions: {$menuPermissions->count()}\n";
    
    foreach ($menuPermissions as $perm) {
        echo "- {$perm->name} (ID: {$perm->id})\n";
    }
} else {
    echo "❌ Partner role not found\n";
}

// Check user permissions directly
echo "\n=== User Direct Permissions ===\n";
$userPermissions = $user->permissions;
echo "Count: {$userPermissions->count()}\n";

// Test specific permission
echo "\n=== Testing menu-dashboard Permission ===\n";
$dashboardPerm = EnhancedPermission::where('name', 'menu-dashboard')->first();
if ($dashboardPerm) {
    echo "✅ Permission exists: {$dashboardPerm->name} (ID: {$dashboardPerm->id})\n";
    
    // Check if user has this permission via role
    if ($partnerRole) {
        $roleHasPerm = $partnerRole->permissions->contains('id', $dashboardPerm->id);
        echo "Role has permission: " . ($roleHasPerm ? 'YES' : 'NO') . "\n";
    }
    
    // Check if user has this permission directly
    $userHasPerm = $user->permissions->contains('id', $dashboardPerm->id);
    echo "User has permission directly: " . ($userHasPerm ? 'YES' : 'NO') . "\n";
    
    // Test hasPermission method
    $hasPermMethod = $user->hasPermission('menu-dashboard');
    echo "hasPermission() result: " . ($hasPermMethod ? 'YES' : 'NO') . "\n";
    
    // Test can method
    $canMethod = $user->can('menu-dashboard');
    echo "can() result: " . ($canMethod ? 'YES' : 'NO') . "\n";
} else {
    echo "❌ menu-dashboard permission not found\n";
}
