<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\EnhancedUser;
use App\Models\EnhancedRole;
use App\Models\EnhancedPermission;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Partner Menu Permissions Test ===\n\n";

// Get partner role
$partnerRole = EnhancedRole::where('name', 'partner')->first();
if (!$partnerRole) {
    echo "❌ Partner role not found!\n";
    exit(1);
}

echo "✅ Partner role found: {$partnerRole->display_name}\n";

// Check menu permissions
$menuPermissions = [
    'menu-dashboard',
    'menu-courses', 
    'menu-subjects',
    'menu-topics',
    'menu-batches',
    'menu-students',
    'menu-teachers',
    'menu-questions',
    'menu-exams',
    'menu-analytics',
    'menu-sms',
    'menu-settings'
];

echo "\n=== Menu Permissions Check ===\n";
$missingPermissions = [];

foreach ($menuPermissions as $permission) {
    $hasPermission = $partnerRole->permissions()->where('name', $permission)->exists();
    $status = $hasPermission ? '✅' : '❌';
    echo "{$status} {$permission}\n";
    
    if (!$hasPermission) {
        $missingPermissions[] = $permission;
    }
}

if (empty($missingPermissions)) {
    echo "\n🎉 All menu permissions are properly assigned to Partner role!\n";
} else {
    echo "\n⚠️  Missing permissions: " . implode(', ', $missingPermissions) . "\n";
}

// Test with actual partner user
$partnerUser = EnhancedUser::where('role', 'partner')->first();
if ($partnerUser) {
    echo "\n=== User Permission Test ===\n";
    echo "Testing user: {$partnerUser->name} (ID: {$partnerUser->id})\n\n";
    
    foreach ($menuPermissions as $permission) {
        $canAccess = $partnerUser->can($permission);
        $status = $canAccess ? '✅' : '❌';
        echo "{$status} {$permission}\n";
    }
} else {
    echo "\n⚠️  No partner user found for testing\n";
}

echo "\n=== Summary ===\n";
echo "Total menu items: " . count($menuPermissions) . "\n";
echo "Partner role permissions: " . $partnerRole->permissions()->where('name', 'like', 'menu-%')->count() . "\n";
echo "Missing permissions: " . count($missingPermissions) . "\n";
