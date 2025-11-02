<?php

namespace App\DTO\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class UpdateExamDTO extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'exam_number' => 'nullable|string|max:255',
            'course_id' => 'nullable|exists:courses,id',
            'description' => 'nullable|string',
            'exam_type' => 'required|in:online,offline',
            'total_questions' => 'nullable|integer|min:1',
            'passing_marks' => 'required|integer|min:0',
            'allow_review' => 'boolean',
            'show_results_immediately' => 'boolean',
            'has_negative_marking' => 'boolean',
            'negative_marks_per_question' => 'required_if:has_negative_marking,1|nullable|numeric|min:0|max:5',
            'question_header' => 'nullable|string',
            'question_language' => 'required|in:english,bangla',
            'startDateTime' => 'nullable|date',
            'endDateTime' => 'nullable|date|after_or_equal:startDateTime',
            'status' => 'nullable|in:draft,published',
        ];
    }

    public function validatedDTO(): array
    {
        $validated = $this->validated();

        // Convert datetime-local strings to Carbon instances
        if (isset($validated['startDateTime'])) {
            $validated['start_time'] = Carbon::parse($validated['startDateTime']);
            unset($validated['startDateTime']);
        }
        if (isset($validated['endDateTime'])) {
            $validated['end_time'] = Carbon::parse($validated['endDateTime']);
            unset($validated['endDateTime']);
        }

        // Set default values for boolean and negative marking if not present
        $validated['allow_review'] = $validated['allow_review'] ?? false;
        $validated['show_results_immediately'] = $validated['show_results_immediately'] ?? true;
        $validated['has_negative_marking'] = $validated['has_negative_marking'] ?? false;

        if ($validated['has_negative_marking']) {
            $validated['negative_marks_per_question'] = $validated['negative_marks_per_question'] ?? 0.25;
        } else {
            $validated['negative_marks_per_question'] = 0;
        }

        return $validated;
    }

    public function authorize(): bool
    {
        return true;
    }
}