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
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable()->after('partner_id');
            $table->unsignedBigInteger('batch_id')->nullable()->after('course_id');
        });

        // Add foreign key constraints
        Schema::table('students', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key constraints first
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropForeign(['batch_id']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['course_id', 'batch_id']);
        });
    }
};
