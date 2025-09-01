@extends('layouts.partner-layout')

@section('title', 'Question Paper Parameters')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Question Paper Parameters</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">Configure settings for your question paper before downloading</p>
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

        <!-- Parameters Form -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Paper Settings</h3>
            </div>
            
            <form action="{{ route('partner.exams.download-paper', $exam) }}" method="POST" class="p-6 space-y-6">
                @csrf
                
                <!-- Paper Format Section -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">Paper Format</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="paper_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Paper Size</label>
                            <select id="paper_size" name="paper_size" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="A4" selected>A4 (210 × 297 mm)</option>
                                <option value="Letter">Letter (8.5 × 11 in)</option>
                                <option value="Legal">Legal (8.5 × 14 in)</option>
                                <option value="A3">A3 (297 × 420 mm)</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="orientation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Orientation</label>
                            <select id="orientation" name="orientation" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="portrait" selected>Portrait</option>
                                <option value="landscape">Landscape</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Typography Section -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">Typography</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="font_family" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Font Family</label>
                            <select id="font_family" name="font_family" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="Arial" selected>Arial</option>
                                <option value="Times New Roman">Times New Roman</option>
                                <option value="Calibri">Calibri</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Verdana">Verdana</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="font_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Base Font Size</label>
                            <select id="font_size" name="font_size" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="10">10pt</option>
                                <option value="11">11pt</option>
                                <option value="12" selected>12pt</option>
                                <option value="14">14pt</option>
                                <option value="16">16pt</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="line_spacing" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Line Spacing</label>
                            <select id="line_spacing" name="line_spacing" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="1.0">Single (1.0)</option>
                                <option value="1.15">1.15</option>
                                <option value="1.5" selected>1.5</option>
                                <option value="2.0">Double (2.0)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Margins Section -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">Margins & Spacing</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label for="margin_top" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Top Margin (mm)</label>
                            <input type="number" id="margin_top" name="margin_top" value="25" min="10" max="50" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <div>
                            <label for="margin_bottom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bottom Margin (mm)</label>
                            <input type="number" id="margin_bottom" name="margin_bottom" value="25" min="10" max="50" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <div>
                            <label for="margin_left" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Left Margin (mm)</label>
                            <input type="number" id="margin_left" name="margin_left" value="20" min="10" max="50" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <div>
                            <label for="margin_right" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Right Margin (mm)</label>
                            <input type="number" id="margin_right" name="margin_right" value="20" min="10" max="50" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- Content Options Section -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">Content Options</h4>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="include_header" name="include_header" value="1" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="include_header" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Include exam header information</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="include_instructions" name="include_instructions" value="1" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="include_instructions" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Include student instructions</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="include_question_headers" name="include_question_headers" value="1" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="include_question_headers" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Include question headers (if available)</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="include_footer" name="include_footer" value="1" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="include_footer" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Include footer with timestamp</label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('partner.exams.show', $exam) }}" 
                       class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        ← Back to Exam
                    </a>
                    
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                        📥 Download Question Paper
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
