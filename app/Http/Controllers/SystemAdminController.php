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
     * Student Interactive Grid View
     */
    public function studentInteractiveGrid(Request $request)
    {
        try {
            $query = Student::with(['partner', 'examResults'])
                ->withCount('examResults');

            // Apply filters
            if ($request->has('search') && $request->search) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('full_name', 'like', "%{$searchTerm}%")
                      ->orWhere('phone', 'like', "%{$searchTerm}%")
                      ->orWhere('email', 'like', "%{$searchTerm}%");
                });
            }

            if ($request->has('partner') && $request->partner) {
                $query->where('partner_id', $request->partner);
            }

            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            $students = $query->latest()->paginate(50);

            // Calculate average scores and check login access
            foreach ($students as $student) {
                if ($student->exam_results_count > 0) {
                    $student->average_score = round($student->examResults->avg('percentage'), 1);
                } else {
                    $student->average_score = 0;
                }
                
                // Check if student has login access
                $student->has_login_access = EnhancedUser::where('id', $student->id)->where('role', 'student')->exists();
            }

            // Get all partners for filters
            $partners = Partner::select('id', 'name')->get();

            return view('system-admin.sa-student-ig', compact('students', 'partners'));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading student interactive grid: ' . $e->getMessage());
            
            return view('system-admin.sa-student-ig', [
                'students' => collect(),
                'partners' => collect(),
                'error' => 'Unable to load student data: ' . $e->getMessage()
            ]);
        }
    }

    public function singleStudentInteractiveGrid($id)
    {
        try {
            $student = Student::with(['partner', 'examResults'])
                ->withCount('examResults')
                ->findOrFail($id);

            // Calculate average score
            if ($student->exam_results_count > 0) {
                $student->average_score = round($student->examResults->avg('percentage'), 1);
            } else {
                $student->average_score = 0;
            }

            // Check login access
            $student->has_login_access = EnhancedUser::where('id', $student->id)->where('role', 'student')->exists();

            // Get all partners for dropdown
            $partners = Partner::select('id', 'name')->get();

            return view('system-admin.sa-single-student-ig', compact('student', 'partners'));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading single student interactive grid: ' . $e->getMessage());
            
            return redirect()->route('system-admin.all-students')
                ->with('error', 'Student not found: ' . $e->getMessage());
        }
    }

    /**
     * Get detailed student information for modal
     */
    public function getStudentDetails($id)
    {
        try {
            $student = Student::with(['partner', 'examResults'])
                ->withCount('examResults')
                ->findOrFail($id);

            // Calculate average score
            if ($student->exam_results_count > 0) {
                $student->average_score = round($student->examResults->avg('percentage'), 1);
            } else {
                $student->average_score = 0;
            }

            // Check login access
            $student->has_login_access = EnhancedUser::where('id', $student->id)->where('role', 'student')->exists();

            return response()->json($student);

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading student details: ' . $e->getMessage());
            return response()->json(['error' => 'Student not found'], 404);
        }
    }

    /**
     * Update a specific student field
     */
    public function updateStudentField(Request $request, $id)
    {
        try {
            $student = Student::findOrFail($id);
            
            $field = $request->input('field');
            $value = $request->input('value');

            // Validate allowed fields
            $allowedFields = ['full_name', 'phone', 'email', 'partner_id', 'status'];
            if (!in_array($field, $allowedFields)) {
                return response()->json(['success' => false, 'message' => 'Field not allowed'], 400);
            }

            // Validate partner_id if provided
            if ($field === 'partner_id' && $value) {
                $partner = Partner::find($value);
                if (!$partner) {
                    return response()->json(['success' => false, 'message' => 'Invalid partner'], 400);
                }
            }

            // Validate status if provided
            if ($field === 'status') {
                $allowedStatuses = ['active', 'suspended', 'inactive'];
                if (!in_array($value, $allowedStatuses)) {
                    return response()->json(['success' => false, 'message' => 'Invalid status'], 400);
                }
            }

            // Update the field
            $student->update([$field => $value]);

            return response()->json(['success' => true, 'message' => 'Field updated successfully']);

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error updating student field: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error updating field: ' . $e->getMessage()], 500);
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
    public function subscriptionPlans(Request $request)
    {
        try {
            // Get partner type filter (default to 'partner')
            $partnerType = $request->get('type', 'partner');
            
            // Get all plans from database filtered by partner type
            $plans = \App\Models\SubscriptionPlan::with(['planFeatures', 'enabledFeatures'])
                ->where('partner_type', $partnerType)
                ->orderBy('sort_order')
                ->orderBy('price')
                ->get();

            return view('system-admin.sa-subscription-plans', compact('plans', 'partnerType'));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading subscription plans: ' . $e->getMessage());
            return view('system-admin.sa-subscription-plans', [
                'plans' => collect(),
                'partnerType' => 'partner',
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

    /**
     * Show create subscription form
     */
    public function createSubscription()
    {
        try {
            return view('system-admin.sa-create-subscription');
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading create subscription form: ' . $e->getMessage());
            return redirect()->route('system-admin.subscription-plans')
                ->with('error', 'Unable to load create subscription form: ' . $e->getMessage());
        }
    }

    /**
     * Store new subscription plan
     */
    public function storeSubscription(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:subscription_plans,slug',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'is_custom_pricing' => 'boolean',
                'currency' => 'required|string|in:BDT,USD,EUR',
                'billing_cycle' => 'required|string|in:monthly,yearly,lifetime',
                'partner_type' => 'required|string|in:partner,student',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean',
                'is_popular' => 'boolean',
                'implementation_cost' => 'nullable|numeric|min:0',
                'implementation_cost_label' => 'nullable|string|max:100',
                'enable_offer' => 'boolean',
                'offer_price' => 'nullable|numeric|min:0',
                'offer_name' => 'nullable|string|max:255',
                'offer_description' => 'nullable|string|max:500',
                'offer_start_date' => 'nullable|date',
                'offer_end_date' => 'nullable|date|after:offer_start_date',
                'offer_max_users' => 'nullable|integer|min:0',
                'enable_annual_offer' => 'boolean',
                'annual_offer_price' => 'nullable|numeric|min:0',
                'annual_offer_name' => 'nullable|string|max:255',
                'annual_offer_description' => 'nullable|string|max:500',
                'annual_offer_start_date' => 'nullable|date',
                'annual_offer_end_date' => 'nullable|date|after:annual_offer_start_date',
                'annual_offer_max_users' => 'nullable|integer|min:0',
                'referral_eligible' => 'boolean',
                'referral_reward_months' => 'nullable|integer|min:1|max:12',
                'referral_minimum_amount' => 'nullable|numeric|min:0',
                'referral_conditions' => 'nullable|json',
                'features' => 'nullable|array',
                'features.*.enabled' => 'boolean',
                'features.*.value' => 'nullable|string',
                'features.*.limit_value' => 'nullable|string',
            ]);

            // Handle table-driven features
            $featuresData = [];
            if ($request->has('features')) {
                foreach ($request->features as $featureId => $featureData) {
                    if (isset($featureData['enabled']) && $featureData['enabled']) {
                        // Get the feature to determine its type
                        $feature = \App\Models\PlanFeature::find($featureId);
                        $defaultValue = ($feature && $feature->type === 'boolean') ? '1' : '0';
                        
                        $featuresData[$featureId] = [
                            'enabled' => true,
                            'value' => $featureData['value'] ?? $defaultValue,
                            'limit_value' => $featureData['limit_value'] ?? $defaultValue,
                        ];
                    }
                }
            }

            // Handle offer pricing
            $offerData = [];
            if ($request->has('enable_offer')) {
                $offerData = [
                    'offer_price' => $request->offer_price,
                    'offer_name' => $request->offer_name,
                    'offer_description' => $request->offer_description,
                    'offer_start_date' => $request->offer_start_date,
                    'offer_end_date' => $request->offer_end_date,
                    'offer_max_users' => $request->offer_max_users,
                    'offer_code' => $request->offer_code,
                    'offer_badge_text' => $request->offer_badge_text,
                    'offer_badge_color' => $request->offer_badge_color ?: 'red',
                    'offer_is_active' => true,
                    'offer_auto_apply' => $request->has('offer_auto_apply'),
                    'offer_show_original_price' => $request->has('offer_show_original_price'),
                ];
            }

            // Handle annual offer pricing
            $annualOfferData = [];
            if ($request->has('enable_annual_offer')) {
                $monthlyPrice = $request->price ?: 0;
                $annualPrice = $request->annual_price ?: 0;
                $monthlyTotal = $monthlyPrice * 12;
                $savingsAmount = $monthlyTotal - $annualPrice;
                $savingsPercentage = $monthlyTotal > 0 ? round(($savingsAmount / $monthlyTotal) * 100, 1) : 0;

                $annualOfferData = [
                    'annual_price' => $request->annual_price,
                    'annual_offer_name' => $request->annual_offer_name,
                    'annual_offer_description' => $request->annual_offer_description,
                    'annual_discount_percentage' => $savingsPercentage,
                    'annual_savings_amount' => $savingsAmount,
                    'annual_offer_active' => true,
                    'annual_badge_text' => $request->annual_badge_text ?: 'SAVE 2 MONTHS',
                    'annual_badge_color' => $request->annual_badge_color ?: 'green',
                    'annual_show_monthly_equivalent' => $request->has('annual_show_monthly_equivalent'),
                    'annual_highlight_savings' => $request->has('annual_highlight_savings'),
                ];
            }

            // Handle referral system
            $referralData = [];
            if ($request->has('referral_eligible')) {
                $referralData = [
                    'referral_eligible' => true,
                    'referral_reward_months' => $request->referral_reward_months ?: 1,
                    'referral_minimum_amount' => $request->referral_minimum_amount,
                    'referral_conditions' => $request->referral_conditions ? json_decode($request->referral_conditions, true) : null,
                ];
            }

            $plan = \App\Models\SubscriptionPlan::create(array_merge([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'price' => $request->has('is_custom_pricing') || empty($request->price) ? null : $request->price,
                'currency' => $request->currency,
                'billing_cycle' => $request->billing_cycle,
                'partner_type' => $request->partner_type,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->has('is_active'),
                'is_popular' => $request->has('is_popular'),
                'implementation_cost' => $request->implementation_cost,
                'implementation_cost_label' => $request->implementation_cost_label,
            ], $offerData, $annualOfferData, $referralData));

            // Attach features to the plan
            if (!empty($featuresData)) {
                $plan->planFeatures()->sync($featuresData);
            }

            \Log::info("SystemAdminController: Created subscription plan: {$plan->name}");

            return redirect()->route('system-admin.subscription-plans')
                ->with('success', 'Subscription plan created successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error creating subscription plan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Unable to create subscription plan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show edit subscription form
     */
    public function editSubscription($id)
    {
        try {
            $plan = \App\Models\SubscriptionPlan::find($id);
            
            if (!$plan) {
                return redirect()->route('system-admin.subscription-plans')
                    ->with('error', 'Subscription plan not found. It may have been deleted.');
            }
            
            return view('system-admin.sa-edit-subscription', compact('plan'));
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading edit subscription form: ' . $e->getMessage());
            return redirect()->route('system-admin.subscription-plans')
                ->with('error', 'Unable to load edit subscription form: ' . $e->getMessage());
        }
    }

    /**
     * Update subscription plan
     */
    public function updateSubscription(Request $request, $id)
    {
        try {
            $plan = \App\Models\SubscriptionPlan::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:subscription_plans,slug,' . $id,
                'description' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'is_custom_pricing' => 'boolean',
                'currency' => 'required|string|in:BDT,USD,EUR',
                'billing_cycle' => 'required|string|in:monthly,yearly,lifetime',
                'partner_type' => 'required|string|in:partner,student',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean',
                'is_popular' => 'boolean',
                'implementation_cost' => 'nullable|numeric|min:0',
                'implementation_cost_label' => 'nullable|string|max:100',
                'features' => 'nullable|array',
                'features.*.enabled' => 'boolean',
                'features.*.value' => 'nullable|string',
                'features.*.limit_value' => 'nullable|string',
            ]);

            // Handle table-driven features
            $featuresData = [];
            if ($request->has('features')) {
                foreach ($request->features as $featureId => $featureData) {
                    if (isset($featureData['enabled']) && $featureData['enabled']) {
                        // Get the feature to determine its type
                        $feature = \App\Models\PlanFeature::find($featureId);
                        $defaultValue = ($feature && $feature->type === 'boolean') ? '1' : '0';
                        
                        $featuresData[$featureId] = [
                            'enabled' => true,
                            'value' => $featureData['value'] ?? $defaultValue,
                            'limit_value' => $featureData['limit_value'] ?? $defaultValue,
                        ];
                    }
                }
            }

            $plan->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'price' => $request->has('is_custom_pricing') || empty($request->price) ? null : $request->price,
                'currency' => $request->currency,
                'billing_cycle' => $request->billing_cycle,
                'partner_type' => $request->partner_type,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->has('is_active'),
                'is_popular' => $request->has('is_popular'),
                'implementation_cost' => $request->implementation_cost,
                'implementation_cost_label' => $request->implementation_cost_label,
            ]);

            // Update features
            $plan->planFeatures()->sync($featuresData);

            \Log::info("SystemAdminController: Updated subscription plan: {$plan->name}");

            return redirect()->route('system-admin.subscription-plans')
                ->with('success', 'Subscription plan updated successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error updating subscription plan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Unable to update subscription plan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete subscription plan
     */
    public function deleteSubscription($id)
    {
        try {
            $plan = \App\Models\SubscriptionPlan::findOrFail($id);
            $planName = $plan->name;
            $plan->delete();

            \Log::info("SystemAdminController: Deleted subscription plan: {$planName}");

            return response()->json([
                'success' => true,
                'message' => 'Subscription plan deleted successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error deleting subscription plan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete subscription plan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle custom plan request
     */
    public function customPlanRequest(Request $request)
    {
        try {
            $request->validate([
                'organization_name' => 'required|string|max:255',
                'contact_person' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'requirements' => 'required|string|min:10',
                'budget_range' => 'nullable|string',
                'timeline' => 'nullable|string',
                'additional_notes' => 'nullable|string',
            ]);

            // Store the custom plan request
            $customRequest = [
                'organization_name' => $request->organization_name,
                'contact_person' => $request->contact_person,
                'email' => $request->email,
                'phone' => $request->phone,
                'requirements' => $request->requirements,
                'budget_range' => $request->budget_range,
                'timeline' => $request->timeline,
                'additional_notes' => $request->additional_notes,
                'submitted_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ];

            // Log the request (you can also store in database or send email)
            \Log::info('Custom Plan Request Received:', $customRequest);

            // Here you can:
            // 1. Store in database
            // 2. Send email notification to admin
            // 3. Send confirmation email to requester
            // 4. Create a ticket in your support system

            // For now, we'll just log it and return success
            \Log::info("Custom plan request from: {$request->organization_name} ({$request->email})");

            return response()->json([
                'success' => true,
                'message' => 'Custom plan request submitted successfully! We will contact you within 24 hours.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error processing custom plan request: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unable to process custom plan request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function referralManagement()
    {
        try {
            // Get referral statistics
            $totalReferrals = \App\Models\Referral::count();
            $successfulReferrals = \App\Models\Referral::where('status', 'completed')->count();
            $pendingReferrals = \App\Models\Referral::where('status', 'pending')->count();
            $totalRewards = \App\Models\ReferralReward::sum('reward_value');
            $appliedRewards = \App\Models\ReferralReward::where('status', 'applied')->sum('reward_value');
            $pendingRewards = \App\Models\ReferralReward::where('status', 'pending')->sum('reward_value');

            // Get top referrers
            $topReferrers = \App\Models\Partner::withCount(['referrals', 'successfulReferrals'])
                ->orderBy('successful_referrals_count', 'desc')
                ->take(10)
                ->get();

            // Get recent referrals
            $recentReferrals = \App\Models\Referral::with(['referrer', 'referred', 'referralCode'])
                ->latest()
                ->take(20)
                ->get();

            // Get referral codes
            $referralCodes = \App\Models\ReferralCode::with(['referrer', 'referrals'])
                ->latest()
                ->take(20)
                ->get();

            // Get rewards
            $rewards = \App\Models\ReferralReward::with(['referrer', 'referral'])
                ->latest()
                ->take(20)
                ->get();

            $stats = [
                'total_referrals' => $totalReferrals,
                'successful_referrals' => $successfulReferrals,
                'pending_referrals' => $pendingReferrals,
                'success_rate' => $totalReferrals > 0 ? round(($successfulReferrals / $totalReferrals) * 100, 1) : 0,
                'total_rewards' => $totalRewards,
                'applied_rewards' => $appliedRewards,
                'pending_rewards' => $pendingRewards,
            ];

            return view('system-admin.sa-referral-management', compact(
                'stats',
                'topReferrers',
                'recentReferrals',
                'referralCodes',
                'rewards'
            ));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading referral management: ' . $e->getMessage());
            return view('system-admin.sa-referral-management', [
                'stats' => [],
                'topReferrers' => collect(),
                'recentReferrals' => collect(),
                'referralCodes' => collect(),
                'rewards' => collect(),
                'error' => 'Unable to load referral data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show plan features management page
     */
    public function planFeatures()
    {
        try {
            $features = \App\Models\PlanFeature::withCount('subscriptionPlans')
                ->orderBy('category')
                ->orderBy('sort_order')
                ->get()
                ->groupBy('category');

            $categories = \App\Models\PlanFeature::getCategories();

            return view('system-admin.sa-plan-features', compact('features', 'categories'));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading plan features: ' . $e->getMessage());
            return redirect()->route('system-admin.system-admin-dashboard')
                ->with('error', 'Unable to load plan features: ' . $e->getMessage());
        }
    }

    /**
     * Show create plan feature form
     */
    public function createPlanFeature()
    {
        try {
            $categories = \App\Models\PlanFeature::getCategories();
            $featureTypes = \App\Models\PlanFeature::getTypes();

            return view('system-admin.sa-create-plan-feature', compact('categories', 'featureTypes'));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading create plan feature form: ' . $e->getMessage());
            return redirect()->route('system-admin.plan-features')
                ->with('error', 'Unable to load create form: ' . $e->getMessage());
        }
    }

    /**
     * Store new plan feature
     */
    public function storePlanFeature(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:plan_features,slug',
                'description' => 'nullable|string',
                'type' => 'required|in:boolean,numeric,text,select',
                'category' => 'required|string|max:100',
                'feature_for' => 'required|in:partner,student,both',
                'unit' => 'nullable|string|max:50',
                'default_value' => 'nullable|string',
                'options' => 'nullable|array',
                'is_active' => 'boolean',
                'sort_order' => 'nullable|integer|min:0',
            ]);

            $feature = \App\Models\PlanFeature::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'type' => $request->type,
                'category' => $request->category,
                'feature_for' => $request->feature_for,
                'unit' => $request->unit,
                'default_value' => $request->default_value,
                'options' => $request->options,
                'is_active' => $request->has('is_active'),
                'sort_order' => $request->sort_order ?? 0,
            ]);

            \Log::info("SystemAdminController: Created plan feature: {$feature->name}");

            return redirect()->route('system-admin.plan-features')
                ->with('success', 'Plan feature created successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error creating plan feature: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Unable to create plan feature: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show edit plan feature form
     */
    public function editPlanFeature($id)
    {
        try {
            $feature = \App\Models\PlanFeature::findOrFail($id);
            $categories = \App\Models\PlanFeature::getCategories();
            $featureTypes = \App\Models\PlanFeature::getTypes();

            return view('system-admin.sa-edit-plan-feature', compact('feature', 'categories', 'featureTypes'));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading edit plan feature form: ' . $e->getMessage());
            return redirect()->route('system-admin.plan-features')
                ->with('error', 'Unable to load edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update plan feature
     */
    public function updatePlanFeature(Request $request, $id)
    {
        try {
            $feature = \App\Models\PlanFeature::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:plan_features,slug,' . $id,
                'description' => 'nullable|string',
                'type' => 'required|in:boolean,numeric,text,select',
                'category' => 'required|string|max:100',
                'feature_for' => 'required|in:partner,student,both',
                'unit' => 'nullable|string|max:50',
                'default_value' => 'nullable|string',
                'options' => 'nullable|array',
                'is_active' => 'boolean',
                'sort_order' => 'nullable|integer|min:0',
            ]);

            $feature->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'type' => $request->type,
                'category' => $request->category,
                'feature_for' => $request->feature_for,
                'unit' => $request->unit,
                'default_value' => $request->default_value,
                'options' => $request->options,
                'is_active' => $request->has('is_active'),
                'sort_order' => $request->sort_order ?? 0,
            ]);

            \Log::info("SystemAdminController: Updated plan feature: {$feature->name}");

            return redirect()->route('system-admin.plan-features')
                ->with('success', 'Plan feature updated successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error updating plan feature: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Unable to update plan feature: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete plan feature
     */
    public function deletePlanFeature($id)
    {
        try {
            $feature = \App\Models\PlanFeature::findOrFail($id);

            // Check if feature is being used by any plans
            if ($feature->subscriptionPlans()->count() > 0) {
                return redirect()->route('system-admin.plan-features')
                    ->with('error', 'Cannot delete feature that is being used by subscription plans');
            }

            $featureName = $feature->name;
            $feature->delete();

            \Log::info("SystemAdminController: Deleted plan feature: {$featureName}");

            return redirect()->route('system-admin.plan-features')
                ->with('success', 'Plan feature deleted successfully');

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error deleting plan feature: ' . $e->getMessage());
            return redirect()->route('system-admin.plan-features')
                ->with('error', 'Unable to delete plan feature: ' . $e->getMessage());
        }
    }

    /**
     * Show payment methods management page
     */
    public function paymentMethods()
    {
        try {
            $paymentMethods = \App\Models\PaymentMethod::ordered()->get();
            $types = \App\Models\PaymentMethod::getTypes();
            $currencies = \App\Models\PaymentMethod::getSupportedCurrencies();

            return view('system-admin.sa-payment-methods', compact('paymentMethods', 'types', 'currencies'));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading payment methods: ' . $e->getMessage());
            return redirect()->route('system-admin.system-admin-dashboard')
                ->with('error', 'Unable to load payment methods: ' . $e->getMessage());
        }
    }

    /**
     * Show create payment method form
     */
    public function createPaymentMethod()
    {
        try {
            $types = \App\Models\PaymentMethod::getTypes();
            $currencies = \App\Models\PaymentMethod::getSupportedCurrencies();

            return view('system-admin.sa-create-payment-method', compact('types', 'currencies'));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading create payment method form: ' . $e->getMessage());
            return redirect()->route('system-admin.payment-methods')
                ->with('error', 'Unable to load create form: ' . $e->getMessage());
        }
    }

    /**
     * Store new payment method
     */
    public function storePaymentMethod(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:payment_methods,slug',
                'type' => 'required|string|in:mobile,bank,cash,check',
                'provider' => 'nullable|string|max:255',
                'account_number' => 'required|string|max:255',
                'account_title' => 'required|string|max:255',
                'branch_name' => 'required|string|max:255',
                'routing_number' => 'nullable|string|max:255',
                'configuration' => 'nullable|array',
                'is_active' => 'boolean',
                'is_popular' => 'boolean',
                'requires_verification' => 'boolean',
                'sort_order' => 'nullable|integer|min:0',
            ]);

            $paymentMethod = \App\Models\PaymentMethod::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'type' => $request->type,
                'provider' => $request->provider,
                'account_number' => $request->account_number,
                'account_title' => $request->account_title,
                'branch_name' => $request->branch_name,
                'routing_number' => $request->routing_number,
                'configuration' => $request->configuration,
                'is_active' => $request->has('is_active'),
                'is_popular' => $request->has('is_popular'),
                'requires_verification' => $request->has('requires_verification'),
                'sort_order' => $request->sort_order ?: 0,
            ]);

            \Log::info("SystemAdminController: Created payment method: {$paymentMethod->name}");

            return redirect()->route('system-admin.payment-methods')
                ->with('success', 'Payment method created successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error creating payment method: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Unable to create payment method: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show edit payment method form
     */
    public function editPaymentMethod($id)
    {
        try {
            $paymentMethod = \App\Models\PaymentMethod::findOrFail($id);
            $types = \App\Models\PaymentMethod::getTypes();
            $currencies = \App\Models\PaymentMethod::getSupportedCurrencies();

            return view('system-admin.sa-edit-payment-method', compact('paymentMethod', 'types', 'currencies'));

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error loading edit payment method form: ' . $e->getMessage());
            return redirect()->route('system-admin.payment-methods')
                ->with('error', 'Unable to load edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update payment method
     */
    public function updatePaymentMethod(Request $request, $id)
    {
        try {
            $paymentMethod = \App\Models\PaymentMethod::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:payment_methods,slug,' . $id,
                'type' => 'required|string|in:mobile,bank,cash,check',
                'provider' => 'nullable|string|max:255',
                'account_number' => 'required|string|max:255',
                'account_title' => 'required|string|max:255',
                'branch_name' => 'required|string|max:255',
                'routing_number' => 'nullable|string|max:255',
                'configuration' => 'nullable|array',
                'is_active' => 'boolean',
                'is_popular' => 'boolean',
                'requires_verification' => 'boolean',
                'sort_order' => 'nullable|integer|min:0',
            ]);

            $paymentMethod->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'type' => $request->type,
                'provider' => $request->provider,
                'account_number' => $request->account_number,
                'account_title' => $request->account_title,
                'branch_name' => $request->branch_name,
                'routing_number' => $request->routing_number,
                'configuration' => $request->configuration,
                'is_active' => $request->has('is_active'),
                'is_popular' => $request->has('is_popular'),
                'requires_verification' => $request->has('requires_verification'),
                'sort_order' => $request->sort_order ?: 0,
            ]);

            \Log::info("SystemAdminController: Updated payment method: {$paymentMethod->name}");

            return redirect()->route('system-admin.payment-methods')
                ->with('success', 'Payment method updated successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error updating payment method: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Unable to update payment method: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete payment method
     */
    public function deletePaymentMethod($id)
    {
        try {
            $paymentMethod = \App\Models\PaymentMethod::findOrFail($id);
            $paymentMethodName = $paymentMethod->name;
            $paymentMethod->delete();

            \Log::info("SystemAdminController: Deleted payment method: {$paymentMethodName}");

            return redirect()->route('system-admin.payment-methods')
                ->with('success', 'Payment method deleted successfully');

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error deleting payment method: ' . $e->getMessage());
            return redirect()->route('system-admin.payment-methods')
                ->with('error', 'Unable to delete payment method: ' . $e->getMessage());
        }
    }

    /**
     * Toggle payment method status
     */
    public function togglePaymentMethodStatus($id)
    {
        try {
            $paymentMethod = \App\Models\PaymentMethod::findOrFail($id);
            $paymentMethod->update(['is_active' => !$paymentMethod->is_active]);

            $status = $paymentMethod->is_active ? 'activated' : 'deactivated';
            \Log::info("SystemAdminController: Payment method {$status}: {$paymentMethod->name}");

            return redirect()->route('system-admin.payment-methods')
                ->with('success', "Payment method {$status} successfully");

        } catch (\Exception $e) {
            \Log::error('SystemAdminController: Error toggling payment method status: ' . $e->getMessage());
            return redirect()->route('system-admin.payment-methods')
                ->with('error', 'Unable to update payment method status: ' . $e->getMessage());
        }
    }
}
