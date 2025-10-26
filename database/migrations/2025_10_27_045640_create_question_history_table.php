<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_history', function (Blueprint $table) {
            $table->bigIncrements('record_id');
            $table->unsignedBigInteger('question_id')->index('question_history_question_id_foreign');
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
            $table->boolean('is_verified')->default(0);
            $table->string('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable()->index('question_history_created_by_foreign');
            $table->timestamps();
            
            $table->index(['partner_id', 'exam_year'], 'question_history_partner_id_exam_year_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_history');
    }
}
