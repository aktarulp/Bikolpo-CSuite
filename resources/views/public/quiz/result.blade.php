<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Online Test Result - {{ $exam->title }} | Bikolpo Live</title>
    
    <!-- SEO Meta Tags for Social Sharing -->
    <meta name="description" content="I scored {{ number_format($result->percentage ?? 0, 1) }}% on {{ $exam->title }} online test! Check out my performance on Bikolpo Live.">
    <meta name="keywords" content="online test, exam, result, {{ $exam->title }}, Bikolpo Live, education, learning">
    
    <!-- Open Graph Meta Tags for Social Media -->
    <meta property="og:title" content="Online Test Result - {{ $exam->title }} | Bikolpo Live">
    <meta property="og:description" content="I scored {{ number_format($result->percentage ?? 0, 1) }}% on {{ $exam->title }} online test! Check out my performance on Bikolpo Live.">
    <meta property="og:image" content="{{ asset('images/online-test-result-share.png') }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Bikolpo Live">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Online Test Result - {{ $exam->title }} | Bikolpo Live">
    <meta name="twitter:description" content="I scored {{ number_format($result->percentage ?? 0, 1) }}% on {{ $exam->title }} online test! Check out my performance on Bikolpo Live.">
    <meta name="twitter:image" content="{{ asset('images/online-test-result-share.png') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/BikolpoLive.svg') }}">
    <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('images/BikolpoLive.svg') }}">
    


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
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 lg:w-10 lg:h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v2a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v2a1 1 0 11-2 0v-2H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732L14.146 12.8l-1.179 4.456a1 1 0 01-1.934 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732L9.854 7.2l1.179-4.456A1 1 0 0112 2z" clip-rule="evenodd" />
</svg>
                </div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-black text-gray-800 mb-2 sm:mb-3 px-2">
                    Congratulations on completing Bikolpo Live Online Test!
                </h1>
                <div class="mt-3 sm:mt-4 inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full shadow-lg">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
</svg>
                    <span class="text-white font-bold text-sm sm:text-base">Powered by Bikolpo Live</span>
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
                                <svg class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 text-white relative z-10" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
</svg>
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
                            <svg class="w-4 h-4 text-white/80 mr-2" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
</svg>
                            <span class="text-white/90 text-xs sm:text-sm font-semibold">
                                {{ $result->student->student_id ?? 'N/A' }}
                                @if($result->student->phone)
                                    <span class="mx-2 text-white/60">•</span>
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
</svg>{{ $result->student->phone }}
                                @endif
                                @if($result->student->email)
                                    <span class="mx-2 text-white/60">•</span>
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
</svg>{{ $result->student->email }}
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
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
</svg>
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
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
</svg>
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
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 lg:w-10 lg:h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v2a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v2a1 1 0 11-2 0v-2H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732L14.146 12.8l-1.179 4.456a1 1 0 01-1.934 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732L9.854 7.2l1.179-4.456A1 1 0 0112 2z" clip-rule="evenodd" />
</svg>
                            </div>
                            <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-white mb-1 sm:mb-2">Exam Results</h1>
                            <p class="text-blue-100 text-xs sm:text-sm px-2">
                                <span class="inline-flex items-center px-2 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold text-white mr-2">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
</svg>
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
                                @if(($result->percentage ?? 0) >= ($exam->passing_marks ?? 50))
