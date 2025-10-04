<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "DEBUG MIGRATION\n";
echo "===============\n\n";

// Get first permission from spatie that doesn't exist in permissions
$sp = DB::table('spatie_permissions')
    ->whereNotIn('name', DB::table('permissions')->pluck('name'))
    ->first();

if ($sp) {
    echo "Trying to insert: {$sp->name}\n";
    echo "Columns in permissions table:\n";
    
    $cols = DB::select('SHOW COLUMNS FROM permissions');
    foreach ($cols as $c) {
        echo "  - {$c->Field} ({$c->Type}) " . ($c->Null === 'NO' ? 'NOT NULL' : 'NULL') . "\n";
    }
    
    echo "\nAttempting insert...\n";
    
    try {
        $id = DB::table('permissions')->insertGetId([
            'name' => $sp->name,
            'display_name' => ucwords(str_replace(['-', '_'], ' ', $sp->name)),
            'description' => 'Migrated from spatie_permissions',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "✅ Success! New ID: {$id}\n";
    } catch (\Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
        echo "\nFull error:\n";
        print_r($e);
    }
} else {
    echo "All permissions already exist!\n";
    echo "permissions: " . DB::table('permissions')->count() . "\n";
    echo "spatie_permissions: " . DB::table('spatie_permissions')->count() . "\n";
}
