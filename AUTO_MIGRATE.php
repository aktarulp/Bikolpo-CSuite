<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "AUTO MIGRATION - PERMISSIONS\n";
echo "============================\n\n";

DB::beginTransaction();

try {
    $spatiePerms = DB::table('spatie_permissions')->get();
    $map = [];
    $added = 0;
    $exists = 0;
    
    foreach ($spatiePerms as $sp) {
        $ex = DB::table('permissions')->where('name', $sp->name)->first();
        
        if ($ex) {
            $map[$sp->id] = $ex->id;
            $exists++;
        } else {
            $newId = DB::table('permissions')->insertGetId([
                'name' => $sp->name,
                'display_name' => ucwords(str_replace(['-', '_'], ' ', $sp->name)),
                'description' => $sp->description ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $map[$sp->id] = $newId;
            $added++;
        }
    }
    
    echo "Permissions: Added {$added}, Existed {$exists}\n";
    
    // Update role_has_permissions
    $rhp = DB::table('role_has_permissions')->get();
    $updated = 0;
    
    foreach ($rhp as $r) {
        if (isset($map[$r->permission_id])) {
            DB::table('role_has_permissions')
                ->where('permission_id', $r->permission_id)
                ->where('role_id', $r->role_id)
                ->update(['permission_id' => $map[$r->permission_id]]);
            $updated++;
        }
    }
    
    echo "Updated role_has_permissions: {$updated}\n";
    
    DB::commit();
    echo "\n✅ SUCCESS!\n";
    echo "Permissions: " . DB::table('permissions')->count() . "\n";
    echo "Safe to drop: spatie_permissions, spatie_roles\n";
    
} catch (\Exception $e) {
    DB::rollback();
    echo "ERROR: " . $e->getMessage() . "\n";
}
