<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Partner;
use App\Models\EnhancedUser;
use App\Models\EnhancedRole;
use App\Models\Student;

class PartnerTestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the authenticated user
        $user = auth()->user();
        if (!$user || !$user->partner) {
            $this->command->error('No authenticated user with partner found. Please login first.');
            return;
        }
        
        $partner = $user->partner;
        
        // Get roles
        $adminRole = EnhancedRole::where('name', 'admin')->first();
        $partnerRole = EnhancedRole::where('name', 'partner')->first();
        $staffRole = EnhancedRole::where('name', 'staff')->first();
        $studentRole = EnhancedRole::where('name', 'student')->first();
        
        // Create test students for this partner
        for ($i = 1; $i <= 5; $i++) {
            $student = Student::create([
                'partner_id' => $partner->id,
                'full_name' => "Test Student {$i}",
                'email' => "student{$i}@test.com",
                'phone' => "0170000000{$i}",
                'student_id' => "STU" . str_pad($i, 9, '0', STR_PAD_LEFT),
                'status' => 'active'
            ]);
            
            $this->command->info("Created student: {$student->full_name}");
        }
        
        $this->command->info('Test students created successfully!');
        $this->command->info('You can now create user accounts for these students through the Partner Settings -> Create User interface.');
    }
}