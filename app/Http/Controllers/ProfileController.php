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
        if ($user->role === 'partner') {
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
            
            // Load partner statistics if partner exists and has an ID
            if ($partner->id) {
                $partner->loadCount([
                    'questions as questions_count',
                    'exams as exams_count',
                    'students as students_count',
                    'courses as courses_count'
                ]);
            } else {
                // Set default values for new partners
                $partner->questions_count = 0;
                $partner->exams_count = 0;
                $partner->students_count = 0;
                $partner->courses_count = 0;
            }
            
            return view('partner.profile.show-partnar', compact('partner'));
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
        
        // If user is a partner, get partner data and show partner profile edit
        if ($user->role === 'partner') {
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
            
            return view('partner.profile.edit-partnar', compact('partner'));
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
        
        if ($user->role !== 'partner') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:partners,email,' . ($user->partner?->id ?? 0),
            'phone' => 'nullable|string|regex:/^01[3-9][0-9]{8}$/|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01XXXXXXXXX)',
        ]);

        $partner = $user->partner;
        
        if (!$partner) {
            // Create new partner record if it doesn't exist
            $partner = new Partner();
            $partner->user_id = $user->id;
        }

        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                \Storage::disk('public')->delete($partner->logo);
            }
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->fill($data);
        $partner->save();

        return Redirect::route('partner.profile.show-partnar')->with('success', 'Partner profile updated successfully.');
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
}
