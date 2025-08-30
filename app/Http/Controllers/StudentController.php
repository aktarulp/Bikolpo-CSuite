<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Traits\HasPartnerContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    use HasPartnerContext;

    public function index(Request $request)
    {
        $partnerId = $this->getPartnerId();
        
        $query = Student::where('partner_id', $partnerId);
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('school_college', 'like', "%{$search}%");
            });
        }
        
        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Course filter
        if ($request->filled('course_id') && $request->course_id !== 'all') {
            $query->where('course_id', $request->course_id);
        }
        
        // Batch filter
        if ($request->filled('batch_id') && $request->batch_id !== 'all') {
            $query->where('batch_id', $request->batch_id);
        }
        
        // Gender filter
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }
        
        $students = $query->with(['course', 'batch'])->latest()->paginate(15);
        
        // Get filter options
        $courses = \App\Models\Course::where('partner_id', $partnerId)->get();
        $batches = \App\Models\Batch::where('partner_id', $partnerId)->get();
        
        return view('partner.students.index', compact('students', 'courses', 'batches'));
    }

    public function create()
    {
        return view('partner.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'student_id' => 'nullable|string|max:50|unique:students,student_id',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|regex:/^01[3-9][0-9]{8}$/|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'school_college' => 'nullable|string|max:255',
            'class_grade' => 'nullable|string|max:50',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|regex:/^01[3-9][0-9]{8}$/|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'nullable|exists:courses,id',
            'batch_id' => 'nullable|exists:batches,id',
        ], [
            'phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
            'parent_phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
            'course_id.exists' => 'The selected course is invalid.',
            'batch_id.exists' => 'The selected batch is invalid.',
        ]);

        $data = $request->all();

        // Get the authenticated user's partner ID using the trait
        $data['partner_id'] = $this->getPartnerId();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        Student::create($data);

        return redirect()->route('partner.students.index')
            ->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['examResults.exam']);
        return view('partner.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('partner.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'student_id' => 'nullable|string|max:50|unique:students,student_id,' . $student->id,
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|regex:/^01[3-9][0-9]{8}$/|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'school_college' => 'nullable|string|max:255',
            'class_grade' => 'nullable|string|max:50',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|regex:/^01[3-9][0-9]{8}$/|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'nullable|exists:courses,id',
            'batch_id' => 'nullable|exists:batches,id',
        ], [
            'phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
            'parent_phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
            'course_id.exists' => 'The selected course is invalid.',
            'batch_id.exists' => 'The selected batch is invalid.',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student->update($data);

        return redirect()->route('partner.students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }

        $student->delete();

        return redirect()->route('partner.students.index')
            ->with('success', 'Student deleted successfully.');
    }

    public function assignment(Request $request)
    {
        try {
            $partnerId = $this->getPartnerId();
            

            
            // Handle form submission for updating assignment
            if ($request->isMethod('post') || $request->isMethod('put')) {
                // Check if this is an assignment update request
                if ($request->has('_action') && $request->_action === 'update_assignment') {
                    $request->validate([
                        'student_id' => 'required|exists:students,id',
                        'batch_id' => 'required|exists:batches,id',
                        'course_id' => 'required|exists:courses,id',
                    ]);
                    
                    $student = Student::findOrFail($request->student_id);
                    
                    // Verify the student belongs to the partner
                    if ($student->partner_id !== $partnerId) {
                        return back()->with('error', 'Unauthorized access to student.');
                    }
                    
                    $student->update([
                        'batch_id' => $request->batch_id,
                        'course_id' => $request->course_id,
                        'assignment_date' => now(),
                    ]);
                    
                    return back()->with('success', 'Student assignment updated successfully.');
                }
            }
            

            
            $students = Student::with(['batch', 'course'])
                ->where('partner_id', $partnerId)
                ->latest()
                ->paginate(15);

            $batches = \App\Models\Batch::where('partner_id', $partnerId)->get();
            $courses = \App\Models\Course::where('partner_id', $partnerId)->get();
            


            return view('partner.students.assignment', compact('students', 'batches', 'courses'));
        } catch (\Exception $e) {
            \Log::error('Student assignment error: ' . $e->getMessage());

            return back()->with('error', 'Error loading student assignment: ' . $e->getMessage());
        }
    }

    public function updateAssignment(Request $request, Student $student)
    {
        $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $student->update([
            'batch_id' => $request->batch_id,
            'course_id' => $request->course_id,
            'assignment_date' => now(),
        ]);

        return redirect()->route('partner.students.assignment')
            ->with('success', 'Student assignment updated successfully.');
    }

    public function bulkAssignment(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'course_id' => 'required|exists:courses,id',
            'student_ids' => 'required|string',
        ]);

        // Decode the JSON string of student IDs
        $studentIds = json_decode($request->student_ids, true);
        
        if (!is_array($studentIds) || empty($studentIds)) {
            return redirect()->route('partner.students.assignment')
                ->with('error', 'No valid student IDs provided.');
        }

        // Validate that all student IDs exist and belong to the partner
        $students = Student::whereIn('id', $studentIds)
            ->where('partner_id', $this->getPartnerId());

        $students->update([
            'batch_id' => $request->batch_id,
            'course_id' => $request->course_id,
            'assignment_date' => now(),
        ]);

        return redirect()->route('partner.students.assignment')
            ->with('success', 'Bulk assignment completed successfully.');
    }
}
