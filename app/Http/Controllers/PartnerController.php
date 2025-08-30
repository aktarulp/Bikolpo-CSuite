<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::latest()->paginate(15);
        return view('partner.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('partner.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:partners,email',
            'phone' => 'nullable|string|regex:/^01[3-9][0-9]{8}$/|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        Partner::create($data);

        return redirect()->route('partner.partners.index')
            ->with('success', 'Partner created successfully.');
    }

    public function show(Partner $partner)
    {
        $partner->load(['questions', 'exams']);
        return view('partner.partners.show', compact('partner'));
    }

    public function edit(Partner $partner)
    {
        return view('partner.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:partners,email,' . $partner->id,
            'phone' => 'nullable|string|regex:/^01[3-9][0-9]{8}$/|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($data);

        return redirect()->route('partner.partners.index')
            ->with('success', 'Partner updated successfully.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()->route('partner.partners.index')
            ->with('success', 'Partner deleted successfully.');
    }

    public function assign(Partner $partner)
    {
        // This method can be used to assign students, courses, or other resources to a partner
        // For now, redirecting to the partner show page
        return redirect()->route('partner.partners.show', $partner)
            ->with('info', 'Partner assignment functionality coming soon.');
    }

    public function toggleStatus(Partner $partner)
    {
        $partner->update([
            'status' => $partner->status === 'active' ? 'inactive' : 'active'
        ]);

        $status = $partner->status === 'active' ? 'activated' : 'deactivated';
        return redirect()->route('partner.partners.index')
            ->with('success', "Partner {$status} successfully.");
    }
}
