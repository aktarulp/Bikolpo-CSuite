@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Create Multiple Choice Question
                    </h1>
                    <p class="mt-2 text-gray-600">Design engaging questions for your students</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('partner.questions.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Questions
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Form Container -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <form action="{{ route('partner.questions.mcq.store') }}" method="POST" id="mcqForm" class="p-8">
                @csrf
                <input type="hidden" name="question_type" value="mcq">
                
                <!-- Question Details Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900">Question Details</h2>
                            <p class="text-gray-600">Enter the main question and basic information</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Course Selection -->
                        <div class="space-y-2">
                            <label for="course_id" class="block text-sm font-medium text-gray-700">
                                Course <span class="text-red-500">*</span>
                            </label>
                            <select name="course_id" id="course_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                <option value="">Select a course</option>
                                @foreach($courses ?? [] as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subject Selection -->
                        <div class="space-y-2">
                            <label for="subject_id" class="block text-sm font-medium text-gray-700">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <select name="subject_id" id="subject_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                <option value="">Select a subject</option>
                                @foreach($subjects ?? [] as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Topic Selection -->
                        <div class="space-y-2">
                            <label for="topic_id" class="block text-sm font-medium text-gray-700">
                                Topic <span class="text-gray-400">(Optional)</span>
                            </label>
                            <select name="topic_id" id="topic_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                <option value="">Select a topic (optional)</option>
                                @foreach($topics ?? [] as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                                 <!-- Question Text and Answer Options Section -->
                 <div class="mb-8">
                     <div class="flex items-center justify-between mb-6">
                         <div class="flex items-center">
                             <div class="flex-shrink-0">
                                                                   <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-teal-600 rounded-full flex items-center justify-center">
                                      <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                      </svg>
                                  </div>
                             </div>
                             <div class="ml-4">
                                 <h2 class="text-xl font-semibold text-gray-900">Question Text</h2>
                                 <p class="text-gray-600">Write your question clearly and concisely</p>
                             </div>
                         </div>
                         
                         <!-- Answer Options Header -->
                         <div class="flex items-center">
                             <div class="flex-shrink-0">
                                 <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-600 rounded-full flex items-center justify-center">
                                     <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                     </svg>
                                 </div>
                             </div>
                             <div class="ml-4">
                                 <h2 class="text-xl font-semibold text-gray-900">Answer Options</h2>
                                 <p class="text-gray-600">Select the correct answer and provide options</p>
                             </div>
                         </div>
                     </div>

                                                                                   <div class="space-y-2">
                         
                                                   <div class="flex gap-3">
                              <!-- Left Side: Rich Text Editor -->
                              <div class="flex-1">
                                 <!-- Rich Text Editor Toolbar -->
                                 <div class="border border-gray-300 rounded-t-lg bg-gray-50 p-2 flex flex-wrap items-center gap-2">
                                     <!-- Text Formatting -->
                                     <button type="button" id="boldBtn" class="p-2 hover:bg-gray-200 rounded" title="Bold">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h8a4 4 0 100-8H6v8zm0 0h8a4 4 0 110 8H6v-8z"></path>
                                         </svg>
                                     </button>
                                     <button type="button" id="italicBtn" class="p-2 hover:bg-gray-200 rounded" title="Italic">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                         </svg>
                                     </button>
                                     <button type="button" id="underlineBtn" class="p-2 hover:bg-gray-200 rounded" title="Underline">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                         </svg>
                                     </button>
                                     
                                     <div class="w-px h-6 bg-gray-300"></div>
                                     
                                     <!-- Equation -->
                                     <button type="button" id="equationBtn" class="p-2 hover:bg-gray-200 rounded text-sm font-medium" title="Insert Equation">
                                         ∑
                                     </button>
                                     
                                     <!-- Local Image Upload -->
                                     <button type="button" id="uploadImageBtn" class="p-2 hover:bg-gray-200 rounded" title="Upload Local Image">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                         </svg>
                                     </button>
                                     
                                     <!-- Hidden file input for image upload -->
                                     <input type="file" id="imageFileInput" accept="image/*" class="hidden">
                                     
                                     <!-- Image Resize -->
                                     <button type="button" id="resizeBtn" class="p-2 hover:bg-gray-200 rounded bg-blue-50 border border-blue-200" title="Resize Selected Image" style="display: inline-flex !important; visibility: visible !important;">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                         </svg>
                                         <span class="ml-1 text-xs text-blue-600 font-medium">Resize</span>
                                     </button>
                                    
                                     <div class="w-px h-6 bg-gray-300"></div>
                                     
                                     <!-- Hyperlink -->
                                     <button type="button" id="linkBtn" class="p-2 hover:bg-gray-200 rounded" title="Insert Hyperlink">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                         </svg>
                                     </button>
                                    
                                     <div class="w-px h-6 bg-gray-300"></div>
                                     
                                     <!-- Clear Formatting -->
                                     <button type="button" id="clearFormatBtn" class="p-2 hover:bg-gray-200 rounded text-sm font-medium" title="Clear Formatting">
                                         Clear
                                     </button>
                                 </div>
                                 
                                 <!-- Rich Text Editor Content -->
                                 <div id="richTextEditor" class="border border-t-0 border-gray-300 rounded-b-lg min-h-[150px] p-4 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200" contenteditable="true" data-placeholder="Enter your question here... You can use formatting, images, and equations."></div>
                                 
                                 <!-- Hidden textarea for form submission -->
                                 <textarea name="question_text" id="question_text" class="hidden" required></textarea>
                                 <input type="hidden" name="q_type_id" value="1">
                                 
                                 <div class="flex justify-between items-center text-sm text-gray-500 mt-2">
                                     <span>Use the toolbar above for formatting, equations, and images.</span>
                                     <span id="charCount">0 characters</span>
                                 </div>
                             </div>
                             
                                                                                         <!-- Right Side: Answer Options -->
                              <div class="w-72">
                                  <div class="space-y-1">
                                                                                                                 <!-- Option A -->
                                      <div class="option-item bg-gray-50 rounded-lg p-2 border-2 border-transparent hover:border-blue-200 transition-all duration-200">
                                          <div class="flex items-center space-x-2">
                                              <div class="flex-shrink-0">
                                                  <input type="radio" name="correct_answer" value="a" id="correct_A" required
                                                         class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                              </div>
                                              <label for="correct_A" class="flex-1">
                                                  <div class="flex items-center space-x-2">
                                                      <span class="option-bullet w-6 h-6 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-xs font-semibold">A</span>
                                                      <input type="text" name="option_a" placeholder="Option A" required
                                                             class="flex-1 px-2 py-1 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                                  </div>
                                              </label>
                                          </div>
                                      </div>
                                      
                                      <!-- Option B -->
                                      <div class="option-item bg-gray-50 rounded-lg p-2 border-2 border-transparent hover:border-blue-200 transition-all duration-200">
                                          <div class="flex items-center space-x-2">
                                              <div class="flex-shrink-0">
                                                  <input type="radio" name="correct_answer" value="b" id="correct_B" required
                                                         class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                              </div>
                                              <label for="correct_B" class="flex-1">
                                                  <div class="flex items-center space-x-2">
                                                      <span class="option-bullet w-6 h-6 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-xs font-semibold">B</span>
                                                      <input type="text" name="option_b" placeholder="Option B" required
                                                             class="flex-1 px-2 py-1 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                                  </div>
                                              </label>
                                          </div>
                                      </div>
                                      
                                      <!-- Option C -->
                                      <div class="option-item bg-gray-50 rounded-lg p-2 border-2 border-transparent hover:border-blue-200 transition-all duration-200">
                                          <div class="flex items-center space-x-2">
                                              <div class="flex-shrink-0">
                                                  <input type="radio" name="correct_answer" value="c" id="correct_C" required
                                                         class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                              </div>
                                              <label for="correct_C" class="flex-1">
                                                  <div class="flex items-center space-x-2">
                                                      <span class="option-bullet w-6 h-6 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-xs font-semibold">C</span>
                                                      <input type="text" name="option_c" placeholder="Option C" required
                                                             class="flex-1 px-2 py-1 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                                  </div>
                                              </label>
                                          </div>
                                      </div>
                                      
                                      <!-- Option D -->
                                      <div class="option-item bg-gray-50 rounded-lg p-2 border-2 border-transparent hover:border-blue-200 transition-all duration-200">
                                          <div class="flex items-center space-x-2">
                                              <div class="flex-shrink-0">
                                                                                                 <input type="radio" name="correct_answer" value="d" id="correct_D" required
                                                          class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                              </div>
                                              <label for="correct_D" class="flex-1">
                                                  <div class="flex items-center space-x-2">
                                                      <span class="option-bullet w-6 h-6 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-xs font-semibold">D</span>
                                                      <input type="text" name="option_d" placeholder="Option D" required
                                                             class="flex-1 px-2 py-1 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                                  </div>
                                              </label>
                                          </div>
                                      </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     

                </div>






                <!-- Explanation Section -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-blue-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-semibold text-gray-900">Explanation (Optional)</h2>
                                <p class="text-gray-600">Provide reasoning for the correct answer</p>
                            </div>
                        </div>
                        
                        <!-- Right Side: Tags Header -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-gradient-to-r from-pink-500 to-rose-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-semibold text-gray-900">Tags</h2>
                                <p class="text-gray-600">Add relevant tags for easy categorization</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <!-- Left Side: Explanation Rich Text Editor -->
                        <div class="flex-1">
                            <!-- Rich Text Editor Toolbar for Explanation -->
                            <div class="border border-gray-300 rounded-t-lg bg-gray-50 p-2 flex flex-wrap items-center gap-2">
                                <!-- Text Formatting -->
                                <button type="button" id="explanationBoldBtn" class="p-2 hover:bg-gray-200 rounded" title="Bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h8a4 4 0 100-8H6v8zm0 0h8a4 4 0 110 8H6v-8z"></path>
                                    </svg>
                                </button>
                                <button type="button" id="explanationItalicBtn" class="p-2 hover:bg-gray-200 rounded" title="Italic">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                </button>
                                <button type="button" id="explanationUnderlineBtn" class="p-2 hover:bg-gray-200 rounded" title="Underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                </button>
                                
                                <div class="w-px h-6 bg-gray-300"></div>
                                
                                <!-- Equation -->
                                <button type="button" id="explanationEquationBtn" class="p-2 hover:bg-gray-200 rounded text-sm font-medium" title="Insert Equation">
                                    ∑
                                </button>
                                
                                <!-- Local Image Upload -->
                                <button type="button" id="explanationUploadImageBtn" class="p-2 hover:bg-gray-200 rounded" title="Upload Local Image">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                </button>
                                
                                <!-- Hidden file input for explanation image upload -->
                                <input type="file" id="explanationImageFileInput" accept="image/*" class="hidden">
                                
                                <!-- Image Resize -->
                                <button type="button" id="explanationResizeBtn" class="p-2 hover:bg-gray-200 rounded bg-blue-50 border border-blue-200" title="Resize Selected Image" style="display: inline-flex !important; visibility: visible !important;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                    </svg>
                                    <span class="ml-1 text-xs text-blue-600 font-medium">Resize</span>
                                </button>
                                
                                <div class="w-px h-6 bg-gray-300"></div>
                                
                                <!-- Hyperlink -->
                                <button type="button" id="explanationLinkBtn" class="p-2 hover:bg-gray-200 rounded" title="Insert Hyperlink">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                </button>
                                
                                <!-- Clear Formatting -->
                                <button type="button" id="explanationClearFormatBtn" class="p-2 hover:bg-gray-200 rounded text-sm font-medium" title="Clear Formatting">
                                    Clear
                                </button>
                            </div>
                            
                            <!-- Rich Text Editor Content for Explanation -->
                            <div id="explanationRichTextEditor" class="border border-t-0 border-gray-300 rounded-b-lg min-h-[150px] p-4 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200" contenteditable="true" data-placeholder="Enter explanation here... You can use formatting, images, equations, and hyperlinks."></div>
                            
                            <!-- Hidden textarea for form submission -->
                            <textarea name="explanation" id="explanation" class="hidden"></textarea>
                            
                            <div class="flex justify-between items-center text-sm text-gray-500 mt-2">
                                <span>Use the toolbar above for formatting, equations, images, and hyperlinks.</span>
                                <span id="explanationCharCount">0 characters</span>
                            </div>
                        </div>
                        
                        <!-- Right Side: Tags Section -->
                        <div class="w-72">
                            <!-- Tags Section -->
                            <div class="space-y-2">
                            <div class="space-y-2">
                                <label for="tags" class="block text-sm font-medium text-gray-700">
                                    Tags
                                </label>
                                <div id="tag-list" class="flex flex-wrap gap-2 mb-2 min-h-[44px] p-2 border border-gray-300 rounded-lg bg-white">
                                    <!-- Tags will be dynamically added here -->
                                </div>
                                <input type="text" id="new-tag" 
                                       placeholder="Type and press Enter or comma to add tags"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <input type="hidden" name="tags" id="tagsInput" value="">
                                <p class="text-sm text-gray-500">Tags help organize and search questions</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question Appearance History -->
                <div class="border-b border-gray-200 pb-6 space-y-2">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-r from-amber-500 to-orange-500">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-white">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold leading-6 text-slate-800">Question Appearance History</h2>
                            <p class="text-sm text-gray-500">Add where and when this question has appeared before.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <!-- Left Side: History Input Fields -->
                        <div class="flex-1">
                            <div id="history-list" class="space-y-2 mb-4">
                                <!-- History items will be added here dynamically -->
                            </div>
                            <div class="flex gap-2">
                                <div class="w-48">
                                    <input type="text" id="exam-name" placeholder="Exam/Test name (e.g., SSC, HSC, JEE)"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                                <div class="w-40">
                                    <select id="exam-board" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option value="">Exam Board (Optional)</option>
                                        <option value="Barisal">Barisal</option>
                                        <option value="Chattogram">Chattogram</option>
                                        <option value="Cumilla">Cumilla</option>
                                        <option value="Dhaka">Dhaka</option>
                                        <option value="Dinajpur">Dinajpur</option>
                                        <option value="Jashore">Jashore</option>
                                        <option value="Mymensingh">Mymensingh</option>
                                        <option value="Rajshahi">Rajshahi</option>
                                        <option value="Sylhet">Sylhet</option>
                                        <option value="Madrasah">Madrasah</option>
                                        <option value="Technical">Technical</option>
                                    </select>
                                </div>
                                <div class="w-24">
                                    <input type="number" id="exam-year" placeholder="Year"
                                        min="1972" max="{{ date('Y') }}" pattern="\d{4}"
                                        title="Enter a 4-digit year between 1972 and {{ date('Y') }}"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                                <div class="w-32">
                                    <select id="exam-month" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option value="">Month</option>
                                        <option value="January">January</option>
                                        <option value="February">February</option>
                                        <option value="March">March</option>
                                        <option value="April">April</option>
                                        <option value="May">May</option>
                                        <option value="June">June</option>
                                        <option value="July">July</option>
                                        <option value="August">August</option>
                                        <option value="September">September</option>
                                        <option value="October">October</option>
                                        <option value="November">November</option>
                                        <option value="December">December</option>
                                    </select>
                                </div>
                                <button type="button" onclick="addHistory()" class="flex items-center justify-center h-9 w-9 rounded-full bg-indigo-600 text-white hover:bg-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Right Side: Empty space to match Explanation section layout -->
                        <div class="w-72">
                            <!-- This space is intentionally left empty to maintain consistent layout with Explanation section -->
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        <button type="button" id="previewBtn"
                                class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Preview
                        </button>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="button" id="resetBtn"
                                class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset
                        </button>
                        
                        <button type="submit" id="submitBtn"
                                class="inline-flex items-center px-8 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Publish Question
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Custom Rich Text Editor -->
<script>
// Custom Rich Text Editor Functions
function initializeRichTextEditor() {
    const editor = document.getElementById('richTextEditor');
    const hiddenTextarea = document.getElementById('question_text');
    const charCount = document.getElementById('charCount');
    
    // Set initial placeholder
    if (!editor.textContent.trim()) {
        editor.textContent = '';
        editor.classList.add('text-gray-400');
    }
    
    // Focus and blur handlers for placeholder
    editor.addEventListener('focus', function() {
        if (!this.textContent.trim()) {
            this.classList.remove('text-gray-400');
        }
    });
    
    editor.addEventListener('blur', function() {
        if (!this.textContent.trim()) {
            this.classList.add('text-gray-400');
        }
    });
    
    // Character counter
    function updateCharCount() {
        const text = editor.textContent || '';
        charCount.textContent = text.length + ' characters';
        
        // Update hidden textarea for form submission
        hiddenTextarea.value = editor.innerHTML;
    }
    
    editor.addEventListener('input', updateCharCount);
    editor.addEventListener('keyup', updateCharCount);
    editor.addEventListener('paste', updateCharCount);
    
    // Initialize character count
    updateCharCount();
    
    // Text formatting functions
    function formatText(command, value = null) {
        document.execCommand(command, false, value);
        editor.focus();
        updateCharCount();
    }
    
    // Bold button
    document.getElementById('boldBtn').addEventListener('click', function() {
        formatText('bold');
        this.classList.toggle('bg-blue-200');
    });
    
    // Italic button
    document.getElementById('italicBtn').addEventListener('click', function() {
        formatText('italic');
        this.classList.toggle('bg-blue-200');
    });
    
    // Underline button
    document.getElementById('underlineBtn').addEventListener('click', function() {
        formatText('underline');
        this.classList.toggle('bg-blue-200');
    });
    
    // Clear formatting button
    document.getElementById('clearFormatBtn').addEventListener('click', function() {
        formatText('removeFormat');
        // Reset button states
        document.getElementById('boldBtn').classList.remove('bg-blue-200');
        document.getElementById('italicBtn').classList.remove('bg-blue-200');
        document.getElementById('underlineBtn').classList.remove('bg-blue-200');
    });
    
    // Equation button
    document.getElementById('equationBtn').addEventListener('click', function() {
        const equation = prompt('Enter your equation (e.g., x² + y² = r²):');
        if (equation) {
            const equationSpan = document.createElement('span');
            equationSpan.innerHTML = equation;
            equationSpan.style.fontFamily = 'serif';
            equationSpan.style.fontSize = '1.1em';
            equationSpan.style.color = '#1f2937';
            
            // Insert at cursor position
            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                range.deleteContents();
                range.insertNode(equationSpan);
            } else {
                editor.appendChild(equationSpan);
            }
            
            updateCharCount();
        }
    });
    
    // Hyperlink button
    document.getElementById('linkBtn').addEventListener('click', function() {
        const url = prompt('Enter URL:');
        if (url) {
            const linkText = prompt('Enter link text (or leave empty to use URL):') || url;
            const link = document.createElement('a');
            link.href = url;
            link.textContent = linkText;
            link.target = '_blank';
            link.style.color = '#2563eb';
            link.style.textDecoration = 'underline';
            
            // Add title for user guidance
            link.title = 'Click to edit, Ctrl+Click to visit';
            
            // Insert at cursor position
            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                range.deleteContents();
                range.insertNode(link);
            } else {
                editor.appendChild(link);
            }
            
            updateCharCount();
        }
    });
    
    // Local image upload button
    document.getElementById('uploadImageBtn').addEventListener('click', function() {
        document.getElementById('imageFileInput').click();
    });
    
    // Handle file input change
    document.getElementById('imageFileInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file');
                return;
            }
            
            // Check file size (5MB limit)
            if (file.size > 5 * 1024 * 1024) {
                alert('Image size must be less than 5MB. Please choose a smaller image.');
                return;
            }
            
            // Show loading indicator
            const loadingMsg = document.createElement('div');
            loadingMsg.textContent = 'Processing image...';
            loadingMsg.style.cssText = 'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.8); color: white; padding: 10px 20px; border-radius: 5px; z-index: 1000;';
            document.body.appendChild(loadingMsg);
            
            // Compress and process image
            compressImage(file, function(compressedDataUrl) {
                insertImage(compressedDataUrl, file.name);
                document.body.removeChild(loadingMsg);
            });
            
            // Reset file input
            document.getElementById('imageFileInput').value = '';
        }
    });
    
    // Image compression function
    function compressImage(file, callback) {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const img = new Image();
        
        img.onload = function() {
            // Calculate new dimensions (max width: 800px, maintain aspect ratio)
            let { width, height } = img;
            const maxWidth = 800;
            
            if (width > maxWidth) {
                height = (height * maxWidth) / width;
                width = maxWidth;
            }
            
            canvas.width = width;
            canvas.height = height;
            
            // Draw and compress image
            ctx.drawImage(img, 0, 0, width, height);
            
            // Convert to data URL with quality 0.8
            const compressedDataUrl = canvas.toDataURL('image/jpeg', 0.8);
            callback(compressedDataUrl);
        };
        
        img.src = URL.createObjectURL(file);
    }
    
         // Helper function to insert local image
     function insertImage(src, alt) {
        const img = document.createElement('img');
        img.src = src;
        img.alt = alt;
        img.style.maxWidth = '100%';
        img.style.height = 'auto';
        img.style.margin = '10px 0';
        img.style.borderRadius = '8px';
        img.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
        
                 // Add click event to select image for resizing
         img.addEventListener('click', function(e) {
             e.preventDefault();
             e.stopPropagation();
             
             // Remove previous selection
             const prevSelected = editor.querySelector('img.selected-for-resize');
             if (prevSelected) {
                 prevSelected.classList.remove('selected-for-resize');
             }
             
             // Add selection to clicked image
             this.classList.add('selected-for-resize');
             selectedImage = this;
             
             // Show resize button hint
             showNotification('Image selected! Click the Resize button to resize it.', 'success');
         });
         
         // Add title for user guidance
         img.title = 'Click to select image for resizing, right-click to remove';
         
         // Add right-click context menu to remove image
         img.addEventListener('contextmenu', function(e) {
             e.preventDefault();
             if (confirm('Remove this image?')) {
                 this.remove();
                 updateCharCount();
                 
                 // Clear selection if this was the selected image
                 if (selectedImage === this) {
                     selectedImage = null;
                     updateResizeButtonState();
                 }
             }
         });
        
        // Insert at cursor position
        const selection = window.getSelection();
        if (selection.rangeCount > 0) {
            const range = selection.getRangeAt(0);
            range.deleteContents();
            range.insertNode(img);
        } else {
            editor.appendChild(img);
        }
        
        updateCharCount();
    }
    
    // Handle paste events to clean HTML
    editor.addEventListener('paste', function(e) {
        e.preventDefault();
        const text = e.clipboardData.getData('text/plain');
        document.execCommand('insertText', false, text);
        updateCharCount();
    });
    
    // Handle link clicks in main editor
    editor.addEventListener('click', function(e) {
        if (e.target.tagName === 'A') {
            e.preventDefault();
            
            // If Ctrl is held, open the link
            if (e.ctrlKey || e.metaKey) {
                window.open(e.target.href, '_blank');
                return;
            }
            
            // Otherwise, allow editing the link
            const newUrl = prompt('Edit URL:', e.target.href);
            if (newUrl !== null) {
                e.target.href = newUrl;
                updateCharCount();
            }
        }
    });
    
    // Handle drag and drop for images
    editor.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = '#3b82f6';
    });
    
    editor.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.borderColor = '#d1d5db';
    });
    
    editor.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = '#d1d5db';
        
        const files = e.dataTransfer.files;
        if (files.length > 0 && files[0].type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                                 const img = document.createElement('img');
                 img.src = e.target.result;
                 img.alt = 'Dropped image';
                 img.style.maxWidth = '100%';
                 img.style.height = 'auto';
                 img.style.margin = '10px 0';
                 img.style.borderRadius = '8px';
                 img.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
                 
                 // Add click event to select image for resizing
                 img.addEventListener('click', function(e) {
                     e.preventDefault();
                     e.stopPropagation();
                     
                     // Remove previous selection
                     const prevSelected = editor.querySelector('img.selected-for-resize');
                     if (prevSelected) {
                         prevSelected.classList.remove('selected-for-resize');
                     }
                     
                     // Add selection to clicked image
                     this.classList.add('selected-for-resize');
                     selectedImage = this;
                     
                     // Show resize button hint
                     showNotification('Image selected! Click the Resize button to resize it.', 'success');
                 });
                 
                 // Add title for user guidance
                 img.title = 'Click to select image for resizing';
                 
                 const selection = window.getSelection();
                 if (selection.rangeCount > 0) {
                     const range = selection.getRangeAt(0);
                     range.deleteContents();
                     range.insertNode(img);
                 } else {
                     editor.appendChild(img);
                 }
                 
                 updateCharCount();
            };
            reader.readAsDataURL(files[0]);
        }
    });
     
     // Image resize functionality
     let selectedImage = null;
     
     // Debug: Check if resize button exists
     const resizeBtn = document.getElementById('resizeBtn');
     if (resizeBtn) {
         console.log('Resize button found and ready!');
         // Add a temporary highlight to make sure it's visible
         resizeBtn.style.backgroundColor = '#fbbf24';
         resizeBtn.style.border = '2px solid #f59e0b';
         setTimeout(() => {
             resizeBtn.style.backgroundColor = '';
             resizeBtn.style.border = '';
         }, 3000);
     } else {
         console.error('Resize button not found!');
     }
     
     // Resize button click handler
     resizeBtn.addEventListener('click', function() {
         console.log('Resize button clicked!');
         
         // Check if we have a selected image
         if (selectedImage) {
             openResizeModal(selectedImage);
         } else {
             alert('Please select an image first. Click on an image to select it.');
         }
     });
     
     // Make images selectable for resizing
     editor.addEventListener('click', function(e) {
         if (e.target.tagName === 'IMG') {
             // Remove previous selection
             const prevSelected = editor.querySelector('img.selected-for-resize');
             if (prevSelected) {
                 prevSelected.classList.remove('selected-for-resize');
             }
             
             // Add selection to clicked image
             e.target.classList.add('selected-for-resize');
             selectedImage = e.target;
             
             // Update resize button state
             updateResizeButtonState();
         }
     });
     
     // Function to update resize button state
     function updateResizeButtonState() {
         const resizeBtn = document.getElementById('resizeBtn');
         if (selectedImage) {
             resizeBtn.classList.add('bg-green-100', 'border-green-300', 'text-green-700');
             resizeBtn.classList.remove('bg-blue-50', 'border-blue-200', 'text-blue-600');
             resizeBtn.title = 'Resize Selected Image (Click to resize)';
         } else {
             resizeBtn.classList.remove('bg-green-100', 'border-green-300', 'text-green-700');
             resizeBtn.classList.add('bg-blue-50', 'border-blue-200', 'text-blue-600');
             resizeBtn.title = 'Resize Selected Image (No image selected)';
         }
     }
     
     // Initialize resize button state
     updateResizeButtonState();
     
     // Function to open resize modal
     function openResizeModal(img) {
         const modal = document.getElementById('resizeModal');
         const widthInput = document.getElementById('resizeWidth');
         const heightInput = document.getElementById('resizeHeight');
         const scaleInput = document.getElementById('resizeScale');
         
         // Set current dimensions
         widthInput.value = Math.round(img.naturalWidth || img.offsetWidth);
         heightInput.value = Math.round(img.naturalHeight || img.offsetHeight);
         scaleInput.value = 100;
         
         // Show modal
         modal.classList.remove('hidden');
         
         // Store original dimensions for calculations
         const originalWidth = parseInt(widthInput.value);
         const originalHeight = parseInt(heightInput.value);
         
         // Handle proportional resizing
         const maintainAspectRatio = document.getElementById('maintainAspectRatio');
         const resizeProportionally = document.getElementById('resizeProportionally');
         const proportionalControls = document.getElementById('proportionalControls');
         
         // Show/hide proportional controls
         resizeProportionally.addEventListener('change', function() {
             proportionalControls.classList.toggle('hidden', !this.checked);
             if (this.checked) {
                 maintainAspectRatio.checked = true;
                 maintainAspectRatio.disabled = true;
             } else {
                 maintainAspectRatio.disabled = false;
             }
         });
         
         // Handle width/height changes with aspect ratio
         function updateDimensions() {
             if (maintainAspectRatio.checked && !resizeProportionally.checked) {
                 if (this === widthInput) {
                     const ratio = originalHeight / originalWidth;
                     heightInput.value = Math.round(parseInt(this.value) * ratio);
                 } else {
                     const ratio = originalWidth / originalHeight;
                     widthInput.value = Math.round(parseInt(this.value) * ratio);
                 }
             }
         }
         
         widthInput.addEventListener('input', updateDimensions);
         heightInput.addEventListener('input', updateDimensions);
         
         // Handle proportional scaling
         scaleInput.addEventListener('input', function() {
             const scale = parseInt(this.value) / 100;
             widthInput.value = Math.round(originalWidth * scale);
             heightInput.value = Math.round(originalHeight * scale);
         });
         
         // Apply resize
         document.getElementById('applyResize').addEventListener('click', function() {
             const newWidth = parseInt(widthInput.value);
             const newHeight = parseInt(heightInput.value);
             const optimizeQuality = document.getElementById('resizeQuality').checked;
             
             if (newWidth < 50 || newWidth > 1200) {
                 alert('Width must be between 50px and 1200px');
                 return;
             }
             
             if (newHeight < 50 || newHeight > 1200) {
                 alert('Height must be between 50px and 1200px');
                 return;
             }
             
             // Resize the image
             resizeImage(selectedImage, newWidth, newHeight, optimizeQuality);
             
             // Close modal
             modal.classList.add('hidden');
             
             // Clean up event listeners
             widthInput.removeEventListener('input', updateDimensions);
             heightInput.removeEventListener('input', updateDimensions);
         });
         
         // Cancel resize
         document.getElementById('cancelResize').addEventListener('click', function() {
             modal.classList.add('hidden');
         });
         
         // Close modal button
         document.getElementById('closeResizeModal').addEventListener('click', function() {
             modal.classList.add('hidden');
         });
         
         // Close modal when clicking outside
         modal.addEventListener('click', function(e) {
             if (e.target === modal) {
                 modal.classList.add('hidden');
             }
         });
     }
     
     // Function to resize image
     function resizeImage(img, newWidth, newHeight, optimizeQuality) {
         const canvas = document.createElement('canvas');
         const ctx = canvas.getContext('2d');
         
         canvas.width = newWidth;
         canvas.height = newHeight;
         
         // Set image smoothing quality
         if (optimizeQuality) {
             ctx.imageSmoothingEnabled = true;
             ctx.imageSmoothingQuality = 'high';
         } else {
             ctx.imageSmoothingQuality = 'low';
         }
         
         // Draw resized image
         ctx.drawImage(img, 0, 0, newWidth, newHeight);
         
         // Convert to data URL
         const resizedDataUrl = canvas.toDataURL('image/jpeg', optimizeQuality ? 0.9 : 0.7);
         
         // Update image
         img.src = resizedDataUrl;
         img.style.width = newWidth + 'px';
         img.style.height = newHeight + 'px';
         
         // Remove selection class
         img.classList.remove('selected-for-resize');
         
         // Update character count
         updateCharCount();
         
         // Show success message
         showNotification('Image resized successfully!', 'success');
     }
     
     // Initialize Explanation Rich Text Editor
     initializeExplanationRichTextEditor();
     
     // Initialize Tags Auto-completion
     initializeTagsAutoCompletion();
 }
 
 // Explanation Rich Text Editor Functions
 function initializeExplanationRichTextEditor() {
     const editor = document.getElementById('explanationRichTextEditor');
     const hiddenTextarea = document.getElementById('explanation');
     const charCount = document.getElementById('explanationCharCount');
     
     // Set initial placeholder
     if (!editor.textContent.trim()) {
         editor.textContent = '';
         editor.classList.add('text-gray-400');
     }
     
     // Focus and blur handlers for placeholder
     editor.addEventListener('focus', function() {
         if (!this.textContent.trim()) {
             this.classList.remove('text-gray-400');
         }
     });
     
     editor.addEventListener('blur', function() {
         if (!this.textContent.trim()) {
             this.classList.add('text-gray-400');
         }
     });
     
     // Character counter
     function updateCharCount() {
         const text = editor.textContent || '';
         charCount.textContent = text.length + ' characters';
         
         // Update hidden textarea for form submission
         hiddenTextarea.value = editor.innerHTML;
     }
     
     editor.addEventListener('input', updateCharCount);
     editor.addEventListener('keyup', updateCharCount);
     editor.addEventListener('paste', updateCharCount);
     
     // Initialize character count
     updateCharCount();
     
     // Text formatting functions
     function formatText(command, value = null) {
         document.execCommand(command, false, value);
         editor.focus();
         updateCharCount();
     }
     
     // Bold button
     document.getElementById('explanationBoldBtn').addEventListener('click', function() {
         formatText('bold');
         this.classList.toggle('bg-blue-200');
     });
     
     // Italic button
     document.getElementById('explanationItalicBtn').addEventListener('click', function() {
         formatText('italic');
         this.classList.toggle('bg-blue-200');
     });
     
     // Underline button
     document.getElementById('explanationUnderlineBtn').addEventListener('click', function() {
         formatText('underline');
         this.classList.toggle('bg-blue-200');
     });
     
     // Clear formatting button
     document.getElementById('explanationClearFormatBtn').addEventListener('click', function() {
         formatText('removeFormat');
         // Reset button states
         document.getElementById('explanationBoldBtn').classList.remove('bg-blue-200');
         document.getElementById('explanationItalicBtn').classList.remove('bg-blue-200');
         document.getElementById('explanationUnderlineBtn').classList.remove('bg-blue-200');
     });
     
     // Equation button
     document.getElementById('explanationEquationBtn').addEventListener('click', function() {
         const equation = prompt('Enter your equation (e.g., x² + y² = r²):');
         if (equation) {
             const equationSpan = document.createElement('span');
             equationSpan.innerHTML = equation;
             equationSpan.style.fontFamily = 'serif';
             equationSpan.style.fontSize = '1.1em';
             equationSpan.style.color = '#1f2937';
             
             // Insert at cursor position
             const selection = window.getSelection();
             if (selection.rangeCount > 0) {
                 const range = selection.getRangeAt(0);
                 range.deleteContents();
                 range.insertNode(equationSpan);
             } else {
                 editor.appendChild(equationSpan);
             }
             
             updateCharCount();
         }
     });
     
     // Local image upload button
     document.getElementById('explanationUploadImageBtn').addEventListener('click', function() {
         document.getElementById('explanationImageFileInput').click();
     });
     
     // Handle file input change
     document.getElementById('explanationImageFileInput').addEventListener('change', function(e) {
         const file = e.target.files[0];
         if (file) {
             // Validate file type
             if (!file.type.startsWith('image/')) {
                 alert('Please select a valid image file');
                 return;
             }
             
             // Check file size (5MB limit)
             if (file.size > 5 * 1024 * 1024) {
                 alert('Image size must be less than 5MB. Please choose a smaller image.');
                 return;
             }
             
             // Show loading indicator
             const loadingMsg = document.createElement('div');
             loadingMsg.textContent = 'Processing image...';
             loadingMsg.style.cssText = 'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.8); color: white; padding: 10px 20px; border-radius: 5px; z-index: 1000;';
             document.body.appendChild(loadingMsg);
             
             // Compress and process image
             compressImage(file, function(compressedDataUrl) {
                 insertExplanationImage(compressedDataUrl, file.name);
                 document.body.removeChild(loadingMsg);
             });
             
             // Reset file input
             document.getElementById('explanationImageFileInput').value = '';
         }
     });
     
     // Helper function to insert image in explanation
     function insertExplanationImage(src, alt) {
         const img = document.createElement('img');
         img.src = src;
         img.alt = alt;
         img.style.maxWidth = '100%';
         img.style.height = 'auto';
         img.style.margin = '10px 0';
         img.style.borderRadius = '8px';
         img.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
         
         // Add click event to select image for resizing
         img.addEventListener('click', function(e) {
             e.preventDefault();
             e.stopPropagation();
             
             // Remove previous selection
             const prevSelected = editor.querySelector('img.selected-for-resize');
             if (prevSelected) {
                 prevSelected.classList.remove('selected-for-resize');
             }
             
             // Add selection to clicked image
             this.classList.add('selected-for-resize');
             explanationSelectedImage = this;
             
             // Show resize button hint
             showNotification('Image selected! Click the Resize button to resize it.', 'success');
         });
         
         // Add title for user guidance
         img.title = 'Click to select image for resizing, right-click to remove';
         
         // Add right-click context menu to remove image
         img.addEventListener('contextmenu', function(e) {
             e.preventDefault();
             if (confirm('Remove this image?')) {
                 this.remove();
                 updateCharCount();
                 
                 // Clear selection if this was the selected image
                 if (explanationSelectedImage === this) {
                     explanationSelectedImage = null;
                     updateExplanationResizeButtonState();
                 }
             }
         });
         
         // Insert at cursor position
         const selection = window.getSelection();
         if (selection.rangeCount > 0) {
             const range = selection.getRangeAt(0);
             range.deleteContents();
             range.insertNode(img);
         } else {
             editor.appendChild(img);
         }
         
         updateCharCount();
     }
     
     // Hyperlink button
     document.getElementById('explanationLinkBtn').addEventListener('click', function() {
         const url = prompt('Enter URL:');
         if (url) {
             const linkText = prompt('Enter link text (or leave empty to use URL):') || url;
             const link = document.createElement('a');
             link.href = url;
             link.textContent = linkText;
             link.target = '_blank';
             link.style.color = '#2563eb';
             link.style.textDecoration = 'underline';
             
             // Add title for user guidance
             link.title = 'Click to edit, Ctrl+Click to visit';
             
             // Insert at cursor position
             const selection = window.getSelection();
             if (selection.rangeCount > 0) {
                 const range = selection.getRangeAt(0);
                 range.deleteContents();
                 range.insertNode(link);
             } else {
                 editor.appendChild(link);
             }
             
             updateCharCount();
         }
     });
     
     // Handle link clicks in explanation editor
     editor.addEventListener('click', function(e) {
         if (e.target.tagName === 'A') {
             e.preventDefault();
             
             // If Ctrl is held, open the link
             if (e.ctrlKey || e.metaKey) {
                 window.open(e.target.href, '_blank');
                 return;
             }
             
             // Otherwise, allow editing the link
             const newUrl = prompt('Edit URL:', e.target.href);
             if (newUrl !== null) {
                 e.target.href = newUrl;
                 updateCharCount();
             }
         }
     });
     
     // Handle paste events to clean HTML
     editor.addEventListener('paste', function(e) {
         e.preventDefault();
         const text = e.clipboardData.getData('text/plain');
         document.execCommand('insertText', false, text);
         updateCharCount();
     });
     
     // Handle drag and drop for images
     editor.addEventListener('dragover', function(e) {
         e.preventDefault();
         this.style.borderColor = '#3b82f6';
     });
     
     editor.addEventListener('dragleave', function(e) {
         e.preventDefault();
         this.style.borderColor = '#d1d5db';
     });
     
     editor.addEventListener('drop', function(e) {
         e.preventDefault();
         this.style.borderColor = '#d1d5db';
         
         const files = e.dataTransfer.files;
         if (files.length > 0 && files[0].type.startsWith('image/')) {
             const reader = new FileReader();
             reader.onload = function(e) {
                 const img = document.createElement('img');
                 img.src = e.target.result;
                 img.alt = 'Dropped image';
                 img.style.maxWidth = '100%';
                 img.style.height = 'auto';
                 img.style.margin = '10px 0';
                 img.style.borderRadius = '8px';
                 img.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
                 
                 // Add click event to select image for resizing
                 img.addEventListener('click', function(e) {
                     e.preventDefault();
                     e.stopPropagation();
                     
                     // Remove previous selection
                     const prevSelected = editor.querySelector('img.selected-for-resize');
                     if (prevSelected) {
                         prevSelected.classList.remove('selected-for-resize');
                     }
                     
                     // Add selection to clicked image
                     this.classList.add('selected-for-resize');
                     explanationSelectedImage = this;
                     
                     // Show resize button hint
                     showNotification('Image selected! Click the Resize button to resize it.', 'success');
                 });
                 
                 // Add title for user guidance
                 img.title = 'Click to select image for resizing';
                 
                 const selection = window.getSelection();
                 if (selection.rangeCount > 0) {
                     const range = selection.getRangeAt(0);
                     range.deleteContents();
                     range.insertNode(img);
                 } else {
                     editor.appendChild(img);
                 }
                 
                 updateCharCount();
             };
             reader.readAsDataURL(files[0]);
         }
     });
     
     // Image resize functionality for explanation
     let explanationSelectedImage = null;
     
     // Debug: Check if resize button exists
     const resizeBtn = document.getElementById('explanationResizeBtn');
     if (resizeBtn) {
         console.log('Explanation resize button found and ready!');
         // Add a temporary highlight to make sure it's visible
         resizeBtn.style.backgroundColor = '#fbbf24';
         resizeBtn.style.border = '2px solid #f59e0b';
         setTimeout(() => {
             resizeBtn.style.backgroundColor = '';
             resizeBtn.style.border = '';
         }, 3000);
     } else {
         console.error('Explanation resize button not found!');
     }
     
     // Resize button click handler
     resizeBtn.addEventListener('click', function() {
         console.log('Explanation resize button clicked!');
         
         // Check if we have a selected image
         if (explanationSelectedImage) {
             openExplanationResizeModal(explanationSelectedImage);
         } else {
             alert('Please select an image first. Click on an image to select it.');
         }
     });
     
     // Make images selectable for resizing
     editor.addEventListener('click', function(e) {
         if (e.target.tagName === 'IMG') {
             // Remove previous selection
             const prevSelected = editor.querySelector('img.selected-for-resize');
             if (prevSelected) {
                 prevSelected.classList.remove('selected-for-resize');
             }
             
             // Add selection to clicked image
             e.target.classList.add('selected-for-resize');
             explanationSelectedImage = e.target;
             
             // Update resize button state
             updateExplanationResizeButtonState();
         }
     });
     
     // Function to update resize button state
     function updateExplanationResizeButtonState() {
         const resizeBtn = document.getElementById('explanationResizeBtn');
         if (explanationSelectedImage) {
             resizeBtn.classList.add('bg-green-100', 'border-green-300', 'text-green-700');
             resizeBtn.classList.remove('bg-blue-50', 'border-blue-200', 'text-blue-600');
             resizeBtn.title = 'Resize Selected Image (Click to resize)';
         } else {
             resizeBtn.classList.remove('bg-green-100', 'border-green-300', 'text-green-700');
             resizeBtn.classList.add('bg-blue-50', 'border-blue-200', 'text-blue-600');
             resizeBtn.title = 'Resize Selected Image (No image selected)';
         }
     }
     
     // Initialize resize button state
     updateExplanationResizeButtonState();
     
     // Function to open resize modal for explanation
     function openExplanationResizeModal(img) {
         const modal = document.getElementById('explanationResizeModal');
         const widthInput = document.getElementById('explanationResizeWidth');
         const heightInput = document.getElementById('explanationResizeHeight');
         const scaleInput = document.getElementById('explanationResizeScale');
         
         // Set current dimensions
         widthInput.value = Math.round(img.naturalWidth || img.offsetWidth);
         heightInput.value = Math.round(img.naturalHeight || img.offsetHeight);
         scaleInput.value = 100;
         
         // Show modal
         modal.classList.remove('hidden');
         
         // Store original dimensions for calculations
         const originalWidth = parseInt(widthInput.value);
         const originalHeight = parseInt(heightInput.value);
         
         // Handle proportional resizing
         const maintainAspectRatio = document.getElementById('explanationMaintainAspectRatio');
         const resizeProportionally = document.getElementById('explanationResizeProportionally');
         const proportionalControls = document.getElementById('explanationProportionalControls');
         
         // Show/hide proportional controls
         resizeProportionally.addEventListener('change', function() {
             proportionalControls.classList.toggle('hidden', !this.checked);
             if (this.checked) {
                 maintainAspectRatio.checked = true;
                 maintainAspectRatio.disabled = true;
             } else {
                 maintainAspectRatio.disabled = false;
             }
         });
         
         // Handle width/height changes with aspect ratio
         function updateDimensions() {
             if (maintainAspectRatio.checked && !resizeProportionally.checked) {
                 if (this === widthInput) {
                     const ratio = originalHeight / originalWidth;
                     heightInput.value = Math.round(parseInt(this.value) * ratio);
                 } else {
                     const ratio = originalWidth / originalHeight;
                     widthInput.value = Math.round(parseInt(this.value) * ratio);
                 }
             }
         }
         
         widthInput.addEventListener('input', updateDimensions);
         heightInput.addEventListener('input', updateDimensions);
         
         // Handle proportional scaling
         scaleInput.addEventListener('input', function() {
             const scale = parseInt(this.value) / 100;
             widthInput.value = Math.round(originalWidth * scale);
             heightInput.value = Math.round(originalHeight * scale);
         });
         
         // Apply resize
         document.getElementById('explanationApplyResize').addEventListener('click', function() {
             const newWidth = parseInt(widthInput.value);
             const newHeight = parseInt(heightInput.value);
             const optimizeQuality = document.getElementById('explanationResizeQuality').checked;
             
             if (newWidth < 50 || newWidth > 1200) {
                 alert('Width must be between 50px and 1200px');
                 return;
             }
             
             if (newHeight < 50 || newHeight > 1200) {
                 alert('Height must be between 50px and 1200px');
                 return;
             }
             
             // Resize the image
             resizeExplanationImage(explanationSelectedImage, newWidth, newHeight, optimizeQuality);
             
             // Close modal
             modal.classList.add('hidden');
             
             // Clean up event listeners
             widthInput.removeEventListener('input', updateDimensions);
             heightInput.removeEventListener('input', updateDimensions);
         });
         
         // Cancel resize
         document.getElementById('explanationCancelResize').addEventListener('click', function() {
             modal.classList.add('hidden');
         });
         
         // Close modal button
         document.getElementById('explanationCloseResizeModal').addEventListener('click', function() {
             modal.classList.add('hidden');
         });
         
         // Close modal when clicking outside
         modal.addEventListener('click', function(e) {
             if (e.target === modal) {
                 modal.classList.add('hidden');
             }
         });
     }
     
     // Function to resize explanation image
     function resizeExplanationImage(img, newWidth, newHeight, optimizeQuality) {
         const canvas = document.createElement('canvas');
         const ctx = canvas.getContext('2d');
         
         canvas.width = newWidth;
         canvas.height = newHeight;
         
         // Set image smoothing quality
         if (optimizeQuality) {
             ctx.imageSmoothingEnabled = true;
             ctx.imageSmoothingQuality = 'high';
         } else {
             ctx.imageSmoothingQuality = 'low';
         }
         
         // Draw resized image
         ctx.drawImage(img, 0, 0, newWidth, newHeight);
         
         // Convert to data URL
         const resizedDataUrl = canvas.toDataURL('image/jpeg', optimizeQuality ? 0.9 : 0.7);
         
         // Update image
         img.src = resizedDataUrl;
         img.style.width = newWidth + 'px';
         img.style.height = newHeight + 'px';
         
         // Remove selection class
         img.classList.remove('selected-for-resize');
         
         // Update character count
         updateCharCount();
         
         // Show success message
         showNotification('Image resized successfully!', 'success');
     }
 }

