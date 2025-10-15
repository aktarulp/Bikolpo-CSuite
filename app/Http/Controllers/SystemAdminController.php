<?php

namespace App\Http\Controllers;

use App\Models\EnhancedUser;
use App\Models\Student;
use App\Models\Partner;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamResult;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Batch;
use App\Models\QuestionStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class SystemAdminController extends Controller
{
    /**
     * System Admin Dashboard
     */
    public function dashboard()
    {
        try {
            // Debug authentication
            \Log::info('SystemAdminController: Dashboard accessed', [
                'user_authenticated' => auth()->check(),
                'user_id' => auth()->id(),
                'user_role' => auth()->user() ? auth()->user()->role : 'none',
                'session_id' => session()->getId()
            ]);
            
            // Check if user is authenticated
            if (!auth()->check()) {
                \Log::error('SystemAdminController: User not authenticated');
                return redirect()->route('login')->with('error', 'Please log in to access the system admin dashboard.');
            }
            
            // Get user info for debugging
            $user = auth()->user();
            \Log::info('SystemAdminController: User details', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_role' => $user->role,
                'user_role_id' => $user->role_id
            ]);
            
            // Get comprehensive system statistics
            $stats = $this->getSystemStats();
            
            // Get recent activity data
            $recentActivity = $this->getRecentActivity();
            
            // Get user growth data for charts
            $userGrowthData = $this->getUserGrowthData();
            
            // Get revenue data
            $revenueData = $this->getRevenueData();
            
            // Get top performing partners
            $topPartners = $this->getTopPartners();
            
            // Get system health status
            $systemHealth = $this->getSystemHealth();
            
            // Get upcoming events/notifications
            $upcomingEvents = $this->getUpcomingEvents();
            
            // Get recent exams and results
            $recent_exams = $this->getRecentExams();
            $recent_results = $this->getRecentResults();
            
            // Ensure all data is properly formatted
            $recentActivity = $recentActivity instanceof \Illuminate\Support\Collection ? $recentActivity : collect($recentActivity);
            $topPartners = $topPartners instanceof \Illuminate\Support\Collection ? $topPartners : collect($topPartners);
            $upcomingEvents = $upcomingEvents instanceof \Illuminate\Support\Collection ? $upcomingEvents : collect($upcomingEvents);
            
            return view('system-admin.system-admin-dashboard', compact(
                'stats',
                'recentActivity',
                'userGrowthData',
                'revenueData',
                'topPartners',
                'systemHealth',
                'upcomingEvents',
                'recent_exams',
                'recent_results'
            ));
            
        } catch (\Exception $e) {
            \Log::error('SystemAdminController dashboard error: ' . $e->getMessage(), [
                'user_id' => auth()->check() ? auth()->id() : 'not authenticated',
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('system-admin.system-admin-dashboard', [
                'stats' => $this->getDefaultStats(),
                'recentActivity' => collect(),
                'userGrowthData' => [],
                'revenueData' => [],
                'topPartners' => collect(),
                'systemHealth' => $this->getDefaultSystemHealth(),
                'upcomingEvents' => collect(),
                'recent_exams' => collect(),
                'recent_results' => collect(),
                'error' => 'Unable to load dashboard data: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Get comprehensive system statistics
     */
    public function getSystemStats()
    {
        try {
            $today = Carbon::today();
            $thisMonth = Carbon::now()->startOfMonth();
            
            return [
                // User Statistics
                'total_users' => EnhancedUser::count(),
                'active_users_today' => EnhancedUser::whereDate('updated_at', $today)->count(),
                'active_users_this_month' => EnhancedUser::where('updated_at', '>=', $thisMonth)->count(),
                'new_users_today' => EnhancedUser::whereDate('created_at', $today)->count(),
                'new_users_this_week' => EnhancedUser::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
                'new_users_this_month' => EnhancedUser::where('created_at', '>=', $thisMonth)->count(),
                
                // Student Statistics
                'total_students' => Student::count(),
                'active_students_today' => Student::whereDate('updated_at', $today)->count(),
                'active_students_this_month' => Student::where('updated_at', '>=', $thisMonth)->count(),
                'students_with_login_access' => EnhancedUser::where('role', 'student')->count(),
                
                // Partner Statistics
                'total_partners' => Partner::count(),
                'active_partners' => Partner::count(), // All partners for super admin
                'active_partners_today' => Partner::whereDate('updated_at', $today)->count(),
                'pending_partners' => Partner::count(), // All partners for super admin
                
                // Content Statistics
                'total_questions' => Question::count(),
                'total_exams' => Exam::count(),
                'total_courses' => Course::count(),
                'total_subjects' => Subject::count(),
                'total_topics' => Topic::count(),
                'total_batches' => Batch::count(),
                
                // Question Type Statistics
                'mcq_questions' => Question::where('question_type', 'mcq')->count(),
                'descriptive_questions' => Question::where('question_type', 'descriptive')->count(),
                'true_false_questions' => Question::where('question_type', 'true_false')->count(),
                
                // Question Performance Statistics
                'total_question_attempts' => QuestionStat::count(),
                'total_correct_answers' => QuestionStat::where('is_correct', true)->count(),
                'overall_accuracy' => QuestionStat::count() > 0 ? 
                    round((QuestionStat::where('is_correct', true)->count() / QuestionStat::count()) * 100, 2) : 0,
                
                // Test Statistics
                'total_exam_attempts' => ExamResult::count(),
                'completed_exams' => ExamResult::where('status', 'completed')->count(),
                'ongoing_exams' => ExamResult::where('status', 'in_progress')->count(),
                'ongoing_tests' => ExamResult::where('status', 'in_progress')->count(),
                'total_ongoing_tests' => ExamResult::where('status', 'in_progress')->count(),
                'average_exam_score' => ExamResult::where('status', 'completed')
                    ->whereNotNull('percentage')
                    ->avg('percentage') ?? 0,
                
                // Revenue Statistics (placeholder - implement based on your payment system)
                'total_revenue' => 0, // Implement based on your payment system
                'total_earnings' => 0, // Alias for total_revenue
                'revenue_today' => 0,
                'earnings_today' => 0, // Alias for revenue_today
                'revenue_this_month' => 0,
                'pending_payments' => 0,
                'pending_payments_count' => 0,
                'pending_payments_amount' => 0,
                
                // System Statistics
                'total_sms_sent' => 0, // Implement based on your SMS system
                'cache_hit_rate' => $this->getCacheHitRate(),
                'database_size' => $this->getDatabaseSize(),
            ];
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error getting system stats: ' . $e->getMessage());
            return $this->getDefaultStats();
        }
    }
    
    /**
     * Get recent exams
     */
    private function getRecentExams()
    {
        try {
            return Exam::with('partner')
                ->latest()
                ->take(10) // More exams for super admin
                ->get();
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error getting recent exams: ' . $e->getMessage());
            return collect();
        }
    }
    
    /**
     * Get recent exam results
     */
    private function getRecentResults()
    {
        try {
            return ExamResult::with(['student', 'exam'])
                ->latest('completed_at')
                ->take(10) // More results for super admin
                ->get();
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error getting recent results: ' . $e->getMessage());
            return collect();
        }
    }
    
    /**
     * Get recent system activity
     */
    private function getRecentActivity()
    {
        try {
            $activities = collect();
            
            // Recent user registrations (all users for super admin)
            $recentUsers = EnhancedUser::latest()
                ->take(10)
                ->get()
                ->map(function($user) {
                    return [
                        'type' => 'user_registration',
                        'title' => 'User Registration',
                        'description' => $user->name . ' registered as ' . ($user->role ?? 'user'),
                        'time' => $user->created_at,
                        'icon' => 'user',
                        'color' => 'blue'
                    ];
                });
            
            // Recent exam completions (all exam results for super admin)
            $recentExams = ExamResult::latest('completed_at')
                ->take(10)
                ->get()
                ->map(function($result) {
                    return [
                        'type' => 'exam_completion',
                        'title' => 'Exam Activity',
                        'description' => 'Exam ' . ($result->status ?? 'unknown') . ' with ' . ($result->percentage ?? 0) . '% score',
                        'time' => $result->completed_at ?? $result->created_at,
                        'icon' => 'exam',
                        'color' => 'green'
                    ];
                });
            
            // Recent partner activities (all partners for super admin)
            $recentPartners = Partner::latest()
                ->take(10)
                ->get()
                ->map(function($partner) {
                    return [
                        'type' => 'partner_activity',
                        'title' => 'Partner Activity',
                        'description' => $partner->name . ' (Status: ' . ($partner->status ?? 'unknown') . ')',
                        'time' => $partner->updated_at,
                        'icon' => 'building',
                        'color' => 'purple'
                    ];
                });
            
            // Merge all activities and sort by time
            $allActivities = $activities
                ->merge($recentUsers)
                ->merge($recentExams)
                ->merge($recentPartners);
            
            // Sort by time and take the most recent 20 (more data for super admin)
            return $allActivities
                ->sortByDesc(function($activity) {
                    return $activity['time'] ?? now();
                })
                ->take(20);
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error getting recent activity: ' . $e->getMessage());
            return collect();
        }
    }
    
    /**
     * Get user growth data for charts
     */
    private function getUserGrowthData()
    {
        try {
            $data = [];
            $months = 6;
            
            for ($i = $months - 1; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $startOfMonth = $date->copy()->startOfMonth();
                $endOfMonth = $date->copy()->endOfMonth();
                
                $data[] = [
                    'month' => $date->format('M Y'),
                    'users' => EnhancedUser::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
                    'students' => Student::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
                    'partners' => Partner::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
                ];
            }
            
            return $data;
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error getting user growth data: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get revenue data
     */
    private function getRevenueData()
    {
        // Placeholder implementation - replace with actual revenue logic
        return [
            'today' => 0,
            'this_month' => 0,
            'last_month' => 0,
            'growth_percentage' => 0,
        ];
    }
    
    /**
     * Get top performing partners
     */
    private function getTopPartners()
    {
        try {
            return Partner::latest()
                ->take(20) // More partners for super admin
                ->get()
                ->map(function($partner) {
                    return [
                        'id' => $partner->id,
                        'name' => $partner->name,
                        'students_count' => $partner->students()->count(), // Real student count
                        'exams_count' => $partner->exams()->count(), // Real exam count
                        'total_exam_attempts' => $partner->examResults()->count(), // Real exam attempts
                        'status' => $partner->status,
                        'created_at' => $partner->created_at,
                    ];
                });
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error getting top partners: ' . $e->getMessage());
            return collect();
        }
    }
    
    /**
     * Get system health status
     */
    private function getSystemHealth()
    {
        return [
            'database' => $this->checkDatabaseConnection(),
            'cache' => $this->checkCacheStatus(),
            'storage' => $this->checkStorageStatus(),
            'queue' => $this->checkQueueStatus(),
            'mail' => $this->checkMailStatus(),
            'overall' => 'healthy', // Will be calculated based on individual checks
        ];
    }
    
    /**
     * Get upcoming events and notifications
     */
    private function getUpcomingEvents()
    {
        try {
            $events = collect();
            
            // All exams (no filtering for super admin)
            $upcomingExams = Exam::with('partner')
                ->take(10)
                ->get()
                ->map(function($exam) {
                    return [
                        'type' => 'exam',
                        'title' => 'Exam: ' . $exam->title,
                        'description' => 'Status: ' . ($exam->status ?? 'unknown') . ' - Partner: ' . ($exam->partner->name ?? 'Unknown'),
                        'time' => $exam->start_time ?? $exam->created_at,
                        'priority' => 'medium',
                    ];
                });
            
            // All partners (no filtering for super admin)
            $pendingPartners = Partner::latest()
                ->take(10)
                ->get()
                ->map(function($partner) {
                    return [
                        'type' => 'partner',
                        'title' => 'Partner: ' . $partner->name,
                        'description' => 'Status: ' . ($partner->status ?? 'unknown') . ' - Created: ' . $partner->created_at->format('M d, Y'),
                        'time' => $partner->created_at,
                        'priority' => 'medium',
                    ];
                });
            
            // Merge all events and sort by time
            $allEvents = $events
                ->merge($upcomingExams)
                ->merge($pendingPartners);
            
            return $allEvents->sortBy(function($event) {
                return $event['time'] ?? now();
            });
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error getting upcoming events: ' . $e->getMessage());
            return collect();
        }
    }
    
    /**
     * Check database connection
     */
    private function checkDatabaseConnection()
    {
        try {
            DB::connection()->getPdo();
            return ['status' => 'healthy', 'message' => 'Connected'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Connection failed'];
        }
    }
    
    /**
     * Check cache status
     */
    private function checkCacheStatus()
    {
        try {
            Cache::put('health_check', 'ok', 60);
            $value = Cache::get('health_check');
            return ['status' => $value === 'ok' ? 'healthy' : 'warning', 'message' => 'Cache operational'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Cache unavailable'];
        }
    }
    
    /**
     * Check storage status
     */
    private function checkStorageStatus()
    {
        try {
            $freeSpace = disk_free_space(storage_path());
            $totalSpace = disk_total_space(storage_path());
            $usagePercentage = (($totalSpace - $freeSpace) / $totalSpace) * 100;
            
            if ($usagePercentage > 90) {
                return ['status' => 'warning', 'message' => 'Storage almost full (' . round($usagePercentage, 1) . '%)'];
            }
            
            return ['status' => 'healthy', 'message' => 'Storage available (' . round($usagePercentage, 1) . '% used)'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Storage check failed'];
        }
    }
    
    /**
     * Check queue status
     */
    private function checkQueueStatus()
    {
        try {
            // This is a basic check - implement based on your queue driver
            return ['status' => 'healthy', 'message' => 'Queue operational'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Queue unavailable'];
        }
    }
    
    /**
     * Check mail status
     */
    private function checkMailStatus()
    {
        try {
            // Basic mail configuration check
            $mailConfig = config('mail.default');
            return ['status' => $mailConfig ? 'healthy' : 'warning', 'message' => 'Mail configured'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Mail configuration error'];
        }
    }
    
    /**
     * Get cache hit rate
     */
    private function getCacheHitRate()
    {
        // Implement cache hit rate calculation based on your cache driver
        return '95%'; // Placeholder
    }
    
    /**
     * Get database size
     */
    private function getDatabaseSize()
    {
        try {
            $result = DB::select("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'size_mb' FROM information_schema.tables WHERE table_schema = ?", [config('database.connections.mysql.database')]);
            return $result[0]->size_mb . ' MB';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }
    
    /**
     * Get default stats for error fallback
     */
    private function getDefaultStats()
    {
        return [
            'total_users' => 0,
            'active_users_today' => 0,
            'active_users_this_month' => 0,
            'new_users_today' => 0,
            'new_users_this_week' => 0,
            'new_users_this_month' => 0,
            'total_students' => 0,
            'active_students_today' => 0,
            'active_students_this_month' => 0,
            'students_with_login_access' => 0,
            'total_partners' => 0,
            'active_partners' => 0,
            'active_partners_today' => 0,
            'pending_partners' => 0,
            'total_questions' => 0,
            'total_exams' => 0,
            'total_courses' => 0,
            'total_subjects' => 0,
            'total_topics' => 0,
            'total_batches' => 0,
            
            // Question Type Statistics
            'mcq_questions' => 0,
            'descriptive_questions' => 0,
            'true_false_questions' => 0,
            
            // Question Performance Statistics
            'total_question_attempts' => 0,
            'total_correct_answers' => 0,
            'overall_accuracy' => 0,
            'total_exam_attempts' => 0,
            'completed_exams' => 0,
            'ongoing_exams' => 0,
            'ongoing_tests' => 0,
            'total_ongoing_tests' => 0,
            'average_exam_score' => 0,
            'total_revenue' => 0,
            'total_earnings' => 0,
            'revenue_today' => 0,
            'earnings_today' => 0,
            'revenue_this_month' => 0,
            'pending_payments' => 0,
            'pending_payments_count' => 0,
            'pending_payments_amount' => 0,
            'total_sms_sent' => 0,
            'cache_hit_rate' => '0%',
            'database_size' => '0 MB',
        ];
    }
    
    /**
     * Get default system health for error fallback
     */
    private function getDefaultSystemHealth()
    {
        return [
            'database' => ['status' => 'unknown', 'message' => 'Unable to check'],
            'cache' => ['status' => 'unknown', 'message' => 'Unable to check'],
            'storage' => ['status' => 'unknown', 'message' => 'Unable to check'],
            'queue' => ['status' => 'unknown', 'message' => 'Unable to check'],
            'mail' => ['status' => 'unknown', 'message' => 'Unable to check'],
            'overall' => 'unknown',
        ];
    }
    
    /**
     * System maintenance actions
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            
            return response()->json([
                'success' => true,
                'message' => 'Cache cleared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error clearing cache: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get system logs
     */
    public function getSystemLogs()
    {
        try {
            $logFile = storage_path('logs/laravel.log');
            if (file_exists($logFile)) {
                $logs = file_get_contents($logFile);
                $recentLogs = collect(explode("\n", $logs))
                    ->filter()
                    ->take(-100) // Last 100 lines
                    ->values();
                
                return response()->json([
                    'success' => true,
                    'logs' => $recentLogs
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Log file not found'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error reading logs: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get user statistics for charts
     */
    public function getUserStats()
    {
        try {
            $stats = $this->getSystemStats();
            $userGrowthData = $this->getUserGrowthData();
            
            return response()->json([
                'success' => true,
                'stats' => $stats,
                'userGrowthData' => $userGrowthData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching user statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show all students list
     */
    public function allStudents(Request $request)
    {
        try {
            \Log::info('SystemAdminController: allStudents called with params:', $request->all());
            
            // Start with base query
            $query = Student::with(['partner', 'examResults'])
                ->withCount('examResults');

            // Apply filters
            if ($request->filled('search')) {
                $searchTerm = $request->get('search');
                \Log::info('SystemAdminController: Applying search filter:', ['search' => $searchTerm]);
                $query->where(function($q) use ($searchTerm) {
                    $q->where('full_name', 'like', "%{$searchTerm}%")
                      ->orWhere('phone', 'like', "%{$searchTerm}%")
                      ->orWhere('email', 'like', "%{$searchTerm}%");
                });
            }

            if ($request->filled('partner')) {
                $query->where('partner_id', $request->get('partner'));
            }

            if ($request->filled('status')) {
                $query->where('status', $request->get('status'));
            }

            if ($request->filled('login_enabled')) {
                $loginEnabled = $request->get('login_enabled');
                \Log::info('SystemAdminController: Applying login_enabled filter:', ['login_enabled' => $loginEnabled]);
                if ($loginEnabled === 'yes') {
                    // Students with login access (exist in ac_users table with role 'student')
                    $query->whereExists(function($q) {
                        $q->select(\DB::raw(1))
                          ->from('ac_users')
                          ->whereRaw('ac_users.id = students.id')
                          ->where('ac_users.role', 'student');
                    });
                } elseif ($loginEnabled === 'no') {
                    // Students without login access (don't exist in ac_users table with role 'student')
                    $query->whereNotExists(function($q) {
                        $q->select(\DB::raw(1))
                          ->from('ac_users')
                          ->whereRaw('ac_users.id = students.id')
                          ->where('ac_users.role', 'student');
                    });
                }
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->get('date_from'));
            }

            // Get paginated results
            $students = $query->latest()->paginate(20);

            // Get summary statistics (unfiltered)
            $totalStudents = Student::count();
            $activeStudents = Student::where('status', 'active')->count();
            $inactiveStudents = Student::where('status', '!=', 'active')->count(); // All non-active students
            $softDeletedStudents = 0; // No soft delete in this model
            $totalPartners = Partner::count();
            $newStudentsThisMonth = Student::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
            $studentsWithLoginAccess = EnhancedUser::where('role', 'student')->count();

            // Get all partners for filter dropdown
            $partners = Partner::select('id', 'name')->get();

            // Calculate average scores for students and check login access
            foreach ($students as $student) {
                if ($student->examResults->count() > 0) {
                    $student->average_score = round($student->examResults->avg('percentage'), 1);
                } else {
                    $student->average_score = 0;
                }
                
                // Check if student has login access (exists in ac_users table with role 'student')
                $student->has_login_access = EnhancedUser::where('id', $student->id)->where('role', 'student')->exists();
            }

            // If AJAX request, return only the table body
            if ($request->ajax()) {
                return view('system-admin.su-allstudents', compact(
                    'students',
                    'totalStudents',
                    'activeStudents', 
                    'inactiveStudents',
                    'softDeletedStudents',
                    'totalPartners',
                    'partners',
                    'newStudentsThisMonth',
                    'studentsWithLoginAccess'
                ));
            }

            return view('system-admin.su-allstudents', compact(
                'students',
                'totalStudents',
                'activeStudents', 
                'inactiveStudents',
                'softDeletedStudents',
                'totalPartners',
                'partners',
                'newStudentsThisMonth',
                'studentsWithLoginAccess'
            ));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading all students: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json(['error' => 'Unable to load students data: ' . $e->getMessage()], 500);
            }
            
                return view('system-admin.su-allstudents', [
                    'students' => collect(),
                    'totalStudents' => 0,
                    'activeStudents' => 0,
                    'inactiveStudents' => 0, 
                    'softDeletedStudents' => 0,
                    'totalPartners' => 0,
                    'partners' => collect(),
                    'newStudentsThisMonth' => 0,
                    'studentsWithLoginAccess' => 0,
                    'error' => 'Unable to load students data: ' . $e->getMessage()
                ]);
        }
    }

    /**
     * Get student details for modal
     */
    public function getStudent($id)
    {
        try {
            $student = Student::with(['partner', 'examResults'])
                ->findOrFail($id);

            return response()->json([
                'id' => $student->id,
                'name' => $student->full_name,
                'mobile' => $student->phone,
                'email' => $student->email,
                'partner' => $student->partner,
                'created_at' => $student->created_at->format('Y-m-d'),
                'exam_results_count' => $student->examResults->count(),
                'average_score' => $student->examResults->count() > 0 ? 
                    round($student->examResults->avg('percentage'), 1) : 0,
                'last_login_at' => null, // No last_login_at field in this model
                'status' => $student->status,
                'deleted_at' => null // No soft delete in this model
            ]);

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error getting student details: ' . $e->getMessage());
            return response()->json(['error' => 'Student not found'], 404);
        }
    }

    public function disableStudentLogin($id)
    {
        try {
            // Check if student exists
            $student = Student::findOrFail($id);
            
            // Check if student has login access (exists in ac_users table)
            $user = EnhancedUser::find($id);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student does not have login access'
                ], 400);
            }
            
            // Delete the user from ac_users table to disable login
            $user->delete();
            
            \Log::info("SystemAdminController: Disabled login access for student ID: {$id}");
            
            return response()->json([
                'success' => true,
                'message' => 'Login access disabled successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error disabling student login: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error disabling login access: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resetStudentPassword($id)
    {
        try {
            // Check if student exists
            $student = Student::findOrFail($id);
            
            // Check if student has login access (exists in ac_users table)
            $user = EnhancedUser::find($id);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student does not have login access'
                ], 400);
            }
            
            // Generate a temporary password
            $temporaryPassword = \Str::random(12);
            
            // Update the user's password
            $user->update([
                'password' => \Hash::make($temporaryPassword)
            ]);
            
            \Log::info("SystemAdminController: Reset password for student ID: {$id}");
            
            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully',
                'temporary_password' => $temporaryPassword
            ]);

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error resetting student password: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error resetting password: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show all partners list
     */
    public function allPartners(Request $request)
    {
        try {
            // Start with base query
            $query = Partner::with(['students', 'exams'])
                ->withCount(['students', 'exams']);

            // Apply filters
            if ($request->filled('search')) {
                $searchTerm = $request->get('search');
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%")
                      ->orWhere('owner_name', 'like', "%{$searchTerm}%")
                      ->orWhere('phone', 'like', "%{$searchTerm}%")
                      ->orWhere('email', 'like', "%{$searchTerm}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->get('status'));
            }

            if ($request->filled('plan')) {
                $query->where('subscription_plan', $request->get('plan'));
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->get('date_from'));
            }

            // Get paginated results
            $partners = $query->latest()->paginate(20);

            // Calculate summary statistics
            $totalStudentsViaPartners = Student::count();
            $totalTestsConducted = Exam::count();
            $avgTestsPerPartner = Partner::count() > 0 ? round($totalTestsConducted / Partner::count(), 1) : 0;
            
            // Get top performing partner
            $topPartner = Partner::withCount('students')
                ->orderBy('students_count', 'desc')
                ->first();
            $topPerformingPartner = $topPartner ? $topPartner->name : 'N/A';
            
            $totalRevenue = 0; // Placeholder for revenue calculation

            // If AJAX request, return only the table body
            if ($request->ajax()) {
                return view('system-admin.sa-partner-management', compact(
                    'partners',
                    'totalStudentsViaPartners',
                    'totalTestsConducted',
                    'avgTestsPerPartner',
                    'topPerformingPartner',
                    'totalRevenue'
                ));
            }

            return view('system-admin.sa-partner-management', compact(
                'partners',
                'totalStudentsViaPartners',
                'totalTestsConducted',
                'avgTestsPerPartner',
                'topPerformingPartner',
                'totalRevenue'
            ));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading all partners: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json(['error' => 'Unable to load partners data: ' . $e->getMessage()], 500);
            }
            
            return view('system-admin.sa-partner-management', [
                'partners' => collect(),
                'totalStudentsViaPartners' => 0,
                'totalTestsConducted' => 0,
                'avgTestsPerPartner' => 0,
                'topPerformingPartner' => 'N/A',
                'totalRevenue' => 0,
                'error' => 'Unable to load partners data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get partner details for modal
     */
    public function getPartner($id)
    {
        try {
            $partner = Partner::with(['students', 'exams'])
                ->findOrFail($id);

            return response()->json([
                'id' => $partner->id,
                'name' => $partner->name,
                'owner_name' => $partner->owner_name,
                'phone' => $partner->phone,
                'email' => $partner->email,
                'address' => $partner->address,
                'subscription_plan' => $partner->subscription_plan ?? 'free',
                'status' => $partner->status ?? 'active',
                'created_at' => $partner->created_at->format('Y-m-d'),
                'students_count' => $partner->students->count(),
                'exams_count' => $partner->exams->count(),
            ]);

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error getting partner details: ' . $e->getMessage());
            return response()->json(['error' => 'Partner not found'], 404);
        }
    }

    // Subscription Management Methods
    public function subscriptionPlans()
    {
        try {
            // Mock data for subscription plans
            $plans = [
                [
                    'id' => 1,
                    'name' => 'Free',
                    'slug' => 'free',
                    'price' => 0,
                    'currency' => 'BDT',
                    'billing_cycle' => 'monthly',
                    'is_popular' => false,
                    'features' => [
                        'max_students' => 50,
                        'max_tests' => 10,
                        'max_questions' => 100,
                        'storage_gb' => 1,
                        'support' => 'email',
                        'analytics' => 'basic',
                        'custom_branding' => false,
                        'api_access' => false
                    ]
                ],
                [
                    'id' => 2,
                    'name' => 'Basic',
                    'slug' => 'basic',
                    'price' => 2500,
                    'currency' => 'BDT',
                    'billing_cycle' => 'monthly',
                    'is_popular' => true,
                    'features' => [
                        'max_students' => 200,
                        'max_tests' => 50,
                        'max_questions' => 500,
                        'storage_gb' => 5,
                        'support' => 'email_phone',
                        'analytics' => 'standard',
                        'custom_branding' => true,
                        'api_access' => false
                    ]
                ],
                [
                    'id' => 3,
                    'name' => 'Premium',
                    'slug' => 'premium',
                    'price' => 5000,
                    'currency' => 'BDT',
                    'billing_cycle' => 'monthly',
                    'is_popular' => false,
                    'features' => [
                        'max_students' => 500,
                        'max_tests' => 200,
                        'max_questions' => 2000,
                        'storage_gb' => 20,
                        'support' => 'priority',
                        'analytics' => 'advanced',
                        'custom_branding' => true,
                        'api_access' => true
                    ]
                ],
                [
                    'id' => 4,
                    'name' => 'Enterprise',
                    'slug' => 'enterprise',
                    'price' => 10000,
                    'currency' => 'BDT',
                    'billing_cycle' => 'monthly',
                    'is_popular' => false,
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
                    ]
                ]
            ];

            return view('system-admin.sa-subscription-plans', compact('plans'));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading subscription plans: ' . $e->getMessage());
            return view('system-admin.sa-subscription-plans', [
                'plans' => [],
                'error' => 'Unable to load subscription plans: ' . $e->getMessage()
            ]);
        }
    }

    public function subscriptionOverview()
    {
        try {
            // Mock data for subscription overview
            $overview = [
                'total_revenue' => 45000,
                'active_subscriptions' => 27,
                'monthly_recurring_revenue' => 15000,
                'churn_rate' => 3.2,
                'revenue_growth' => 12.5,
                'mrr_growth' => 8.2,
                'churn_improvement' => -0.5
            ];

            $recentSubscriptions = [
                [
                    'partner' => 'Smart Learn Coaching',
                    'plan' => 'Premium',
                    'amount' => 5000,
                    'date' => '2024-01-15'
                ],
                [
                    'partner' => 'EduTech Center',
                    'plan' => 'Basic',
                    'amount' => 2500,
                    'date' => '2024-01-14'
                ],
                [
                    'partner' => 'Future Academy',
                    'plan' => 'Enterprise',
                    'amount' => 10000,
                    'date' => '2024-01-13'
                ]
            ];

            $planStats = [
                'free' => 12,
                'basic' => 8,
                'premium' => 5,
                'enterprise' => 2
            ];

            return view('system-admin.sa-subscription-overview', compact('overview', 'recentSubscriptions', 'planStats'));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading subscription overview: ' . $e->getMessage());
            return view('system-admin.sa-subscription-overview', [
                'overview' => [],
                'recentSubscriptions' => [],
                'planStats' => [],
                'error' => 'Unable to load subscription overview: ' . $e->getMessage()
            ]);
        }
    }

    public function subscriptionUsage()
    {
        try {
            // Mock data for usage tracking
            $usageStats = [
                'students' => [
                    'current' => 1247,
                    'limit' => 2500,
                    'percentage' => 49.9
                ],
                'tests' => [
                    'current' => 89,
                    'limit' => 200,
                    'percentage' => 44.5
                ],
                'questions' => [
                    'current' => 1156,
                    'limit' => 2500,
                    'percentage' => 46.2
                ],
                'storage' => [
                    'current' => 45.2,
                    'limit' => 100,
                    'percentage' => 45.2
                ]
            ];

            $partnerUsage = [
                [
                    'partner' => 'Smart Learn Coaching',
                    'plan' => 'Premium',
                    'students' => ['current' => 150, 'limit' => 200, 'percentage' => 75],
                    'tests' => ['current' => 45, 'limit' => 100, 'percentage' => 45],
                    'questions' => ['current' => 600, 'limit' => 1000, 'percentage' => 60],
                    'storage' => ['current' => 6, 'limit' => 20, 'percentage' => 30],
                    'status' => 'healthy'
                ],
                [
                    'partner' => 'EduTech Center',
                    'plan' => 'Basic',
                    'students' => ['current' => 190, 'limit' => 200, 'percentage' => 95],
                    'tests' => ['current' => 45, 'limit' => 50, 'percentage' => 90],
                    'questions' => ['current' => 400, 'limit' => 500, 'percentage' => 80],
                    'storage' => ['current' => 2, 'limit' => 5, 'percentage' => 40],
                    'status' => 'critical'
                ]
            ];

            $alerts = [
                [
                    'type' => 'critical',
                    'partner' => 'EduTech Center',
                    'message' => 'is approaching student limit (95% used)',
                    'suggestion' => 'Consider upgrading to Premium plan'
                ],
                [
                    'type' => 'warning',
                    'partner' => 'Future Academy',
                    'message' => 'is approaching test limit (85% used)',
                    'suggestion' => 'Monitor usage closely'
                ]
            ];

            return view('system-admin.sa-subscription-usage', compact('usageStats', 'partnerUsage', 'alerts'));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading subscription usage: ' . $e->getMessage());
            return view('system-admin.sa-subscription-usage', [
                'usageStats' => [],
                'partnerUsage' => [],
                'alerts' => [],
                'error' => 'Unable to load subscription usage: ' . $e->getMessage()
            ]);
        }
    }

    public function subscriptionBilling()
    {
        try {
            // Mock data for billing and payments
            $billingStats = [
                'total_revenue' => 45000,
                'pending_payments' => 7500,
                'monthly_recurring_revenue' => 15000,
                'failed_payments' => 2500,
                'revenue_growth' => 12.5,
                'mrr_growth' => 8.2,
                'pending_count' => 3,
                'failed_count' => 2
            ];

            $transactions = [
                [
                    'id' => 'TXN-2024-001',
                    'partner' => 'Smart Learn Coaching',
                    'plan' => 'Premium',
                    'amount' => 5000,
                    'payment_method' => 'bKash',
                    'status' => 'completed',
                    'date' => '2024-01-15'
                ],
                [
                    'id' => 'TXN-2024-002',
                    'partner' => 'EduTech Center',
                    'plan' => 'Basic',
                    'amount' => 2500,
                    'payment_method' => 'Bank Transfer',
                    'status' => 'pending',
                    'date' => '2024-01-14'
                ],
                [
                    'id' => 'TXN-2024-003',
                    'partner' => 'Future Academy',
                    'plan' => 'Enterprise',
                    'amount' => 10000,
                    'payment_method' => 'Credit Card',
                    'status' => 'failed',
                    'date' => '2024-01-13'
                ]
            ];

            $paymentMethods = [
                [
                    'name' => 'bKash',
                    'type' => 'Mobile Financial Service',
                    'status' => 'active',
                    'usage_percentage' => 45
                ],
                [
                    'name' => 'Nagad',
                    'type' => 'Mobile Financial Service',
                    'status' => 'active',
                    'usage_percentage' => 25
                ],
                [
                    'name' => 'Rocket',
                    'type' => 'Mobile Financial Service',
                    'status' => 'active',
                    'usage_percentage' => 20
                ],
                [
                    'name' => 'Bank Transfer',
                    'type' => 'Traditional Banking',
                    'status' => 'active',
                    'usage_percentage' => 10
                ]
            ];

            return view('system-admin.sa-subscription-billing', compact('billingStats', 'transactions', 'paymentMethods'));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading subscription billing: ' . $e->getMessage());
            return view('system-admin.sa-subscription-billing', [
                'billingStats' => [],
                'transactions' => [],
                'paymentMethods' => [],
                'error' => 'Unable to load subscription billing: ' . $e->getMessage()
            ]);
        }
    }
}
