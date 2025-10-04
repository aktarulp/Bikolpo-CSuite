<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "CLEANING UP UNUSED PERMISSION TABLES\n";
echo "=====================================\n\n";

// Check current state
echo "1. Current State Check:\n";
$userPermissions = 0;
$modelHasPermissions = 0;

try {
    $userPermissions = DB::table('user_permissions')->count();
    echo "   user_permissions: {$userPermissions} records\n";
} catch (\Exception $e) {
    echo "   user_permissions: Table does not exist\n";
}

try {
    $modelHasPermissions = DB::table('model_has_permissions')->count();
    echo "   model_has_permissions: {$modelHasPermissions} records\n";
} catch (\Exception $e) {
    echo "   model_has_permissions: Table does not exist\n";
}

echo "\n2. Role-Based Permission System Status:\n";
$userRoles = DB::table('user_roles')->count();
$rolePermissions = DB::table('role_permissions')->count();
$permissions = DB::table('permissions')->count();

echo "   user_roles: {$userRoles} records ✅\n";
echo "   role_permissions: {$rolePermissions} records ✅\n";
echo "   permissions: {$permissions} records ✅\n";

echo "\n3. Analysis:\n";
if ($userPermissions === 0 && $modelHasPermissions === 0) {
    echo "   ✅ Both direct permission tables are empty\n";
    echo "   ✅ Safe to remove unused tables\n";
    echo "   ✅ Role-based system is sufficient\n";
} else {
    echo "   ⚠️  Some direct permissions exist\n";
    echo "   ⚠️  Review data before cleanup\n";
}

echo "\n4. Cleanup Plan:\n";
echo "   - Keep: user_roles, role_permissions, permissions\n";
echo "   - Remove: user_permissions, model_has_permissions\n";
echo "   - Update: Remove unused model relationships\n";
echo "   - Result: Clean role-based permission system\n";

echo "\n5. Files to Update:\n";
echo "   - EnhancedUser.php: Remove permissions() relationship\n";
echo "   - EnhancedPermission.php: Remove users() relationship\n";
echo "   - UserRole.php: Keep as is (used for role assignments)\n";

echo "\n✅ ANALYSIS COMPLETE!\n";
echo "Ready to proceed with role-based permission system only.\n";
