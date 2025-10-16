<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;
use App\Models\PlanFeature;

class FreePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Free Plan
        $freePlan = SubscriptionPlan::updateOrCreate(
            ['slug' => 'free'],
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Perfect for getting started',
                'price' => 0,
                'currency' => 'BDT',
                'billing_cycle' => 'monthly',
                'partner_type' => 'partner',
                'sort_order' => 0,
                'is_active' => true,
                'is_popular' => false,
            ]
        );

        // Get features to assign to Free Plan
        $features = [
            'user_limit' => ['enabled' => true, 'value' => '50', 'limit_value' => 50],
            'max_tests' => ['enabled' => true, 'value' => '10', 'limit_value' => 10],
            'max_questions' => ['enabled' => true, 'value' => '100', 'limit_value' => 100],
            'storage_limit' => ['enabled' => true, 'value' => '1', 'limit_value' => 1],
            'email_support' => ['enabled' => true, 'value' => null, 'limit_value' => null],
            'basic_analytics' => ['enabled' => true, 'value' => null, 'limit_value' => null],
            'student_dashboard' => ['enabled' => true, 'value' => null, 'limit_value' => null],
        ];

        // Sync features to Free Plan
        $featureData = [];
        foreach ($features as $featureSlug => $data) {
            $feature = PlanFeature::where('slug', $featureSlug)->first();
            if ($feature) {
                $featureData[$feature->id] = [
                    'is_enabled' => $data['enabled'],
                    'value' => $data['value'],
                    'limit_value' => $data['limit_value'],
                ];
            }
        }

        $freePlan->features()->sync($featureData);

        $this->command->info('Free Plan created/updated with table-driven features!');
    }
}
