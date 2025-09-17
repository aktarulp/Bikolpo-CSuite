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
                                <option value="A4" {{ ($params['paper_size'] ?? 'A4') === 'A4' ? 'selected' : '' }}>A4</option>
                                <option value="Letter" {{ ($params['paper_size'] ?? 'A4') === 'Letter' ? 'selected' : '' }}>Letter</option>
                                <option value="Legal" {{ ($params['paper_size'] ?? 'A4') === 'Legal' ? 'selected' : '' }}>Legal</option>
                            </select>
                        </div>

                        <div>
                            <label for="orientation" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Orientation</label>
                            <select id="orientation" name="orientation" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                <option value="portrait" {{ ($params['orientation'] ?? 'portrait') === 'portrait' ? 'selected' : '' }}>Portrait</option>
                                <option value="landscape" {{ ($params['orientation'] ?? 'portrait') === 'landscape' ? 'selected' : '' }}>Landscape</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="paper_columns" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Columns</label>
                            <select id="paper_columns" name="paper_columns" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                <option value="1" {{ ($params['paper_columns'] ?? '1') === '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ ($params['paper_columns'] ?? '1') === '2' ? 'selected' : '' }}>2</option>
                                <option value="3" {{ ($params['paper_columns'] ?? '1') === '3' ? 'selected' : '' }}>3</option>
                                <option value="4" {{ ($params['paper_columns'] ?? '1') === '4' ? 'selected' : '' }}>4</option>
                            </select>
                        </div>

                        <div>
                            <label for="adjust_to_percentage" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Scale (%)</label>
                            <input type="number" id="adjust_to_percentage" name="adjust_to_percentage" value="{{ $params['adjust_to_percentage'] ?? 100 }}" min="10" max="500" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-4 gap-2">
                        <div>
                            <label for="margin_top" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Top</label>
                            <input type="number" id="margin_top" name="margin_top" value="{{ $params['margin_top'] ?? 0 }}" min="0" max="50" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                        </div>

                        <div>
                            <label for="margin_bottom" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Bottom</label>
                            <input type="number" id="margin_bottom" name="margin_bottom" value="{{ $params['margin_bottom'] ?? 0 }}" min="0" max="50" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                        </div>

                        <div>
                            <label for="margin_left" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Left</label>
                            <input type="number" id="margin_left" name="margin_left" value="{{ $params['margin_left'] ?? 0 }}" min="0" max="50" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                        </div>

                        <div>
                            <label for="margin_right" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Right</label>
                            <input type="number" id="margin_right" name="margin_right" value="{{ $params['margin_right'] ?? 0 }}" min="0" max="50" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
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
                        <input type="checkbox" id="include_header" name="include_header" value="1" {{ ($params['include_header'] ?? true) ? 'checked' : '' }} class="w-3 h-3 text-indigo-600 bg-white border-indigo-300 rounded focus:ring-indigo-500 focus:ring-1 dark:focus:ring-indigo-400 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-indigo-600">
                        <label for="include_header" class="text-xs font-medium text-indigo-600 dark:text-indigo-400">Include Header</label>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="font_family" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Font</label>
                            <select id="font_family" name="font_family" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                <option value="Arial" {{ ($params['font_family'] ?? 'Calibri') === 'Arial' ? 'selected' : '' }}>Arial</option>
                                <option value="Times New Roman" {{ ($params['font_family'] ?? 'Calibri') === 'Times New Roman' ? 'selected' : '' }}>Times New Roman</option>
                                <option value="Calibri" {{ ($params['font_family'] ?? 'Calibri') === 'Calibri' ? 'selected' : '' }}>Calibri</option>
                                <option value="Georgia" {{ ($params['font_family'] ?? 'Calibri') === 'Georgia' ? 'selected' : '' }}>Georgia</option>
                                <option value="Verdana" {{ ($params['font_family'] ?? 'Calibri') === 'Verdana' ? 'selected' : '' }}>Verdana</option>
                            </select>
                        </div>

                        <div>
                            <label for="font_size" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Size</label>
                            <select id="font_size" name="font_size" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                <option value="10" {{ ($params['font_size'] ?? '10') === '10' ? 'selected' : '' }}>10pt</option>
                                <option value="11" {{ ($params['font_size'] ?? '10') === '11' ? 'selected' : '' }}>11pt</option>
                                <option value="12" {{ ($params['font_size'] ?? '10') === '12' ? 'selected' : '' }}>12pt</option>
                                <option value="14" {{ ($params['font_size'] ?? '10') === '14' ? 'selected' : '' }}>14pt</option>
                                <option value="16" {{ ($params['font_size'] ?? '10') === '16' ? 'selected' : '' }}>16pt</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="line_spacing" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Line Spacing</label>
                            <select id="line_spacing" name="line_spacing" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                <option value="1.0" {{ ($params['line_spacing'] ?? '1.0') === '1.0' ? 'selected' : '' }}>Single</option>
                                <option value="1.15" {{ ($params['line_spacing'] ?? '1.0') === '1.15' ? 'selected' : '' }}>1.15</option>
                                <option value="1.5" {{ ($params['line_spacing'] ?? '1.0') === '1.5' ? 'selected' : '' }}>1.5</option>
                                <option value="2.0" {{ ($params['line_spacing'] ?? '1.0') === '2.0' ? 'selected' : '' }}>Double</option>
                            </select>
                        </div>

                        <div>
                            <label for="mcq_columns" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">MCQ Columns</label>
                            <select id="mcq_columns" name="mcq_columns" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                <option value="1" {{ ($params['mcq_columns'] ?? '4') === '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ ($params['mcq_columns'] ?? '4') === '2' ? 'selected' : '' }}>2</option>
                                <option value="3" {{ ($params['mcq_columns'] ?? '4') === '3' ? 'selected' : '' }}>3</option>
                                <option value="4" {{ ($params['mcq_columns'] ?? '4') === '4' ? 'selected' : '' }}>4</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="header_span" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Header Span</label>
                            <select id="header_span" name="header_span" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                <option value="1" {{ ($params['header_span'] ?? '1') === '1' ? 'selected' : '' }}>1 Column</option>
                                <option value="2" {{ ($params['header_span'] ?? '1') === '2' ? 'selected' : '' }}>2 Columns</option>
                                <option value="3" {{ ($params['header_span'] ?? '1') === '3' ? 'selected' : '' }}>3 Columns</option>
                                <option value="4" {{ ($params['header_span'] ?? '1') === '4' ? 'selected' : '' }}>4 Columns</option>
                                <option value="full" {{ ($params['header_span'] ?? '1') === 'full' ? 'selected' : '' }}>Full Width</option>
                            </select>
                        </div>

                        <div>
                            <label for="header_push" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Header Push</label>
                            <select id="header_push" name="header_push" class="w-full px-2 py-1.5 text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                                <option value="1st_col" {{ ($params['header_push'] ?? '1st_col') === '1st_col' ? 'selected' : '' }}>1st Column</option>
                                <option value="2nd_col" {{ ($params['header_push'] ?? '1st_col') === '2nd_col' ? 'selected' : '' }}>2nd Column</option>
                                <option value="3rd_col" {{ ($params['header_push'] ?? '1st_col') === '3rd_col' ? 'selected' : '' }}>3rd Column</option>
                                <option value="4th_col" {{ ($params['header_push'] ?? '1st_col') === '4th_col' ? 'selected' : '' }}>4th Column</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="mark_answer" name="mark_answer" value="1" {{ ($params['mark_answer'] ?? false) ? 'checked' : '' }} class="w-3 h-3 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-1 dark:focus:ring-blue-400 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                            <label for="mark_answer" class="text-xs font-medium text-gray-600 dark:text-gray-400">Mark Correct Answers</label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="show_page_number" name="show_page_number" value="1" {{ ($params['show_page_number'] ?? false) ? 'checked' : '' }} class="w-3 h-3 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-1 dark:focus:ring-blue-400 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
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
