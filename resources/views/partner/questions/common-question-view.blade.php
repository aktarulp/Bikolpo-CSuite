@extends('layouts.partner-layout')

@section('title', 'Question View - ' . $question->questionTypeText)

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
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .question-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        position: relative;
    }
    
    .question-type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }
    
    .question-content {
        padding: 1.5rem;
    }
    
    .question-text {
        font-size: 1.125rem;
        line-height: 1.7;
        color: #1f2937;
        margin-bottom: 1.5rem;
        word-wrap: break-word;
    }
    
    .options-container {
        margin: 1.5rem 0;
    }
    
    .option-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .option-item:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    
    .option-item.correct {
        background: #dcfce7;
        border-color: #22c55e;
    }
    
    .option-letter {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        background: #3b82f6;
        color: white;
        border-radius: 50%;
        font-weight: 600;
        font-size: 0.875rem;
        flex-shrink: 0;
    }
    
    .option-item.correct .option-letter {
        background: #22c55e;
    }
    
    .option-text {
        flex: 1;
        font-size: 1rem;
        line-height: 1.6;
        color: #374151;
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
            padding: 0.75rem;
            gap: 0.75rem;
        }
        
        .option-letter {
            width: 1.75rem;
            height: 1.75rem;
            font-size: 0.75rem;
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
        
        .option-text {
            font-size: 0.875rem;
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
    
    /* Print styles */
    @media print {
        .action-buttons {
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
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold mb-2">Question #{{ $question->id }}</h1>
                    <div class="flex items-center gap-3 flex-wrap">
                        <div class="question-type-badge">
                            @if($question->question_type === 'mcq')
                                <img src="{{ asset('images/mcq.png') }}" alt="MCQ" class="w-5 h-5">
                                <span>Multiple Choice Question</span>
                            @elseif($question->question_type === 'descriptive')
                                <img src="{{ asset('images/cq.png') }}" alt="CQ" class="w-5 h-5">
                                <span>Constructed Question</span>
                            @elseif($question->question_type === 'true_false')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>True/False Question</span>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                <span>Fill in the Blanks</span>
                            @endif
                        </div>
                        
                        @if($question->difficulty_level)
                            <div class="difficulty-indicator 
                                {{ $question->difficulty_level == 1 ? 'difficulty-easy' : ($question->difficulty_level == 2 ? 'difficulty-medium' : 'difficulty-hard') }}">
                                @if($question->difficulty_level == 1)
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Easy
                                @elseif($question->difficulty_level == 2)
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    Medium
                                @else
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    Hard
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                
                @if($question->marks)
                    <div class="text-right">
                        <div class="text-2xl font-bold">{{ $question->marks }}</div>
                        <div class="text-sm opacity-90">Marks</div>
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

            <!-- Question Text -->
            <div class="question-text">
                {!! $question->question_text !!}
            </div>

            <!-- Question Options (for MCQ and True/False) -->
            @if(in_array($question->question_type, ['mcq', 'true_false']) && ($question->option_a || $question->option_b))
                <div class="options-container">
                    @if($question->option_a)
                        <div class="option-item {{ $question->correct_answer === 'a' ? 'correct' : '' }}">
                            <div class="option-letter">A</div>
                            <div class="option-text">{{ $question->option_a }}</div>
                        </div>
                    @endif
                    
                    @if($question->option_b)
                        <div class="option-item {{ $question->correct_answer === 'b' ? 'correct' : '' }}">
                            <div class="option-letter">B</div>
                            <div class="option-text">{{ $question->option_b }}</div>
                        </div>
                    @endif
                    
                    @if($question->option_c)
                        <div class="option-item {{ $question->correct_answer === 'c' ? 'correct' : '' }}">
                            <div class="option-letter">C</div>
                            <div class="option-text">{{ $question->option_c }}</div>
                        </div>
                    @endif
                    
                    @if($question->option_d)
                        <div class="option-item {{ $question->correct_answer === 'd' ? 'correct' : '' }}">
                            <div class="option-letter">D</div>
                            <div class="option-text">{{ $question->option_d }}</div>
                        </div>
                    @endif
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
            <div class="question-meta">
                <div class="meta-grid">
                    <div class="meta-item">
                        <div class="meta-label">Course</div>
                        <div class="meta-value">{{ $question->course->name ?? 'N/A' }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Subject</div>
                        <div class="meta-value">{{ $question->subject->name ?? 'N/A' }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Topic</div>
                        <div class="meta-value">{{ $question->topic->name ?? 'N/A' }}</div>
                    </div>
                    @if($question->questionType)
                        <div class="meta-item">
                            <div class="meta-label">Question Type</div>
                            <div class="meta-value">{{ $question->questionType->q_type_name }}</div>
                        </div>
                    @endif
                    @if($question->time_allocation)
                        <div class="meta-item">
                            <div class="meta-label">Time Allocation</div>
                            <div class="meta-value">{{ $question->time_allocation }} minutes</div>
                        </div>
                    @endif
                    <div class="meta-item">
                        <div class="meta-label">Created</div>
                        <div class="meta-value">{{ $question->created_at->format('M d, Y \a\t g:i A') }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Status</div>
                        <div class="meta-value">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $question->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($question->status) }}
                            </span>
                        </div>
                    </div>
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

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('partner.questions.drafts') }}" class="btn btn-warning">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            View Drafts
        </a>
        
        <a href="{{ route('partner.questions.all') }}" class="btn btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to All Questions
        </a>
        
        @if($question->question_type === 'mcq')
            <a href="{{ route('partner.questions.mcq.edit', $question) }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Question
            </a>
        @elseif($question->question_type === 'descriptive')
            <a href="{{ route('partner.questions.descriptive.edit', $question) }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Question
            </a>
        @elseif($question->question_type === 'true_false')
            <a href="{{ route('partner.questions.tf.edit', $question) }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Question
            </a>
        @else
            <a href="{{ route('partner.questions.edit', $question) }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Question
            </a>
        @endif
        
        <button onclick="window.print()" class="btn btn-outline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print Question
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
                this.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading...';
                
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
});
</script>
@endsection
