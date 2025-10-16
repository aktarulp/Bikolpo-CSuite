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
        <!-- Debug Information -->
        @if(config('app.debug'))
        <div class="mb-4 p-4 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
            <h4 class="font-bold text-yellow-800 dark:text-yellow-200">Debug Information:</h4>
            <p><strong>Plans type:</strong> {{ gettype($plans ?? 'not set') }}</p>
            <p><strong>Plans count:</strong> {{ isset($plans) && is_object($plans) && method_exists($plans, 'count') ? $plans->count() : 'N/A' }}</p>
            @if(isset($error))
            <p><strong>Error:</strong> {{ $error }}</p>
            @endif
        </div>
        @endif
        
        @if(isset($plans) && is_object($plans) && method_exists($plans, 'count') && $plans->count() > 0)
        <!-- Comparison Table Layout -->
        <section class="text-gray-700 body-font bg-gray-50 dark:bg-gray-900 py-16">
            <div class="container mx-auto px-4">
                <div class="flex flex-col lg:flex-row gap-2">
                    <!-- Features Column -->
                    <div class="lg:w-1/4 hidden lg:block">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                        <!-- Header -->
                        <div class="px-6 py-8 text-center bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-700 rounded-t-lg h-32 flex flex-col justify-center items-center">
                            <h3 class="text-xl font-semibold text-blue-600 dark:text-blue-400 mb-3">FEATURES</h3>
                            <h2 class="text-3xl text-gray-900 dark:text-white font-bold">Compare Plans</h2>
                        </div>
                        
                        @php
                            $allFeatures = \App\Models\PlanFeature::orderBy('category')->orderBy('sort_order')->get();
            @endphp
                            @foreach($allFeatures as $feature)
                                <div class="px-6 py-2 h-10 {{ $loop->even ? 'bg-gray-50 dark:bg-gray-700/50' : 'bg-white dark:bg-gray-800' }} border-b border-gray-100 dark:border-gray-700 last:border-b-0 flex items-center">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3 flex-shrink-0"></div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $feature->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Plans Comparison -->
                    <div class="flex flex-col lg:flex-row lg:w-3/4 w-full gap-4">
                    @foreach($plans as $plan)
                    @php
                        $planFeatures = $plan->planFeatures ?? collect();
                        if (is_string($planFeatures)) {
                            $planFeatures = collect();
                        }
                    @endphp
                        <div class="flex-1 w-full {{ $plan->is_popular ? 'border-2 border-blue-500 shadow-xl' : 'border border-gray-200 dark:border-gray-700 shadow-lg' }} rounded-lg bg-white dark:bg-gray-800">
                        @if($plan->is_popular)
                        <span class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 tracking-widest text-xs absolute right-0 top-0 rounded-bl shadow-lg font-bold animate-pulse">
                            <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                            POPULAR
                        </span>
            @endif

                        <!-- Plan Header -->
                        <div class="px-4 py-6 text-center {{ $plan->is_popular ? 'bg-blue-50 dark:bg-blue-900/20' : 'bg-gray-50 dark:bg-gray-800' }} border-b border-gray-200 dark:border-gray-700 rounded-t-lg h-32 flex flex-col justify-center items-center">
                            <h3 class="text-sm font-semibold {{ $plan->is_popular ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }} mb-1">{{ strtoupper($plan->name) }}</h3>
                            <h2 class="text-2xl {{ $plan->is_popular ? 'text-blue-600 dark:text-blue-400' : 'text-gray-900 dark:text-white' }} font-bold mb-1">
                                ৳{{ number_format($plan->price, 0) }}
                                <span class="text-gray-600 dark:text-gray-400 text-sm">/{{ $plan->billing_cycle }}</span>
                            </h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $plan->description }}</p>
                        </div>
                        
                        
                        @foreach($allFeatures as $feature)
                            @php
                                $featurePivot = $planFeatures->where('id', $feature->id)->first();
                                $isEnabled = $featurePivot && $featurePivot->pivot->enabled;
                                $featureValue = $featurePivot ? $featurePivot->pivot->value : null;
                            @endphp
                            
                            <div class="px-6 py-2 h-10 {{ $loop->even ? 'bg-gray-50 dark:bg-gray-700/50' : 'bg-white dark:bg-gray-800' }} border-b border-gray-100 dark:border-gray-700 last:border-b-0 flex items-center justify-center">
                                @if($isEnabled && $featureValue !== null && $featureValue !== '')
                                    @if($feature->type === 'boolean')
                                        @if($featureValue === '1' || $featureValue === 'true')
                                            <span class="inline-flex items-center justify-center w-6 h-6 bg-green-500 text-white rounded-full">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center w-6 h-6 bg-red-500 text-white rounded-full">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                                            </span>
                                        @endif
                                    @elseif($feature->type === 'numeric')
                                        @if($featureValue === '0' || $featureValue === 'unlimited')
                                            <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Unlimited</span>
                                        @else
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $featureValue }}{{ $feature->unit ? ' ' . $feature->unit : '' }}</span>
                                        @endif
                                    @else
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $featureValue }}</span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center justify-center w-6 h-6 bg-gray-300 dark:bg-gray-600 text-white rounded-full">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                                    </span>
                                @endif
                    </div>
                    @endforeach
                        
                        <!-- Annual Offer -->
                        @if($plan->annual_offer_active && $plan->annual_price)
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-t border-green-200 dark:border-green-700 p-4 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-green-200 dark:bg-green-800 rounded-full -translate-y-8 translate-x-8 opacity-20"></div>
                            <div class="absolute bottom-0 left-0 w-12 h-12 bg-green-300 dark:bg-green-700 rounded-full translate-y-6 -translate-x-6 opacity-30"></div>
                            <div class="relative text-center">
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg mb-2">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 01-2 0v-1H3a1 1 0 110-2h1V3a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                                    {{ $plan->annual_badge_text ?: 'SAVE 2 MONTHS' }}
                    </div>
                                <div class="text-xl font-bold text-green-700 dark:text-green-400 mb-1">৳{{ number_format($plan->annual_price, 0) }}/year</div>
                                @if($plan->annual_show_monthly_equivalent)
                                    <div class="text-sm text-green-600 dark:text-green-400 font-medium">৳{{ number_format($plan->annual_price / 12, 0) }}/month</div>
                                @endif
                        </div>
                        </div>
                        @endif

                        <!-- Action Button -->
                        <div class="border-t border-gray-200 dark:border-gray-700 p-6 text-center bg-gray-50 dark:bg-gray-800 rounded-b-lg">
                            <a href="{{ route('system-admin.subscription-plans.edit', $plan->id) }}" 
                               class="inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Plan
                    </a>
                        </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @else
        <!-- No Plans Message -->
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No subscription plans</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new subscription plan.</p>
                <div class="mt-6">
                <a href="{{ route('system-admin.subscription-plans.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create New Plan
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection