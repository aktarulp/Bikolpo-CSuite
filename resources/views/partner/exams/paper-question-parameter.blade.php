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
            border: 2px solid #3b82f6; /* Blue border for A4 */
        }
        
        #livePreview .page-container.a4-landscape {
            width: 297mm;
            min-height: 210mm;
            border: 2px solid #3b82f6; /* Blue border for A4 */
        }
        
        /* Letter size */
        #livePreview .page-container.letter-portrait {
            width: 216mm;
            min-height: 279mm;
            border: 2px solid #10b981; /* Green border for Letter */
        }
        
        #livePreview .page-container.letter-landscape {
            width: 279mm;
            min-height: 216mm;
            border: 2px solid #10b981; /* Green border for Letter */
        }
        
        /* Legal size */
        #livePreview .page-container.legal-portrait {
            width: 216mm;
            min-height: 356mm;
            border: 2px solid #f59e0b; /* Orange border for Legal */
        }
        
        #livePreview .page-container.legal-landscape {
            width: 356mm;
            min-height: 216mm;
            border: 2px solid #f59e0b; /* Orange border for Legal */
        }
        
        
        /* Dynamic preview container sizing based on paper size */
        #livePreview.preview-a4 {
            max-width: 800px;
        }
        
        #livePreview.preview-letter {
            max-width: 820px;
        }
        
        #livePreview.preview-legal {
            max-width: 820px;
        }
        
        #livePreview.preview-a4-landscape,
        #livePreview.preview-letter-landscape,
        #livePreview.preview-legal-landscape {
            max-width: 1100px;
        }
        
        /* Responsive scaling for smaller screens */
        @media (max-width: 1200px) {
            #livePreview .page-container {
                transform: scale(0.8);
                transform-origin: top center;
            }
            #livePreview.preview-a4-landscape,
            #livePreview.preview-letter-landscape,
            #livePreview.preview-legal-landscape {
                max-width: 900px;
            }
        }
        
        @media (max-width: 900px) {
            #livePreview .page-container {
                transform: scale(0.6);
                transform-origin: top center;
            }
            #livePreview.preview-a4,
            #livePreview.preview-letter,
            #livePreview.preview-legal {
                max-width: 600px;
            }
            #livePreview.preview-a4-landscape,
            #livePreview.preview-letter-landscape,
            #livePreview.preview-legal-landscape {
                max-width: 700px;
            }
        }
        
        @media (max-width: 600px) {
            #livePreview .page-container {
                transform: scale(0.4);
                transform-origin: top center;
            }
            #livePreview.preview-a4,
            #livePreview.preview-letter,
            #livePreview.preview-legal,
            #livePreview.preview-a4-landscape,
            #livePreview.preview-letter-landscape,
            #livePreview.preview-legal-landscape {
                max-width: 100%;
            }
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
     
     /* Paper Container Layout - matching PHP method */
     .paper-container {
         background: white;
         border: 2px solid #3b82f6;
         margin: 0 auto;
         display: grid;
         gap: 20px;
         padding: 20px;
         box-sizing: border-box;
         position: relative;
         page-break-inside: avoid;
         break-inside: avoid;
     }
     
     .paper-container.paper-columns-1 {
         grid-template-columns: 1fr;
     }
     
     .paper-container.paper-columns-2 {
         grid-template-columns: 1fr 1fr;
         gap: 10px;
         padding: 15px;
     }
     
     .paper-container.paper-columns-3 {
         grid-template-columns: 1fr 1fr 1fr;
         gap: 10px;
         padding: 15px;
     }
     
     .paper-container.paper-columns-4 {
         grid-template-columns: 1fr 1fr 1fr 1fr;
         gap: 10px;
         padding: 15px;
     }
     
     /* Question column containers for sequential filling */
     .paper-container .question-column {
         display: flex;
         flex-direction: column;
         min-height: 0;
         background: rgba(248, 250, 252, 0.3);
         border: 1px dashed #cbd5e1;
         border-radius: 4px;
         padding: 10px;
         margin-bottom: 5px;
     }
     
     .paper-container .question-column[data-column="1"] {
         background: rgba(239, 246, 255, 0.5); /* Blue tint for first column */
     }
     
     .paper-container .question-column[data-column="2"] {
         background: rgba(236, 253, 245, 0.5); /* Green tint for second column */
     }
     
     .paper-container .question-column[data-column="3"] {
         background: rgba(255, 251, 235, 0.5); /* Yellow tint for third column */
     }
     
     .paper-container .question-column[data-column="4"] {
         background: rgba(254, 242, 242, 0.5); /* Red tint for fourth column */
     }
     
     /* Footer spanning all columns */
     .paper-container .footer {
         margin-top: 40px;
         text-align: center;
         color: #666;
         border-top: 1px solid #ccc;
         padding-top: 20px;
         font-size: 0.9em;
     }
     
     /* Header Container */
     .paper-container .header-container {
         text-align: center;
         border-bottom: 2px solid #333;
         padding-bottom: 15px;
         margin-bottom: 20px;
         background: rgba(248, 250, 252, 0.8);
         border-radius: 4px;
         padding: 15px;
     }
     
     .paper-container .exam-title {
         font-weight: bold;
         margin-bottom: 10px;
     }
     
     .paper-container .exam-info {
         color: #666;
     }
     
     .paper-container .question-header {
         margin: 15px 0;
         padding: 15px;
         background: #f9f9f9;
         border-radius: 5px;
     }
     
     /* Question styling within paper container */
     .paper-container .question {
         margin-bottom: 10px;
         page-break-inside: avoid;
         break-inside: avoid;
     }
     
     .paper-container .question-number {
         font-weight: bold;
         color: #333;
     }
     
     .paper-container .question-text {
         margin: 5px 0;
     }
     
     .paper-container .marks {
         font-weight: bold;
         color: #333;
         float: right;
     }
     
     /* MCQ Options Grid */
     .paper-container .mcq-options {
         display: grid;
         gap: 10px;
         margin: 5px 0;
     }
     
     .paper-container .mcq-options.columns-1 { grid-template-columns: 1fr; }
     .paper-container .mcq-options.columns-2 { grid-template-columns: 1fr 1fr; }
     .paper-container .mcq-options.columns-3 { grid-template-columns: 1fr 1fr 1fr; }
     .paper-container .mcq-options.columns-4 { grid-template-columns: 1fr 1fr 1fr 1fr; }
     
     .paper-container .option {
         margin: 5px 0;
     }
     
     /* Paper size specific styling for preview */
     #livePreview .paper-container {
         max-width: 800px;
         min-height: 600px;
     }
     
     /* A4 dimensions */
     #livePreview.preview-a4 .paper-container {
         width: 210mm;
         min-height: 297mm;
     }
     
     #livePreview.preview-a4-landscape .paper-container {
         width: 297mm;
         min-height: 210mm;
     }
     
     /* Letter dimensions */
     #livePreview.preview-letter .paper-container {
         width: 216mm;
         min-height: 279mm;
         border-color: #10b981;
     }
     
     #livePreview.preview-letter-landscape .paper-container {
         width: 279mm;
         min-height: 216mm;
         border-color: #10b981;
     }
     
     /* Legal dimensions */
     #livePreview.preview-legal .paper-container {
         width: 216mm;
         min-height: 356mm;
         border-color: #f59e0b;
     }
     
     #livePreview.preview-legal-landscape .paper-container {
         width: 356mm;
         min-height: 216mm;
         border-color: #f59e0b;
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
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 shadow-xl rounded-xl border-2 border-blue-200 dark:border-blue-800 mb-6 relative overflow-hidden">
            <!-- Decorative background pattern -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-blue-100/30 to-transparent dark:from-blue-800/20 dark:to-transparent rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-indigo-100/30 to-transparent dark:from-indigo-800/20 dark:to-transparent rounded-full translate-y-12 -translate-x-12"></div>
            
            <div class="px-4 py-3 border-b border-blue-200 dark:border-blue-800 bg-gradient-to-l from-blue-100/50 to-indigo-100/50 dark:from-blue-900/30 dark:to-indigo-900/30 relative">
                <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-blue-900 dark:text-blue-100 bg-gradient-to-r from-blue-800 to-indigo-800 dark:from-blue-200 dark:to-indigo-200 bg-clip-text text-transparent">Paper Settings</h3>
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                            <div class="w-2 h-2 bg-indigo-400 rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
                </div>
            </div>
            
                    <button type="button" id="saveSettingsBtn"
                            class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <span>Save Settings</span>
                    </button>
                </div>
            </div>
            
            <form id="parameterForm" action="{{ route('partner.exams.download-paper', $exam) }}" method="POST" class="p-4">
                @csrf
                
                <!-- Hidden data for JavaScript -->
                <div id="examData" 
                     data-title="{{ addslashes($exam->title) }}"
                     data-id="{{ $exam->id }}"
                     data-duration="{{ $exam->duration }}"
                     data-total-questions="{{ $exam->questions->count() }}"
                     data-passing-marks="{{ $exam->passing_marks }}"
                     data-question-header="{{ addslashes($exam->question_header ?? "") }}"
                     data-partner-name="{{ addslashes($partner->name ?? 'Unknown Partner') }}"
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
                
                <!-- Compact Settings Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        
                    <!-- Paper Format -->
                    <div class="bg-gradient-to-br from-white to-blue-50/30 dark:from-gray-800 dark:to-blue-900/20 border-2 border-blue-200 dark:border-blue-700 rounded-xl p-3 shadow-lg relative overflow-hidden">
                        <!-- Subtle background pattern -->
                        <div class="absolute top-0 right-0 w-16 h-16 bg-blue-100/20 dark:bg-blue-800/10 rounded-full -translate-y-8 translate-x-8"></div>
                        
                        <div class="flex items-center space-x-2 mb-3 relative">
                            <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-sm">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xs font-bold text-blue-800 dark:text-blue-200 uppercase tracking-wide">Paper Format</h4>
                        </div>
                        
                        <div class="space-y-2">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label for="paper_size" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Size</label>
                                    <select id="paper_size" name="paper_size" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                        <option value="A4" selected>A4</option>
                                        <option value="Letter">Letter</option>
                                        <option value="Legal">Legal</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="orientation" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Orientation</label>
                                    <select id="orientation" name="orientation" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                        <option value="portrait" selected>Portrait</option>
                                        <option value="landscape">Landscape</option>
                                    </select>
                                </div>
                                </div>
                                
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label for="paper_columns" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Columns</label>
                                    <select id="paper_columns" name="paper_columns" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                            </div>
                            
                                    <div>
                                    <label for="adjust_to_percentage" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Scale (%)</label>
                                    <input type="number" id="adjust_to_percentage" name="adjust_to_percentage" value="100" min="10" max="500" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                    </div>
                                    </div>
                            
                            <div class="grid grid-cols-4 gap-2">
                                <div>
                                    <label for="margin_top" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Top</label>
                                    <input type="number" id="margin_top" name="margin_top" value="0" min="0" max="50" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                </div>
                                
                                <div>
                                    <label for="margin_bottom" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Bottom</label>
                                    <input type="number" id="margin_bottom" name="margin_bottom" value="0" min="0" max="50" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                </div>
                                
                                <div>
                                    <label for="margin_left" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Left</label>
                                    <input type="number" id="margin_left" name="margin_left" value="0" min="0" max="50" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                </div>
                                
                                <div>
                                    <label for="margin_right" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Right</label>
                                    <input type="number" id="margin_right" name="margin_right" value="0" min="0" max="50" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                </div>
                            </div>
                                </div>
                            </div>
                            
                    <!-- Typography & Content -->
                    <div class="bg-gradient-to-br from-white to-indigo-50/30 dark:from-gray-800 dark:to-indigo-900/20 border-2 border-indigo-200 dark:border-indigo-700 rounded-xl p-3 shadow-lg relative overflow-hidden">
                        <!-- Subtle background pattern -->
                        <div class="absolute top-0 right-0 w-16 h-16 bg-indigo-100/20 dark:bg-indigo-800/10 rounded-full -translate-y-8 translate-x-8"></div>
                        
                        <div class="flex items-center justify-between mb-3 relative">
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-sm">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-xs font-bold text-indigo-800 dark:text-indigo-200 uppercase tracking-wide">Typography & Content</h4>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="include_header" name="include_header" value="1" checked class="w-3 h-3 text-indigo-600 bg-white border-indigo-300 rounded focus:ring-indigo-500 focus:ring-1 dark:focus:ring-indigo-400 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-indigo-600">
                                <label for="include_header" class="text-xs font-medium text-indigo-600 dark:text-indigo-400">Include Header</label>
                            </div>
                                </div>
                                
                        <div class="space-y-2">
                            <div class="grid grid-cols-2 gap-2">
                                        <div>
                                    <label for="font_family" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Font</label>
                                    <select id="font_family" name="font_family" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                         <option value="Arial">Arial</option>
                                         <option value="Times New Roman">Times New Roman</option>
                                         <option value="Calibri" selected>Calibri</option>
                                         <option value="Georgia">Georgia</option>
                                         <option value="Verdana">Verdana</option>
                                     </select>
                                </div>
                                
                                <div>
                                    <label for="font_size" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Size</label>
                                    <select id="font_size" name="font_size" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                         <option value="10" selected>10pt</option>
                                         <option value="11">11pt</option>
                                         <option value="12">12pt</option>
                                         <option value="14">14pt</option>
                                         <option value="16">16pt</option>
                                     </select>
                                </div>
                                </div>
                                
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label for="line_spacing" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Line Spacing</label>
                                    <select id="line_spacing" name="line_spacing" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                        <option value="1.0" selected>Single</option>
                                         <option value="1.15">1.15</option>
                                         <option value="1.5">1.5</option>
                                        <option value="2.0">Double</option>
                                     </select>
                                </div>
                                
                                <div>
                                    <label for="mcq_columns" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">MCQ Columns</label>
                                    <select id="mcq_columns" name="mcq_columns" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                         <option value="1">1</option>
                                         <option value="2">2</option>
                                         <option value="3">3</option>
                                         <option value="4" selected>4</option>
                                     </select>
                        </div>
                                </div>
                                
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label for="header_span" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Header Span</label>
                                    <select id="header_span" name="header_span" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                        <option value="1" selected>1 Column</option>
                                        <option value="2">2 Columns</option>
                                        <option value="3">3 Columns</option>
                                        <option value="4">4 Columns</option>
                                        <option value="full">Full Width</option>
                                                 </select>
                                             </div>
                                
                                <div>
                                    <label for="header_push" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Header Push</label>
                                    <select id="header_push" name="header_push" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                        <option value="1st_col" selected>1st Column</option>
                                        <option value="2nd_col">2nd Column</option>
                                        <option value="3rd_col">3rd Column</option>
                                        <option value="4th_col">4th Column</option>
                                                 </select>
                                        </div>
                                  </div>
                                  
                            <div class="grid grid-cols-2 gap-2">
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="mark_answer" name="mark_answer" value="1" class="w-3 h-3 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-1 dark:focus:ring-blue-400 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="mark_answer" class="text-xs font-medium text-gray-600 dark:text-gray-400">Mark Correct Answers</label>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="show_page_number" name="show_page_number" value="1" class="w-3 h-3 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-1 dark:focus:ring-blue-400 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="show_page_number" class="text-xs font-medium text-gray-600 dark:text-gray-400">Show Page Number</label>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                                 <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-4 mt-4 border-t-2 border-blue-200 dark:border-blue-800 bg-gradient-to-r from-blue-50/50 to-indigo-50/50 dark:from-blue-900/20 dark:to-indigo-900/20 -mx-4 px-4 py-4 relative">
                    <!-- Decorative elements -->
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    
                     <a href="{{ route('partner.exams.show', $exam) }}" 
                       class="flex items-center space-x-2 px-4 py-2.5 text-sm font-medium text-blue-700 dark:text-blue-300 hover:text-blue-900 dark:hover:text-blue-100 bg-white dark:bg-gray-800 border-2 border-blue-200 dark:border-blue-700 rounded-xl hover:shadow-lg hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>Back to Exam</span>
                     </a>
                     
                     <button type="button" id="downloadPdfBtn"
                            class="flex items-center space-x-2 px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
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
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-xs text-gray-500">Paper Size:</span>
                            <span id="currentPaperSize" class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded">A4 Portrait</span>
                    </div>
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
    
    // Define updatePreview function first
    function updatePreview() {
        try {
            console.log('🚀 updatePreview called');
            
            // Get elements fresh to avoid scope issues
            const currentForm = document.getElementById('parameterForm');
            const currentPreviewContainer = document.getElementById('livePreview');
            
            // Check if form exists
            if (!currentForm) {
                console.error('❌ Form not found!');
                return;
            }
            
            // Check if previewContainer exists
            if (!currentPreviewContainer) {
                console.error('❌ Preview container not found!');
                return;
            }
            
            console.log('✅ Both form and previewContainer found');
        
        // First, let's clear the placeholder message
        currentPreviewContainer.innerHTML = '<div class="text-center text-blue-500 py-4">🔄 Generating preview...</div>';
        console.log('🔄 Cleared placeholder message');
        
        const formData = new FormData(currentForm);
        const params = Object.fromEntries(formData.entries());
        console.log('📋 Form params:', params);
        
        // Check if we have basic required parameters
        if (!params.paper_size) {
            console.warn('⚠️ Paper size not found in form data');
        }
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
         console.log('Current preview container classes:', currentPreviewContainer.className);
        
                 // Get exam data from the page
         const examDataElement = document.getElementById('examData');
         console.log('🔍 examDataElement found:', !!examDataElement);
         
         if (!examDataElement) {
             console.error('❌ examData element not found!');
             return;
         }
         
         console.log('📊 examDataElement dataset:', examDataElement.dataset);
         
         const examData = {
             title: examDataElement.dataset.title,
             id: parseInt(examDataElement.dataset.id),
             duration: parseInt(examDataElement.dataset.duration),
             total_questions: parseInt(examDataElement.dataset.totalQuestions),
             passing_marks: parseInt(examDataElement.dataset.passingMarks),
             question_header: examDataElement.dataset.questionHeader,
             questions: JSON.parse(examDataElement.dataset.questions)
         };
         console.log('📚 Exam data:', examData);
         console.log('📝 Total questions:', examData.questions.length);
         
         if (examData.questions.length === 0) {
             console.warn('⚠️ No questions found for this exam!');
             currentPreviewContainer.innerHTML = `
                 <div class="text-center text-red-500 py-8">
                     <svg class="w-12 h-12 mx-auto mb-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                     </svg>
                     <p class="text-lg font-medium">No Questions Found</p>
                     <p class="text-sm">This exam doesn't have any questions assigned yet.</p>
                 </div>
             `;
             return;
         }
         
         console.log('Questions with correct answers:', examData.questions.map(q => ({
             question_text: q.question_text.substring(0, 50) + '...',
             correct_answer: q.correct_answer,
             has_correct_answer: !!q.correct_answer
         })));
        
                 // Generate preview HTML
         try {
             const previewHTML = generatePreviewHTML(examData, params);
             console.log('Preview HTML generated, length:', previewHTML.length);
             
             if (previewHTML && previewHTML.length > 0) {
                 currentPreviewContainer.innerHTML = previewHTML;
                 console.log('✅ Preview content set successfully');
             } else {
                 throw new Error('Generated preview HTML is empty');
             }
         } catch (error) {
             console.error('❌ Error generating preview:', error);
             currentPreviewContainer.innerHTML = `
                 <div class="text-center text-red-500 py-8">
                     <svg class="w-12 h-12 mx-auto mb-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                     </svg>
                     <p class="text-lg font-medium">Preview Generation Failed</p>
                     <p class="text-sm">Error: ${error.message}</p>
                     <p class="text-xs text-gray-500 mt-2">Check console for details</p>
                 </div>
             `;
             return;
         }
         
         // Debug: Check what was actually created
         setTimeout(() => {
             const paperContainer = document.querySelector('.paper-container');
             if (paperContainer) {
                 console.log('Paper container found and styled');
                 
                 // Apply font styling directly to paper container
                 paperContainer.style.fontFamily = params.font_family || 'Arial';
                 paperContainer.style.fontSize = (params.font_size || 12) + 'pt';
                 paperContainer.style.lineHeight = params.line_spacing || 1.5;
                 
                 // Apply scaling if needed
                 const adjustToPercentage = parseInt(params.adjust_to_percentage) || 100;
                 if (adjustToPercentage !== 100) {
                     paperContainer.style.transform = `scale(${adjustToPercentage / 100})`;
                     paperContainer.style.transformOrigin = 'top left';
                 }
             } else {
                 console.error('No paper container found!');
             }
         }, 100);
         
         console.log('Paper container styled and ready');
        
        // Apply paper format settings to preview container
         const paperSize = params.paper_size || 'A4';
         const orientation = params.orientation || 'portrait';
         
         console.log('🔧 PAPER SIZE UPDATE:', {
             paperSize: paperSize,
             orientation: orientation
         });
         
         // Update preview container classes based on paper size and orientation
         if (currentPreviewContainer) {
             // Remove all existing preview size classes
             currentPreviewContainer.classList.remove('preview-a4', 'preview-letter', 'preview-legal', 'preview-a4-landscape', 'preview-letter-landscape', 'preview-legal-landscape');
             
             // Add the appropriate preview size class
             const previewClass = `preview-${paperSize.toLowerCase()}${orientation === 'landscape' ? '-landscape' : ''}`;
             currentPreviewContainer.classList.add(previewClass);
             
             console.log('📦 Preview container updated with class:', previewClass);
             
             // Update the paper size indicator
             const paperSizeIndicator = document.getElementById('currentPaperSize');
             if (paperSizeIndicator) {
                 const displayText = `${paperSize} ${orientation.charAt(0).toUpperCase() + orientation.slice(1)}`;
                 paperSizeIndicator.textContent = displayText;
                 
                 // Update indicator color based on paper size
                 paperSizeIndicator.className = 'text-xs font-medium px-2 py-1 rounded';
                 if (paperSize === 'A4') {
                     paperSizeIndicator.classList.add('text-blue-600', 'bg-blue-100');
                 } else if (paperSize === 'Letter') {
                     paperSizeIndicator.classList.add('text-green-600', 'bg-green-100');
                 } else if (paperSize === 'Legal') {
                     paperSizeIndicator.classList.add('text-orange-600', 'bg-orange-100');
                 }
                 
                 console.log('🏷️ Paper size indicator updated:', displayText);
             }
         }
        } catch (error) {
            console.error('❌ Fatal error in updatePreview:', error);
            const errorPreviewContainer = document.getElementById('livePreview');
            if (errorPreviewContainer) {
                errorPreviewContainer.innerHTML = `
                    <div class="text-center text-red-500 py-8">
                        <svg class="w-12 h-12 mx-auto mb-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <p class="text-lg font-medium">Preview Error</p>
                        <p class="text-sm">Fatal error: ${error.message}</p>
                        <p class="text-xs text-gray-500 mt-2">Check console for details</p>
                    </div>
                `;
            }
        }
    }
    
    // Load saved settings if available
    loadSavedSettings();
    
    // Apply default preview container sizing if no saved settings
    setTimeout(() => {
        const previewContainer = document.getElementById('livePreview');
        if (previewContainer && !previewContainer.classList.contains('preview-a4') && 
            !previewContainer.classList.contains('preview-letter') && 
            !previewContainer.classList.contains('preview-legal')) {
            previewContainer.classList.add('preview-a4'); // Default to A4
            console.log('📦 Default preview container class applied: preview-a4');
        }
        
        // Trigger initial preview update
        updatePreview();
    }, 200);
    
    // Add event listeners to all form inputs
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('change', updatePreview);
        input.addEventListener('input', updatePreview);
    });
    
    // Function to generate preview HTML matching PHP method structure
    function generatePreviewHTML(exam, params) {
        console.log('generatePreviewHTML called with:', { exam, params });
        
        const paperColumns = parseInt(params.paper_columns) || 1;
        const headerSpan = params.header_span || '1';
        const mcqColumns = parseInt(params.mcq_columns) || 4;
        const paperSize = params.paper_size || 'A4';
        const orientation = params.orientation || 'portrait';
        const fontSize = parseInt(params.font_size) || 12;
        const adjustToPercentage = parseInt(params.adjust_to_percentage) || 100;
        
        // Calculate header grid column span based on paper columns
        let headerGridSpan;
        if (headerSpan === 'full') {
            headerGridSpan = '1 / -1'; // Span full width
        } else {
            const spanValue = parseInt(headerSpan);
            if (spanValue >= paperColumns) {
                headerGridSpan = `1 / ${paperColumns + 1}`;
            } else {
                headerGridSpan = `1 / ${spanValue + 1}`;
            }
        }
        
        console.log('Generating single-container HTML to match PHP method');
        
        // Start with the paper container (matches PHP structure)
        let html = `<div class="paper-container paper-columns-${paperColumns}" data-header-span="${headerSpan}" style="font-family: '${params.font_family || 'Arial'}'; font-size: ${fontSize}pt; line-height: ${params.line_spacing || 1.5}; transform: scale(${adjustToPercentage / 100}); transform-origin: top left;">`;
        
        // Add header container if enabled
        if (params.include_header !== false) {
            html += `<div class="header-container" style="grid-column: ${headerGridSpan}; text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px;">`;
            html += `<div class="exam-title" style="font-size: ${fontSize + 8}pt; font-weight: bold; margin-bottom: 10px;">${exam.title}</div>`;
            
            const totalMarks = exam.questions.reduce((sum, q) => sum + (parseInt(q.marks) || 1), 0);
            html += `<div class="exam-info" style="font-size: ${fontSize - 2}pt; color: #666;">`;
            html += `<strong>Exam ID:</strong> ${exam.id} | `;
            html += `<strong>Duration:</strong> ${exam.duration} minutes | `;
            html += `<strong>Total Questions:</strong> ${exam.total_questions} | `;
            html += `<strong>Passing Marks:</strong> ${exam.passing_marks}% | `;
            html += `<strong>Total Marks:</strong> ${totalMarks}`;
            html += `</div>`;
            
            if (exam.question_header) {
                html += `<div class="question-header" style="margin-top: 15px; padding: 15px; background: #f9f9f9; border-radius: 5px;">${exam.question_header}</div>`;
            }
            html += `</div>`;
        }
        
        // Add questions with sequential column filling logic
        if (paperColumns > 1) {
            // Multi-column layout: fill first column completely, then second column, etc.
            const questionsPerColumn = calculateQuestionsPerColumn(exam.questions.length, paperColumns, params);
            let questionIndex = 0;
            
            console.log(`Sequential column filling: ${questionsPerColumn} questions per column`);
            
            // Create column containers and fill them sequentially
            for (let columnIndex = 0; columnIndex < paperColumns; columnIndex++) {
                const questionsInThisColumn = Math.min(questionsPerColumn, exam.questions.length - questionIndex);
                
                if (questionsInThisColumn > 0) {
                    html += `<div class="question-column" data-column="${columnIndex + 1}">`;
                    
                    console.log(`Column ${columnIndex + 1}: Adding ${questionsInThisColumn} questions starting from question ${questionIndex + 1}`);
                    
                    // Fill this column with questions
                    for (let i = 0; i < questionsInThisColumn && questionIndex < exam.questions.length; i++) {
                        const question = exam.questions[questionIndex];
                        const questionNumber = questionIndex + 1;
                        const marks = parseInt(question.marks) || 1;
                        
                        html += generateQuestionHTMLSimple(question, questionNumber, marks, params, mcqColumns);
                        questionIndex++;
                    }
                    
                    html += '</div>';
                }
                
                // Break if all questions are distributed
                if (questionIndex >= exam.questions.length) {
                    break;
                }
            }
        } else {
            // Single column layout: add questions sequentially
            exam.questions.forEach((question, index) => {
                const questionNumber = index + 1;
                const marks = parseInt(question.marks) || 1;
                html += generateQuestionHTMLSimple(question, questionNumber, marks, params, mcqColumns);
            });
        }
        
        // Add footer if enabled
        if (params.include_footer !== false) {
            const footerSpan = paperColumns > 1 ? '1 / -1' : '';
            const totalMarks = exam.questions.reduce((sum, q) => sum + (parseInt(q.marks) || 1), 0);
            html += `<div class="footer" style="grid-column: ${footerSpan}; margin-top: 40px; text-align: center; font-size: ${fontSize - 2}pt; color: #666; border-top: 1px solid #ccc; padding-top: 20px;">`;
            html += `<p>Generated on: ${new Date().toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            })}</p>`;
            html += `<p>Total Questions: ${exam.questions.length} | Total Marks: ${totalMarks}</p>`;
            html += `</div>`;
        }
        
        // Close paper container
        html += '</div>';
        
        console.log('Generated simplified HTML matching PHP method');
        return html;
    }
    
    // Generate HTML for a single question (matching PHP method)
    function generateQuestionHTMLSimple(question, questionNumber, marks, params, mcqColumns) {
        let html = `<div class="question" style="margin-bottom: 10px; page-break-inside: avoid; break-inside: avoid;">`;
        html += `<div class="question-number" style="font-weight: bold; color: #333;">`;
        html += `Question ${questionNumber} <span class="marks" style="font-weight: bold; color: #333; float: right;">[${marks} mark${marks > 1 ? 's' : ''}]</span>`;
        html += `</div>`;
        
        if (question.question_header) {
            html += `<div class="question-header" style="margin: 5px 0; font-style: italic; color: #666;">${question.question_header}</div>`;
        }
        
        // Clean question text to remove any "(Question #X)" patterns
        const cleanQuestionText = question.question_text.replace(/\(Question\s*#\d+\)/gi, '').trim();
        html += `<div class="question-text" style="margin: 5px 0;">${cleanQuestionText}</div>`;
        
        if (question.question_type === 'mcq') {
            html += `<div class="mcq-options columns-${mcqColumns}" style="display: grid; gap: 10px; margin: 5px 0; grid-template-columns: repeat(${mcqColumns}, 1fr);">`;
            
            const options = [
                { label: 'A', text: question.option_a },
                { label: 'B', text: question.option_b },
                { label: 'C', text: question.option_c },
                { label: 'D', text: question.option_d }
            ].filter(opt => opt.text);
            
            options.forEach(option => {
                let isCorrect = false;
                if (params.mark_answer && question.correct_answer) {
                    if (typeof question.correct_answer === 'string') {
                        isCorrect = option.label === question.correct_answer.toUpperCase();
                    } else if (typeof question.correct_answer === 'number') {
                        const answerMap = {1: 'A', 2: 'B', 3: 'C', 4: 'D'};
                        isCorrect = option.label === answerMap[question.correct_answer];
                    }
                }
                
                const optionStyle = isCorrect ? ' style="background-color: #e8f5e8; border-left: 4px solid #28a745; padding-left: 10px;"' : '';
                const correctIndicator = isCorrect ? ' <strong style="color: #28a745;">✓</strong>' : '';
                
                html += `<div class="option" style="margin: 5px 0;"${optionStyle}>${option.label}) ${option.text}${correctIndicator}</div>`;
            });
            
            html += '</div>';
        }
        
        html += '</div>';
        return html;
    }
    
    // Calculate questions per column for sequential filling (matching PHP logic)
    function calculateQuestionsPerColumn(totalQuestions, paperColumns, params) {
        // Get paper dimensions and calculate available space
        const paperSize = params.paper_size || 'A4';
        const orientation = params.orientation || 'portrait';
        const fontSize = parseInt(params.font_size) || 12;
        const lineSpacing = parseFloat(params.line_spacing) || 1.5;
        
        // Paper height in mm (approximate)
        const paperHeights = {
            'A4': orientation === 'landscape' ? 210 : 297,
            'Letter': orientation === 'landscape' ? 216 : 279,
            'Legal': orientation === 'landscape' ? 216 : 356
        };
        
        const paperHeight = paperHeights[paperSize] || 297;
        
        // Calculate available height (subtract margins and header space)
        const marginTop = parseInt(params.margin_top) || 0;
        const marginBottom = parseInt(params.margin_bottom) || 0;
        const headerHeight = (params.include_header !== false) ? 40 : 0; // Approximate header height in mm
        
        const availableHeight = paperHeight - marginTop - marginBottom - headerHeight - 40; // 40mm padding
        
        // Estimate question height based on font size and line spacing
        // Average question takes about 4-6 lines depending on complexity
        const averageLinesPerQuestion = 5;
        const lineHeightMm = (fontSize * lineSpacing * 0.35); // Convert pt to mm approximately
        const questionHeightMm = lineHeightMm * averageLinesPerQuestion + 5; // 5mm spacing between questions
        
        // Calculate maximum questions that can fit in one column
        const maxQuestionsPerColumn = Math.floor(availableHeight / questionHeightMm);
        
        // Ensure we don't have empty columns by distributing evenly with a minimum
        let questionsPerColumn = Math.max(
            maxQuestionsPerColumn,
            Math.ceil(totalQuestions / paperColumns)
        );
        
        // But don't exceed what can physically fit
        questionsPerColumn = Math.min(questionsPerColumn, maxQuestionsPerColumn || 20);
        
        // Ensure minimum of 5 questions per column if we have questions
        if (totalQuestions > 0) {
            questionsPerColumn = Math.max(questionsPerColumn, 5);
        }
        
        console.log(`Questions per column calculation:`, {
            totalQuestions,
            paperColumns,
            paperSize,
            orientation,
            paperHeight,
            availableHeight,
            maxQuestionsPerColumn,
            questionsPerColumn
        });
        
        return questionsPerColumn;
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
     
     // PDF Download functionality
     const downloadPdfBtn = document.getElementById('downloadPdfBtn');
     if (downloadPdfBtn) {
         downloadPdfBtn.addEventListener('click', function() {
             downloadPDF();
         });
     }
     
     // Save Settings functionality
     const saveSettingsBtn = document.getElementById('saveSettingsBtn');
     if (saveSettingsBtn) {
         saveSettingsBtn.addEventListener('click', function() {
             saveSettings();
         });
     }
     
     // Function to save settings
     function saveSettings() {
         try {
             const form = document.getElementById('parameterForm');
             const formData = new FormData(form);
             const parameters = Object.fromEntries(formData.entries());
             
             // Convert checkboxes to proper boolean values
             parameters.include_header = parameters.include_header === '1';
             parameters.mark_answer = parameters.mark_answer === '1';
             parameters.show_page_number = parameters.show_page_number === '1';
             
             console.log('Saving parameters:', parameters);
             
             fetch('{{ route("partner.exams.save-paper-settings", $exam) }}', {
                 method: 'POST',
                 headers: {
                     'Content-Type': 'application/json',
                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                 },
                 body: JSON.stringify({
                     parameters: parameters
                 })
             })
             .then(response => response.json())
             .then(data => {
                 if (data.status === 'success') {
                     // Show success message
                     const btn = document.getElementById('saveSettingsBtn');
                     const originalText = btn.innerHTML;
                     btn.innerHTML = '✅ Settings Saved!';
                     btn.classList.add('bg-green-600');
                     
                     setTimeout(() => {
                         btn.innerHTML = originalText;
                         btn.classList.remove('bg-green-600');
                     }, 2000);
                 } else {
                     throw new Error(data.message || 'Failed to save settings');
                 }
             })
             .catch(error => {
                 console.error('Error saving settings:', error);
                 alert('Failed to save settings: ' + error.message);
             });
         } catch (error) {
             console.error('Error preparing settings:', error);
             alert('Error preparing settings for save.');
         }
     }
     
     // Function to load saved settings
     function loadSavedSettings() {
         @if(isset($savedSettings) && !empty($savedSettings))
             const savedSettings = @json($savedSettings);
             console.log('Loading saved settings:', savedSettings);
             
             // Populate form fields with saved settings
             Object.keys(savedSettings).forEach(key => {
                 const element = document.getElementById(key) || document.querySelector(`[name="${key}"]`);
                 if (element) {
                     if (element.type === 'checkbox') {
                         element.checked = Boolean(savedSettings[key]);
                     } else if (element.type === 'number') {
                         element.value = savedSettings[key];
                     } else if (element.tagName === 'SELECT') {
                         element.value = savedSettings[key];
                     } else {
                         element.value = savedSettings[key];
                     }
                 }
             });
             
             // Update preview after loading settings
             setTimeout(() => {
                 updatePreview();
             }, 100);
             
             // Apply initial preview container sizing
             setTimeout(() => {
                 const paperSize = savedSettings.paper_size || 'A4';
                 const orientation = savedSettings.orientation || 'portrait';
                 const previewContainer = document.getElementById('livePreview');
                 if (previewContainer) {
                     previewContainer.classList.remove('preview-a4', 'preview-letter', 'preview-legal', 'preview-a4-landscape', 'preview-letter-landscape', 'preview-legal-landscape');
                     const previewClass = `preview-${paperSize.toLowerCase()}${orientation === 'landscape' ? '-landscape' : ''}`;
                     previewContainer.classList.add(previewClass);
                     console.log('📦 Initial preview container class applied:', previewClass);
                     
                     // Update the paper size indicator
                     const paperSizeIndicator = document.getElementById('currentPaperSize');
                     if (paperSizeIndicator) {
                         const displayText = `${paperSize} ${orientation.charAt(0).toUpperCase() + orientation.slice(1)}`;
                         paperSizeIndicator.textContent = displayText;
                         
                         // Update indicator color based on paper size
                         paperSizeIndicator.className = 'text-xs font-medium px-2 py-1 rounded';
                         if (paperSize === 'A4') {
                             paperSizeIndicator.classList.add('text-blue-600', 'bg-blue-100');
                         } else if (paperSize === 'Letter') {
                             paperSizeIndicator.classList.add('text-green-600', 'bg-green-100');
                         } else if (paperSize === 'Legal') {
                             paperSizeIndicator.classList.add('text-orange-600', 'bg-orange-100');
                         }
                     }
                 }
             }, 150);
         @endif
     }
     
     // Function to save settings
     function saveSettings() {
         const saveBtn = document.getElementById('saveSettingsBtn');
         const originalText = saveBtn.innerHTML;
         
         // Show loading state
         saveBtn.innerHTML = `
             <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
             </svg>
             <span>Saving...</span>
         `;
         saveBtn.disabled = true;
         
         try {
             // Get form parameters
             const formData = new FormData(form);
             const params = Object.fromEntries(formData.entries());
             
             // Send to server for saving
             fetch('{{ route("partner.exams.save-paper-settings", $exam) }}', {
                 method: 'POST',
                 headers: {
                     'Content-Type': 'application/json',
                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                 },
                 body: JSON.stringify({
                     parameters: params
                 })
             })
             .then(response => {
                 if (!response.ok) {
                     throw new Error(`HTTP error! status: ${response.status}`);
                 }
                 return response.json();
             })
             .then(data => {
                 // Show success message
                 saveBtn.innerHTML = `
                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                     </svg>
                     <span>Saved!</span>
                 `;
                 saveBtn.classList.remove('from-green-500', 'to-emerald-600', 'hover:from-green-600', 'hover:to-emerald-700');
                 saveBtn.classList.add('from-green-600', 'to-green-700');
                 
                 setTimeout(() => {
                     saveBtn.innerHTML = originalText;
                     saveBtn.disabled = false;
                     saveBtn.classList.remove('from-green-600', 'to-green-700');
                     saveBtn.classList.add('from-green-500', 'to-emerald-600', 'hover:from-green-600', 'hover:to-emerald-700');
                 }, 2000);
             })
             .catch(error => {
                 console.error('Save Settings Error:', error);
                 
                 // Show error message
                 saveBtn.innerHTML = `
                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                     </svg>
                     <span>Failed!</span>
                 `;
                 saveBtn.classList.remove('from-green-500', 'to-emerald-600', 'hover:from-green-600', 'hover:to-emerald-700');
                 saveBtn.classList.add('from-red-500', 'to-red-600');
                 
                 setTimeout(() => {
                     saveBtn.innerHTML = originalText;
                     saveBtn.disabled = false;
                     saveBtn.classList.remove('from-red-500', 'to-red-600');
                     saveBtn.classList.add('from-green-500', 'to-emerald-600', 'hover:from-green-600', 'hover:to-emerald-700');
                 }, 3000);
                 
                 alert('Failed to save settings: ' + error.message + '\n\nPlease try again.');
             });
         } catch (error) {
             console.error('Save Settings Error:', error);
             saveBtn.innerHTML = originalText;
             saveBtn.disabled = false;
             alert('Failed to save settings. Please try again.');
         }
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
        
        /* Page numbering */
        .page-number {
            position: absolute !important;
            bottom: 10px !important;
            right: 10px !important;
            font-size: 10pt !important;
            color: #666 !important;
            z-index: 10 !important;
            font-family: "${exactStyles.fontFamily}" !important;
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
