<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING IF SPATIE_ROLES TABLE IS SAFE TO DELETE ===\n\n";

// 1. Check config
echo "1. Config Check:\n";
echo "   Roles table configured: " . config('permission.table_names.roles') . "\n";
echo "   Permissions table configured: " . config('permission.table_names.permissions') . "\n\n";

// 2. Check if Spatie is using the correct table
echo "2. Spatie Model Check:\n";
$roles = \Spatie\Permission\Models\Role::all();
echo "   Roles loaded by Spatie: " . $roles->count() . "\n";
echo "   Role names: " . $roles->pluck('name')->implode(', ') . "\n\n";

// 3. Check for foreign key constraints
echo "3. Foreign Key Check:\n";
try {
    $constraints = DB::select("
        SELECT 
            TABLE_NAME,
            CONSTRAINT_NAME,
            REFERENCED_TABLE_NAME
        FROM information_schema.KEY_COLUMN_USAGE
        WHERE REFERENCED_TABLE_NAME = 'spatie_roles'
        AND TABLE_SCHEMA = DATABASE()
    ");
    
    if (count($constraints) > 0) {
        echo "   ⚠️  WARNING: Found foreign key constraints referencing spatie_roles:\n";
        foreach ($constraints as $constraint) {
            echo "      - {$constraint->TABLE_NAME}.{$constraint->CONSTRAINT_NAME}\n";
        }
        echo "\n   You need to drop these constraints first!\n\n";
    } else {
        echo "   ✅ No foreign key constraints found.\n\n";
    }
} catch (\Exception $e) {
    echo "   Could not check constraints: " . $e->getMessage() . "\n\n";
}

// 4. Check if any data references spatie_roles
echo "4. Data Reference Check:\n";
try {
    $spatieRolesCount = DB::table('spatie_roles')->count();
    echo "   Records in spatie_roles: {$spatieRolesCount}\n";
    
    // Check model_has_roles
    $modelHasRolesCount = DB::table('model_has_roles')->count();
    echo "   Records in model_has_roles: {$modelHasRolesCount}\n";
    
    if ($modelHasRolesCount > 0) {
        echo "   ⚠️  Checking if model_has_roles references spatie_roles...\n";
        // Get sample role_id from model_has_roles
        $sampleRoleId = DB::table('model_has_roles')->value('role_id');
        $existsInRoles = DB::table('roles')->where('id', $sampleRoleId)->exists();
        $existsInSpatieRoles = DB::table('spatie_roles')->where('id', $sampleRoleId)->exists();
        
        if ($existsInRoles) {
            echo "   ✅ model_has_roles references 'roles' table (GOOD)\n";
        } elseif ($existsInSpatieRoles) {
            echo "   ❌ model_has_roles references 'spatie_roles' table (BAD - Don't delete yet!)\n";
        }
    }
    echo "\n";
} catch (\Exception $e) {
    echo "   Could not check data: " . $e->getMessage() . "\n\n";
}

// 5. Final recommendation
echo "5. RECOMMENDATION:\n";
if (config('permission.table_names.roles') === 'roles' && $roles->count() > 0) {
    echo "   ✅ Config is correct (using 'roles' table)\n";
    echo "   ✅ Spatie is loading roles from 'roles' table\n";
    echo "   ✅ You can safely delete 'spatie_roles' table\n\n";
    echo "   Run this SQL:\n";
    echo "   DROP TABLE IF EXISTS spatie_roles;\n";
    echo "   DROP TABLE IF EXISTS spatie_permissions;\n";
} else {
    echo "   ⚠️  NOT SAFE to delete yet. Please verify configuration.\n";
}
