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
            $table->unsignedBigInteger('course_id')->nullable()->index('questions_course_id_foreign');
            $table->unsignedBigInteger('subject_id')->nullable()->index('questions_subject_id_foreign');
            $table->unsignedBigInteger('topic_id')->nullable()->index('questions_topic_id_foreign');
            $table->unsignedBigInteger('partner_id')->index('questions_partner_id_foreign');
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
            $table->longText('tags')->nullable();
            $table->longText('appearance_history')->nullable();
            $table->text('expected_answer_points')->nullable();
            $table->text('sample_answer')->nullable();
            $table->integer('min_words')->nullable();
            $table->integer('max_words')->nullable();
            $table->longText('sub_questions')->nullable();
            $table->text('expected_answer_structure')->nullable();
            $table->text('key_concepts')->nullable();
            $table->integer('time_allocation')->nullable();
            $table->unsignedBigInteger('q_type_id')->nullable()->index('questions_q_type_id_foreign');
            $table->unsignedBigInteger('created_by')->nullable()->index('questions_created_by_foreign');
            $table->timestamps();
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
