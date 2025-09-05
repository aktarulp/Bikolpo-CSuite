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
        $subjects = Subject::with(['course'])
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
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code',
            'description' => 'nullable|string',
        ]);

        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();
        $userId = auth()->id();

        // Create subject with direct course relationship
        $subject = Subject::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'partner_id' => $partnerId,
            'created_by' => $userId,
            'status' => 'active',
        ]);

        return redirect()->route('partner.subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    public function show(Subject $subject)
    {
        $subject->load(['course', 'topics']);
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
            
        return view('partner.subjects.edit', compact('subject', 'courses'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code,' . $subject->id,
            'description' => 'nullable|string',
        ]);

        // Update subject with direct course relationship
        $subject->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'course_id' => $request->course_id,
        ]);

        return redirect()->route('partner.subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('partner.subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
}
