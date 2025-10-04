<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\EnhancedUser;
use Spatie\Permission\Models\Role;

echo "=== Fixing User Role Assignment ===\n";

$user = EnhancedUser::first();
echo "User: {$user->name}\n";

// Clear existing roles
$user->syncRoles([]);
echo "✓ Cleared existing roles\n";

// Assign partner role (lowercase to match database)
$user->assignRole('partner');
echo "✓ Assigned partner role\n";

// Verify the assignment
$user = $user->fresh(); // Reload from database
echo "Current roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
echo "Permission count: " . $user->getAllPermissions()->count() . "\n";

// Test a few permissions
$testPermissions = ['menu-dashboard', 'menu-students', 'students-add'];
echo "\nTesting permissions:\n";
foreach ($testPermissions as $permission) {
    $hasPermission = $user->can($permission);
    echo ($hasPermission ? '✓' : '✗') . " {$permission}\n";
}

echo "\n✅ User role fix completed!\n";
