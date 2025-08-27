<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAssignment;
use Illuminate\Http\Request;

class ExamAssignmentController extends Controller
{
    public function index(Exam $exam)
    {
        $assignments = ExamAssignment::where('exam_id', $exam->id)->orderByDesc('id')->paginate(20);
        return view('partner.exams.assignments.index', compact('exam', 'assignments'));
    }

    public function store(Request $request, Exam $exam)
    {
        $entries = $request->input('entries');
        // Support JSON string from hidden input
        if (is_string($entries)) {
            $decoded = json_decode($entries, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $entries = $decoded;
            }
        }
        $request->merge(['entries' => $entries]);

        $validated = $request->validate([
            'entries' => 'required|array|min:1',
            'entries.*.phone' => 'required|string|max:20',
            'entries.*.student_name' => 'nullable|string|max:255',
        ]);

        $created = [];
        foreach ($validated['entries'] as $entry) {
            $phone = trim($entry['phone']);
            $studentName = $entry['student_name'] ?? null;
            $assignment = ExamAssignment::firstOrNew([
                'exam_id' => $exam->id,
                'phone' => $phone,
            ]);
            if (!$assignment->exists) {
                $assignment->student_name = $studentName;
                $assignment->access_code = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $assignment->save();
                $created[] = $assignment;
            }
        }

        return redirect()->route('partner.exams.assignments.index', $exam)
            ->with('success', count($created) . ' assignment(s) created.');
    }

    public function regenerate(Exam $exam, ExamAssignment $assignment)
    {
        $assignment->access_code = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $assignment->used_at = null;
        $assignment->attempts = 0;
        $assignment->save();

        return back()->with('success', 'Access code regenerated.');
    }

    public function destroy(Exam $exam, ExamAssignment $assignment)
    {
        $assignment->delete();
        return back()->with('success', 'Assignment removed.');
    }
}

