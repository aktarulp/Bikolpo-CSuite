@extends('layouts.partner-layout')

@section('title', 'Question Paper Parameters')

@section('content')
<style>
    #livePreview.landscape {
        transform: none !important;
        writing-mode: horizontal-tb;
    }
    
    #livePreview.portrait {
        transform: none !important;
        writing-mode: horizontal-tb;
    }
    
         #livePreview {
         margin: 0 auto;
         display: block;
         overflow: visible;
     }
     
     /* Page Container Styles */
     .page-container {
         background: white;
         border: 1px solid #ddd;
         margin-bottom: 20px;
         box-shadow: 0 2px 4px rgba(0,0,0,0.1);
         page-break-after: always;
         break-after: page;
     }
     
     .page-container:last-child {
         page-break-after: auto;
         break-after: auto;
     }
     
     .page-content {
         padding: 20px;
         min-height: 100%;
         box-sizing: border-box;
     }
     
     /* Print Styles */
     @media print {
         .page-container {
             page-break-after: always;
             break-after: page;
             margin-bottom: 0;
             box-shadow: none;
         }
         
         .page-container:last-child {
             page-break-after: auto;
             break-after: auto;
         }
     }
    
    /* Paper Column Layout Styles */
    #livePreview.paper-columns-2 {
        column-count: 2 !important;
        column-gap: 20px !important;
        column-rule: 1px solid #ddd !important;
        column-fill: balance !important;
    }
    
    #livePreview.paper-columns-3 {
        column-count: 3 !important;
        column-gap: 20px !important;
        column-rule: 1px solid #ddd !important;
        column-fill: balance !important;
    }
    
    #livePreview.paper-columns-1 {
        column-count: 1 !important;
        column-gap: normal !important;
        column-rule: none !important;
        column-fill: auto !important;
    }
    
         /* Ensure content doesn't break awkwardly in columns */
     #livePreview > div {
         break-inside: avoid;
         page-break-inside: avoid;
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
                                        <option value="1" selected>1 Column</option>
                                        <option value="2">2 Columns</option>
                                        <option value="3">3 Columns</option>
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
                            
                            <!-- Font Settings, Line Spacing and MCQ Columns -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label for="font_family" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Font Family</label>
                                    <select id="font_family" name="font_family" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                        <option value="Arial" selected>Arial</option>
                                        <option value="Times New Roman">Times New Roman</option>
                                        <option value="Calibri">Calibri</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Verdana">Verdana</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="font_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Font Size</label>
                                    <select id="font_size" name="font_size" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                        <option value="10">10pt</option>
                                        <option value="11">11pt</option>
                                        <option value="12" selected>12pt</option>
                                        <option value="14">14pt</option>
                                        <option value="16">16pt</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="line_spacing" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Line Spacing</label>
                                    <select id="line_spacing" name="line_spacing" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                        <option value="1.0">Single (1.0)</option>
                                        <option value="1.15">1.15</option>
                                        <option value="1.5" selected>1.5</option>
                                        <option value="2.0">Double (2.0)</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="mcq_columns" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">MCQ Columns</label>
                                    <select id="mcq_columns" name="mcq_columns" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                        <option value="1">1 Column</option>
                                        <option value="2" selected>2 Columns</option>
                                        <option value="3">3 Columns</option>
                                        <option value="4">4 Columns</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Content Options -->
                            <div class="space-y-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content Options</label>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="include_header" name="include_header" value="1" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="include_header" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Include exam header information</label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input type="checkbox" id="include_full_marks" name="include_full_marks" value="1" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="include_full_marks" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Include full marks on left side</label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input type="checkbox" id="include_duration" name="include_duration" value="1" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="include_duration" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Include duration information</label>
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
    
             // Function to update live preview
    function updatePreview() {
        console.log('updatePreview called');
        
        const formData = new FormData(form);
        const params = Object.fromEntries(formData.entries());
        console.log('Form params:', params);
        
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
        
                 // Generate preview HTML
         const previewHTML = generatePreviewHTML(examData, params);
         console.log('Preview HTML generated, length:', previewHTML.length);
         previewContainer.innerHTML = previewHTML;
        
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
         
         // Add visual indicator for Paper columns
         if (params.paper_columns) {
             const paperColumns = parseInt(params.paper_columns);
             previewContainer.setAttribute('data-paper-columns', paperColumns);
             
             // Add CSS custom property for paper columns
             previewContainer.style.setProperty('--paper-columns', paperColumns);
             
             // Apply paper column layout to the preview container
             if (paperColumns > 1) {
                 previewContainer.style.columnCount = paperColumns;
                 previewContainer.style.columnGap = '20px';
                 previewContainer.style.columnRule = '1px solid #ddd';
                 
                 // Force column layout with additional CSS properties
                 previewContainer.style.columnFill = 'balance';
                 previewContainer.style.breakInside = 'avoid';
                 
                 // Add CSS class for better column control
                 previewContainer.classList.add(`paper-columns-${paperColumns}`);
                 previewContainer.classList.remove('paper-columns-1');
             } else {
                 previewContainer.style.columnCount = 'auto';
                 previewContainer.style.columnGap = 'normal';
                 previewContainer.style.columnRule = 'none';
                 previewContainer.style.columnFill = 'auto';
                 previewContainer.style.breakInside = 'auto';
                 
                 // Remove all column classes
                 previewContainer.classList.remove('paper-columns-2', 'paper-columns-3');
                 previewContainer.classList.add('paper-columns-1');
             }
         }
    }
    
        // Function to generate preview HTML with pagination
    function generatePreviewHTML(exam, params) {
        console.log('generatePreviewHTML called with:', { exam, params });
        
        let html = '';
        
        // Get paper dimensions for pagination
        let paperHeight;
        const paperSizes = {
            'A4': { width: 210, height: 297 },
            'Letter': { width: 216, height: 279 },
            'Legal': { width: 216, height: 356 },
            'A3': { width: 297, height: 420 }
        };
        
        if (paperSizes[params.paper_size]) {
            const size = paperSizes[params.paper_size];
            // Swap dimensions for landscape orientation
            if (params.orientation === 'landscape') {
                paperHeight = size.width;
            } else {
                paperHeight = size.height;
            }
        } else {
            paperHeight = 297; // Default A4 height
        }
        
        // Convert mm to pixels (assuming 96 DPI, 1 inch = 25.4mm)
        const pixelsPerMm = 96 / 25.4;
        const maxPageHeight = (paperHeight - 40) * pixelsPerMm; // Subtract margins
        
        let currentPageContent = '';
        let currentPageHeight = 0;
        let pageNumber = 1;
        
        // Function to add a new page
        function addPage(content) {
            const pageWidth = paperSizes[params.paper_size] ? 
                (params.orientation === 'landscape' ? paperSizes[params.paper_size].height + 'mm' : paperSizes[params.paper_size].width + 'mm') : 
                '210mm';
            
            html += `
                <div class="page-container" style="width: ${pageWidth}; height: ${paperHeight}mm;">
                    <div class="page-content">
                        ${content}
                    </div>
                </div>`;
        }
        
        // Function to check if content fits on current page
        function checkPageFit(contentHeight) {
            return (currentPageHeight + contentHeight) <= maxPageHeight;
        }
        
        // Header
        if (params.include_header) {
            const headerContent = `
                <div style="text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px;">
                    <div style="font-size: ${(parseInt(params.font_size) || 12) + 8}pt; font-weight: bold; margin-bottom: 5px;">${exam.title}</div>
                    <div style="font-size: ${(parseInt(params.font_size) || 12) + 4}pt; font-weight: bold; margin-bottom: 5px;">${exam.question_header || 'Model Test'}</div>`;
            
            let headerFooterContent = headerContent;
            
            // Full Marks and Duration below Model Test -1
            if (params.include_full_marks || params.include_duration) {
                headerFooterContent += '<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; font-size: ' + (parseInt(params.font_size) || 12) + 'pt; font-weight: bold; color: #333;">';
                
                if (params.include_full_marks) {
                    const totalMarks = exam.questions.reduce((sum, q) => sum + (q.marks || 1), 0);
                    headerFooterContent += `<div>Full Marks: ${totalMarks}</div>`;
                } else {
                    headerFooterContent += '<div></div>'; // Empty div for spacing
                }
                
                if (params.include_duration) {
                    headerFooterContent += `<div>Time: ${exam.duration} minutes</div>`;
                } else {
                    headerFooterContent += '<div></div>'; // Empty div for spacing
                }
                
                headerFooterContent += '</div>';
            }
            
            headerFooterContent += '</div>';
            
            // Estimate header height (approximately 120px for header)
            const headerHeight = 120;
            
            if (!checkPageFit(headerHeight)) {
                // Start new page with header
                addPage(headerFooterContent);
                currentPageHeight = headerHeight;
                currentPageContent = '';
            } else {
                currentPageContent += headerFooterContent;
                currentPageHeight += headerHeight;
            }
        }
        
        // Questions
        exam.questions.forEach((question, index) => {
            const questionNumber = index + 1;
            
            // Generate question content
            let questionContent = `<div style="margin-bottom: 25px;">`;
            
            if (question.question_header) {
                questionContent += `<div style="margin: 10px 0; font-style: italic; color: #666;">${question.question_header}</div>`;
            }
            
            // Clean question text to remove any "(Question #X)" patterns
            const cleanQuestionText = question.question_text.replace(/\(Question\s*#\d+\)/gi, '').trim();
            questionContent += `<div style="margin: 10px 0; font-weight: bold; color: #333;">${questionNumber}. ${cleanQuestionText}</div>`;
            
            if (question.question_type === 'mcq') {
                const columns = parseInt(params.mcq_columns) || 2;
                const options = [
                    { label: 'A', text: question.option_a },
                    { label: 'B', text: question.option_b },
                    { label: 'C', text: question.option_c },
                    { label: 'D', text: question.option_d }
                ].filter(opt => opt.text); // Only include options that have text
                
                questionContent += '<div style="margin-left: 20px;">';
                questionContent += `<div style="display: grid; grid-template-columns: repeat(${columns}, 1fr); gap: 20px; margin: 10px 0; row-gap: 8px;">`;
                
                // Generate options based on column count
                options.forEach((option, optionIndex) => {
                    questionContent += `<div style="margin: 2px 0; display: flex; align-items: center;">
                        <div style="width: 20px; height: 20px; border: 2px solid #333; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 8px; font-size: 10pt; font-weight: bold; line-height: 1; text-align: center; position: relative;">
                            <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); margin: 0; padding: 0;">${option.label}</span>
                        </div>
                        <span>${option.text}</span>
                    </div>`;
                });
                
                questionContent += '</div>';
                questionContent += '</div>';
            }
            
            questionContent += '</div>';
            
            // Estimate question height (approximately 80px per question + options)
            const questionHeight = 80 + (question.question_type === 'mcq' ? (question.option_a ? 80 : 0) : 0);
            
            if (!checkPageFit(questionHeight)) {
                // Add current page content to HTML
                if (currentPageContent) {
                    addPage(currentPageContent);
                }
                
                // Start new page
                currentPageContent = questionContent;
                currentPageHeight = questionHeight;
                pageNumber++;
            } else {
                currentPageContent += questionContent;
                currentPageHeight += questionHeight;
            }
        });
        
        // Always add remaining content to final page
        if (currentPageContent) {
            addPage(currentPageContent);
        }
        
        console.log('Generated HTML with pagination, pages:', pageNumber);
        return html;
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
