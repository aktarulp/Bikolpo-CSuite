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
     
   
    
                   /* Paper Column Layout Styles */
                    #livePreview.paper-columns-2 {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 10px !important;
            padding: 5px !important;
            align-items: start !important;
        }
        
        #livePreview.paper-columns-3 {
            display: grid !important;
            grid-template-columns: 1fr 1fr 1fr !important;
            gap: 10px !important;
            padding: 5px !important;
            align-items: start !important;
        }
      
      #livePreview.paper-columns-1 {
          display: block !important;
          padding: 5px !important;
      }
    
                                                                               /* Ensure content doesn't break awkwardly in columns */
        #livePreview > div {
            break-inside: avoid;
            page-break-inside: avoid;
        }
        
        /* Better column content handling */
        #livePreview.paper-columns-2 .page-container,
        #livePreview.paper-columns-3 .page-container {
            break-inside: avoid;
            page-break-inside: avoid;
        }
        
                 /* Column content spacing and flow */
         #livePreview.paper-columns-2 > div:not(.header-container),
         #livePreview.paper-columns-3 > div:not(.header-container) {
             padding: 3px;
         }
         
         /* Ensure questions flow naturally across columns */
         #livePreview.paper-columns-2 .question,
         #livePreview.paper-columns-3 .question {
             break-inside: avoid;
             page-break-inside: avoid;
             margin-bottom: 10px;
         }
         
         /* Force questions to flow naturally in grid layout */
         #livePreview.paper-columns-2,
         #livePreview.paper-columns-3 {
             grid-auto-flow: row dense;
         }
         
         /* Ensure questions don't get stuck in wrong columns */
         #livePreview.paper-columns-2 .question,
         #livePreview.paper-columns-3 .question {
             grid-column: auto;
         }
     
     
     
                  /* Header container styling */
       .header-container {
           /* Remove display: contents to make it visible to grid */
           background: rgba(248, 250, 252, 0.8);
           border-radius: 8px;
           padding: 10px;
           margin-bottom: 15px;
       }
      
      /* Header span styles for different paper column configurations */
      #livePreview.paper-columns-2[data-header-span="1"] .header-container {
          grid-column: 1 / 2 !important;
      }
      
      #livePreview.paper-columns-2[data-header-span="2"] .header-container {
          grid-column: 1 / 3 !important;
      }
      
      #livePreview.paper-columns-3[data-header-span="1"] .header-container {
          grid-column: 1 / 2 !important;
      }
      
      #livePreview.paper-columns-3[data-header-span="2"] .header-container {
          grid-column: 1 / 3 !important;
      }
      
      #livePreview.paper-columns-3[data-header-span="3"] .header-container {
          grid-column: 1 / 4 !important;
      }
      
      #livePreview.paper-columns-3[data-header-span="4"] .header-container {
          grid-column: 1 / 5 !important;
      }
      
      #livePreview.paper-columns-3[data-header-span="full"] .header-container {
          grid-column: 1 / -1 !important;
      }
     
           /* Questions container styling for multi-column layout */
      #livePreview .questions-container {
          display: contents;
      }
      
        /* Page container styling */
        #livePreview .page-container {
            border: 3px solid #3b82f6;
            background: white;
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            page-break-inside: avoid;
            break-inside: avoid;
            min-height: 400px; /* More reasonable height for preview */
            width: 100%;
            box-sizing: border-box;
            position: relative;
        }
        
        /* Add page number indicator */
        #livePreview .page-container::before {
            content: "PAGE " attr(data-page);
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
        
        /* Multi-column layout within pages */
        #livePreview .page-container[data-columns="2"] {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 30px !important;
        }
        
        #livePreview .page-container[data-columns="3"] {
            display: grid !important;
            grid-template-columns: 1fr 1fr 1fr !important;
            gap: 20px !important;
        }
        
        /* Question column styling */
        #livePreview .question-column {
            border-left: 2px solid #e5e7eb;
            padding-left: 15px;
            min-width: 0;
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
        
        /* Pagination styling */
        #livePreview .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        
        #livePreview .pagination button {
            padding: 8px 16px;
            border: 1px solid #d1d5db;
            background: white;
            color: #374151;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        #livePreview .pagination button:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }
        
        #livePreview .pagination button:disabled {
            background: #f3f4f6;
            color: #9ca3af;
            cursor: not-allowed;
        }
        
        #livePreview .pagination .page-info {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }
        
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
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
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
                                    <label for="paper_columns" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Paper Columns</label>
                                    <select id="paper_columns" name="paper_columns" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
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
                        <div class="space-y-4">
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
                     
                     <button type="submit" 
                             class="px-6 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                         📥 Download Question Paper
                     </button>
                 </div>
            </form>
        </div>

        <!-- Live Preview (Full Width) -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Live Preview</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">See how your question paper will look</p>
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
    
    // Global variable to track current page
    let currentPage = 1;
    
    // Function to navigate between pages
    window.goToPage = function(pageNum) {
        const totalPages = document.querySelectorAll('.page-container').length;
        
        if (pageNum < 1 || pageNum > totalPages) {
            return;
        }
        
        currentPage = pageNum;
        
        // Hide all pages
        document.querySelectorAll('.page-container').forEach((page, index) => {
            if (index + 1 === pageNum) {
                page.style.display = 'block';
            } else {
                page.style.display = 'none';
            }
        });
        
        // Update pagination display
        document.getElementById('currentPageDisplay').textContent = pageNum;
        
        // Update button states
        document.getElementById('prevBtn').disabled = pageNum === 1;
        document.getElementById('nextBtn').disabled = pageNum === totalPages;
        
        console.log(`Navigated to page ${pageNum}`);
    };
    
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
         
         // Debug: Check what was actually created
         setTimeout(() => {
             const pageContainers = document.querySelectorAll('.page-container');
             console.log(`After setting innerHTML, found ${pageContainers.length} page containers`);
             pageContainers.forEach((page, index) => {
                 console.log(`Page ${index + 1}:`, {
                     dataPage: page.getAttribute('data-page'),
                     dataColumns: page.getAttribute('data-columns'),
                     display: page.style.display,
                     visible: page.offsetHeight > 0
                 });
             });
         }, 100);
         
         // Set up pagination - show only first page initially
         const totalPages = document.querySelectorAll('.page-container').length;
         console.log(`Found ${totalPages} pages in preview`);
         
         if (totalPages > 1) {
             // Hide all pages except the first one
             document.querySelectorAll('.page-container').forEach((page, index) => {
                 if (index === 0) {
                     page.style.display = 'block';
                     console.log(`Showing page ${index + 1}`);
                 } else {
                     page.style.display = 'none';
                     console.log(`Hiding page ${index + 1}`);
                 }
             });
             
             // Reset current page
             currentPage = 1;
             
             // Update pagination display
             const currentPageDisplay = document.getElementById('currentPageDisplay');
             if (currentPageDisplay) {
                 currentPageDisplay.textContent = '1';
                 console.log('Updated current page display to 1');
             }
             
             // Update button states
             const prevBtn = document.getElementById('prevBtn');
             const nextBtn = document.getElementById('nextBtn');
             if (prevBtn) {
                 prevBtn.disabled = true;
                 console.log('Disabled previous button');
             }
             if (nextBtn) {
                 nextBtn.disabled = totalPages === 1;
                 console.log(`Next button disabled: ${totalPages === 1}`);
             }
         } else {
             console.log('Only one page found, no pagination needed');
         }
         
         // Apply current styling
         previewContainer.style.fontFamily = params.font_family || 'Arial';
         previewContainer.style.fontSize = (params.font_size || 12) + 'pt';
         previewContainer.style.lineHeight = params.line_spacing || 1.5;
         
         // Apply paper format settings
         if (params.paper_size) {
             // Adjust preview container based on paper size
             const paperSizes = {
                 'A4': { width: '210mm', height: '297mm' },
                 'Letter': { width: '8.5in', height: '11in' },
                 'Legal': { width: '8.5in', height: '14in' },
                 'A3': { width: '297mm', height: '420mm' }
             };
             
             if (paperSizes[params.paper_size]) {
                 const size = paperSizes[params.paper_size];
                 
                 // Check if landscape orientation is selected
                 if (params.orientation === 'landscape') {
                     // Swap width and height for landscape
                     previewContainer.style.width = size.height;
                     previewContainer.style.height = size.width;
                 } else {
                     // Normal portrait orientation
                     previewContainer.style.width = size.width;
                     previewContainer.style.height = size.height;
                 }
                 
                 previewContainer.style.maxWidth = '100%';
                 previewContainer.style.maxHeight = '100%';
             }
         }
         
         if (params.orientation) {
             // Adjust preview container orientation
             if (params.orientation === 'landscape') {
                 // For landscape, swap width and height instead of rotating
                 const currentWidth = previewContainer.style.width;
                 const currentHeight = previewContainer.style.height;
                 
                 if (currentWidth && currentHeight) {
                     previewContainer.style.width = currentHeight;
                     previewContainer.style.height = currentWidth;
                 }
                 
                 // Add landscape class for styling
                 previewContainer.classList.add('landscape');
                 previewContainer.classList.remove('portrait');
             } else {
                 // For portrait, ensure normal dimensions
                 previewContainer.classList.add('portrait');
                 previewContainer.classList.remove('landscape');
                 
                 // Reset any landscape adjustments
                 if (params.paper_size) {
                     const paperSizes = {
                         'A4': { width: '210mm', height: '297mm' },
                         'Letter': { width: '8.5in', height: '11in' },
                         'Legal': { width: '8.5in', height: '14in' },
                         'A3': { width: '297mm', height: '420mm' }
                     };
                     
                     if (paperSizes[params.paper_size]) {
                         const size = paperSizes[params.paper_size];
                         previewContainer.style.width = size.width;
                         previewContainer.style.height = size.height;
                     }
                 }
             }
         }
         
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
         
                   // Add visual indicator for Paper columns
          if (params.paper_columns) {
              const paperColumns = parseInt(params.paper_columns);
              previewContainer.setAttribute('data-paper-columns', paperColumns);
              
              // Remove all existing paper column classes first
              previewContainer.classList.remove('paper-columns-1', 'paper-columns-2', 'paper-columns-3');
              
              // Add the appropriate paper column class
              previewContainer.classList.add(`paper-columns-${paperColumns}`);
              
              console.log(`Applied paper-columns-${paperColumns} class`);
          }
    }
    
        // Function to generate preview HTML with multi-page support
    function generatePreviewHTML(exam, params) {
        console.log('generatePreviewHTML called with:', { exam, params });
        
        let html = '';
        
        // Calculate questions per page based on A4 dimensions
        const questionsPerPage = calculateQuestionsPerPage(params);
        const totalQuestions = exam.questions.length;
        const totalPages = Math.ceil(totalQuestions / questionsPerPage);
        
        console.log(`Calculated: ${questionsPerPage} questions per page, ${totalPages} total pages`);
        
        // Generate each page
        for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
            const startIndex = (pageNum - 1) * questionsPerPage;
            const endIndex = Math.min(startIndex + questionsPerPage, totalQuestions);
            const pageQuestions = exam.questions.slice(startIndex, endIndex);
            
            console.log(`Page ${pageNum}: Questions ${startIndex + 1} to ${endIndex} (${pageQuestions.length} questions)`);
            
            // Start page container
            const paperColumns = parseInt(params.paper_columns) || 1;
            html += `<div class="page-container" data-columns="${paperColumns}" data-page="${pageNum}">`;
            console.log(`Created page container ${pageNum} with ${paperColumns} columns`);
            
            // Page title
            html += `<div class="page-title">📄 Page ${pageNum} of ${totalPages} (${pageQuestions.length} questions)</div>`;
            
            // Header (only on first page)
            if (pageNum === 1 && params.include_header) {
                const headerSpan = params.header_span || '1';
                console.log(`Generating header with span: ${headerSpan}`);
                
                const headerContent = `
                    <div class="header-container" style="text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px;">
                        <div style="font-size: ${(parseInt(params.font_size) || 12) + 8}pt; font-weight: bold; margin-bottom: 3px;">${exam.title}</div>
                        <div style="font-size: ${(parseInt(params.font_size) || 12) + 4}pt; font-weight: bold; margin-bottom: 3px;">${exam.question_header || 'Model Test'}</div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; font-size: ${(parseInt(params.font_size) || 12) + 4}pt; font-weight: bold; color: #333;">
                            <div>Full Marks: ${exam.questions.reduce((sum, q) => sum + (q.marks || 1), 0)}</div>
                            <div>Time: ${exam.duration} minutes</div>
                        </div>
                    </div>`;
                
                html += headerContent;
            }
            
            // Questions for this page
            if (paperColumns > 1) {
                // Multi-column layout within the page
                html += `<div class="questions-container">`;
                
                // Create columns
                for (let columnIndex = 0; columnIndex < paperColumns; columnIndex++) {
                    html += `<div class="question-column">`;
                    html += `<div style="font-size: 12px; color: #666; margin-bottom: 10px; font-weight: bold;">Column ${columnIndex + 1}</div>`;
                    
                    // Distribute questions across columns for this page
                    let questionsInThisColumn = 0;
                    for (let i = columnIndex; i < pageQuestions.length; i += paperColumns) {
                        const question = pageQuestions[i];
                        const questionNumber = startIndex + i + 1;
                        html += generateQuestionHTML(question, questionNumber, params);
                        questionsInThisColumn++;
                    }
                    
                    console.log(`Page ${pageNum}, Column ${columnIndex + 1}: ${questionsInThisColumn} questions`);
                    html += '</div>';
                }
                
                html += '</div>';
            } else {
                // Single column layout
                pageQuestions.forEach((question, index) => {
                    const questionNumber = startIndex + index + 1;
                    html += generateQuestionHTML(question, questionNumber, params);
                });
            }
            
            // Close page container
            html += '</div>';
        }
        
        // Add pagination controls
        if (totalPages > 1) {
            html += generatePaginationHTML(totalPages);
            console.log(`Added pagination for ${totalPages} pages`);
        } else {
            console.log('No pagination needed - only one page');
        }
        
        console.log(`Generated HTML with ${totalPages} pages and pagination`);
        return html;
    }
    
    // Function to calculate questions per page based on A4 dimensions
    function calculateQuestionsPerPage(params) {
        const fontSize = parseInt(params.font_size) || 12;
        const lineSpacing = parseFloat(params.line_spacing) || 1.5;
        
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
        
        // Calculate how many questions can fit
        const questionsPerPage = Math.max(6, Math.floor(availableHeight / avgQuestionHeightMm));
        
        console.log('A4 Page Calculation:', {
            pageHeight,
            availableHeight,
            lineHeightMm,
            avgQuestionHeightMm,
            questionsPerPage
        });
        
        return questionsPerPage;
    }
    
    // Function to generate pagination HTML
    function generatePaginationHTML(totalPages) {
        let html = '<div class="pagination">';
        
        // Previous button
        html += '<button onclick="goToPage(currentPage - 1)" id="prevBtn" disabled>← Previous</button>';
        
        // Page info
        html += `<div class="page-info">Page <span id="currentPageDisplay">1</span> of ${totalPages}</div>`;
        
        // Next button
        html += '<button onclick="goToPage(currentPage + 1)" id="nextBtn">Next →</button>';
        
        html += '</div>';
        
        return html;
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
     

     
             // Initial preview
        console.log('DOM loaded, calling updatePreview');
        updatePreview();
    });
</script>
@endsection
