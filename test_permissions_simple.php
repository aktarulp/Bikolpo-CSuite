<?php

/**
 * Simple test script to verify the permissions system
 */

echo "=== Testing Permissions System ===\n\n";

// Test database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=exam', 'root', '');
    echo "✓ Database connection successful\n\n";
    
    // Test roles table
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM roles");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✓ Roles table accessible: {$result['count']} roles found\n";
    
    // Test system_settings table
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM system_settings WHERE `group` = 'permissions'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✓ System settings accessible: {$result['count']} permission settings found\n";
    
    // Test user_roles table
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM user_roles");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✓ User roles table accessible: {$result['count']} user-role assignments found\n";
    
    // Show some sample data
    echo "\n=== Sample Data ===\n";
    
    // Show roles
    $stmt = $pdo->query("SELECT id, name, description FROM roles LIMIT 5");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Roles:\n";
    foreach ($roles as $role) {
        echo "  - {$role['name']}: {$role['description']}\n";
    }
    
    // Show system settings
    $stmt = $pdo->query("SELECT `key`, `value`, `type` FROM system_settings WHERE `group` = 'permissions' LIMIT 5");
    $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "\nSystem Settings:\n";
    foreach ($settings as $setting) {
        echo "  - {$setting['key']}: {$setting['value']} ({$setting['type']})\n";
    }
    
    echo "\n=== All Tests Passed! ===\n";
    echo "The permissions system database is working correctly.\n";
    
} catch (PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
