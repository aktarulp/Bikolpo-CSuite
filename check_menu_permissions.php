<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "MENU PERMISSIONS CHECK\n";
echo "======================\n\n";

// Check menu permissions
$menuPerms = DB::table('permissions')->where('name', 'LIKE', 'menu-%')->get();
echo "Menu permissions in database: {$menuPerms->count()}\n\n";

foreach ($menuPerms as $perm) {
    echo "  {$perm->id}. {$perm->name}\n";
}

echo "\n";

// Check partner role permissions
$partnerRole = DB::table('roles')->where('name', 'partner')->first();
if ($partnerRole) {
    $partnerPerms = DB::table('role_permissions')
        ->join('permissions', 'role_permissions.permission_id', '=', 'permissions.id')
        ->where('role_permissions.role_id', $partnerRole->id)
        ->where('permissions.name', 'LIKE', 'menu-%')
        ->count();
    
    echo "Partner role menu permissions: {$partnerPerms}\n";
} else {
    echo "Partner role not found!\n";
}

echo "\nTest access for current user:\n";
$service = new \App\Services\MenuPermissionService();
$menus = ['dashboard', 'students', 'teachers', 'courses'];
foreach ($menus as $menu) {
    $canAccess = $service->canAccessMenu($menu) ? '✅' : '❌';
    echo "  {$canAccess} menu-{$menu}\n";
}
