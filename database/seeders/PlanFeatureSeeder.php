<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PlanFeature;

class PlanFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            // Dashboard Features
            [
                'name' => 'Student Dashboard',
                'slug' => 'student_dashboard',
                'description' => 'Access to student dashboard with exam history, progress tracking, and performance analytics',
                'category' => 'dashboard',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Teacher Dashboard',
                'slug' => 'teacher_dashboard',
                'description' => 'Comprehensive teacher dashboard for managing students, creating exams, and tracking progress',
                'category' => 'dashboard',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Admin Dashboard',
                'slug' => 'admin_dashboard',
                'description' => 'Advanced admin dashboard for system management, user oversight, and analytics',
                'category' => 'dashboard',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 3
            ],

            // User Management
            [
                'name' => 'Multi User Support',
                'slug' => 'multi_user',
                'description' => 'Support for multiple users with role-based access control',
                'category' => 'users',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 10
            ],
            [
                'name' => 'User Limit',
                'slug' => 'user_limit',
                'description' => 'Maximum number of users allowed',
                'category' => 'users',
                'type' => 'numeric',
                'unit' => 'users',
                'is_active' => true,
                'sort_order' => 11
            ],
            [
                'name' => 'Role Management',
                'slug' => 'role_management',
                'description' => 'Advanced role and permission management system',
                'category' => 'users',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 12
            ],

            // Analytics & Reporting
            [
                'name' => 'Basic Analytics',
                'slug' => 'basic_analytics',
                'description' => 'Basic performance analytics and reporting',
                'category' => 'analytics',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 20
            ],
            [
                'name' => 'Advanced Analytics',
                'slug' => 'advanced_analytics',
                'description' => 'Advanced analytics with detailed insights, trends, and predictive analysis',
                'category' => 'analytics',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 21
            ],
            [
                'name' => 'Custom Reports',
                'slug' => 'custom_reports',
                'description' => 'Ability to create custom reports and export data',
                'category' => 'analytics',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 22
            ],

            // Communication
            [
                'name' => 'Email Notifications',
                'slug' => 'email_notifications',
                'description' => 'Automated email notifications for exams, results, and updates',
                'category' => 'communication',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 30
            ],
            [
                'name' => 'SMS Notifications',
                'slug' => 'sms_notifications',
                'description' => 'SMS notifications for important updates and reminders',
                'category' => 'communication',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 31
            ],
            [
                'name' => 'Push Notifications',
                'slug' => 'push_notifications',
                'description' => 'Mobile push notifications for real-time updates',
                'category' => 'communication',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 32
            ],

            // Storage & Files
            [
                'name' => 'Storage Limit',
                'slug' => 'storage_limit',
                'description' => 'Maximum storage space available',
                'category' => 'storage',
                'type' => 'numeric',
                'unit' => 'GB',
                'is_active' => true,
                'sort_order' => 40
            ],
            [
                'name' => 'File Upload',
                'slug' => 'file_upload',
                'description' => 'Ability to upload and manage files',
                'category' => 'storage',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 41
            ],
            [
                'name' => 'Document Management',
                'slug' => 'document_management',
                'description' => 'Advanced document management and organization',
                'category' => 'storage',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 42
            ],

            // API & Integration
            [
                'name' => 'API Access',
                'slug' => 'api_access',
                'description' => 'RESTful API access for third-party integrations',
                'category' => 'api',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 50
            ],
            [
                'name' => 'Webhook Support',
                'slug' => 'webhook_support',
                'description' => 'Webhook support for real-time data synchronization',
                'category' => 'api',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 51
            ],
            [
                'name' => 'Third-party Integrations',
                'slug' => 'third_party_integrations',
                'description' => 'Integration with popular third-party services',
                'category' => 'api',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 52
            ],

            // Support
            [
                'name' => 'Email Support',
                'slug' => 'email_support',
                'description' => 'Email-based customer support',
                'category' => 'support',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 60
            ],
            [
                'name' => 'Phone Support',
                'slug' => 'phone_support',
                'description' => 'Phone-based customer support',
                'category' => 'support',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 61
            ],
            [
                'name' => 'Priority Support',
                'slug' => 'priority_support',
                'description' => 'Priority customer support with faster response times',
                'category' => 'support',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 62
            ],
            [
                'name' => 'Dedicated Support',
                'slug' => 'dedicated_support',
                'description' => 'Dedicated support representative',
                'category' => 'support',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 63
            ],

            // Security
            [
                'name' => 'Two-Factor Authentication',
                'slug' => 'two_factor_auth',
                'description' => 'Two-factor authentication for enhanced security',
                'category' => 'security',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 70
            ],
            [
                'name' => 'SSO Integration',
                'slug' => 'sso_integration',
                'description' => 'Single Sign-On integration with enterprise systems',
                'category' => 'security',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 71
            ],
            [
                'name' => 'Advanced Security',
                'slug' => 'advanced_security',
                'description' => 'Advanced security features and monitoring',
                'category' => 'security',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 72
            ],

            // Customization
            [
                'name' => 'Custom Branding',
                'slug' => 'custom_branding',
                'description' => 'Custom branding and white-label options',
                'category' => 'customization',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 80
            ],
            [
                'name' => 'White Label',
                'slug' => 'white_label',
                'description' => 'Complete white-label solution',
                'category' => 'customization',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 81
            ],
            [
                'name' => 'Custom Domain',
                'slug' => 'custom_domain',
                'description' => 'Custom domain support',
                'category' => 'customization',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 82
            ],

            // General Features
            [
                'name' => 'Mobile App',
                'slug' => 'mobile_app',
                'description' => 'Mobile application support',
                'category' => 'general',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 90
            ],
            [
                'name' => 'Offline Mode',
                'slug' => 'offline_mode',
                'description' => 'Offline functionality for exams and content',
                'category' => 'general',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 91
            ],
            [
                'name' => 'Certificate Generation',
                'slug' => 'certificate_generation',
                'description' => 'Automatic certificate generation for completed exams',
                'category' => 'general',
                'type' => 'boolean',
                'unit' => null,
                'is_active' => true,
                'sort_order' => 92
            ]
        ];

        foreach ($features as $feature) {
            PlanFeature::create($feature);
        }
    }
}