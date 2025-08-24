@extends('layouts.app')

@section('title', 'Edit Student Profile')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Profile</h1>
            <p class="text-gray-600 dark:text-gray-400">Update your profile information</p>
        </div>
        <a href="{{ route('student.profile.show') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            View Profile
        </a>
    </div>

    <!-- Edit Profile Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Personal Information</h3>
        </div>
        
        <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Profile Photo -->
            <div class="flex justify-center">
                <div class="relative">
                    @if($student->photo)
                        <img src="{{ Storage::url($student->photo) }}" 
                             alt="Current Profile Photo" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 dark:border-gray-700 mb-4">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mb-4">
                            <i class="fas fa-user text-4xl text-gray-400 dark:text-gray-500"></i>
                        </div>
                    @endif
                    
                    <div class="text-center">
                        <label for="photo" class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                            <i class="fas fa-camera mr-2"></i>
                            Change Photo
                        </label>
                        <input type="file" id="photo" name="photo" class="hidden" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="full_name" 
                        name="full_name" 
                        value="{{ old('full_name', $student->full_name) }}" 
                        required
                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    @error('full_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Date of Birth <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="date_of_birth" 
                        name="date_of_birth" 
                        value="{{ old('date_of_birth', $student->date_of_birth->format('Y-m-d')) }}" 
                        required
                        max="{{ date('Y-m-d', strtotime('-1 day')) }}"
                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    @error('date_of_birth')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Gender <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="gender" 
                        name="gender" 
                        required
                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">Select gender</option>
                        <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Address
                    </label>
                    <textarea 
                        id="address" 
                        name="address" 
                        rows="3"
                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter your address"
                    >{{ old('address', $student->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        City
                    </label>
                    <input 
                        type="text" 
                        id="city" 
                        name="city" 
                        value="{{ old('city', $student->city) }}" 
                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter your city"
                    >
                    @error('city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- School/College -->
                <div>
                    <label for="school_college" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        School/College
                    </label>
                    <input 
                        type="text" 
                        id="school_college" 
                        name="school_college" 
                        value="{{ old('school_college', $student->school_college) }}" 
                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter your school/college name"
                    >
                    @error('school_college')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Class/Grade -->
                <div>
                    <label for="class_grade" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Class/Grade
                    </label>
                    <input 
                        type="text" 
                        id="class_grade" 
                        name="class_grade" 
                        value="{{ old('class_grade', $student->class_grade) }}" 
                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter your class/grade"
                    >
                    @error('class_grade')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parent Name -->
                <div>
                    <label for="parent_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Parent/Guardian Name
                    </label>
                    <input 
                        type="text" 
                        id="parent_name" 
                        name="parent_name" 
                        value="{{ old('parent_name', $student->parent_name) }}" 
                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter parent/guardian name"
                    >
                    @error('parent_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parent Phone -->
                <div>
                    <label for="parent_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Parent/Guardian Phone
                    </label>
                    <input 
                        type="tel" 
                        id="parent_phone" 
                        name="parent_phone" 
                        value="{{ old('parent_phone', $student->parent_phone) }}" 
                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter parent/guardian phone"
                    >
                    @error('parent_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('student.profile.show') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors duration-200">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Preview image before upload
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.querySelector('img[src*="' + file.name + '"]') || 
                       document.querySelector('.w-32.h-32.rounded-full');
            if (img) {
                img.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
