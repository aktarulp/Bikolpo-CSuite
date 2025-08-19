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
        // Remove all comprehensive questions from the database
        DB::table('questions')->where('question_type', 'comprehensive')->delete();
        
        // Remove comprehensive question type from question_types table
        DB::table('question_types')->where('q_type_code', 'COMP')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add comprehensive question type
        DB::table('question_types')->insert([
            'q_type_name' => 'Comprehensive Question',
            'q_type_code' => 'COMP',
            'description' => 'Complex questions that may combine multiple concepts',
            'status' => 'active',
            'sort_order' => 3,
            'has_options' => false,
            'has_explanation' => true,
            'has_image' => true,
            'has_marks' => true,
            'has_difficulty' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
