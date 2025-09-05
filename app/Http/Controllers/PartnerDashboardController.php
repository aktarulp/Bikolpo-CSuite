<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Question;
use App\Models\Exam;
use App\Models\Student;
use App\Models\QuestionSet;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\ExamResult;
use App\Models\Course;
use App\Models\Batch;
use App\Models\QuestionStat;
use App\Traits\HasPartnerContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerDashboardController extends Controller
{
    use HasPartnerContext;

    public function index()
    {
        try {
            // Test database connection first
            try {
                \DB::connection()->getPdo();
                \Log::info('Database connection successful');
            } catch (\Exception $e) {
                \Log::error('Database connection failed: ' . $e->getMessage());
                throw new \Exception('Database connection failed: ' . $e->getMessage());
            }
            
            // Get the authenticated user's partner ID using the trait
            $partnerId = $this->getPartnerId();
            
            // Debug: Log the partner ID and student counts
            \Log::info('PartnerDashboardController - Partner ID: ' . $partnerId);
            
            // Get student count with debugging
            $totalStudents = Student::where('partner_id', $partnerId)->count();
            $studentsWithExams = Student::whereHas('examResults.exam', function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId);
            })->distinct()->count();
            
            \Log::info('PartnerDashboardController - Total Students: ' . $totalStudents . ', Students with Exams: ' . $studentsWithExams);
            
            // Also log the raw SQL query for debugging
            $studentQuery = Student::where('partner_id', $partnerId);
            \Log::info('Student Query SQL: ' . $studentQuery->toSql());
            \Log::info('Student Query Bindings: ' . json_encode($studentQuery->getBindings()));
            
            // Test direct database query
            $directCount = \DB::table('students')->where('partner_id', $partnerId)->count();
            \Log::info('Direct DB Query Count: ' . $directCount);
            
            // Get question analytics for this partner
            $questionAnalytics = QuestionStat::whereHas('exam', function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId);
            });
            
            $stats = [
                'total_questions' => Question::where('partner_id', $partnerId)->count(),
                'total_exams' => Exam::where('partner_id', $partnerId)->count(),
                'total_students' => $totalStudents,
                'total_courses' => Course::where('partner_id', $partnerId)->count(),
                'total_batches' => Batch::where('partner_id', $partnerId)->count(),
                'total_question_attempts' => $questionAnalytics->count(),
                'total_correct_answers' => $questionAnalytics->where('is_correct', true)->count(),
                'overall_accuracy' => $questionAnalytics->count() > 0 ? 
                    round(($questionAnalytics->where('is_correct', true)->count() / $questionAnalytics->count()) * 100, 1) : 0,
            ];

            $recent_exams = Exam::where('partner_id', $partnerId)
                ->latest()
                ->take(5)
                ->get();

            $recent_results = ExamResult::whereHas('exam', function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId);
            })
            ->with(['student', 'exam'])
            ->latest()
            ->take(10)
            ->get();

            // Get the partner data for the layout
            $partner = Partner::where('user_id', auth()->id())->first();

            return view('partner.dashboard', compact('stats', 'recent_exams', 'recent_results', 'partner'));
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('PartnerDashboardController error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return a view with an error message
            return view('partner.dashboard', [
                'stats' => ['total_questions' => 0, 'total_exams' => 0, 'total_students' => 0, 'total_courses' => 0, 'total_batches' => 0],
                'recent_exams' => collect(),
                'recent_results' => collect(),
                'partner' => null,
                'error' => 'Unable to load dashboard data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Seed demo students for the current partner
     */
    public function seedDemoStudents()
    {
        try {
            // Get the authenticated user
            $user = Auth::user();
            
            if (!$user || !$user->isPartner()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Partner login required.'
                ], 403);
            }

            // Get the partner associated with the authenticated user
            $partner = Partner::where('user_id', $user->id)->first();
            
            if (!$partner) {
                return response()->json([
                    'success' => false,
                    'message' => 'No partner profile found for the authenticated user.'
                ], 404);
            }

            // Check if students already exist
            $existingCount = Student::where('partner_id', $partner->id)->count();
            
            if ($existingCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Students already exist for this partner ({$existingCount} students found)."
                ], 400);
            }

            // Demo student data
            $demoStudents = [
                [
                    'full_name' => 'আহমেদ রহমান',
                    'student_id' => 'STU' . str_pad($partner->id, 3, '0', STR_PAD_LEFT) . '001',
                    'date_of_birth' => '2005-03-15',
                    'gender' => 'male',
                    'email' => 'ahmed.student' . $partner->id . '@demo.com',
                    'phone' => '+880 1712345678',
                    'address' => 'রংপুর, বাংলাদেশ',
                    'city' => 'রংপুর',
                    'school_college' => 'রংপুর সরকারি কলেজ',
                    'class_grade' => 'Class 12',
                    'parent_name' => 'মোঃ আব্দুল রহমান',
                    'parent_phone' => '+880 1812345678',
                    'status' => 'active',
                    'partner_id' => $partner->id,
                    'user_id' => null,
                ],
                [
                    'full_name' => 'ফাতেমা খাতুন',
                    'student_id' => 'STU' . str_pad($partner->id, 3, '0', STR_PAD_LEFT) . '002',
                    'date_of_birth' => '2006-07-22',
                    'gender' => 'female',
                    'email' => 'fatema.student' . $partner->id . '@demo.com',
                    'phone' => '+880 1723456789',
                    'address' => 'ঢাকা, বাংলাদেশ',
                    'city' => 'ঢাকা',
                    'school_college' => 'ঢাকা সরকারি কলেজ',
                    'class_grade' => 'Class 11',
                    'parent_name' => 'মোঃ আব্দুল খালেক',
                    'parent_phone' => '+880 1823456789',
                    'status' => 'active',
                    'partner_id' => $partner->id,
                    'user_id' => null,
                ],
                [
                    'full_name' => 'সাবরিনা আক্তার',
                    'student_id' => 'STU' . str_pad($partner->id, 3, '0', STR_PAD_LEFT) . '003',
                    'date_of_birth' => '2005-11-08',
                    'gender' => 'female',
                    'email' => 'sabrina.student' . $partner->id . '@demo.com',
                    'phone' => '+880 1734567890',
                    'address' => 'চট্টগ্রাম, বাংলাদেশ',
                    'city' => 'চট্টগ্রাম',
                    'school_college' => 'চট্টগ্রাম সরকারি কলেজ',
                    'class_grade' => 'Class 12',
                    'parent_name' => 'মোঃ আব্দুল মালেক',
                    'parent_phone' => '+880 1834567890',
                    'status' => 'active',
                    'partner_id' => $partner->id,
                    'user_id' => null,
                ],
                [
                    'full_name' => 'রাকিব হাসান',
                    'student_id' => 'STU' . str_pad($partner->id, 3, '0', STR_PAD_LEFT) . '004',
                    'date_of_birth' => '2004-09-12',
                    'gender' => 'male',
                    'email' => 'rakib.student' . $partner->id . '@demo.com',
                    'phone' => '+880 1745678901',
                    'address' => 'সিলেট, বাংলাদেশ',
                    'city' => 'সিলেট',
                    'school_college' => 'সিলেট সরকারি কলেজ',
                    'class_grade' => 'Class 12',
                    'parent_name' => 'মোঃ আব্দুল হামিদ',
                    'parent_phone' => '+880 1845678901',
                    'status' => 'active',
                    'partner_id' => $partner->id,
                    'user_id' => null,
                ],
                [
                    'full_name' => 'নুসরাত জাহান',
                    'student_id' => 'STU' . str_pad($partner->id, 3, '0', STR_PAD_LEFT) . '005',
                    'date_of_birth' => '2006-01-25',
                    'gender' => 'female',
                    'email' => 'nusrat.student' . $partner->id . '@demo.com',
                    'phone' => '+880 1756789012',
                    'address' => 'খুলনা, বাংলাদেশ',
                    'city' => 'খুলনা',
                    'school_college' => 'খুলনা সরকারি কলেজ',
                    'class_grade' => 'Class 11',
                    'parent_name' => 'মোঃ আব্দুল করিম',
                    'parent_phone' => '+880 1856789012',
                    'status' => 'active',
                    'partner_id' => $partner->id,
                    'user_id' => null,
                ]
            ];

            // Create students
            foreach ($demoStudents as $studentData) {
                Student::create($studentData);
            }

            return response()->json([
                'success' => true,
                'message' => 'Demo students created successfully!',
                'count' => count($demoStudents)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating demo students: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Refresh dashboard statistics
     */
    public function refreshStats()
    {
        try {
            $partnerId = $this->getPartnerId();
            
            // Clear any potential query cache
            \DB::flushQueryLog();
            
            $stats = [
                'total_questions' => Question::where('partner_id', $partnerId)->count(),
                'total_exams' => Exam::where('partner_id', $partnerId)->count(),
                'total_students' => Student::where('partner_id', $partnerId)->count(),
                'total_courses' => Course::where('partner_id', $partnerId)->count(),
                'total_batches' => Batch::where('partner_id', $partnerId)->count(),
            ];
            
            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error refreshing stats: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current student count for debugging
     */
    public function getStudentCount()
    {
        try {
            $partnerId = $this->getPartnerId();
            
            $totalStudents = Student::where('partner_id', $partnerId)->count();
            $studentsWithExams = Student::whereHas('examResults.exam', function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId);
            })->distinct()->count();
            
            return response()->json([
                'success' => true,
                'partner_id' => $partnerId,
                'total_students' => $totalStudents,
                'students_with_exams' => $studentsWithExams,
                'all_students' => Student::where('partner_id', $partnerId)->get(['id', 'full_name', 'student_id', 'status'])
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting student count: ' . $e->getMessage()
            ], 500);
        }
    }
}
