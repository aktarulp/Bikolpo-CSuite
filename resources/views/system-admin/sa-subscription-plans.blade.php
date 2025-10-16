@extends('layouts.system-admin-layout')

@section('title', 'Subscription Plans - System Admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Subscription Plans & Pricing</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage subscription plans and pricing tiers</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('system-admin.subscription-plans.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create New Plan
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Navigation Tabs -->
        <div class="px-4 sm:px-6 lg:px-8">
            <nav class="flex space-x-8 overflow-x-auto" aria-label="Tabs">
                <a href="{{ route('system-admin.subscription-plans') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('system-admin.subscription-plans') ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Plans & Pricing
                </a>
                <a href="{{ route('system-admin.plan-features') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('system-admin.plan-features*') ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Plan Features
                </a>
                <a href="{{ route('system-admin.subscription-overview') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('system-admin.subscription-overview') ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Overview & Analytics
                </a>
                <a href="{{ route('system-admin.subscription-usage') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('system-admin.subscription-usage') ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Usage Tracking
                </a>
                <a href="{{ route('system-admin.subscription-billing') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('system-admin.subscription-billing') ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Billing & Payments
                </a>
            </nav>
        </div>
    </div>

    <!-- Plans Grid -->
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $freePlan = \App\Models\SubscriptionPlan::where('slug', 'free')->first();
            @endphp
            
            @if($freePlan)
            <!-- Free Plan -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-2 border-gray-200 dark:border-gray-700 p-6 relative">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $freePlan->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ $freePlan->description }}</p>
                    
                    <div class="mt-4">
                        <span class="text-4xl font-bold text-gray-900 dark:text-white">৳{{ number_format($freePlan->price, 0) }}</span>
                        <span class="text-gray-600 dark:text-gray-400">/month</span>
                    </div>
                </div>
                
                <div class="mt-6 space-y-3">
                    @foreach($freePlan->enabledFeatures as $feature)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            @if($feature->type === 'numeric' && $feature->pivot->value)
                                {{ $feature->name }}: {{ $feature->pivot->value }}{{ $feature->unit ? ' ' . $feature->unit : '' }}
                            @else
                                {{ $feature->name }}
                            @endif
                        </span>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-6 flex space-x-2">
                    <a href="{{ route('system-admin.subscription-plans.edit', $freePlan->id) }}" 
                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-center text-sm">
                        Edit Plan
                    </a>
                    <button class="flex-1 bg-gray-600 text-white font-medium py-2 px-4 rounded-lg text-sm">
                        Current Plan
                    </button>
                </div>
            </div>
            @endif

            <!-- Basic Plan -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-2 border-blue-200 dark:border-blue-700 p-6 relative">
                <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                    <span class="bg-blue-500 text-white px-4 py-1 rounded-full text-sm font-medium">
                        Popular
                    </span>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Basic</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">For small coaching centers</p>
                    
                    <div class="mt-4 relative">
                        <div class="flex items-center justify-center space-x-2">
                            <span class="text-4xl font-bold text-gray-900 dark:text-white">৳2,500</span>
                            <span class="text-gray-600 dark:text-gray-400">/month</span>
                        </div>
                        <!-- Annual Offer Display -->
                        <div class="mt-2 text-center">
                            <div class="text-sm text-gray-600 dark:text-gray-400">or</div>
                            <div class="text-lg font-semibold text-green-600 dark:text-green-400">৳25,000/year</div>
                            <div class="text-xs text-green-500 dark:text-green-300">Save ৳5,000 (17%)</div>
                        </div>
                        <!-- Offer Badge -->
                        <div class="absolute -top-2 -right-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                POPULAR
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 space-y-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Up to 200 students</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">50 tests per month</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">500 questions</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">5GB storage</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Priority support</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Custom branding</span>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('system-admin.subscription-plans.edit', 1) }}" 
                       class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center">
                        Edit Plan
                    </a>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-2 border-purple-200 dark:border-purple-700 p-6 relative">
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Premium</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">For growing centers</p>
                    
                    <div class="mt-4 relative">
                        <div class="flex items-center justify-center space-x-2">
                            <span class="text-4xl font-bold text-gray-900 dark:text-white">৳5,000</span>
                            <span class="text-gray-600 dark:text-gray-400">/month</span>
                        </div>
                        <!-- Annual Offer Display -->
                        <div class="mt-2 text-center">
                            <div class="text-sm text-gray-600 dark:text-gray-400">or</div>
                            <div class="text-lg font-semibold text-green-600 dark:text-green-400">৳50,000/year</div>
                            <div class="text-xs text-green-500 dark:text-green-300">Save ৳10,000 (17%)</div>
                        </div>
                        <!-- Offer Badge -->
                        <div class="absolute -top-2 -right-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                LIMITED
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 space-y-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Up to 500 students</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">200 tests per month</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">2,000 questions</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">20GB storage</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Advanced analytics</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">API access</span>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('system-admin.subscription-plans.edit', 2) }}" 
                       class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center">
                        Edit Plan
                    </a>
                </div>
            </div>

            <!-- Enterprise Plan -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-2 border-emerald-200 dark:border-emerald-700 p-6 relative">
                <div class="text-center">
                    <div class="w-16 h-16 bg-emerald-100 dark:bg-emerald-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Enterprise</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">For large organizations</p>
                    
                    <div class="mt-4 relative">
                        <div class="flex items-center justify-center space-x-2">
                            <span class="text-4xl font-bold text-gray-900 dark:text-white">৳10,000</span>
                            <span class="text-gray-600 dark:text-gray-400">/month</span>
                        </div>
                        <!-- Annual Offer Display -->
                        <div class="mt-2 text-center">
                            <div class="text-sm text-gray-600 dark:text-gray-400">or</div>
                            <div class="text-lg font-semibold text-green-600 dark:text-green-400">৳100,000/year</div>
                            <div class="text-xs text-green-500 dark:text-green-300">Save ৳20,000 (17%)</div>
                        </div>
                        <!-- Offer Badge -->
                        <div class="absolute -top-2 -right-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                50% OFF
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 space-y-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Unlimited students</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Unlimited tests</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Unlimited questions</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">100GB storage</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Dedicated support</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">White label</span>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('system-admin.subscription-plans.edit', 3) }}" 
                       class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center">
                        Edit Plan
                    </a>
                </div>
            </div>

            <!-- Custom Plan -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl shadow-lg border-2 border-indigo-200 dark:border-indigo-700 p-6 relative">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Custom Plan</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Tailored to your specific needs</p>
                    
                    <div class="mt-4">
                        <span class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">Contact Us</span>
                        <span class="text-gray-600 dark:text-gray-400 block text-sm">for custom pricing</span>
                    </div>
                </div>
                
                <div class="mt-6 space-y-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-indigo-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Unlimited everything</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-indigo-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Dedicated support</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-indigo-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Custom features</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-indigo-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">White label solution</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-indigo-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Priority development</span>
                    </div>
                </div>
                
                <div class="mt-6">
                    <button onclick="openCustomPlanModal()" 
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 transform hover:scale-105">
                        Request Custom Plan
                    </button>
                </div>
            </div>
        </div>

        <!-- Plan Statistics -->
        <div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Plan Statistics</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">12</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Free Plan Users</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">8</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Basic Plan Users</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">5</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Premium Plan Users</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">2</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Enterprise Plan Users</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Plan Request Modal -->
