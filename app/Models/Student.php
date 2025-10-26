<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne; // Add this import

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
        'father_name',
        'father_phone',
        'mother_name',
        'mother_phone',
        'guardian',
        'guardian_name',
        'guardian_phone',
        'blood_group',
        'religion',
        'status',
        'enable_login',
        'created_by',
        'default_role',
    ];

    protected $casts = [
        'enroll_date' => 'date',
        'date_of_birth' => 'date',
        'status' => 'string',
        'enable_login' => 'string',
    ];

    /**
     * Validation rules for student creation/update
     */
    public static function getValidationRules($studentId = null)
    {
        $partnerId = request('partner_id');
        
        $rules = [
            'full_name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'father_phone' => 'nullable|string|max:20',
            'mother_phone' => 'nullable|string|max:20',
            'guardian_phone' => 'nullable|string|max:20',
            'partner_id' => 'required|exists:partners,id',
        ];

        // Add unique constraints that are scoped to partner_id
        if ($studentId) {
            // For updates, exclude current student from uniqueness check
            $rules['student_id'] .= '|unique:students,student_id,' . $studentId . ',id,partner_id,' . $partnerId;
            $rules['email'] .= '|unique:students,email,' . $studentId . ',id,partner_id,' . $partnerId;
            $rules['phone'] .= '|unique:students,phone,' . $studentId . ',id,partner_id,' . $partnerId;
            $rules['father_phone'] .= '|unique:students,father_phone,' . $studentId . ',id,partner_id,' . $partnerId;
            $rules['mother_phone'] .= '|unique:students,mother_phone,' . $studentId . ',id,partner_id,' . $partnerId;
            $rules['guardian_phone'] .= '|unique:students,guardian_phone,' . $studentId . ',id,partner_id,' . $partnerId;
        } else {
            // For creation, check uniqueness within partner
            $rules['student_id'] .= '|unique:students,student_id,NULL,id,partner_id,' . $partnerId;
            $rules['email'] .= '|unique:students,email,NULL,id,partner_id,' . $partnerId;
            $rules['phone'] .= '|unique:students,phone,NULL,id,partner_id,' . $partnerId;
            $rules['father_phone'] .= '|unique:students,father_phone,NULL,id,partner_id,' . $partnerId;
            $rules['mother_phone'] .= '|unique:students,mother_phone,NULL,id,partner_id,' . $partnerId;
            $rules['guardian_phone'] .= '|unique:students,guardian_phone,NULL,id,partner_id,' . $partnerId;
        }

        return $rules;
    }

    /**
     * Check if login is enabled for this student
     */
    public function isLoginEnabled()
    {
        return $this->enable_login === 'y';
    }

    /**
     * Enable login for this student
     */
    public function enableLogin()
    {
        $this->update(['enable_login' => 'y']);
    }

    /**
     * Disable login for this student
     */
    public function disableLogin()
    {
        $this->update(['enable_login' => 'n']);
    }

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
        return $this->hasOne(EnhancedUser::class, 'student_id', 'id');
    }

    /**
     * Get the partner associated with the student.
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Get the course associated with the student (Legacy - for backward compatibility).
     * @deprecated Use enrollments() or courses() instead
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get all enrollments for this student.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get all courses the student is enrolled in (Many-to-Many).
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_batch_enrollments')
            ->withPivot([
                'id',
                'batch_id',
                'partner_id',
                'enrolled_at',
                'status',
                'completion_date',
                'final_grade',
                'grade_letter',
                'remarks',
                'transferred_to_course_id',
                'transferred_at',
                'enrolled_by',
                'updated_by',
                'created_at',
                'updated_at'
            ])
            ->withTimestamps();
    }

    /**
     * Get active enrollments for this student.
     */
    public function activeEnrollments()
    {
        return $this->hasMany(Enrollment::class)
            ->where('status', Enrollment::STATUS_ACTIVE);
    }

    /**
     * Get completed enrollments for this student.
     */
    public function completedEnrollments()
    {
        return $this->hasMany(Enrollment::class)
            ->where('status', Enrollment::STATUS_COMPLETED);
    }

    /**
     * Get active courses for this student.
     */
    public function activeCourses()
    {
        return $this->belongsToMany(Course::class, 'course_batch_enrollments')
            ->wherePivot('status', Enrollment::STATUS_ACTIVE)
            ->withPivot([
                'batch_id',
                'enrolled_at',
                'status'
            ])
            ->withTimestamps();
    }

    /**
     * Check if student is currently enrolled in a specific course.
     */
    public function isEnrolledIn($courseId)
    {
        return $this->enrollments()
            ->where('course_id', $courseId)
            ->where('status', Enrollment::STATUS_ACTIVE)
            ->exists();
    }

    /**
     * Enroll student in a course.
     */
    public function enrollInCourse($courseId, $batchId = null, $enrolledAt = null, $enrolledBy = null)
    {
        // Check if already enrolled
        if ($this->isEnrolledIn($courseId)) {
            throw new \Exception('Student is already enrolled in this course.');
        }

        return Enrollment::create([
            'student_id' => $this->id,
            'course_id' => $courseId,
            'batch_id' => $batchId ?? $this->batch_id,
            'partner_id' => $this->partner_id,
            'enrolled_at' => $enrolledAt ?? now(),
            'status' => Enrollment::STATUS_ACTIVE,
            'enrolled_by' => $enrolledBy ?? auth()->id(),
        ]);
    }

    /**
     * Get enrollment history for this student.
     */
    public function getEnrollmentHistory()
    {
        return $this->enrollments()
            ->with(['course', 'batch', 'enrolledBy'])
            ->orderBy('enrolled_at', 'desc')
            ->get();
    }

    /**
     * Get the batch associated with the student.
     */
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    /**
     * Get the user who created this student.
     */
    public function creator()
    {
        return $this->belongsTo(EnhancedUser::class, 'created_by');
    }

    /**
     * Get the default role for this student.
     */
    public function defaultRole()
    {
        return $this->belongsTo(EnhancedRole::class, 'default_role', 'name');
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
        $endDate = $this->course->end_date ?? now()->addYear(); // Default to one year from now if no end date

        // Ensure both dates are valid before calling between()
        if (!$startDate || !$endDate) {
            return false;
        }

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

    /**
     * Get the progress records for this student.
     */
    public function topicProgress()
    {
        return $this->hasMany(ProgressPivot::class);
    }

    /**
     * Update progress for a specific topic
     *
     * @param int $topicId
     * @param array $progressData
     * @return ProgressPivot
     */
    public function updateTopicProgress($topicId, array $progressData)
    {
        return ProgressPivot::updateOrCreate(
            [
                'student_id' => $this->id,
                'topic_id' => $topicId,
            ],
            array_merge($progressData, [
                'last_activity_at' => now(),
            ])
        );
    }

    /**
     * Get progress percentage for a specific topic
     *
     * @param int $topicId
     * @return float
     */
    public function getTopicProgressPercentage($topicId)
    {
        $progress = ProgressPivot::where('student_id', $this->id)
            ->where('topic_id', $topicId)
            ->first();
            
        return $progress ? $progress->completion_percentage : 0;
    }

    /**
     * Get the photo URL for this student.
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            // Extract filename from the stored path
            $filename = basename($this->photo);
            
            // Use direct serving route for better Hostinger compatibility
            return route('student.photo.serve', ['filename' => $filename]);
        }
        return url('images/default-avatar.svg');
    }

    /**
     * Get all topic progress data for this student
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTopicProgress()
    {
        return $this->topicProgress()->with('topic')->get();
    }
}