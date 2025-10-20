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
            $table->unsignedBigInteger('batch_id')->nullable()->index('students_batch_id_foreign');
            $table->unsignedBigInteger('course_id')->nullable()->index('students_course_id_foreign');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('enable_login', ['y', 'n'])->default('n');
            $table->timestamp('assignment_date')->nullable();
            $table->string('default_role')->nullable()->index('students_default_role_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex('students_batch_id_foreign');
            $table->dropIndex('students_course_id_foreign');
            $table->dropIndex('students_default_role_foreign');
            $table->dropColumn(['batch_id', 'course_id', 'status', 'enable_login', 'assignment_date', 'default_role']);
        });
    }
};
