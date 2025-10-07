<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_types', function (Blueprint $table) {
            $table->bigIncrements('q_type_id');
            $table->string('q_type_name', 100)->unique('question_types_q_type_name_unique');
            $table->string('q_type_code', 20)->unique('question_types_q_type_code_unique');
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->integer('sort_order')->default(0);
            $table->boolean('has_options')->default(0);
            $table->boolean('has_explanation')->default(1);
            $table->boolean('has_image')->default(1);
            $table->boolean('has_marks')->default(1);
            $table->boolean('has_difficulty')->default(1);
            $table->unsignedBigInteger('partner_id')->nullable()->index('question_types_partner_id_foreign');
            $table->unsignedBigInteger('created_by')->nullable()->index('question_types_created_by_foreign');
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
        Schema::dropIfExists('question_types');
    }
}