<div id="customPlanModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Request Custom Plan</h3>
                <button onclick="closeCustomPlanModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form id="customPlanForm" class="mt-6 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Organization Name -->
                    <div>
                        <label for="organization_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Organization Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="organization_name" 
                               name="organization_name" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="Your organization name">
                    </div>

                    <!-- Contact Person -->
                    <div>
                        <label for="contact_person" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Contact Person <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="contact_person" 
                               name="contact_person" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="Your full name">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="your@email.com">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Phone Number
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="+880 1234 567890">
                    </div>
                </div>

                <!-- Requirements -->
                <div>
                    <label for="requirements" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Specific Requirements <span class="text-red-500">*</span>
                    </label>
                    <textarea id="requirements" 
                              name="requirements" 
                              rows="4"
                              required
                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                              placeholder="Please describe your specific requirements, expected number of students, tests, features needed, etc."></textarea>
                </div>

                <!-- Budget Range -->
                <div>
                    <label for="budget_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Budget Range (Optional)
                    </label>
                    <select id="budget_range" 
                            name="budget_range"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Select budget range</option>
                        <option value="under-5000">Under ৳5,000/month</option>
                        <option value="5000-10000">৳5,000 - ৳10,000/month</option>
                        <option value="10000-25000">৳10,000 - ৳25,000/month</option>
                        <option value="25000-50000">৳25,000 - ৳50,000/month</option>
                        <option value="over-50000">Over ৳50,000/month</option>
                        <option value="discuss">Let's discuss</option>
                    </select>
                </div>

                <!-- Timeline -->
                <div>
                    <label for="timeline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Expected Timeline
                    </label>
                    <select id="timeline" 
                            name="timeline"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Select timeline</option>
                        <option value="asap">ASAP</option>
                        <option value="1-month">Within 1 month</option>
                        <option value="2-3-months">2-3 months</option>
                        <option value="3-6-months">3-6 months</option>
                        <option value="flexible">Flexible</option>
                    </select>
                </div>

                <!-- Additional Notes -->
                <div>
                    <label for="additional_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Additional Notes
                    </label>
                    <textarea id="additional_notes" 
                              name="additional_notes" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                              placeholder="Any additional information or questions you have..."></textarea>
                </div>

                <!-- Modal Footer -->
                <div class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" 
                            onclick="closeCustomPlanModal()"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Send Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openCustomPlanModal() {
    document.getElementById('customPlanModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCustomPlanModal() {
    document.getElementById('customPlanModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('customPlanForm').reset();
}

// Close modal when clicking outside
document.getElementById('customPlanModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCustomPlanModal();
    }
});

// Handle form submission
document.getElementById('customPlanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Show loading state
    submitButton.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Sending...';
    submitButton.disabled = true;
    
    fetch('{{ route("system-admin.subscription-plans.custom-request") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Custom plan request submitted successfully! We will contact you soon.');
            closeCustomPlanModal();
        } else {
            alert('Error submitting request: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error submitting request. Please try again.');
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
});
</script>
@endpush

@endsection
