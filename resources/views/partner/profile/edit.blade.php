@extends('layouts.partner-layout')

@section('title', 'Edit Profile')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Edit Profile
                    </h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Update your complete profile information
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('partner.profile.show') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View Profile
                    </a>
                    <button type="submit" form="profile-form"
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primaryGreen hover:bg-primaryGreen/90 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Update Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

        <!-- Edit Profile Form -->
        <form id="profile-form" action="{{ route('partner.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            


            <!-- Basic Information Group -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-purple-200 dark:border-purple-700 shadow-xl hover:shadow-2xl transition-all duration-300">
                <div class="px-6 py-4 border-b border-purple-200 dark:border-purple-700 bg-gradient-to-r from-purple-50 to-blue-50 dark:from-purple-900/50 dark:to-blue-900/50 rounded-t-2xl">
                    <h3 class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600 dark:from-purple-400 dark:to-blue-400 flex items-center">
                        <svg class="w-5 h-5 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        🎯 Basic Information
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                         <!-- Logo Upload -->
                         <div class="group flex items-center space-x-4">
                             <label for="logo" class="text-sm font-semibold text-purple-700 dark:text-purple-300 whitespace-nowrap flex items-center">
                                 🖼️ Logo
                             </label>
                             <div class="flex-1">
                                                                   <input type="file" id="logo" name="logo" accept="image/*"
                                         class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                 
                                 @error('logo')
                                     <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                 @enderror
                             </div>
                         </div>

                                                   <!-- Partner Category -->
                          <div class="group flex items-center space-x-4">
                              <label for="partner_category" class="text-sm font-semibold text-rose-700 dark:text-rose-300 whitespace-nowrap flex items-center">
                                  🏷️ Partner Category
                              </label>
                              <div class="flex-1">
                                                                                                         <select id="partner_category" name="partner_category" 
                                            class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                       <option value="">Select Partner Category</option>
                                       <option value="school" {{ old('partner_category', $partner->partner_category) == 'school' ? 'selected' : '' }}>School</option>
                                       <option value="college" {{ old('partner_category', $partner->partner_category) == 'college' ? 'selected' : '' }}>College</option>
                                       <option value="university" {{ old('partner_category', $partner->partner_category) == 'university' ? 'selected' : '' }}>University</option>
                                       <option value="coaching_center" {{ old('partner_category', $partner->partner_category) == 'coaching_center' ? 'selected' : '' }}>Coaching Center</option>
                                       <option value="training_institute" {{ old('partner_category', $partner->partner_category) == 'training_institute' ? 'selected' : '' }}>Training Institute</option>
                                       <option value="tutoring_service" {{ old('partner_category', $partner->partner_category) == 'tutoring_service' ? 'selected' : '' }}>Tutoring Service</option>
                                       <option value="home_tutor" {{ old('partner_category', $partner->partner_category) == 'home_tutor' ? 'selected' : '' }}>Home Tutor</option>
                                       <option value="teacher" {{ old('partner_category', $partner->partner_category) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                       <option value="online_education" {{ old('partner_category', $partner->partner_category) == 'online_education' ? 'selected' : '' }}>Online Education</option>
                                       <option value="skill_development" {{ old('partner_category', $partner->partner_category) == 'skill_development' ? 'selected' : '' }}>Skill Development Center</option>
                                       <option value="language_center" {{ old('partner_category', $partner->partner_category) == 'language_center' ? 'selected' : '' }}>Language Center</option>
                                       <option value="computer_training" {{ old('partner_category', $partner->partner_category) == 'computer_training' ? 'selected' : '' }}>Computer Training Center</option>
                                       <option value="other" {{ old('partner_category', $partner->partner_category) == 'other' ? 'selected' : '' }}>Other</option>
                                   </select>
                                  @error('partner_category')
                                      <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                  @enderror
                              </div>
                          </div>
                     </div>

                                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
 
 
                         <div class="group flex items-center space-x-4">
                             <label for="institute_name" class="text-sm font-semibold text-blue-700 dark:text-blue-300 whitespace-nowrap flex items-center">
                                 🏫 Institute Name
                             </label>
                             <div class="flex-1">
                                 <input type="text" id="institute_name" name="institute_name" value="{{ old('institute_name', $partner->institute_name) }}"
                                        class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                 @error('institute_name')
                                     <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                 @enderror
                             </div>
                         </div>
 
                         <div class="group flex items-center space-x-4">
                             <label for="institute_name_bangla" class="text-sm font-semibold text-indigo-700 dark:text-indigo-300 whitespace-nowrap flex items-center">
                                 🏫 Institute Name (বাংলা)
                             </label>
                             <div class="flex-1">
                                 <input type="text" id="institute_name_bangla" name="institute_name_bangla" value="{{ old('institute_name_bangla', $partner->institute_name_bangla) }}"
                                        class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                 @error('institute_name_bangla')
                                     <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                 @enderror
                             </div>
                         </div>

                         <div class="group flex items-center space-x-4">
                             <label for="slug_bangla" class="text-sm font-semibold text-pink-700 dark:text-pink-300 whitespace-nowrap flex items-center">
                                 🔗 Short Name (বাংলা)
                             </label>
                             <div class="flex-1">
                                 <input type="text" id="slug_bangla" name="slug_bangla" value="{{ old('slug_bangla', $partner->slug_bangla) }}"
                                        class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                 @error('slug_bangla')
                                     <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                 @enderror
                             </div>
                         </div>

                        <div class="group flex items-center space-x-4">
                            <label for="owner_name" class="text-sm font-semibold text-emerald-700 dark:text-emerald-300 whitespace-nowrap flex items-center">
                                👤 Owner Name
                            </label>
                            <div class="flex-1">
                                                                 <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name', $partner->owner_name) }}"
                                        class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                @error('owner_name')
                                    <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                                                                          <div class="group flex items-center space-x-4">
                             <label for="owner_director_name" class="text-sm font-semibold text-amber-700 dark:text-amber-300 whitespace-nowrap flex items-center">
                                 🎯 Director/Manager
                             </label>
                             <div class="flex-1">
                                 <input type="text" id="owner_director_name" name="owner_director_name" value="{{ old('owner_director_name', $partner->owner_director_name) }}"
                                        class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                 @error('owner_director_name')
                                     <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                 @enderror
                             </div>
                         </div>
 

 
                                                                                                       <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                              <!-- Short Name -->
                              <div class="group flex items-center space-x-2">
                                  <label for="slug" class="text-sm font-semibold text-violet-700 dark:text-violet-300 whitespace-nowrap flex items-center">
                                      🔗 Short Name
                                  </label>
                                  <div class="flex-1">
                                      <input type="text" id="slug" name="slug" value="{{ old('slug', $partner->slug) }}"
                                             class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                      @error('slug')
                                          <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                      @enderror
                                  </div>
                              </div>
                              
                              <!-- Year of Establishment -->
                              <div class="group flex items-center space-x-2">
                                                                     <label for="year_of_establishment" class="text-sm font-semibold text-rose-700 dark:text-rose-300 whitespace-nowrap flex items-center">
                                       🏛️ Year of Estd.
                                   </label>
                                  <div class="flex-1">
                                      <input type="number" id="year_of_establishment" name="year_of_establishment" value="{{ old('year_of_establishment', $partner->year_of_establishment) }}" min="1900" max="{{ date('Y') + 1 }}"
                                             class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                      @error('year_of_establishment')
                                          <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                      @enderror
                                  </div>
                              </div>
                          </div>
                    </div>


                </div>
            </div>

            <!-- Contact Information Group -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-emerald-200 dark:border-emerald-700 shadow-xl hover:shadow-2xl transition-all duration-300">
                <div class="px-6 py-4 border-b border-emerald-200 dark:border-emerald-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/50 dark:to-teal-900/50 rounded-t-2xl">
                    <h3 class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-400 dark:to-teal-400 flex items-center">
                        <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        📞 Contact Information
                    </h3>
                </div>
                                 <div class="p-6 space-y-4">
                                          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                         <div class="group flex items-center space-x-4">
                             <label for="mobile" class="text-sm font-semibold text-emerald-700 dark:text-emerald-300 whitespace-nowrap flex items-center">
                                 📱 Mobile
                             </label>
                             <div class="flex-1">
                                 <input type="text" id="mobile" name="mobile" value="{{ old('mobile', $partner->mobile) }}"
                                        class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                 @error('mobile')
                                     <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                 @enderror
                             </div>
                         </div>

                         <div class="group flex items-center space-x-4">
                             <label for="alternate_mobile" class="text-sm font-semibold text-teal-700 dark:text-teal-300 whitespace-nowrap flex items-center">
                                 📱 Alt Mobile
                             </label>
                             <div class="flex-1">
                                 <input type="text" id="alternate_mobile" name="alternate_mobile" value="{{ old('alternate_mobile', $partner->alternate_mobile) }}"
                                        class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                 @error('alternate_mobile')
                                     <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                 @enderror
                             </div>
                         </div>

                         <div class="group flex items-center space-x-4">
                             <label for="website" class="text-sm font-semibold text-cyan-700 dark:text-cyan-300 whitespace-nowrap flex items-center">
                                 🌐 Website
                             </label>
                             <div class="flex-1">
                                 <input type="url" id="website" name="website" value="{{ old('website', $partner->website) }}"
                                        class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                 @error('website')
                                     <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                 @enderror
                             </div>
                         </div>

                         <div class="group flex items-center space-x-4">
                             <label for="facebook_page" class="text-sm font-semibold text-blue-700 dark:text-blue-300 whitespace-nowrap flex items-center">
                                 📘 Facebook
                             </label>
                             <div class="flex-1">
                                 <input type="url" id="facebook_page" name="facebook_page" value="{{ old('facebook_page', $partner->facebook_page) }}"
                                        class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                 @error('facebook_page')
                                     <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                 @enderror
                             </div>
                         </div>

                         <div class="group flex items-center space-x-4">
                             <label for="primary_contact_person" class="text-sm font-semibold text-indigo-700 dark:text-indigo-300 whitespace-nowrap flex items-center">
                                 👨‍💼 Primary Contact
                             </label>
                             <div class="flex-1">
                                 <input type="text" id="primary_contact_person" name="primary_contact_person" value="{{ old('primary_contact_person', $partner->primary_contact_person) }}"
                                        class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                 @error('primary_contact_person')
                                     <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                 @enderror
                             </div>
                         </div>

                         <div class="group flex items-center space-x-4">
                             <label for="primary_contact_no" class="text-sm font-semibold text-purple-700 dark:text-purple-300 whitespace-nowrap flex items-center">
                                 📞 Primary Contact No
                             </label>
                             <div class="flex-1">
                                 <input type="text" id="primary_contact_no" name="primary_contact_no" value="{{ old('primary_contact_no', $partner->primary_contact_no) }}"
                                        class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                 @error('primary_contact_no')
                                     <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                 @enderror
                             </div>
                         </div>

                         <div class="group flex items-center space-x-4">
                             <label for="alternate_contact_person" class="text-sm font-semibold text-pink-700 dark:text-pink-300 whitespace-nowrap flex items-center">
                                 👩‍💼 Alt Contact
                             </label>
                             <div class="flex-1">
                                 <input type="text" id="alternate_contact_person" name="alternate_contact_person" value="{{ old('alternate_contact_person', $partner->alternate_contact_person) }}"
                                        class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                 @error('alternate_contact_person')
                                     <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                 @enderror
                             </div>
                         </div>

                         <div class="group flex items-center space-x-4">
                             <label for="alternate_contact_no" class="text-sm font-semibold text-rose-700 dark:text-rose-300 whitespace-nowrap flex items-center">
                                 📞 Alt Contact No
                             </label>
                             <div class="flex-1">
                                 <input type="text" id="alternate_contact_no" name="alternate_contact_no" value="{{ old('alternate_contact_no', $partner->alternate_contact_no) }}"
                                        class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                 @error('alternate_contact_no')
                                     <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                 @enderror
                             </div>
                         </div>
                     </div>
                </div>
            </div>

            <!-- Location Information Group -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-amber-200 dark:border-amber-700 shadow-xl hover:shadow-2xl transition-all duration-300">

                <div class="px-6 py-4 border-b border-amber-200 dark:border-amber-700 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/50 dark:to-orange-900/50 rounded-t-2xl">

                    <h3 class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-orange-600 dark:from-amber-400 dark:to-orange-400 flex items-center">

                        <svg class="w-5 h-5 mr-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>

                        </svg>
                        🗺️ Location Information
                    </h3>
                </div>
                                 <div class="p-6 space-y-4">
                                                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <div class="group flex items-center space-x-4">
                                <label for="division" class="text-sm font-semibold text-amber-700 dark:text-amber-300 whitespace-nowrap flex items-center">
                                    🏛️ Division
                                </label>
                                <div class="flex-1">
                                                                         <select id="division" name="division"
                                             class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                        <option value="">Select Division</option>
                                    </select>
                                    @error('division')
                                        <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                                                    <div class="group flex items-center space-x-4">
                                <label for="district" class="text-sm font-semibold text-orange-700 dark:text-orange-300 whitespace-nowrap flex items-center">
                                    🏘️ District
                                </label>
                                <div class="flex-1">
                                                                         <select id="district" name="district"
                                             class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                        <option value="">Select District</option>
                                    </select>
                                    @error('district')
                                        <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                                                    <div class="group flex items-center space-x-4">
                                <label for="upazila" class="text-sm font-semibold text-red-700 dark:text-red-300 whitespace-nowrap flex items-center">
                                    🏢 Upazila
                                </label>
                                <div class="flex-1">
                                                                         <select id="upazila" name="upazila"
                                             class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                        <option value="">Select Upazila</option>
                                    </select>
                                    @error('upazila')
                                        <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>



                                                  
                     </div>



                                                                                   

                                             <!-- Row 2: Post Office, Post Code, Village/Road (3 columns) -->
                       <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                                     <div class="group flex items-center space-x-4">
                               <label for="post_office" class="text-sm font-semibold text-rose-700 dark:text-rose-300 whitespace-nowrap flex items-center">
                                   📮 Post Office
                               </label>
                               <div class="flex-1">
                                                                       <input type="text" id="post_office" name="post_office" value="{{ old('post_office', $partner->post_office) }}"
                                           class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                   @error('post_office')
                                       <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                   @enderror
                               </div>
                           </div>

                                                                                                     <div class="group flex items-center space-x-4">
                               <label for="post_code" class="text-sm font-semibold text-purple-700 dark:text-purple-300 whitespace-nowrap flex items-center">
                                   📮 Post Code
                               </label>
                               <div class="flex-1">
                                                                       <input type="text" id="post_code" name="post_code" value="{{ old('post_code', $partner->post_code) }}"
                                           class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                   @error('post_code')
                                       <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                   @enderror
                               </div>
                           </div>

                                                                                                     <div class="group flex items-center space-x-4">
                               <label for="village_road_no" class="text-sm font-semibold text-indigo-700 dark:text-indigo-300 whitespace-nowrap flex items-center">
                                   🛣️ Village/Road
                               </label>
                               <div class="flex-1">
                                                                       <input type="text" id="village_road_no" name="village_road_no" value="{{ old('village_road_no', $partner->village_road_no) }}"
                                           class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                   @error('village_road_no')
                                       <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                   @enderror
                               </div>
                           </div>
                     </div>

                                                                                       <!-- Row 3: Flat/House and Short Address (2 columns) -->
                       <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                                      <div class="group flex items-center space-x-4">
                                <label for="flat_house_no" class="text-sm font-semibold text-blue-700 dark:text-blue-300 whitespace-nowrap flex items-center">
                                    🏠 Flat/House
                                </label>
                                <div class="flex-1">
                                                                         <input type="text" id="flat_house_no" name="flat_house_no" value="{{ old('flat_house_no', $partner->flat_house_no) }}"
                                            class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                    @error('flat_house_no')
                                        <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="group flex items-center space-x-4">
                                <label for="short_address" class="text-sm font-semibold text-cyan-700 dark:text-cyan-300 whitespace-nowrap flex items-center">
                                    📍 Short Address
                                </label>
                                <div class="flex-1">
                                                                         <input type="text" id="short_address" name="short_address" value="{{ old('short_address', $partner->short_address) }}"
                                            class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                    @error('short_address')
                                        <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                      </div>



                                                                                                                                                                       
                </div>
            </div>




            <!-- Academic & Service Offer Group -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-amber-200 dark:border-amber-700 shadow-xl hover:shadow-2xl transition-all duration-300">
                <div class="px-6 py-4 border-b border-amber-200 dark:border-amber-700 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/50 dark:to-orange-900/50 rounded-t-2xl">
                    <h3 class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-orange-600 dark:from-amber-400 dark:to-orange-400 flex items-center">
                        <svg class="w-5 h-5 mr-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        📚 Academic & Service Offer
                    </h3>
                </div>
                                 <div class="p-6 space-y-4">
                     <!-- Course Offer Section -->
                     <div>
                         <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center">
                            🎯 Course Offer
                        </h4>
                                                                                                    <!-- Course Groups in Columns -->
                          <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                             <!-- Academic Group - Column 1 -->
                             <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4 border border-amber-200 dark:border-amber-700">
                                 <h5 class="text-sm font-semibold text-amber-700 dark:text-amber-300 mb-3 flex items-center">
                                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                     </svg>
                                     📚 Academic
                                 </h5>
                                 <div class="space-y-3">
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="ssc_preparation" name="course_offers[]" value="ssc_preparation" 
                                                {{ in_array('ssc_preparation', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-amber-600 bg-gray-100 border-gray-300 rounded focus:ring-amber-500 dark:focus:ring-amber-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="ssc_preparation" class="text-sm font-medium text-gray-700 dark:text-gray-300">SSC Preparation</label>
                                     </div>
                                     
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="hsc_preparation" name="course_offers[]" value="hsc_preparation" 
                                                {{ in_array('hsc_preparation', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-amber-600 bg-gray-100 border-gray-300 rounded focus:ring-amber-500 dark:focus:ring-amber-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="hsc_preparation" class="text-sm font-medium text-gray-700 dark:text-gray-300">HSC Preparation</label>
                                     </div>
                                     
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="academic_preparation" name="course_offers[]" value="academic_preparation" 
                                                {{ in_array('academic_preparation', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-amber-600 bg-gray-100 border-gray-300 rounded focus:ring-amber-500 dark:focus:ring-amber-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="academic_preparation" class="text-sm font-medium text-gray-700 dark:text-gray-300">Academic Preparation</label>
                                     </div>
                                 </div>
                             </div>

                             <!-- Admission Group - Column 2 -->
                             <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-700">
                                 <h5 class="text-sm font-semibold text-blue-700 dark:text-blue-300 mb-3 flex items-center">
                                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                     </svg>
                                     🎓 Admission
                                 </h5>
                                 <div class="space-y-3">
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="university_admission" name="course_offers[]" value="university_admission" 
                                                {{ in_array('university_admission', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="university_admission" class="text-sm font-medium text-gray-700 dark:text-gray-300">University Admission</label>
                                     </div>
                                     
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="nursing_admission" name="course_offers[]" value="nursing_admission" 
                                                {{ in_array('nursing_admission', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="nursing_admission" class="text-sm font-medium text-gray-700 dark:text-gray-300">Nursing Admission</label>
                                     </div>
                                     
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="engineering_admission" name="course_offers[]" value="engineering_admission" 
                                                {{ in_array('engineering_admission', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="engineering_admission" class="text-sm font-medium text-gray-700 dark:text-gray-300">Engineering Admission</label>
                                     </div>
                                     
                                                                           <div class="flex items-center space-x-3">
                                          <input type="checkbox" id="gst_admission" name="course_offers[]" value="gst_admission" 
                                                 {{ in_array('gst_admission', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                 class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                          <label for="gst_admission" class="text-sm font-medium text-gray-700 dark:text-gray-300">GST Admission</label>
                                      </div>
                                      
                                      <div class="flex items-center space-x-3">
                                          <input type="checkbox" id="bteb_admission" name="course_offers[]" value="bteb_admission" 
                                                 {{ in_array('bteb_admission', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                 class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                          <label for="bteb_admission" class="text-sm font-medium text-gray-700 dark:text-gray-300">BTEB Admission</label>
                                      </div>
                                 </div>
                             </div>

                             <!-- Job Preparation Group - Column 3 -->
                             <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 border border-green-200 dark:border-green-700">
                                 <h5 class="text-sm font-semibold text-green-700 dark:text-green-300 mb-3 flex items-center">
                                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2z"></path>
                                     </svg>
                                     💼 Job Preparation
                                 </h5>
                                 <div class="space-y-3">
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="bcs_preparation" name="course_offers[]" value="bcs_preparation" 
                                                {{ in_array('bcs_preparation', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="bcs_preparation" class="text-sm font-medium text-gray-700 dark:text-gray-300">BCS Preparation</label>
                                     </div>
                                     
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="bank_job_preparation" name="course_offers[]" value="bank_job_preparation" 
                                                {{ in_array('bank_job_preparation', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="bank_job_preparation" class="text-sm font-medium text-gray-700 dark:text-gray-300">Bank Job Preparation</label>
                                     </div>
                                     
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="primary_teacher_recruitment" name="course_offers[]" value="primary_teacher_recruitment" 
                                                {{ in_array('primary_teacher_recruitment', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="primary_teacher_recruitment" class="text-sm font-medium text-gray-700 dark:text-gray-300">Primary Teacher Recruitment</label>
                                     </div>
                                     
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="ntrca" name="course_offers[]" value="ntrca" 
                                                {{ in_array('ntrca', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="ntrca" class="text-sm font-medium text-gray-700 dark:text-gray-300">NTRCA</label>
                                     </div>
                                 </div>
                             </div>

                             <!-- Skills & Training Group - Column 4 -->
                             <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-4 border border-purple-200 dark:border-purple-700">
                                 <h5 class="text-sm font-semibold text-purple-700 dark:text-purple-300 mb-3 flex items-center">
                                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                     </svg>
                                     🚀 Skills & Training
                                 </h5>
                                 <div class="space-y-3">
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="computer_training" name="course_offers[]" value="computer_training" 
                                                {{ in_array('computer_training', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="computer_training" class="text-sm font-medium text-gray-700 dark:text-gray-300">Computer Training</label>
                                     </div>
                                     
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="typing_speed_training" name="course_offers[]" value="typing_speed_training" 
                                                {{ in_array('typing_speed_training', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="typing_speed_training" class="text-sm font-medium text-gray-700 dark:text-gray-300">Typing Speed Training</label>
                                     </div>
                                     
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="ms_office" name="course_offers[]" value="ms_office" 
                                                {{ in_array('ms_office', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="ms_office" class="text-sm font-medium text-gray-700 dark:text-gray-300">MS Office</label>
                                     </div>
                                     
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="graphics_design" name="course_offers[]" value="graphics_design" 
                                                {{ in_array('graphics_design', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="graphics_design" class="text-sm font-medium text-gray-700 dark:text-gray-300">Graphics Design</label>
                                     </div>
                                     
                                     <div class="flex items-center space-x-3">
                                         <input type="checkbox" id="freelancing" name="course_offers[]" value="freelancing" 
                                                {{ in_array('freelancing', old('course_offers', $partner->course_offers ?? [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="freelancing" class="text-sm font-medium text-gray-700 dark:text-gray-300">Freelancing</label>
                                     </div>
                                 </div>
                             </div>
                         </div>
                        
                                                                                                   <!-- Custom Course Input and Selected Courses Display -->
                          <div class="mt-4 grid grid-cols-1 lg:grid-cols-2 gap-4">
                             <!-- Custom Course Input - Left Side -->
                             <div>
                                 <label for="custom_courses" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                     ➕ Add Custom Courses (comma separated)
                                 </label>
                                                                                                       <textarea id="custom_courses" name="custom_courses" rows="1" 
                                             placeholder="e.g., IELTS Preparation, TOEFL, GRE, GMAT, etc."
                                             class="block w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">{{ old('custom_courses', $partner->custom_courses) }}</textarea>
                                 @error('custom_courses')
                                     <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                                 @enderror
                             </div>
                             
                             <!-- Display Selected Courses - Right Side -->
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                     📋 Selected Courses
                                 </label>
                                 <div id="selected-courses-display" class="flex flex-wrap gap-2 p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl min-h-[60px]">
                                     @if($partner->course_offers)
                                         @foreach($partner->course_offers as $course)
                                             @php
                                                 // Determine colors based on course type
                                                 if (in_array($course, ['ssc_preparation', 'hsc_preparation', 'academic_preparation'])) {
                                                     $bgColor = 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200';
                                                     $hoverColor = 'text-amber-600 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-200';
                                                 } elseif (in_array($course, ['university_admission', 'nursing_admission', 'engineering_admission', 'gst_admission', 'bteb_admission'])) {
                                                     $bgColor = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                                                     $hoverColor = 'text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200';
                                                 } elseif (in_array($course, ['bcs_preparation', 'bank_job_preparation', 'primary_teacher_recruitment', 'ntrca'])) {
                                                     $bgColor = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                                     $hoverColor = 'text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200';
                                                 } elseif (in_array($course, ['computer_training', 'typing_speed_training', 'ms_office', 'graphics_design', 'freelancing'])) {
                                                     $bgColor = 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200';
                                                     $hoverColor = 'text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-200';
                                                 } else {
                                                     $bgColor = 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200';
                                                     $hoverColor = 'text-amber-600 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-200';
                                                 }
                                             @endphp
                                             <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $bgColor }}">
                                                 {{ ucwords(str_replace('_', ' ', $course)) }}
                                                 <button type="button" onclick="removeCourse('{{ $course }}')" class="ml-2 {{ $hoverColor }}">
                                                     ×
                                                 </button>
                                             </span>
                                         @endforeach
                                     @endif
                                     @if($partner->custom_courses)
                                         @foreach(explode(',', $partner->custom_courses) as $customCourse)
                                             @if(trim($customCourse))
                                                 <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                                     {{ trim($customCourse) }}
                                                     <button type="button" onclick="removeCustomCourse('{{ trim($customCourse) }}')" class="ml-2 text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-200">
                                                         ×
                                                     </button>
                                                 </span>
                                             @endif
                                         @endforeach
                                     @endif
                                 </div>
                             </div>
                         </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center pt-6">
                <button type="submit" id="submit-btn"
                        class="inline-flex justify-center items-center px-8 py-4 text-lg font-medium rounded-xl text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    🚀 Update Profile
                </button>
                
                <!-- Fallback submit button (hidden by default, shown if JavaScript fails) -->
                <button type="submit" id="fallback-submit" style="display: none;"
                        class="inline-flex justify-center items-center px-8 py-4 text-lg font-medium rounded-xl text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    🚀 Update Profile (Fallback)
                </button>
            </div>
         </form>
     </div>
</div>

<script>
// Bangladesh Administrative Data - Complete List
const bangladeshData = {
    "Dhaka": {
        "Dhaka": ["Dhamrai", "Dohar", "Keraniganj", "Nawabganj", "Savar"],
        "Gazipur": ["Gazipur Sadar", "Kaliakair", "Kaliganj", "Kapasia", "Sreepur"],
        "Narayanganj": ["Araihazar", "Bandar", "Narayanganj Sadar", "Rupganj", "Sonargaon"],
        "Tangail": ["Basail", "Bhuapur", "Delduar", "Dhanbari", "Ghatail", "Gopalpur", "Kalihati", "Madhupur", "Mirzapur", "Nagarpur", "Sakhipur", "Tangail Sadar"],
        "Narsingdi": ["Belabo", "Monohardi", "Narsingdi Sadar", "Palash", "Raipura", "Shibpur"],
        "Kishoreganj": ["Austagram", "Bajitpur", "Bhairab", "Hossainpur", "Itna", "Karimganj", "Katiadi", "Kishoreganj Sadar", "Kuliarchar", "Mithamain", "Nikli", "Pakundia", "Tarail"],
        "Manikganj": ["Daulatpur", "Ghior", "Harirampur", "Manikganj Sadar", "Saturia", "Shibalaya", "Singair"],
        "Munshiganj": ["Gazaria", "Lohajang", "Munshiganj Sadar", "Sirajdikhan", "Sreenagar", "Tongibari"],
        "Rajbari": ["Baliakandi", "Goalandaghat", "Pangsha", "Rajbari Sadar"],
        "Madaripur": ["Kalkini", "Madaripur Sadar", "Rajoir", "Shibchar"],
        "Gopalganj": ["Gopalganj Sadar", "Kashiani", "Kotalipara", "Muksudpur", "Tungipara"],
        "Faridpur": ["Alfadanga", "Bhanga", "Boalmari", "Charbhadrasan", "Faridpur Sadar", "Madhukhali", "Nagarkanda", "Sadarpur", "Saltha"]
    },
    "Chittagong": {
        "Chittagong": ["Anwara", "Banshkhali", "Boalkhali", "Chandanaish", "Fatikchhari", "Hathazari", "Lohagara", "Mirsharai", "Patiya", "Rangunia", "Raojan", "Sandwip", "Satkania", "Sitakunda"],
        "Cox's Bazar": ["Chakaria", "Cox's Bazar Sadar", "Kutubdia", "Maheshkhali", "Ramu", "Teknaf", "Ukhia"],
        "Comilla": ["Barura", "Brahmanpara", "Burichong", "Chandina", "Chauddagram", "Comilla Sadar", "Daudkandi", "Debidwar", "Homna", "Laksam", "Lalmai", "Monoharganj", "Meghna", "Muradnagar", "Nangalkot", "Titas"],
        "Feni": ["Chhagalnaiya", "Daganbhuiyan", "Feni Sadar", "Parshuram", "Sonagazi"],
        "Noakhali": ["Begumganj", "Chatkhil", "Companiganj", "Hatiya", "Kabirhat", "Noakhali Sadar", "Senbagh", "Subarnachar"],
        "Chandpur": ["Chandpur Sadar", "Faridganj", "Haimchar", "Hajiganj", "Kachua", "Matlab Dakshin", "Matlab Uttar", "Shahrasti"],
        "Lakshmipur": ["Lakshmipur Sadar", "Raipur", "Ramganj", "Ramgati", "Kamalnagar"],
        "Brahmanbaria": ["Akhaura", "Bancharampur", "Brahmanbaria Sadar", "Kasba", "Nabinagar", "Nasirnagar", "Sarail", "Ashuganj"]
    },
    "Rajshahi": {
        "Rajshahi": ["Bagha", "Bagmara", "Charghat", "Durgapur", "Godagari", "Mohanpur", "Paba", "Puthia", "Tanore"],
        "Natore": ["Bagatipara", "Baraigram", "Gurudaspur", "Lalpur", "Natore Sadar", "Singra"],
        "Naogaon": ["Atrai", "Badalgachi", "Dhamoirhat", "Manda", "Mohadevpur", "Naogaon Sadar", "Niamatpur", "Patnitala", "Porsha", "Raninagar", "Sapahar"],
        "Chapainawabganj": ["Bholahat", "Gomastapur", "Nachole", "Nawabganj Sadar", "Shibganj"],
        "Pabna": ["Atgharia", "Bera", "Bhangura", "Chatmohar", "Faridpur", "Ishwardi", "Pabna Sadar", "Santhia", "Sujanagar"],
        "Sirajganj": ["Belkuchi", "Chauhali", "Dhangora", "Kamarkhanda", "Kazipur", "Raiganj", "Shahjadpur", "Sirajganj Sadar", "Tarash", "Ullahpara"],
        "Bogura": ["Adamdighi", "Bogura Sadar", "Dhunat", "Gabtali", "Kahaloo", "Nandigram", "Sariakandi", "Shabganj", "Sherpur", "Shibganj", "Sonatola"]
    },
    "Khulna": {
        "Khulna": ["Batiaghata", "Dacope", "Dumuria", "Koyra", "Paikgachha", "Phultala", "Rupsa", "Terokhada"],
        "Bagerhat": ["Bagerhat Sadar", "Chitalmari", "Fakirhat", "Kachua", "Mollahat", "Mongla", "Morrelganj", "Rampal", "Sarankhola"],
        "Satkhira": ["Assasuni", "Debhata", "Kalaroa", "Kaliganj", "Satkhira Sadar", "Shyamnagar", "Tala"],
        "Jessore": ["Abhaynagar", "Bagherpara", "Chaugachha", "Jhikargachha", "Keshabpur", "Jessore Sadar", "Manirampur", "Sharsha"],
        "Magura": ["Magura Sadar", "Mohammadpur", "Shalikha", "Sreepur"],
        "Jhenaidah": ["Harinakunda", "Jhenaidah Sadar", "Kaliganj", "Kotchandpur", "Maheshpur", "Shailkupa"],
        "Narail": ["Kalia", "Lohagara", "Narail Sadar"],
        "Chuadanga": ["Alamdanga", "Chuadanga Sadar", "Damurhuda", "Jibannagar"]
    },
    "Barisal": {
        "Barisal": ["Agailjhara", "Babuganj", "Bakerganj", "Banaripara", "Barisal Sadar", "Gaurnadi", "Hizla", "Mehendiganj", "Muladi", "Wazirpur"],
        "Bhola": ["Bhola Sadar", "Burhanuddin", "Char Fasson", "Daulatkhan", "Lalmohan", "Manpura", "Tazumuddin"],
        "Pirojpur": ["Bhandaria", "Kawkhali", "Mathbaria", "Nazirpur", "Pirojpur Sadar", "Zianagar"],
        "Barguna": ["Amtali", "Bamna", "Barguna Sadar", "Betagi", "Patharghata", "Taltali"],
        "Patuakhali": ["Bauphal", "Dashmina", "Galachipa", "Kalapara", "Mirzaganj", "Patuakhali Sadar", "Rangabali", "Dumki"]
    },
    "Sylhet": {
        "Sylhet": ["Balaganj", "Beanibazar", "Bishwanath", "Companiganj", "Dakshin Surma", "Fenchuganj", "Golapganj", "Gowainghat", "Jaintiapur", "Kanaighat", "Osmani Nagar", "Sylhet Sadar", "Zakiganj"],
        "Moulvibazar": ["Barlekha", "Juri", "Kamalganj", "Kulaura", "Moulvibazar Sadar", "Rajnagar", "Sreemangal"],
        "Habiganj": ["Ajmiriganj", "Bahubal", "Baniyachong", "Chunarughat", "Habiganj Sadar", "Lakhai", "Madhabpur", "Nabiganj"],
        "Sunamganj": ["Bishwamvarpur", "Chhatak", "Derai", "Dharampasha", "Dowarabazar", "Jagannathpur", "Jamalganj", "Sulla", "Sunamganj Sadar", "Tahirpur"]
    },
    "Rangpur": {
        "Rangpur": ["Badarganj", "Gangachara", "Kaunia", "Mithapukur", "Pirgachha", "Pirganj", "Rangpur Sadar", "Taraganj"],
        "Dinajpur": ["Birampur", "Birganj", "Biral", "Bochaganj", "Chirirbandar", "Dinajpur Sadar", "Fulbari", "Ghoraghat", "Hakimpur", "Kaharole", "Khansama", "Nawabganj", "Parbatipur"],
        "Kurigram": ["Bhurungamari", "Chilmari", "Kurigram Sadar", "Nageswari", "Phulbari", "Rajarhat", "Raumari", "Ulipur"],
        "Lalmonirhat": ["Aditmari", "Hatibandha", "Kaliganj", "Lalmonirhat Sadar", "Patgram"],
        "Nilphamari": ["Dimla", "Domar", "Jaldhaka", "Kishoreganj", "Nilphamari Sadar", "Saidpur"],
        "Panchagarh": ["Atwari", "Boda", "Debiganj", "Panchagarh Sadar", "Tetulia"],
        "Thakurgaon": ["Baliadangi", "Haripur", "Pirganj", "Ranisankail", "Thakurgaon Sadar"]
    },
    "Mymensingh": {
        "Mymensingh": ["Bhaluka", "Dhobaura", "Fulbaria", "Gaffargaon", "Gauripur", "Haluaghat", "Ishwarganj", "Muktagachha", "Mymensingh Sadar", "Nandail", "Phulpur", "Trishal"],
        "Jamalpur": ["Bakshiganj", "Dewanganj", "Islampur", "Jamalpur Sadar", "Madarganj", "Melandaha", "Sarishabari"],
        "Netrokona": ["Atpara", "Barhatta", "Dharmapasha", "Dhobaura", "Khaliajuri", "Kalmakanda", "Kendua", "Madan", "Mohanganj", "Netrokona Sadar", "Purbadhala"],
        "Sherpur": ["Jhenaigati", "Nakla", "Nalitabari", "Sherpur Sadar", "Sreefardi"]
    }
};

// Cascading Dropdown Functionality
document.addEventListener('DOMContentLoaded', function() {
    const divisionSelect = document.getElementById('division');
    const districtSelect = document.getElementById('district');
    const upazilaSelect = document.getElementById('upazila');
    
    // Populate divisions
    function populateDivisions() {
        divisionSelect.innerHTML = '<option value="">Select Division</option>';
        Object.keys(bangladeshData).forEach(division => {
            const option = document.createElement('option');
            option.value = division;
            option.textContent = division;
            divisionSelect.appendChild(option);
        });
    }
    
    // Populate districts based on selected division
    function populateDistricts(division) {
        districtSelect.innerHTML = '<option value="">Select District</option>';
        upazilaSelect.innerHTML = '<option value="">Select Upazila</option>';
        
        if (division && bangladeshData[division]) {
            Object.keys(bangladeshData[division]).forEach(district => {
                const option = document.createElement('option');
                option.value = district;
                option.textContent = district;
                districtSelect.appendChild(option);
            });
        }
    }
    
    // Populate upazilas based on selected district
    function populateUpazilas(division, district) {
        upazilaSelect.innerHTML = '<option value="">Select Upazila</option>';
        
        if (division && district && bangladeshData[division] && bangladeshData[division][district]) {
            bangladeshData[division][district].forEach(upazila => {
                const option = document.createElement('option');
                option.value = upazila;
                option.textContent = upazila;
                upazilaSelect.appendChild(option);
            });
        }
    }
    
    // Event listeners
    divisionSelect.addEventListener('change', function() {
        const selectedDivision = this.value;
        populateDistricts(selectedDivision);
        
        // Set old values if they exist
        if (selectedDivision && '{{ old("division", $partner->division) }}' === selectedDivision) {
            districtSelect.value = '{{ old("district", $partner->district) }}';
            if (districtSelect.value) {
                populateUpazilas(selectedDivision, districtSelect.value);
                upazilaSelect.value = '{{ old("upazila", $partner->upazila) }}';
            }
        }
    });
    
    districtSelect.addEventListener('change', function() {
        const selectedDivision = divisionSelect.value;
        const selectedDistrict = this.value;
        populateUpazilas(selectedDivision, selectedDistrict);
        
        // Set old value if it exists
        if (selectedDivision && selectedDistrict && '{{ old("district", $partner->district) }}' === selectedDistrict) {
            upazilaSelect.value = '{{ old("upazila", $partner->upazila) }}';
        }
    });
    
    // Initialize dropdowns
    populateDivisions();
    
    // Set old values if they exist
    const oldDivision = '{{ old("division", $partner->division) }}';
    const oldDistrict = '{{ old("district", $partner->district) }}';
    const oldUpazila = '{{ old("upazila", $partner->upazila) }}';
    
    if (oldDivision) {
        divisionSelect.value = oldDivision;
        populateDistricts(oldDivision);
        
        if (oldDistrict) {
            districtSelect.value = oldDistrict;
            populateUpazilas(oldDivision, oldDistrict);
            
            if (oldUpazila) {
                upazilaSelect.value = oldUpazila;
            }
        }
    }
});

// Form submission function
function submitForm() {
    const form = document.getElementById('profile-form');
    const submitBtn = document.getElementById('submit-btn');
    
    if (form && submitBtn) {
        // Show loading state
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Updating...
        `;
        submitBtn.disabled = true;
        
        // Submit the form
        form.submit();
    }
}

// Course Management Functions
function removeCourse(courseValue) {
    const checkbox = document.getElementById(courseValue.replace(/_/g, '_'));
    if (checkbox) {
        checkbox.checked = false;
    }
    updateSelectedCoursesDisplay();
}

function removeCustomCourse(courseName) {
    const textarea = document.getElementById('custom_courses');
    let courses = textarea.value.split(',').map(c => c.trim()).filter(c => c !== courseName);
    textarea.value = courses.join(', ');
    updateSelectedCoursesDisplay();
}

function updateSelectedCoursesDisplay() {
    const display = document.getElementById('selected-courses-display');
    if (!display) return;
    
    let html = '';
    
    // Add predefined courses with different colors based on groups
    const checkboxes = document.querySelectorAll('input[name="course_offers[]"]:checked');
    checkboxes.forEach(checkbox => {
        let bgColor, textColor, hoverColor;
        
                 // Determine colors based on course type
         if (['ssc_preparation', 'hsc_preparation', 'academic_preparation'].includes(checkbox.value)) {
             // Academic group - amber colors
             bgColor = 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200';
             hoverColor = 'text-amber-600 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-200';
         } else if (['university_admission', 'nursing_admission', 'engineering_admission', 'gst_admission', 'bteb_admission'].includes(checkbox.value)) {
             // Admission group - blue colors
             bgColor = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
             hoverColor = 'text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200';
         } else if (['bcs_preparation', 'bank_job_preparation', 'primary_teacher_recruitment', 'ntrca'].includes(checkbox.value)) {
             // Job Preparation group - green colors
             bgColor = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
             hoverColor = 'text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200';
         } else if (['computer_training', 'typing_speed_training', 'ms_office', 'graphics_design', 'freelancing'].includes(checkbox.value)) {
             // Skills & Training group - purple colors
             bgColor = 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200';
             hoverColor = 'text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-200';
         } else {
             // Default - amber colors
             bgColor = 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200';
             hoverColor = 'text-amber-600 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-200';
         }
        
        html += `<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${bgColor}">
            ${checkbox.value.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}
            <button type="button" onclick="removeCourse('${checkbox.value}')" class="ml-2 ${hoverColor}">×</button>
        </span>`;
    });
    
    // Add custom courses
    const customCourses = document.getElementById('custom_courses').value;
    if (customCourses) {
        customCourses.split(',').forEach(course => {
            const trimmedCourse = course.trim();
            if (trimmedCourse) {
                html += `<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                    ${trimmedCourse}
                    <button type="button" onclick="removeCustomCourse('${trimmedCourse}')" class="ml-2 text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-200">×</button>
                </span>`;
            }
        });
    }
    
    display.innerHTML = html;
}

// Add event listeners for course management
document.addEventListener('DOMContentLoaded', function() {
    // Add change event listeners to checkboxes
    const courseCheckboxes = document.querySelectorAll('input[name="course_offers[]"]');
    courseCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCoursesDisplay);
    });
    
    // Add input event listener to custom courses textarea
    const customCoursesTextarea = document.getElementById('custom_courses');
    if (customCoursesTextarea) {
        customCoursesTextarea.addEventListener('input', updateSelectedCoursesDisplay);
    }
});

// Add loading state to submit button
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profile-form');
    const submitBtn = document.getElementById('submit-btn');
    const fallbackSubmit = document.getElementById('fallback-submit');
    
    console.log('Form element:', form);
    console.log('Submit button element:', submitBtn);
    console.log('Fallback submit element:', fallbackSubmit);
    
    if (submitBtn && form) {
        // Hide fallback button since main button is working
        if (fallbackSubmit) {
            fallbackSubmit.style.display = 'none';
        }
        
        submitBtn.addEventListener('click', function(e) {
            console.log('Submit button clicked!');
            
            // Prevent default to handle manually
            e.preventDefault();
            
            // Add loading state
            this.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Updating...
            `;
            this.disabled = true;
            
            // Submit the form
            console.log('Submitting form...');
            form.submit();
        });
        
        // Also add form submit event listener
        form.addEventListener('submit', function(e) {
            console.log('Form is being submitted!');
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);
            
            // Log form data
            const formData = new FormData(this);
            console.log('Form data entries:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }
        });
    } else {
        console.error('Form or submit button not found!');
        if (!form) console.error('Form with ID "profile-form" not found');
        if (!submitBtn) console.error('Submit button with ID "submit-btn" not found');
        
        // Show fallback button if main button fails
        if (fallbackSubmit) {
            fallbackSubmit.style.display = 'inline-flex';
            console.log('Showing fallback submit button');
        }
    }
});

// Fallback: If JavaScript fails completely, show fallback button after a delay
setTimeout(function() {
    const submitBtn = document.getElementById('submit-btn');
    const fallbackSubmit = document.getElementById('fallback-submit');
    
    if (submitBtn && submitBtn.disabled === false && fallbackSubmit) {
        // If main button is not disabled (meaning JavaScript didn't run), show fallback
        fallbackSubmit.style.display = 'inline-flex';
        console.log('JavaScript may have failed, showing fallback button');
    }
}, 2000);
</script>
@endsection


