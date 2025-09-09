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
<body class="font-inter antialiased bg-gradient-to-br from-slate-50 via-blue-50 via-indigo-50 to-purple-100 min-h-screen overflow-x-hidden">
    <!-- Enhanced Geometric Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <!-- Large Geometric Shapes -->
        <div class="absolute top-0 left-0 w-full h-full">
            <!-- Hexagon Pattern -->
            <div class="absolute top-20 left-10 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-indigo-500/20 transform rotate-12 animate-pulse"></div>
            <div class="absolute top-40 right-20 w-24 h-24 bg-gradient-to-br from-purple-400/25 to-pink-500/25 transform -rotate-12 animate-pulse delay-1000"></div>
            <div class="absolute bottom-32 left-1/4 w-40 h-40 bg-gradient-to-br from-emerald-400/20 to-teal-500/20 transform rotate-45 animate-pulse delay-500"></div>
            
            <!-- Triangle Shapes -->
            <div class="absolute top-1/3 right-1/3 w-0 h-0 border-l-[30px] border-r-[30px] border-b-[52px] border-l-transparent border-r-transparent border-b-gradient-to-b from-cyan-400/30 to-blue-500/30 transform rotate-45 animate-pulse delay-700"></div>
            <div class="absolute bottom-20 right-10 w-0 h-0 border-l-[20px] border-r-[20px] border-b-[35px] border-l-transparent border-r-transparent border-b-gradient-to-b from-rose-400/25 to-pink-500/25 transform -rotate-45 animate-pulse delay-1200"></div>
            
            <!-- Diamond Shapes -->
            <div class="absolute top-1/4 left-1/3 w-16 h-16 bg-gradient-to-br from-amber-400/20 to-orange-500/20 transform rotate-45 animate-pulse delay-300"></div>
            <div class="absolute bottom-1/3 right-1/4 w-20 h-20 bg-gradient-to-br from-violet-400/25 to-purple-500/25 transform -rotate-45 animate-pulse delay-900"></div>
            
            <!-- Circular Elements -->
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-200/30 to-indigo-200/30 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-purple-200/30 to-pink-200/30 rounded-full blur-3xl animate-pulse delay-1000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-cyan-200/20 to-blue-200/20 rounded-full blur-3xl animate-pulse delay-500"></div>
            
            <!-- Abstract Wave Shapes -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-emerald-300/15 to-teal-400/15 transform rotate-12 skew-x-12 animate-pulse delay-400"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-rose-300/20 to-pink-400/20 transform -rotate-12 skew-y-12 animate-pulse delay-800"></div>
            
            <!-- Floating Geometric Elements -->
            <div class="absolute top-1/2 left-10 w-8 h-8 bg-gradient-to-br from-yellow-400/30 to-amber-500/30 transform rotate-45 animate-bounce delay-600"></div>
            <div class="absolute top-1/3 right-10 w-6 h-6 bg-gradient-to-br from-green-400/35 to-emerald-500/35 transform rotate-12 animate-bounce delay-1100"></div>
            <div class="absolute bottom-1/4 left-1/2 w-10 h-10 bg-gradient-to-br from-indigo-400/25 to-purple-500/25 transform -rotate-12 animate-bounce delay-1300"></div>
        </div>
        
        <!-- Subtle Grid Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="w-full h-full" style="background-image: radial-gradient(circle at 1px 1px, rgba(59, 130, 246, 0.3) 1px, transparent 0); background-size: 20px 20px;"></div>
        </div>
    </div>

    <div class="relative min-h-screen py-2 sm:py-4 lg:py-8">
        <div class="max-w-4xl mx-auto px-3 sm:px-4 lg:px-8">
            <!-- Header with Branding -->
            <div class="text-center mb-4 sm:mb-6 lg:mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 rounded-full shadow-2xl mb-3 sm:mb-4 lg:mb-6 transform hover:scale-105 transition-all duration-300">
                    <i class="fas fa-trophy text-xl sm:text-2xl lg:text-3xl text-white"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-black text-gray-800 mb-2 sm:mb-3 px-2">
                    Congratulations on completing Bikolpo LQ Online Test!
                </h1>
                <div class="mt-3 sm:mt-4 inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full shadow-lg">
                    <i class="fas fa-star text-yellow-300 mr-2 text-sm sm:text-base"></i>
                    <span class="text-white font-bold text-sm sm:text-base">Powered by Bikolpo LQ</span>
                </div>
            </div>

            <!-- Student Information Section -->
            @if($result->student)
            <div class="relative bg-white rounded-3xl sm:rounded-[2rem] shadow-2xl border border-gray-100 overflow-hidden mb-4 sm:mb-6 lg:mb-8 transform hover:scale-[1.02] transition-all duration-500 group">
                <!-- Advanced Decorative Elements -->
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-emerald-300/25 to-teal-400/25 rounded-full -translate-y-20 translate-x-20 animate-pulse"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-green-300/20 to-emerald-400/20 rounded-full translate-y-16 -translate-x-16 animate-pulse delay-1000"></div>
                <div class="absolute top-1/2 left-0 w-24 h-24 bg-gradient-to-r from-cyan-300/15 to-blue-400/15 rounded-full -translate-x-12 animate-pulse delay-500"></div>
                <div class="absolute top-1/4 right-0 w-20 h-20 bg-gradient-to-l from-teal-300/20 to-green-400/20 rounded-full translate-x-10 animate-pulse delay-700"></div>
                
                <!-- Geometric Shapes Overlay -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute top-8 left-8 w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 transform rotate-45 animate-spin" style="animation-duration: 20s;"></div>
                    <div class="absolute bottom-8 right-8 w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 transform -rotate-45 animate-spin" style="animation-duration: 25s;"></div>
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-8 h-8 bg-gradient-to-br from-cyan-500 to-blue-600 transform rotate-12 animate-pulse"></div>
                </div>
                
                <div class="relative bg-gradient-to-br from-emerald-600 via-green-600 to-teal-700 px-4 sm:px-6 lg:px-8 py-6 sm:py-8 overflow-hidden">
                    <!-- Animated Background Pattern -->
                    <div class="absolute inset-0 opacity-15">
                        <div class="absolute top-6 left-6 w-3 h-3 bg-white rounded-full animate-pulse"></div>
                        <div class="absolute top-12 right-12 w-2 h-2 bg-white rounded-full animate-pulse delay-1000"></div>
                        <div class="absolute bottom-8 left-12 w-2.5 h-2.5 bg-white rounded-full animate-pulse delay-500"></div>
                        <div class="absolute bottom-6 right-6 w-3 h-3 bg-white rounded-full animate-pulse delay-1500"></div>
                        <div class="absolute top-1/2 left-6 w-1.5 h-1.5 bg-white rounded-full animate-pulse delay-300"></div>
                        <div class="absolute top-1/3 right-8 w-2 h-2 bg-white rounded-full animate-pulse delay-800"></div>
                    </div>
                    
                    <!-- Floating Elements -->
                    <div class="absolute top-4 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-yellow-300/40 rounded-full animate-bounce delay-200"></div>
                    <div class="absolute bottom-4 right-1/4 w-1.5 h-1.5 bg-amber-300/50 rounded-full animate-bounce delay-600"></div>
                    
                    <div class="relative text-center">
                        <!-- Enhanced Photo Container -->
                        <div class="inline-flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 bg-gradient-to-br from-white/30 to-white/10 backdrop-blur-md rounded-full shadow-2xl mb-4 sm:mb-6 overflow-hidden border-4 border-white/40 transform hover:scale-110 hover:rotate-6 transition-all duration-500 group-hover:shadow-3xl">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent rounded-full"></div>
                            @if($result->student->photo)
                                <img src="{{ asset('storage/' . $result->student->photo) }}" 
                                     alt="{{ $result->student->full_name ?? 'Student' }}" 
                                     class="relative w-full h-full object-cover rounded-full z-10">
                            @else
                                <i class="fas fa-user text-2xl sm:text-3xl lg:text-4xl text-white relative z-10"></i>
                            @endif
                            <!-- Glow Effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/30 to-teal-500/30 rounded-full blur-xl group-hover:blur-2xl transition-all duration-500"></div>
                        </div>
                        
                        <!-- Enhanced Name -->
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-white mb-2 sm:mb-3 drop-shadow-2xl bg-gradient-to-r from-white to-emerald-100 bg-clip-text text-transparent">
                            {{ $result->student->full_name ?? 'Student Information' }}
                        </h2>
                        
                        <!-- Enhanced Contact Info -->
                        <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 shadow-lg">
                            <i class="fas fa-id-card text-white/80 mr-2 text-sm"></i>
                            <span class="text-white/90 text-xs sm:text-sm font-semibold">
                                {{ $result->student->student_id ?? 'N/A' }}
                                @if($result->student->phone)
                                    <span class="mx-2 text-white/60">•</span>
                                    <i class="fas fa-phone mr-1"></i>{{ $result->student->phone }}
                                @endif
                                @if($result->student->email)
                                    <span class="mx-2 text-white/60">•</span>
                                    <i class="fas fa-envelope mr-1"></i>{{ $result->student->email }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="p-4 sm:p-6 lg:p-8">
                    
                    @if($result->student->course || $result->student->partner)
                    <div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            @if($result->student->partner)
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg sm:rounded-xl p-4 border border-purple-200 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-building text-white text-sm"></i>
                                    </div>
                                    <span class="text-xs font-semibold text-purple-600 uppercase tracking-wide">Institution</span>
                                </div>
                                <div class="text-sm sm:text-base font-bold text-purple-800 leading-tight">{{ $result->student->partner->name ?? 'N/A' }}</div>
                            </div>
                            @endif
                            
                            @if($result->student->course)
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg sm:rounded-xl p-4 border border-blue-200 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-book text-white text-sm"></i>
                                    </div>
                                    <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Course</span>
                                </div>
                                <div class="text-sm sm:text-base font-bold text-blue-800 leading-tight">{{ $result->student->course->name ?? 'N/A' }}</div>
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
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-4 lg:gap-6">
                        <!-- Left Side - Title and Exam Info -->
                        <div class="text-center lg:text-left flex-1">
                            <div class="inline-flex items-center justify-center w-16 h-16 sm:w-18 sm:h-18 lg:w-20 lg:h-20 bg-white/20 backdrop-blur-sm rounded-full shadow-lg mb-3 sm:mb-4">
                                <i class="fas fa-trophy text-xl sm:text-2xl lg:text-3xl text-white"></i>
                            </div>
                            <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-white mb-1 sm:mb-2">Exam Results</h1>
                            <p class="text-blue-100 text-xs sm:text-sm px-2">
                                <span class="inline-flex items-center px-2 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold text-white mr-2">
                                    <i class="fas fa-bookmark mr-1"></i>
                                    Exam:
                                </span>
                                <span class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-yellow-400/30 to-amber-500/30 backdrop-blur-sm rounded-full text-xs sm:text-sm font-bold text-white border border-yellow-300/50 shadow-lg">
                                    {{ $exam->title }}
                                </span>
                            </p>
                        </div>
                        
                        <!-- Right Side - Score Card -->
                        <div class="flex flex-col items-center lg:items-end">
                            <!-- Score Circle -->
                            <div class="inline-flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 bg-gradient-to-br from-white/25 to-white/10 backdrop-blur-md rounded-full shadow-2xl mb-3 relative border-2 border-white/30">
                                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent rounded-full"></div>
                                <div class="relative text-center px-1">
                                    <div class="text-sm sm:text-base lg:text-lg font-bold text-white leading-tight">{{ number_format($result->percentage ?? 0, 1) }}%</div>
                                    <div class="text-xs text-white font-medium leading-none">SCORE</div>
                                </div>
                            </div>
                            
                            <!-- Status Badge -->
                            <div class="inline-flex items-center px-4 sm:px-6 py-2 rounded-full text-xs sm:text-sm font-semibold shadow-lg
                                @if(($result->percentage ?? 0) >= ($exam->passing_marks ?? 50))
                                    bg-gradient-to-r from-green-500 to-emerald-600 text-white border border-green-400/50
                                @else
                                    bg-gradient-to-r from-red-500 to-rose-600 text-white border border-red-400/50
                                @endif">
                                <i class="fas fa-{{ ($result->percentage ?? 0) >= ($exam->passing_marks ?? 50) ? 'check-circle' : 'times-circle' }} mr-2"></i>
                                {{ ($result->percentage ?? 0) >= ($exam->passing_marks ?? 50) ? 'PASSED' : 'FAILED' }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="relative p-4 sm:p-6 lg:p-8">

                    <!-- Performance Stats Grid -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
                        <!-- Total Questions Card -->
                        <div class="group relative bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl p-3 sm:p-4 border border-blue-200/50 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 hover:scale-105 overflow-hidden">
                            <div class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-br from-blue-400/20 to-indigo-500/20 rounded-full -translate-y-6 translate-x-6"></div>
                            <div class="relative">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mb-2 shadow-lg">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="text-xl sm:text-2xl font-black text-blue-800 mb-0.5">{{ $result->total_questions ?? 0 }}</div>
                                <div class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Total Questions</div>
                            </div>
                        </div>
                        
                        <!-- Correct Answers Card -->
                        <div class="group relative bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-3 sm:p-4 border border-green-200/50 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 hover:scale-105 overflow-hidden">
                            <div class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-br from-green-400/20 to-emerald-500/20 rounded-full -translate-y-6 translate-x-6"></div>
                            <div class="relative">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mb-2 shadow-lg">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="text-xl sm:text-2xl font-black text-green-800 mb-0.5">{{ $result->correct_answers ?? 0 }}</div>
                                <div class="text-xs font-semibold text-green-600 uppercase tracking-wide">Correct</div>
                            </div>
                        </div>
                        
                        <!-- Wrong Answers Card -->
                        <div class="group relative bg-gradient-to-br from-red-50 to-rose-100 rounded-xl p-3 sm:p-4 border border-red-200/50 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 hover:scale-105 overflow-hidden">
                            <div class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-br from-red-400/20 to-rose-500/20 rounded-full -translate-y-6 translate-x-6"></div>
                            <div class="relative">
                                <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-rose-600 rounded-lg flex items-center justify-center mb-2 shadow-lg">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="text-xl sm:text-2xl font-black text-red-800 mb-0.5">{{ $result->wrong_answers ?? 0 }}</div>
                                <div class="text-xs font-semibold text-red-600 uppercase tracking-wide">Wrong</div>
                            </div>
                        </div>
                        
                        <!-- Unanswered Card -->
                        <div class="group relative bg-gradient-to-br from-orange-50 to-amber-100 rounded-xl p-3 sm:p-4 border border-orange-200/50 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 hover:scale-105 overflow-hidden">
                            <div class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-br from-orange-400/20 to-amber-500/20 rounded-full -translate-y-6 translate-x-6"></div>
                            <div class="relative">
                                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-amber-600 rounded-lg flex items-center justify-center mb-2 shadow-lg">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="text-xl sm:text-2xl font-black text-orange-800 mb-0.5">{{ $result->unanswered ?? 0 }}</div>
                                <div class="text-xs font-semibold text-orange-600 uppercase tracking-wide">Unanswered</div>
                            </div>
                        </div>
                    </div>
                            
                    <!-- Score Details -->
                    <div class="relative bg-gradient-to-br from-slate-50 to-gray-100 rounded-2xl p-4 sm:p-6 mb-6 sm:mb-8 border border-gray-200/50 shadow-xl overflow-hidden">
                        <!-- Decorative Elements -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-200/20 to-indigo-300/20 rounded-full -translate-y-12 translate-x-12"></div>
                        <div class="absolute bottom-0 left-0 w-20 h-20 bg-gradient-to-tr from-blue-200/20 to-cyan-300/20 rounded-full translate-y-10 -translate-x-10"></div>
                        
                        <div class="relative">
                            <h3 class="text-lg sm:text-xl font-black text-gray-800 mb-4 sm:mb-5 text-center bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                                <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                                Score Details
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                                <!-- Final Score Card -->
                                <div class="group relative bg-gradient-to-br from-purple-50 to-indigo-100 rounded-xl p-3 sm:p-4 border border-purple-200/50 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 hover:scale-105 overflow-hidden">
                                    <div class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-br from-purple-400/20 to-indigo-500/20 rounded-full -translate-y-6 translate-x-6"></div>
                                    <div class="relative text-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center mb-2 shadow-lg mx-auto">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-xl sm:text-2xl font-black text-purple-800 mb-0.5">{{ $result->score ?? 0 }}</div>
                                        <div class="text-xs font-semibold text-purple-600 uppercase tracking-wide">Final Score</div>
                                    </div>
                                </div>
                                
                                <!-- Grade Card -->
                                <div class="group relative bg-gradient-to-br from-emerald-50 to-teal-100 rounded-xl p-3 sm:p-4 border border-emerald-200/50 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 hover:scale-105 overflow-hidden">
                                    <div class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-br from-emerald-400/20 to-teal-500/20 rounded-full -translate-y-6 translate-x-6"></div>
                                    <div class="relative text-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center mb-2 shadow-lg mx-auto">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-xl sm:text-2xl font-black text-emerald-800 mb-0.5">{{ $result->grade ?? 'N/A' }}</div>
                                        <div class="text-xs font-semibold text-emerald-600 uppercase tracking-wide">Grade</div>
                                    </div>
                                </div>
                                
                                <!-- Passing Marks Card -->
                                <div class="group relative bg-gradient-to-br from-amber-50 to-yellow-100 rounded-xl p-3 sm:p-4 border border-amber-200/50 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 hover:scale-105 overflow-hidden">
                                    <div class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-br from-amber-400/20 to-yellow-500/20 rounded-full -translate-y-6 translate-x-6"></div>
                                    <div class="relative text-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-lg flex items-center justify-center mb-2 shadow-lg mx-auto">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-xl sm:text-2xl font-black text-amber-800 mb-0.5">{{ $exam->passing_marks ?? 50 }}%</div>
                                        <div class="text-xs font-semibold text-amber-600 uppercase tracking-wide">Passing Marks</div>
                                    </div>
                                </div>
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
                    <div class="relative bg-gradient-to-br from-indigo-50 via-blue-50 to-cyan-100 rounded-2xl p-4 sm:p-6 mb-6 sm:mb-8 border border-indigo-200/50 shadow-xl overflow-hidden">
                        <!-- Decorative Elements -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-200/20 to-blue-300/20 rounded-full -translate-y-12 translate-x-12"></div>
                        <div class="absolute bottom-0 left-0 w-20 h-20 bg-gradient-to-tr from-cyan-200/20 to-blue-300/20 rounded-full translate-y-10 -translate-x-10"></div>
                        
                        <div class="relative">
                            <h3 class="text-lg sm:text-xl font-black text-gray-800 mb-4 sm:mb-5 text-center bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                                <i class="fas fa-clock text-indigo-500 mr-2"></i>
                                Time Information
                            </h3>
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                                <!-- Started At Card -->
                                <div class="group relative bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-3 sm:p-4 border border-green-200/50 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 hover:scale-105 overflow-hidden">
                                    <div class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-br from-green-400/20 to-emerald-500/20 rounded-full -translate-y-6 translate-x-6"></div>
                                    <div class="relative text-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mb-2 shadow-lg mx-auto">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-xs font-semibold text-green-600 uppercase tracking-wide mb-1">Started At</div>
                                        <div class="text-xs sm:text-sm font-bold text-green-800 leading-tight">{{ $result->started_at ? $result->started_at->format('M d, g:i A') : 'N/A' }}</div>
                                    </div>
                                </div>
                                
                                <!-- Completed At Card -->
                                <div class="group relative bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl p-3 sm:p-4 border border-blue-200/50 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 hover:scale-105 overflow-hidden">
                                    <div class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-br from-blue-400/20 to-indigo-500/20 rounded-full -translate-y-6 translate-x-6"></div>
                                    <div class="relative text-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mb-2 shadow-lg mx-auto">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-xs font-semibold text-blue-600 uppercase tracking-wide mb-1">Completed At</div>
                                        <div class="text-xs sm:text-sm font-bold text-blue-800 leading-tight">{{ $result->completed_at ? $result->completed_at->format('M d, g:i A') : 'N/A' }}</div>
                                    </div>
                                </div>
                                
                                <!-- Time Taken Card -->
                                <div class="group relative bg-gradient-to-br from-purple-50 to-violet-100 rounded-xl p-3 sm:p-4 border border-purple-200/50 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 hover:scale-105 overflow-hidden">
                                    <div class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-br from-purple-400/20 to-violet-500/20 rounded-full -translate-y-6 translate-x-6"></div>
                                    <div class="relative text-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-violet-600 rounded-lg flex items-center justify-center mb-2 shadow-lg mx-auto">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-xs font-semibold text-purple-600 uppercase tracking-wide mb-1">Time Taken</div>
                                        <div class="text-xs sm:text-sm font-bold text-purple-800 leading-tight">
                                            @if($result->started_at && $result->completed_at)
                                                @php
                                                    $totalSeconds = $result->started_at->diffInSeconds($result->completed_at);
                                                    $minutes = floor($totalSeconds / 60);
                                                    $seconds = $totalSeconds % 60;
                                                @endphp
                                                {{ $minutes }}m {{ $seconds }}s
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Time Limit Card -->
                                <div class="group relative bg-gradient-to-br from-amber-50 to-orange-100 rounded-xl p-3 sm:p-4 border border-amber-200/50 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 hover:scale-105 overflow-hidden">
                                    <div class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-br from-amber-400/20 to-orange-500/20 rounded-full -translate-y-6 translate-x-6"></div>
                                    <div class="relative text-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mb-2 shadow-lg mx-auto">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-xs font-semibold text-amber-600 uppercase tracking-wide mb-1">Time Limit</div>
                                        <div class="text-xs sm:text-sm font-bold text-amber-800 leading-tight">{{ $exam->duration ?? 'N/A' }} min</div>
                                    </div>
                                </div>
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
