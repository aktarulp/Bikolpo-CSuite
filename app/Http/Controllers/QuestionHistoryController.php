<?php

namespace App\Http\Controllers;

use App\Models\QuestionHistory;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Traits\HasPartnerContext;

class QuestionHistoryController extends Controller
{
    use HasPartnerContext;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $partnerId = $this->getPartnerId();

        $query = QuestionHistory::with(['question', 'partner'])
            ->where('partner_id', $partnerId); // ✅ Filter by current partner

        // Apply filters
        if ($request->filled('exam_year')) {
            $query->byYear($request->exam_year);
        }

        if ($request->filled('exam_month')) {
            $query->byMonth($request->exam_month);
        }

        if ($request->filled('public_exam_name')) {
            $query->byExamName($request->public_exam_name);
        }

        if ($request->filled('exam_board')) {
            $query->byBoard($request->exam_board);
        }

        if ($request->filled('verified')) {
            if ($request->verified === '1') {
                $query->verified();
            } elseif ($request->verified === '0') {
                $query->unverified();
            }
        }

        $questionHistories = $query->orderBy('exam_year', 'desc')
                                  ->orderBy('created_at', 'desc')
                                  ->paginate(20);

        // Get unique values for filter dropdowns - filtered by current partner
        $examYears = QuestionHistory::where('partner_id', $partnerId)->distinct()->pluck('exam_year')->sort()->reverse();
        $examMonths = QuestionHistory::where('partner_id', $partnerId)->distinct()->pluck('exam_month')->sort();
        $examNames = QuestionHistory::where('partner_id', $partnerId)->distinct()->pluck('public_exam_name')->sort();
        $examBoards = QuestionHistory::where('partner_id', $partnerId)->distinct()->pluck('exam_board')->sort();

        return view('partner.question-history.index', compact(
            'questionHistories',
            'examYears',
            'examMonths',
            'examNames',
            'examBoards'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $partnerId = $this->getPartnerId();

        // ✅ Only show questions from current partner
        $questions = Question::where('status', 'active')
            ->where('partner_id', $partnerId)
            ->with(['subject', 'topic', 'questionType'])
            ->get();

        // ✅ Only show current partner in the dropdown
        $partners = \App\Models\Partner::where('id', $partnerId)->get();

        return view('partner.question-history.create', compact('questions', 'partners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $partnerId = $this->getPartnerId();

        $validated = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'partner_id' => 'required|exists:partners,id',
            'public_exam_name' => 'required|string|max:255',
            'private_exam_name' => 'nullable|string|max:255',
            'exam_month' => 'required|string|max:50',
            'exam_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'remarks' => 'nullable|string',
            'exam_board' => 'nullable|string|max:100',
            'exam_type' => 'nullable|string|max:100',
            'subject_name' => 'nullable|string|max:100',
            'topic_name' => 'nullable|string|max:100',
            'question_number' => 'nullable|integer|min:1',
            'marks_allocated' => 'nullable|integer|min:1',
            'source_reference' => 'nullable|string|max:255',
            'is_verified' => 'boolean',
            'verified_by' => 'nullable|string|max:100',
        ]);

        // ✅ Ensure partner_id matches current partner
        if ($validated['partner_id'] !== $partnerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Partner mismatch'
            ], 403);
        }

        // ✅ Ensure question belongs to current partner
        $question = Question::where('id', $validated['question_id'])
            ->where('partner_id', $partnerId)
            ->first();

        if (!$question) {
            return response()->json([
                'success' => false,
                'message' => 'Question not found or access denied'
            ], 404);
        }

