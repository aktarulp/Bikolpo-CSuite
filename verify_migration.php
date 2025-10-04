<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== VERIFICATION AFTER MIGRATION ===\n\n";

$pCount = DB::table('permissions')->count();
$spCount = DB::table('spatie_permissions')->count();

echo "permissions table: {$pCount}\n";
echo "spatie_permissions table: {$spCount}\n\n";

if ($pCount >= $spCount) {
    echo "✅ All permissions migrated!\n\n";
    
    // Check role_has_permissions
    echo "Checking role_has_permissions...\n";
    $rhpCount = DB::table('role_has_permissions')->count();
    echo "Records: {$rhpCount}\n";
    
    if ($rhpCount > 0) {
        $permId = DB::table('role_has_permissions')->value('permission_id');
        $inPerms = DB::table('permissions')->where('id', $permId)->exists();
        $inSpatie = DB::table('spatie_permissions')->where('id', $permId)->exists();
        
        if ($inSpatie && !$inPerms) {
            echo "⚠️  role_has_permissions still references spatie_permissions\n";
            echo "Need to update permission IDs\n";
        } else {
            echo "✅ role_has_permissions uses permissions table\n";
        }
    }
    
    echo "\nSafe to delete spatie_permissions? ";
    if ($pCount >= $spCount) {
        echo "YES (after updating role_has_permissions if needed)\n";
    } else {
        echo "NO\n";
    }
} else {
    echo "⚠️  Migration incomplete\n";
}
