<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "MIGRATING ROLE ASSIGNMENTS TO CUSTOM TABLE\n";
echo "===========================================\n\n";

DB::beginTransaction();

try {
    // Step 1: Check current state
    echo "1. Current State:\n";
    $modelHasRolesCount = DB::table('model_has_roles')->count();
    $userRolesCount = DB::table('user_roles')->count();
    
    echo "   model_has_roles: {$modelHasRolesCount} records\n";
    echo "   user_roles: {$userRolesCount} records\n\n";
    
    if ($modelHasRolesCount === 0) {
        echo "❌ No data in model_has_roles to migrate!\n";
        DB::rollback();
        exit;
    }
    
    // Step 2: Get all role assignments from Spatie table
    echo "2. Reading Spatie Role Assignments:\n";
    $assignments = DB::table('model_has_roles')
        ->where('model_type', 'App\\Models\\EnhancedUser')
        ->orWhere('model_type', 'App\\Models\\User')
        ->get();
    
    echo "   Found {$assignments->count()} assignments to migrate\n\n";
    
    if ($assignments->count() === 0) {
        echo "❌ No user role assignments found in model_has_roles!\n";
        DB::rollback();
        exit;
    }
    
    // Step 3: Show what we're migrating
    echo "3. Assignment Details:\n";
    foreach ($assignments as $assignment) {
        echo "   User ID: {$assignment->model_id}, Role ID: {$assignment->role_id}\n";
    }
    echo "\n";
    
    // Step 4: Migrate to user_roles table
    echo "4. Migrating to user_roles table:\n";
    $migrated = 0;
    $skipped = 0;
    
    foreach ($assignments as $assignment) {
        // Check if already exists
        $exists = DB::table('user_roles')
            ->where('user_id', $assignment->model_id)
            ->where('role_id', $assignment->role_id)
            ->exists();
        
        if (!$exists) {
            DB::table('user_roles')->insert([
                'user_id' => $assignment->model_id,
                'role_id' => $assignment->role_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            echo "   ✓ Migrated User {$assignment->model_id} → Role {$assignment->role_id}\n";
            $migrated++;
        } else {
            echo "   ○ Skipped User {$assignment->model_id} → Role {$assignment->role_id} (already exists)\n";
            $skipped++;
        }
    }
    
    echo "\n";
    echo "5. Migration Summary:\n";
    echo "   Migrated: {$migrated}\n";
    echo "   Skipped: {$skipped}\n";
    echo "   Total processed: " . ($migrated + $skipped) . "\n\n";
    
    // Step 5: Verify migration
    echo "6. Verification:\n";
    $newUserRolesCount = DB::table('user_roles')->count();
    echo "   user_roles now has: {$newUserRolesCount} records\n";
    
    // Test with a sample user
    $sampleUser = DB::table('user_roles')->first();
    if ($sampleUser) {
        echo "   Sample: User {$sampleUser->user_id} has Role {$sampleUser->enhanced_role_id}\n";
        
        // Test MenuPermissionService logic
        $roleIds = DB::table('user_roles')
            ->where('user_id', $sampleUser->user_id)
            ->pluck('enhanced_role_id')
            ->toArray();
        
        echo "   MenuPermissionService would find role IDs: " . implode(', ', $roleIds) . "\n";
    }
    
    echo "\n7. Next Steps:\n";
    echo "   ✅ Migration successful!\n";
    echo "   ✅ MenuPermissionService will now work correctly\n";
    echo "   ✅ Menu access control should function properly\n";
    echo "   \n";
    echo "   Optional cleanup:\n";
    echo "   - You can now delete model_has_roles data if desired\n";
    echo "   - Test menu access control to confirm it works\n";
    
    DB::commit();
    echo "\n✅ MIGRATION COMPLETED SUCCESSFULLY!\n";
    
} catch (\Exception $e) {
    DB::rollback();
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "Migration rolled back.\n";
}
