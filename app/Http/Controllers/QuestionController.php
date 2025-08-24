<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\QuestionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        // Get the currently authenticated partner
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }

        $partner = $user->partner;
        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        $query = Question::with(['topic.subject.course', 'partner', 'questionType', 'createdBy'])
            ->where('partner_id', $partner->id); // Use authenticated partner's ID

        // Apply filters
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
            $query->where('q_type_id', $request->question_type);
        }

        $questions = $query->latest()->paginate(15);
        $courses = Course::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        $topics = Topic::where('status', 'active')->get();
        $questionTypes = QuestionType::where('status', 'active')->orderBy('sort_order')->get();

        return view('partner.questions.index', compact('questions', 'courses', 'subjects', 'topics', 'questionTypes'));
    }

    /**
     * Display the questions dashboard with statistics.
     * Now redirects to all questions view.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dashboard()
    {
        // Redirect to all questions view instead of showing dashboard
        return redirect()->route('partner.questions.all');
    }

    /**
     * Display all questions in a list view.
     *
     * @return \Illuminate\View\View
     */
    public function allQuestions(Request $request)
    {
        // Get the currently authenticated partner
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }

        $partner = $user->partner;
        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        $query = Question::with(['course', 'subject', 'topic', 'partner', 'questionType', 'createdBy'])
            ->where('partner_id', $partner->id); // Use authenticated partner's ID

        // Apply search filter
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

        // Apply filters
        if ($request->filled('course_filter')) {
            $query->where('course_id', $request->course_filter);
        }

        if ($request->filled('subject_filter')) {
            $query->where('subject_id', $request->subject_filter);
        }

        if ($request->filled('topic_filter')) {
            $query->where('topic_id', $request->topic_filter);
        }

        if ($request->filled('question_type_filter')) {
            $query->whereHas('questionType', function($q) use ($request) {
                $q->where('q_type_code', $request->question_type_filter);
            });
        }

        $questions = $query->latest()->paginate(15);
        
        // Debug: Log the query and results
        \Log::info('Questions Query:', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
            'count' => $questions->total(),
            'partner_id' => $partner->id
        ]);
        
        // Debug: Check what questions exist in the database
        $allQuestions = Question::where('partner_id', $partner->id)->get();
        \Log::info('All Questions for Partner:', [
            'partner_id' => $partner->id,
            'total_questions' => $allQuestions->count(),
            'questions' => $allQuestions->map(function($q) {
                return [
                    'id' => $q->id,
                    'question_text' => substr($q->question_text, 0, 50) . (strlen($q->question_text) > 50 ? '...' : ''),
                    'course_id' => $q->course_id,
                    'subject_id' => $q->subject_id,
                    'topic_id' => $q->topic_id,
                    'partner_id' => $q->partner_id,
                    'question_type' => $q->question_type,
                    'q_type_id' => $q->q_type_id
                ];
            })
        ]);
        
        // Append search parameter to pagination links
        if ($request->filled('search')) {
            $questions->appends(['search' => $request->search]);
        }
        if ($request->filled('course_filter')) {
            $questions->appends(['course_filter' => $request->course_filter]);
        }
        if ($request->filled('subject_filter')) {
            $questions->appends(['subject_filter' => $request->subject_filter]);
        }
        if ($request->filled('topic_filter')) {
            $questions->appends(['topic_filter' => $request->topic_filter]);
        }
        if ($request->filled('question_type_filter')) {
            $questions->appends(['question_type_filter' => $request->question_type_filter]);
        }
        
        $courses = Course::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        $topics = Topic::where('status', 'active')->get();
        $questionTypes = QuestionType::where('status', 'active')->orderBy('sort_order')->get();

        return view('partner.questions.all-question-view', compact('questions', 'courses', 'subjects', 'topics', 'questionTypes'));
    }

    public function create()
    {
        $courses = Course::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->with('course')->get();
        $topics = Topic::where('status', 'active')->with('subject')->get();

        return view('partner.questions.create', compact('courses', 'subjects', 'topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'question_text' => 'required|string|max:1000',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:a,b,c,d',
            'explanation' => 'nullable|string',
            'difficulty_level' => 'required|in:1,2,3',
            'marks' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get the currently authenticated partner
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }

        $partner = $user->partner;
        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        $data = $request->all();
        $data['partner_id'] = $partner->id; // Use authenticated partner's ID
        $data['created_by'] = $user->id; // Set the user who created the question

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('questions', 'public');
        }

        Question::create($data);

        return redirect()->route('partner.questions.index')
            ->with('success', 'Question created successfully.');
    }

    public function show(Question $question)
    {
        $question->load(['topic.subject.course', 'partner']);
        return view('partner.questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        // Redirect to the appropriate type-specific edit route
        switch ($question->question_type) {
            case 'mcq':
                return redirect()->route('partner.questions.mcq.edit', $question);
            case 'descriptive':
                return redirect()->route('partner.questions.descriptive.edit', $question);
            default:
                abort(404, 'Unknown question type');
        }
    }

    public function update(Request $request, Question $question)
    {
        // Redirect to the appropriate type-specific update route
        switch ($question->question_type) {
            case 'mcq':
                return redirect()->route('partner.questions.mcq.edit', $question);
            case 'descriptive':
                return redirect()->route('partner.questions.descriptive.edit', $question);
            default:
                abort(404, 'Unknown question type');
        }
        
        // Commented out - redirecting to type-specific routes instead
        /*
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'question_text' => 'required|string|max:1000',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:a,b,c,d',
            'explanation' => 'nullable|string',
            'difficulty_level' => 'required|in:1,2,3',
            'marks' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }
            $data['image'] = $request->file('image')->store('questions', 'public');
        }

        $question->update($data);

        return redirect()->route('partner.questions.index')
            ->with('success', 'Question updated successfully.');
        */
    }

    public function destroy(Question $question)
    {
        if ($question->image) {
            Storage::disk('public')->delete($question->image);
        }

        $question->delete();

        // Redirect to appropriate index based on question type
        switch ($question->question_type) {
            case 'mcq':
                return redirect()->route('partner.questions.all')
                    ->with('success', 'Question deleted successfully.');
            case 'descriptive':
                return redirect()->route('partner.questions.descriptive.index')
                    ->with('success', 'Question deleted successfully.');
            default:
                return redirect()->route('partner.questions.index')
                    ->with('success', 'Question deleted successfully.');
        }
    }

    public function checkDuplicate(Request $request)
    {
        $request->validate([
            'question_text' => 'required|string',
        ]);

        $duplicate = Question::where('question_text', 'LIKE', '%' . $request->question_text . '%')
            ->orWhere('question_text', 'LIKE', '%' . substr($request->question_text, 0, 50) . '%')
            ->first();

        return response()->json([
            'duplicate' => $duplicate ? true : false,
            'question' => $duplicate ? $duplicate->load('topic.subject.course') : null,
        ]);
    }

    public function getSubjects(Request $request)
    {
        $subjects = Subject::where('course_id', $request->course_id)
            ->where('status', 'active')
            ->get();

        return response()->json($subjects);
    }

    public function getTopics(Request $request)
    {
        $topics = Topic::where('subject_id', $request->subject_id)
            ->where('status', 'active')
            ->get();

        return response()->json($topics);
    }

    // MCQ Question Methods
    public function mcqAllQuestionView(Request $request)
    {
        $query = Question::with(['course', 'subject', 'topic', 'partner'])
            ->where('question_type', 'mcq')
            ->where('partner_id', 1); // Default partner ID

        // Apply filters
        if ($request->filled('course_filter')) {
            $query->where('course_id', $request->course_filter);
        }

        if ($request->filled('subject_filter')) {
            $query->where('subject_id', $request->subject_filter);
        }

        if ($request->filled('topic_filter')) {
            $query->where('topic_id', $request->topic_filter);
        }



        $questions = $query->latest()->paginate(15);
        $courses = Course::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        $topics = Topic::where('status', 'active')->get();

        return view('partner.questions.all-question-view', compact('questions', 'courses', 'subjects', 'topics'));
    }

    public function mcqCreate()
    {
        $courses = Course::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->with('course')->get();
        $topics = Topic::where('status', 'active')->with('subject')->get();

        return view('partner.questions.mcq.create-mcq', compact('courses', 'subjects', 'topics'));
    }

    public function mcqStore(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
            'topic_id' => 'nullable|exists:topics,id',
            'question_text' => 'required|string|max:5000', // Increased limit for HTML content
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:a,b,c,d',
            'explanation' => 'nullable|string|max:5000', // Increased limit for HTML content
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string', // Changed from json to string to handle the form data properly
            'appearance_history' => 'nullable|string', // Changed from json to string to handle the form data properly
        ]);

        try {
            \DB::beginTransaction();

            // Get the currently authenticated partner
            $user = auth()->user();
            if (!$user || !$user->isPartner()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access. Partner login required.'
                ], 403);
            }

            $partner = $user->partner;
            if (!$partner) {
                return response()->json([
                    'success' => false,
                    'message' => 'Partner profile not found.'
                ], 404);
            }

            $data = $request->all();
            $data['question_type'] = 'mcq';
            $data['partner_id'] = $partner->id; // Use authenticated partner's ID
            $data['created_by'] = $user->id; // Set the user who created the question
            $data['status'] = 'active';
            $data['marks'] = $data['marks'] ?? 1; // Default marks to 1
            $data['difficulty_level'] = $data['difficulty_level'] ?? 2; // Default difficulty to Medium (2)
            
            // Set the MCQ question type ID
            $mcqType = \App\Models\QuestionType::where('q_type_code', 'MCQ')->first();
            if ($mcqType) {
                $data['q_type_id'] = $mcqType->q_type_id;
            }

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('questions', 'public');
            }

            // Create the question
            $question = Question::create($data);

            // Handle tags if available
            if ($request->filled('tags')) {
                $tags = $request->tags;
                if (is_string($tags)) {
                    $tagsArray = json_decode($tags, true);
                    if (is_array($tagsArray)) {
                        $data['tags'] = $tagsArray;
                    }
                }
            }

            // Handle question history if available
            if ($request->filled('appearance_history')) {
                $appearanceHistory = $request->appearance_history;
                if (is_string($appearanceHistory)) {
                    $appearanceHistoryArray = json_decode($appearanceHistory, true);
                    
                    if (is_array($appearanceHistoryArray) && !empty($appearanceHistoryArray)) {
                        foreach ($appearanceHistoryArray as $history) {
                            \App\Models\QuestionHistory::create([
                                'question_id' => $question->id,
                                'partner_id' => $partner->id,
                                'public_exam_name' => $history['exam_name'] ?? null,
                                'private_exam_name' => $history['exam_name'] ?? null,
                                'exam_month' => $history['exam_month'] ?? null,
                                'exam_year' => $history['exam_year'] ?? null,
                                'exam_board' => $history['exam_board'] ?? null,
                                'subject_name' => $data['subject_id'] ? \App\Models\Subject::find($data['subject_id'])->name : null,
                                'topic_name' => $data['topic_id'] ? \App\Models\Topic::find($data['topic_id'])->name : null,
                                'is_verified' => false,
                            ]);
                        }
                    }
                }
            }

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'MCQ question created successfully!',
                'question_id' => $question->id
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating MCQ question: ' . $e->getMessage()
            ], 500);
        }
    }

    public function mcqShow(Question $question)
    {
        if ($question->question_type !== 'mcq') {
            abort(404);
        }
        
        $question->load(['course', 'subject', 'topic', 'partner']);
        return view('partner.questions.mcq.show', compact('question'));
    }

    public function mcqEdit(Question $question)
    {
        if ($question->question_type !== 'mcq') {
            abort(404);
        }

        // Load the question with its relationships
        $question->load(['course', 'subject', 'topic']);

        $courses = Course::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->with('course')->get();
        $topics = Topic::where('status', 'active')->with('subject')->get();

        return view('partner.questions.mcq.mcq-modify', compact('question', 'courses', 'subjects', 'topics'));
    }

    public function mcqUpdate(Request $request, Question $question)
    {
        if ($question->question_type !== 'mcq') {
            abort(404);
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
            'topic_id' => 'nullable|exists:topics,id',
            'question_text' => 'required|string|max:1000',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:a,b,c,d',
            'explanation' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|json',
            'appearance_history' => 'nullable|json',
        ]);

        $data = $request->all();
        $data['marks'] = $data['marks'] ?? 1; // Default marks to 1
        $data['difficulty_level'] = $data['difficulty_level'] ?? 2; // Default difficulty to Medium (2)

        if ($request->hasFile('image')) {
            // Delete old image
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }
            $data['image'] = $request->file('image')->store('questions', 'public');
        }

        $question->update($data);

        return redirect()->route('partner.questions.index')
            ->with('success', 'MCQ question updated successfully.');
    }

    public function mcqDestroy(Question $question)
    {
        if ($question->question_type !== 'mcq') {
            abort(404);
        }

        if ($question->image) {
            Storage::disk('public')->delete($question->image);
        }

        $question->delete();

        return redirect()->route('partner.questions.index')
            ->with('success', 'MCQ question deleted successfully.');
    }

    // Descriptive Question Methods
    public function descriptiveCreate()
    {
        $courses = Course::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        $topics = Topic::where('status', 'active')->get();

        return view('partner.questions.create-desc', compact('courses', 'subjects', 'topics'));
    }

    public function descriptiveStore(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
            'topic_id' => 'nullable|exists:topics,id',
            'question_text' => 'required|string|max:5000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|json',
            'appearance_history' => 'nullable|json',
        ]);

        // Get the currently authenticated partner
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }

        $partner = $user->partner;
        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        $data = $request->all();
        $data['question_type'] = 'descriptive';
        $data['partner_id'] = $partner->id; // Use authenticated partner's ID
        $data['created_by'] = $user->id; // Set the user who created the question
        
        // Handle empty topic_id
        if (empty($data['topic_id'])) {
            $data['topic_id'] = null;
        }
        
        // Set default values for required fields
        $data['status'] = 'active';
        $data['difficulty_level'] = 2; // Default to medium
        $data['marks'] = 5; // Default to 5 marks
        
        // Set MCQ fields to null for descriptive questions
        $data['option_a'] = null;
        $data['option_b'] = null;
        $data['option_c'] = null;
        $data['option_d'] = null;
        $data['correct_answer'] = null;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('questions', 'public');
        }

        try {
            \DB::beginTransaction();

            // Create the question
            $question = Question::create($data);

            // Handle question history if available
            if ($request->filled('appearance_history')) {
                $appearanceHistory = json_decode($request->appearance_history, true);
                
                if (is_array($appearanceHistory) && !empty($appearanceHistory)) {
                    foreach ($appearanceHistory as $history) {
                        \App\Models\QuestionHistory::create([
                            'question_id' => $question->id,
                            'partner_id' => $partner->id,
                            'public_exam_name' => $history['exam_name'] ?? null,
                            'private_exam_name' => $history['exam_year'] ?? null,
                            'exam_month' => $history['exam_month'] ?? null,
                            'exam_year' => $history['exam_year'] ?? null,
                            'exam_board' => $history['exam_board'] ?? null,
                            'subject_name' => $data['subject_id'] ? \App\Models\Subject::find($data['subject_id'])->name : null,
                            'topic_name' => $data['topic_id'] ? \App\Models\Topic::find($data['topic_id'])->name : null,
                            'is_verified' => false,
                        ]);
                    }
                }
            }

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            
            return redirect()->route('partner.questions.index')
                ->with('error', 'Error creating descriptive question: ' . $e->getMessage());
        }

        $message = 'Descriptive question created successfully.';

        return redirect()->route('partner.questions.index')
            ->with('success', $message);
    }

    public function descriptiveIndex()
    {
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }

        $partner = $user->partner;
        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        $descriptiveQuestions = Question::where('partner_id', $partner->id)
            ->where('question_type', 'descriptive')
            ->with(['course', 'subject', 'topic', 'questionType'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('partner.questions.descriptive.index', compact('descriptiveQuestions'));
    }

    public function descriptiveEdit(Question $question)
    {
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }

        $partner = $user->partner;
        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        // Check if the question belongs to the authenticated partner
        if ($question->partner_id !== $partner->id) {
            abort(403, 'Unauthorized access to this question.');
        }

        // Check if it's a descriptive question
        if ($question->question_type !== 'descriptive') {
            abort(400, 'This is not a descriptive question.');
        }

        $courses = Course::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        $topics = Topic::where('status', 'active')->get();

        // Load question history
        $questionHistory = $question->questionHistory;

        return view('partner.questions.descriptive.edit', compact('question', 'courses', 'subjects', 'topics', 'questionHistory'));
    }

    public function descriptiveUpdate(Request $request, Question $question)
    {
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }

        $partner = $user->partner;
        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        // Check if the question belongs to the authenticated partner
        if ($question->partner_id !== $partner->id) {
            abort(403, 'Unauthorized access to this question.');
        }

        // Check if it's a descriptive question
        if ($question->question_type !== 'descriptive') {
            abort(400, 'This is not a descriptive question.');
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
            'topic_id' => 'nullable|exists:topics,id',
            'question_text' => 'required|string|max:5000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|json',
            'appearance_history' => 'nullable|json',
        ]);

        $data = $request->all();
        
        // Handle empty topic_id
        if (empty($data['topic_id'])) {
            $data['topic_id'] = null;
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($question->image) {
                \Storage::disk('public')->delete($question->image);
            }
            $data['image'] = $request->file('image')->store('questions', 'public');
        }

        try {
            \DB::beginTransaction();

            // Update the question
            $question->update($data);

            // Handle question history if available
            if ($request->filled('appearance_history')) {
                // Delete existing history
                $question->questionHistory()->delete();
                
                $appearanceHistory = json_decode($request->appearance_history, true);
                
                if (is_array($appearanceHistory) && !empty($appearanceHistory)) {
                    foreach ($appearanceHistory as $history) {
                        \App\Models\QuestionHistory::create([
                            'question_id' => $question->id,
                            'partner_id' => $partner->id,
                            'public_exam_name' => $history['exam_name'] ?? null,
                            'private_exam_name' => $history['exam_year'] ?? null,
                            'exam_month' => $history['exam_month'] ?? null,
                            'exam_year' => $history['exam_year'] ?? null,
                            'exam_board' => $history['exam_board'] ?? null,
                            'subject_name' => $data['subject_id'] ? \App\Models\Subject::find($data['subject_id'])->name : null,
                            'topic_name' => $data['topic_id'] ? \App\Models\Topic::find($data['topic_id'])->name : null,
                            'is_verified' => false,
                        ]);
                    }
                }
            }

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            
            return redirect()->route('partner.questions.descriptive.edit', $question)
                ->with('error', 'Error updating descriptive question: ' . $e->getMessage());
        }

        return redirect()->route('partner.questions.descriptive.index')
            ->with('success', 'Descriptive question updated successfully.');
    }

    public function descriptiveDestroy(Question $question)
    {
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }

        $partner = $user->partner;
        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        // Check if the question belongs to the authenticated partner
        if ($question->partner_id !== $partner->id) {
            abort(403, 'Unauthorized access to this question.');
        }

        // Check if it's a descriptive question
        if ($question->question_type !== 'descriptive') {
            abort(400, 'This is not a descriptive question.');
        }

        try {
            \DB::beginTransaction();

            // Delete question history
            $question->questionHistory()->delete();
            
            // Delete question image if exists
            if ($question->image) {
                \Storage::disk('public')->delete($question->image);
            }
            
            // Delete the question
            $question->delete();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            
            return redirect()->route('partner.questions.descriptive.index')
                ->with('error', 'Error deleting descriptive question: ' . $e->getMessage());
        }

        return redirect()->route('partner.questions.descriptive.index')
            ->with('success', 'Descriptive question deleted successfully.');
    }

}
