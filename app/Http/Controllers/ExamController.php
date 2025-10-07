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
use App\Services\ExamManagementService;
use App\Services\ExamQuestionManagementService;
use App\Services\PdfGeneratorService;
use App\Services\BulkSmsBdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\DTO\Exam\CreateExamDTO;
use App\DTO\Exam\UpdateExamDTO;
use App\DTO\Exam\AssignStudentsDTO;
use App\DTO\Exam\UpdateManualResultDTO;
use App\DTO\Exam\PaperParametersDTO;
use App\DTO\Exam\AssignQuestionsDTO;

class ExamController extends Controller
{
    protected $examManagementService;
    protected $examQuestionManagementService;
    protected $pdfGeneratorService;

    public function __construct(
        ExamManagementService $examManagementService,
        ExamQuestionManagementService $examQuestionManagementService,
        PdfGeneratorService $pdfGeneratorService
    )
    {
        $this->examManagementService = $examManagementService;
        $this->examQuestionManagementService = $examQuestionManagementService;
        $this->pdfGeneratorService = $pdfGeneratorService;
    }

    public function index(Request $request)
    {
        $partnerId = $this->getPartnerId();
        $filters = $request->only(['status', 'q']);

        $exams = $this->examManagementService->getExamsForPartner($partnerId, $filters);
        $counts = $this->examManagementService->getExamCounts($partnerId);

        return view('partner.exams.index', compact('exams', 'counts'));
    }

    public function create()
    {
        $partnerId = $this->getPartnerId();
        $courses = Course::where('partner_id', $partnerId)->get();
        $subjects = Subject::where('partner_id', $partnerId)->get();
        $questionTypes = QuestionType::all();
        $questionSets = QuestionSet::where('partner_id', $partnerId)->get();
        $topics = Topic::where('partner_id', $partnerId)->get();

        return view('partner.exams.create', compact('courses', 'subjects', 'questionTypes', 'questionSets', 'topics'));
    }

    public function store(CreateExamDTO $request)
    {
        $partnerId = $this->getPartnerId();
        $isDraft = $request->input('action') === 'save_draft';

        $validatedData = $request->validatedDTO();

        $exam = $this->examManagementService->createExam($validatedData, $partnerId, $isDraft);

        if ($isDraft) {
            return response()->json([
                'success' => true,
                'message' => 'Draft saved successfully!',
                'exam_id' => $exam->id,
                'exam_title' => $exam->title
            ]);
        } else {
            return redirect()->route('partner.exams.show', $exam->id)->with('success', 'Exam created successfully!');
        }
    }

