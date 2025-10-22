<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <title>Live Online Exam Platform - Bikolpo Live | Smart Exam System</title>
    <meta name="description" content="Join live online exams with Bikolpo Live. Professional, secure, and user-friendly exam platform. Access your exams with phone number and access code. Real-time monitoring and instant results.">
    <meta name="keywords" content="live exam, online exam, digital assessment, exam platform, Bikolpo Live, online testing, secure exam, real-time exam">
    <meta name="author" content="Bikolpo Live">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Live Online Exam Platform - Bikolpo Live">
    <meta property="og:description" content="Professional online exam platform with real-time monitoring and instant results. Secure, user-friendly, and accessible from anywhere.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/BikolpoLive.svg') }}">
    <meta property="og:site_name" content="Bikolpo Live">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Live Online Exam Platform - Bikolpo Live">
    <meta name="twitter:description" content="Professional online exam platform with real-time monitoring and instant results.">
    <meta name="twitter:image" content="{{ asset('images/BikolpoLive.svg') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/BikolpoLive.svg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/BikolpoLive.svg') }}">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "Bikolpo Live Exam Platform",
        "description": "Professional online exam platform with real-time monitoring and instant results",
        "url": "{{ url()->current() }}",
        "applicationCategory": "EducationalApplication",
        "operatingSystem": "Web Browser",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "BDT"
        },
        "provider": {
            "@type": "Organization",
            "name": "Bikolpo Live",
            "url": "{{ config('app.url') }}",
            "logo": "{{ asset('images/BikolpoLive.svg') }}"
        }
    }
    </script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 font-sans antialiased">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="w-full h-full" style="background-image: radial-gradient(circle at 1px 1px, rgba(59, 130, 246, 0.3) 1px, transparent 0); background-size: 20px 20px;"></div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-blue-200 rounded-full opacity-20 animate-pulse"></div>
    <div class="absolute top-32 right-20 w-16 h-16 bg-indigo-200 rounded-full opacity-30 animate-bounce"></div>
    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-purple-200 rounded-full opacity-25 animate-pulse"></div>
    
    <!-- Main Container -->
    <div class="relative z-10 min-h-screen flex items-center justify-center px-4 py-4">
        <div class="w-full max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl border-2 border-blue-200/50 mb-4 relative overflow-hidden">
                    <!-- Animated background gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 via-indigo-500/20 to-purple-500/20 animate-pulse"></div>
                    <!-- Logo container with enhanced visibility -->
                    <div class="relative z-10 bg-white/80 rounded-2xl p-2 shadow-lg">
                        <img src="{{ asset('images/BikolpoLive.svg') }}" alt="Bikolpo Live Logo" class="h-12 w-12 object-contain drop-shadow-lg">
                    </div>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">Live Exam</span>
                    <span class="text-gray-800">Platform</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Professional, secure, and user-friendly online examination system
                </p>
            </div>
            
            <!-- Main Content Grid -->
            <div class="grid lg:grid-cols-2 gap-8 items-start">
                <!-- Left Column - Features & Information -->
                <div class="order-1 lg:order-1">
                    <div class="space-y-6">
                        <!-- Features Section -->
                        <div class="bg-white/60 backdrop-blur-sm rounded-3xl p-6 border border-white/20 shadow-xl">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Platform Features</h3>
                            <div class="grid gap-4">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 text-sm">Real-time Monitoring</h4>
                                        <p class="text-gray-600 text-xs">Advanced proctoring with live monitoring</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 text-sm">Instant Results</h4>
                                        <p class="text-gray-600 text-xs">Get immediate feedback and analytics</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 text-sm">Secure Platform</h4>
                                        <p class="text-gray-600 text-xs">Enterprise-grade security</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 text-sm">Mobile Optimized</h4>
                                        <p class="text-gray-600 text-xs">Works on all devices</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Instructions Section -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl p-6 border border-blue-100">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">How to Access</h3>
                            <ol class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 w-5 h-5 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3 mt-0.5">1</span>
                                    <span>Enter your registered mobile number</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 w-5 h-5 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3 mt-0.5">2</span>
                                    <span>Input the 6-digit access code from your instructor</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 w-5 h-5 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3 mt-0.5">3</span>
                                    <span>Click "Start Live Exam" to begin your assessment</span>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Access Form -->
                <div class="order-2 lg:order-2">
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl p-6 md:p-8 border border-white/20">
                        <div class="text-center mb-6">
                            <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-2">Join Your Exam</h2>
                            <p class="text-gray-600 text-sm">Enter your credentials to access the exam</p>
                        </div>
                        
                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-400 rounded-xl">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-red-700 font-semibold text-sm">Please check your details</p>
                                </div>
                                <ul class="text-xs text-red-600 mt-1 list-disc list-inside ml-6">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Access Form -->
                        <form method="POST" action="{{ route('public.quiz.process-access') }}" class="space-y-4" novalidate>
                            @csrf
                            
                            <!-- Phone Number Field -->
                            <div class="space-y-1">
                                <label for="phone" class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                        </svg>
                                        Phone Number
                                    </span>
                                </label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}"
                                       placeholder="017xxxxxxxx"
                                       pattern="01[3-9][0-9]{8}"
                                       maxlength="11"
                                       required
                                       autocomplete="tel"
                                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 text-gray-800 text-base transition-all duration-200 shadow-sm hover:shadow-md">
                                <p class="text-xs text-gray-500">Enter your 11-digit mobile number</p>
                            </div>
                            
                            <!-- Access Code Field -->
                            <div class="space-y-1">
                                <label for="access_code" class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Access Code
                                    </span>
                                </label>
                                <input type="text" 
                                       id="access_code" 
                                       name="access_code" 
                                       value="{{ old('access_code') }}"
                                       placeholder="6-digit code"
                                       maxlength="6"
                                       pattern="[0-9]{6}"
                                       required
                                       autocomplete="off"
                                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-gray-800 text-center tracking-widest text-lg font-mono transition-all duration-200 shadow-sm hover:shadow-md">
                                <p class="text-xs text-gray-500">Enter the 6-digit access code provided by your instructor</p>
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-2 text-base">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Start Live Exam
                            </button>
                        </form>
                        
                        <!-- Additional Options -->
                        <div class="mt-6 text-center">
                            <button type="button"
                                    onclick="handleMultipleExams()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg border border-gray-200 transition-all duration-200 hover:shadow-md text-sm">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                View All Available Exams
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="relative z-10 bg-white/80 backdrop-blur-sm border-t border-gray-200 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-gray-600 text-sm">
                © {{ date('Y') }} Bikolpo Live. All rights reserved. | 
                <a href="#" class="text-blue-600 hover:text-blue-800 transition-colors">Privacy Policy</a> | 
                <a href="#" class="text-blue-600 hover:text-blue-800 transition-colors">Terms of Service</a>
            </p>
        </div>
    </footer>
    
    <script>
        // Enhanced form validation and UX
        document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.getElementById('phone');
            const accessCodeInput = document.getElementById('access_code');
            const form = document.querySelector('form');
            
            // Phone number formatting
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);
                e.target.value = value;
            });
            
            // Access code formatting
            accessCodeInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 6) value = value.slice(0, 6);
                e.target.value = value;
            });
            
            // Form submission with loading state
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                `;
            });
        });
        
        function handleMultipleExams() {
            // Redirect to available exams page
            window.location.href = "{{ route('public.quiz.available') }}";
        }
    </script>
</body>
</html>