<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Partner;
use Carbon\Carbon;

class TestPublicExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partner = Partner::first();
        
        Exam::create([
            'partner_id' => $partner->id,
            'title' => 'Test Public Exam',
            'description' => 'This is a test public exam for system admin verification',
            'is_public' => true,
            'status' => 'published',
            'duration' => 60,
            'total_questions' => 50,
            'passing_marks' => 20,
            'start_time' => Carbon::now()->addHour(),
            'end_time' => Carbon::now()->addHours(2),
        ]);
    }
}