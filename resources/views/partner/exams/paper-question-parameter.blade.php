@extends('layouts.partner-layout')

@section('title', 'Question Paper Parameters')

@section('content')
<style>
    #livePreview.landscape {
        writing-mode: horizontal-tb;
    }
    
    #livePreview.portrait {
        writing-mode: horizontal-tb;
    }
    
         #livePreview {
         margin: 0 auto;
         display: block;
         overflow: visible;
     }
     
   
    
        /* Paper Column Layout Styles - removed old grid layout that was causing page splitting */
    
                                                                               /* Ensure content doesn't break awkwardly in columns */
        #livePreview > div {
            break-inside: avoid;
            page-break-inside: avoid;
        }
        
     
     
                          /* Header container styling */
        .header-container {
            background: rgba(248, 250, 252, 0.8);
            border-radius: 4px;
            padding: 5px;
            margin-bottom: 8px;
            grid-column: 1 / -1; /* Default to span all columns */
            height: auto !important;
            min-height: auto !important;
            align-self: start;
        }
        
        /* Header span styles for different configurations */
        #livePreview .header-container[style*="grid-column: 1 / 2"] {
            grid-column: 1 / 2 !important;
            background: rgba(59, 130, 246, 0.1) !important; /* Blue tint for 1 column span */
        }
        
        #livePreview .header-container[style*="grid-column: 1 / 3"] {
            grid-column: 1 / 3 !important;
            background: rgba(16, 185, 129, 0.1) !important; /* Green tint for 2 column span */
        }
        
        #livePreview .header-container[style*="grid-column: 1 / 4"] {
            grid-column: 1 / 4 !important;
            background: rgba(245, 158, 11, 0.1) !important; /* Orange tint for 3 column span */
        }
        
        #livePreview .header-container[style*="grid-column: 1 / 5"] {
            grid-column: 1 / 5 !important;
            background: rgba(239, 68, 68, 0.1) !important; /* Red tint for 4 column span */
        }
        
                /* Page container styling */
        #livePreview .page-container {
            background: white;
            margin: 0;
            padding: 0;
            border-radius: 0;
            page-break-inside: avoid;
            break-inside: avoid;
            border-green-500;
            box-sizing: border-box;
            position: relative;
        }
        
        /* A4 aspect ratio maintenance */
        #livePreview .page-container.a4-portrait {
            width: 210mm;
            min-height: 297mm;
            
        }
        
        #livePreview .page-container.a4-landscape {
            width: 297mm;
            min-height: 210mm;
            
        }
        
        /* Letter size */
        #livePreview .page-container.letter-portrait {
            width: 8.5in;
            min-height: 11in;
    
        }
        
        #livePreview .page-container.letter-landscape {
            width: 11in;
            min-height: 8.5in;
            
        }
        
        /* Legal size */
        #livePreview .page-container.legal-portrait {
            width: 8.5in;
            min-height: 14in;
            
        }
        
        #livePreview .page-container.legal-landscape {
            width: 14in;
            min-height: 8.5in;
        
        }
        
        
        /* True size mode - no scaling */
        #livePreview.true-size .page-container {
            transform: none !important;
        }
        
        /* Responsive scaling for smaller screens (only when not in true size mode) */
        @media (max-width: 1200px) {
            #livePreview:not(.true-size) .page-container {
                transform: scale(0.8);
                transform-origin: top center;
            }
        }
        
        @media (max-width: 900px) {
            #livePreview:not(.true-size) .page-container {
                transform: scale(0.6);
                transform-origin: top center;
            }
        }
        
        @media (max-width: 600px) {
            #livePreview:not(.true-size) .page-container {
                transform: scale(0.4);
                transform-origin: top center;
            }
        }
        
        /* True size mode styling */
        #livePreview.true-size {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 80vh;
        }
        
        #livePreview.true-size .page-container {
            margin: 0 auto;
        }
        
        /* Margin area visualization */
        .page-container {
            position: relative;
        }
        
        /* Margin area grid - shows area outside margins */
        .margin-area-grid {
            position: absolute;
            pointer-events: none;
            z-index: 0;
            background: rgba(255, 0, 0, 0.2);
        }
        
        /* Content area - shows printable area within margins */
        .content-area {
            position: absolute;
            background: rgba(0, 255, 0, 0.1);
            border: 2px solid rgba(0, 255, 0, 0.5);
            pointer-events: none;
            z-index: 1;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            padding: 0;
            box-sizing: border-box;
        }
        
        
        /* Multi-column layout within pages - now handled by questions-grid */
        #livePreview .questions-grid {
            display: grid !important;
            gap: 10px !important;
            position: relative;
        }
        
        #livePreview .questions-grid[style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr 1fr !important;
        }
        
        #livePreview .questions-grid[style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: 1fr 1fr 1fr !important;
        }
        
        /* Question column styling */
        #livePreview .question-column {
            min-width: 0;
            padding: 0 5px;
            border: 1px dashed #ccc;
            background: rgba(0, 0, 0, 0.02);
            min-height: 100px;
        }
        
        
        /* Column separator styling */
        #livePreview .column-separator {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 1px;
            background: #333;
            opacity: 0.3;
            z-index: 1;
        }
        
        /* Question styling */
        #livePreview .question {
            margin-bottom: 8px;
            padding: 5px;
            border-left: 2px solid #3b82f6;
            background: #f8fafc;
            border-radius: 2px;
        }
        
        /* Header styling */
        #livePreview .header-container {
            background: #f1f5f9;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        
        /* Page title styling */
        #livePreview .page-title {
            background: #3b82f6;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
            font-weight: bold;
        }
        
        /* Continuous page layout - no pagination needed */
        
        /* Ensure questions don't break across grid columns */
     .header-container[style*="grid-column"] {
         width: 100%;
     }
     
     /* Scaling functionality */
     .adjust-to-percentage {
         transform: scale(var(--adjust-percentage, 1)) !important;
         transform-origin: center !important;
     }
     
     
      
     
