<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        $user = $request->user();
        
        
        // If user is a partner, get partner data and show partner profile
        if ($user->role === 'partner' || $user->role === 'partner_admin' || request()->is('partner/*')) {
            $partner = $user->partner;
            
            // If partner doesn't exist, create a basic one
            if (!$partner) {
                $partner = new Partner();
                $partner->user_id = $user->id;
                $partner->name = $user->name;
                $partner->email = $user->email;
                $partner->status = 'active';
                $partner->partner_category = 'Institution';
                $partner->save();
            }
            
            // Refresh partner data to get latest information
            $partner = $partner->fresh();
            
            // Load partner statistics if partner exists and has an ID
            if ($partner->id) {
                $partner->loadCount([
                    'questions',
                    'exams',
                    'students',
                    'courses',
                    'batches',
                    'subjects',
                    'topics'
                ]);
                
                // Load relationships for more detailed stats
                $partner->load([
                    'courses' => function($query) {
                        $query->where('status', 'active');
                    },
                    'batches' => function($query) {
                        $query->where('flag', 'active');
                    },
                    'students' => function($query) {
                        $query->where('status', 'active')->limit(5);
                    }
                ]);
            } else {
                // Set default values for new partners
                $partner->questions_count = 0;
                $partner->exams_count = 0;
                $partner->students_count = 0;
                $partner->courses_count = 0;
                $partner->batches_count = 0;
                $partner->subjects_count = 0;
                $partner->topics_count = 0;
            }
            
            return view('partner.profile.show-partnar', compact('partner', 'user'));
        }
        
        return view('profile.show-partnar', [
            'user' => $user,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Check if user is accessing from partner area
        if (request()->is('partner/*')) {
            $partner = $user->partner;
            
            // If partner doesn't exist, create a basic one
            if (!$partner) {
                $partner = new Partner();
                $partner->user_id = $user->id;
                $partner->name = $user->name;
                $partner->email = $user->email;
                $partner->status = 'active';
                $partner->partner_category = 'Institution';
                $partner->save();
            }
            
        // Load divisions for cascading dropdown
        $divisions = \App\Models\Division::active()->ordered()->get()->map(function($division) {
            $division->display_name = $division->name . ($division->name_bangla ? ' (' . $division->name_bangla . ')' : '');
            return $division;
        });
        
        // Find current division, district, and upazila IDs based on stored names
        $currentDivisionId = null;
        $currentDistrictId = null;
        $currentUpazilaId = null;
        
        if ($partner->division) {
            $currentDivision = \App\Models\Division::where('name', $partner->division)->first();
            $currentDivisionId = $currentDivision ? $currentDivision->id : null;
        }
        
        if ($partner->district && $currentDivisionId) {
            $currentDistrict = \App\Models\District::where('name', $partner->district)
                ->where('division_id', $currentDivisionId)
                ->first();
            $currentDistrictId = $currentDistrict ? $currentDistrict->id : null;
        }
        
        if ($partner->upazila && $currentDistrictId) {
            $currentUpazila = \App\Models\Upazila::where('name', $partner->upazila)
                ->where('district_id', $currentDistrictId)
                ->first();
            $currentUpazilaId = $currentUpazila ? $currentUpazila->id : null;
        }
        
        return view('partner.profile.edit-partnar', compact('partner', 'divisions', 'currentDivisionId', 'currentDistrictId', 'currentUpazilaId'));
        }
        
        return view('profile.edit-partnar', [
            'user' => $user,
        ]);
    }

    /**
     * Display the user's profile (for user profile views).
     */
    public function showUser(Request $request): View
    {
        $user = $request->user();
        return view('partner.profile.show-user-profile', compact('user'));
    }

    /**
     * Display the user's profile edit form (for user profile views).
     */
    public function editUser(Request $request): View
    {
        $user = $request->user();
        return view('partner.profile.edit-user-profile', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateUser(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:ac_users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ], [
            'new_password.confirmed' => 'The new password confirmation does not match.',
        ]);

        // Update basic information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Handle password change if provided
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }
            $user->password = Hash::make($request->new_password);
        }

        // Reset email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('partner.profile.show-user-profile')->with('success', 'User profile updated successfully.');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Check if user is a partner and redirect accordingly
        if (request()->user()->role === 'partner') {
            return Redirect::route('partner.profile.edit-partnar')->with('status', 'profile-updated');
        }
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the partner's profile information.
     */
    public function updatePartner(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        
        // Check if user has partner role or is accessing from partner area
        if ($user->role !== 'partner' && !request()->is('partner/*')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            // Basic Information
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:partners,email,' . ($user->partner?->id ?? 0),
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'alternate_mobile' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'facebook_page' => 'nullable|url|max:255',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'institute_name' => 'nullable|string|max:255',
            'institute_name_bangla' => 'nullable|string|max:255',
            'slug_bangla' => 'nullable|string|max:255',
            
            // Contact Persons
            'owner_director_contact' => 'nullable|string|max:20',
            'alternate_contact_person' => 'nullable|string|max:255',
            'alternate_contact_no' => 'nullable|string|max:20',
            
            // Address
            'short_address' => 'nullable|string|max:500',
            'short_address_bangla' => 'nullable|string|max:500',
            'flat_house_no' => 'nullable|string|max:100',
            'village_road_no' => 'nullable|string|max:255',
            'post_office' => 'nullable|string|max:100',
            'post_code' => 'nullable|string|max:20',
            'district' => 'nullable|integer|exists:districts,id',
            'division' => 'nullable|integer|exists:divisions,id',
            'upazila' => 'nullable|integer|exists:upazilas,id',
            'city' => 'nullable|string|max:100',
            'map_location' => 'nullable|url',
            
            // Institute Details
            'eiin_no' => 'nullable|string|max:50',
            'trade_license_no' => 'nullable|string|max:50',
            'tin_no' => 'nullable|string|max:50',
            
            // Images
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Subscription
        ]);

        $partner = $user->partner;
        
        if (!$partner) {
            // Create new partner record if it doesn't exist
            $partner = new Partner();
            $partner->user_id = $user->id;
        }

        // Get all validated data
        $data = $request->except(['logo', 'cover_photo']);


        // Convert division, district, and upazila IDs to names
        if ($request->has('division') && $request->division) {
            $division = \App\Models\Division::find($request->division);
            $data['division'] = $division ? $division->name : null;
        }

        if ($request->has('district') && $request->district) {
            $district = \App\Models\District::find($request->district);
            $data['district'] = $district ? $district->name : null;
        }

        if ($request->has('upazila') && $request->upazila) {
            $upazila = \App\Models\Upazila::find($request->upazila);
            $data['upazila'] = $upazila ? $upazila->name : null;
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($partner->logo && \Storage::disk('public')->exists($partner->logo)) {
                \Storage::disk('public')->delete($partner->logo);
            }
            $logoPath = $request->file('logo')->store('partners', 'public');
            $data['logo'] = $logoPath;
        }

        // Handle cover photo upload
        if ($request->hasFile('cover_photo')) {
            // Delete old cover photo if exists
            if ($partner->cover_photo && \Storage::disk('public')->exists($partner->cover_photo)) {
                \Storage::disk('public')->delete($partner->cover_photo);
            }
            $coverPath = $request->file('cover_photo')->store('partners', 'public');
            $data['cover_photo'] = $coverPath;
        }

        // Update partner data
        $partner->fill($data);
        $partner->save();

        return redirect()->route('partner.profile.show-partnar')->with('success', 'Partner profile updated successfully! 🎉');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Get districts by division ID (AJAX)
     */
    public function getDistrictsByDivision($divisionId)
    {
        $districts = \App\Models\District::where('division_id', $divisionId)
            ->orderBy('name')
            ->get(['id', 'name', 'name_bangla'])
            ->map(function($district) {
                $district->display_name = $district->name . ($district->name_bangla ? ' (' . $district->name_bangla . ')' : '');
                return $district;
            });
            
        return response()->json(['districts' => $districts]);
    }

    /**
     * Get upazilas by district ID (AJAX)
     */
    public function getUpazilasByDistrict($districtId)
    {
        $upazilas = \App\Models\Upazila::where('district_id', $districtId)
            ->orderBy('name')
            ->get(['id', 'name', 'name_bangla'])
            ->map(function($upazila) {
                $upazila->display_name = $upazila->name . ($upazila->name_bangla ? ' (' . $upazila->name_bangla . ')' : '');
                return $upazila;
            });
            
        return response()->json(['upazilas' => $upazilas]);
    }
}
