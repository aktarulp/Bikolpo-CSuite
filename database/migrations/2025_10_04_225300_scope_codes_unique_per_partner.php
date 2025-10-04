<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Courses: drop global unique index on code and add unique(partner_id, code)
        Schema::table('courses', function (Blueprint $table) {
            // Drop existing unique index on code if it exists
            try {
                $table->dropUnique('courses_code_unique');
            } catch (\Throwable $e) {
                // Index may not exist in some environments; ignore
            }
            // Add composite unique index
            $table->unique(['partner_id', 'code'], 'courses_partner_id_code_unique');
        });

        // Subjects: drop global unique index on code and add unique(partner_id, code)
        Schema::table('subjects', function (Blueprint $table) {
            try {
                $table->dropUnique('subjects_code_unique');
            } catch (\Throwable $e) {}
            $table->unique(['partner_id', 'code'], 'subjects_partner_id_code_unique');
        });

        // Topics: drop global unique index on code and add unique(partner_id, code)
        Schema::table('topics', function (Blueprint $table) {
            try {
                $table->dropUnique('topics_code_unique');
            } catch (\Throwable $e) {}
            $table->unique(['partner_id', 'code'], 'topics_partner_id_code_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to global unique on code
        Schema::table('courses', function (Blueprint $table) {
            try {
                $table->dropUnique('courses_partner_id_code_unique');
            } catch (\Throwable $e) {}
            $table->unique('code', 'courses_code_unique');
        });

        Schema::table('subjects', function (Blueprint $table) {
            try {
                $table->dropUnique('subjects_partner_id_code_unique');
            } catch (\Throwable $e) {}
            $table->unique('code', 'subjects_code_unique');
        });

        Schema::table('topics', function (Blueprint $table) {
            try {
                $table->dropUnique('topics_partner_id_code_unique');
            } catch (\Throwable $e) {}
            $table->unique('code', 'topics_code_unique');
        });
    }
};