@extends('layouts.system-admin-layout')

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
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Payment Method Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="e.g., Credit Card, Mobile Banking"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Slug <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="e.g., credit_card, mobile_banking"
                                   required>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">URL-friendly identifier (auto-generated from name)</p>
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
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
                                <option value="mobile" {{ old('type') == 'mobile' ? 'selected' : '' }}>Mobile Banking Service (MFS)</option>
                                <option value="bank" {{ old('type') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="cash" {{ old('type') == 'cash' ? 'selected' : '' }}>Cash Payment</option>
                                <option value="check" {{ old('type') == 'check' ? 'selected' : '' }}>Check Payment</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="provider" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Provider
                            </label>
                            <select id="provider" 
                                    name="provider"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select a provider</option>
                            </select>
                            @error('provider')
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
                                A/C No. <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="account_number" 
                                   name="account_number" 
                                   value="{{ old('account_number') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Enter account number"
                                   required>
                            @error('account_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="account_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                A/C Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="account_title" 
                                   name="account_title" 
                                   value="{{ old('account_title') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Enter account title"
                                   required>
                            @error('account_title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label for="branch_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Branch Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="branch_name" 
                                   name="branch_name" 
                                   value="{{ old('branch_name') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Enter branch name"
                                   required>
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
                                   placeholder="Enter routing number">
                            @error('routing_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>


                <!-- Settings -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Settings</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sort Order
                            </label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', 0) }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="0">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Lower numbers appear first</p>
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Active
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="is_popular" 
                                       name="is_popular" 
                                       value="1"
                                       {{ old('is_popular') ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_popular" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Popular
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="requires_verification" 
                                       name="requires_verification" 
                                       value="1"
                                       {{ old('requires_verification') ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="requires_verification" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Requires Verification
                                </label>
                            </div>
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
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '_')
        .replace(/-+/g, '_')
        .trim('_');
    document.getElementById('slug').value = slug;
});

// Color picker synchronization
document.getElementById('color').addEventListener('input', function() {
    document.getElementById('color_text').value = this.value;
});

document.getElementById('color_text').addEventListener('input', function() {
    document.getElementById('color').value = this.value;
});

// Provider options based on type
const providerOptions = {
    'mobile': [
        { value: 'bkash', label: 'bKash' },
        { value: 'rocket', label: 'Rocket' },
        { value: 'nagad', label: 'Nagad' },
        { value: 'upay', label: 'Upay' },
        { value: 'tap', label: 'Tap' }
    ],
    'bank': [
        { value: 'sbl', label: 'Sonali Bank' },
        { value: 'janata', label: 'Janata Bank' },
        { value: 'agrani', label: 'Agrani Bank' },
        { value: 'brac', label: 'BRAC Bank' },
        { value: 'city', label: 'City Bank' },
        { value: 'dhaka', label: 'Dhaka Bank' },
        { value: 'eastern', label: 'Eastern Bank' },
        { value: 'islami', label: 'Islami Bank' },
        { value: 'mutual_trust', label: 'Mutual Trust Bank PLC' },
        { value: 'prime', label: 'Prime Bank' },
        { value: 'southeast', label: 'Southeast Bank' }
    ],
    'cash': [
        { value: 'office', label: 'Office Payment' },
        { value: 'agent', label: 'Agent Collection' },
        { value: 'pickup', label: 'Pickup Service' }
    ],
    'check': [
        { value: 'personal', label: 'Personal Check' },
        { value: 'business', label: 'Business Check' },
        { value: 'bank_draft', label: 'Bank Draft' },
        { value: 'cashier', label: 'Cashier Check' }
    ]
};

function updateProviderOptions() {
    const type = document.getElementById('type').value;
    const providerSelect = document.getElementById('provider');
    
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
