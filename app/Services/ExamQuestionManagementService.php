<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamQuestion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ExamQuestionManagementService
{
    /**
     * Attach questions to an exam.
     *
     * @param Exam $exam
     * @param array $questionData An array of ['question_id' => id, 'marks' => marks]
     * @return void
     */
    public function attachQuestions(Exam $exam, array $questionData)
    {
        DB::transaction(function () use ($exam, $questionData) {
            // Detach existing questions first if any
            $exam->questions()->detach();

            $pivotData = [];
            foreach ($questionData as $index => $data) {
                $pivotData[$data['question_id']] = [
                    'order' => $index,
                    'marks' => $data['marks'] ?? 1, // Default marks to 1
                ];
            }
            $exam->questions()->attach($pivotData);

            // Update total questions count on the exam
            $exam->update(['total_questions' => count($questionData)]);
        });
    }

    /**
     * Sync questions for an exam.
     *
     * @param Exam $exam
     * @param array $questionData An array of ['question_id' => id, 'marks' => marks]
     * @return void
     */
    public function syncQuestions(Exam $exam, array $questionData)
    {
        $pivotData = [];
        foreach ($questionData as $index => $data) {
            $pivotData[$data['question_id']] = [
                'order' => $index,
                'marks' => $data['marks'] ?? 1,
            ];
        }
        $exam->questions()->sync($pivotData);
        $exam->update(['total_questions' => count($questionData)]);
    }

    /**
     * Get questions for an exam.
     *
     * @param Exam $exam
     * @return \Illuminate\Support\Collection
     */
    public function getExamQuestions(Exam $exam): Collection
    {
        return $exam->questions()->orderBy('pivot_order')->get();
    }

    /**
     * Remove a question from an exam.
     *
     * @param Exam $exam
     * @param int $questionId
     * @return int
     */
    public function removeQuestion(Exam $exam, int $questionId): int
    {
        $detached = $exam->questions()->detach($questionId);
        $exam->update(['total_questions' => $exam->questions()->count()]);
        return $detached;
    }
}
