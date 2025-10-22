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
        Schema::table('partners', function (Blueprint $table) {
            // Check and drop columns if they exist
            $columnsToRemove = [
                'target_group',
                'class_range',
                'total_students',
                'subjects_offered',
                'custom_courses',
            ];

            $existingColumns = [];
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('partners', $column)) {
                    $existingColumns[] = $column;
                }
            }

            if (!empty($existingColumns)) {
                $table->dropColumn($existingColumns);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            // Restore Academic Information fields if rolled back
            $table->string('target_group')->nullable()->after('category');
            $table->string('class_range', 100)->nullable()->after('target_group');
            $table->integer('total_students')->nullable()->after('class_range');
            $table->text('subjects_offered')->nullable()->after('batch_system');
            $table->text('custom_courses')->nullable()->after('course_offers');
        });
    }
};
