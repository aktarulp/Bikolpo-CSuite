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
        $query = Question::with(['topic.subject.course', 'partner', 'questionType'])
            ->where('partner_id', 1); // Default partner ID

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
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Get the authenticated user (coaching partner)
        $user = auth()->user();
        $partnerId = $user ? $user->id : 1; // Default partner ID if no user

        // 1. Fetching simple counts
        $totalQuestions = Question::where('partner_id', $partnerId)->count();
        $totalMcq = Question::where('partner_id', $partnerId)
                            ->whereHas('questionType', function($q) {
                                $q->where('q_type_code', 'MCQ');
                            })
                            ->count();
        $totalCourses = Course::where('status', 'active')->count();
        $totalSubjects = Subject::where('status', 'active')->count();

        // 2. Fetching grouped data (Course, Subject, Topic-wise status)
        // Questions by Course
        $questionsByCourse = Course::where('status', 'active')
                                    ->withCount(['questions as total_questions' => function($query) use ($partnerId) {
                                        $query->where('partner_id', $partnerId);
                                    }])
                                    ->get();

        // Questions by Subject
        $questionsBySubject = Subject::where('status', 'active')
                                    ->withCount(['questions as total_questions' => function($query) use ($partnerId) {
                                        $query->where('partner_id', $partnerId);
                                    }])
                                    ->get();

        // Questions by Topic
        $questionsByTopic = Topic::where('status', 'active')
                                ->withCount(['questions as total_questions' => function($query) use ($partnerId) {
                                    $query->where('partner_id', $partnerId);
                                }])
                                ->get();

        // Ensure we have valid data even if queries fail
        $totalQuestions = $totalQuestions ?: 0;
        $totalMcq = $totalMcq ?: 0;
        $totalCourses = $totalCourses ?: 0;
        $totalSubjects = $totalSubjects ?: 0;
        $questionsByCourse = $questionsByCourse ?: collect();
        $questionsBySubject = $questionsBySubject ?: collect();
        $questionsByTopic = $questionsByTopic ?: collect();

        // Pass all the data to the Blade view
        return view('partner.questions.question-dashboard', compact(
            'totalQuestions',
            'totalMcq',
            'totalCourses',
            'totalSubjects',
            'questionsByCourse',
            'questionsBySubject',
            'questionsByTopic'
        ));
    }

    /**
     * Display all questions in a list view.
     *
     * @return \Illuminate\View\View
     */
    public function allQuestions(Request $request)
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

        $data = $request->all();
        $data['partner_id'] = 1; // Default partner ID

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
            case 'comprehensive':
                return redirect()->route('partner.questions.comprehensive.edit', $question);
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
            case 'comprehensive':
                return redirect()->route('partner.questions.comprehensive.edit', $question);
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
            case 'comprehensive':
                return redirect()->route('partner.questions.comprehensive.index')
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
            $data['partner_id'] = 1; // Default partner ID
            $data['status'] = 'active';
            $data['marks'] = $data['marks'] ?? 1; // Default marks to 1
            $data['difficulty_level'] = $data['difficulty_level'] ?? 2; // Default difficulty to Medium (2)

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
            'topic_id' => 'required|exists:topics,id',
            'question_text' => 'required|string|max:1000',
            'expected_answer_points' => 'nullable|string',
            'sample_answer' => 'nullable|string',
            'min_words' => 'nullable|integer|min:10|max:1000',
            'max_words' => 'nullable|integer|min:50|max:2000',
            'difficulty_level' => 'required|in:1,2,3',
            'marks' => 'required|integer|min:1|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|json',
            'appearance_history' => 'nullable|json',
        ]);

        $data = $request->all();
        $data['question_type'] = 'descriptive';
        $data['partner_id'] = 1; // Default partner ID

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('questions', 'public');
        }

        Question::create($data);

        $message = 'Descriptive question created successfully.';

        return redirect()->route('partner.questions.index')
            ->with('success', $message);
    }

    // Comprehensive Question Methods
    public function comprehensiveCreate()
    {
        $courses = Course::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        $topics = Topic::where('status', 'active')->get();

        return view('partner.questions.create-comp', compact('courses', 'subjects', 'topics'));
    }

    public function comprehensiveStore(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
            'topic_id' => 'required|exists:topics,id',
            'question_text' => 'required|string|max:1000',
            'sub_questions' => 'nullable|string',
            'expected_answer_structure' => 'nullable|string',
            'key_concepts' => 'nullable|string',
            'sample_answer' => 'nullable|string',
            'min_words' => 'nullable|integer|min:100|max:2000',
            'max_words' => 'nullable|integer|min:200|max:5000',
            'time_allocation' => 'nullable|integer|min:15|max:120',
            'difficulty_level' => 'required|in:1,2,3',
            'marks' => 'required|integer|min:5|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|json',
            'appearance_history' => 'nullable|json',
        ]);

        $data = $request->all();
        $data['question_type'] = 'comprehensive';
        $data['partner_id'] = 1; // Default partner ID

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('questions', 'public');
        }

        Question::create($data);

        $message = 'Comprehensive question created successfully.';

        return redirect()->route('partner.questions.index')
            ->with('success', $message);
    }
}
