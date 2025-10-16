@extends('layouts.system-admin-layout')

@section('title', 'Edit Subscription Plan - System Admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Subscription Plan</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update plan details and features</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <a href="{{ route('system-admin.subscription-plans') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Plans
                    </a>
                    <button onclick="deletePlan({{ $plan->id }})" 
                            class="inline-flex items-center px-4 py-2 border border-red-300 dark:border-red-600 rounded-md shadow-sm text-sm font-medium text-red-700 dark:text-red-300 bg-white dark:bg-gray-700 hover:bg-red-50 dark:hover:bg-red-900">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Plan
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Navigation Tabs -->
        <div class="px-4 sm:px-6 lg:px-8">
            <nav class="flex space-x-8" aria-label="Tabs">
                <a href="{{ route('system-admin.subscription-plans') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                    Plans & Pricing
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
            </nav>
        </div>
    </div>

    <!-- Form -->
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <div class="max-w-4xl mx-auto">
            <form action="{{ route('system-admin.subscription-plans.update', $plan->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Basic Information -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Basic Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Plan Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Plan Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $plan->name) }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="e.g., Premium Plan"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Slug <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug', $plan->slug) }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="e.g., premium-plan"
                                   required>
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                      placeholder="Describe the plan features and benefits">{{ old('description', $plan->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing & Billing -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Pricing & Billing</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Price (৳) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price', $plan->price) }}"
                                       step="0.01"
                                       min="0"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                       {{ $plan->price ? 'required' : '' }}>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <button type="button" 
                                            onclick="toggleCustomPricing()"
                                            class="text-sm {{ $plan->price ? 'text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300' : 'text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300' }}">
                                        {{ $plan->price ? 'Custom' : 'Fixed' }}
                                    </button>
                                </div>
                            </div>
                            @if($plan->price === null)
                                <input type="hidden" id="is_custom_pricing" name="is_custom_pricing" value="1">
                            @endif
                            @error('price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Currency -->
                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Currency
                            </label>
                            <select id="currency" 
                                    name="currency"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="BDT" {{ old('currency', $plan->currency) == 'BDT' ? 'selected' : '' }}>BDT (৳)</option>
                                <option value="USD" {{ old('currency', $plan->currency) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="EUR" {{ old('currency', $plan->currency) == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                            </select>
                            @error('currency')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Billing Cycle -->
                        <div>
                            <label for="billing_cycle" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Billing Cycle
                            </label>
                            <select id="billing_cycle" 
                                    name="billing_cycle"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="monthly" {{ old('billing_cycle', $plan->billing_cycle) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ old('billing_cycle', $plan->billing_cycle) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                <option value="lifetime" {{ old('billing_cycle', $plan->billing_cycle) == 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                            </select>
                            @error('billing_cycle')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Plan Type & Status -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Plan Type & Status</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Partner Type -->
                        <div>
                            <label for="partner_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Plan Type <span class="text-red-500">*</span>
                            </label>
                            <select id="partner_type" 
                                    name="partner_type"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                    required>
                                <option value="">Select Plan Type</option>
                                <option value="partner" {{ old('partner_type', $plan->partner_type) == 'partner' ? 'selected' : '' }}>Partner Plan</option>
                                <option value="student" {{ old('partner_type', $plan->partner_type) == 'student' ? 'selected' : '' }}>Student Plan</option>
                            </select>
                            @error('partner_type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sort Order
                            </label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', $plan->sort_order) }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="flex items-center space-x-6">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', $plan->is_active) ? 'checked' : '' }}
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
                                       {{ old('is_popular', $plan->is_popular) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_popular" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Popular
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Referral System (Invite & Earn) -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Referral System (Invite & Earn)</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="referral_eligible" 
                                   name="referral_eligible" 
                                   value="1"
                                   {{ old('referral_eligible', $plan->referral_eligible) ? 'checked' : '' }}
                                   onchange="toggleReferralSettings()"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="referral_eligible" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Enable Referral System for this plan
                            </label>
                        </div>
                        
                        <div id="referral_settings" class="space-y-4 {{ old('referral_eligible', $plan->referral_eligible) ? '' : 'hidden' }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="referral_reward_months" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Reward Months
                                    </label>
                                    <input type="number" 
                                           id="referral_reward_months" 
                                           name="referral_reward_months" 
                                           value="{{ old('referral_reward_months', $plan->referral_reward_months) }}"
                                           min="1"
                                           max="12"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="1">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Number of free months for successful referral</p>
                                </div>
                                
                                <div>
                                    <label for="referral_minimum_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Minimum Amount (৳)
                                    </label>
                                    <input type="number" 
                                           id="referral_minimum_amount" 
                                           name="referral_minimum_amount" 
                                           value="{{ old('referral_minimum_amount', $plan->referral_minimum_amount) }}"
                                           step="0.01"
                                           min="0"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="0.00">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimum subscription amount to qualify</p>
                                </div>
                            </div>
                            
                            <div>
                                <label for="referral_conditions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Additional Conditions (JSON)
                                </label>
                                <textarea id="referral_conditions" 
                                          name="referral_conditions" 
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                          placeholder='{"min_duration": "6_months", "plan_types": ["premium", "enterprise"]}'>{{ old('referral_conditions', $plan->referral_conditions ? json_encode($plan->referral_conditions, JSON_PRETTY_PRINT) : '') }}</textarea>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JSON format for additional referral conditions</p>
                            </div>
                            
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-2">How it works:</h4>
                                <ul class="text-xs text-blue-800 dark:text-blue-200 space-y-1">
                                    <li>• Partner invites another partner using their referral code</li>
                                    <li>• Invited partner subscribes to a 6-month plan</li>
                                    <li>• Inviter gets {{ old('referral_reward_months', $plan->referral_reward_months) ?: 1 }} month(s) free subscription</li>
                                    <li>• System tracks and manages all referral activities</li>
                                </ul>
                            </div>
                            
                            <div id="referral_preview" class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-green-900 dark:text-green-100 mb-2">Referral Reward Preview:</h4>
                                <p class="text-xs text-green-800 dark:text-green-200">
                                    When a partner successfully refers someone to this plan, they will receive 
                                    <span id="preview_months">{{ old('referral_reward_months', $plan->referral_reward_months) ?: 1 }}</span> 
                                    month(s) of free subscription.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Plan Features -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Plan Features</h3>
                    <div class="space-y-6">
                        @php
                            $features = \App\Models\PlanFeature::active()->ordered()->get()->groupBy('category');
                            $categories = \App\Models\PlanFeature::getCategories();
                        @endphp
                        @foreach($features as $category => $categoryFeatures)
                        <div>
                            <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-4">
                                {{ $categories[$category] ?? ucfirst($category) }}
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($categoryFeatures as $feature)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <input type="checkbox"
                                                       id="feature_{{ $feature->id }}"
                                                       name="features[{{ $feature->id }}][enabled]"
                                                       value="1"
                                                       {{ $plan->features()->where('plan_feature_id', $feature->id)->where('is_enabled', true)->exists() ? 'checked' : '' }}
                                                       onchange="toggleFeatureInput({{ $feature->id }}, '{{ $feature->type }}')"
                                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                <label for="feature_{{ $feature->id }}" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    {{ $feature->name }}
                                                </label>
                                            </div>
                                            @if($feature->description)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $feature->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($feature->type === 'numeric')
                                    <div id="feature_input_{{ $feature->id }}" class="mt-3 {{ $plan->features()->where('plan_feature_id', $feature->id)->where('is_enabled', true)->exists() ? '' : 'hidden' }}">
                                        <label for="feature_value_{{ $feature->id }}" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Value @if($feature->unit)({{ $feature->unit }})@endif
                                        </label>
                                        <input type="number"
                                               id="feature_value_{{ $feature->id }}"
                                               name="features[{{ $feature->id }}][value]"
                                               value="{{ $plan->features()->where('plan_feature_id', $feature->id)->first()->pivot->value ?? $feature->default_value }}"
                                               min="0"
                                               class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                               placeholder="Enter value">
                                    </div>
                                    @elseif($feature->type === 'text')
                                    <div id="feature_input_{{ $feature->id }}" class="mt-3 {{ $plan->features()->where('plan_feature_id', $feature->id)->where('is_enabled', true)->exists() ? '' : 'hidden' }}">
                                        <label for="feature_value_{{ $feature->id }}" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Value
                                        </label>
                                        <input type="text"
                                               id="feature_value_{{ $feature->id }}"
                                               name="features[{{ $feature->id }}][value]"
                                               value="{{ $plan->features()->where('plan_feature_id', $feature->id)->first()->pivot->value ?? $feature->default_value }}"
                                               class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                               placeholder="Enter value">
                                    </div>
                                    @elseif($feature->type === 'select' && $feature->options)
                                    <div id="feature_input_{{ $feature->id }}" class="mt-3 {{ $plan->features()->where('plan_feature_id', $feature->id)->where('is_enabled', true)->exists() ? '' : 'hidden' }}">
                                        <label for="feature_value_{{ $feature->id }}" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Select Option
                                        </label>
                                        <select id="feature_value_{{ $feature->id }}"
                                                name="features[{{ $feature->id }}][value]"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                            <option value="">Select an option</option>
                                            @foreach($feature->options as $key => $option)
                                            <option value="{{ $key }}" {{ ($plan->features()->where('plan_feature_id', $feature->id)->first()->pivot->value ?? $feature->default_value) == $key ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    @if($feature->type === 'numeric')
                                    <div id="feature_limit_{{ $feature->id }}" class="mt-3 {{ $plan->features()->where('plan_feature_id', $feature->id)->where('is_enabled', true)->exists() ? '' : 'hidden' }}">
                                        <label for="feature_limit_value_{{ $feature->id }}" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Limit @if($feature->unit)({{ $feature->unit }})@endif
                                        </label>
                                        <input type="number"
                                               id="feature_limit_value_{{ $feature->id }}"
                                               name="features[{{ $feature->id }}][limit_value]"
                                               value="{{ $plan->features()->where('plan_feature_id', $feature->id)->first()->pivot->limit_value ?? '' }}"
                                               min="0"
                                               class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                               placeholder="Enter limit">
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('system-admin.subscription-plans') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    nameInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.value === '') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            slugInput.value = slug;
        }
    });
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('border-red-500');
            } else {
                field.classList.remove('border-red-500');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
});

// Feature input toggle
function toggleFeatureInput(featureId, featureType) {
    const checkbox = document.getElementById('feature_' + featureId);
    const inputDiv = document.getElementById('feature_input_' + featureId);
    const limitDiv = document.getElementById('feature_limit_' + featureId);

    if (checkbox.checked) {
        if (inputDiv) {
            inputDiv.classList.remove('hidden');
        }
        if (limitDiv && featureType === 'numeric') {
            limitDiv.classList.remove('hidden');
        }
    } else {
        if (inputDiv) {
            inputDiv.classList.add('hidden');
        }
        if (limitDiv) {
            limitDiv.classList.add('hidden');
        }
    }
}

// Referral settings toggle
function toggleReferralSettings() {
    const checkbox = document.getElementById('referral_eligible');
    const settingsDiv = document.getElementById('referral_settings');
    
    if (checkbox.checked) {
        settingsDiv.classList.remove('hidden');
    } else {
        settingsDiv.classList.add('hidden');
    }
}

// Update referral preview
document.addEventListener('DOMContentLoaded', function() {
    const rewardMonthsInput = document.getElementById('referral_reward_months');
    const previewMonths = document.getElementById('preview_months');
    
    if (rewardMonthsInput && previewMonths) {
        rewardMonthsInput.addEventListener('input', function() {
            previewMonths.textContent = this.value || '1';
        });
    }
});

// Custom pricing toggle
function toggleCustomPricing() {
    const priceInput = document.getElementById('price');
    const customButton = event.target;
    
    if (priceInput.value === '0' || priceInput.value === '') {
        // Switch to custom pricing
        priceInput.value = '';
        priceInput.placeholder = 'Contact for pricing';
        priceInput.removeAttribute('required');
        customButton.textContent = 'Fixed';
        customButton.classList.remove('text-blue-600', 'hover:text-blue-800', 'dark:text-blue-400', 'dark:hover:text-blue-300');
        customButton.classList.add('text-green-600', 'hover:text-green-800', 'dark:text-green-400', 'dark:hover:text-green-300');
        
        // Add hidden input to indicate custom pricing
        let customInput = document.getElementById('is_custom_pricing');
        if (!customInput) {
            customInput = document.createElement('input');
            customInput.type = 'hidden';
            customInput.id = 'is_custom_pricing';
            customInput.name = 'is_custom_pricing';
            customInput.value = '1';
            priceInput.parentNode.appendChild(customInput);
        }
    } else {
        // Switch to fixed pricing
        priceInput.value = '0';
        priceInput.placeholder = '';
        priceInput.setAttribute('required', 'required');
        customButton.textContent = 'Custom';
        customButton.classList.remove('text-green-600', 'hover:text-green-800', 'dark:text-green-400', 'dark:hover:text-green-300');
        customButton.classList.add('text-blue-600', 'hover:text-blue-800', 'dark:text-blue-400', 'dark:hover:text-blue-300');
        
        // Remove custom pricing indicator
        const customInput = document.getElementById('is_custom_pricing');
        if (customInput) {
            customInput.remove();
        }
    }
}

function deletePlan(planId) {
    if (confirm('Are you sure you want to delete this subscription plan? This action cannot be undone.')) {
        fetch(`/system-admin/subscription/plans/${planId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Plan deleted successfully');
                window.location.href = '{{ route("system-admin.subscription-plans") }}';
            } else {
                alert('Error deleting plan: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting plan');
        });
    }
}
</script>
@endpush

@endsection
