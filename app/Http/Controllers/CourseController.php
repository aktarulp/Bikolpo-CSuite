<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Validation\Rule;
use App\Traits\HasPartnerContext;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use HasPartnerContext;


    public function index()
    {
        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();
        
        // Only show active courses for the logged-in partner
        $courses = Course::withCount(['subjects', 'batches', 'studentsEnrolled as enrollments_count'])
            ->where('partner_id', $partnerId)
            ->where('status', 'active')
            ->where('flag', 'active')
            ->latest()
            ->paginate(15);
            
        return view('partner.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('partner.courses.create');
    }

    public function show(Course $course)
    {
        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();
        
        // Verify the course belongs to the authenticated partner
        if ($course->partner_id !== $partnerId) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        // Load related data
        $course->load(['subjects', 'batches' => function($query) {
            $query->withCount(['enrolledStudents as students_count']);
        }, 'studentsEnrolled as enrollments']);
        
        return view('partner.courses.show', compact('course'));
    }

    public function store(Request $request)
    {
        // Get the authenticated user's partner ID using the trait (needed for scoped unique rule)
        $partnerId = $this->getPartnerId();

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('courses', 'code')->where(fn($q) => $q->where('partner_id', $partnerId)),
            ],
            'description' => 'nullable|string',
        ]);

        $userId = auth()->id();

        // Create course with partner_id and created_by
        Course::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'partner_id' => $partnerId,
            'created_by' => $userId,
            'status' => 'active',
        ]);

        return redirect()->route('partner.courses.index')
            ->with('success', 'Course created successfully.');
    }


    public function edit(Course $course)
    {
        // Ensure the course belongs to the logged-in partner
        $partnerId = $this->getPartnerId();
        if ($course->partner_id !== $partnerId) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        return view('partner.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        // Ensure the course belongs to the logged-in partner
        $partnerId = $this->getPartnerId();
        if ($course->partner_id !== $partnerId) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('courses', 'code')
                    ->ignore($course->id, 'id')
                    ->where(fn($q) => $q->where('partner_id', $partnerId)),
            ],
            'description' => 'nullable|string',
        ]);

        $course->update($request->only(['name','code','description']));

        return redirect()->route('partner.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        // Ensure the course belongs to the logged-in partner
        $partnerId = $this->getPartnerId();
        if ($course->partner_id !== $partnerId) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        // Check if course has any subjects
        $subjectsCount = $course->subjects()->count();
        
        if ($subjectsCount > 0) {
            return redirect()->route('partner.courses.index')
                ->with('error', "Cannot delete this course. It has {$subjectsCount} subject(s) associated with it. Please delete or move the subjects first.");
        }
        
        // Soft delete by changing flag to 'deleted'
        $course->flag = 'deleted';
        $course->save();

        return redirect()->route('partner.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
