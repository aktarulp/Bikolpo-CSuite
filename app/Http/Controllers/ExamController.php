<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\StudentExamResult;
use App\Models\Partner;
use Illuminate\Http\Request;

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
            'startDate' => 'required|date|after_or_equal:today',
            'startTime' => 'required|date_format:H:i',
            'endDate' => 'required|date|after_or_equal:startDate',
            'endTime' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:15|max:480',
            'total_questions' => 'required|integer|min:1|max:1000',
            'passing_marks' => 'required|integer|min:0|max:100',
            'allow_retake' => 'boolean',
            'show_results_immediately' => 'boolean',
            'has_negative_marking' => 'boolean',
            'negative_marks_per_question' => 'required_if:has_negative_marking,1|nullable|numeric|min:0|max:5',
            'question_head' => 'nullable|string',
        ]);

        // Combine date and time fields to create datetime values
        $startDateTime = \Carbon\Carbon::parse($request->startDate . ' ' . $request->startTime);
        $endDateTime = \Carbon\Carbon::parse($request->endDate . ' ' . $request->endTime);

        // Validate that end datetime is after start datetime
        if ($endDateTime <= $startDateTime) {
            return back()->withErrors(['endTime' => 'End time must be after start time.'])->withInput();
        }

        // Validate that start datetime is in the future
        if ($startDateTime <= now()) {
            return back()->withErrors(['startDate' => 'Start date and time must be in the future.'])->withInput();
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
            'startDate' => 'required|date',
            'startTime' => 'required|date_format:H:i',
            'endDate' => 'required|date|after_or_equal:startDate',
            'endTime' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:15|max:480',
            'total_questions' => 'required|integer|min:1|max:1000',
            'passing_marks' => 'required|integer|min:0|max:100',
            'allow_retake' => 'boolean',
            'show_results_immediately' => 'boolean',
            'has_negative_marking' => 'boolean',
            'negative_marks_per_question' => 'required_if:has_negative_marking,1|nullable|numeric|min:0|max:5',
            'question_head' => 'nullable|string',
            'exam_question_id' => 'nullable|exists:exam_questions,id',
        ]);

        // Combine date and time fields to create datetime values
        $startDateTime = \Carbon\Carbon::parse($request->startDate . ' ' . $request->startTime);
        $endDateTime = \Carbon\Carbon::parse($request->endDate . ' ' . $request->endTime);

        // Validate that end datetime is after start datetime
        if ($endDateTime <= $startDateTime) {
            return back()->withErrors(['endTime' => 'End time must be after start time.'])->withInput();
        }

        $data = $request->only([
            'title',
            'description',
            'exam_type',
            'duration',
            'total_questions',
            'passing_marks',
            'question_head',
            'exam_question_id',
        ]);

        // Add the combined datetime values
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
        $results = StudentExamResult::where('exam_id', $exam->id)
            ->with('student')
            ->latest()
            ->paginate(20);

        return view('partner.exams.results', compact('exam', 'results'));
    }

    public function export(Exam $exam)
    {
        $results = StudentExamResult::where('exam_id', $exam->id)
            ->with('student')
            ->get();

        // For now, return a simple view. In a real app, you'd generate CSV/PDF
        return view('partner.exams.export', compact('exam', 'results'));
    }

    public function assignQuestions(Exam $exam)
    {
        $partnerId = $this->getPartnerId();
        
        // Get available questions for this partner
        $questions = \App\Models\Question::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->with(['topic', 'subject'])
            ->get();
            
        // Get currently assigned questions for this exam
        $assignedQuestions = \App\Models\ExamQuestion::where('exam_id', $exam->id)
            ->pluck('question_id');
        
        // Get subjects and topics for filters
        $subjects = \App\Models\Subject::where('status', 'active')->get();
        $topics = \App\Models\Topic::where('status', 'active')->get();
        
        // Debug: Log the data being passed to the view
        \Log::info('Assign Questions View Data', [
            'exam_id' => $exam->id,
            'questions_count' => $questions->count(),
            'assigned_questions_count' => $assignedQuestions->count(),
            'subjects_count' => $subjects->count(),
            'topics_count' => $topics->count(),
            'partner_id' => $partnerId
        ]);
        
        return view('partner.exams.assign-questions', compact('exam', 'questions', 'assignedQuestions', 'subjects', 'topics'));
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
                'question_ids.*' => 'exists:questions,id'
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
            $examQuestions = [];
            
            foreach ($questionIds as $index => $questionId) {
                $question = \App\Models\Question::find($questionId);
                $examQuestions[] = [
                    'exam_id' => $exam->id,
                    'question_id' => $questionId,
                    'order' => $index + 1,
                    'marks' => $question->marks ?? 1,
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
                $insertedCount = \App\Models\ExamQuestion::insert($examQuestions);
                \Log::info('Inserted exam questions', ['inserted_count' => $insertedCount]);
            }

            // Update the exam's total questions count
            $exam->update(['total_questions' => count($questionIds)]);
            \Log::info('Updated exam total questions', ['new_total' => count($questionIds)]);

            return redirect()->route('partner.exams.index')
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
}
