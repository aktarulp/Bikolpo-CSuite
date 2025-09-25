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

    public function updateProfile(Request $request)
    {
        $partner = $request->user()->partner; // Get the authenticated user's partner record

        if (!$partner) {
            return response()->json(['message' => 'Partner profile not found.'], 404);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'institute_name_bangla' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:partners,slug,' . $partner->id,
            'slug_bangla' => 'nullable|string|max:255',
            'established_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'short_address' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_contact_person' => 'nullable|string|max:255',
            'primary_contact_no' => 'nullable|string|regex:/^01[3-9][0-9]{8}$/|max:20',
            'alternate_contact_person' => 'nullable|string|max:255',
            'alternate_contact_no' => 'nullable|string|regex:/^01[3-9][0-9]{8}$/|max:20',
            'email' => 'required|email|unique:partners,email,' . $partner->id,
            'website' => 'nullable|url|max:255',
            'facebook_page' => 'nullable|url|max:255',
            // 'address' => 'nullable|string|max:255',
            'flat_house_no' => 'nullable|string|max:255',
            'village_road_no' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'post_office' => 'nullable|string|max:255',
            'post_code' => 'nullable|string|max:255',
            'upazila_p_s' => 'nullable|string|max:255',
            // 'upazila' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'division' => 'nullable|string|max:255',
            'map_location' => 'nullable|url',
            'subscription_plan' => 'nullable|string|max:255',
            'subscription_plan_id' => 'nullable|string|max:255',
            'subscription_start_date' => 'nullable|date',
            'subscription_end_date' => 'nullable|date|after_or_equal:subscription_start_date',
            'payment_status' => 'required|in:pending,paid,overdue,cancelled',
            'status' => 'required|in:active,inactive',
            'flag' => 'required|in:active,deleted',
        ];

        $validatedData = $request->validate($rules);

        try {
            // Handle Logo Upload and Deletion
            if ($request->hasFile('logo')) {
                if ($partner->logo) {
                    Storage::disk('public')->delete($partner->logo);
                }
                $validatedData['logo'] = $request->file('logo')->store('partners', 'public');
            } elseif ($request->has('delete_logo') && $request->input('delete_logo') === '1') {
                if ($partner->logo) {
                    Storage::disk('public')->delete($partner->logo);
                }
                $validatedData['logo'] = null;
            } else {
                // If no new file and not marked for deletion, keep existing logo path
                unset($validatedData['logo']); // Prevent nulling out if not updated/deleted
            }

            $partner->update($validatedData);
            return response()->json(['message' => 'Partner profile updated successfully!', 'partner' => $partner], 200);
        } catch (\Exception $e) {
            \Log::error('Error updating partner profile: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'Failed to update partner profile.', 'error' => $e->getMessage()], 500);
        }
    }
}
