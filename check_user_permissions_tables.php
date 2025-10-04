<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "USER PERMISSIONS TABLES ANALYSIS\n";
echo "=================================\n\n";

// List of potential user permission tables
$potentialTables = [
    'user_permissions',
    'model_has_permissions',
    'user_permission_assignments',
    'enhanced_user_permissions',
    'permission_user'
];

$existingTables = [];

foreach ($potentialTables as $table) {
    try {
        $count = DB::table($table)->count();
        $existingTables[] = $table;
        echo "✅ {$table}: {$count} records\n";
        
        // Show table structure
        $cols = DB::select("SHOW COLUMNS FROM {$table}");
        echo "   Columns: ";
        foreach ($cols as $col) {
            echo $col->Field . " ";
        }
        echo "\n";
        
        // Show sample data
        if ($count > 0) {
            $sample = DB::table($table)->first();
            if ($sample) {
                echo "   Sample: ";
                $data = (array)$sample;
                foreach ($data as $key => $value) {
                    echo "{$key}={$value} ";
                }
                echo "\n";
            }
        }
        echo "\n";
        
    } catch (\Exception $e) {
        echo "❌ {$table}: Does not exist\n\n";
    }
}

echo "SUMMARY:\n";
echo "========\n";
echo "Found " . count($existingTables) . " user permission tables:\n";
foreach ($existingTables as $table) {
    echo "- {$table}\n";
}

if (count($existingTables) > 1) {
    echo "\n⚠️  WARNING: Multiple permission tables found!\n";
    echo "This could cause permission inconsistency.\n";
}

// Check what each table is used for
echo "\nUSAGE ANALYSIS:\n";
echo "===============\n";

foreach ($existingTables as $table) {
    echo "\n{$table} table:\n";
    
    switch ($table) {
        case 'user_permissions':
            echo "- Purpose: Custom direct user-permission assignments\n";
            echo "- Bypasses roles - assigns permissions directly to users\n";
            echo "- Used for: Special permissions, exceptions, overrides\n";
            break;
            
        case 'model_has_permissions':
            echo "- Purpose: Spatie Laravel Permission package\n";
            echo "- Direct user-permission assignments (bypassing roles)\n";
            echo "- Used by: Spatie HasPermissions trait\n";
            break;
            
        default:
            echo "- Purpose: Unknown - needs investigation\n";
            break;
    }
}

echo "\nPERMISSION FLOW ANALYSIS:\n";
echo "=========================\n";
echo "Your system has multiple permission sources:\n";
echo "1. Role-based permissions: user_roles → role_permissions → permissions\n";
echo "2. Direct user permissions: user_permissions → permissions\n";
echo "3. Spatie direct permissions: model_has_permissions → permissions\n";
echo "\nFinal user permissions = Role permissions + Direct permissions\n";
