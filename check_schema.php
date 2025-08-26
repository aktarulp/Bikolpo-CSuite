<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Checking tables for partner_id columns and adding missing ones...\n\n";

// Tables that should have partner_id column
$tables = [
    'users', 'partners', 'students', 'courses', 'subjects', 'topics', 
    'questions', 'question_sets', 'exams', 'student_exam_results', 
    'batches', 'typing_passages', 'question_types', 'question_history', 
    'sessions', 'roles', 'cache', 'jobs', 'password_reset_tokens',
    'question_set_question'
];

// Tables that should NOT have partner_id (system tables)
$excludeTables = [
    'users', 'partners', 'roles', 'cache', 'jobs', 'password_reset_tokens', 'sessions'
];

// Tables that should have partner_id
$partnerTables = array_diff($tables, $excludeTables);

echo "Tables that should have partner_id column:\n";
foreach ($partnerTables as $table) {
    echo "- {$table}\n";
}

echo "\nChecking current schema...\n";

foreach ($partnerTables as $table) {
    try {
        if (!Schema::hasTable($table)) {
            echo "{$table}: TABLE DOES NOT EXIST - SKIPPING\n";
            continue;
        }

        $columns = DB::select("SHOW COLUMNS FROM {$table}");
        $hasPartnerId = false;
        $hasForeignKey = false;
        
        foreach ($columns as $column) {
            if ($column->Field === 'partner_id') {
                $hasPartnerId = true;
                // Check if there's a foreign key constraint
                $constraints = DB::select("
                    SELECT CONSTRAINT_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = '{$table}' 
                    AND COLUMN_NAME = 'partner_id' 
                    AND REFERENCED_TABLE_NAME IS NOT NULL
                ");
                $hasForeignKey = !empty($constraints);
                break;
            }
        }
        
        if ($hasPartnerId) {
            if ($hasForeignKey) {
                echo "{$table}: ✓ HAS partner_id WITH foreign key constraint\n";
            } else {
                echo "{$table}: ⚠ HAS partner_id BUT NO foreign key constraint - ADDING CONSTRAINT\n";
                addForeignKeyConstraint($table);
            }
        } else {
            echo "{$table}: ✗ NO partner_id - ADDING COLUMN AND CONSTRAINT\n";
            addPartnerIdColumn($table);
        }
    } catch (Exception $e) {
        echo "{$table}: ERROR - " . $e->getMessage() . "\n";
    }
}

echo "\nDone checking and updating schema.\n";

function addPartnerIdColumn($table) {
    try {
        // Check if partners table exists and has data
        if (!Schema::hasTable('partners')) {
            echo "  ERROR: partners table does not exist\n";
            return;
        }

        $partnerCount = DB::table('partners')->count();
        if ($partnerCount == 0) {
            echo "  ERROR: partners table is empty\n";
            return;
        }

        $defaultPartnerId = DB::table('partners')->first()->id;

        // Add partner_id column
        DB::statement("ALTER TABLE {$table} ADD COLUMN partner_id BIGINT UNSIGNED AFTER id");
        
        // Update existing records with default partner_id
        DB::table($table)->update(['partner_id' => $defaultPartnerId]);
        
        // Make partner_id not nullable
        DB::statement("ALTER TABLE {$table} MODIFY COLUMN partner_id BIGINT UNSIGNED NOT NULL");
        
        // Add foreign key constraint
        DB::statement("ALTER TABLE {$table} ADD CONSTRAINT fk_{$table}_partner_id FOREIGN KEY (partner_id) REFERENCES partners(id) ON DELETE CASCADE");
        
        // Add index for better performance
        DB::statement("ALTER TABLE {$table} ADD INDEX idx_{$table}_partner_id (partner_id)");
        
        echo "  ✓ Added partner_id column, foreign key constraint, and index\n";
        
    } catch (Exception $e) {
        echo "  ERROR adding partner_id: " . $e->getMessage() . "\n";
    }
}

function addForeignKeyConstraint($table) {
    try {
        // Check if foreign key already exists
        $constraints = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = '{$table}' 
            AND COLUMN_NAME = 'partner_id' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");
        
        if (!empty($constraints)) {
            echo "  ✓ Foreign key constraint already exists\n";
            return;
        }

        // Add foreign key constraint
        DB::statement("ALTER TABLE {$table} ADD CONSTRAINT fk_{$table}_partner_id FOREIGN KEY (partner_id) REFERENCES partners(id) ON DELETE CASCADE");
        
        // Add index if it doesn't exist
        $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Column_name = 'partner_id'");
        if (empty($indexes)) {
            DB::statement("ALTER TABLE {$table} ADD INDEX idx_{$table}_partner_id (partner_id)");
            echo "  ✓ Added foreign key constraint and index\n";
        } else {
            echo "  ✓ Added foreign key constraint\n";
        }
        
    } catch (Exception $e) {
        echo "  ERROR adding foreign key: " . $e->getMessage() . "\n";
    }
}
