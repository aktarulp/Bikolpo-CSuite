<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index(Request $request)
    {
        $partnerId = auth()->user()->partner_id;
        
        $query = Teacher::with(['courses', 'subjects', 'students', 'batches'])
                        ->forPartner($partnerId);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('teacher_id', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('employment_status', $request->status);
        }

        // Department filter
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $teachers = $query->paginate(12);

        // Get filter options
        $departments = Teacher::forPartner($partnerId)
                             ->whereNotNull('department')
                             ->distinct()
                             ->pluck('department');

        $stats = [
            'total_teachers' => Teacher::forPartner($partnerId)->count(),
            'active_teachers' => Teacher::forPartner($partnerId)->active()->count(),
            'inactive_teachers' => Teacher::forPartner($partnerId)->where('employment_status', 'Inactive')->count(),
            'on_leave_teachers' => Teacher::forPartner($partnerId)->where('employment_status', 'On Leave')->count(),
        ];

        return view('partner.teachers.index', compact('teachers', 'departments', 'stats'));
    }

    /**
     * Show the form for creating a new teacher.
     */
    public function create()
    {
        return view('partner.teachers.create');
    }

    /**
     * Store a newly created teacher.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|string|max:255|unique:teachers,teacher_id',
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'phone' => 'required|string|max:255|unique:teachers,phone',
            'alternate_phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:teachers,email',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:255',
            'emergency_contact_relation' => 'required|string|max:255',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'religion' => 'nullable|in:Islam,Hinduism,Christianity,Buddhism,Other',
            'marital_status' => 'nullable|in:Single,Married,Divorced,Widowed',
            'national_id' => 'nullable|string|max:255',
            'passport_number' => 'nullable|string|max:255',
            'tin_number' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'employee_type' => 'nullable|string|max:255',
            'employment_status' => 'required|in:Active,Inactive,On Leave',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'bank_routing_number' => 'nullable|string|max:255',
            'subject_specialization' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'highest_degree' => 'nullable|string|max:255',
            'institution_name' => 'nullable|string|max:255',
            'salary_type' => 'nullable|string|max:255',
            'salary_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|max:255',
            'account_details' => 'nullable|string|max:255',
            'present_address' => 'nullable|string|max:500',
            'permanent_address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['partner_id'] = auth()->user()->partner_id;
            $data['created_by'] = auth()->id();

            // Handle photo upload - DIRECT STORAGE IN PUBLIC/UPLOADS FOR HOSTINGER
            if ($request->hasFile('photo')) {
                // Store directly in public/uploads/teachers/ for Hostinger compatibility
                $uploadsDir = public_path('uploads/teachers');
                
                // Ensure uploads directory exists
                if (!is_dir($uploadsDir)) {
                    mkdir($uploadsDir, 0755, true);
                }
                
                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
                $uploadsPath = $uploadsDir . '/' . $filename;
                
                // Move file directly to uploads directory
                $request->file('photo')->move($uploadsDir, $filename);
                
                // Store path in database (relative to uploads directory)
                $data['photo'] = 'teachers/' . $filename;
            }

            $teacher = Teacher::create($data);

            DB::commit();

            return redirect()->route('partner.teachers.index')
                           ->with('success', 'Teacher created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Teacher creation failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'partner_id' => auth()->user()->partner_id ?? null,
                'data' => $data ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                           ->with('error', 'Failed to create teacher: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Display the specified teacher.
     */
    public function show(Teacher $teacher)
    {
        // Ensure teacher belongs to current partner
        if ($teacher->partner_id !== auth()->user()->partner_id) {
            abort(403);
        }

        $teacher->load(['courses', 'subjects', 'students', 'batches', 'creator', 'updater']);

        return view('partner.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified teacher.
     */
    public function edit(Teacher $teacher)
    {
        // Ensure teacher belongs to current partner
        if ($teacher->partner_id !== auth()->user()->partner_id) {
            abort(403);
        }


        return view('partner.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified teacher.
     */
    public function update(Request $request, Teacher $teacher)
    {
        // Ensure teacher belongs to current partner
        if ($teacher->partner_id !== auth()->user()->partner_id) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'teacher_id' => ['required', 'string', 'max:255', Rule::unique('teachers')->ignore($teacher->id)],
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'phone' => ['required', 'string', 'max:255', Rule::unique('teachers')->ignore($teacher->id)],
            'alternate_phone' => 'nullable|string|max:255',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('teachers')->ignore($teacher->id)],
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:255',
            'emergency_contact_relation' => 'required|string|max:255',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'religion' => 'nullable|in:Islam,Hinduism,Christianity,Buddhism,Other',
            'marital_status' => 'nullable|in:Single,Married,Divorced,Widowed',
            'national_id' => 'nullable|string|max:255',
            'passport_number' => 'nullable|string|max:255',
            'tin_number' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'employee_type' => 'nullable|string|max:255',
            'employment_status' => 'required|in:Active,Inactive,On Leave',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'bank_routing_number' => 'nullable|string|max:255',
            'subject_specialization' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'highest_degree' => 'nullable|string|max:255',
            'institution_name' => 'nullable|string|max:255',
            'salary_type' => 'nullable|string|max:255',
            'salary_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|max:255',
            'account_details' => 'nullable|string|max:255',
            'present_address' => 'nullable|string|max:500',
            'permanent_address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['updated_by'] = auth()->id();

            // Handle photo upload - DIRECT STORAGE IN PUBLIC/UPLOADS FOR HOSTINGER
            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($teacher->photo) {
                    $oldPhotoPath = public_path('uploads/' . $teacher->photo);
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }
                
                // Store directly in public/uploads/teachers/ for Hostinger compatibility
                $uploadsDir = public_path('uploads/teachers');
                
                // Ensure uploads directory exists
                if (!is_dir($uploadsDir)) {
                    mkdir($uploadsDir, 0755, true);
                }
                
                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
                $uploadsPath = $uploadsDir . '/' . $filename;
                
                // Move file directly to uploads directory
                $request->file('photo')->move($uploadsDir, $filename);
                
                // Store path in database (relative to uploads directory)
                $data['photo'] = 'teachers/' . $filename;
            }

            $teacher->update($data);

            DB::commit();

            return redirect()->route('partner.teachers.show', $teacher)
                           ->with('success', 'Teacher updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Failed to update teacher. Please try again.')
                           ->withInput();
        }
    }

    /**
     * Remove the specified teacher.
     */
    public function destroy(Teacher $teacher)
    {
        // Ensure teacher belongs to current partner
        if ($teacher->partner_id !== auth()->user()->partner_id) {
            abort(403);
        }

        try {
            DB::beginTransaction();

            // Delete photo if exists
            if ($teacher->photo) {
                $photoPath = public_path('uploads/' . $teacher->photo);
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

            // Soft delete the teacher
            $teacher->delete();

            DB::commit();

            return redirect()->route('partner.teachers.index')
                           ->with('success', 'Teacher deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Failed to delete teacher. Please try again.');
        }
    }

    /**
     * Show soft deleted teachers.
     */
    public function trashed()
    {
        $teachers = Teacher::onlyTrashed()
                          ->where('partner_id', auth()->user()->partner_id)
                          ->orderBy('deleted_at', 'desc')
                          ->paginate(20);

        return view('partner.teachers.trashed', compact('teachers'));
    }

    /**
     * Restore a soft deleted teacher.
     */
    public function restore($id)
    {
        $teacher = Teacher::onlyTrashed()->findOrFail($id);
        
        // Ensure teacher belongs to current partner
        if ($teacher->partner_id !== auth()->user()->partner_id) {
            abort(403);
        }

        try {
            $teacher->restore();
            
            return redirect()->route('partner.teachers.index')
                           ->with('success', 'Teacher restored successfully!');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to restore teacher. Please try again.');
        }
    }

    /**
     * Permanently delete a teacher.
     */
    public function forceDelete($id)
    {
        $teacher = Teacher::onlyTrashed()->findOrFail($id);
        
        // Ensure teacher belongs to current partner
        if ($teacher->partner_id !== auth()->user()->partner_id) {
            abort(403);
        }

        try {
            DB::beginTransaction();

            // Delete photo if exists
            if ($teacher->photo) {
                $photoPath = public_path('uploads/' . $teacher->photo);
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

            $teacher->forceDelete();

            DB::commit();

            return redirect()->route('partner.teachers.trashed')
                           ->with('success', 'Teacher permanently deleted!');
                           
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Failed to permanently delete teacher. Please try again.');
        }
    }

    /**
     * Show assignment form for teacher.
     */
    public function assignments(Teacher $teacher)
    {
        // Ensure teacher belongs to current partner
        if ($teacher->partner_id !== auth()->user()->partner_id) {
            abort(403);
        }

        $partnerId = auth()->user()->partner_id;

        $courses = Course::where('partner_id', $partnerId)->get();
        $subjects = Subject::where('partner_id', $partnerId)->get();
        $students = Student::where('partner_id', $partnerId)->get();
        $batches = Batch::where('partner_id', $partnerId)->get();

        $teacher->load(['courses', 'subjects', 'students', 'batches']);

        return view('partner.teachers.assignments', compact('teacher', 'courses', 'subjects', 'students', 'batches'));
    }

    /**
     * Update teacher assignments.
     */
    public function updateAssignments(Request $request, Teacher $teacher)
    {
        // Ensure teacher belongs to current partner
        if ($teacher->partner_id !== auth()->user()->partner_id) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:subjects,id',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
            'batches' => 'nullable|array',
            'batches.*' => 'exists:batches,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            DB::beginTransaction();

            $assignedBy = auth()->id();
            $assignedAt = now();

            // Update course assignments
            if ($request->has('courses')) {
                $courseData = [];
                foreach ($request->courses as $courseId) {
                    $courseData[$courseId] = [
                        'assigned_by' => $assignedBy,
                        'assigned_at' => $assignedAt
                    ];
                }
                $teacher->courses()->sync($courseData);
            } else {
                $teacher->courses()->detach();
            }

            // Update subject assignments
            if ($request->has('subjects')) {
                $subjectData = [];
                foreach ($request->subjects as $subjectId) {
                    $subjectData[$subjectId] = [
                        'assigned_by' => $assignedBy,
                        'assigned_at' => $assignedAt
                    ];
                }
                $teacher->subjects()->sync($subjectData);
            } else {
                $teacher->subjects()->detach();
            }

            // Update student assignments
            if ($request->has('students')) {
                $studentData = [];
                foreach ($request->students as $studentId) {
                    $studentData[$studentId] = [
                        'assigned_by' => $assignedBy,
                        'assigned_at' => $assignedAt
                    ];
                }
                $teacher->students()->sync($studentData);
            } else {
                $teacher->students()->detach();
            }

            // Update batch assignments
            if ($request->has('batches')) {
                $batchData = [];
                foreach ($request->batches as $batchId) {
                    $batchData[$batchId] = [
                        'assigned_by' => $assignedBy,
                        'assigned_at' => $assignedAt
                    ];
                }
                $teacher->batches()->sync($batchData);
            } else {
                $teacher->batches()->detach();
            }

            DB::commit();

            return redirect()->route('partner.teachers.show', $teacher)
                           ->with('success', 'Teacher assignments updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Failed to update assignments. Please try again.');
        }
    }
}

