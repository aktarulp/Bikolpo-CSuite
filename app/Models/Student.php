<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'partner_id',
        'course_id',
        'batch_id',
        'enroll_date',
        'full_name',
        'student_id',
        'date_of_birth',
        'gender',
        'photo',
        'email',
        'phone',
        'address',
        'city',
        'school_college',
        'class_grade',
        'parent_name',
        'parent_phone',
        'status',
    ];

    protected $casts = [
        'enroll_date' => 'date',
        'date_of_birth' => 'date',
        'status' => 'string',
    ];

    // Relationships
    /**
     * Get all exam results for this student
     */
    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_results');
    }

    /**
     * Get the user account associated with the student.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the partner associated with the student.
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Get the course associated with the student.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the batch associated with the student.
     */
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    /**
     * Get all migrations for this student.
     */
    public function migrations()
    {
        return $this->hasMany(StudentMigration::class);
    }

    /**
     * Get the latest migration for this student.
     */
    public function latestMigration()
    {
        return $this->hasOne(StudentMigration::class)->latestOfMany();
    }

    /**
     * Get the current course duration for this student.
     */
    public function getCurrentCourseDurationAttribute()
    {
        if (!$this->course || !$this->enroll_date) {
            return null;
        }

        $endDate = $this->course->end_date ?? now();
        return $this->enroll_date->diffInDays($endDate);
    }

    /**
     * Check if student is currently enrolled in a course.
     */
    public function isCurrentlyEnrolled()
    {
        if (!$this->course || !$this->enroll_date) {
            return false;
        }

        $now = now();
        $startDate = $this->course->start_date ?? $this->enroll_date;
        $endDate = $this->course->end_date;

        return $now->between($startDate, $endDate);
    }

    /**
     * Get comprehensive analytics for this student
     */
    public function getComprehensiveAnalytics()
    {
        $questionStats = \App\Models\QuestionStat::where('student_id', $this->id);
        
        return [
            'student_id' => $this->id,
            'total_exams_taken' => $this->examResults()->count(),
            'total_questions_attempted' => $questionStats->count(),
            'total_correct_answers' => $questionStats->where('is_correct', true)->count(),
            'total_incorrect_answers' => $questionStats->where('is_correct', false)->where('is_answered', true)->count(),
            'total_skipped_questions' => $questionStats->where('is_skipped', true)->count(),
            'overall_accuracy' => $questionStats->count() > 0 ? round(($questionStats->where('is_correct', true)->count() / $questionStats->count()) * 100, 2) : 0,
            'average_time_per_question' => $questionStats->whereNotNull('time_spent_seconds')->avg('time_spent_seconds'),
            'difficulty_performance' => $this->getDifficultyPerformance(),
            'question_type_performance' => $this->getQuestionTypePerformance(),
            'exam_performance' => $this->getExamPerformance(),
            'improvement_trend' => $this->getImprovementTrend(),
        ];
    }

    /**
     * Get student performance by difficulty level
     */
    public function getDifficultyPerformance()
    {
        $questionStats = \App\Models\QuestionStat::where('student_id', $this->id)->with('question')->get();
        $difficultyStats = [];
        
        foreach ($questionStats as $stat) {
            if ($stat->question) {
                $questionAnalytics = $stat->question->analytics;
                $difficulty = \App\Models\QuestionStat::calculateQuestionDifficulty(
                    \App\Models\QuestionStat::forQuestion($stat->question_id)
                );
                
                if (!isset($difficultyStats[$difficulty])) {
                    $difficultyStats[$difficulty] = [
                        'total' => 0,
                        'correct' => 0,
                        'incorrect' => 0,
                        'skipped' => 0,
                    ];
                }
                
                $difficultyStats[$difficulty]['total']++;
                if ($stat->is_correct) {
                    $difficultyStats[$difficulty]['correct']++;
                } elseif ($stat->is_answered) {
                    $difficultyStats[$difficulty]['incorrect']++;
                } else {
                    $difficultyStats[$difficulty]['skipped']++;
                }
            }
        }
        
        return $difficultyStats;
    }

    /**
     * Get student performance by question type
     */
    public function getQuestionTypePerformance()
    {
        $questionStats = \App\Models\QuestionStat::where('student_id', $this->id);
        $typeStats = [];
        
        foreach ($questionStats->get() as $stat) {
            $type = $stat->question_type;
            
            if (!isset($typeStats[$type])) {
                $typeStats[$type] = [
                    'total' => 0,
                    'correct' => 0,
                    'incorrect' => 0,
                    'skipped' => 0,
                ];
            }
            
            $typeStats[$type]['total']++;
            if ($stat->is_correct) {
                $typeStats[$type]['correct']++;
            } elseif ($stat->is_answered) {
                $typeStats[$type]['incorrect']++;
            } else {
                $typeStats[$type]['skipped']++;
            }
        }
        
        return $typeStats;
    }

    /**
     * Get student performance across all exams
     */
    public function getExamPerformance()
    {
        $examResults = $this->examResults()->with('exam')->orderBy('completed_at', 'desc')->get();
        $performance = [];
        
        foreach ($examResults as $result) {
            $performance[] = [
                'exam_id' => $result->exam_id,
                'exam_title' => $result->exam->title ?? 'Unknown Exam',
                'score' => $result->score,
                'percentage' => $result->percentage,
                'grade' => $result->grade,
                'correct_answers' => $result->correct_answers,
                'wrong_answers' => $result->wrong_answers,
                'unanswered' => $result->unanswered,
                'completed_at' => $result->completed_at,
                'is_passed' => $result->is_passed,
            ];
        }
        
        return $performance;
    }

    /**
     * Get improvement trend over time
     */
    public function getImprovementTrend()
    {
        $examResults = $this->examResults()
            ->whereNotNull('completed_at')
            ->orderBy('completed_at', 'asc')
            ->get(['percentage', 'completed_at']);
        
        if ($examResults->count() < 2) {
            return ['trend' => 'insufficient_data', 'change' => 0];
        }
        
        $firstScore = $examResults->first()->percentage;
        $lastScore = $examResults->last()->percentage;
        $change = $lastScore - $firstScore;
        
        $trend = 'stable';
        if ($change > 5) $trend = 'improving';
        elseif ($change < -5) $trend = 'declining';
        
        return [
            'trend' => $trend,
            'change' => round($change, 2),
            'first_score' => $firstScore,
            'last_score' => $lastScore,
            'total_exams' => $examResults->count(),
        ];
    }

    /**
     * Get questions that student finds difficult
     */
    public function getDifficultQuestions($limit = 10)
    {
        return \App\Models\QuestionStat::where('student_id', $this->id)
            ->where('is_correct', false)
            ->where('is_answered', true)
            ->with('question')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get questions that student finds easy
     */
    public function getEasyQuestions($limit = 10)
    {
        return \App\Models\QuestionStat::where('student_id', $this->id)
            ->where('is_correct', true)
            ->with('question')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
