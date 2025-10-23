@extends('system-admin.system-admin-layout')

@section('title', 'Create Payment Method - System Admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Payment Method</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Add a new payment method to your system</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('system-admin.payment-methods') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Payment Methods
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <form action="{{ route('system-admin.payment-methods.store') }}" method="POST" class="max-w-4xl mx-auto">
            @csrf
            
            <div class="space-y-6">
                <!-- Basic Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Basic Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Payment Type <span class="text-red-500">*</span>
                            </label>
                            <select id="type" 
                                    name="type"
                                    onchange="updateProviderOptions()"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                    required>
                                <option value="">Select a type</option>
                                <option value="Bank" {{ old('type') == 'Bank' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="MFS" {{ old('type') == 'MFS' ? 'selected' : '' }}>Mobile Financial Service (MFS)</option>
                                <option value="Cash" {{ old('type') == 'Cash' ? 'selected' : '' }}>Cash Payment</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="provider_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Provider Name
                            </label>
                            <select id="provider_name" 
                                    name="provider_name"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select a provider</option>
                            </select>
                            @error('provider_name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label for="branch_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Branch Name
                            </label>
                            <input type="text" 
                                   id="branch_name" 
                                   name="branch_name" 
                                   value="{{ old('branch_name') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Enter branch name (for banks)">
                            @error('branch_name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="routing_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Routing Number
                            </label>
                            <input type="text" 
                                   id="routing_number" 
                                   name="routing_number" 
                                   value="{{ old('routing_number') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Enter routing number (optional)">
                            @error('routing_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>

                <!-- Account Details -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Account Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Account Number
                            </label>
                            <input type="text" 
                                   id="account_number" 
                                   name="account_number" 
                                   value="{{ old('account_number') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Enter account number (for banks/MFS)">
                            @error('account_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="account_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Account Title
                            </label>
                            <input type="text" 
                                   id="account_title" 
                                   name="account_title" 
                                   value="{{ old('account_title') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Enter account holder name">
                            @error('account_title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>



                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('system-admin.payment-methods') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Payment Method
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Provider options based on type
const providerOptions = {
    'Bank': [
        { value: 'Sonali Bank', label: 'Sonali Bank' },
        { value: 'Janata Bank', label: 'Janata Bank' },
        { value: 'Agrani Bank', label: 'Agrani Bank' },
        { value: 'BRAC Bank', label: 'BRAC Bank' },
        { value: 'City Bank', label: 'City Bank' },
        { value: 'Dhaka Bank', label: 'Dhaka Bank' },
        { value: 'Eastern Bank', label: 'Eastern Bank' },
        { value: 'Islami Bank', label: 'Islami Bank' },
        { value: 'Mutual Trust Bank', label: 'Mutual Trust Bank PLC' },
        { value: 'Prime Bank', label: 'Prime Bank' },
        { value: 'Southeast Bank', label: 'Southeast Bank' },
        { value: 'Dutch Bangla Bank', label: 'Dutch Bangla Bank' },
        { value: 'Standard Bank', label: 'Standard Bank' },
        { value: 'Bank Asia', label: 'Bank Asia' },
        { value: 'Trust Bank', label: 'Trust Bank' }
    ],
    'MFS': [
        { value: 'bKash', label: 'bKash' },
        { value: 'Rocket', label: 'Rocket' },
        { value: 'Nagad', label: 'Nagad' },
        { value: 'Upay', label: 'Upay' },
        { value: 'Tap', label: 'Tap' },
        { value: 'SureCash', label: 'SureCash' },
        { value: 'mCash', label: 'mCash' }
    ],
    'Cash': [
        { value: 'Office Payment', label: 'Office Payment' },
        { value: 'Agent Collection', label: 'Agent Collection' },
        { value: 'Pickup Service', label: 'Pickup Service' },
        { value: 'Cash on Delivery', label: 'Cash on Delivery' }
    ]
};

function updateProviderOptions() {
    const type = document.getElementById('type').value;
    const providerSelect = document.getElementById('provider_name');
    
    // Clear existing options
    providerSelect.innerHTML = '<option value="">Select a provider</option>';
    
    if (providerOptions[type]) {
        providerOptions[type].forEach(option => {
            const optionElement = document.createElement('option');
            optionElement.value = option.value;
            optionElement.textContent = option.label;
            providerSelect.appendChild(optionElement);
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateProviderOptions();
});
</script>
@endsection
