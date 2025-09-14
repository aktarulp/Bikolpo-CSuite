<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Live Exam Access - {{ config('app.name', 'Bikolpo LQ') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .slide-up {
            animation: slideUp 0.8s ease-out;
        }
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .pulse-glow {
            animation: pulseGlow 2s infinite;
        }
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(99, 102, 241, 0.3); }
            50% { box-shadow: 0 0 40px rgba(99, 102, 241, 0.6); }
        }
        .mobile-card {
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        .desktop-card {
            border-radius: 32px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.12);
        }
        .input-focus {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.2);
        }
        .btn-primary-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.4);
        }
        .error-card {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border: 1px solid #f87171;
        }
        .success-card {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border: 1px solid #34d399;
        }
        .info-card {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border: 1px solid #60a5fa;
        }
        .feature-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .mobile-feature-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body class="min-h-screen gradient-bg font-sans">
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl floating-animation"></div>
        <div class="absolute top-40 right-10 w-96 h-96 bg-purple-300/20 rounded-full blur-3xl floating-animation" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 left-1/3 w-80 h-80 bg-blue-300/20 rounded-full blur-3xl floating-animation" style="animation-delay: 4s;"></div>
        <div class="absolute bottom-40 right-1/3 w-64 h-64 bg-indigo-300/20 rounded-full blur-3xl floating-animation" style="animation-delay: 1s;"></div>
    </div>

    <!-- Navigation -->
    @include('navigation-layout')

    <!-- Main Content -->
    <div class="relative min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-7xl mx-auto">
            
            <!-- Header Section -->
            <div class="text-center mb-8 slide-up">
                <div class="inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 mb-6 bg-white/20 rounded-full backdrop-blur-sm">
                    <img src="{{ asset('images/Bikolpo_LQ_Transparent.png') }}" 
                         alt="{{ config('app.name', 'Bikolpo LQ') }}" 
                         class="w-12 h-12 md:w-16 md:h-16 object-contain">
                </div>
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 leading-tight">
                    Live Exam Portal
                </h1>
                <div class="flex items-center justify-center space-x-3 mb-6">
                    <div class="flex items-center space-x-2 bg-green-500/20 px-4 py-2 rounded-full backdrop-blur-sm">
                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                        <span class="text-green-100 text-sm font-semibold">LIVE</span>
                    </div>
                    <span class="text-white/70 text-sm">Real-time examinations</span>
                </div>
            </div>

            <!-- Main Card -->
            <div class="mobile-card md:desktop-card mx-auto max-w-2xl p-6 md:p-10 slide-up">
                
                <!-- Enhanced Error Messages -->
                @if ($errors->any())
                    <div class="mb-8 error-card rounded-2xl p-6 slide-up">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-red-800 mb-3">Access Denied</h3>
                                <div class="space-y-2">
                                    @foreach ($errors->all() as $error)
                                        <div class="flex items-start space-x-3">
                                            <i class="fas fa-times-circle text-red-600 mt-1 flex-shrink-0"></i>
                                            <p class="text-red-700 text-sm leading-relaxed">{{ $error }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 p-4 bg-red-50/50 rounded-xl">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <i class="fas fa-lightbulb text-red-600"></i>
                                        <span class="text-sm font-semibold text-red-800">Need Help?</span>
                                    </div>
                                    <p class="text-xs text-red-600">
                                        Double-check your credentials. Contact your teacher if the problem persists.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Success Messages -->
                @if (session('success'))
                    <div class="mb-8 success-card rounded-2xl p-6 slide-up">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-circle text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-green-800">Success</h3>
                                <p class="text-green-700 text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Info Messages -->
                @if (session('info'))
                    <div class="mb-8 info-card rounded-2xl p-6 slide-up">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-info-circle text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-blue-800">Information</h3>
                                <p class="text-blue-700 text-sm">{{ session('info') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Form Section -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl mb-4 pulse-glow">
                        <i class="fas fa-key text-white text-xl md:text-2xl"></i>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Access Your Exam</h2>
                    <p class="text-gray-600 text-sm md:text-base">Enter your credentials to start your live examination</p>
                </div>

                <!-- Access Form -->
                <form method="POST" action="{{ route('public.quiz.process-access') }}" class="space-y-6" id="accessForm">
                    @csrf
                    
                    <!-- Phone Number Input -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Phone Number</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   class="input-focus w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-gray-50/50 text-lg font-medium" 
                                   placeholder="01712345678"
                                   pattern="01[3-9][0-9]{8}"
                                   maxlength="11"
                                   required>
                        </div>
                        <p class="text-xs text-gray-500">11-digit Bangladeshi mobile number</p>
                    </div>

                    <!-- Access Code Input -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Access Code</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   id="access_code" 
                                   name="access_code" 
                                   value="{{ old('access_code') }}"
                                   class="input-focus w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-gray-50/50 text-lg font-mono tracking-widest text-center" 
                                   placeholder="123456"
                                   maxlength="6"
                                   pattern="[0-9]{6}"
                                   required>
                        </div>
                        <p class="text-xs text-gray-500">6-digit code from your teacher</p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="btn-primary-modern w-full py-4 px-6 text-white font-bold rounded-2xl shadow-lg text-lg">
                        <span class="flex items-center justify-center">
                            <i class="fas fa-rocket mr-3"></i>
                            Start Live Exam
                            <i class="fas fa-arrow-right ml-3"></i>
                        </span>
                    </button>

                    <!-- Fallback Submit Button -->
                    <button type="button" 
                            id="fallbackSubmit"
                            class="hidden w-full py-4 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg text-lg transition-all duration-200">
                        <span class="flex items-center justify-center">
                            <i class="fas fa-refresh mr-3"></i>
                            Retry Access
                        </span>
                    </button>

                    <!-- Multiple Exams Button -->
                    <div class="text-center pt-4">
                        <button type="button" 
                                onclick="handleMultipleExams()"
                                class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-800 rounded-xl border border-gray-200 hover:border-gray-300 transition-all duration-200 font-medium text-sm">
                            <i class="fas fa-list mr-2"></i>
                            View All Available Exams
                        </button>
                    </div>
                </form>
            </div>

            <!-- Features Section -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="glass-effect rounded-2xl p-6 text-center slide-up">
                    <div class="mobile-feature-icon md:feature-icon mx-auto mb-4">
                        <i class="fas fa-shield-alt text-white text-lg md:text-xl"></i>
                    </div>
                    <h3 class="font-bold text-white mb-2 text-sm md:text-base">Secure Platform</h3>
                    <p class="text-white/80 text-xs md:text-sm">Your data is protected with enterprise-grade security</p>
                </div>
                
                <div class="glass-effect rounded-2xl p-6 text-center slide-up" style="animation-delay: 0.2s;">
                    <div class="mobile-feature-icon md:feature-icon mx-auto mb-4">
                        <i class="fas fa-clock text-white text-lg md:text-xl"></i>
                    </div>
                    <h3 class="font-bold text-white mb-2 text-sm md:text-base">Real-time Results</h3>
                    <p class="text-white/80 text-xs md:text-sm">Get instant feedback on your performance</p>
                </div>
                
                <div class="glass-effect rounded-2xl p-6 text-center slide-up" style="animation-delay: 0.4s;">
                    <div class="mobile-feature-icon md:feature-icon mx-auto mb-4">
                        <i class="fas fa-mobile-alt text-white text-lg md:text-xl"></i>
                    </div>
                    <h3 class="font-bold text-white mb-2 text-sm md:text-base">Mobile Friendly</h3>
                    <p class="text-white/80 text-xs md:text-sm">Optimized for all devices and screen sizes</p>
                </div>
            </div>

            <!-- Instructions Section -->
            <div class="mt-12 max-w-4xl mx-auto">
                <div class="glass-effect rounded-2xl p-6 md:p-8 slide-up">
                    <h3 class="text-xl md:text-2xl font-bold text-white mb-6 text-center">How to Access Your Exam</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-4">
                                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <span class="text-white font-bold text-sm">1</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white mb-1">Enter Phone Number</h4>
                                    <p class="text-white/80 text-sm">Use your 11-digit mobile number (e.g., 01712345678)</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-4">
                                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <span class="text-white font-bold text-sm">2</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white mb-1">Enter Access Code</h4>
                                    <p class="text-white/80 text-sm">Use the 6-digit code provided by your teacher</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-start space-x-4">
                                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <span class="text-white font-bold text-sm">3</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white mb-1">Click Start Exam</h4>
                                    <p class="text-white/80 text-sm">Begin your live examination immediately</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-4">
                                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <span class="text-white font-bold text-sm">4</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white mb-1">Get Results</h4>
                                    <p class="text-white/80 text-sm">View your performance instantly after completion</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-12 text-center">
                <p class="text-white/60 text-sm">
                    © {{ date('Y') }} {{ config('app.name', 'Bikolpo LQ') }}. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Enhanced error message display function
        function showErrorMessage(message) {
            const existingError = document.querySelector('.dynamic-error-message');
            if (existingError) {
                existingError.remove();
            }
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'dynamic-error-message mb-8 error-card rounded-2xl p-6 slide-up';
            errorDiv.innerHTML = `
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-red-800 mb-2">Access Error</h3>
                        <p class="text-red-700 text-sm leading-relaxed">${message}</p>
                        <div class="mt-4 p-4 bg-red-50/50 rounded-xl">
                            <div class="flex items-center space-x-2 mb-2">
                                <i class="fas fa-lightbulb text-red-600"></i>
                                <span class="text-sm font-semibold text-red-800">Need Help?</span>
                            </div>
                            <p class="text-xs text-red-600">
                                Double-check your credentials. Contact your teacher if the problem persists.
                            </p>
                        </div>
                    </div>
                </div>
            `;
            
            const form = document.getElementById('accessForm');
            form.parentNode.insertBefore(errorDiv, form);
            
            errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.remove();
                }
            }, 10000);
        }

        // Phone number formatting and validation
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 11) {
                value = value.substring(0, 11);
            }
            
            if (value.length >= 2 && value.substring(0, 2) !== '01') {
                value = '01' + value.substring(2);
            }
            
            if (value.length >= 3) {
                const secondDigit = parseInt(value.charAt(2));
                if (secondDigit < 3 || secondDigit > 9) {
                    value = value.substring(0, 2) + '3' + value.substring(3);
                }
            }
            
            e.target.value = value;
            
            const existingError = document.querySelector('.dynamic-error-message');
            if (existingError) {
                existingError.remove();
            }
        });

        // Access code formatting
        document.getElementById('access_code').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
            
            const existingError = document.querySelector('.dynamic-error-message');
            if (existingError) {
                existingError.remove();
            }
        });

        // Real-time validation
        document.getElementById('phone').addEventListener('blur', function(e) {
            const phone = e.target.value;
            if (phone.length > 0 && phone.length !== 11) {
                showErrorMessage('Phone number must be exactly 11 digits. Please enter a valid Bangladeshi mobile number.');
            } else if (phone.length === 11 && !phone.startsWith('01')) {
                showErrorMessage('Phone number must start with 01. Please enter a valid Bangladeshi mobile number.');
            } else if (phone.length === 11 && phone.startsWith('01')) {
                const secondDigit = parseInt(phone.charAt(2));
                if (secondDigit < 3 || secondDigit > 9) {
                    showErrorMessage('Invalid phone number. The third digit must be between 3-9 for Bangladeshi mobile numbers.');
                }
            }
        });

        document.getElementById('access_code').addEventListener('blur', function(e) {
            const accessCode = e.target.value;
            if (accessCode.length > 0 && accessCode.length !== 6) {
                showErrorMessage('Access code must be exactly 6 digits. Please enter the code provided by your teacher.');
            }
        });

        // CSRF token refresh
        function refreshCSRFToken() {
            return fetch('{{ route("public.quiz.access") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newToken = doc.querySelector('meta[name="csrf-token"]').getAttribute('content');
                document.querySelector('meta[name="csrf-token"]').setAttribute('content', newToken);
                document.querySelector('input[name="_token"]').value = newToken;
                return newToken;
            })
            .catch(error => {
                console.error('Error refreshing CSRF token:', error);
                return null;
            });
        }

        // Form submission with enhanced error handling
        document.getElementById('accessForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>Processing...';
            submitButton.disabled = true;
            
            const submitForm = () => {
                const formData = new FormData(form);
                return fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
            };
            
            const handleResponse = (response) => {
                if (response.status === 419) {
                    return refreshCSRFToken().then(() => {
                        return submitForm();
                    }).then(handleResponse);
                }
                
                if (response.ok) {
                    if (response.redirected) {
                        window.location.href = response.url;
                    } else {
                        return response.json().then(data => {
                            if (data.success && data.redirect) {
                                window.location.href = data.redirect;
                            } else {
                                window.location.href = response.url;
                            }
                        }).catch(() => {
                            window.location.href = response.url;
                        });
                    }
                } else {
                    return response.json().then(data => {
                        if (data.message) {
                            showErrorMessage(data.message);
                        } else {
                            showErrorMessage('An error occurred while processing your request. Please try again.');
                        }
                    }).catch(() => {
                        return response.text().then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const errorElement = doc.querySelector('.text-red-700, .text-red-600, .alert-danger');
                            if (errorElement) {
                                showErrorMessage(errorElement.textContent.trim());
                            } else {
                                showErrorMessage('An error occurred. Please try again.');
                            }
                        });
                    });
                }
            };
            
            submitForm()
            .then(handleResponse)
            .catch(error => {
                console.error('Error:', error);
                showErrorMessage('An unexpected error occurred. Please try again or use the fallback button below.');
                document.getElementById('fallbackSubmit').classList.remove('hidden');
            })
            .finally(() => {
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        });

        // Fallback submit handler
        document.getElementById('fallbackSubmit').addEventListener('click', function() {
            document.querySelector('button[type="submit"]').classList.add('hidden');
            this.classList.remove('hidden');
            document.getElementById('accessForm').submit();
        });

        // Multiple exams handling
        function handleMultipleExams() {
            const phone = document.getElementById('phone').value;
            const accessCode = document.getElementById('access_code').value;
            
            if (!phone || !accessCode) {
                showErrorMessage('Please enter both phone number and access code first.');
                return;
            }
            
            if (phone.length !== 11) {
                showErrorMessage('Please enter a valid 11-digit phone number starting with 01.');
                return;
            }
            
            if (accessCode.length !== 6) {
                showErrorMessage('Please enter a valid 6-digit access code.');
                return;
            }
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("public.quiz.multiple-exams") }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            
            const phoneInput = document.createElement('input');
            phoneInput.type = 'hidden';
            phoneInput.name = 'phone';
            phoneInput.value = phone;
            form.appendChild(phoneInput);
            
            const accessCodeInput = document.createElement('input');
            accessCodeInput.type = 'hidden';
            accessCodeInput.name = 'access_code';
            accessCodeInput.value = accessCode;
            form.appendChild(accessCodeInput);
            
            document.body.appendChild(form);
            form.submit();
        }

        // Add loading animation to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.slide-up');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>