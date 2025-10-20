<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Batch;
use App\Models\ExamResult;
use App\Traits\HasPartnerContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
        $partnerId = $this->getPartnerId();
        $courses = \App\Models\Course::where('partner_id', $partnerId)->get();
        $batches = \App\Models\Batch::where('partner_id', $partnerId)->get();
        
        return view('partner.students.create', compact('courses', 'batches'));
    }

    public function store(Request $request)
    {
        $partnerId = $this->getPartnerId();
        
        // Set partner_id in request for validation rules
        $request->merge(['partner_id' => $partnerId]);
        
        // Basic validation rules first
        $rules = [
            'full_name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'father_phone' => 'nullable|string|max:20',
            'mother_phone' => 'nullable|string|max:20',
            'guardian_phone' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date',
            'enroll_date' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'school_college' => 'nullable|string|max:255',
            'class_grade' => 'nullable|string|max:50',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'guardian' => 'nullable|in:Father,Mother,Other',
            'guardian_name' => 'nullable|string|max:255',
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'religion' => 'required|in:Islam,Hinduism,Christianity,Buddhism',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'required|exists:batches,id',
        ];
        
        // Add phone number regex validation
        $rules['phone'] .= '|regex:/^01[3-9][0-9]{8}$/';
        $rules['father_phone'] .= '|regex:/^01[3-9][0-9]{8}$/';
        $rules['mother_phone'] .= '|regex:/^01[3-9][0-9]{8}$/';
        $rules['guardian_phone'] .= '|regex:/^01[3-9][0-9]{8}$/';
        
        // Add partner-scoped unique constraints
        $rules['student_id'] .= '|unique:students,student_id,NULL,id,partner_id,' . $partnerId;
        $rules['email'] .= '|unique:students,email,NULL,id,partner_id,' . $partnerId;
        $rules['phone'] .= '|unique:students,phone,NULL,id,partner_id,' . $partnerId;
        $rules['father_phone'] .= '|unique:students,father_phone,NULL,id,partner_id,' . $partnerId;
        $rules['mother_phone'] .= '|unique:students,mother_phone,NULL,id,partner_id,' . $partnerId;
        $rules['guardian_phone'] .= '|unique:students,guardian_phone,NULL,id,partner_id,' . $partnerId;
        
        $request->validate($rules, [
            'email.unique' => 'This email address is already registered in your organization.',
            'phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
            'phone.unique' => 'This phone number is already registered in your organization.',
            'father_phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
            'mother_phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
            'guardian_phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
            'guardian_phone.unique' => 'This guardian phone number is already registered.',
            'course_id.exists' => 'The selected course is invalid.',
            'batch_id.exists' => 'The selected batch is invalid.',
        ]);

        $data = $request->all();

        // Get the authenticated user's partner ID using the trait
        $data['partner_id'] = $this->getPartnerId();
        
        // Set the created_by field to the current authenticated user
        $data['created_by'] = auth()->id();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('student-photos', 'public');
        }

        try {
            $student = Student::create($data);
            
            return redirect()->route('partner.students.index')
                ->with('success', 'Student created successfully.');
        } catch (\Exception $e) {
            \Log::error('Student creation failed', [
                'error' => $e->getMessage(),
                'data' => $data,
                'partner_id' => $partnerId
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create student: ' . $e->getMessage()]);
        }
    }

    public function show(Student $student)
    {
        // For partner view
        $student->load(['examResults.exam']);
        return view('partner.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $student->load(['course', 'batch']); // Load relationships
        $courses = Course::where('partner_id', auth()->user()->partner_id)->get();
        $batches = Batch::where('partner_id', auth()->user()->partner_id)->get();
        
        return view('partner.students.edit', compact('student', 'courses', 'batches'));
    }

    public function update(Request $request, Student $student)
    {
        $partnerId = $this->getPartnerId();
        
        // Set partner_id in request for validation rules
        $request->merge(['partner_id' => $partnerId]);
        
        // Basic validation rules for update
        $rules = [
            'full_name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'father_phone' => 'nullable|string|max:20',
            'mother_phone' => 'nullable|string|max:20',
            'guardian_phone' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date',
            'enroll_date' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'school_college' => 'nullable|string|max:255',
            'class_grade' => 'nullable|string|max:50',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'guardian' => 'nullable|in:Father,Mother,Other',
            'guardian_name' => 'nullable|string|max:255',
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'religion' => 'required|in:Islam,Hinduism,Christianity,Buddhism',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'required|exists:batches,id',
        ];
        
        // Add phone number regex validation
        $rules['phone'] .= '|regex:/^01[3-9][0-9]{8}$/';
        $rules['father_phone'] .= '|regex:/^01[3-9][0-9]{8}$/';
        $rules['mother_phone'] .= '|regex:/^01[3-9][0-9]{8}$/';
        $rules['guardian_phone'] .= '|regex:/^01[3-9][0-9]{8}$/';
        
        // Add partner-scoped unique constraints for update
        $rules['student_id'] .= '|unique:students,student_id,' . $student->id . ',id,partner_id,' . $partnerId;
        $rules['email'] .= '|unique:students,email,' . $student->id . ',id,partner_id,' . $partnerId;
        $rules['phone'] .= '|unique:students,phone,' . $student->id . ',id,partner_id,' . $partnerId;
        $rules['father_phone'] .= '|unique:students,father_phone,' . $student->id . ',id,partner_id,' . $partnerId;
        $rules['mother_phone'] .= '|unique:students,mother_phone,' . $student->id . ',id,partner_id,' . $partnerId;
        $rules['guardian_phone'] .= '|unique:students,guardian_phone,' . $student->id . ',id,partner_id,' . $partnerId;

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($student->photo) {
                Storage::delete($student->photo);
            }
            
            // Store new photo
            $data['photo'] = $request->file('photo')->store('student-photos', 'public');
        }

        // Update student
        $student->update($data);

        return redirect()->route('partner.students.index')
            ->with('success', 'Student updated successfully');
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

    /**
     * Get student record for the authenticated user using multiple approaches
     */
    private function getStudentForUser($user)
    {
        // Try to get student record through relationship first
        $student = $user->student;
        
        // If relationship doesn't work, try to find student by student_id
        if (!$student && $user->student_id) {
            $student = Student::find($user->student_id);
        }
        
        // If still no student, try to find by user_id
        if (!$student) {
            $student = Student::where('user_id', $user->id)->first();
        }
        
        return $student;
    }

    /**
     * Display the student's own profile
     */
    public function showProfile()
    {
        $user = Auth::user();
        
        // Try to get student record using multiple approaches
        $student = $this->getStudentForUser($user);
        
        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Student profile not found.');
        }
        
        // Load relationships
        $student->load(['course', 'batch']);
        
        // Calculate exam statistics
        $examStats = [
            'total' => ExamResult::where('student_id', $student->id)->count(),
            'passed' => ExamResult::where('student_id', $student->id)
                ->where('percentage', '>=', 50)
                ->count(),
            'average' => round((float) (ExamResult::where('student_id', $student->id)
                ->whereNotNull('percentage')
                ->avg('percentage') ?? 0), 1),
        ];
        
        return view('student.profile.show', compact('student', 'examStats'));
    }

    /**
     * Show the form for editing the student's own profile
     */
    public function editProfile()
    {
        $user = Auth::user();
        
        // Try to get student record using multiple approaches
        $student = $this->getStudentForUser($user);
        
        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Student profile not found.');
        }
        
        return view('student.profile.edit', compact('student'));
    }

    /**
     * Update the student's own profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Try to get student record using multiple approaches
        $student = $this->getStudentForUser($user);
        
        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Student profile not found.');
        }
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|unique:students,email,'.$student->id,
            'phone' => 'required|string|regex:/^01[3-9][0-9]{8}$/|max:20|unique:students,phone,'.$student->id,
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'school_college' => 'nullable|string|max:255',
            'class_grade' => 'nullable|string|max:50',
            'father_name' => 'nullable|string|max:255',
            'father_phone' => 'nullable|string|regex:/^01[3-9][0-9]{8}$/|max:20',
            'mother_name' => 'nullable|string|max:255',
            'mother_phone' => 'nullable|string|regex:/^01[3-9][0-9]{8}$/|max:20',
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'religion' => 'required|in:Islam,Hinduism,Christianity,Buddhism',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'email.unique' => 'This email address is already registered.',
            'phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
            'phone.unique' => 'This phone number is already registered.',
            'father_phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
            'mother_phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
        ]);

        $data = $request->except(['photo']);
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            
            // Store new photo
            $data['photo'] = $request->file('photo')->store('student-photos', 'public');
        }

        // Update student
        $student->update($data);

        return redirect()->route('student.profile.show')
            ->with('success', 'Profile updated successfully.');
    }
}