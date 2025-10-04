<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\EnhancedRole;
use App\Models\EnhancedPermission;
use App\Models\EnhancedUser;

echo "=== Fixing Partner Menu Permissions ===\n\n";

// Get partner role
$partnerRole = EnhancedRole::where('name', 'partner')->first();
if (!$partnerRole) {
    echo "❌ Partner role not found!\n";
    exit(1);
}

echo "✅ Partner role found: {$partnerRole->display_name}\n";

// Define all menu permissions that should exist
$requiredMenuPermissions = [
    'menu-dashboard' => 'Access Dashboard Menu',
    'menu-courses' => 'Access Courses Menu',
    'menu-subjects' => 'Access Subjects Menu',
    'menu-topics' => 'Access Topics Menu',
    'menu-batches' => 'Access Batches Menu',
    'menu-students' => 'Access Students Menu',
    'menu-teachers' => 'Access Teachers Menu',
    'menu-questions' => 'Access Questions Menu',
    'menu-exams' => 'Access Exams Menu',
    'menu-analytics' => 'Access Analytics Menu',
    'menu-sms' => 'Access SMS Menu',
    'menu-settings' => 'Access Settings Menu'
];

echo "\n=== Creating Missing Permissions ===\n";

$createdCount = 0;
foreach ($requiredMenuPermissions as $permissionName => $description) {
    $permission = EnhancedPermission::where('name', $permissionName)->first();
    
    if (!$permission) {
        $permission = EnhancedPermission::create([
            'name' => $permissionName,
            'display_name' => $description,
            'description' => $description,
            'module' => str_replace('menu-', '', $permissionName),
            'action' => 'menu',
            'status' => 'active'
        ]);
        echo "✅ Created: {$permissionName}\n";
        $createdCount++;
    } else {
        echo "⚪ Exists: {$permissionName}\n";
    }
}

echo "\n=== Assigning Permissions to Partner Role ===\n";

$assignedCount = 0;
foreach ($requiredMenuPermissions as $permissionName => $description) {
    $permission = EnhancedPermission::where('name', $permissionName)->first();
    
    if ($permission && !$partnerRole->permissions->contains($permission->id)) {
        $partnerRole->permissions()->attach($permission->id, [
            'granted_by' => 1,
            'granted_at' => now()
        ]);
        echo "✅ Assigned: {$permissionName}\n";
        $assignedCount++;
    } else {
        echo "⚪ Already has: {$permissionName}\n";
    }
}

echo "\n=== Testing Partner User Permissions ===\n";

$partnerUser = EnhancedUser::where('role', 'partner')->first();
if ($partnerUser) {
    echo "👤 Testing user: {$partnerUser->name}\n\n";
    
    $accessibleCount = 0;
    foreach ($requiredMenuPermissions as $permissionName => $description) {
        $canAccess = $partnerUser->can($permissionName);
        $status = $canAccess ? '✅' : '❌';
        echo "{$status} {$permissionName}\n";
        if ($canAccess) $accessibleCount++;
    }
    
    echo "\n📊 Results:\n";
    echo "- Created permissions: {$createdCount}\n";
    echo "- Assigned permissions: {$assignedCount}\n";
    echo "- Accessible menus: {$accessibleCount}/" . count($requiredMenuPermissions) . "\n";
    
    if ($accessibleCount === count($requiredMenuPermissions)) {
        echo "\n🎉 SUCCESS! All menu items are now accessible to partner users!\n";
    } else {
        echo "\n⚠️  Some menu items are still not accessible. Check permission system configuration.\n";
    }
} else {
    echo "⚠️  No partner user found for testing\n";
}

echo "\n=== Summary ===\n";
echo "Partner role now has " . $partnerRole->permissions()->where('name', 'like', 'menu-%')->count() . " menu permissions\n";