function loadTinyMCECDN2() {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js';
    script.referrerPolicy = 'origin';
    script.onload = function() {
        console.log('TinyMCE loaded successfully from jsDelivr');
        initializeTinyMCE();
    };
    script.onerror = function() {
        console.log('All CDNs failed, using fallback textarea');
        fallbackToTextarea();
    };
    document.head.appendChild(script);
}

function fallbackToTextarea() {
    const textarea = document.getElementById('question_text');
    if (textarea) {
        textarea.style.height = '300px';
        textarea.style.resize = 'vertical';
        textarea.style.fontFamily = '-apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif';
        textarea.style.fontSize = '14px';
        textarea.style.lineHeight = '1.6';
        textarea.style.padding = '1rem';
        textarea.style.borderRadius = '0.5rem';
        textarea.style.border = '1px solid #d1d5db';
        textarea.style.backgroundColor = '#ffffff';
        
        // Add character counter functionality
        textarea.addEventListener('input', function() {
            const charCount = document.getElementById('charCount');
            if (charCount) {
                charCount.textContent = this.value.length + ' characters';
            }
        });
    }
}

function initializeTinyMCE() {
    if (typeof tinymce !== 'undefined') {
        console.log('TinyMCE is available, initializing...');
        tinymce.init({
            selector: '#question_text',
            height: 300,
            menubar: false,
            statusbar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic underline strikethrough | ' +
                'forecolor backcolor | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | removeformat | table image link | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; line-height: 1.6; }',
            placeholder: 'Enter your question here... You can use formatting, images, and tables.',
            branding: false,
            elementpath: false,
            resize: false,
            relative_urls: false,
            remove_script_host: false,
            convert_urls: false,
            setup: function(editor) {
                console.log('TinyMCE editor setup function called');
                
                // Update character count
                editor.on('keyup', function() {
                    const content = editor.getContent({format: 'text'});
                    const charCount = document.getElementById('charCount');
                    if (charCount) {
                        charCount.textContent = content.length + ' characters';
                    }
                });
                
                // Update character count on paste
                editor.on('paste', function() {
                    setTimeout(function() {
                        const content = editor.getContent({format: 'text'});
                        const charCount = document.getElementById('charCount');
                        if (charCount) {
                            charCount.textContent = content.length + ' characters';
                        }
                    }, 100);
                });
            },
            init_instance_callback: function(editor) {
                console.log('TinyMCE instance callback triggered');
                console.log('Editor container:', editor.getContainer());
                
                // Ensure the editor is visible and toolbar is shown
                setTimeout(function() {
                    if (editor.getContainer()) {
                        editor.getContainer().style.display = 'block';
                        const toolbar = editor.getContainer().querySelector('.tox-toolbar');
                        if (toolbar) {
                            toolbar.style.display = 'flex';
                            console.log('Toolbar found and displayed');
                        } else {
                            console.log('Toolbar not found');
                        }
                    }
                }, 200);
            }
        });
    } else {
        console.error('TinyMCE not loaded. Falling back to regular textarea.');
        fallbackToTextarea();
    }
}

