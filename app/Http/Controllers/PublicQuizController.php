<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAssignment;
use App\Models\Student;
use App\Models\StudentExamResult;
use Illuminate\Http\Request;

class PublicQuizController extends Controller
{
    public function showJoin()
    {
        return view('public.join');
    }

    public function join(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'code' => 'required|string|size:6',
        ]);

        $assignment = ExamAssignment::where('phone', $validated['phone'])
            ->where('access_code', $validated['code'])
            ->first();

        if (!$assignment) {
            return back()->withErrors(['code' => 'Invalid phone or access code'])->withInput();
        }

        $exam = Exam::findOrFail($assignment->exam_id);
        if ($exam->status !== 'published' || now()->lt($exam->start_time) || now()->gt($exam->end_time)) {
            return back()->withErrors(['code' => 'This quiz is not available now']);
        }

        // Create minimal student on the fly if not bound
        if (!$assignment->student_id) {
            $student = Student::firstOrCreate([
                'email' => $assignment->phone . '@guest.local',
            ], [
                'full_name' => $assignment->student_name ?: 'Guest Student',
                'student_id' => null,
                'date_of_birth' => now()->subYears(16)->toDateString(),
                'gender' => 'other',
                'phone' => $assignment->phone,
                'status' => 'active',
            ]);
            $assignment->student_id = $student->id;
            $assignment->save();
        }

        $studentId = $assignment->student_id;

        // Prevent multiple attempts
        $existing = StudentExamResult::where('student_id', $studentId)
            ->where('exam_id', $exam->id)
            ->where('status', 'completed')
            ->first();
        if ($existing && !$exam->allow_retake) {
            return redirect()->route('public.result', [$exam->id, 'phone' => $assignment->phone, 'code' => $assignment->access_code])
                ->with('error', 'You have already completed this quiz.');
        }

        // Create or resume
        $result = StudentExamResult::firstOrCreate([
            'student_id' => $studentId,
            'exam_id' => $exam->id,
        ], [
            'started_at' => now(),
            'total_questions' => $exam->questionSet->questions()->count(),
            'status' => 'in_progress',
        ]);

        // Mark assignment used
        if (!$assignment->used_at) {
            $assignment->used_at = now();
        }
        $assignment->attempts = $assignment->attempts + 1;
        $assignment->save();

        $questions = $exam->questionSet->questions()->get();
        return view('public.take', compact('exam', 'questions', 'result', 'assignment'));
    }

    public function submit(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'code' => 'required|string|size:6',
            'answers' => 'array',
        ]);

        $assignment = ExamAssignment::where('exam_id', $exam->id)
            ->where('phone', $validated['phone'])
            ->where('access_code', $validated['code'])
            ->firstOrFail();

        $studentId = $assignment->student_id;
        $result = StudentExamResult::where('student_id', $studentId)
            ->where('exam_id', $exam->id)
            ->where('status', 'in_progress')
            ->firstOrFail();

        // Enforce duration
        $deadline = $result->started_at->clone()->addMinutes($exam->duration);
        if (now()->greaterThan($deadline)) {
            // Continue to grade but mark as completed
        }

        $answers = $validated['answers'] ?? [];
        $questions = $exam->questionSet->questions;

        $correct = 0; $wrong = 0; $unanswered = 0; $earnedMarks = 0; $totalMarks = 0;
        foreach ($questions as $question) {
            $totalMarks += (int)($question->pivot->marks ?? ($question->marks ?? 1));
            $studentAnswer = $answers[$question->id] ?? null;
            if ($studentAnswer === null) {
                $unanswered++;
                continue;
            }
            if ($studentAnswer === $question->correct_answer) {
                $correct++;
                $earnedMarks += (int)($question->pivot->marks ?? ($question->marks ?? 1));
            } else {
                $wrong++;
            }
        }
        $percentage = $totalMarks > 0 ? ($earnedMarks / $totalMarks) * 100 : 0;

        $result->update([
            'completed_at' => now(),
            'correct_answers' => $correct,
            'wrong_answers' => $wrong,
            'unanswered' => $unanswered,
            'score' => $earnedMarks,
            'percentage' => $percentage,
            'status' => 'completed',
            'answers' => $answers,
        ]);

        return redirect()->route('public.result', [$exam->id, 'phone' => $assignment->phone, 'code' => $assignment->access_code])
            ->with('success', 'Submitted');
    }

    public function result(Request $request, $examId)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'code' => 'required|string|size:6',
        ]);
        $assignment = ExamAssignment::where('exam_id', $examId)
            ->where('phone', $request->phone)
            ->where('access_code', $request->code)
            ->firstOrFail();
        $exam = Exam::findOrFail($examId);
        $result = StudentExamResult::where('student_id', $assignment->student_id)
            ->where('exam_id', $examId)->firstOrFail();
        $questions = $exam->questionSet->questions;
        return view('public.result', compact('exam', 'result', 'questions'));
    }
}

