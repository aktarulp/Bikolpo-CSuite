@extends('layouts.system-admin-layout')

@section('title', 'Create Subscription Plan - System Admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Subscription Plan</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Add a new subscription plan to your system</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('system-admin.subscription-plans') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Plans
                    </a>
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
            <form action="{{ route('system-admin.subscription-plans.store') }}" method="POST" class="space-y-8">
                @csrf
                
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
                                   value="{{ old('name') }}"
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
                                   value="{{ old('slug') }}"
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
                                      placeholder="Describe the plan features and benefits">{{ old('description') }}</textarea>
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
                                       value="{{ old('price', 0) }}"
                                       step="0.01"
                                       min="0"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                       required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <button type="button" 
                                            onclick="toggleCustomPricing()"
                                            class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        Custom
                                    </button>
                                </div>
                            </div>
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
                                <option value="BDT" {{ old('currency', 'BDT') == 'BDT' ? 'selected' : '' }}>BDT (৳)</option>
                                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
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
                                <option value="monthly" {{ old('billing_cycle', 'monthly') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ old('billing_cycle') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                <option value="lifetime" {{ old('billing_cycle') == 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                            </select>
                            @error('billing_cycle')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Offer Pricing -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Offer Pricing (Optional)</h3>
                    
                    <div class="space-y-6">
                        <!-- Offer Toggle -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="enable_offer" 
                                   name="enable_offer" 
                                   value="1"
                                   {{ old('enable_offer') ? 'checked' : '' }}
                                   onchange="toggleOfferFields()"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="enable_offer" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Enable promotional pricing
                            </label>
                        </div>

                        <!-- Offer Fields (initially hidden) -->
                        <div id="offerFields" class="space-y-6 hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Offer Price -->
                                <div>
                                    <label for="offer_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Offer Price (৳)
                                    </label>
                                    <input type="number" 
                                           id="offer_price" 
                                           name="offer_price" 
                                           value="{{ old('offer_price') }}"
                                           step="0.01"
                                           min="0"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="Enter offer price">
                                    @error('offer_price')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Offer Name -->
                                <div>
                                    <label for="offer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Offer Name
                                    </label>
                                    <input type="text" 
                                           id="offer_name" 
                                           name="offer_name" 
                                           value="{{ old('offer_name') }}"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="e.g., Early Bird Special">
                                    @error('offer_name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Offer Description -->
                            <div>
                                <label for="offer_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Offer Description
                                </label>
                                <textarea id="offer_description" 
                                          name="offer_description" 
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                          placeholder="Describe the offer benefits...">{{ old('offer_description') }}</textarea>
                                @error('offer_description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Offer Start Date -->
                                <div>
                                    <label for="offer_start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Offer Start Date
                                    </label>
                                    <input type="datetime-local" 
                                           id="offer_start_date" 
                                           name="offer_start_date" 
                                           value="{{ old('offer_start_date') }}"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    @error('offer_start_date')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Offer End Date -->
                                <div>
                                    <label for="offer_end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Offer End Date
                                    </label>
                                    <input type="datetime-local" 
                                           id="offer_end_date" 
                                           name="offer_end_date" 
                                           value="{{ old('offer_end_date') }}"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    @error('offer_end_date')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Max Users -->
                                <div>
                                    <label for="offer_max_users" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Max Users (Optional)
                                    </label>
                                    <input type="number" 
                                           id="offer_max_users" 
                                           name="offer_max_users" 
                                           value="{{ old('offer_max_users') }}"
                                           min="1"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="Leave empty for unlimited">
                                    @error('offer_max_users')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Offer Code -->
                                <div>
                                    <label for="offer_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Offer Code (Optional)
                                    </label>
                                    <input type="text" 
                                           id="offer_code" 
                                           name="offer_code" 
                                           value="{{ old('offer_code') }}"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="e.g., EARLYBIRD2024">
                                    @error('offer_code')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Badge Text -->
                                <div>
                                    <label for="offer_badge_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Badge Text
                                    </label>
                                    <input type="text" 
                                           id="offer_badge_text" 
                                           name="offer_badge_text" 
                                           value="{{ old('offer_badge_text') }}"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="e.g., 50% OFF">
                                    @error('offer_badge_text')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Badge Color -->
                                <div>
                                    <label for="offer_badge_color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Badge Color
                                    </label>
                                    <select id="offer_badge_color" 
                                            name="offer_badge_color"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                        <option value="red" {{ old('offer_badge_color', 'red') == 'red' ? 'selected' : '' }}>Red</option>
                                        <option value="green" {{ old('offer_badge_color') == 'green' ? 'selected' : '' }}>Green</option>
                                        <option value="blue" {{ old('offer_badge_color') == 'blue' ? 'selected' : '' }}>Blue</option>
                                        <option value="yellow" {{ old('offer_badge_color') == 'yellow' ? 'selected' : '' }}>Yellow</option>
                                        <option value="purple" {{ old('offer_badge_color') == 'purple' ? 'selected' : '' }}>Purple</option>
                                        <option value="orange" {{ old('offer_badge_color') == 'orange' ? 'selected' : '' }}>Orange</option>
                                    </select>
                                    @error('offer_badge_color')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Offer Settings -->
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="offer_auto_apply" 
                                           name="offer_auto_apply" 
                                           value="1"
                                           {{ old('offer_auto_apply') ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="offer_auto_apply" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Auto-apply offer
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="offer_show_original_price" 
                                           name="offer_show_original_price" 
                                           value="1"
                                           {{ old('offer_show_original_price', true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="offer_show_original_price" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Show original price
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Annual Subscription Offer -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Annual Subscription Offer (Optional)</h3>
                    
                    <div class="space-y-6">
                        <!-- Annual Offer Toggle -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="enable_annual_offer" 
                                   name="enable_annual_offer" 
                                   value="1"
                                   {{ old('enable_annual_offer') ? 'checked' : '' }}
                                   onchange="toggleAnnualOfferFields()"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="enable_annual_offer" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Enable annual subscription discount
                            </label>
                        </div>

                        <!-- Annual Offer Fields (initially hidden) -->
                        <div id="annualOfferFields" class="space-y-6 hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Annual Price -->
                                <div>
                                    <label for="annual_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Annual Price (৳)
                                    </label>
                                    <input type="number" 
                                           id="annual_price" 
                                           name="annual_price" 
                                           value="{{ old('annual_price') }}"
                                           step="0.01"
                                           min="0"
                                           onchange="calculateAnnualSavings()"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="Enter annual price">
                                    @error('annual_price')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Annual Offer Name -->
                                <div>
                                    <label for="annual_offer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Offer Name
                                    </label>
                                    <input type="text" 
                                           id="annual_offer_name" 
                                           name="annual_offer_name" 
                                           value="{{ old('annual_offer_name') }}"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="e.g., Annual Subscription">
                                    @error('annual_offer_name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Annual Offer Description -->
                            <div>
                                <label for="annual_offer_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Offer Description
                                </label>
                                <textarea id="annual_offer_description" 
                                          name="annual_offer_description" 
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                          placeholder="Describe the annual offer benefits...">{{ old('annual_offer_description') }}</textarea>
                                @error('annual_offer_description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Savings Display -->
                            <div id="annualSavingsDisplay" class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 hidden">
                                <h4 class="text-sm font-medium text-green-800 dark:text-green-200 mb-2">Annual Savings Preview</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <span class="text-green-600 dark:text-green-400">Monthly Total:</span>
                                        <span id="monthlyTotal" class="font-medium text-green-800 dark:text-green-200">৳0</span>
                                    </div>
                                    <div>
                                        <span class="text-green-600 dark:text-green-400">Annual Price:</span>
                                        <span id="annualPriceDisplay" class="font-medium text-green-800 dark:text-green-200">৳0</span>
                                    </div>
                                    <div>
                                        <span class="text-green-600 dark:text-green-400">You Save:</span>
                                        <span id="savingsAmount" class="font-medium text-green-800 dark:text-green-200">৳0</span>
                                        <span id="savingsPercentage" class="text-green-600 dark:text-green-400">(0%)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Badge Text -->
                                <div>
                                    <label for="annual_badge_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Badge Text
                                    </label>
                                    <input type="text" 
                                           id="annual_badge_text" 
                                           name="annual_badge_text" 
                                           value="{{ old('annual_badge_text', 'SAVE 2 MONTHS') }}"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="e.g., SAVE 2 MONTHS">
                                    @error('annual_badge_text')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Badge Color -->
                                <div>
                                    <label for="annual_badge_color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Badge Color
                                    </label>
                                    <select id="annual_badge_color" 
                                            name="annual_badge_color"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                        <option value="green" {{ old('annual_badge_color', 'green') == 'green' ? 'selected' : '' }}>Green</option>
                                        <option value="blue" {{ old('annual_badge_color') == 'blue' ? 'selected' : '' }}>Blue</option>
                                        <option value="purple" {{ old('annual_badge_color') == 'purple' ? 'selected' : '' }}>Purple</option>
                                        <option value="orange" {{ old('annual_badge_color') == 'orange' ? 'selected' : '' }}>Orange</option>
                                        <option value="red" {{ old('annual_badge_color') == 'red' ? 'selected' : '' }}>Red</option>
                                        <option value="yellow" {{ old('annual_badge_color') == 'yellow' ? 'selected' : '' }}>Yellow</option>
                                    </select>
                                    @error('annual_badge_color')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Annual Offer Settings -->
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="annual_show_monthly_equivalent" 
                                           name="annual_show_monthly_equivalent" 
                                           value="1"
                                           {{ old('annual_show_monthly_equivalent', true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="annual_show_monthly_equivalent" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Show monthly equivalent price
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="annual_highlight_savings" 
                                           name="annual_highlight_savings" 
                                           value="1"
                                           {{ old('annual_highlight_savings', true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="annual_highlight_savings" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Highlight savings amount
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Referral System -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Referral System (Invite & Earn)</h3>
                    
                    <div class="space-y-6">
                        <!-- Referral Toggle -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="referral_eligible" 
                                   name="referral_eligible" 
                                   value="1"
                                   {{ old('referral_eligible') ? 'checked' : '' }}
                                   onchange="toggleReferralFields()"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="referral_eligible" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Enable referral rewards for this plan
                            </label>
                        </div>

                        <!-- Referral Fields (initially hidden) -->
                        <div id="referralFields" class="space-y-6 hidden">
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">How it works:</h4>
                                <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                                    <li>• Partners can invite other partners using their referral code</li>
                                    <li>• When referred partner subscribes to a 6+ month plan, referrer gets reward</li>
                                    <li>• Rewards are automatically applied to referrer's account</li>
                                    <li>• System tracks all referrals and rewards</li>
                                </ul>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Reward Months -->
                                <div>
                                    <label for="referral_reward_months" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Reward Months
                                    </label>
                                    <input type="number" 
                                           id="referral_reward_months" 
                                           name="referral_reward_months" 
                                           value="{{ old('referral_reward_months', 1) }}"
                                           min="1"
                                           max="12"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="Number of free months">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Number of free months referrer gets</p>
                                    @error('referral_reward_months')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Minimum Amount -->
                                <div>
                                    <label for="referral_minimum_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Minimum Subscription Amount (৳)
                                    </label>
                                    <input type="number" 
                                           id="referral_minimum_amount" 
                                           name="referral_minimum_amount" 
                                           value="{{ old('referral_minimum_amount') }}"
                                           step="0.01"
                                           min="0"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="Minimum amount for referral reward">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave empty for no minimum</p>
                                    @error('referral_minimum_amount')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Referral Conditions -->
                            <div>
                                <label for="referral_conditions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Additional Conditions (JSON)
                                </label>
                                <textarea id="referral_conditions" 
                                          name="referral_conditions" 
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                          placeholder='{"min_subscription_duration": 6, "plan_types": ["premium", "enterprise"]}'>{{ old('referral_conditions') }}</textarea>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Optional JSON conditions for referral eligibility</p>
                                @error('referral_conditions')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Referral Preview -->
                            <div id="referralPreview" class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 hidden">
                                <h4 class="text-sm font-medium text-green-800 dark:text-green-200 mb-2">Referral Reward Preview</h4>
                                <div class="text-sm text-green-700 dark:text-green-300">
                                    <p>When a partner refers someone who subscribes to this plan:</p>
                                    <ul class="mt-2 space-y-1">
                                        <li>• Referrer gets <span id="previewRewardMonths" class="font-medium">1</span> month(s) free subscription</li>
                                        <li id="previewMinimumAmount" class="hidden">• Minimum subscription amount: ৳<span id="previewMinimumValue">0</span></li>
                                        <li>• Reward is automatically applied to referrer's account</li>
                                    </ul>
                                </div>
                            </div>
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
                                <option value="partner" {{ old('partner_type') == 'partner' ? 'selected' : '' }}>Partner Plan</option>
                                <option value="student" {{ old('partner_type') == 'student' ? 'selected' : '' }}>Student Plan</option>
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
                                   value="{{ old('sort_order', 0) }}"
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
                        </div>
                    </div>
                </div>

                <!-- Plan Features -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Plan Features</h3>
                    
                    <div class="space-y-6">
                        @php
                            $features = \App\Models\PlanFeature::active()->ordered()->get()->groupBy('category');
                        @endphp
                        
                        @foreach($features as $category => $categoryFeatures)
                        <div>
                            <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-4">
                                {{ \App\Models\PlanFeature::getCategories()[$category] ?? ucfirst($category) }}
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
                                                       {{ old("features.{$feature->id}.enabled") ? 'checked' : '' }}
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
                                    <div id="feature_input_{{ $feature->id }}" class="mt-3 hidden">
                                        <label for="feature_value_{{ $feature->id }}" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Value @if($feature->unit)({{ $feature->unit }})@endif
                                        </label>
                                        <input type="number" 
                                               id="feature_value_{{ $feature->id }}" 
                                               name="features[{{ $feature->id }}][value]" 
                                               value="{{ old("features.{$feature->id}.value") }}"
                                               min="0"
                                               class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                               placeholder="Enter value">
                                    </div>
                                    @elseif($feature->type === 'text')
                                    <div id="feature_input_{{ $feature->id }}" class="mt-3 hidden">
                                        <label for="feature_value_{{ $feature->id }}" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Value
                                        </label>
                                        <input type="text" 
                                               id="feature_value_{{ $feature->id }}" 
                                               name="features[{{ $feature->id }}][value]" 
                                               value="{{ old("features.{$feature->id}.value") }}"
                                               class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                               placeholder="Enter value">
                                    </div>
                                    @elseif($feature->type === 'select' && $feature->options)
                                    <div id="feature_input_{{ $feature->id }}" class="mt-3 hidden">
                                        <label for="feature_value_{{ $feature->id }}" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Select Option
                                        </label>
                                        <select id="feature_value_{{ $feature->id }}" 
                                                name="features[{{ $feature->id }}][value]"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                            <option value="">Select an option</option>
                                            @foreach($feature->options as $key => $option)
                                            <option value="{{ $key }}" {{ old("features.{$feature->id}.value") == $key ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    
                                    @if($feature->type === 'numeric')
                                    <div id="feature_limit_{{ $feature->id }}" class="mt-3 hidden">
                                        <label for="feature_limit_value_{{ $feature->id }}" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Limit @if($feature->unit)({{ $feature->unit }})@endif
                                        </label>
                                        <input type="number" 
                                               id="feature_limit_value_{{ $feature->id }}" 
                                               name="features[{{ $feature->id }}][limit_value]" 
                                               value="{{ old("features.{$feature->id}.limit_value") }}"
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
                        Create Plan
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

// Offer fields toggle
function toggleOfferFields() {
    const enableOffer = document.getElementById('enable_offer');
    const offerFields = document.getElementById('offerFields');
    
    if (enableOffer.checked) {
        offerFields.classList.remove('hidden');
    } else {
        offerFields.classList.add('hidden');
    }
}

// Annual offer fields toggle
function toggleAnnualOfferFields() {
    const enableAnnualOffer = document.getElementById('enable_annual_offer');
    const annualOfferFields = document.getElementById('annualOfferFields');
    
    if (enableAnnualOffer.checked) {
        annualOfferFields.classList.remove('hidden');
    } else {
        annualOfferFields.classList.add('hidden');
    }
}

// Calculate annual savings
function calculateAnnualSavings() {
    const monthlyPrice = parseFloat(document.getElementById('price').value) || 0;
    const annualPrice = parseFloat(document.getElementById('annual_price').value) || 0;
    
    if (monthlyPrice > 0 && annualPrice > 0) {
        const monthlyTotal = monthlyPrice * 12;
        const savingsAmount = monthlyTotal - annualPrice;
        const savingsPercentage = ((savingsAmount / monthlyTotal) * 100).toFixed(1);
        
        // Update display
        document.getElementById('monthlyTotal').textContent = '৳' + monthlyTotal.toLocaleString();
        document.getElementById('annualPriceDisplay').textContent = '৳' + annualPrice.toLocaleString();
        document.getElementById('savingsAmount').textContent = '৳' + savingsAmount.toLocaleString();
        document.getElementById('savingsPercentage').textContent = '(' + savingsPercentage + '%)';
        
        // Show savings display
        document.getElementById('annualSavingsDisplay').classList.remove('hidden');
    } else {
        // Hide savings display
        document.getElementById('annualSavingsDisplay').classList.add('hidden');
    }
}

// Referral fields toggle
function toggleReferralFields() {
    const enableReferral = document.getElementById('referral_eligible');
    const referralFields = document.getElementById('referralFields');
    
    if (enableReferral.checked) {
        referralFields.classList.remove('hidden');
        updateReferralPreview();
    } else {
        referralFields.classList.add('hidden');
    }
}

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

// Update referral preview
function updateReferralPreview() {
    const rewardMonths = document.getElementById('referral_reward_months').value || 1;
    const minimumAmount = document.getElementById('referral_minimum_amount').value;
    
    // Update preview
    document.getElementById('previewRewardMonths').textContent = rewardMonths;
    
    if (minimumAmount && minimumAmount > 0) {
        document.getElementById('previewMinimumValue').textContent = minimumAmount;
        document.getElementById('previewMinimumAmount').classList.remove('hidden');
    } else {
        document.getElementById('previewMinimumAmount').classList.add('hidden');
    }
    
    // Show preview
    document.getElementById('referralPreview').classList.remove('hidden');
}

// Add event listeners for referral fields
document.addEventListener('DOMContentLoaded', function() {
    const referralRewardMonths = document.getElementById('referral_reward_months');
    const referralMinimumAmount = document.getElementById('referral_minimum_amount');
    
    if (referralRewardMonths) {
        referralRewardMonths.addEventListener('input', updateReferralPreview);
    }
    
    if (referralMinimumAmount) {
        referralMinimumAmount.addEventListener('input', updateReferralPreview);
    }
});
</script>
@endpush

@endsection