        $questionHistory = QuestionHistory::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Question history created successfully',
            'data' => $questionHistory->load('question', 'partner')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionHistory $questionHistory): View
    {
        $questionHistory->load('question', 'partner');
        return view('partner.question-history.show', compact('questionHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuestionHistory $questionHistory): View
    {
        $partnerId = $this->getPartnerId();

        // ✅ Ensure question history belongs to current partner
        if ($questionHistory->partner_id !== $partnerId) {
            abort(403, 'Unauthorized access to question history.');
        }

        // ✅ Only show questions from current partner
        $questions = Question::where('status', 'active')
            ->where('partner_id', $partnerId)
            ->with(['subject', 'topic', 'questionType'])
            ->get();

        // ✅ Only show current partner in the dropdown
        $partners = \App\Models\Partner::where('id', $partnerId)->get();

        return view('partner.question-history.edit', compact('questionHistory', 'questions', 'partners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuestionHistory $questionHistory): JsonResponse
    {
        $partnerId = $this->getPartnerId();

        // ✅ Ensure question history belongs to current partner
        if ($questionHistory->partner_id !== $partnerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to question history.'
            ], 403);
        }

        $validated = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'partner_id' => 'required|exists:partners,id',
            'public_exam_name' => 'required|string|max:255',
            'private_exam_name' => 'nullable|string|max:255',
            'exam_month' => 'required|string|max:50',
            'exam_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'remarks' => 'nullable|string',
            'exam_board' => 'nullable|string|max:100',
            'exam_type' => 'nullable|string|max:100',
            'subject_name' => 'nullable|string|max:100',
            'topic_name' => 'nullable|string|max:100',
            'question_number' => 'nullable|integer|min:1',
            'marks_allocated' => 'nullable|integer|min:1',
            'source_reference' => 'nullable|string|max:255',
            'is_verified' => 'boolean',
            'verified_by' => 'nullable|string|max:100',
        ]);

        // ✅ Ensure partner_id matches current partner
        if ($validated['partner_id'] !== $partnerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Partner mismatch'
            ], 403);
        }

        // ✅ Ensure question belongs to current partner
        $question = Question::where('id', $validated['question_id'])
            ->where('partner_id', $partnerId)
            ->first();

        if (!$question) {
            return response()->json([
                'success' => false,
                'message' => 'Question not found or access denied'
            ], 404);
        }

        $questionHistory->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Question history updated successfully',
            'data' => $questionHistory->load('question', 'partner')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionHistory $questionHistory): JsonResponse
    {
        $questionHistory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Question history deleted successfully'
        ]);
    }

    /**
     * Get question history statistics
     */
    public function statistics(): JsonResponse
    {
        $partnerId = $this->getPartnerId();

        $stats = [
            'total_records' => QuestionHistory::where('partner_id', $partnerId)->count(),
            'verified_records' => QuestionHistory::where('partner_id', $partnerId)->verified()->count(),
            'unverified_records' => QuestionHistory::where('partner_id', $partnerId)->unverified()->count(),
            'by_year' => QuestionHistory::where('partner_id', $partnerId)
                ->selectRaw('exam_year, COUNT(*) as count')
                ->groupBy('exam_year')
                ->orderBy('exam_year', 'desc')
                ->get(),
            'by_board' => QuestionHistory::where('partner_id', $partnerId)
                ->selectRaw('exam_board, COUNT(*) as count')
                ->whereNotNull('exam_board')
                ->groupBy('exam_board')
                ->orderBy('count', 'desc')
                ->get(),
            'by_exam_type' => QuestionHistory::where('partner_id', $partnerId)
                ->selectRaw('exam_type, COUNT(*) as count')
                ->whereNotNull('exam_type')
                ->groupBy('exam_type')
                ->orderBy('count', 'desc')
                ->get(),
        ];

        return response()->json($stats);
    }

    /**
     * Bulk verify question history records
     */
    public function bulkVerify(Request $request): JsonResponse
    {
        $partnerId = $this->getPartnerId();

        $validated = $request->validate([
            'record_ids' => 'required|array',
            'record_ids.*' => 'exists:question_history,record_id',
            'verified_by' => 'required|string|max:100',
        ]);

        // ✅ Only verify records from current partner
        $verifiedCount = QuestionHistory::where('partner_id', $partnerId)
            ->whereIn('record_id', $validated['record_ids'])
            ->update([
                'is_verified' => true,
                'verified_by' => $validated['verified_by'],
                'verified_at' => now(),
            ]);

        if ($verifiedCount === 0) {
            return response()->json([
                'success' => false,
                'message' => 'No matching records found or access denied'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => $verifiedCount . ' records verified successfully'
        ]);
    }
}
