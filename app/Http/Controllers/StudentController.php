<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Traits\HasPartnerContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    use HasPartnerContext;

    public function index()
    {
        $students = Student::latest()->paginate(15);
        return view('partner.students.index', compact('students'));
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
}
