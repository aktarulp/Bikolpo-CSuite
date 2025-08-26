<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\QuestionSet;
use App\Models\Question;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\QuestionType;

class QuestionSetController extends Controller
{
    /**
     * Show the question set creation form.
     */
    public function create()
    {
        // Ensure partner context
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }

        $partner = $user->partner;
        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        // Get questions with filtering capabilities
        $questions = Question::with(['topic.subject.course', 'questionType'])
            ->where('partner_id', $partner->id)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Get courses, subjects, and topics for filters
        $courses = Course::where('partner_id', $partner->id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
            
        $subjects = Subject::where('partner_id', $partner->id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
            
        $topics = Topic::where('partner_id', $partner->id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Get question types for filtering
        $questionTypes = QuestionType::where(function($query) use ($partner) {
                $query->where('partner_id', $partner->id)
                      ->orWhereNull('partner_id'); // Include global question types
            })
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        return view('partner.question-sets.CreateQSet', compact('questions', 'courses', 'subjects', 'topics', 'questionTypes'));
    }

    /**
     * Handle the question set creation form submission.
     */
    public function store(Request $request)
    {
        // Ensure partner context
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }

        $partner = $user->partner;
        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'language' => 'required|string|max:50',
            'description' => 'nullable|string',
            'number_of_question' => 'required|integer|min:1',
            'question_ids' => 'required|array|min:1',
            'question_ids.*' => 'exists:questions,id',
            'status' => 'nullable|string|in:draft,published',
        ]);

        try {
            \DB::beginTransaction();

            // Create the question set
            $questionSet = QuestionSet::create([
                'partner_id' => $partner->id,
                'name' => $request->name,
                'language' => $request->language,
                'description' => $request->description,
                'total_questions' => count($request->question_ids),
                'question_limit' => $request->number_of_question,
                'status' => $request->status ?? 'draft'
            ]);

            // Prepare question attachments with order and marks
            $questionAttachments = [];
            foreach ($request->question_ids as $index => $questionId) {
                $order = $request->input("order_map.{$questionId}", $index + 1);
                $marks = $request->input("marks_map.{$questionId}", 1);
                
                $questionAttachments[$questionId] = [
                    'order' => $order,
                    'marks' => $marks
                ];
            }

            // Attach the selected questions to the question set
            $questionSet->questions()->attach($questionAttachments);

            // Update the question set totals
            $questionSet->updateTotals();

            \DB::commit();

            return redirect()->route('partner.question-sets.show', $questionSet->id)
                             ->with('success', 'Question set created successfully!');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error creating question set:', ['error' => $e->getMessage()]);
            
            return back()->withErrors(['error' => 'An error occurred while creating the question set. Please try again.'])->withInput();
        }
    }

    public function index()
    {
        // Ensure partner context
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }

        $partner = $user->partner;
        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        $questionSets = QuestionSet::with(['partner.user'])
            ->where('partner_id', $partner->id)
            ->latest()
            ->paginate(15);

        $totalSets = QuestionSet::where('partner_id', $partner->id)->count();
        $publishedCount = QuestionSet::where('partner_id', $partner->id)->where('status', 'published')->count();
        $draftCount = QuestionSet::where('partner_id', $partner->id)->where('status', 'draft')->count();

        return view('partner.question-sets.index', compact('questionSets', 'totalSets', 'publishedCount', 'draftCount'));
    }

    public function show(Request $request, QuestionSet $questionSet)
    {
        // Ensure partner context
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }

        $partner = $user->partner;
        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        $questionSet->load(['questions.topic.subject.course', 'partner']);

        // IDs already attached
        $attachedQuestionIds = $questionSet->questions()->pluck('questions.id');

        // Build available questions query (exclude already attached)
        $query = Question::with(['topic.subject.course', 'questionType'])
            ->leftJoin('question_types', 'questions.q_type_id', '=', 'question_types.q_type_id')
            ->select('questions.*')
            ->where('questions.partner_id', $partner->id)
            ->where('questions.status', 'active')
            ->whereNotIn('questions.id', $attachedQuestionIds)
            // Sort CQ first, then MCQ, then others; within group, newest first
            ->orderByRaw("CASE WHEN question_types.q_type_code = 'CQ' THEN 0 WHEN question_types.q_type_code = 'MCQ' THEN 1 ELSE 2 END")
            ->orderBy('questions.created_at', 'desc');

        if ($request->filled('course')) {
            $query->whereHas('topic.subject', function($q) use ($request) {
                $q->where('course_id', $request->course);
            });
        }

        if ($request->filled('subject')) {
            $query->whereHas('topic', function($q) use ($request) {
                $q->where('subject_id', $request->subject);
            });
        }

        if ($request->filled('topic')) {
            $query->where('topic_id', $request->topic);
        }

        if ($request->filled('question_type')) {
            $query->where('questions.q_type_id', $request->question_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('question_text', 'like', "%{$search}%")
                  ->orWhere('option_a', 'like', "%{$search}%")
                  ->orWhere('option_b', 'like', "%{$search}%")
                  ->orWhere('option_c', 'like', "%{$search}%")
                  ->orWhere('option_d', 'like', "%{$search}%")
                  ->orWhere('explanation', 'like', "%{$search}%")
                  ->orWhereHas('topic.subject.course', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('topic.subject', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('topic', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('questionType', function($q) use ($search) {
                      $q->where('q_type_name', 'like', "%{$search}%");
                  });
            });
        }

        $availableQuestions = $query->paginate(10);

        $courses = Course::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        $topics = Topic::where('status', 'active')->get();
        $questionTypes = QuestionType::where('status', 'active')->orderBy('sort_order')->get();

        return view('partner.question-sets.show', compact(
            'questionSet', 'availableQuestions', 'courses', 'subjects', 'topics', 'questionTypes'
        ));
    }

    public function edit(QuestionSet $questionSet)
    {
        return view('partner.question-sets.edit', compact('questionSet'));
    }

    public function update(Request $request, QuestionSet $questionSet)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'language' => 'nullable|in:english,bangla',
            'question_limit' => 'nullable|integer|min:1',
            'status' => 'nullable|in:draft,published,archived',
        ]);

        $questionSet->update($request->only(['name', 'description', 'status', 'language', 'question_limit']));

        return redirect()->route('partner.question-sets.index')
            ->with('success', 'Question set updated successfully.');
    }

    public function destroy(QuestionSet $questionSet)
    {
        $questionSet->delete();

        return redirect()->route('partner.question-sets.index')
            ->with('success', 'Question set deleted successfully.');
    }

    public function addQuestions(Request $request, QuestionSet $questionSet)
    {
        $request->validate([
            'question_ids' => 'required|array',
            'question_ids.*' => 'exists:questions,id',
        ]);

        $questionIds = $request->question_ids;
        $order = $questionSet->questions()->count() + 1;

        foreach ($questionIds as $questionId) {
            $questionSet->questions()->attach($questionId, ['order' => $order++]);
        }

        $questionSet->updateTotals();

        return redirect()->route('partner.question-sets.show', $questionSet)
            ->with('success', 'Questions added to set successfully.');
    }

    public function removeQuestion(QuestionSet $questionSet, Question $question)
    {
        $questionSet->questions()->detach($question->id);
        $questionSet->updateTotals();

        return redirect()->route('partner.question-sets.show', $questionSet)
            ->with('success', 'Question removed from set successfully.');
    }
}