    public function show(Exam $exam)
    {
        $partnerId = $this->getPartnerId();

        if ($exam->partner_id !== $partnerId) {
            abort(403);
        }

        $exam->load(['questions', 'assignedStudents', 'accessCodes']);

        return view('partner.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $partnerId = $this->getPartnerId();

        if ($exam->partner_id !== $partnerId) {
            abort(403);
        }

        $courses = Course::where('partner_id', $partnerId)->get();
        $subjects = Subject::where('partner_id', $partnerId)->get();
        $questionTypes = QuestionType::all();
        $questionSets = QuestionSet::where('partner_id', $partnerId)->get();
        $topics = Topic::where('partner_id', $partnerId)->get();
        $assignedQuestions = $this->examQuestionManagementService->getExamQuestions($exam);

        return view('partner.exams.edit', compact('exam', 'courses', 'subjects', 'questionTypes', 'questionSets', 'topics', 'assignedQuestions'));
    }

    public function update(UpdateExamDTO $request, Exam $exam)
    {
        $partnerId = $this->getPartnerId();

        if ($exam->partner_id !== $partnerId) {
            return response()->json(['error' => 'Unauthorized access to this exam.'], 403);
        }

        $isDraft = $request->input('action') === 'save_draft';

        $validatedData = $request->validatedDTO();

        $this->examManagementService->updateExam($exam, $validatedData, $isDraft);

        if ($isDraft) {
            return response()->json([
                'success' => true,
                'message' => 'Draft updated successfully!',
                'exam_id' => $exam->id,
                'exam_title' => $exam->title
            ]);
        } else {
            return back()->with('success', 'Exam updated successfully.');
        }
    }

    public function destroy(Exam $exam)
    {
        $partnerId = $this->getPartnerId();

        if ($exam->partner_id !== $partnerId) {
            abort(403);
        }

        try {
            $this->examManagementService->deleteExam($exam);
            return back()->with('success', 'Exam deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting exam: ' . $e->getMessage());
        }
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
        try {
            $this->examManagementService->publishExam($exam);
            return back()->with('success', 'Exam published successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error publishing exam: ' . $e->getMessage());
        }
    }

    public function unpublish(Exam $exam)
    {
        try {
            $this->examManagementService->unpublishExam($exam);
            return back()->with('success', 'Exam unpublished successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error unpublishing exam: ' . $e->getMessage());
        }
    }

    public function results(Exam $exam)
    {
        $partnerId = $this->getPartnerId();

        if ($exam->partner_id !== $partnerId) {
            abort(403);
        }

        $results = $this->examManagementService->getExamResults($exam);

        // Get simple counts for header chips
        $counts = [
            'all' => $results->count(),
            'taken' => $results->where('status', 'completed')->count(),
            'absent' => $results->where('status', 'absent')->count(),
            'passed' => $results->where('percentage', '>=', $exam->passing_marks)->count(),
            'failed' => $results->where('percentage', '<', $exam->passing_marks)->where('status', 'completed')->count(),
        ];
        
        return view('partner.exams.results', compact('exam', 'results', 'counts'));
    }

    public function showResult(Exam $exam, ExamResult $result)
    {
        $partnerId = $this->getPartnerId();

        if ($exam->partner_id !== $partnerId || $result->exam_id !== $exam->id) {
            abort(403);
        }
        
        $result->load(['student.batch', 'exam.questions' => function($query) use ($partnerId) {
            $query->where('partner_id', $partnerId)->orderBy('pivot_order');
        }, 'questionStats']);

        // Process questions and student answers for display
        $processedQuestions = $result->exam->questions->map(function ($question) use ($result) {
            $stat = $result->questionStats->where('question_id', $question->id)->first();
            
            // Ensure answers are strings for consistent comparison in the view
            $studentAnswer = $stat ? (string)($stat->answer_given ?? '') : '';
            $correctAnswer = (string)($question->correct_answer ?? '');
            
            $isCorrect = $stat ? $stat->is_correct : false;

            return array_merge($question->toArray(), [
                'student_answer' => $studentAnswer,
                'correct_answer' => $correctAnswer, // Add correct answer to processed data
                'is_correct' => $isCorrect,
                'marks_obtained' => $stat ? $stat->marks_obtained : 0,
            ]);
        });

        // Prepare analytics (e.g., number of correct/wrong/unanswered)
        $analytics = [
            'correct' => $result->correct_answers,
            'wrong' => $result->wrong_answers,
            'unanswered' => $result->unanswered,
            'total' => $result->total_questions,
        ];

        // Also include the student's answers in a separate array, keyed by question ID
        $studentAnswers = $result->questionStats->keyBy('question_id')->map(function ($stat) {
            $answerGiven = $stat->answer_given;
            // Ensure answer_given is a string, even if it was stored as an array (e.g., multi-select)
            if (is_array($answerGiven)) {
                $answerGiven = json_encode($answerGiven); // Convert array to JSON string
            }
            return [
                'answer_given' => (string)$answerGiven,
                'is_correct' => $stat->is_correct,
                'marks_obtained' => $stat->marks_obtained,
            ];
        })->toArray();

        $data = [
            'exam' => $exam->toArray(),
            'student' => $result->student->toArray(),
            'result' => [
                'id' => $result->id,
                'score' => $result->score,
                'percentage' => $result->percentage,
                'status' => $result->status,
                'started_at' => $result->started_at ? $result->started_at->format('Y-m-d H:i:s') : null,
                'completed_at' => $result->completed_at ? $result->completed_at->format('Y-m-d H:i:s') : null,
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

    public function updateResult(UpdateManualResultDTO $request, Exam $exam, ExamResult $result)
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

        try {
            $updatedResult = $this->examManagementService->updateManualResult(
                $exam,
                $result,
                $request->input('answers', []),
                $request->input('started_at'),
                $request->input('completed_at')
            );

            return response()->json(['success' => true, 'message' => 'Result updated successfully.', 'result' => $updatedResult]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update result: ' . $e->getMessage()], 500);
        }
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
            ->where('partner_id', $partnerId)
            ->with(['topic', 'subject'])
            ->orderBy('exam_questions.order')
            ->get();

        // Get the student's answers
        $studentAnswers = $result->answers ?? [];

        // Process each question with student's answer and result
        $processedQuestions = $questions->map(function ($question, $index) use ($studentAnswers, $result) {
            // Retrieve the student's answer for this specific question from the $studentAnswers array.
            // $studentAnswers now contains the raw answers from $result->answers which is already cast as array.
            $rawStudentAnswer = $studentAnswers[$question->id] ?? null;
            
            // If the raw answer is an array (e.g., for multi-select MCQs), convert it to a comma-separated string for display.
            $questionAnswer = is_array($rawStudentAnswer) ? implode(', ', $rawStudentAnswer) : (string)($rawStudentAnswer ?? '');

            // Ensure the correct_answer is also a string
            $rawCorrectAnswer = $question->correct_answer ?? null;
            $correctAnswer = is_array($rawCorrectAnswer) ? implode(', ', $rawCorrectAnswer) : (string)($rawCorrectAnswer ?? '');
            
            $isCorrect = false;
            $isSkipped = false;
            $score = 0;
            $timeTaken = null;

            // Determine if the answer is correct, wrong, or skipped
            if ($questionAnswer === '') {
                $isSkipped = true;
            } else {
                if ($question->question_type === 'mcq') {
                    // Convert form answer to lowercase for comparison
                    $isCorrect = strtolower($questionAnswer) === strtolower($correctAnswer);
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

            // Ensure options are an array for MCQ questions
            $options = null;
            if ($question->question_type === 'mcq' && !empty($question->options)) {
                if (is_string($question->options)) {
                    $decodedOptions = json_decode($question->options, true);
                    $options = is_array($decodedOptions) ? $decodedOptions : null;
                } elseif (is_array($question->options)) {
                    $options = $question->options;
                }
            }

            return [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'question_type' => $question->question_type,
                'marks' => $question->marks ?? 1,
                'correct_answer' => $correctAnswer,
                'submitted_answer' => $questionAnswer,
                'is_correct' => $isCorrect,
                'is_skipped' => $isSkipped,
                'score' => $score,
                'options' => $options, // Pass the processed options array
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

        // Extract student and exam data directly for the view
        $student = $result->student;

        // The original method returned JSON. Now it will render a view.
        // This will pass the structured data to the Blade view.
        return view('partner.exams.result-details', compact('exam', 'student', 'result', 'processedQuestions', 'analytics', 'studentAnswers', 'questions'));
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
        $questions = $exam->questions()
            ->where('partner_id', $partnerId)
            ->orderBy('exam_questions.order')
            ->get();
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

    public function export(Exam $exam)
    {
        // Get exam questions with their details - order by the pivot table's order column
        $questions = $exam->questions()
            ->where('partner_id', $partnerId)
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
        $questions = $exam->questions()
            ->where('partner_id', $partnerId)
            ->with(['topic', 'subject'])
            ->get();
        
        // Get saved paper settings or use defaults
        $savedSettings = $exam->paper_settings ?? [];
        
        // Get partner information for footer
        $partner = $exam->partner;
        
        return view('partner.exams.paper-parameters', compact('exam', 'questions', 'savedSettings', 'partner'));
    }
    
    public function downloadPaper(Request $request, Exam $exam)
    {
        try {
            // Validate the request
            $request->validate([
                'parameters' => 'required|array',
                'parameters.paper_size' => 'required|in:A4,Letter,Legal,A3',
                'parameters.orientation' => 'required|in:portrait,landscape',
                'parameters.paper_columns' => 'required|in:1,2,3,4',
                'parameters.adjust_to_percentage' => 'required|integer|min:10|max:500',
                'parameters.header_span' => 'required|in:1,2,3,4,full',
                'parameters.header_push' => 'required|in:1st_col,2nd_col,3rd_col,4th_col',
                'parameters.font_family' => 'required|string',
                'parameters.font_size' => 'required|integer|min:8|max:24',
                'parameters.line_spacing' => 'required|numeric|min:0.5|max:3.0',
                'parameters.mcq_columns' => 'required|in:1,2,3,4',
                'parameters.margin_top' => 'required|integer|min:0|max:50',
                'parameters.margin_bottom' => 'required|integer|min:0|max:50',
                'parameters.margin_left' => 'required|integer|min:0|max:50',
                'parameters.margin_right' => 'required|integer|min:0|max:50',
                'parameters.include_header' => 'boolean',
                'parameters.mark_answer' => 'boolean',
                'parameters.show_page_number' => 'boolean',
            ]);
            
            $parameters = $request->input('parameters');
            
            // Validate PDF parameters
            $this->validatePDFParameters($parameters);
            
            // Get exam questions for PDF generation
            $questions = $exam->questions()
                ->where('partner_id', $partnerId)
                ->with(['topic', 'subject'])
                ->orderBy('exam_questions.order')
                ->get();
            
            // Get partner information for footer
            $partner = $exam->partner;
            
            // Generate HTML using server-side method with parameters
            $pdfHtml = $this->generateQuestionPaperHTMLWithParameters($exam, $questions, $parameters, $partner);
            
            // Debug: Log the generated HTML structure
            \Log::info('PDF Generation Debug', [
                'html_length' => strlen($pdfHtml),
                'paper_size' => $parameters['paper_size'] ?? 'A4',
                'orientation' => $parameters['orientation'] ?? 'portrait',
                'columns' => $parameters['paper_columns'] ?? 1,
                'font_size' => $parameters['font_size'] ?? 12,
                'margins' => [
                    'top' => $parameters['margin_top'] ?? 20,
                    'right' => $parameters['margin_right'] ?? 20,
                    'bottom' => $parameters['margin_bottom'] ?? 20,
                    'left' => $parameters['margin_left'] ?? 20,
                ]
            ]);
            
            // Generate PDF using Browsershot with server-generated HTML
            $pdf = $this->generatePDFWithBrowsershot($pdfHtml, $parameters);
            
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
            ->with('course', 'subject', 'topic', 'questionType');

        // Apply less restrictive filters
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
            'subjects' => \App\Models\Subject::where('partner_id', $partnerId)->where('status', 'active')->where('flag', 'active')->get(),
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
    
    private function generateQuestionPaperHTMLWithParameters($exam, $questions, $parameters, $partner = null)
    {
        // New pagination-aware generation: estimate question heights in mm,
        // paginate into pages (columns filled top-to-bottom) and produce one <div> per page.
        $paperColumns = (int)($parameters['paper_columns'] ?? 1);
        $mcqColumns = (int)($parameters['mcq_columns'] ?? 4);
        $paperSize = $parameters['paper_size'] ?? 'A4';
        $orientation = $parameters['orientation'] ?? 'portrait';

        // helper: paper dims in mm
        $paperDims = [
            'A4' => ['w' => 210, 'h' => 297],
            'Letter' => ['w' => 216, 'h' => 279],
            'Legal' => ['w' => 216, 'h' => 356],
            'A3' => ['w' => 297, 'h' => 420],
        ];
        $p = $paperDims[$paperSize] ?? $paperDims['A4'];
        $widthMm = ($orientation === 'landscape') ? $p['h'] : $p['w'];
        $heightMm = ($orientation === 'landscape') ? $p['w'] : $p['h'];

        // usable height per page (in mm)
        $marginTop = (float)($parameters['margin_top'] ?? 20);
        $marginBottom = (float)($parameters['margin_bottom'] ?? 20);
        $headerHeight = ($parameters['include_header'] ?? true) ? 20 : 0;
        $footerHeight = ($parameters['show_page_number'] ?? true) ? 8 : 0;
        $usableHeightMm = max(10, $heightMm - $marginTop - $marginBottom - $headerHeight - $footerHeight);

        // convert pt/mm helpers
        $ptToMm = 0.352778;

        $estimateQuestionHeightMm = function($question) use ($parameters, $ptToMm) {
            $fontSize = (float)($parameters['font_size'] ?? 12);
            $lineSpacing = (float)($parameters['line_spacing'] ?? 1.5);
            $lineHeightMm = $fontSize * $lineSpacing * $ptToMm;

            $text = strip_tags($question->question_text ?? '');
            $charsPerLine = max(40, (int)floor(1200 / max(6, $fontSize))); // heuristic
            $lines = max(1, (int)ceil(mb_strlen($text) / $charsPerLine));

            // MCQ options
            $opts = 0;
            foreach (['option_a','option_b','option_c','option_d'] as $k) {
                if (!empty($question->$k)) $opts++;
            }
            $optLines = $opts; // ~1 line per option heuristic

            $totalLines = $lines + $optLines + 1; // +1 for question title/spacing
            $h = $totalLines * $lineHeightMm + 2; // padding mm
            return max(4, min(150, $h));
        };

        // paginate: fill columns top-to-bottom; when no column can accept next question, create new page
        $pages = [];
        $current = [
            'columns' => array_fill(0, $paperColumns, []),
            'heights' => array_fill(0, $paperColumns, 0.0)
        ];

        $globalIndex = 0;
        foreach ($questions as $q) {
            $globalIndex++;
            $qh = $estimateQuestionHeightMm($q);
            $placed = false;

            // try to place into first column that fits or into empty column at minimum
            for ($c = 0; $c < $paperColumns; $c++) {
                if ($current['heights'][$c] + $qh <= $usableHeightMm || count($current['columns'][$c]) === 0) {
                    $current['columns'][$c][] = ['q' => $q, 'number' => $globalIndex];
                    $current['heights'][$c] += $qh;
                    $placed = true;
                    break;
                }
            }

            if (!$placed) {
                // push current page and start a new one
                $pages[] = $current['columns'];
                $current = [
                    'columns' => array_fill(0, $paperColumns, []),
                    'heights' => array_fill(0, $paperColumns, 0.0)
                ];
                // place into first column of new page
                $current['columns'][0][] = ['q' => $q, 'number' => $globalIndex];
                $current['heights'][0] += $qh;
            }
        }

        // push last page if has content
        $hasContent = false;
        foreach ($current['columns'] as $col) { if (count($col) > 0) { $hasContent = true; break; } }
        if ($hasContent) $pages[] = $current['columns'];

        // build HTML for pages
        $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Question Paper - ' . htmlspecialchars($exam->title) . '</title>';
        $html .= '<style>@page { size: ' . $paperSize . ' ' . $orientation . '; margin: ' . $marginTop . 'mm ' . ($parameters['margin_right'] ?? 20) . 'mm ' . $marginBottom . 'mm ' . ($parameters['margin_left'] ?? 20) . 'mm; }';
        $html .= 'body{font-family:"' . ($parameters['font_family'] ?? 'Arial') . '",Arial,sans-serif;margin:0;padding:0;font-size:' . ($parameters['font_size'] ?? 12) . 'pt;line-height:' . ($parameters['line_spacing'] ?? 1.5) . ';}';
        $html .= '.page{box-sizing:border-box;width:' . $widthMm . 'mm;min-height:' . $heightMm . 'mm;padding:0;margin:0 auto;background:white;padding-top:' . $marginTop . 'mm;padding-bottom:' . $marginBottom . 'mm;}';
        $html .= '.paper-container{display:grid;gap:12px;grid-template-columns:repeat(' . $paperColumns . ',1fr);padding:0 10px;}';
        $html .= '.question{margin-bottom:6px;page-break-inside:avoid;break-inside:avoid-column;}';
        $html .= '.header{ text-align:center;margin-bottom:8px;padding-bottom:6px;border-bottom:1px solid #ddd;}';
        $html .= '.footer{text-align:center;margin-top:8px;font-size:10pt;color:#666;}';
        $html .= '</style></head><body>';

        $pageNo = 1;
        foreach ($pages as $pageCols) {
            $html .= '<div class="page" data-page="' . $pageNo . '">';
            // header
            if ($parameters['include_header'] ?? true) {
                $html .= '<div class="header"><div class="exam-title" style="font-weight:700;font-size:' . ((int)$parameters['font_size'] + 4) . 'pt;">' . htmlspecialchars($exam->title) . '</div>';
                $html .= '<div class="exam-info" style="font-size:' . max(8, (int)$parameters['font_size'] - 2) . 'pt;color:#666;">';
                $html .= 'Exam ID: ' . $exam->id . ' | Duration: ' . $exam->duration . ' mins | Total Questions: ' . $questions->count();
                $html .= '</div></div>';
            }

            $html .= '<div class="paper-container paper-columns-' . $paperColumns . '">';
            // columns
            for ($c = 0; $c < $paperColumns; $c++) {
                $html .= '<div class="question-column" data-column="' . ($c + 1) . '">';
                $colItems = $pageCols[$c] ?? [];
                foreach ($colItems as $item) {
                    $q = $item['q'];
                    $num = $item['number'];
                    // render question
                    $html .= '<div class="question"><div style="font-weight:600;">Q' . $num . '</div>';
                    $html .= '<div>'. nl2br(htmlspecialchars($q->question_text ?? '')) .'</div>';
                    if ($q->question_type === 'mcq') {
                        $html .= '<div class="mcq-options" style="margin-top:6px;">';
                        foreach (['option_a','option_b','option_c','option_d'] as $idx => $k) {
                            if (!empty($q->$k)) {
                                $label = strtoupper(['a','b','c','d'][$idx]);
                                $html .= '<div>' . $label . ') ' . htmlspecialchars($q->$k) . '</div>';
                            }
                        }
                        $html .= '</div>';
                    }
                    $html .= '</div>';
                }
                $html .= '</div>';
            }
            $html .= '</div>'; // paper-container

            if ($parameters['show_page_number'] ?? true) {
                $html .= '<div class="footer">Page ' . $pageNo . '</div>';
            }

            $html .= '</div>'; // page
            $pageNo++;
        }

        $html .= '</body></html>';

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
        
        // Validate margins (allow 0mm margins)
        $margins = ['margin_top', 'margin_bottom', 'margin_left', 'margin_right'];
        foreach ($margins as $margin) {
            if (!isset($parameters[$margin]) || !is_numeric($parameters[$margin]) || $parameters[$margin] < 0 || $parameters[$margin] > 50) {
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
<html>
<head>
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

    /**
     * Calculate questions per column for sequential filling
     */
    private function calculateQuestionsPerColumn($totalQuestions, $paperColumns, $parameters)
    {
        // Get paper dimensions and calculate available space
        $paperSize = $parameters['paper_size'] ?? 'A4';
        $orientation = $parameters['orientation'] ?? 'portrait';
        $fontSize = (int)($parameters['font_size'] ?? 12);
        $lineSpacing = (float)($parameters['line_spacing'] ?? 1.5);
        
        // Paper height in mm (approximate)
        $paperHeights = [
            'A4' => $orientation === 'landscape' ? 210 : 297,
            'Letter' => $orientation === 'landscape' ? 216 : 279, 
            'Legal' => $orientation === 'landscape' ? 216 : 356
        ];
        
        $paperHeight = $paperHeights[$paperSize] ?? 297;
        
        // Calculate available height (subtract margins and header space)
        $marginTop = (int)($parameters['margin_top'] ?? 0);
        $marginBottom = (int)($parameters['margin_bottom'] ?? 0);
        $headerHeight = ($parameters['include_header'] ?? true) ? 40 : 0; // Approximate header height in mm
        
        $availableHeight = $paperHeight - $marginTop - $marginBottom - $headerHeight - 40; // 40mm padding
        
        // Estimate question height based on font size and line spacing
        // Average question takes about 4-6 lines depending on complexity
        $averageLinesPerQuestion = 5;
        $lineHeightMm = ($fontSize * $lineSpacing * 0.35); // Convert pt to mm approximately
        $questionHeightMm = $lineHeightMm * $averageLinesPerQuestion + 5; // 5mm spacing between questions
        
        // Calculate maximum questions that can fit in one column
        $maxQuestionsPerColumn = (int)floor($availableHeight / $questionHeightMm);
        
        // Ensure we don't have empty columns by distributing evenly with a minimum
        $questionsPerColumn = max(
            $maxQuestionsPerColumn,
            (int)ceil($totalQuestions / $paperColumns)
        );
        
        // But don't exceed what can physically fit
        $questionsPerColumn = min($questionsPerColumn, $maxQuestionsPerColumn ?: 20);
        
        // Ensure minimum of 5 questions per column if we have questions
        if ($totalQuestions > 0) {
            $questionsPerColumn = max($questionsPerColumn, 5);
        }
        
        return $questionsPerColumn;
    }
    
    /**
     * Save paper settings to database
     */
    public function savePaperSettings(Request $request, Exam $exam)
    {
        try {
            $partnerId = $this->getPartnerId();
            
            // Verify the exam belongs to the partner
            if ($exam->partner_id !== $partnerId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access to exam'
                ], 403);
            }

            $parameters = $request->input('parameters', []);
            
            // Validate parameters
            $validated = $request->validate([
                'parameters.paper_size' => 'required|string|in:A4,Letter,Legal',
                'parameters.orientation' => 'required|string|in:portrait,landscape',
                'parameters.paper_columns' => 'required|integer|min:1|max:4',
                'parameters.adjust_to_percentage' => 'required|integer|min:10|max:500',
                'parameters.font_family' => 'required|string',
                'parameters.font_size' => 'required|integer|min:8|max:24',
                'parameters.line_spacing' => 'required|numeric|min:0.5|max:3.0',
                'parameters.mcq_columns' => 'required|integer|min:1|max:6',
                'parameters.margin_top' => 'required|integer|min:0|max:50',
                'parameters.margin_bottom' => 'required|integer|min:0|max:50',
                'parameters.margin_left' => 'required|integer|min:0|max:50',
                'parameters.margin_right' => 'required|integer|min:0|max:50',
                'parameters.header_span' => 'required|string',
                'parameters.header_push' => 'required|string',
                'parameters.include_header' => 'boolean',
                'parameters.mark_answer' => 'boolean',
                'parameters.show_page_number' => 'boolean'
            ]);

            // Convert checkbox values to boolean
            $parameters['include_header'] = isset($parameters['include_header']) && $parameters['include_header'] === '1';
            $parameters['mark_answer'] = isset($parameters['mark_answer']) && $parameters['mark_answer'] === '1';
            $parameters['show_page_number'] = isset($parameters['show_page_number']) && $parameters['show_page_number'] === '1';

            // Store paper settings in the exam model
            $exam->paper_settings = $parameters;
            $exam->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Paper settings saved successfully',
                'data' => [
                    'exam_id' => $exam->id,
                    'settings' => $parameters
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error saving paper settings: ' . $e->getMessage(), [
                'exam_id' => $exam->id ?? null,
                'partner_id' => $this->getPartnerId(),
                'parameters' => $request->input('parameters', [])
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save paper settings: ' . $e->getMessage()
            ], 500);
        }
    }

    public function assignStudentsForm(Exam $exam)
    {
        $partnerId = $this->getPartnerId();

        if ($exam->partner_id !== $partnerId) {
            abort(403);
        }

        $exam->load(['assignedStudents.course', 'assignedStudents.batch']);

        $batches = Batch::where('partner_id', $partnerId)->get();
        $courses = Course::where('partner_id', $partnerId)->get();

        return view('partner.exams.assign-students', compact('exam', 'batches', 'courses'));
    }

    public function assignStudents(AssignStudentsDTO $request, Exam $exam)
    {
        $partnerId = $this->getPartnerId();
        if ($exam->partner_id !== $partnerId) {
            return response()->json(['error' => 'Unauthorized access to this exam.'], 403);
        }

        $validatedData = $request->validatedDTO();

        try {
            $this->examManagementService->assignStudents(
                $exam,
                $validatedData['student_ids'],
                $validatedData['access_code'],
                $validatedData['valid_until']
            );
            return response()->json(['success' => true, 'message' => 'Students assigned successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to assign students: ' . $e->getMessage()], 500);
        }
    }

    public function revokeAccess(Request $request, Exam $exam)
    {
        $partnerId = $this->getPartnerId();
        if ($exam->partner_id !== $partnerId) {
            return response()->json(['error' => 'Unauthorized access to this exam.'], 403);
        }

        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'required|exists:students,id',
        ]);

        try {
            $count = $this->examManagementService->revokeStudentsAccess(
                $exam,
                $request->input('student_ids')
            );
            return response()->json(['success' => true, 'message' => "{$count} students' access revoked successfully."]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to revoke access: ' . $e->getMessage()], 500);
        }
    }

    public function addQuestions(AssignQuestionsDTO $request, Exam $exam)
    {
        $partnerId = $this->getPartnerId();
        if ($exam->partner_id !== $partnerId) {
            return response()->json(['error' => 'Unauthorized access to this exam.'], 403);
        }

        $validatedData = $request->validatedDTO();

        try {
            $this->examQuestionManagementService->syncQuestions($exam, $validatedData['questions']);
            return response()->json(['success' => true, 'message' => 'Questions added successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add questions: ' . $e->getMessage()], 500);
        }
    }

    public function printPaper(PaperParametersDTO $request, Exam $exam)
    {
        $partnerId = $this->getPartnerId();
        if ($exam->partner_id !== $partnerId) {
            abort(403);
        }

        $params = $request->validatedDTO();

        try {
            $pdfContent = $this->pdfGeneratorService->generateExamPaperPdf($exam, $params);
            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="exam_paper_"' . $exam->id . '.pdf"');
        } catch (\Exception $e) {
            return back()->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }

    public function printPaperPreview(PaperParametersDTO $request, Exam $exam)
    {
        $partnerId = $this->getPartnerId();
        if ($exam->partner_id !== $partnerId) {
            abort(403);
        }

        $params = $request->validatedDTO();

        $paperColumns = $params['paper_columns'] ?? 1;
        $headerSpan = $params['header_span'] ?? 'full';
        $fontSize = $params['font_size'] ?? 12;
        $mcqColumns = $params['mcq_columns'] ?? 2;

        return view('partner.exams.paper-preview', compact('exam', 'params', 'paperColumns', 'headerSpan', 'fontSize', 'mcqColumns'));
    }
}
