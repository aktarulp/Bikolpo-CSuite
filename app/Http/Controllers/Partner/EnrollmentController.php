<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use App\Models\Batch;
use Illuminate\Http\Request;
use App\Traits\HasPartnerContext;

class EnrollmentController extends Controller
{
    use HasPartnerContext;

    /**
     * Display a listing of enrollments for the partner
     */
    public function index(Request $request)
    {
        $partner = $this->getPartner();
        
        $query = Enrollment::with(['student', 'course', 'batch'])
            ->where('partner_id', $partner->id);

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by course
        if ($request->filled('course_id') && $request->course_id !== 'all') {
            $query->where('course_id', $request->course_id);
        }

        // Filter by student
        if ($request->filled('search')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('student_id', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $enrollments = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $courses = Course::where('partner_id', $partner->id)->get();
        $statuses = Enrollment::getStatuses();

        return view('partner.enrollments.index', compact('enrollments', 'courses', 'statuses'));
    }

    /**
     * Show the form for creating a new enrollment
     */
    public function create(Request $request)
    {
        $partner = $this->getPartner();
        
        // Get students for autocomplete - we only need id, name, and student_id
        $students = Student::where('partner_id', $partner->id)
            ->where('status', 'active')
            ->select('id', 'full_name', 'student_id')
            ->orderBy('full_name')
            ->get();
            
        // Load courses with their batches for cascading dropdown
        $courses = Course::where('partner_id', $partner->id)
            ->where('status', 'active')
            ->with(['batches' => function($query) {
                $query->where('flag', 'active')
                    ->orderBy('year', 'desc')
                    ->orderBy('name');
            }])
            ->get();

        // Pre-select student if provided
        $selectedStudent = $request->student_id 
            ? Student::find($request->student_id) 
            : null;

        return view('partner.enrollments.create', compact('students', 'courses', 'selectedStudent'));
    }

    /**
     * Store a newly created enrollment
     */
    public function store(Request $request)
    {
        $partner = $this->getPartner();

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'nullable|exists:batches,id',
            'enrolled_at' => 'required|date',
            'remarks' => 'nullable|string|max:1000',
        ]);

        // Verify student belongs to partner
        $student = Student::where('id', $validated['student_id'])
            ->where('partner_id', $partner->id)
            ->firstOrFail();

        // Verify course belongs to partner
        $course = Course::where('id', $validated['course_id'])
            ->where('partner_id', $partner->id)
            ->firstOrFail();

        // Check if already enrolled
        if (!Enrollment::canEnroll($validated['student_id'], $validated['course_id'])) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['course_id' => 'Student is already actively enrolled in this course.']);
        }

        // Create enrollment
        Enrollment::create([
            'student_id' => $validated['student_id'],
            'course_id' => $validated['course_id'],
            'batch_id' => $validated['batch_id'] ?? $student->batch_id,
            'partner_id' => $partner->id,
            'enrolled_at' => $validated['enrolled_at'],
            'status' => Enrollment::STATUS_ACTIVE,
            'remarks' => $validated['remarks'],
            'enrolled_by' => auth()->id(),
        ]);

        return redirect()
            ->route('partner.enrollments.index')
            ->with('success', 'Student enrolled successfully!');
    }

    /**
     * Display the specified enrollment
     */
    public function show(Enrollment $enrollment)
    {
        $partner = $this->getPartner();

        // Verify enrollment belongs to partner
        if ($enrollment->partner_id !== $partner->id) {
            abort(404);
        }

        $enrollment->load(['student', 'course', 'batch', 'enrolledBy', 'updatedBy']);

        return view('partner.enrollments.show', compact('enrollment'));
    }

    /**
     * Show the form for editing the specified enrollment
     */
    public function edit(Enrollment $enrollment)
    {
        $partner = $this->getPartner();

        // Verify enrollment belongs to partner
        if ($enrollment->partner_id !== $partner->id) {
            abort(404);
        }

        $courses = Course::where('partner_id', $partner->id)->get();
        // Load only batches that belong to the current course
        $batches = Batch::where('partner_id', $partner->id)
            ->where('course_id', $enrollment->course_id)
            ->get();
        $statuses = Enrollment::getStatuses();

        return view('partner.enrollments.edit', compact('enrollment', 'courses', 'batches', 'statuses'));
    }

    /**
     * Update the specified enrollment
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $partner = $this->getPartner();

        // Verify enrollment belongs to partner
        if ($enrollment->partner_id !== $partner->id) {
            abort(404);
        }

        $validated = $request->validate([
            'batch_id' => 'nullable|exists:batches,id',
            'status' => 'required|in:active,completed,dropped,suspended,transferred',
            'completion_date' => 'nullable|date|after_or_equal:enrolled_at',
            'final_grade' => 'nullable|numeric|min:0|max:100',
            'grade_letter' => 'nullable|string|max:2',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $validated['updated_by'] = auth()->id();

        $enrollment->update($validated);

        return redirect()
            ->route('partner.enrollments.show', $enrollment)
            ->with('success', 'Enrollment updated successfully!');
    }

    /**
     * Mark enrollment as completed
     */
    public function complete(Request $request, Enrollment $enrollment)
    {
        $partner = $this->getPartner();

        if ($enrollment->partner_id !== $partner->id) {
            abort(404);
        }

        $validated = $request->validate([
            'final_grade' => 'required|numeric|min:0|max:100',
            'grade_letter' => 'required|string|max:2',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $enrollment->markAsCompleted(
            $validated['final_grade'],
            $validated['grade_letter'],
            $validated['remarks'] ?? null
        );

        $enrollment->update(['updated_by' => auth()->id()]);

        return redirect()
            ->back()
            ->with('success', 'Enrollment marked as completed successfully!');
    }

    /**
     * Mark enrollment as dropped
     */
    public function drop(Request $request, Enrollment $enrollment)
    {
        $partner = $this->getPartner();

        if ($enrollment->partner_id !== $partner->id) {
            abort(404);
        }

        $validated = $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $enrollment->markAsDropped($validated['remarks']);
        $enrollment->update(['updated_by' => auth()->id()]);

        return redirect()
            ->back()
            ->with('success', 'Enrollment marked as dropped.');
    }

    /**
     * Mark enrollment as suspended
     */
    public function suspend(Request $request, Enrollment $enrollment)
    {
        $partner = $this->getPartner();

        if ($enrollment->partner_id !== $partner->id) {
            abort(404);
        }

        $validated = $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $enrollment->markAsSuspended($validated['remarks']);
        $enrollment->update(['updated_by' => auth()->id()]);

        return redirect()
            ->back()
            ->with('success', 'Enrollment suspended successfully.');
    }

    /**
     * Reactivate a suspended/dropped enrollment
     */
    public function reactivate(Request $request, Enrollment $enrollment)
    {
        $partner = $this->getPartner();

        if ($enrollment->partner_id !== $partner->id) {
            abort(404);
        }

        $validated = $request->validate([
            'remarks' => 'nullable|string|max:1000',
        ]);

        try {
            $enrollment->reactivate($validated['remarks'] ?? null);
            $enrollment->update(['updated_by' => auth()->id()]);

            return redirect()
                ->back()
                ->with('success', 'Enrollment reactivated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Get student's enrollment history
     */
    public function studentHistory($studentId)
    {
        $partner = $this->getPartner();

        $student = Student::where('id', $studentId)
            ->where('partner_id', $partner->id)
            ->firstOrFail();

        $enrollments = $student->enrollments()
            ->with(['course', 'batch', 'enrolledBy'])
            ->orderBy('enrolled_at', 'desc')
            ->get();

        return view('partner.enrollments.student-history', compact('student', 'enrollments'));
    }

    /**
     * Get course's enrollment list
     */
    public function courseEnrollments($courseId)
    {
        $partner = $this->getPartner();

        $course = Course::where('id', $courseId)
            ->where('partner_id', $partner->id)
            ->firstOrFail();

        $enrollments = $course->enrollments()
            ->with(['student', 'batch'])
            ->orderBy('enrolled_at', 'desc')
            ->get();

        $stats = $course->getEnrollmentStatistics();

        return view('partner.enrollments.course-enrollments', compact('course', 'enrollments', 'stats'));
    }

    /**
     * Remove the specified enrollment (permanently)
     */
    public function destroy(Enrollment $enrollment)
    {
        $partner = $this->getPartner();

        if ($enrollment->partner_id !== $partner->id) {
            abort(404);
        }

        $studentName = $enrollment->student->full_name;
        $courseName = $enrollment->course->name;

        // Permanently delete (not soft delete)
        $enrollment->forceDelete();

        return redirect()
            ->route('partner.enrollments.index')
            ->with('success', "Enrollment deleted: {$studentName} from {$courseName}");
    }

    /**
     * Get batches by course (AJAX endpoint)
     */
    public function getBatchesByCourse($courseId)
    {
        $partner = $this->getPartner();
        
        $batches = Batch::where('partner_id', $partner->id)
            ->where('course_id', $courseId)
            ->where('flag', 'active')
            ->orderBy('year', 'desc')
            ->orderBy('name')
            ->get(['id', 'name', 'year']);
            
        return response()->json(['batches' => $batches]);
    }
}
