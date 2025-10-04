<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Database Structure Check ===\n\n";

// Check role_permissions table
echo "=== role_permissions table ===\n";
try {
    $columns = DB::select('SHOW COLUMNS FROM role_permissions');
    foreach ($columns as $column) {
        echo "- {$column->Field} ({$column->Type})\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== user_roles table ===\n";
try {
    $columns = DB::select('SHOW COLUMNS FROM user_roles');
    foreach ($columns as $column) {
        echo "- {$column->Field} ({$column->Type})\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Sample Data ===\n";

// Check if partner role exists
echo "Partner role in roles table:\n";
try {
    $partnerRole = DB::select("SELECT id, name, display_name FROM roles WHERE name = 'partner' LIMIT 1");
    if ($partnerRole) {
        $role = $partnerRole[0];
        echo "✅ ID: {$role->id}, Name: {$role->name}, Display: {$role->display_name}\n";
        
        // Check role permissions
        echo "\nRole permissions count:\n";
        $permCount = DB::select("SELECT COUNT(*) as count FROM role_permissions WHERE role_id = ?", [$role->id]);
        echo "Count: " . $permCount[0]->count . "\n";
        
        // Check specific menu permissions
        echo "\nMenu permissions for partner role:\n";
        $menuPerms = DB::select("
            SELECT p.name, p.display_name 
            FROM permissions p 
            JOIN role_permissions rp ON p.id = rp.permission_id 
            WHERE rp.role_id = ? AND p.name LIKE 'menu-%'
            LIMIT 5
        ", [$role->id]);
        
        foreach ($menuPerms as $perm) {
            echo "- {$perm->name}: {$perm->display_name}\n";
        }
    } else {
        echo "❌ Partner role not found\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// Check user-role relationship
echo "\n=== User-Role Relationship ===\n";
try {
    $userRole = DB::select("
        SELECT u.id, u.name, u.role, ur.role_id, r.name as role_name 
        FROM users u 
        LEFT JOIN user_roles ur ON u.id = ur.user_id 
        LEFT JOIN roles r ON ur.role_id = r.id 
        WHERE u.role = 'partner' 
        LIMIT 1
    ");
    
    if ($userRole) {
        $ur = $userRole[0];
        echo "✅ User: {$ur->name}\n";
        echo "   User role field: {$ur->role}\n";
        echo "   Pivot role_id: " . ($ur->role_id ?? 'NULL') . "\n";
        echo "   Pivot role name: " . ($ur->role_name ?? 'NULL') . "\n";
    } else {
        echo "❌ No partner user found\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
