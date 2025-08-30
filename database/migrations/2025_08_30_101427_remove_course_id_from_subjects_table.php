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
        Schema::table('subjects', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['course_id']);
            
            // Remove the course_id column
            $table->dropColumn('course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            // Add the course_id column back
            $table->unsignedBigInteger('course_id')->after('id');
            
            // Add the foreign key constraint back
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }
};
