<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExamManagementService
{
    /**
     * Get a paginated list of exams for a partner.
     *
     * @param int $partnerId
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getExamsForPartner(int $partnerId, array $filters, int $perPage = 15)
    {
        $query = Exam::with(['partner', 'examQuestion'])
            ->withCount('questions as assigned_questions_count')
            ->withCount('assignedStudents as assigned_students_count')
            ->where('partner_id', $partnerId);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['q'])) {
            $q = $filters['q'];
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    /**
     * Get counts for different exam statuses for a partner.
     *
     * @param int $partnerId
     * @return array
     */
    public function getExamCounts(int $partnerId): array
    {
        return [
            'all' => Exam::where('partner_id', $partnerId)->count(),
            'published' => Exam::where('partner_id', $partnerId)->where('status', 'published')->count(),
            'draft' => Exam::where('partner_id', $partnerId)->where('status', 'draft')->count(),
            'upcoming' => Exam::where('partner_id', $partnerId)->where('status', 'published')->where('start_time', '>', Carbon::now())->count(),
            'completed' => Exam::where('partner_id', $partnerId)->where('status', 'published')->where('end_time', '<', Carbon::now())->count(),
        ];
    }

    /**
     * Create a new exam.
     *
     * @param array $data
     * @param int $partnerId
     * @param bool $isDraft
     * @return Exam
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createExam(array $data, int $partnerId, bool $isDraft = false): Exam
    {
        $data['partner_id'] = $partnerId;
        $data['created_by'] = auth()->id();
        $data['status'] = $isDraft ? 'draft' : ($data['status'] ?? 'draft'); // Default to draft if not specified

        // Handle boolean fields and negative marking
        $data['allow_retake'] = $data['allow_retake'] ?? false;
        $data['show_results_immediately'] = $data['show_results_immediately'] ?? true;
        $data['has_negative_marking'] = $data['has_negative_marking'] ?? false;

        if ($data['has_negative_marking']) {
            $data['negative_marks_per_question'] = $data['negative_marks_per_question'] ?? 0.25;
        } else {
            $data['negative_marks_per_question'] = 0;
        }
        
        // Ensure flag is set
        $data['flag'] = 'active';

        return Exam::create($data);
    }

    /**
     * Update an existing exam.
     *
     * @param Exam $exam
     * @param array $data
     * @param bool $isDraft
     * @return Exam
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateExam(Exam $exam, array $data, bool $isDraft = false): Exam
    {
        // Handle boolean fields and negative marking
        $data['allow_retake'] = $data['allow_retake'] ?? false;
        $data['show_results_immediately'] = $data['show_results_immediately'] ?? true;
        $data['has_negative_marking'] = $data['has_negative_marking'] ?? false;

        if ($data['has_negative_marking']) {
            $data['negative_marks_per_question'] = $data['negative_marks_per_question'] ?? 0.25;
        } else {
            $data['negative_marks_per_question'] = 0;
        }

        // Update status if not a draft save
        if (!$isDraft) {
            $data['status'] = $data['status'] ?? 'published';
        } else {
            $data['status'] = 'draft';
        }

        $exam->update($data);
        return $exam;
    }

    /**
     * Publish an exam.
     *
     * @param Exam $exam
     * @return Exam
     */
    public function publishExam(Exam $exam): Exam
    {
        $exam->update(['status' => 'published']);
        return $exam;
    }

    /**
     * Unpublish an exam.
     *
     * @param Exam $exam
     * @return Exam
     */
    public function unpublishExam(Exam $exam): Exam
    {
        $exam->update(['status' => 'draft']);
        return $exam;
    }

    /**
     * Delete an exam.
     *
     * @param Exam $exam
     * @return bool|null
     */
    public function deleteExam(Exam $exam): ?bool
    {
        return $exam->delete();
    }

    /**
     * Get exam results for a given exam, including absent students.
     *
     * @param Exam $exam
     * @return \Illuminate\Support\Collection
     */
    public function getExamResults(Exam $exam)
    {
        $exam->load('assignedStudents.course', 'assignedStudents.batch');
        $assignedStudents = $exam->assignedStudents;

        $examResults = ExamResult::where('exam_id', $exam->id)
            ->with('student')
            ->get()
            ->keyBy('student_id');

        $results = collect();

        foreach ($assignedStudents as $student) {
            $result = $examResults->get($student->id);

            if ($result) {
                $results->push($result);
            } else {
                $mockResult = new ExamResult([
                    'id' => 'absent_' . $student->id,
                    'student_id' => $student->id,
                    'exam_id' => $exam->id,
                    'started_at' => null,
                    'completed_at' => null,
                    'total_questions' => $exam->total_questions,
                    'correct_answers' => 0,
                    'wrong_answers' => 0,
                    'unanswered' => $exam->total_questions,
                    'score' => 0,
                    'percentage' => 0,
                    'status' => 'absent',
                    'answers' => [],
                ]);
                $mockResult->setRelation('student', $student);
                $results->push($mockResult);
            }
        }

        return $results->sortBy('student.name');
    }

    /**
     * Update a manual exam result.
     *
     * @param Exam $exam
     * @param ExamResult $result
     * @param array $answers
     * @param string|null $startedAt
     * @param string|null $completedAt
     * @return ExamResult
     * @throws \Exception
     */
    public function updateManualResult(Exam $exam, ExamResult $result, array $answers, ?string $startedAt, ?string $completedAt): ExamResult
    {
        if ($result->exam_id !== $exam->id) {
            throw new \Exception('Result not found for this exam.');
        }

        if ($result->result_type !== 'manual') {
            throw new \Exception('Only manual results can be updated.');
        }

        $questions = $exam->questions()->with('questionType')->get()->keyBy('id');

        $correctAnswers = 0;
        $wrongAnswers = 0;
        $unanswered = 0;
        $totalScore = 0;
        $detailedAnswers = [];

        foreach ($questions as $questionId => $question) {
            $answer = $answers[$questionId] ?? null;
            $isCorrect = false;
            $marksObtained = 0;

            if ($question->question_type === 'mcq') {
                if ($answer !== null && strtolower($answer) === strtolower($question->correct_answer)) {
                    $isCorrect = true;
                    $correctAnswers++;
                    $marksObtained = $question->pivot->marks;
                } elseif ($answer !== null) {
                    $wrongAnswers++;
                    $marksObtained = -$exam->negative_marks_per_question; // Apply negative marking
                } else {
                    $unanswered++;
                }
            } else { // Descriptive questions
                if ($answer !== null && $answer !== '') {
                    // Placeholder for descriptive question scoring logic
                    // This should be replaced with actual scoring based on keywords, word count, etc.
                    // For now, let's assume if answered, it's partially correct for demonstration
                    $marksObtained = $question->pivot->marks / 2; // Example: half marks for answered descriptive
                    $correctAnswers++; // Count as partially correct
                } else {
                    $unanswered++;
                }
            }
            $totalScore += $marksObtained;

            $detailedAnswers[$questionId] = [
                'question_id' => $questionId,
                'question_text' => $question->question_text,
                'provided_answer' => $answer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
                'marks_obtained' => $marksObtained,
                'question_type' => $question->question_type,
            ];
        }

        $percentage = $exam->total_questions > 0 ? ($totalScore / $exam->total_questions) * 100 : 0;

        $updateData = [
            'started_at' => $startedAt ? Carbon::parse($startedAt) : null,
            'completed_at' => $completedAt ? Carbon::parse($completedAt) : null,
            'total_questions' => $questions->count(),
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'unanswered' => $unanswered,
            'score' => $totalScore,
            'percentage' => round($percentage, 2),
            'answers' => $detailedAnswers,
        ];
        
        $result->update($updateData);

        // Delete existing question statistics and create new ones
        $result->questionStats()->delete();
        // Re-create question statistics records (same as quiz submission)
        foreach ($questions as $question) {
            $questionAnswer = $answers[$question->id] ?? null;
            $isAnswered = !empty($questionAnswer);
            $isCorrect = false;
            $isSkipped = false;
            $answerMetadata = null;

            if ($questionAnswer === null || $questionAnswer === '') {
                $isSkipped = true;
            } else {
                if ($question->question_type === 'mcq') {
                    $isCorrect = strtolower($questionAnswer) === strtolower($question->correct_answer);
                } else {
                    // For descriptive questions, give partial marks based on word count
                    // This is a simplified example; actual logic would be more complex
                    $isCorrect = true; // Assume partially correct if answered
                }
            }
            
            $result->questionStats()->create([
                'question_id' => $question->id,
                'is_correct' => $isCorrect,
                'is_answered' => $isAnswered,
                'is_skipped' => $isSkipped,
                'answer_given' => $questionAnswer,
                'correct_answer' => $question->correct_answer,
                'answer_metadata' => $answerMetadata,
            ]);
        }

        return $result->fresh();
    }

    /**
     * Assign students to an exam.
     *
     * @param Exam $exam
     * @param array $studentIds
     * @param string $accessCode
     * @param \Carbon\Carbon $validUntil
     * @return void
     */
    public function assignStudents(Exam $exam, array $studentIds, string $accessCode, Carbon $validUntil)
    {
        DB::transaction(function () use ($exam, $studentIds, $accessCode, $validUntil) {
            foreach ($studentIds as $studentId) {
                $exam->accessCodes()->create([
                    'student_id' => $studentId,
                    'access_code' => $accessCode,
                    'valid_until' => $validUntil,
                    'created_by' => auth()->id(),
                ]);
            }
        });
    }

    /**
     * Revoke access for students from an exam.
     *
     * @param Exam $exam
     * @param array $studentIds
     * @return int
     */
    public function revokeStudentsAccess(Exam $exam, array $studentIds): int
    {
        return $exam->accessCodes()->whereIn('student_id', $studentIds)->delete();
    }
}
