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
                                   placeholder="Enter your phone number"
                                   required>
                        </div>
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
        // Auto-format phone number
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
            }
            e.target.value = value;
        });

        // Auto-format access code
        document.getElementById('access_code').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });
    </script>
</body>
</html>
