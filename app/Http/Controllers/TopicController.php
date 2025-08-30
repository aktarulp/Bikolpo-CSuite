<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Subject;
use App\Traits\HasPartnerContext;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    use HasPartnerContext;

    public function index()
    {
        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();
        
        // Only show topics for the logged-in partner
        $topics = Topic::with(['subject.courses'])
            ->where('partner_id', $partnerId)
            ->latest()
            ->paginate(15);
            
        return view('partner.topics.index', compact('topics'));
    }

    public function create()
    {
        $partnerId = $this->getPartnerId();
        $subjects = Subject::where('status', 'active')
            ->with('courses')
            ->whereHas('courses', function($query) use ($partnerId) {
                $query->where('courses.partner_id', $partnerId);
            })
            ->get();
        return view('partner.topics.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:topics,code',
            'description' => 'nullable|string',
            'chapter_number' => 'nullable|integer|min:1',
        ]);

        // Get the authenticated user's partner ID using the trait
        $partnerId = $this->getPartnerId();
        $userId = auth()->id();

        // Create topic with partner_id and created_by
        Topic::create([
            'subject_id' => $request->subject_id,
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'chapter_number' => $request->chapter_number,
            'partner_id' => $partnerId,
            'created_by' => $userId,
            'status' => 'active',
        ]);

        return redirect()->route('partner.topics.index')
            ->with('success', 'Topic created successfully.');
    }

    public function show(Topic $topic)
    {
        $topic->load(['subject.courses', 'questions']);
        return view('partner.topics.show', compact('topic'));
    }

    public function edit(Topic $topic)
    {
        $partnerId = $this->getPartnerId();
        $subjects = Subject::where('status', 'active')
            ->with('courses')
            ->whereHas('courses', function($query) use ($partnerId) {
                $query->where('courses.partner_id', $partnerId);
            })
            ->get();
        return view('partner.topics.edit', compact('topic', 'subjects'));
    }

    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:topics,code,' . $topic->id,
            'description' => 'nullable|string',
            'chapter_number' => 'nullable|integer|min:1',
        ]);

        $topic->update($request->all());

        return redirect()->route('partner.topics.index')
            ->with('success', 'Topic updated successfully.');
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();

        return redirect()->route('partner.topics.index')
            ->with('success', 'Topic deleted successfully.');
    }
}
