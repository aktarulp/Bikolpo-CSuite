<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;
use App\Models\PlanFeature;

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
                'features_data' => [
                    'user_limit' => ['enabled' => true, 'value' => '50', 'limit_value' => 50],
                    'max_tests' => ['enabled' => true, 'value' => '10', 'limit_value' => 10],
                    'max_questions' => ['enabled' => true, 'value' => '100', 'limit_value' => 100],
                    'storage_gb' => ['enabled' => true, 'value' => '1', 'limit_value' => 1],
                    'email_support' => ['enabled' => true],
                    'student_dashboard' => ['enabled' => true],
                    'teacher_dashboard' => ['enabled' => true],
                    'basic_analytics' => ['enabled' => true],
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
                'features_data' => [
                    'user_limit' => ['enabled' => true, 'value' => '200', 'limit_value' => 200],
                    'max_tests' => ['enabled' => true, 'value' => '50', 'limit_value' => 50],
                    'max_questions' => ['enabled' => true, 'value' => '500', 'limit_value' => 500],
                    'storage_gb' => ['enabled' => true, 'value' => '5', 'limit_value' => 5],
                    'email_support' => ['enabled' => true],
                    'phone_support' => ['enabled' => true],
                    'student_dashboard' => ['enabled' => true],
                    'teacher_dashboard' => ['enabled' => true],
                    'standard_analytics' => ['enabled' => true],
                    'custom_branding' => ['enabled' => true],
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
                'features_data' => [
                    'user_limit' => ['enabled' => true, 'value' => '500', 'limit_value' => 500],
                    'max_tests' => ['enabled' => true, 'value' => '200', 'limit_value' => 200],
                    'max_questions' => ['enabled' => true, 'value' => '2000', 'limit_value' => 2000],
                    'storage_gb' => ['enabled' => true, 'value' => '20', 'limit_value' => 20],
                    'priority_support' => ['enabled' => true],
                    'student_dashboard' => ['enabled' => true],
                    'teacher_dashboard' => ['enabled' => true],
                    'advanced_analytics' => ['enabled' => true],
                    'custom_branding' => ['enabled' => true],
                    'api_access' => ['enabled' => true],
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
                'features_data' => [
                    'user_limit' => ['enabled' => true, 'value' => 'unlimited', 'limit_value' => -1],
                    'max_tests' => ['enabled' => true, 'value' => 'unlimited', 'limit_value' => -1],
                    'max_questions' => ['enabled' => true, 'value' => 'unlimited', 'limit_value' => -1],
                    'storage_gb' => ['enabled' => true, 'value' => '100', 'limit_value' => 100],
                    'dedicated_support' => ['enabled' => true],
                    'student_dashboard' => ['enabled' => true],
                    'teacher_dashboard' => ['enabled' => true],
                    'enterprise_analytics' => ['enabled' => true],
                    'custom_branding' => ['enabled' => true],
                    'api_access' => ['enabled' => true],
                    'white_label' => ['enabled' => true],
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
                'features_data' => [
                    'max_exams' => ['enabled' => true, 'value' => '5', 'limit_value' => 5],
                    'max_attempts' => ['enabled' => true, 'value' => '3', 'limit_value' => 3],
                    'email_support' => ['enabled' => true],
                    'basic_analytics' => ['enabled' => true],
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
                'features_data' => [
                    'max_exams' => ['enabled' => true, 'value' => 'unlimited', 'limit_value' => -1],
                    'max_attempts' => ['enabled' => true, 'value' => 'unlimited', 'limit_value' => -1],
                    'priority_support' => ['enabled' => true],
                    'advanced_analytics' => ['enabled' => true],
                    'certificates' => ['enabled' => true],
                ]
            ]
        ];

        // Create partner plans
        foreach ($partnerPlans as $planData) {
            $featuresData = $planData['features_data'];
            unset($planData['features_data']);
            
            $plan = SubscriptionPlan::create($planData);
            
            // Attach features
            $pivotData = [];
            foreach ($featuresData as $slug => $data) {
                $feature = PlanFeature::where('slug', $slug)->first();
                if ($feature) {
                    $pivotData[$feature->id] = $data;
                }
            }
            $plan->planFeatures()->sync($pivotData);
        }

        // Create student plans
        foreach ($studentPlans as $planData) {
            $featuresData = $planData['features_data'];
            unset($planData['features_data']);
            
            $plan = SubscriptionPlan::create($planData);
            
            // Attach features
            $pivotData = [];
            foreach ($featuresData as $slug => $data) {
                $feature = PlanFeature::where('slug', $slug)->first();
                if ($feature) {
                    $pivotData[$feature->id] = $data;
                }
            }
            $plan->planFeatures()->sync($pivotData);
        }
    }
}
