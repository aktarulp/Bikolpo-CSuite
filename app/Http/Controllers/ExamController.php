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
        $query = Exam::with(['partner'])
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'exam_type' => 'required|in:online,offline',
            'start_time' => 'required|date_format:Y-m-d\\TH:i|after:now',
            'end_time' => 'required|date_format:Y-m-d\\TH:i|after:start_time',
            'duration' => 'required|integer|min:1',
            'total_questions' => 'required|integer|min:1|max:1000',
            'passing_marks' => 'required|integer|min:0|max:100',
            'allow_retake' => 'boolean',
            'show_results_immediately' => 'boolean',
            'has_negative_marking' => 'boolean',
            'negative_marks_per_question' => 'required_if:has_negative_marking,1|nullable|numeric|min:0|max:5',
            'status' => 'nullable|in:draft,published,ongoing,completed,cancelled',
            'flag' => 'nullable|in:active,deleted',
            'language' => 'nullable|string',
            'question_head' => 'nullable|string',
            'question_limit' => 'nullable|integer|min:1|max:1000',
            'is_verified' => 'boolean',
            'is_public' => 'boolean',
        ]);

        // Whitelist fields to avoid mass-assigning unexpected input
        $data = $request->only([
            'title',
            'description',
            'exam_type',
            'start_time',
            'end_time',
            'duration',
            'total_questions',
            'passing_marks',
            'language',
            'question_head',
            'question_limit',
            'status',
            'flag',
        ]);

        $data['partner_id'] = $this->getPartnerId();
        
        // Ensure end time is after start time
        $startTime = \Carbon\Carbon::parse($data['start_time']);
        $endTime = \Carbon\Carbon::parse($data['end_time']);
        
        if ($endTime <= $startTime) {
            // Auto-calculate end time based on start time + duration
            $data['end_time'] = $startTime->addMinutes($data['duration'])->format('Y-m-d H:i:s');
        }
        
        // Set boolean fields first
        $data['allow_retake'] = $request->boolean('allow_retake');
        $data['show_results_immediately'] = $request->boolean('show_results_immediately', true);
        $data['has_negative_marking'] = $request->boolean('has_negative_marking');
        $data['is_verified'] = $request->boolean('is_verified');
        $data['is_public'] = $request->boolean('is_public');
        
        // Set default values if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'draft';
        }
        if (!isset($data['flag'])) {
            $data['flag'] = 'active';
        }
        
        // Handle negative marking
        if ($data['has_negative_marking']) {
            $data['negative_marks_per_question'] = $request->input('negative_marks_per_question', 0.25);
        } else {
            $data['negative_marks_per_question'] = 0;
        }

        $exam = Exam::create($data);

        return redirect()->route('partner.exams.index')
            ->with('success', 'Exam created successfully.');
    }

    public function show(Exam $exam)
    {
        $exam->load(['studentResults.student']);
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
            'start_time' => 'required|date_format:Y-m-d\\TH:i',
            'end_time' => 'required|date_format:Y-m-d\\TH:i|after:start_time',
            'duration' => 'required|integer|min:1',
            'total_questions' => 'required|integer|min:1|max:1000',
            'passing_marks' => 'required|integer|min:0|max:100',
            'allow_retake' => 'boolean',
            'show_results_immediately' => 'boolean',
            'has_negative_marking' => 'boolean',
            'negative_marks_per_question' => 'required_if:has_negative_marking,1|nullable|numeric|min:0|max:5',
            'status' => 'nullable|in:draft,published,ongoing,completed,cancelled',
            'flag' => 'nullable|in:active,deleted',
            'language' => 'nullable|string',
            'question_head' => 'nullable|string',
            'question_limit' => 'nullable|integer|min:1|max:1000',
            'is_verified' => 'boolean',
            'is_public' => 'boolean',
        ]);

        // Whitelist fields
        $data = $request->only([
            'title',
            'description',
            'exam_type',
            'start_time',
            'end_time',
            'duration',
            'total_questions',
            'passing_marks',
            'language',
            'question_head',
            'question_limit',
            'status',
            'flag',
        ]);
        
        // Ensure end time is after start time
        $startTime = \Carbon\Carbon::parse($data['start_time']);
        $endTime = \Carbon\Carbon::parse($data['end_time']);
        
        if ($endTime <= $startTime) {
            // Auto-calculate end time based on start time + duration
            $data['end_time'] = $startTime->addMinutes($data['duration'])->format('Y-m-d H:i:s');
        }
        
        $data['allow_retake'] = $request->boolean('allow_retake');
        $data['show_results_immediately'] = $request->boolean('show_results_immediately', true);
        $data['has_negative_marking'] = $request->boolean('has_negative_marking');
        $data['is_verified'] = $request->boolean('is_verified');
        $data['is_public'] = $request->boolean('is_public');
        
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
        $exam->delete();

        return redirect()->route('partner.exams.index')
            ->with('success', 'Exam deleted successfully.');
    }

    public function publish(Exam $exam)
    {
        $exam->update(['status' => 'published']);

        return redirect()->route('partner.exams.show', $exam)
            ->with('success', 'Exam published successfully.');
    }

    public function unpublish(Exam $exam)
    {
        $exam->update(['status' => 'draft']);

        return redirect()->route('partner.exams.show', $exam)
            ->with('success', 'Exam unpublished successfully.');
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
