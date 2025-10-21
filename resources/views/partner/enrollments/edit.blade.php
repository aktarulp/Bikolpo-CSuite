@extends('layouts.partner-layout')

@section('title', 'Edit Assignment')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-orange-50/30 to-gray-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-4 sm:py-6 lg:py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto space-y-4 sm:space-y-6 animate-fade-in">
        
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('partner.enrollments.show', $enrollment) }}" 
                   class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-xl bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 hover:border-orange-500 dark:hover:border-orange-500 transition-all duration-200 hover:scale-110 shadow-sm">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white">
                        Edit Assignment
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        Update enrollment details and status
                    </p>
                </div>
            </div>
        </div>

        @if($errors->any())
        <div class="bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-800 dark:text-red-300 mb-2">Please fix the following errors:</h3>
                    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('partner.enrollments.update', $enrollment) }}" method="POST" class="space-y-4 sm:space-y-6">
            @csrf
            @method('PUT')

            {{-- Student & Course Info (Read-only) --}}
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-6 border-2 border-blue-200 dark:border-blue-800 shadow-md">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Assignment Details</h2>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-semibold mb-1">Student</p>
                        <p class="text-base font-bold text-gray-900 dark:text-white">{{ $enrollment->student->full_name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $enrollment->student->student_id }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-semibold mb-1">Course</p>
                        <p class="text-base font-bold text-gray-900 dark:text-white">{{ $enrollment->course->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $enrollment->course->code }}</p>
                    </div>
                </div>
            </div>

            {{-- Main Form Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                
                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-orange-500 to-amber-600 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white">Update Information</h3>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-6 space-y-6">
                    
                    {{-- Status Selection --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Status *
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                            @foreach($statuses as $key => $label)
                            <label class="block cursor-pointer">
                                <input type="radio" name="status" value="{{ $key }}" 
                                       class="hidden peer" 
                                       {{ old('status', $enrollment->status) === $key ? 'checked' : '' }}>
                                <div class="px-4 py-3 border-2 rounded-xl text-center transition-all duration-200 hover:scale-105 hover:shadow-md
                                            @if($key === 'active') border-green-300 dark:border-green-700 bg-green-50 dark:bg-green-900/20 peer-checked:border-green-500 peer-checked:ring-2 peer-checked:ring-green-500/50 peer-checked:scale-105 @endif
                                            @if($key === 'completed') border-blue-300 dark:border-blue-700 bg-blue-50 dark:bg-blue-900/20 peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-500/50 peer-checked:scale-105 @endif
                                            @if($key === 'dropped') border-red-300 dark:border-red-700 bg-red-50 dark:bg-red-900/20 peer-checked:border-red-500 peer-checked:ring-2 peer-checked:ring-red-500/50 peer-checked:scale-105 @endif
                                            @if($key === 'suspended') border-yellow-300 dark:border-yellow-700 bg-yellow-50 dark:bg-yellow-900/20 peer-checked:border-yellow-500 peer-checked:ring-2 peer-checked:ring-yellow-500/50 peer-checked:scale-105 @endif
                                            @if($key === 'transferred') border-purple-300 dark:border-purple-700 bg-purple-50 dark:bg-purple-900/20 peer-checked:border-purple-500 peer-checked:ring-2 peer-checked:ring-purple-500/50 peer-checked:scale-105 @endif">
                                    <p class="text-xs font-bold
                                             @if($key === 'active') text-green-700 dark:text-green-300 @endif
                                             @if($key === 'completed') text-blue-700 dark:text-blue-300 @endif
                                             @if($key === 'dropped') text-red-700 dark:text-red-300 @endif
                                             @if($key === 'suspended') text-yellow-700 dark:text-yellow-300 @endif
                                             @if($key === 'transferred') text-purple-700 dark:text-purple-300 @endif">
                                        {{ $label }}
                                    </p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Batch Selection --}}
                    <div>
                        <label for="batch_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Batch (Optional)
                        </label>
                        <select name="batch_id" id="batch_id" 
                                class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200">
                            <option value="">-- Select Batch --</option>
                            @foreach($batches as $batch)
                                <option value="{{ $batch->id }}" {{ old('batch_id', $enrollment->batch_id) == $batch->id ? 'selected' : '' }}>
                                    {{ $batch->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('batch_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Completion Date --}}
                    <div>
                        <label for="completion_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Completion Date (Optional)
                        </label>
                        <input type="date" name="completion_date" id="completion_date" 
                               value="{{ old('completion_date', $enrollment->completion_date?->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Set this when status is "Completed"</p>
                        @error('completion_date')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Final Grade & Grade Letter --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="final_grade" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                Final Grade (0-100)
                            </label>
                            <input type="number" name="final_grade" id="final_grade" 
                                   min="0" max="100" step="0.01"
                                   value="{{ old('final_grade', $enrollment->final_grade) }}"
                                   placeholder="e.g., 85.50"
                                   class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200">
                            @error('final_grade')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="grade_letter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Grade Letter
                            </label>
                            <input type="text" name="grade_letter" id="grade_letter" 
                                   maxlength="2"
                                   value="{{ old('grade_letter', $enrollment->grade_letter) }}"
                                   placeholder="e.g., A+, B, C"
                                   class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-white uppercase focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200">
                            @error('grade_letter')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Remarks --}}
                    <div>
                        <label for="remarks" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            Remarks (Optional)
                        </label>
                        <textarea name="remarks" id="remarks" rows="4" 
                                  placeholder="Add any additional notes or comments..."
                                  class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-white resize-none focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200">{{ old('remarks', $enrollment->remarks) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maximum 1000 characters</p>
                        @error('remarks')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Card Footer --}}
                <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col-reverse sm:flex-row sm:justify-between sm:items-center gap-3">
                        <a href="{{ route('partner.enrollments.show', $enrollment) }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                        
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </div>

            </div>

            {{-- Helpful Tips Card --}}
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-2xl p-6 border border-purple-200 dark:border-purple-800 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-purple-900 dark:text-purple-300 mb-2">💡 Quick Tips</h4>
                        <ul class="text-xs text-purple-800 dark:text-purple-400 space-y-1 list-disc list-inside">
                            <li><strong>Active:</strong> Student is currently enrolled in the course</li>
                            <li><strong>Completed:</strong> Student has finished the course (set completion date & grades)</li>
                            <li><strong>Dropped:</strong> Student has withdrawn from the course</li>
                            <li><strong>Suspended:</strong> Enrollment is temporarily on hold</li>
                            <li><strong>Transferred:</strong> Student has moved to a different course</li>
                        </ul>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const courseSelect = document.getElementById('course_id');
    const batchSelect = document.getElementById('batch_id');
    
    if (courseSelect && batchSelect) {
        courseSelect.addEventListener('change', function() {
            const courseId = this.value;
            
            // Clear existing batch options except the first one
            batchSelect.innerHTML = '<option value="">-- Select Batch (Optional) --</option>';
            
            if (courseId) {
                // Fetch batches for the selected course
                fetch(`/partner/batches/by-course/${courseId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.batches.forEach(batch => {
                            const option = document.createElement('option');
                            option.value = batch.id;
                            option.textContent = `${batch.name} (${batch.year})`;
                            batchSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching batches:', error);
                    });
            }
        });
    }
});
</script>
@endsection
