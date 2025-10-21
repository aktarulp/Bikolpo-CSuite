<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Traits\HasPartnerContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BatchController extends Controller
{
    use HasPartnerContext;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch courses with their batches grouped
        $courses = \App\Models\Course::where('partner_id', $this->getPartnerId())
            ->where('status', 'active')
            ->with(['batches' => function($query) {
                $query->where('flag', 'active')
                    ->withCount('students')
                    ->orderBy('year', 'desc')
                    ->orderBy('name');
            }])
            ->orderBy('name')
            ->get();
        
        // Get total batch count for stats
        $totalBatches = Batch::byPartner($this->getPartnerId())
            ->where('flag', 'active')
            ->count();
            
        return view('partner.batches.index', compact('courses', 'totalBatches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = \App\Models\Course::where('partner_id', $this->getPartnerId())
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
            
        return view('partner.batches.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $partnerId = $this->getPartnerId();

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => [
                'required','string','max:255',
                Rule::unique('batches', 'name')->where(fn($q) => $q->where('partner_id', $partnerId)
                                                       ->where('year', $request->input('year'))
                                                       ->where('course_id', $request->input('course_id'))),
            ],
            'year' => 'required|integer|min:2000|max:2030',
        ]);

        $batch = Batch::create([
            'name' => $request->name,
            'course_id' => $request->course_id,
            'year' => $request->year,
            'status' => 'active', // Default to active
            'partner_id' => $partnerId,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('partner.batches.index')
            ->with('success', 'Batch created successfully!');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        // Ensure the batch belongs to the logged-in partner
        if ($batch->partner_id !== $this->getPartnerId()) {
            abort(403, 'Unauthorized access to this batch.');
        }
        
        $courses = \App\Models\Course::where('partner_id', $this->getPartnerId())
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
        
        return view('partner.batches.edit', compact('batch', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Batch $batch)
    {
        // Ensure the batch belongs to the logged-in partner
        if ($batch->partner_id !== $this->getPartnerId()) {
            abort(403, 'Unauthorized access to this batch.');
        }
        
        $partnerId = $this->getPartnerId();

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => [
                'required','string','max:255',
                Rule::unique('batches', 'name')
                    ->ignore($batch->id, 'id')
                    ->where(fn($q) => $q->where('partner_id', $partnerId)
                                       ->where('year', $request->input('year'))
                                       ->where('course_id', $request->input('course_id'))),
            ],
            'year' => 'required|integer|min:2000|max:2030',
            'status' => 'required|in:active,inactive',
        ]);

        $batch->update($request->only(['name', 'course_id', 'year', 'status']));

        return redirect()->route('partner.batches.index')
            ->with('success', 'Batch updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Batch $batch)
    {
        // Ensure the batch belongs to the logged-in partner
        if ($batch->partner_id !== $this->getPartnerId()) {
            abort(403, 'Unauthorized access to this batch.');
        }
        
        // Check if batch has any students
        $studentsCount = $batch->students()->count();
        
        if ($studentsCount > 0) {
            return redirect()->route('partner.batches.index')
                ->with('error', "Cannot delete this batch. It has {$studentsCount} student(s) associated with it. Please delete or move the students first.");
        }
        
        // No students associated, mark as deleted instead of hard delete
        $batch->update(['flag' => 'deleted']);
        
        return redirect()->route('partner.batches.index')
            ->with('success', 'Batch deleted successfully!');
    }

    public function restore($id)
    {
        $batch = Batch::findOrFail($id);
        $batch->update(['flag' => 'active']);
        
        return redirect()->route('partner.batches.index')
            ->with('success', 'Batch restored successfully!');
    }

    public function trashed()
    {
        $deletedBatches = Batch::byPartner($this->getPartnerId())
            ->where('flag', 'deleted')
            ->latest()
            ->paginate(15);
            
        return view('partner.batches.trashed', compact('deletedBatches'));
    }
}
