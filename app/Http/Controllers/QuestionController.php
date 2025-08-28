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
        
        $query = Question::with(['topic.subject.course', 'partner', 'questionType'])
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
        $query = Question::with(['topic.subject.course', 'questionType'])
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
}
