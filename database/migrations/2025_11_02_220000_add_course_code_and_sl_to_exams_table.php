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
            // Add course_code column
            $table->string('course_code')->nullable()->after('exam_number');
            
            // Add foreign key relationship to courses table
            $table->unsignedBigInteger('course_id')->nullable()->after('course_code');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
            
            // Add SL (serial number) column
            $table->integer('sl')->nullable()->after('course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropColumn(['sl', 'course_id', 'course_code']);
        });
    }
};