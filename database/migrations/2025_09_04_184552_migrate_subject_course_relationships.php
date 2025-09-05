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
        // Migrate data from pivot table to direct relationship
        // For each subject, assign it to the first course it's associated with
        $pivotData = DB::table('subject_on_course')->get();
        
        foreach ($pivotData as $pivot) {
            // Update the subject with the course_id
            DB::table('subjects')
                ->where('id', $pivot->subject_id)
                ->update(['course_id' => $pivot->course_id]);
        }
        
        // If there are subjects without course assignments, assign them to the first available course
        $subjectsWithoutCourse = DB::table('subjects')
            ->whereNull('course_id')
            ->get();
            
        $firstCourse = DB::table('courses')->where('status', 'active')->first();
        
        if ($firstCourse && $subjectsWithoutCourse->count() > 0) {
            DB::table('subjects')
                ->whereNull('course_id')
                ->update(['course_id' => $firstCourse->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear the course_id from subjects
        DB::table('subjects')->update(['course_id' => null]);
    }
};