@extends('layouts.student-layout')

@section('title', 'My Syllabus')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header Section -->
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    My Syllabus
                </h1>
                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                    Track and update your progress across all subjects and topics
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="px-4 sm:px-6 lg:px-8 pb-10">
        @if(!$course)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-8 shadow-sm text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No course assigned</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You don't have a course assigned yet. Please contact your administrator.</p>
            </div>
        @else
            <!-- Course Info -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $course->name }}</h2>
                        @if($course->code)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $course->code }}</p>
                        @endif
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                            {{ $subjects->count() }} Subjects
                        </span>
                    </div>
                </div>
            </div>

            <!-- Subjects and Topics -->
            <div class="space-y-6">
                @forelse($subjects as $subject)
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                        <!-- Subject Header -->
                        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $subject->name }}</h3>
                                @if($subject->code)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300">
                                        {{ $subject->code }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Topics List -->
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @if($subject->topics->isEmpty())
                                <div class="px-5 py-8 text-center">
                                    <p class="text-gray-500 dark:text-gray-400">No topics available for this subject.</p>
                                </div>
                            @else
                                @foreach($subject->topics as $topic)
                                    <div class="px-5 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center">
                                                    @if($topic->chapter_number)
                                                        <span class="flex-shrink-0 inline-flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-800 text-xs font-bold mr-2 dark:bg-indigo-900/50 dark:text-indigo-300">
                                                            {{ $topic->chapter_number }}
                                                        </span>
                                                    @endif
                                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $topic->name }}</h4>
                                                </div>
                                                @if($topic->description)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">{{ $topic->description }}</p>
                                                @endif
                                            </div>
                                            
                                            <!-- Progress Percentage -->
                                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white w-12 text-right">
                                                {{ number_format($progressData->get($topic->id)->completion_percentage ?? 0, 0) }}%
                                            </span>
                                        </div>
                                        
                                        <!-- Progress Bar and Slider -->
                                        <div class="mb-3">
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                <div 
                                                    class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2.5 rounded-full progress-bar" 
                                                    style="width: {{ $progressData->get($topic->id)->completion_percentage ?? 0 }}%"
                                                    data-topic-id="{{ $topic->id }}"
                                                ></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Slider and Update Button -->
                                        <div class="flex items-center gap-3">
                                            <input 
                                                type="range" 
                                                min="0" 
                                                max="100" 
                                                value="{{ $progressData->get($topic->id)->completion_percentage ?? 0 }}" 
                                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 topic-progress-slider"
                                                data-topic-id="{{ $topic->id }}"
                                                data-topic-name="{{ $topic->name }}"
                                            >
                                            <button 
                                                class="update-progress-btn flex-shrink-0 px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-xs font-medium rounded-lg shadow transition-all duration-300 update-btn"
                                                data-topic-id="{{ $topic->id }}"
                                            >
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-8 shadow-sm text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No subjects found</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">There are no subjects available for your course.</p>
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sliders = document.querySelectorAll('.topic-progress-slider');
        const updateButtons = document.querySelectorAll('.update-progress-btn');
        
        // Update progress bar when slider changes
        sliders.forEach(slider => {
            slider.addEventListener('input', function() {
                const topicId = this.dataset.topicId;
                const value = this.value;
                const progressBar = document.querySelector(`.progress-bar[data-topic-id="${topicId}"]`);
                const percentageSpan = this.parentElement.previousElementSibling.querySelector('span');
                
                if (progressBar) {
                    progressBar.style.width = value + '%';
                }
                
                if (percentageSpan) {
                    percentageSpan.textContent = value + '%';
                }
            });
        });
        
        // Update progress when update button is clicked
        updateButtons.forEach(button => {
            button.addEventListener('click', function() {
                const topicId = this.dataset.topicId;
                const slider = document.querySelector(`.topic-progress-slider[data-topic-id="${topicId}"]`);
                const value = slider.value;
                
                // Send AJAX request to update progress
                fetch('{{ route("student.syllabus.update-topic-progress") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        topic_id: topicId,
                        completion_percentage: value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success feedback
                        const originalText = this.textContent;
                        this.textContent = 'Updated!';
                        this.classList.remove('from-green-500', 'to-emerald-600');
                        this.classList.add('from-emerald-500', 'to-green-600');
                        
                        setTimeout(() => {
                            this.textContent = originalText;
                            this.classList.remove('from-emerald-500', 'to-green-600');
                            this.classList.add('from-green-500', 'to-emerald-600');
                        }, 1500);
                    } else {
                        alert('Error updating progress: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating progress. Please try again.');
                });
            });
        });
    });
</script>
@endsection