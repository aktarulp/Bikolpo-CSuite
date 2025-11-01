<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student Registration - Step 1 - BikolpoLive</title>
    
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

    <!-- Registration Form Section -->
    <section class="py-8 sm:py-12 md:py-16">
        <div class="max-w-md mx-auto px-4 sm:px-6">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Create Your Account
                </h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
                    Enter your mobile number to get started
                </p>
            </div>

            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-center space-x-4 mb-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-primaryBlue text-white flex items-center justify-center text-sm font-semibold">
                            1
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white hidden sm:inline">Phone</span>
                    </div>
                    <div class="w-12 h-0.5 bg-gray-300 dark:bg-gray-600"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center text-sm font-semibold">
                            2
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400 hidden sm:inline">Verify</span>
                    </div>
                    <div class="w-12 h-0.5 bg-gray-300 dark:bg-gray-600"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center text-sm font-semibold">
                            3
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400 hidden sm:inline">Account</span>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 sm:p-8">
                
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-red-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <ul class="text-sm text-red-700 dark:text-red-300 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Success Messages -->
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                        <div class="flex items-center text-sm text-green-700 dark:text-green-300">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <!-- Registration Form -->
                <form method="POST" action="{{ route('public.student.register.phone.submit') }}" class="space-y-6" id="phoneForm">
                    @csrf
                    
                    <!-- Phone Input Field -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mobile Number
                        </label>
                        
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">+880</span>
                            </div>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone') }}"
                                class="block w-full pl-16 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primaryBlue focus:border-transparent transition-colors text-base"
                                placeholder="1XXXXXXXXX"
                                pattern="01[3-9]\d{8}"
                                maxlength="11"
                                required
                                autofocus
                                autocomplete="tel"
                            >
                            <div id="validIcon" class="hidden absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Enter your 11-digit Bangladeshi mobile number (01XXXXXXXXX)
                        </p>
                    </div>

                    <!-- Info Box -->
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm text-blue-800 dark:text-blue-200">
                                    <span class="font-semibold">We'll send you an OTP</span> - A 6-digit verification code will be sent to your mobile number via SMS.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        id="submitBtn"
                        class="w-full bg-primaryBlue hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryBlue disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                    >
                        <span id="btnText">Send Verification Code</span>
                        <svg id="btnLoader" class="hidden animate-spin ml-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>

                <!-- Footer Links -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="font-medium text-primaryBlue hover:text-blue-700 dark:hover:text-blue-400">
                            Sign in
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-footer />

    <script>
        const phoneInput = document.getElementById('phone');
        const phoneForm = document.getElementById('phoneForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnLoader = document.getElementById('btnLoader');
        const validIcon = document.getElementById('validIcon');

        // Format phone number input and show validation
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            e.target.value = value;
            
            const isValid = value.length === 11 && /^01[3-9]\d{8}$/.test(value);
            
            if (value.length > 0 && isValid) {
                validIcon.classList.remove('hidden');
                phoneInput.classList.remove('border-red-300');
                phoneInput.classList.add('border-green-500');
            } else {
                validIcon.classList.add('hidden');
                phoneInput.classList.remove('border-green-500');
                phoneInput.classList.add('border-gray-300', 'dark:border-gray-600');
            }
        });

        // Form submission
        phoneForm.addEventListener('submit', function(e) {
            const phone = phoneInput.value.trim();
            if (phone.length !== 11 || !phone.match(/^01[3-9]\d{8}$/)) {
                e.preventDefault();
                phoneInput.focus();
                phoneInput.classList.add('border-red-500', 'ring-2', 'ring-red-500/20');
                setTimeout(() => {
                    phoneInput.classList.remove('border-red-500', 'ring-2', 'ring-red-500/20');
                }, 2000);
                return false;
            }

            submitBtn.disabled = true;
            btnText.textContent = 'Sending...';
            btnLoader.classList.remove('hidden');
        });

        // Auto-focus
        if (phoneInput.value === '') {
            setTimeout(() => phoneInput.focus(), 100);
        }
    </script>

</body>
</html>
