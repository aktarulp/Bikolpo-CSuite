<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Bikolpo Live - Online Test Platform')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'Bikolpo Live - Online Test Platform for Educational Excellence')">
    <meta name="keywords" content="online test, exam platform, education, Bikolpo Live, Bangladesh">
    <meta name="author" content="Bikolpo Live">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', 'Bikolpo Live - Online Test Platform')">
    <meta property="og:description" content="@yield('description', 'Bikolpo Live - Online Test Platform for Educational Excellence')">
    <meta property="og:image" content="{{ asset('images/BikolpoLive.svg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Bikolpo Live">
    <meta property="og:locale" content="en_US">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Bikolpo Live - Online Test Platform')">
    <meta name="twitter:description" content="@yield('description', 'Bikolpo Live - Online Test Platform for Educational Excellence')">
    <meta name="twitter:image" content="{{ asset('images/BikolpoLive.svg') }}">
    
    <!-- Organization Logo for Google Search -->
    <meta name="logo" content="{{ asset('images/BikolpoLive.svg') }}">
    <link rel="logo" href="{{ asset('images/BikolpoLive.svg') }}">
    
    <!-- Structured Data for Google Search Console -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Bikolpo Live",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/BikolpoLive.svg') }}",
        "description": "Online Test Platform for Educational Excellence",
        "sameAs": [
            "https://www.facebook.com/bikolpolive",
            "https://www.linkedin.com/company/bikolpolive"
        ],
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+880-XXX-XXXXXX",
            "contactType": "customer service",
            "areaServed": "BD",
            "availableLanguage": ["English", "Bengali"]
        },
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "BD"
        }
    }
    </script>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/BikolpoLive.svg') }}">
    <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('images/BikolpoLive.svg') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

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
        
        .font-bangla {
            font-family: 'Nikosh', 'Hind Siliguri', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 font-bangla">
    
    @include('navigation-layout')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-br from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 opacity-0 invisible border border-white/20 backdrop-blur-sm">
        <i class="fas fa-arrow-up text-sm"></i>
    </button>

    <script>
        // Back to Top Button
        const backToTopBtn = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.remove('opacity-0', 'invisible');
                backToTopBtn.classList.add('opacity-100', 'visible');
            } else {
                backToTopBtn.classList.add('opacity-0', 'invisible');
                backToTopBtn.classList.remove('opacity-100', 'visible');
            }
        });
        
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
