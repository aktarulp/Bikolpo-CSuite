<?php

namespace App\DTO\Exam;

use Illuminate\Foundation\Http\FormRequest;

class AssignQuestionsDTO extends FormRequest
{
    public function rules(): array
    {
        return [
            'questions' => 'required|array',
            'questions.*.question_id' => 'required|exists:questions,id',
            'questions.*.marks' => 'nullable|integer|min:1',
        ];
    }

    public function validatedDTO(): array
    {
        return $this->validated();
    }

    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'partner';
    }
}
