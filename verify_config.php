<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Config Check:\n";
echo "Roles table: " . config('permission.table_names.roles') . "\n";
echo "Permissions table: " . config('permission.table_names.permissions') . "\n\n";

echo "Spatie Role Model loads from:\n";
$roles = \Spatie\Permission\Models\Role::all();
echo "Count: " . $roles->count() . "\n";
foreach ($roles as $role) {
    echo "- " . $role->name . "\n";
}
