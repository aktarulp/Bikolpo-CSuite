<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "MIGRATING PERMISSIONS (Matching Schema)\n";
echo "========================================\n\n";

$spatiePerms = DB::table('spatie_permissions')->get();
echo "Source: {$spatiePerms->count()} permissions\n\n";

$added = 0;
$exists = 0;

foreach ($spatiePerms as $perm) {
    $check = DB::table('permissions')->where('name', $perm->name)->exists();
    
    if (!$check) {
        try {
            DB::table('permissions')->insert([
                'name' => $perm->name,
                'display_name' => ucwords(str_replace(['-', '_'], ' ', $perm->name)),
                'description' => $perm->description ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $added++;
            echo "✓ {$perm->name}\n";
        } catch (\Exception $e) {
            echo "✗ {$perm->name}: {$e->getMessage()}\n";
        }
    } else {
        $exists++;
    }
}

echo "\n";
echo "Added: {$added}\n";
echo "Already existed: {$exists}\n";
echo "Total in permissions table: " . DB::table('permissions')->count() . "\n";
echo "\n✅ Migration complete!\n";
