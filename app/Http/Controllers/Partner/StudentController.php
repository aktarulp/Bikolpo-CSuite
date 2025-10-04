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
        // Check menu permission
        if (!auth()->user()->can('menu-students')) {
            abort(403, 'Access denied. You do not have permission to view students.');
        }

        $students = Student::with(['user', 'courses', 'batches'])
            ->where('partner_id', $this->getPartnerId())
            ->paginate(20);

        return view('partner.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        // Check both menu and button permissions
        if (!auth()->user()->can('menu-students')) {
            abort(403, 'Access denied. You do not have permission to access students.');
        }

        if (!auth()->user()->can('students-add')) {
            abort(403, 'Access denied. You do not have permission to add students.');
        }

        return view('partner.students.create');
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        // Check permissions before processing
        if (!auth()->user()->can('students-add')) {
            abort(403, 'Access denied. You do not have permission to add students.');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
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

        try {
            $student = Student::create(array_merge($validated, [
                'partner_id' => $this->getPartnerId(),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'status' => 'active',
                'enable_login' => 'y',
                'enroll_date' => now(),
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Student created successfully',
                'redirect' => route('partner.students.index')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating student: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        // Check permissions
        if (!auth()->user()->can('students-view')) {
            abort(403, 'Access denied. You do not have permission to view student details.');
        }

        // Ensure student belongs to current partner
        if ($student->partner_id !== $this->getPartnerId()) {
            abort(404, 'Student not found.');
        }

        $student->load(['user', 'courses', 'batches', 'examResults']);

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

        return view('partner.students.edit', compact('student'));
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, Student $student)
    {
        // Check permissions
        if (!auth()->user()->can('students-edit')) {
            abort(403, 'Access denied. You do not have permission to edit students.');
        }

        // Ensure student belongs to current partner
        if ($student->partner_id !== $this->getPartnerId()) {
            abort(404, 'Student not found.');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $student->user_id,
            'phone' => 'required|string|unique:users,phone,' . $student->user_id,
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

        try {
            $student->update(array_merge($validated, [
                'updated_by' => auth()->id(),
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully',
                'redirect' => route('partner.students.index')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating student: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified student.
     */
    public function destroy(Student $student)
    {
        // Check permissions
        if (!auth()->user()->can('students-delete')) {
            abort(403, 'Access denied. You do not have permission to delete students.');
        }

        // Ensure student belongs to current partner
        if ($student->partner_id !== $this->getPartnerId()) {
            abort(404, 'Student not found.');
        }

        try {
            $student->delete();

            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting student: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export students data.
     */
    public function export(Request $request)
    {
        // Check permissions
        if (!auth()->user()->can('students-export')) {
            abort(403, 'Access denied. You do not have permission to export students.');
        }

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
        // Check permissions
        if (!auth()->user()->can('students-import')) {
            abort(403, 'Access denied. You do not have permission to import students.');
        }

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
        // Check permissions
        if (!auth()->user()->can('students-assign-course')) {
            abort(403, 'Access denied. You do not have permission to assign courses to students.');
        }

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
        // Check permissions
        if (!auth()->user()->can('students-manage-grades')) {
            abort(403, 'Access denied. You do not have permission to manage student grades.');
        }

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
