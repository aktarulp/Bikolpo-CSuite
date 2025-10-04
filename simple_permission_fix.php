<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Simple Permission Fix for Partner Role ===\n\n";

// Step 1: Check what tables exist
echo "Step 1: Checking database tables...\n";
$tables = DB::select("SHOW TABLES");
$tableNames = array_map(function($table) {
    return array_values((array)$table)[0];
}, $tables);

echo "Available tables:\n";
foreach ($tableNames as $table) {
    if (strpos($table, 'role') !== false || strpos($table, 'permission') !== false) {
        echo "  - {$table}\n";
    }
}

// Step 2: Check role_permissions table structure
echo "\n Step 2: Checking role_permissions table structure...\n";
try {
    $columns = DB::select("SHOW COLUMNS FROM role_permissions");
    echo "Columns in role_permissions:\n";
    foreach ($columns as $col) {
        echo "  - {$col->Field} ({$col->Type})\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// Step 3: Check current partner role permissions
echo "\nStep 3: Checking partner role...\n";
$partner = DB::table('roles')->where('name', 'partner')->first();
if ($partner) {
    echo "✅ Partner role ID: {$partner->id}\n";
    
    // Count current permissions
    $permCount = DB::table('role_permissions')
        ->where('enhanced_role_id', $partner->id)
        ->count();
    echo "Current permissions: {$permCount}\n";
    
    // Show some permissions
    $perms = DB::select("
        SELECT p.name, p.display_name 
        FROM permissions p
        JOIN role_permissions rp ON p.id = rp.enhanced_permission_id
        WHERE rp.enhanced_role_id = ?
        LIMIT 5
    ", [$partner->id]);
    
    echo "Sample permissions:\n";
    foreach ($perms as $perm) {
        echo "  - {$perm->name}\n";
    }
} else {
    echo "❌ Partner role not found\n";
}

// Step 4: Simple solution - Remove @can directives temporarily
echo "\n=== SOLUTION ===\n";
echo "The permission system needs proper setup. Here are your options:\n\n";

echo "OPTION 1: Remove permission checks temporarily\n";
echo "  - Comment out all @can and @endcan directives in partner-layout.blade.php\n";
echo "  - This will show all menu items regardless of permissions\n\n";

echo "OPTION 2: Assign all permissions to partner role\n";
echo "  - Run the permission seeder if it exists\n";
echo "  - Or manually assign permissions in the database\n\n";

echo "OPTION 3: Use a simpler permission system\n";
echo "  - Check user's role field directly instead of permissions\n";
echo "  - Example: @if(auth()->user()->role === 'partner')\n\n";

echo "Would you like me to implement OPTION 3 (role-based checks)? (Y/N)\n";
