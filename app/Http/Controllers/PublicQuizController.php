<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAccessCode;
use App\Models\Student;
use App\Models\StudentExamResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PublicQuizController extends Controller
{
    /**
     * Show the public quiz access page
     */
    public function showAccessPage()
    {
        return view('public.quiz.access');
    }

    /**
     * Process quiz access request
     */
    public function processAccess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|regex:/^01[3-9][0-9]{8}$/|max:15',
            'access_code' => 'required|string|size:6',
        ], [
            'phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $accessCode = ExamAccessCode::where('access_code', $request->access_code)
            ->whereHas('student', function ($query) use ($request) {
                $query->where('phone', $request->phone);
            })
            ->with(['exam', 'student'])
            ->first();

        if (!$accessCode || !$accessCode->isValid()) {
            return back()->withErrors(['access' => 'Invalid phone number or access code.'])->withInput();
        }

        // Check if student has already attempted this exam
        $existingResult = StudentExamResult::where('student_id', $accessCode->student_id)
            ->where('exam_id', $accessCode->exam_id)
            ->first();

        if ($existingResult && $existingResult->status === 'completed') {
            return back()->withErrors(['access' => 'You have already completed this exam.'])->withInput();
        }

        // Store access info in session for the quiz
        session([
            'quiz_access' => [
                'access_code_id' => $accessCode->id,
                'student_id' => $accessCode->student_id,
                'exam_id' => $accessCode->exam_id,
                'student_name' => $accessCode->student->full_name,
            ]
        ]);

        return redirect()->route('public.quiz.start', $accessCode->exam_id);
    }

    /**
     * Show the quiz start page
     */
    public function showQuiz(Exam $exam)
    {
        $accessInfo = session('quiz_access');
        
        if (!$accessInfo || $accessInfo['exam_id'] != $exam->id) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Invalid access. Please try again.']);
        }

        // Check if exam is active
        if (!$exam->isActive) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'This exam is not currently active.']);
        }

        $accessCode = ExamAccessCode::find($accessInfo['access_code_id']);
        if (!$accessCode || !$accessCode->isValid()) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Access code is no longer valid.']);
        }

        return view('public.quiz.start', compact('exam', 'accessInfo'));
    }

    /**
     * Start the quiz
     */
    public function startQuiz(Exam $exam)
    {
        $accessInfo = session('quiz_access');
        
        if (!$accessInfo || $accessInfo['exam_id'] != $exam->id) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Invalid access. Please try again.']);
        }

        // Check if already started
        $existingResult = StudentExamResult::where('student_id', $accessInfo['student_id'])
            ->where('exam_id', $exam->id)
            ->first();

        if ($existingResult && $existingResult->status === 'in_progress') {
            // Resume existing quiz
            return redirect()->route('public.quiz.take', $exam->id);
        }

        // Create new exam result
        $result = StudentExamResult::create([
            'student_id' => $accessInfo['student_id'],
            'exam_id' => $exam->id,
            'started_at' => now(),
            'total_questions' => $exam->total_questions ?? 0,
            'status' => 'in_progress',
        ]);

        // Mark access code as used
        $accessCode = ExamAccessCode::find($accessInfo['access_code_id']);
        $accessCode->markAsUsed();

        return redirect()->route('public.quiz.take', $exam->id);
    }

    /**
     * Show the quiz questions
     */
    public function takeQuiz(Exam $exam)
    {
        $accessInfo = session('quiz_access');
        
        if (!$accessInfo || $accessInfo['exam_id'] != $exam->id) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Invalid access. Please try again.']);
        }

        $result = StudentExamResult::where('student_id', $accessInfo['student_id'])
            ->where('exam_id', $exam->id)
            ->where('status', 'in_progress')
            ->first();

        if (!$result) {
            return redirect()->route('public.quiz.start', $exam->id);
        }

        // Check if time has expired
        $startTime = $result->started_at;
        $endTime = $startTime->addMinutes($exam->duration);
        
        if (now()->gt($endTime)) {
            // Auto-submit exam
            $this->autoSubmitExam($result);
            return redirect()->route('public.quiz.result', $exam->id);
        }

        // $questions = $exam->questionSet->questions;
        $questions = collect(); // Empty collection for now
        $remainingTime = $endTime->diffInSeconds(now());

        return view('public.quiz.take', compact('exam', 'questions', 'result', 'remainingTime'));
    }

    /**
     * Submit the quiz
     */
    public function submitQuiz(Request $request, Exam $exam)
    {
        $accessInfo = session('quiz_access');
        
        if (!$accessInfo || $accessInfo['exam_id'] != $exam->id) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Invalid access. Please try again.']);
        }

        $result = StudentExamResult::where('student_id', $accessInfo['student_id'])
            ->where('exam_id', $exam->id)
            ->where('status', 'in_progress')
            ->first();

        if (!$result) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'No active quiz found.']);
        }

        // Process answers and calculate score
        $answers = $request->input('answers', []);
        $score = $this->calculateScore($exam, $answers);

        // Update result
        $result->update([
            'completed_at' => now(),
            'status' => 'completed',
            'answers' => $answers,
            'score' => $score,
            'percentage' => 0, // Placeholder since questionSet is removed
        ]);

        // Clear session
        session()->forget('quiz_access');

        return redirect()->route('public.quiz.result', $exam->id);
    }

    /**
     * Show quiz result
     */
    public function showResult(Exam $exam)
    {
        $accessInfo = session('quiz_access');
        
        if (!$accessInfo || $accessInfo['exam_id'] != $exam->id) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Invalid access. Please try again.']);
        }

        $result = StudentExamResult::where('student_id', $accessInfo['student_id'])
            ->where('exam_id', $exam->id)
            ->where('status', 'completed')
            ->first();

        if (!$result) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'No completed quiz found.']);
        }

        return view('public.quiz.result', compact('exam', 'result'));
    }

    /**
     * Calculate quiz score
     */
    private function calculateScore(Exam $exam, array $answers)
    {
        $score = 0;
        // $questions = $exam->questionSet->questions;
        $questions = collect(); // Empty collection for now

        foreach ($questions as $question) {
            $questionId = $question->id;
            $studentAnswer = $answers[$questionId] ?? null;

            if ($studentAnswer) {
                if ($question->question_type === 'mcq') {
                    if ($studentAnswer === $question->correct_answer) {
                        $score += $question->pivot->marks ?? 1;
                    }
                } else {
                    // For descriptive questions, give partial marks based on word count
                    $wordCount = str_word_count($studentAnswer);
                    $minWords = $question->min_words ?? 10;
                    $maxWords = $question->max_words ?? 100;
                    
                    if ($wordCount >= $minWords) {
                        $score += ($question->pivot->marks ?? 1) * min(1, $wordCount / $maxWords);
                    }
                }
            }
        }

        return $score;
    }

    /**
     * Auto-submit exam when time expires
     */
    private function autoSubmitExam(StudentExamResult $result)
    {
        $result->update([
            'completed_at' => now(),
            'status' => 'abandoned',
            'score' => 0,
            'percentage' => 0,
        ]);
    }
}
