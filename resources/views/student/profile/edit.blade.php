@extends('layouts.student-layout')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Profile</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Update your personal information</p>
            </div>
            <a href="{{ route('student.profile.show') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Profile
            </a>
        </div>

        <!-- Edit Profile Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 sm:p-8">
                <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="flex flex-col md:flex-row items-center gap-6 mb-8">
                        <div class="relative">
                            <div class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-gradient-to-br from-primaryGreen to-emerald-600 flex items-center justify-center overflow-hidden shadow-lg ring-4 ring-white dark:ring-gray-700">
                                @if($student->photo)
                                    <img id="preview-image" src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->full_name }}" class="w-full h-full object-cover">
                                @else
                                    <span id="preview-initials" class="text-2xl md:text-3xl font-bold text-white">
                                        {{ strtoupper(substr($student->full_name, 0, 1)) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profile Photo</label>
                            <div class="flex items-center gap-3">
                                <input type="file" name="photo" id="photo" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-primaryGreen/10 file:text-primaryGreen
                                    hover:file:bg-primaryGreen/20
                                    dark:file:bg-primaryGreen/20 dark:file:text-white
                                    dark:hover:file:bg-primaryGreen/30
                                    cursor-pointer" accept="image/*">
                                <button type="button" id="remove-photo" class="px-3 py-2 text-sm bg-red-100 text-red-700 rounded-lg hover:bg-red-200 dark:bg-red-900/30 dark:text-red-300 dark:hover:bg-red-900/50">
                                    Remove
                                </button>
                            </div>
                            @error('photo')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Basic Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                                <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $student->full_name) }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">
                                @error('full_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Student ID</label>
                                <input type="text" name="student_id" id="student_id" value="{{ old('student_id', $student->student_id) }}" readonly
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white cursor-not-allowed">
                            </div>
                            
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '') }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">
                                @error('date_of_birth')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gender</label>
                                <select name="gender" id="gender" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="blood_group" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Blood Group</label>
                                <select name="blood_group" id="blood_group" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">
                                    <option value="">Select Blood Group</option>
                                    <option value="A+" {{ old('blood_group', $student->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_group', $student->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_group', $student->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_group', $student->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ old('blood_group', $student->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_group', $student->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ old('blood_group', $student->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_group', $student->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                                @error('blood_group')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="religion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Religion</label>
                                <select name="religion" id="religion" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">
                                    <option value="">Select Religion</option>
                                    <option value="Islam" {{ old('religion', $student->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Hinduism" {{ old('religion', $student->religion) == 'Hinduism' ? 'selected' : '' }}>Hinduism</option>
                                    <option value="Christianity" {{ old('religion', $student->religion) == 'Christianity' ? 'selected' : '' }}>Christianity</option>
                                    <option value="Buddhism" {{ old('religion', $student->religion) == 'Buddhism' ? 'selected' : '' }}>Buddhism</option>
                                </select>
                                @error('religion')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $student->phone) }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address</label>
                                <textarea name="address" id="address" rows="3" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">{{ old('address', $student->address) }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">City</label>
                                <input type="text" name="city" id="city" value="{{ old('city', $student->city) }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="school_college" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">School/College</label>
                                <input type="text" name="school_college" id="school_college" value="{{ old('school_college', $student->school_college) }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">
                                @error('school_college')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="class_grade" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Class/Grade</label>
                                <input type="text" name="class_grade" id="class_grade" value="{{ old('class_grade', $student->class_grade) }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">
                                @error('class_grade')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Guardian Information -->
                    <div class="pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Guardian Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="father_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Father's Name</label>
                                <input type="text" name="father_name" id="father_name" value="{{ old('father_name', $student->father_name) }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">
                                @error('father_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="father_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Father's Phone</label>
                                <input type="tel" name="father_phone" id="father_phone" value="{{ old('father_phone', $student->father_phone) }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">
                                @error('father_phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="mother_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mother's Name</label>
                                <input type="text" name="mother_name" id="mother_name" value="{{ old('mother_name', $student->mother_name) }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">
                                @error('mother_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="mother_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mother's Phone</label>
                                <input type="tel" name="mother_phone" id="mother_phone" value="{{ old('mother_phone', $student->mother_phone) }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-colors">
                                @error('mother_phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" 
                            class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-primaryGreen to-emerald-600 hover:from-primaryGreen/90 hover:to-emerald-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Profile
                        </button>
                        
                        <a href="{{ route('student.profile.show') }}" 
                            class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition-all duration-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photo');
    const previewImage = document.getElementById('preview-image');
    const previewInitials = document.getElementById('preview-initials');
    const removePhotoBtn = document.getElementById('remove-photo');
    
    // Handle photo preview
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (previewImage) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                }
                if (previewInitials) {
                    previewInitials.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Handle photo removal
    removePhotoBtn.addEventListener('click', function() {
        photoInput.value = '';
        if (previewImage) {
            previewImage.classList.add('hidden');
        }
        if (previewInitials) {
            previewInitials.classList.remove('hidden');
        }
    });
});
</script>
@endsection