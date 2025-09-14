@extends('layouts.partner-layout')

@section('title', 'Edit Result - ' . $exam->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="space-y-6 p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <a href="{{ route('partner.exams.results', $exam) }}" 
                       class="inline-flex items-center px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-xl transition-all duration-200 hover:shadow-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Results
                    </a>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent dark:from-orange-400 dark:to-red-400">
                            Edit Result
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Edit manual result for {{ $result->student->full_name }} - {{ $exam->title }}</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="text-right">
                        <div class="text-sm text-gray-500 dark:text-gray-400">Total Questions</div>
                        <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $exam->questions->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

       

        <!-- Result Entry Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Student Information & Timing</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Edit student result and exam timing information</p>
            </div>
            
            <form id="detailedResultForm" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Student Information and Timing -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Student</label>
                        <div class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-100 dark:bg-gray-700 dark:text-white">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    @if($result->student->photo && file_exists(public_path('storage/' . $result->student->photo)))
                                        <img class="h-8 w-8 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600" 
                                             src="{{ asset('storage/' . $result->student->photo) }}" 
                                             alt="{{ $result->student->full_name }}">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center border-2 border-gray-200 dark:border-gray-600">
                                            <span class="text-xs font-bold text-white">
                                                {{ strtoupper(substr($result->student->full_name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $result->student->full_name)[1] ?? '', 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $result->student->full_name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $result->student->student_id }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="started_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Started At</label>
                        <input type="datetime-local" id="started_at" name="started_at" value="{{ $result->started_at ? $result->started_at->format('Y-m-d\TH:i') : '' }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label for="completed_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Completed At</label>
                        <input type="datetime-local" id="completed_at" name="completed_at" value="{{ $result->completed_at ? $result->completed_at->format('Y-m-d\TH:i') : '' }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <!-- Questions Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Question-wise Answer Entry</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Enter answers for each question in the exam</p>
                    </div>
                    
                    <div class="p-6">
                @if($exam->questions->count() > 0)
                    <div class="space-y-6">
                        @foreach($exam->questions as $index => $question)
                            @php
                                $answerData = $result->answers[(string)$question->id] ?? null;
                                $answer = $answerData['answer'] ?? '';
                                $answerUpper = trim(strtoupper($answer));
                            @endphp
                            <div class="border border-gray-200 dark:border-gray-600 rounded-xl p-3 sm:p-4 bg-gray-50 dark:bg-gray-700/50">
                                @if($question->question_type === 'mcq')
                                    <!-- MCQ Layout: Single Line with Question Number, Text, and Options -->
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                                        <!-- Question Number -->
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 rounded-full text-xs sm:text-sm font-bold bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg">
                                                {{ $index + 1 }}
                                            </span>
                                        </div>
                                        
                                        <!-- Question Text -->
                                        <div class="flex-1 min-w-0">
                                            <span class="text-sm sm:text-base text-gray-900 dark:text-white font-medium leading-tight">{{ $question->question_text }}</span>
                                        </div>
                                        
                                        <!-- Answer Options -->
                                        <div class="grid grid-cols-4 gap-2 sm:gap-3 flex-shrink-0 w-full max-w-2xl">
                                            @if($question->option_a)
                                                <div class="flex items-center gap-1 sm:gap-2 p-2 rounded-lg transition-all duration-200 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50
                                                    @if(strtoupper($question->correct_answer) === 'A' || $question->correct_answer === '1' || $question->correct_answer === 1)
                                                        bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 shadow-sm
                                                    @endif" onclick="selectAnswer('{{ $question->id }}', 'A')">
                                                    <label class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 border rounded cursor-pointer transition-all duration-200 relative group
                                                        @if(strtoupper($question->correct_answer) === 'A' || $question->correct_answer === '1' || $question->correct_answer === 1)
                                                            border-green-500 bg-green-100 dark:bg-green-800/30 hover:bg-green-200 dark:hover:bg-green-700/40 shadow-md
                                                        @else
                                                            border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 hover:border-gray-400 dark:hover:border-gray-500
                                                        @endif">
                                                        <input type="radio" name="answers[{{ $question->id }}]" value="A" class="sr-only" onchange="toggleAnswer(this)" {{ $answerUpper === 'A' ? 'checked' : '' }}>
                                                        <span class="font-bold text-xs sm:text-sm transition-all duration-200
                                                            @if(strtoupper($question->correct_answer) === 'A' || $question->correct_answer === '1' || $question->correct_answer === 1)
                                                                text-green-800 dark:text-green-200
                                                            @else
                                                                text-gray-900 dark:text-white group-hover:text-gray-700 dark:group-hover:text-gray-200
                                                            @endif">a</span>
                                                        <!-- Tick Mark -->
                                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-200 answer-tick">
                                                            <svg class="w-6 h-6" viewBox="0 0 512.001 512.001" xml:space="preserve">
                                                                <g>
                                                                    <rect x="348.315" y="290.037" style="fill:#F4B2B0;" width="87.23" height="66.389"></rect>
                                                                    <rect x="348.315" y="356.426" style="fill:#F4B2B0;" width="87.23" height="66.389"></rect>
                                                                </g>
                                                                <g>
                                                                    <path style="fill:#B3404A;" d="M435.543,275.647h-29.235v-21.065c0-7.943-6.44-14.382-14.382-14.382h-43.618 c-7.942,0-14.382,6.439-14.382,14.382c0,7.943,6.44,14.382,14.382,14.382h29.235v6.682h-29.235 c-7.942,0-14.382,6.439-14.382,14.382v66.395v66.395c0,7.943,6.44,14.382,14.382,14.382h29.235v12.959 c0,18.237-14.837,33.075-33.075,33.075H123.916c-18.238,0-33.075-14.837-33.075-33.075V268.965h193.923 c7.942,0,14.382-6.439,14.382-14.382c0-7.943-6.44-14.382-14.382-14.382H76.459c-7.942,0-14.382,6.439-14.382,14.382v195.579 c0,34.098,27.741,61.84,61.84,61.84h220.551c34.099,0,61.84-27.741,61.84-61.84v-12.959h29.235c7.942,0,14.382-6.439,14.382-14.382 v-66.395V290.03C449.925,282.086,443.485,275.647,435.543,275.647z M362.688,304.412h29.235h29.235v37.63h-58.47L362.688,304.412 L362.688,304.412z M421.16,408.436h-29.235H362.69v-37.63h58.47V408.436z"></path>
                                                                    <path style="fill:#B3404A;" d="M334.87,212.881c-7.942,0-14.382-6.439-14.382-14.382V115.06c0-47.583-38.712-86.295-86.295-86.295 s-86.295,38.712-86.295,86.295v83.438c0,7.943-6.44,14.382-14.382,14.382c-7.942,0-14.382-6.439-14.382-14.382V115.06 C119.133,51.616,170.749,0,234.193,0s115.06,51.616,115.06,115.06v83.438C349.252,206.442,342.812,212.881,334.87,212.881z"></path>
                                                                </g>
                                                                <path style="fill:#F4B2B0;" d="M223.584,369.825l-32.677-32.677l-33.222,33.222l32.677,32.677l20.895,20.895 c6.535,6.535,17.121,6.567,23.695,0.07l75.748-74.858l-33.222-33.222L223.584,369.825z"></path>
                                                                <path style="fill:#B3404A;" d="M223.14,443.246c-8.332,0-16.163-3.243-22.054-9.134l-53.572-53.572 c-2.697-2.697-4.213-6.356-4.213-10.17c0-3.814,1.516-7.473,4.213-10.17l33.222-33.222c2.698-2.697,6.356-4.213,10.17-4.213 c3.814,0,7.472,1.516,10.17,4.213l22.507,22.509l43.723-43.724c2.698-2.697,6.356-4.213,10.17-4.213 c3.814,0,7.472,1.516,10.17,4.213l33.222,33.222c2.708,2.708,4.224,6.383,4.213,10.213c-0.012,3.829-1.549,7.495-4.273,10.187 l-75.748,74.858C239.185,440.047,231.399,443.246,223.14,443.246z M178.025,370.37l43.402,43.402 c0.585,0.587,1.256,0.709,1.713,0.709c0.452,0,1.116-0.121,1.701-0.699l65.459-64.689l-12.822-12.822l-43.723,43.724 c-5.618,5.616-14.722,5.616-20.341,0l-22.507-22.509L178.025,370.37z"></path>
                                                            </svg>
                                                        </div>
                                                    </label>
                                                    <span class="text-xs sm:text-sm break-words font-medium
                                                        @if(strtoupper($question->correct_answer) === 'A' || $question->correct_answer === '1' || $question->correct_answer === 1)
                                                            text-green-800 dark:text-green-200
                                                        @else
                                                            text-gray-600 dark:text-gray-400
                                                        @endif">{{ $question->option_a }}</span>
                                                </div>
                                            @else
                                                <div></div>
                                            @endif
                                            @if($question->option_b)
                                                <div class="flex items-center gap-1 sm:gap-2 p-2 rounded-lg transition-all duration-200 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50
                                                    @if(strtoupper($question->correct_answer) === 'B' || $question->correct_answer === '2' || $question->correct_answer === 2)
                                                        bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 shadow-sm
                                                    @endif" onclick="selectAnswer('{{ $question->id }}', 'B')">
                                                    <label class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 border rounded cursor-pointer transition-all duration-200 relative group
                                                        @if(strtoupper($question->correct_answer) === 'B' || $question->correct_answer === '2' || $question->correct_answer === 2)
                                                            border-green-500 bg-green-100 dark:bg-green-800/30 hover:bg-green-200 dark:hover:bg-green-700/40 shadow-md
                                                        @else
                                                            border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 hover:border-gray-400 dark:hover:border-gray-500
                                                        @endif">
                                                        <input type="radio" name="answers[{{ $question->id }}]" value="B" class="sr-only" onchange="toggleAnswer(this)" {{ $answerUpper === 'B' ? 'checked' : '' }}>
                                                        <span class="font-bold text-xs sm:text-sm transition-all duration-200
                                                            @if(strtoupper($question->correct_answer) === 'B' || $question->correct_answer === '2' || $question->correct_answer === 2)
                                                                text-green-800 dark:text-green-200
                                                            @else
                                                                text-gray-900 dark:text-white group-hover:text-gray-700 dark:group-hover:text-gray-200
                                                            @endif">b</span>
                                                        <!-- Tick Mark -->
                                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-200 answer-tick">
                                                            <svg class="w-6 h-6" viewBox="0 0 512.001 512.001" xml:space="preserve">
                                                                <g>
                                                                    <rect x="348.315" y="290.037" style="fill:#F4B2B0;" width="87.23" height="66.389"></rect>
                                                                    <rect x="348.315" y="356.426" style="fill:#F4B2B0;" width="87.23" height="66.389"></rect>
                                                                </g>
                                                                <g>
                                                                    <path style="fill:#B3404A;" d="M435.543,275.647h-29.235v-21.065c0-7.943-6.44-14.382-14.382-14.382h-43.618 c-7.942,0-14.382,6.439-14.382,14.382c0,7.943,6.44,14.382,14.382,14.382h29.235v6.682h-29.235 c-7.942,0-14.382,6.439-14.382,14.382v66.395v66.395c0,7.943,6.44,14.382,14.382,14.382h29.235v12.959 c0,18.237-14.837,33.075-33.075,33.075H123.916c-18.238,0-33.075-14.837-33.075-33.075V268.965h193.923 c7.942,0,14.382-6.439,14.382-14.382c0-7.943-6.44-14.382-14.382-14.382H76.459c-7.942,0-14.382,6.439-14.382,14.382v195.579 c0,34.098,27.741,61.84,61.84,61.84h220.551c34.099,0,61.84-27.741,61.84-61.84v-12.959h29.235c7.942,0,14.382-6.439,14.382-14.382 v-66.395V290.03C449.925,282.086,443.485,275.647,435.543,275.647z M362.688,304.412h29.235h29.235v37.63h-58.47L362.688,304.412 L362.688,304.412z M421.16,408.436h-29.235H362.69v-37.63h58.47V408.436z"></path>
                                                                    <path style="fill:#B3404A;" d="M334.87,212.881c-7.942,0-14.382-6.439-14.382-14.382V115.06c0-47.583-38.712-86.295-86.295-86.295 s-86.295,38.712-86.295,86.295v83.438c0,7.943-6.44,14.382-14.382,14.382c-7.942,0-14.382-6.439-14.382-14.382V115.06 C119.133,51.616,170.749,0,234.193,0s115.06,51.616,115.06,115.06v83.438C349.252,206.442,342.812,212.881,334.87,212.881z"></path>
                                                                </g>
                                                                <path style="fill:#F4B2B0;" d="M223.584,369.825l-32.677-32.677l-33.222,33.222l32.677,32.677l20.895,20.895 c6.535,6.535,17.121,6.567,23.695,0.07l75.748-74.858l-33.222-33.222L223.584,369.825z"></path>
                                                                <path style="fill:#B3404A;" d="M223.14,443.246c-8.332,0-16.163-3.243-22.054-9.134l-53.572-53.572 c-2.697-2.697-4.213-6.356-4.213-10.17c0-3.814,1.516-7.473,4.213-10.17l33.222-33.222c2.698-2.697,6.356-4.213,10.17-4.213 c3.814,0,7.472,1.516,10.17,4.213l22.507,22.509l43.723-43.724c2.698-2.697,6.356-4.213,10.17-4.213 c3.814,0,7.472,1.516,10.17,4.213l33.222,33.222c2.708,2.708,4.224,6.383,4.213,10.213c-0.012,3.829-1.549,7.495-4.273,10.187 l-75.748,74.858C239.185,440.047,231.399,443.246,223.14,443.246z M178.025,370.37l43.402,43.402 c0.585,0.587,1.256,0.709,1.713,0.709c0.452,0,1.116-0.121,1.701-0.699l65.459-64.689l-12.822-12.822l-43.723,43.724 c-5.618,5.616-14.722,5.616-20.341,0l-22.507-22.509L178.025,370.37z"></path>
                                                            </svg>
                                                        </div>
                                                    </label>
                                                    <span class="text-xs sm:text-sm break-words font-medium
                                                        @if(strtoupper($question->correct_answer) === 'B' || $question->correct_answer === '2' || $question->correct_answer === 2)
                                                            text-green-800 dark:text-green-200
                                                        @else
                                                            text-gray-600 dark:text-gray-400
                                                        @endif">{{ $question->option_b }}</span>
                                                </div>
                                            @else
                                                <div></div>
                                            @endif
                                            @if($question->option_c)
                                                <div class="flex items-center gap-1 sm:gap-2 p-2 rounded-lg transition-all duration-200 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50
                                                    @if(strtoupper($question->correct_answer) === 'C' || $question->correct_answer === '3' || $question->correct_answer === 3)
                                                        bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 shadow-sm
                                                    @endif" onclick="selectAnswer('{{ $question->id }}', 'C')">
                                                    <label class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 border rounded cursor-pointer transition-all duration-200 relative group
                                                        @if(strtoupper($question->correct_answer) === 'C' || $question->correct_answer === '3' || $question->correct_answer === 3)
                                                            border-green-500 bg-green-100 dark:bg-green-800/30 hover:bg-green-200 dark:hover:bg-green-700/40 shadow-md
                                                        @else
                                                            border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 hover:border-gray-400 dark:hover:border-gray-500
                                                        @endif">
                                                        <input type="radio" name="answers[{{ $question->id }}]" value="C" class="sr-only" onchange="toggleAnswer(this)" {{ $answerUpper === 'C' ? 'checked' : '' }}>
                                                        <span class="font-bold text-xs sm:text-sm transition-all duration-200
                                                            @if(strtoupper($question->correct_answer) === 'C' || $question->correct_answer === '3' || $question->correct_answer === 3)
                                                                text-green-800 dark:text-green-200
                                                            @else
                                                                text-gray-900 dark:text-white group-hover:text-gray-700 dark:group-hover:text-gray-200
                                                            @endif">c</span>
                                                        <!-- Tick Mark -->
                                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-200 answer-tick">
                                                            <svg class="w-6 h-6" viewBox="0 0 512.001 512.001" xml:space="preserve">
                                                                <g>
                                                                    <rect x="348.315" y="290.037" style="fill:#F4B2B0;" width="87.23" height="66.389"></rect>
                                                                    <rect x="348.315" y="356.426" style="fill:#F4B2B0;" width="87.23" height="66.389"></rect>
                                                                </g>
                                                                <g>
                                                                    <path style="fill:#B3404A;" d="M435.543,275.647h-29.235v-21.065c0-7.943-6.44-14.382-14.382-14.382h-43.618 c-7.942,0-14.382,6.439-14.382,14.382c0,7.943,6.44,14.382,14.382,14.382h29.235v6.682h-29.235 c-7.942,0-14.382,6.439-14.382,14.382v66.395v66.395c0,7.943,6.44,14.382,14.382,14.382h29.235v12.959 c0,18.237-14.837,33.075-33.075,33.075H123.916c-18.238,0-33.075-14.837-33.075-33.075V268.965h193.923 c7.942,0,14.382-6.439,14.382-14.382c0-7.943-6.44-14.382-14.382-14.382H76.459c-7.942,0-14.382,6.439-14.382,14.382v195.579 c0,34.098,27.741,61.84,61.84,61.84h220.551c34.099,0,61.84-27.741,61.84-61.84v-12.959h29.235c7.942,0,14.382-6.439,14.382-14.382 v-66.395V290.03C449.925,282.086,443.485,275.647,435.543,275.647z M362.688,304.412h29.235h29.235v37.63h-58.47L362.688,304.412 L362.688,304.412z M421.16,408.436h-29.235H362.69v-37.63h58.47V408.436z"></path>
                                                                    <path style="fill:#B3404A;" d="M334.87,212.881c-7.942,0-14.382-6.439-14.382-14.382V115.06c0-47.583-38.712-86.295-86.295-86.295 s-86.295,38.712-86.295,86.295v83.438c0,7.943-6.44,14.382-14.382,14.382c-7.942,0-14.382-6.439-14.382-14.382V115.06 C119.133,51.616,170.749,0,234.193,0s115.06,51.616,115.06,115.06v83.438C349.252,206.442,342.812,212.881,334.87,212.881z"></path>
                                                                </g>
                                                                <path style="fill:#F4B2B0;" d="M223.584,369.825l-32.677-32.677l-33.222,33.222l32.677,32.677l20.895,20.895 c6.535,6.535,17.121,6.567,23.695,0.07l75.748-74.858l-33.222-33.222L223.584,369.825z"></path>
                                                                <path style="fill:#B3404A;" d="M223.14,443.246c-8.332,0-16.163-3.243-22.054-9.134l-53.572-53.572 c-2.697-2.697-4.213-6.356-4.213-10.17c0-3.814,1.516-7.473,4.213-10.17l33.222-33.222c2.698-2.697,6.356-4.213,10.17-4.213 c3.814,0,7.472,1.516,10.17,4.213l22.507,22.509l43.723-43.724c2.698-2.697,6.356-4.213,10.17-4.213 c3.814,0,7.472,1.516,10.17,4.213l33.222,33.222c2.708,2.708,4.224,6.383,4.213,10.213c-0.012,3.829-1.549,7.495-4.273,10.187 l-75.748,74.858C239.185,440.047,231.399,443.246,223.14,443.246z M178.025,370.37l43.402,43.402 c0.585,0.587,1.256,0.709,1.713,0.709c0.452,0,1.116-0.121,1.701-0.699l65.459-64.689l-12.822-12.822l-43.723,43.724 c-5.618,5.616-14.722,5.616-20.341,0l-22.507-22.509L178.025,370.37z"></path>
                                                            </svg>
                                                        </div>
                                                    </label>
                                                    <span class="text-xs sm:text-sm break-words font-medium
                                                        @if(strtoupper($question->correct_answer) === 'C' || $question->correct_answer === '3' || $question->correct_answer === 3)
                                                            text-green-800 dark:text-green-200
                                                        @else
                                                            text-gray-600 dark:text-gray-400
                                                        @endif">{{ $question->option_c }}</span>
                                                </div>
                                            @else
                                                <div></div>
                                            @endif
                                            @if($question->option_d)
                                                <div class="flex items-center gap-1 sm:gap-2 p-2 rounded-lg transition-all duration-200 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50
                                                    @if(strtoupper($question->correct_answer) === 'D' || $question->correct_answer === '4' || $question->correct_answer === 4)
                                                        bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 shadow-sm
                                                    @endif" onclick="selectAnswer('{{ $question->id }}', 'D')">
                                                    <label class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 border rounded cursor-pointer transition-all duration-200 relative group
                                                        @if(strtoupper($question->correct_answer) === 'D' || $question->correct_answer === '4' || $question->correct_answer === 4)
                                                            border-green-500 bg-green-100 dark:bg-green-800/30 hover:bg-green-200 dark:hover:bg-green-700/40 shadow-md
                                                        @else
                                                            border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 hover:border-gray-400 dark:hover:border-gray-500
                                                        @endif">
                                                        <input type="radio" name="answers[{{ $question->id }}]" value="D" class="sr-only" onchange="toggleAnswer(this)" {{ $answerUpper === 'D' ? 'checked' : '' }}>
                                                        <span class="font-bold text-xs sm:text-sm transition-all duration-200
                                                            @if(strtoupper($question->correct_answer) === 'D' || $question->correct_answer === '4' || $question->correct_answer === 4)
                                                                text-green-800 dark:text-green-200
                                                            @else
                                                                text-gray-900 dark:text-white group-hover:text-gray-700 dark:group-hover:text-gray-200
                                                            @endif">d</span>
                                                        <!-- Tick Mark -->
                                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-200 answer-tick">
                                                            <svg class="w-6 h-6" viewBox="0 0 512.001 512.001" xml:space="preserve">
                                                                <g>
                                                                    <rect x="348.315" y="290.037" style="fill:#F4B2B0;" width="87.23" height="66.389"></rect>
                                                                    <rect x="348.315" y="356.426" style="fill:#F4B2B0;" width="87.23" height="66.389"></rect>
                                                                </g>
                                                                <g>
                                                                    <path style="fill:#B3404A;" d="M435.543,275.647h-29.235v-21.065c0-7.943-6.44-14.382-14.382-14.382h-43.618 c-7.942,0-14.382,6.439-14.382,14.382c0,7.943,6.44,14.382,14.382,14.382h29.235v6.682h-29.235 c-7.942,0-14.382,6.439-14.382,14.382v66.395v66.395c0,7.943,6.44,14.382,14.382,14.382h29.235v12.959 c0,18.237-14.837,33.075-33.075,33.075H123.916c-18.238,0-33.075-14.837-33.075-33.075V268.965h193.923 c7.942,0,14.382-6.439,14.382-14.382c0-7.943-6.44-14.382-14.382-14.382H76.459c-7.942,0-14.382,6.439-14.382,14.382v195.579 c0,34.098,27.741,61.84,61.84,61.84h220.551c34.099,0,61.84-27.741,61.84-61.84v-12.959h29.235c7.942,0,14.382-6.439,14.382-14.382 v-66.395V290.03C449.925,282.086,443.485,275.647,435.543,275.647z M362.688,304.412h29.235h29.235v37.63h-58.47L362.688,304.412 L362.688,304.412z M421.16,408.436h-29.235H362.69v-37.63h58.47V408.436z"></path>
                                                                    <path style="fill:#B3404A;" d="M334.87,212.881c-7.942,0-14.382-6.439-14.382-14.382V115.06c0-47.583-38.712-86.295-86.295-86.295 s-86.295,38.712-86.295,86.295v83.438c0,7.943-6.44,14.382-14.382,14.382c-7.942,0-14.382-6.439-14.382-14.382V115.06 C119.133,51.616,170.749,0,234.193,0s115.06,51.616,115.06,115.06v83.438C349.252,206.442,342.812,212.881,334.87,212.881z"></path>
                                                                </g>
                                                                <path style="fill:#F4B2B0;" d="M223.584,369.825l-32.677-32.677l-33.222,33.222l32.677,32.677l20.895,20.895 c6.535,6.535,17.121,6.567,23.695,0.07l75.748-74.858l-33.222-33.222L223.584,369.825z"></path>
                                                                <path style="fill:#B3404A;" d="M223.14,443.246c-8.332,0-16.163-3.243-22.054-9.134l-53.572-53.572 c-2.697-2.697-4.213-6.356-4.213-10.17c0-3.814,1.516-7.473,4.213-10.17l33.222-33.222c2.698-2.697,6.356-4.213,10.17-4.213 c3.814,0,7.472,1.516,10.17,4.213l22.507,22.509l43.723-43.724c2.698-2.697,6.356-4.213,10.17-4.213 c3.814,0,7.472,1.516,10.17,4.213l33.222,33.222c2.708,2.708,4.224,6.383,4.213,10.213c-0.012,3.829-1.549,7.495-4.273,10.187 l-75.748,74.858C239.185,440.047,231.399,443.246,223.14,443.246z M178.025,370.37l43.402,43.402 c0.585,0.587,1.256,0.709,1.713,0.709c0.452,0,1.116-0.121,1.701-0.699l65.459-64.689l-12.822-12.822l-43.723,43.724 c-5.618,5.616-14.722,5.616-20.341,0l-22.507-22.509L178.025,370.37z"></path>
                                                            </svg>
                                                        </div>
                                                    </label>
                                                    <span class="text-xs sm:text-sm break-words font-medium
                                                        @if(strtoupper($question->correct_answer) === 'D' || $question->correct_answer === '4' || $question->correct_answer === 4)
                                                            text-green-800 dark:text-green-200
                                                        @else
                                                            text-gray-600 dark:text-gray-400
                                                        @endif">{{ $question->option_d }}</span>
                                                </div>
                                            @else
                                                <div></div>
                                            @endif
                                        </div>
                                        
                                    </div>
                                @else
                                    <!-- Constructed Question Layout: Single Line with Question Number, Text, and Answer Field -->
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                                        <!-- Question Number -->
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 rounded-full text-xs sm:text-sm font-bold bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg">
                                                {{ $index + 1 }}
                                            </span>
                                        </div>
                                        
                                        <!-- Question Text -->
                                        <div class="flex-1 min-w-0">
                                            <span class="text-sm sm:text-base text-gray-900 dark:text-white font-medium leading-tight">{{ $question->question_text }}</span>
                                        </div>
                                        
                                        <!-- Answer Field -->
                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Answer:</span>
                                            <textarea id="answer_{{ $question->id }}" 
                                                      name="answers[{{ $question->id }}]" 
                                                      rows="1" 
                                                      class="w-24 sm:w-32 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white resize-none text-xs sm:text-sm"
                                                      placeholder="Answer...">{{ $answer }}</textarea>
                                            @if($question->min_words)
                                                <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">Min {{ $question->min_words }}w</span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                @endif
                                
                            </div>
                        @endforeach
                    </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" onclick="resetForm()" class="px-6 py-3 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-xl transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                                Reset Form
                            </button>
                            <button type="submit" class="px-8 py-3 text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                Update Result
                            </button>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('detailedResultForm');
    const startedAtInput = document.getElementById('started_at');
    const completedAtInput = document.getElementById('completed_at');

    // Debug: Check if elements are found
    console.log('Form found:', !!form);
    
    // Initialize pre-checked answers to show visual tick marks
    initializePreCheckedAnswers();
    console.log('Started input found:', !!startedAtInput);
    console.log('Completed input found:', !!completedAtInput);

    // Note: Times are pre-populated from the existing result data

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Form submission started');
        
        // Basic validation
        const hasAnswers = Array.from(document.querySelectorAll('input[name^="answers"], textarea[name^="answers"]')).some(input => input.value.trim() !== '');
        if (!hasAnswers) {
            alert('Please provide at least one answer');
            return;
        }
        
        const formData = new FormData(form);
        
        // Debug: Log form data
        console.log('Form data being sent:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
        
        // Debug: Check if answers are being collected
        const answerInputs = document.querySelectorAll('input[name^="answers"], textarea[name^="answers"]');
        console.log('Answer inputs found:', answerInputs.length);
        answerInputs.forEach((input, index) => {
            console.log(`Answer ${index + 1}:`, input.name, '=', input.value);
        });
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Saving...';
        submitBtn.disabled = true;

        // Submit the form
        const updateUrl = '{{ route("partner.exams.result-update", ["exam" => $exam, "result" => $result]) }}';
        console.log('Update URL:', updateUrl);
        console.log('Exam ID:', {{ $exam->id }});
        console.log('Result ID:', {{ $result->id }});
        
        fetch(updateUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            if (!response.ok) {
                // Try to get error details from response
                return response.text().then(text => {
                    console.error('Server response:', text);
                    throw new Error(`HTTP error! status: ${response.status}. Response: ${text}`);
                });
            }
            
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            
            if (data.success) {
                // Show success message
                alert('Result saved successfully!');
                // Redirect to results page
                window.location.href = data.redirect_url;
            } else {
                console.error('Server error:', data);
                alert('Error: ' + (data.message || 'Failed to save result'));
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            console.error('Error details:', error.message);
            alert('Error saving result: ' + error.message + '. Please check console for details.');
        })
        .finally(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
    });

    // Auto-save functionality (optional)
    let autoSaveTimeout;
    function autoSave() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            // Auto-save logic can be implemented here
            console.log('Auto-saving...');
        }, 5000); // Auto-save after 5 seconds of inactivity
    }

    // Add auto-save listeners
    startedAtInput.addEventListener('change', autoSave);
    completedAtInput.addEventListener('change', autoSave);
    
    // Add auto-save for all answer inputs
    document.querySelectorAll('input[name^="answers"], textarea[name^="answers"]').forEach(input => {
        input.addEventListener('change', autoSave);
    });
});

