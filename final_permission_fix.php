<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\EnhancedUser;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

echo "=== Final Permission Fix ===\n";

// Step 1: Get the user
$user = EnhancedUser::first();
echo "User: {$user->name} (ID: {$user->id})\n";
echo "Current role field: {$user->role}\n";

// Step 2: Clear all caches
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
echo "✓ Cleared permission cache\n";

// Step 3: Check Partner role
$partnerRole = Role::where('name', 'Partner')->first();
if (!$partnerRole) {
    echo "❌ Partner role not found\n";
    exit;
}

echo "Partner role: {$partnerRole->name} (ID: {$partnerRole->id})\n";
echo "Partner permissions: {$partnerRole->permissions->count()}\n";

// Step 4: Clear existing role assignments
DB::table('model_has_roles')
    ->where('model_id', $user->id)
    ->where('model_type', get_class($user))
    ->delete();
echo "✓ Cleared existing role assignments\n";

// Step 5: Assign Partner role directly
DB::table('model_has_roles')->insert([
    'role_id' => $partnerRole->id,
    'model_type' => get_class($user),
    'model_id' => $user->id
]);
echo "✓ Assigned Partner role directly\n";

// Step 6: Clear cache again
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

// Step 7: Reload user and test
$user = EnhancedUser::find($user->id);
echo "User roles after assignment: " . $user->roles->pluck('name')->implode(', ') . "\n";
echo "User permissions count: " . $user->getAllPermissions()->count() . "\n";

// Step 8: Test specific permissions
$testPermissions = [
    'menu-dashboard',
    'menu-students', 
    'menu-teachers',
    'menu-courses',
    'menu-settings',
    'students-add',
    'users-manage-roles'
];

echo "\n=== Permission Test Results ===\n";
$workingCount = 0;
foreach ($testPermissions as $permission) {
    $hasPermission = $user->can($permission);
    echo ($hasPermission ? '✅' : '❌') . " {$permission}\n";
    if ($hasPermission) $workingCount++;
}

echo "\n=== Summary ===\n";
echo "Working permissions: {$workingCount}/" . count($testPermissions) . "\n";

if ($workingCount === count($testPermissions)) {
    echo "🎉 SUCCESS: All permissions are working!\n";
    echo "The user now has full Partner access.\n";
} else {
    echo "⚠️ Some permissions are still not working.\n";
    
    // Additional debugging
    echo "\nDebugging info:\n";
    echo "- User class: " . get_class($user) . "\n";
    echo "- Role assignments in DB: " . DB::table('model_has_roles')->where('model_id', $user->id)->count() . "\n";
    echo "- Partner role permissions: " . $partnerRole->permissions->count() . "\n";
}

echo "\n✅ Fix process completed!\n";
