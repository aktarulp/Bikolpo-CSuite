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
        $batches = Batch::byPartner($this->getPartnerId())
            ->where('flag', 'active')
            ->withCount('students')
            ->latest()
            ->paginate(15);
            
        return view('partner.batches.index', compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('partner.batches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $partnerId = $this->getPartnerId();

        $request->validate([
            'name' => [
                'required','string','max:255',
                Rule::unique('batches', 'name')->where(fn($q) => $q->where('partner_id', $partnerId)
                                                       ->where('year', $request->input('year'))),
            ],
            'year' => 'required|integer|min:2000|max:2030',
        ]);

        $batch = Batch::create([
            'name' => $request->name,
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
    public function show(Batch $batch)
    {
        // Ensure the batch belongs to the logged-in partner
        if ($batch->partner_id !== $this->getPartnerId()) {
            abort(403, 'Unauthorized access to this batch.');
        }
        
        // Load students relationship
        $batch->load(['students' => function($query) {
            $query->orderBy('full_name');
        }]);
        
        return view('partner.batches.show', compact('batch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        // Ensure the batch belongs to the logged-in partner
        if ($batch->partner_id !== $this->getPartnerId()) {
            abort(403, 'Unauthorized access to this batch.');
        }
        
        return view('partner.batches.edit', compact('batch'));
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
            'name' => [
                'required','string','max:255',
                Rule::unique('batches', 'name')
                    ->ignore($batch->id, 'id')
                    ->where(fn($q) => $q->where('partner_id', $partnerId)
                                       ->where('year', $request->input('year'))),
            ],
            'year' => 'required|integer|min:2000|max:2030',
            'status' => 'required|in:active,inactive',
        ]);

        $batch->update($request->only(['name', 'year', 'status']));

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
