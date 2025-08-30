<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Course;
use App\Traits\HasPartnerContext;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    use HasPartnerContext;

    public function index()
    {
        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();
        
        // Only show subjects for the logged-in partner
        $subjects = Subject::with(['courses'])
            ->where('partner_id', $partnerId)
            ->withCount('topics')
            ->latest()
            ->paginate(15);
            
        return view('partner.subjects.index', compact('subjects'));
    }

    public function create()
    {
        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();
        
        // Only show courses for the logged-in partner
        $courses = Course::where('status', 'active')
            ->where('partner_id', $partnerId)
            ->get();
            
        return view('partner.subjects.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_ids' => 'required|array|min:1',
            'course_ids.*' => 'exists:courses,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code',
            'description' => 'nullable|string',
        ]);

        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();
        $userId = auth()->id();

        // Create subject without course_id (will be linked via pivot table)
        $subject = Subject::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'partner_id' => $partnerId,
            'created_by' => $userId,
            'status' => 'active',
        ]);

        // Attach the subject to multiple courses
        $subject->courses()->attach($request->course_ids, ['partner_id' => $partnerId]);

        return redirect()->route('partner.subjects.index')
            ->with('success', 'Subject created successfully and linked to ' . count($request->course_ids) . ' course(s).');
    }

    public function show(Subject $subject)
    {
        $subject->load(['courses', 'topics']);
        return view('partner.subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();
        
        // Only show courses for the logged-in partner
        $courses = Course::where('status', 'active')
            ->where('partner_id', $partnerId)
            ->get();
            
        // Get the currently selected course IDs for this subject
        $selectedCourseIds = $subject->courses->pluck('id')->toArray();
            
        return view('partner.subjects.edit', compact('subject', 'courses', 'selectedCourseIds'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'course_ids' => 'required|array|min:1',
            'course_ids.*' => 'exists:courses,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code,' . $subject->id,
            'description' => 'nullable|string',
        ]);

        // Update subject basic information
        $subject->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
        ]);

        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();

        // Sync the courses (this will add new relationships and remove old ones)
        $subject->courses()->sync($request->course_ids, ['partner_id' => $partnerId]);

        return redirect()->route('partner.subjects.index')
            ->with('success', 'Subject updated successfully and courses synchronized.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('partner.subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
}
