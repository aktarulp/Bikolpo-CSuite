<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\EnhancedUser;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

echo "=== Simple Role Fix ===\n";

$user = EnhancedUser::first();

// Check both Partner and partner roles
$partnerRole = Role::where('name', 'partner')->first();
if (!$partnerRole) {
    $partnerRole = Role::where('name', 'Partner')->first();
}

if (!$partnerRole) {
    echo "❌ No partner role found\n";
    exit;
}

echo "User: {$user->name} (ID: {$user->id})\n";
echo "Partner role: {$partnerRole->name} (ID: {$partnerRole->id})\n";

// Clear existing role assignments
DB::table('model_has_roles')->where('model_id', $user->id)->where('model_type', get_class($user))->delete();
echo "✓ Cleared existing roles\n";

// Insert new role assignment
DB::table('model_has_roles')->insert([
    'role_id' => $partnerRole->id,
    'model_type' => get_class($user),
    'model_id' => $user->id
]);
echo "✓ Assigned partner role directly\n";

// Clear cache
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
echo "✓ Cleared permission cache\n";

// Test permissions
$user = $user->fresh();
echo "Permission count: " . $user->getAllPermissions()->count() . "\n";

$testPermissions = ['menu-dashboard', 'menu-students', 'menu-teachers', 'menu-courses'];
echo "\nTesting key permissions:\n";
foreach ($testPermissions as $permission) {
    $hasPermission = $user->can($permission);
    echo ($hasPermission ? '✅' : '❌') . " {$permission}\n";
}

echo "\n🎉 Fix completed!\n";
