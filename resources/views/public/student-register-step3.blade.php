<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Complete Registration - Step 3 - BikolpoLive</title>
    
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
                    Complete Your Profile
                </h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
                    Fill in your details to finish registration
                </p>
            </div>

            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-center space-x-4 mb-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-primaryBlue text-white flex items-center justify-center text-sm font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white hidden sm:inline">Phone</span>
                    </div>
                    <div class="w-12 h-0.5 bg-primaryBlue"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-primaryBlue text-white flex items-center justify-center text-sm font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white hidden sm:inline">Verify</span>
                    </div>
                    <div class="w-12 h-0.5 bg-primaryBlue"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-primaryBlue text-white flex items-center justify-center text-sm font-semibold">
                            3
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white hidden sm:inline">Account</span>
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

                <!-- Registration Form -->
                <form method="POST" action="{{ route('public.student.register.password.submit') }}" class="space-y-5" id="registrationForm">
                    @csrf
                    
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Full Name
                        </label>
                        <input 
                            type="text" 
                            id="full_name" 
                            name="full_name" 
                            value="{{ old('full_name') }}"
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primaryBlue focus:border-transparent transition-colors text-base"
                            placeholder="Enter your full name"
                            required
                            autofocus
                            autocomplete="name"
                        >
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primaryBlue focus:border-transparent transition-colors text-base"
                            placeholder="Enter your email address"
                            required
                            autocomplete="email"
                        >
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="block w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primaryBlue focus:border-transparent transition-colors text-base"
                                placeholder="Create a password"
                                required
                                minlength="8"
                                autocomplete="new-password"
                            >
                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                            >
                                <svg id="eyeIcon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eyeOffIcon" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Password must be at least 8 characters long
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Confirm Password
                        </label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primaryBlue focus:border-transparent transition-colors text-base"
                            placeholder="Confirm your password"
                            required
                            autocomplete="new-password"
                        >
                        <p id="passwordMatch" class="mt-2 text-xs hidden"></p>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start">
                        <input 
                            id="terms" 
                            name="terms" 
                            type="checkbox" 
                            class="h-4 w-4 mt-1 text-primaryBlue focus:ring-primaryBlue border-gray-300 dark:border-gray-600 rounded cursor-pointer"
                            required
                        >
                        <label for="terms" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                            I agree to the 
                            <a href="{{ route('terms') }}" target="_blank" class="text-primaryBlue hover:text-blue-700 dark:hover:text-blue-400 font-medium">
                                Terms of Service
                            </a> 
                            and 
                            <a href="{{ route('privacy') }}" target="_blank" class="text-primaryBlue hover:text-blue-700 dark:hover:text-blue-400 font-medium">
                                Privacy Policy
                            </a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        id="submitBtn"
                        class="w-full bg-primaryBlue hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryBlue disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                    >
                        <span id="btnText">Create Account</span>
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
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        const togglePasswordBtn = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeOffIcon = document.getElementById('eyeOffIcon');
        const registrationForm = document.getElementById('registrationForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnLoader = document.getElementById('btnLoader');
        const passwordMatch = document.getElementById('passwordMatch');

        // Toggle password visibility
        togglePasswordBtn.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('hidden');
            eyeOffIcon.classList.toggle('hidden');
        });

        // Check password match
        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirm = passwordConfirmInput.value;

            if (confirm.length === 0) {
                passwordMatch.classList.add('hidden');
                passwordConfirmInput.classList.remove('border-red-500', 'border-green-500');
                return;
            }

            passwordMatch.classList.remove('hidden');
            if (password === confirm) {
                passwordMatch.textContent = '✓ Passwords match';
                passwordMatch.className = 'mt-2 text-xs text-green-600 dark:text-green-400';
                passwordConfirmInput.classList.remove('border-red-500');
                passwordConfirmInput.classList.add('border-green-500');
            } else {
                passwordMatch.textContent = '✗ Passwords do not match';
                passwordMatch.className = 'mt-2 text-xs text-red-600 dark:text-red-400';
                passwordConfirmInput.classList.remove('border-green-500');
                passwordConfirmInput.classList.add('border-red-500');
            }
        }

        passwordConfirmInput.addEventListener('input', checkPasswordMatch);

        // Form submission
        registrationForm.addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirm = passwordConfirmInput.value;

            if (password.length < 8) {
                e.preventDefault();
                passwordInput.focus();
                return false;
            }

            if (password !== confirm) {
                e.preventDefault();
                passwordConfirmInput.focus();
                return false;
            }

            submitBtn.disabled = true;
            btnText.textContent = 'Creating Account...';
            btnLoader.classList.remove('hidden');
        });
    </script>

</body>
</html>
