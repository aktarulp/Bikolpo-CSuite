<?php

namespace App\Http\Controllers;

use App\Models\QuestionHistory;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class QuestionHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = QuestionHistory::with(['question', 'partner']);

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

        // Get unique values for filter dropdowns
        $examYears = QuestionHistory::distinct()->pluck('exam_year')->sort()->reverse();
        $examMonths = QuestionHistory::distinct()->pluck('exam_month')->sort();
        $examNames = QuestionHistory::distinct()->pluck('public_exam_name')->sort();
        $examBoards = QuestionHistory::distinct()->pluck('exam_board')->sort();

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
        $questions = Question::where('status', 'active')->get();
        $partners = \App\Models\Partner::all();
        return view('partner.question-history.create', compact('questions', 'partners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
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
            'difficulty_level' => 'nullable|string|max:50',
            'source_reference' => 'nullable|string|max:255',
            'is_verified' => 'boolean',
            'verified_by' => 'nullable|string|max:100',
        ]);

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
        $questions = Question::where('status', 'active')->get();
        $partners = \App\Models\Partner::all();
        return view('partner.question-history.edit', compact('questionHistory', 'questions', 'partners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuestionHistory $questionHistory): JsonResponse
    {
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
            'difficulty_level' => 'nullable|string|max:50',
            'source_reference' => 'nullable|string|max:255',
            'is_verified' => 'boolean',
            'verified_by' => 'nullable|string|max:100',
        ]);

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
        $stats = [
            'total_records' => QuestionHistory::count(),
            'verified_records' => QuestionHistory::verified()->count(),
            'unverified_records' => QuestionHistory::unverified()->count(),
            'by_year' => QuestionHistory::selectRaw('exam_year, COUNT(*) as count')
                                      ->groupBy('exam_year')
                                      ->orderBy('exam_year', 'desc')
                                      ->get(),
            'by_board' => QuestionHistory::selectRaw('exam_board, COUNT(*) as count')
                                       ->whereNotNull('exam_board')
                                       ->groupBy('exam_board')
                                       ->orderBy('count', 'desc')
                                       ->get(),
            'by_exam_type' => QuestionHistory::selectRaw('exam_type, COUNT(*) as count')
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
        $validated = $request->validate([
            'record_ids' => 'required|array',
            'record_ids.*' => 'exists:question_history,record_id',
            'verified_by' => 'required|string|max:100',
        ]);

        QuestionHistory::whereIn('record_id', $validated['record_ids'])
                      ->update([
                          'is_verified' => true,
                          'verified_by' => $validated['verified_by'],
                          'verified_at' => now(),
                      ]);

        return response()->json([
            'success' => true,
            'message' => count($validated['record_ids']) . ' records verified successfully'
        ]);
    }
}