// Tags Management Function
function initializeTagsAutoCompletion() {
    const tagList = document.getElementById('tag-list');
    const newTagInput = document.getElementById('new-tag');
    const tagsInput = document.getElementById('tagsInput');
    
    if (!tagList || !newTagInput || !tagsInput) {
        console.error('Tags elements not found');
        return;
    }
    
    // Sample tags for auto-completion (you can replace these with actual tags from your database)
    const commonTags = [
        'algebra', 'geometry', 'calculus', 'trigonometry', 'statistics', 'probability',
        'equations', 'inequalities', 'functions', 'graphs', 'derivatives', 'integrals',
        'matrices', 'vectors', 'complex numbers', 'sequences', 'series', 'limits',
        'continuity', 'differentiation', 'integration', 'applications', 'word problems',
        'proofs', 'theorems', 'definitions', 'examples', 'exercises', 'practice',
        'basic', 'intermediate', 'advanced', 'fundamental', 'conceptual', 'procedural'
    ];
    
    // Create suggestions container
    const suggestionsContainer = document.createElement('div');
    suggestionsContainer.id = 'tagsSuggestions';
    suggestionsContainer.className = 'absolute z-10 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-48 overflow-y-auto hidden';
    suggestionsContainer.style.top = '100%';
    suggestionsContainer.style.left = '0';
    
    // Insert suggestions container after the new tag input
    newTagInput.parentNode.style.position = 'relative';
    newTagInput.parentNode.appendChild(suggestionsContainer);
    
    // Function to add a new tag
    function addTag(tagText) {
        if (tagText.trim() === '') return;
        
        // Check if tag already exists
        const existingTags = Array.from(tagList.children).map(tag => tag.textContent.trim());
        if (existingTags.includes(tagText.trim())) return;
        
        // Create tag element
        const tag = document.createElement('div');
        tag.className = 'inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full border border-blue-200';
        tag.innerHTML = `
            <span>${tagText.trim()}</span>
            <button type="button" class="text-blue-600 hover:text-blue-800 focus:outline-none" onclick="removeTag(this)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        
        tagList.appendChild(tag);
        updateTagsInput();
        newTagInput.value = '';
    }
    
    // Function to remove a tag
    window.removeTag = function(button) {
        button.parentElement.remove();
        updateTagsInput();
    };
    
    // Function to update hidden input for form submission
    function updateTagsInput() {
        const tags = Array.from(tagList.children).map(tag => tag.querySelector('span').textContent.trim());
        tagsInput.value = JSON.stringify(tags);
    }
    
    // Function to show suggestions
    function showSuggestions(filteredTags) {
        if (filteredTags.length === 0) {
            suggestionsContainer.classList.add('hidden');
            return;
        }
        
        suggestionsContainer.innerHTML = '';
        filteredTags.forEach(tag => {
            const suggestionItem = document.createElement('div');
            suggestionItem.className = 'px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm text-gray-700 border-b border-gray-100 last:border-b-0';
            suggestionItem.textContent = tag;
            
            suggestionItem.addEventListener('click', function() {
                addTag(tag);
                suggestionsContainer.classList.add('hidden');
            });
            
            suggestionsContainer.appendChild(suggestionItem);
        });
        
        suggestionsContainer.classList.remove('hidden');
    }
    
    // Handle input events for auto-completion
    newTagInput.addEventListener('input', function(e) {
        const value = this.value;
        
        // Check if comma was pressed
        if (e.data === ',') {
            const tagText = value.slice(0, -1).trim(); // Remove the comma
            if (tagText) {
                addTag(tagText);
            }
            return;
        }
        
        // Show suggestions based on current input
        if (value.length > 1) {
            const filteredTags = commonTags.filter(tag => 
                tag.toLowerCase().startsWith(value.toLowerCase()) && 
                tag.toLowerCase() !== value.toLowerCase()
            );
            showSuggestions(filteredTags);
        } else {
            suggestionsContainer.classList.add('hidden');
        }
    });
    
    // Handle keydown events
    newTagInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addTag(this.value);
            suggestionsContainer.classList.add('hidden');
        } else if (e.key === 'Escape') {
            suggestionsContainer.classList.add('hidden');
        }
    });
    
    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!newTagInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
            suggestionsContainer.classList.add('hidden');
        }
    });
    
    // Handle focus to show suggestions if there's text
    newTagInput.addEventListener('focus', function() {
        const value = this.value;
        if (value.length > 1) {
            const filteredTags = commonTags.filter(tag => 
                tag.toLowerCase().startsWith(value.toLowerCase()) && 
                tag.toLowerCase() !== value.toLowerCase()
            );
            showSuggestions(filteredTags);
        }
    });
    
    // Initialize tags from old input if available
    const oldTags = @json(old('tags', []));
    if (oldTags && oldTags.length > 0) {
        oldTags.forEach(tag => addTag(tag));
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Custom Rich Text Editor
    initializeRichTextEditor();

    // Course and Subject cascading dropdowns
    const courseSelect = document.getElementById('course_id');
    const subjectSelect = document.getElementById('subject_id');
    const topicSelect = document.getElementById('topic_id');
    
    // Store all subjects and topics for filtering
    const allSubjects = @json($subjects ?? []);
    const allTopics = @json($topics ?? []);
    
    // Course change handler
    courseSelect.addEventListener('change', function() {
        const courseId = this.value;
        
        // Reset subject and topic selections
        subjectSelect.innerHTML = '<option value="">Select a subject</option>';
        topicSelect.innerHTML = '<option value="">Select a topic</option>';
        
        if (courseId) {
            // Filter subjects by course
            const filteredSubjects = allSubjects.filter(subject => subject.course_id == courseId);
            filteredSubjects.forEach(subject => {
                const option = document.createElement('option');
                option.value = subject.id;
                option.textContent = subject.name;
                subjectSelect.appendChild(option);
            });
        }
    });
    
    // Subject change handler
    subjectSelect.addEventListener('change', function() {
        const subjectId = this.value;
        
        // Reset topic selection
        topicSelect.innerHTML = '<option value="">Select a topic</option>';
        
        if (subjectId) {
            // Filter topics by subject
            const filteredTopics = allTopics.filter(topic => topic.subject_id == subjectId);
            filteredTopics.forEach(topic => {
                const option = document.createElement('option');
                option.value = topic.id;
                option.textContent = topic.name;
                topicSelect.appendChild(option);
            });
        }
    });

    // Character counter is now handled by TinyMCE setup function

         // Option selection highlighting
     const optionItems = document.querySelectorAll('.option-item');
     const radioButtons = document.querySelectorAll('input[name="correct_answer"]');
     
     radioButtons.forEach(radio => {
         radio.addEventListener('change', function() {
             // Remove all previous selections
             optionItems.forEach(item => {
                 item.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-50');
                 const bullet = item.querySelector('.option-bullet');
                 if (bullet) {
                     bullet.classList.remove('bg-green-500', 'text-white', 'font-bold');
                     bullet.classList.add('bg-gray-200', 'text-gray-600');
                 }
             });
             
             // Add selection to current option
             if (this.checked) {
                 const currentItem = this.closest('.option-item');
                 currentItem.classList.add('ring-2', 'ring-blue-500', 'bg-blue-50');
                 
                 // Highlight the bullet for correct answer
                 const bullet = currentItem.querySelector('.option-bullet');
                 if (bullet) {
                     bullet.classList.remove('bg-gray-200', 'text-gray-600');
                     bullet.classList.add('bg-green-500', 'text-white', 'font-bold');
                 }
             }
         });
     });

    // Preview functionality
    const previewBtn = document.getElementById('previewBtn');
    const previewModal = document.getElementById('previewModal');
    const closePreview = document.getElementById('closePreview');
    const closePreviewBtn = document.getElementById('closePreviewBtn');
    const previewContent = document.getElementById('previewContent');

    previewBtn.addEventListener('click', function() {
        const formData = new FormData(document.getElementById('mcqForm'));
        let previewHTML = '';
        
        // Get content from rich text editor
        const questionContent = document.getElementById('richTextEditor').innerHTML;
        
        // Build preview content
        previewHTML += `
            <div class="bg-gray-50 rounded-lg p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Question</h4>
                <div class="text-gray-700 mb-4">${questionContent || 'No question text provided'}</div>
                
                <div class="space-y-3">
                    <h5 class="font-medium text-gray-900">Options:</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="flex items-center space-x-2">
                            <span class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-semibold">A</span>
                            <span class="text-gray-700">${formData.get('option_a') || 'Option A'}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs font-semibold">B</span>
                            <span class="text-gray-700">${formData.get('option_b') || 'Option B'}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-6 h-6 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-xs font-semibold">C</span>
                            <span class="text-gray-700">${formData.get('option_c') || 'Option C'}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-6 h-6 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-xs font-semibold">D</span>
                            <span class="text-gray-700">${formData.get('option_d') || 'Option D'}</span>
                        </div>
                    </div>
                    
                                         <div class="mt-4 pt-4 border-t border-gray-200">
                         <p class="text-sm text-gray-600">
                             <strong>Correct Answer:</strong> 
                             <span class="text-green-600 font-medium">${formData.get('correct_answer') || 'Not selected'}</span>
                         </p>
                     </div>
                </div>
            </div>
        `;
        
        if (formData.get('explanation')) {
            previewHTML += `
                <div class="bg-blue-50 rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Explanation</h4>
                    <p class="text-gray-700">${formData.get('explanation')}</p>
                </div>
            `;
        }
        
        // Add tags to preview
        const tags = JSON.parse(formData.get('tags') || '[]');
        if (tags.length > 0) {
            previewHTML += `
                <div class="bg-purple-50 rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Tags</h4>
                    <div class="flex flex-wrap gap-2">
                        ${tags.map(tag => `<span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm font-medium rounded-full border border-purple-200">${tag}</span>`).join('')}
                    </div>
                </div>
            `;
        }
        
        // Add history to preview
        const historyInput = document.getElementById('historyInput');
        if (historyInput && historyInput.value) {
            const history = JSON.parse(historyInput.value || '[]');
            if (history.length > 0) {
                previewHTML += `
                    <div class="bg-amber-50 rounded-lg p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Question Appearance History</h4>
                        <div>
                            ${history.map(item => `
                                <div class="flex items-center space-x-3 p-3 bg-amber-100 rounded-lg border border-amber-200">
                                    <div class="flex items-center justify-center w-5 h-5 rounded-full bg-amber-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 text-amber-700">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-amber-800">${item}</span>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            }
        }
        
        previewContent.innerHTML = previewHTML;
        previewModal.classList.remove('hidden');
    });

    [closePreview, closePreviewBtn].forEach(btn => {
        btn.addEventListener('click', function() {
            previewModal.classList.add('hidden');
        });
    });

    // Close modal when clicking outside
    previewModal.addEventListener('click', function(e) {
        if (e.target === previewModal) {
            previewModal.classList.add('hidden');
        }
    });

    // Reset functionality
    const resetBtn = document.getElementById('resetBtn');
    resetBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
            resetForm();
        }
    });



    // Form submission
    const form = document.getElementById('mcqForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Update the hidden textarea with rich text editor content before submission
        const questionContent = document.getElementById('richTextEditor').innerHTML;
        document.getElementById('question_text').value = questionContent;
        
        // Update the hidden textarea with explanation rich text editor content before submission
        const explanationContent = document.getElementById('explanationRichTextEditor').innerHTML;
        document.getElementById('explanation').value = explanationContent;
        
        // Validate form
        if (!validateForm()) {
            return;
        }
        
        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Publishing...
        `;
        submitBtn.disabled = true;
        
        // Submit form via AJAX
        const formData = new FormData(form);
        
        // Debug: Log form data
        console.log('Form action:', form.action);
        console.log('Form data entries:');
        for (let [key, value] of formData.entries()) {
            console.log(key, ':', value);
        }
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showNotification(data.message, 'success');
                
                // Show success alert
                if (confirm(data.message + '\n\nClick OK to create a new question.')) {
                    // Reset form
                    resetForm();
                }
            } else {
                showNotification(data.message || 'Error creating question', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error creating question. Please try again.', 'error');
        })
        .finally(() => {
            // Reset button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
    
    // Form validation function
    function validateForm() {
        const requiredFields = [
            'course_id', 'subject_id', 'question_text', 
            'option_a', 'option_b', 'option_c', 'option_d', 
            'correct_answer'
        ];
        
        for (const fieldName of requiredFields) {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (!field || !field.value.trim()) {
                showNotification(`Please fill in all required fields. Missing: ${fieldName.replace('_', ' ')}`, 'error');
                field?.focus();
                return false;
            }
        }
        
        // Check if question text has content
        const questionText = document.getElementById('richTextEditor').innerHTML.trim();
        if (!questionText || questionText === '<br>') {
            showNotification('Please enter question text', 'error');
            document.getElementById('richTextEditor').focus();
            return false;
        }
        
        return true;
    }
    
    // Reset form function
    function resetForm() {
        // Reset form fields
        form.reset();
        
        // Reset rich text editors
        document.getElementById('richTextEditor').innerHTML = '';
        document.getElementById('richTextEditor').classList.add('text-gray-400');
        document.getElementById('explanationRichTextEditor').innerHTML = '';
        document.getElementById('explanationRichTextEditor').classList.add('text-gray-400');
        
        // Reset button states
        document.getElementById('boldBtn').classList.remove('bg-blue-200');
        document.getElementById('italicBtn').classList.remove('bg-blue-200');
        document.getElementById('underlineBtn').classList.remove('bg-blue-200');
        document.getElementById('explanationBoldBtn').classList.remove('bg-blue-200');
        document.getElementById('explanationItalicBtn').classList.remove('bg-blue-200');
        document.getElementById('explanationUnderlineBtn').classList.remove('bg-blue-200');
        
        // Reset character counts
        document.getElementById('charCount').textContent = '0 characters';
        document.getElementById('explanationCharCount').textContent = '0 characters';
        
        // Reset tags
        document.getElementById('tag-list').innerHTML = '';
        document.getElementById('tagsInput').value = '';
        
        // Reset history
        document.getElementById('history-list').innerHTML = '';
        const historyInput = document.getElementById('historyInput');
        if (historyInput) {
            historyInput.value = '';
        }
        
        // Reset option selections and bullet colors
        const optionItems = document.querySelectorAll('.option-item');
        optionItems.forEach(item => {
            item.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-50');
            const bullet = item.querySelector('.option-bullet');
            if (bullet) {
                bullet.classList.remove('bg-green-500', 'text-white', 'font-bold');
                bullet.classList.add('bg-gray-200', 'text-gray-600');
            }
        });
        
        // Reset course/subject/topic dropdowns
        document.getElementById('subject_id').innerHTML = '<option value="">Select a subject</option>';
        document.getElementById('topic_id').innerHTML = '<option value="">Select a topic</option>';
        

        
        showNotification('Form reset successfully!', 'success');
    }

    // Notification function
    function showNotification(message, type = 'success') {
        const notification = document.getElementById('successNotification');
        if (!notification) {
            console.error('Notification element not found');
            return;
        }
        
        const notificationSpan = notification.querySelector('span');
        if (!notificationSpan) {
            console.error('Notification span not found');
            return;
        }
        
        // Update message
        notificationSpan.textContent = message;
        
        // Update notification type
        notification.className = 'fixed top-4 right-4 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50';
        
        if (type === 'success') {
            notification.classList.add('bg-green-500');
        } else if (type === 'error') {
            notification.classList.add('bg-red-500');
        } else if (type === 'warning') {
            notification.classList.add('bg-yellow-500');
        } else {
            notification.classList.add('bg-blue-500');
        }
        
        // Show notification
        notification.classList.remove('translate-x-full');
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
        }, 5000);
    }

    // Add smooth animations to form elements
    const formElements = document.querySelectorAll('input, select, textarea');
    formElements.forEach(element => {
        element.addEventListener('focus', function() {
            this.parentElement.classList.add('scale-105');
        });
        
        element.addEventListener('blur', function() {
            this.parentElement.classList.remove('scale-105');
        });
    });



    // Initialize Question Appearance History
    initializeQuestionHistory();
});

// Question Appearance History Management Functions
function initializeQuestionHistory() {
    const historyList = document.getElementById('history-list');
    
    if (!historyList) {
        console.error('History list element not found');
        return;
    }

    // Add history item
    window.addHistory = function() {
        const examName = document.getElementById('exam-name').value.trim();
        const examBoard = document.getElementById('exam-board').value;
        const examYear = document.getElementById('exam-year').value.trim();
        const examMonth = document.getElementById('exam-month').value;
        
        if (!examName || !examYear) {
            alert('Please enter both Exam/Test name and Year');
            return;
        }
        
        // Validate year format and range
        const currentYear = new Date().getFullYear();
        const yearRegex = /^\d{4}$/;
        
        if (!yearRegex.test(examYear)) {
            alert('Year must be a 4-digit number (e.g., 2025)');
            return;
        }
        
        const yearNum = parseInt(examYear);
        if (yearNum < 1972 || yearNum > currentYear) {
            alert(`Year must be between 1972 and ${currentYear}`);
            return;
        }

        // Create history text for display
        let historyText = `${examName} ${examYear}`;
        if (examBoard) {
            historyText += `, ${examBoard}`;
        }
        if (examMonth) {
            historyText += `, ${examMonth}`;
        }

        // Check if history already exists
        const existingHistory = Array.from(historyList.children).map(item => 
            item.querySelector('span').textContent.trim()
        );
        if (existingHistory.includes(historyText)) {
            alert('This history entry already exists');
            return;
        }

        // Create history item
        const historyItem = document.createElement('div');
        historyItem.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200';
        historyItem.innerHTML = `
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-6 h-6 rounded-full bg-amber-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-amber-600">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-700">${historyText}</span>
                    <span class="text-xs text-gray-500">${examName}${examBoard ? ` • ${examBoard}` : ''} • ${examYear}${examMonth ? ` • ${examMonth}` : ''}</span>
                </div>
            </div>
            <button type="button" onclick="removeHistory(this)" class="text-red-500 hover:text-red-700 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M8.75 4A.75.75 0 018 3.25a.75.75 0 01.75-.75h2.5a.75.75 0 01.75.75v2.5a.75.75 0 01-.75.75h-2.5A.75.75 0 018 5.75v-2.5zM8 8.75A.75.75 0 018.75 8h2.5a.75.75 0 01.75.75v2.5a.75.75 0 01-.75.75h-2.5A.75.75 0 018 11.25v-2.5zM8.75 13A.75.75 0 018 12.25a.75.75 0 01.75-.75h2.5a.75.75 0 01.75.75v2.5a.75.75 0 01-.75.75h-2.5A.75.75 0 018 14.75v-2.5z" clip-rule="evenodd" />
                </svg>
            </button>
        `;
        
        // Store the detailed data as a data attribute
        historyItem.setAttribute('data-exam-name', examName);
        historyItem.setAttribute('data-exam-board', examBoard);
        historyItem.setAttribute('data-exam-year', examYear);
        historyItem.setAttribute('data-exam-month', examMonth);
        
        historyList.appendChild(historyItem);
        
        // Clear the input fields
        document.getElementById('exam-name').value = '';
        document.getElementById('exam-board').value = '';
        document.getElementById('exam-year').value = '';
        document.getElementById('exam-month').value = '';
        
        updateHistoryInput();
    };

    // Remove history item
    window.removeHistory = function(button) {
        const historyItem = button.closest('div');
        historyItem.remove();
        updateHistoryInput();
    };

    // Update hidden input for form submission
    function updateHistoryInput() {
        const historyItems = Array.from(historyList.children).map(item => ({
            exam_name: item.getAttribute('data-exam-name'),
            exam_board: item.getAttribute('data-exam-board'),
            exam_year: item.getAttribute('data-exam-year'),
            exam_month: item.getAttribute('data-exam-month')
        }));
        
        // Create or update hidden input for form submission
        let hiddenInput = document.getElementById('historyInput');
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'appearance_history';
            hiddenInput.id = 'historyInput';
            document.getElementById('mcqForm').appendChild(hiddenInput);
        }
        hiddenInput.value = JSON.stringify(historyItems);
    }

    // Handle Enter key press on input fields
    const examNameInput = document.getElementById('exam-name');
    const examBoardInput = document.getElementById('exam-board');
    const examYearInput = document.getElementById('exam-year');
    const examMonthInput = document.getElementById('exam-month');
    
    if (examNameInput) {
        examNameInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addHistory();
            }
        });
    }
    
    if (examBoardInput) {
        examBoardInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addHistory();
            }
        });
    }
    
    if (examYearInput) {
        examYearInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addHistory();
            }
        });
    }
    
    if (examMonthInput) {
        examMonthInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addHistory();
            }
        });
    }

    // Load history from old input if available (for edit mode)
    const oldHistory = @json(old('appearance_history', []));
    if (oldHistory && oldHistory.length > 0) {
        oldHistory.forEach(history => {
            // Populate the input fields
            if (history.exam_name) document.getElementById('exam-name').value = history.exam_name;
            if (history.exam_board) document.getElementById('exam-board').value = history.exam_board;
            if (history.exam_year) document.getElementById('exam-year').value = history.exam_year;
            if (history.exam_month) document.getElementById('exam-month').value = history.exam_month;
            
            // Add the history item
            addHistory();
        });
    }
}
</script>
@endpush

