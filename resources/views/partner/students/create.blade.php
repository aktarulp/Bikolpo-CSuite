@extends('layouts.partner-layout')

@section('title', 'Add Student')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 py-6">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-6">
                <div class="mb-4 lg:mb-0">
                    <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-400">
                        Add New Student
                    </h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-2">
                        Complete the form below to register a new student
                    </p>
        </div>
                <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('partner.students.index') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
            Back to Students
        </a>
                    <button type="submit" form="student-form" 
                            class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm hover:shadow-md transition-all duration-200 text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Student
                    </button>
                </div>
            </div>
    </div>

        <!-- Main Form Container -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <form id="student-form" action="{{ route('partner.students.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Basic Information -->
            <div class="px-6 py-8 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Basic Information</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Essential student details and enrollment information</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                    <div class="sm:col-span-2 lg:col-span-1">
                        <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Full Name *</label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" required
                               class="w-full rounded-lg border border-gray-300 dark:border-gray-600 px-4 py-3 text-sm transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 hover:border-gray-400 dark:hover:border-gray-500 bg-white dark:bg-gray-700">
                        @error('full_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Student ID *</label>
                        <input type="text" name="student_id" value="{{ old('student_id') }}" required
                               class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('student_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Date of Birth *</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required
                               class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('date_of_birth')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Gender *</label>
                        <select name="gender" required class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Blood Group *</label>
                        <select name="blood_group" required class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
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
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Religion *</label>
                        <select name="religion" required class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                            <option value="">Select Religion</option>
                            <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Hinduism" {{ old('religion') == 'Hinduism' ? 'selected' : '' }}>Hinduism</option>
                            <option value="Christianity" {{ old('religion') == 'Christianity' ? 'selected' : '' }}>Christianity</option>
                            <option value="Buddhism" {{ old('religion') == 'Buddhism' ? 'selected' : '' }}>Buddhism</option>
                        </select>
                        @error('religion')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Enroll Date *</label>
                        <input type="date" name="enroll_date" value="{{ old('enroll_date', date('Y-m-d')) }}" required
                               class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('enroll_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Course *</label>
                        <select name="course_id" required class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Batch *</label>
                        <select name="batch_id" required class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                            <option value="">Select Batch</option>
                            @foreach($batches as $batch)
                                <option value="{{ $batch->id }}" {{ old('batch_id') == $batch->id ? 'selected' : '' }}>
                                    {{ $batch->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('batch_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="px-6 py-8 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Contact Information</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Communication details and address information</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                               title="Please enter a valid email address"
                               class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Phone Number *</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                               placeholder="01XXXXXXXXX"
                               pattern="01[3-9][0-9]{8}"
                               title="Please enter a valid Bangladeshi phone number (01XXXXXXXXX)"
                               maxlength="11"
                               class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Home Dirstict</label>
                        <input type="text" name="city" value="{{ old('city') }}"
                               class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('city')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                
                <!-- Full Width Address Field -->
                <div class="mt-4">
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Detailed Address</label>
                    <input type="text" name="address" value="{{ old('address') }}"
                           placeholder="Enter full address details..."
                           class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Academic Information -->
            <div class="px-6 py-8 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Academic Information</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Previous education and academic background</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Last Institute</label>
                        <input type="text" name="school_college" value="{{ old('school_college') }}"
                               class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('school_college')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Last Degree/Class</label>
                        <input type="text" name="class_grade" value="{{ old('class_grade') }}"
                               class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('class_grade')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Parent & Guardian Information -->
            <div class="px-6 py-8 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Parent & Guardian Information</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Family details and guardian contact information</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Father's Name</label>
                        <input type="text" name="father_name" value="{{ old('father_name') }}"
                               class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('father_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Father's Phone (Optional)</label>
                        <input type="tel" name="father_phone" value="{{ old('father_phone') }}"
                               placeholder="01XXXXXXXXX"
                               pattern="01[3-9][0-9]{8}"
                               title="Please enter a valid Bangladeshi phone number (01XXXXXXXXX)"
                               maxlength="11"
                               class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('father_phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Mother's Name</label>
                        <input type="text" name="mother_name" value="{{ old('mother_name') }}"
                               class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('mother_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Mother's Phone</label>
                        <input type="tel" name="mother_phone" value="{{ old('mother_phone') }}"
                               placeholder="01XXXXXXXXX"
                               pattern="01[3-9][0-9]{8}"
                               title="Please enter a valid Bangladeshi phone number (01XXXXXXXXX)"
                               maxlength="11"
                               class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('mother_phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
            </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Guardian (Optional)</label>
                        <select name="guardian" class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                            <option value="">Select Guardian</option>
                            <option value="Father" {{ old('guardian') == 'Father' ? 'selected' : '' }}>Father</option>
                            <option value="Mother" {{ old('guardian') == 'Mother' ? 'selected' : '' }}>Mother</option>
                            <option value="Other" {{ old('guardian') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('guardian')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Guardian Name (Optional)</label>
                        <input type="text" name="guardian_name" value="{{ old('guardian_name') }}"
                               class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('guardian_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Guardian Phone (Optional)</label>
                        <input type="tel" name="guardian_phone" value="{{ old('guardian_phone') }}"
                               placeholder="01XXXXXXXXX"
                               pattern="01[3-9][0-9]{8}"
                               title="Please enter a valid Bangladeshi phone number (01XXXXXXXXX)"
                               maxlength="11"
                               class="w-full rounded-md border border-gray-300 dark:border-gray-600 p-2 text-sm focus:ring-2 focus:ring-primaryGreen focus:border-transparent">
                        @error('guardian_phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Student Photo</label>
                        <input type="file" name="photo" accept="image/*" 
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primaryGreen file:text-white hover:file:bg-green-600">
                        @error('photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>


        </form>
    </div>
</div>
@endsection 

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const guardianSelect = document.querySelector('select[name="guardian"]');
    const guardianNameInput = document.querySelector('input[name="guardian_name"]');
    const guardianPhoneInput = document.querySelector('input[name="guardian_phone"]');
    const fatherNameInput = document.querySelector('input[name="father_name"]');
    const fatherPhoneInput = document.querySelector('input[name="father_phone"]');
    const motherNameInput = document.querySelector('input[name="mother_name"]');
    const motherPhoneInput = document.querySelector('input[name="mother_phone"]');

    // Store original values to restore if "Other" is selected
    let originalGuardianName = '';
    let originalGuardianPhone = '';

    guardianSelect.addEventListener('change', function() {
        const selectedGuardian = this.value;
        
        // Store current values before auto-populating (only if not already auto-populated)
        if (selectedGuardian === 'Father' || selectedGuardian === 'Mother') {
            if (!originalGuardianName && !originalGuardianPhone) {
                originalGuardianName = guardianNameInput.value;
                originalGuardianPhone = guardianPhoneInput.value;
            }
        }

        if (selectedGuardian === 'Father') {
            // Auto-populate with father's information
            guardianNameInput.value = fatherNameInput.value;
            guardianPhoneInput.value = fatherPhoneInput.value;
            
            // Add visual indication that fields are auto-populated
            guardianNameInput.style.backgroundColor = '#f0f9ff';
            guardianPhoneInput.style.backgroundColor = '#f0f9ff';
            guardianNameInput.title = 'Auto-populated from Father\'s information';
            guardianPhoneInput.title = 'Auto-populated from Father\'s information';
            
        } else if (selectedGuardian === 'Mother') {
            // Auto-populate with mother's information
            guardianNameInput.value = motherNameInput.value;
            guardianPhoneInput.value = motherPhoneInput.value;
            
            // Add visual indication that fields are auto-populated
            guardianNameInput.style.backgroundColor = '#f0f9ff';
            guardianPhoneInput.style.backgroundColor = '#f0f9ff';
            guardianNameInput.title = 'Auto-populated from Mother\'s information';
            guardianPhoneInput.title = 'Auto-populated from Mother\'s information';
            
        } else {
            // For "Other" or empty selection, restore original values and reset styling
            guardianNameInput.value = originalGuardianName;
            guardianPhoneInput.value = originalGuardianPhone;
            guardianNameInput.style.backgroundColor = '';
            guardianPhoneInput.style.backgroundColor = '';
            guardianNameInput.title = '';
            guardianPhoneInput.title = '';
        }
    });

    // Update guardian fields if father/mother information changes while they are selected as guardian
    function updateGuardianFields() {
        const selectedGuardian = guardianSelect.value;
        
        if (selectedGuardian === 'Father') {
            guardianNameInput.value = fatherNameInput.value;
            guardianPhoneInput.value = fatherPhoneInput.value;
        } else if (selectedGuardian === 'Mother') {
            guardianNameInput.value = motherNameInput.value;
            guardianPhoneInput.value = motherPhoneInput.value;
        }
    }

    // Listen for changes in father/mother fields
    fatherNameInput.addEventListener('input', updateGuardianFields);
    fatherPhoneInput.addEventListener('input', updateGuardianFields);
    motherNameInput.addEventListener('input', updateGuardianFields);
    motherPhoneInput.addEventListener('input', updateGuardianFields);

    // Trigger change event on page load if guardian is already selected
    if (guardianSelect.value) {
        guardianSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush 
