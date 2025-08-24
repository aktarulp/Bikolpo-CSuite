<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
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
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'school_college' => 'nullable|string|max:255',
            'class_grade' => 'nullable|string|max:50',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

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
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'school_college' => 'nullable|string|max:255',
            'class_grade' => 'nullable|string|max:50',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

    /**
     * Show the student's own profile.
     */
    public function showOwnProfile()
    {
        $user = auth()->user();
        $student = $user->student;
        
        if (!$student) {
            return redirect()->route('student.profile.edit')
                ->with('error', 'Please complete your student profile first.');
        }
        
        return view('student.profile.show', compact('student'));
    }

    /**
     * Show the form for editing the student's own profile.
     */
    public function editOwnProfile()
    {
        $user = auth()->user();
        $student = $user->student;
        
        if (!$student) {
            return redirect()->route('student.profile.edit')
                ->with('error', 'Please complete your student profile first.');
        }
        
        return view('student.profile.edit', compact('student'));
    }

    /**
     * Update the student's own profile.
     */
    public function updateOwnProfile(Request $request)
    {
        $user = auth()->user();
        $student = $user->student;
        
        if (!$student) {
            return redirect()->route('student.profile.edit')
                ->with('error', 'Please complete your student profile first.');
        }
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'school_college' => 'nullable|string|max:255',
            'class_grade' => 'nullable|string|max:50',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student->update($data);

        return redirect()->route('student.profile.show')
            ->with('success', 'Profile updated successfully.');
    }
}