// Function to select answer when clicking on option container
function selectAnswer(questionId, answerValue) {
    const radioInput = document.querySelector(`input[name="answers[${questionId}]"][value="${answerValue}"]`);
    if (radioInput) {
        radioInput.checked = true;
        toggleAnswer(radioInput);
    }
}

// Function to initialize pre-checked answers on page load
function initializePreCheckedAnswers() {
    const checkedRadios = document.querySelectorAll('input[type="radio"]:checked');
    checkedRadios.forEach(radio => {
        toggleAnswer(radio);
    });
}

// Function to toggle answer selection with tick mark
function toggleAnswer(radioInput) {
    const questionId = radioInput.name.match(/\[(\d+)\]/)[1];
    const allOptions = document.querySelectorAll(`input[name="answers[${questionId}]"]`);
    
    // Remove tick marks from all options in this question
    allOptions.forEach(option => {
        const label = option.closest('label');
        const tick = label.querySelector('.answer-tick');
        const letter = label.querySelector('span');
        
        if (tick) {
            tick.style.opacity = '0';
        }
        if (letter) {
            letter.style.opacity = '1';
        }
        
        // Reset styling
        label.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
        label.classList.add('border-gray-300', 'dark:border-gray-600');
    });
    
    // Add tick mark to selected option
    if (radioInput.checked) {
        const label = radioInput.closest('label');
        const tick = label.querySelector('.answer-tick');
        const letter = label.querySelector('span');
        
        if (tick) {
            tick.style.opacity = '1';
        }
        if (letter) {
            letter.style.opacity = '0';
        }
        
        // Add selection styling
        label.classList.add('ring-2', 'ring-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
        label.classList.remove('border-gray-300', 'dark:border-gray-600');
    }
}

function resetForm() {
    if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
        document.getElementById('detailedResultForm').reset();
        
        // Reset times to defaults
        const now = new Date();
        const startedTime = new Date(now.getTime() - (2 * 60 * 60 * 1000));
        document.getElementById('started_at').value = startedTime.toISOString().slice(0, 16);
        document.getElementById('completed_at').value = now.toISOString().slice(0, 16);
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl+S to save
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        document.getElementById('detailedResultForm').dispatchEvent(new Event('submit'));
    }
    
    // Ctrl+R to reset
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        resetForm();
    }
});
</script>
@endsection
