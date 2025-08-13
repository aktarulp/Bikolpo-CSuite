<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partnerId = 1; // For now, using default partner ID
        $batches = Batch::byPartner($partnerId)
            ->visible()
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
        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:2030',
        ]);

        $batch = Batch::create([
            'name' => $request->name,
            'year' => $request->year,
            'status' => 'active', // Default to active
            'partner_id' => 1, // For now, using default partner ID
        ]);

        return redirect()->route('partner.batches.index')
            ->with('success', 'Batch created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Batch $batch)
    {
        return view('partner.batches.show', compact('batch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        return view('partner.batches.edit', compact('batch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Batch $batch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:2030',
            'status' => 'required|in:active,inactive',
        ]);

        $batch->update([
            'name' => $request->name,
            'year' => $request->year,
            'status' => $request->status,
        ]);

        return redirect()->route('partner.batches.index')
            ->with('success', 'Batch updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Batch $batch)
    {
        // Soft delete - update flag to 'deleted' instead of removing from database
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
        $partnerId = 1; // For now, using default partner ID
        $deletedBatches = Batch::byPartner($partnerId)
            ->where('flag', 'deleted')
            ->latest()
            ->paginate(15);
            
        return view('partner.batches.trashed', compact('deletedBatches'));
    }
}
