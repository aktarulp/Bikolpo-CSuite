<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->unsignedBigInteger('student_id')->index();
            $table->unsignedBigInteger('course_id')->index();
            $table->unsignedBigInteger('batch_id')->nullable()->index();
            $table->unsignedBigInteger('partner_id')->index();
            
            // Enrollment Details
            $table->date('enrolled_at');
            $table->enum('status', [
                'active',      // Currently enrolled
                'completed',   // Successfully completed
                'dropped',     // Student dropped out
                'suspended',   // Temporarily suspended
                'transferred'  // Transferred to another course
            ])->default('active');
            
            // Completion Details
            $table->date('completion_date')->nullable();
            $table->decimal('final_grade', 5, 2)->nullable();
            $table->string('grade_letter', 2)->nullable(); // A+, A, B+, etc.
            $table->text('remarks')->nullable();
            
            // Transfer/Migration Details (if transferred)
            $table->unsignedBigInteger('transferred_to_course_id')->nullable();
            $table->date('transferred_at')->nullable();
            
            // Audit Fields
            $table->unsignedBigInteger('enrolled_by')->nullable()->index();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // For data integrity
            
            // Indexes for performance
            $table->index(['student_id', 'course_id']);
            $table->index(['student_id', 'status']);
            $table->index(['course_id', 'status']);
            $table->index(['partner_id', 'status']);
            
            // Unique constraint: A student cannot have multiple active enrollments in the same course
            $table->unique(['student_id', 'course_id', 'status'], 'unique_active_enrollment');
            
            // Foreign Key Constraints
            $table->foreign('student_id')
                  ->references('id')->on('students')
                  ->onDelete('cascade');
                  
            $table->foreign('course_id')
                  ->references('id')->on('courses')
                  ->onDelete('cascade');
                  
            $table->foreign('batch_id')
                  ->references('id')->on('batches')
                  ->onDelete('set null');
                  
            $table->foreign('partner_id')
                  ->references('id')->on('partners')
                  ->onDelete('cascade');
                  
            $table->foreign('enrolled_by')
                  ->references('id')->on('ac_users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
}
