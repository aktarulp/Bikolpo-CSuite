<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Online Test Result - {{ $exam->title }} | Bikolpo LQ</title>
    
    <!-- SEO Meta Tags for Social Sharing -->
    <meta name="description" content="I scored {{ number_format($result->percentage ?? 0, 1) }}% on {{ $exam->title }} online test! Check out my performance on Bikolpo LQ.">
    <meta name="keywords" content="online test, exam, result, {{ $exam->title }}, Bikolpo LQ, education, learning">
    
    <!-- Open Graph Meta Tags for Social Media -->
    <meta property="og:title" content="Online Test Result - {{ $exam->title }} | Bikolpo LQ">
    <meta property="og:description" content="I scored {{ number_format($result->percentage ?? 0, 1) }}% on {{ $exam->title }} online test! Check out my performance on Bikolpo LQ.">
    <meta property="og:image" content="{{ asset('images/online-test-result-share.png') }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Bikolpo LQ">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Online Test Result - {{ $exam->title }} | Bikolpo LQ">
    <meta name="twitter:description" content="I scored {{ number_format($result->percentage ?? 0, 1) }}% on {{ $exam->title }} online test! Check out my performance on Bikolpo LQ.">
    <meta name="twitter:image" content="{{ asset('images/online-test-result-share.png') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-inter antialiased bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen overflow-x-hidden">
    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-200/30 to-indigo-200/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-purple-200/30 to-pink-200/30 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-cyan-200/20 to-blue-200/20 rounded-full blur-3xl animate-pulse delay-500"></div>
    </div>

    <div class="relative min-h-screen py-2 sm:py-4 lg:py-8">
        <div class="max-w-4xl mx-auto px-3 sm:px-4 lg:px-8">
            <!-- Header with Branding -->
            <div class="text-center mb-4 sm:mb-6 lg:mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 rounded-full shadow-2xl mb-3 sm:mb-4 lg:mb-6 transform hover:scale-105 transition-all duration-300">
                    <i class="fas fa-trophy text-xl sm:text-2xl lg:text-3xl text-white"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-black text-gray-800 mb-2 sm:mb-3 px-2">
                    Online Test Completed!
                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-gray-600 font-medium px-2">Congratulations on completing {{ $exam->title }}</p>
                <div class="mt-3 sm:mt-4 inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full shadow-lg">
                    <i class="fas fa-star text-yellow-300 mr-2 text-sm sm:text-base"></i>
                    <span class="text-white font-bold text-sm sm:text-base">Powered by Bikolpo LQ</span>
                </div>
            </div>

            <!-- Student Information Section -->
            @if($result->student)
            <div class="relative bg-white rounded-2xl sm:rounded-3xl shadow-xl border border-gray-100 overflow-hidden mb-4 sm:mb-6 lg:mb-8">
                <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 sm:w-18 sm:h-18 lg:w-20 lg:h-20 bg-white/20 backdrop-blur-sm rounded-full shadow-lg mb-3 sm:mb-4 overflow-hidden">
                            @if($result->student->photo)
                                <img src="{{ asset('storage/' . $result->student->photo) }}" 
                                     alt="{{ $result->student->full_name ?? 'Student' }}" 
                                     class="w-full h-full object-cover rounded-full">
                            @else
                                <i class="fas fa-user text-xl sm:text-2xl lg:text-3xl text-white"></i>
                            @endif
                        </div>
                        <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white mb-1 sm:mb-2">{{ $result->student->full_name ?? 'Student Information' }}</h2>
                        <p class="text-green-100 text-xs sm:text-sm px-2">
                            {{ $result->student->student_id ?? 'N/A' }}
                            @if($result->student->phone)
                                | {{ $result->student->phone }}
                            @endif
                            @if($result->student->email)
                                | {{ $result->student->email }}
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="p-4 sm:p-6 lg:p-8">
                    
                    @if($result->student->course || $result->student->partner)
                    <div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            @if($result->student->partner)
                            <div class="bg-purple-50 rounded-lg sm:rounded-xl p-4 border border-purple-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-building text-purple-600 mr-2 text-sm"></i>
                                    <span class="text-xs font-semibold text-purple-600 uppercase tracking-wide">Institution</span>
                                </div>
                                <div class="text-sm sm:text-base font-bold text-purple-800">{{ $result->student->partner->name ?? 'N/A' }}</div>
                            </div>
                            @endif
                            
                            @if($result->student->course)
                            <div class="bg-blue-50 rounded-lg sm:rounded-xl p-4 border border-blue-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-book text-blue-600 mr-2 text-sm"></i>
                                    <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Course</span>
                                </div>
                                <div class="text-sm sm:text-base font-bold text-blue-800">{{ $result->student->course->name ?? 'N/A' }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Professional Result Card -->
            <div class="relative bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-gray-100 overflow-hidden mb-4 sm:mb-6 lg:mb-8 transform hover:scale-[1.01] transition-all duration-300">
                <!-- Professional Header -->
                <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 sm:w-18 sm:h-18 lg:w-20 lg:h-20 bg-white/20 backdrop-blur-sm rounded-full shadow-lg mb-3 sm:mb-4">
                            <i class="fas fa-trophy text-xl sm:text-2xl lg:text-3xl text-white"></i>
                        </div>
                        <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-white mb-1 sm:mb-2">Online Test Completed!</h1>
                        <p class="text-blue-100 text-xs sm:text-sm px-2">{{ $exam->title }}</p>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="relative p-4 sm:p-6 lg:p-8">
                    <!-- Score Section -->
                    <div class="text-center mb-6 sm:mb-8">
                        <div class="inline-flex items-center justify-center w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 rounded-full shadow-xl mb-4 sm:mb-6 relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent rounded-full"></div>
                            <div class="relative text-center">
                                <div class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1">{{ number_format($result->percentage ?? 0, 1) }}%</div>
                                <div class="text-xs text-white font-medium">SCORE</div>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="inline-flex items-center px-4 sm:px-6 py-2 rounded-full text-xs sm:text-sm font-semibold shadow-md mb-3 sm:mb-4
                            @if(($result->percentage ?? 0) >= ($exam->passing_marks ?? 50))
                                bg-green-100 text-green-800 border border-green-200
                            @else
                                bg-red-100 text-red-800 border border-red-200
                            @endif">
                            <i class="fas fa-{{ ($result->percentage ?? 0) >= ($exam->passing_marks ?? 50) ? 'check-circle' : 'times-circle' }} mr-2"></i>
                            {{ ($result->percentage ?? 0) >= ($exam->passing_marks ?? 50) ? 'PASSED' : 'FAILED' }}
                        </div>
                    </div>

                    <!-- Performance Stats Grid -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 lg:gap-4 mb-6 sm:mb-8">
                        <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 border border-gray-200 text-center shadow-sm hover:shadow-md transition-all duration-200">
                            <div class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800 mb-1">{{ $result->total_questions ?? 0 }}</div>
                            <div class="text-xs text-gray-600 font-medium">Total Questions</div>
                        </div>
                        
                        <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 border border-gray-200 text-center shadow-sm hover:shadow-md transition-all duration-200">
                            <div class="text-lg sm:text-xl lg:text-2xl font-bold text-green-600 mb-1">{{ $result->correct_answers ?? 0 }}</div>
                            <div class="text-xs text-gray-600 font-medium">Correct</div>
                        </div>
                        
                        <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 border border-gray-200 text-center shadow-sm hover:shadow-md transition-all duration-200">
                            <div class="text-lg sm:text-xl lg:text-2xl font-bold text-red-600 mb-1">{{ $result->wrong_answers ?? 0 }}</div>
                            <div class="text-xs text-gray-600 font-medium">Wrong</div>
                        </div>
                        
                        <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 border border-gray-200 text-center shadow-sm hover:shadow-md transition-all duration-200">
                            <div class="text-lg sm:text-xl lg:text-2xl font-bold text-orange-600 mb-1">{{ $result->unanswered ?? 0 }}</div>
                            <div class="text-xs text-gray-600 font-medium">Unanswered</div>
                        </div>
                    </div>
                            
                    <!-- Score Details -->
                    <div class="bg-gray-50 rounded-lg sm:rounded-xl p-4 sm:p-6 mb-6 sm:mb-8 border border-gray-200">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4 text-center">Score Details</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                            <div class="text-center p-3 sm:p-4 bg-white rounded-lg border border-gray-200 shadow-sm">
                                <div class="text-lg sm:text-xl font-bold text-gray-800 mb-1">{{ $result->score ?? 0 }}</div>
                                <div class="text-xs text-gray-600 font-medium">Final Score</div>
                            </div>
                            <div class="text-center p-3 sm:p-4 bg-white rounded-lg border border-gray-200 shadow-sm">
                                <div class="text-lg sm:text-xl font-bold text-gray-800 mb-1">{{ $result->grade ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-600 font-medium">Grade</div>
                            </div>
                            <div class="text-center p-3 sm:p-4 bg-white rounded-lg border border-gray-200 shadow-sm">
                                <div class="text-lg sm:text-xl font-bold text-gray-800 mb-1">{{ $exam->passing_marks ?? 50 }}%</div>
                                <div class="text-xs text-gray-600 font-medium">Passing Marks</div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Sharing Section -->
                    <div class="bg-blue-50 rounded-lg sm:rounded-xl p-4 sm:p-6 mb-6 sm:mb-8 border border-blue-200">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-2 sm:mb-3 text-center">Share Your Achievement</h3>
                        <p class="text-xs sm:text-sm text-gray-600 text-center mb-3 sm:mb-4 px-2">Let your friends know about your performance and inspire them to try Bikolpo LQ!</p>
                        
                        <div class="grid grid-cols-2 sm:flex sm:flex-wrap justify-center gap-2 sm:gap-3">
                            <!-- Facebook Share -->
                            <button onclick="shareOnFacebook()" class="flex items-center justify-center px-3 sm:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                <i class="fab fa-facebook-f mr-1 sm:mr-2"></i>
                                <span class="hidden sm:inline">Facebook</span>
                                <span class="sm:hidden">FB</span>
                            </button>
                            
                            <!-- WhatsApp Share -->
                            <button onclick="shareOnWhatsApp()" class="flex items-center justify-center px-3 sm:px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs sm:text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                <i class="fab fa-whatsapp mr-1 sm:mr-2"></i>
                                <span class="hidden sm:inline">WhatsApp</span>
                                <span class="sm:hidden">WA</span>
                            </button>
                            
                            <!-- X (Twitter) Share -->
                            <button onclick="shareOnTwitter()" class="flex items-center justify-center px-3 sm:px-4 py-2 bg-black hover:bg-gray-800 text-white text-xs sm:text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                <i class="fab fa-x-twitter mr-1 sm:mr-2"></i>
                                <span class="hidden sm:inline">Share on X</span>
                                <span class="sm:hidden">X</span>
                            </button>
                            
                            <!-- Copy Link -->
                            <button onclick="copyToClipboard()" class="flex items-center justify-center px-3 sm:px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-xs sm:text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                <i class="fas fa-link mr-1 sm:mr-2"></i>
                                <span class="hidden sm:inline">Copy Link</span>
                                <span class="sm:hidden">Copy</span>
                            </button>
                        </div>
                    </div>

                    <!-- Time Information -->
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg sm:rounded-2xl p-4 sm:p-6 mb-6 sm:mb-8 border border-slate-200 shadow-lg">
                        <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800 mb-4 sm:mb-6 text-center flex items-center justify-center">
                            <i class="fas fa-clock text-blue-600 mr-2 sm:mr-3 text-sm sm:text-base"></i>
                            Time Information
                        </h3>
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 lg:gap-4">
                            <div class="text-center p-3 sm:p-4 bg-white rounded-lg sm:rounded-xl border border-slate-200 shadow-md">
                                <div class="text-xs sm:text-sm text-gray-600 mb-1 sm:mb-2 font-semibold">Started At</div>
                                <div class="text-xs sm:text-sm font-bold text-gray-800">{{ $result->started_at ? $result->started_at->format('M d, g:i A') : 'N/A' }}</div>
                            </div>
                            
                            <div class="text-center p-3 sm:p-4 bg-white rounded-lg sm:rounded-xl border border-slate-200 shadow-md">
                                <div class="text-xs sm:text-sm text-gray-600 mb-1 sm:mb-2 font-semibold">Completed At</div>
                                <div class="text-xs sm:text-sm font-bold text-gray-800">{{ $result->completed_at ? $result->completed_at->format('M d, g:i A') : 'N/A' }}</div>
                            </div>
                            
                            <div class="text-center p-3 sm:p-4 bg-white rounded-lg sm:rounded-xl border border-slate-200 shadow-md">
                                <div class="text-xs sm:text-sm text-gray-600 mb-1 sm:mb-2 font-semibold">Time Taken</div>
                                <div class="text-xs sm:text-sm font-bold text-gray-800">{{ ($result->started_at && $result->completed_at) ? $result->started_at->diffInMinutes($result->completed_at) : 'N/A' }} min</div>
                            </div>
                            
                            <div class="text-center p-3 sm:p-4 bg-white rounded-lg sm:rounded-xl border border-slate-200 shadow-md">
                                <div class="text-xs sm:text-sm text-gray-600 mb-1 sm:mb-2 font-semibold">Time Limit</div>
                                <div class="text-xs sm:text-sm font-bold text-gray-800">{{ $exam->duration ?? 'N/A' }} min</div>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Insights -->
                    <div class="bg-gradient-to-r from-amber-50 via-orange-50 to-red-50 rounded-lg sm:rounded-2xl p-4 sm:p-6 mb-6 sm:mb-8 border border-amber-200 shadow-lg">
                        <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800 mb-4 sm:mb-6 text-center flex items-center justify-center">
                            <i class="fas fa-lightbulb text-amber-600 mr-2 sm:mr-3 text-sm sm:text-base"></i>
                            Performance Insights
                        </h3>
                        <div class="space-y-3 sm:space-y-4">
                            @if(($result->percentage ?? 0) >= 90)
                                <div class="flex items-start sm:items-center p-3 sm:p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg sm:rounded-xl border border-green-200 shadow-md">
                                    <i class="fas fa-star text-green-600 text-lg sm:text-xl lg:text-2xl mr-3 sm:mr-4 mt-1 sm:mt-0 flex-shrink-0"></i>
                                    <span class="text-green-800 font-semibold text-sm sm:text-base lg:text-lg">Outstanding performance! You've mastered this material with exceptional understanding.</span>
                                </div>
                            @elseif(($result->percentage ?? 0) >= 80)
                                <div class="flex items-start sm:items-center p-3 sm:p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg sm:rounded-xl border border-blue-200 shadow-md">
                                    <i class="fas fa-thumbs-up text-blue-600 text-lg sm:text-xl lg:text-2xl mr-3 sm:mr-4 mt-1 sm:mt-0 flex-shrink-0"></i>
                                    <span class="text-blue-800 font-semibold text-sm sm:text-base lg:text-lg">Excellent work! You have a solid understanding of the subject matter.</span>
                                </div>
                            @elseif(($result->percentage ?? 0) >= 70)
                                <div class="flex items-start sm:items-center p-3 sm:p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg sm:rounded-xl border border-yellow-200 shadow-md">
                                    <i class="fas fa-check-circle text-yellow-600 text-lg sm:text-xl lg:text-2xl mr-3 sm:mr-4 mt-1 sm:mt-0 flex-shrink-0"></i>
                                    <span class="text-yellow-800 font-semibold text-sm sm:text-base lg:text-lg">Good job! Consider reviewing areas where you struggled for improvement.</span>
                                </div>
                            @else
                                <div class="flex items-start sm:items-center p-3 sm:p-4 bg-gradient-to-r from-red-50 to-red-100 rounded-lg sm:rounded-xl border border-red-200 shadow-md">
                                    <i class="fas fa-exclamation-triangle text-red-600 text-lg sm:text-xl lg:text-2xl mr-3 sm:mr-4 mt-1 sm:mt-0 flex-shrink-0"></i>
                                    <span class="text-red-800 font-semibold text-sm sm:text-base lg:text-lg">Keep practicing! Review the material thoroughly and try again for better results.</span>
                                </div>
                            @endif
                            
                            @if(isset($result->unanswered) && $result->unanswered > 0)
                                <div class="flex items-start sm:items-center p-3 sm:p-4 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg sm:rounded-xl border border-orange-200 shadow-md">
                                    <i class="fas fa-clock text-orange-600 text-lg sm:text-xl lg:text-2xl mr-3 sm:mr-4 mt-1 sm:mt-0 flex-shrink-0"></i>
                                    <span class="text-orange-800 font-semibold text-sm sm:text-base lg:text-lg">You left {{ $result->unanswered }} question(s) unanswered. Try to answer all questions next time for maximum points.</span>
                                </div>
                            @endif

                            @if(isset($exam->has_negative_marking) && $exam->has_negative_marking && $result->wrong_answers > 0)
                                <div class="flex items-start sm:items-center p-3 sm:p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg sm:rounded-xl border border-purple-200 shadow-md">
                                    <i class="fas fa-info-circle text-purple-600 text-lg sm:text-xl lg:text-2xl mr-3 sm:mr-4 mt-1 sm:mt-0 flex-shrink-0"></i>
                                    <span class="text-purple-800 font-semibold text-sm sm:text-base lg:text-lg">This quiz has negative marking. Each wrong answer deducts {{ $exam->negative_marks_per_question ?? 0.25 }} marks.</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-center">
                        <a href="{{ route('public.quiz.review', ['exam' => $exam->id, 'result' => $result->id]) }}" 
                           class="flex-1 sm:flex-none flex justify-center items-center py-3 px-4 sm:px-6 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                            <i class="fas fa-file-alt mr-2 text-sm sm:text-base"></i>
                            <span class="text-sm sm:text-base">Review Answers</span>
                        </a>
                        
                        <a href="{{ route('public.quiz.access') }}" 
                           class="flex-1 sm:flex-none flex justify-center items-center py-3 px-4 sm:px-6 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                            <i class="fas fa-play-circle mr-2 text-sm sm:text-base"></i>
                            <span class="text-sm sm:text-base">Take Another Test</span>
                        </a>
                        
                        <button onclick="window.print()" 
                                class="flex-1 sm:flex-none flex justify-center items-center py-3 px-4 sm:px-6 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                            <i class="fas fa-download mr-2 text-sm sm:text-base"></i>
                            <span class="text-sm sm:text-base">Download Result</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center text-gray-600 mb-4 sm:mb-6 lg:mb-8">
                <div class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full shadow-lg">
                    <i class="fas fa-star text-yellow-300 mr-2 text-sm sm:text-base"></i>
                    <span class="text-white font-semibold text-sm sm:text-base">Powered by Bikolpo LQ</span>
                </div>
                <p class="text-xs sm:text-sm mt-3 sm:mt-4 text-gray-500 px-2">
                    Report generated on {{ now()->format('M d, Y g:i A') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        .font-inter {
            font-family: 'Inter', sans-serif;
        }
        
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Custom animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes glow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
            50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.8); }
        }
        
        .animate-glow {
            animation: glow 2s ease-in-out infinite;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.5);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.7);
        }
        
        /* Mobile-specific improvements */
        @media (max-width: 640px) {
            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
            
            /* Improve touch targets */
            button, a {
                min-height: 44px;
                min-width: 44px;
            }
            
            /* Better text readability on mobile */
            .text-xs {
                font-size: 0.75rem;
                line-height: 1rem;
            }
            
            /* Optimize grid layouts for mobile */
            .grid-cols-2 {
                gap: 0.5rem;
            }
            
            /* Improve card spacing */
            .rounded-lg {
                border-radius: 0.5rem;
            }
            
            /* Better button spacing */
            .gap-2 > * + * {
                margin-top: 0.5rem;
            }
        }
        
        /* Print styles */
        @media print {
            body { 
                background: white !important; 
            }
            .bg-gradient-to-br { 
                background: white !important; 
            }
            .shadow-2xl, .shadow-xl, .shadow-lg, .shadow-sm { 
                box-shadow: none !important; 
            }
            .rounded-2xl, .rounded-xl, .rounded-lg { 
                border-radius: 0 !important; 
            }
            .bg-gradient-to-r { 
                background: #f8fafc !important; 
            }
            .text-white { 
                color: #000000 !important; 
            }
            .bg-white\/10 { 
                background: #ffffff !important; 
            }
            .backdrop-blur-sm { 
                backdrop-filter: none !important; 
            }
        }
    </style>

    <!-- JavaScript for Social Media Sharing -->
    <script>
        // Social Media Sharing Functions
        function shareOnFacebook() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent(`I scored {{ number_format($result->percentage ?? 0, 1) }}% on {{ $exam->title }} online test! Check out my performance on Bikolpo LQ.`);
            const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${text}`;
            window.open(facebookUrl, '_blank', 'width=600,height=400');
        }
        
        function shareOnWhatsApp() {
            const text = `I scored {{ number_format($result->percentage ?? 0, 1) }}% on {{ $exam->title }} online test! Check out my performance on Bikolpo LQ. ${window.location.href}`;
            const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(text)}`;
            window.open(whatsappUrl, '_blank');
        }
        
        function shareOnTwitter() {
            const text = `I scored {{ number_format($result->percentage ?? 0, 1) }}% on {{ $exam->title }} online test! Check out my performance on Bikolpo LQ.`;
            const url = window.location.href;
            const twitterUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
            window.open(twitterUrl, '_blank', 'width=600,height=400');
        }
        
        function copyToClipboard() {
            const text = `I scored {{ number_format($result->percentage ?? 0, 1) }}% on {{ $exam->title }} online test! Check out my performance on Bikolpo LQ. ${window.location.href}`;
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    showNotification('Link copied to clipboard!', 'success');
                });
            } else {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showNotification('Link copied to clipboard!', 'success');
            }
        }
        
        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
        
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add floating animation to the main score circle
            const scoreCircle = document.querySelector('.inline-flex.items-center.justify-center.w-32.h-32');
            if (scoreCircle) {
                scoreCircle.classList.add('animate-float');
            }
            
            // Add glow effect to the main card
            const mainCard = document.querySelector('.relative.bg-white\\/10');
            if (mainCard) {
                mainCard.classList.add('animate-glow');
            }
            
            // Add hover effects to stat cards
            const statCards = document.querySelectorAll('.bg-white\\/20.backdrop-blur-sm');
            statCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05) translateY(-5px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1) translateY(0)';
                });
            });
        });
    </script>
</body>
</html>
