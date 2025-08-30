<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Traits\HasPartnerContext;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use HasPartnerContext;

    public function index()
    {
        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();
        
        // Only show courses for the logged-in partner
        $courses = Course::withCount('subjects')
            ->where('partner_id', $partnerId)
            ->latest()
            ->paginate(15);
            
        return view('partner.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('partner.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code',
            'description' => 'nullable|string',
        ]);

        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();
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

    public function show(Course $course)
    {
        // Ensure the course belongs to the logged-in partner
        $partnerId = $this->getPartnerId();
        if ($course->partner_id !== $partnerId) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $course->load(['subjects.topics']);
        return view('partner.courses.show', compact('course'));
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
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'description' => 'nullable|string',
        ]);

        $course->update($request->all());

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
        
        $course->delete();

        return redirect()->route('partner.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
