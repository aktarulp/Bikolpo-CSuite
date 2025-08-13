@extends('layouts.app')

@section('title', 'Create MCQ Question')

@section('content')
<style>
/* Modern Material Design CSS Variables */
:root {
    --md-primary: #6366f1;
    --md-primary-variant: #4f46e5;
    --md-secondary: #06b6d4;
    --md-secondary-variant: #0891b2;
    --md-surface: #ffffff;
    --md-surface-variant: #f8fafc;
    --md-background: #f1f5f9;
    --md-error: #ef4444;
    --md-on-primary: #ffffff;
    --md-on-secondary: #ffffff;
    --md-on-surface: #0f172a;
    --md-on-background: #0f172a;
    --md-on-error: #ffffff;
    
    /* Modern Elevation shadows */
    --md-elevation-1: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --md-elevation-2: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
    --md-elevation-3: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --md-elevation-4: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --md-elevation-5: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    
    /* Modern Transitions */
    --md-transition-standard: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    --md-transition-deceleration: 0.0s cubic-bezier(0.0, 0.0, 0.2, 1);
    --md-transition-acceleration: 0.4s cubic-bezier(0.4, 0.0, 1, 1);
    --md-transition-sharp: 0.225s cubic-bezier(0.0, 0.0, 0.2, 1);
}

/* Dark mode variables */
@media (prefers-color-scheme: dark) {
    :root {
        --md-surface: #0f172a;
        --md-surface-variant: #1e293b;
        --md-background: #020617;
        --md-on-surface: #f8fafc;
        --md-on-background: #f8fafc;
    }
}

/* Base styles */
body {
    background: var(--md-background);
    color: var(--md-on-background);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.6;
}

/* Modern Material Design Container */
.md-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 32px;
}

/* Modern Material Design Card */
.md-card {
    background: var(--md-surface);
    border-radius: 24px;
    box-shadow: var(--md-elevation-1);
    transition: all var(--md-transition-standard);
    overflow: hidden;
    margin-bottom: 32px;
    border: 1px solid rgba(148, 163, 184, 0.1);
    backdrop-filter: blur(20px);
}

.md-card:hover {
    box-shadow: var(--md-elevation-4);
    transform: translateY(-4px);
}

.md-card-header {
    background: linear-gradient(135deg, var(--md-primary) 0%, var(--md-primary-variant) 50%, #7c3aed 100%);
    color: var(--md-on-primary);
    padding: 32px;
    position: relative;
    overflow: hidden;
}

.md-card-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
    animation: material-float 10s ease-in-out infinite;
}

@keyframes material-float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-30px) rotate(180deg); }
}

.md-card-header h1 {
    font-size: 3rem;
    font-weight: 700;
    margin: 0 0 12px 0;
    position: relative;
    z-index: 1;
    background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.md-card-header p {
    font-size: 1.25rem;
    opacity: 0.95;
    margin: 0;
    position: relative;
    z-index: 1;
    font-weight: 400;
}

.md-card-content {
    padding: 40px;
}

/* Modern Material Design Form Fields */
.md-form-field {
    margin-bottom: 28px;
    position: relative;
}

.md-form-field label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--md-on-surface);
    margin-bottom: 10px;
    transition: color var(--md-transition-standard);
    letter-spacing: 0.025em;
}

.md-form-field input,
.md-form-field select,
.md-form-field textarea {
    width: 100%;
    padding: 18px 20px;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    font-size: 1rem;
    background: var(--md-surface);
    color: var(--md-on-surface);
    transition: all var(--md-transition-standard);
    box-sizing: border-box;
    font-weight: 500;
}

.md-form-field input:focus,
.md-form-field select:focus,
.md-form-field textarea:focus {
    outline: none;
    border-color: var(--md-primary);
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1), var(--md-elevation-2);
    transform: translateY(-2px);
}

.md-form-field input:hover,
.md-form-field select:hover,
.md-form-field textarea:hover {
    border-color: #cbd5e1;
    box-shadow: var(--md-elevation-2);
}

/* Modern Material Design Select Styling */
.md-form-field select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 20px center;
    background-repeat: no-repeat;
    background-size: 20px;
    padding-right: 56px;
}