<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
</svg>
@else
<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
</svg>
@endif
                                {{ ($result->percentage ?? 0) >= ($exam->passing_marks ?? 50) ? 'PASSED' : 'FAILED' }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="relative p-4 sm:p-6 lg:p-8">

                    <!-- Performance Stats Grid - Professional Slim Design -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
                        <!-- Total Questions Card -->
                        <div class="group relative bg-white rounded-xl p-3 sm:p-4 border border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <div class="relative">
                                <!-- Top Section - Icon and Label -->
                                <div class="flex items-center mb-2">
                                    <div class="w-6 h-6 bg-blue-500 rounded-md flex items-center justify-center mr-2">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Total Questions</span>
                                </div>
                                
                                <!-- Center Section - Main Number -->
                                <div class="text-center mb-2">
                                    <div class="text-xl sm:text-2xl font-bold text-gray-800">{{ $result->total_questions ?? 0 }}</div>
                                </div>
                                
                                <!-- Bottom Section - Total Marks -->
                                <div class="bg-gray-50 rounded-md p-2 border border-gray-100">
                                    <div class="flex items-center justify-center">
                                        <svg class="w-3 h-3 text-gray-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        <span class="text-xs font-medium text-gray-600 mr-1">Total Marks:</span>
                                        <span class="text-xs font-bold text-gray-800">
                                            @php
                                                $totalMarks = 0;
                                                $questions = $exam->questions()->get();
                                                foreach ($questions as $question) {
                                                    $totalMarks += $question->pivot->marks ?? 1;
                                                }
                                            @endphp
                                            {{ $totalMarks }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Correct Answers Card -->
                        <div class="group relative bg-white rounded-xl p-3 sm:p-4 border border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <div class="relative">
                                <!-- Top Section - Icon and Label -->
                                <div class="flex items-center mb-2">
                                    <div class="w-6 h-6 bg-green-500 rounded-md flex items-center justify-center mr-2">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Correct</span>
                                </div>
                                
                                <!-- Center Section - Main Number -->
                                <div class="text-center mb-2">
                                    <div class="text-xl sm:text-2xl font-bold text-gray-800">{{ $result->correct_answers ?? 0 }}</div>
                                </div>
                                
                                <!-- Bottom Section - Marks Gained -->
                                <div class="bg-gray-50 rounded-md p-2 border border-gray-100">
                                    <div class="flex items-center justify-center">
                                        <svg class="w-3 h-3 text-gray-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        <span class="text-xs font-medium text-gray-600 mr-1">Marks Gained:</span>
                                        <span class="text-xs font-bold text-gray-800">
                                            @php
                                                $correctMarks = 0;
                                                if ($result->correct_answers > 0) {
                                                    $questionStats = \App\Models\QuestionStat::where('exam_result_id', $result->id)
                                                        ->where('is_correct', true)
                                                        ->get();
                                                    
                                                    if ($questionStats->count() > 0) {
                                                        foreach ($questionStats as $stat) {
                                                            $correctMarks += $stat->marks ?? 1;
                                                        }
                                                    } else {
                                                        $avgMarksPerQuestion = ($result->total_marks ?? 0) / ($result->total_questions ?? 1);
                                                        $correctMarks = round($result->correct_answers * $avgMarksPerQuestion);
                                                    }
                                                }
                                            @endphp
                                            {{ $correctMarks }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Wrong Answers Card -->
                        <div class="group relative bg-white rounded-xl p-3 sm:p-4 border border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <div class="relative">
                                <!-- Top Section - Icon and Label -->
                                <div class="flex items-center mb-2">
                                    <div class="w-6 h-6 bg-red-500 rounded-md flex items-center justify-center mr-2">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Wrong</span>
                                </div>
                                
                                <!-- Center Section - Main Number -->
                                <div class="text-center mb-2">
                                    <div class="text-xl sm:text-2xl font-bold text-gray-800">{{ $result->wrong_answers ?? 0 }}</div>
                                </div>
                                
                                <!-- Bottom Section - Deduction -->
                                <div class="bg-gray-50 rounded-md p-2 border border-gray-100">
                                    <div class="flex items-center justify-center">
                                        <svg class="w-3 h-3 text-gray-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m16 0l-4-4m4 4l-4 4M4 12l4-4m-4 4l4 4"></path>
                                        </svg>
                                        <span class="text-xs font-medium text-gray-600 mr-1">Deduction:</span>
                                        <span class="text-xs font-bold text-gray-800">
                                            @php
                                                $wrongMarks = 0;
                                                if ($result->wrong_answers > 0 && $exam->has_negative_marking) {
                                                    $wrongMarks = $result->wrong_answers * ($exam->negative_marks_per_question ?? 0);
                                                }
                                            @endphp
                                            -{{ $wrongMarks }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Skipped Card -->
                        <div class="group relative bg-white rounded-xl p-3 sm:p-4 border border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <div class="relative">
                                <!-- Top Section - Icon and Label -->
                                <div class="flex items-center mb-2">
                                    <div class="w-6 h-6 bg-orange-500 rounded-md flex items-center justify-center mr-2">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Skipped</span>
                                </div>
                                
                                <!-- Center Section - Main Number -->
                                <div class="text-center mb-2">
                                    <div class="text-xl sm:text-2xl font-bold text-gray-800">{{ $result->unanswered ?? 0 }}</div>
                                </div>
                                
                                <!-- Bottom Section - Missed -->
                                <div class="bg-gray-50 rounded-md p-2 border border-gray-100">
                                    <div class="flex items-center justify-center">
                                        <svg class="w-3 h-3 text-gray-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-xs font-medium text-gray-600 mr-1">Missed:</span>
                                        <span class="text-xs font-bold text-gray-800">
                                            @php
                                                $unansweredMarks = 0;
                                                if ($result->unanswered > 0) {
                                                    $questionStats = \App\Models\QuestionStat::where('exam_result_id', $result->id)
                                                        ->where('is_skipped', true)
                                                        ->get();
                                                    
                                                    if ($questionStats->count() > 0) {
                                                        foreach ($questionStats as $stat) {
                                                            $unansweredMarks += $stat->marks ?? 1;
                                                        }
                                                    } else {
                                                        $avgMarksPerQuestion = ($result->total_marks ?? 0) / ($result->total_questions ?? 1);
                                                        $unansweredMarks = round($result->unanswered * $avgMarksPerQuestion);
                                                    }
                                                }
                                            @endphp
                                            {{ $unansweredMarks }}
                                        </span>
                                    </div>
                                </div>
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

                    <!-- Social Media Sharing Section -->
                    <div class="bg-blue-50 rounded-lg sm:rounded-xl p-4 sm:p-6 mb-6 sm:mb-8 border border-blue-200">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-2 sm:mb-3 text-center">Share Your Achievement</h3>
                        <p class="text-xs sm:text-sm text-gray-600 text-center mb-3 sm:mb-4 px-2">Let your friends know about your performance and inspire them to try Bikolpo Live!</p>
                        
                        <div class="grid grid-cols-2 sm:flex sm:flex-wrap justify-center gap-2 sm:gap-3">
                            <!-- Facebook Share -->
                            <button onclick="shareOnFacebook()" class="flex items-center justify-center px-3 sm:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="currentColor" viewBox="0 0 24 24">
    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12z"/>
</svg>
                                <span class="hidden sm:inline">Facebook</span>
                                <span class="sm:hidden">FB</span>
                            </button>
                            
                            <!-- WhatsApp Share -->
                            <button onclick="shareOnWhatsApp()" class="flex items-center justify-center px-3 sm:px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs sm:text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="currentColor" viewBox="0 0 24 24">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
</svg>
                                <span class="hidden sm:inline">WhatsApp</span>
                                <span class="sm:hidden">WA</span>
                            </button>
                            
                            <!-- X (Twitter) Share -->
                            <button onclick="shareOnTwitter()" class="flex items-center justify-center px-3 sm:px-4 py-2 bg-black hover:bg-gray-800 text-white text-xs sm:text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="currentColor" viewBox="0 0 24 24">
    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
</svg>
                                <span class="hidden sm:inline">Share on X</span>
                                <span class="sm:hidden">X</span>
                            </button>
                            
                            <!-- Copy Link -->
                            <button onclick="copyToClipboard()" class="flex items-center justify-center px-3 sm:px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-xs sm:text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
</svg>
                                <span class="hidden sm:inline">Copy Link</span>
                                <span class="sm:hidden">Copy</span>
                            </button>
                        </div>
                    </div>

                    <!-- Performance Insights -->
                    <div class="bg-gradient-to-r from-amber-50 via-orange-50 to-red-50 rounded-lg sm:rounded-2xl p-4 sm:p-6 mb-6 sm:mb-8 border border-amber-200 shadow-lg">
                        <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800 mb-4 sm:mb-6 text-center flex items-center justify-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-600 mr-2 sm:mr-3" fill="currentColor" viewBox="0 0 20 20">
    <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z" />
</svg>
                            Performance Insights
                        </h3>
                        <div class="space-y-3 sm:space-y-4">
                            @if(($result->percentage ?? 0) >= 90)
                                <div class="flex items-start sm:items-center p-3 sm:p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg sm:rounded-xl border border-green-200 shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8 text-green-600 mr-3 sm:mr-4 mt-1 sm:mt-0 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
</svg>
                                    <span class="text-green-800 font-semibold text-sm sm:text-base lg:text-lg">Outstanding performance! You've mastered this material with exceptional understanding.</span>
                                </div>
                            @elseif(($result->percentage ?? 0) >= 80)
                                <div class="flex items-start sm:items-center p-3 sm:p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg sm:rounded-xl border border-blue-200 shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8 text-blue-600 mr-3 sm:mr-4 mt-1 sm:mt-0 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
</svg>
                                    <span class="text-blue-800 font-semibold text-sm sm:text-base lg:text-lg">Excellent work! You have a solid understanding of the subject matter.</span>
                                </div>
                            @elseif(($result->percentage ?? 0) >= 70)
                                <div class="flex items-start sm:items-center p-3 sm:p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg sm:rounded-xl border border-yellow-200 shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8 text-yellow-600 mr-3 sm:mr-4 mt-1 sm:mt-0 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
</svg>
                                    <span class="text-yellow-800 font-semibold text-sm sm:text-base lg:text-lg">Good job! Consider reviewing areas where you struggled for improvement.</span>
                                </div>
                            @else
                                <div class="flex items-start sm:items-center p-3 sm:p-4 bg-gradient-to-r from-red-50 to-red-100 rounded-lg sm:rounded-xl border border-red-200 shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8 text-red-600 mr-3 sm:mr-4 mt-1 sm:mt-0 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
</svg>
                                    <span class="text-red-800 font-semibold text-sm sm:text-base lg:text-lg">Keep practicing! Review the material thoroughly and try again for better results.</span>
                                </div>
                            @endif
                            
                            @if(isset($result->unanswered) && $result->unanswered > 0)
                                <div class="flex items-start sm:items-center p-3 sm:p-4 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg sm:rounded-xl border border-orange-200 shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8 text-orange-600 mr-3 sm:mr-4 mt-1 sm:mt-0 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
</svg>
                                    <span class="text-orange-800 font-semibold text-sm sm:text-base lg:text-lg">You left {{ $result->unanswered }} question(s) unanswered. Try to answer all questions next time for maximum points.</span>
                                </div>
                            @endif

                            @if(isset($exam->has_negative_marking) && $exam->has_negative_marking && $result->wrong_answers > 0)
                                <div class="flex items-start sm:items-center p-3 sm:p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg sm:rounded-xl border border-purple-200 shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8 text-purple-600 mr-3 sm:mr-4 mt-1 sm:mt-0 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
</svg>
                                    <span class="text-purple-800 font-semibold text-sm sm:text-base lg:text-lg">This quiz has negative marking. Each wrong answer deducts {{ $exam->negative_marks_per_question ?? 0.25 }} marks.</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-center">
                        <a href="{{ route('public.quiz.review', ['exam' => $exam->id, 'result' => $result->id]) }}" 
                           class="flex-1 sm:flex-none flex justify-center items-center py-3 px-4 sm:px-6 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
    <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" />
</svg>
                            <span class="text-sm sm:text-base">Review Answers</span>
                        </a>
                        
                        <a href="{{ route('public.quiz.access') }}" 
                           class="flex-1 sm:flex-none flex justify-center items-center py-3 px-4 sm:px-6 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
</svg>
                            <span class="text-sm sm:text-base">Take Another Test</span>
                        </a>
                        
                        <button onclick="window.print()" 
                                class="flex-1 sm:flex-none flex justify-center items-center py-3 px-4 sm:px-6 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
</svg>
                            <span class="text-sm sm:text-base">Download Result</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center text-gray-600 mb-4 sm:mb-6 lg:mb-8">
                <div class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full shadow-lg">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
</svg>
                    <span class="text-white font-semibold text-sm sm:text-base">Powered by Bikolpo Live</span>
                </div>
                <p class="text-xs sm:text-sm mt-3 sm:mt-4 text-gray-500 px-2">
                    Report generated on {{ now()->format('M d, Y g:i A') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
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
            const text = encodeURIComponent(`I scored {{ number_format($result->percentage ?? 0, 1) }}% on {{ $exam->title }} online test! Check out my performance on Bikolpo Live.`);
            const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${text}`;
            window.open(facebookUrl, '_blank', 'width=600,height=400');
        }
        
        function shareOnWhatsApp() {
            const text = `I scored {{ number_format($result->percentage ?? 0, 1) }}% on {{ $exam->title }} online test! Check out my performance on Bikolpo Live. ${window.location.href}`;
            const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(text)}`;
            window.open(whatsappUrl, '_blank');
        }
        
        function shareOnTwitter() {
            const text = `I scored {{ number_format($result->percentage ?? 0, 1) }}% on {{ $exam->title }} online test! Check out my performance on Bikolpo Live.`;
            const url = window.location.href;
            const twitterUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
            window.open(twitterUrl, '_blank', 'width=600,height=400');
        }
        
        function copyToClipboard() {
            const text = `I scored {{ number_format($result->percentage ?? 0, 1) }}% on {{ $exam->title }} online test! Check out my performance on Bikolpo Live. ${window.location.href}`;
            
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
