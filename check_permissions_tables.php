<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING PERMISSIONS TABLES ===\n\n";

// 1. Check config
echo "1. Config:\n";
echo "   Permissions table: " . config('permission.table_names.permissions') . "\n\n";

// 2. Count records
echo "2. Record Counts:\n";
$permissionsCount = DB::table('permissions')->count();
$spatiePermissionsCount = DB::table('spatie_permissions')->count();
$rolePermissionsCount = DB::table('role_permissions')->count();

echo "   permissions table: {$permissionsCount} records\n";
echo "   spatie_permissions table: {$spatiePermissionsCount} records\n";
echo "   role_permissions table: {$rolePermissionsCount} records\n\n";

// 3. Check what Spatie is using
echo "3. Spatie Model Check:\n";
$spatiePerms = \Spatie\Permission\Models\Permission::count();
echo "   Spatie loads: {$spatiePerms} permissions\n\n";

// 4. Check role_has_permissions table
echo "4. Role-Permission Assignments:\n";
try {
    $roleHasPerms = DB::table('role_has_permissions')->count();
    echo "   role_has_permissions table: {$roleHasPerms} records\n";
    
    if ($roleHasPerms > 0) {
        $samplePermId = DB::table('role_has_permissions')->value('permission_id');
        $inPermissions = DB::table('permissions')->where('id', $samplePermId)->exists();
        $inSpatie = DB::table('spatie_permissions')->where('id', $samplePermId)->exists();
        
        echo "   References: ";
        if ($inPermissions) echo "'permissions' table ✅\n";
        elseif ($inSpatie) echo "'spatie_permissions' table ❌\n";
        else echo "unknown\n";
    }
} catch (\Exception $e) {
    echo "   Table not found or error: " . $e->getMessage() . "\n";
}
echo "\n";

// 5. Check role_permissions table (your custom table)
echo "5. Custom Role-Permissions Table:\n";
try {
    $customRolePerms = DB::table('role_permissions')->count();
    echo "   role_permissions table: {$customRolePerms} records\n";
    
    if ($customRolePerms > 0) {
        $sample = DB::table('role_permissions')->first();
        echo "   Sample columns: " . implode(', ', array_keys((array)$sample)) . "\n";
    }
} catch (\Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}
echo "\n";

// 6. Sample data comparison
echo "6. Sample Permissions:\n";
echo "   From 'permissions' table:\n";
$perms = DB::table('permissions')->select('id', 'name')->limit(5)->get();
foreach ($perms as $p) {
    echo "      ID:{$p->id} - {$p->name}\n";
}

echo "\n   From 'spatie_permissions' table:\n";
$spatiePerms = DB::table('spatie_permissions')->select('id', 'name')->limit(5)->get();
foreach ($spatiePerms as $p) {
    echo "      ID:{$p->id} - {$p->name}\n";
}

echo "\n7. RECOMMENDATION:\n";
if (config('permission.table_names.permissions') === 'permissions') {
    echo "   Config uses 'permissions' table ✅\n";
    
    if ($spatiePerms > 0) {
        echo "   Spatie loads from 'permissions' table ✅\n";
        echo "\n   ⚠️  WAIT! Check if you need data from spatie_permissions:\n";
        echo "   - If spatie_permissions has more/different permissions,\n";
        echo "     you may need to migrate them first.\n";
        echo "   - If permissions are the same, safe to delete.\n";
    }
} else {
    echo "   ❌ Config still uses spatie_permissions - NOT SAFE!\n";
}
