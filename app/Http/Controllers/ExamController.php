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
            'question_head' => 'nullable|string',
            'question_header' => 'nullable|string',
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

        // Whitelist fields to avoid mass-assigning unexpected input
        $data = $request->only([
            'title',
            'description',
            'exam_type',
            'duration',
            'total_questions',
            'passing_marks',
            'question_head',
            'question_header',
        ]);

        // Add the combined datetime values
        $data['start_time'] = $startDateTime->format('Y-m-d H:i:s');
        $data['end_time'] = $endDateTime->format('Y-m-d H:i:s');

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
            'user_info' => [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name ?? 'Unknown',
                'user_email' => auth()->user()->email ?? 'Unknown'
            ]
        ]);

        return redirect()->route('partner.exams.index')
            ->with('success', 'Exam created successfully.');
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
            'question_head' => 'nullable|string',
            'question_header' => 'nullable|string',
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
            'question_head',
            'question_header',
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
        $results = ExamResult::where('exam_id', $exam->id)
            ->with('student')
            ->latest()
            ->paginate(20);

        return view('partner.exams.results', compact('exam', 'results'));
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

    public function assignQuestions(Exam $exam)
    {
        $partnerId = $this->getPartnerId();
        
        // Get available questions for this partner
        $questions = \App\Models\Question::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->with(['topic', 'subject', 'course'])
            ->get();
            
        // Get currently assigned questions for this exam with their marks
        $assignedQuestions = \App\Models\ExamQuestion::where('exam_id', $exam->id)
            ->pluck('question_id');
            
        // Get assigned questions with marks for display
        $assignedQuestionsWithMarks = \App\Models\ExamQuestion::where('exam_id', $exam->id)
            ->pluck('marks', 'question_id');
        
        // Get courses, subjects and topics for filters
        $courses = \App\Models\Course::where('status', 'active')
            ->where('partner_id', $partnerId)
            ->get();
        $subjects = \App\Models\Subject::where('status', 'active')->get();
        $topics = \App\Models\Topic::where('status', 'active')->get();
        
        // Debug: Log the data being passed to the view
        \Log::info('Assign Questions View Data', [
            'exam_id' => $exam->id,
            'questions_count' => $questions->count(),
            'assigned_questions_count' => $assignedQuestions->count(),
            'courses_count' => $courses->count(),
            'subjects_count' => $subjects->count(),
            'topics_count' => $topics->count(),
            'partner_id' => $partnerId
        ]);
        
        return view('partner.exams.assign-questions', compact('exam', 'questions', 'assignedQuestions', 'assignedQuestionsWithMarks', 'courses', 'subjects', 'topics'));
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
                'question_ids' => 'required|array',
                'question_ids.*' => 'exists:questions,id',
                'question_marks' => 'required|array',
                'question_marks.*' => 'integer|min:1|max:100'
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
            $questionIds = $request->question_ids;
            $questionMarks = $request->question_marks;
            $examQuestions = [];
            
            foreach ($questionIds as $index => $questionId) {
                $question = \App\Models\Question::find($questionId);
                $marks = isset($questionMarks[$questionId]) ? (int)$questionMarks[$questionId] : 1;
                
                $examQuestions[] = [
                    'exam_id' => $exam->id,
                    'question_id' => $questionId,
                    'order' => $index + 1,
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

            return redirect()->route('partner.exams.show', $exam)
                ->with('success', 'Questions assigned successfully to the exam.');

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
        // Prefer authenticated partner, fallback to first available partner for legacy/demo
        $userId = auth()->id();
        if ($userId) {
            $pid = Partner::where('user_id', $userId)->value('id');
            if ($pid) {
                return (int) $pid;
            }
        }
        
        // Fallback to first available partner
        $firstPartnerId = Partner::value('id');
        if ($firstPartnerId) {
            return (int) $firstPartnerId;
        }
        
        throw new \Exception('No partner found. Please create a partner first.');
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
