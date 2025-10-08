<?php

namespace App\DTO\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class AssignStudentsDTO extends FormRequest
{
    public function rules(): array
    {
        return [
            'student_ids' => 'required|array',
            'student_ids.*' => 'required|exists:students,id',
            'access_code' => 'required|string|size:6|unique:exam_access_codes,access_code',
            'valid_until' => 'required|date|after_or_equal:now',
        ];
    }

    public function validatedDTO(): array
    {
        $validated = $this->validated();

        $validated['valid_until'] = Carbon::parse($validated['valid_until']);

        return $validated;
    }

    public function authorize(): bool
    {
        return true;
    }
}
