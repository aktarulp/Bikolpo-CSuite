<?php

namespace App\DTO\Exam;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManualResultDTO extends FormRequest
{
    public function rules(): array
    {
        return [
            'answers' => 'required|array',
            'answers.*' => 'nullable|string',
            'started_at' => 'nullable|date',
            'completed_at' => 'nullable|date|after_or_equal:started_at',
        ];
    }

    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'partner';
    }
}
