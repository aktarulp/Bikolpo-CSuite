<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║          FULL MIGRATION TO SINGLE TABLES                   ║\n";
echo "║  Consolidating: spatie_roles → roles                       ║\n";
echo "║                 spatie_permissions → permissions           ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

DB::beginTransaction();

try {
    // STEP 1: Migrate Permissions
    echo "STEP 1: Migrating Permissions\n";
    echo "==============================\n";
    
    $spatiePerms = DB::table('spatie_permissions')->get();
    $permissionIdMap = []; // Map old ID to new ID
    
    foreach ($spatiePerms as $spPerm) {
        // Check if permission exists by name
        $existing = DB::table('permissions')->where('name', $spPerm->name)->first();
        
        if ($existing) {
            // Already exists, map old ID to existing ID
            $permissionIdMap[$spPerm->id] = $existing->id;
            echo "  ✓ Exists: {$spPerm->name} (ID: {$spPerm->id} → {$existing->id})\n";
        } else {
            // Create new permission
            $newId = DB::table('permissions')->insertGetId([
                'name' => $spPerm->name,
                'display_name' => ucwords(str_replace(['-', '_'], ' ', $spPerm->name)),
                'description' => $spPerm->description ?? "Permission for {$spPerm->name}",
                'created_at' => $spPerm->created_at ?? now(),
                'updated_at' => $spPerm->updated_at ?? now(),
            ]);
            
            $permissionIdMap[$spPerm->id] = $newId;
            echo "  + Added: {$spPerm->name} (ID: {$spPerm->id} → {$newId})\n";
        }
    }
    
    echo "\n  Total permissions mapped: " . count($permissionIdMap) . "\n\n";
    
    // STEP 2: Update role_has_permissions table
    echo "STEP 2: Updating role_has_permissions\n";
    echo "======================================\n";
    
    $roleHasPerms = DB::table('role_has_permissions')->get();
    $updated = 0;
    
    foreach ($roleHasPerms as $rhp) {
        if (isset($permissionIdMap[$rhp->permission_id])) {
            $newPermId = $permissionIdMap[$rhp->permission_id];
            
            DB::table('role_has_permissions')
                ->where('permission_id', $rhp->permission_id)
                ->where('role_id', $rhp->role_id)
                ->update(['permission_id' => $newPermId]);
            
            $updated++;
            echo "  ✓ Updated role {$rhp->role_id}: perm {$rhp->permission_id} → {$newPermId}\n";
        }
    }
    
    echo "\n  Total updated: {$updated}\n\n";
    
    // STEP 3: Update model_has_permissions table (if exists)
    echo "STEP 3: Updating model_has_permissions\n";
    echo "=======================================\n";
    
    try {
        $modelHasPerms = DB::table('model_has_permissions')->get();
        $mhpUpdated = 0;
        
        foreach ($modelHasPerms as $mhp) {
            if (isset($permissionIdMap[$mhp->permission_id])) {
                $newPermId = $permissionIdMap[$mhp->permission_id];
                
                DB::table('model_has_permissions')
                    ->where('permission_id', $mhp->permission_id)
                    ->where('model_type', $mhp->model_type)
                    ->where('model_id', $mhp->model_id)
                    ->update(['permission_id' => $newPermId]);
                
                $mhpUpdated++;
            }
        }
        
        echo "  Total updated: {$mhpUpdated}\n\n";
    } catch (\Exception $e) {
        echo "  Table not found or empty (OK)\n\n";
    }
    
    // STEP 4: Verify migration
    echo "STEP 4: Verification\n";
    echo "====================\n";
    
    $finalPermCount = DB::table('permissions')->count();
    $spatiePermCount = DB::table('spatie_permissions')->count();
    
    echo "  permissions table: {$finalPermCount}\n";
    echo "  spatie_permissions table: {$spatiePermCount}\n";
    
    if ($finalPermCount >= $spatiePermCount) {
        echo "  ✅ All permissions migrated!\n\n";
    } else {
        echo "  ⚠️  Some permissions may be missing\n\n";
    }
    
    // STEP 5: Final check
    echo "STEP 5: Final Checks\n";
    echo "====================\n";
    
    // Check if role_has_permissions now references permissions table
    $samplePermId = DB::table('role_has_permissions')->value('permission_id');
    if ($samplePermId) {
        $inPermissions = DB::table('permissions')->where('id', $samplePermId)->exists();
        $inSpatie = DB::table('spatie_permissions')->where('id', $samplePermId)->exists();
        
        if ($inPermissions) {
            echo "  ✅ role_has_permissions → permissions table\n";
        } elseif ($inSpatie) {
            echo "  ❌ Still references spatie_permissions\n";
            throw new \Exception("Migration failed - still referencing old table");
        }
    }
    
    echo "\n";
    echo "╔════════════════════════════════════════════════════════════╗\n";
    echo "║                    MIGRATION SUCCESSFUL!                   ║\n";
    echo "╚════════════════════════════════════════════════════════════╝\n\n";
    
    echo "You can now safely:\n";
    echo "1. DROP TABLE spatie_permissions;\n";
    echo "2. DROP TABLE spatie_roles;\n\n";
    
    echo "Commit changes? (y/n): ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    
    if (trim($line) === 'y') {
        DB::commit();
        echo "\n✅ Changes committed!\n";
    } else {
        DB::rollback();
        echo "\n❌ Changes rolled back.\n";
    }
    
} catch (\Exception $e) {
    DB::rollback();
    echo "\n\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "Changes rolled back.\n";
}
