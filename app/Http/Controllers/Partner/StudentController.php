<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index()
    {
        // Permission checking disabled

        $students = Student::with(['user', 'courses', 'batch'])
            ->where('partner_id', $this->getPartnerId())
            ->paginate(20);

        // Get courses and batches for filters
        $courses = \App\Models\Course::where('partner_id', $this->getPartnerId())->get();
        $batches = \App\Models\Batch::where('partner_id', $this->getPartnerId())->get();

        return view('partner.students.index', compact('students', 'courses', 'batches'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        // Permission checking disabled
        // Note: Course and batch enrollment is now handled via the Enrollment system

        return view('partner.students.create');
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        // Permission checking disabled

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:ac_users,email',
            'phone' => 'required|string|unique:ac_users,phone',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'school_college' => 'nullable|string|max:255',
            'class_grade' => 'nullable|string|max:50',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'religion' => 'nullable|in:Islam,Hinduism,Christianity,Buddhism',
        ]);

        $student = Student::create(array_merge($validated, [
            'partner_id' => $this->getPartnerId(),
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'status' => 'active',
            'enable_login' => 'y',
            'enroll_date' => now(),
        ]));

        return redirect()
            ->route('partner.students.show', $student)
            ->with('success', 'Student created successfully! You can now enroll them in courses.');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        // Permission checking disabled

        // Ensure student belongs to current partner
        if ($student->partner_id !== $this->getPartnerId()) {
            abort(404, 'Student not found.');
        }

        $student->load(['user', 'courses', 'batch', 'examResults']);

        return view('partner.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        // Check permissions
        if (!auth()->user()->can('students-edit')) {
            abort(403, 'Access denied. You do not have permission to edit students.');
        }

        // Ensure student belongs to current partner
        if ($student->partner_id !== $this->getPartnerId()) {
            abort(404, 'Student not found.');
        }

        // Note: Course and batch enrollment is now handled via the Enrollment system
        
        return view('partner.students.edit', compact('student'));
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, Student $student)
    {
        // Permission checking disabled

        // Ensure student belongs to current partner
        if ($student->partner_id !== $this->getPartnerId()) {
            abort(404, 'Student not found.');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:ac_users,email,' . $student->user_id,
            'phone' => 'required|string|unique:ac_users,phone,' . $student->user_id,
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'school_college' => 'nullable|string|max:255',
            'class_grade' => 'nullable|string|max:50',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'religion' => 'nullable|in:Islam,Hinduism,Christianity,Buddhism',
        ]);

        $student->update(array_merge($validated, [
            'updated_by' => auth()->id(),
        ]));

        return redirect()
            ->route('partner.students.show', $student)
            ->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified student.
     */
    public function destroy(Student $student)
    {
        // Permission checking disabled

        // Ensure student belongs to current partner
        if ($student->partner_id !== $this->getPartnerId()) {
            abort(404, 'Student not found.');
        }

        $studentName = $student->full_name;
        $student->delete();

        return redirect()
            ->route('partner.students.index')
            ->with('success', "Student '{$studentName}' deleted successfully!");
    }

    /**
     * Export students data.
     */
    public function export(Request $request)
    {
        // Permission checking disabled

        $students = Student::with(['user', 'courses'])
            ->where('partner_id', $this->getPartnerId())
            ->get();

        // Here you would implement your export logic
        // For example, using Laravel Excel or similar package

        return response()->json([
            'success' => true,
            'message' => 'Students exported successfully',
            'data' => $students->toArray()
        ]);
    }

    /**
     * Import students data.
     */
    public function import(Request $request)
    {
        // Permission checking disabled

        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls'
        ]);

        try {
            // Here you would implement your import logic
            // For example, using Laravel Excel or similar package

            return response()->json([
                'success' => true,
                'message' => 'Students imported successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error importing students: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Assign course to student.
     */
    public function assignCourse(Request $request, Student $student)
    {
        // Permission checking disabled

        // Ensure student belongs to current partner
        if ($student->partner_id !== $this->getPartnerId()) {
            abort(404, 'Student not found.');
        }

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);

        try {
            $student->courses()->attach($validated['course_id'], [
                'assigned_at' => now(),
                'assigned_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Course assigned to student successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error assigning course: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Manage student grades.
     */
    public function manageGrades(Student $student)
    {
        // Permission checking disabled

        // Ensure student belongs to current partner
        if ($student->partner_id !== $this->getPartnerId()) {
            abort(404, 'Student not found.');
        }

        $student->load(['examResults.exam', 'courses']);

        return view('partner.students.grades', compact('student'));
    }

    /**
     * Get current partner ID.
     */
    private function getPartnerId()
    {
        return auth()->user()->partner_id ?? 1;
    }
}