</style>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-0">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Question Paper Parameters</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">Configure settings and see live preview of your question paper</p>
        </div>

        <!-- Exam Info Card -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg">
                        #{{ $exam->id }}
                    </span>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $exam->title }}</h2>
                </div>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Questions:</span>
                        <span class="font-medium text-gray-900 dark:text-white ml-2">{{ $exam->questions->count() }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Duration:</span>
                        <span class="font-medium text-gray-900 dark:text-white ml-2">{{ $exam->duration }} min</span>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Total Marks:</span>
                        <span class="font-medium text-gray-900 dark:text-white ml-2">{{ $exam->questions->sum(function($q) { return $q->pivot->marks ?? 1; }) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Status:</span>
                        <span class="font-medium text-gray-900 dark:text-white ml-2">{{ ucfirst($exam->status) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paper Settings Form -->
        <div class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-900 shadow-2xl rounded-2xl border border-slate-200/50 dark:border-slate-700/50 mb-6 backdrop-blur-sm">
            <div class="px-6 py-4 border-b border-slate-200/60 dark:border-slate-700/60 bg-gradient-to-r from-slate-100/50 to-slate-200/50 dark:from-slate-800/50 dark:to-slate-700/50 rounded-t-2xl">
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full shadow-lg"></div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 bg-gradient-to-r from-slate-700 to-slate-900 dark:from-slate-300 dark:to-slate-100 bg-clip-text text-transparent">Paper Settings</h3>
                </div>
            </div>
            
            <form id="parameterForm" action="{{ route('partner.exams.download-paper', $exam) }}" method="POST" class="p-6">
                @csrf
                
                <!-- Hidden data for JavaScript -->
                <div id="examData" 
                     data-title="{{ addslashes($exam->title) }}"
                     data-id="{{ $exam->id }}"
                     data-duration="{{ $exam->duration }}"
                     data-total-questions="{{ $exam->questions->count() }}"
                     data-passing-marks="{{ $exam->passing_marks }}"
                     data-question-header="{{ addslashes($exam->question_header ?? "") }}"
                                            data-questions="{{ $exam->questions->map(function($q) { 
                          return [
                              'question_text' => $q->question_text,
                              'question_header' => $q->question_header ?? '',
                              'question_type' => $q->question_type,
                              'option_a' => $q->option_a ?? '',
                              'option_b' => $q->option_b ?? '',
                              'option_c' => $q->option_c ?? '',
                              'option_d' => $q->option_d ?? '',
                              'correct_answer' => $q->correct_answer ?? '',
                              'marks' => $q->pivot->marks ?? 1
                          ];
                      })->toJson() }}"
                     style="display: none;">
                </div>
                
                <!-- Professional Settings Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                        
                    <!-- Paper Format -->
                    <div class="bg-gradient-to-br from-white/80 to-slate-50/80 dark:from-slate-800/80 dark:to-slate-900/80 backdrop-blur-sm rounded-xl border border-slate-200/60 dark:border-slate-700/60 shadow-lg p-4">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-1.5 h-1.5 bg-gradient-to-r from-slate-500 to-slate-600 rounded-full shadow-sm"></div>
                            <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Paper Format</h4>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="paper_size" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Paper Size</label>
                                    <select id="paper_size" name="paper_size" class="w-full px-3 py-2.5 text-sm bg-white/90 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-600/60 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 dark:text-white shadow-sm transition-all duration-200 hover:shadow-md">
                                        <option value="A4" selected>A4 (210 × 297 mm)</option>
                                        <option value="Letter">Letter (8.5 × 11 in)</option>
                                        <option value="Legal">Legal (8.5 × 14 in)</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="orientation" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Orientation</label>
                                    <select id="orientation" name="orientation" class="w-full px-3 py-2.5 text-sm bg-white/90 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-600/60 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 dark:text-white shadow-sm transition-all duration-200 hover:shadow-md">
                                        <option value="portrait" selected>Portrait</option>
                                        <option value="landscape">Landscape</option>
                                    </select>
                                </div>
                                </div>
                                
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="paper_columns" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Columns</label>
                                    <select id="paper_columns" name="paper_columns" class="w-full px-3 py-2.5 text-sm bg-white/90 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-600/60 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 dark:text-white shadow-sm transition-all duration-200 hover:shadow-md">
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                            </div>
                            
                                    <div>
                                    <label for="adjust_to_percentage" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Scale (%)</label>
                                    <input type="number" id="adjust_to_percentage" name="adjust_to_percentage" value="100" min="10" max="500" class="w-full px-3 py-2.5 text-sm bg-white/90 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-600/60 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 dark:text-white shadow-sm transition-all duration-200 hover:shadow-md">
                                    </div>
                                    </div>
                                </div>
                            </div>
                            
                    <!-- Typography & Content -->
                    <div class="bg-gradient-to-br from-white/80 to-slate-50/80 dark:from-slate-800/80 dark:to-slate-900/80 backdrop-blur-sm rounded-xl border border-slate-200/60 dark:border-slate-700/60 shadow-lg p-4">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-1.5 h-1.5 bg-gradient-to-r from-slate-500 to-slate-600 rounded-full shadow-sm"></div>
                            <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Typography & Content</h4>
                                </div>
                                
                        <div class="space-y-3">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                    <label for="font_family" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Font Family</label>
                                    <select id="font_family" name="font_family" class="w-full px-3 py-2.5 text-sm bg-white/90 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-600/60 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 dark:text-white shadow-sm transition-all duration-200 hover:shadow-md">
                                         <option value="Arial">Arial</option>
                                         <option value="Times New Roman">Times New Roman</option>
                                         <option value="Calibri" selected>Calibri</option>
                                         <option value="Georgia">Georgia</option>
                                         <option value="Verdana">Verdana</option>
                                     </select>
                                </div>
                                
                                <div>
                                    <label for="font_size" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Font Size</label>
                                    <select id="font_size" name="font_size" class="w-full px-3 py-2.5 text-sm bg-white/90 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-600/60 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 dark:text-white shadow-sm transition-all duration-200 hover:shadow-md">
                                         <option value="10" selected>10pt</option>
                                         <option value="11">11pt</option>
                                         <option value="12">12pt</option>
                                         <option value="14">14pt</option>
                                         <option value="16">16pt</option>
                                     </select>
                                </div>
                                </div>
                                
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="line_spacing" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Line Spacing</label>
                                    <select id="line_spacing" name="line_spacing" class="w-full px-3 py-2.5 text-sm bg-white/90 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-600/60 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 dark:text-white shadow-sm transition-all duration-200 hover:shadow-md">
                                        <option value="1.0" selected>Single</option>
                                         <option value="1.15">1.15</option>
                                         <option value="1.5">1.5</option>
                                        <option value="2.0">Double</option>
                                     </select>
                                </div>
                                
                                <div>
                                    <label for="mcq_columns" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">MCQ Columns</label>
                                    <select id="mcq_columns" name="mcq_columns" class="w-full px-3 py-2.5 text-sm bg-white/90 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-600/60 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 dark:text-white shadow-sm transition-all duration-200 hover:shadow-md">
                                         <option value="1">1</option>
                                         <option value="2">2</option>
                                         <option value="3">3</option>
                                         <option value="4" selected>4</option>
                                     </select>
                                </div>
                            </div>
                        </div>
                                </div>
                                
                    <!-- Margins -->
                    <div class="bg-gradient-to-br from-white/80 to-slate-50/80 dark:from-slate-800/80 dark:to-slate-900/80 backdrop-blur-sm rounded-xl border border-slate-200/60 dark:border-slate-700/60 shadow-lg p-4">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-1.5 h-1.5 bg-gradient-to-r from-slate-500 to-slate-600 rounded-full shadow-sm"></div>
                            <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Margins (mm)</h4>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3">
                                <div>
                                <label for="margin_top" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Top</label>
                                <input type="number" id="margin_top" name="margin_top" value="0" min="0" max="50" class="w-full px-3 py-2.5 text-sm bg-white/90 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-600/60 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 dark:text-white shadow-sm transition-all duration-200 hover:shadow-md">
                                </div>
                            
                            <div>
                                <label for="margin_bottom" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Bottom</label>
                                <input type="number" id="margin_bottom" name="margin_bottom" value="0" min="0" max="50" class="w-full px-3 py-2.5 text-sm bg-white/90 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-600/60 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 dark:text-white shadow-sm transition-all duration-200 hover:shadow-md">
                            </div>
                            
                            <div>
                                <label for="margin_left" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Left</label>
                                <input type="number" id="margin_left" name="margin_left" value="0" min="0" max="50" class="w-full px-3 py-2.5 text-sm bg-white/90 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-600/60 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 dark:text-white shadow-sm transition-all duration-200 hover:shadow-md">
                                           </div>
                            
                            <div>
                                <label for="margin_right" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Right</label>
                                <input type="number" id="margin_right" name="margin_right" value="0" min="0" max="50" class="w-full px-3 py-2.5 text-sm bg-white/90 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-600/60 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 dark:text-white shadow-sm transition-all duration-200 hover:shadow-md">
                            </div>
                                           </div>
                                       </div>
                                       
                    <!-- Header Settings -->
                    <div class="bg-gradient-to-br from-white/80 to-slate-50/80 dark:from-slate-800/80 dark:to-slate-900/80 backdrop-blur-sm rounded-xl border border-slate-200/60 dark:border-slate-700/60 shadow-lg p-4">
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-1.5 h-1.5 bg-gradient-to-r from-slate-500 to-slate-600 rounded-full shadow-sm"></div>
                                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Header Settings</h4>
                            </div>
                            
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="include_header" name="include_header" value="1" checked class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500/50 focus:ring-2 dark:focus:ring-blue-400 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600 shadow-sm">
                                    <label for="include_header" class="text-xs font-semibold text-slate-600 dark:text-slate-400">Include Header</label>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="mark_answer" name="mark_answer" value="1" class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500/50 focus:ring-2 dark:focus:ring-blue-400 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600 shadow-sm">
                                    <label for="mark_answer" class="text-xs font-semibold text-slate-600 dark:text-slate-400">Mark Correct Answers</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="header_span" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Header Span</label>
                                    <select id="header_span" name="header_span" class="w-full px-3 py-2.5 text-sm bg-white/90 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-600/60 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 dark:text-white shadow-sm transition-all duration-200 hover:shadow-md">
                                        <option value="1" selected>1 Column</option>
                                        <option value="2">2 Columns</option>
                                        <option value="3">3 Columns</option>
                                        <option value="4">4 Columns</option>
                                        <option value="full">Full Width</option>
                                                 </select>
                                             </div>
                                
                                <div>
                                    <label for="header_push" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5">Header Push</label>
                                    <select id="header_push" name="header_push" class="w-full px-3 py-2.5 text-sm bg-white/90 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-600/60 rounded-lg focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 dark:text-white shadow-sm transition-all duration-200 hover:shadow-md">
                                        <option value="1st_col" selected>1st Column</option>
                                        <option value="2nd_col">2nd Column</option>
                                        <option value="3rd_col">3rd Column</option>
                                        <option value="4th_col">4th Column</option>
                                                 </select>
                                        </div>
                                  </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                                 <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 mt-6 border-t border-slate-200/60 dark:border-slate-700/60 bg-gradient-to-r from-slate-50/50 to-slate-100/50 dark:from-slate-800/50 dark:to-slate-900/50 -mx-6 px-6 py-4 rounded-b-2xl">
                     <a href="{{ route('partner.exams.show', $exam) }}" 
                       class="flex items-center space-x-2 px-4 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-white/80 dark:bg-slate-800/80 border border-slate-200/60 dark:border-slate-700/60 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 backdrop-blur-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>Back to Exam</span>
                     </a>
                     
                     <button type="button" id="downloadPdfBtn"
                            class="flex items-center space-x-2 px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-bold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Download PDF</span>
                     </button>
                 </div>
            </form>
        </div>

        <!-- Live Preview (Full Width) -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Live Preview</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">See how your question paper will look</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-600 dark:text-gray-400" id="scaleIndicator">Scaled to fit screen</span>
                        <button type="button" id="trueSizeToggle" 
                                class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-lg hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 transition-all duration-200 shadow-md">
                            📏 True Size
                        </button>
                    </div>
                </div>
            </div>
                         <div class="p-6">
                 <div id="livePreview" class="bg-white border border-gray-200 rounded-lg p-6 overflow-visible" style="font-family: Arial, sans-serif; font-size: 12pt; line-height: 1.5; transition: all 0.3s ease; box-sizing: border-box;">
                     <!-- Preview content will be loaded here -->
                     <div class="text-center text-gray-500 py-8">
                         <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                         </svg>
                         <p>Adjust parameters above to see live preview</p>
                     </div>
                 </div>
            </div>
        </div>
    </div>
</div>

<script>
// Live preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const previewContainer = document.getElementById('livePreview');
    const form = document.getElementById('parameterForm');
    
    // Continuous page layout - no current page tracking needed
    
    // Navigation removed - all pages displayed continuously
    
             // Function to update live preview
    function updatePreview() {
        console.log('updatePreview called');
        
                 const formData = new FormData(form);
         const params = Object.fromEntries(formData.entries());
         console.log('Form params:', params);
         console.log('Paper size:', params.paper_size);
         console.log('Orientation:', params.orientation);
         console.log('Margin values from form:', {
             top: params.margin_top,
             right: params.margin_right,
             bottom: params.margin_bottom,
             left: params.margin_left
         });
         
         // Debug: Check if paper size select is working
         const paperSizeSelect = document.getElementById('paper_size');
         console.log('Paper size select value:', paperSizeSelect ? paperSizeSelect.value : 'NOT FOUND');
         console.log('Paper size select selectedIndex:', paperSizeSelect ? paperSizeSelect.selectedIndex : 'NOT FOUND');
         console.log('Mark Answer checkbox value:', params.mark_answer);
         console.log('Mark Answer checkbox type:', typeof params.mark_answer);
         console.log('MCQ columns:', params.mcq_columns);
         console.log('Paper columns:', params.paper_columns);
         console.log('Font size:', params.font_size);
         console.log('Current preview container classes:', previewContainer.className);
        
                 // Get exam data from the page
         const examDataElement = document.getElementById('examData');
         const examData = {
             title: examDataElement.dataset.title,
             id: parseInt(examDataElement.dataset.id),
             duration: parseInt(examDataElement.dataset.duration),
             total_questions: parseInt(examDataElement.dataset.totalQuestions),
             passing_marks: parseInt(examDataElement.dataset.passingMarks),
             question_header: examDataElement.dataset.questionHeader,
             questions: JSON.parse(examDataElement.dataset.questions)
         };
         console.log('Exam data:', examData);
         console.log('Questions with correct answers:', examData.questions.map(q => ({
             question_text: q.question_text.substring(0, 50) + '...',
             correct_answer: q.correct_answer,
             has_correct_answer: !!q.correct_answer
         })));
        
                 // Generate preview HTML
         const previewHTML = generatePreviewHTML(examData, params);
         console.log('Preview HTML generated, length:', previewHTML.length);
         previewContainer.innerHTML = previewHTML;
         
         // Debug: Check what was actually created and show all pages stacked vertically
         setTimeout(() => {
             const pageContainers = document.querySelectorAll('.page-container');
             console.log(`After setting innerHTML, found ${pageContainers.length} page containers`);
             
             // Show all pages stacked vertically with page breaks
             pageContainers.forEach((page, index) => {
                 page.style.display = 'block';
                 page.style.marginBottom = '20px';
                 page.style.pageBreakAfter = 'always';
                 page.style.breakAfter = 'page';
                 
                 // Remove page break from last page
                 if (index === pageContainers.length - 1) {
                     page.style.pageBreakAfter = 'avoid';
                     page.style.breakAfter = 'avoid';
                 }
                 
                 console.log(`Page ${index + 1}:`, {
                     dataPage: page.getAttribute('data-page'),
                     dataColumns: page.getAttribute('data-columns'),
                     display: page.style.display,
                     visible: page.offsetHeight > 0
                 });
             });
             
             console.log('All pages displayed vertically with page breaks');
         }, 100);
         
                  // All pages are now displayed vertically with page breaks
         console.log('All pages displayed in continuous vertical layout');
        
                 // Apply current styling
         previewContainer.style.fontFamily = params.font_family || 'Arial';
         previewContainer.style.fontSize = (params.font_size || 12) + 'pt';
         previewContainer.style.lineHeight = params.line_spacing || 1.5;
         
         // Apply scaling settings
         const adjustToPercentage = parseInt(params.adjust_to_percentage) || 100;
         
         // Apply adjust to percentage scaling
             document.querySelectorAll('.page-container').forEach(pageContainer => {
                 // Remove existing scaling classes
             pageContainer.classList.remove('adjust-to-percentage');
                 
                 // Apply adjust to percentage scaling
                 if (adjustToPercentage !== 100) {
                     pageContainer.classList.add('adjust-to-percentage');
                     pageContainer.style.setProperty('--adjust-percentage', adjustToPercentage / 100);
                 }
             });
         
         
         // Apply paper format settings to page containers
         const paperSize = params.paper_size || 'A4';
         const orientation = params.orientation || 'portrait';
         const sizeClass = `${paperSize.toLowerCase()}-${orientation}`;
         
         // Update all page containers with the correct paper size class and margins
         document.querySelectorAll('.page-container').forEach((pageContainer, index) => {
             console.log(`Updating page container ${index + 1}: current classes:`, pageContainer.className);
             // Remove all existing paper size classes
             pageContainer.classList.remove('a4-portrait', 'a4-landscape', 'letter-portrait', 'letter-landscape', 'legal-portrait', 'legal-landscape');
             
             // Add the correct paper size class
             pageContainer.classList.add(sizeClass);
             console.log(`Updated page container ${index + 1}: new classes:`, pageContainer.className);
             
             // Update data attributes
             pageContainer.setAttribute('data-paper-size', paperSize);
             pageContainer.setAttribute('data-orientation', orientation);
             
             // Apply margin values from form to the page container (convert mm to px)
             const marginTop = (parseInt(params.margin_top) || 0) * 3.7795275591 + 'px'; // 1mm = 3.7795275591px
             const marginRight = (parseInt(params.margin_right) || 0) * 3.7795275591 + 'px';
             const marginBottom = (parseInt(params.margin_bottom) || 0) * 3.7795275591 + 'px';
             const marginLeft = (parseInt(params.margin_left) || 0) * 3.7795275591 + 'px';
             
             // Set page container margins to 0 to use full width
             pageContainer.style.marginTop = '0px';
             pageContainer.style.marginRight = '0px';
             pageContainer.style.marginBottom = '0px';
             pageContainer.style.marginLeft = '0px';
             
             // Don't apply margins as padding - only use visual indicators
             // The margin visualization will show the margin areas without affecting layout
             
             // Add margin area grid visualization
             console.log(`Adding margin visualization to page container ${index + 1}`);
             addMarginAreaGrid(pageContainer, params);
             
             // Log the exact dimensions being applied
             const computedStyle = window.getComputedStyle(pageContainer);
             console.log(`Updated page container ${index + 1} with class: ${sizeClass}`);
             console.log(`Dimensions: width=${computedStyle.width}, height=${computedStyle.height}`);
             console.log(`Margins: top=${marginTop}, right=${marginRight}, bottom=${marginBottom}, left=${marginLeft}`);
         });
         
         // Add visual indicator for MCQ columns
         if (params.mcq_columns) {
             const columns = parseInt(params.mcq_columns);
             previewContainer.setAttribute('data-mcq-columns', columns);
             
             // Add CSS custom property for MCQ columns
             previewContainer.style.setProperty('--mcq-columns', columns);
         }
         
         // Add visual indicator for Header Span
         if (params.header_span) {
             const headerSpan = params.header_span;
             previewContainer.setAttribute('data-header-span', headerSpan);
             
             console.log(`Applied header span: ${headerSpan}`);
             console.log(`Header span value: ${headerSpan}, type: ${typeof headerSpan}`);
         }
         
                   // Add visual indicator for Paper columns (now handled within page containers)
          if (params.paper_columns) {
              const paperColumns = parseInt(params.paper_columns);
              previewContainer.setAttribute('data-paper-columns', paperColumns);
              
              console.log(`Paper columns set to: ${paperColumns} (handled within page containers)`);
          }
    }
    
        // Function to generate preview HTML with multi-page support
    function generatePreviewHTML(exam, params) {
        console.log('generatePreviewHTML called with:', { exam, params });
        
        let html = '';
        
                // Calculate questions per page based on A4 dimensions
        const baseQuestionsPerPage = calculateQuestionsPerPage(params);
        const totalQuestions = exam.questions.length;
        
        // Calculate total pages needed - fill each page completely before moving to next
        let totalPages = 0;
        let currentIndex = 0;
        
        // Calculate pages dynamically to ensure proper filling
        while (currentIndex < totalQuestions) {
            const questionsForThisPage = calculateActualQuestionsPerPage(exam, params, currentIndex);
            console.log(`Page ${totalPages + 1}: Will contain ${questionsForThisPage} questions starting from index ${currentIndex}`);
            currentIndex += questionsForThisPage;
            totalPages++;
        }
        
        console.log(`Calculated: ${baseQuestionsPerPage} base questions per page, ${totalQuestions} total questions, ${totalPages} total pages`);
        console.log(`Page filling strategy: Fill each page completely before moving to next page`);
        
        // Generate each page
        currentIndex = 0;
        for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
            const startIndex = currentIndex;
            const questionsForThisPage = calculateActualQuestionsPerPage(exam, params, startIndex);
            const endIndex = Math.min(startIndex + questionsForThisPage, totalQuestions);
            const pageQuestions = exam.questions.slice(startIndex, endIndex);
            
            currentIndex = endIndex;
            
            console.log(`Page ${pageNum}: Questions ${startIndex + 1} to ${endIndex} (${pageQuestions.length} questions) - Filling page completely`);
            console.log(`Page ${pageNum} questions array:`, pageQuestions.map((q, i) => `Q${startIndex + i + 1}: ${q.question_text.substring(0, 30)}...`));
            console.log(`DEBUG: Page ${pageNum} - questionsForThisPage: ${questionsForThisPage}, actual questions: ${pageQuestions.length}`);
            
            // Start page container with proper paper size classes
            const paperColumns = parseInt(params.paper_columns) || 1;
            const paperSize = params.paper_size || 'A4';
            const orientation = params.orientation || 'portrait';
            const sizeClass = `${paperSize.toLowerCase()}-${orientation}`;
            const adjustToPercentage = parseInt(params.adjust_to_percentage) || 100;
            
            console.log(`Page ${pageNum}: Creating page container with sizeClass: ${sizeClass}, paperSize: ${paperSize}, orientation: ${orientation}`);
            
            // Determine scaling classes
            let scalingClasses = '';
            if (adjustToPercentage !== 100) {
                scalingClasses += ' adjust-to-percentage';
            }
            
            html += `<div class="page-container ${sizeClass}${scalingClasses}" data-columns="${paperColumns}" data-page="${pageNum}" data-paper-size="${paperSize}" data-orientation="${orientation}" style="--adjust-percentage: ${adjustToPercentage / 100};">`;
            console.log(`Created page container ${pageNum} with ${paperColumns} columns, size: ${paperSize} ${orientation}`);
            
            
            // Questions for this page - fill completely before moving to next page
            if (paperColumns > 1) {
                // Multi-column layout within the page - create a grid container that includes header
                html += `<div class="questions-grid" style="display: grid; grid-template-columns: repeat(${paperColumns}, 1fr); gap: 20px; position: relative;">`;
                
                // Header (only on first page) - handle based on span
                if (pageNum === 1 && params.include_header) {
                    const headerSpan = params.header_span || '1';
                    console.log(`Generating header with span: ${headerSpan} for ${paperColumns} columns`);
                    
                    if (headerSpan === 'full' || parseInt(headerSpan) > 1) {
                        // Header spans multiple columns - put outside grid
                        const headerContent = `
                            <div class="header-container" data-header-span="${headerSpan}" style="text-align: center; border-bottom: 2px solid #333; padding: 15px; margin-bottom: 20px; width: 100%; height: auto; min-height: auto;">
                                <div style="font-size: ${(parseInt(params.font_size) || 12) + 8}pt; font-weight: bold; margin-bottom: 3px;">${exam.title}</div>
                                <div style="font-size: ${(parseInt(params.font_size) || 12) + 4}pt; font-weight: bold; margin-bottom: 3px;">${exam.question_header || 'Model Test'}</div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; font-size: ${(parseInt(params.font_size) || 12) + 4}pt; font-weight: bold; color: #333;">
                                    <div>Full Marks: ${exam.questions.reduce((sum, q) => sum + (q.marks || 1), 0)}</div>
                                    <div>Time: ${exam.duration} minutes</div>
                                </div>
                            </div>`;
                        
                        html += headerContent;
                    }
                    // For single column header, we'll add it inside the first column
                }
                
                // Add vertical separator lines between columns (but not over header)
                const hasHeader = (pageNum === 1 && params.include_header);
                const headerSpan = params.header_span || '1';
                const headerSpansMultipleColumns = headerSpan === 'full' || parseInt(headerSpan) > 1;
                
                // Only add separators if header doesn't span all columns
                if (!headerSpansMultipleColumns) {
                    for (let i = 1; i < paperColumns; i++) {
                        html += `<div class="column-separator" style="position: absolute; top: 0; bottom: 0; left: ${(i * 100) / paperColumns}%; width: 1px; background: #333; opacity: 0.3;"></div>`;
                    }
                }
                
                // Create columns and distribute questions sequentially (fill each column completely)
                console.log(`Page ${pageNum}: Starting sequential column filling with ${paperColumns} columns`);
                
                // Calculate questions per column for this page
                const questionsPerColumn = Math.ceil(pageQuestions.length / paperColumns);
                console.log(`Page ${pageNum}: ${pageQuestions.length} questions, ${questionsPerColumn} questions per column`);
                
                // Track question index across all columns
                let globalQuestionIndex = 0;
                
                // Check if header spans only first column
                const headerSpansOnlyFirstColumn = hasHeader && !headerSpansMultipleColumns;
                
                for (let columnIndex = 0; columnIndex < paperColumns; columnIndex++) {
                    html += `<div class="question-column" data-column="${columnIndex + 1}" style="padding: 0 10px;">`;
                    
                    // Add header to first column if it spans only one column
                    if (headerSpansOnlyFirstColumn && columnIndex === 0) {
                        const headerContent = `
                            <div class="header-container" data-header-span="${headerSpan}" style="text-align: center; border-bottom: 2px solid #333; padding: 15px; margin-bottom: 20px; width: 100%; height: auto; min-height: auto;">
                                <div style="font-size: ${(parseInt(params.font_size) || 12) + 8}pt; font-weight: bold; margin-bottom: 3px;">${exam.title}</div>
                                <div style="font-size: ${(parseInt(params.font_size) || 12) + 4}pt; font-weight: bold; margin-bottom: 3px;">${exam.question_header || 'Model Test'}</div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; font-size: ${(parseInt(params.font_size) || 12) + 4}pt; font-weight: bold; color: #333;">
                                    <div>Full Marks: ${exam.questions.reduce((sum, q) => sum + (q.marks || 1), 0)}</div>
                                    <div>Time: ${exam.duration} minutes</div>
                                </div>
                            </div>`;
                        
                        html += headerContent;
                    }
                    
                    // Calculate how many questions should go in this column
                    const remainingQuestions = pageQuestions.length - globalQuestionIndex;
                    const remainingColumns = paperColumns - columnIndex;
                    const questionsInThisColumn = Math.ceil(remainingQuestions / remainingColumns);
                    
                    let questionsAdded = 0;
                    const columnQuestions = [];
                    
                    // Fill this column with questions starting from globalQuestionIndex
                    for (let i = 0; i < questionsInThisColumn && globalQuestionIndex < pageQuestions.length; i++) {
                        const question = pageQuestions[globalQuestionIndex];
                        // Calculate the correct question number based on the page and position
                        const questionNumber = startIndex + globalQuestionIndex + 1;
                        html += generateQuestionHTML(question, questionNumber, params);
                        questionsAdded++;
                        columnQuestions.push(`Q${questionNumber}`);
                        globalQuestionIndex++;
                    }
                    
                    console.log(`Page ${pageNum}, Column ${columnIndex + 1}: ${questionsAdded} questions - ${columnQuestions.join(', ')}`);
                    html += '</div>';
                }
                
                html += '</div>';
            } else {
                // Single column layout - fill page completely
                // Header (only on first page) for single column
                if (pageNum === 1 && params.include_header) {
                    const headerSpan = params.header_span || '1';
                    console.log(`Generating header for single column with span: ${headerSpan}`);
                    
                    const headerContent = `
                        <div class="header-container" data-header-span="${headerSpan}" style="text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px;">
                            <div style="font-size: ${(parseInt(params.font_size) || 12) + 8}pt; font-weight: bold; margin-bottom: 3px;">${exam.title}</div>
                            <div style="font-size: ${(parseInt(params.font_size) || 12) + 4}pt; font-weight: bold; margin-bottom: 3px;">${exam.question_header || 'Model Test'}</div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; font-size: ${(parseInt(params.font_size) || 12) + 4}pt; font-weight: bold; color: #333;">
                                <div>Full Marks: ${exam.questions.reduce((sum, q) => sum + (q.marks || 1), 0)}</div>
                                <div>Time: ${exam.duration} minutes</div>
                            </div>
                        </div>`;
                    
                    html += headerContent;
                }
                
                // Add questions
                pageQuestions.forEach((question, index) => {
                    const questionNumber = startIndex + index + 1;
                    html += generateQuestionHTML(question, questionNumber, params);
                });
            }
            
            // Close page container
            html += '</div>';
        }
        
        // No pagination needed - all pages displayed continuously
        console.log(`Generated HTML with ${totalPages} pages in continuous layout`);
        return html;
    }
    
    // Helper function to get paper dimensions in mm
    function getPaperDimensions(paperSize, orientation) {
        const dimensions = {
            'A4': { portrait: { width: 210, height: 297 }, landscape: { width: 297, height: 210 } },
            'Letter': { portrait: { width: 216, height: 279 }, landscape: { width: 279, height: 216 } }, // 8.5" x 11" in mm
            'Legal': { portrait: { width: 216, height: 356 }, landscape: { width: 356, height: 216 } }  // 8.5" x 14" in mm
        };
        
        return dimensions[paperSize][orientation] || dimensions['A4']['portrait'];
    }
    
    // Function to calculate questions per page based on selected paper size
    function calculateQuestionsPerPage(params) {
        console.log('calculateQuestionsPerPage called with params:', params);
        const fontSize = parseInt(params.font_size) || 12;
        const lineSpacing = parseFloat(params.line_spacing) || 1.5;
        const paperColumns = parseInt(params.paper_columns) || 1;
        
        // Get paper dimensions based on selected paper size and orientation
        const paperSize = params.paper_size || 'A4';
        const orientation = params.orientation || 'portrait';
        console.log('Using paper size:', paperSize, 'orientation:', orientation);
        const dimensions = getPaperDimensions(paperSize, orientation);
        console.log('Paper dimensions:', dimensions);
        
        const pageHeight = dimensions.height;
        const pageWidth = dimensions.width;
        
        // Margins (top, bottom, left, right) in mm
        const marginTop = 0;
        const marginBottom = 0;
        const marginLeft = 0;
        const marginRight = 0;
        
        // Header height in mm (if included)
        const headerHeight = params.include_header ? 20 : 0;
        
        // Available height for questions
        const availableHeight = pageHeight - marginTop - marginBottom - headerHeight;
        
        // Calculate line height in mm (font size * line spacing)
        const lineHeightMm = (fontSize * lineSpacing * 0.35); // Approximate conversion from pt to mm
        
        // Estimate questions per page based on average question height
        // Each question typically takes 3-5 lines depending on complexity
        const avgLinesPerQuestion = 4;
        const avgQuestionHeightMm = lineHeightMm * avgLinesPerQuestion;
        
        // Calculate how many questions can fit per page
        let questionsPerPage = Math.floor(availableHeight / avgQuestionHeightMm);
        
        // Adjust for multi-column layout - more questions can fit with columns
        if (paperColumns > 1) {
            // With columns, we can fit more questions vertically
            // Each column gets the full height, so we can fit more questions
            questionsPerPage = Math.floor(questionsPerPage * 2); // Double the questions with columns
        }
        
        // Ensure minimum questions per page based on paper size
        // Legal size should allow more questions than A4
        let minQuestions = 25; // Default for A4
        if (paperSize === 'Legal') {
            minQuestions = 35; // Legal is taller, can fit more questions
        } else if (paperSize === 'Letter') {
            minQuestions = 28; // Letter is slightly shorter than A4
        }
        
        questionsPerPage = Math.max(minQuestions, questionsPerPage);
        
        console.log(`${paperSize} ${orientation} Page Calculation:`, {
            paperSize,
            orientation,
            pageHeight,
            pageWidth,
            availableHeight,
            lineHeightMm,
            avgQuestionHeightMm,
            paperColumns,
            questionsPerPage
        });
        
        return questionsPerPage;
    }
    
    // Function to calculate actual questions that can fit on a page
    function calculateActualQuestionsPerPage(exam, params, startIndex) {
        const paperColumns = parseInt(params.paper_columns) || 1;
        const baseQuestionsPerPage = calculateQuestionsPerPage(params);
        const remainingQuestions = exam.questions.length - startIndex;
        
        let questionsForPage;
        
        // For multi-column layouts, we can fit more questions
        if (paperColumns > 1) {
            // With columns, we can fit significantly more questions
            // Each column gets the full height, so multiply by column count
            questionsForPage = baseQuestionsPerPage * paperColumns;
        } else {
            // For single column, use the base calculation but allow more questions
            // Use dynamic minimum based on paper size
            const paperSize = params.paper_size || 'A4';
            let minQuestions = 30; // Default for A4
            if (paperSize === 'Legal') {
                minQuestions = 40; // Legal is taller, can fit more questions
            } else if (paperSize === 'Letter') {
                minQuestions = 32; // Letter is slightly shorter than A4
            }
            questionsForPage = Math.max(baseQuestionsPerPage, minQuestions);
        }
        
        const finalCount = Math.min(questionsForPage, remainingQuestions);
        
        console.log(`calculateActualQuestionsPerPage:`, {
            paperColumns,
            baseQuestionsPerPage,
            remainingQuestions,
            questionsForPage,
            finalCount,
            startIndex
        });
        
        return finalCount;
    }
    
     // Pagination removed - all pages displayed continuously
     
     // Function to add margin area grid visualization
     function addMarginAreaGrid(pageContainer, params) {
         console.log('Adding margin area grid to page container');
         
         // Remove existing margin area grids if any
         const existingGrids = pageContainer.querySelectorAll('.margin-area-grid');
         existingGrids.forEach(grid => grid.remove());
         console.log(`Removed ${existingGrids.length} existing margin area grids`);
         
         const existingContentArea = pageContainer.querySelector('.content-area');
         if (existingContentArea) {
             existingContentArea.remove();
         }
         
         // Get margin values and convert mm to px
         const marginTop = (parseInt(params.margin_top) || 0) * 3.7795275591; // 1mm = 3.7795275591px
         const marginRight = (parseInt(params.margin_right) || 0) * 3.7795275591;
         const marginBottom = (parseInt(params.margin_bottom) || 0) * 3.7795275591;
         const marginLeft = (parseInt(params.margin_left) || 0) * 3.7795275591;
         
         console.log('Margin values (mm to px):', { marginTop, marginRight, marginBottom, marginLeft });
         console.log('Original margin values (mm):', { 
             top: parseInt(params.margin_top) || 0, 
             right: parseInt(params.margin_right) || 0, 
             bottom: parseInt(params.margin_bottom) || 0, 
             left: parseInt(params.margin_left) || 0 
         });
         
         // Create content area (shows printable area within margins)
         const contentArea = document.createElement('div');
         contentArea.className = 'content-area';
         contentArea.style.position = 'absolute';
         contentArea.style.top = marginTop;
         contentArea.style.left = marginLeft;
         contentArea.style.right = marginRight;
         contentArea.style.bottom = marginBottom;
         contentArea.style.background = 'rgba(0, 255, 0, 0.1)';
         contentArea.style.border = '2px solid rgba(0, 255, 0, 0.5)';
         contentArea.style.pointerEvents = 'none';
         contentArea.style.zIndex = '1';
         contentArea.style.width = 'auto';
         contentArea.style.height = 'auto';
         pageContainer.appendChild(contentArea);
         
         // Create margin area grids for each side (non-printable areas)
         // Top margin area
         if (marginTop > 0) {
             const topMarginArea = document.createElement('div');
             topMarginArea.className = 'margin-area-grid';
             topMarginArea.style.position = 'absolute';
             topMarginArea.style.top = '0px';
             topMarginArea.style.left = '0px';
             topMarginArea.style.right = '0px';
             topMarginArea.style.height = marginTop + 'px';
             topMarginArea.style.background = 'rgba(255, 0, 0, 0.2)';
             topMarginArea.style.pointerEvents = 'none';
             topMarginArea.style.zIndex = '-1';
             pageContainer.appendChild(topMarginArea);
         }
         
         // Bottom margin area
         if (marginBottom > 0) {
             console.log('Creating bottom margin area with height:', marginBottom + 'px');
             const bottomMarginArea = document.createElement('div');
             bottomMarginArea.className = 'margin-area-grid';
             bottomMarginArea.style.position = 'absolute';
             bottomMarginArea.style.bottom = '0px';
             bottomMarginArea.style.left = '0px';
             bottomMarginArea.style.right = '0px';
             bottomMarginArea.style.height = marginBottom + 'px';
             bottomMarginArea.style.background = 'rgba(255, 0, 0, 0.2)';
             bottomMarginArea.style.pointerEvents = 'none';
             bottomMarginArea.style.zIndex = '-1';
             pageContainer.appendChild(bottomMarginArea);
             console.log('Bottom margin area created and appended');
         } else {
             console.log('No bottom margin area created (marginBottom = 0)');
         }
         
         // Left margin area
         if (marginLeft > 0) {
             const leftMarginArea = document.createElement('div');
             leftMarginArea.className = 'margin-area-grid';
             leftMarginArea.style.position = 'absolute';
             leftMarginArea.style.top = '0px';
             leftMarginArea.style.left = '0px';
             leftMarginArea.style.width = marginLeft + 'px';
             leftMarginArea.style.bottom = '0px';
             leftMarginArea.style.background = 'rgba(255, 0, 0, 0.2)';
             leftMarginArea.style.pointerEvents = 'none';
             leftMarginArea.style.zIndex = '-1';
             pageContainer.appendChild(leftMarginArea);
         }
         
         // Right margin area
         if (marginRight > 0) {
             console.log('Creating right margin area with width:', marginRight + 'px');
             const rightMarginArea = document.createElement('div');
             rightMarginArea.className = 'margin-area-grid';
             rightMarginArea.style.position = 'absolute';
             rightMarginArea.style.top = '0px';
             rightMarginArea.style.right = '0px';
             rightMarginArea.style.width = marginRight + 'px';
             rightMarginArea.style.bottom = '0px';
             rightMarginArea.style.background = 'rgba(255, 0, 0, 0.2)';
             rightMarginArea.style.pointerEvents = 'none';
             rightMarginArea.style.zIndex = '-1';
             pageContainer.appendChild(rightMarginArea);
             console.log('Right margin area created and appended');
         } else {
             console.log('No right margin area created (marginRight = 0)');
         }
         
         // Count how many margin areas were actually created
         const createdGrids = pageContainer.querySelectorAll('.margin-area-grid');
         console.log(`Margin area grids and content area added. Total margin areas created: ${createdGrids.length}`);
         
         // Log what margin areas exist
         createdGrids.forEach((grid, index) => {
             const rect = grid.getBoundingClientRect();
             console.log(`Margin area ${index + 1}:`, {
                 position: grid.style.position,
                 top: grid.style.top,
                 right: grid.style.right,
                 bottom: grid.style.bottom,
                 left: grid.style.left,
                 width: grid.style.width,
                 height: grid.style.height,
                 background: grid.style.background,
                 zIndex: grid.style.zIndex
             });
         });
     }
     
          // Function to generate HTML for a single question
     function generateQuestionHTML(question, questionNumber, params) {
         let questionContent = `<div style="margin-bottom: 10px;">`;
        
                 if (question.question_header) {
             questionContent += `<div style="margin: 5px 0; font-style: italic; color: #666;">${question.question_header}</div>`;
         }
         
         // Clean question text to remove any "(Question #X)" patterns
         const cleanQuestionText = question.question_text.replace(/\(Question\s*#\d+\)/gi, '').trim();
         questionContent += `<div style="margin: 5px 0; font-weight: bold; color: #333;">${questionNumber}. ${cleanQuestionText}</div>`;
        
        if (question.question_type === 'mcq') {
            const columns = parseInt(params.mcq_columns) || 4;
            const options = [
                { label: 'A', text: question.option_a },
                { label: 'B', text: question.option_b },
                { label: 'C', text: question.option_c },
                { label: 'D', text: question.option_d }
            ].filter(opt => opt.text); // Only include options that have text
            
                         questionContent += '<div style="margin-left: 15px;">';
             questionContent += `<div style="display: grid; grid-template-columns: repeat(${columns}, 1fr); gap: 10px; margin: 5px 0; row-gap: 5px;">`;
            
            // Generate options based on column count
            options.forEach((option, optionIndex) => {
                // Check if this is the correct answer from database
                // Handle both string and numeric correct answers
                let isCorrectAnswer = false;
                
                if (question.correct_answer) {
                    // Try to match the correct answer with the option label
                    if (typeof question.correct_answer === 'string') {
                        isCorrectAnswer = option.label === question.correct_answer.toUpperCase();
                    } else if (typeof question.correct_answer === 'number') {
                        // If correct_answer is numeric (1,2,3,4), convert to letter
                        const answerMap = {1: 'A', 2: 'B', 3: 'C', 4: 'D'};
                        isCorrectAnswer = option.label === answerMap[question.correct_answer];
                    }
                }
                
                // Debug logging
                console.log(`Question ${questionNumber}, Option ${option.label}:`, {
                    correct_answer: question.correct_answer,
                    correct_answer_type: typeof question.correct_answer,
                    option_label: option.label,
                    isCorrect: isCorrectAnswer,
                    mark_answer: params.mark_answer
                });
                
                // Determine circle styling based on mark answer setting
                let circleStyle = 'width: 20px; height: 20px; border: 2px solid #333; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 8px; font-size: 10pt; font-weight: bold; line-height: 1; text-align: center; position: relative;';
                
                if (params.mark_answer && isCorrectAnswer) {
                    // Fill the circle for correct answer when mark answer is checked
                    circleStyle = 'width: 20px; height: 20px; border: 2px solid #333; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 8px; font-size: 10pt; font-weight: bold; line-height: 1; text-align: center; position: relative; background-color: #333; color: white;';
                    console.log(`Filling circle for correct answer: ${option.label}`);
                }
                
                questionContent += `<div style="margin: 2px 0; display: flex; align-items: center;">
                    <div style="${circleStyle}">
                        <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); margin: 0; padding: 0;">${option.label}</span>
                    </div>
                    <span>${option.text}</span>
                </div>`;
            });
            
            questionContent += '</div>';
            questionContent += '</div>';
        }
        
        questionContent += '</div>';
        return questionContent;
    }
    
         // Add event listeners to all form inputs
     const inputs = form.querySelectorAll('input, select');
     inputs.forEach(input => {
         input.addEventListener('change', updatePreview);
         input.addEventListener('input', updatePreview);
     });
     
     // True Size Toggle functionality
     const trueSizeToggle = document.getElementById('trueSizeToggle');
     const scaleIndicator = document.getElementById('scaleIndicator');
     let isTrueSize = false;
     
     if (trueSizeToggle) {
         trueSizeToggle.addEventListener('click', function() {
             isTrueSize = !isTrueSize;
             
             if (isTrueSize) {
                 // Enable true size mode
                 previewContainer.classList.add('true-size');
                 trueSizeToggle.innerHTML = '📐 Fit Screen';
                 trueSizeToggle.className = 'px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-md';
                 scaleIndicator.textContent = 'True paper size (scroll to see full page)';
                 
                 // Log the actual dimensions
                 const pageContainers = document.querySelectorAll('.page-container');
                 if (pageContainers.length > 0) {
                     const firstPage = pageContainers[0];
                     const computedStyle = window.getComputedStyle(firstPage);
                     console.log('True Size Mode - Actual dimensions:', {
                         width: computedStyle.width,
                         height: computedStyle.height,
                         paperSize: firstPage.getAttribute('data-paper-size'),
                         orientation: firstPage.getAttribute('data-orientation')
                     });
                 }
             } else {
                 // Enable scaled mode
                 previewContainer.classList.remove('true-size');
                 trueSizeToggle.innerHTML = '📏 True Size';
                 trueSizeToggle.className = 'px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-lg hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 transition-all duration-200 shadow-md';
                 scaleIndicator.textContent = 'Scaled to fit screen';
                 
                 console.log('Scaled Mode - Preview scaled for screen display');
             }
         });
     }
     
     // PDF Download functionality
     const downloadPdfBtn = document.getElementById('downloadPdfBtn');
     if (downloadPdfBtn) {
         downloadPdfBtn.addEventListener('click', function() {
             downloadPDF();
         });
     }
     
     
     // Function to download PDF
     function downloadPDF() {
         const downloadBtn = document.getElementById('downloadPdfBtn');
         const originalText = downloadBtn.innerHTML;
         
         // Show loading state
         downloadBtn.innerHTML = '⏳ Generating PDF...';
         downloadBtn.disabled = true;
         
         try {
             // Get the current preview HTML with exact page break styles
             let previewHTML = previewContainer.innerHTML;
             
             // Debug: Log the number of page containers in preview
             const tempDiv = document.createElement('div');
             tempDiv.innerHTML = previewHTML;
             const pageContainers = tempDiv.querySelectorAll('.page-container');
             console.log(`Preview contains ${pageContainers.length} page containers`);
             
             // CRITICAL: Convert ALL computed styles to inline styles for pixel-perfect matching
             function convertComputedStylesToInline(element) {
                 const computedStyle = window.getComputedStyle(element);
                 const importantStyles = [
                     'font-family', 'font-size', 'font-weight', 'font-style',
                     'line-height', 'color', 'background-color', 'background',
                     'margin', 'margin-top', 'margin-right', 'margin-bottom', 'margin-left',
                     'padding', 'padding-top', 'padding-right', 'padding-bottom', 'padding-left',
                     'border', 'border-top', 'border-right', 'border-bottom', 'border-left',
                     'border-radius', 'border-width', 'border-style', 'border-color',
                     'box-shadow', 'text-align', 'text-decoration', 'text-transform',
                     'width', 'height', 'min-width', 'min-height', 'max-width', 'max-height',
                     'display', 'position', 'top', 'right', 'bottom', 'left',
                     'z-index', 'overflow', 'visibility', 'opacity',
                     'page-break-before', 'page-break-after', 'page-break-inside',
                     'break-before', 'break-after', 'break-inside'
                 ];
                 
                 let inlineStyles = '';
                 importantStyles.forEach(style => {
                     const value = computedStyle.getPropertyValue(style);
                     if (value && value !== 'initial' && value !== 'inherit' && value !== 'normal') {
                         inlineStyles += `${style}: ${value} !important; `;
                     }
                 });
                 
                 if (inlineStyles) {
                     element.setAttribute('style', inlineStyles + (element.getAttribute('style') || ''));
                 }
                 
                 // Apply to all child elements
                 Array.from(element.children).forEach(child => {
                     convertComputedStylesToInline(child);
                 });
             }
             
             // Apply computed styles to all elements in the preview
             const previewClone = previewContainer.cloneNode(true);
             convertComputedStylesToInline(previewClone);
             
             // Ensure page break styles are properly set
             const clonedPageContainers = previewClone.querySelectorAll('.page-container');
             clonedPageContainers.forEach((page, index) => {
                 if (index === clonedPageContainers.length - 1) {
                     // Last page - no page break
                     page.style.setProperty('page-break-after', 'avoid', 'important');
                     page.style.setProperty('break-after', 'avoid', 'important');
                 } else {
                     // All other pages - page break after
                     page.style.setProperty('page-break-after', 'always', 'important');
                     page.style.setProperty('break-after', 'page', 'important');
                 }
             });
             
             // Get the HTML with all inline styles
             previewHTML = previewClone.innerHTML;
             
             // Debug: Log page break styles
             const finalTempDiv = document.createElement('div');
             finalTempDiv.innerHTML = previewHTML;
             const finalPageContainers = finalTempDiv.querySelectorAll('.page-container');
             console.log('Page break styles in final HTML:');
             finalPageContainers.forEach((page, index) => {
                 const pageBreakAfter = page.style.pageBreakAfter;
                 const breakAfter = page.style.breakAfter;
                 console.log(`Page ${index + 1}: page-break-after="${pageBreakAfter}", break-after="${breakAfter}"`);
             });
             
             // Get form parameters
             const formData = new FormData(form);
             const params = Object.fromEntries(formData.entries());
             
             // Debug: Log the parameters being sent
             console.log('Form parameters being sent to PDF:', params);
             console.log('Paper size:', params.paper_size);
             console.log('Orientation:', params.orientation);
             console.log('Font family:', params.font_family);
             console.log('Font size:', params.font_size);
             console.log('Line spacing:', params.line_spacing);
             console.log('Margins:', {
                 top: params.margin_top,
                 right: params.margin_right,
                 bottom: params.margin_bottom,
                 left: params.margin_left
             });
             
             // Create the complete HTML for PDF generation
             const completeHTML = createCompleteHTMLForPDF(previewHTML, params);
             
             // Send to server for PDF generation
             fetch('{{ route("partner.exams.download-paper", $exam) }}', {
                 method: 'POST',
                 headers: {
                     'Content-Type': 'application/json',
                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                 },
                 body: JSON.stringify({
                     preview_html: completeHTML,
                     parameters: params
                 })
             })
             .then(response => {
                 if (!response.ok) {
                     throw new Error(`HTTP error! status: ${response.status}`);
                 }
                 return response.blob();
             })
             .then(blob => {
                 // Create download link
                 const url = window.URL.createObjectURL(blob);
                 const a = document.createElement('a');
                 a.href = url;
                 a.download = 'question_paper_{{ $exam->id }}_' + new Date().toISOString().slice(0,19).replace(/:/g, '-') + '.pdf';
                 document.body.appendChild(a);
                 a.click();
                 window.URL.revokeObjectURL(url);
                 document.body.removeChild(a);
                 
                 // Show success message
                 downloadBtn.innerHTML = '✅ PDF Downloaded!';
                 setTimeout(() => {
                     downloadBtn.innerHTML = originalText;
                     downloadBtn.disabled = false;
                 }, 2000);
             })
             .catch(error => {
                 console.error('PDF Generation Error:', error);
                 
                 // Show error message
                 downloadBtn.innerHTML = '❌ Failed to Generate PDF';
                 setTimeout(() => {
                     downloadBtn.innerHTML = originalText;
                     downloadBtn.disabled = false;
                 }, 3000);
                 
                 alert('Failed to generate PDF: ' + error.message + '\n\nPlease try again or contact support if the problem persists.');
             });
         } catch (error) {
             console.error('Preview Generation Error:', error);
             downloadBtn.innerHTML = '❌ Preview Error';
             setTimeout(() => {
                 downloadBtn.innerHTML = originalText;
                 downloadBtn.disabled = false;
             }, 3000);
             alert('Failed to generate preview content. Please refresh the page and try again.');
         }
     }
     
     // Helper functions for page dimensions
     function getPageWidth(params) {
         const paperSize = params.paper_size || 'A4';
         const orientation = params.orientation || 'portrait';
         
         if (paperSize === 'A4') {
             return orientation === 'landscape' ? '297mm' : '210mm';
         } else if (paperSize === 'Letter') {
             return orientation === 'landscape' ? '11in' : '8.5in';
         } else if (paperSize === 'Legal') {
             return orientation === 'landscape' ? '14in' : '8.5in';
         }
         return '210mm'; // Default to A4 portrait
     }
     
     function getPageHeight(params) {
         const paperSize = params.paper_size || 'A4';
         const orientation = params.orientation || 'portrait';
         
         if (paperSize === 'A4') {
             return orientation === 'landscape' ? '210mm' : '297mm';
         } else if (paperSize === 'Letter') {
             return orientation === 'landscape' ? '8.5in' : '11in';
         } else if (paperSize === 'Legal') {
             return orientation === 'landscape' ? '8.5in' : '14in';
         }
         return '297mm'; // Default to A4 portrait
     }
     
     // Function to create pixel-perfect HTML for PDF generation
     function createCompleteHTMLForPDF(previewHTML, params) {
         // Debug: Log the parameters being used
         console.log('PDF Generation Parameters:', params);
         console.log('Preview HTML length:', previewHTML.length);
         
         // Log sample of the HTML to verify inline styles are captured
         const sampleDiv = document.createElement('div');
         sampleDiv.innerHTML = previewHTML;
         const firstPage = sampleDiv.querySelector('.page-container');
         if (firstPage) {
             console.log('First page inline styles:', firstPage.getAttribute('style'));
         }
         
         // Get exact computed styles from the preview for fallback
         const previewElement = document.getElementById('livePreview');
         const computedStyles = window.getComputedStyle(previewElement);
         
         const exactStyles = {
             fontFamily: computedStyles.fontFamily,
             fontSize: computedStyles.fontSize,
             lineHeight: computedStyles.lineHeight,
             color: computedStyles.color,
             backgroundColor: computedStyles.backgroundColor
         };
         
         return `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Paper - {{ $exam->title }}</title>
    <style>
        @page {
            size: ${params.paper_size || 'A4'} ${params.orientation || 'portrait'};
            margin: ${params.margin_top || '0'}mm ${params.margin_right || '0'}mm ${params.margin_bottom || '0'}mm ${params.margin_left || '0'}mm;
        }
        
        * {
            box-sizing: border-box;
        }
        
        body { 
            font-family: "${exactStyles.fontFamily}" !important;
            font-size: ${exactStyles.fontSize} !important;
            line-height: ${exactStyles.lineHeight} !important;
            color: ${exactStyles.color} !important;
            background-color: ${exactStyles.backgroundColor} !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* PIXEL-PERFECT MATCHING - Use exact preview styles */
        #livePreview {
            font-family: "${exactStyles.fontFamily}" !important;
            font-size: ${exactStyles.fontSize} !important;
            line-height: ${exactStyles.lineHeight} !important;
            color: ${exactStyles.color} !important;
            background-color: ${exactStyles.backgroundColor} !important;
            margin: ${exactStyles.margin} !important;
            padding: ${exactStyles.padding} !important;
            border: ${exactStyles.border} !important;
            border-radius: ${exactStyles.borderRadius} !important;
            box-shadow: ${exactStyles.boxShadow} !important;
            display: block !important;
            overflow: visible !important;
        }
        
        /* Exact page container styling - match preview pixel by pixel */
        .page-container {
            border: 1px solid #3b82f6 !important;
            background: white !important;
            margin: 0 !important;
            padding: ${params.margin_top || '0'}mm ${params.margin_right || '0'}mm ${params.margin_bottom || '0'}mm ${params.margin_left || '0'}mm !important;
            border-radius: 0 !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            width: ${getPageWidth(params)} !important;
            min-height: ${getPageHeight(params)} !important;
            max-width: ${getPageWidth(params)} !important;
            box-sizing: border-box !important;
            position: relative !important;
            text-align: left !important;
        }
        
        /* Scaling functionality for PDF */
        .adjust-to-percentage {
            transform: scale(var(--adjust-percentage, 1)) !important;
            transform-origin: center !important;
        }
        
        
        
        /* Apply exact same styling as preview to ALL elements */
        .page-container, .page-container * {
            font-family: "${exactStyles.fontFamily}" !important;
            font-size: ${exactStyles.fontSize} !important;
            line-height: ${exactStyles.lineHeight} !important;
            color: ${exactStyles.color} !important;
        }
        
        /* Ensure all text elements use the exact preview font */
        h1, h2, h3, h4, h5, h6, p, div, span, li, td, th, label, input, textarea, select {
            font-family: "${exactStyles.fontFamily}" !important;
            font-size: ${exactStyles.fontSize} !important;
            line-height: ${exactStyles.lineHeight} !important;
            color: ${exactStyles.color} !important;
        }
        
        /* Header styling - exact match */
        .header-container {
            background: rgba(248, 250, 252, 0.8) !important;
            border-radius: 4px !important;
            padding: 5px !important;
            margin-bottom: 2px !important;
            text-align: center !important;
            border-bottom: 2px solid #333 !important;
            padding-bottom: 2px !important;
            margin-bottom: 2px !important;
            width: 100% !important;
            clear: both !important;
            font-family: "${exactStyles.fontFamily}" !important;
            font-size: ${exactStyles.fontSize} !important;
            line-height: ${exactStyles.lineHeight} !important;
            color: ${exactStyles.color} !important;
        }
        
        /* Question styling - exact match */
        .question {
            margin-bottom: 8px !important;
            padding: 5px !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 2px !important;
            font-family: "${exactStyles.fontFamily}" !important;
            font-size: ${exactStyles.fontSize} !important;
            line-height: ${exactStyles.lineHeight} !important;
            color: ${exactStyles.color} !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        
        /* Page breaks - exact match to preview */
        .page-container {
            page-break-after: always !important;
            break-after: page !important;
        }
        
        .page-container:last-child {
            page-break-after: avoid !important;
            break-after: avoid !important;
        }
        
        /* Override with inline styles if they exist */
        .page-container[style*="page-break-after: always"] {
            page-break-after: always !important;
            break-after: page !important;
        }
        
        .page-container[style*="page-break-after: avoid"] {
            page-break-after: avoid !important;
            break-after: avoid !important;
        }
        
        /* Additional page break rules for better PDF compatibility */
        .page-container[data-page="1"] {
            page-break-before: auto !important;
        }
        
        .page-container[data-page]:not([data-page="1"]) {
            page-break-before: always !important;
        }
        
        /* Ensure headers don't break */
        .header-container {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        
        .page-title {
            position: absolute !important;
            top: -12px !important;
            left: 20px !important;
            background: white !important;
            padding: 0 8px !important;
            font-size: 12px !important;
            color: #6b7280 !important;
            font-weight: 500 !important;
            font-family: "${exactStyles.fontFamily}" !important;
        }
        
        .questions-grid {
            position: relative !important;
            overflow: hidden !important;
        }
        
        .column-separator {
            position: absolute !important;
            top: 0 !important;
            bottom: 0 !important;
            width: 1px !important;
            background: #333 !important;
            opacity: 0.3 !important;
            z-index: 1 !important;
        }
        
        .question-column {
            padding: 0 5px !important;
            min-width: 0 !important;
            float: left !important;
            box-sizing: border-box !important;
        }
        
        /* Column widths for different layouts */
        .question-column[data-columns="2"] {
            width: 50% !important;
        }
        
        .question-column[data-columns="3"] {
            width: 33.333% !important;
        }
        
        .question-column[data-columns="4"] {
            width: 25% !important;
        }
        
        .question-column[data-columns="5"] {
            width: 20% !important;
        }
        
        /* Clear floats */
        .questions-grid::after {
            content: "" !important;
            display: table !important;
            clear: both !important;
        }
        
        .pagination {
            display: none !important;
        }
        
        /* Print-specific styles - maintain exact appearance */
        @media print {
            body { 
                margin: 0 !important; 
                padding: 0 !important;
            }
            .page-container { 
                margin: 0 !important; 
                padding: ${params.margin_top || '0'}mm ${params.margin_right || '0'}mm ${params.margin_bottom || '0'}mm ${params.margin_left || '0'}mm !important;
            }
        }
    </style>
</head>
<body>
    <div id="livePreview">
        ${previewHTML}
    </div>
</body>
</html>`;
     }
     
     

     
             // Initial preview
        console.log('DOM loaded, calling updatePreview');
        updatePreview();
        
    });
</script>
@endsection
