<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id')->index('exams_partner_id_foreign');
            $table->unsignedBigInteger('question_set_id')->nullable()->index('exams_question_set_id_foreign');
            $table->integer('total_questions')->default(10);
            $table->text('question_head')->nullable();
            $table->text('question_header')->nullable();
            $table->json('paper_settings')->nullable();
            $table->string('question_language')->default('english');
            $table->string('exam_type')->default('online');
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('duration')->comment("Duration in minutes");
            $table->integer('passing_marks')->default(0);
            $table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'cancelled'])->default('draft');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->boolean('allow_review')->default(0);
            $table->boolean('show_results_immediately')->default(1);
            $table->boolean('has_negative_marking')->default(0);
            $table->decimal('negative_marks_per_question', 5, 2)->default(0.25);
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_public')->default(0);
            $table->unsignedBigInteger('created_by')->nullable()->index('exams_created_by_foreign');
            $table->timestamps();
            $table->string('ba')->default('ক');
            $table->string('bb')->default('খ');
            $table->string('bc')->default('গ');
            $table->string('bd')->default('ঘ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
