<?php
public function showDetails(Exam $exam, ExamResult $result)
{
    $resultData = [
        'id' => $result->id,
        'student_name' => $result->student->name,
        'student_id' => $result->student->student_id,
        'exam_title' => $exam->title,
        'started_at' => $result->started_at->format('M d, Y H:i:s'),
        'completed_at' => $result->completed_at?->format('M d, Y H:i:s'),
        'time_taken' => $result->time_taken,
        'total_questions' => $result->total_questions,
        'correct_answers' => $result->correct_answers,
        'wrong_answers' => $result->wrong_answers,
        'unanswered' => $result->unanswered,
        'score' => number_format($result->score, 2),
        'percentage' => number_format($result->percentage, 2),
        'status' => $result->status,
        'passing_marks' => $exam->passing_marks,
        'is_passed' => $result->is_passed
    ];

    $questions = $result->questions->map(function ($q) {
        return [
            'id' => $q->id,
            'question_text' => $q->question_text,
            'question_type' => $q->question_type,
            'marks' => $q->marks,
            'correct_answer' => $q->correct_answer,
            'submitted_answer' => $q->pivot->submitted_answer,
            'is_correct' => $q->pivot->is_correct,
            'is_skipped' => $q->pivot->is_skipped,
            'score' => $q->pivot->score,
            'options' => $q->options,
            'time_taken' => $q->pivot->time_taken,
            'topic' => $q->topic?->name,
            'subject' => $q->subject->name
        ];
    });

    return view('partner.exams.details-results', compact('exam', 'resultData', 'questions'));
}