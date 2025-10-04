<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Config roles table: " . config('permission.table_names.roles') . "\n";
echo "Spatie loads: " . \Spatie\Permission\Models\Role::count() . " roles\n";

// Check model_has_roles
$modelRoleId = DB::table('model_has_roles')->value('role_id');
if ($modelRoleId) {
    $inRoles = DB::table('roles')->where('id', $modelRoleId)->exists();
    $inSpatie = DB::table('spatie_roles')->where('id', $modelRoleId)->exists();
    
    echo "model_has_roles uses: ";
    if ($inRoles) echo "roles table (GOOD)\n";
    elseif ($inSpatie) echo "spatie_roles table (BAD)\n";
    else echo "unknown\n";
}

echo "\nSafe to delete spatie_roles? ";
if (config('permission.table_names.roles') === 'roles') {
    echo "YES\n";
} else {
    echo "NO\n";
}
