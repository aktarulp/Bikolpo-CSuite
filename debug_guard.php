<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\EnhancedUser;
use Spatie\Permission\Models\Role;

echo "=== Guard Debug ===\n";

$user = EnhancedUser::first();
echo "User guard: web\n"; // Default guard for web users

$partnerRole = Role::where('name', 'Partner')->first();
echo "Partner role guard: " . $partnerRole->guard_name . "\n";

// Try to assign role with explicit guard
try {
    $user->syncRoles([]);
    $user->assignRole('Partner');
    echo "✅ Role assigned successfully\n";
    
    $user = $user->fresh();
    echo "User roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
    echo "Has Partner role: " . ($user->hasRole('Partner') ? 'Yes' : 'No') . "\n";
    echo "Can access menu-dashboard: " . ($user->can('menu-dashboard') ? 'Yes' : 'No') . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
