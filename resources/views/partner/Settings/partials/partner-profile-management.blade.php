<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Institution Information</h3>
    <form>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="institutionName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Institution Name</label>
                <input type="text" id="institutionName" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->name ?? '' }}">
            </div>
            <div>
                <label for="establishmentDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Establishment Date</label>
                <input type="date" id="establishmentDate" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->establishment_date ?? '' }}">
            </div>
        </div>
    </form>
</div>

<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Details</h3>
    <form>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="contactPerson" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Person</label>
                <input type="text" id="contactPerson" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->contact_person ?? '' }}">
            </div>
            <div>
                <label for="contactEmail" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Email</label>
                <input type="email" id="contactEmail" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->email ?? '' }}">
            </div>
            <div>
                <label for="contactPhone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Phone</label>
                <input type="tel" id="contactPhone" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->phone ?? '' }}">
            </div>
            <div>
                <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Website</label>
                <input type="url" id="website" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->website ?? '' }}">
            </div>
        </div>
    </form>
</div>

<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Address Information</h3>
    <form>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="addressLine1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address Line 1</label>
                <input type="text" id="addressLine1" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->address_line1 ?? '' }}">
            </div>
            <div>
                <label for="addressLine2" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address Line 2 (Optional)</label>
                <input type="text" id="addressLine2" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->address_line2 ?? '' }}">
            </div>
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                <input type="text" id="city" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->city ?? '' }}">
            </div>
            <div>
                <label for="stateProvince" class="block text-sm font-medium text-gray-700 dark:text-gray-300">State/Province</label>
                <input type="text" id="stateProvince" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->state_province ?? '' }}">
            </div>
            <div class="col-span-full">
                <label for="postalCode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postal Code</label>
                <input type="text" id="postalCode" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->postal_code ?? '' }}">
            </div>
        </div>
    </form>
</div>

<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Business Information</h3>
    <form>
        <div class="mb-4">
            <label for="businessID" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Business ID/Tax ID</label>
            <input type="text" id="businessID" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white" value="{{ $partner->business_id ?? '' }}">
        </div>
    </form>
</div>

<div class="flex justify-end mt-6">
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-primaryGreen text-white font-medium rounded-md shadow-sm hover:bg-primaryGreen/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen">Save Changes</button>
</div>
