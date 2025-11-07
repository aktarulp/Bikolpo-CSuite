<?php

namespace App\Http\Controllers;

use App\Models\QCReator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QCReatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qcreators = QCReator::latest()->paginate(15);
        return view('system-admin.qcreators.sa-index', compact('qcreators'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system-admin.qcreators.sa-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'organization' => 'nullable|string|max:255',
            'experiences' => 'nullable|string',
            'remarks' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'nullable|email|unique:qcreators,email',
            'phone' => 'nullable|string|unique:qcreators,phone',
        ]);

        $data = $request->except('photo');
        
        // Handle photo upload - DIRECT STORAGE IN PUBLIC/UPLOADS FOR HOSTINGER
        if ($request->hasFile('photo')) {
            // Store directly in public/uploads/qcreators/ for Hostinger compatibility
            $uploadsDir = public_path('uploads/qcreators');
            
            // Ensure uploads directory exists
            if (!is_dir($uploadsDir)) {
                mkdir($uploadsDir, 0755, true);
            }
            
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
            $uploadsPath = $uploadsDir . '/' . $filename;
            
            // Move file directly to uploads directory
            $request->file('photo')->move($uploadsDir, $filename);
            
            // Store path in database (relative to uploads directory)
            $data['photo'] = 'qcreators/' . $filename;
        }

        QCReator::create($data);

        return redirect()->route('system-admin.qcreators.index')
            ->with('success', 'QCReator created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QCReator  $qCReator
     * @return \Illuminate\Http\Response
     */
    public function show(QCReator $qcreator)
    {
        return view('system-admin.qcreators.sa-show', compact('qcreator'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QCReator  $qCReator
     * @return \Illuminate\Http\Response
     */
    public function edit(QCReator $qcreator)
    {
        return view('system-admin.qcreators.sa-edit', compact('qcreator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QCReator  $qCReator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QCReator $qcreator)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'organization' => 'nullable|string|max:255',
            'experiences' => 'nullable|string',
            'remarks' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'nullable|email|unique:qcreators,email,'.$qcreator->id,
            'phone' => 'nullable|string|unique:qcreators,phone,'.$qcreator->id,
        ]);

        $data = $request->except('photo');
        
        // Handle photo upload - DIRECT STORAGE IN PUBLIC/UPLOADS FOR HOSTINGER
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($qcreator->photo) {
                $oldPhotoPath = public_path('uploads/' . $qcreator->photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }
            
            // Store directly in public/uploads/qcreators/ for Hostinger compatibility
            $uploadsDir = public_path('uploads/qcreators');
            
            // Ensure uploads directory exists
            if (!is_dir($uploadsDir)) {
                mkdir($uploadsDir, 0755, true);
            }
            
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
            $uploadsPath = $uploadsDir . '/' . $filename;
            
            // Move file directly to uploads directory
            $request->file('photo')->move($uploadsDir, $filename);
            
            // Store path in database (relative to uploads directory)
            $data['photo'] = 'qcreators/' . $filename;
        }

        $qcreator->update($data);

        return redirect()->route('system-admin.qcreators.index')
            ->with('success', 'QCReator updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QCReator  $qCReator
     * @return \Illuminate\Http\Response
     */
    public function destroy(QCReator $qcreator)
    {
        // Delete photo if exists
        if ($qcreator->photo) {
            $oldPhotoPath = public_path('uploads/' . $qcreator->photo);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
        }
        
        $qcreator->delete();

        return redirect()->route('system-admin.qcreators.index')
            ->with('success', 'QCReator deleted successfully.');
    }
}