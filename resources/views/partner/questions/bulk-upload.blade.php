@extends('layouts.partner-layout')

@section('title', 'Bulk Upload Questions')

@section('content')
<div class="container mx-auto max-w-6xl">
    <!-- Page Header -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Bulk Upload Questions</h1>
                <p class="text-gray-600">Upload multiple questions at once using a simplified CSV format</p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('partner.questions.all') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2.5 rounded-lg transition-colors duration-200 flex items-center gap-2.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Questions
                </a>
            </div>
        </div>
        
        <!-- Two-Step Process Explanation -->
        <div class="bg-blue-100 border border-blue-300 rounded-lg p-4 mt-4">
            <h3 class="text-lg font-semibold text-blue-800 mb-3">✨ New Simplified Process - Two Steps!</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-700">
                <div>
                    <h4 class="font-medium mb-2">Step 1: Upload Questions</h4>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Prepare CSV with only question content</li>
                        <li>No need to know course/subject/topic IDs</li>
                        <li>Questions are saved as drafts</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-medium mb-2">Step 2: Review & Publish</h4>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Review all uploaded questions</li>
                        <li>Assign course, subject, and topic</li>
                        <li>Set marks and difficulty level</li>
                        <li>Publish questions when ready</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('import_errors'))
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Import completed with some errors</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <ul class="list-disc pl-5 space-y-1 max-h-40 overflow-y-auto">
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
    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
        <div class="max-w-3xl mx-auto">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('partner.questions.bulk-upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- File Upload -->
                <div>
                    <label for="csv_file" class="block text-sm font-medium text-gray-700 mb-2">
                        Select CSV File
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="csv_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload a file</span>
                                    <input id="csv_file" name="csv_file" type="file" class="sr-only" accept=".csv,.txt" required>
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">CSV or TXT up to 2MB</p>
                        </div>
                    </div>
                    @error('csv_file')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center gap-2 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Upload Questions as Drafts
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Instructions and Template -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Instructions & Template</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Instructions -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-800">How to prepare your CSV file:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-sm text-gray-600">
                        <li>Use the template below as a starting point</li>
                        <li>Only fill in the question content and options</li>
                        <li><strong>No need to know course/subject/topic IDs!</strong></li>
                        <li>Save your file as CSV format</li>
                        <li>Maximum file size: 2MB</li>
                    </ol>
                    
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h4 class="font-medium text-green-800 mb-2">✅ Required Fields (Only 6 columns!):</h4>
                        <ul class="text-sm text-green-700 space-y-1">
                            <li><strong>question_text:</strong> The actual question</li>
                            <li><strong>option_a:</strong> First multiple choice option</li>
                            <li><strong>option_b:</strong> Second multiple choice option</li>
                            <li><strong>option_c:</strong> Third multiple choice option</li>
                            <li><strong>option_d:</strong> Fourth multiple choice option</li>
                            <li><strong>correct_answer:</strong> The correct answer (a, b, c, or d)</li>
                        </ul>
                    </div>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="font-medium text-blue-800 mb-2">📝 Optional Fields:</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li><strong>explanation:</strong> Explanation of the answer (optional)</li>
                        </ul>
                    </div>
                </div>

                <!-- Template Download -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-800">Download Template</h3>
                    <p class="text-sm text-gray-600 mb-4">Download a sample CSV template with the correct format and example data.</p>
                    
                    <button onclick="downloadTemplate()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mb-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download CSV Template
                    </button>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-800 mb-2">Sample Data:</h4>
                        <div class="text-xs text-gray-600 font-mono bg-white p-3 rounded border overflow-x-auto">
                            <div class="whitespace-nowrap">
                                question_text,option_a,option_b,option_c,option_d,correct_answer,explanation<br>
                                "What is the capital of France?","London","Paris","Berlin","Madrid","b","Paris is the capital and largest city of France."<br>
                                "What is 2 + 2?","3","4","5","6","b","Basic addition: 2 + 2 = 4"<br>
                                "Which planet is closest to the Sun?","Venus","Mercury","Earth","Mars","b","Mercury is the first planet from the Sun."
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Next Steps Info -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-xl font-semibold text-yellow-800 mb-4">🔄 What Happens Next?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-yellow-700">
                <div class="text-center">
                    <div class="bg-yellow-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2">
                        <span class="text-yellow-800 font-bold">1</span>
                    </div>
                    <h3 class="font-medium">Upload Complete</h3>
                    <p>Questions are saved as drafts</p>
                </div>
                <div class="text-center">
                    <div class="bg-yellow-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2">
                        <span class="text-yellow-800 font-bold">2</span>
                    </div>
                    <h3 class="font-medium">Review & Assign</h3>
                    <p>Set course, subject, topic, marks</p>
                </div>
                <div class="text-center">
                    <div class="bg-yellow-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2">
                        <span class="text-yellow-800 font-bold">3</span>
                    </div>
                    <h3 class="font-medium">Publish</h3>
                    <p>Questions become active and usable</p>
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
