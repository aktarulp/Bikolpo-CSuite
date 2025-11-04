@extends('system-admin.system-admin-layout')

@section('title', 'Edit QCReator')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-4">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit QCReator</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Update information for this question creator</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('system-admin.qcreators.index') }}" 
                       class="inline-flex items-center gap-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-xl px-4 py-2 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Back to List</span>
                    </a>
                    <a href="{{ route('system-admin.qcreators.show', $qcreator) }}" 
                       class="inline-flex items-center gap-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-xl px-4 py-2 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>View</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <form action="{{ route('system-admin.qcreators.update', $qcreator) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Creator Information</h2>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Photo Upload -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Photo</label>
                            <div class="mt-1 flex items-center">
                                <div class="bg-gray-200 dark:bg-gray-700 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl w-32 h-32 flex items-center justify-center overflow-hidden">
                                    <img id="photoPreview" src="{{ $qcreator->photo ? $qcreator->photo_url : '' }}" alt="Preview" class="{{ $qcreator->photo ? '' : 'hidden' }} w-full h-full object-cover">
                                    <span id="photoPlaceholder" class="{{ $qcreator->photo ? 'hidden' : '' }} text-gray-500 dark:text-gray-400">
                                        <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <input type="file" name="photo" id="photo" accept="image/*"
                                       class="block w-full text-sm text-gray-500 dark:text-gray-400
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-indigo-50 file:text-indigo-700
                                              hover:file:bg-indigo-100
                                              dark:file:bg-indigo-900/30 dark:file:text-indigo-300
                                              dark:hover:file:bg-indigo-800/50">
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Upload a new photo (JPG, PNG, GIF) or leave blank to keep current</p>
                                @if($qcreator->photo)
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Current photo: {{ basename($qcreator->photo) }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Basic Information -->
                        <div class="md:col-span-2 space-y-6">
                            <!-- Full Name -->
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="full_name" id="full_name" required value="{{ old('full_name', $qcreator->full_name) }}"
                                       class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm px-3 py-2 border"
                                       placeholder="Enter full name">
                                @error('full_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Designation & Organization -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="designation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Designation</label>
                                    <input type="text" name="designation" id="designation" value="{{ old('designation', $qcreator->designation) }}"
                                           class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm px-3 py-2 border"
                                           placeholder="Enter designation">
                                </div>
                                
                                <div>
                                    <label for="organization" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Organization</label>
                                    <input type="text" name="organization" id="organization" value="{{ old('organization', $qcreator->organization) }}"
                                           class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm px-3 py-2 border"
                                           placeholder="Enter organization">
                                </div>
                            </div>
                            
                            <!-- Email & Phone -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $qcreator->email) }}"
                                           class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm px-3 py-2 border"
                                           placeholder="Enter email address">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $qcreator->phone) }}"
                                           class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm px-3 py-2 border"
                                           placeholder="Enter phone number">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Experiences -->
                    <div>
                        <label for="experiences" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Experiences</label>
                        <textarea name="experiences" id="experiences" rows="4"
                                  class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm px-3 py-2 border"
                                  placeholder="Enter experiences and qualifications">{{ old('experiences', $qcreator->experiences) }}</textarea>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Describe the creator's experience in question creation</p>
                    </div>
                    
                    <!-- Remarks -->
                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Remarks</label>
                        <textarea name="remarks" id="remarks" rows="3"
                                  class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm px-3 py-2 border"
                                  placeholder="Any additional remarks or notes">{{ old('remarks', $qcreator->remarks) }}</textarea>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
                    <a href="{{ route('system-admin.qcreators.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Creator
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Photo preview functionality
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const photoPreview = document.getElementById('photoPreview');
        const photoPlaceholder = document.getElementById('photoPlaceholder');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
                photoPreview.classList.remove('hidden');
                photoPlaceholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            // If no new file selected, show current photo if exists
            const currentPhotoSrc = photoPreview.src;
            if (currentPhotoSrc && currentPhotoSrc !== window.location.href) {
                photoPreview.classList.remove('hidden');
                photoPlaceholder.classList.add('hidden');
            } else {
                photoPreview.classList.add('hidden');
                photoPlaceholder.classList.remove('hidden');
            }
        }
    });
</script>
@endsection