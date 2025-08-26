@extends('layouts.partner-layout')

@section('title', 'Create Question Set')

@push('styles')
<style>
    /* Custom checkbox animations and states */
    .q-checkbox:checked + div {
        animation: checkboxPop 0.2s ease-out;
    }
    
    @keyframes checkboxPop {
        0% { transform: scale(0.8); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    /* Hover effects for checkbox container */
    .group:hover .q-checkbox:not(:checked) + div {
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
    }
    
    /* Focus states */
    .q-checkbox:focus + div {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        outline: none;
    }
    
    /* Dark mode adjustments */
    .dark .group:hover .q-checkbox:not(:checked) + div {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }
    
    /* Row hover effects */
    tr:hover .group .q-checkbox:not(:checked) + div {
        border-color: #93c5fd;
    }
    
    .dark tr:hover .group .q-checkbox:not(:checked) + div {
        border-color: #60a5fa;
    }
    
    /* Selected row styling */
    .question-row.selected {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-left: 4px solid #3b82f6;
    }
    
    .dark .question-row.selected {
        background: linear-gradient(135deg, rgba(30, 58, 138, 0.1) 0%, rgba(30, 64, 175, 0.1) 100%);
        border-left: 4px solid #60a5fa;
    }
    
    /* Enhanced checkbox states */
    .q-checkbox:checked + div {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border-color: #2563eb;
    }
    
    .dark .q-checkbox:checked + div {
        background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
        border-color: #3b82f6;
    }
    
    /* Disabled state styling */
    .q-checkbox:disabled + div {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .q-checkbox:disabled + div + span {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Focus ring for accessibility */
    .q-checkbox:focus-visible + div {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        outline: 2px solid transparent;
    }
    
    /* Smooth transitions for all interactive elements */
    .question-row * {
        transition: all 0.2s ease-in-out;
    }
    
    /* Right-aligned checkbox column styling */
    .question-row td:last-child {
        border-left: 1px solid #e5e7eb;
    }
    
    .dark .question-row td:last-child {
        border-left: 1px solid #374151;
    }
    
    /* Enhanced visual separation for the checkbox column */
    .question-row td:last-child .group {
        padding: 0.25rem;
        border-radius: 0.375rem;
        transition: all 0.2s ease-in-out;
    }
    
    .question-row:hover td:last-child .group {
        background-color: rgba(59, 130, 246, 0.05);
    }
    
    .dark .question-row:hover td:last-child .group {
        background-color: rgba(59, 130, 246, 0.1);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto p-2">
          <div class="mb-6 rounded-xl overflow-hidden shadow-sm">
        <div class="bg-gradient-to-r from-primaryGreen via-emerald-600 to-sky-600 px-4 py-4 md:px-6 md:py-5 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-5 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h8" />
                    </svg>
                    <div>
                        <div class="text-lg md:text-xl font-semibold">Create Question Set</div>
                    </div>
                </div>
                                 <div class="flex items-center gap-2">
                     <!-- Action buttons moved to filters section -->
                 </div>
            </div>
        </div>
    </div>

    <form id="question-set-form" action="{{ route('partner.question-sets.store') }}" method="POST">
        @csrf

                 

        <!-- Step 2: Question Bank (Responsive) -->
        <div class="md:grid md:grid-cols-12 md:gap-6">
                 <div class="md:col-span-12 bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden mb-4">
             <!-- Enhanced Question Bank Header -->
             <div class="bg-gradient-to-r from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-800 dark:via-blue-900/20 dark:to-indigo-900/20 border-b border-slate-200 dark:border-slate-700">
                 <div class="px-6 py-4">
                     <div class="flex items-center justify-between">
                         <div class="flex items-center gap-3">
                             <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 shadow-lg">
                                 <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                 </svg>
                             </div>
                             <div>
                                 <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200">Question Bank</h2>
                                 <p class="text-sm text-slate-600 dark:text-slate-400">Browse and select questions for your question set</p>
                             </div>
                         </div>
                         <div class="flex items-center gap-3">
                             <button type="button" id="toggle-filters" class="md:hidden px-4 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-sm font-medium shadow-md transition-all duration-200 transform hover:scale-105">
                                 <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                                 </svg>
                                 Filters
                             </button>
                         </div>
                     </div>
                 </div>
             </div>
             
             <div class="px-6 pt-4 pb-6">
                         <div id="filters-form" class="hidden md:block mb-6">
                 <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 rounded-xl p-6 border border-blue-100 dark:border-gray-600 shadow-sm">
                                                                                                               <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Filter/Search & Select Questions</h4>
                            </div>
                            <div class="flex items-center gap-3">
                                <span id="selected-count-badge" class="px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-600 to-green-600 text-white text-sm font-bold shadow-lg border-0">Selected 0 / 0</span>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('partner.question-sets.index') }}" class="px-3 py-2 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                        Cancel
                                    </a>
                                    <button type="submit" id="save-draft-btn-top" class="px-3 py-2 text-xs font-medium text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/20 border border-blue-300 dark:border-blue-600 rounded-md hover:bg-blue-100 dark:hover:bg-blue-800/30 transition-colors duration-200">
                                        Save Draft
                                    </button>
                                    <button type="submit" id="publish-btn-top" class="px-3 py-2 text-xs font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 rounded-md shadow-sm transition-all duration-200 transform hover:scale-105">
                                        Publish
                                    </button>
                                </div>
                            </div>
                        </div>
                       
                       <!-- Question Set Information Fields -->
                       <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-4">
                           <div class="md:col-span-2">
                               <div class="flex items-center gap-2">
                                   <svg class="w-4 h-4" viewBox="0 0 24 24" aria-hidden="true">
                                       <defs>
                                           <linearGradient id="qsLangLeft" x1="0" y1="0" x2="1" y2="1">
                                               <stop offset="0%" stop-color="#2563eb"></stop>
                                               <stop offset="100%" stop-color="#60a5fa"></stop>
                                           </linearGradient>
                                           <linearGradient id="qsLangRight" x1="0" y1="0" x2="1" y2="1">
                                               <stop offset="0%" stop-color="#10b981"></stop>
                                               <stop offset="100%" stop-color="#34d399"></stop>
                                           </linearGradient>
                                       </defs>
                                       <rect x="2" y="3" width="10" height="14" rx="2" ry="2" fill="url(#qsLangLeft)"></rect>
                                       <rect x="12" y="7" width="10" height="14" rx="2" ry="2" fill="url(#qsLangRight)"></rect>
                                       <text x="7" y="10" font-size="8" font-weight="700" fill="#ffffff" text-anchor="middle" dominant-baseline="middle">A</text>
                                       <text x="17" y="14" font-size="8" font-weight="700" fill="#ffffff" text-anchor="middle" dominant-baseline="middle">文</text>
                                   </svg>
                                   <span class="text-xs text-black dark:text-gray-400 font-bold">Question Language:</span>
                                   <div class="inline-flex rounded-md overflow-hidden border border-gray-200 dark:border-gray-700">
                                       <button type="button" id="lang-toggle-en" class="px-2 py-1 text-xs bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">English</button>
                                       <button type="button" id="lang-toggle-bn" class="px-2 py-1 text-xs bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-l border-gray-200 dark:border-gray-700">বাংলা</button>
                                   </div>
                                   <input type="hidden" name="language" id="language-field" value="{{ old('language', 'english') }}">
                               </div>
                           </div>
                           
                           <div class="md:col-span-2">
                               <div class="flex items-center gap-1">
                                   <span class="text-xs text-black font-bold dark:text-gray-300">No. Of Questions:</span>
                                   <input type="text" name="number_of_question" inputmode="numeric" maxlength="3" pattern="^[1-9][0-9]?$" title="Enter 1-499" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2)" class="w-16 border border-gray-300 dark:border-gray-700 border-red-500 rounded-md py-1 px-2 bg-white dark:bg-gray-900 text-xs" placeholder="e.g., 50" value="{{ old('number_of_question', old('question_limit')) }}" required>
                               </div>
                           </div>
                           
                           <div class="md:col-span-2">
                               <div class="flex items-center gap-1">
                                   <label class="text-xs text-black font-bold dark:text-gray-200 whitespace-nowrap">Question Set Name <span class="text-red-500">*</span></label>
                                   <input type="text" name="name" class="flex-1 border border-gray-300 dark:border-gray-700 rounded-md py-1 px-2 focus:outline-none focus:ring-2 focus:ring-primaryGreen/40 border-red-500 focus:border-primaryGreen/50 dark:bg-gray-900 text-xs" placeholder="Enter Question Set Name" value="{{ old('name') }}" required>
                               </div>
                           </div>
                       </div>
                       
                       <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-4">
                           <div class="md:col-span-6">
                               <div class="flex items-center gap-1">
                                   <label class="text-xs text-black font-bold dark:text-gray-200">Description</label>
                                   <input type="text" name="description" class="w-full border border-gray-300 dark:border-gray-700 rounded-md py-1 px-2 focus:outline-none focus:ring-2 focus:ring-primaryGreen/40 border-red-500 focus:border-primaryGreen/50 dark:bg-gray-900 text-xs" placeholder="Enter Description" value="{{ old('description') }}">
                               </div>
                               @error('name')
                                   <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                               @enderror
                               @error('description')
                                   <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                               @enderror
                           </div>
                       </div>
                     
                                                                                       <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                                                      <div>
                                <select name="course" class="w-full rounded-md border border-gray-300 dark:border-gray-600 py-2 px-3 text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-1 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                    <option value="">All Courses</option>
                                    @foreach(($courses ?? []) as $course)
                                        <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <select name="subject" class="w-full rounded-md border border-gray-300 dark:border-gray-600 py-2 px-3 text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-1 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                    <option value="">All Subjects</option>
                                    @foreach(($subjects ?? []) as $subject)
                                        <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <select name="topic" class="w-full rounded-md border border-gray-300 dark:border-gray-600 py-2 px-3 text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-1 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                    <option value="">All Topics</option>
                                    @foreach(($topics ?? []) as $topic)
                                        <option value="{{ $topic->id }}" {{ request('topic') == $topic->id ? 'selected' : '' }}>{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <select name="question_type" class="w-full rounded-md border border-gray-300 dark:border-gray-600 py-2 px-3 text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-1 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                    <option value="">All Types</option>
                                    @foreach(($questionTypes ?? []) as $questionType)
                                        <option value="{{ $questionType->q_type_id }}" {{ request('question_type') == $questionType->q_type_id ? 'selected' : '' }}>{{ $questionType->q_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                           
                                                       <div class="md:col-span-2">
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 pl-4 flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                                        </svg>
                                    </div>
                                    <input name="search" value="{{ request('search') }}" type="text" placeholder="Search questions, subjects..." class="w-full rounded-md border border-gray-300 dark:border-gray-600 pl-12 pr-3 py-2 px-3 text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-1 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500">
                                </div>
                            </div>
                       </div>
                       

                 </div>
             </div>

            <!-- Active filter chips -->
            <div id="active-filters" class="hidden md:flex flex-wrap items-center gap-2 mb-4">
                @php
                    $chips = [];
                    if(request('course')) { $chips[] = ['label' => 'Course', 'value' => optional(($courses ?? collect())->firstWhere('id', request('course')))->name ?? request('course'), 'key' => 'course']; }
                    if(request('subject')) { $chips[] = ['label' => 'Subject', 'value' => optional(($subjects ?? collect())->firstWhere('id', request('subject')))->name ?? request('subject'), 'key' => 'subject']; }
                    if(request('topic')) { $chips[] = ['label' => 'Topic', 'value' => optional(($topics ?? collect())->firstWhere('id', request('topic')))->name ?? request('topic'), 'key' => 'topic']; }
                    if(request('question_type')) { $chips[] = ['label' => 'Type', 'value' => optional(($questionTypes ?? collect())->firstWhere('q_type_id', request('question_type')))->q_type_name ?? request('question_type'), 'key' => 'question_type']; }
                    if(request('search')) { $chips[] = ['label' => 'Search', 'value' => request('search'), 'key' => 'search']; }
                @endphp
                @foreach($chips as $chip)
                    <a href="{{ url()->current() . '?' . http_build_query(collect(request()->query())->except($chip['key'])->toArray()) }}"
                       class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 text-xs hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        <span class="font-medium">{{ $chip['label'] }}:</span>
                        <span>{{ $chip['value'] }}</span>
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endforeach
            </div>

            <div id="limit-warning" class="hidden mb-3 px-3 py-2 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm dark:bg-yellow-900/20 dark:border-yellow-800 dark:text-yellow-300"></div>

            

                                                   <div class="flex items-center justify-between mb-4">
                  <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">Page {{ $questions->firstItem() }}-{{ $questions->lastItem() }} of {{ $questions->total() }}</div>
              </div>

             <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
                 <table class="w-full">
                                                                                       <thead class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 dark:from-blue-900/20 dark:via-indigo-900/20 dark:to-purple-900/20">
                                                     <tr>
                                                               <th class="px-3 py-2 text-left">
                                    <span class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">Question</span>
                                </th>
                                
                                <th class="px-3 py-2 text-left hidden md:table-cell w-16">
                                    <span class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">Order</span>
                                </th>
                                <th class="px-3 py-2 text-left hidden md:table-cell w-16">
                                    <span class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">Marks</span>
                                </th>
                                
                                                                                                 <th class="px-3 py-2 text-center w-24">
                                     <button type="button" id="header-select-toggle" class="flex items-center justify-center w-full cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-all duration-200 group">
                                         <div class="flex items-center gap-2">
                                             <div class="w-4 h-4 border-2 border-gray-400 dark:border-gray-500 rounded bg-white dark:bg-gray-800 flex items-center justify-center group-hover:border-blue-500 dark:group-hover:border-blue-400 transition-colors duration-200">
                                                 <svg class="w-2.5 h-2.5 text-gray-500 dark:text-gray-400 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                                     <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                 </svg>
                                             </div>
                                             <span id="header-select-text" class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">Select All</span>
                                         </div>
                                     </button>
                                 </th>
                           </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                          @forelse($questions ?? [] as $q)
                                                             <tr class="hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-all duration-200 group question-row" data-question-id="{{ $q->id }}">
                                                                       <td class="px-3 py-2 align-middle">
                                        <div class="flex items-start gap-2">
                                            @php
                                                $qType = $q->questionType->q_type_code ?? strtoupper($q->question_type ?? 'N/A');
                                                $qTypeLower = strtolower($qType);
                                                
                                                // Define styles and icons for different question types
                                                $tagStyles = [
                                                    'mcq' => 'border-green-500 bg-white',
                                                    'mcq1' => 'border-green-500 bg-white',
                                                    'mcq2' => 'border-green-500 bg-white',
                                                    'mcq3' => 'border-green-500 bg-white',
                                                    'mcq4' => 'border-green-500 bg-white',
                                                    'mcq5' => 'border-green-500 bg-white',
                                                    'mcq6' => 'border-green-500 bg-white',
                                                    'mcq7' => 'border-green-500 bg-white',
                                                    'mcq8' => 'border-green-500 bg-white',
                                                    'mcq9' => 'border-green-500 bg-white',
                                                    'mcq10' => 'border-green-500 bg-white',
                                                    'desc' => 'border-blue-500 bg-white',
                                                    'desc1' => 'border-blue-500 bg-white',
                                                    'desc2' => 'border-blue-500 bg-white',
                                                    'desc3' => 'border-blue-500 bg-white',
                                                    'desc4' => 'border-blue-500 bg-white',
                                                    'desc5' => 'border-blue-500 bg-white',
                                                    'comp' => 'border-purple-500 bg-white',
                                                    'comp1' => 'border-purple-500 bg-white',
                                                    'comp2' => 'border-purple-500 bg-white',
                                                    'comp3' => 'border-purple-500 bg-white',
                                                    'comp4' => 'border-purple-500 bg-white',
                                                    'comp5' => 'border-purple-500 bg-white',
                                                    'typing' => 'border-orange-500 bg-white',
                                                    'typing1' => 'border-orange-500 bg-white',
                                                    'typing2' => 'border-orange-500 bg-white',
                                                    'typing3' => 'border-orange-500 bg-white',
                                                    'typing4' => 'border-orange-500 bg-white',
                                                    'typing5' => 'border-orange-500 bg-white',
                                                    'default' => 'border-gray-500 bg-white'
                                                ];
                                                
                                                $style = $tagStyles[$qTypeLower] ?? $tagStyles['default'];
                                            @endphp
                                                                                                                                     <div class="inline-flex items-center justify-center w-6 h-6  {{ $style }} shadow-sm flex-shrink-0">
                                                @if(str_contains($qTypeLower, 'mcq'))
                                                    <!-- MCQ Icon - PNG from public folder -->
                                                    <img src="{{ asset('images/mcq.png') }}" alt="MCQ" class="w-5 h-5 object-contain">
                                                @elseif(str_contains($qTypeLower, 'desc'))
                                                    <!-- Descriptive Icon - PNG from public folder -->
                                                    <img src="{{ asset('images/cq.png') }}" alt="Descriptive" class="w-5 h-5 object-contain">
                                                @elseif(str_contains($qTypeLower, 'comp'))
                                                    <!-- Comprehensive Icon - PNG from public folder -->
                                                    <img src="{{ asset('images/cq.png') }}" alt="Comprehensive" class="w-5 h-5 object-contain">
                                                @elseif(str_contains($qTypeLower, 'typing'))
                                                    <!-- Typing Icon - PNG from public folder -->
                                                    <img src="{{ asset('images/cq.png') }}" alt="Typing" class="w-5 h-5 object-contain">
                                                @else
                                                    <!-- Default Icon - PNG from public folder -->
                                                    <img src="{{ asset('images/cq.png') }}" alt="Question" class="w-5 h-5 object-contain">
                                                @endif
                                            </div>
                                                                                         <div class="text-sm text-gray-900 dark:text-gray-100 leading-tight flex-1">
                                                 <span>{!! Str::limit($q->question_text, 120) !!}</span><span class="inline-flex items-center justify-center w-5 h-5 rounded-full text-xs font-bold bg-purple-600 dark:bg-purple-700 text-white border border-purple-700 dark:border-purple-600 ml-2 cursor-help shadow-sm" title="{{ $q->topic->subject->name ?? 'Unknown Subject' }}">{{ substr($q->topic->subject->name ?? 'U', 0, 1) }}</span>
                                             </div>
                                        </div>
                                    </td>
                                   
                                   <td class="px-3 py-2 align-middle hidden md:table-cell">
                                       <input type="number" min="1" class="order-input w-14 h-7 rounded-lg border border-gray-200 dark:border-gray-600 px-2 text-xs text-center bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" name="order_map[{{ $q->id }}]" data-id="{{ $q->id }}" placeholder="#">
                                   </td>
                                   <td class="px-3 py-2 align-middle hidden md:table-cell">
                                       <input type="number" min="1" value="1" class="marks-input w-14 h-7 rounded-lg border border-gray-200 dark:border-gray-600 px-2 text-xs text-center bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" name="marks_map[{{ $q->id }}]" data-id="{{ $q->id }}">
                                   </td>
                                   
                                   <td class="px-3 py-2 align-middle">
                                       <div class="flex items-center justify-center">
                                           <label class="relative inline-flex items-center cursor-pointer group">
                                               <input type="checkbox" class="q-checkbox sr-only" 
                                                      data-id="{{ $q->id }}" 
                                                      data-text="{{ Str::limit(strip_tags($q->question_text), 140) }}" 
                                                      data-marks="1">
                                               <div class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded-md transition-all duration-200 group-hover:border-blue-400 dark:group-hover:border-blue-500 bg-white dark:bg-gray-800 flex items-center justify-center">
                                                   <svg class="w-3 h-3 text-white transform scale-0 transition-transform duration-200 ease-in-out" fill="currentColor" viewBox="0 0 20 20">
                                                       <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                   </svg>
                                               </div>
                                               
                                           </label>
                                       </div>
                                   </td>
                               </tr>
                         @empty
                                                                                           <tr>
                                   <td colspan="4" class="px-6 py-12 text-center">
                                     <div class="flex flex-col items-center gap-3">
                                         <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                         </svg>
                                         <div class="text-gray-500 dark:text-gray-400">
                                             <p class="text-sm font-medium">No questions found</p>
                                             <p class="text-xs">Try adjusting your filters or search terms</p>
                                         </div>
                                     </div>
                                 </td>
                             </tr>
                         @endforelse
                     </tbody>
                 </table>
             </div>

            <div class="mt-4">
                {{ ($questions ?? null) ? $questions->withQueryString()->links() : '' }}
            </div>
        </div>

        <!-- Step 4: Hidden status field (controls are in header) -->
        <input type="hidden" id="status-field" name="status" value="draft">
        
        <!-- Hidden container to inject selected IDs on submit -->
        <div id="selected-hidden-inputs"></div>
    </form>
</div>
@endsection 

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const STORAGE_KEY = 'qs_create_selected_questions';
    const NEXT_ORDER_KEY = 'qs_create_next_order';
    const FORM_STATE_KEY = 'qs_create_form_state';
    
    // Reset selection on first entry into this page so form opens in normal state
    try {
        const referrer = document.referrer || '';
        let samePath = false;
        try { samePath = new URL(referrer, window.location.origin).pathname === window.location.pathname; } catch (_) {}
        if (!samePath) {
            localStorage.removeItem(STORAGE_KEY);
            localStorage.removeItem(NEXT_ORDER_KEY);
            localStorage.removeItem(FORM_STATE_KEY);
        }
    } catch (_) {}
    const filtersWrapper = document.getElementById('filters-form');
    const checkboxes = Array.from(document.querySelectorAll('.q-checkbox'));
    const selectedList = null;
    const selectedCountEl = null;
    const selectedCountFab = null;
    const selectedCountBadge = document.getElementById('selected-count-badge');
    const selectedMarksEl = null;
    const totalMarksInput = null;
    const hiddenInputsContainer = document.getElementById('selected-hidden-inputs');
         const form = document.getElementById('question-set-form');
     const questionLimitInput = document.querySelector('input[name="number_of_question"]');
    const limitWarning = document.getElementById('limit-warning');
    const statusField = document.getElementById('status-field');
    const saveDraftBtn = document.getElementById('save-draft-btn');
    const publishBtn = null;
    const saveDraftBtnTop = document.getElementById('save-draft-btn-top');
    const publishBtnTop = document.getElementById('publish-btn-top');
         const toggleFiltersBtn = document.getElementById('toggle-filters');
     const mobileSelectedToggle = null;
     const selectedSection = null;
     const clearAllSelectedBtn = null;
           const headerSelectToggle = document.getElementById('header-select-toggle');
      const headerSelectText = document.getElementById('header-select-text');
      const langField = document.getElementById('language-field');
      const langBtnEn = document.getElementById('lang-toggle-en');
      const langBtnBn = document.getElementById('lang-toggle-bn');

    function loadNextOrder() {
        const n = parseInt(localStorage.getItem(NEXT_ORDER_KEY) || '1', 10) || 1;
        return n;
    }
    function saveNextOrder(n) {
        localStorage.setItem(NEXT_ORDER_KEY, String(n));
    }
    // removed: selected-slots selection panel

    function loadSelected() {
        try { return JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}'); }
        catch(e) { return {}; }
    }

    function setLanguageToggleActive(lang) {
        const activeClasses = ['bg-primaryGreen','text-white'];
        const inactiveClasses = ['bg-white','dark:bg-gray-800','text-gray-700','dark:text-gray-200'];
        if (langBtnEn && langBtnBn) {
            // Reset both
            [langBtnEn, langBtnBn].forEach(btn => {
                btn.classList.remove(...activeClasses);
                inactiveClasses.forEach(c => { if (!btn.classList.contains(c)) btn.classList.add(c); });
            });
            const activeBtn = (lang === 'bangla') ? langBtnBn : langBtnEn;
            if (activeBtn) {
                inactiveClasses.forEach(c => activeBtn.classList.remove(c));
                activeBtn.classList.add(...activeClasses);
            }
        }
    }

    function saveSelected(map) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(map));
    }

    // Form state preservation functions
    function saveFormState() {
        const formState = {};
        const formInputs = form.querySelectorAll('input[name], textarea[name], select[name]');
        formInputs.forEach(input => {
            if (input.name && input.name !== 'search' && input.name !== 'course' && input.name !== 'subject' && input.name !== 'topic' && input.name !== 'question_type') {
                formState[input.name] = input.value;
            }
        });
        localStorage.setItem(FORM_STATE_KEY, JSON.stringify(formState));
    }

    function restoreFormState() {
        try {
            const formState = JSON.parse(localStorage.getItem(FORM_STATE_KEY) || '{}');
            Object.keys(formState).forEach(name => {
                const input = form.querySelector(`[name="${name}"]`);
                if (input && input.name !== 'search' && input.name !== 'course' && input.name !== 'subject' && input.name !== 'topic' && input.name !== 'question_type') {
                    input.value = formState[name];
                }
            });
        } catch (e) {
            console.warn('Failed to restore form state:', e);
        }
    }

    function clearFormState() {
        localStorage.removeItem(FORM_STATE_KEY);
        localStorage.removeItem(STORAGE_KEY);
        localStorage.removeItem(NEXT_ORDER_KEY);
    }

    function syncCheckboxes() {
        const map = loadSelected();
        checkboxes.forEach(cb => {
            const id = String(cb.dataset.id);
            cb.checked = Boolean(map[id]);
            const row = cb.closest('tr');
            if (row) {
                row.classList.toggle('selected', cb.checked);
                row.classList.remove('bg-green-50/40');
            }
            
                         // Update custom checkbox visual state
             const checkboxContainer = cb.closest('label');
             if (checkboxContainer) {
                 const checkboxBox = checkboxContainer.querySelector('div');
                 const checkboxIcon = checkboxContainer.querySelector('svg');
                 
                 if (cb.checked) {
                     checkboxBox.classList.add('bg-blue-600', 'border-blue-600', 'dark:bg-blue-500', 'dark:border-blue-500');
                     checkboxBox.classList.remove('border-gray-300', 'dark:border-gray-600', 'bg-white', 'dark:bg-gray-800');
                     checkboxIcon.classList.remove('scale-0');
                     checkboxIcon.classList.add('scale-100');
                 } else {
                     checkboxBox.classList.remove('bg-blue-600', 'border-blue-600', 'dark:bg-blue-500', 'dark:border-blue-500');
                     checkboxBox.classList.add('border-gray-300', 'dark:border-gray-600', 'bg-white', 'dark:bg-gray-800');
                     checkboxIcon.classList.remove('scale-100');
                     checkboxIcon.classList.add('scale-0');
                 }
             }
        });
    }

         function updateHeaderText() {
         const map = loadSelected();
         const totalOnPage = checkboxes.length;
         const selectedOnPage = checkboxes.reduce((acc, cb) => acc + (map[String(cb.dataset.id)] ? 1 : 0), 0);
         
         if (headerSelectText) {
             if (selectedOnPage === 0) {
                 headerSelectText.textContent = 'Select All';
             } else if (selectedOnPage === totalOnPage) {
                 headerSelectText.textContent = 'Clear All';
             } else {
                 headerSelectText.textContent = `Selected ${selectedOnPage}`;
             }
         }
     }
 
     function renderSelected() {
         const map = loadSelected();
         const items = Object.values(map);
 
         // Render list
         document.querySelectorAll('.selected-indicator').forEach(el => {
             const id = String(el.getAttribute('data-id'));
             el.classList.toggle('hidden', !map[id]);
         });
 
                   // Totals
          const count = items.length;
          const limit = parseInt((questionLimitInput && questionLimitInput.value) ? questionLimitInput.value : '0', 10) || 0;
          if (selectedCountBadge) selectedCountBadge.textContent = `Selected ${count} / ${limit}`;
 
         // Enforce question limit in UI by disabling further selections
         const disableNewSelections = limit > 0 && count >= limit;
         checkboxes.forEach(cb => {
             if (cb.checked) {
                 cb.disabled = false;
             } else {
                 cb.disabled = disableNewSelections;
             }
         });
 
         // Update header text
         updateHeaderText();
 
         // No per-item remove buttons in inline view
     }

    function getUsedOrderNumbers() {
        const used = new Set();
        checkboxes.forEach(cb => {
            if (!cb.checked) return;
            const id = String(cb.dataset.id);
            const inp = document.querySelector(`.order-input[data-id="${id}"]`);
            const val = parseInt((inp && inp.value) ? inp.value : '0', 10) || 0;
            if (val > 0) used.add(val);
        });
        return used;
    }

    function getNextOrderNumber() {
        const used = getUsedOrderNumbers();
        let n = 1;
        while (used.has(n)) n++;
        return n;
    }

    function renumberOrderInputs() {
        const selected = checkboxes.filter(cb => cb.checked);
        const items = selected.map(cb => {
            const id = String(cb.dataset.id);
            const inp = document.querySelector(`.order-input[data-id="${id}"]`);
            const val = parseInt((inp && inp.value) ? inp.value : '0', 10) || 0;
            return { id, inp, val };
        });
        items.sort((a, b) => {
            if (a.val && b.val) return a.val - b.val;
            if (a.val) return -1;
            if (b.val) return 1;
            return 0;
        });
        items.forEach((item, idx) => {
            if (item.inp) item.inp.value = String(idx + 1);
        });
        saveNextOrder(items.length + 1);
    }

    // Handle click on remove (X) icon in the Added column
    document.addEventListener('click', function(e) {
        const target = e.target.closest('.selected-remove');
        if (!target) return;
        const id = String(target.getAttribute('data-id'));
        if (!id) return;
        const map = loadSelected();
        if (map[id]) {
            delete map[id];
            saveSelected(map);
            const cb = document.querySelector(`.q-checkbox[data-id="${id}"]`);
            if (cb) cb.checked = false;
            const orderInp = document.querySelector(`.order-input[data-id="${id}"]`);
            if (orderInp) orderInp.value = '';
            renderSelected();
            if (typeof reorderRows === 'function') reorderRows();
            renumberOrderInputs();
        }
    });

    function reorderRows() {
        const tbody = document.querySelector('table.w-full tbody');
        if (!tbody) return;
        const rows = Array.from(tbody.querySelectorAll('tr.question-row'));
        const selectedRows = [];
        const unselectedRows = [];
        rows.forEach(row => {
            const cb = row.querySelector('.q-checkbox');
            if (cb && cb.checked) {
                selectedRows.push(row);
            } else {
                unselectedRows.push(row);
            }
        });
        [...selectedRows, ...unselectedRows].forEach(row => tbody.appendChild(row));
    }

    function onCheckboxChange(ev) {
        const cb = ev.target;
        const id = String(cb.dataset.id);
        const text = cb.dataset.text || '';
        const marks = parseInt(cb.dataset.marks || '0', 10) || 0;
        const map = loadSelected();

        // Enforce limit at interaction time
        const currentCount = Object.keys(map).length;
        const limit = parseInt((questionLimitInput && questionLimitInput.value) ? questionLimitInput.value : '0', 10) || 0;
        if (cb.checked && limit > 0 && currentCount >= limit) {
            // revert check
            cb.checked = false;
            if (limitWarning) {
                limitWarning.textContent = `You can select up to ${limit} questions.`;
                limitWarning.classList.remove('hidden');
            } else {
                alert(`You can select up to ${limit} questions.`);
            }
            return; 
        }

        // Apply change
        if (cb.checked) {
            map[id] = { id, text, marks };
            // Set default Q. No if empty
            const orderInp = document.querySelector(`.order-input[data-id="${id}"]`);
            if (orderInp && (!orderInp.value || parseInt(orderInp.value, 10) <= 0)) {
                const next = loadNextOrder();
                orderInp.value = String(next);
                saveNextOrder(next + 1);
            }
        } else {
            delete map[id];
            // Clear Q. No on unselect
            const orderInp = document.querySelector(`.order-input[data-id="${id}"]`);
            if (orderInp) orderInp.value = '';
            renumberOrderInputs();
        }
        saveSelected(map);
        renderSelected();
        const row = cb.closest('tr');
        if (row) {
            row.classList.toggle('selected', cb.checked);
            row.classList.remove('bg-green-50/40');
        }
        
                 // Update custom checkbox visual state immediately
         const checkboxContainer = cb.closest('label');
         if (checkboxContainer) {
             const checkboxBox = checkboxContainer.querySelector('div');
             const checkboxIcon = checkboxContainer.querySelector('svg');
             
             if (cb.checked) {
                 checkboxBox.classList.add('bg-blue-600', 'border-blue-600', 'dark:bg-blue-500', 'dark:border-blue-500');
                 checkboxBox.classList.remove('border-gray-300', 'dark:border-gray-600', 'bg-white', 'dark:bg-gray-800');
                 checkboxIcon.classList.remove('scale-0');
                 checkboxIcon.classList.add('scale-100');
             } else {
                 checkboxBox.classList.remove('bg-blue-600', 'border-blue-600', 'dark:bg-blue-500', 'dark:border-blue-500');
                 checkboxBox.classList.add('border-gray-300', 'dark:border-gray-600', 'bg-white', 'dark:bg-gray-800');
                 checkboxIcon.classList.remove('scale-100');
                 checkboxIcon.classList.add('scale-0');
             }
         }
        
        // Immediately reorder rows to move selected questions to top
        reorderRows();
        
        if (limitWarning && (limit === 0 || Object.keys(loadSelected()).length < limit)) {
            limitWarning.classList.add('hidden');
            limitWarning.textContent = '';
        }
    }

    // Initialize
    syncCheckboxes();
    renderSelected();
    reorderRows();
    checkboxes.forEach(cb => cb.addEventListener('change', onCheckboxChange));

    // Initialize and wire language toggle
    if (langField && (langBtnEn || langBtnBn)) {
        setLanguageToggleActive((langField.value || 'english').toLowerCase());
        if (langBtnEn) {
            langBtnEn.addEventListener('click', function() {
                langField.value = 'english';
                setLanguageToggleActive('english');
            });
        }
        if (langBtnBn) {
            langBtnBn.addEventListener('click', function() {
                langField.value = 'bangla';
                setLanguageToggleActive('bangla');
            });
        }
    }

    // Re-evaluate UI when limit changes
    if (questionLimitInput) {
        ['input','change'].forEach(evt => questionLimitInput.addEventListener(evt, renderSelected));
    }

    

         // Auto-apply filters when selection changes, preserving selection in localStorage
     function autoApplyFilters() {
         // Save form state before applying filters
         saveFormState();
         
         const params = new URLSearchParams(window.location.search);
         filtersWrapper.querySelectorAll('select, input[name="search"]').forEach(el => {
             if (el.name) {
                 if (el.value) params.set(el.name, el.value); else params.delete(el.name);
             }
         });
         const url = `${window.location.pathname}?${params.toString()}`;
         window.location.assign(url);
     }

     // Add event listeners for auto-apply on filter changes
     if (filtersWrapper) {
         // Auto-apply on select changes
         filtersWrapper.querySelectorAll('select').forEach(select => {
             select.addEventListener('change', autoApplyFilters);
         });
         
         // Auto-apply on search input with debouncing
         const searchInput = filtersWrapper.querySelector('input[name="search"]');
         if (searchInput) {
             let searchTimeout;
             searchInput.addEventListener('input', function() {
                 clearTimeout(searchTimeout);
                 searchTimeout = setTimeout(autoApplyFilters, 500); // 500ms delay for search
             });
         }
     }

         // Toggle filters on mobile
     if (toggleFiltersBtn && filtersWrapper) {
         toggleFiltersBtn.addEventListener('click', function() {
             if (filtersWrapper.classList.contains('hidden')) {
                 filtersWrapper.classList.remove('hidden');
             } else {
                 filtersWrapper.classList.add('hidden');
             }
         });
     }

    // Restore form state after page loads
    restoreFormState();

    // Add event listeners for pagination links to preserve form state
    document.addEventListener('click', function(e) {
        const paginationLink = e.target.closest('a[href*="page="]');
        if (paginationLink && paginationLink.href.includes(window.location.pathname)) {
            e.preventDefault();
            saveFormState();
            window.location.href = paginationLink.href;
        }
    });

    // Add event listeners to save form state when inputs change
    if (form) {
        form.addEventListener('input', function(e) {
            if (e.target.name && e.target.name !== 'search' && e.target.name !== 'course' && e.target.name !== 'subject' && e.target.name !== 'topic' && e.target.name !== 'question_type') {
                saveFormState();
            }
        });
        
        form.addEventListener('change', function(e) {
            if (e.target.name && e.target.name !== 'search' && e.target.name !== 'course' && e.target.name !== 'subject' && e.target.name !== 'topic' && e.target.name !== 'question_type') {
                saveFormState();
            }
        });
    }
 
     // Header select toggle functionality
     if (headerSelectToggle) {
         headerSelectToggle.addEventListener('click', function() {
            const map = loadSelected();
            const totalOnPage = checkboxes.length;
            const selectedOnPage = checkboxes.reduce((acc, cb) => acc + (map[String(cb.dataset.id)] ? 1 : 0), 0);
            
            if (selectedOnPage === totalOnPage && totalOnPage > 0) {
                // Clear selections on this page only
                checkboxes.forEach(cb => {
                    const id = String(cb.dataset.id);
                    if (map[id]) delete map[id];
                    cb.checked = false;
                });
                
                // Clear order inputs on this page
                document.querySelectorAll('.order-input').forEach(inp => { inp.value = ''; });
                
                saveSelected(map);
                syncCheckboxes();
                renderSelected();
                reorderRows();
                
                if (limitWarning) {
                    limitWarning.classList.add('hidden');
                    limitWarning.textContent = '';
                }
            } else {
                // Select all on this page (respecting the overall limit)
                const limit = parseInt((questionLimitInput && questionLimitInput.value) ? questionLimitInput.value : '0', 10) || 0;
                const currentCount = Object.keys(map).length;
                let remaining = limit > 0 ? Math.max(0, limit - currentCount) : Infinity;
                let nextOrder = loadNextOrder();
                
                checkboxes.forEach(cb => {
                    if (remaining <= 0) return;
                    if (!cb.checked) {
                        const id = String(cb.dataset.id);
                        const text = cb.dataset.text || '';
                        const marks = parseInt(cb.dataset.marks || '0', 10) || 0;
                        map[id] = { id, text, marks };
                        cb.checked = true;
                        const orderInp = document.querySelector(`.order-input[data-id="${id}"]`);
                        if (orderInp && (!orderInp.value || parseInt(orderInp.value, 10) <= 0)) {
                            orderInp.value = String(nextOrder++);
                        }
                        if (remaining !== Infinity) remaining--;
                    }
                });
                
                saveNextOrder(nextOrder);
                saveSelected(map);
                syncCheckboxes();
                renderSelected();
                reorderRows();
                
                if (limitWarning && (limit > 0 && Object.keys(loadSelected()).length >= limit)) {
                    limitWarning.textContent = `You can select up to ${limit} questions.`;
                    limitWarning.classList.remove('hidden');
                }
            }
        });
    }

    // No mobile selected panel toggle needed in inline mode

    // On submit: inject hidden inputs for selected IDs and question_limit
    if (form) {
        // Save form state before submission to handle validation errors
        form.addEventListener('submit', function() {
            saveFormState();
        });
        
        if (saveDraftBtn) {
            saveDraftBtn.addEventListener('click', function() {
                if (statusField) statusField.value = 'draft';
                clearFormState(); // Clear form state on save draft
            });
        }
        if (publishBtn) {
            publishBtn.addEventListener('click', function() {
                if (statusField) statusField.value = 'published';
            });
        }
        if (saveDraftBtnTop) {
            saveDraftBtnTop.addEventListener('click', function() {
                if (statusField) statusField.value = 'draft';
                clearFormState(); // Clear form state on save draft
            });
        }
        if (publishBtnTop) {
            publishBtnTop.addEventListener('click', function() {
                if (statusField) statusField.value = 'published';
            });
        }
        form.addEventListener('submit', function(e) {
            // prevent publish if selected < limit
            const currentMap = loadSelected();
            const selectedCount = Object.keys(currentMap).length;
            const limitVal = parseInt((questionLimitInput && questionLimitInput.value) ? questionLimitInput.value : '0', 10) || 0;
            const statusVal = statusField ? String(statusField.value || '') : '';
            if (statusVal === 'published' && limitVal > 0 && selectedCount < limitVal) {
                if (limitWarning) {
                    limitWarning.textContent = `To publish, select at least ${limitVal} questions.`;
                    limitWarning.classList.remove('hidden');
                } else {
                    alert(`To publish, select at least ${limitVal} questions.`);
                }
                e.preventDefault();
                return;
            }
            hiddenInputsContainer.innerHTML = '';
            const map = loadSelected();
            Object.keys(map).forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'question_ids[]';
                input.value = id;
                hiddenInputsContainer.appendChild(input);
            });
            // Ensure backend gets question_limit derived from number_of_question
            if (questionLimitInput) {
                const ql = document.createElement('input');
                ql.type = 'hidden';
                ql.name = 'question_limit';
                ql.value = String(limitVal);
                hiddenInputsContainer.appendChild(ql);
            }
            // Clear storage after submit
            // localStorage.removeItem(STORAGE_KEY);
            saveNextOrder(1);
        });

        // nothing else
    }
});
</script>
@endpush
