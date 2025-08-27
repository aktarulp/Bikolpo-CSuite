<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\QuestionSet;
use App\Models\StudentExamResult;
use App\Models\Partner;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $partnerId = $this->getPartnerId();
        $query = Exam::with(['questionSet', 'partner'])
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
        $questionSets = QuestionSet::where('partner_id', $partnerId)
            ->where('status', 'published')
            ->get();
        return view('partner.exams.create', compact('questionSets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_set_id' => 'required|exists:question_sets,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date_format:Y-m-d\\TH:i|after:now',
            'end_time' => 'required|date_format:Y-m-d\\TH:i|after:start_time',
            'duration' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:0',
            'allow_retake' => 'boolean',
            'show_results_immediately' => 'boolean',
        ]);

        // Whitelist fields to avoid mass-assigning unexpected input
        $data = $request->only([
            'question_set_id',
            'title',
            'description',
            'start_time',
            'end_time',
            'duration',
            'passing_marks',
        ]);

        $data['partner_id'] = $this->getPartnerId();
        $data['allow_retake'] = $request->boolean('allow_retake');
        $data['show_results_immediately'] = $request->boolean('show_results_immediately', true);
        $data['status'] = 'draft';

        Exam::create($data);

        return redirect()->route('partner.exams.index')
            ->with('success', 'Exam created successfully.');
    }

    public function show(Exam $exam)
    {
        $exam->load(['questionSet.questions', 'studentResults.student']);
        return view('partner.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $partnerId = $this->getPartnerId();
        $questionSets = QuestionSet::where('partner_id', $partnerId)
            ->where('status', 'published')
            ->get();
        return view('partner.exams.edit', compact('exam', 'questionSets'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'question_set_id' => 'required|exists:question_sets,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date_format:Y-m-d\\TH:i',
            'end_time' => 'required|date_format:Y-m-d\\TH:i|after:start_time',
            'duration' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:0',
            'allow_retake' => 'boolean',
            'show_results_immediately' => 'boolean',
        ]);

        // Whitelist fields
        $data = $request->only([
            'question_set_id',
            'title',
            'description',
            'start_time',
            'end_time',
            'duration',
            'passing_marks',
        ]);
        $data['allow_retake'] = $request->boolean('allow_retake');
        $data['show_results_immediately'] = $request->boolean('show_results_immediately', true);

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
        // Prefer authenticated partner, fallback to 1 for legacy/demo
        $userId = auth()->id();
        if ($userId) {
            $pid = Partner::where('user_id', $userId)->value('id');
            if ($pid) {
                return (int) $pid;
            }
        }
        return 1;
    }
}
