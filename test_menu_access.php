<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\EnhancedUser;

echo "=== Testing Menu Access for Partner User ===\n\n";

$user = EnhancedUser::where('role', 'partner')->first();
if (!$user) {
    echo "❌ No partner user found\n";
    exit(1);
}

echo "👤 Testing user: {$user->name}\n\n";

$menuItems = [
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

$accessibleCount = 0;
echo "📋 Menu Access Results:\n";
foreach ($menuItems as $permission => $label) {
    $canAccess = $user->can($permission);
    $status = $canAccess ? '✅' : '❌';
    echo "{$status} {$label} ({$permission})\n";
    if ($canAccess) $accessibleCount++;
}

echo "\n📊 Summary:\n";
echo "Accessible menus: {$accessibleCount}/" . count($menuItems) . "\n";

if ($accessibleCount === count($menuItems)) {
    echo "\n🎉 SUCCESS! Partner user can now access ALL menu items!\n";
    echo "The menu visibility issue has been resolved.\n";
} else {
    echo "\n⚠️  PARTIAL ACCESS: Some menu items are still not accessible.\n";
    echo "You may need to check the permission assignments.\n";
}
