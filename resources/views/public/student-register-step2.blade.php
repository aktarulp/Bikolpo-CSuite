<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verify OTP - Step 2 - BikolpoLive</title>
    
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
                    Verify Your Number
                </h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
                    Enter the 6-digit code sent to your phone
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
                            2
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white hidden sm:inline">Verify</span>
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
                
                <!-- Phone Number Display -->
                <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                        Code sent to <span class="font-semibold text-gray-900 dark:text-white">{{ $phoneNumber }}</span>
                    </p>
                </div>

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

                <!-- OTP Form -->
                <form method="POST" action="{{ route('public.student.register.otp.submit') }}" class="space-y-6" id="otpForm">
                    @csrf
                    
                    <div>
                        <label for="otp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Enter Verification Code
                        </label>
                        <div class="flex justify-center space-x-2 mb-4">
                            @for($i = 0; $i < 6; $i++)
                                <input
                                    type="text"
                                    class="otp-input w-12 h-12 text-center text-lg font-semibold border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primaryBlue focus:border-transparent transition-all"
                                    maxlength="1"
                                    pattern="[0-9]"
                                    inputmode="numeric"
                                    autocomplete="off"
                                    data-index="{{ $i }}"
                                >
                            @endfor
                        </div>
                        <input type="hidden" id="otp" name="otp" value="">
                        
                        <!-- Timer -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                Didn't receive the code?
                            </p>
                            <div id="timerContainer">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Resend code in <span id="timer" class="font-semibold text-primaryBlue">02:00</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Verify Button -->
                    <button 
                        type="submit"
                        id="verifyBtn"
                        class="w-full bg-primaryBlue hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryBlue disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                        disabled
                    >
                        <span id="btnText">Verify OTP</span>
                        <svg id="btnLoader" class="hidden animate-spin ml-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>

                <!-- Resend Form -->
                <form method="POST" action="{{ route('public.student.register.otp.resend') }}" id="resendForm" class="mt-4">
                    @csrf
                    <button 
                        type="submit"
                        id="resendBtn"
                        class="w-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 disabled:opacity-50 disabled:cursor-not-allowed hidden"
                    >
                        Resend Verification Code
                    </button>
                </form>

                <!-- Footer Links -->
                <div class="mt-6 text-center">
                    <button 
                        type="button"
                        onclick="window.location.href='{{ route('public.student.register.phone') }}'"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-primaryBlue dark:hover:text-blue-400 font-medium"
                    >
                        ← Change phone number
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-footer />

    <script>
        const otpInputs = document.querySelectorAll('.otp-input');
        const hiddenOtpInput = document.getElementById('otp');
        const otpForm = document.getElementById('otpForm');
        const verifyBtn = document.getElementById('verifyBtn');
        const btnText = document.getElementById('btnText');
        const btnLoader = document.getElementById('btnLoader');
        const resendBtn = document.getElementById('resendBtn');
        const resendForm = document.getElementById('resendForm');
        const timerContainer = document.getElementById('timerContainer');
        const timerDisplay = document.getElementById('timer');

        let timeLeft = 120;
        let timerInterval = null;

        function updateOtpValue() {
            const otpValue = Array.from(otpInputs).map(input => input.value).join('');
            hiddenOtpInput.value = otpValue;
            verifyBtn.disabled = otpValue.length !== 6;
        }

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', function(e) {
                const value = e.target.value.replace(/\D/g, '');
                if (value.length > 1) {
                    e.target.value = value[0];
                }
                
                updateOtpValue();
                
                if (value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
                
                if (e.key === 'v' && (e.ctrlKey || e.metaKey)) {
                    e.preventDefault();
                    navigator.clipboard.readText().then(text => {
                        const digits = text.replace(/\D/g, '').slice(0, 6);
                        digits.split('').forEach((digit, i) => {
                            if (otpInputs[i]) {
                                otpInputs[i].value = digit;
                            }
                        });
                        updateOtpValue();
                        if (digits.length === 6) {
                            otpInputs[5].focus();
                        } else if (otpInputs[digits.length]) {
                            otpInputs[digits.length].focus();
                        }
                    });
                }
            });

            input.addEventListener('focus', function() {
                this.select();
            });
        });

        function startTimer() {
            timerInterval = setInterval(() => {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    timerContainer.classList.add('hidden');
                    resendBtn.classList.remove('hidden');
                }
            }, 1000);
        }

        otpForm.addEventListener('submit', function(e) {
            const otpValue = hiddenOtpInput.value;
            if (otpValue.length !== 6) {
                e.preventDefault();
                otpInputs[0].focus();
                return false;
            }

            verifyBtn.disabled = true;
            btnText.textContent = 'Verifying...';
            btnLoader.classList.remove('hidden');
        });

        resendForm.addEventListener('submit', function(e) {
            resendBtn.disabled = true;
            resendBtn.textContent = 'Sending...';
            
            timeLeft = 120;
            timerContainer.classList.remove('hidden');
            resendBtn.classList.add('hidden');
            startTimer();
        });

        if (otpInputs[0]) {
            setTimeout(() => otpInputs[0].focus(), 100);
        }

        startTimer();
    </script>

</body>
</html>
