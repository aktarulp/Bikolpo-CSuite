@extends('layouts.system-admin-layout')

@section('title', 'Payment Methods Management - System Admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Payment Methods Management</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage supported payment methods and their settings</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('system-admin.payment-methods.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Payment Method
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Navigation Tabs -->
        <div class="px-4 sm:px-6 lg:px-8">
            <nav class="flex space-x-8 overflow-x-auto" aria-label="Tabs">
                <a href="{{ route('system-admin.subscription-plans') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                    Plans & Pricing
                </a>
                <a href="{{ route('system-admin.plan-features') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                    Plan Features
                </a>
                <a href="{{ route('system-admin.subscription-overview') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                    Overview & Analytics
                </a>
                <a href="{{ route('system-admin.subscription-usage') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                    Usage Tracking
                </a>
                <a href="{{ route('system-admin.subscription-billing') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                    Billing & Payments
                </a>
                <a href="{{ route('system-admin.payment-methods') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600 dark:text-blue-400">
                    Payment Methods
                </a>
            </nav>
        </div>
    </div>

    <!-- Content -->
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Methods</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $paymentMethods->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Methods</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $paymentMethods->where('is_active', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Popular Methods</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $paymentMethods->where('is_popular', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Types</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $paymentMethods->pluck('type')->unique()->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($paymentMethods as $paymentMethod)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            @if($paymentMethod->icon)
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $paymentMethod->color }}20; color: {{ $paymentMethod->color }}">
                                <i class="{{ $paymentMethod->icon }}"></i>
                            </div>
                            @else
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $paymentMethod->color }}20; color: {{ $paymentMethod->color }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            @endif
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $paymentMethod->name }}</h3>
                                @if($paymentMethod->provider)
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $paymentMethod->provider }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($paymentMethod->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Active
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                Inactive
                            </span>
                            @endif
                            @if($paymentMethod->is_popular)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                Popular
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-6 py-4">
                    <div class="space-y-3">
                        <!-- Type -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Type</span>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                @if($paymentMethod->type === 'card') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @elseif($paymentMethod->type === 'bank') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($paymentMethod->type === 'mobile') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                @elseif($paymentMethod->type === 'digital_wallet') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                @elseif($paymentMethod->type === 'crypto') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                @endif">
                                {{ $types[$paymentMethod->type] ?? ucfirst($paymentMethod->type) }}
                            </span>
                        </div>

                        <!-- Processing Fee -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Processing Fee</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $paymentMethod->getFormattedProcessingFee() }}</span>
                        </div>

                        <!-- Amount Limits -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Limits</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $paymentMethod->getFormattedAmountLimits() }}</span>
                        </div>

                        <!-- Supported Currencies -->
                        @if($paymentMethod->supported_currencies && count($paymentMethod->supported_currencies) > 0)
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Supported Currencies</span>
                            <div class="mt-1 flex flex-wrap gap-1">
                                @foreach($paymentMethod->supported_currencies as $currency)
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                    {{ $currency }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Description -->
                        @if($paymentMethod->description)
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Description</span>
                            <p class="text-sm text-gray-900 dark:text-white mt-1">{{ $paymentMethod->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('system-admin.payment-methods.edit', $paymentMethod->id) }}" 
                               class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            
                            <form action="{{ route('system-admin.payment-methods.toggle-status', $paymentMethod->id) }}" 
                                  method="POST" 
                                  class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium {{ $paymentMethod->is_active ? 'text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20' : 'text-green-700 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20' }} bg-white dark:bg-gray-800 transition-colors duration-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($paymentMethod->is_active)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                        @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        @endif
                                    </svg>
                                    {{ $paymentMethod->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </div>
                        
                        <form action="{{ route('system-admin.payment-methods.delete', $paymentMethod->id) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Are you sure you want to delete this payment method? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-3 py-1.5 border border-red-300 dark:border-red-600 rounded-md text-xs font-medium text-red-700 dark:text-red-400 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($paymentMethods->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No payment methods found</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating your first payment method.</p>
            <div class="mt-6">
                <a href="{{ route('system-admin.payment-methods.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Payment Method
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

@if(session('success'))
<div id="success-message" class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg z-50">
    <div class="flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        {{ session('success') }}
    </div>
</div>
@endif

@if(session('error'))
<div id="error-message" class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50">
    <div class="flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        {{ session('error') }}
    </div>
</div>
@endif

<script>
// Auto-hide success/error messages
document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');
    
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.opacity = '0';
            setTimeout(() => successMessage.remove(), 300);
        }, 3000);
    }
    
    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.opacity = '0';
            setTimeout(() => errorMessage.remove(), 300);
        }, 5000);
    }
});
</script>
@endsection
