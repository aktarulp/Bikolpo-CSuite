<?php

namespace App\DTO\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class CreateExamDTO extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'exam_type' => 'required|in:mcq,descriptive,both',
            'total_questions' => 'nullable|integer|min:1',
            'passing_marks' => 'required|integer|min:0',
            'allow_retake' => 'boolean',
            'show_results_immediately' => 'boolean',
            'has_negative_marking' => 'boolean',
            'negative_marks_per_question' => 'required_if:has_negative_marking,1|nullable|numeric|min:0|max:5',
            'question_header' => 'nullable|string',
            'question_language' => 'required|in:english,bangla',
            'startDateTime' => 'nullable|date',
            'endDateTime' => 'nullable|date|after_or_equal:startDateTime',
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
        $validated['allow_retake'] = $validated['allow_retake'] ?? false;
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
        // Only authenticated partners can create exams
        return auth()->check() && auth()->user()->role === 'partner';
    }
}
