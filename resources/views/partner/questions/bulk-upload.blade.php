@extends('layouts.partner-layout')

@section('title', 'Bulk Upload Questions')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-4 sm:py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Bulk Upload Questions</h1>
                    <p class="text-gray-600 text-sm sm:text-base">Upload multiple questions at once using CSV format</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('partner.questions.drafts') }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors duration-200 text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        View Drafts
                    </a>
                    <a href="{{ route('partner.questions.all') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200 text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Questions
                    </a>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="h-5 w-5 text-green-400 mt-0.5 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('import_errors'))
            <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="h-5 w-5 text-yellow-400 mt-0.5 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-yellow-800 mb-2">Import completed with some errors</h3>
                        <div class="text-sm text-yellow-700 max-h-32 overflow-y-auto">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach (session('import_errors') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Upload Form -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="p-6">
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-red-400 mt-0.5 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-red-800 mb-2">There were errors with your submission</h3>
                                <ul class="text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('partner.questions.bulk-upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- File Upload -->
                    <div>
                        <label for="csv_file" class="block text-sm font-medium text-gray-700 mb-3">
                            Select CSV File
                        </label>
                        <div class="relative">
                            <input id="csv_file" name="csv_file" type="file" 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:cursor-pointer cursor-pointer border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                                   accept=".csv,.txt" required>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">CSV or TXT files up to 2MB</p>
                        @error('csv_file')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center">
                        <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Upload Questions
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quick Guide -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Guide</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Required Fields -->
                    <div>
                        <h3 class="font-medium text-gray-800 mb-3">Required Fields</h3>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <span><strong>question_text:</strong> The question content</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <span><strong>option_a, option_b, option_c, option_d:</strong> Answer choices</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <span><strong>correct_answer:</strong> a, b, c, or d</span>
                            </div>
                        </div>
                    </div>

                    <!-- Optional Fields -->
                    <div>
                        <h3 class="font-medium text-gray-800 mb-3">Optional Fields</h3>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                <span><strong>explanation:</strong> Answer explanation</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Download Template -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="font-medium text-gray-800 mb-1">Need a template?</h3>
                            <p class="text-sm text-gray-600">Download a sample CSV file to get started</p>
                        </div>
                        <button onclick="downloadTemplate()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download Template
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Process Steps -->
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl border border-blue-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">What happens next?</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-10 h-10 flex items-center justify-center mx-auto mb-3">
                        <span class="text-blue-600 font-bold text-sm">1</span>
                    </div>
                    <h3 class="font-medium text-gray-800 text-sm mb-1">Upload</h3>
                    <p class="text-xs text-gray-600">Questions saved as drafts</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-10 h-10 flex items-center justify-center mx-auto mb-3">
                        <span class="text-blue-600 font-bold text-sm">2</span>
                    </div>
                    <h3 class="font-medium text-gray-800 text-sm mb-1">Review</h3>
                    <p class="text-xs text-gray-600">Assign course & subject</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-10 h-10 flex items-center justify-center mx-auto mb-3">
                        <span class="text-blue-600 font-bold text-sm">3</span>
                    </div>
                    <h3 class="font-medium text-gray-800 text-sm mb-1">Publish</h3>
                    <p class="text-xs text-gray-600">Questions become active</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function downloadTemplate() {
    const csvContent = `question_text,option_a,option_b,option_c,option_d,correct_answer,explanation
"What is the capital of France?","London","Paris","Berlin","Madrid","b","Paris is the capital and largest city of France."
"What is 2 + 2?","3","4","5","6","b","Basic addition: 2 + 2 = 4"
"Which planet is closest to the Sun?","Venus","Mercury","Earth","Mars","b","Mercury is the first planet from the Sun."
"What is the largest ocean on Earth?","Atlantic","Indian","Arctic","Pacific","d","The Pacific Ocean is the largest and deepest ocean on Earth."
"What is the chemical symbol for gold?","Ag","Au","Fe","Cu","b","Au is the chemical symbol for gold (from Latin 'aurum')."`;

    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'questions_template.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}
</script>
@endsection