@push('styles')
<style>
/* Custom Rich Text Editor Styling */
#richTextEditor {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    font-size: 14px;
    line-height: 1.6;
    color: #374151;
    background-color: #ffffff;
    min-height: 150px;
    outline: none;
    overflow-y: auto;
}

#richTextEditor:empty:before {
    content: attr(data-placeholder);
    color: #9ca3af;
    pointer-events: none;
}

#richTextEditor:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Rich Text Editor Toolbar */
#richTextEditor + div {
    border-top: none;
}

/* Toolbar button styles */
#richTextEditor + div button {
    transition: all 0.2s ease;
}

#richTextEditor + div button:hover {
    background-color: #e5e7eb;
    transform: translateY(-1px);
}

#richTextEditor + div button.bg-blue-200 {
    background-color: #dbeafe;
    color: #1d4ed8;
    border: 1px solid #93c5fd;
}

/* Equation styling */
#richTextEditor span[style*="font-family: serif"] {
    background-color: #f3f4f6;
    padding: 2px 6px;
    border-radius: 4px;
    border: 1px solid #d1d5db;
}

/* Image styling */
#richTextEditor img {
    display: block;
    margin: 10px auto;
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: all 0.3s ease;
}

#richTextEditor img:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Selected image for resizing */
#richTextEditor img.selected-for-resize {
    outline: 3px solid #3b82f6;
    outline-offset: 2px;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    transform: scale(1.02);
}

