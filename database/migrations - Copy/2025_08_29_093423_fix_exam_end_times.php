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
        // Fix exam end times that are incorrectly set
        // Based on the debug output, these exams should end today (August 29th)
        
        DB::table('exams')
            ->where('id', 10)
            ->update([
                'end_time' => '2025-08-29 11:30:00'
            ]);
            
        DB::table('exams')
            ->where('id', 11)
            ->update([
                'end_time' => '2025-08-29 11:30:00'
            ]);
            
        // Log the fix
        \Log::info('Fixed exam end times', [
            'exam_id_10' => '2025-08-29 11:30:00',
            'exam_id_11' => '2025-08-29 11:30:00',
            'fixed_at' => now()->toDateTimeString()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original times (if needed)
        DB::table('exams')
            ->where('id', 10)
            ->update([
                'end_time' => '2025-08-31 11:20:00'
            ]);
            
        DB::table('exams')
            ->where('id', 11)
            ->update([
                'end_time' => '2025-08-29 11:29:00'
            ]);
    }
};
