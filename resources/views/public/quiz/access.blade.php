<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quiz Access - CSuite</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo and Header -->
            <div class="text-center">
                <div class="mx-auto h-20 w-20 bg-gradient-to-br from-primaryGreen to-emerald-500 rounded-full flex items-center justify-center shadow-lg mb-6">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Quiz Access</h2>
                <p class="text-gray-600">Enter your phone number and access code to start the quiz</p>
            </div>

            <!-- Access Form -->
            <div class="bg-white rounded-xl shadow-xl p-8">
                <!-- Phone Number Format Help -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Phone Number Format</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p><strong>Important:</strong> Enter your phone number in the format <code class="bg-blue-100 px-1 rounded">01XXXXXXXXX</code></p>
                                <p class="mt-1">• <strong>Do NOT</strong> include +880 or country code</p>
                                <p class="mt-1">• <strong>Do NOT</strong> include spaces or dashes</p>
                                <p class="mt-1">• <strong>Example:</strong> If your number is +880 17 1234 5678, enter: <code class="bg-blue-100 px-1 rounded">01712345678</code></p>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-red-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Access Error</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('public.quiz.process-access') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Phone Number
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen transition-colors"
                                   placeholder="01XXXXXXXXX"
                                   pattern="01[3-9][0-9]{8}"
                                   maxlength="11"
                                   required>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Enter your 11-digit Bangladeshi phone number starting with 01 (e.g., 01712345678)</p>
                        <p class="mt-1 text-xs text-gray-400">Note: Do not include +880 or country code</p>
                    </div>

                    <!-- Access Code -->
                    <div>
                        <label for="access_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Access Code
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   id="access_code" 
                                   name="access_code" 
                                   value="{{ old('access_code') }}"
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen transition-colors font-mono text-lg tracking-widest text-center"
                                   placeholder="000000"
                                   maxlength="6"
                                   pattern="[0-9]{6}"
                                   required>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Enter the 6-digit access code provided by your teacher</p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primaryGreen to-emerald-600 hover:from-primaryGreen/90 hover:to-emerald-600/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                        Access Quiz
                    </button>

                    <!-- Multiple Exams Button -->
                    <div class="text-center">
                        <p class="text-sm text-gray-500 mb-2">Have multiple exams?</p>
                        <button type="button" 
                                onclick="handleMultipleExams()"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Check All Available Exams
                        </button>
                    </div>
                </form>

                <!-- Help Section -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="text-center">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Need Help?</h3>
                        <p class="text-sm text-gray-500">
                            Contact your teacher if you don't have an access code or are experiencing issues.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} CSuite. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Auto-format phone number for Bangladeshi format (01XXXXXXXXX)
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove all non-digits
            
            // Limit to 11 digits
            if (value.length > 11) {
                value = value.substring(0, 11);
            }
            
            // Ensure it starts with 01
            if (value.length >= 2 && value.substring(0, 2) !== '01') {
                value = '01' + value.substring(2);
            }
            
            // Ensure second digit is 3-9 (valid Bangladeshi mobile prefixes)
            if (value.length >= 3) {
                const secondDigit = parseInt(value.charAt(2));
                if (secondDigit < 3 || secondDigit > 9) {
                    value = value.substring(0, 2) + '3' + value.substring(3);
                }
            }
            
            e.target.value = value;
        });

        // Auto-format access code
        document.getElementById('access_code').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });

        // Handle multiple exams button click
        function handleMultipleExams() {
            const phone = document.getElementById('phone').value;
            const accessCode = document.getElementById('access_code').value;
            
            if (!phone || !accessCode) {
                alert('Please enter both phone number and access code first.');
                return;
            }
            
            // Create a form and submit to multiple-exams route
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("public.quiz.multiple-exams") }}';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Add phone
            const phoneInput = document.createElement('input');
            phoneInput.type = 'hidden';
            phoneInput.name = 'phone';
            phoneInput.value = phone;
            form.appendChild(phoneInput);
            
            // Add access code
            const accessCodeInput = document.createElement('input');
            accessCodeInput.type = 'hidden';
            accessCodeInput.name = 'access_code';
            accessCodeInput.value = accessCode;
            form.appendChild(accessCodeInput);
            
            // Submit form
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>
