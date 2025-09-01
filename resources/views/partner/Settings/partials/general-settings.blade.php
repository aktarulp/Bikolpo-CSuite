<div class="space-y-8">
    <!-- Institution Information -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Institution Information</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Basic details about your educational institution</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="institution_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Institution Name</label>
                    <input type="text" id="institution_name" name="institution_name" value="{{ $partner->institute_name ?? $partner->name ?? '' }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
                <div>
                    <label for="institution_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Institution Type</label>
                    <select id="institution_type" name="institution_type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        <option value="school" {{ ($partner->category ?? '') == 'school' ? 'selected' : '' }}>School</option>
                        <option value="college" {{ ($partner->category ?? '') == 'college' ? 'selected' : '' }}>College</option>
                        <option value="university" {{ ($partner->category ?? '') == 'university' ? 'selected' : '' }}>University</option>
                        <option value="coaching_center" {{ ($partner->category ?? '') == 'coaching_center' ? 'selected' : '' }}>Coaching Center</option>
                        <option value="training_institute" {{ ($partner->category ?? '') == 'training_institute' ? 'selected' : '' }}>Training Institute</option>
                    </select>
                </div>
                <div>
                    <label for="established_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Established Year</label>
                    <input type="number" id="established_year" name="established_year" value="{{ $partner->year_of_establishment ?? $partner->established_year ?? '' }}" min="1900" max="{{ date('Y') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
                <div>
                    <label for="accreditation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Accreditation</label>
                    <input type="text" id="accreditation" name="accreditation" value="{{ $partner->eiin_no ?? '' }}" placeholder="e.g., NAAC, UGC, etc." class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200" placeholder="Brief description of your institution">{{ $partner->description ?? '' }}</textarea>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Contact Information</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">How students and parents can reach you</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Primary Email</label>
                    <input type="email" id="email" name="email" value="{{ $partner->email ?? '' }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Primary Phone</label>
                    <input type="tel" id="phone" name="phone" value="{{ $partner->phone ?? '' }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Website</label>
                    <input type="url" id="website" name="website" value="{{ $partner->website ?? '' }}" placeholder="https://example.com" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
                <div>
                    <label for="social_media" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Social Media</label>
                    <input type="text" id="social_media" name="social_media" value="{{ $partner->social_media ?? '' }}" placeholder="Facebook, Instagram, LinkedIn" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
            </div>
        </div>
    </div>

    <!-- Address Information -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Address Information</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Physical location of your institution</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="address_line1" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address Line 1</label>
                    <input type="text" id="address_line1" name="address_line1" value="{{ $partner->address ?? '' }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
                <div>
                    <label for="address_line2" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address Line 2</label>
                    <input type="text" id="address_line2" name="address_line2" value="{{ $partner->short_address ?? '' }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">City</label>
                    <input type="text" id="city" name="city" value="{{ $partner->city ?? '' }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">State/Province</label>
                    <input type="text" id="state" name="state" value="{{ $partner->division ?? '' }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Postal Code</label>
                    <input type="text" id="postal_code" name="postal_code" value="{{ $partner->post_code ?? '' }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country</label>
                    <select id="country" name="country" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        <option value="Bangladesh" {{ ($partner->district ?? '') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                        <option value="India" {{ ($partner->district ?? '') == 'India' ? 'selected' : '' }}>India</option>
                        <option value="Pakistan" {{ ($partner->country ?? '') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                        <option value="Nepal" {{ ($partner->country ?? '') == 'Nepal' ? 'selected' : '' }}>Nepal</option>
                        <option value="Sri Lanka" {{ ($partner->country ?? '') == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                        <option value="Other" {{ ($partner->country ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Business Information -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Business Information</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Operational and business details</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="business_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Business Hours</label>
                    <input type="text" id="business_hours" name="business_hours" value="{{ $partner->business_hours ?? '' }}" placeholder="e.g., Mon-Fri 9:00 AM - 5:00 PM" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
                <div>
                    <label for="timezone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Timezone</label>
                    <select id="timezone" name="timezone" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        <option value="Asia/Dhaka" {{ ($partner->timezone ?? '') == 'Asia/Dhaka' ? 'selected' : '' }}>Asia/Dhaka (GMT+6)</option>
                        <option value="Asia/Kolkata" {{ ($partner->timezone ?? '') == 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata (GMT+5:30)</option>
                        <option value="Asia/Karachi" {{ ($partner->timezone ?? '') == 'Asia/Karachi' ? 'selected' : '' }}>Asia/Karachi (GMT+5)</option>
                        <option value="Asia/Kathmandu" {{ ($partner->timezone ?? '') == 'Asia/Kathmandu' ? 'selected' : '' }}>Asia/Kathmandu (GMT+5:45)</option>
                        <option value="Asia/Colombo" {{ ($partner->timezone ?? '') == 'Asia/Colombo' ? 'selected' : '' }}>Asia/Colombo (GMT+5:30)</option>
                    </select>
                </div>
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Currency</label>
                    <select id="currency" name="currency" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        <option value="BDT" {{ ($partner->currency ?? '') == 'BDT' ? 'selected' : '' }}>BDT (Bangladeshi Taka)</option>
                        <option value="INR" {{ ($partner->currency ?? '') == 'INR' ? 'selected' : '' }}>INR (Indian Rupee)</option>
                        <option value="PKR" {{ ($partner->currency ?? '') == 'PKR' ? 'selected' : '' }}>PKR (Pakistani Rupee)</option>
                        <option value="NPR" {{ ($partner->currency ?? '') == 'NPR' ? 'selected' : '' }}>NPR (Nepalese Rupee)</option>
                        <option value="LKR" {{ ($partner->currency ?? '') == 'LKR' ? 'selected' : '' }}>LKR (Sri Lankan Rupee)</option>
                        <option value="USD" {{ ($partner->currency ?? '') == 'USD' ? 'selected' : '' }}>USD (US Dollar)</option>
                    </select>
                </div>
                <div>
                    <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Primary Language</label>
                    <select id="language" name="language" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        <option value="en" {{ ($partner->language ?? '') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="bn" {{ ($partner->language ?? '') == 'bn' ? 'selected' : '' }}>Bengali</option>
                        <option value="hi" {{ ($partner->language ?? '') == 'hi' ? 'selected' : '' }}>Hindi</option>
                        <option value="ur" {{ ($partner->language ?? '') == 'ur' ? 'selected' : '' }}>Urdu</option>
                        <option value="ne" {{ ($partner->language ?? '') == 'ne' ? 'selected' : '' }}>Nepali</option>
                        <option value="si" {{ ($partner->language ?? '') == 'si' ? 'selected' : '' }}>Sinhala</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- System Preferences -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">System Preferences</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Application behavior and display settings</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="date_format" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date Format</label>
                    <select id="date_format" name="date_format" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        <option value="Y-m-d" {{ ($partner->date_format ?? '') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                        <option value="d/m/Y" {{ ($partner->date_format ?? '') == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                        <option value="m/d/Y" {{ ($partner->date_format ?? '') == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                        <option value="d-m-Y" {{ ($partner->date_format ?? '') == 'd-m-Y' ? 'selected' : '' }}>DD-MM-YYYY</option>
                    </select>
                </div>
                <div>
                    <label for="time_format" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Time Format</label>
                    <select id="time_format" name="time_format" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        <option value="12" {{ ($partner->time_format ?? '') == '12' ? 'selected' : '' }}>12-hour (AM/PM)</option>
                        <option value="24" {{ ($partner->time_format ?? '') == '24' ? 'selected' : '' }}>24-hour</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Auto-save Forms</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Automatically save form data as you type</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="auto_save" class="sr-only peer" {{ ($partner->auto_save ?? true) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primaryGreen/20 dark:peer-focus:ring-primaryGreen/30 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primaryGreen"></div>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Email Notifications</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Receive email notifications for important events</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="email_notifications" class="sr-only peer" {{ ($partner->email_notifications ?? true) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primaryGreen/20 dark:peer-focus:ring-primaryGreen/30 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primaryGreen"></div>
                </label>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="flex justify-end">
        <button type="button" onclick="saveGeneralSettings()" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-primaryGreen hover:bg-primaryGreen/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Save General Settings
        </button>
    </div>
</div>

<script>
function saveGeneralSettings() {
    // Collect all form data
    const formData = {
        institution_name: document.getElementById('institution_name').value,
        institution_type: document.getElementById('institution_type').value,
        established_year: document.getElementById('established_year').value,
        accreditation: document.getElementById('accreditation').value,
        description: document.getElementById('description').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        website: document.getElementById('website').value,
        social_media: document.getElementById('social_media').value,
        address_line1: document.getElementById('address_line1').value,
        address_line2: document.getElementById('address_line2').value,
        city: document.getElementById('city').value,
        state: document.getElementById('state').value,
        postal_code: document.getElementById('postal_code').value,
        country: document.getElementById('country').value,
        business_hours: document.getElementById('business_hours').value,
        timezone: document.getElementById('timezone').value,
        currency: document.getElementById('currency').value,
        language: document.getElementById('language').value,
        date_format: document.getElementById('date_format').value,
        time_format: document.getElementById('time_format').value,
        auto_save: document.querySelector('input[name="auto_save"]').checked,
        email_notifications: document.querySelector('input[name="email_notifications"]').checked
    };

    // Here you would typically send the data to your backend
    console.log('Saving general settings:', formData);
    
    // Show success message
    if (typeof showToast === 'function') {
        showToast('General settings saved successfully!', 'success');
    }
}
</script>
