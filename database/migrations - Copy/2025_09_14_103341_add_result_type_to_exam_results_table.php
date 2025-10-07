<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('exam_results', function (Blueprint $table) {
            // Add result_type column with enum values 'auto' and 'manual'
            // Default value is 'auto' and it's nullable
            $table->enum('result_type', ['auto', 'manual'])
                  ->default('auto')
                  ->nullable()
                  ->after('status')
                  ->comment('Type of result: auto (system generated) or manual (manually entered)');
        });

        // Update all existing rows to have result_type = 'auto'
        DB::table('exam_results')
          ->whereNull('result_type')
          ->update(['result_type' => 'auto']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_results', function (Blueprint $table) {
            // Drop the result_type column
            $table->dropColumn('result_type');
        });
    }
};
