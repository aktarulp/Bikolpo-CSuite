@extends('layouts.app')

@section('title', 'MCQ Questions')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">MCQ Questions</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage your multiple choice questions</p>
            
        </div>
        <div class="flex gap-3">
            <a href="{{ route('partner.questions.mcq.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                + MCQ
            </a>
            
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Course</label>
                <select name="course_filter" class="w-full rounded-md border p-2">
                    <option value="">All Courses</option>
                    @foreach($courses ?? [] as $course)
                        <option value="{{ $course->id }}" {{ request('course_filter') == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Subject</label>
                <select name="subject_filter" class="w-full rounded-md border p-2">
                    <option value="">All Subjects</option>
                    @foreach($subjects ?? [] as $subject)
                        <option value="{{ $subject->id }}" {{ request('subject_filter') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Topic</label>
                <select name="topic_filter" class="w-full rounded-md border p-2">
                    <option value="">All Topics</option>
                    @foreach($topics ?? [] as $topic)
                        <option value="{{ $topic->id }}" {{ request('topic_filter') == $topic->id ? 'selected' : '' }}>
                            {{ $topic->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-end gap-2">
                                        <a href="{{ route('partner.questions.mcq.all-question-view') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md transition-colors duration-200 text-center">
                    Clear
                </a>
                
            </div>
        </form>
    </div>

    <!-- Questions List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                MCQ Questions ({{ $questions->total() }})
            </h2>
        </div>

        @if($questions->count() > 0)
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($questions as $question)
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 border-l-4 border-transparent hover:border-primaryGreen">
                        <div class="flex items-start gap-4">
                            <div class="flex flex-col items-start gap-2 min-w-[120px]">
                                <a href="{{ route('partner.questions.mcq.show', $question) }}" 
                                   class="inline-flex items-center gap-2 px-3 py-2 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>
                                <a href="{{ route('partner.questions.mcq.edit', $question) }}" 
                                   class="inline-flex items-center gap-2 px-3 py-2 text-sm text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-md transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('partner.questions.mcq.destroy', $question) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md transition-colors duration-200"
                                            onclick="return confirm('Are you sure you want to delete this question?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                        {{ $question->course->name ?? 'N/A' }}
                                    </span>
                                    <span class="text-gray-400 dark:text-gray-500">→</span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                        {{ $question->subject->name ?? 'N/A' }}
                                    </span>
                                    <span class="text-gray-400 dark:text-gray-500">→</span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-800">
                                        {{ $question->topic->name ?? 'N/A' }}
                                    </span>
                                </div>
                                
                                <h3 class="text-base font-medium text-gray-900 dark:text-white mb-3 leading-relaxed flex items-center gap-2">
                                    {!! Str::limit($question->question_text, 150) !!}
                                    @if($question->image)
                                        <div class="relative group">
                                            <svg class="w-4 h-4 text-blue-500 hover:text-blue-700 cursor-pointer transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" title="View Image">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <!-- Image Preview Tooltip -->
                                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none z-50 scale-95 group-hover:scale-100 image-preview-tooltip">
                                                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg shadow-xl p-3">
                                                    <img src="{{ asset('storage/' . $question->image) }}" 
                                                         alt="Question Image" 
                                                         class="rounded">
                                                </div>
                                                <!-- Arrow -->
                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-200 dark:border-t-gray-600"></div>
                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-3 border-r-3 border-t-3 border-transparent border-t-white dark:border-t-gray-800 -mt-1"></div>
                                            </div>
                                        </div>
                                    @endif
                                </h3>
                                
                                <div class="flex flex-wrap gap-2 text-sm">
                                    <span class="inline-flex items-center px-3 py-2 rounded-lg shadow-sm {{ $question->correct_answer === 'a' ? 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/40 dark:to-emerald-900/40 border-2 border-green-300 dark:border-green-600 text-green-800 dark:text-green-200 font-medium shadow-green-100 dark:shadow-green-900/20' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200' }}">
                                        <span class="font-bold mr-2 text-sm {{ $question->correct_answer === 'a' ? 'text-green-700 dark:text-green-300' : 'text-gray-500 dark:text-gray-400' }}">A</span> 
                                        {!! Str::limit($question->option_a, 40) !!}
                                        @if($question->correct_answer === 'a')
                                            <svg class="w-4 h-4 ml-2 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <span class="inline-flex items-center px-3 py-2 rounded-lg shadow-sm {{ $question->correct_answer === 'b' ? 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/40 dark:to-emerald-900/40 border-2 border-green-300 dark:border-green-600 text-green-800 dark:text-green-200 font-medium shadow-green-100 dark:shadow-green-900/20' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200' }}">
                                        <span class="font-bold mr-2 text-sm {{ $question->correct_answer === 'b' ? 'text-green-700 dark:text-green-300' : 'text-gray-500 dark:text-gray-400' }}">B</span> 
                                        {!! Str::limit($question->option_b, 40) !!}
                                        @if($question->correct_answer === 'b')
                                            <svg class="w-4 h-4 ml-2 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <span class="inline-flex items-center px-3 py-2 rounded-lg shadow-sm {{ $question->correct_answer === 'c' ? 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/40 dark:to-emerald-900/40 border-2 border-green-300 dark:border-green-600 text-green-800 dark:text-green-200 font-medium shadow-green-100 dark:shadow-green-900/20' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200' }}">
                                        <span class="font-bold mr-2 text-sm {{ $question->correct_answer === 'c' ? 'text-green-700 dark:text-green-300' : 'text-gray-500 dark:text-gray-400' }}">C</span> 
                                        {!! Str::limit($question->option_c, 40) !!}
                                        @if($question->correct_answer === 'c')
                                            <svg class="w-4 h-4 ml-2 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <span class="inline-flex items-center px-3 py-2 rounded-lg shadow-sm {{ $question->correct_answer === 'd' ? 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/40 dark:to-emerald-900/40 border-2 border-green-300 dark:border-green-600 text-green-800 dark:text-green-200 font-medium shadow-green-100 dark:shadow-green-900/20' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200' }}">
                                        <span class="font-bold mr-2 text-sm {{ $question->correct_answer === 'd' ? 'text-green-700 dark:text-green-300' : 'text-gray-500 dark:text-gray-400' }}">D</span> 
                                        {!! Str::limit($question->option_d, 40) !!}
                                        @if($question->correct_answer === 'd')
                                            <svg class="w-4 h-4 ml-2 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </span>
                                </div>
                                

                                                        </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                {{ $questions->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No MCQ questions</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new MCQ question.</p>
                <div class="mt-6">
                    <a href="{{ route('partner.questions.mcq.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        + MCQ
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.image-preview-tooltip {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    transform-origin: bottom center;
}

.image-preview-tooltip.group:hover\:opacity-100 {
    transition-delay: 0.1s;
}

.image-preview-tooltip img {
    max-width: 300px;
    max-height: 200px;
    object-fit: contain;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all filter select elements
    const filterSelects = document.querySelectorAll('select[name="course_filter"], select[name="subject_filter"], select[name="topic_filter"]');
    
    // Add change event listener to each filter
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Submit the form automatically when any filter changes
            this.closest('form').submit();
        });
    });
});
</script>

@endsection