/* Resize modal styling */
#resizeModal input[type="number"] {
    text-align: center;
}

#resizeModal input[type="number"]:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

#resizeModal .space-y-4 > div {
    padding: 0.5rem 0;
}

#resizeModal label {
    font-weight: 500;
    color: #374151;
}

/* Image upload button specific styling */
#uploadImageBtn {
    position: relative;
}

#uploadImageBtn:hover {
    background-color: #dbeafe;
    color: #1d4ed8;
}

/* Ensure resize button is always visible */
#resizeBtn {
    display: inline-flex !important;
    visibility: visible !important;
    opacity: 1 !important;
    background-color: #dbeafe !important;
    border: 1px solid #93c5fd !important;
    color: #1d4ed8 !important;
    transition: all 0.2s ease;
}

#resizeBtn:hover {
    background-color: #bfdbfe !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
}

#resizeBtn:active {
    transform: translateY(0);
}

/* Hyperlink button styling for main editor */
#linkBtn:hover {
    background-color: #e5e7eb;
    transform: translateY(-1px);
}

/* Hyperlink styling in both editors */
#richTextEditor a,
#explanationRichTextEditor a {
    color: #2563eb;
    text-decoration: underline;
    cursor: pointer;
    transition: all 0.2s ease;
}

#richTextEditor a:hover,
#explanationRichTextEditor a:hover {
    color: #1d4ed8;
    text-decoration: none;
    background-color: #f3f4f6;
    padding: 2px 4px;
    border-radius: 4px;
}

