@extends('system-admin.system-admin-layout')

@section('title', 'Edit Payment Method - System Admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Payment Method</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update payment method details and settings</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <a href="{{ route('system-admin.payment-methods') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Payment Methods
                    </a>
                    <button onclick="deletePaymentMethod({{ $id }})" 
                            class="inline-flex items-center px-4 py-2 border border-red-300 dark:border-red-600 rounded-md shadow-sm text-sm font-medium text-red-700 dark:text-red-300 bg-white dark:bg-gray-700 hover:bg-red-50 dark:hover:bg-red-900">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Payment Method
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Navigation Tabs -->
        <div class="px-4 sm:px-6 lg:px-8">
            <nav class="flex space-x-8" aria-label="Tabs">
                <a href="{{ route('system-admin.payment-methods') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                    Payment Methods
                </a>
                <a href="{{ route('system-admin.subscription-plans') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                    Subscription Plans
                </a>
                <a href="{{ route('system-admin.plan-features') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                    Plan Features
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Error Message -->
            @if(isset($error))
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Error</h3>
                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                            {{ $error }}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Form -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <form action="{{ route('system-admin.payment-methods.update', $id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information -->
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Basic Information</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Configure the basic details of this payment method</p>
                    </div>
                    
                    <div class="px-6 py-4 space-y-6">
                        <!-- Payment Method Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Payment Method Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', 'Credit Card') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                   placeholder="Enter payment method name"
                                   required>
                            @error('name')
                                <p class="text-sm text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Payment Type <span class="text-red-500">*</span>
                            </label>
                            <select name="type" 
                                    id="type" 
                                    class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                    required>
                                <option value="">Select a type</option>
                                <option value="card" {{ old('type', 'card') == 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
                                <option value="digital_wallet" {{ old('type', 'card') == 'digital_wallet' ? 'selected' : '' }}>Digital Wallet</option>
                                <option value="bank" {{ old('type', 'card') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="mobile" {{ old('type', 'card') == 'mobile' ? 'selected' : '' }}>Mobile Money</option>
                                <option value="crypto" {{ old('type', 'card') == 'crypto' ? 'selected' : '' }}>Cryptocurrency</option>
                            </select>
                            @error('type')
                                <p class="text-sm text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Provider -->
                        <div>
                            <label for="provider" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Provider <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="provider" 
                                   id="provider" 
                                   value="{{ old('provider', 'Stripe') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                   placeholder="Enter provider name"
                                   required>
                            @error('provider')
                                <p class="text-sm text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="3"
                                      class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                      placeholder="Enter payment method description">{{ old('description', 'Accept payments via Visa, Mastercard, American Express, and other major credit cards.') }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Financial Settings -->
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Financial Settings</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Configure fees and transaction limits</p>
                    </div>
                    
                    <div class="px-6 py-4 space-y-6">
                        <!-- Processing Fee -->
                        <div>
                            <label for="processing_fee" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Processing Fee (%) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="processing_fee" 
                                   id="processing_fee" 
                                   step="0.01"
                                   min="0"
                                   max="100"
                                   value="{{ old('processing_fee', '2.9') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                   placeholder="0.00"
                                   required>
                            @error('processing_fee')
                                <p class="text-sm text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount Limits -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="min_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Minimum Amount ($)
                                </label>
                                <input type="number" 
                                       name="min_amount" 
                                       id="min_amount" 
                                       step="0.01"
                                       min="0"
                                       value="{{ old('min_amount', '1.00') }}"
                                       class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                       placeholder="0.00">
                                @error('min_amount')
                                    <p class="text-sm text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="max_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Maximum Amount ($)
                                </label>
                                <input type="number" 
                                       name="max_amount" 
                                       id="max_amount" 
                                       step="0.01"
                                       min="0"
                                       value="{{ old('max_amount', '10000.00') }}"
                                       class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                       placeholder="0.00">
                                @error('max_amount')
                                    <p class="text-sm text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status Settings -->
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Status Settings</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Configure availability and visibility</p>
                    </div>
                    
                    <div class="px-6 py-4 space-y-6">
                        <!-- Active Status -->
                        <div class="flex items-center justify-between">
                            <div>
                                <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Active Status
                                </label>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Enable or disable this payment method</p>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       id="is_active" 
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            </div>
                        </div>

                        <!-- Popular Status -->
                        <div class="flex items-center justify-between">
                            <div>
                                <label for="is_popular" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Popular Payment Method
                                </label>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Mark as popular to highlight to users</p>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_popular" 
                                       id="is_popular" 
                                       value="1"
                                       {{ old('is_popular', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            </div>
                        </div>
                    </div>

                    <!-- Visual Settings -->
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Visual Settings</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Configure icons and colors for display</p>
                    </div>
                    
                    <div class="px-6 py-4 space-y-6">
                        <!-- Icon -->
                        <div>
                            <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Icon Class
                            </label>
                            <input type="text" 
                                   name="icon" 
                                   id="icon" 
                                   value="{{ old('icon', 'fas fa-credit-card') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition-all duration-200 hover:shadow-sm"
                                   placeholder="fas fa-credit-card">
                            @error('icon')
                                <p class="text-sm text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Color -->
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Color Code
                            </label>
                            <input type="color" 
                                   name="color" 
                                   id="color" 
                                   value="{{ old('color', '#3B82F6') }}"
                                   class="w-20 h-10 border border-slate-200 dark:border-slate-600 rounded-lg cursor-pointer">
                            @error('color')
                                <p class="text-sm text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 rounded-b-lg">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('system-admin.payment-methods') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Payment Method
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function deletePaymentMethod(id) {
    if (confirm('Are you sure you want to delete this payment method? This action cannot be undone.')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("system-admin.payment-methods.delete", ":id") }}'.replace(':id', id);
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method override
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
