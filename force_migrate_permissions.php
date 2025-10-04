<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "FORCE MIGRATING PERMISSIONS\n";
echo "============================\n\n";

$spatiePerms = DB::table('spatie_permissions')->get();
echo "Source: {$spatiePerms->count()} permissions\n";

$added = 0;
$exists = 0;

foreach ($spatiePerms as $perm) {
    $check = DB::table('permissions')->where('name', $perm->name)->exists();
    
    if (!$check) {
        DB::table('permissions')->insert([
            'name' => $perm->name,
            'guard_name' => $perm->guard_name ?? 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $added++;
        echo ".";
    } else {
        $exists++;
    }
}

echo "\n\nAdded: {$added}\n";
echo "Already existed: {$exists}\n";
echo "Total now: " . DB::table('permissions')->count() . "\n";