/* File input styling */
#imageFileInput {
    display: none;
}

/* Loading indicator styling */
.image-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    z-index: 1000;
    font-size: 14px;
}

/* Focus styles for contenteditable */
#richTextEditor:focus-within {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Explanation Rich Text Editor Styling */
#explanationRichTextEditor {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    font-size: 14px;
    line-height: 1.6;
    color: #374151;
    background-color: #ffffff;
    min-height: 150px;
    outline: none;
    overflow-y: auto;
}

#explanationRichTextEditor:empty:before {
    content: attr(data-placeholder);
    color: #9ca3af;
    pointer-events: none;
}

#explanationRichTextEditor:focus-within {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Explanation editor image styling */
#explanationRichTextEditor img {
    display: block;
    margin: 10px auto;
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: all 0.3s ease;
}

#explanationRichTextEditor img:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Selected image for resizing in explanation */
#explanationRichTextEditor img.selected-for-resize {
    outline: 3px solid #3b82f6;
    outline-offset: 2px;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    transform: scale(1.02);
}

/* Explanation resize modal styling */
#explanationResizeModal input[type="number"] {
    text-align: center;
}

#explanationResizeModal input[type="number"]:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

#explanationResizeModal .space-y-4 > div {
    padding: 0.5rem 0;
}

