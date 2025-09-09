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
     * Validate access request
     */
    private function validateAccessRequest(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:11|max:11',
            'access_code' => 'required|string|size:6',
        ]);
    }

    /**
     * Process quiz access request
     */
    public function processAccess(Request $request)
    {
        // Log the incoming request for debugging
        \Log::info('Quiz access request received', [
            'phone' => $request->phone,
            'access_code' => $request->access_code,
            'is_ajax' => $request->ajax(),
            'session_id' => session()->getId(),
            'csrf_token' => $request->header('X-CSRF-TOKEN'),
            'user_agent' => $request->header('User-Agent')
        ]);

        // Handle CSRF token mismatch gracefully
        try {
            // Validate the request
            $this->validateAccessRequest($request);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Quiz access validation failed', [
                'errors' => $e->errors(),
                'phone' => $request->phone,
                'access_code' => $request->access_code
            ]);
            
            if ($request->ajax() && $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                    'message' => 'Validation failed'
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        }

        // Normalize phone number to handle both formats
        $phone = $this->normalizePhoneNumber($request->phone);
        
        // Log the phone number processing for debugging
        \Log::info('Quiz access attempt', [
            'original_phone' => $request->phone,
            'normalized_phone' => $phone,
            'access_code' => $request->access_code,
            'target_exam_id' => 22
        ]);
        
        $validator = Validator::make(['phone' => $phone, 'access_code' => $request->access_code], [
            'phone' => 'required|string|regex:/^01[3-9][0-9]{8}$/|size:11',
            'access_code' => 'required|string|size:6',
        ], [
            'phone.regex' => 'Please enter a valid Bangladeshi phone number starting with 01 (e.g., 01712345678). Do not include +880 or country code.',
            'phone.size' => 'Phone number must be exactly 11 digits.',
        ]);

        if ($validator->fails()) {
            \Log::warning('Quiz access validation failed', [
                'phone' => $phone,
                'access_code' => $request->access_code,
                'errors' => $validator->errors()->toArray()
            ]);
            
            // For debugging, let's see what the actual validation errors are
            if ($request->access_code === '302184') {
                \Log::error('Validation failed for 302184', [
                    'phone' => $phone,
                    'original_phone' => $request->phone,
                    'validation_errors' => $validator->errors()->toArray(),
                    'phone_regex_test' => preg_match('/^01[3-9][0-9]{8}$/', $phone),
                    'access_code_length' => strlen($request->access_code)
                ]);
            }
            
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




        if (!$accessCode) {
            \Log::warning('Quiz access failed - access code not found', [
                'phone' => $phone,
                'access_code' => $request->access_code,
                'normalized_phone' => $phone
            ]);
            
            // Additional debugging: Check what students exist with similar phone numbers
            $similarStudents = \App\Models\Student::where('phone', 'LIKE', '%' . substr($phone, 2) . '%')->get();
            \Log::info('Similar students found', [
                'count' => $similarStudents->count(),
                'students' => $similarStudents->map(function($s) {
                    return ['id' => $s->id, 'phone' => $s->phone, 'name' => $s->full_name];
                })->toArray()
            ]);
            
            // Check if access code exists at all
            $accessCodeExists = \App\Models\ExamAccessCode::where('access_code', $request->access_code)->exists();
            \Log::info('Access code existence check', [
                'access_code' => $request->access_code,
                'exists' => $accessCodeExists
            ]);
            
            if ($request->ajax() && $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid access code. Please check your code and try again.',
                    'errors' => ['access' => 'Invalid access code. Please check your code and try again.']
                ], 422);
            }
            
            return back()->withErrors(['access' => 'Invalid access code. Please check your code and try again.'])->withInput();
        }

        // Check if exam has ended first
        if ($accessCode->isExpired()) {
            \Log::warning('Quiz access failed - exam time expired', [
                'phone' => $phone,
                'access_code' => $request->access_code,
                'exam_end_time' => $accessCode->exam->end_time
            ]);
            return back()->withErrors(['access' => 'Exam time has expired.'])->withInput();
        }

        \Log::info('Quiz access successful', [
            'student_id' => $accessCode->student_id,
            'exam_id' => $accessCode->exam_id,
            'student_name' => $accessCode->student->full_name,
            'exam_title' => $accessCode->exam->title,
            'exam_status' => $accessCode->exam->isActive ? 'active' : 'scheduled',
            'has_submitted' => $accessCode->hasSubmittedExam()
        ]);

        // Check access code status to determine access level
        \Log::info('Checking access code status', [
            'access_code_id' => $accessCode->id,
            'access_code_status' => $accessCode->status,
            'student_id' => $accessCode->student_id,
            'exam_id' => $accessCode->exam_id,
            'used_at' => $accessCode->used_at
        ]);
        
        if ($accessCode->status === 'used') {
            // Access code is "used" (submitted) - redirect directly to results
            \Log::info('Access code is submitted, redirecting to results', [
                'student_id' => $accessCode->student_id,
                'exam_id' => $accessCode->exam_id,
                'access_code_status' => $accessCode->status
            ]);
            
            // Store access info in session for results page
            session([
                'quiz_access' => [
                    'access_code_id' => $accessCode->id,
                    'student_id' => $accessCode->student_id,
                    'exam_id' => $accessCode->exam_id,
                    'student_name' => $accessCode->student->full_name,
                ]
            ]);
            
            \Log::info('Redirecting to results page from processAccess', [
                'exam_id' => $accessCode->exam_id,
                'redirect_url' => route('public.quiz.result', $accessCode->exam_id),
                'session_data' => session('quiz_access')
            ]);
            
            if ($request->ajax() && $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'redirect' => route('public.quiz.result', $accessCode->exam_id)
                ]);
            }
            
            return redirect()->route('public.quiz.result', $accessCode->exam_id);
        } elseif ($accessCode->status === 'active') {
            // Access code is "active" (waiting) - allow normal test access
            \Log::info('Access code is waiting, allowing normal test access', [
                'student_id' => $accessCode->student_id,
                'exam_id' => $accessCode->exam_id,
                'access_code_status' => $accessCode->status
            ]);
        } else {
            // Access code is in some other state (inactive, etc.)
            \Log::warning('Quiz access failed - access code not in valid state', [
                'phone' => $phone,
                'access_code' => $request->access_code,
                'status' => $accessCode->status
            ]);
            
            if ($request->ajax() && $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'This access code is not active. Please contact your teacher.',
                    'errors' => ['access' => 'This access code is not active. Please contact your teacher.']
                ], 422);
            }
            
            return back()->withErrors(['access' => 'This access code is not active. Please contact your teacher.'])->withInput();
        }

        // Check if student has already attempted this exam
        $existingResult = ExamResult::where('student_id', $accessCode->student_id)
            ->where('exam_id', $accessCode->exam_id)
            ->first();

        if ($existingResult) {
            if ($existingResult->status === 'completed') {
                // If exam is completed, redirect to results page instead of showing error
                \Log::info('Student has completed exam, redirecting to results', [
                    'student_id' => $accessCode->student_id,
                    'exam_id' => $accessCode->exam_id,
                    'result_id' => $existingResult->id
                ]);
                
                // Store access info in session for results page
                session([
                    'quiz_access' => [
                        'access_code_id' => $accessCode->id,
                        'student_id' => $accessCode->student_id,
                        'exam_id' => $accessCode->exam_id,
                        'student_name' => $accessCode->student->full_name,
                    ]
                ]);
                
                return redirect()->route('public.quiz.result', $accessCode->exam_id);
            } elseif ($existingResult->status === 'in_progress') {
                // If exam is in progress, redirect to take page to continue
                \Log::info('Student has exam in progress, redirecting to continue', [
                    'student_id' => $accessCode->student_id,
                    'exam_id' => $accessCode->exam_id,
                    'result_id' => $existingResult->id
                ]);
                
                // Store access info in session for the quiz
                session([
                    'quiz_access' => [
                        'access_code_id' => $accessCode->id,
                        'student_id' => $accessCode->student_id,
                        'exam_id' => $accessCode->exam_id,
                        'student_name' => $accessCode->student->full_name,
                    ]
                ]);
                
                return redirect()->route('public.quiz.take', $accessCode->exam_id);
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

        // Handle AJAX requests differently
        if ($request->ajax() && $request->header('X-Requested-With') === 'XMLHttpRequest') {
            // Always redirect to waiting view for all exam statuses
            $exam = $accessCode->exam;
            if ($exam->status === 'published' && !$accessCode->isExpired()) {
                $redirectUrl = route('public.quiz.start', $exam->id);
            } else {
                $redirectUrl = route('public.quiz.access');
            }
            
            return response()->json([
                'success' => true,
                'redirect' => $redirectUrl
            ]);
        }
        
        // Always redirect to waiting view for all exam statuses
        $exam = $accessCode->exam;
        
        \Log::info('Redirecting to waiting view', [
            'exam_id' => $exam->id,
            'exam_title' => $exam->title,
            'status' => $exam->status,
            'is_active' => $exam->isActive,
            'is_scheduled' => $exam->isScheduled(),
            'start_time' => $exam->start_time,
            'end_time' => $exam->end_time,
            'current_time' => now()->toDateTimeString()
        ]);
        
        // Check if exam is available (published and not expired)
        if ($exam->status === 'published' && !$accessCode->isExpired()) {
            \Log::info('Redirecting to waiting view', ['exam_id' => $exam->id]);
            return redirect()->route('public.quiz.start', $exam->id);
        } else {
            \Log::warning('Exam not available', [
                'exam_id' => $exam->id,
                'status' => $exam->status,
                'is_expired' => $accessCode->isExpired(),
                'current_time' => now()->toDateTimeString(),
                'start_time' => $exam->start_time,
                'end_time' => $exam->end_time
            ]);
            
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'This exam is not currently available.']);
        }
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

        // Check if any access code is valid (using same logic as processAccess)
        $validAccessCodes = $accessCodes->filter(function ($accessCode) {
            // Access code is valid if:
            // 1. Status is active OR used (submitted)
            // 2. Exam end date hasn't passed
            return ($accessCode->status === 'active' || $accessCode->status === 'used') && !$accessCode->isExpired();
        });

        if ($validAccessCodes->isEmpty()) {
            return back()->withErrors(['access' => 'Access code is no longer valid.'])->withInput();
        }

        // Check if all access codes are 'used' (submitted) - redirect to results
        $usedAccessCodes = $validAccessCodes->filter(function ($accessCode) {
            return $accessCode->status === 'used';
        });

        if ($usedAccessCodes->count() === $validAccessCodes->count()) {
            // All access codes are submitted, redirect to results for the first exam
            $firstUsedCode = $usedAccessCodes->first();
            
            // Store access info in session for results page
            session([
                'quiz_access' => [
                    'access_code_id' => $firstUsedCode->id,
                    'student_id' => $firstUsedCode->student_id,
                    'exam_id' => $firstUsedCode->exam_id,
                    'student_name' => $firstUsedCode->student->full_name,
                ]
            ]);
            
            \Log::info('All access codes are submitted, redirecting to results', [
                'student_id' => $firstUsedCode->student_id,
                'exam_id' => $firstUsedCode->exam_id,
                'access_code_status' => $firstUsedCode->status
            ]);
            
            return redirect()->route('public.quiz.result', $firstUsedCode->exam_id);
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

        // Always redirect to waiting view for all exam statuses
        if ($exam->status === 'published') {
            return redirect()->route('public.quiz.start', $exam);
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
            \Log::warning('Invalid session for showQuiz', [
                'exam_id' => $exam->id,
                'access_info' => $accessInfo,
                'session_id' => session()->getId()
            ]);
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Session expired. Please enter your access details again.']);
        }

        $accessCode = ExamAccessCode::find($accessInfo['access_code_id']);
        if (!$accessCode) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Access code not found.']);
        }

        // Check if exam has ended
        if ($accessCode->isExpired()) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Exam time has expired.']);
        }

        // Check access code status to determine access level
        if ($accessCode->status === 'used') {
            // Access code is "used" (submitted) - redirect directly to results
            \Log::info('Access code is submitted via showQuiz, redirecting to results', [
                'student_id' => $accessInfo['student_id'],
                'exam_id' => $exam->id,
                'access_code_status' => $accessCode->status
            ]);
            
            return redirect()->route('public.quiz.result', $exam->id);
        } elseif ($accessCode->status === 'active') {
            // Access code is "active" (waiting) - allow normal test access
            \Log::info('Access code is waiting via showQuiz, allowing normal test access', [
                'student_id' => $accessInfo['student_id'],
                'exam_id' => $exam->id,
                'access_code_status' => $accessCode->status
            ]);
        }

        // Always show waiting view regardless of exam status
        // Get all participants for the waiting room
        $participants = $this->getAllParticipants($exam);
        return view('public.quiz.waiting', compact('exam', 'accessInfo', 'participants'));
    }

    /**
     * Get all participants for the exam (waiting and completed)
     */
    private function getAllParticipants(Exam $exam)
    {
        return ExamAccessCode::where('exam_id', $exam->id)
            ->with(['student', 'student.course', 'student.batch'])
            ->get()
            ->map(function ($accessCode) {
                $student = $accessCode->student;
                $status = $accessCode->used_at ? 'completed' : 'waiting';
                
                return [
                    'id' => $student->id,
                    'name' => $student->full_name,
                    'photo' => $student->photo,
                    'student_id' => $student->student_id ?? $student->id,
                    'course_name' => $student->course->name ?? 'Course',
                    'batch_name' => $student->batch->name ?? 'Batch',
                    'status' => $status,
                    'joined_at' => $accessCode->created_at,
                    'completed_at' => $accessCode->used_at,
                ];
            })
            ->sortBy('joined_at')
            ->values();
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
            ->where('status', 'in_progress')
            ->first();

        if ($existingResult) {
            // Resume existing quiz
            return redirect()->route('public.quiz.take', $exam->id);
        }

        // Check if student has already submitted the exam
        $completedResult = ExamResult::where('student_id', $accessInfo['student_id'])
            ->where('exam_id', $exam->id)
            ->where('status', 'completed')
            ->first();

        if ($completedResult) {
            // If exam allows retake, create a new result for retake
            if ($exam->allow_retake) {
                \Log::info('Creating new result for retake', [
                    'exam_id' => $exam->id,
                    'student_id' => $accessInfo['student_id'],
                    'previous_result_id' => $completedResult->id
                ]);
                
                // Create new result for retake
                $result = ExamResult::create([
                    'student_id' => $accessInfo['student_id'],
                    'exam_id' => $exam->id,
                    'started_at' => now(),
                    'total_questions' => $exam->total_questions ?? 0,
                    'status' => 'in_progress',
                ]);
                
                return redirect()->route('public.quiz.take', $exam->id);
            } else {
                return redirect()->route('public.quiz.result', $exam->id);
            }
        }

        // Create new exam result
        $result = ExamResult::create([
            'student_id' => $accessInfo['student_id'],
            'exam_id' => $exam->id,
            'started_at' => now(),
            'total_questions' => $exam->total_questions ?? 0,
            'status' => 'in_progress',
        ]);

        // Don't mark access code as used yet - only when exam is submitted
        // The access code will remain valid until exam is completed or exam time expires

        return redirect()->route('public.quiz.take', $exam->id);
    }

    /**
     * Show the quiz questions
     */
    public function takeQuiz(Exam $exam)
    {
        $accessInfo = session('quiz_access');
        
        if (!$accessInfo || $accessInfo['exam_id'] != $exam->id) {
            \Log::warning('Invalid session for takeQuiz', [
                'exam_id' => $exam->id,
                'access_info' => $accessInfo,
                'session_id' => session()->getId()
            ]);
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Session expired. Please enter your access details again.']);
        }

        $result = ExamResult::where('student_id', $accessInfo['student_id'])
            ->where('exam_id', $exam->id)
            ->where('status', 'in_progress')
            ->first();

        if (!$result) {
            // Check if student has already submitted the exam
            $completedResult = ExamResult::where('student_id', $accessInfo['student_id'])
                ->where('exam_id', $exam->id)
                ->where('status', 'completed')
                ->first();

            if ($completedResult) {
                return redirect()->route('public.quiz.result', $exam->id);
            }

            // If no active quiz, create a new one directly
            $result = ExamResult::create([
                'student_id' => $accessInfo['student_id'],
                'exam_id' => $exam->id,
                'started_at' => now(),
                'total_questions' => $exam->total_questions ?? 0,
                'status' => 'in_progress',
            ]);
        }

        // Check if time has expired - ONLY based on exam end_time, not duration
        $examEndTime = \Carbon\Carbon::parse($exam->end_time)->setTimezone(config('app.timezone'));
        $currentTime = \Carbon\Carbon::now(config('app.timezone'));
        
        if ($currentTime->gt($examEndTime)) {
            // Auto-submit exam - exam has ended
            $this->autoSubmitExam($result);
            return redirect()->route('public.quiz.result', $exam->id);
        }

        // Load questions from exam_questions table
        $questions = $exam->questions()->orderBy('pivot_order')->get();
        
        // Calculate remaining time based on exam duration
        $examDurationSeconds = $exam->duration * 60; // Convert minutes to seconds
        
        // For quiz, use the full duration regardless of when student started
        // This ensures the timer always shows the correct exam duration
        $remainingTime = $examDurationSeconds;
        
        // Also check if exam end time has passed
        $timeUntilExamEnds = $currentTime->diffInSeconds($examEndTime);
        $remainingTime = min($remainingTime, $timeUntilExamEnds);
        
        \Log::info('Quiz Timer Set', [
            'exam_id' => $exam->id,
            'exam_duration_minutes' => $exam->duration,
            'exam_duration_seconds' => $examDurationSeconds,
            'remaining_time_seconds' => $remainingTime,
            'remaining_time_minutes' => floor($remainingTime / 60),
            'remaining_time_hours' => floor($remainingTime / 3600),
            'current_time' => $currentTime->toDateTimeString(),
            'exam_end_time' => $examEndTime->toDateTimeString(),
            'time_until_exam_ends' => $timeUntilExamEnds,
            'calculation_method' => 'full_duration'
        ]);

        // Get participants (students who are currently taking or have taken this exam)
        $participants = ExamResult::where('exam_id', $exam->id)
            ->whereIn('status', ['in_progress', 'completed'])
            ->with('student')
            ->get()
            ->map(function($examResult) use ($accessInfo) {
                return [
                    'id' => $examResult->student->id,
                    'name' => $examResult->student->full_name,
                    'phone' => $this->maskPhoneNumber($examResult->student->phone),
                    'photo' => $examResult->student->photo,
                    'status' => $examResult->status,
                    'started_at' => $examResult->started_at,
                    'is_current_user' => $examResult->student->id == $accessInfo['student_id']
                ];
            })
            ->sortByDesc('is_current_user'); // Sort to put current user first

        return view('public.quiz.take', compact('exam', 'questions', 'result', 'remainingTime', 'participants'));
    }

    /**
     * Mask phone number by replacing middle 6 digits with X
     */
    private function maskPhoneNumber($phone)
    {
        if (empty($phone) || strlen($phone) < 11) {
            return $phone;
        }
        
        // For 11-digit phone numbers like 01712345678
        // Show first 2 digits and last 3 digits, mask middle 6
        return substr($phone, 0, 2) . 'XXXXXX' . substr($phone, -3);
    }

    /**
     * Submit the quiz
     */
    public function submitQuiz(Request $request, Exam $exam)
    {
        try {
            \Log::info('Quiz submission started', [
                'exam_id' => $exam->id,
                'request_data' => $request->all(),
                'session_data' => session('quiz_access')
            ]);

            $accessInfo = session('quiz_access');
            
            if (!$accessInfo || $accessInfo['exam_id'] != $exam->id) {
                \Log::warning('Quiz submission failed - invalid access', [
                    'exam_id' => $exam->id,
                    'access_info' => $accessInfo,
                    'session_id' => session()->getId()
                ]);
                return redirect()->route('public.quiz.access')->withErrors(['access' => 'Session expired. Please enter your access details again.']);
            }

            $result = ExamResult::where('student_id', $accessInfo['student_id'])
                ->where('exam_id', $exam->id)
                ->where('status', 'in_progress')
                ->first();

            if (!$result) {
                \Log::warning('Quiz submission failed - no active quiz found', [
                    'exam_id' => $exam->id,
                    'student_id' => $accessInfo['student_id']
                ]);
                return redirect()->route('public.quiz.access')->withErrors(['access' => 'No active quiz found.']);
            }

            // Process answers and calculate score
            $answers = $request->input('answers', []);
            \Log::info('Processing quiz answers', [
                'exam_id' => $exam->id,
                'answers_count' => count($answers),
                'answers' => $answers
            ]);

            $scoreData = $this->calculateScore($exam, $answers, $accessInfo['student_id'], $result->id);
            \Log::info('Quiz score calculated', [
                'exam_id' => $exam->id,
                'score_data' => $scoreData
            ]);

            // Update result
            $result->update([
                'completed_at' => now(),
                'status' => 'completed',
                'answers' => $answers,
                'score' => $scoreData['score'],
                'percentage' => $scoreData['percentage'],
                'correct_answers' => $scoreData['correct_answers'],
                'wrong_answers' => $scoreData['wrong_answers'],
                'unanswered' => $scoreData['unanswered'],
                'total_questions' => $scoreData['total_questions'],
            ]);

            \Log::info('Quiz submission completed successfully', [
                'exam_id' => $exam->id,
                'student_id' => $accessInfo['student_id'],
                'result_id' => $result->id
            ]);

            // Mark access code as used now that exam is completed
            $accessCode = ExamAccessCode::find($accessInfo['access_code_id']);
            \Log::info('Attempting to mark access code as used', [
                'access_code_id' => $accessInfo['access_code_id'],
                'access_code_found' => $accessCode ? true : false,
                'current_status' => $accessCode ? $accessCode->status : 'not_found'
            ]);
            
            if ($accessCode) {
                $accessCode->markAsUsed();
            } else {
                \Log::error('Access code not found when trying to mark as used', [
                    'access_code_id' => $accessInfo['access_code_id']
                ]);
            }

            // Store result info in session for result page
            session([
                'quiz_result' => [
                    'exam_id' => $exam->id,
                    'student_id' => $accessInfo['student_id'],
                    'result_id' => $result->id,
                ]
            ]);

            return redirect()->route('public.quiz.result', $exam->id);
        } catch (\Exception $e) {
            \Log::error('Quiz submission failed with exception', [
                'exam_id' => $exam->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'An error occurred while submitting your quiz. Please try again.']);
        }
    }

    /**
     * Show quiz result
     */
    public function showResult(Exam $exam)
    {
        // Check if results should be shown immediately
        // Allow access for students with submitted status even if show_results_immediately is false
        $accessInfo = session('quiz_access');
        $allowAccess = $exam->show_results_immediately || 
                      ($accessInfo && $accessInfo['exam_id'] == $exam->id);
        
        if (!$allowAccess) {
            return redirect()->route('public.quiz.access')
                ->with('info', 'Results are not available immediately. Please contact your instructor.');
        }

        $resultInfo = session('quiz_result');
        
        \Log::info('Accessing results page', [
            'exam_id' => $exam->id,
            'result_info' => $resultInfo,
            'access_info' => $accessInfo,
            'session_id' => session()->getId(),
            'all_session_data' => session()->all()
        ]);
        
        // Try to find the result using different methods
        $result = null;
        
        if ($resultInfo && $resultInfo['exam_id'] == $exam->id) {
            // Use result info from session
            $result = ExamResult::with(['student.course', 'student.partner'])->where('id', $resultInfo['result_id'])
                ->where('exam_id', $exam->id)
                ->first();
        } elseif ($accessInfo && $accessInfo['exam_id'] == $exam->id) {
            // Use access info from session - look for any result for this student and exam
            $result = ExamResult::with(['student.course', 'student.partner'])->where('student_id', $accessInfo['student_id'])
                ->where('exam_id', $exam->id)
                ->where('status', 'completed')
                ->latest('completed_at')
                ->first();
                
            // If no completed result found, look for any result
            if (!$result) {
                $result = ExamResult::with(['student.course', 'student.partner'])->where('student_id', $accessInfo['student_id'])
                    ->where('exam_id', $exam->id)
                    ->latest('created_at')
                    ->first();
            }
        } else {
            // Look for the most recent completed result for this exam
            $result = ExamResult::with(['student.course', 'student.partner'])->where('exam_id', $exam->id)
                ->where('status', 'completed')
                ->latest('completed_at')
                ->first();
        }

        \Log::info('Result found', [
            'exam_id' => $exam->id,
            'result_found' => $result ? true : false,
            'result_id' => $result ? $result->id : null,
            'result_status' => $result ? $result->status : null,
            'student_id' => $accessInfo['student_id'] ?? 'not_set'
        ]);

        if (!$result) {
            \Log::error('No result found for submitted access code', [
                'exam_id' => $exam->id,
                'access_info' => $accessInfo,
                'result_info' => $resultInfo
            ]);
            
            // For submitted access codes, try to find any result or create a placeholder
            if ($accessInfo && $accessInfo['exam_id'] == $exam->id) {
                // Look for any result for this student and exam, regardless of status
                $result = ExamResult::with(['student.course', 'student.partner'])->where('student_id', $accessInfo['student_id'])
                    ->where('exam_id', $exam->id)
                    ->latest('created_at')
                    ->first();
                    
                if (!$result) {
                    // Create a placeholder result for submitted access codes
                    $result = new ExamResult([
                        'student_id' => $accessInfo['student_id'],
                        'exam_id' => $exam->id,
                        'status' => 'completed',
                        'completed_at' => now(),
                        'total_questions' => $exam->total_questions ?? 0,
                        'correct_answers' => 0,
                        'wrong_answers' => 0,
                        'unanswered' => $exam->total_questions ?? 0,
                        'score' => 0,
                        'percentage' => 0,
                        'answers' => []
                    ]);
                    
                    \Log::info('Created placeholder result for submitted access code', [
                        'exam_id' => $exam->id,
                        'student_id' => $accessInfo['student_id']
                    ]);
                }
            }
            
            if (!$result) {
                return redirect()->route('public.quiz.access')
                    ->withErrors(['access' => 'No quiz result found. Please contact your instructor.']);
            }
        }

        // Don't clear quiz_result session - allow re-access to results
        // session()->forget('quiz_result');

        return view('public.quiz.result', compact('exam', 'result'));
    }

    /**
     * Calculate quiz score and record individual question statistics
     */
    private function calculateScore(Exam $exam, array $answers, $studentId, $examResultId)
    {
        $score = 0;
        $correctAnswers = 0;
        $wrongAnswers = 0;
        $unanswered = 0;
        $totalMarks = 0;
        
        $questions = $exam->questions()->orderBy('pivot_order')->get();

        foreach ($questions as $question) {
            $questionId = $question->id;
            $studentAnswer = $answers[$questionId] ?? null;
            $questionMarks = $question->pivot->marks ?? 1;
            $totalMarks += $questionMarks;

            // Determine if the answer is correct, wrong, or unanswered
            $isAnswered = !empty($studentAnswer);
            $isCorrect = false;
            $isSkipped = false;
            $answerMetadata = null;

            if ($studentAnswer === null || $studentAnswer === '') {
                $unanswered++;
                $isSkipped = true;
            } else {
                if ($question->question_type === 'mcq') {
                    if ($studentAnswer === $question->correct_answer) {
                        $score += $questionMarks;
                        $correctAnswers++;
                        $isCorrect = true;
                    } else {
                        $wrongAnswers++;
                        // Apply negative marking for wrong answers if enabled
                        if ($exam->has_negative_marking) {
                            $negativeMarks = $exam->negative_marks_per_question ?? 0;
                            $score -= $negativeMarks;
                        }
                    }
                } else {
                    // For descriptive questions, give partial marks based on word count
                    $wordCount = str_word_count($studentAnswer);
                    $minWords = $question->min_words ?? 10;
                    $maxWords = $question->max_words ?? 100;
                    
                    $answerMetadata = [
                        'word_count' => $wordCount,
                        'min_words_required' => $minWords,
                        'max_words_expected' => $maxWords,
                    ];
                    
                    if ($wordCount >= $minWords) {
                        $partialScore = $questionMarks * min(1, $wordCount / $maxWords);
                        $score += $partialScore;
                        $correctAnswers++; // Count as correct if meets minimum word requirement
                        $isCorrect = true;
                    } else {
                        $wrongAnswers++;
                        // Apply negative marking for descriptive questions that don't meet word requirements
                        if ($exam->has_negative_marking) {
                            $negativeMarks = $exam->negative_marks_per_question ?? 0;
                            $score -= $negativeMarks;
                        }
                    }
                }
            }

            // Record individual question statistics
            \App\Models\QuestionStat::create([
                'question_id' => $questionId,
                'exam_id' => $exam->id,
                'student_id' => $studentId,
                'exam_result_id' => $examResultId,
                'student_answer' => $studentAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
                'is_answered' => $isAnswered,
                'is_skipped' => $isSkipped,
                'question_order' => $question->pivot->order ?? 0,
                'marks' => $questionMarks,
                'question_type' => $question->question_type,
                'answer_metadata' => $answerMetadata,
                'question_answered_at' => now(),
            ]);
        }

        // Ensure score doesn't go below 0
        $score = max(0, $score);
        
        $percentage = $totalMarks > 0 ? ($score / $totalMarks) * 100 : 0;

        return [
            'score' => $score,
            'percentage' => $percentage,
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'unanswered' => $unanswered,
            'total_marks' => $totalMarks,
            'total_questions' => $questions->count(),
        ];
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
        // Allow access to exam regardless of completion status
        // The actual redirect logic will be handled in processAccess/selectExam
        return true;
    }

    /**
     * Handle exam selection
     */
    public function selectExam(Request $request, $accessCodeId)
    {
        $accessCode = ExamAccessCode::find($accessCodeId);
        
        if (!$accessCode) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Access code not found.']);
        }

        // Check if exam has ended
        if ($accessCode->isExpired()) {
            return redirect()->route('public.quiz.access')->withErrors(['access' => 'Exam time has expired.']);
        }

        // Check access code status to determine access level
        if ($accessCode->status === 'used') {
            // Access code is "used" (submitted) - redirect directly to results
            \Log::info('Access code is submitted via selectExam, redirecting to results', [
                'student_id' => $accessCode->student_id,
                'exam_id' => $accessCode->exam_id,
                'access_code_status' => $accessCode->status
            ]);
            
            return redirect()->route('public.quiz.result', $accessCode->exam_id);
        } elseif ($accessCode->status === 'active') {
            // Access code is "active" (waiting) - allow normal test access
            \Log::info('Access code is waiting via selectExam, allowing normal test access', [
                'student_id' => $accessCode->student_id,
                'exam_id' => $accessCode->exam_id,
                'access_code_status' => $accessCode->status
            ]);
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

        // Always redirect to waiting view for all exam statuses
        if ($exam->status === 'published' && !$accessCode->isExpired()) {
            return redirect()->route('public.quiz.start', $exam->id);
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

    /**
     * Recover session data for submitted exams
     */
    private function recoverSessionForSubmittedExam($accessCode)
    {
        if (!$accessCode) {
            return false;
        }

        // Store access info in session for results page
        session([
            'quiz_access' => [
                'access_code_id' => $accessCode->id,
                'student_id' => $accessCode->student_id,
                'exam_id' => $accessCode->exam_id,
                'student_name' => $accessCode->student->full_name,
            ]
        ]);

        \Log::info('Session recovered for submitted exam', [
            'access_code_id' => $accessCode->id,
            'student_id' => $accessCode->student_id,
            'exam_id' => $accessCode->exam_id
        ]);

        return true;
    }

    /**
     * Validate and recover session if needed
     */
    private function validateOrRecoverSession($examId, $accessCodeId = null)
    {
        $accessInfo = session('quiz_access');
        
        // If session is valid, return true
        if ($accessInfo && $accessInfo['exam_id'] == $examId) {
            return true;
        }

        // Try to recover session using access code
        if ($accessCodeId) {
            $accessCode = ExamAccessCode::find($accessCodeId);
            if ($accessCode && $accessCode->exam_id == $examId) {
                return $this->recoverSessionForSubmittedExam($accessCode);
            }
        }

        return false;
    }

    /**
     * Handle direct access to results page with access code recovery
     */
    public function directResultAccess(Request $request, Exam $exam)
    {
        // Try to find access code from URL parameters or session
        $accessCodeId = $request->get('access_code_id');
        $accessCode = null;

        if ($accessCodeId) {
            $accessCode = ExamAccessCode::find($accessCodeId);
        }

        // If no access code provided, try to find from session
        if (!$accessCode) {
            $accessInfo = session('quiz_access');
            if ($accessInfo && $accessInfo['exam_id'] == $exam->id) {
                $accessCode = ExamAccessCode::find($accessInfo['access_code_id']);
            }
        }

        // If still no access code, redirect to access page
        if (!$accessCode) {
            return redirect()->route('public.quiz.access')
                ->withErrors(['access' => 'Please enter your access details to view results.']);
        }

        // Check if access code is for this exam
        if ($accessCode->exam_id != $exam->id) {
            return redirect()->route('public.quiz.access')
                ->withErrors(['access' => 'Invalid access code for this exam.']);
        }

        // Recover session for submitted exam
        $this->recoverSessionForSubmittedExam($accessCode);

        // Redirect to results
        return redirect()->route('public.quiz.result', $exam->id);
    }
}
