<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Question;
use App\Models\ExamAccessCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Resolve the Student record for this user
        $student = Student::with(['course', 'batch'])
            ->where('id', $user->student_id)
            ->first();

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

        $studentId = $student->id;
        $courseId = $student->course_id;
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

        // Basic stats
        $totalExamsTaken = ExamResult::where('student_id', $studentId)->where('status', 'completed')->count();
        $averageScore = round((float) (ExamResult::where('student_id', $studentId)->whereNotNull('percentage')->avg('percentage') ?? 0), 1);
        $passedExams = ExamResult::where('student_id', $studentId)->where('status', 'completed')->where('percentage', '>=', 50)->count();

        // Batchmate totals (how many exams faced collectively)
        $batchmateExamFaced = 0;
        if ($batchId) {
            $batchStudentIds = Student::where('batch_id', $batchId)->pluck('id');
            $batchmateExamFaced = ExamResult::whereIn('student_id', $batchStudentIds)->where('status', 'completed')->count();
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

        // Syllabus completion: based on questions in course vs attempted by student
        [$syllabusCompletion, $subjectProgress] = $this->computeSyllabusProgress($student);

        $stats = [
            'total_exams_taken' => $totalExamsTaken,
            'completed_exams' => $totalExamsTaken,
            'average_score' => $averageScore,
            'passed_exams' => $passedExams,
            'upcoming_exams' => $upcomingExams->count(),
            'batchmate_exam_faced' => $batchmateExamFaced,
            'course_rank' => $courseRank ? ($courseRank . ' / ' . $coursePopulation) : null,
            'batch_rank' => $batchRank ? ($batchRank . ' / ' . $batchPopulation) : null,
            'syllabus_completion' => $syllabusCompletion,
        ];

        return view('student.dashboard.student-dashboard', [
            'user' => $user,
            'student' => $student,
            'my_course' => $student->course,
            'my_batch' => $student->batch,
            'available_exams' => $upcomingExams, // Treat upcoming as available to start soon
            'upcoming_exams' => $upcomingExams,
            'recent_results' => $recentResults,
            'stats' => $stats,
            'subjectProgress' => $subjectProgress,
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
     * Compute syllabus progress using course subjects and questions attempted by the student.
     */
    private function computeSyllabusProgress(Student $student): array
    {
        $courseId = $student->course_id;
        if (!$courseId) { return [0, collect()]; }

        // Total course questions
        $totalCourseQuestions = Question::where('course_id', $courseId)->count();

        // Attempted course questions by this student (join for efficiency)
        $attemptedCourseQuestions = \DB::table('question_statistics as qs')
            ->join('questions as q', 'q.id', '=', 'qs.question_id')
            ->where('qs.student_id', $student->id)
            ->where('q.course_id', $courseId)
            ->distinct('qs.question_id')
            ->count('qs.question_id');

        $completionPercent = $totalCourseQuestions > 0
            ? round(($attemptedCourseQuestions / $totalCourseQuestions) * 100)
            : 0;

        // Per-subject progress bars
        $subjects = Subject::where('course_id', $courseId)->get();
        $subjectProgress = $subjects->map(function ($subject) use ($student) {
            $totalQ = Question::where('subject_id', $subject->id)->count();
            $attemptedQ = \DB::table('question_statistics as qs')
                ->join('questions as q', 'q.id', '=', 'qs.question_id')
                ->where('qs.student_id', $student->id)
                ->where('q.subject_id', $subject->id)
                ->distinct('qs.question_id')
                ->count('qs.question_id');
            $pct = $totalQ > 0 ? round(($attemptedQ / $totalQ) * 100) : 0;
            return [
                'subject' => $subject,
                'total' => $totalQ,
                'attempted' => $attemptedQ,
                'percent' => $pct,
            ];
        });

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
