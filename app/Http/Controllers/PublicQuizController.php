<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAccessCode;
use App\Models\Student;
use App\Models\ExamResult;
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
        // Normalize phone number to handle both formats
        $phone = $this->normalizePhoneNumber($request->phone);
        
        // Log the phone number processing for debugging
        \Log::info('Quiz access attempt', [
            'original_phone' => $request->phone,
            'normalized_phone' => $phone,
            'access_code' => $request->access_code
        ]);
        
        $validator = Validator::make(['phone' => $phone, 'access_code' => $request->access_code], [
            'phone' => 'required|string|regex:/^01[3-9][0-9]{8}$/|max:15',
            'access_code' => 'required|string|size:6',
        ], [
            'phone.regex' => 'Please enter a valid Bangladeshi phone number starting with 01 (e.g., 01712345678). Do not include +880 or country code.',
        ]);

        if ($validator->fails()) {
            \Log::warning('Quiz access validation failed', [
                'phone' => $phone,
                'access_code' => $request->access_code,
                'errors' => $validator->errors()->toArray()
            ]);
            return back()->withErrors($validator)->withInput();
        }

        // Try to find access code with normalized phone number
        $accessCode = ExamAccessCode::where('access_code', $request->access_code)
            ->whereHas('student', function ($query) use ($phone) {
                $query->where('phone', $phone)
                      ->orWhere('phone', '+880 ' . substr($phone, 0, 2) . ' ' . substr($phone, 2))
                      ->orWhere('phone', '+880' . substr($phone, 0, 2) . ' ' . substr($phone, 2));
            })
            ->with(['exam', 'student'])
            ->first();

        // Debug: Log what we're searching for
        \Log::info('Phone number search details', [
            'normalized_phone' => $phone,
            'search_patterns' => [
                $phone,
                '+880 ' . substr($phone, 0, 2) . ' ' . substr($phone, 2),
                '+880' . substr($phone, 0, 2) . ' ' . substr($phone, 2)
            ]
        ]);

        if (!$accessCode || !$accessCode->isValid()) {
            \Log::warning('Quiz access failed - invalid access code or phone', [
                'phone' => $phone,
                'access_code' => $request->access_code,
                'access_code_found' => $accessCode ? true : false,
                'is_valid' => $accessCode ? $accessCode->isValid() : false
            ]);
            
            // Additional debugging: Check what students exist with similar phone numbers
            $similarStudents = \App\Models\Student::where('phone', 'LIKE', '%' . substr($phone, 2) . '%')->get();
            \Log::info('Similar students found', [
                'count' => $similarStudents->count(),
                'students' => $similarStudents->map(function($s) {
                    return ['id' => $s->id, 'phone' => $s->phone, 'name' => $s->full_name];
                })->toArray()
            ]);
            
            // Provide more specific error messages
            if (!$accessCode) {
                return back()->withErrors(['access' => 'Invalid access code. Please check your code and try again.'])->withInput();
            }
            
            if ($accessCode->status === 'used') {
                return back()->withErrors(['access' => 'This access code has already been used. Contact your teacher if you need to retake the exam.'])->withInput();
            }
            
            if ($accessCode->isExpired()) {
                return back()->withErrors(['access' => 'This access code has expired. Please contact your teacher for a new code.'])->withInput();
            }
            
            return back()->withErrors(['access' => 'Access code is not valid. Please check your code and try again.'])->withInput();
        }

        \Log::info('Quiz access successful', [
            'student_id' => $accessCode->student_id,
            'exam_id' => $accessCode->exam_id,
            'student_name' => $accessCode->student->full_name
        ]);

        // Check if student has already attempted this exam
        $existingResult = ExamResult::where('student_id', $accessCode->student_id)
            ->where('exam_id', $accessCode->exam_id)
            ->first();

        if ($existingResult) {
            if ($existingResult->status === 'completed') {
                return back()->withErrors(['access' => 'You have already completed this exam.'])->withInput();
            } elseif ($existingResult->status === 'in_progress') {
                return back()->withErrors(['access' => 'You have an exam in progress. Please complete it first or contact your teacher to reset it.'])->withInput();
            }
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
     * Handle multiple exam access
     */
    public function handleMultipleExams(Request $request)
    {
        // Normalize phone number to handle both formats
        $phone = $this->normalizePhoneNumber($request->phone);
        
        $validator = Validator::make(['phone' => $phone, 'access_code' => $request->access_code], [
            'phone' => 'required|string|regex:/^01[3-9][0-9]{8}$/|max:15',
            'access_code' => 'required|string|size:6',
        ], [
            'phone.regex' => 'Please enter a valid Bangladeshi phone number starting with 01 (e.g., 01712345678). Do not include +880 or country code.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Find the student by phone number (try multiple formats)
        $student = Student::where('phone', $phone)
                         ->orWhere('phone', '+880 ' . substr($phone, 0, 2) . ' ' . substr($phone, 2))
                         ->orWhere('phone', '+880' . substr($phone, 0, 2) . ' ' . substr($phone, 2))
                         ->first();
        
        if (!$student) {
            return back()->withErrors(['access' => 'Phone number not found.'])->withInput();
        }

        // Find all access codes for this student
        $accessCodes = ExamAccessCode::where('student_id', $student->id)
            ->where('access_code', $request->access_code)
            ->with(['exam'])
            ->get();

        if ($accessCodes->isEmpty()) {
            return back()->withErrors(['access' => 'Invalid access code for this phone number.'])->withInput();
        }

        // Check if any access code is valid
        $validAccessCodes = $accessCodes->filter(function ($accessCode) {
            return $accessCode->isValid();
        });

        if ($validAccessCodes->isEmpty()) {
            return back()->withErrors(['access' => 'Access code is no longer valid.'])->withInput();
        }

        // Get all available exams for this student
        $availableExams = $validAccessCodes->map(function ($accessCode) {
            return [
                'access_code_id' => $accessCode->id,
                'exam' => $accessCode->exam,
                'status' => $this->getExamStatus($accessCode->exam),
                'can_take' => $this->canTakeExam($accessCode->exam, $accessCode->student_id),
            ];
        })->filter(function ($examData) {
            return $examData['exam'] && $examData['exam']->flag === 'active';
        });

        if ($availableExams->isEmpty()) {
            return back()->withErrors(['access' => 'No available exams found.'])->withInput();
        }

        // Store student info in session
        session([
            'student_info' => [
                'student_id' => $student->id,
                'student_name' => $student->full_name,
                'phone' => $student->phone,
            ]
        ]);

        // If only one exam, redirect directly to it
        if ($availableExams->count() === 1) {
            $examData = $availableExams->first();
            return $this->redirectToExam($examData);
        }

        // Multiple exams available - show selection dashboard
        return view('public.quiz.select', compact('availableExams'));
    }

    /**
     * Redirect to appropriate exam page
     */
    private function redirectToExam($examData)
    {
        $exam = $examData['exam'];
        $accessCodeId = $examData['access_code_id'];
        
        // Store access info in session for the quiz
        session([
            'quiz_access' => [
                'access_code_id' => $accessCodeId,
                'student_id' => session('student_info.student_id'),
                'exam_id' => $exam->id,
                'student_name' => session('student_info.student_name'),
            ]
        ]);

        if ($exam->isActive) {
            return redirect()->route('public.quiz.start', $exam);
        } elseif ($exam->isScheduled()) {
            return redirect()->route('public.quiz.waiting', $exam);
        } else {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'This exam is not currently available.']);
        }
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

        $accessCode = ExamAccessCode::find($accessInfo['access_code_id']);
        if (!$accessCode || !$accessCode->isValid()) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Access code is no longer valid.']);
        }

        // Check if exam is active
        if (!$exam->isActive) {
            // Check if exam is scheduled for the future
            if ($exam->isScheduled()) {
                // Show waiting room for scheduled exams
                return view('public.quiz.waiting', compact('exam', 'accessInfo'));
            } else {
                // Exam is not available (cancelled, completed, etc.)
                return redirect()->route('public.quiz.access')->withErrors(['access' => 'This exam is not currently available.']);
            }
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
        $existingResult = ExamResult::where('student_id', $accessInfo['student_id'])
            ->where('exam_id', $exam->id)
            ->first();

        if ($existingResult && $existingResult->status === 'in_progress') {
            // Resume existing quiz
            return redirect()->route('public.quiz.take', $exam->id);
        }

        // Create new exam result
        $result = ExamResult::create([
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

        $result = ExamResult::where('student_id', $accessInfo['student_id'])
            ->where('exam_id', $exam->id)
            ->where('status', 'in_progress')
            ->first();

        if (!$result) {
            return redirect()->route('public.quiz.start', $exam->id);
        }

        // Check if time has expired - ONLY based on exam end_time, not duration
        $examEndTime = \Carbon\Carbon::parse($exam->end_time)->setTimezone(config('app.timezone'));
        $currentTime = \Carbon\Carbon::now(config('app.timezone'));
        
        // Debug logging for time calculations
        \Log::info('Quiz Time Debug', [
            'exam_id' => $exam->id,
            'exam_title' => $exam->title,
            'exam_start_time' => $exam->start_time,
            'exam_end_time' => $exam->end_time,
            'exam_duration' => $exam->duration,
            'current_time' => $currentTime->toDateTimeString(),
            'exam_end_time_parsed' => $examEndTime->toDateTimeString(),
            'timezone' => config('app.timezone'),
            'is_exam_ended' => $currentTime->gt($examEndTime),
            'remaining_seconds' => $examEndTime->diffInSeconds($currentTime),
            'remaining_minutes' => $examEndTime->diffInMinutes($currentTime),
            'remaining_hours' => $examEndTime->diffInHours($currentTime),
        ]);
        
        if ($currentTime->gt($examEndTime)) {
            // Auto-submit exam - exam has ended
            \Log::info('Auto-submitting quiz due to exam end time', [
                'exam_id' => $exam->id,
                'exam_end_time' => $examEndTime->toDateTimeString(),
                'current_time' => $currentTime->toDateTimeString(),
            ]);
            $this->autoSubmitExam($result);
            return redirect()->route('public.quiz.result', $exam->id);
        }

        // Load questions from exam_questions table
        $questions = $exam->questions()->orderBy('pivot_order')->get();
        
        // Remaining time is based on exam end time, not quiz duration
        $remainingTime = $currentTime->diffInSeconds($examEndTime);
        
        // Ensure remaining time is not negative
        if ($remainingTime < 0) {
            $remainingTime = 0;
        }
        
        \Log::info('Quiz Timer Set', [
            'exam_id' => $exam->id,
            'remaining_time_seconds' => $remainingTime,
            'remaining_time_minutes' => floor($remainingTime / 60),
            'remaining_time_hours' => floor($remainingTime / 3600),
        ]);

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

        $result = ExamResult::where('student_id', $accessInfo['student_id'])
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
        // Check if results should be shown immediately
        if (!$exam->show_results_immediately) {
            return redirect()->route('public.quiz.access')
                ->with('info', 'Results are not available immediately. Please contact your instructor.');
        }

        $accessInfo = session('quiz_access');
        
        // If no session data, try to find the most recent completed result for this exam
        if (!$accessInfo || $accessInfo['exam_id'] != $exam->id) {
            // Look for the most recent completed result for this exam
            $result = ExamResult::where('exam_id', $exam->id)
                ->where('status', 'completed')
                ->latest('completed_at')
                ->first();

            if (!$result) {
                return redirect()->route('public.quiz.access')->withErrors(['access' => 'No completed quiz found.']);
            }
        } else {
            $result = ExamResult::where('student_id', $accessInfo['student_id'])
                ->where('exam_id', $exam->id)
                ->where('status', 'completed')
                ->first();

            if (!$result) {
                return redirect()->route('public.quiz.access')->withErrors(['access' => 'No completed quiz found.']);
            }
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
     * Auto-submit exam when exam end time is reached
     */
    private function autoSubmitExam(ExamResult $result)
    {
        // Get the exam details for better logging
        $exam = $result->exam;
        
        // Log the auto-submission details
        \Log::info('Auto-submitting quiz due to exam end time', [
            'exam_id' => $exam->id ?? 'unknown',
            'exam_title' => $exam->title ?? 'unknown',
            'student_id' => $result->student_id,
            'started_at' => $result->started_at->toDateTimeString(),
            'exam_end_time' => $exam->end_time ?? 'unknown',
            'auto_submitted_at' => now()->toDateTimeString(),
            'total_time_taken' => $result->started_at->diffInMinutes(now()),
            'reason' => 'exam_end_time_reached'
        ]);
        
        $result->update([
            'completed_at' => now(),
            'status' => 'abandoned',
            'score' => 0,
            'percentage' => 0,
        ]);
    }

    /**
     * Show available exams for a student
     */
    public function showAvailableExams()
    {
        $studentInfo = session('student_info');
        
        if (!$studentInfo) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Please login first.']);
        }

        // Get all access codes for this student
        $accessCodes = ExamAccessCode::where('student_id', $studentInfo['student_id'])
            ->where('status', 'active')
            ->with(['exam'])
            ->get();

        $availableExams = $accessCodes->map(function ($accessCode) {
            return [
                'access_code_id' => $accessCode->id,
                'exam' => $accessCode->exam,
                'status' => $this->getExamStatus($accessCode->exam),
                'can_take' => $this->canTakeExam($accessCode->exam, $accessCode->student_id),
            ];
        })->filter(function ($examData) {
            return $examData['exam'] && $examData['exam']->flag === 'active';
        });

        return view('public.quiz.select', compact('availableExams'));
    }

    /**
     * Get exam status for display
     */
    private function getExamStatus($exam)
    {
        if ($exam->isActive) {
            return 'active';
        } elseif ($exam->isScheduled()) {
            return 'scheduled';
        } elseif ($exam->isCompleted) {
            return 'completed';
        } else {
            return 'unavailable';
        }
    }

    /**
     * Check if student can take the exam
     */
    private function canTakeExam($exam, $studentId)
    {
        // Check if already completed
        $existingResult = ExamResult::where('student_id', $studentId)
            ->where('exam_id', $exam->id)
            ->first();

        if ($existingResult && $existingResult->status === 'completed') {
            return false;
        }

        return true;
    }

    /**
     * Handle exam selection
     */
    public function selectExam(Request $request, $accessCodeId)
    {
        $accessCode = ExamAccessCode::find($accessCodeId);
        
        if (!$accessCode || !$accessCode->isValid()) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Access code is no longer valid.']);
        }

        // Verify student info
        $studentInfo = session('student_info');
        if (!$studentInfo || $studentInfo['student_id'] != $accessCode->student_id) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Invalid access. Please try again.']);
        }

        // Store access info in session for the quiz
        session([
            'quiz_access' => [
                'access_code_id' => $accessCode->id,
                'student_id' => $studentInfo['student_id'],
                'exam_id' => $accessCode->exam_id,
                'student_name' => $studentInfo['student_name'],
            ]
        ]);

        $exam = $accessCode->exam;

        // Redirect based on exam status
        if ($exam->isActive) {
            return redirect()->route('public.quiz.start', $exam);
        } elseif ($exam->isScheduled()) {
            return redirect()->route('public.quiz.waiting', $exam);
        } else {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'This exam is not currently available.']);
        }
    }

    /**
     * Normalize phone number to handle both formats (01XXXXXXXXX and +880 17XXXXXXXX)
     */
    private function normalizePhoneNumber($phone)
    {
        // Remove any leading/trailing whitespace
        $phone = trim($phone);

        // Remove any +880 or 880 prefix if present
        if (strpos($phone, '+880') === 0) {
            $phone = substr($phone, 4);
        } elseif (strpos($phone, '880') === 0) {
            $phone = substr($phone, 3);
        }

        // Ensure it starts with 01
        if (strpos($phone, '01') !== 0) {
            $phone = '01' . $phone;
        }

        return $phone;
    }
}
