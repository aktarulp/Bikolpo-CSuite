<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Validation\Rule;
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
        
        // Only show active topics for the logged-in partner (flag = 'active')
        $topics = Topic::with(['subject.course'])
            ->where('partner_id', $partnerId)
            ->where('flag', 'active')
            ->latest()
            ->paginate(15);
            
        return view('partner.topics.index', compact('topics'));
    }

    public function create()
    {
        $partnerId = $this->getPartnerId();
        $subjects = Subject::where('flag', 'active')
            ->with('course')
            ->where('partner_id', $partnerId)
            ->get();
        return view('partner.topics.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        // Get partner for scoped unique rule
        $partnerId = $this->getPartnerId();

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('topics', 'code')->where(fn($q) => $q->where('partner_id', $partnerId)),
            ],
            'description' => 'nullable|string',
            'chapter_number' => 'nullable|integer|min:1',
        ]);

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


    public function edit(Topic $topic)
    {
        $partnerId = $this->getPartnerId();
        $subjects = Subject::where('status', 'active')
            ->where('flag', 'active')
            ->with('course')
            ->where('partner_id', $partnerId)
            ->get();
        return view('partner.topics.edit', compact('topic', 'subjects'));
    }

    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('topics', 'code')
                    ->ignore($topic->id, 'id')
                    ->where(fn($q) => $q->where('partner_id', $this->getPartnerId())),
            ],
            'description' => 'nullable|string',
            'chapter_number' => 'nullable|integer|min:1',
        ]);

        $topic->update($request->only(['subject_id','name','code','description','chapter_number']));

        return redirect()->route('partner.topics.index')
            ->with('success', 'Topic updated successfully.');
    }

    public function destroy(Topic $topic)
    {
        // Check if topic has questions
        $questionsCount = $topic->questions()->count();
        
        if ($questionsCount > 0) {
            return redirect()->route('partner.topics.index')
                ->with('error', "Cannot delete this topic. It has {$questionsCount} question(s) associated with it. Please delete or move the questions first.");
        }
        
        // No child items, mark as deleted instead of hard delete
        $topic->update(['flag' => 'deleted']);

        return redirect()->route('partner.topics.index')
            ->with('success', 'Topic deleted successfully.');
    }
}
