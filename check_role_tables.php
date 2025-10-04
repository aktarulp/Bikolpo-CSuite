<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "CHECKING ROLE TABLES\n";
echo "====================\n\n";

$roleTables = [
    'roles',
    'spatie_roles',
    'enhanced_roles',
    'ac_roles'
];

foreach ($roleTables as $table) {
    try {
        $count = DB::table($table)->count();
        echo "✅ {$table}: {$count} records\n";
        
        // Show sample data
        $sample = DB::table($table)->first();
        if ($sample) {
            echo "   Sample: ID={$sample->id}, Name=" . ($sample->name ?? 'N/A') . "\n";
        }
    } catch (\Exception $e) {
        echo "❌ {$table}: Does not exist\n";
    }
    echo "\n";
}

echo "RECOMMENDATION:\n";
echo "===============\n";
echo "We need to rename the roles table to ac_roles and update all references.\n";
