<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "ACCESS CONTROL TABLES RENAME PLAN\n";
echo "==================================\n\n";

// Define table mappings
$tableMappings = [
    'users' => 'ac_users',
    'user_roles' => 'ac_user_roles',
    'role_permissions' => 'ac_role_permissions',
    'permissions' => 'ac_permissions'
];

echo "RENAME MAPPINGS:\n";
foreach ($tableMappings as $old => $new) {
    echo "  {$old} → {$new}\n";
}

echo "\nSTEP 1: Check Current Tables\n";
echo "----------------------------\n";

foreach ($tableMappings as $oldTable => $newTable) {
    try {
        $count = DB::table($oldTable)->count();
        echo "✅ {$oldTable}: {$count} records\n";
    } catch (\Exception $e) {
        echo "❌ {$oldTable}: Does not exist\n";
    }
}

echo "\nSTEP 2: Create Rename SQL\n";
echo "-------------------------\n";

$renameSql = [];
foreach ($tableMappings as $oldTable => $newTable) {
    $renameSql[] = "RENAME TABLE `{$oldTable}` TO `{$newTable}`;";
}

echo "SQL Commands to execute:\n";
foreach ($renameSql as $sql) {
    echo "  {$sql}\n";
}

echo "\nSTEP 3: Files That Need Updates\n";
echo "-------------------------------\n";

$filesToUpdate = [
    'Models' => [
        'app/Models/EnhancedUser.php',
        'app/Models/EnhancedRole.php', 
        'app/Models/EnhancedPermission.php',
        'app/Models/UserRole.php',
        'app/Models/User.php'
    ],
    'Services' => [
        'app/Services/MenuPermissionService.php'
    ],
    'Controllers' => [
        'app/Http/Controllers/Partner/AccessControlController.php',
        'app/Http/Controllers/UserManagementController.php'
    ],
    'Seeders' => [
        'database/seeders/MenuPermissionsSeeder.php'
    ],
    'Config' => [
        'config/permission.php'
    ]
];

foreach ($filesToUpdate as $category => $files) {
    echo "\n{$category}:\n";
    foreach ($files as $file) {
        echo "  - {$file}\n";
    }
}

echo "\nSTEP 4: Search Patterns to Replace\n";
echo "----------------------------------\n";

$searchPatterns = [
    "DB::table('users')" => "DB::table('ac_users')",
    "DB::table('user_roles')" => "DB::table('ac_user_roles')",
    "DB::table('role_permissions')" => "DB::table('ac_role_permissions')",
    "DB::table('permissions')" => "DB::table('ac_permissions')",
    "'users'" => "'ac_users'",
    "'user_roles'" => "'ac_user_roles'",
    "'role_permissions'" => "'ac_role_permissions'",
    "'permissions'" => "'ac_permissions'",
    '"users"' => '"ac_users"',
    '"user_roles"' => '"ac_user_roles"',
    '"role_permissions"' => '"ac_role_permissions"',
    '"permissions"' => '"ac_permissions"'
];

echo "Patterns to replace:\n";
foreach ($searchPatterns as $old => $new) {
    echo "  {$old} → {$new}\n";
}

echo "\n⚠️  WARNING: This is a major change!\n";
echo "- Backup your database before proceeding\n";
echo "- Test thoroughly after changes\n";
echo "- Update any external references\n";

echo "\n📋 READY TO PROCEED\n";
echo "Run the SQL commands manually, then update the code files.\n";
