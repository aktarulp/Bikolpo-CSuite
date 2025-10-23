<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Question;
use App\Models\ExamAccessCode;
use App\Models\ProgressPivot;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentDashboardController extends Controller
{
    /**
     * Get student record for the authenticated user using multiple approaches
     */
    private function getStudentForUser($user)
    {
        // Try to get student record through relationship first
        $student = $user->student;
        
        // If relationship doesn't work, try to find student by student_id
        if (!$student && isset($user->student_id) && $user->student_id) {
            $student = Student::find($user->student_id);
        }
        
        // If still no student, try to find by user_id (for legacy compatibility)
        if (!$student && isset($user->id)) {
            $student = Student::where('user_id', $user->id)->first();
        }
        
        return $student;
    }

    public function index()
    {
        $user = Auth::user();

        // Resolve the Student record for this user using multiple approaches
        $student = $this->getStudentForUser($user);

        // Defensive fallback if no Student record yet
        if (!$student) {
            $empty = collect();
            return view('student.dashboard.student-dashboard', [
                'user' => $user,
                'student' => null,
                'my_course' => null,
                'my_batch' => null,
                'available_exams' => $empty,
                'upcoming_exams' => $empty,
                'recent_results' => $empty,
                'stats' => [
                    'total_exams_taken' => 0,
                    'completed_exams' => 0,
                    'average_score' => 0,
                    'passed_exams' => 0,
                    'upcoming_exams' => 0,
                    'batchmate_exam_faced' => 0,
                    'course_rank' => null,
                    'batch_rank' => null,
                    'syllabus_completion' => 0,
                ],
                'subjectProgress' => $empty,
            ]);
        }

        // Load relationships
        $student = $student->load(['courses', 'batch']);

        $studentId = $student->id;
        
        // Get the primary course (first active enrollment) or fallback to legacy course_id
        $primaryCourse = $student->activeCourses()->first() ?? $student->course;
        $courseId = $primaryCourse ? $primaryCourse->id : $student->course_id;
        $batchId = $student->batch_id;

        // Recent results (completed)
        $recentResults = ExamResult::where('student_id', $studentId)
            ->where('status', 'completed')
            ->with('exam')
            ->orderByDesc('completed_at')
            ->take(5)
            ->get();

        // Upcoming exams via access codes assigned to this student
        $upcomingAccessCodes = ExamAccessCode::valid()
            ->where('student_id', $studentId)
            ->with('exam')
            ->get()
            ->filter(function ($ac) {
                return $ac->exam && $ac->exam->start_time && now()->lt($ac->exam->start_time);
            })
            ->sortBy(fn($ac) => $ac->exam->start_time)
            ->values();

        $upcomingExams = $upcomingAccessCodes->pluck('exam')->take(5);

        // Enhanced stats calculation for the four requested metrics
        // 1. Exams Taken - Count of completed exams
        $totalExamsTaken = ExamResult::where('student_id', $studentId)
            ->where('status', 'completed')
            ->count();

        // 2. Passed Exams - Count of exams with passing score (>= 50%)
        $passedExams = ExamResult::where('student_id', $studentId)
            ->where('status', 'completed')
            ->where('percentage', '>=', 50)
            ->count();

        // 3. Average Score - Average of all completed exam percentages
        $averageScore = 0;
        if ($totalExamsTaken > 0) {
            $averageScore = round((float) (ExamResult::where('student_id', $studentId)
                ->where('status', 'completed')
                ->whereNotNull('percentage')
                ->avg('percentage') ?? 0), 1);
        }

        // 4. Upcoming Exams - Count of future exams assigned to student
        $upcomingExamsCount = $upcomingExams->count();

        // Batchmate totals (how many exams faced collectively)
        $batchmateExamFaced = 0;
        if ($batchId) {
            $batchStudentIds = Student::where('batch_id', $batchId)->pluck('id');
            $batchmateExamFaced = ExamResult::whereIn('student_id', $batchStudentIds)
                ->where('status', 'completed')
                ->count();
        }

        // Ranking calculations (course and batch) based on average percentage over completed exams
        [$courseRank, $coursePopulation] = $this->computeRank(
            baseQuery: ExamResult::query(),
            scopeField: 'course_id',
            scopeId: $courseId,
            studentId: $studentId
        );

        [$batchRank, $batchPopulation] = $this->computeRank(
            baseQuery: ExamResult::query(),
            scopeField: 'batch_id',
            scopeId: $batchId,
            studentId: $studentId
        );

        // Calculate progress using the progress_pivot table
        [$syllabusCompletion, $subjectProgress] = $this->computeProgressFromPivot($student);

        $stats = [
            'total_exams_taken' => $totalExamsTaken,
            'completed_exams' => $totalExamsTaken,
            'average_score' => $averageScore,
            'passed_exams' => $passedExams,
            'upcoming_exams' => $upcomingExamsCount,
            'batchmate_exam_faced' => $batchmateExamFaced,
            'course_rank' => $courseRank ? ($courseRank . ' / ' . $coursePopulation) : null,
            'batch_rank' => $batchRank ? ($batchRank . ' / ' . $batchPopulation) : null,
            'syllabus_completion' => $syllabusCompletion,
        ];

        return view('student.dashboard.student-dashboard', [
            'user' => $user,
            'student' => $student,
            'my_course' => $primaryCourse,
            'my_courses' => $student->activeCourses, // All active courses
            'my_batch' => $student->batch,
            'available_exams' => $upcomingExams, // Treat upcoming as available to start soon
            'upcoming_exams' => $upcomingExams,
            'recent_results' => $recentResults,
            'stats' => $stats,
            'subjectProgress' => $subjectProgress,
        ]);
    }

    /**
     * Display the student's syllabus with subjects and topics
     */
    public function syllabus()
    {
        $user = Auth::user();
        $student = $this->getStudentForUser($user);

        if (!$student) {
            return view('student.syllabus.index', [
                'student' => $student,
                'course' => null,
                'subjects' => collect(),
            ]);
        }

        // Load relationships
        $student = $student->load(['courses', 'batch']);

        // Get the primary course (first active enrollment) or fallback to legacy course_id
        $primaryCourse = $student->activeCourses()->first() ?? $student->course;
        
        if (!$primaryCourse) {
            return view('student.syllabus.index', [
                'student' => $student,
                'course' => null,
                'subjects' => collect(),
            ]);
        }

        // Get all subjects for the student's primary course
        $subjects = Subject::where('course_id', $primaryCourse->id)
            ->with(['topics' => function ($query) {
                $query->orderBy('chapter_number')->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        // Get progress data for all topics
        $progressData = ProgressPivot::where('student_id', $student->id)
            ->get()
            ->keyBy('topic_id');

        return view('student.syllabus.index', [
            'student' => $student,
            'course' => $primaryCourse,
            'subjects' => $subjects,
            'progressData' => $progressData,
        ]);
    }

    /**
     * Display the student's analytics dashboard
     */
    public function analytics()
    {
        $user = Auth::user();
        $student = $this->getStudentForUser($user);

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Student profile not found.');
        }

        // Load relationships
        $student = $student->load(['courses', 'batch']);

        // Get exam results for analytics
        $examResults = ExamResult::where('student_id', $student->id)
            ->with('exam')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate overall statistics
        $totalExams = $examResults->count();
        $passedExams = $examResults->where('percentage', '>=', 50)->count();
        $failedExams = $totalExams - $passedExams;
        $averageScore = $totalExams > 0 ? round($examResults->avg('percentage'), 1) : 0;
        $highestScore = $totalExams > 0 ? $examResults->max('percentage') : 0;
        $lowestScore = $totalExams > 0 ? $examResults->min('percentage') : 0;

        // Subject-wise performance (based on exam questions' subjects)
        $subjectData = [];
        
        foreach ($examResults as $result) {
            $exam = $result->exam;
            if ($exam) {
                // Get all questions for this exam
                $examQuestions = $exam->questions()->with('subject')->get();
                
                // Group by subject
                $questionsBySubject = $examQuestions->groupBy('subject_id');
                
                foreach ($questionsBySubject as $subjectId => $questions) {
                    $subject = $questions->first()->subject;
                    if ($subject) {
                        $subjectName = $subject->name;
                        
                        // Initialize subject array if not exists
                        if (!isset($subjectData[$subjectName])) {
                            $subjectData[$subjectName] = [
                                'subject_id' => $subjectId,
                                'subject' => $subjectName,
                                'results' => [],
                            ];
                        }
                        
                        // Add result percentage
                        $subjectData[$subjectName]['results'][] = $result->percentage;
                    }
                }
            }
        }
        
        // Calculate statistics for each subject
        $subjectPerformance = collect($subjectData)->map(function ($data) {
            $results = collect($data['results']);
            return [
                'subject' => $data['subject'],
                'exams' => $results->count(),
                'average' => $results->count() > 0 ? round($results->avg(), 1) : 0,
                'highest' => $results->count() > 0 ? round($results->max(), 1) : 0,
                'lowest' => $results->count() > 0 ? round($results->min(), 1) : 0,
            ];
        })->sortByDesc('average')->values();

        // Performance trend (last 5 exams)
        $performanceTrend = $examResults
            ->take(5)
            ->reverse()
            ->values()
            ->map(function ($result) {
                return [
                    'exam' => $result->exam->title ?? 'Unknown Exam',
                    'date' => $result->created_at->format('M d'),
                    'score' => round($result->percentage, 1),
                ];
            });

        // Time-based analytics
        $timeStats = [
            'total_time' => $examResults->sum('time_taken'),
            'average_time' => $totalExams > 0 ? round($examResults->avg('time_taken'), 1) : 0,
        ];

        // Question analytics
        $questionStats = [
            'total_questions' => $examResults->sum('total_questions'),
            'correct_answers' => $examResults->sum('correct_answers'),
            'wrong_answers' => $examResults->sum('wrong_answers'),
            'unanswered' => $examResults->sum('unanswered'),
        ];

        // Calculate accuracy percentage
        $accuracy = $questionStats['total_questions'] > 0 
            ? round(($questionStats['correct_answers'] / $questionStats['total_questions']) * 100, 1) 
            : 0;

        return view('student.analytics.index', [
            'student' => $student,
            'examResults' => $examResults,
            'stats' => [
                'totalExams' => $totalExams,
                'passedExams' => $passedExams,
                'failedExams' => $failedExams,
                'averageScore' => $averageScore,
                'highestScore' => $highestScore,
                'lowestScore' => $lowestScore,
                'accuracy' => $accuracy,
                'totalTime' => $timeStats['total_time'],
                'averageTime' => $timeStats['average_time'],
            ],
            'subjectPerformance' => $subjectPerformance,
            'performanceTrend' => $performanceTrend,
            'questionStats' => $questionStats,
        ]);
    }

    /**
     * Update progress for a topic
     */
    public function updateTopicProgress(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'completion_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $user = Auth::user();
        $student = $this->getStudentForUser($user);

        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        $progress = ProgressPivot::updateOrCreate(
            [
                'student_id' => $student->id,
                'topic_id' => $request->topic_id,
            ],
            [
                'completion_percentage' => $request->completion_percentage,
                'last_activity_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully',
            'progress' => $progress,
        ]);
    }

    /**
     * Update progress for multiple topics
     */
    public function updateMultipleTopicProgress(Request $request)
    {
        $request->validate([
            'progress' => 'required|array',
            'progress.*.topic_id' => 'required|exists:topics,id',
            'progress.*.completion_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $user = Auth::user();
        $student = $this->getStudentForUser($user);

        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        $updatedProgress = [];

        foreach ($request->progress as $item) {
            $progress = ProgressPivot::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'topic_id' => $item['topic_id'],
                ],
                [
                    'completion_percentage' => $item['completion_percentage'],
                    'last_activity_at' => now(),
                ]
            );

            $updatedProgress[] = $progress;
        }

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully',
            'progress' => $updatedProgress,
        ]);
    }

    /**
     * Compute rank within a scope (course or batch) based on average percentage over completed exams.
     */
    private function computeRank($baseQuery, string $scopeField, $scopeId, int $studentId): array
    {
        if (!$scopeId) { return [null, 0]; }

        // Build averages per student within scope
        $averages = \DB::table('students as s')
            ->join('exam_results as er', 'er.student_id', '=', 's.id')
            ->select('s.id as student_id', \DB::raw('AVG(er.percentage) as avg_percentage'))
            ->where('s.' . $scopeField, $scopeId)
            ->whereNotNull('er.percentage')
            ->where('er.status', 'completed')
            ->groupBy('s.id')
            ->orderByDesc('avg_percentage')
            ->get();

        if ($averages->isEmpty()) { return [null, 0]; }

        $population = $averages->count();
        $rank = null;
        $position = 1;
        $lastAvg = null;
        $sameRank = 1;

        foreach ($averages as $row) {
            if ($lastAvg !== null) {
                if ((float)$row->avg_percentage < (float)$lastAvg) {
                    $position += $sameRank;
                    $sameRank = 1;
                } else {
                    $sameRank++;
                }
            }
            if ((int)$row->student_id === $studentId) {
                $rank = $position;
                break;
            }
            $lastAvg = $row->avg_percentage;
        }

        return [$rank, $population];
    }

    /**
     * Compute syllabus progress using the progress_pivot table
     */
    private function computeProgressFromPivot(Student $student): array
    {
        // Get the primary course (first active enrollment) or fallback to legacy course_id
        $primaryCourse = $student->activeCourses()->first() ?? $student->course;
        $courseId = $primaryCourse ? $primaryCourse->id : $student->course_id;
        
        if (!$courseId) { return [0, collect()]; }

        // Get all subjects for the course
        $subjects = Subject::where('course_id', $courseId)->get();

        // Get all progress records for this student
        $progressRecords = ProgressPivot::where('student_id', $student->id)
            ->with('topic.subject')
            ->get();

        // Group progress by subject
        $subjectProgressMap = [];
        foreach ($progressRecords as $record) {
            $subjectId = $record->topic->subject_id ?? null;
            if ($subjectId) {
                if (!isset($subjectProgressMap[$subjectId])) {
                    $subjectProgressMap[$subjectId] = [
                        'total_topics' => 0,
                        'completed_percentage_sum' => 0,
                    ];
                }
                $subjectProgressMap[$subjectId]['total_topics']++;
                $subjectProgressMap[$subjectId]['completed_percentage_sum'] += $record->completion_percentage;
            }
        }

        // Calculate subject progress
        $subjectProgress = $subjects->map(function ($subject) use ($subjectProgressMap) {
            $progressData = $subjectProgressMap[$subject->id] ?? null;
            
            if ($progressData && $progressData['total_topics'] > 0) {
                $percent = round($progressData['completed_percentage_sum'] / $progressData['total_topics'], 2);
            } else {
                $percent = 0;
            }
            
            return [
                'subject' => $subject,
                'percent' => $percent,
            ];
        });

        // Calculate overall completion percentage
        $totalSubjects = $subjects->count();
        $completedSubjects = 0;
        $totalCompletion = 0;

        foreach ($subjectProgress as $sp) {
            if ($sp['percent'] > 0) {
                $completedSubjects++;
            }
            $totalCompletion += $sp['percent'];
        }

        $completionPercent = $totalSubjects > 0 ? round($totalCompletion / $totalSubjects, 2) : 0;

        return [$completionPercent, $subjectProgress];
    }

    /**
     * Calculate study streak for student
     */
    private function calculateStudyStreak($studentId)
    {
        $results = ExamResult::where('student_id', $studentId)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($results->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $lastDate = null;

        foreach ($results as $result) {
            $currentDate = $result->created_at->format('Y-m-d');
            
            if ($lastDate === null) {
                $streak = 1;
                $lastDate = $currentDate;
            } elseif ($lastDate === $currentDate) {
                // Same day, continue
                continue;
            } else {
                $daysDiff = now()->parse($lastDate)->diffInDays(now()->parse($currentDate));
                if ($daysDiff === 1) {
                    $streak++;
                    $lastDate = $currentDate;
                } else {
                    break;
                }
            }
        }

        return $streak;
    }

    /**
     * Get subject-wise performance
     */
    private function getSubjectPerformance($studentId)
    {
        // Check if exams table has subject_id column, if not return empty collection
        try {
            return DB::table('exam_results')
                ->join('exams', 'exam_results.exam_id', '=', 'exams.id')
                ->join('subjects', 'exams.subject_id', '=', 'subjects.id')
                ->where('exam_results.student_id', $studentId)
                ->select(
                    'subjects.name',
                    DB::raw('AVG(exam_results.percentage) as average_score'),
                    DB::raw('COUNT(exam_results.id) as total_exams')
                )
                ->groupBy('subjects.id', 'subjects.name')
                ->orderBy('average_score', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    $item->average_score = round($item->average_score, 1);
                    return $item;
                });
        } catch (\Exception $e) {
            // If subject_id column doesn't exist, return empty collection
            \Log::warning('Subject performance query failed, likely missing subject_id column in exams table', [
                'error' => $e->getMessage(),
                'student_id' => $studentId
            ]);
            return collect([]);
        }
    }
}