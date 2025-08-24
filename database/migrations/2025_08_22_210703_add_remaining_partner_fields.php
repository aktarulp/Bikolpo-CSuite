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
            'institute_name' => 'VARCHAR(255) NULL',
            'partner_category' => 'VARCHAR(255) NULL',
            'owner_director_name' => 'VARCHAR(255) NULL',
            'primary_contact_person' => 'VARCHAR(255) NULL',
            'primary_contact_no' => 'VARCHAR(255) NULL',
            'alternate_contact_person' => 'VARCHAR(255) NULL',
            'alternate_contact_no' => 'VARCHAR(255) NULL',
            'upazila_p_s' => 'VARCHAR(255) NULL',
            'post_office' => 'VARCHAR(255) NULL',
            'post_code' => 'VARCHAR(255) NULL',
            'village_road_no' => 'VARCHAR(255) NULL',
            'flat_house_no' => 'VARCHAR(255) NULL',
            'subscription_plan_id' => 'VARCHAR(255) NULL'
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
                'institute_name',
                'partner_category',
                'owner_director_name',
                'primary_contact_person',
                'primary_contact_no',
                'alternate_contact_person',
                'alternate_contact_no',
                'upazila_p_s',
                'post_office',
                'post_code',
                'village_road_no',
                'flat_house_no',
                'subscription_plan_id'
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
