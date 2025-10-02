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
                $q->where('full_name_en', 'like', "%{$search}%")
                  ->orWhere('full_name_bn', 'like', "%{$search}%")
                  ->orWhere('teacher_id', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
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
            'inactive_teachers' => Teacher::forPartner($partnerId)->where('status', 'Inactive')->count(),
            'on_leave_teachers' => Teacher::forPartner($partnerId)->where('status', 'On Leave')->count(),
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
            'full_name_en' => 'required|string|max:150',
            'full_name_bn' => 'nullable|string|max:150',
            'father_name' => 'nullable|string|max:150',
            'mother_name' => 'nullable|string|max:150',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'nullable|date|before:today',
            'blood_group' => 'nullable|string|max:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'mobile' => 'required|string|max:20|unique:teachers,mobile',
            'alt_mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100|unique:teachers,email',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_number' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'subject_specialization' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'experience_years' => 'nullable|integer|min:0',
            'status' => 'required|in:Active,Inactive,On Leave',
            'highest_degree' => 'nullable|string|max:100',
            'institution_name' => 'nullable|string|max:150',
            'salary_type' => 'nullable|in:Monthly,Per Class,Per Student',
            'salary_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|in:Cash,Bank,Mobile Banking',
            'account_details' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
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

            // Handle photo upload
            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('teachers/photos', 'public');
            }

            $teacher = Teacher::create($data);

            DB::commit();

            return redirect()->route('partner.teachers.index')
                           ->with('success', 'Teacher created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Failed to create teacher. Please try again.')
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
            'full_name_en' => 'required|string|max:150',
            'full_name_bn' => 'nullable|string|max:150',
            'father_name' => 'nullable|string|max:150',
            'mother_name' => 'nullable|string|max:150',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'nullable|date|before:today',
            'blood_group' => 'nullable|string|max:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'mobile' => ['required', 'string', 'max:20', Rule::unique('teachers')->ignore($teacher->id)],
            'alt_mobile' => 'nullable|string|max:20',
            'email' => ['nullable', 'email', 'max:100', Rule::unique('teachers')->ignore($teacher->id)],
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_number' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'subject_specialization' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'experience_years' => 'nullable|integer|min:0',
            'status' => 'required|in:Active,Inactive,On Leave',
            'highest_degree' => 'nullable|string|max:100',
            'institution_name' => 'nullable|string|max:150',
            'salary_type' => 'nullable|in:Monthly,Per Class,Per Student',
            'salary_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|in:Cash,Bank,Mobile Banking',
            'account_details' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
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

            // Handle photo upload
            if ($request->hasFile('photo')) {
                // Delete old photo
                if ($teacher->photo) {
                    Storage::disk('public')->delete($teacher->photo);
                }
                $data['photo'] = $request->file('photo')->store('teachers/photos', 'public');
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
                Storage::disk('public')->delete($teacher->photo);
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
     * Show assignment form for teacher.
     */
    public function assignments(Teacher $teacher)
    {
        // Ensure teacher belongs to current partner
        if ($teacher->partner_id !== auth()->user()->partner_id) {
            abort(403);
        }

        $partnerId = auth()->user()->partner_id;

        // Ensure teacher belongs to current partner
        if ($teacher->partner_id !== $partnerId) {
            abort(403, 'Unauthorized access to teacher assignments.');
        }

        $courses = Course::where('partner_id', $partnerId)->get();
        $subjects = Subject::where('partner_id', $partnerId)->with('course')->get();
        $students = Student::where('partner_id', $partnerId)->with(['course', 'batch'])->get();
        $batches = Batch::where('partner_id', $partnerId)->get();

        // Load teacher relationships with partner constraint
        $teacher->load([
            'courses' => function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId);
            },
            'subjects' => function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId);
            },
            'students' => function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId);
            },
            'batches' => function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId);
            }
        ]);

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

        $partnerId = auth()->user()->partner_id;

        // Validate that all requested IDs belong to current partner
        $courses = Course::where('partner_id', $partnerId)->pluck('id')->toArray();
        $subjects = Subject::where('partner_id', $partnerId)->pluck('id')->toArray();
        $students = Student::where('partner_id', $partnerId)->pluck('id')->toArray();
        $batches = Batch::where('partner_id', $partnerId)->pluck('id')->toArray();

        $validator = Validator::make($request->all(), [
            'courses' => 'nullable|array',
            'courses.*' => 'in:' . implode(',', $courses),
            'subjects' => 'nullable|array',
            'subjects.*' => 'in:' . implode(',', $subjects),
            'students' => 'nullable|array',
            'students.*' => 'in:' . implode(',', $students),
            'batches' => 'nullable|array',
            'batches.*' => 'in:' . implode(',', $batches),
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
                    // Ensure course belongs to current partner
                    $course = Course::where('id', $courseId)->where('partner_id', $partnerId)->first();
                    if ($course) {
                        $courseData[$courseId] = [
                            'assigned_by' => $assignedBy,
                            'assigned_at' => $assignedAt
                        ];
                    }
                }
                $teacher->courses()->sync($courseData);
            } else {
                $teacher->courses()->detach();
            }

            // Update subject assignments
            if ($request->has('subjects')) {
                $subjectData = [];
                foreach ($request->subjects as $subjectId) {
                    // Ensure subject belongs to current partner
                    $subject = Subject::where('id', $subjectId)->where('partner_id', $partnerId)->first();
                    if ($subject) {
                        $subjectData[$subjectId] = [
                            'assigned_by' => $assignedBy,
                            'assigned_at' => $assignedAt
                        ];
                    }
                }
                $teacher->subjects()->sync($subjectData);
            } else {
                $teacher->subjects()->detach();
            }

            // Update student assignments
            if ($request->has('students')) {
                $studentData = [];
                foreach ($request->students as $studentId) {
                    // Ensure student belongs to current partner
                    $student = Student::where('id', $studentId)->where('partner_id', $partnerId)->first();
                    if ($student) {
                        $studentData[$studentId] = [
                            'assigned_by' => $assignedBy,
                            'assigned_at' => $assignedAt
                        ];
                    }
                }
                $teacher->students()->sync($studentData);
            } else {
                $teacher->students()->detach();
            }

            // Update batch assignments
            if ($request->has('batches')) {
                $batchData = [];
                foreach ($request->batches as $batchId) {
                    // Ensure batch belongs to current partner
                    $batch = Batch::where('id', $batchId)->where('partner_id', $partnerId)->first();
                    if ($batch) {
                        $batchData[$batchId] = [
                            'assigned_by' => $assignedBy,
                            'assigned_at' => $assignedAt
                        ];
                    }
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
