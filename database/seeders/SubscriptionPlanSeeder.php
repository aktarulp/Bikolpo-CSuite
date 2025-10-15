<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Partner Plans
        $partnerPlans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Perfect for getting started',
                'price' => 0,
                'currency' => 'BDT',
                'billing_cycle' => 'monthly',
                'partner_type' => 'partner',
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 1,
                'features' => [
                    'max_students' => 50,
                    'max_tests' => 10,
                    'max_questions' => 100,
                    'storage_gb' => 1,
                    'support' => 'email',
                    'analytics' => 'basic',
                    'custom_branding' => false,
                    'api_access' => false
                ],
                'limits' => [
                    'students' => 50,
                    'tests' => 10,
                    'questions' => 100,
                    'storage' => 1
                ]
            ],
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'description' => 'For small coaching centers',
                'price' => 2500,
                'currency' => 'BDT',
                'billing_cycle' => 'monthly',
                'partner_type' => 'partner',
                'is_active' => true,
                'is_popular' => true,
                'sort_order' => 2,
                'features' => [
                    'max_students' => 200,
                    'max_tests' => 50,
                    'max_questions' => 500,
                    'storage_gb' => 5,
                    'support' => 'email_phone',
                    'analytics' => 'standard',
                    'custom_branding' => true,
                    'api_access' => false
                ],
                'limits' => [
                    'students' => 200,
                    'tests' => 50,
                    'questions' => 500,
                    'storage' => 5
                ]
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'description' => 'For growing centers',
                'price' => 5000,
                'currency' => 'BDT',
                'billing_cycle' => 'monthly',
                'partner_type' => 'partner',
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 3,
                'features' => [
                    'max_students' => 500,
                    'max_tests' => 200,
                    'max_questions' => 2000,
                    'storage_gb' => 20,
                    'support' => 'priority',
                    'analytics' => 'advanced',
                    'custom_branding' => true,
                    'api_access' => true
                ],
                'limits' => [
                    'students' => 500,
                    'tests' => 200,
                    'questions' => 2000,
                    'storage' => 20
                ]
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'For large organizations',
                'price' => 10000,
                'currency' => 'BDT',
                'billing_cycle' => 'monthly',
                'partner_type' => 'partner',
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 4,
                'features' => [
                    'max_students' => -1, // unlimited
                    'max_tests' => -1, // unlimited
                    'max_questions' => -1, // unlimited
                    'storage_gb' => 100,
                    'support' => 'dedicated',
                    'analytics' => 'enterprise',
                    'custom_branding' => true,
                    'api_access' => true,
                    'white_label' => true
                ],
                'limits' => [
                    'students' => -1, // unlimited
                    'tests' => -1, // unlimited
                    'questions' => -1, // unlimited
                    'storage' => 100
                ]
            ]
        ];

        // Student Plans
        $studentPlans = [
            [
                'name' => 'Student Free',
                'slug' => 'student-free',
                'description' => 'Free access for students',
                'price' => 0,
                'currency' => 'BDT',
                'billing_cycle' => 'monthly',
                'partner_type' => 'student',
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 1,
                'features' => [
                    'max_exams' => 5,
                    'max_attempts' => 3,
                    'support' => 'email',
                    'analytics' => 'basic'
                ],
                'limits' => [
                    'exams' => 5,
                    'attempts' => 3
                ]
            ],
            [
                'name' => 'Student Premium',
                'slug' => 'student-premium',
                'description' => 'Premium features for students',
                'price' => 500,
                'currency' => 'BDT',
                'billing_cycle' => 'monthly',
                'partner_type' => 'student',
                'is_active' => true,
                'is_popular' => true,
                'sort_order' => 2,
                'features' => [
                    'max_exams' => -1, // unlimited
                    'max_attempts' => -1, // unlimited
                    'support' => 'priority',
                    'analytics' => 'advanced',
                    'certificates' => true
                ],
                'limits' => [
                    'exams' => -1, // unlimited
                    'attempts' => -1 // unlimited
                ]
            ]
        ];

        // Create partner plans
        foreach ($partnerPlans as $plan) {
            SubscriptionPlan::create($plan);
        }

        // Create student plans
        foreach ($studentPlans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}