/* Modern Material Design Grid */
.md-grid {
    display: grid;
    gap: 28px;
}

.md-grid-2 {
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
}

.md-grid-3 {
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
}

/* Modern Material Design Buttons */
.md-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 16px 32px;
    border: none;
    border-radius: 16px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all var(--md-transition-standard);
    position: relative;
    overflow: hidden;
    min-height: 56px;
    letter-spacing: 0.025em;
}

.md-button::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.md-button:hover::before {
    width: 400px;
    height: 400px;
}

.md-button-primary {
    background: linear-gradient(135deg, var(--md-primary) 0%, var(--md-primary-variant) 100%);
    color: var(--md-on-primary);
    box-shadow: var(--md-elevation-2);
}

.md-button-primary:hover {
    background: linear-gradient(135deg, var(--md-primary-variant) 0%, #4338ca 100%);
    box-shadow: var(--md-elevation-5);
    transform: translateY(-3px);
}

.md-button-secondary {
    background: var(--md-surface);
    color: var(--md-primary);
    border: 2px solid var(--md-primary);
    box-shadow: var(--md-elevation-1);
}

.md-button-secondary:hover {
    background: var(--md-primary);
    color: var(--md-on-primary);
    box-shadow: var(--md-elevation-4);
    transform: translateY(-3px);
}

.md-button-icon {
    margin-right: 10px;
    width: 22px;
    height: 22px;
}

/* Modern Material Design Rich Text Editor */
.md-rich-text-editor {
    border: 2px solid #e2e8f0;
    border-radius: 20px;
    overflow: hidden;
    transition: all var(--md-transition-standard);
    box-shadow: var(--md-elevation-1);
}

.md-rich-text-editor:focus-within {
    border-color: var(--md-primary);
    box-shadow: var(--md-elevation-4);
    transform: translateY(-3px);
}

.md-rich-text-toolbar {
    background: linear-gradient(135deg, var(--md-surface-variant) 0%, #f1f5f9 100%);
    border-bottom: 1px solid #e2e8f0;
    padding: 16px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.md-rich-text-button {
    padding: 10px 14px;
    border: none;
    border-radius: 12px;
    background: transparent;
    color: var(--md-on-surface);
    cursor: pointer;
    transition: all var(--md-transition-standard);
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 44px;
    height: 44px;
}

.md-rich-text-button:hover {
    background: rgba(99, 102, 241, 0.1);
    color: var(--md-primary);
    transform: scale(1.05);
}

.md-rich-text-button:active {
    transform: scale(0.95);
}

.md-rich-text-button svg {
    width: 20px;
    height: 20px;
}

.md-rich-text-content {
    min-height: 140px;
    padding: 20px;
    background: var(--md-surface);
    color: var(--md-on-surface);
    outline: none;
    font-size: 1rem;
    line-height: 1.7;
}

.md-rich-text-content:empty::before {
    content: attr(data-placeholder);
    color: #9ca3af;
    font-style: italic;
}

/* Modern Material Design File Input */
.md-file-input {
    position: relative;
    display: inline-block;
    width: 100%;
}

.md-file-input input[type="file"] {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.md-file-display {
    border: 2px dashed #cbd5e1;
    border-radius: 20px;
    padding: 40px;
    text-align: center;
    background: linear-gradient(135deg, var(--md-surface-variant) 0%, #f1f5f9 100%);
    transition: all var(--md-transition-standard);
    cursor: pointer;
}

.md-file-display:hover {
    border-color: var(--md-primary);
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(99, 102, 241, 0.1) 100%);
    transform: translateY(-3px);
    box-shadow: var(--md-elevation-3);
}

.md-file-icon {
    width: 56px;
    height: 56px;
    margin: 0 auto 20px;
    color: #9ca3af;
}

/* Modern Material Design Tags */
.md-tag {
    display: inline-flex;
    align-items: center;
    padding: 10px 18px;
    margin: 6px;
    background: linear-gradient(135deg, var(--md-secondary) 0%, var(--md-secondary-variant) 100%);
    color: var(--md-on-secondary);
    border-radius: 24px;
    font-size: 0.875rem;
    font-weight: 600;
    box-shadow: var(--md-elevation-2);
    transition: all var(--md-transition-standard);
    animation: tag-appear 0.4s ease-out;
}

@keyframes tag-appear {
    from {
        opacity: 0;
        transform: scale(0.8) translateY(15px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.md-tag:hover {
    transform: translateY(-3px);
    box-shadow: var(--md-elevation-4);
}

.md-tag-remove {
    margin-left: 10px;
    padding: 6px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    cursor: pointer;
    transition: all var(--md-transition-standard);
}

.md-tag-remove:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

/* Modern Material Design History Items */
.md-history-item {
    display: flex;
    gap: 18px;
    padding: 20px;
    margin-bottom: 18px;
    background: linear-gradient(135deg, var(--md-surface-variant) 0%, #f1f5f9 100%);
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    transition: all var(--md-transition-standard);
    animation: history-appear 0.5s ease-out;
}

@keyframes history-appear {
    from {
        opacity: 0;
        transform: translateX(-25px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.md-history-item:hover {
    box-shadow: var(--md-elevation-3);
    transform: translateY(-3px);
}

.md-history-item input {
    flex: 1;
    padding: 14px;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.875rem;
}

.md-history-remove {
    padding: 10px;
    border: none;
    border-radius: 12px;
    background: #fef2f2;
    color: #dc2626;
    cursor: pointer;
    transition: all var(--md-transition-standard);
}

.md-history-remove:hover {
    background: #fee2e2;
    transform: scale(1.05);
}

/* Modern Material Design Error Messages */
.md-error {
    color: var(--md-error);
    font-size: 0.875rem;
    margin-top: 10px;
    padding: 12px 16px;
    background: #fef2f2;
    border-radius: 12px;
    border-left: 4px solid var(--md-error);
    animation: error-shake 0.6s ease-in-out;
    font-weight: 500;
}

@keyframes error-shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-6px); }
    75% { transform: translateX(6px); }
}

/* Modern Material Design Math Equation */
.md-math-equation {
    display: inline-block;
    padding: 10px 18px;
    margin: 6px;
    background: linear-gradient(135deg, var(--md-surface-variant) 0%, #f1f5f9 100%);
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    font-family: 'JetBrains Mono', 'Courier New', monospace;
    font-size: 0.875rem;
    transition: all var(--md-transition-standard);
}

.md-math-equation:hover {
    background: linear-gradient(135deg, var(--md-primary) 0%, var(--md-primary-variant) 100%);
    color: var(--md-on-primary);
    transform: translateY(-3px);
    box-shadow: var(--md-elevation-3);
}

/* Modern Material Design Responsive */
@media (max-width: 768px) {
    .md-container {
        padding: 20px;
    }
    
    .md-card-header {
        padding: 24px;
    }
    
    .md-card-header h1 {
        font-size: 2.5rem;
    }
    
    .md-card-content {
        padding: 28px;
    }
    
    .md-grid-2,
    .md-grid-3 {
        grid-template-columns: 1fr;
    }
    
    .md-button {
        width: 100%;
        margin-bottom: 10px;
    }
}

/* Modern Material Design Animations */
.md-fade-in {
    animation: fade-in 0.8s ease-out;
}

.md-slide-up {
    animation: slide-up 0.8s ease-out;
}

@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slide-up {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Modern Material Design Focus States */
.md-focus-ring:focus {
    outline: none;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

/* Modern Material Design Loading States */
.md-loading {
    position: relative;
    overflow: hidden;
}

.md-loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.1), transparent);
    animation: loading 1.8s infinite;
}

@keyframes loading {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Modern Material Design Hover Effects */
.md-hover-lift {
    transition: var(--md-transition-standard);
}

.md-hover-lift:hover {
    transform: translateY(-4px);
    box-shadow: var(--md-elevation-5);
}

/* Modern Material Design Enhanced Animations */
.md-ripple {
    position: relative;
    overflow: hidden;
}

.md-ripple::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.md-ripple:hover::before {
    width: 400px;
    height: 400px;
}

/* Modern Material Design Enhanced Form Fields */
.md-form-field input:focus,
.md-form-field select:focus,
.md-form-field textarea:focus {
    outline: none;
    border-color: var(--md-primary);
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1), var(--md-elevation-3);
    transform: translateY(-3px);
}

/* Modern Material Design Enhanced Cards */
.md-card {
    background: var(--md-surface);
    border-radius: 24px;
    box-shadow: var(--md-elevation-1);
    transition: all var(--md-transition-standard);
    overflow: hidden;
    margin-bottom: 32px;
    border: 1px solid rgba(148, 163, 184, 0.1);
    backdrop-filter: blur(20px);
}

.md-card:hover {
    box-shadow: var(--md-elevation-4);
    transform: translateY(-4px);
}
</style>

<div class="md-container md-fade-in">
    <!-- Material Design Header Card -->
    <div class="md-card">
        <div class="md-card-header">
            <h1>Create MCQ Question</h1>
            <p>Design engaging multiple choice questions with rich content</p>
        </div>
        <div class="md-card-content">
            <div class="md-grid md-grid-2">
                <div>
                    <a href="{{ route('partner.questions.mcq.index') }}" 
                       class="md-button md-button-secondary md-hover-lift md-ripple">
                        <svg class="md-button-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Questions
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Material Design Form Card -->
    <div class="md-card md-slide-up">
        <div class="md-card-header">
            <h2 style="font-size: 1.5rem; margin: 0;">Question Details</h2>
        </div>

        <form action="{{ route('partner.questions.mcq.store') }}" method="POST" enctype="multipart/form-data" class="md-card-content">
            @csrf
            
            <!-- Course, Subject, Topic Selection -->
            <div class="md-grid md-grid-3">
                <div class="md-form-field">
                    <label for="course_id">Course *</label>
                    <select name="course_id" id="course_id" required class="md-focus-ring">
                        <option value="">Select Course</option>
                        @foreach($courses ?? [] as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <div class="md-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="md-form-field">
                    <label for="subject_id">Subject *</label>
                    <select name="subject_id" id="subject_id" required class="md-focus-ring">
                        <option value="">Select Subject</option>
                        @foreach($subjects ?? [] as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <div class="md-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="md-form-field">
                    <label for="topic_id">Topic *</label>
                    <select name="topic_id" id="topic_id" required class="md-focus-ring">
                        <option value="">Select Topic</option>
                        @foreach($topics ?? [] as $topic)
                            <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                                {{ $topic->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('topic_id')
                        <div class="md-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Question Text and MCQ Options -->
            <div class="md-grid md-grid-2" style="gap: 32px;">
                <!-- Question Text -->
                <div>
                    <div class="md-form-field">
                        <label for="question_text">Question Text *</label>
                        <div class="md-rich-text-editor">
                            <!-- Rich Text Toolbar -->
                            <div class="md-rich-text-toolbar">
                                <button type="button" class="md-rich-text-button" data-command="bold" title="Bold">
                                    <svg fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M15.6 11.79c.97-.67 1.65-1.77 1.65-2.79 0-2.26-1.75-4-4-4H7v14h7.04c2.09 0 3.71-1.7 3.71-3.79 0-1.52-.86-2.82-2.15-3.42zM10 7.5h3c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-3v-3zm3.5 9H10v-3h3.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5z"/>
                                    </svg>
                                </button>
                                <button type="button" class="md-rich-text-button" data-command="italic" title="Italic">
                                    <svg fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M10 4v3h2.21l-3.42 8H6v3h8v-3h-2.21l3.42-8H18V4z"/>
                                    </svg>
                                </button>
                                <button type="button" class="md-rich-text-button" data-command="underline" title="Underline">
                                    <svg fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 17c3.31 0 6-2.69 6-6V3h-2.5v8c0 1.93-1.57 3.5-3.5 3.5S8.5 12.93 8.5 11V3H6v8c0 3.31 2.69 6 6 6zm-7 2v2h14v-2H5z"/>
                                    </svg>
                                </button>
                                <div style="width: 1px; height: 24px; background: #e0e0e0; margin: 0 8px;"></div>
                                <button type="button" class="md-rich-text-button" data-command="insertUnorderedList" title="Bullet List">
                                    <svg fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/>
                                    </svg>
                                </button>
                                <button type="button" class="md-rich-text-button" data-command="insertOrderedList" title="Numbered List">
                                    <svg fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M2 17h2v.5H2v-1zm0-6h2v.5H2v-1zm0 3h2v.5H2v-1zm4-3h14v-2H6v2zm0 4h14v-2H6v2zM6 7v2h14V7H6z"/>
                                    </svg>
                                </button>
                                <div style="width: 1px; height: 24px; background: #e0e0e0; margin: 0 8px;"></div>
                                <button type="button" class="md-rich-text-button" data-command="justifyLeft" title="Align Left">
                                    <svg fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M15 15H3v2h12v-2zm0-8H3v2h12V7zm0 4H3v2h12v-2z"/>
                                    </svg>
                                </button>
                                <button type="button" class="md-rich-text-button" data-command="justifyCenter" title="Align Center">
                                    <svg fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 15h10v-2H7v2zm0-8h10V5H7v2zm0 4h10v-2H7v2z"/>
                                    </svg>
                                </button>
                                <button type="button" class="md-rich-text-button" data-command="justifyRight" title="Align Right">
                                    <svg fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 15h10v-2H9v2zm0-8h10V5H9v2zm0 4h10v-2H9v2z"/>
                                    </svg>
                                </button>
                                <div style="width: 1px; height: 24px; background: #e0e0e0; margin: 0 8px;"></div>
                                <button type="button" class="md-rich-text-button" id="mathBtn" title="Insert Math Equation">
                                    <span style="font-size: 18px; font-weight: bold;">∑</span>
                                </button>
                            </div>
                            <!-- Rich Text Content -->
                            <div id="question_text_editor" class="md-rich-text-content" contenteditable="true" data-placeholder="Enter your question here..."></div>
                            <input type="hidden" name="question_text" id="question_text" required>
                        </div>
                        @error('question_text')
                            <div class="md-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Question Image -->
                    <div class="md-form-field">
                        <label for="image">Question Image (Optional)</label>
                        <div class="md-file-input">
                            <input type="file" name="image" id="image" accept="image/*">
                            <div class="md-file-display">
                                <svg class="md-file-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p style="margin: 0 0 8px 0; color: var(--md-on-surface);">Click to upload or drag and drop</p>
                                <p style="margin: 0; font-size: 0.875rem; color: #9ca3af;">JPEG, PNG, JPG, GIF (Max: 2MB)</p>
                            </div>
                        </div>
                        @error('image')
                            <div class="md-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- MCQ Options -->
                <div>
                    <div class="md-grid md-grid-2" style="gap: 16px;">
                        <div class="md-form-field">
                            <label for="option_a">Option A *</label>
                            <input type="text" name="option_a" id="option_a" required 
                                   class="md-focus-ring"
                                   value="{{ old('option_a') }}" placeholder="Enter option A">
                            @error('option_a')
                                <div class="md-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="md-form-field">
                            <label for="option_b">Option B *</label>
                            <input type="text" name="option_b" id="option_b" required 
                                   class="md-focus-ring"
                                   value="{{ old('option_b') }}" placeholder="Enter option B">
                            @error('option_b')
                                <div class="md-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="md-grid md-grid-2" style="gap: 16px;">
                        <div class="md-form-field">
                            <label for="option_c">Option C *</label>
                            <input type="text" name="option_c" id="option_c" required 
                                   class="md-focus-ring"
                                   value="{{ old('option_c') }}" placeholder="Enter option C">
                            @error('option_c')
                                <div class="md-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="md-form-field">
                            <label for="option_d">Option D *</label>
                            <input type="text" name="option_d" id="option_d" required 
                                   class="md-focus-ring"
                                   value="{{ old('option_d') }}" placeholder="Enter option D">
                            @error('option_d')
                                <div class="md-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="md-grid md-grid-2" style="gap: 16px; margin-top: 16px;">
                        <div class="md-form-field">
                            <label for="correct_answer">Correct Answer *</label>
                            <select name="correct_answer" id="correct_answer" required class="md-focus-ring">
                                <option value="">Select</option>
                                <option value="a" {{ old('correct_answer') == 'a' ? 'selected' : '' }}>A</option>
                                <option value="b" {{ old('correct_answer') == 'b' ? 'selected' : '' }}>B</option>
                                <option value="c" {{ old('correct_answer') == 'c' ? 'selected' : '' }}>C</option>
                                <option value="d" {{ old('correct_answer') == 'd' ? 'selected' : '' }}>D</option>
                            </select>
                            @error('correct_answer')
                                <div class="md-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="md-form-field">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="md-focus-ring">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="md-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Explanation and Marks -->
            <div class="md-grid md-grid-2" style="gap: 32px; margin-top: 24px;">
                <div class="md-form-field">
                    <label for="explanation">Explanation</label>
                    <textarea name="explanation" id="explanation" rows="4" 
                               class="md-focus-ring"
                               placeholder="Explain why this answer is correct...">{{ old('explanation') }}</textarea>
                    @error('explanation')
                        <div class="md-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="md-form-field">
                    <label for="marks">Marks *</label>
                    <input type="number" name="marks" id="marks" required min="1" max="100"
                           class="md-focus-ring"
                           value="{{ old('marks', 1) }}" placeholder="Enter marks">
                    @error('marks')
                        <div class="md-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- History and Tags -->
            <div class="md-grid md-grid-2" style="gap: 32px; margin-top: 24px;">
                <!-- Question Appearance History -->
                <div>
                    <label class="md-form-field" style="margin-bottom: 16px;">Question Appearance History</label>
                    <p style="margin: 0 0 16px 0; color: #6b7280; font-size: 0.875rem;">Add where and when this question has appeared before.</p>
                    
                    <div id="historyContainer" style="margin-bottom: 16px;">
                        <!-- History items will be added here -->
                    </div>
                    
                    <button type="button" onclick="addHistory()" 
                            class="md-button md-button-secondary md-hover-lift">
                        <svg class="md-button-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add History
                    </button>
                </div>

                <!-- Question Tags -->
                <div>
                    <label class="md-form-field" style="margin-bottom: 16px;">Question Tags</label>
                    <p style="margin: 0 0 16px 0; color: #6b7280; font-size: 0.875rem;">Add tags to make the question easily searchable.</p>
                    
                    <div id="tagsContainer" style="margin-bottom: 16px;">
                        <!-- Tags will be displayed here -->
                    </div>
                    
                    <div class="md-grid md-grid-2" style="gap: 12px;">
                        <input type="text" id="tagInput" placeholder="Enter tag (e.g., biology)" 
                               class="md-focus-ring" style="margin: 0;">
                        <button type="button" onclick="addTag()" 
                                class="md-button md-button-primary md-hover-lift">
                            Add Tag
                        </button>
                    </div>
                    
                    <!-- Hidden inputs -->
                    <input type="hidden" name="tags" id="tagsInput" value="{{ old('tags', '[]') }}">
                    <input type="hidden" name="appearance_history" id="historyInput" value="{{ old('appearance_history', '[]') }}">
                </div>
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 16px; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e0e0e0;">
                <a href="{{ route('partner.questions.mcq.index') }}" 
                   class="md-button md-button-secondary md-hover-lift">
                    Cancel
                </a>
                <button type="submit" 
                        class="md-button md-button-primary md-hover-lift">
                    Create Question
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rich Text Editor functionality
    const editor = document.getElementById('question_text_editor');
    const hiddenInput = document.getElementById('question_text');
    const mathBtn = document.getElementById('mathBtn');
    
    // Set initial content if there's old input
    if (hiddenInput.value) {
        editor.innerHTML = hiddenInput.value;
    }
    
    // Update hidden input when editor content changes
    editor.addEventListener('input', function() {
        hiddenInput.value = this.innerHTML;
    });
    
    // Handle toolbar button clicks
    document.querySelectorAll('.md-rich-text-button').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const command = this.dataset.command;
            
            if (command) {
                document.execCommand(command, false, null);
                editor.focus();
            }
        });
    });
    
    // Math equation button
    mathBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const equation = prompt('Enter LaTeX equation (e.g., x^2 + y^2 = r^2):');
        if (equation) {
            const mathSpan = document.createElement('span');
            mathSpan.className = 'md-math-equation';
            mathSpan.innerHTML = `\\(${equation}\\)`;
            mathSpan.contentEditable = false;
            
            // Insert at cursor position
            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                range.insertNode(mathSpan);
                range.collapse(false);
            } else {
                editor.appendChild(mathSpan);
            }
            
            // Update hidden input
            hiddenInput.value = editor.innerHTML;
            editor.focus();
        }
    });
    
    // Placeholder functionality
    editor.addEventListener('focus', function() {
        if (this.innerHTML === '' || this.innerHTML === this.dataset.placeholder) {
            this.innerHTML = '';
        }
    });
    
    editor.addEventListener('blur', function() {
        if (this.innerHTML === '') {
            this.innerHTML = this.dataset.placeholder;
        }
    });
    
    // Initialize placeholder if empty
    if (editor.innerHTML === '') {
        editor.innerHTML = editor.dataset.placeholder;
    }

    // Question Appearance History functionality
    let historyCounter = 0;
    
    window.addHistory = function() {
        const container = document.getElementById('historyContainer');
        const historyId = 'history_' + historyCounter++;
        
        const historyDiv = document.createElement('div');
        historyDiv.id = historyId;
        historyDiv.className = 'md-history-item';
        historyDiv.innerHTML = `
            <div class="md-form-field" style="margin-bottom: 0;">
                <input type="text" name="history_exam[${historyId}]" placeholder="Exam/Test name" 
                       class="md-focus-ring" style="background: var(--md-surface); border-color: #e0e0e0; box-shadow: var(--md-elevation-1); padding: 12px;">
            </div>
            <div class="md-form-field" style="margin-bottom: 0;">
                <input type="number" name="history_year[${historyId}]" placeholder="Year (e.g., 2024)" 
                       min="1900" max="2100" step="1"
                       class="md-focus-ring" style="background: var(--md-surface); border-color: #e0e0e0; box-shadow: var(--md-elevation-1); padding: 12px;">
            </div>
            <button type="button" onclick="removeHistory('${historyId}')" 
                    class="md-history-remove">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        `;
        
        container.appendChild(historyDiv);
        updateHistoryInput();
    };
    
    window.removeHistory = function(historyId) {
        const element = document.getElementById(historyId);
        if (element) {
            element.remove();
            updateHistoryInput();
        }
    };
    
    function updateHistoryInput() {
        const historyInput = document.getElementById('historyInput');
        const historyItems = document.querySelectorAll('[id^="history_"]');
        const historyData = [];
        
        historyItems.forEach(item => {
            const examInput = item.querySelector('input[name^="history_exam"]');
            const yearInput = item.querySelector('input[name^="history_year"]');
            
            if (examInput && yearInput) {
                historyData.push({
                    exam: examInput.value,
                    year: yearInput.value
                });
            }
        });
        
        historyInput.value = JSON.stringify(historyData);
    }
    
    // Question Tags functionality
    let tags = [];
    
    window.addTag = function() {
        const tagInput = document.getElementById('tagInput');
        const tagText = tagInput.value.trim();
        
        if (tagText) {
            // Split by comma and process each tag
            const tagArray = tagText.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
            
            tagArray.forEach(tag => {
                if (tag && !tags.includes(tag)) {
                    tags.push(tag);
                }
            });
            
            displayTags();
            updateTagsInput();
            tagInput.value = '';
        }
    };
    
    window.removeTag = function(tagToRemove) {
        tags = tags.filter(tag => tag !== tagToRemove);
        displayTags();
        updateTagsInput();
    };
    
    function displayTags() {
        const container = document.getElementById('tagsContainer');
        container.innerHTML = '';
        
        tags.forEach(tag => {
            const tagElement = document.createElement('span');
            tagElement.className = 'md-tag';
            tagElement.innerHTML = `
                #${tag}
                <button type="button" onclick="removeTag('${tag}')" class="md-tag-remove">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            container.appendChild(tagElement);
        });
    }
    
    function updateTagsInput() {
        const tagsInput = document.getElementById('tagsInput');
        tagsInput.value = JSON.stringify(tags);
    }
    
    // Initialize tags from old input if available
    const oldTags = document.getElementById('tagsInput').value;
    if (oldTags && oldTags !== '[]') {
        try {
            tags = JSON.parse(oldTags);
            displayTags();
        } catch (e) {
            console.error('Error parsing old tags:', e);
        }
    }
    
    // Initialize history from old input if available
    const oldHistory = document.getElementById('historyInput').value;
    if (oldHistory && oldHistory !== '[]') {
        try {
            const historyData = JSON.parse(oldHistory);
            historyData.forEach(item => {
                // Recreate history items from old data
                const container = document.getElementById('historyContainer');
                const historyId = 'history_' + historyCounter++;
                
                const historyDiv = document.createElement('div');
                historyDiv.id = historyId;
                historyDiv.className = 'md-history-item';
                historyDiv.innerHTML = `
                    <div class="md-form-field" style="margin-bottom: 0;">
                        <input type="text" name="history_exam[${historyId}]" placeholder="Exam/Test name" 
                               value="${item.exam || ''}"
                               class="md-focus-ring" style="background: var(--md-surface); border-color: #e0e0e0; box-shadow: var(--md-elevation-1); padding: 12px;">
                    </div>
                    <div class="md-form-field" style="margin-bottom: 0;">
                        <input type="number" name="history_year[${historyId}]" placeholder="Year (e.g., 2024)" 
                               value="${item.year || ''}"
                               class="md-focus-ring" style="background: var(--md-surface); border-color: #e0e0e0; box-shadow: var(--md-elevation-1); padding: 12px;">
                    </div>
                    <button type="button" onclick="removeHistory('${historyId}')" 
                            class="md-history-remove">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                `;
                
                container.appendChild(historyDiv);
            });
        } catch (e) {
            console.error('Error parsing old history:', e);
        }
    }
    
    // Add event listeners for real-time updates
    document.addEventListener('input', function(e) {
        if (e.target.name && e.target.name.startsWith('history_')) {
            updateHistoryInput();
        }
    });
    
    // Add enter key support for tag input
    document.getElementById('tagInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addTag();
        }
    });
    
    // Add comma support for automatic tag completion
    document.getElementById('tagInput').addEventListener('input', function(e) {
        if (e.target.value.includes(',')) {
            addTag();
        }
    });



    const courseSelect = document.getElementById('course_id');
    const subjectSelect = document.getElementById('subject_id');
    const topicSelect = document.getElementById('topic_id');

    // Course change handler
    courseSelect.addEventListener('change', function() {
        const courseId = this.value;
        if (courseId) {
            // Fetch subjects for selected course
            fetch(`/partner/questions/subjects?course_id=${courseId}`)
                .then(response => response.json())
                .then(data => {
                    subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                    topicSelect.innerHTML = '<option value="">Select Topic</option>';
                    
                    data.forEach(subject => {
                        const option = document.createElement('option');
                        option.value = subject.id;
                        option.textContent = subject.name;
                        subjectSelect.appendChild(option);
                    });
                });
        } else {
            subjectSelect.innerHTML = '<option value="">Select Subject</option>';
            topicSelect.innerHTML = '<option value="">Select Topic</option>';
        }
    });

    // Subject change handler
    subjectSelect.addEventListener('change', function() {
        const subjectId = this.value;
        if (subjectId) {
            // Fetch topics for selected subject
            fetch(`/partner/questions/topics?subject_id=${subjectId}`)
                .then(response => response.json())
                .then(data => {
                    topicSelect.innerHTML = '<option value="">Select Topic</option>';
                    
                    data.forEach(topic => {
                        const option = document.createElement('option');
                        option.value = topic.id;
                        option.textContent = topic.name;
                        topicSelect.appendChild(option);
                    });
                });
        } else {
            topicSelect.innerHTML = '<option value="">Select Topic</option>';
        }
    });
});
</script>
@endsection