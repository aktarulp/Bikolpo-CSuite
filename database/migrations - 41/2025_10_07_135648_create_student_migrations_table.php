<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentMigrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_migrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('from_course_id')->nullable();
            $table->unsignedBigInteger('to_course_id')->nullable();
            $table->unsignedBigInteger('from_batch_id')->nullable();
            $table->unsignedBigInteger('to_batch_id')->nullable();
            $table->date('migration_date');
            $table->text('reason')->nullable();
            $table->string('status')->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['student_id', 'migration_date'], 'student_migrations_student_id_migration_date_index');
            $table->index(['from_course_id', 'to_course_id'], 'student_migrations_from_course_id_to_course_id_index');
            $table->index(['from_batch_id', 'to_batch_id'], 'student_migrations_from_batch_id_to_batch_id_index');
            $table->foreign('from_batch_id', 'student_migrations_from_batch_id_foreign')->references('id')->on('batches')->onDelete('set NULL');
            $table->foreign('from_course_id', 'student_migrations_from_course_id_foreign')->references('id')->on('courses')->onDelete('set NULL');
            $table->foreign('student_id', 'student_migrations_student_id_foreign')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('to_batch_id', 'student_migrations_to_batch_id_foreign')->references('id')->on('batches')->onDelete('set NULL');
            $table->foreign('to_course_id', 'student_migrations_to_course_id_foreign')->references('id')->on('courses')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_migrations');
    }
}
