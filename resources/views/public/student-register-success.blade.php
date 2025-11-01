<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registration Successful - BikolpoLive</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        bangla: ['"Nikosh"', '"Hind Siliguri"', 'sans-serif']
                    },
                    colors: {
                        primaryGreen: '#16a34a',
                        primaryOrange: '#f97316',
                        primaryBlue: '#3b82f6',
                        primaryPurple: '#8b5cf6'
                    }
                }
            }
        }
    </script>

</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans min-h-screen">
   @include('navigation-layout');

    <!-- Success Section -->
    <section class="py-8 sm:py-12 md:py-16 min-h-screen flex items-center">
        <div class="max-w-md mx-auto px-4 sm:px-6">
            
            <!-- Success Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-6 sm:p-8 text-center animate-fade-in">
                
                <!-- Success Icon with Animation -->
                <div class="mb-6">
                    <div class="relative inline-block">
                        <!-- Animated circles -->
                        <div class="absolute inset-0 rounded-full bg-green-100 dark:bg-green-900/30 animate-ping"></div>
                        <div class="absolute inset-0 rounded-full bg-green-200 dark:bg-green-800/30 animate-pulse"></div>
                        
                        <!-- Success checkmark circle -->
                        <div class="relative w-20 h-20 sm:w-24 sm:h-24 mx-auto bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-12 h-12 sm:w-16 sm:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Success Message -->
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-3">
                    Registration Successful!
                </h1>
                
                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 mb-2">
                    Welcome to BikolpoLive @if(isset($name) && $name)<span class="font-semibold text-gray-900 dark:text-white">{{ $name }}</span>@endif!
                </p>
                
                <p class="text-sm text-gray-500 dark:text-gray-500 mb-6">
                    Your account has been created successfully.
                </p>

                <!-- Account Details Card -->
                @if(isset($email) && $email)
                <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-1">
                        <span class="font-medium">Email:</span> 
                        <span class="text-primaryBlue dark:text-blue-400">{{ $email }}</span>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        You can now log in with your email and password
                    </p>
                </div>
                @endif

                <!-- Next Steps -->
                <div class="mb-6 space-y-3">
                    <div class="flex items-start text-left p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <svg class="w-5 h-5 text-primaryBlue mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Account Created</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Your student account is ready to use</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start text-left p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <svg class="w-5 h-5 text-primaryBlue mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Start Learning</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Explore courses and begin your learning journey</p>
                        </div>
                    </div>
                </div>

                <!-- Redirect Countdown -->
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <p class="text-sm text-green-800 dark:text-green-200 mb-2">
                        <span class="font-semibold">Redirecting to login page in</span>
                        <span id="countdown" class="font-bold text-lg text-green-600 dark:text-green-400 mx-1">5</span>
                        <span class="font-semibold">seconds...</span>
                    </p>
                    <div class="w-full bg-green-200 dark:bg-green-800 rounded-full h-2">
                        <div id="progressBar" class="bg-green-600 h-2 rounded-full transition-all duration-1000" style="width: 100%"></div>
                    </div>
                </div>

                <!-- Login Button -->
                <a 
                    href="{{ route('login') }}"
                    class="block w-full bg-primaryBlue hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryBlue mb-4"
                >
                    Go to Login Page
                </a>

                <!-- Back to Home -->
                <a 
                    href="{{ url('/') }}"
                    class="block text-sm text-gray-600 dark:text-gray-400 hover:text-primaryBlue dark:hover:text-blue-400 font-medium"
                >
                    ← Back to Home
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-footer />

    <script>
        let countdown = 5;
        const countdownElement = document.getElementById('countdown');
        const progressBar = document.getElementById('progressBar');
        const totalTime = 5000; // 5 seconds
        let elapsed = 0;

        // Update countdown and progress bar
        const interval = setInterval(() => {
            countdown--;
            elapsed += 1000;
            
            if (countdown >= 0) {
                countdownElement.textContent = countdown;
                const progress = ((totalTime - elapsed) / totalTime) * 100;
                progressBar.style.width = progress + '%';
            }

            if (countdown <= 0) {
                clearInterval(interval);
                window.location.href = '{{ route('login') }}';
            }
        }, 1000);

        // Allow manual navigation
        document.querySelectorAll('a[href="{{ route('login') }}"]').forEach(link => {
            link.addEventListener('click', function(e) {
                clearInterval(interval);
            });
        });
    </script>

    <style>
        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(-20px) scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
    </style>

</body>
</html>

