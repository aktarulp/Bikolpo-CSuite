<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\EnhancedUser;
use App\Models\EnhancedRole;
use Illuminate\Support\Facades\DB;

echo "=== Fixing User-Role Assignment ===\n\n";

// Get partner user
$user = EnhancedUser::where('role', 'partner')->first();
if (!$user) {
    echo "❌ No partner user found\n";
    exit(1);
}

echo "👤 User: {$user->name} (ID: {$user->id})\n";
echo "🏷️  Role field: {$user->role}\n";

// Get partner role
$partnerRole = EnhancedRole::where('name', 'partner')->first();
if (!$partnerRole) {
    echo "❌ Partner role not found\n";
    exit(1);
}

echo "🎭 Partner role: {$partnerRole->display_name} (ID: {$partnerRole->id})\n\n";

// Check if user is already assigned to the role
$existingAssignment = DB::table('user_roles')
    ->where('user_id', $user->id)
    ->where('role_id', $partnerRole->id)
    ->first();

if ($existingAssignment) {
    echo "✅ User is already assigned to partner role\n";
} else {
    echo "⚠️  User is NOT assigned to partner role. Fixing...\n";
    
    // Assign user to partner role
    DB::table('user_roles')->insert([
        'user_id' => $user->id,
        'role_id' => $partnerRole->id,
        'assigned_by' => 1,
        'assigned_at' => now(),
        'created_at' => now(),
        'updated_at' => now()
    ]);
    
    echo "✅ User assigned to partner role\n";
}

// Update user's role_id field
if ($user->role_id != $partnerRole->id) {
    echo "⚠️  User's role_id field is incorrect. Fixing...\n";
    $user->update(['role_id' => $partnerRole->id]);
    echo "✅ User's role_id field updated\n";
}

echo "\n=== Verification ===\n";

// Refresh user model
$user = $user->fresh();

// Check user roles via relationship
$userRoles = $user->roles;
echo "User roles count: {$userRoles->count()}\n";
foreach ($userRoles as $role) {
    echo "- {$role->name} (ID: {$role->id})\n";
}

// Check if partner role has permissions
$rolePermissions = $partnerRole->permissions;
echo "\nPartner role permissions count: {$rolePermissions->count()}\n";

$menuPermissions = $rolePermissions->filter(function($perm) {
    return str_starts_with($perm->name, 'menu-');
});
echo "Menu permissions count: {$menuPermissions->count()}\n";

// Test permission check
echo "\n=== Testing Permission Check ===\n";
$testPermission = 'menu-dashboard';
$hasPermission = $user->hasPermission($testPermission);
echo "User hasPermission('{$testPermission}'): " . ($hasPermission ? 'YES' : 'NO') . "\n";

$canPermission = $user->can($testPermission);
echo "User can('{$testPermission}'): " . ($canPermission ? 'YES' : 'NO') . "\n";

echo "\n🎉 User-role assignment fix completed!\n";
