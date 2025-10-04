<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== MIGRATING ROLE ASSIGNMENTS ===\n\n";

DB::beginTransaction();

try {
    // Get all role assignments
    $assignments = DB::table('model_has_roles')->get();
    
    echo "Found {$assignments->count()} role assignments\n\n";
    
    $updated = 0;
    $skipped = 0;
    
    foreach ($assignments as $assignment) {
        // Find the role in spatie_roles
        $spatieRole = DB::table('spatie_roles')->where('id', $assignment->role_id)->first();
        
        if ($spatieRole) {
            // Find matching role in roles table by name
            $newRole = DB::table('roles')->where('name', strtolower($spatieRole->name))->first();
            
            if ($newRole) {
                // Update the assignment to use new role_id
                DB::table('model_has_roles')
                    ->where('role_id', $assignment->role_id)
                    ->where('model_type', $assignment->model_type)
                    ->where('model_id', $assignment->model_id)
                    ->update(['role_id' => $newRole->id]);
                
                echo "✓ Updated: {$spatieRole->name} (old ID: {$assignment->role_id}) -> (new ID: {$newRole->id})\n";
                $updated++;
            } else {
                echo "⚠ Skipped: {$spatieRole->name} - no matching role in 'roles' table\n";
                $skipped++;
            }
        }
    }
    
    echo "\n";
    echo "Updated: {$updated}\n";
    echo "Skipped: {$skipped}\n\n";
    
    if ($skipped === 0) {
        DB::commit();
        echo "✅ SUCCESS! All role assignments migrated.\n";
        echo "   You can now safely delete spatie_roles table.\n\n";
        echo "   Run: DROP TABLE spatie_roles;\n";
    } else {
        DB::rollback();
        echo "❌ ROLLED BACK! Some roles couldn't be migrated.\n";
        echo "   Please create missing roles in 'roles' table first.\n";
    }
    
} catch (\Exception $e) {
    DB::rollback();
    echo "ERROR: " . $e->getMessage() . "\n";
}
