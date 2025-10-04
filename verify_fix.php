<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\EnhancedUser;
use App\Models\EnhancedRole;

echo "=== Partner Menu Fix Verification ===\n\n";

// Get partner role
$partnerRole = EnhancedRole::where('name', 'partner')->first();
if (!$partnerRole) {
    echo "❌ Partner role not found\n";
    exit(1);
}

echo "✅ Partner role found: {$partnerRole->display_name}\n";

// Get partner user
$user = EnhancedUser::where('role', 'partner')->first();
if (!$user) {
    echo "❌ No partner user found\n";
    exit(1);
}

echo "👤 Testing with user: {$user->name}\n\n";

// Check all menu permissions that should be in the sidebar
$menuPermissions = [
    'menu-dashboard' => 'Dashboard',
    'menu-courses' => 'Courses',
    'menu-subjects' => 'Subjects',
    'menu-topics' => 'Topics',
    'menu-batches' => 'Batches',
    'menu-students' => 'Students', 
    'menu-teachers' => 'Teachers',
    'menu-questions' => 'Questions',
    'menu-exams' => 'Exams',
    'menu-analytics' => 'Analytics',
    'menu-sms' => 'SMS',
    'menu-settings' => 'Settings'
];

echo "\n=== Menu Access Status ===\n";
$accessibleMenus = 0;
foreach ($menuPermissions as $permission => $label) {
    $hasPermission = $user->can($permission);
    echo ($hasPermission ? '✓' : '✗') . " {$label}\n";
    if ($hasPermission) $accessibleMenus++;
}

echo "\n=== Summary ===\n";
echo "Accessible menus: {$accessibleMenus}/" . count($menuPermissions) . "\n";

if ($accessibleMenus === count($menuPermissions)) {
    echo "🎉 SUCCESS: User now has full access to all menus!\n";
} else {
    echo "⚠️  WARNING: User still has limited access.\n";
}

// Test some button permissions too
$buttonPermissions = [
    'students-add' => 'Add Student',
    'courses-edit' => 'Edit Course',
    'users-manage-roles' => 'Manage Roles',
    'settings-view' => 'View Settings'
];

echo "\n=== Button Permissions Sample ===\n";
foreach ($buttonPermissions as $permission => $label) {
    $hasPermission = $user->can($permission);
    echo ($hasPermission ? '✓' : '✗') . " {$label}\n";
}
