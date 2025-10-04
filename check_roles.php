<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== VERIFICATION AFTER CONFIG CHANGE ===\n\n";

echo "1. Spatie Config:\n";
echo "   Roles table: " . config('permission.table_names.roles') . "\n";
echo "   Permissions table: " . config('permission.table_names.permissions') . "\n\n";

echo "2. Roles loaded by Spatie\\Permission\\Models\\Role:\n";
echo "   ================================================\n";
$spatieRoles = \Spatie\Permission\Models\Role::all();
foreach ($spatieRoles as $role) {
    echo "   ID: {$role->id} - Name: {$role->name}\n";
}
echo "   Total: " . $spatieRoles->count() . "\n\n";

echo "3. Direct query from 'roles' table:\n";
echo "   ==================================\n";
$directRoles = DB::table('roles')->select('id', 'name')->get();
foreach ($directRoles as $role) {
    echo "   ID: {$role->id} - Name: {$role->name}\n";
}
echo "   Total: " . $directRoles->count() . "\n\n";

echo "4. Direct query from 'spatie_roles' table:\n";
echo "   =========================================\n";
$oldSpatieRoles = DB::table('spatie_roles')->select('id', 'name')->get();
foreach ($oldSpatieRoles as $role) {
    echo "   ID: {$role->id} - Name: {$role->name}\n";
}
echo "   Total: " . $oldSpatieRoles->count() . "\n\n";

if ($spatieRoles->count() === $directRoles->count()) {
    echo "✅ SUCCESS! Spatie is now using the 'roles' table!\n";
    echo "   You can now safely drop the 'spatie_roles' table.\n\n";
    echo "   Run this SQL:\n";
    echo "   DROP TABLE IF EXISTS spatie_roles;\n";
    echo "   DROP TABLE IF EXISTS spatie_permissions;\n";
} else {
    echo "⚠️  WARNING! Spatie is still using 'spatie_roles' table.\n";
    echo "   Please run: php artisan config:clear\n";
}
