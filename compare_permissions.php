<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "PERMISSIONS TABLE COMPARISON\n";
echo "============================\n\n";

$pCount = DB::table('permissions')->count();
$spCount = DB::table('spatie_permissions')->count();
$rpCount = DB::table('role_permissions')->count();

echo "permissions: {$pCount}\n";
echo "spatie_permissions: {$spCount}\n";
echo "role_permissions: {$rpCount}\n\n";

echo "Config uses: " . config('permission.table_names.permissions') . "\n\n";

echo "Spatie loads: " . \Spatie\Permission\Models\Permission::count() . " permissions\n\n";

// Check which table role_has_permissions uses
$rhp = DB::table('role_has_permissions')->value('permission_id');
if ($rhp) {
    $inP = DB::table('permissions')->where('id', $rhp)->exists();
    $inSP = DB::table('spatie_permissions')->where('id', $rhp)->exists();
    
    echo "role_has_permissions uses: ";
    if ($inP) echo "permissions ✅\n";
    elseif ($inSP) echo "spatie_permissions ❌\n";
}

echo "\nSAFE TO DELETE spatie_permissions? ";
if (config('permission.table_names.permissions') === 'permissions' && $pCount > 0) {
    echo "CHECK DATA FIRST!\n";
    echo "Compare if both tables have same permissions.\n";
} else {
    echo "NO - migrate first\n";
}
