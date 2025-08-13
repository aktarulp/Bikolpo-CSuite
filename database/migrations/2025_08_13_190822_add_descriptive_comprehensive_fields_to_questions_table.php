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
        Schema::table('questions', function (Blueprint $table) {
            // Descriptive question fields
            if (!Schema::hasColumn('questions', 'expected_answer_points')) {
                $table->text('expected_answer_points')->nullable()->after('explanation');
            }
            if (!Schema::hasColumn('questions', 'sample_answer')) {
                $table->text('sample_answer')->nullable()->after('expected_answer_points');
            }
            if (!Schema::hasColumn('questions', 'min_words')) {
                $table->integer('min_words')->nullable()->after('sample_answer');
            }
            if (!Schema::hasColumn('questions', 'max_words')) {
                $table->integer('max_words')->nullable()->after('min_words');
            }
            
            // Comprehensive question fields
            if (!Schema::hasColumn('questions', 'sub_questions')) {
                $table->text('sub_questions')->nullable()->after('max_words');
            }
            if (!Schema::hasColumn('questions', 'expected_answer_structure')) {
                $table->text('expected_answer_structure')->nullable()->after('sub_questions');
            }
            if (!Schema::hasColumn('questions', 'key_concepts')) {
                $table->text('key_concepts')->nullable()->after('expected_answer_structure');
            }
            if (!Schema::hasColumn('questions', 'time_allocation')) {
                $table->integer('time_allocation')->nullable()->after('key_concepts');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn([
                'expected_answer_points',
                'sample_answer',
                'min_words',
                'max_words',
                'sub_questions',
                'expected_answer_structure',
                'key_concepts',
                'time_allocation'
            ]);
        });
    }
};
