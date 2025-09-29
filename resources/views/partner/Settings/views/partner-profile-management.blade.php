<div class="flex justify-end mb-4">
    <button id="toggleEditView" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <i class="fas fa-edit mr-2"></i>
        <span>Edit Profile</span>
    </button>
</div>

<form id="partnerProfileForm" action="{{ route('partner.profile.update-details') }}" method="POST">
    @csrf
    @method('PUT')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Institution Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Institution Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->name ?? '' }}" readonly>
            </div>
            <div>
                <label for="institute_name_bangla" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Institution Name (Bangla)</label>
                <input type="text" id="institute_name_bangla" name="institute_name_bangla" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->institute_name_bangla ?? '' }}" readonly>
            </div>
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                <input type="text" id="slug" name="slug" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->slug ?? '' }}" readonly>
            </div>
            <div>
                <label for="slug_bangla" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug (Bangla)</label>
                <input type="text" id="slug_bangla" name="slug_bangla" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->slug_bangla ?? '' }}" readonly>
            </div>
            <div>
                <label for="established_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Established Year</label>
                <input type="number" id="established_year" name="established_year" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->established_year ?? '' }}" readonly>
            </div>
            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Logo</label>
                <div class="mt-1 flex items-center">
                    <span class="inline-block h-12 w-12 rounded-md overflow-hidden bg-gray-100 dark:bg-gray-700">
                        <img id="logo-preview" src="{{ $partner->logo ? asset('storage/' . $partner->logo) : asset('images/default-logo.png') }}" alt="Partner Logo" class="h-full w-full object-cover {{ $partner->logo ? '' : 'hidden' }}">
                        <svg id="logo-placeholder" class="h-full w-full text-gray-300 {{ $partner->logo ? 'hidden' : '' }}" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.997A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0z" />
                        </svg>
                    </span>
                    <input type="file" id="logo" name="logo" accept="image/*" class="ml-5 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primaryGreen/10 file:text-primaryGreen hover:file:bg-primaryGreen/20 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white dark:file:bg-emerald-900/30 dark:file:text-emerald-300 dark:hover:file:bg-emerald-900/50" readonly>
                    <button type="button" id="removeLogo" class="ml-3 text-red-500 hover:text-red-700 text-sm font-medium hidden">Remove</button>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="primary_contact_person" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Primary Contact Person</label>
                <input type="text" id="primary_contact_person" name="primary_contact_person" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->primary_contact_person ?? '' }}" readonly>
            </div>
            <div>
                <label for="primary_contact_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Primary Contact Number</label>
                <input type="tel" id="primary_contact_no" name="primary_contact_no" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->primary_contact_no ?? '' }}" readonly>
            </div>
            <div>
                <label for="alternate_contact_person" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alternate Contact Person</label>
                <input type="text" id="alternate_contact_person" name="alternate_contact_person" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->alternate_contact_person ?? '' }}" readonly>
            </div>
            <div>
                <label for="alternate_contact_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alternate Contact Number</label>
                <input type="tel" id="alternate_contact_no" name="alternate_contact_no" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->alternate_contact_no ?? '' }}" readonly>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->email ?? '' }}" readonly>
            </div>
            <div>
                <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Website</label>
                <input type="url" id="website" name="website" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->website ?? '' }}" readonly>
            </div>
            <div class="col-span-full">
                <label for="facebook_page" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facebook Page URL</label>
                <input type="url" id="facebook_page" name="facebook_page" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->facebook_page ?? '' }}" readonly>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Address Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="col-span-full">
                <label for="short_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Short Address</label>
                <textarea id="short_address" name="short_address" rows="2" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" readonly>{{ $partner->short_address ?? '' }}</textarea>
            </div>
            <div>
                <label for="division" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Division</label>
                <input type="text" id="division" name="division" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->division ?? '' }}" readonly>
            </div>
            <div>
                <label for="district" class="block text-sm font-medium text-gray-700 dark:text-gray-300">District</label>
                <input type="text" id="district" name="district" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->district ?? '' }}" readonly>
            </div>
            <div>
                <label for="upazila_p_s" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upazila/P.S.</label>
                <input type="text" id="upazila_p_s" name="upazila_p_s" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->upazila_p_s ?? '' }}" readonly>
            </div>
            <div>
                <label for="flat_house_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Flat/House No.</label>
                <input type="text" id="flat_house_no" name="flat_house_no" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->flat_house_no ?? '' }}" readonly>
            </div>
            <div>
                <label for="village_road_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Village/Road No.</label>
                <input type="text" id="village_road_no" name="village_road_no" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->village_road_no ?? '' }}" readonly>
            </div>
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                <input type="text" id="city" name="city" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->city ?? '' }}" readonly>
            </div>
            <div>
                <label for="post_office" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Post Office</label>
                <input type="text" id="post_office" name="post_office" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->post_office ?? '' }}" readonly>
            </div>
            <div>
                <label for="post_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Post Code</label>
                <input type="text" id="post_code" name="post_code" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->post_code ?? '' }}" readonly>
            </div>
            <div class="col-span-full">
                <label for="map_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Map Location URL</label>
                <input type="url" id="map_location" name="map_location" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->map_location ?? '' }}" readonly>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Subscription Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="subscription_plan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subscription Plan</label>
                <input type="text" id="subscription_plan" name="subscription_plan" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->subscription_plan ?? '' }}" readonly>
            </div>
            <div>
                <label for="subscription_plan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subscription Plan ID</label>
                <input type="text" id="subscription_plan_id" name="subscription_plan_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->subscription_plan_id ?? '' }}" readonly>
            </div>
            <div>
                <label for="subscription_start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subscription Start Date</label>
                <input type="date" id="subscription_start_date" name="subscription_start_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->subscription_start_date ?? '' }}" readonly>
            </div>
            <div>
                <label for="subscription_end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subscription End Date</label>
                <input type="date" id="subscription_end_date" name="subscription_end_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->subscription_end_date ?? '' }}" readonly>
            </div>
            <div>
                <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Status</label>
                <select id="payment_status" name="payment_status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" readonly>
                    <option value="pending" {{ ($partner->payment_status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ ($partner->payment_status ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="overdue" {{ ($partner->payment_status ?? '') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                    <option value="cancelled" {{ ($partner->payment_status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Account Status & Flag</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Status</label>
                <select id="status" name="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" readonly>
                    <option value="active" {{ ($partner->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ ($partner->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div>
                <label for="flag" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Flag</label>
                <select id="flag" name="flag" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" readonly>
                    <option value="active" {{ ($partner->flag ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="deleted" {{ ($partner->flag ?? '') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                </select>
            </div>
        </div>
    </div>

    <div class="flex justify-end mt-6">
        <button type="submit" id="saveChangesBtn" class="inline-flex items-center px-4 py-2 bg-primaryGreen text-white font-medium rounded-md shadow-sm hover:bg-primaryGreen/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen hidden">Save Changes</button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('toggleEditView');
        const saveChangesBtn = document.getElementById('saveChangesBtn');
        const form = document.getElementById('partnerProfileForm');
        const formInputs = form.querySelectorAll('input, select, textarea');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let isEditing = false;

        function showToast(message, type = 'success') {
            const body = document.querySelector('body');
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 max-w-sm w-full bg-${type === 'success' ? 'green' : 'red'}-50 border border-${type === 'success' ? 'green' : 'red'}-200 rounded-lg shadow-lg p-4 transition-all duration-300 transform translate-x-full`;
            toast.innerHTML = `
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-${type === 'success' ? 'green' : 'red'}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z'}"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-${type === 'success' ? 'green' : 'red'}-800">${message}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button type="button" class="inline-flex text-${type === 'success' ? 'green' : 'red'}-400 hover:text-${type === 'success' ? 'green' : 'red'}-600" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            body.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);

            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        function toggleFormEditMode() {
            isEditing = !isEditing;

            formInputs.forEach(input => {
                if (isEditing) {
                    input.removeAttribute('readonly');
                    input.classList.remove('bg-gray-100', 'dark:bg-gray-900'); // Remove readonly appearance
                    if (input.tagName === 'SELECT') {
                        input.removeAttribute('disabled');
                    } else if (input.type === 'file') {
                        input.removeAttribute('disabled');
                    }
                } else {
                    input.setAttribute('readonly', true);
                    input.classList.add('bg-gray-100', 'dark:bg-gray-900'); // Add readonly appearance
                    if (input.tagName === 'SELECT') {
                        input.setAttribute('disabled', true);
                    } else if (input.type === 'file') {
                        input.setAttribute('disabled', true);
                    }
                }
            });

            if (isEditing) {
                toggleButton.innerHTML = '<i class="fas fa-times mr-2"></i> <span>Cancel Edit</span>';
                toggleButton.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'focus:ring-blue-500');
                toggleButton.classList.add('bg-red-600', 'hover:bg-red-700', 'focus:ring-red-500');
                saveChangesBtn.classList.remove('hidden');
            } else {
                toggleButton.innerHTML = '<i class="fas fa-edit mr-2"></i> <span>Edit Profile</span>';
                toggleButton.classList.remove('bg-red-600', 'hover:bg-red-700', 'focus:ring-red-500');
                toggleButton.classList.add('bg-blue-600', 'hover:bg-blue-700', 'focus:ring-blue-500');
                saveChangesBtn.classList.add('hidden');
                // Optionally revert changes if cancelled (requires storing initial values)
                // form.reset();
            }
        }

        // Set initial state to read-only on load
        formInputs.forEach(input => {
            input.setAttribute('readonly', true);
            input.classList.add('bg-gray-100', 'dark:bg-gray-900');
            if (input.tagName === 'SELECT') {
                input.setAttribute('disabled', true);
            } else if (input.type === 'file') {
                input.setAttribute('disabled', true);
            }
        });

        toggleButton.addEventListener('click', toggleFormEditMode);

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(form);

            // Append _method for Laravel PUT request
            formData.append('_method', 'PUT');

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        // 'Accept': 'application/json', // Do not set Content-Type for FormData with files
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    showToast(data.message || 'Profile updated successfully!', 'success');
                    toggleFormEditMode(); // Switch back to view mode after saving
                    // Optionally update the displayed partner data if needed
                    // For now, a full page reload or a specific data update would be needed for logo/cover_photo
                } else {
                    let errorMessage = data.message || 'Failed to update profile.';
                    if (data.errors) {
                        errorMessage += '\n';
                        for (const key in data.errors) {
                            errorMessage += `\n- ${data.errors[key].join(', ')}`;
                        }
                    }
                    showToast(errorMessage, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('An unexpected error occurred. Please try again.', 'error');
            }
        });
    });

// Logo and Cover Photo Preview Logic
document.addEventListener('DOMContentLoaded', function() {
    const logoInput = document.getElementById('logo');
    const logoPreview = document.getElementById('logo-preview');
    const logoPlaceholder = document.getElementById('logo-placeholder');
    const removeLogoBtn = document.getElementById('removeLogo');

    function setupFileInput(inputElement, previewElement, placeholderElement, removeButton, initialSrc) {
        // Set initial visibility
        if (initialSrc && initialSrc !== '{{ asset('images/default-logo.png') }}' && initialSrc !== '{{ asset('images/default-cover.png') }}') {
            previewElement.classList.remove('hidden');
            placeholderElement.classList.add('hidden');
            removeButton.classList.remove('hidden');
        } else {
            previewElement.classList.add('hidden');
            placeholderElement.classList.remove('hidden');
            removeButton.classList.add('hidden');
        }

        inputElement.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewElement.src = e.target.result;
                    previewElement.classList.remove('hidden');
                    placeholderElement.classList.add('hidden');
                    removeButton.classList.remove('hidden');
                };
                reader.readAsDataURL(this.files[0]);
            } else {
                // If no file selected, revert to previous state
                previewElement.src = initialSrc;
                if (initialSrc && initialSrc !== '{{ asset('images/default-logo.png') }}' && initialSrc !== '{{ asset('images/default-cover.png') }}') {
                    previewElement.classList.remove('hidden');
                    placeholderElement.classList.add('hidden');
                    removeButton.classList.remove('hidden');
                } else {
                    previewElement.classList.add('hidden');
                    placeholderElement.classList.remove('hidden');
                    removeButton.classList.add('hidden');
                }
            }
        });

        removeButton.addEventListener('click', function() {
            inputElement.value = ''; // Clear the file input
            previewElement.src = '#';
            previewElement.classList.add('hidden');
            placeholderElement.classList.remove('hidden');
            removeButton.classList.add('hidden');
            // Add a hidden input to signal deletion to backend
            const hiddenDeleteInput = document.createElement('input');
            hiddenDeleteInput.type = 'hidden';
            hiddenDeleteInput.name = `delete_${inputElement.name}`;
            hiddenDeleteInput.value = '1';
            form.appendChild(hiddenDeleteInput);
        });
    }

    // Initialize for logo
    setupFileInput(logoInput, logoPreview, logoPlaceholder, removeLogoBtn, '{{ $partner->logo ? asset('storage/' . $partner->logo) : asset('images/default-logo.png') }}');

});
</script>
@endpush
