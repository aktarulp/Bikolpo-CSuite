<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Background with gradient and floating elements -->
        <div class="min-h-screen relative overflow-hidden bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
            
            <!-- Floating Elements -->
            <div class="absolute top-20 left-10 w-20 h-20 bg-green-400/20 rounded-full animate-bounce-slow"></div>
            <div class="absolute top-40 right-20 w-16 h-16 bg-blue-400/20 rounded-full animate-pulse-slow"></div>
            <div class="absolute bottom-20 left-20 w-12 h-12 bg-purple-400/20 rounded-full animate-bounce-slow animation-delay-1000"></div>
            <div class="absolute bottom-40 right-10 w-24 h-24 bg-orange-400/20 rounded-full animate-pulse-slow animation-delay-2000"></div>
            
            <!-- Grid Pattern Overlay -->
            <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
            
            <!-- Main Content -->
            <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
                
                <!-- Logo Section -->
                <div class="mb-8 animate-fade-in">
                    <x-brand-logo 
                        size="xl" 
                        variant="hero" 
                        :href="route('landing')" 
                        :show-tagline="true" 
                    />
                </div>

                <!-- Form Container -->
                <div class="w-full sm:max-w-md animate-slide-up">
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl rounded-3xl border border-white/20 dark:border-gray-700/20 overflow-hidden">
                        <div class="p-8">
                            {{ $slot }}
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center animate-fade-in">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        © 2025 Bikolpo LQ. All rights reserved.
                    </p>
                </div>
            </div>
        </div>

        <style>
            .bg-grid-pattern {
                background-image: 
                    linear-gradient(rgba(0,0,0,0.1) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(0,0,0,0.1) 1px, transparent 1px);
                background-size: 20px 20px;
            }
            
            .animation-delay-1000 {
                animation-delay: 1s;
            }
            
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            @keyframes slideUp {
                from { opacity: 0; transform: translateY(40px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            .animate-fade-in {
                animation: fadeIn 0.6s ease-out;
            }
            
            .animate-slide-up {
                animation: slideUp 0.8s ease-out;
            }
            
            .animate-bounce-slow {
                animation: bounce 3s infinite;
            }
            
            .animate-pulse-slow {
                animation: pulse 4s infinite;
            }
        </style>
    </body>
</html>
