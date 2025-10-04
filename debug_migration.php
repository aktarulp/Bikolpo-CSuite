<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "DEBUG MIGRATION ISSUE\n";
echo "=====================\n\n";

// Check what's in model_has_roles
echo "1. Data in model_has_roles:\n";
$assignments = DB::table('model_has_roles')->get();
foreach ($assignments as $assignment) {
    echo "   Model Type: {$assignment->model_type}\n";
    echo "   Model ID: {$assignment->model_id}\n";
    echo "   Role ID: {$assignment->role_id}\n\n";
    
    // Check if user exists
    $userExists = DB::table('users')->where('id', $assignment->model_id)->exists();
    echo "   User ID {$assignment->model_id} exists: " . ($userExists ? 'YES' : 'NO') . "\n";
    
    // Check if role exists
    $roleExists = DB::table('roles')->where('id', $assignment->role_id)->exists();
    echo "   Role ID {$assignment->role_id} exists: " . ($roleExists ? 'YES' : 'NO') . "\n\n";
}

// Check user_roles table constraints
echo "2. Foreign Key Constraints on user_roles:\n";
try {
    $constraints = DB::select("
        SELECT 
            CONSTRAINT_NAME,
            COLUMN_NAME,
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME
        FROM information_schema.KEY_COLUMN_USAGE
        WHERE TABLE_NAME = 'user_roles'
        AND TABLE_SCHEMA = DATABASE()
        AND REFERENCED_TABLE_NAME IS NOT NULL
    ");
    
    if (count($constraints) > 0) {
        foreach ($constraints as $constraint) {
            echo "   {$constraint->CONSTRAINT_NAME}: {$constraint->COLUMN_NAME} → {$constraint->REFERENCED_TABLE_NAME}.{$constraint->REFERENCED_COLUMN_NAME}\n";
        }
    } else {
        echo "   No foreign key constraints found\n";
    }
} catch (\Exception $e) {
    echo "   Error checking constraints: " . $e->getMessage() . "\n";
}

echo "\n3. Test Manual Insert:\n";
$assignment = $assignments->first();
if ($assignment) {
    try {
        DB::table('user_roles')->insert([
            'user_id' => $assignment->model_id,
            'role_id' => $assignment->role_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "   ✓ Manual insert successful\n";
        
        // Clean up
        DB::table('user_roles')->where('user_id', $assignment->model_id)->delete();
    } catch (\Exception $e) {
        echo "   ❌ Manual insert failed: " . $e->getMessage() . "\n";
    }
}
