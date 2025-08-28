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
        // Create users table with all fields
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone', 15)->nullable()->unique();
            $table->enum('role', ['partner', 'student'])->default('partner');
            $table->unsignedBigInteger('role_id')->nullable();
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Create roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Create cache tables
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        // Create jobs tables
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue');
            $table->longText('payload');
            $table->tinyInteger('attempts')->unsigned();
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
            $table->index(['queue', 'reserved_at']);
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // Create password reset tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Create sessions table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('payload');
            $table->integer('last_activity');
            $table->index(['user_id', 'last_activity']);
        });

        // Create partners table with all fields including status and flag
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->text('map_location')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('alternate_mobile')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_page')->nullable();
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->year('established_year')->nullable();
            $table->string('eiin_no')->nullable();
            $table->string('trade_license_no')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('category')->nullable();
            $table->string('target_group')->nullable();
            $table->text('subjects_offered')->nullable();
            $table->string('class_range')->nullable();
            $table->integer('total_teachers')->nullable();
            $table->integer('total_students')->nullable();
            $table->boolean('batch_system')->default(false);
            $table->string('subscription_plan')->nullable();
            $table->date('subscription_start_date')->nullable();
            $table->date('subscription_end_date')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('institute_name')->nullable();
            $table->string('partner_category')->nullable();
            $table->string('owner_director_name')->nullable();
            $table->string('primary_contact_person')->nullable();
            $table->string('primary_contact_no')->nullable();
            $table->string('alternate_contact_person')->nullable();
            $table->string('alternate_contact_no')->nullable();
            $table->string('upazila_p_s')->nullable();
            $table->string('post_office')->nullable();
            $table->string('post_code')->nullable();
            $table->string('village_road_no')->nullable();
            $table->string('flat_house_no')->nullable();
            $table->string('subscription_plan_id')->nullable();
            $table->string('institute_name_bangla')->nullable();
            $table->string('slug_bangla')->nullable();
            $table->integer('year_of_establishment')->nullable();
            $table->text('short_address')->nullable();
            $table->json('course_offers')->nullable();
            $table->text('custom_courses')->nullable();
            $table->timestamps();
        });

        // Create students table with all fields including status and flag
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('student_id')->nullable()->unique();
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('photo')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('school_college')->nullable();
            $table->string('class_grade')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('parent_phone')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Create courses table with all fields including status and flag
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Create subjects table with all fields including status and flag
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Create topics table with all fields including status and flag
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->integer('chapter_number')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Create questions table with all fields including status and flag
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_type')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->unsignedBigInteger('topic_id')->nullable();
            $table->unsignedBigInteger('partner_id');
            $table->text('question_text');
            $table->string('option_a')->nullable();
            $table->string('option_b')->nullable();
            $table->string('option_c')->nullable();
            $table->string('option_d')->nullable();
            $table->enum('correct_answer', ['a', 'b', 'c', 'd'])->nullable();
            $table->text('explanation')->nullable();
            $table->integer('difficulty_level')->default(1);
            $table->integer('marks')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->json('tags')->nullable();
            $table->json('appearance_history')->nullable();
            $table->text('expected_answer_points')->nullable();
            $table->text('sample_answer')->nullable();
            $table->integer('min_words')->nullable();
            $table->integer('max_words')->nullable();
            $table->json('sub_questions')->nullable();
            $table->text('expected_answer_structure')->nullable();
            $table->text('key_concepts')->nullable();
            $table->integer('time_allocation')->nullable();
            $table->unsignedBigInteger('q_type_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Create question sets table with all fields including status and flag
        Schema::create('question_sets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('total_questions')->default(0);
            $table->integer('total_marks')->default(0);
            $table->integer('time_limit')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->string('language', 20)->default('english');
            $table->unsignedInteger('question_limit')->nullable();
            $table->text('question_head')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Create exams table with all fields including status and flag
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('question_set_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('duration')->comment('Duration in minutes');
            $table->integer('passing_marks')->default(0);
            $table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'cancelled'])->default('draft');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->boolean('allow_retake')->default(false);
            $table->boolean('show_results_immediately')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Create student exam results table with all fields including status and flag
        Schema::create('student_exam_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('exam_id');
            $table->dateTime('started_at');
            $table->dateTime('completed_at')->nullable();
            $table->integer('total_questions');
            $table->integer('correct_answers')->default(0);
            $table->integer('wrong_answers')->default(0);
            $table->integer('unanswered')->default(0);
            $table->decimal('score', 5, 2)->default(0);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->enum('status', ['in_progress', 'completed', 'abandoned'])->default('in_progress');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->json('answers')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Create question set question table with all fields including status and flag
        Schema::create('question_set_question', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_set_id');
            $table->unsignedBigInteger('question_id');
            $table->integer('order')->default(0);
            $table->unsignedInteger('marks')->default(1);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Create question types table with all fields including status and flag
        Schema::create('question_types', function (Blueprint $table) {
            $table->bigIncrements('q_type_id');
            $table->string('q_type_name', 100)->unique();
            $table->string('q_type_code', 20)->unique();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->integer('sort_order')->default(0);
            $table->boolean('has_options')->default(false);
            $table->boolean('has_explanation')->default(true);
            $table->boolean('has_image')->default(true);
            $table->boolean('has_marks')->default(true);
            $table->boolean('has_difficulty')->default(true);
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Create question history table with all fields including status and flag
        Schema::create('question_history', function (Blueprint $table) {
            $table->bigIncrements('record_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('partner_id');
            $table->string('public_exam_name');
            $table->string('private_exam_name')->nullable();
            $table->string('exam_month');
            $table->integer('exam_year');
            $table->text('remarks')->nullable();
            $table->string('exam_board')->nullable();
            $table->string('exam_type')->nullable();
            $table->string('subject_name')->nullable();
            $table->string('topic_name')->nullable();
            $table->integer('question_number')->nullable();
            $table->integer('marks_allocated')->nullable();
            $table->string('source_reference')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Create batches table with all fields including status and flag
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('year');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Create typing passages table with all fields including status and flag
        Schema::create('typing_passages', function (Blueprint $table) {
            $table->id();
            $table->text('passage_text');
            $table->string('title');
            $table->enum('language', ['english', 'bangla']);
            $table->enum('difficulty', ['easy', 'medium', 'hard']);
            $table->enum('category', ['general', 'technical', 'literature', 'news', 'academic', 'business']);
            $table->integer('word_count');
            $table->integer('character_count');
            $table->string('author')->nullable();
            $table->string('source')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->integer('usage_count')->default(0);
            $table->integer('average_wpm')->default(0);
            $table->integer('average_accuracy')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Add foreign key constraints
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('subjects', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('topics', function (Blueprint $table) {
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('q_type_id')->references('q_type_id')->on('question_types')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('question_sets', function (Blueprint $table) {
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('exams', function (Blueprint $table) {
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('question_set_id')->references('id')->on('question_sets')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('student_exam_results', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('question_set_question', function (Blueprint $table) {
            $table->foreign('question_set_id')->references('id')->on('question_sets')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('question_types', function (Blueprint $table) {
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('question_history', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('batches', function (Blueprint $table) {
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('typing_passages', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Add additional indexes (foreign keys already create indexes for their columns)
        Schema::table('question_history', function (Blueprint $table) {
            $table->index(['partner_id', 'exam_year']);
        });

        Schema::table('typing_passages', function (Blueprint $table) {
            $table->index(['language', 'difficulty']);
            $table->index(['category', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('typing_passages');
        Schema::dropIfExists('batches');
        Schema::dropIfExists('question_history');
        Schema::dropIfExists('question_types');
        Schema::dropIfExists('question_set_question');
        Schema::dropIfExists('student_exam_results');
        Schema::dropIfExists('exams');
        Schema::dropIfExists('question_sets');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('topics');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('students');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('users');
    }
};
