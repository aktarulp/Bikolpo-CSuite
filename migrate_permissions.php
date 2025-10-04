<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== MIGRATING PERMISSIONS ===\n\n";

DB::beginTransaction();

try {
    $spatiePerms = DB::table('spatie_permissions')->get();
    
    echo "Found {$spatiePerms->count()} permissions in spatie_permissions\n\n";
    
    $added = 0;
    $skipped = 0;
    
    foreach ($spatiePerms as $perm) {
        // Check if permission already exists in permissions table
        $exists = DB::table('permissions')->where('name', $perm->name)->exists();
        
        if (!$exists) {
            // Insert into permissions table
            DB::table('permissions')->insert([
                'name' => $perm->name,
                'guard_name' => $perm->guard_name ?? 'web',
                'created_at' => $perm->created_at ?? now(),
                'updated_at' => $perm->updated_at ?? now(),
            ]);
            echo "✓ Added: {$perm->name}\n";
            $added++;
        } else {
            $skipped++;
        }
    }
    
    echo "\nAdded: {$added}\n";
    echo "Skipped (already exists): {$skipped}\n\n";
    
    DB::commit();
    echo "✅ SUCCESS! Permissions migrated.\n";
    echo "   Now check role_has_permissions table.\n";
    
} catch (\Exception $e) {
    DB::rollback();
    echo "ERROR: " . $e->getMessage() . "\n";
}
