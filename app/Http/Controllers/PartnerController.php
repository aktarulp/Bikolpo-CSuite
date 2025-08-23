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
            'address' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'institute_name' => 'nullable|string|max:255',
            'institute_name_bangla' => 'nullable|string|max:255',
            'partner_category' => 'nullable|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'owner_director_name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:partners,slug',
            'slug_bangla' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'alternate_mobile' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'facebook_page' => 'nullable|string|max:255',
            'primary_contact_person' => 'nullable|string|max:255',
            'primary_contact_no' => 'nullable|string|max:20',
            'alternate_contact_person' => 'nullable|string|max:255',
            'alternate_contact_no' => 'nullable|string|max:20',
            'division' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'upazila' => 'nullable|string|max:100',
            'upazila_p_s' => 'nullable|string|max:255',
            'post_office' => 'nullable|string|max:255',
            'post_code' => 'nullable|string|max:20',
            'village_road_no' => 'nullable|string|max:255',
            'flat_house_no' => 'nullable|string|max:255',
            'short_address' => 'nullable|string|max:500',
            'map_location' => 'nullable|url|max:500',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'year_of_establishment' => 'nullable|integer|max:' . date('Y'),
            'eiin_no' => 'nullable|string|max:100',
            'trade_license_no' => 'nullable|string|max:100',
            'tin_no' => 'nullable|string|max:100',
            'category' => 'nullable|string|in:school,college,university,coaching_center,training_institute,other',
            'target_group' => 'nullable|string|in:primary,secondary,higher_secondary,university,adult,all',
            'subjects_offered' => 'nullable|string',
            'class_range' => 'nullable|string|max:100',
            'total_teachers' => 'nullable|integer|min:0',
            'total_students' => 'nullable|integer|min:0',
            'batch_system' => 'nullable|boolean',
            'course_offers' => 'nullable|array',
            'course_offers.*' => 'nullable|string|max:255',
            'custom_courses' => 'nullable|string|max:1000',
            'subscription_plan' => 'nullable|string|max:255',
            'subscription_plan_id' => 'nullable|string|max:255',
            'subscription_start_date' => 'nullable|date',
            'subscription_end_date' => 'nullable|string|max:255',
            'payment_status' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        
        // Handle checkbox
        $data['batch_system'] = $request->has('batch_system');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }



        Partner::create($data);

        return redirect()->route('partner.partners.index')
            ->with('success', 'Partner created successfully.');
    }

    public function show(Partner $partner)
    {
        $partner->load(['questions', 'questionSets', 'exams']);
        return view('partner.partners.show', compact('partner'));
    }

    public function edit(Partner $partner)
    {
        return view('partner.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'address' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'institute_name' => 'nullable|string|max:255',
            'institute_name_bangla' => 'nullable|string|max:255',
            'partner_category' => 'nullable|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'owner_director_name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:partners,slug,' . $partner->id,
            'slug_bangla' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'alternate_mobile' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'facebook_page' => 'nullable|string|max:255',
            'primary_contact_person' => 'nullable|string|max:255',
            'primary_contact_no' => 'nullable|string|max:20',
            'alternate_contact_person' => 'nullable|string|max:255',
            'alternate_contact_no' => 'nullable|string|max:20',
            'division' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'upazila' => 'nullable|string|max:100',
            'upazila_p_s' => 'nullable|string|max:255',
            'post_office' => 'nullable|string|max:255',
            'post_code' => 'nullable|string|max:20',
            'village_road_no' => 'nullable|string|max:255',
            'flat_house_no' => 'nullable|string|max:255',
            'short_address' => 'nullable|string|max:500',
            'map_location' => 'nullable|url|max:500',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'year_of_establishment' => 'nullable|integer|min:1900|max:' . date('Y'),
            'eiin_no' => 'nullable|string|max:100',
            'trade_license_no' => 'nullable|string|max:100',
            'tin_no' => 'nullable|string|max:100',
            'category' => 'nullable|string|in:school,college,university,coaching_center,training_institute,other',
            'target_group' => 'nullable|string|in:primary,secondary,higher_secondary,university,adult,all',
            'subjects_offered' => 'nullable|string',
            'class_range' => 'nullable|string|max:100',
            'total_teachers' => 'nullable|integer|min:0',
            'total_students' => 'nullable|integer|min:0',
            'batch_system' => 'nullable|boolean',
            'course_offers' => 'nullable|array',
            'course_offers.*' => 'nullable|string|max:255',
            'custom_courses' => 'nullable|string|max:1000',
            'subscription_plan' => 'nullable|string|max:255',
            'subscription_plan_id' => 'nullable|string|max:255',
            'subscription_start_date' => 'nullable|date',
            'subscription_end_date' => 'nullable|date',
            'payment_status' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        
        // Handle checkbox
        $data['batch_system'] = $request->has('batch_system');

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

    /**
     * Show the authenticated partner's profile
     */
    public function showProfile()
    {
        $partner = auth()->user()->partner;
        return view('partner.profile.show', compact('partner'));
    }

    /**
     * Show the form for editing the authenticated partner's profile
     */
    public function editProfile()
    {
        $partner = auth()->user()->partner;
        return view('partner.profile.edit', compact('partner'));
    }

    /**
     * Update the authenticated partner's profile
     */
    public function updateProfile(Request $request)
    {
        // Add debugging
        \Log::info('Partner Profile Update Request Started', [
            'user_id' => auth()->id(),
            'request_data' => $request->except(['logo', '_token'])
        ]);
        
        $partner = auth()->user()->partner;
        
        if (!$partner) {
            \Log::error('No partner record found for user', ['user_id' => auth()->id()]);
            return redirect()->back()->with('error', 'Partner profile not found.');
        }
        
        try {
            $request->validate([
                'address' => 'nullable|string|max:500',
                'description' => 'nullable|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

                'institute_name' => 'nullable|string|max:255',
                'institute_name_bangla' => 'nullable|string|max:255',
                'partner_category' => 'nullable|string|max:255',
                'owner_name' => 'nullable|string|max:255',
                'owner_director_name' => 'nullable|string|max:255',
                'slug' => 'nullable|string|max:255|unique:partners,slug,' . $partner->id,
                'slug_bangla' => 'nullable|string|max:255',
                'mobile' => 'nullable|string|max:20',
                'alternate_mobile' => 'nullable|string|max:20',
                'website' => 'nullable|url|max:255',
                'facebook_page' => 'nullable|string|max:255',
                'primary_contact_person' => 'nullable|string|max:255',
                'primary_contact_no' => 'nullable|string|max:20',
                'alternate_contact_person' => 'nullable|string|max:255',
                'alternate_contact_no' => 'nullable|string|max:20',
                'division' => 'nullable|string|max:100',
                'district' => 'nullable|string|max:100',
                'upazila' => 'nullable|string|max:100',
                'upazila_p_s' => 'nullable|string|max:255',
                'post_office' => 'nullable|string|max:255',
                'post_code' => 'nullable|string|max:20',
                'village_road_no' => 'nullable|string|max:255',
                'flat_house_no' => 'nullable|string|max:255',
                'short_address' => 'nullable|string|max:500',
                'map_location' => 'nullable|url|max:500',
                'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
                'year_of_establishment' => 'nullable|integer|min:1900|max:' . date('Y'),
                'eiin_no' => 'nullable|string|max:100',
                'trade_license_no' => 'nullable|string|max:100',
                'tin_no' => 'nullable|string|max:100',
                'category' => 'nullable|string|in:school,college,university,coaching_center,training_institute,other',
                'target_group' => 'nullable|string|in:primary,secondary,higher_secondary,university,adult,all',
                'subjects_offered' => 'nullable|string',
                'class_range' => 'nullable|string|max:100',
                'total_teachers' => 'nullable|integer|min:0',
                'total_students' => 'nullable|integer|min:0',
                'batch_system' => 'nullable|boolean',
                'course_offers' => 'nullable|array',
                'course_offers.*' => 'nullable|string|max:255',
                'custom_courses' => 'nullable|string|max:1000',
                'subscription_plan' => 'nullable|string|max:255',
                'subscription_plan_id' => 'nullable|string|max:255',
                'subscription_start_date' => 'nullable|date',
                'subscription_end_date' => 'nullable|date',
                'payment_status' => 'nullable|string|max:255',
                'status' => 'nullable|string|max:255',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Partner Profile Validation Failed', [
                'user_id' => auth()->id(),
                'errors' => $e->errors()
            ]);
            throw $e;
        }

        $data = $request->all();
        
        // Handle checkbox
        $data['batch_system'] = $request->has('batch_system');

        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($data);

        \Log::info('Partner Profile Updated Successfully', [
            'user_id' => auth()->id(),
            'partner_id' => $partner->id
        ]);

        return redirect()->route('partner.profile.show')
            ->with('success', 'Profile updated successfully.');
    }
}
