<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Support\Str;

class PartnerComprehensiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing partners or create a sample user if none exist
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $partners = Partner::all();
        
        if ($partners->isEmpty()) {
            $this->command->error('No partners found. Please run PartnerSeeder first.');
            return;
        }

        foreach ($partners as $partner) {
            $partner->update([
                'slug' => Str::slug($partner->user->name ?? 'partner-' . $partner->id),
                'cover_photo' => null, // Will be set when actual photos are uploaded
                'owner_name' => fake()->name(),
                'mobile' => fake()->phoneNumber(),
                'alternate_mobile' => fake()->optional(0.7)->phoneNumber(),
                'website' => fake()->optional(0.6)->url(),
                'facebook_page' => fake()->optional(0.5)->url(),
                'division' => fake()->randomElement(['Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Barisal', 'Sylhet', 'Rangpur', 'Mymensingh']),
                'district' => fake()->randomElement(['Dhaka', 'Gazipur', 'Narayanganj', 'Tangail', 'Manikganj', 'Munshiganj', 'Rajbari', 'Madaripur']),
                'upazila' => fake()->randomElement(['Dhamrai', 'Savar', 'Keraniganj', 'Nawabganj', 'Dohar']),
                'map_location' => fake()->optional(0.4)->text(),
                'established_year' => fake()->numberBetween(1990, 2023),
                'eiin_no' => fake()->optional(0.8)->numerify('########'),
                'trade_license_no' => fake()->optional(0.7)->numerify('##########'),
                'tin_no' => fake()->optional(0.6)->numerify('##########'),
                'category' => fake()->randomElement(['School', 'College', 'University', 'Coaching Center', 'Training Institute']),
                'target_group' => fake()->randomElement(['Primary Students', 'Secondary Students', 'Higher Secondary Students', 'University Students', 'All Ages']),
                'subjects_offered' => fake()->randomElement([
                    'Mathematics, Physics, Chemistry, Biology',
                    'English, Bangla, Mathematics, Science',
                    'Computer Science, Programming, Web Development',
                    'Business Studies, Accounting, Economics',
                    'All Subjects'
                ]),
                'class_range' => fake()->randomElement(['Class 1-5', 'Class 6-10', 'Class 11-12', 'All Classes', 'University Level']),
                'total_teachers' => fake()->numberBetween(5, 100),
                'total_students' => fake()->numberBetween(50, 2000),
                'batch_system' => fake()->boolean(),
                'subscription_plan' => fake()->randomElement(['Basic', 'Standard', 'Premium', 'Enterprise']),
                'subscription_start_date' => fake()->dateTimeBetween('-1 year', 'now'),
                'subscription_end_date' => fake()->dateTimeBetween('now', '+1 year'),
                'payment_status' => fake()->randomElement(['pending', 'paid', 'overdue', 'cancelled']),
                'created_by' => $user->id,
            ]);
        }

        $this->command->info('Partners table has been populated with comprehensive data!');
    }
}
