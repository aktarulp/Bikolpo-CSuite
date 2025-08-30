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
        Schema::rename('course_subject', 'subject_on_course');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('subject_on_course', 'course_subject');
    }
};
