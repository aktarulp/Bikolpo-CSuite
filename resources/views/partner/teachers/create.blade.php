@extends('layouts.partner-layout')

@section('title', 'Add New Teacher')

@section('content')
<div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 min-h-screen p-3 sm:p-4 lg:p-6">
    <div class="max-w-5xl mx-auto">

        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('partner.teachers.index') }}" 
                       class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 rounded-xl shadow-lg hover:shadow-xl flex items-center justify-center transition-all duration-200 group transform hover:scale-105">
                        <i class="fas fa-arrow-left text-white group-hover:text-white transition-colors"></i>
                    </a>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-user-plus text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Add New Teacher</h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Create a comprehensive teacher profile</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Progress Steps -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center text-blue-600 dark:text-blue-400">
                        <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-semibold mr-2">1</div>
                        <span class="font-medium">Teacher Information</span>
                    </div>
                    <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700 mx-4"></div>
                    <div class="flex items-center text-gray-400">
                        <div class="w-6 h-6 bg-gray-200 dark:bg-gray-700 text-gray-500 rounded-full flex items-center justify-center text-xs font-semibold mr-2">2</div>
                        <span>Review & Save</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('partner.teachers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Personal Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user text-blue-600 dark:text-blue-400 text-sm"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Personal Information</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Basic personal details</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name (English) -->
                    <div>
                        <label for="full_name_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Full Name (English) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="full_name_en" id="full_name_en" required value="{{ old('full_name_en') }}"
                               class="block w-full px-3 py-2.5 border @error('full_name_en') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500 @enderror rounded-lg dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter teacher's full name in English">
                        @error('full_name_en')
                            <div class="mt-1 flex items-center text-sm text-red-600">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Full Name (Bengali) -->
                    <div>
                        <label for="full_name_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name (Bengali)</label>
                        <input type="text" name="full_name_bn" id="full_name_bn" value="{{ old('full_name_bn') }}"
                               class="block w-full px-3 py-2.5 border @error('full_name_bn') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500 @enderror rounded-lg dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter teacher's full name in Bengali">
                        @error('full_name_bn')
                            <div class="mt-1 flex items-center text-sm text-red-600">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Father's Name -->
                    <div>
                        <label for="father_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Father's Name</label>
                        <input type="text" name="father_name" id="father_name" value="{{ old('father_name') }}"
                               class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('father_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mother's Name -->
                    <div>
                        <label for="mother_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mother's Name</label>
                        <input type="text" name="mother_name" id="mother_name" value="{{ old('mother_name') }}"
                               class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('mother_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Gender <span class="text-red-500">*</span>
                        </label>
                        <select name="gender" id="gender" required 
                                class="block w-full px-3 py-2.5 border @error('gender') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500 @enderror rounded-lg dark:bg-gray-700 dark:text-white transition-colors duration-200">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="mt-1 flex items-center text-sm text-red-600">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="dob" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date of Birth</label>
                        <input type="date" name="dob" id="dob" value="{{ old('dob') }}"
                               class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('dob')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Blood Group -->
                    <div>
                        <label for="blood_group" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Blood Group</label>
                        <select name="blood_group" id="blood_group" class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Select Blood Group</option>
                            <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                        @error('blood_group')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Photo -->
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Photo</label>
                        <input type="file" name="photo" id="photo" accept="image/*"
                               class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <p class="mt-1 text-xs text-gray-500">Max size: 2MB. Formats: JPG, PNG</p>
                        @error('photo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-phone text-green-600 dark:text-green-400 text-sm"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Contact Information</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Phone, email and address details</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mobile -->
                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Mobile Number <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="mobile" id="mobile" required value="{{ old('mobile') }}"
                               class="block w-full px-3 py-2.5 border @error('mobile') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500 @enderror rounded-lg dark:bg-gray-700 dark:text-white transition-colors duration-200"
                               placeholder="Enter mobile number (e.g., 01712345678)">
                        @error('mobile')
                            <div class="mt-1 flex items-center text-sm text-red-600">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Alternative Mobile -->
                    <div>
                        <label for="alt_mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alternative Mobile</label>
                        <input type="text" name="alt_mobile" id="alt_mobile" value="{{ old('alt_mobile') }}"
                               class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('alt_mobile')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Emergency Contact Name -->
                    <div>
                        <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Emergency Contact Name</label>
                        <input type="text" name="emergency_contact_name" id="emergency_contact_name" value="{{ old('emergency_contact_name') }}"
                               class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('emergency_contact_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Emergency Contact Number -->
                    <div>
                        <label for="emergency_contact_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Emergency Contact Number</label>
                        <input type="text" name="emergency_contact_number" id="emergency_contact_number" value="{{ old('emergency_contact_number') }}"
                               class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('emergency_contact_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Addresses -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Present Address -->
                    <div>
                        <label for="present_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Present Address</label>
                        <textarea name="present_address" id="present_address" rows="3"
                                  class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">{{ old('present_address') }}</textarea>
                        @error('present_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Permanent Address -->
                    <div>
                        <label for="permanent_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Permanent Address</label>
                        <textarea name="permanent_address" id="permanent_address" rows="3"
                                  class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">{{ old('permanent_address') }}</textarea>
                        @error('permanent_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-50 to-violet-50 dark:from-purple-900/20 dark:to-violet-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-briefcase text-purple-600 dark:text-purple-400 text-sm"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Professional Information</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Job role and work experience</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Designation -->
                    <div>
                        <label for="designation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Designation</label>
                        <input type="text" name="designation" id="designation" value="{{ old('designation') }}"
                               class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('designation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                        <input type="text" name="department" id="department" value="{{ old('department') }}"
                               class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('department')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject Specialization -->
                    <div>
                        <label for="subject_specialization" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subject Specialization</label>
                        <input type="text" name="subject_specialization" id="subject_specialization" value="{{ old('subject_specialization') }}"
                               class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('subject_specialization')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Joining Date -->
                    <div>
                        <label for="joining_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Joining Date</label>
                        <input type="date" name="joining_date" id="joining_date" value="{{ old('joining_date') }}"
                               class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('joining_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Experience Years -->
                    <div>
                        <label for="experience_years" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Experience (Years)</label>
                        <input type="number" name="experience_years" id="experience_years" min="0" value="{{ old('experience_years', 0) }}"
                               class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('experience_years')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required 
                                class="block w-full px-3 py-2.5 border @error('status') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500 @enderror rounded-lg dark:bg-gray-700 dark:text-white transition-colors duration-200">
                            <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="On Leave" {{ old('status') == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                        </select>
                        @error('status')
                            <div class="mt-1 flex items-center text-sm text-red-600">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Education & Salary -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Education -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">Education</h2>
                    
                    <div class="space-y-4">
                        <!-- Highest Degree -->
                        <div>
                            <label for="highest_degree" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Highest Degree</label>
                            <input type="text" name="highest_degree" id="highest_degree" value="{{ old('highest_degree') }}"
                                   class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('highest_degree')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Institution Name -->
                        <div>
                            <label for="institution_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Institution Name</label>
                            <input type="text" name="institution_name" id="institution_name" value="{{ old('institution_name') }}"
                                   class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('institution_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Salary Information -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">Salary Information</h2>
                    
                    <div class="space-y-4">
                        <!-- Salary Type -->
                        <div>
                            <label for="salary_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Salary Type</label>
                            <select name="salary_type" id="salary_type" class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Type</option>
                                <option value="Monthly" {{ old('salary_type') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="Per Class" {{ old('salary_type') == 'Per Class' ? 'selected' : '' }}>Per Class</option>
                                <option value="Per Student" {{ old('salary_type') == 'Per Student' ? 'selected' : '' }}>Per Student</option>
                            </select>
                            @error('salary_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Salary Amount -->
                        <div>
                            <label for="salary_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Salary Amount</label>
                            <input type="number" name="salary_amount" id="salary_amount" step="0.01" min="0" value="{{ old('salary_amount') }}"
                                   class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('salary_amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Method</option>
                                <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Bank" {{ old('payment_method') == 'Bank' ? 'selected' : '' }}>Bank</option>
                                <option value="Mobile Banking" {{ old('payment_method') == 'Mobile Banking' ? 'selected' : '' }}>Mobile Banking</option>
                            </select>
                            @error('payment_method')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Account Details -->
                        <div>
                            <label for="account_details" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Account Details</label>
                            <input type="text" name="account_details" id="account_details" value="{{ old('account_details') }}"
                                   class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('account_details')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">Additional Notes</h2>
                
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                    <textarea name="notes" id="notes" rows="4"
                              class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                              placeholder="Any additional information about the teacher...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                    <div class="text-sm text-gray-600 dark:text-gray-400 order-2 sm:order-1">
                        <i class="fas fa-info-circle mr-1"></i>
                        All required fields (*) must be filled
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto order-1 sm:order-2">
                        <a href="{{ route('partner.teachers.index') }}" 
                           class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-all duration-200 text-center border border-gray-300 dark:border-gray-600">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-user-plus mr-2"></i>
                            Create Teacher
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
