@extends('layouts.partner-layout')

@section('title', 'Question Analytics - ' . $question->questionTypeText)

@section('content')
<style>
    /* Mobile-first responsive design */
    .question-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 1rem;
    }
    
    .question-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        margin-bottom: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .question-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #3b82f6;
    }
    
    .question-header {
        background: #ffffff;
        color: #1f2937;
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .question-type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #f3f4f6;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
    }
    
    .question-content {
        padding: 1.5rem;
    }
    
    .question-text {
        font-size: 0.875rem;
        line-height: 1.2;
        color: #374151;
        margin-bottom: 1rem;
        word-wrap: break-word;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }
    
    .options-container {
        margin: 0.5rem 0;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: center;
        visibility: visible;
    }
    
    .option-item {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 4px;
        transition: all 0.15s ease;
        cursor: pointer;
        font-size: 0.75rem;
    }
    
    .option-item:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }
    
    .option-item.correct {
        background: #f0fdf4;
        border-color: #22c55e;
    }
    
    .option-letter {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 1.25rem;
        height: 1.25rem;
        background: #f3f4f6;
        color: #6b7280;
        border-radius: 3px;
        font-weight: 500;
        font-size: 0.625rem;
        flex-shrink: 0;
    }
    
    .option-item.correct .option-letter {
        background: #22c55e;
        color: white;
    }
    
    .option-text {
        font-size: 0.75rem;
        line-height: 1.2;
        color: #374151;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }
    
    .question-meta {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
    
    .meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .meta-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .meta-value {
        font-size: 0.875rem;
        color: #1f2937;
        font-weight: 500;
    }
    
    .explanation-section {
        background: #fef3c7;
        border: 1px solid #f59e0b;
        border-radius: 8px;
        padding: 1.5rem;
        margin: 1.5rem 0;
    }
    
    .explanation-title {
        font-size: 1rem;
        font-weight: 600;
        color: #92400e;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .explanation-content {
        font-size: 0.875rem;
        line-height: 1.6;
        color: #92400e;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 2rem;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }
    
    .btn-primary {
        background: #3b82f6;
        color: white;
    }
    
    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }
    
    .btn-secondary {
        background: #6b7280;
        color: white;
    }
    
    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-1px);
    }
    
    .btn-success {
        background: #22c55e;
        color: white;
    }
    
    .btn-success:hover {
        background: #16a34a;
        transform: translateY(-1px);
    }
    
    .btn-outline {
        background: transparent;
        color: #3b82f6;
        border: 2px solid #3b82f6;
    }
    
    .btn-outline:hover {
        background: #3b82f6;
        color: white;
    }
    
    .image-container {
        margin: 1rem 0;
        text-align: center;
    }
    
    .question-image {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .difficulty-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .difficulty-easy {
        background: #dcfce7;
        color: #166534;
    }
    
    .difficulty-medium {
        background: #fef3c7;
        color: #92400e;
    }
    
    .difficulty-hard {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin: 1rem 0;
    }
    
    .tag {
        background: #e0e7ff;
        color: #3730a3;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .question-container {
            padding: 0.5rem;
        }
        
        .question-header {
            padding: 1rem;
        }
        
        .question-content {
            padding: 1rem;
        }
        
        .question-text {
            font-size: 1rem;
        }
        
        .option-item {
            padding: 0.5rem 0.75rem;
            gap: 0.5rem;
        }
        
        .option-letter {
            width: 1.25rem;
            height: 1.25rem;
            font-size: 0.625rem;
        }
        
        .option-text {
            font-size: 0.8125rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn {
            justify-content: center;
            width: 100%;
        }
        
        .meta-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 480px) {
        .question-header h1 {
            font-size: 1.25rem;
        }
        
        .question-text {
            font-size: 0.95rem;
        }
        
        .option-item {
            padding: 0.5rem;
            gap: 0.5rem;
        }
        
        .option-letter {
            width: 1.125rem;
            height: 1.125rem;
            font-size: 0.625rem;
        }
        
        .option-text {
            font-size: 0.8125rem;
            line-height: 1.4;
        }
    }
    
    /* Loading states */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }
    
    /* Animation for correct answers */
    @keyframes correctAnswer {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .option-item.correct {
        animation: correctAnswer 0.6s ease-in-out;
    }
    
    /* Analytics Dashboard Styles */
    .analytics-dashboard {
        margin-top: 2rem;
    }
    
    .analytics-card {
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .analytics-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    .tab-button {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .tab-button:hover {
        color: #374151;
    }
    
    .tab-button.active {
        color: #2563eb;
        border-color: #2563eb;
    }
    
    .tab-content {
        display: block;
    }
    
    .tab-content.hidden {
        display: none;
    }
    
    /* Student Performance Cards */
    .student-card {
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }
    
    .student-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.1);
    }
    
    /* Progress Bars */
    .progress-bar {
        transition: width 0.3s ease;
    }
    
    /* Mobile Responsive Enhancements */
    @media (max-width: 640px) {
        .analytics-card {
            padding: 1rem;
        }
        
        .analytics-card .text-3xl {
            font-size: 1.875rem;
        }
        
        .tab-button {
            padding: 0.75rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .student-card {
            padding: 0.75rem;
        }
        
        .grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3 {
            grid-template-columns: 1fr;
        }
        
        .question-text {
            white-space: normal;
            line-height: 1.4;
        }
        
        .question-header .flex.items-center {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .question-header .flex.items-center .flex-1 {
            width: 100%;
        }
        
        .question-header .mt-1.flex.items-center {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .question-header .flex.items-center.gap-3 {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .question-header .question-text {
            width: 100%;
            margin-left: 0;
        }
        
        .options-container {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }
        
        .option-item {
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
        }
        
        .option-text {
            max-width: 150px;
        }
    }
    
    /* Loading Animation */
    .loading-spinner {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    /* Print styles */
    @media print {
        .action-buttons,
        .analytics-dashboard {
            display: none;
        }
        
        .question-card {
            box-shadow: none;
            border: 1px solid #e5e7eb;
        }
    }
</style>

<div class="question-container">
    <div class="question-card">
        <!-- Question Header -->
        <div class="question-header">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3 flex-1">
                    <div class="question-type-badge w-10 h-10 rounded-lg flex items-center justify-center
                        {{ $question->question_type === 'mcq' ? 'bg-blue-100' : ($question->question_type === 'true_false' ? 'bg-orange-100' : 'bg-green-100') }}">
                            @if($question->question_type === 'mcq')
                                <img src="{{ asset('images/mcq.png') }}" alt="MCQ" class="w-5 h-5">
                            @elseif($question->question_type === 'descriptive')
                                <img src="{{ asset('images/cq.png') }}" alt="CQ" class="w-5 h-5">
                        @else
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                {{ $question->question_type === 'mcq' ? 'bg-blue-100 text-blue-800' : ($question->question_type === 'true_false' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800') }}">
                                {{ $question->question_type === 'mcq' ? 'MCQ' : ($question->question_type === 'true_false' ? 'T/F' : 'Descriptive') }}
                            </span>
                            <!-- Question Text moved here -->
                            <div class="question-text flex-1" title="{{ strip_tags($question->question_text) }}">
                                {{ strip_tags($question->question_text) }}
                            </div>
                        </div>
                        @if($question->difficulty_level)
                            <div class="mt-1 flex items-center gap-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    {{ $question->difficulty_level == 1 ? 'bg-green-100 text-green-800' : ($question->difficulty_level == 2 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                @if($question->difficulty_level == 1)
                                    Easy
                                @elseif($question->difficulty_level == 2)
                                    Medium
                                @else
                                    Hard
                                @endif
                                </span>
                                <!-- Breadcrumb moved here -->
                                <span class="text-xs text-gray-600">
                                    {{ $question->course->name ?? 'N/A' }} → {{ $question->subject->name ?? 'N/A' }} → {{ $question->topic->name ?? 'N/A' }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <!-- Options moved here -->
                    @if(in_array($question->question_type, ['mcq', 'true_false']))
                        <div class="options-container ml-4">
                            @if($question->option_a)
                                <div class="option-item {{ $question->correct_answer === 'a' ? 'correct' : '' }}" title="{{ $question->option_a }}">
                                    <div class="option-letter">A</div>
                                    <div class="option-text">{{ $question->option_a }}</div>
                                </div>
                            @endif
                            
                            @if($question->option_b)
                                <div class="option-item {{ $question->correct_answer === 'b' ? 'correct' : '' }}" title="{{ $question->option_b }}">
                                    <div class="option-letter">B</div>
                                    <div class="option-text">{{ $question->option_b }}</div>
                                </div>
                            @endif
                            
                            @if($question->option_c)
                                <div class="option-item {{ $question->correct_answer === 'c' ? 'correct' : '' }}" title="{{ $question->option_c }}">
                                    <div class="option-letter">C</div>
                                    <div class="option-text">{{ $question->option_c }}</div>
                                </div>
                            @endif
                            
                            @if($question->option_d)
                                <div class="option-item {{ $question->correct_answer === 'd' ? 'correct' : '' }}" title="{{ $question->option_d }}">
                                    <div class="option-letter">D</div>
                                    <div class="option-text">{{ $question->option_d }}</div>
                                </div>
                            @endif
                            
                            @if(!$question->option_a && !$question->option_b && !$question->option_c && !$question->option_d)
                                <div class="text-gray-500 text-xs italic">No options</div>
                            @endif
                        </div>
                    @endif
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-2">
                    @if($question->question_type === 'mcq')
                        <a href="{{ route('partner.questions.mcq.edit', $question) }}" 
                           class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 group">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                    @elseif($question->question_type === 'descriptive')
                        <a href="{{ route('partner.questions.descriptive.edit', $question) }}" 
                           class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 group">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                    @elseif($question->question_type === 'true_false')
                        <a href="{{ route('partner.questions.tf.edit', $question) }}" 
                           class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 group">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('partner.questions.edit', $question) }}" 
                           class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 group">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Question ID and Marks -->
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-semibold text-gray-900">Question #{{ $question->id }}</h1>
                @if($question->marks)
                    <div class="text-right">
                        <div class="text-xl font-bold text-gray-900">{{ $question->marks }}</div>
                        <div class="text-xs text-gray-500">Marks</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Question Content -->
        <div class="question-content">
            <!-- Question Image -->
            @if($question->image)
                <div class="image-container">
                    <img src="{{ Storage::url($question->image) }}" alt="Question Image" class="question-image">
                </div>
            @endif


            <!-- Descriptive Question Specific Fields -->
            @if($question->question_type === 'descriptive')
                @if($question->expected_answer_points)
                    <div class="explanation-section">
                        <div class="explanation-title">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Expected Answer Points
                        </div>
                        <div class="explanation-content">
                            {!! $question->expected_answer_points !!}
                        </div>
                    </div>
                @endif

                @if($question->sample_answer)
                    <div class="explanation-section">
                        <div class="explanation-title">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Sample Answer
                        </div>
                        <div class="explanation-content">
                            {!! $question->sample_answer !!}
                        </div>
                    </div>
                @endif

                @if($question->min_words || $question->max_words)
                    <div class="question-meta">
                        <div class="meta-grid">
                            @if($question->min_words)
                                <div class="meta-item">
                                    <div class="meta-label">Minimum Words</div>
                                    <div class="meta-value">{{ $question->min_words }}</div>
                                </div>
                            @endif
                            @if($question->max_words)
                                <div class="meta-item">
                                    <div class="meta-label">Maximum Words</div>
                                    <div class="meta-value">{{ $question->max_words }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @if($question->key_concepts)
                    <div class="explanation-section">
                        <div class="explanation-title">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Key Concepts
                        </div>
                        <div class="explanation-content">
                            {!! $question->key_concepts !!}
                        </div>
                    </div>
                @endif
            @endif

            <!-- Question Metadata -->
            <div class="space-y-2 text-xs text-gray-600">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ $question->time_allocation ?? 'N/A' }} min</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $question->created_at->format('M d, Y') }}</span>
                    </div>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                {{ $question->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($question->status) }}
                            </span>
                </div>
            </div>

            <!-- Tags -->
            @if($question->tags && count($question->tags) > 0)
                <div class="tags-container">
                    @foreach($question->tags as $tag)
                        <span class="tag">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif

            <!-- Explanation -->
            @if($question->explanation)
                <div class="explanation-section">
                    <div class="explanation-title">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Explanation
                    </div>
                    <div class="explanation-content">
                        {!! $question->explanation !!}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Analytics Dashboard -->
    <div class="analytics-dashboard mt-8">
        <!-- Analytics Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="analytics-card bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Attempts</p>
                        <p class="text-3xl font-bold">{{ $analytics['total_attempts'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-400 bg-opacity-30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
                    </div>
                </div>
            </div>

            <div class="analytics-card bg-gradient-to-r from-green-500 to-green-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Correct Answers</p>
                        <p class="text-3xl font-bold">{{ $analytics['total_correct'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-400 bg-opacity-30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
                    </div>
                </div>
            </div>

            <div class="analytics-card bg-gradient-to-r from-red-500 to-red-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Incorrect Answers</p>
                        <p class="text-3xl font-bold">{{ $analytics['total_incorrect'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-400 bg-opacity-30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                    </div>
                </div>
            </div>

            <div class="analytics-card bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Success Rate</p>
                        <p class="text-3xl font-bold">{{ $analytics['correct_percentage'] ?? 0 }}%</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-400 bg-opacity-30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Analytics Tabs -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button onclick="showTab('overview')" class="tab-button active py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                        Overview
                    </button>
                    <button onclick="showTab('students')" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                        Student Performance
                    </button>
                    <button onclick="showTab('distribution')" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                        Answer Distribution
                    </button>
                    <button onclick="showTab('timeline')" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                        Performance Timeline
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- Overview Tab -->
                <div id="overview-tab" class="tab-content">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Performance Metrics -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Performance Metrics</h3>
                            
                            <div class="space-y-4">
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                    <span class="text-sm font-medium text-gray-600">Answer Rate</span>
                                    <span class="text-lg font-semibold text-gray-900">{{ $analytics['answer_rate'] ?? 0 }}%</span>
                                </div>
                                
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                    <span class="text-sm font-medium text-gray-600">Average Time Spent</span>
                                    <span class="text-lg font-semibold text-gray-900">
                                        @if($analytics['average_time_spent'])
                                            {{ floor($analytics['average_time_spent'] / 60) }}m {{ $analytics['average_time_spent'] % 60 }}s
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                    <span class="text-sm font-medium text-gray-600">Difficulty Level</span>
                                    <span class="text-lg font-semibold text-gray-900 capitalize">{{ $analytics['difficulty_level'] ?? 'Unknown' }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                    <span class="text-sm font-medium text-gray-600">Skipped Questions</span>
                                    <span class="text-lg font-semibold text-gray-900">{{ $analytics['total_skipped'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                            
                            <div class="space-y-3 max-h-64 overflow-y-auto">
                                @forelse($recentAttempts as $attempt)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-medium text-blue-600">
                                                    {{ substr($attempt->student->full_name ?? 'Unknown', 0, 2) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $attempt->student->full_name ?? 'Unknown Student' }}</p>
                                                <p class="text-xs text-gray-500">{{ $attempt->exam->title ?? 'Unknown Exam' }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $attempt->is_correct ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $attempt->is_correct ? 'Correct' : 'Incorrect' }}
                                            </span>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $attempt->question_answered_at ? $attempt->question_answered_at->diffForHumans() : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-center py-4">No recent attempts found</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Student Performance Tab -->
                <div id="students-tab" class="tab-content hidden">
                    <div class="space-y-8">
                        <!-- Students who got it correct -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                                Students Who Answered Correctly ({{ $correctStudents->count() }})
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @forelse($correctStudents as $studentData)
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-medium text-green-600">
                                                    {{ substr($studentData['student']->full_name ?? 'U', 0, 2) }}
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $studentData['student']->full_name ?? 'Unknown Student' }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $studentData['student']->phone ?? 'No phone' }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-1 text-xs text-gray-600">
                                            <div class="flex justify-between">
                                                <span>Attempts:</span>
                                                <span class="font-medium">{{ $studentData['attempts'] }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Last:</span>
                                                <span class="font-medium">
                                                    {{ $studentData['last_attempt'] ? $studentData['last_attempt']->format('M d') : 'N/A' }}
                                                </span>
                                            </div>
                                            @if($studentData['average_time'])
                                                <div class="flex justify-between">
                                                    <span>Time:</span>
                                                    <span class="font-medium">
                                                        {{ floor($studentData['average_time'] / 60) }}m {{ $studentData['average_time'] % 60 }}s
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        @if($studentData['exams']->count() > 0)
                                            <div class="mt-2">
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($studentData['exams']->take(2) as $exam)
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-green-100 text-green-800">
                                                            {{ Str::limit($exam, 15) }}
                                                        </span>
                                                    @endforeach
                                                    @if($studentData['exams']->count() > 2)
                                                        <span class="text-xs text-gray-500">+{{ $studentData['exams']->count() - 2 }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="col-span-full text-center py-8 text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p>No students have answered this question correctly yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Students who got it incorrect -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Students Who Answered Incorrectly ({{ $incorrectStudents->count() }})
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @forelse($incorrectStudents as $studentData)
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-medium text-red-600">
                                                    {{ substr($studentData['student']->full_name ?? 'U', 0, 2) }}
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $studentData['student']->full_name ?? 'Unknown Student' }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $studentData['student']->phone ?? 'No phone' }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-1 text-xs text-gray-600">
                                            <div class="flex justify-between">
                                                <span>Attempts:</span>
                                                <span class="font-medium">{{ $studentData['attempts'] }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Last:</span>
                                                <span class="font-medium">
                                                    {{ $studentData['last_attempt'] ? $studentData['last_attempt']->format('M d') : 'N/A' }}
                                                </span>
                                            </div>
                                            @if($studentData['average_time'])
                                                <div class="flex justify-between">
                                                    <span>Time:</span>
                                                    <span class="font-medium">
                                                        {{ floor($studentData['average_time'] / 60) }}m {{ $studentData['average_time'] % 60 }}s
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        @if(isset($studentData['common_wrong_answers']) && $studentData['common_wrong_answers']->count() > 0)
                                            <div class="mt-2">
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($studentData['common_wrong_answers']->take(2) as $answer => $count)
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-red-100 text-red-800">
                                                            {{ $answer }} ({{ $count }})
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if($studentData['exams']->count() > 0)
                                            <div class="mt-2">
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($studentData['exams']->take(2) as $exam)
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-red-100 text-red-800">
                                                            {{ Str::limit($exam, 15) }}
                                                        </span>
                                                    @endforeach
                                                    @if($studentData['exams']->count() > 2)
                                                        <span class="text-xs text-gray-500">+{{ $studentData['exams']->count() - 2 }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="col-span-full text-center py-8 text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p>No students have answered this question incorrectly yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Answer Distribution Tab -->
                <div id="distribution-tab" class="tab-content hidden">
                    @if(count($answerDistribution) > 0)
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900">Answer Distribution</h3>
                            
                            <div class="space-y-3">
                                @foreach($answerDistribution as $answer => $count)
                                    @php
                                        $percentage = $analytics['total_answered'] > 0 ? round(($count / $analytics['total_answered']) * 100, 1) : 0;
                                        $isCorrect = $answer === $question->correct_answer;
                                    @endphp
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center space-x-2">
                                                <span class="w-6 h-6 bg-{{ $isCorrect ? 'green' : 'gray' }}-100 text-{{ $isCorrect ? 'green' : 'gray' }}-800 rounded flex items-center justify-center text-xs font-medium">
                                                    {{ strtoupper($answer) }}
                                                </span>
                                                <span class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $question->{'option_' . $answer} ?? 'Option ' . strtoupper($answer) }}
                                                </span>
                                                @if($isCorrect)
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                        ✓
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <span class="text-lg font-bold text-gray-900">{{ $count }}</span>
                                                <span class="text-xs text-gray-500 ml-1">({{ $percentage }}%)</span>
                                            </div>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                                            <div class="bg-{{ $isCorrect ? 'green' : 'blue' }}-500 h-1.5 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
        @else
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <p>No answer distribution data available for this question type</p>
                        </div>
                    @endif
                </div>

                <!-- Performance Timeline Tab -->
                <div id="timeline-tab" class="tab-content hidden">
                    @if($performanceOverTime->count() > 0)
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900">Performance Over Time</h3>
                            
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="space-y-4">
                                    @foreach($performanceOverTime as $monthData)
                                        @php
                                            $correctPercentage = $monthData->total_attempts > 0 ? round(($monthData->correct_attempts / $monthData->total_attempts) * 100, 1) : 0;
                                        @endphp
                                        <div class="flex items-center justify-between p-4 bg-white rounded-lg border">
                                            <div>
                                                <h4 class="font-medium text-gray-900">{{ \Carbon\Carbon::createFromFormat('Y-m', $monthData->month)->format('F Y') }}</h4>
                                                <p class="text-sm text-gray-500">{{ $monthData->total_attempts }} total attempts</p>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-2xl font-bold text-gray-900">{{ $correctPercentage }}%</div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $monthData->correct_attempts }} correct, {{ $monthData->incorrect_attempts }} incorrect
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <p>No performance timeline data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between items-center mt-6">
        <a href="{{ route('partner.questions.all') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            Back to All Questions
            </a>
        
        <div class="flex gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
                Print
        </button>
        </div>
    </div>
</div>

<script>
// Tab functionality
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
        button.classList.add('border-transparent', 'text-gray-500');
        button.classList.remove('border-blue-500', 'text-blue-600');
    });
    
    // Show selected tab content
    const selectedTab = document.getElementById(tabName + '-tab');
    if (selectedTab) {
        selectedTab.classList.remove('hidden');
    }
    
    // Add active class to selected tab button
    const selectedButton = document.querySelector(`[onclick="showTab('${tabName}')"]`);
    if (selectedButton) {
        selectedButton.classList.add('active', 'border-blue-500', 'text-blue-600');
        selectedButton.classList.remove('border-transparent', 'text-gray-500');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize first tab as active
    showTab('overview');
    
    // Add smooth scrolling for better UX
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add loading states to buttons
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function() {
            if (this.href && !this.href.includes('javascript:')) {
                this.classList.add('loading');
                const originalText = this.innerHTML;
                this.innerHTML = '<svg class="w-4 h-4 loading-spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading...';
                
                // Reset after 3 seconds if still loading
                setTimeout(() => {
                    this.classList.remove('loading');
                    this.innerHTML = originalText;
                }, 3000);
            }
        });
    });
    
    // Add keyboard navigation for accessibility
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            // Close any open modals or go back
            if (window.history.length > 1) {
                window.history.back();
            }
        }
        
        // Tab navigation with arrow keys
        if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
            const activeTab = document.querySelector('.tab-button.active');
            if (activeTab) {
                const tabs = Array.from(document.querySelectorAll('.tab-button'));
                const currentIndex = tabs.indexOf(activeTab);
                let nextIndex;
                
                if (e.key === 'ArrowLeft') {
                    nextIndex = currentIndex > 0 ? currentIndex - 1 : tabs.length - 1;
                } else {
                    nextIndex = currentIndex < tabs.length - 1 ? currentIndex + 1 : 0;
                }
                
                const tabNames = ['overview', 'students', 'distribution', 'timeline'];
                if (tabNames[nextIndex]) {
                    showTab(tabNames[nextIndex]);
                }
            }
        }
    });
    
    // Add touch gestures for mobile
    let startY = 0;
    let startX = 0;
    
    document.addEventListener('touchstart', function(e) {
        startY = e.touches[0].clientY;
        startX = e.touches[0].clientX;
    });
    
    document.addEventListener('touchend', function(e) {
        const endY = e.changedTouches[0].clientY;
        const endX = e.changedTouches[0].clientX;
        const diffY = startY - endY;
        const diffX = startX - endX;
        
        // Swipe left to go back (if significant horizontal swipe)
        if (Math.abs(diffX) > Math.abs(diffY) && diffX > 50) {
            if (window.history.length > 1) {
                window.history.back();
            }
        }
    });
    
    // Add intersection observer for analytics cards animation
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe analytics cards for animation
    document.querySelectorAll('.analytics-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
    
    // Add search functionality for student lists
    function addStudentSearch() {
        const studentSections = document.querySelectorAll('#students-tab .space-y-8 > div');
        studentSections.forEach(section => {
            const heading = section.querySelector('h3');
            if (heading) {
                const searchInput = document.createElement('input');
                searchInput.type = 'text';
                searchInput.placeholder = 'Search students...';
                searchInput.className = 'w-full px-3 py-2 border border-gray-300 rounded-lg mb-4 text-sm';
                
                const studentCards = section.querySelectorAll('.grid > div');
                
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    studentCards.forEach(card => {
                        const studentName = card.querySelector('p.text-sm.font-medium')?.textContent.toLowerCase() || '';
                        const studentPhone = card.querySelector('p.text-xs.text-gray-500')?.textContent.toLowerCase() || '';
                        
                        if (studentName.includes(searchTerm) || studentPhone.includes(searchTerm)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
                
                heading.parentNode.insertBefore(searchInput, heading.nextSibling);
            }
        });
    }
    
    // Initialize student search after a short delay to ensure DOM is ready
    setTimeout(addStudentSearch, 100);
});
</script>
@endsection