#explanationResizeModal label {
    font-weight: 500;
    color: #374151;
}

/* Explanation editor button styling */
#explanationBoldBtn:hover,
#explanationItalicBtn:hover,
#explanationUnderlineBtn:hover,
#explanationEquationBtn:hover,
#explanationUploadImageBtn:hover,
#explanationResizeBtn:hover,
#explanationLinkBtn:hover,
#explanationClearFormatBtn:hover {
    background-color: #e5e7eb;
    transform: translateY(-1px);
}

#explanationBoldBtn.bg-blue-200,
#explanationItalicBtn.bg-blue-200,
#explanationUnderlineBtn.bg-blue-200 {
    background-color: #dbeafe;
    color: #1d4ed8;
    border: 1px solid #93c5fd;
}

/* Ensure explanation resize button is always visible */
#explanationResizeBtn {
    display: inline-flex !important;
    visibility: visible !important;
    opacity: 1 !important;
    background-color: #dbeafe !important;
    border: 1px solid #93c5fd !important;
    color: #1d4ed8 !important;
    transition: all 0.2s ease;
}

#explanationResizeBtn:hover {
    background-color: #bfdbfe !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
}

#explanationResizeBtn:active {
    transform: translateY(0);
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Smooth transitions */
* {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}

/* Custom focus styles */
.focus-within\:ring-2:focus-within {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

 /* Hover effects */
 .option-item:hover {
     transform: translateY(-2px);
     box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
 }
 
 /* Option bullet styling */
 .option-bullet {
     transition: all 0.3s ease;
 }
 
 .option-bullet.bg-green-500 {
     transform: scale(1.1);
     box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
 }

/* Gradient text animation */
@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.bg-gradient-to-r {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
}

/* Form validation styles */
input:invalid, select:invalid, textarea:invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

/* Loading animation */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Custom button hover effects */
button:hover {
    transform: translateY(-1px);
}

button:active {
    transform: translateY(0);
}

/* Modal backdrop blur */
.modal-backdrop {
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

/* Responsive design improvements */
@media (max-width: 768px) {
    .max-w-6xl {
        max-width: 100%;
        margin: 0 1rem;
    }
    
    .p-8 {
        padding: 1.5rem;
    }
    
    .grid-cols-1.lg\:grid-cols-2 {
        grid-template-columns: 1fr;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .bg-white {
        background-color: #1f2937;
    }
    
    .text-gray-900 {
        color: #f9fafb;
    }
    
    .text-gray-700 {
        color: #d1d5db;
    }
    
    .text-gray-600 {
        color: #9ca3af;
    }
    
    .border-gray-200 {
        border-color: #374151;
    }
    
    .border-gray-300 {
        border-color: #4b5563;
    }
}

/* Enhanced form styling */
.form-input:focus {
    transform: scale(1.02);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Floating label animation */
.floating-label {
    position: relative;
}

.floating-label input:focus + label,
.floating-label input:not(:placeholder-shown) + label {
    transform: translateY(-1.5rem) scale(0.85);
    color: #3b82f6;
}

/* Card hover effects */
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Glow effects */
.glow-on-hover:hover {
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
}

/* Smooth page transitions */
.page-transition {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Enhanced button animations */
.btn-animate {
    position: relative;
    overflow: hidden;
}

.btn-animate::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-animate:hover::before {
    left: 100%;
}

/* Form section animations */
.form-section {
    animation: slideInLeft 0.8s ease-out;
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Staggered animation for form elements */
.form-element:nth-child(1) { animation-delay: 0.1s; }
.form-element:nth-child(2) { animation-delay: 0.2s; }
.form-element:nth-child(3) { animation-delay: 0.3s; }
.form-element:nth-child(4) { animation-delay: 0.4s; }

/* Enhanced focus rings */
.enhanced-focus:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), 0 0 0 1px rgba(59, 130, 246, 0.2);
}

/* Smooth color transitions */
.color-transition {
    transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
}

/* Enhanced shadows */
.enhanced-shadow {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.enhanced-shadow:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Tags Auto-completion Styling */
#tagsSuggestions {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
}

#tagsSuggestions div {
    transition: background-color 0.15s ease-in-out;
}

#tagsSuggestions div:hover {
    background-color: #eff6ff;
}

#tagsSuggestions div:first-child {
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}

#tagsSuggestions div:last-child {
    border-bottom-left-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
    border-bottom: none;
}

