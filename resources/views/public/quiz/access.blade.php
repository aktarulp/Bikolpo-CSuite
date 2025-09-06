<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Live Exam Access - Bikolpo LQ</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        bangla: ['"Hind Siliguri"', 'sans-serif']
                    },
                    colors: {
                        primaryGreen: '#16a34a',
                        primaryOrange: '#f97316',
                        primaryBlue: '#3b82f6',
                        primaryPurple: '#8b5cf6'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'bounce-slow': 'bounce 2s infinite',
                        'pulse-slow': 'pulse 3s infinite'
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 font-bangla">
    @include('navigation-layout')
    
    <!-- Enhanced Background Decorative Elements -->
  <div class="fixed inset-0 overflow-hidden pointer-events-none">
    <!-- Large floating orbs -->
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-200/30 to-transparent rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-purple-200/30 to-transparent rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 left-1/4 w-40 h-40 bg-gradient-to-r from-indigo-200/20 to-transparent rounded-full blur-2xl animate-pulse"></div>
    
    <!-- Additional abstract shapes -->
    <div class="absolute top-20 left-20 w-32 h-32 bg-gradient-to-br from-pink-200/20 to-transparent rounded-full blur-xl animate-bounce"></div>
    <div class="absolute bottom-20 right-20 w-24 h-24 bg-gradient-to-tl from-yellow-200/20 to-transparent rounded-full blur-lg animate-pulse"></div>
    
    <!-- Geometric shapes -->
    <div class="absolute top-1/3 right-1/4 w-16 h-16 bg-gradient-to-r from-cyan-200/30 to-transparent rotate-45 blur-md"></div>
    <div class="absolute bottom-1/3 left-1/3 w-20 h-20 bg-gradient-to-l from-emerald-200/30 to-transparent rotate-12 blur-md"></div>
    
    <!-- Floating dots -->
    <div class="absolute top-1/4 right-1/3 w-3 h-3 bg-blue-300/40 rounded-full animate-ping"></div>
    <div class="absolute bottom-1/4 left-1/4 w-2 h-2 bg-purple-300/40 rounded-full animate-ping" style="animation-delay: 1s;"></div>
    <div class="absolute top-3/4 right-1/2 w-2.5 h-2.5 bg-indigo-300/40 rounded-full animate-ping" style="animation-delay: 2s;"></div>
  </div>

  <!-- Main Content -->
  <div class="relative py-8 px-4">
    
    <!-- Welcome Section -->
    <div class="w-full max-w-6xl mx-auto text-left mb-12">
      <div class="flex items-center space-x-4 mb-6">
        <div class="relative">
          <div class="w-32 h-32 flex items-center justify-center p-2">
            <img src="{{ asset('images/Bikolpo_LQ_Transparent.png') }}" 
                 alt="Bikolpo LQ Logo" 
                 class="h-full w-auto object-contain">
          </div>
          <!-- Live indicator -->
          <div class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center animate-ping">
            <div class="w-3 h-3 bg-white rounded-full animate-pulse"></div>
          </div>
        </div>
        <div>
          <h1 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-primaryGreen via-primaryBlue to-primaryPurple bg-clip-text text-transparent leading-tight">
            Welcome to Live Exam Portal
          </h1>
          <div class="flex items-center space-x-2 mt-2">
            <div class="flex items-center space-x-1">
              <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
              <span class="text-sm font-semibold text-green-600">LIVE</span>
            </div>
            <span class="text-sm text-gray-500">•</span>
            <span class="text-sm text-gray-500">Real-time examinations</span>
          </div>
        </div>
      </div>
      

    </div>
    
    <!-- Two Column Layout -->
    <div class="w-full max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
      
      <!-- Left Column: Access Form (First on Mobile) -->
      <div class="flex justify-center lg:justify-start order-1 lg:order-1">
        <div class="relative w-full max-w-md">
          <!-- Abstract shapes around the card -->
          <div class="absolute -top-8 -left-8 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-transparent rounded-full blur-xl"></div>
          <div class="absolute -bottom-8 -right-8 w-28 h-28 bg-gradient-to-tl from-purple-400/20 to-transparent rounded-full blur-xl"></div>
          <div class="absolute top-1/2 -right-10 w-20 h-20 bg-gradient-to-r from-green-400/20 to-transparent rounded-full blur-lg"></div>
          <div class="absolute top-1/3 -left-6 w-16 h-16 bg-gradient-to-l from-pink-400/20 to-transparent rounded-full blur-md"></div>
          
          <!-- Main quiz access card -->
          <div class="relative bg-white/95 backdrop-blur-sm shadow-2xl rounded-3xl p-8 border border-white/30 overflow-hidden">
            <!-- Decorative elements inside the card -->
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-blue-100/30 to-transparent rounded-full -translate-y-12 translate-x-12"></div>
            <div class="absolute bottom-0 left-0 w-20 h-20 bg-gradient-to-tr from-purple-100/30 to-transparent rounded-full translate-y-10 -translate-x-10"></div>
            
            <!-- Subtle geometric accent -->
            <div class="absolute top-3 right-3 w-6 h-6 border-2 border-blue-200/30 rounded-lg rotate-45"></div>
            <div class="absolute bottom-3 left-3 w-5 h-5 border-2 border-purple-200/30 rounded-full"></div>
            
            <!-- Title with enhanced styling -->
            <div class="relative text-center mb-6">
              <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-primaryGreen to-emerald-600 rounded-xl shadow-lg mb-3">
                <i class="fas fa-question-circle text-white text-lg"></i>
              </div>
              <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-green-600 bg-clip-text text-transparent">
                Live Exam Access
              </h2>
              <p class="text-gray-500 mt-1 text-sm">Enter your credentials to start</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
              <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center space-x-3">
                  <i class="fas fa-exclamation-triangle text-red-500"></i>
                  <div>
                    <h3 class="font-semibold text-red-800">Access Error</h3>
                    <ul class="mt-1 text-sm text-red-700">
                      @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            @endif

            <!-- Enhanced Form -->
            <form method="POST" action="{{ route('public.quiz.process-access') }}" class="relative space-y-4" id="accessForm">
              @csrf
              
              <!-- Phone Number with enhanced styling -->
              <div class="relative">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-phone text-gray-400"></i>
                  </div>
                  <input type="tel" 
                         id="phone" 
                         name="phone" 
                         value="{{ old('phone') }}"
                         class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500/20 focus:border-green-500 bg-gray-50/50 transition-all duration-200" 
                         placeholder="01XXXXXXXXX"
                         pattern="01[3-9][0-9]{8}"
                         maxlength="11"
                         required>
                </div>
                <p class="mt-2 text-sm text-gray-500">11-digit Bangladeshi mobile number</p>
              </div>

              <!-- Access Code with enhanced styling -->
              <div class="relative">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Access Code</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-key text-gray-400"></i>
                  </div>
                  <input type="text" 
                         id="access_code" 
                         name="access_code" 
                         value="{{ old('access_code') }}"
                         class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500/20 focus:border-green-500 bg-gray-50/50 transition-all duration-200 text-center text-lg font-mono tracking-widest" 
                         placeholder="000000"
                         maxlength="6"
                         pattern="[0-9]{6}"
                         required>
                </div>
                <p class="mt-2 text-sm text-gray-500">6-digit access code from your teacher</p>
              </div>

              <!-- Enhanced Submit Button -->
              <button type="submit" 
                class="relative w-full py-3 px-6 bg-gradient-to-r from-primaryGreen to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 overflow-hidden group">
                <!-- Button background animation -->
                <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                <!-- Button content -->
                <span class="relative flex items-center justify-center">
                  Start Live Exam
                  <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                </span>
              </button>

              <!-- Fallback Submit Button (Hidden by default) -->
              <button type="button" 
                id="fallbackSubmit"
                class="hidden relative w-full py-3 px-6 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 overflow-hidden group">
                <span class="relative flex items-center justify-center">
                  <i class="fas fa-refresh mr-2"></i>
                  Retry with Fallback
                </span>
              </button>

              <!-- Multiple Exams Button -->
              <div class="text-center pt-4">
                <button type="button" 
                        onclick="handleMultipleExams()"
                        class="inline-block px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-800 rounded-lg border border-gray-200 hover:border-gray-300 transition-all duration-200 font-medium text-sm">
                  <i class="fas fa-list mr-2"></i>
                  View All Available Exams
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Right Column: Promotional Content -->
      <div class="text-center lg:text-left space-y-6 order-2 lg:order-2">

        <!-- Description Card -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200/50 shadow-sm">
          <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-rocket text-white text-lg animate-bounce"></i>
              </div>
            </div>
            <div class="flex-1">
              <p class="text-lg text-gray-700 leading-relaxed mb-3">
                Access your assigned live exams with ease. Enter your credentials to start your learning journey with Bikolpo LQ.
              </p>
              <div class="flex flex-wrap items-center gap-4 text-sm">
                <div class="flex items-center space-x-2 text-green-600">
                  <i class="fas fa-check-circle"></i>
                  <span>Instant Access</span>
                </div>
                <div class="flex items-center space-x-2 text-blue-600">
                  <i class="fas fa-clock"></i>
                  <span>Real-time Results</span>
                </div>
                <div class="flex items-center space-x-2 text-purple-600">
                  <i class="fas fa-shield-alt"></i>
                  <span>Secure Platform</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Instructions Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full">
          
          <div class="bg-white/80 backdrop-blur-sm rounded-xl p-3 border border-white/30 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center space-x-3 mb-2">
              <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-phone text-white text-sm"></i>
              </div>
              <h3 class="text-sm font-bold text-gray-800">Phone Number</h3>
            </div>
            <p class="text-gray-600 text-xs leading-relaxed">Enter your 11-digit mobile number starting with 01 (e.g., 01712345678)</p>
          </div>
          
          <div class="bg-white/80 backdrop-blur-sm rounded-xl p-3 border border-white/30 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center space-x-3 mb-2">
              <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-key text-white text-sm"></i>
              </div>
              <h3 class="text-sm font-bold text-gray-800">Access Code</h3>
            </div>
            <p class="text-gray-600 text-xs leading-relaxed">Use the 6-digit code provided by your teacher (e.g., 123456)</p>
          </div>
          
          <div class="bg-white/80 backdrop-blur-sm rounded-xl p-3 border border-white/30 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center space-x-3 mb-2">
              <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-clock text-white text-sm"></i>
              </div>
              <h3 class="text-sm font-bold text-gray-800">Time Limit</h3>
            </div>
            <p class="text-gray-600 text-xs leading-relaxed">Complete your live exam within the allocated time. Timer will be visible during the test.</p>
          </div>
          
          <div class="bg-white/80 backdrop-blur-sm rounded-xl p-3 border border-white/30 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center space-x-3 mb-2">
              <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check-circle text-white text-sm"></i>
              </div>
              <h3 class="text-sm font-bold text-gray-800">Submit & Results</h3>
            </div>
            <p class="text-gray-600 text-xs leading-relaxed">Review your answers before submitting. Results are available immediately after completion.</p>
          </div>
        </div>

        <!-- Additional Instructions -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 border border-white/30 shadow-lg">
          <h3 class="text-lg font-bold text-gray-800 mb-4 text-center">Important Instructions</h3>
          <div class="space-y-3 text-sm text-gray-600">
            <div class="flex items-start space-x-3">
              <div class="w-2 h-2 bg-primaryGreen rounded-full mt-2 flex-shrink-0"></div>
              <span>Ensure you have a stable internet connection before starting the live exam</span>
            </div>
            <div class="flex items-start space-x-3">
              <div class="w-2 h-2 bg-primaryBlue rounded-full mt-2 flex-shrink-0"></div>
              <span>Don't refresh the page or close the browser during the live exam</span>
            </div>
            <div class="flex items-start space-x-3">
              <div class="w-2 h-2 bg-primaryPurple rounded-full mt-2 flex-shrink-0"></div>
              <span>You can take multiple exams with the same credentials</span>
            </div>
            <div class="flex items-start space-x-3">
              <div class="w-2 h-2 bg-primaryOrange rounded-full mt-2 flex-shrink-0"></div>
              <span>Contact your teacher if you encounter any technical issues</span>
            </div>
          </div>
        </div>

        <!-- Trust Indicators -->
        <div class="pt-4 text-center">
          <p class="text-sm text-gray-500 mb-4">Trusted by 1000+ students</p>
          <div class="flex flex-col sm:flex-row items-center justify-center space-y-2 sm:space-y-0 sm:space-x-6">
            <div class="flex items-center space-x-2">
              <div class="w-2 h-2 bg-primaryGreen rounded-full animate-pulse"></div>
              <span class="text-sm text-gray-600 font-medium">Secure Platform</span>
            </div>
            <div class="flex items-center space-x-2">
              <div class="w-2 h-2 bg-primaryGreen rounded-full animate-pulse"></div>
              <span class="text-sm text-gray-600 font-medium">Real-time Results</span>
            </div>
            <div class="flex items-center space-x-2">
              <div class="w-2 h-2 bg-primaryGreen rounded-full animate-pulse"></div>
              <span class="text-sm text-gray-600 font-medium">24/7 Access</span>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>

  <!-- JavaScript for Header Functionality -->
  <script>
    // Dark Mode Toggle
    const darkToggle = document.getElementById('darkToggle');
    const html = document.documentElement;
    
    // Check for saved theme preference
    if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
      html.classList.add('dark');
    }
    
    darkToggle.addEventListener('click', () => {
      html.classList.toggle('dark');
      localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
    });

    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    
    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    // Header scroll effect
    const header = document.querySelector('header');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 100) {
        header.classList.add('shadow-lg', 'bg-white/95', 'dark:bg-gray-900/95');
      } else {
        header.classList.remove('shadow-lg', 'bg-white/95', 'dark:bg-gray-900/95');
      }
    });

    // Phone number formatting
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
    });

    // Access code formatting
    document.getElementById('access_code').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
    });

    // CSRF token refresh function
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

    // Form submission with CSRF token refresh
    document.getElementById('accessForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        
        // Show loading state
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
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
                // CSRF token mismatch, refresh and retry
                console.log('CSRF token mismatch, refreshing...');
                return refreshCSRFToken().then(() => {
                    return submitForm();
                }).then(handleResponse);
            }
            
            if (response.ok) {
                // Check if response is a redirect
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    // Try to parse as JSON for AJAX response
                    return response.json().then(data => {
                        if (data.success && data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            window.location.href = response.url;
                        }
                    }).catch(() => {
                        // If not JSON, redirect to response URL
                        window.location.href = response.url;
                    });
                }
            } else {
                // Handle error response
                return response.text().then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const errorElement = doc.querySelector('.text-red-700, .text-red-600, .alert-danger');
                    if (errorElement) {
                        alert('Error: ' + errorElement.textContent.trim());
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        };
        
        // Initial submission
        submitForm()
        .then(handleResponse)
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            // Show fallback button
            document.getElementById('fallbackSubmit').classList.remove('hidden');
        })
        .finally(() => {
            // Reset button state
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        });
    });

    // Fallback submit handler
    document.getElementById('fallbackSubmit').addEventListener('click', function() {
        // Show fallback button and hide main button
        document.querySelector('button[type="submit"]').classList.add('hidden');
        this.classList.remove('hidden');
        
        // Submit form normally (without AJAX)
        document.getElementById('accessForm').submit();
    });

    // Multiple exams handling
    function handleMultipleExams() {
        const phone = document.getElementById('phone').value;
        const accessCode = document.getElementById('access_code').value;
        
        if (!phone || !accessCode) {
            alert('Please enter both phone number and access code first.');
            return;
        }
        
        if (phone.length !== 11) {
            alert('Please enter a valid 11-digit phone number.');
            return;
        }
        
        if (accessCode.length !== 6) {
            alert('Please enter a valid 6-digit access code.');
            return;
        }
        
        // Create and submit form
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
  </script>

</body>
</html>
