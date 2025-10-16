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
        <section class="text-gray-700 body-font overflow-hidden border-t border-gray-200 dark:border-gray-700">
            <div class="container px-5 py-24 mx-auto flex">
                <!-- Features Column -->
                <div class="lg:w-1/4 hidden lg:block">
                    <div class="border-t border-gray-300 dark:border-gray-600 border-b border-l rounded-tl-lg rounded-bl-lg overflow-hidden">
                        <!-- Header row to match plan headers -->
                        <div class="px-3 py-4 text-center bg-gray-50 dark:bg-gray-800">
                            <h3 class="tracking-widest text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">FEATURES</h3>
                            <h2 class="text-3xl text-gray-900 dark:text-white font-bold leading-none mb-1">Compare</h2>
                            <span class="text-xs text-gray-500 dark:text-gray-400">All features</span>
                    </div>
                        
                        @php
                            $allFeatures = \App\Models\PlanFeature::orderBy('category')->orderBy('sort_order')->get();
                        @endphp
                        @foreach($allFeatures as $feature)
                            <p class="{{ $loop->even ? 'bg-gray-100 dark:bg-gray-800' : '' }} text-gray-900 dark:text-white h-12 text-center px-4 flex items-center justify-start">
                                {{ $feature->name }}
                            </p>
                        @endforeach
                    </div>
                </div>
                
                <!-- Plans Comparison -->
                <div class="flex flex-col lg:flex-row lg:w-3/4 w-full lg:border border-gray-300 dark:border-gray-600 rounded-lg">
                    @foreach($plans as $plan)
                    @php
                        $planFeatures = $plan->planFeatures ?? collect();
                        if (is_string($planFeatures)) {
                            $planFeatures = collect();
                        }
                    @endphp
                    <div class="flex-1 w-full mb-10 lg:mb-0 border-2 {{ $plan->is_popular ? 'border-blue-500' : 'border-gray-300 dark:border-gray-600' }} rounded-lg lg:rounded-none relative">
                        @if($plan->is_popular)
                        <span class="bg-blue-500 text-white px-3 py-1 tracking-widest text-xs absolute right-0 top-0 rounded-bl">POPULAR</span>
                        @endif
                        
                        <!-- Plan Header -->
                        <div class="px-3 py-4 text-center bg-gray-50 dark:bg-gray-800">
                            <h3 class="tracking-widest text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">{{ strtoupper($plan->name) }}</h3>
                            <h2 class="text-3xl text-gray-900 dark:text-white font-bold flex items-center justify-center leading-none mb-1">
                                ৳{{ number_format($plan->price, 0) }}
                                <span class="text-gray-600 dark:text-gray-400 text-sm ml-1">/{{ $plan->billing_cycle }}</span>
                            </h2>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $plan->description }}</span>
                        </div>
                        
                        
                        @foreach($allFeatures as $feature)
                            @php
                                $featurePivot = $planFeatures->where('id', $feature->id)->first();
                                $isEnabled = $featurePivot && $featurePivot->pivot->enabled;
                                $featureValue = $featurePivot ? $featurePivot->pivot->value : null;
                            @endphp
                            
                            @if($isEnabled && $featureValue !== null && $featureValue !== '')
                                @if($feature->type === 'boolean')
                                    @if($featureValue === '1' || $featureValue === 'true')
                                        <p class="{{ $loop->even ? 'bg-gray-100 dark:bg-gray-800' : '' }} text-gray-600 dark:text-gray-400 text-center h-12 flex items-center justify-center">
                                            <span class="w-5 h-5 inline-flex items-center justify-center bg-green-500 text-white rounded-full flex-shrink-0">
                                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-3 h-3" viewBox="0 0 24 24">
                                                    <path d="M20 6L9 17l-5-5"></path>
                                                </svg>
                                            </span>
                                        </p>
                                    @else
                                        <p class="{{ $loop->even ? 'bg-gray-100 dark:bg-gray-800' : '' }} text-gray-600 dark:text-gray-400 text-center h-12 flex items-center justify-center">
                                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" class="w-5 h-5 text-gray-500" viewBox="0 0 24 24">
                                                <path d="M18 6L6 18M6 6l12 12"></path>
                        </svg>
                                        </p>
                                    @endif
                                @elseif($feature->type === 'numeric')
                                    @if($featureValue === '0' || $featureValue === 'unlimited')
                                        <p class="{{ $loop->even ? 'bg-gray-100 dark:bg-gray-800' : '' }} text-gray-600 dark:text-gray-400 text-center h-12 flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Unlimited</span>
                                        </p>
                                    @else
                                        <p class="{{ $loop->even ? 'bg-gray-100 dark:bg-gray-800' : '' }} text-gray-600 dark:text-gray-400 text-center h-12 flex items-center justify-center">
                                            <span class="text-sm font-medium">{{ $featureValue }}{{ $feature->unit ? ' ' . $feature->unit : '' }}</span>
                                        </p>
                                    @endif
                                @else
                                    <p class="{{ $loop->even ? 'bg-gray-100 dark:bg-gray-800' : '' }} text-gray-600 dark:text-gray-400 text-center h-12 flex items-center justify-center">
                                        <span class="text-sm font-medium">{{ $featureValue }}</span>
                                    </p>
                                @endif
                            @else
                                <p class="{{ $loop->even ? 'bg-gray-100 dark:bg-gray-800' : '' }} text-gray-600 dark:text-gray-400 text-center h-12 flex items-center justify-center">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" class="w-5 h-5 text-gray-500" viewBox="0 0 24 24">
                                        <path d="M18 6L6 18M6 6l12 12"></path>
                                    </svg>
                                </p>
                            @endif
                    @endforeach
                        
                        <!-- Annual Offer -->
                        @if($plan->annual_offer_active && $plan->annual_price)
                        <div class="bg-green-50 dark:bg-green-900/20 border-t border-gray-300 dark:border-gray-600 p-4">
                            <div class="text-center">
                                <div class="text-sm font-semibold text-green-800 dark:text-green-300 mb-1">{{ $plan->annual_badge_text ?: 'SAVE 2 MONTHS' }}</div>
                                <div class="text-lg font-bold text-green-700 dark:text-green-400">৳{{ number_format($plan->annual_price, 0) }}/year</div>
                                @if($plan->annual_show_monthly_equivalent)
                                    <div class="text-xs text-green-600 dark:text-green-400">৳{{ number_format($plan->annual_price / 12, 0) }}/month</div>
                                @endif
                </div>
            </div>
            @endif

                        <!-- Action Button -->
                        <div class="border-t border-gray-300 dark:border-gray-600 p-6 text-center">
                            <a href="{{ route('system-admin.subscription-plans.edit', $plan->id) }}" 
                               class="flex items-center mt-auto text-white bg-blue-500 border-0 py-2 px-4 w-full focus:outline-none hover:bg-blue-600 rounded">
                        Edit Plan
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-auto" viewBox="0 0 24 24">
                                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                            </a>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">{{ $plan->description }}</p>
                        </div>
                    </div>
                    @endforeach
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