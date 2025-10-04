<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "DETAILED USER PERMISSIONS ANALYSIS\n";
echo "===================================\n\n";

// Check user_permissions table
echo "1. USER_PERMISSIONS TABLE (Custom System):\n";
echo "-------------------------------------------\n";
try {
    $userPermCount = DB::table('user_permissions')->count();
    echo "Records: {$userPermCount}\n";
    
    if ($userPermCount > 0) {
        echo "Sample data:\n";
        $samples = DB::table('user_permissions')->limit(3)->get();
        foreach ($samples as $sample) {
            echo "  User: {$sample->user_id}, Permission: {$sample->permission_id}\n";
        }
    } else {
        echo "No data found\n";
    }
    
    // Check structure
    $cols = DB::select('SHOW COLUMNS FROM user_permissions');
    echo "Columns:\n";
    foreach ($cols as $col) {
        echo "  - {$col->Field} ({$col->Type})\n";
    }
    echo "\n";
} catch (\Exception $e) {
    echo "❌ user_permissions table does not exist\n\n";
}

// Check model_has_permissions table
echo "2. MODEL_HAS_PERMISSIONS TABLE (Spatie System):\n";
echo "------------------------------------------------\n";
try {
    $modelPermCount = DB::table('model_has_permissions')->count();
    echo "Records: {$modelPermCount}\n";
    
    if ($modelPermCount > 0) {
        echo "Sample data:\n";
        $samples = DB::table('model_has_permissions')->limit(3)->get();
        foreach ($samples as $sample) {
            echo "  Model: {$sample->model_type}, ID: {$sample->model_id}, Permission: {$sample->permission_id}\n";
        }
    } else {
        echo "No data found\n";
    }
    
    // Check structure
    $cols = DB::select('SHOW COLUMNS FROM model_has_permissions');
    echo "Columns:\n";
    foreach ($cols as $col) {
        echo "  - {$col->Field} ({$col->Type})\n";
    }
    echo "\n";
} catch (\Exception $e) {
    echo "❌ model_has_permissions table does not exist\n\n";
}

// Check usage in code
echo "3. CODE USAGE ANALYSIS:\n";
echo "------------------------\n";
echo "user_permissions table:\n";
echo "  - Used by: EnhancedUser model (permissions() relationship)\n";
echo "  - Used by: EnhancedPermission model (users() relationship)\n";
echo "  - Purpose: Direct user-permission assignments (bypassing roles)\n";
echo "  - Columns: user_id, permission_id, granted_by, granted_at, expires_at\n\n";

echo "model_has_permissions table:\n";
echo "  - Used by: Spatie Laravel Permission package\n";
echo "  - Purpose: Direct user-permission assignments (Spatie system)\n";
echo "  - Columns: permission_id, model_type, model_id, team_id\n\n";

// Check current permission system
echo "4. CURRENT PERMISSION SYSTEM:\n";
echo "------------------------------\n";
echo "Your system supports multiple permission sources:\n";
echo "1. Role-based permissions:\n";
echo "   user_roles → role_permissions → permissions\n";
echo "2. Direct user permissions (Custom):\n";
echo "   user_permissions → permissions\n";
echo "3. Direct user permissions (Spatie):\n";
echo "   model_has_permissions → permissions\n\n";

echo "Final user permissions = Role permissions + Direct permissions\n\n";

// Check if MenuPermissionService handles direct permissions
echo "5. MENU PERMISSION SERVICE CHECK:\n";
echo "----------------------------------\n";
echo "Current MenuPermissionService only checks:\n";
echo "  - Role-based permissions via user_roles table\n";
echo "  - Does NOT check direct user permissions\n";
echo "  - May miss permissions assigned directly to users\n\n";

echo "RECOMMENDATION:\n";
echo "If you use direct user permissions, update MenuPermissionService\n";
echo "to also check user_permissions table for complete permission set.\n";
