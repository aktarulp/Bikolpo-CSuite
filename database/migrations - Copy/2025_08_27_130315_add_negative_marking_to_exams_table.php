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
        Schema::table('exams', function (Blueprint $table) {
            $table->boolean('has_negative_marking')->default(false)->after('show_results_immediately');
            $table->decimal('negative_marks_per_question', 5, 2)->default(0.25)->after('has_negative_marking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn(['has_negative_marking', 'negative_marks_per_question']);
        });
    }
};
