<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\EnhancedUser;
use App\Models\Partner;
use App\Models\Student;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\ExamQuestion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SystemAdminController extends Controller
{
    /**
     * System Admin Dashboard
     */
    public function dashboard()
    {
        try {
            // Get system statistics
            $stats = $this->getSystemStats();
            
            // Ensure all required keys exist with default values
            $requiredKeys = [
                'total_students', 'total_partners', 'total_exams', 'total_questions', 'mcq_questions',
                'descriptive_questions', 'true_false_questions', 'active_students_today', 'active_partners_today', 
                'total_ongoing_tests', 'ongoing_tests', 'total_earnings', 'earnings_today', 'pending_payments_count',
                'pending_payments_amount', 'total_question_attempts', 'total_correct_answers', 'overall_accuracy'
            ];
            
            foreach ($requiredKeys as $key) {
                if (!isset($stats[$key])) {
                    $stats[$key] = 0;
                }
            }
            
            // Get recent exams
            $recent_exams = Exam::with(['partner', 'questions'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Get recent exam results using Eloquent relationships
            try {
                $recent_results = \App\Models\ExamResult::with(['student', 'exam'])
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();
            } catch (\Exception $e) {
                // If ExamResult model doesn't exist or table doesn't exist, provide empty collection
                $recent_results = collect();
            }

            return view('system-admin.system-admin-dashboard', compact('stats', 'recent_exams', 'recent_results'));
        } catch (\Exception $e) {
            // Provide default stats array with all required keys
            $defaultStats = [
                'total_students' => 0, 'total_partners' => 0, 'total_exams' => 0, 'total_questions' => 0, 
                'mcq_questions' => 0, 'descriptive_questions' => 0, 'true_false_questions' => 0,
                'active_students_today' => 0, 'active_partners_today' => 0, 'total_ongoing_tests' => 0,
                'ongoing_tests' => 0, 'total_earnings' => 0, 'earnings_today' => 0,
                'pending_payments_count' => 0, 'pending_payments_amount' => 0,
                'total_question_attempts' => 0, 'total_correct_answers' => 0, 'overall_accuracy' => 0
            ];
            
            return view('system-admin.system-admin-dashboard', [
                'error' => 'Failed to load dashboard data: ' . $e->getMessage(),
                'stats' => $defaultStats,
                'recent_exams' => collect(),
                'recent_results' => collect()
            ]);
        }
    }

    /**
     * All Students Management
     */
    public function allStudents(Request $request)
    {
        try {
            $query = Student::with(['partner', 'courses as enrollments'])
                ->orderBy('created_at', 'desc');

            // Search functionality
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            }

            // Filter by status
            if ($request->has('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            $students = $query->paginate(20);
            
            // Get summary statistics
            $totalStudents = Student::count();
            $activeStudents = Student::where('status', 'active')->count();
            $inactiveStudents = Student::where('status', 'inactive')->count();
            $suspendedStudents = Student::where('status', 'suspended')->count();
            $newStudentsToday = Student::whereDate('created_at', today())->count();
            
            // Get additional statistics for the dashboard
            try {
                $softDeletedStudents = Student::onlyTrashed()->count();
            } catch (\Exception $e) {
                $softDeletedStudents = 0; // If soft deletes not enabled
            }
            $totalPartners = Partner::count();
            $studentsWithLoginAccess = Student::whereNotNull('email')->where('email', '!=', '')->count();
            $newStudentsThisMonth = Student::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
            
            // Get partners for filter dropdown
            $partners = Partner::select('id', 'institute_name as name')->get();

            return view('system-admin.sa-allstudents', compact(
                'students', 
                'totalStudents', 
                'activeStudents', 
                'inactiveStudents', 
                'suspendedStudents', 
                'newStudentsToday',
                'softDeletedStudents',
                'totalPartners',
                'studentsWithLoginAccess',
                'newStudentsThisMonth',
                'partners'
            ));
        } catch (\Exception $e) {
            return view('system-admin.sa-allstudents', [
                'error' => 'Failed to load students: ' . $e->getMessage(),
                'students' => \App\Models\Student::paginate(20), // Return empty paginator instead of collection
                'totalStudents' => 0,
                'activeStudents' => 0,
                'inactiveStudents' => 0,
                'suspendedStudents' => 0,
                'newStudentsToday' => 0,
                'softDeletedStudents' => 0,
                'totalPartners' => 0,
                'studentsWithLoginAccess' => 0,
                'newStudentsThisMonth' => 0,
                'partners' => collect()
            ]);
        }
    }

    /**
     * Single Student Details
     */
    public function singleStudent($id)
    {
        try {
            $student = Student::with(['partner', 'courses as enrollments', 'examResults.exam'])
                ->findOrFail($id);

            // Get student's exam history
            $examHistory = $student->examResults()
                ->with('exam')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            // Get student's enrollment details
            $enrollments = $student->courses;
            // Add course relationship to each enrollment
            $enrollments->load('course');

            return view('system-admin.sa-single-student-ig', compact('student', 'examHistory', 'enrollments'));
        } catch (\Exception $e) {
            return redirect()->route('system-admin.all-students')
                ->with('error', 'Student not found: ' . $e->getMessage());
        }
    }

    /**
     * Delete Student
     */
    public function deleteStudent(Request $request, $id)
    {
        try {
            $student = Student::findOrFail($id);
            
            // Check if student can be deleted (no active exams, no login access, etc.)
            $examResultsCount = $student->examResults()->count();
            
            if ($examResultsCount > 0 || $student->isLoginEnabled() || $student->partner_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete student: Student has active exams, login access, or is associated with a partner.'
                ], 400);
            }
            
            $studentName = $student->full_name;
            $student->delete();
            
            return response()->json([
                'success' => true,
                'message' => "Student '{$studentName}' deleted successfully!"
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting student: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting student: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * All Partners Management
     */
    public function allPartners(Request $request)
    {
        try {
            $query = Partner::with(['batches', 'courses'])
                ->orderBy('created_at', 'desc');

            // Search functionality
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('institute_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            }

            $partners = $query->paginate(20);

            return view('system-admin.sa-partner-management', compact('partners'));
        } catch (\Exception $e) {
            return view('system-admin.sa-partner-management', [
                'error' => 'Failed to load partners: ' . $e->getMessage(),
                'partners' => collect()
            ]);
        }
    }

    /**
     * Subscription Plans Management
     */
    public function subscriptionPlans()
    {
        try {
            // This would typically fetch from a subscription plans table
            // For now, return a basic view
            return view('system-admin.sa-subscription-plans');
        } catch (\Exception $e) {
            return view('system-admin.sa-subscription-plans', [
                'error' => 'Failed to load subscription plans: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get System Statistics
     */
    private function getSystemStats()
    {
        // Default stats array with all required keys
        $defaultStats = [
            'total_students' => 0,
            'total_partners' => 0,
            'total_exams' => 0,
            'total_questions' => 0,
            'mcq_questions' => 0,
            'descriptive_questions' => 0,
            'true_false_questions' => 0,
            'active_students_today' => 0,
            'active_partners_today' => 0,
            'total_ongoing_tests' => 0,
            'ongoing_tests' => 0,
            'total_earnings' => 0,
            'earnings_today' => 0,
            'pending_payments_count' => 0,
            'pending_payments_amount' => 0,
            'total_question_attempts' => 0,
            'total_correct_answers' => 0,
            'overall_accuracy' => 0
        ];

        try {
            // Safely get counts with individual try-catch blocks
            $stats = $defaultStats;
            
            try {
                $stats['total_students'] = Student::count();
            } catch (\Exception $e) {
                Log::warning('Failed to get student count: ' . $e->getMessage());
            }
            
            try {
                $stats['total_partners'] = Partner::count();
            } catch (\Exception $e) {
                Log::warning('Failed to get partner count: ' . $e->getMessage());
            }
            
            try {
                $stats['total_exams'] = Exam::count();
            } catch (\Exception $e) {
                Log::warning('Failed to get exam count: ' . $e->getMessage());
            }
            
            try {
                $stats['total_questions'] = Question::count();
            } catch (\Exception $e) {
                Log::warning('Failed to get question count: ' . $e->getMessage());
            }
            
            try {
                $stats['mcq_questions'] = Question::where('question_type', 'mcq')->count();
            } catch (\Exception $e) {
                Log::warning('Failed to get MCQ question count: ' . $e->getMessage());
            }
            
            try {
                $stats['descriptive_questions'] = Question::where('question_type', 'descriptive')->count();
            } catch (\Exception $e) {
                Log::warning('Failed to get descriptive question count: ' . $e->getMessage());
            }
            
            try {
                $stats['true_false_questions'] = Question::where('question_type', 'true_false')->count();
            } catch (\Exception $e) {
                Log::warning('Failed to get true/false question count: ' . $e->getMessage());
            }
            
            try {
                $stats['active_students_today'] = Student::whereDate('last_login_at', today())->count();
            } catch (\Exception $e) {
                Log::warning('Failed to get active students today: ' . $e->getMessage());
            }
            
            try {
                $stats['active_partners_today'] = Partner::whereDate('last_login_at', today())->count();
            } catch (\Exception $e) {
                Log::warning('Failed to get active partners today: ' . $e->getMessage());
            }
            
            try {
                $stats['total_ongoing_tests'] = Exam::where('status', 'active')->count();
                $stats['ongoing_tests'] = $stats['total_ongoing_tests'];
            } catch (\Exception $e) {
                Log::warning('Failed to get ongoing tests: ' . $e->getMessage());
            }
            
            try {
                $stats['total_question_attempts'] = DB::table('question_attempts')->count() ?? 0;
                $stats['total_correct_answers'] = DB::table('question_attempts')->where('is_correct', true)->count() ?? 0;
            } catch (\Exception $e) {
                Log::warning('Failed to get question attempts: ' . $e->getMessage());
            }

            // Calculate overall accuracy
            if ($stats['total_question_attempts'] > 0) {
                $stats['overall_accuracy'] = round(
                    ($stats['total_correct_answers'] / $stats['total_question_attempts']) * 100, 
                    2
                );
            }

            return $stats;
        } catch (\Exception $e) {
            Log::error('Failed to get system stats: ' . $e->getMessage());
            return $defaultStats;
        }
    }

    /**
     * Create Subscription Plan
     */
    public function createSubscriptionPlan()
    {
        try {
            return view('system-admin.sa-create-subscription');
        } catch (\Exception $e) {
            return view('system-admin.sa-create-subscription', [
                'error' => 'Failed to load create subscription page: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Store Subscription Plan
     */
    public function storeSubscriptionPlan(Request $request)
    {
        try {
            // This would typically save the subscription plan to database
            // For now, redirect back with success message
            return redirect()->route('system-admin.subscription-plans')
                ->with('success', 'Subscription plan created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create subscription plan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update Subscription Plan
     */
    public function updateSubscriptionPlan(Request $request, $id)
    {
        try {
            // This would typically update the subscription plan in database
            // For now, redirect back with success message
            return redirect()->route('system-admin.subscription-plans')
                ->with('success', 'Subscription plan updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update subscription plan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete Subscription Plan
     */
    public function deleteSubscriptionPlan($id)
    {
        try {
            // This would typically delete the subscription plan from database
            // For now, redirect back with success message
            return redirect()->route('system-admin.subscription-plans')
                ->with('success', 'Subscription plan deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete subscription plan: ' . $e->getMessage());
        }
    }

    /**
     * Plan Features Management
     */
    public function planFeatures()
    {
        try {
            // Mock data for plan features grouped by category
            $features = collect([
                'Core Features' => collect([
                    (object)[
                        'id' => 1,
                        'name' => 'Basic Exam Creation',
                        'description' => 'Create up to 10 exams per month',
                        'is_active' => true,
                        'type' => 'numeric',
                        'feature_for' => 'partner',
                        'subscription_plans_count' => 5,
                        'created_at' => now()->subDays(30)
                    ],
                    (object)[
                        'id' => 2,
                        'name' => 'Student Management',
                        'description' => 'Manage up to 100 students',
                        'is_active' => true,
                        'type' => 'numeric',
                        'feature_for' => 'partner',
                        'subscription_plans_count' => 3,
                        'created_at' => now()->subDays(25)
                    ],
                    (object)[
                        'id' => 3,
                        'name' => 'Basic Analytics',
                        'description' => 'View basic performance metrics',
                        'is_active' => true,
                        'type' => 'boolean',
                        'feature_for' => 'partner',
                        'subscription_plans_count' => 4,
                        'created_at' => now()->subDays(20)
                    ]
                ]),
                'Advanced Features' => collect([
                    (object)[
                        'id' => 4,
                        'name' => 'Advanced Analytics',
                        'description' => 'Detailed performance insights and reports',
                        'is_active' => true,
                        'type' => 'boolean',
                        'feature_for' => 'partner',
                        'subscription_plans_count' => 2,
                        'created_at' => now()->subDays(15)
                    ],
                    (object)[
                        'id' => 5,
                        'name' => 'Custom Branding',
                        'description' => 'White-label solution with custom branding',
                        'is_active' => true,
                        'type' => 'text',
                        'feature_for' => 'partner',
                        'subscription_plans_count' => 1,
                        'created_at' => now()->subDays(10)
                    ],
                    (object)[
                        'id' => 6,
                        'name' => 'API Access',
                        'description' => 'Full API access for integrations',
                        'is_active' => false,
                        'type' => 'boolean',
                        'feature_for' => 'partner',
                        'subscription_plans_count' => 0,
                        'created_at' => now()->subDays(5)
                    ]
                ]),
                'Premium Features' => collect([
                    (object)[
                        'id' => 7,
                        'name' => 'Priority Support',
                        'description' => '24/7 priority customer support',
                        'is_active' => true,
                        'type' => 'boolean',
                        'feature_for' => 'partner',
                        'subscription_plans_count' => 1,
                        'created_at' => now()->subDays(3)
                    ],
                    (object)[
                        'id' => 8,
                        'name' => 'Advanced Security',
                        'description' => 'Enhanced security features and compliance',
                        'is_active' => true,
                        'type' => 'boolean',
                        'feature_for' => 'partner',
                        'subscription_plans_count' => 1,
                        'created_at' => now()->subDays(1)
                    ]
                ])
            ]);

            return view('system-admin.sa-plan-features', compact('features'));
        } catch (\Exception $e) {
            return view('system-admin.sa-plan-features', [
                'error' => 'Failed to load plan features: ' . $e->getMessage(),
                'features' => collect()
            ]);
        }
    }

    /**
     * Edit Subscription Plan
     */
    public function editSubscriptionPlan($id)
    {
        try {
            return view('system-admin.sa-edit-subscription', compact('id'));
        } catch (\Exception $e) {
            return view('system-admin.sa-edit-subscription', [
                'error' => 'Failed to load edit subscription page: ' . $e->getMessage(),
                'id' => $id
            ]);
        }
    }

    /**
     * Subscription Overview & Analytics
     */
    public function subscriptionOverview()
    {
        try {
            return view('system-admin.sa-subscription-overview');
        } catch (\Exception $e) {
            return view('system-admin.sa-subscription-overview', [
                'error' => 'Failed to load subscription overview: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Subscription Usage Analytics
     */
    public function subscriptionUsage()
    {
        try {
            return view('system-admin.sa-subscription-usage');
        } catch (\Exception $e) {
            return view('system-admin.sa-subscription-usage', [
                'error' => 'Failed to load subscription usage: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Subscription Billing Management
     */
    public function subscriptionBilling()
    {
        try {
            return view('system-admin.sa-subscription-billing');
        } catch (\Exception $e) {
            return view('system-admin.sa-subscription-billing', [
                'error' => 'Failed to load subscription billing: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Create Plan Feature
     */
    public function createPlanFeature()
    {
        try {
            $featureTypes = [
                'boolean' => 'Boolean (Yes/No)',
                'numeric' => 'Numeric (Number)',
                'text' => 'Text (Description)'
            ];
            
            $featureTargets = [
                'partner' => 'Partner Only',
                'student' => 'Student Only',
                'both' => 'Both Partner & Student'
            ];
            
            $categories = [
                'Core Features' => 'Core Features',
                'Advanced Features' => 'Advanced Features',
                'Analytics' => 'Analytics',
                'Integrations' => 'Integrations',
                'Support' => 'Support'
            ];
            
            return view('system-admin.sa-create-plan-feature', compact('featureTypes', 'featureTargets', 'categories'));
        } catch (\Exception $e) {
            return view('system-admin.sa-create-plan-feature', [
                'error' => 'Failed to load create plan feature page: ' . $e->getMessage(),
                'featureTypes' => [],
                'featureTargets' => [],
                'categories' => []
            ]);
        }
    }

    /**
     * Edit Plan Feature
     */
    public function editPlanFeature($id)
    {
        try {
            $featureTypes = [
                'boolean' => 'Boolean (Yes/No)',
                'numeric' => 'Numeric (Number)',
                'text' => 'Text (Description)'
            ];
            
            $featureTargets = [
                'partner' => 'Partner Only',
                'student' => 'Student Only',
                'both' => 'Both Partner & Student'
            ];
            
            $categories = [
                'Core Features' => 'Core Features',
                'Advanced Features' => 'Advanced Features',
                'Analytics' => 'Analytics',
                'Integrations' => 'Integrations',
                'Support' => 'Support'
            ];
            
            // Get the feature to edit (mock data for now)
            $feature = (object) [
                'id' => $id,
                'name' => 'Sample Feature',
                'description' => 'This is a sample feature description',
                'type' => 'boolean',
                'feature_for' => 'partner',
                'category' => 'Core Features',
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 0,
                'icon' => 'check-circle',
                'color' => 'blue'
            ];
            
            return view('system-admin.sa-edit-plan-feature', compact('id', 'feature', 'featureTypes', 'featureTargets', 'categories'));
        } catch (\Exception $e) {
            return view('system-admin.sa-edit-plan-feature', [
                'error' => 'Failed to load edit plan feature page: ' . $e->getMessage(),
                'id' => $id,
                'feature' => null,
                'featureTypes' => [],
                'featureTargets' => [],
                'categories' => []
            ]);
        }
    }

    /**
     * Store Plan Feature
     */
    public function storePlanFeature(Request $request)
    {
        try {
            // This would typically save the plan feature to database
            // For now, redirect back with success message
            return redirect()->route('system-admin.plan-features')
                ->with('success', 'Plan feature created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create plan feature: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update Plan Feature
     */
    public function updatePlanFeature(Request $request, $id)
    {
        try {
            // This would typically update the plan feature in database
            // For now, redirect back with success message
            return redirect()->route('system-admin.plan-features')
                ->with('success', 'Plan feature updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update plan feature: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete Plan Feature
     */
    public function deletePlanFeature($id)
    {
        try {
            // This would typically delete the plan feature from database
            // For now, redirect back with success message
            return redirect()->route('system-admin.plan-features')
                ->with('success', 'Plan feature deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete plan feature: ' . $e->getMessage());
        }
    }

    /**
     * Payment Methods Management
     */
    public function paymentMethods()
    {
        try {
            // Get payment methods from database
            $paymentMethods = \App\Models\PaymentMethod::all();

            return view('system-admin.sa-payment-methods', compact('paymentMethods'));
        } catch (\Exception $e) {
            return view('system-admin.sa-payment-methods', [
                'error' => 'Failed to load payment methods: ' . $e->getMessage(),
                'paymentMethods' => collect()
            ]);
        }
    }

    /**
     * Create Payment Method
     */
    public function createPaymentMethod()
    {
        try {
            return view('system-admin.sa-create-payment-method');
        } catch (\Exception $e) {
            return view('system-admin.sa-create-payment-method', [
                'error' => 'Failed to load create payment method page: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Edit Payment Method
     */
    public function editPaymentMethod($id)
    {
        try {
            // Mock data for the payment method to edit
            $paymentMethod = (object) [
                'id' => $id,
                'name' => 'Credit Card',
                'type' => 'card',
                'provider' => 'Stripe',
                'description' => 'Accept payments via Visa, Mastercard, American Express, and other major credit cards.',
                'processing_fee' => 2.9,
                'min_amount' => 1.00,
                'max_amount' => 10000.00,
                'is_active' => true,
                'is_popular' => true,
                'icon' => 'fas fa-credit-card',
                'color' => '#3B82F6',
                'created_at' => now()->subDays(30)
            ];
            
            return view('system-admin.sa-edit-payment-method', compact('id', 'paymentMethod'));
        } catch (\Exception $e) {
            return view('system-admin.sa-edit-payment-method', [
                'error' => 'Failed to load edit payment method page: ' . $e->getMessage(),
                'id' => $id,
                'paymentMethod' => null
            ]);
        }
    }

    /**
     * Store Payment Method
     */
    public function storePaymentMethod(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'type' => 'required|in:Bank,MFS,Cash',
                'provider_name' => 'nullable|string|max:100',
                'branch_name' => 'nullable|string|max:100',
                'account_number' => 'nullable|string|max:50',
                'account_title' => 'nullable|string|max:150',
                'routing_number' => 'nullable|string|max:50'
            ]);

            // Create the payment method
            $paymentMethod = \App\Models\PaymentMethod::create($validated);

            return redirect()->route('system-admin.payment-methods')
                ->with('success', 'Payment method created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create payment method: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update Payment Method
     */
    public function updatePaymentMethod(Request $request, $id)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'type' => 'required|in:Bank,MFS,Cash',
                'provider_name' => 'nullable|string|max:100',
                'branch_name' => 'nullable|string|max:100',
                'account_number' => 'nullable|string|max:50',
                'account_title' => 'nullable|string|max:150',
                'routing_number' => 'nullable|string|max:50'
            ]);

            // Find and update the payment method
            $paymentMethod = \App\Models\PaymentMethod::findOrFail($id);
            $paymentMethod->update($validated);

            return redirect()->route('system-admin.payment-methods')
                ->with('success', 'Payment method updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update payment method: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Toggle Payment Method Status
     */
    public function togglePaymentMethodStatus($id)
    {
        try {
            // This would typically toggle the payment method status in database
            // For now, redirect back with success message
            return redirect()->route('system-admin.payment-methods')
                ->with('success', 'Payment method status updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to toggle payment method status: ' . $e->getMessage());
        }
    }

    /**
     * Delete Payment Method
     */
    public function deletePaymentMethod($id)
    {
        try {
            $paymentMethod = \App\Models\PaymentMethod::findOrFail($id);
            $paymentMethod->delete();
            
            return redirect()->route('system-admin.payment-methods')
                ->with('success', 'Payment method deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete payment method: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of public exams
     */
    public function publicExamsIndex(Request $request)
    {
        try {
            $query = Exam::with(['partner'])
                ->where('is_public', true)
                // Exclude test exams
                ->where('title', '!=', 'Test Public Exam')
                ->orderBy('created_at', 'desc');

            // Search functionality - using 'q' parameter as expected by the view
            if ($request->has('q') && $request->q) {
                $search = $request->q;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // Filter by status - mapping view statuses to actual database values
            if ($request->has('status') && $request->status !== '') {
                $status = $request->status;
                // Map view statuses to database values
                switch($status) {
                    case 'published':
                        $query->where('status', 'active');
                        break;
                    case 'ongoing':
                        $query->where('status', 'active')
                              ->where('start_time', '<=', now())
                              ->where('end_time', '>=', now());
                        break;
                    case 'completed':
                        $query->where('status', 'active')
                              ->where('end_time', '<', now());
                        break;
                    case 'draft':
                        $query->where('status', 'draft');
                        break;
                    case 'cancelled':
                        $query->where('status', 'archived');
                        break;
                    default:
                        // No filter for 'all' or unrecognized statuses
                        break;
                }
            }

            $exams = $query->paginate(20);
            
            // Get summary statistics for the counts array expected by the view
            $counts = [
                'all' => Exam::where('is_public', true)->where('title', '!=', 'Test Public Exam')->count(),
                'draft' => Exam::where('is_public', true)->where('status', 'draft')->where('title', '!=', 'Test Public Exam')->count(),
                'published' => Exam::where('is_public', true)->where('status', 'active')->where('title', '!=', 'Test Public Exam')->count(),
                'ongoing' => Exam::where('is_public', true)
                                 ->where('status', 'active')
                                 ->where('start_time', '<=', now())
                                 ->where('end_time', '>=', now())
                                 ->where('title', '!=', 'Test Public Exam')
                                 ->count(),
                'completed' => Exam::where('is_public', true)
                                   ->where('status', 'active')
                                   ->where('end_time', '<', now())
                                   ->where('title', '!=', 'Test Public Exam')
                                   ->count(),
                'cancelled' => Exam::where('is_public', true)->where('status', 'archived')->where('title', '!=', 'Test Public Exam')->count()
            ];
            
            return view('system-admin.public-exams.sa-index', compact('exams', 'counts'));
        } catch (\Exception $e) {
            return redirect()->route('system-admin.system-admin-dashboard')
                ->with('error', 'Failed to load public exams: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new public exam
     */
    public function publicExamsCreate()
    {
        try {
            // Get partners for the form
            $partners = Partner::all();
            
            // Get courses for the form
            $courses = \App\Models\Course::all();
            
            // Get qcreators for the form
            $qcreators = \App\Models\QCReator::all();
            
            return view('system-admin.public-exams.sa-create', compact('partners', 'courses', 'qcreators'));
        } catch (\Exception $e) {
            return redirect()->route('system-admin.public-exams.index')
                ->with('error', 'Failed to load create exam page: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created public exam
     */
    public function publicExamsStore(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'duration' => 'required|integer|min:1',
                'total_questions' => 'required|integer|min:1',
                'passing_marks' => 'required|numeric|min:0',
                'status' => 'required|in:draft,active,archived',
                'partner_id' => 'nullable|exists:partners,id',
                'startDateTime' => 'nullable|date',
                'endDateTime' => 'nullable|date|after:startDateTime',
                'allow_review' => 'boolean',
                'has_negative_marking' => 'boolean',
                'negative_marks_per_question' => 'nullable|numeric|min:0',
                'question_language' => 'required|in:english,bangla',
                'is_public' => 'boolean',
                'course_id' => 'required|exists:courses,id',
                'qcreator_id' => 'required|exists:qcreators,id',
                'exam_number' => 'nullable|string',
                'price' => 'nullable|integer|min:0',
                'exam_type' => 'in:online,offline'
            ]);
            
            // Set is_public to true for public exams
            $validated['is_public'] = true;
            
            // Set exam_type to online by default if not provided
            if (!isset($validated['exam_type'])) {
                $validated['exam_type'] = 'online';
            }
            
            // Handle datetime fields
            if (isset($validated['startDateTime'])) {
                $validated['start_time'] = $validated['startDateTime'];
                unset($validated['startDateTime']);
            }
            
            if (isset($validated['endDateTime'])) {
                $validated['end_time'] = $validated['endDateTime'];
                unset($validated['endDateTime']);
            }
            
            // Handle boolean fields
            $validated['allow_review'] = isset($validated['allow_review']) ? true : false;
            $validated['has_negative_marking'] = isset($validated['has_negative_marking']) ? true : false;
            $validated['show_results_immediately'] = false; // Default value
            
            // Set default partner_id to 0 if not provided
            if (!isset($validated['partner_id']) || is_null($validated['partner_id'])) {
                $validated['partner_id'] = 0;
            }
            
            // Create the exam
            $exam = Exam::create($validated);

            return redirect()->route('system-admin.public-exams.index')
                ->with('success', 'Public exam created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create public exam: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified public exam
     */
    public function publicExamsShow(Exam $exam)
    {
        try {
            // Ensure it's a public exam
            if (!$exam->is_public) {
                return redirect()->route('system-admin.public-exams.index')
                    ->with('error', 'Exam not found.');
            }
            
            $exam->load(['partner', 'questions']);
            
            return view('system-admin.public-exams.sa-show', compact('exam'));
        } catch (\Exception $e) {
            return redirect()->route('system-admin.public-exams.index')
                ->with('error', 'Failed to load exam details: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified public exam
     */
    public function publicExamsEdit(Exam $exam)
    {
        try {
            // Ensure it's a public exam
            if (!$exam->is_public) {
                return redirect()->route('system-admin.public-exams.index')
                    ->with('error', 'Exam not found.');
            }
            
            // Get partners for the form
            $partners = Partner::all();
            
            // Get courses for the form
            $courses = \App\Models\Course::all();
            
            // Get qcreators for the form
            $qcreators = \App\Models\QCReator::all();
            
            $exam->load(['partner']);
            
            return view('system-admin.public-exams.sa-edit', compact('exam', 'partners', 'courses', 'qcreators'));
        } catch (\Exception $e) {
            return redirect()->route('system-admin.public-exams.index')
                ->with('error', 'Failed to load edit exam page: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified public exam
     */
    public function publicExamsUpdate(Request $request, Exam $exam)
    {
        try {
            // Ensure it's a public exam
            if (!$exam->is_public) {
                return redirect()->route('system-admin.public-exams.index')
                    ->with('error', 'Exam not found.');
            }
            
            // Validate the request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'duration' => 'required|integer|min:1',
                'total_questions' => 'required|integer|min:1',
                'passing_marks' => 'required|numeric|min:0',
                'status' => 'required|in:draft,active,archived',
                'partner_id' => 'nullable|exists:partners,id',
                'startDateTime' => 'nullable|date',
                'endDateTime' => 'nullable|date|after:startDateTime',
                'allow_review' => 'boolean',
                'has_negative_marking' => 'boolean',
                'negative_marks_per_question' => 'nullable|numeric|min:0',
                'question_language' => 'required|in:english,bangla',
                'is_public' => 'boolean',
                'course_id' => 'required|exists:courses,id',
                'qcreator_id' => 'required|exists:qcreators,id',
                'exam_number' => 'nullable|string',
                'price' => 'nullable|integer|min:0',
                'exam_type' => 'in:online,offline'
            ]);
            
            // Set is_public to true for public exams
            $validated['is_public'] = true;
            
            // Set exam_type to online by default
            $validated['exam_type'] = 'online';
            
            // Handle datetime fields
            if (isset($validated['startDateTime'])) {
                $validated['start_time'] = $validated['startDateTime'];
                unset($validated['startDateTime']);
            }
            
            if (isset($validated['endDateTime'])) {
                $validated['end_time'] = $validated['endDateTime'];
                unset($validated['endDateTime']);
            }
            
            // Handle boolean fields
            $validated['allow_review'] = isset($validated['allow_review']) ? true : false;
            $validated['has_negative_marking'] = isset($validated['has_negative_marking']) ? true : false;
            $validated['show_results_immediately'] = false; // Default value
            
            // Update the exam
            $exam->update($validated);

            return redirect()->route('system-admin.public-exams.index')
                ->with('success', 'Public exam updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update public exam: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified public exam
     */
    public function publicExamsDestroy(Exam $exam)
    {
        try {
            // Ensure it's a public exam
            if (!$exam->is_public) {
                return redirect()->route('system-admin.public-exams.index')
                    ->with('error', 'Exam not found.');
            }
            
            $examTitle = $exam->title;
            $exam->delete();
            
            return redirect()->route('system-admin.public-exams.index')
                ->with('success', "Public exam '{$examTitle}' deleted successfully!");
        } catch (\Exception $e) {
            return redirect()->route('system-admin.public-exams.index')
                ->with('error', 'Failed to delete public exam: ' . $e->getMessage());
        }
    }
    
    /**
     * Publish the specified public exam
     */
    public function publicExamsPublish(Exam $exam)
    {
        try {
            // Ensure it's a public exam
            if (!$exam->is_public) {
                return redirect()->route('system-admin.public-exams.index')
                    ->with('error', 'Exam not found.');
            }
            
            // Update the exam status to active
            $exam->update(['status' => 'active']);
            
            return redirect()->route('system-admin.public-exams.index')
                ->with('success', "Public exam '{$exam->title}' published successfully!");
        } catch (\Exception $e) {
            return redirect()->route('system-admin.public-exams.index')
                ->with('error', 'Failed to publish public exam: ' . $e->getMessage());
        }
    }
    
    /**
     * Unpublish the specified public exam
     */
    public function publicExamsUnpublish(Exam $exam)
    {
        try {
            // Ensure it's a public exam
            if (!$exam->is_public) {
                return redirect()->route('system-admin.public-exams.index')
                    ->with('error', 'Exam not found.');
            }
            
            // Update the exam status to draft
            $exam->update(['status' => 'draft']);
            
            return redirect()->route('system-admin.public-exams.index')
                ->with('success', "Public exam '{$exam->title}' unpublished successfully!");
        } catch (\Exception $e) {
            return redirect()->route('system-admin.public-exams.index')
                ->with('error', 'Failed to unpublish public exam: ' . $e->getMessage());
        }
    }
    
    /**
     * Show the assign questions form for public exams
     */
    public function publicExamsAssignQuestions(Exam $exam)
    {
        try {
            // Ensure it's a public exam
            if (!$exam->is_public) {
                return redirect()->route('system-admin.public-exams.index')
                    ->with('error', 'Exam not found.');
            }

            // Get all active questions (no partner restriction for system admin)
            $questionsQuery = \App\Models\Question::query()
                ->where('status', 'active')
                ->with('course', 'subject', 'topic', 'questionType');

            $questions = $questionsQuery->with('exams.course')->get();
            
            return view('system-admin.public-exams.sa-assign-questions', [
                'exam' => $exam,
                'questions' => $questions,
                'assignedQuestions' => $exam->questions->pluck('id'),
                'assignedQuestionsWithMarks' => $exam->questions->pluck('pivot.marks', 'id'),
                'assignedQuestionsWithOrder' => $exam->questions->pluck('pivot.order', 'id'),
                'courses' => \App\Models\Course::where('status', 'active')->get(),
                'subjects' => \App\Models\Subject::where('status', 'active')->where('flag', 'active')->get(),
                'topics' => \App\Models\Topic::where('status', 'active')->get(),
                'questionTypes' => \App\Models\Question::where('status', 'active')
                    ->select('question_type')
                    ->distinct()
                    ->pluck('question_type')
                    ->map(function($type) {
                        return [
                            'value' => $type,
                            'label' => match($type) {
                                'mcq' => 'MCQ',
                                'descriptive' => 'Descriptive',
                                'true_false' => 'True/False',
                                'fill_in_blank' => 'Fill in the Blanks',
                                default => ucfirst(str_replace('_', ' ', $type))
                            }
                        ];
                    }),
                'availableDates' => \App\Models\Question::where('status', 'active')
                    ->selectRaw('DATE(created_at) as date')
                    ->groupBy('date')
                    ->orderBy('date', 'desc')
                    ->get()
                    ->map(function($question) {
                        $date = \Carbon\Carbon::parse($question->date);
                        return [
                            'value' => $date->format('Y-m-d'),
                            'label' => $date->format('d-M-Y')
                        ];
                    }),
            ]);
        } catch (\Exception $e) {
            return redirect()->route('system-admin.public-exams.index')
                ->with('error', 'Failed to load assign questions page: ' . $e->getMessage());
        }
    }

    /**
     * Store assigned questions for public exams
     */
    public function publicExamsStoreAssignedQuestions(Request $request, Exam $exam)
    {
        try {
            // Ensure it's a public exam
            if (!$exam->is_public) {
                return redirect()->route('system-admin.public-exams.index')
                    ->with('error', 'Exam not found.');
            }

            $request->validate([
                'question_ids' => 'nullable|array',
                'question_ids.*' => 'exists:questions,id',
                'question_marks' => 'nullable|array',
                'question_marks.*' => 'integer|min:1|max:100',
                'question_numbers' => 'array',
                'question_numbers.*' => 'nullable|integer|min:1|max:999'
            ]);

            // Clear existing assigned questions for this exam
            \App\Models\ExamQuestion::where('exam_id', $exam->id)->delete();

            // Store new assigned questions
            $questionIds = $request->has('question_ids') && is_array($request->question_ids) 
                ? array_filter($request->question_ids) // Remove empty values
                : [];
            $questionMarks = $request->has('question_marks') && is_array($request->question_marks) 
                ? $request->question_marks 
                : [];
            $questionNumbers = $request->has('question_numbers') && is_array($request->question_numbers) 
                ? $request->question_numbers 
                : [];
            $examQuestions = [];
            
            if (!empty($questionIds)) {
                foreach ($questionIds as $index => $questionId) {
                    $marks = isset($questionMarks[$questionId]) ? (int)$questionMarks[$questionId] : 1;
                    
                    // Only use question number if it's not empty, otherwise use sequential order
                    $order = $index + 1;
                    if (isset($questionNumbers[$questionId]) && !empty($questionNumbers[$questionId])) {
                        $order = (int)$questionNumbers[$questionId];
                    }
                    
                    $examQuestions[] = [
                        'exam_id' => $exam->id,
                        'question_id' => $questionId,
                        'order' => $order,
                        'marks' => $marks,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Insert all exam questions
                if (!empty($examQuestions)) {
                    \App\Models\ExamQuestion::insert($examQuestions);
                }
            }

            // Validate that assigned questions don't exceed the exam's total_questions limit
            $assignedCount = count($questionIds);
            if ($assignedCount > $exam->total_questions) {
                return redirect()->back()
                    ->with('warning', "You've assigned {$assignedCount} questions, which exceeds the exam's limit of {$exam->total_questions}. Please review your selections.")
                    ->withInput();
            }

            return redirect()->route('system-admin.public-exams.show', $exam)
                ->with('success', 'Questions assigned successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to assign questions: ' . $e->getMessage())
                ->withInput();
        }
    }
}
