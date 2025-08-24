<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verify OTP - Partner Registration</title>
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
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 font-bangla">
    <!-- Header -->
    <header class="bg-white/90 dark:bg-gray-900/95 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('landing') }}" class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-primaryGreen to-green-600 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-primaryGreen">বিকল্প কম্পিউটার</h1>
                        <p class="text-xs text-gray-500">Your Smart Exam Partner</p>
                    </div>
                </a>
                <a href="{{ route('partner.onboarding') }}" class="bg-primaryGreen text-white px-6 py-2 rounded-full font-semibold">
                    Sign In
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen py-16">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <div class="w-20 h-20 bg-gradient-to-br from-primaryGreen to-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-envelope text-white text-3xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    <span class="text-primaryGreen">Verify Your Email</span>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400">
                    We've sent a 6-digit verification code to your email address
                </p>
            </div>

            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 px-6 py-4 rounded-xl mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-green-500"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- OTP Verification Form -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
                <form action="{{ route('partner.verify-otp.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="text-center">
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Please check your email and enter the 6-digit verification code below
                        </p>
                    </div>

                    <div class="space-y-4">
                        <label for="otp" class="block text-center font-semibold text-gray-700 dark:text-gray-300 text-lg">
                            Verification Code
                        </label>
                        <div class="flex justify-center">
                            <input type="text" id="otp" name="otp" maxlength="6" required
                                class="w-64 text-center text-3xl font-bold tracking-widest rounded-xl border-2 border-gray-300 dark:border-gray-600 px-6 py-4 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                placeholder="000000" 
                                autocomplete="off"
                                inputmode="numeric"
                                pattern="[0-9]{6}" />
                        </div>
                        @error('otp')
                            <p class="text-red-500 text-sm text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-center space-y-4">
                        <button type="submit" 
                            class="w-full bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-check mr-2"></i>
                            Verify OTP
                        </button>

                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <p>Didn't receive the code?</p>
                            <form action="{{ route('partner.resend-otp') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-primaryGreen hover:text-green-600 font-semibold underline">
                                    Resend OTP
                                </button>
                            </form>
                        </div>
                    </div>
                </form>

                <!-- Instructions -->
                <div class="mt-8 p-6 bg-gray-50 dark:bg-gray-700 rounded-xl">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-primaryBlue"></i>
                        What to do next?
                    </h3>
                    <ol class="text-sm text-gray-600 dark:text-gray-400 space-y-2 list-decimal list-inside">
                        <li>Check your email inbox (and spam folder)</li>
                        <li>Look for an email from "বিকল্প কম্পিউটার"</li>
                        <li>Copy the 6-digit verification code</li>
                        <li>Paste it in the field above</li>
                        <li>Click "Verify OTP" to complete registration</li>
                    </ol>
                </div>

                <!-- Support -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                        Need help? Contact our support team
                    </p>
                    <div class="flex justify-center space-x-4">
                        <a href="https://wa.me/8801610800060" target="_blank" 
                            class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors duration-200">
                            <i class="fab fa-whatsapp mr-2"></i>
                            WhatsApp
                        </a>
                        <a href="mailto:bikolpo247@gmail.com" 
                            class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200">
                            <i class="fas fa-envelope mr-2"></i>
                            Email
                        </a>
                    </div>
                </div>
            </div>

            <!-- Back to Registration -->
            <div class="text-center mt-8">
                <a href="{{ route('partner.register') }}" class="text-primaryGreen hover:text-green-600 font-semibold">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Registration
                </a>
            </div>
        </div>
    </main>

    <script>
        // Auto-focus on OTP input
        document.getElementById('otp').focus();

        // Auto-format OTP input
        const otpInput = document.getElementById('otp');
        otpInput.addEventListener('input', function(e) {
            // Remove non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Limit to 6 digits
            if (this.value.length > 6) {
                this.value = this.value.slice(0, 6);
            }
        });

        // Auto-submit when 6 digits are entered
        otpInput.addEventListener('input', function(e) {
            if (this.value.length === 6) {
                // Small delay to show the last digit
                setTimeout(() => {
                    this.form.submit();
                }, 300);
            }
        });
    </script>
</body>
</html>
