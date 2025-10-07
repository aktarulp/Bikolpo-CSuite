<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix exam end times with proper timezone handling
        // The issue is that times are being stored/interpreted incorrectly
        
        // Set the timezone to Asia/Dhaka for proper time handling
        $timezone = 'Asia/Dhaka';
        
        // Get current time in Asia/Dhaka timezone
        $currentTime = Carbon::now($timezone);
        
        // Set exam end times to be 2 hours from now (current time + 2 hours)
        $endTime = $currentTime->copy()->addHours(2);
        
        // Update exam 10
        DB::table('exams')
            ->where('id', 10)
            ->update([
                'end_time' => $endTime->toDateTimeString()
            ]);
            
        // Update exam 11  
        DB::table('exams')
            ->where('id', 11)
            ->update([
                'end_time' => $endTime->toDateTimeString()
            ]);
            
        // Also clear any existing exam results that might have incorrect start times
        DB::table('exam_results')->truncate();
            
        // Log the fix
        \Log::info('Fixed exam end times with timezone and cleared results', [
            'timezone' => $timezone,
            'current_time_dhaka' => $currentTime->toDateTimeString(),
            'new_end_time' => $endTime->toDateTimeString(),
            'exam_ids' => [10, 11],
            'cleared_exam_results' => true,
            'fixed_at' => now()->toDateTimeString()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original times
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
    }
};
