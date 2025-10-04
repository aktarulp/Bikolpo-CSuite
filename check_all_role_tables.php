<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "ALL USER-ROLE ASSIGNMENT TABLES\n";
echo "================================\n\n";

// List of potential role assignment tables
$potentialTables = [
    'user_roles',
    'model_has_roles', 
    'role_user',
    'enhanced_user_roles',
    'user_role_assignments'
];

$existingTables = [];

foreach ($potentialTables as $table) {
    try {
        $count = DB::table($table)->count();
        $existingTables[] = $table;
        echo "✅ {$table}: {$count} records\n";
        
        // Show sample data
        $sample = DB::table($table)->first();
        if ($sample) {
            $columns = array_keys((array)$sample);
            echo "   Columns: " . implode(', ', $columns) . "\n";
        }
        echo "\n";
        
    } catch (\Exception $e) {
        echo "❌ {$table}: Does not exist\n\n";
    }
}

echo "SUMMARY:\n";
echo "========\n";
echo "Found " . count($existingTables) . " user-role assignment tables:\n";
foreach ($existingTables as $table) {
    echo "- {$table}\n";
}

if (count($existingTables) > 1) {
    echo "\n⚠️  WARNING: Multiple tables found! This could cause data inconsistency.\n";
    echo "Recommendation: Consolidate to one table.\n";
}
