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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_id', 20)->unique(); // auto generated ID like TCH-2025-001
            
            // Personal Information
            $table->string('full_name_en', 150);
            $table->string('full_name_bn', 150)->nullable();
            $table->string('father_name', 150)->nullable();
            $table->string('mother_name', 150)->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('dob')->nullable();
            $table->string('blood_group', 5)->nullable();
            $table->string('photo')->nullable();
            
            // Contact Information
            $table->string('mobile', 20);
            $table->string('alt_mobile', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('emergency_contact_name', 100)->nullable();
            $table->string('emergency_contact_number', 20)->nullable();
            
            // Professional Information
            $table->string('designation', 100)->nullable();
            $table->string('department', 100)->nullable();
            $table->string('subject_specialization')->nullable();
            $table->date('joining_date')->nullable();
            $table->integer('experience_years')->default(0);
            $table->enum('status', ['Active', 'Inactive', 'On Leave'])->default('Active');
            
            // Education
            $table->string('highest_degree', 100)->nullable();
            $table->string('institution_name', 150)->nullable();
            
            // Salary & Payment
            $table->enum('salary_type', ['Monthly', 'Per Class', 'Per Student'])->nullable();
            $table->decimal('salary_amount', 10, 2)->nullable();
            $table->enum('payment_method', ['Cash', 'Bank', 'Mobile Banking'])->nullable();
            $table->string('account_details')->nullable();
            
            // Others
            $table->text('notes')->nullable();
            $table->json('documents')->nullable(); // for storing file paths like NID, CV etc
            $table->decimal('rating', 3, 2)->default(0.00);
            
            // System fields
            $table->unsignedBigInteger('user_id')->nullable(); // if teacher has login access
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // Add soft deletes column
            
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            
            // Indexes
            $table->index(['partner_id', 'status']);
            $table->index('teacher_id');
            $table->index('mobile');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
