<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;

class ProttoyDemoStudentsSeeder extends Seeder
{
    public function run(): void
    {
        $slug = 'prottoy';
        $partner = \App\Models\Partner::where('slug', $slug)->first();
        if (!$partner) {
            $this->command?->warn("Partner with slug '{$slug}' not found. Skipping demo students.");
            return;
        }

        $timestamp = now();
        for ($i = 1; $i <= 50; $i++) {
            Student::create([
                'user_id' => $partner->user_id,
                'full_name' => 'Demo Student ' . $i,
                'student_id' => null,
                'date_of_birth' => '2005-01-01',
                'gender' => 'other',
                'photo' => null,
                'address' => null,
                'city' => 'Demo City',
                'school_college' => 'Prottoy Demo School',
                'class_grade' => '10',
                'parent_name' => null,
                'parent_phone' => null,
                'status' => 'active',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }

        $this->command?->info('Inserted 50 demo students for slug prottoy');
    }
}


