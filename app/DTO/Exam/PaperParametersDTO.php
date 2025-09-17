<?php

namespace App\DTO\Exam;

use Illuminate\Foundation\Http\FormRequest;

class PaperParametersDTO extends FormRequest
{
    public function rules(): array
    {
        return [
            'paper_size' => 'nullable|in:A4,Letter,Legal,A3',
            'orientation' => 'nullable|in:portrait,landscape',
            'paper_columns' => 'nullable|in:1,2,3,4',
            'mcq_columns' => 'nullable|in:1,2,3,4',
            'adjust_to_percentage' => 'nullable|integer|min:10|max:500',
            'header_span' => 'nullable|in:1,2,3,4,full',
            'header_push' => 'nullable|in:1st_col,2nd_col,3rd_col,4th_col',
            'font_family' => 'nullable|string|max:100',
            'font_size' => 'nullable|integer|min:8|max:24',
            'line_spacing' => 'nullable|numeric|min:0.5|max:3.0',
            'margin_top' => 'nullable|numeric|min:0|max:200',
            'margin_right' => 'nullable|numeric|min:0|max:200',
            'margin_bottom' => 'nullable|numeric|min:0|max:200',
            'margin_left' => 'nullable|numeric|min:0|max:200',
            'include_header' => 'nullable|boolean',
            'mark_answer' => 'nullable|boolean',
            'show_page_number' => 'nullable|boolean',
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
