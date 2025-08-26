@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg mb-6">
                <img class="h-12 w-auto" src="{{ asset('images/logo.png') }}" alt="CSuite Logo">
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-3">Partner Registration</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Join our partner network and start offering CSuite services to your students
            </p>
        </div>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('partner.register') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Progress Steps -->
                <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-8 py-6">
                    <div class="flex items-center justify-center space-x-4 text-white">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-30 rounded-full flex items-center justify-center text-sm font-semibold">1</div>
                            <span class="ml-2 text-sm font-medium">Company Info</span>
                        </div>
                        <div class="w-8 h-px bg-white bg-opacity-30"></div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-30 rounded-full flex items-center justify-center text-sm font-semibold">2</div>
                            <span class="ml-2 text-sm font-medium">Contact Details</span>
                        </div>
                        <div class="w-8 h-px bg-white bg-opacity-30"></div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white bg-opacity-30 rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                            <span class="ml-2 text-sm font-medium">Complete</span>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Company Information -->
                            <div class="bg-gray-50 rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-indigo-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"/>
                                    </svg>
                                    Company Information
                                </h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name *</label>
                                        <input id="company_name" name="company_name" type="text" required 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                               value="{{ old('company_name') }}" placeholder="Enter your company name">
                                        @error('company_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="business_type" class="block text-sm font-medium text-gray-700 mb-1">Business Type *</label>
                                        <select id="business_type" name="business_type" required 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                                            <option value="">Select Business Type</option>
                                            <option value="Educational Institution" {{ old('business_type') == 'Educational Institution' ? 'selected' : '' }}>Educational Institution</option>
                                            <option value="Training Center" {{ old('business_type') == 'Training Center' ? 'selected' : '' }}>Training Center</option>
                                            <option value="Corporate" {{ old('business_type') == 'Corporate' ? 'selected' : '' }}>Corporate</option>
                                            <option value="Individual" {{ old('business_type') == 'Individual' ? 'selected' : '' }}>Individual</option>
                                            <option value="Other" {{ old('business_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('business_type')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                                        <input id="website" name="website" type="url" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                               value="{{ old('website') }}" placeholder="https://example.com">
                                        @error('website')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="number_of_students" class="block text-sm font-medium text-gray-700 mb-1">Number of Students *</label>
                                        <select id="number_of_students" name="number_of_students" required 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                                            <option value="">Select Range</option>
                                            <option value="1-50" {{ old('number_of_students') == '1-50' ? 'selected' : '' }}>1-50 Students</option>
                                            <option value="51-100" {{ old('number_of_students') == '51-100' ? 'selected' : '' }}>51-100 Students</option>
                                            <option value="101-500" {{ old('number_of_students') == '101-500' ? 'selected' : '' }}>101-500 Students</option>
                                            <option value="501-1000" {{ old('number_of_students') == '501-1000' ? 'selected' : '' }}>501-1000 Students</option>
                                            <option value="1000+" {{ old('number_of_students') == '1000+' ? 'selected' : '' }}>1000+ Students</option>
                                        </select>
                                        @error('number_of_students')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Business Details -->
                            <div class="bg-gray-50 rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-indigo-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1zm-3 3a1 1 0 100 2h.01a1 1 0 100-2H10zm-4 1a1 1 0 011-1h.01a1 1 0 110 2H7a1 1 0 01-1-1zm1-4a1 1 0 100 2h.01a1 1 0 100-2H7zm2 0a1 1 0 100 2h.01a1 1 0 100-2H9zm2 0a1 1 0 100 2h.01a1 1 0 100-2H11zm2 0a1 1 0 100 2h.01a1 1 0 100-2H13zm-4-3a1 1 0 100 2h.01a1 1 0 100-2H9zm2 0a1 1 0 100 2h.01a1 1 0 100-2H11zm2 0a1 1 0 100 2h.01a1 1 0 100-2H13z" clip-rule="evenodd"/>
                                    </svg>
                                    Business Details
                                </h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="business_license" class="block text-sm font-medium text-gray-700 mb-1">Business License Number</label>
                                        <input id="business_license" name="business_license" type="text" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                               value="{{ old('business_license') }}" placeholder="Enter license number">
                                        @error('business_license')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="tax_id" class="block text-sm font-medium text-gray-700 mb-1">Tax ID Number</label>
                                        <input id="tax_id" name="tax_id" type="text" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                               value="{{ old('tax_id') }}" placeholder="Enter tax ID">
                                        @error('tax_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Contact Information -->
                            <div class="bg-gray-50 rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-indigo-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                    Contact Information
                                </h3>
                                
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                                            <input id="first_name" name="first_name" type="text" required 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                                   value="{{ old('first_name') }}" placeholder="John">
                                            @error('first_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                                            <input id="last_name" name="last_name" type="text" required 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                                   value="{{ old('last_name') }}" placeholder="Doe">
                                            @error('last_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                                        <input id="email" name="email" type="email" required 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                               value="{{ old('email') }}" placeholder="john@company.com">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                                        <input id="phone" name="phone" type="tel" required 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                               value="{{ old('phone') }}" placeholder="+1 (555) 123-4567">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="bg-gray-50 rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-indigo-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    Address Information
                                </h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address *</label>
                                        <input id="address" name="address" type="text" required 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                               value="{{ old('address') }}" placeholder="123 Business Street">
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                            <input id="city" name="city" type="text" required 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                                   value="{{ old('city') }}" placeholder="Dhaka">
                                            @error('city')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code *</label>
                                            <input id="postal_code" name="postal_code" type="text" required 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                                   value="{{ old('postal_code') }}" placeholder="1000">
                                            @error('postal_code')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                                        <select id="country" name="country" required 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                                            <option value="">Select Country</option>
                                            <option value="Bangladesh" {{ old('country') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                            <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                                            <option value="Pakistan" {{ old('country') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                            <option value="Sri Lanka" {{ old('country') == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                                            <option value="Nepal" {{ old('country') == 'Nepal' ? 'selected' : '' }}>Nepal</option>
                                            <option value="Other" {{ old('country') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('country')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Password Section -->
                            <div class="bg-gray-50 rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-indigo-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Account Security
                                </h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                                        <input id="password" name="password" type="password" required 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                               placeholder="Enter a strong password">
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label>
                                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                               placeholder="Confirm your password">
                                        @error('password_confirmation')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Submit -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-start mb-6">
                            <input id="terms_accepted" name="terms_accepted" type="checkbox" required 
                                   class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="terms_accepted" class="ml-3 text-sm text-gray-700">
                                I agree to the <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">Terms of Service</a> and <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">Privacy Policy</a> *
                            </label>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="submit" 
                                    class="flex-1 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-semibold py-4 px-8 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Create Partner Account
                            </button>
                            
                            <a href="{{ route('login') }}" 
                               class="flex-1 sm:flex-none bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-4 px-8 rounded-lg transition-all duration-200 flex items-center justify-center">
                                Already have an account?
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Trust Indicators -->
        <div class="mt-8 text-center">
            <div class="flex items-center justify-center space-x-6 text-sm text-gray-500">
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    Secure Registration
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-blue-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    Email Verification
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-purple-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    24/7 Support
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
