<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "DETAILED ROLE ASSIGNMENT ANALYSIS\n";
echo "==================================\n\n";

// Check user_roles table
echo "1. USER_ROLES TABLE:\n";
echo "--------------------\n";
$userRolesCount = DB::table('user_roles')->count();
echo "Records: {$userRolesCount}\n";

if ($userRolesCount > 0) {
    echo "Sample data:\n";
    $samples = DB::table('user_roles')->limit(3)->get();
    foreach ($samples as $sample) {
        $roleId = isset($sample->enhanced_role_id) ? $sample->enhanced_role_id : (isset($sample->role_id) ? $sample->role_id : 'N/A');
        echo "  User: {$sample->user_id}, Role: {$roleId}\n";
    }
} else {
    echo "No data found\n";
}

// Check structure
$cols = DB::select('SHOW COLUMNS FROM user_roles');
echo "Columns: ";
foreach ($cols as $col) {
    echo $col->Field . " ";
}
echo "\n\n";

// Check model_has_roles table (Spatie)
echo "2. MODEL_HAS_ROLES TABLE (Spatie):\n";
echo "-----------------------------------\n";
$modelRolesCount = DB::table('model_has_roles')->count();
echo "Records: {$modelRolesCount}\n";

if ($modelRolesCount > 0) {
    echo "Sample data:\n";
    $samples = DB::table('model_has_roles')->limit(3)->get();
    foreach ($samples as $sample) {
        echo "  Model: {$sample->model_type}, ID: {$sample->model_id}, Role: {$sample->role_id}\n";
    }
} else {
    echo "No data found\n";
}

// Check structure
$cols = DB::select('SHOW COLUMNS FROM model_has_roles');
echo "Columns: ";
foreach ($cols as $col) {
    echo $col->Field . " ";
}
echo "\n\n";

// Analysis
echo "3. ANALYSIS:\n";
echo "------------\n";

if ($userRolesCount > 0 && $modelRolesCount > 0) {
    echo "⚠️  BOTH tables have data - potential duplication!\n";
} elseif ($userRolesCount > 0) {
    echo "✅ Using user_roles table (custom system)\n";
} elseif ($modelRolesCount > 0) {
    echo "✅ Using model_has_roles table (Spatie system)\n";
} else {
    echo "❌ No role assignments found in either table!\n";
}

echo "\n4. USAGE IN CODE:\n";
echo "-----------------\n";
echo "- MenuPermissionService uses: user_roles table\n";
echo "- Spatie package uses: model_has_roles table\n";
echo "- EnhancedUser model uses: user_roles table\n";
echo "- Some migration scripts use: model_has_roles table\n";
