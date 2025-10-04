<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "USER_ROLES TABLE ANALYSIS\n";
echo "=========================\n\n";

// Check table structure
echo "1. Table Structure:\n";
$cols = DB::select('SHOW COLUMNS FROM user_roles');
foreach ($cols as $c) {
    echo "   - {$c->Field} ({$c->Type}) " . ($c->Null === 'NO' ? 'NOT NULL' : 'NULL') . "\n";
}

echo "\n2. Sample Data:\n";
$sample = DB::table('user_roles')->limit(5)->get();
if ($sample->count() > 0) {
    foreach ($sample as $row) {
        echo "   User ID: {$row->user_id}, Role ID: {$row->enhanced_role_id}\n";
    }
} else {
    echo "   No data found\n";
}

echo "\n3. Record Count: " . DB::table('user_roles')->count() . "\n";

echo "\n4. Foreign Key Check:\n";
try {
    $fks = DB::select("
        SELECT 
            COLUMN_NAME,
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME
        FROM information_schema.KEY_COLUMN_USAGE
        WHERE TABLE_NAME = 'user_roles'
        AND TABLE_SCHEMA = DATABASE()
        AND REFERENCED_TABLE_NAME IS NOT NULL
    ");
    
    if (count($fks) > 0) {
        foreach ($fks as $fk) {
            echo "   {$fk->COLUMN_NAME} → {$fk->REFERENCED_TABLE_NAME}.{$fk->REFERENCED_COLUMN_NAME}\n";
        }
    } else {
        echo "   No foreign keys found\n";
    }
} catch (\Exception $e) {
    echo "   Error checking foreign keys: " . $e->getMessage() . "\n";
}

echo "\n5. Usage Check:\n";
echo "   This table links users to their roles\n";
echo "   Used by MenuPermissionService to get user's role IDs\n";
echo "   Used by EnhancedUser model for role relationships\n";
