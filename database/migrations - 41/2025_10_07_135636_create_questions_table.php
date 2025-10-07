<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
            $table->text('correct_answer')->nullable();
            $table->text('explanation')->nullable();
            $table->integer('difficulty_level')->default(1);
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
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
            
            $table->foreign('course_id', 'questions_course_id_foreign')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('created_by', 'questions_created_by_foreign')->references('id')->on('users')->onDelete('set NULL');
            $table->foreign('partner_id', 'questions_partner_id_foreign')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('q_type_id', 'questions_q_type_id_foreign')->references('q_type_id')->on('question_types')->onDelete('set NULL');
            $table->foreign('subject_id', 'questions_subject_id_foreign')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('topic_id', 'questions_topic_id_foreign')->references('id')->on('topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
