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
            $table->string('teacher_id')->unique();
            $table->string('full_name_en');
            $table->string('full_name_bn')->nullable();
            $table->string('mother_name')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('dob')->nullable();
            $table->string('blood_group', 5)->nullable();
            $table->string('photo')->nullable();
            $table->string('mobile', 20);
            $table->string('alt_mobile', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('emergency_contact_name', 100)->nullable();
            $table->string('emergency_contact_number', 20)->nullable();
            $table->string('designation', 100)->nullable();
            $table->string('department', 100)->nullable();
            $table->string('subject_specialization')->nullable();
            $table->date('joining_date')->nullable();
            $table->integer('experience_years')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'On Leave'])->default('Active');
            $table->string('highest_degree', 100)->nullable();
            $table->string('institution_name', 150)->nullable();
            $table->enum('salary_type', ['Monthly', 'Per Class', 'Per Student'])->nullable();
            $table->decimal('salary_amount', 10, 2)->nullable();
            $table->enum('payment_method', ['Cash', 'Bank', 'Mobile Banking'])->nullable();
            $table->string('account_details')->nullable();
            $table->text('notes')->nullable();
            $table->json('documents')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('ac_users')->onDelete('set null');
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('ac_users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('ac_users')->onDelete('set null');

            // Indexes
            $table->index(['partner_id', 'status']);
            $table->index(['partner_id', 'department']);
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