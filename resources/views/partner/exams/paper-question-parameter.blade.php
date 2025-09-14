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
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
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
        
        /* Add header span indicator */
        #livePreview .header-container::after {
            content: "Header Span: " attr(data-header-span);
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
      
        /* Header span styles - now handled within page containers */
     
        /* Questions container styling - now handled by questions-grid */
      
                /* Page container styling */
        #livePreview .page-container {
            border: 3px solid #3b82f6;
            background: white;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            page-break-inside: avoid;
            break-inside: avoid;
            width: 210mm; /* A4 width */
            min-height: 297mm; /* A4 height */
            max-width: 210mm;
            box-sizing: border-box;
            position: relative;
        }
        
        /* A4 aspect ratio maintenance */
        #livePreview .page-container.a4-portrait {
            width: 210mm;
            min-height: 297mm;
            max-width: 210mm;
        }
        
        #livePreview .page-container.a4-landscape {
            width: 297mm;
            min-height: 210mm;
            max-width: 297mm;
        }
        
        /* Letter size */
        #livePreview .page-container.letter-portrait {
            width: 8.5in;
            min-height: 11in;
            max-width: 8.5in;
        }
        
        #livePreview .page-container.letter-landscape {
            width: 11in;
            min-height: 8.5in;
            max-width: 11in;
        }
        
        /* Legal size */
        #livePreview .page-container.legal-portrait {
            width: 8.5in;
            min-height: 14in;
            max-width: 8.5in;
        }
        
        #livePreview .page-container.legal-landscape {
            width: 14in;
            min-height: 8.5in;
            max-width: 14in;
        }
        
        /* A3 size */
        #livePreview .page-container.a3-portrait {
            width: 297mm;
            min-height: 420mm;
            max-width: 297mm;
        }
        
        #livePreview .page-container.a3-landscape {
            width: 420mm;
            min-height: 297mm;
            max-width: 420mm;
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
            margin: 10px auto;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        
        /* Add page number indicator */
        #livePreview .page-container::before {
            content: "PAGE " attr(data-page) " - " attr(data-paper-size) " " attr(data-orientation);
            position: absolute;
            top: -15px;
            left: 20px;
            background: #3b82f6;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        
        /* Add paper size dimensions indicator */
        #livePreview .page-container::after {
            content: attr(data-paper-size) " (" attr(data-orientation) ")";
            position: absolute;
            top: -15px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        
        /* Multi-column layout within pages - now handled by questions-grid */
        #livePreview .questions-grid {
            display: grid !important;
            gap: 20px !important;
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
            padding: 0 10px;
            border: 1px dashed #ccc;
            background: rgba(0, 0, 0, 0.02);
            min-height: 200px;
        }
        
        /* Debug: Make columns more visible */
        #livePreview .question-column::before {
            content: "Column " attr(data-column);
            display: block;
            background: #f0f0f0;
            padding: 5px;
            margin: -10px -10px 10px -10px;
            font-size: 12px;
            font-weight: bold;
            color: #666;
            border-bottom: 1px solid #ddd;
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
            margin-bottom: 15px;
            padding: 10px;
            border-left: 3px solid #3b82f6;
            background: #f8fafc;
            border-radius: 4px;
        }
        
        /* Header styling */
        #livePreview .header-container {
            background: #f1f5f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
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
      
     
</style>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-8">
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
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Paper Settings</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Configure your question paper parameters</p>
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
                
                <!-- Paper Format Section -->
                <div class="space-y-6">
                    <!-- Two Column Grid Layout -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        <!-- Layout Column -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">Layout</h4>
                            
                            <!-- Paper Size, Orientation and Paper Columns -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="paper_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Paper Size</label>
                                    <select id="paper_size" name="paper_size" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                        <option value="A4" selected>A4 (210 × 297 mm)</option>
                                        <option value="Letter">Letter (8.5 × 11 in)</option>
                                        <option value="Legal">Legal (8.5 × 14 in)</option>
                                        <option value="A3">A3 (297 × 420 mm)</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="orientation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Orientation</label>
                                    <select id="orientation" name="orientation" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                        <option value="portrait" selected>Portrait</option>
                                        <option value="landscape">Landscape</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="paper_columns" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Columns</label>
                                    <select id="paper_columns" name="paper_columns" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Margins -->
                            <div class="space-y-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Margins (mm)</label>
                                <div class="grid grid-cols-4 gap-3">
                                    <div>
                                        <label for="margin_top" class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Top</label>
                                        <input type="number" id="margin_top" name="margin_top" value="25" min="10" max="50" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                    </div>
                                    
                                    <div>
                                        <label for="margin_bottom" class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Bottom</label>
                                        <input type="number" id="margin_bottom" name="margin_bottom" value="25" min="10" max="50" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                    </div>
                                    
                                    <div>
                                        <label for="margin_left" class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Left</label>
                                        <input type="number" id="margin_left" name="margin_left" value="20" min="10" max="50" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                    </div>
                                    
                                    <div>
                                        <label for="margin_right" class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Right</label>
                                        <input type="number" id="margin_right" name="margin_right" value="20" min="10" max="50" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Display Options Column -->
                        <div class="space-y-4 lg:col-span-2">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">Display Options</h4>
                            
                            <!-- Font Settings, Line Spacing, MCQ Columns and Header Span -->
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                <div>
                                    <label for="font_family" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Font Family</label>
                                                                         <select id="font_family" name="font_family" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                         <option value="Arial">Arial</option>
                                         <option value="Times New Roman">Times New Roman</option>
                                         <option value="Calibri" selected>Calibri</option>
                                         <option value="Georgia">Georgia</option>
                                         <option value="Verdana">Verdana</option>
                                     </select>
                                </div>
                                
                                <div>
                                    <label for="font_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Font Size</label>
                                                                         <select id="font_size" name="font_size" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                         <option value="10" selected>10pt</option>
                                         <option value="11">11pt</option>
                                         <option value="12">12pt</option>
                                         <option value="14">14pt</option>
                                         <option value="16">16pt</option>
                                     </select>
                                </div>
                                
                                <div>
                                    <label for="line_spacing" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Line Spacing</label>
                                                                         <select id="line_spacing" name="line_spacing" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                         <option value="1.0" selected>Single (1.0)</option>
                                         <option value="1.15">1.15</option>
                                         <option value="1.5">1.5</option>
                                         <option value="2.0">Double (2.0)</option>
                                     </select>
                                </div>
                                
                                <div>
                                    <label for="mcq_columns" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">MCQ Columns</label>
                                                                         <select id="mcq_columns" name="mcq_columns" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                         <option value="1">1</option>
                                         <option value="2">2</option>
                                         <option value="3">3</option>
                                         <option value="4" selected>4</option>
                                     </select>
                                </div>
                                
                                <div>
                                    <label for="header_span" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Header Span</label>
                                                                         <select id="header_span" name="header_span" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                         <option value="1" selected>1</option>
                                         <option value="2">2</option>
                                         <option value="3">3</option>
                                         <option value="4">4</option>
                                         <option value="full">Full Width</option>
                                     </select>
                                </div>
                            </div>
                            
                                                                                      <!-- Content Options -->
                              <div class="space-y-3">
                                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content Options</label>
                                  <div class="grid grid-cols-2 gap-4">
                                      <div class="space-y-2">
                                                                                     <div class="flex items-center">
                                               <input type="checkbox" id="include_header" name="include_header" value="1" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                               <label for="include_header" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Header</label>
                                               <span class="ml-2 text-xs text-gray-500">(Title, Model Test, Full Marks & Time)</span>
                                           </div>
                                       </div>
                                       
                                                                               <div class="space-y-2">
                                                                                         <div class="flex items-center">
                                                 <input type="checkbox" id="mark_answer" name="mark_answer" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                 <label for="mark_answer" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Mark Answer</label>
                                                 <span class="ml-2 text-xs text-gray-500">(Check to show correct answers)</span>
                                             </div>
                                        </div>
                                  </div>
                              </div>
                        </div>
                    </div>
                </div>
                
                                 <!-- Action Buttons -->
                 <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                     <a href="{{ route('partner.exams.show', $exam) }}" 
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                         ← Back to Exam
                     </a>
                     
                     <button type="button" id="downloadPdfBtn"
                             class="px-6 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                         📄 Download as PDF
                     </button>
                     @if(config('app.debug'))
                     <button type="button" id="testPdfBtn"
                             class="px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold rounded-lg hover:from-purple-600 hover:to-pink-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                         🧪 Test PDF
                     </button>
                     @endif
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
         
         // Apply paper format settings to page containers
         const paperSize = params.paper_size || 'A4';
         const orientation = params.orientation || 'portrait';
         const sizeClass = `${paperSize.toLowerCase()}-${orientation}`;
         
         // Update all page containers with the correct paper size class and margins
         document.querySelectorAll('.page-container').forEach((pageContainer, index) => {
             // Remove all existing paper size classes
             pageContainer.classList.remove('a4-portrait', 'a4-landscape', 'letter-portrait', 'letter-landscape', 'legal-portrait', 'legal-landscape', 'a3-portrait', 'a3-landscape');
             
             // Add the correct paper size class
             pageContainer.classList.add(sizeClass);
             
             // Update data attributes
             pageContainer.setAttribute('data-paper-size', paperSize);
             pageContainer.setAttribute('data-orientation', orientation);
             
             // Apply margin values from form to the page container
             const marginTop = (parseInt(params.margin_top) || 20) + 'px';
             const marginRight = (parseInt(params.margin_right) || 20) + 'px';
             const marginBottom = (parseInt(params.margin_bottom) || 20) + 'px';
             const marginLeft = (parseInt(params.margin_left) || 20) + 'px';
             
             pageContainer.style.marginTop = marginTop;
             pageContainer.style.marginRight = marginRight;
             pageContainer.style.marginBottom = marginBottom;
             pageContainer.style.marginLeft = marginLeft;
             
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
            
            html += `<div class="page-container ${sizeClass}" data-columns="${paperColumns}" data-page="${pageNum}" data-paper-size="${paperSize}" data-orientation="${orientation}">`;
            console.log(`Created page container ${pageNum} with ${paperColumns} columns, size: ${paperSize} ${orientation}`);
            
            // Page title
            html += `<div class="page-title">📄 Page ${pageNum} of ${totalPages} (${pageQuestions.length} questions)</div>`;
            
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
    
    // Function to calculate questions per page based on A4 dimensions
    function calculateQuestionsPerPage(params) {
        const fontSize = parseInt(params.font_size) || 12;
        const lineSpacing = parseFloat(params.line_spacing) || 1.5;
        const paperColumns = parseInt(params.paper_columns) || 1;
        
        // A4 dimensions in mm: 210mm x 297mm
        const pageHeight = 297;
        const pageWidth = 210;
        
        // Margins (top, bottom, left, right) in mm
        const marginTop = 20;
        const marginBottom = 20;
        const marginLeft = 15;
        const marginRight = 15;
        
        // Header height in mm (if included)
        const headerHeight = params.include_header ? 40 : 0;
        
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
        
        // Ensure minimum questions per page - increase minimum for better filling
        // Allow more questions per page to match what preview actually shows
        questionsPerPage = Math.max(25, questionsPerPage);
        
        console.log('A4 Page Calculation:', {
            pageHeight,
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
            // Increase the limit to match what the preview actually shows
            questionsForPage = Math.max(baseQuestionsPerPage, 30); // Allow up to 30 questions per page
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
     
     // Test PDF functionality (debug mode only)
     const testPdfBtn = document.getElementById('testPdfBtn');
     if (testPdfBtn) {
         testPdfBtn.addEventListener('click', function() {
             testPDFGeneration();
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
         } else if (paperSize === 'A3') {
             return orientation === 'landscape' ? '420mm' : '297mm';
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
         } else if (paperSize === 'A3') {
             return orientation === 'landscape' ? '297mm' : '420mm';
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
            margin: ${params.margin_top || '20'}mm ${params.margin_right || '20'}mm ${params.margin_bottom || '20'}mm ${params.margin_left || '20'}mm;
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
            border: 3px solid #3b82f6 !important;
            background: white !important;
            margin: 20px auto !important;
            padding: 20px !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            width: ${getPageWidth(params)} !important;
            min-height: ${getPageHeight(params)} !important;
            max-width: ${getPageWidth(params)} !important;
            box-sizing: border-box !important;
            position: relative !important;
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
            border-radius: 8px !important;
            padding: 10px !important;
            margin-bottom: 15px !important;
            text-align: center !important;
            border-bottom: 2px solid #333 !important;
            padding-bottom: 15px !important;
            margin-bottom: 20px !important;
            width: 100% !important;
            clear: both !important;
            font-family: "${exactStyles.fontFamily}" !important;
            font-size: ${exactStyles.fontSize} !important;
            line-height: ${exactStyles.lineHeight} !important;
            color: ${exactStyles.color} !important;
        }
        
        /* Question styling - exact match */
        .question {
            margin-bottom: 15px !important;
            padding: 10px !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 4px !important;
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
            padding: 0 10px !important;
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
                margin: 20px auto !important; 
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important; 
                border: 3px solid #3b82f6 !important;
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
     
     // Function to test PDF generation
     function testPDFGeneration() {
         const testBtn = document.getElementById('testPdfBtn');
         const originalText = testBtn.innerHTML;
         
         // Show loading state
         testBtn.innerHTML = '⏳ Testing PDF Generation...';
         testBtn.disabled = true;
         
         fetch('{{ route("partner.exams.test-pdf", $exam) }}', {
             method: 'GET',
             headers: {
                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
             }
         })
         .then(response => {
             if (!response.ok) {
                 throw new Error(`HTTP error! status: ${response.status}`);
             }
             return response.json();
         })
         .then(data => {
             // Check if there's an error in the response
             if (data.error) {
                 throw new Error(data.message || data.error);
             }
             
             // Show results in a modal or alert
             let resultMessage = 'PDF Generation Test Results:\n\n';
             resultMessage += `Total Tests: ${data.summary.total_tests}\n`;
             resultMessage += `Successful: ${data.summary.successful}\n`;
             resultMessage += `Failed: ${data.summary.failed}\n\n`;
             
             data.test_results.forEach(result => {
                 if (result.status === 'success') {
                     resultMessage += `✅ ${result.paper_size} ${result.orientation}: ${result.generation_time_ms}ms (${Math.round(result.pdf_size_bytes/1024)}KB)\n`;
                 } else {
                     resultMessage += `❌ ${result.paper_size} ${result.orientation}: ${result.error}\n`;
                 }
             });
             
             alert(resultMessage);
             
             // Show success message
             testBtn.innerHTML = '✅ Test Complete!';
             setTimeout(() => {
                 testBtn.innerHTML = originalText;
                 testBtn.disabled = false;
             }, 2000);
         })
         .catch(error => {
             console.error('Test Error:', error);
             testBtn.innerHTML = '❌ Test Failed';
             setTimeout(() => {
                 testBtn.innerHTML = originalText;
                 testBtn.disabled = false;
             }, 3000);
             
             // Show detailed error message
             let errorMessage = 'Failed to run PDF tests.\n\n';
             errorMessage += `Error: ${error.message}\n\n`;
             errorMessage += 'Possible causes:\n';
             errorMessage += '• Browsershot/Chrome not installed\n';
             errorMessage += '• Server configuration issues\n';
             errorMessage += '• Memory or timeout issues\n\n';
             errorMessage += 'Please check the browser console and server logs for more details.';
             
             alert(errorMessage);
         });
     }
     
     // Function to debug preview vs PDF differences
     function debugPreviewPDF() {
         console.log('=== DEBUGGING PREVIEW VS PDF ===');
         
         // Get current preview HTML
         const previewHTML = previewContainer.innerHTML;
         console.log('Preview HTML length:', previewHTML.length);
         
         // Create a sample div to analyze
         const sampleDiv = document.createElement('div');
         sampleDiv.innerHTML = previewHTML;
         
         // Analyze page containers
         const pageContainers = sampleDiv.querySelectorAll('.page-container');
         console.log('Number of page containers:', pageContainers.length);
         
         pageContainers.forEach((page, index) => {
             console.log(`Page ${index + 1}:`, {
                 dataPage: page.getAttribute('data-page'),
                 dataColumns: page.getAttribute('data-columns'),
                 inlineStyles: page.getAttribute('style'),
                 computedStyles: {
                     width: window.getComputedStyle(page).width,
                     height: window.getComputedStyle(page).height,
                     fontSize: window.getComputedStyle(page).fontSize,
                     fontFamily: window.getComputedStyle(page).fontFamily,
                     margin: window.getComputedStyle(page).margin,
                     padding: window.getComputedStyle(page).padding,
                     border: window.getComputedStyle(page).border,
                     boxShadow: window.getComputedStyle(page).boxShadow
                 }
             });
         });
         
         // Analyze questions
         const questions = sampleDiv.querySelectorAll('.question');
         console.log('Number of questions:', questions.length);
         
         if (questions.length > 0) {
             const firstQuestion = questions[0];
             console.log('First question styles:', {
                 inlineStyles: firstQuestion.getAttribute('style'),
                 computedStyles: {
                     fontSize: window.getComputedStyle(firstQuestion).fontSize,
                     fontFamily: window.getComputedStyle(firstQuestion).fontFamily,
                     margin: window.getComputedStyle(firstQuestion).margin,
                     padding: window.getComputedStyle(firstQuestion).padding,
                     border: window.getComputedStyle(firstQuestion).border
                 }
             });
         }
         
         console.log('=== END DEBUG ===');
     }

     
             // Initial preview
        console.log('DOM loaded, calling updatePreview');
        updatePreview();
        
        // Add debug function to window for console access
        window.debugPreviewPDF = debugPreviewPDF;
    });
</script>
@endsection
