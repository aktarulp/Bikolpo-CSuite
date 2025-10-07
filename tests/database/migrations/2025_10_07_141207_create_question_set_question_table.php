<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionSetQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_set_question', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_set_id')->index('question_set_question_question_set_id_foreign');
            $table->unsignedBigInteger('question_id')->index('question_set_question_question_id_foreign');
            $table->integer('order')->default(0);
            $table->unsignedInteger('marks')->default(1);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable()->index('question_set_question_created_by_foreign');
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
        Schema::dropIfExists('question_set_question');
    }
}
