<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_sets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id')->index('question_sets_partner_id_foreign');
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
            $table->unsignedBigInteger('created_by')->nullable()->index('question_sets_created_by_foreign');
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
        Schema::dropIfExists('question_sets');
    }
}
