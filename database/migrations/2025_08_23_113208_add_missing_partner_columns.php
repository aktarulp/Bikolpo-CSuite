<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add fields only if they don't exist
        $columns = [
            'owner_name' => 'VARCHAR(255) NULL',
            'slug' => 'VARCHAR(255) NULL',
            'mobile' => 'VARCHAR(255) NULL',
            'alternate_mobile' => 'VARCHAR(255) NULL',
            'website' => 'VARCHAR(255) NULL',
            'facebook_page' => 'VARCHAR(255) NULL',
            'division' => 'VARCHAR(255) NULL',
            'district' => 'VARCHAR(255) NULL',
            'upazila' => 'VARCHAR(255) NULL',
            'map_location' => 'TEXT NULL',
            'established_year' => 'INT NULL',
            'eiin_no' => 'VARCHAR(255) NULL',
            'trade_license_no' => 'VARCHAR(255) NULL',
            'tin_no' => 'VARCHAR(255) NULL',
            'category' => 'VARCHAR(255) NULL',
            'target_group' => 'VARCHAR(255) NULL',
            'subjects_offered' => 'TEXT NULL',
            'class_range' => 'VARCHAR(255) NULL',
            'subscription_plan' => 'VARCHAR(255) NULL',
            'subscription_start_date' => 'DATE NULL',
            'subscription_end_date' => 'DATE NULL',
            'logo' => 'VARCHAR(255) NULL',
            'batch_system' => 'BOOLEAN DEFAULT FALSE'
        ];

        foreach ($columns as $column => $definition) {
            if (!$this->columnExists('partners', $column)) {
                DB::statement("ALTER TABLE partners ADD COLUMN {$column} {$definition}");
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn([
                'owner_name',
                'slug',
                'mobile',
                'alternate_mobile',
                'website',
                'facebook_page',
                'division',
                'district',
                'upazila',
                'map_location',
                'established_year',
                'eiin_no',
                'trade_license_no',
                'tin_no',
                'category',
                'target_group',
                'subjects_offered',
                'class_range',
                'subscription_plan',
                'subscription_start_date',
                'subscription_end_date',
                'logo',
                'batch_system'
            ]);
        });
    }

    /**
     * Check if a column exists in a table
     */
    private function columnExists($table, $column): bool
    {
        $columns = DB::select("SHOW COLUMNS FROM {$table} LIKE '{$column}'");
        return count($columns) > 0;
    }
};