/* Ensure the tags input container has proper positioning */
#new-tag {
    position: relative;
}

/* Tag list styling */
#tag-list {
    min-height: 44px;
}

#tag-list:empty::before {
    content: '';
    display: block;
    height: 20px;
}

/* Question Appearance History Styling */
#history-list {
    min-height: 44px;
}

#history-list:empty::before {
    content: '';
    display: block;
    height: 20px;
}

#new-history {
    transition: all 0.2s ease;
}

#new-history:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* History item styling */
#history-list > div {
    transition: all 0.2s ease;
}

#history-list > div:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Add button styling */
#new-history + button {
    transition: all 0.2s ease;
}

#new-history + button:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}
</style>
@endpush

<!-- Preview Modal -->
<div id="previewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-2xl bg-white">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-gray-900">Question Preview</h3>
            <button id="closePreview" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div id="previewContent" class="space-y-6">
            <!-- Preview content will be populated here -->
        </div>
        
        <div class="flex justify-end mt-6">
            <button id="closePreviewBtn" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                Close
            </button>
        </div>
    </div>
</div>

 <!-- Success Notification -->
 <div id="successNotification" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50">
     <div class="flex items-center">
         <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
         </svg>
         <span>Question created successfully!</span>
     </div>
 </div>
 
 <!-- Image Resize Modal -->
 <div id="resizeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
     <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-2xl bg-white">
         <div class="flex items-center justify-between mb-6">
             <h3 class="text-xl font-bold text-gray-900">Resize Image</h3>
             <button id="closeResizeModal" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                 </svg>
             </button>
         </div>
         
         <div class="space-y-4">
             <div class="flex items-center space-x-4">
                 <label class="text-sm font-medium text-gray-700">Width:</label>
                 <input type="number" id="resizeWidth" class="w-20 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="50" max="1200">
                 <span class="text-sm text-gray-500">px</span>
             </div>
             
             <div class="flex items-center space-x-4">
                 <label class="text-sm font-medium text-gray-700">Height:</label>
                 <input type="number" id="resizeHeight" class="w-20 px-3 py-2 border border-gray-300 rounded-md focus:2 focus:ring-blue-500 focus:border-blue-500" min="50" max="1200">
                 <span class="text-sm text-gray-500">px</span>
             </div>
             
             <div class="flex items-center space-x-2">
                 <input type="checkbox" id="maintainAspectRatio" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                 <label for="maintainAspectRatio" class="text-sm text-gray-700">Maintain aspect ratio</label>
             </div>
             
             <div class="flex items-center space-x-2">
                 <input type="checkbox" id="resizeProportionally" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                 <label for="resizeProportionally" class="text-sm text-gray-700">Resize proportionally (%)</label>
             </div>
             
             <div id="proportionalControls" class="hidden space-y-2">
                 <div class="flex items-center space-x-4">
                     <label class="text-sm font-medium text-gray-700">Scale:</label>
                     <input type="number" id="resizeScale" class="w-20 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="10" max="200" value="100">
                     <span class="text-sm text-gray-500">%</span>
                 </div>
             </div>
             
             <div class="flex items-center space-x-2">
                 <input type="checkbox" id="resizeQuality" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                 <label for="resizeQuality" class="text-sm text-gray-700">Optimize quality</label>
             </div>
         </div>
         
         <div class="flex justify-end space-x-3 mt-6">
             <button id="cancelResize" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                 Cancel
             </button>
             <button id="applyResize" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                 Apply
             </button>
         </div>
     </div>
 </div>
 
 <!-- Explanation Image Resize Modal -->
 <div id="explanationResizeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
     <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-2xl bg-white">
         <div class="flex items-center justify-between mb-6">
             <h3 class="text-xl font-bold text-gray-900">Resize Explanation Image</h3>
             <button id="explanationCloseResizeModal" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                 </svg>
             </button>
         </div>
         
         <div class="space-y-4">
             <div class="flex items-center space-x-4">
                 <label class="text-sm font-medium text-gray-700">Width:</label>
                 <input type="number" id="explanationResizeWidth" class="w-20 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="50" max="1200">
                 <span class="text-sm text-gray-500">px</span>
             </div>
             
             <div class="flex items-center space-x-4">
                 <label class="text-sm font-medium text-gray-700">Height:</label>
                 <input type="number" id="explanationResizeHeight" class="w-20 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="50" max="1200">
                 <span class="text-sm text-gray-500">px</span>
             </div>
             
             <div class="flex items-center space-x-2">
                 <input type="checkbox" id="explanationMaintainAspectRatio" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                 <label for="explanationMaintainAspectRatio" class="text-sm text-gray-700">Maintain aspect ratio</label>
             </div>
             
             <div class="flex items-center space-x-2">
                 <input type="checkbox" id="explanationResizeProportionally" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                 <label for="explanationResizeProportionally" class="text-sm text-gray-700">Resize proportionally (%)</label>
             </div>
             
             <div id="explanationProportionalControls" class="hidden space-y-2">
                 <div class="flex items-center space-x-4">
                     <label class="text-sm font-medium text-gray-700">Scale:</label>
                     <input type="number" id="explanationResizeScale" class="w-20 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="10" max="200" value="100">
                     <span class="text-sm text-gray-500">%</span>
                 </div>
             </div>
             
             <div class="flex items-center space-x-2">
                 <input type="checkbox" id="explanationResizeQuality" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                 <label for="explanationResizeQuality" class="text-sm text-gray-700">Optimize quality</label>
             </div>
         </div>
         
         <div class="flex justify-end space-x-3 mt-6">
             <button id="explanationCancelResize" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                 Cancel
             </button>
             <button id="explanationApplyResize" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                 Apply
             </button>
         </div>
     </div>
 </div>
