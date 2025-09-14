<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Student;
use App\Models\Partner;
use App\Models\Question;
use App\Models\QuestionSet;
use App\Models\QuestionType;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Batch;
use App\Models\ExamQuestion;
use App\Models\ExamAccessCode;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $partnerId = $this->getPartnerId();
        $query = Exam::with(['partner', 'examQuestion'])
            ->withCount('questions as assigned_questions_count')
            ->withCount('assignedStudents as assigned_students_count')
            ->where('partner_id', $partnerId);

        // Filters
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($q = $request->get('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $exams = $query->latest()->paginate(15)->withQueryString();

        // Simple counts for header chips
        $counts = [
            'all' => Exam::where('partner_id', $partnerId)->count(),
            'draft' => Exam::where('partner_id', $partnerId)->where('status', 'draft')->count(),
            'published' => Exam::where('partner_id', $partnerId)->where('status', 'published')->count(),
            'ongoing' => Exam::where('partner_id', $partnerId)->where('status', 'ongoing')->count(),
            'completed' => Exam::where('partner_id', $partnerId)->where('status', 'completed')->count(),
            'deleted' => Exam::withoutGlobalScope('active')->where('partner_id', $partnerId)->where('flag', 'deleted')->count(),
        ];

        return view('partner.exams.index', compact('exams', 'counts'));
    }

    public function create()
    {
        $partnerId = $this->getPartnerId();
        return view('partner.exams.create');
    }

    public function store(Request $request)
    {
        // Ensure the authenticated user is a partner
        if (!auth()->user() || auth()->user()->role !== 'partner') {
            abort(403, 'Only partners can create exams.');
        }

        // Check if this is a draft save
        $isDraft = $request->boolean('is_draft', false);
        
        // Different validation rules for draft vs full save
        if ($isDraft) {
            // More lenient validation for drafts - only require title
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'exam_type' => 'nullable|in:online,offline',
                'startDateTime' => 'nullable|date',
                'endDateTime' => 'nullable|date',
                'duration' => 'nullable|integer|min:1|max:480',
                'total_questions' => 'nullable|integer|min:1|max:1000',
                'passing_marks' => 'nullable|integer|min:0|max:100',
                'allow_retake' => 'boolean',
                'show_results_immediately' => 'boolean',
                'has_negative_marking' => 'boolean',
                'negative_marks_per_question' => 'nullable|numeric|min:0|max:5',
                'question_header' => 'nullable|string',
                'question_language' => 'required|in:english,bangla',
            ]);
        } else {
            // Full validation for complete exam creation
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'exam_type' => 'required|in:online,offline',
                'startDateTime' => 'required|date',
                'endDateTime' => 'required|date',
                'duration' => 'required|integer|min:15|max:480',
                'total_questions' => 'required|integer|min:1|max:1000',
                'passing_marks' => 'required|integer|min:0|max:100',
                'allow_retake' => 'boolean',
                'show_results_immediately' => 'boolean',
                'has_negative_marking' => 'boolean',
                'negative_marks_per_question' => 'required_if:has_negative_marking,1|nullable|numeric|min:0|max:5',
                'question_header' => 'nullable|string',
                'question_language' => 'required|in:english,bangla',
            ]);
        }

        // Parse the datetime-local inputs directly (only if not draft or if values exist)
        $startDateTime = null;
        $endDateTime = null;
        $now = \Carbon\Carbon::now();
        
        if ($request->startDateTime) {
            $startDateTime = \Carbon\Carbon::parse($request->startDateTime);
        }
        if ($request->endDateTime) {
            $endDateTime = \Carbon\Carbon::parse($request->endDateTime);
        }

        // Comprehensive datetime validation (only for non-draft saves or if dates are provided)
        $errors = [];
        
        if (!$isDraft && $startDateTime && $endDateTime) {
            // Validate that start datetime is in the future
            if ($startDateTime <= $now) {
                $errors['startDateTime'] = 'Start date and time must be in the future. Current time is ' . $now->format('M d, Y H:i');
            }

            // Validate that end datetime is after start datetime
            if ($endDateTime <= $startDateTime) {
                $errors['endDateTime'] = 'End date and time must be after start date and time.';
            }

            // Validate that end datetime is not too far in the future (optional: limit to 1 year)
            $maxEndDate = $now->copy()->addYear();
            if ($endDateTime > $maxEndDate) {
                $errors['endDateTime'] = 'End date and time cannot be more than 1 year in the future.';
            }
        } elseif ($startDateTime && $endDateTime) {
            // For drafts, only validate if both dates are provided and they make sense
            if ($endDateTime <= $startDateTime) {
                $errors['endDateTime'] = 'End date and time must be after start date and time.';
            }
        }

        // If there are validation errors, return with errors
        if (!empty($errors)) {
            if ($isDraft) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $errors
                ], 422);
            } else {
                return back()->withErrors($errors)->withInput();
            }
        }

        // Whitelist fields to avoid mass-assigning unexpected input
        $data = $request->only([
            'title',
            'description',
            'exam_type',
            'duration',
            'total_questions',
            'passing_marks',
            'question_header',
            'question_language',
        ]);

        // For draft saves, provide default values for required fields that might be empty
        if ($isDraft) {
            $data['exam_type'] = $data['exam_type'] ?? 'online';
            $data['duration'] = $data['duration'] ?? 60; // Default 60 minutes
            $data['total_questions'] = $data['total_questions'] ?? 10; // Default 10 questions
            $data['passing_marks'] = $data['passing_marks'] ?? 50; // Default 50% passing marks
            $data['question_language'] = $data['question_language'] ?? 'english'; // Default English
        }

        // Add the combined datetime values (only if they exist)
        if ($startDateTime) {
            $data['start_time'] = $startDateTime->format('Y-m-d H:i:s');
        }
        if ($endDateTime) {
            $data['end_time'] = $endDateTime->format('Y-m-d H:i:s');
        }

        $data['partner_id'] = $this->getPartnerId();
        
        // Set default values for hidden fields
        $data['status'] = 'draft';
        $data['flag'] = 'active';
        $data['exam_question_id'] = null;
        $data['created_by'] = auth()->id(); // Set to the authenticated partner user's ID
        
        // Set boolean fields first
        $data['allow_retake'] = $request->boolean('allow_retake');
        $data['show_results_immediately'] = $request->boolean('show_results_immediately', true);
        $data['has_negative_marking'] = $request->boolean('has_negative_marking');
        
        // Handle negative marking
        if ($data['has_negative_marking']) {
            $data['negative_marks_per_question'] = $request->input('negative_marks_per_question', 0.25);
        } else {
            $data['negative_marks_per_question'] = 0;
        }

        $exam = Exam::create($data);

        // Debug: Log what was actually saved to the database
        \Log::info('Exam created', [
            'exam_id' => $exam->id,
            'data_sent' => $data,
            'exam_attributes' => $exam->getAttributes(),
            'created_by_value' => $exam->created_by,
            'auth_user_id' => auth()->id(),
            'partner_id' => $this->getPartnerId(),
            'is_draft' => $isDraft,
            'user_info' => [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name ?? 'Unknown',
                'user_email' => auth()->user()->email ?? 'Unknown'
            ]
        ]);

        // Return appropriate response based on request type
        if ($isDraft) {
            return response()->json([
                'success' => true,
                'message' => 'Draft saved successfully!',
                'exam_id' => $exam->id,
                'exam_title' => $exam->title
            ]);
        } else {
            return redirect()->route('partner.exams.index')
                ->with('success', 'Exam created successfully.');
        }
    }

    public function show(Exam $exam)
    {
        $exam->load([
            'studentResults.student', 
            'examQuestion',
            'questions' => function($query) {
                $query->orderBy('pivot_order', 'asc');
            },
            'accessCodes.student' => function($query) {
                $query->orderBy('full_name', 'asc');
            }
        ]);
        return view('partner.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $partnerId = $this->getPartnerId();
        return view('partner.exams.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'exam_type' => 'required|in:online,offline',
            'startDateTime' => 'required|date',
            'endDateTime' => 'required|date',
            'duration' => 'required|integer|min:15|max:480',
            'total_questions' => 'required|integer|min:1|max:1000',
            'passing_marks' => 'required|integer|min:0|max:100',
            'allow_retake' => 'boolean',
            'show_results_immediately' => 'boolean',
            'has_negative_marking' => 'boolean',
            'negative_marks_per_question' => 'required_if:has_negative_marking,1|nullable|numeric|min:0|max:5',
            'question_header' => 'nullable|string',
            'question_language' => 'required|in:english,bangla',
            'exam_question_id' => 'nullable|exists:exam_questions,id',
        ]);

        // Parse the datetime-local inputs directly
        $startDateTime = \Carbon\Carbon::parse($request->startDateTime);
        $endDateTime = \Carbon\Carbon::parse($request->endDateTime);
        $now = \Carbon\Carbon::now();

        // Comprehensive datetime validation
        $errors = [];

        // Validate that start datetime is in the future
        if ($startDateTime <= $now) {
            $errors['startDateTime'] = 'Start date and time must be in the future. Current time is ' . $now->format('M d, Y H:i');
        }

        // Validate that end datetime is after start datetime
        if ($endDateTime <= $startDateTime) {
            $errors['endDateTime'] = 'End date and time must be after start date and time.';
        }

        // Validate that end datetime is not too far in the future (optional: limit to 1 year)
        $maxEndDate = $now->copy()->addYear();
        if ($endDateTime > $maxEndDate) {
            $errors['endDateTime'] = 'End date and time cannot be more than 1 year in the future.';
        }

        // If there are validation errors, return with errors
        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        $data = $request->only([
            'title',
            'description',
            'exam_type',
            'duration',
            'total_questions',
            'passing_marks',
            'question_header',
            'question_language',
            'exam_question_id',
        ]);

        // Add the parsed datetime values
        $data['start_time'] = $startDateTime->format('Y-m-d H:i:s');
        $data['end_time'] = $endDateTime->format('Y-m-d H:i:s');
        
        $data['allow_retake'] = $request->boolean('allow_retake');
        $data['show_results_immediately'] = $request->boolean('show_results_immediately', true);
        $data['has_negative_marking'] = $request->boolean('has_negative_marking');
        
        // Handle negative marking
        if ($data['has_negative_marking']) {
            $data['negative_marks_per_question'] = $request->input('negative_marks_per_question', 0.25);
        } else {
            $data['negative_marks_per_question'] = 0;
        }

        $exam->update($data);

        return redirect()->route('partner.exams.index')
            ->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        // Ensure the authenticated user is a partner
        if (!auth()->user() || auth()->user()->role !== 'partner') {
            abort(403, 'Only partners can delete exams.');
        }

        // Verify the exam belongs to this partner
        $partnerId = $this->getPartnerId();
        if ($exam->partner_id !== $partnerId) {
            abort(403, 'Unauthorized access to this exam.');
        }

        // Soft delete by changing flag to 'deleted'
        $exam->softDelete();

        return redirect()->route('partner.exams.index')
            ->with('success', 'Exam deleted successfully. It can be restored from the deleted exams section.');
    }

    public function restore(Exam $exam)
    {
        // Ensure the authenticated user is a partner
        if (!auth()->user() || auth()->user()->role !== 'partner') {
            abort(403, 'Only partners can restore exams.');
        }

        // Verify the exam belongs to this partner
        $partnerId = $this->getPartnerId();
        if ($exam->partner_id !== $partnerId) {
            abort(403, 'Unauthorized access to this exam.');
        }

        // Restore by changing flag back to 'active'
        $exam->restore();

        return redirect()->route('partner.exams.index')
            ->with('success', 'Exam restored successfully.');
    }

    public function deleted()
    {
        $partnerId = $this->getPartnerId();
        
        // Get deleted exams for this partner
        $deletedExams = Exam::withoutGlobalScope('active')
            ->where('partner_id', $partnerId)
            ->where('flag', 'deleted')
            ->with(['partner', 'examQuestion'])
            ->latest()
            ->paginate(15);

        return view('partner.exams.deleted', compact('deletedExams'));
    }

    public function publish(Exam $exam)
    {
        // Ensure the authenticated user is a partner
        if (!auth()->user() || auth()->user()->role !== 'partner') {
            abort(403, 'Only partners can publish exams.');
        }

        $partnerId = $this->getPartnerId();
        
        // Verify the exam belongs to this partner
        if ($exam->partner_id !== $partnerId) {
            abort(403, 'Unauthorized access to this exam.');
        }

        // Debug: Log the current exam status and attempt to update
        \Log::info('Attempting to publish exam', [
            'exam_id' => $exam->id,
            'current_status' => $exam->status,
            'partner_id' => $partnerId,
            'exam_partner_id' => $exam->partner_id
        ]);

        try {
            $result = $exam->update(['status' => 'published']);
            
            \Log::info('Exam update result', [
                'exam_id' => $exam->id,
                'update_result' => $result,
                'new_status' => $exam->fresh()->status
            ]);

            if ($result) {
                return redirect()->route('partner.exams.show', $exam)
                    ->with('success', 'Exam published successfully.');
            } else {
                return redirect()->back()
                    ->with('error', 'Failed to publish exam. Please try again.');
            }
        } catch (\Exception $e) {
            \Log::error('Error publishing exam', [
                'exam_id' => $exam->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Error publishing exam: ' . $e->getMessage());
        }
    }

    public function unpublish(Exam $exam)
    {
        // Ensure the authenticated user is a partner
        if (!auth()->user() || auth()->user()->role !== 'partner') {
            abort(403, 'Only partners can unpublish exams.');
        }

        $partnerId = $this->getPartnerId();
        
        // Verify the exam belongs to this partner
        if ($exam->partner_id !== $partnerId) {
            abort(403, 'Unauthorized access to this exam.');
        }

        // Debug: Log the current exam status and attempt to update
        \Log::info('Attempting to unpublish exam', [
            'exam_id' => $exam->id,
            'current_status' => $exam->status,
            'partner_id' => $partnerId,
            'exam_partner_id' => $exam->partner_id
        ]);

        try {
            $result = $exam->update(['status' => 'draft']);
            
            \Log::info('Exam update result', [
                'exam_id' => $exam->id,
                'update_result' => $result,
                'new_status' => $exam->fresh()->status
            ]);

            if ($result) {
                return redirect()->route('partner.exams.show', $exam)
                    ->with('success', 'Exam unpublished successfully.');
            } else {
                return redirect()->back()
                    ->with('error', 'Failed to unpublish exam. Please try again.');
            }
        } catch (\Exception $e) {
            \Log::error('Error unpublishing exam', [
                'exam_id' => $exam->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Error unpublishing exam: ' . $e->getMessage());
        }
    }

    public function results(Exam $exam)
    {
        // Load the exam with assigned students
        $exam->load('assignedStudents.course', 'assignedStudents.batch');
        
        // Get all assigned students for this exam
        $assignedStudents = $exam->assignedStudents;

        // Get all exam results for this exam
        $examResults = ExamResult::where('exam_id', $exam->id)
            ->with('student')
            ->get()
            ->keyBy('student_id');

        // Create a combined list showing all assigned students
        $results = collect();
        
        foreach ($assignedStudents as $student) {
            $result = $examResults->get($student->id);
            
            if ($result) {
                // Student has taken the exam - use actual result data
                $results->push($result);
            } else {
                // Student hasn't taken the exam - create a mock result with "Absent" status
                $mockResult = new ExamResult([
                    'id' => 'absent_' . $student->id, // Unique ID for absent students
                    'student_id' => $student->id,
                    'exam_id' => $exam->id,
                    'started_at' => null,
                    'completed_at' => null,
                    'total_questions' => $exam->total_questions,
                    'correct_answers' => 0,
                    'wrong_answers' => 0,
                    'unanswered' => $exam->total_questions,
                    'score' => 0,
                    'percentage' => 0,
                    'status' => 'absent',
                    'answers' => [],
                ]);
                
                // Set the student relationship
                $mockResult->setRelation('student', $student);
                $results->push($mockResult);
            }
        }

        // Sort results: completed exams first, then absent students
        $results = $results->sortByDesc(function ($result) {
            return $result->status === 'absent' ? 0 : 1;
        });

        // Paginate the results
        $perPage = 20;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedResults = $results->slice($offset, $perPage);
        
        // Create pagination data
        $total = $results->count();
        $lastPage = ceil($total / $perPage);
        
        $pagination = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedResults,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );

        return view('partner.exams.results', compact('exam') + ['results' => $pagination]);
    }

    public function getResultDetails(Exam $exam, ExamResult $result)
    {
        // Verify the result belongs to this exam
        if ($result->exam_id !== $exam->id) {
            return response()->json(['error' => 'Result not found for this exam'], 404);
        }

        // Load the result with all necessary relationships
        $result->load(['student', 'exam']);

        // Get detailed analytics for this result
        $analytics = $result->detailed_analytics;

        // Get exam questions with their details
        $questions = $exam->questions()
            ->with(['topic', 'subject'])
            ->orderBy('exam_questions.order')
            ->get();

        // Get the student's answers
        $studentAnswers = $result->answers ?? [];

        // Process each question with student's answer and result
        $processedQuestions = $questions->map(function ($question, $index) use ($studentAnswers, $result) {
            $questionAnswer = $studentAnswers[$question->id] ?? null;
            $isCorrect = false;
            $isSkipped = false;
            $score = 0;
            $timeTaken = null;

            // Determine if the answer is correct, wrong, or skipped
            if ($questionAnswer === null || $questionAnswer === '') {
                $isSkipped = true;
            } else {
                if ($question->question_type === 'mcq') {
                    // Convert form answer to lowercase for comparison
                    $isCorrect = strtolower($questionAnswer) === strtolower($question->correct_answer);
                } else {
                    // For descriptive questions, check if it meets minimum requirements
                    $wordCount = str_word_count($questionAnswer);
                    $minWords = $question->min_words ?? 10;
                    $isCorrect = $wordCount >= $minWords;
                }
            }

            // Calculate score for this question
            if ($isCorrect) {
                $score = $question->marks ?? 1;
            }

            // Parse options for MCQ questions
            $options = null;
            if ($question->question_type === 'mcq' && $question->options) {
                $options = is_string($question->options) ? json_decode($question->options, true) : $question->options;
            }

            return [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'question_type' => $question->question_type,
                'marks' => $question->marks ?? 1,
                'correct_answer' => $question->correct_answer,
                'submitted_answer' => $questionAnswer,
                'is_correct' => $isCorrect,
                'is_skipped' => $isSkipped,
                'score' => $score,
                'options' => $options,
                'time_taken' => $timeTaken,
                'topic' => $question->topic?->name,
                'subject' => $question->subject?->name,
            ];
        });

        // Prepare the response data
        $data = [
            'result' => [
                'id' => $result->id,
                'student_name' => $result->student->full_name,
                'student_id' => $result->student->student_id,
                'exam_title' => $result->exam->title,
                'started_at' => $result->started_at?->format('M d, Y H:i:s'),
                'completed_at' => $result->completed_at?->format('M d, Y H:i:s'),
                'time_taken' => $result->time_taken,
                'total_questions' => $result->total_questions,
                'correct_answers' => $result->correct_answers,
                'wrong_answers' => $result->wrong_answers,
                'unanswered' => $result->unanswered,
                'score' => $result->score,
                'percentage' => $result->percentage,
                'status' => $result->status,
                'passing_marks' => $result->exam->passing_marks,
                'is_passed' => $result->percentage >= $result->exam->passing_marks,
            ],
            'questions' => $processedQuestions,
            'analytics' => $analytics,
            'answers' => $studentAnswers,
        ];

        return response()->json($data);
    }

    public function storeResult(Request $request, Exam $exam)
    {
        // Ensure the authenticated user is a partner
        if (!auth()->user() || auth()->user()->role !== 'partner') {
            return response()->json(['error' => 'Only partners can create results.'], 403);
        }

        // Verify the exam belongs to this partner
        $partnerId = $this->getPartnerId();
        if ($exam->partner_id !== $partnerId) {
            return response()->json(['error' => 'Unauthorized access to this exam.'], 403);
        }

        // Validate the request
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'score' => 'required|numeric|min:0|max:' . $exam->total_questions,
            'correct_answers' => 'required|integer|min:0|max:' . $exam->total_questions,
            'wrong_answers' => 'required|integer|min:0|max:' . $exam->total_questions,
            'unanswered' => 'required|integer|min:0|max:' . $exam->total_questions,
            'started_at' => 'nullable|date',
            'completed_at' => 'nullable|date|after_or_equal:started_at',
        ]);

        // Validate that correct + wrong + unanswered = total questions
        $totalAnswers = $request->correct_answers + $request->wrong_answers + $request->unanswered;
        if ($totalAnswers !== $exam->total_questions) {
            return response()->json([
                'error' => "Total answers ({$totalAnswers}) must equal total questions ({$exam->total_questions})"
            ], 422);
        }

        // Check if student is assigned to this exam
        $isAssigned = $exam->assignedStudents()->where('students.id', $request->student_id)->exists();
        if (!$isAssigned) {
            return response()->json([
                'error' => 'Student is not assigned to this exam'
            ], 422);
        }

        // Check if result already exists for this student and exam
        $existingResult = ExamResult::where('exam_id', $exam->id)
            ->where('student_id', $request->student_id)
            ->first();

        if ($existingResult) {
            return response()->json([
                'error' => 'Result already exists for this student. Please update the existing result instead.'
            ], 422);
        }

        // Calculate percentage
        $percentage = ($request->score / $exam->total_questions) * 100;

        // Create the result
        $result = ExamResult::create([
            'student_id' => $request->student_id,
            'exam_id' => $exam->id,
            'started_at' => $request->started_at ? \Carbon\Carbon::parse($request->started_at) : null,
            'completed_at' => $request->completed_at ? \Carbon\Carbon::parse($request->completed_at) : now(),
            'total_questions' => $exam->total_questions,
            'correct_answers' => $request->correct_answers,
            'wrong_answers' => $request->wrong_answers,
            'unanswered' => $request->unanswered,
            'score' => $request->score,
            'percentage' => round($percentage, 2),
            'status' => 'completed',
            'result_type' => 'manual',
            'answers' => [], // Empty for manual results
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Result created successfully',
            'result' => $result
        ]);
    }

    public function resultEntry(Exam $exam)
    {
        // Ensure the authenticated user is a partner
        if (!auth()->user() || auth()->user()->role !== 'partner') {
            abort(403, 'Only partners can access result entry.');
        }

        // Verify the exam belongs to this partner
        $partnerId = $this->getPartnerId();
        if ($exam->partner_id !== $partnerId) {
            abort(403, 'Unauthorized access to this exam.');
        }

        // Load exam with questions
        $exam->load([
            'questions' => function($query) {
                $query->orderBy('exam_questions.order', 'asc');
            }
        ]);

        // Get students who are absent (no results or status = 'absent')
        $absentStudents = $exam->assignedStudents()
            ->whereDoesntHave('examResults', function($query) use ($exam) {
                $query->where('exam_id', $exam->id)
                      ->where('status', '!=', 'absent');
            })
            ->orWhereHas('examResults', function($query) use ($exam) {
                $query->where('exam_id', $exam->id)
                      ->where('status', 'absent');
            })
            ->with(['course', 'batch'])
            ->get();

        return view('partner.exams.result-entry', compact('exam', 'absentStudents'));
    }

    public function storeDetailedResult(Request $request, Exam $exam)
    {
        // Ensure the authenticated user is a partner
        if (!auth()->user() || auth()->user()->role !== 'partner') {
            return response()->json(['error' => 'Only partners can create results.'], 403);
        }

        // Verify the exam belongs to this partner
        $partnerId = $this->getPartnerId();
        if ($exam->partner_id !== $partnerId) {
            return response()->json(['error' => 'Unauthorized access to this exam.'], 403);
        }

        // Validate the request
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'answers' => 'required|array',
            'answers.*' => 'nullable|string',
            'started_at' => 'nullable|date',
            'completed_at' => 'nullable|date|after_or_equal:started_at',
        ]);

        // Check if student is assigned to this exam
        $isAssigned = $exam->assignedStudents()->where('students.id', $request->student_id)->exists();
        if (!$isAssigned) {
            return response()->json([
                'error' => 'Student is not assigned to this exam'
            ], 422);
        }

        // Check if result already exists for this student and exam
        $existingResult = ExamResult::where('exam_id', $exam->id)
            ->where('student_id', $request->student_id)
            ->first();

        if ($existingResult) {
            return response()->json([
                'error' => 'Result already exists for this student. Please update the existing result instead.'
            ], 422);
        }

        // Load exam questions
        $questions = $exam->questions()->orderBy('exam_questions.order')->get();
        $answers = $request->answers;
        
        // Calculate results
        $correctAnswers = 0;
        $wrongAnswers = 0;
        $unanswered = 0;
        $totalScore = 0;
        $detailedAnswers = [];

        foreach ($questions as $question) {
            $questionAnswer = $answers[$question->id] ?? null;
            $isCorrect = false;
            $isAnswered = false;
            $score = 0;

            if ($questionAnswer !== null && $questionAnswer !== '') {
                $isAnswered = true;
                
                if ($question->question_type === 'mcq') {
                    // Convert form answer to lowercase for comparison
                    $isCorrect = strtolower($questionAnswer) === strtolower($question->correct_answer);
                } else {
                    // For descriptive questions, check if it meets minimum requirements
                    $wordCount = str_word_count($questionAnswer);
                    $minWords = $question->min_words ?? 10;
                    $isCorrect = $wordCount >= $minWords;
                }
                
                if ($isCorrect) {
                    $correctAnswers++;
                    $score = $question->pivot->marks ?? 1;
                    $totalScore += $score;
                } else {
                    $wrongAnswers++;
                }
            } else {
                $unanswered++;
            }

            $detailedAnswers[$question->id] = [
                'answer' => $questionAnswer,
                'is_correct' => $isCorrect,
                'is_answered' => $isAnswered,
                'score' => $score,
                'time_spent' => null, // Manual entry doesn't track time per question
            ];
        }

        // Calculate percentage
        $totalMarks = $questions->sum(function($q) { return $q->pivot->marks ?? 1; });
        $percentage = $totalMarks > 0 ? ($totalScore / $totalMarks) * 100 : 0;

        // Create the result
        $result = ExamResult::create([
            'student_id' => $request->student_id,
            'exam_id' => $exam->id,
            'started_at' => $request->started_at ? \Carbon\Carbon::parse($request->started_at) : null,
            'completed_at' => $request->completed_at ? \Carbon\Carbon::parse($request->completed_at) : now(),
            'total_questions' => $questions->count(),
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'unanswered' => $unanswered,
            'score' => $totalScore,
            'percentage' => round($percentage, 2),
            'status' => 'completed',
            'result_type' => 'manual',
            'answers' => $detailedAnswers,
        ]);

        // Create question statistics records (same as quiz submission)
        foreach ($questions as $question) {
            $questionAnswer = $answers[$question->id] ?? null;
            $isAnswered = !empty($questionAnswer);
            $isCorrect = false;
            $isSkipped = false;
            $answerMetadata = null;

            if ($questionAnswer === null || $questionAnswer === '') {
                $isSkipped = true;
            } else {
                if ($question->question_type === 'mcq') {
                    // Convert form answer to lowercase for comparison
                    $isCorrect = strtolower($questionAnswer) === strtolower($question->correct_answer);
                } else {
                    // For descriptive questions, give partial marks based on word count
                    $wordCount = str_word_count($questionAnswer);
                    $minWords = $question->min_words ?? 10;
                    $maxWords = $question->max_words ?? 100;
                    
                    $answerMetadata = [
                        'word_count' => $wordCount,
                        'min_words_required' => $minWords,
                        'max_words_expected' => $maxWords,
                    ];
                    
                    $isCorrect = $wordCount >= $minWords;
                }
            }

            // Record individual question statistics
            \App\Models\QuestionStat::create([
                'question_id' => $question->id,
                'exam_id' => $exam->id,
                'student_id' => $request->student_id,
                'exam_result_id' => $result->id,
                'student_answer' => $questionAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
                'is_answered' => $isAnswered,
                'is_skipped' => $isSkipped,
                'question_order' => $question->pivot->order ?? 0,
                'marks' => $question->pivot->marks ?? 1,
                'question_type' => $question->question_type,
                'answer_metadata' => $answerMetadata,
                'question_answered_at' => $request->completed_at ? \Carbon\Carbon::parse($request->completed_at) : now(),
            ]);
        }

        // Mark access code as used (same as quiz submission)
        $accessCode = \App\Models\ExamAccessCode::where('student_id', $request->student_id)
            ->where('exam_id', $exam->id)
            ->where('status', 'active')
            ->first();

        if ($accessCode) {
            $accessCode->markAsUsed();
            \Log::info('Access code marked as used for manual result entry', [
                'access_code_id' => $accessCode->id,
                'student_id' => $request->student_id,
                'exam_id' => $exam->id,
                'result_id' => $result->id
            ]);
        } else {
            \Log::warning('No active access code found for manual result entry', [
                'student_id' => $request->student_id,
                'exam_id' => $exam->id,
                'result_id' => $result->id
            ]);
        }

        \Log::info('Manual result entry completed successfully', [
            'exam_id' => $exam->id,
            'student_id' => $request->student_id,
            'result_id' => $result->id,
            'score' => $totalScore,
            'percentage' => round($percentage, 2),
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'unanswered' => $unanswered
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Detailed result created successfully',
            'result' => $result,
            'redirect_url' => route('partner.exams.results', $exam)
        ]);
    }

    /**
     * Show the edit result form
     */
    public function editResult(Exam $exam, ExamResult $result)
    {
        // Ensure the authenticated user is a partner
        if (!auth()->user() || auth()->user()->role !== 'partner') {
            abort(403, 'Only partners can edit results.');
        }

        // Verify the exam belongs to this partner
        $partnerId = $this->getPartnerId();
        if ($exam->partner_id !== $partnerId) {
            abort(403, 'Unauthorized access to this exam.');
        }

        // Verify the result belongs to this exam
        if ($result->exam_id !== $exam->id) {
            abort(404, 'Result not found for this exam.');
        }

        // Only allow editing manual results
        if ($result->result_type !== 'manual') {
            abort(403, 'Only manual results can be edited.');
        }

        // Load exam with questions
        $exam->load([
            'questions' => function($query) {
                $query->orderBy('exam_questions.order', 'asc');
            }
        ]);

        // Load the result with student
        $result->load('student');

        return view('partner.exams.result-edit', compact('exam', 'result'));
    }

    /**
     * Update the manual result
     */
    public function updateResult(Request $request, Exam $exam, ExamResult $result)
    {
        // Ensure the authenticated user is a partner
        if (!auth()->user() || auth()->user()->role !== 'partner') {
            return response()->json(['error' => 'Only partners can update results.'], 403);
        }

        // Verify the exam belongs to this partner
        $partnerId = $this->getPartnerId();
        if ($exam->partner_id !== $partnerId) {
            return response()->json(['error' => 'Unauthorized access to this exam.'], 403);
        }

        // Verify the result belongs to this exam
        if ($result->exam_id !== $exam->id) {
            return response()->json(['error' => 'Result not found for this exam.'], 404);
        }

        // Only allow updating manual results
        if ($result->result_type !== 'manual') {
            return response()->json(['error' => 'Only manual results can be updated.'], 403);
        }

        // Debug: Log incoming request data
        \Log::info('UpdateResult request received', [
            'exam_id' => $exam->id,
            'result_id' => $result->id,
            'answers_count' => count($request->answers ?? []),
            'started_at' => $request->started_at,
            'completed_at' => $request->completed_at,
            'answers' => $request->answers
        ]);

        // Validate the request
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'nullable|string',
            'started_at' => 'nullable|date',
            'completed_at' => 'nullable|date|after_or_equal:started_at',
        ]);

        // Load exam questions
        $questions = $exam->questions()->orderBy('exam_questions.order')->get();
        $answers = $request->answers;
        
        // Calculate results
        $correctAnswers = 0;
        $wrongAnswers = 0;
        $unanswered = 0;
        $totalScore = 0;
        $detailedAnswers = [];

        foreach ($questions as $question) {
            $questionAnswer = $answers[$question->id] ?? null;
            $isCorrect = false;
            $isAnswered = false;
            $score = 0;

            if ($questionAnswer !== null && $questionAnswer !== '') {
                $isAnswered = true;
                
                if ($question->question_type === 'mcq') {
                    // Convert form answer to lowercase for comparison
                    $isCorrect = strtolower($questionAnswer) === strtolower($question->correct_answer);
                } else {
                    // For descriptive questions, check if it meets minimum requirements
                    $wordCount = str_word_count($questionAnswer);
                    $minWords = $question->min_words ?? 10;
                    $isCorrect = $wordCount >= $minWords;
                }
                
                if ($isCorrect) {
                    $correctAnswers++;
                    $score = $question->pivot->marks ?? 1;
                    $totalScore += $score;
                } else {
                    $wrongAnswers++;
                }
            } else {
                $unanswered++;
            }

            $detailedAnswers[$question->id] = [
                'answer' => $questionAnswer,
                'is_correct' => $isCorrect,
                'is_answered' => $isAnswered,
                'score' => $score,
                'time_spent' => null, // Manual entry doesn't track time per question
            ];
        }

        // Calculate percentage
        $totalMarks = $questions->sum(function($q) { return $q->pivot->marks ?? 1; });
        $percentage = $totalMarks > 0 ? ($totalScore / $totalMarks) * 100 : 0;

        // Update the result
        $updateData = [
            'started_at' => $request->started_at ? \Carbon\Carbon::parse($request->started_at) : $result->started_at,
            'completed_at' => $request->completed_at ? \Carbon\Carbon::parse($request->completed_at) : $result->completed_at,
            'total_questions' => $questions->count(),
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'unanswered' => $unanswered,
            'score' => $totalScore,
            'percentage' => round($percentage, 2),
            'answers' => $detailedAnswers,
        ];
        
        \Log::info('Updating result with data', [
            'result_id' => $result->id,
            'update_data' => $updateData
        ]);
        
        $updateResult = $result->update($updateData);
        
        \Log::info('Result update result', [
            'result_id' => $result->id,
            'update_success' => $updateResult,
            'updated_result' => $result->fresh()
        ]);

        // Delete existing question statistics and create new ones
        $result->questionStats()->delete();

        // Create question statistics records (same as quiz submission)
        foreach ($questions as $question) {
            $questionAnswer = $answers[$question->id] ?? null;
            $isAnswered = !empty($questionAnswer);
            $isCorrect = false;
            $isSkipped = false;
            $answerMetadata = null;

            if ($questionAnswer === null || $questionAnswer === '') {
                $isSkipped = true;
            } else {
                if ($question->question_type === 'mcq') {
                    // Convert form answer to lowercase for comparison
                    $isCorrect = strtolower($questionAnswer) === strtolower($question->correct_answer);
                } else {
                    // For descriptive questions, give partial marks based on word count
                    $wordCount = str_word_count($questionAnswer);
                    $minWords = $question->min_words ?? 10;
                    $maxWords = $question->max_words ?? 100;
                    
                    $answerMetadata = [
                        'word_count' => $wordCount,
                        'min_words_required' => $minWords,
                        'max_words_expected' => $maxWords,
                    ];
                    
                    $isCorrect = $wordCount >= $minWords;
                }
            }

            // Record individual question statistics
            \App\Models\QuestionStat::create([
                'question_id' => $question->id,
                'exam_id' => $exam->id,
                'student_id' => $result->student_id,
                'exam_result_id' => $result->id,
                'student_answer' => $questionAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
                'is_answered' => $isAnswered,
                'is_skipped' => $isSkipped,
                'question_order' => $question->pivot->order ?? 0,
                'marks' => $question->pivot->marks ?? 1,
                'question_type' => $question->question_type,
                'answer_metadata' => $answerMetadata,
                'question_answered_at' => $request->completed_at ? \Carbon\Carbon::parse($request->completed_at) : $result->completed_at,
            ]);
        }

        \Log::info('Manual result updated successfully', [
            'exam_id' => $exam->id,
            'student_id' => $result->student_id,
            'result_id' => $result->id,
            'score' => $totalScore,
            'percentage' => round($percentage, 2),
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'unanswered' => $unanswered
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Result updated successfully',
            'result' => $result,
            'redirect_url' => route('partner.exams.results', $exam)
        ]);
    }

    public function export(Exam $exam)
    {
        // Get exam questions with their details - order by the pivot table's order column
        $questions = $exam->questions()
            ->with(['topic', 'subject'])
            ->orderBy('exam_questions.order')
            ->get();
        
        // Generate HTML content for the question paper
        $html = $this->generateQuestionPaperHTML($exam, $questions);
        
        // Generate filename
        $filename = 'question_paper_' . $exam->id . '_' . date('Y-m-d_H-i-s') . '.html';
        
        // Return response with HTML content for download
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
    
    public function paperParameters(Exam $exam)
    {
        // Get exam questions for display purposes
        $questions = $exam->questions()->with(['topic', 'subject'])->get();
        
        return view('partner.exams.paper-question-parameter', compact('exam', 'questions'));
    }
    
    public function downloadPaper(Request $request, Exam $exam)
    {
        try {
            // Validate the request
            $request->validate([
                'preview_html' => 'required|string',
                'parameters' => 'required|array',
                'parameters.paper_size' => 'required|in:A4,Letter,Legal,A3',
                'parameters.orientation' => 'required|in:portrait,landscape',
                'parameters.paper_columns' => 'required|in:1,2,3',
                'parameters.header_span' => 'required|in:1,2,3,4,full',
                'parameters.font_family' => 'required|string',
                'parameters.font_size' => 'required|integer|min:8|max:20',
                'parameters.line_spacing' => 'required|numeric|min:0.5|max:3.0',
                'parameters.mcq_columns' => 'required|in:1,2,3,4',
                'parameters.margin_top' => 'required|integer|min:10|max:50',
                'parameters.margin_bottom' => 'required|integer|min:10|max:50',
                'parameters.margin_left' => 'required|integer|min:10|max:50',
                'parameters.margin_right' => 'required|integer|min:10|max:50',
                'parameters.include_header' => 'boolean',
                'parameters.mark_answer' => 'boolean',
            ]);
            
            $parameters = $request->input('parameters');
            $previewHtml = $request->input('preview_html');
            
            // Validate PDF parameters
            $this->validatePDFParameters($parameters);
            
            // Debug: Log the HTML structure
            \Log::info('PDF Generation Debug', [
                'html_length' => strlen($previewHtml),
                'page_containers_count' => substr_count($previewHtml, 'class="page-container"'),
                'page_break_always_count' => substr_count($previewHtml, 'page-break-after: always'),
                'page_break_avoid_count' => substr_count($previewHtml, 'page-break-after: avoid'),
                'break_after_page_count' => substr_count($previewHtml, 'break-after: page'),
                'break_after_avoid_count' => substr_count($previewHtml, 'break-after: avoid'),
                'page_break_inside_avoid_count' => substr_count($previewHtml, 'page-break-inside: avoid'),
                'break_inside_avoid_count' => substr_count($previewHtml, 'break-inside: avoid'),
            ]);
            
            // Generate PDF using Browsershot with exact preview HTML
            $pdf = $this->generatePDFWithBrowsershot($previewHtml, $parameters);
            
            // Generate filename
            $filename = 'question_paper_' . $exam->id . '_' . date('Y-m-d_H-i-s') . '.pdf';
            
            // Return PDF response
            return response($pdf, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage(), [
                'exam_id' => $exam->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'PDF generation failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    private function generateQuestionPaperHTML($exam, $questions)
    {
        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Paper - ' . htmlspecialchars($exam->title) . '</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
        .exam-title { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
        .exam-info { font-size: 14px; color: #666; }
        .instructions { background: #f5f5f5; padding: 20px; border-radius: 5px; margin-bottom: 30px; }
        .question { margin-bottom: 25px; page-break-inside: avoid; }
        .question-number { font-weight: bold; color: #333; }
        .question-text { margin: 5px 0; }
        .question-header { margin: 5px 0; font-style: italic; color: #666; }
        .options { margin-left: 20px; }
        .option { margin: 5px 0; }
        .marks { font-weight: bold; color: #333; float: right; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #666; border-top: 1px solid #ccc; padding-top: 20px; }
        @media print { body { margin: 20px; } .question { page-break-inside: avoid; } }
    </style>
</head>
<body>
    <div class="header">
        <div class="exam-title">' . htmlspecialchars($exam->title) . '</div>
        <div class="exam-info">
            <strong>Exam ID:</strong> ' . $exam->id . ' | 
            <strong>Duration:</strong> ' . $exam->duration . ' minutes | 
            <strong>Total Questions:</strong> ' . $exam->total_questions . ' | 
            <strong>Passing Marks:</strong> ' . $exam->passing_marks . '% | 
            <strong>Total Marks:</strong> ' . $questions->sum(function($q) { return $q->pivot->marks ?? 1; }) . '
        </div>';
        
        if ($exam->question_header) {
            $html .= '<div class="question-header" style="margin-top: 15px; padding: 15px; background: #f9f9f9; border-radius: 5px;">' . $exam->question_header . '</div>';
        }
        
        $html .= '</div>
    
    <div class="instructions">
        <strong>Instructions:</strong>
        <ul>
            <li>Read each question carefully before answering</li>
            <li>All questions are compulsory</li>
            <li>Write your answers clearly and legibly</li>
            <li>Check your answers before submitting</li>
        </ul>
    </div>';
        
        foreach ($questions as $index => $question) {
            $questionNumber = $index + 1;
            $marks = $question->pivot->marks ?? 1;
            
            $html .= '
    <div class="question">
        <div class="question-number">
            Question ' . $questionNumber . ' <span class="marks">[' . $marks . ' mark' . ($marks > 1 ? 's' : '') . ']</span>
        </div>';
            
            if ($question->question_header) {
                $html .= '<div class="question-header">' . htmlspecialchars($question->question_header) . '</div>';
            }
            
            $html .= '<div class="question-text">' . htmlspecialchars($question->question_text) . '</div>';
            
            if ($question->question_type === 'mcq') {
                $html .= '<div class="options">';
                if ($question->option_a) $html .= '<div class="option">A) ' . htmlspecialchars($question->option_a) . '</div>';
                if ($question->option_b) $html .= '<div class="option">B) ' . htmlspecialchars($question->option_b) . '</div>';
                if ($question->option_c) $html .= '<div class="option">C) ' . htmlspecialchars($question->option_c) . '</div>';
                if ($question->option_d) $html .= '<div class="option">D) ' . htmlspecialchars($question->option_d) . '</div>';
                $html .= '</div>';
            }
            
            $html .= '</div>';
        }
        
        $html .= '
    <div class="footer">
        <p>Generated on: ' . date('F d, Y \a\t g:i A') . '</p>
        <p>Total Questions: ' . $questions->count() . ' | Total Marks: ' . $questions->sum(function($q) { return $q->pivot->marks ?? 1; }) . '</p>
    </div>
</body>
</html>';
        
        return $html;
    }

    public function assignQuestions(Exam $exam, Request $request)
    {
        $partnerId = $this->getPartnerId();
        
        // Eager load relationships for the initial page load
        $questionsQuery = \App\Models\Question::query()
            ->where('partner_id', $partnerId)
            ->where('status', 'active')
            ->with('course', 'subject', 'topic', 'questionType')
            ->whereHas('course', function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId)
                      ->where('status', 'active')
                      ->where(function($q) {
                          $q->whereNull('start_date')
                            ->orWhere('start_date', '<=', now())
                            ->orWhere('end_date', '>=', now());
                      });
            });

        // Apply filters based on the request
        if ($request->filled('search')) {
            $search = $request->input('search');
            $questionsQuery->where(function ($query) use ($search) {
                $query->where('question_text', 'like', "%{$search}%")
                      ->orWhere('option_a', 'like', "%{$search}%")
                      ->orWhere('option_b', 'like', "%{$search}%")
                      ->orWhere('option_c', 'like', "%{$search}%")
                      ->orWhere('option_d', 'like', "%{$search}%")
                      ->orWhere('explanation', 'like', "%{$search}%")
                      ->orWhereHas('course', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      })
                      ->orWhereHas('subject', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      })
                      ->orWhereHas('topic', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            });
        }

        if ($request->filled('course_filter')) {
            $questionsQuery->where('course_id', $request->input('course_filter'));
        }

        if ($request->filled('subject_filter')) {
            $questionsQuery->where('subject_id', $request->input('subject_filter'));
        }

        if ($request->filled('topic_filter')) {
            $questionsQuery->where('topic_id', $request->input('topic_filter'));
        }

        if ($request->filled('question_type_filter')) {
            $questionsQuery->where('question_type', $request->input('question_type_filter'));
        }

        if ($request->filled('date_filter')) {
            $questionsQuery->whereDate('created_at', $request->input('date_filter'));
        }
        
        // Sort questions by drag and drop order if present
        $assignedQuestionsWithOrder = $exam->questions->pluck('pivot.order', 'id')->toArray();
        
        $questions = $questionsQuery->get();
        
        // Check if the request is an AJAX call from the "search as you go" logic
        if ($request->ajax()) {
            return view('partner.exams.partials.questions-grid', [
                'questions' => $questions,
                'assignedQuestions' => $exam->questions->pluck('id'),
                'assignedQuestionsWithMarks' => $exam->questions->pluck('pivot.marks', 'id'),
                'assignedQuestionsWithOrder' => $assignedQuestionsWithOrder,
            ])->render();
        }
        
        // For the initial page load, return the full view
        return view('partner.exams.assign-questions', [
            'exam' => $exam,
            'questions' => $questions,
            'assignedQuestions' => $exam->questions->pluck('id'),
            'assignedQuestionsWithMarks' => $exam->questions->pluck('pivot.marks', 'id'),
            'assignedQuestionsWithOrder' => $assignedQuestionsWithOrder,
            'courses' => \App\Models\Course::where('partner_id', $partnerId)->where('status', 'active')->get(),
            'subjects' => \App\Models\Subject::where('partner_id', $partnerId)->where('status', 'active')->get(),
            'topics' => \App\Models\Topic::where('partner_id', $partnerId)->where('status', 'active')->get(),
            'questionTypes' => \App\Models\Question::where('partner_id', $partnerId)
                ->where('status', 'active')
                ->select('question_type')
                ->distinct()
                ->pluck('question_type')
                ->map(function($type) {
                    return [
                        'value' => $type,
                        'label' => match($type) {
                            'mcq' => 'MCQ',
                            'descriptive' => 'Descriptive',
                            'true_false' => 'True/False',
                            'fill_in_blank' => 'Fill in the Blanks',
                            default => ucfirst(str_replace('_', ' ', $type))
                        }
                    ];
                }),
            'availableDates' => \App\Models\Question::where('partner_id', $partnerId)
                ->where('status', 'active')
                ->selectRaw('DATE(created_at) as date')
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->get()
                ->map(function($question) {
                    $date = \Carbon\Carbon::parse($question->date);
                    return [
                        'value' => $date->format('Y-m-d'),
                        'label' => $date->format('d-M-Y')
                    ];
                }),
        ]);
    }

    public function storeAssignedQuestions(Request $request, Exam $exam)
    {
        try {
            // Debug: Log the request data
            \Log::info('Assign Questions Request', [
                'exam_id' => $exam->id,
                'request_data' => $request->all(),
                'question_ids' => $request->question_ids
            ]);

            $request->validate([
                'question_ids' => 'nullable|array',
                'question_ids.*' => 'exists:questions,id',
                'question_marks' => 'nullable|array',
                'question_marks.*' => 'integer|min:1|max:100',
                'question_numbers' => 'array',
                'question_numbers.*' => 'nullable|integer|min:1|max:999'
            ]);

            $partnerId = $this->getPartnerId();
            
            // Verify the exam belongs to this partner
            if ($exam->partner_id !== $partnerId) {
                abort(403, 'Unauthorized access to this exam.');
            }

            // Clear existing assigned questions for this exam
            $deletedCount = \App\Models\ExamQuestion::where('exam_id', $exam->id)->delete();
            \Log::info('Deleted existing exam questions', ['deleted_count' => $deletedCount]);

            // Store new assigned questions
            $questionIds = $request->has('question_ids') && is_array($request->question_ids) 
                ? array_filter($request->question_ids) // Remove empty values
                : [];
            $questionMarks = $request->has('question_marks') && is_array($request->question_marks) 
                ? $request->question_marks 
                : [];
            $questionNumbers = $request->has('question_numbers') && is_array($request->question_numbers) 
                ? $request->question_numbers 
                : [];
            $examQuestions = [];
            
            // If no questions are selected, we just clear all questions (already done above)
            if (empty($questionIds)) {
                \Log::info('No questions selected - all questions removed from exam', ['exam_id' => $exam->id]);
            } else {
                foreach ($questionIds as $index => $questionId) {
                    $question = \App\Models\Question::find($questionId);
                    $marks = isset($questionMarks[$questionId]) ? (int)$questionMarks[$questionId] : 1;
                    
                    // Only use question number if it's not empty, otherwise use sequential order
                    $order = $index + 1;
                    if (isset($questionNumbers[$questionId]) && !empty($questionNumbers[$questionId])) {
                        $order = (int)$questionNumbers[$questionId];
                    }
                    
                    $examQuestions[] = [
                        'exam_id' => $exam->id,
                        'question_id' => $questionId,
                        'order' => $order,
                        'marks' => $marks,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Debug: Log the exam questions to be inserted
                \Log::info('Exam Questions to Insert', [
                    'exam_id' => $exam->id,
                    'exam_questions' => $examQuestions
                ]);

                // Insert all exam questions
                if (!empty($examQuestions)) {
                    \App\Models\ExamQuestion::insert($examQuestions);
                    $insertedCount = count($examQuestions);
                    \Log::info('Inserted exam questions', ['inserted_count' => $insertedCount]);
                }
            }

            // Validate that assigned questions don't exceed the exam's total_questions limit
            $assignedCount = count($questionIds);
            if ($assignedCount > $exam->total_questions) {
                \Log::warning('Assigned questions exceed exam limit', [
                    'exam_id' => $exam->id,
                    'assigned_count' => $assignedCount,
                    'total_questions_limit' => $exam->total_questions
                ]);
                
                return redirect()->back()
                    ->with('error', "Cannot assign {$assignedCount} questions. Exam limit is {$exam->total_questions} questions.")
                    ->withInput();
            }
            
            \Log::info('Questions assigned successfully', [
                'exam_id' => $exam->id,
                'assigned_count' => $assignedCount,
                'total_questions_limit' => $exam->total_questions
            ]);

            $successMessage = $assignedCount > 0 
                ? 'Questions assigned successfully to the exam.'
                : 'All questions have been removed from the exam.';

            return redirect()->route('partner.exams.show', $exam)
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            \Log::error('Error assigning questions to exam', [
                'exam_id' => $exam->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Error assigning questions: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function debug(Exam $exam)
    {
        $partnerId = $this->getPartnerId();
        
        // Debug information
        $debugInfo = [
            'exam_id' => $exam->id,
            'current_status' => $exam->status,
            'partner_id' => $partnerId,
            'exam_partner_id' => $exam->partner_id,
            'fillable_fields' => $exam->getFillable(),
            'table_name' => $exam->getTable(),
            'connection' => $exam->getConnectionName(),
        ];
        
        // Check if status field exists in database
        try {
            $columns = \Schema::getColumnListing($exam->getTable());
            $debugInfo['database_columns'] = $columns;
            $debugInfo['status_column_exists'] = in_array('status', $columns);
        } catch (\Exception $e) {
            $debugInfo['database_error'] = $e->getMessage();
        }
        
        return response()->json($debugInfo);
    }

    private function getPartnerId(): int
    {
        $userId = auth()->id();
        if (!$userId) {
            throw new \Exception('User not authenticated.');
        }
        
        $user = auth()->user();
        if (!$user) {
            throw new \Exception('User not found.');
        }
        
        // Get the partner for this specific user - no fallback to other partners
        $partner = $user->partner;
        if (!$partner) {
            throw new \Exception('Partner profile not found for user ID: ' . $userId . '. Please contact administrator.');
        }
        
        return (int) $partner->id;
    }
    
    private function generateQuestionPaperHTMLWithParameters($exam, $questions, $parameters)
    {
        // Get column configuration
        $paperColumns = (int)($parameters['paper_columns'] ?? 1);
        $headerSpan = $parameters['header_span'] ?? '1';
        $mcqColumns = (int)($parameters['mcq_columns'] ?? 4);
        
        // Calculate header grid column span based on paper columns
        if ($headerSpan === 'full') {
            $headerGridSpan = '1 / -1'; // Span full width
        } else {
            $spanValue = (int)$headerSpan;
            
            if ($spanValue >= $paperColumns) {
                // If header span is >= paper columns, span across all columns
                $headerGridSpan = "1 / " . ($paperColumns + 1);
            } else {
                // If header span is < paper columns, span across specified columns
                $headerGridSpan = "1 / " . ($spanValue + 1);
            }
        }
        
        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Paper - ' . htmlspecialchars($exam->title) . '</title>
    <style>
        @page {
            size: ' . $parameters['paper_size'] . ' ' . $parameters['orientation'] . ';
            margin: ' . $parameters['margin_top'] . 'mm ' . $parameters['margin_right'] . 'mm ' . $parameters['margin_bottom'] . 'mm ' . $parameters['margin_left'] . 'mm;
        }
        body { 
            font-family: "' . $parameters['font_family'] . '", Arial, sans-serif; 
            margin: 0; 
            line-height: ' . $parameters['line_spacing'] . '; 
            font-size: ' . $parameters['font_size'] . 'pt;
        }
        
        /* Paper Column Layout */
        .paper-container {
            display: grid;
            gap: 20px;
            padding: 20px;
        }
        
        .paper-container.paper-columns-1 {
            grid-template-columns: 1fr;
        }
        
        .paper-container.paper-columns-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            padding: 15px;
        }
        
        .paper-container.paper-columns-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            padding: 15px;
        }
        
        /* Header Span */
        .header-container {
            grid-column: ' . $headerGridSpan . ';
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .exam-title { font-size: ' . ($parameters['font_size'] + 8) . 'pt; font-weight: bold; margin-bottom: 10px; }
        .exam-info { font-size: ' . ($parameters['font_size'] - 2) . 'pt; color: #666; }
        .instructions { background: #f5f5f5; padding: 20px; border-radius: 5px; margin-bottom: 30px; }
        .question { margin-bottom: 10px; page-break-inside: avoid; break-inside: avoid; }
        .question-number { font-weight: bold; color: #333; }
        .question-text { margin: 5px 0; }
        .question-header { margin: 5px 0; font-style: italic; color: #666; }
        .options { margin-left: 20px; }
        .option { margin: 5px 0; }
        .marks { font-weight: bold; color: #333; float: right; }
        .footer { margin-top: 40px; text-align: center; font-size: ' . ($parameters['font_size'] - 2) . 'pt; color: #666; border-top: 1px solid #ccc; padding-top: 20px; }
        
        /* MCQ Options Grid */
        .mcq-options {
            display: grid;
            gap: 10px;
            margin: 5px 0;
        }
        
        .mcq-options.columns-1 { grid-template-columns: 1fr; }
        .mcq-options.columns-2 { grid-template-columns: 1fr 1fr; }
        .mcq-options.columns-3 { grid-template-columns: 1fr 1fr 1fr; }
        .mcq-options.columns-4 { grid-template-columns: 1fr 1fr 1fr 1fr; }
        
        @media print { 
            body { margin: 0; } 
            .question { page-break-inside: avoid; break-inside: avoid; } 
        }
    </style>
</head>
<body>
            <div class="paper-container paper-columns-' . $paperColumns . '" data-header-span="' . $headerSpan . '">
        <div class="header-container">';
        
        if ($parameters['include_header'] ?? true) {
            $html .= '
        <div class="exam-title">' . htmlspecialchars($exam->title) . '</div>';
            
            // Always include full marks and time when header is enabled
            $html .= '
        <div class="exam-info">
            <strong>Exam ID:</strong> ' . $exam->id . ' | 
            <strong>Duration:</strong> ' . $exam->duration . ' minutes | 
            <strong>Total Questions:</strong> ' . $exam->total_questions . ' | 
            <strong>Passing Marks:</strong> ' . $exam->passing_marks . '% | 
            <strong>Total Marks:</strong> ' . $questions->sum(function($q) { return $q->pivot->marks ?? 1; }) . '
        </div>';
            
            if ($exam->question_header && ($parameters['include_question_headers'] ?? true)) {
                $html .= '<div class="question-header" style="margin-top: 15px; padding: 15px; background: #f9f9f9; border-radius: 5px;">' . $exam->question_header . '</div>';
            }
        }
        
        $html .= '</div>';
        
        if ($parameters['include_instructions'] ?? true) {
            $html .= '
    <div class="instructions">
        <strong>Instructions:</strong>
        <ul>
            <li>Read each question carefully before answering</li>
            <li>All questions are compulsory</li>
            <li>Write your answers clearly and legibly</li>
            <li>Check your answers before submitting</li>
        </ul>
    </div>';
        }
        
        // Add questions sequentially - CSS Grid will handle the distribution
        foreach ($questions as $index => $question) {
            $questionNumber = $index + 1;
            $marks = $question->pivot->marks ?? 1;
            
            $html .= $this->generateQuestionHTML($question, $questionNumber, $marks, $parameters, $mcqColumns);
        }
        
        if ($parameters['include_footer'] ?? true) {
            $html .= '
    <div class="footer">
        <p>Generated on: ' . date('F d, Y \a\t g:i A') . '</p>
        <p>Total Questions: ' . $questions->count() . ' | Total Marks: ' . $questions->sum(function($q) { return $q->pivot->marks ?? 1; }) . '</p>
    </div>';
        }
        
        $html .= '
    </div>
</body>
</html>';
        
        return $html;
    }
    
    /**
     * Generate HTML for a single question
     */
    private function generateQuestionHTML($question, $questionNumber, $marks, $parameters, $mcqColumns)
    {
        $html = '
    <div class="question">
        <div class="question-number">
            Question ' . $questionNumber . ' <span class="marks">[' . $marks . ' mark' . ($marks > 1 ? 's' : '') . ']</span>
        </div>';
        
        if ($question->question_header && ($parameters['include_question_headers'] ?? true)) {
            $html .= '<div class="question-header">' . htmlspecialchars($question->question_header) . '</div>';
        }
        
        $html .= '<div class="question-text">' . htmlspecialchars($question->question_text) . '</div>';
        
        if ($question->question_type === 'mcq') {
            $html .= '<div class="mcq-options columns-' . $mcqColumns . '">';
            
            $options = [
                'A' => $question->option_a,
                'B' => $question->option_b,
                'C' => $question->option_c,
                'D' => $question->option_d
            ];
            
            foreach ($options as $label => $text) {
                if ($text) {
                    $isCorrect = false;
                    if ($parameters['mark_answer'] ?? false) {
                        // Check if this is the correct answer
                        if ($question->correct_answer) {
                            if (is_numeric($question->correct_answer)) {
                                // If correct_answer is numeric (1,2,3,4), convert to letter
                                $answerMap = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D'];
                                $isCorrect = $label === $answerMap[$question->correct_answer];
                            } else {
                                // If correct_answer is string (A,B,C,D)
                                $isCorrect = strtoupper($question->correct_answer) === $label;
                            }
                        }
                    }
                    
                    $optionStyle = $isCorrect ? ' style="background-color: #e8f5e8; border-left: 4px solid #28a745; padding-left: 10px;"' : '';
                    $correctIndicator = $isCorrect ? ' <strong style="color: #28a745;">✓</strong>' : '';
                    
                    $html .= '<div class="option"' . $optionStyle . '>' . $label . ') ' . htmlspecialchars($text) . $correctIndicator . '</div>';
                }
            }
            
            $html .= '</div>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * Validate PDF generation parameters
     */
    private function validatePDFParameters($parameters)
    {
        $validPaperSizes = ['A4', 'Letter', 'Legal', 'A3'];
        $validOrientations = ['portrait', 'landscape'];
        
        if (!in_array($parameters['paper_size'], $validPaperSizes)) {
            throw new \InvalidArgumentException('Invalid paper size: ' . $parameters['paper_size']);
        }
        
        if (!in_array($parameters['orientation'], $validOrientations)) {
            throw new \InvalidArgumentException('Invalid orientation: ' . $parameters['orientation']);
        }
        
        // Validate margins
        $margins = ['margin_top', 'margin_bottom', 'margin_left', 'margin_right'];
        foreach ($margins as $margin) {
            if (!isset($parameters[$margin]) || !is_numeric($parameters[$margin]) || $parameters[$margin] < 10 || $parameters[$margin] > 50) {
                throw new \InvalidArgumentException('Invalid margin value for ' . $margin . ': ' . ($parameters[$margin] ?? 'not set'));
            }
        }
    }
    
    /**
     * Generate PDF using Browsershot with exact preview HTML
     */
    private function generatePDFWithBrowsershot($html, $parameters)
    {
        try {
            // Create Browsershot instance
            $browsershot = \Spatie\Browsershot\Browsershot::html($html);
            
            // Configure paper size and orientation
            $paperSize = $parameters['paper_size'] ?? 'A4';
            $orientation = $parameters['orientation'] ?? 'portrait';
            
            // Set paper format with exact parameters
            $browsershot->format($paperSize)
                       ->landscape($orientation === 'landscape')
                       ->margins(
                           (int)($parameters['margin_top'] ?? 20),
                           (int)($parameters['margin_right'] ?? 20),
                           (int)($parameters['margin_bottom'] ?? 20),
                           (int)($parameters['margin_left'] ?? 20),
                           'mm'
                       );
            
            // Log the exact parameters being used
            \Log::info('Browsershot Parameters', [
                'paper_size' => $paperSize,
                'orientation' => $orientation,
                'margins' => [
                    'top' => $parameters['margin_top'] ?? 20,
                    'right' => $parameters['margin_right'] ?? 20,
                    'bottom' => $parameters['margin_bottom'] ?? 20,
                    'left' => $parameters['margin_left'] ?? 20,
                ],
                'font_family' => $parameters['font_family'] ?? 'Arial',
                'font_size' => $parameters['font_size'] ?? 12,
                'line_spacing' => $parameters['line_spacing'] ?? 1.5,
            ]);
            
            // Enhanced Browsershot configuration for pixel-perfect PDF generation
            $browsershot->timeout(120) // 2 minutes timeout
                       ->setOption('printBackground', true) // Include background colors and images
                       ->setOption('preferCSSPageSize', true) // Use CSS @page rules
                       ->setOption('displayHeaderFooter', false) // No header/footer
                       ->setOption('scale', 1.0) // No scaling
                       ->setOption('dpi', 300) // High DPI for crisp text
                       ->setOption('width', 1200) // High resolution for pixel-perfect rendering
                       ->setOption('height', 1600) // High resolution for pixel-perfect rendering
                       ->setOption('deviceScaleFactor', 2) // Retina quality
                       ->emulateMedia('print') // Use print media queries
                       ->addChromiumArguments([
                           '--no-sandbox',
                           '--disable-gpu',
                           '--disable-dev-shm-usage',
                           '--disable-extensions',
                           '--disable-plugins',
                           '--disable-images', // Disable images for faster rendering
                           '--disable-javascript', // Disable JS for consistent rendering
                           '--run-all-compositor-stages-before-draw',
                           '--disable-background-timer-throttling',
                           '--disable-backgrounding-occluded-windows',
                           '--disable-renderer-backgrounding',
                           '--disable-features=TranslateUI',
                           '--disable-ipc-flooding-protection',
                           '--font-render-hinting=none',
                           '--disable-font-subpixel-positioning',
                           '--disable-web-security', // Disable web security for consistent rendering
                           '--disable-features=VizDisplayCompositor', // Disable display compositor
                           '--force-device-scale-factor=2', // Force high DPI rendering
                           '--high-dpi-support=1', // Enable high DPI support
                           '--force-color-profile=srgb', // Force sRGB color profile
                           '--disable-features=TranslateUI,BlinkGenPropertyTrees', // Disable unnecessary features
                           '--enable-font-antialiasing', // Enable font antialiasing
                           '--disable-features=VizDisplayCompositor,TranslateUI' // Additional optimizations
                       ]);
            
            // Generate PDF
            $pdf = $browsershot->pdf();
            
            return $pdf;
            
        } catch (\Exception $e) {
            \Log::error('Browsershot PDF Generation Error: ' . $e->getMessage(), [
                'parameters' => $parameters,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw new \Exception('PDF generation failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Test PDF generation with various configurations
     */
    public function testPDFGeneration(Request $request, Exam $exam)
    {
        if (!config('app.debug')) {
            return response()->json(['error' => 'Test endpoint only available in debug mode'], 403);
        }
        
        $testResults = [];
        $paperSizes = ['A4', 'Letter', 'Legal'];
        $orientations = ['portrait', 'landscape'];
        
        foreach ($paperSizes as $paperSize) {
            foreach ($orientations as $orientation) {
                try {
                    $startTime = microtime(true);
                    
                    // Generate test HTML
                    $testHtml = $this->generateTestHTML($exam, $paperSize, $orientation);
                    
                    // Generate PDF
                    $parameters = [
                        'paper_size' => $paperSize,
                        'orientation' => $orientation,
                        'margin_top' => 20,
                        'margin_bottom' => 20,
                        'margin_left' => 20,
                        'margin_right' => 20,
                        'font_family' => 'Arial',
                        'font_size' => 12,
                        'line_spacing' => 1.5,
                        'paper_columns' => 1,
                        'header_span' => 'full',
                        'mcq_columns' => 2,
                        'include_header' => true,
                        'mark_answer' => false
                    ];
                    
                    $pdf = $this->generatePDFWithBrowsershot($testHtml, $parameters);
                    
                    $endTime = microtime(true);
                    $generationTime = round(($endTime - $startTime) * 1000, 2);
                    
                    $testResults[] = [
                        'paper_size' => $paperSize,
                        'orientation' => $orientation,
                        'status' => 'success',
                        'generation_time_ms' => $generationTime,
                        'pdf_size_bytes' => strlen($pdf)
                    ];
                    
                } catch (\Exception $e) {
                    $testResults[] = [
                        'paper_size' => $paperSize,
                        'orientation' => $orientation,
                        'status' => 'error',
                        'error' => $e->getMessage()
                    ];
                }
            }
        }
        
        $summary = [
            'total_tests' => count($testResults),
            'successful' => count(array_filter($testResults, fn($r) => $r['status'] === 'success')),
            'failed' => count(array_filter($testResults, fn($r) => $r['status'] === 'error'))
        ];
        
        return response()->json([
            'test_results' => $testResults,
            'summary' => $summary
        ]);
    }
    
    /**
     * Generate simple test HTML for PDF testing
     */
    private function generateTestHTML($exam, $paperSize, $orientation)
    {
        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test PDF - ' . $exam->title . '</title>
    <style>
        @page {
            size: ' . $paperSize . ' ' . $orientation . ';
            margin: 20mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .test-content {
            text-align: center;
            padding: 50px;
        }
        .test-title {
            font-size: 24pt;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .test-info {
            font-size: 14pt;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="test-content">
        <div class="test-title">PDF Generation Test</div>
        <div class="test-info">
            <p>Paper Size: ' . $paperSize . '</p>
            <p>Orientation: ' . $orientation . '</p>
            <p>Exam: ' . htmlspecialchars($exam->title) . '</p>
            <p>Generated: ' . date('Y-m-d H:i:s') . '</p>
        </div>
    </div>
</body>
</html>';
    }
    
    /**
     * Simple PDF test endpoint
     */
    public function simplePDFTest()
    {
        if (!config('app.debug')) {
            return response()->json(['error' => 'Test endpoint only available in debug mode'], 403);
        }
        
        try {
            $testHtml = '<!DOCTYPE html>
<html>
<head>
    <title>Simple PDF Test</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>PDF Generation Test</h1>
    <p>This is a simple test to verify Browsershot is working correctly.</p>
    <p>Generated at: ' . date('Y-m-d H:i:s') . '</p>
</body>
</html>';
            
            $parameters = [
                'paper_size' => 'A4',
                'orientation' => 'portrait',
                'margin_top' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
                'margin_right' => 20,
                'font_family' => 'Arial',
                'font_size' => 12,
                'line_spacing' => 1.5,
                'paper_columns' => 1,
                'header_span' => 'full',
                'mcq_columns' => 2,
                'include_header' => true,
                'mark_answer' => false
            ];
            
            $pdf = $this->generatePDFWithBrowsershot($testHtml, $parameters);
            
            return response()->json([
                'status' => 'success',
                'message' => 'PDF generation successful',
                'pdf_size_bytes' => strlen($pdf)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'PDF generation failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
