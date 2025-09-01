<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\QuestionType;
use App\Traits\HasPartnerContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    use HasPartnerContext;

    public function index(Request $request)
    {
        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();
        
        $query = Question::with(['topic.subject.courses', 'partner', 'questionType'])
            ->where('partner_id', $partnerId);

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
     * API endpoint for questions (used in step 2 of question set creation)
     */
    public function apiIndex(Request $request)
    {
        // Get the currently authenticated partner
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }

        // For question set creation, show all available questions (not just partner's own)
        $query = Question::with(['topic.subject.courses', 'questionType'])
            ->where('status', 'active');

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

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('question_text', 'like', "%{$search}%")
                  ->orWhere('option_a', 'like', "%{$search}%")
                  ->orWhere('option_b', 'like', "%{$search}%")
                  ->orWhere('option_c', 'like', "%{$search}%")
                  ->orWhere('option_d', 'like', "%{$search}%")
                  ->orWhere('explanation', 'like', "%{$search}%")
                  ->orWhereHas('topic.subject.courses', function($q) use ($search) {
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

        $limit = $request->get('limit', 50);
        
        // Log the query for debugging
        \Log::info('Questions API Query', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
            'limit' => $limit,
            'user_id' => $user->id,
            'user_role' => $user->role
        ]);
        
        $questions = $query->latest()->limit($limit)->get();
        
        // Log the results
        \Log::info('Questions API Results', [
            'count' => $questions->count(),
            'sample_ids' => $questions->take(5)->pluck('id')->toArray()
        ]);

        return response()->json([
            'data' => $questions,
            'total' => $questions->count()
        ]);
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
        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();
        
        $query = Question::with(['course', 'subject', 'topic', 'partner', 'questionType'])
            ->where('partner_id', $partnerId);

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
                  ->orWhereHas('topic.subject.courses', function($q) use ($search) {
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
        $subjects = Subject::where('status', 'active')->with('courses')->get();
        $topics = Topic::where('status', 'active')->with('subject')->get();

        return view('partner.questions.create', compact('courses', 'subjects', 'topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'question_text' => 'required|string|max:1000',
            'question_header' => 'nullable|string|max:500',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:a,b,c,d',
            'explanation' => 'nullable|string',
            'marks' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        // Get the authenticated user's partner ID using the trait
        $data['partner_id'] = $this->getPartnerId();
        
        // Set the authenticated user's ID as created_by
        $data['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('questions', 'public');
        }

        Question::create($data);

        return redirect()->route('partner.questions.index')
            ->with('success', 'Question created successfully.');
    }

    public function show(Question $question)
    {
        $question->load(['topic.subject.courses', 'partner']);
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
            'question' => $duplicate ? $duplicate->load('topic.subject.courses') : null,
        ]);
    }

    public function getSubjects(Request $request)
    {
        $partnerId = $this->getPartnerId();
        
        // Add logging for debugging
        \Log::info('getSubjects called', [
            'course_id' => $request->course_id,
            'partner_id' => $partnerId
        ]);
        
        $subjects = Subject::whereHas('courses', function($query) use ($request) {
                $query->where('course_id', $request->course_id);
            })
            ->where('partner_id', $partnerId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        \Log::info('Subjects found', [
            'count' => $subjects->count(),
            'subjects' => $subjects->pluck('name', 'id')->toArray()
        ]);

        return response()->json($subjects);
    }

    public function getTopics(Request $request)
    {
        $partnerId = $this->getPartnerId();
        
        // Add logging for debugging
        \Log::info('getTopics called', [
            'subject_id' => $request->subject_id,
            'partner_id' => $partnerId
        ]);
        
        $topics = Topic::where('subject_id', $request->subject_id)
            ->where('partner_id', $partnerId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        \Log::info('Topics found', [
            'count' => $topics->count(),
            'topics' => $topics->pluck('name', 'id')->toArray()
        ]);

        return response()->json($topics);
    }

    // MCQ Question Methods
    public function mcqAllQuestionView(Request $request)
    {
        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();
        
        $query = Question::with(['course', 'subject', 'topic', 'partner'])
            ->where('question_type', 'mcq')
            ->where('partner_id', $partnerId);

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
        $courses = Course::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
        $subjects = Subject::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
        $topics = Topic::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('partner.questions.all-question-view', compact('questions', 'courses', 'subjects', 'topics'));
    }

    public function mcqCreate()
    {
        $partnerId = $this->getPartnerId();
        
        $courses = Course::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
        $subjects = Subject::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->with('courses')
            ->orderBy('name')
            ->get();
        $topics = Topic::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->with('subject')
            ->orderBy('name')
            ->get();

        return view('partner.questions.mcq.create-mcq', compact('courses', 'subjects', 'topics'));
    }

    public function mcqStore(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
            'topic_id' => 'nullable|exists:topics,id',
            'question_text' => 'required|string|max:1000',
            'question_header' => 'nullable|string|max:500',
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

        try {
            \DB::beginTransaction();

            $data = $request->all();
            $data['question_type'] = 'mcq';
            
            // Get the authenticated user's partner ID using the trait
            $data['partner_id'] = $this->getPartnerId();
            
            if (!$data['partner_id']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Partner profile not found. Please contact administrator.'
                ], 400);
            }
            
            // Set the authenticated user's ID as created_by
            $data['created_by'] = auth()->id();
            
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

            // Handle question history if available
            if ($request->filled('appearance_history')) {
                $appearanceHistory = json_decode($request->appearance_history, true);
                
                if (is_array($appearanceHistory) && !empty($appearanceHistory)) {
                    foreach ($appearanceHistory as $history) {
                        \App\Models\QuestionHistory::create([
                            'question_id' => $question->id,
                            'partner_id' => $data['partner_id'],
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

        $partnerId = $this->getPartnerId();
        
        $courses = Course::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
        $subjects = Subject::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->with('courses')
            ->orderBy('name')
            ->get();
        $topics = Topic::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->with('subject')
            ->orderBy('name')
            ->get();

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
        $partnerId = $this->getPartnerId();
        
        $courses = Course::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
        $subjects = Subject::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
        $topics = Topic::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('partner.questions.create-desc', compact('courses', 'subjects', 'topics'));
    }

    public function descriptiveStore(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
            'topic_id' => 'nullable|exists:topics,id',
            'question_text' => 'required|string|max:5000',
            'question_header' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|json',
            'appearance_history' => 'nullable|json',
        ]);

        $data = $request->all();
        $data['question_type'] = 'descriptive';
        // Get the authenticated user's partner ID using the trait
        $data['partner_id'] = $this->getPartnerId();
        
        if (!$data['partner_id']) {
            return redirect()->back()->with('error', 'Partner profile not found. Please contact administrator.');
        }
        
        // Handle empty topic_id
        if (empty($data['topic_id'])) {
            $data['topic_id'] = null;
        }
        
        // Set default values for required fields
        $data['status'] = 'active';
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
                            'partner_id' => $data['partner_id'],
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


    /**
     * Generate sample MCQ questions for the authenticated partner and user.
     */
    public function generateSampleMcqs(Request $request)
    {
        // Auth partner context
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }
        $partner = $user->partner;
        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        $count = (int)($request->input('count', 50));
        $count = max(1, min($count, 200)); // Safety cap

        $mcqType = \App\Models\QuestionType::where('q_type_code', 'MCQ')->first();
        $courses = \App\Models\Course::where('status', 'active')->get();
        $subjectsByCourse = \App\Models\Subject::where('status', 'active')->get()->groupBy('course_id');
        $topicsBySubject = \App\Models\Topic::where('status', 'active')->get()->groupBy('subject_id');

        if ($courses->isEmpty()) {
            return redirect()->back()->with('error', 'No active courses found to attach sample questions.');
        }

        $samples = [
            ['What is the capital of France?', 'Paris', 'Berlin', 'Madrid', 'Rome', 'a'],
            ['Which planet is known as the Red Planet?', 'Earth', 'Mars', 'Jupiter', 'Venus', 'b'],
            ['What is the largest ocean on Earth?', 'Indian', 'Atlantic', 'Pacific', 'Arctic', 'c'],
            ['Who wrote Hamlet?', 'Shakespeare', 'Hemingway', 'Tolstoy', 'Dickens', 'a'],
            ['The chemical symbol for water is?', 'H2O', 'CO2', 'O2', 'NaCl', 'a'],
            ['What gas do plants absorb?', 'Oxygen', 'Nitrogen', 'Carbon Dioxide', 'Hydrogen', 'c'],
            ['What is 9 × 8?', '72', '64', '81', '56', 'a'],
            ['Which is a prime number?', '21', '29', '35', '39', 'b'],
            ['Speed unit is?', 'Pascal', 'Newton', 'm/s', 'Watt', 'c'],
            ['Energy unit is?', 'Joule', 'Volt', 'Ohm', 'Ampere', 'a'],
        ];

        $created = 0;

        for ($i = 1; $i <= $count; $i++) {
            $course = $courses->random();
            $subjects = $subjectsByCourse->get($course->id) ?? collect();
            $subject = $subjects->isNotEmpty() ? $subjects->random() : \App\Models\Subject::where('status', 'active')->inRandomOrder()->first();
            $topics = $subject ? ($topicsBySubject->get($subject->id) ?? collect()) : collect();
            $topic = $topics->isNotEmpty() ? $topics->random() : (\App\Models\Topic::where('status', 'active')->inRandomOrder()->first());

            // Fallback safety: skip if no subject/topic context exists at all
            if (!$subject || !$topic) {
                continue;
            }

            $tpl = $samples[array_rand($samples)];
            [$qt, $a, $b, $c, $d, $correct] = $tpl;
            $questionText = "[Sample MCQ #{$i}] {$qt}";

            \App\Models\Question::create([
                'question_type' => 'mcq',
                'q_type_id' => $mcqType?->q_type_id,
                'course_id' => $course->id,
                'subject_id' => $subject->id,
                'topic_id' => $topic->id,
                'partner_id' => $partner->id,
                'created_by' => $user->id,
                'question_text' => $questionText,
                'option_a' => $a,
                'option_b' => $b,
                'option_c' => $c,
                'option_d' => $d,
                'correct_answer' => $correct,
                'explanation' => null,

                'marks' => 1,
                'status' => 'active',
            ]);

            $created++;
        }

        return redirect()->back()->with('success', "{$created} sample MCQ questions created for your partner.");
    }

    /**
     * Check the current session and user authentication status.
     */
    public function checkSession(Request $request)
    {
        $sessionData = [
            'authenticated' => auth()->check(),
            'user_id' => auth()->id(),
            'user_name' => auth()->user()?->name,
            'user_email' => auth()->user()?->email,
            'user_role' => auth()->user()?->role,
            'session_id' => session()->getId(),
            'session_lifetime' => config('session.lifetime'),
            'session_driver' => config('session.driver'),
            'csrf_token' => csrf_token(),
            'timestamp' => now()->toISOString(),
        ];

        if (auth()->check() && auth()->user()->isPartner()) {
            $partner = auth()->user()->partner;
            if ($partner) {
                $sessionData['partner'] = [
                    'id' => $partner->id,
                    'name' => $partner->name,
                    'status' => $partner->status,
                    'user_id' => $partner->user_id,
                ];
                
                // Get existing question counts
                $sessionData['question_counts'] = [
                    'total' => Question::where('partner_id', $partner->id)->count(),
                    'mcq' => Question::where('partner_id', $partner->id)->where('question_type', 'mcq')->count(),
                    'descriptive' => Question::where('partner_id', $partner->id)->where('question_type', 'descriptive')->count(),
                ];
            }
        }

        if ($request->wantsJson()) {
            return response()->json($sessionData);
        }

        return view('partner.questions.session-check', compact('sessionData'));
    }

    /**
     * Seed MCQ questions for the authenticated partner.
     */
    public function seedMcqQuestions(Request $request)
    {
        // Auth partner context
        $user = auth()->user();
        if (!$user || !$user->isPartner()) {
            abort(403, 'Unauthorized access. Partner login required.');
        }
        
        $partner = $user->partner;
        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        $count = (int)($request->input('count', 100));
        $count = max(1, min($count, 500)); // Safety cap

        try {
            // Get required data
            $mcqType = QuestionType::where('q_type_code', 'MCQ')->first();
            if (!$mcqType) {
                return redirect()->back()->with('error', 'MCQ question type not found. Please ensure question types are seeded first.');
            }

            $courses = Course::where('status', 'active')->get();
            if ($courses->isEmpty()) {
                return redirect()->back()->with('error', 'No active courses found. Please create courses first.');
            }

            $subjectsByCourse = Subject::where('status', 'active')->get()->groupBy('course_id');
            $topicsBySubject = Topic::where('status', 'active')->get()->groupBy('subject_id');

            // Enhanced sample question templates with explanations
            $samples = [
                ['What is the capital of France?', 'Paris', 'Berlin', 'Madrid', 'Rome', 'a', 'Paris is the capital and largest city of France.'],
                ['Which planet is known as the Red Planet?', 'Earth', 'Mars', 'Jupiter', 'Venus', 'b', 'Mars is called the Red Planet due to iron oxide on its surface.'],
                ['What is the largest ocean on Earth?', 'Indian', 'Atlantic', 'Pacific', 'Arctic', 'c', 'The Pacific Ocean is the largest and deepest ocean on Earth.'],
                ['Who wrote Hamlet?', 'Shakespeare', 'Hemingway', 'Tolstoy', 'Dickens', 'a', 'William Shakespeare wrote the famous tragedy Hamlet.'],
                ['The chemical symbol for water is?', 'H2O', 'CO2', 'O2', 'NaCl', 'a', 'H2O represents two hydrogen atoms and one oxygen atom.'],
                ['What gas do plants absorb?', 'Oxygen', 'Nitrogen', 'Carbon Dioxide', 'Hydrogen', 'c', 'Plants absorb carbon dioxide during photosynthesis.'],
                ['What is 9 × 8?', '72', '64', '81', '56', 'a', '9 multiplied by 8 equals 72.'],
                ['Which is a prime number?', '21', '29', '35', '39', 'b', '29 is a prime number as it has no divisors other than 1 and itself.'],
                ['Speed unit is?', 'Pascal', 'Newton', 'm/s', 'Watt', 'c', 'Meters per second (m/s) is the SI unit for speed.'],
                ['Energy unit is?', 'Joule', 'Volt', 'Ohm', 'Ampere', 'a', 'Joule is the SI unit for energy.'],
                ['What is the largest mammal?', 'Elephant', 'Blue Whale', 'Giraffe', 'Hippopotamus', 'b', 'The Blue Whale is the largest mammal on Earth.'],
                ['Which element has the symbol Fe?', 'Iron', 'Fluorine', 'Francium', 'Fermium', 'a', 'Fe is the chemical symbol for Iron.'],
                ['What is the square root of 144?', '10', '11', '12', '13', 'c', '12 × 12 = 144, so the square root is 12.'],
                ['Who painted the Mona Lisa?', 'Van Gogh', 'Da Vinci', 'Picasso', 'Rembrandt', 'b', 'Leonardo da Vinci painted the Mona Lisa.'],
                ['What is the main component of the sun?', 'Liquid Lava', 'Molten Iron', 'Hot Gases', 'Solid Rock', 'c', 'The sun is primarily composed of hot gases, mainly hydrogen and helium.'],
                ['Which country has the largest population?', 'India', 'China', 'USA', 'Russia', 'b', 'China has the largest population in the world.'],
                ['What is the chemical symbol for gold?', 'Ag', 'Au', 'Fe', 'Cu', 'b', 'Au is the chemical symbol for gold (from Latin "aurum").'],
                ['Who discovered gravity?', 'Einstein', 'Newton', 'Galileo', 'Copernicus', 'b', 'Isaac Newton formulated the law of universal gravitation.'],
                ['What is the largest desert in the world?', 'Sahara', 'Antarctic', 'Arabian', 'Gobi', 'b', 'The Antarctic Desert is the largest desert in the world.'],
                ['Which language has the most native speakers?', 'English', 'Spanish', 'Mandarin', 'Hindi', 'c', 'Mandarin Chinese has the most native speakers worldwide.'],
            ];

            $created = 0;
            DB::beginTransaction();

            for ($i = 1; $i <= $count; $i++) {
                $course = $courses->random();
                $subjects = $subjectsByCourse->get($course->id) ?? collect();
                $subject = $subjects->isNotEmpty() ? $subjects->random() : Subject::where('status', 'active')->inRandomOrder()->first();
                $topics = $subject ? ($topicsBySubject->get($subject->id) ?? collect()) : collect();
                $topic = $topics->isNotEmpty() ? $topics->random() : (Topic::where('status', 'active')->inRandomOrder()->first());

                // Skip if no subject/topic context exists
                if (!$subject || !$topic) {
                    continue;
                }

                $tpl = $samples[array_rand($samples)];
                [$qt, $a, $b, $c, $d, $correct, $explanation] = $tpl;
                $questionText = "[Sample MCQ #{$i}] {$qt}";

                Question::create([
                    'question_type' => 'mcq',
                    'q_type_id' => $mcqType->q_type_id,
                    'course_id' => $course->id,
                    'subject_id' => $subject->id,
                    'topic_id' => $topic->id,
                    'partner_id' => $partner->id,
                    'created_by' => $user->id,
                    'question_text' => $questionText,
                    'option_a' => $a,
                    'option_b' => $b,
                    'option_c' => $c,
                    'option_d' => $d,
                    'correct_answer' => $correct,
                    'explanation' => $explanation,
                    'marks' => 1,
                    'status' => 'active',
                ]);

                $created++;
            }

            DB::commit();

            return redirect()->back()->with('success', "Successfully created {$created} MCQ questions for your partner.");

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error seeding MCQ questions: ' . $e->getMessage());
        }
    }

    /**
     * Show the bulk upload form for questions.
     *
     * @return \Illuminate\View\View
     */
    public function showBulkUploadForm()
    {
        return view('partner.questions.bulk-upload');
    }

    /**
     * Handle bulk upload of questions from CSV file.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        try {
            $file = $request->file('csv_file');
            $partnerId = $this->getPartnerId();
            
            $handle = fopen($file->getPathname(), 'r');
            $headers = fgetcsv($handle);
            
            // Simplified required headers - only essential question data
            $requiredHeaders = ['question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer'];
            $missingHeaders = array_diff($requiredHeaders, $headers);
            
            if (!empty($missingHeaders)) {
                fclose($handle);
                return redirect()->back()->withErrors(['csv_file' => 'Missing required headers: ' . implode(', ', $missingHeaders)]);
            }

            $successCount = 0;
            $errorCount = 0;
            $errors = [];
            $rowNumber = 1; // Start from 1 since we already read headers

            while (($data = fgetcsv($handle)) !== false) {
                $rowNumber++;
                
                try {
                    // Map CSV data to array
                    $rowData = array_combine($headers, $data);
                    
                    // Get MCQ question type
                    $mcqType = QuestionType::where('q_type_code', 'MCQ')->first();
                    if (!$mcqType) {
                        $errors[] = "Row {$rowNumber}: MCQ question type not found in system";
                        $errorCount++;
                        continue;
                    }

                    // Validate correct answer format
                    $correctAnswer = strtolower(trim($rowData['correct_answer']));
                    if (!in_array($correctAnswer, ['a', 'b', 'c', 'd'])) {
                        $errors[] = "Row {$rowNumber}: Correct answer must be 'a', 'b', 'c', or 'd'";
                        $errorCount++;
                        continue;
                    }

                    // Create question as draft (no course/subject/topic assigned yet)
                    $question = Question::create([
                        'question_type' => 'mcq',
                        'q_type_id' => $mcqType->q_type_id,
                        'course_id' => null, // Will be set later
                        'subject_id' => null, // Will be set later
                        'topic_id' => null, // Will be set later
                        'partner_id' => $partnerId,
                        'created_by' => auth()->id(),
                        'question_text' => trim($rowData['question_text']),
                        'option_a' => trim($rowData['option_a'] ?? ''),
                        'option_b' => trim($rowData['option_b'] ?? ''),
                        'option_c' => trim($rowData['option_c'] ?? ''),
                        'option_d' => trim($rowData['option_d'] ?? ''),
                        'correct_answer' => $correctAnswer,
                        'explanation' => trim($rowData['explanation'] ?? ''),
                        'marks' => 1, // Default marks
                        'difficulty_level' => 2, // Default to Medium
                        'status' => 'draft', // Important: Set as draft
                        'tags' => json_encode(['bulk_upload', 'draft']),
                    ]);

                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = "Row {$rowNumber}: " . $e->getMessage();
                    $errorCount++;
                }
            }

            fclose($handle);

            $message = "Successfully imported {$successCount} questions as drafts.";
            if ($errorCount > 0) {
                $message .= " {$errorCount} questions failed to import.";
            }

            if (!empty($errors)) {
                session()->flash('import_errors', $errors);
            }

            // Redirect to draft questions page instead of all questions
            return redirect()->route('partner.questions.drafts')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['csv_file' => 'Error processing file: ' . $e->getMessage()]);
        }
    }

    /**
     * Show draft questions for review and publishing.
     *
     * @return \Illuminate\View\View
     */
    public function showDrafts()
    {
        $partnerId = $this->getPartnerId();
        
        // Fetch draft questions for this partner
        $draftQuestions = Question::where('partner_id', $partnerId)
            ->where('status', 'draft')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Fetch available courses, subjects, and topics for this partner only
        $courses = Course::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
            
        // Load subjects with their course relationships
        $subjects = Subject::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->with('courses')
            ->orderBy('name')
            ->get();
            
        $topics = Topic::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('partner.questions.drafts', compact('draftQuestions', 'courses', 'subjects', 'topics'));
    }

    /**
     * Update draft questions with metadata and publish them.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDrafts(Request $request)
    {
        $request->validate([
            'questions' => 'required|array',
            'questions.*.id' => 'required|exists:questions,id',
            'questions.*.course_id' => 'required|exists:courses,id',
            'questions.*.subject_id' => 'required|exists:subjects,id',
            'questions.*.topic_id' => 'nullable|exists:topics,id',
        ]);

        try {
            \DB::beginTransaction();

            $partnerId = $this->getPartnerId();
            $updatedCount = 0;

            foreach ($request->questions as $questionData) {
                $question = Question::where('id', $questionData['id'])
                    ->where('partner_id', $partnerId)
                    ->where('status', 'draft')
                    ->first();

                if (!$question) {
                    continue; // Skip if question doesn't exist or doesn't belong to partner
                }

                // Update question with metadata
                $question->update([
                    'course_id' => $questionData['course_id'],
                    'subject_id' => $questionData['subject_id'],
                    'topic_id' => $questionData['topic_id'] ?? null,
                    'status' => 'active', // Publish the question
                    'tags' => json_encode(array_filter(['published', $questionData['topic_id'] ? 'topic_' . $questionData['topic_id'] : null])),
                ]);

                $updatedCount++;
            }

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Successfully published {$updatedCount} questions!",
                'updated_count' => $updatedCount
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error updating questions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete draft questions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteDrafts(Request $request)
    {
        $request->validate([
            'question_ids' => 'required|array',
            'question_ids.*' => 'required|exists:questions,id'
        ]);

        try {
            $partnerId = $this->getPartnerId();
            
            $deletedCount = Question::where('partner_id', $partnerId)
                ->where('status', 'draft')
                ->whereIn('id', $request->question_ids)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} draft questions!",
                'deleted_count' => $deletedCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting questions: ' . $e->getMessage()
            ], 500);
        }
    }
}
