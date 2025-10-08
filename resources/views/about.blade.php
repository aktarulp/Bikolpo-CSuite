<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>About Us - Bikolpo Live</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                    bangla: ['"Nikosh"', '"Hind Siliguri"', 'sans-serif'],
                    brand: ['"Poppins"', 'sans-serif'],
                    modern: ['"Inter"', 'sans-serif'],
                    display: ['"Space Grotesk"', 'sans-serif']
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
    <link href="https://fonts.googleapis.com/css2?family=Nikosh:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 font-bangla">
    
    @include('navigation-layout')

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-white via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12 lg:py-16">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-primaryGreen/5 via-transparent to-primaryBlue/5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <div class="inline-flex items-center px-6 py-3 rounded-full bg-primaryGreen/10 border border-primaryGreen/20 mb-8">
                    <i class="fas fa-info-circle text-primaryGreen mr-3 text-lg"></i>
                    <span class="text-sm font-medium text-primaryGreen">About Bikolpo Live</span>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 bg-gradient-to-r from-gray-900 via-primaryGreen to-primaryBlue dark:from-white dark:via-primaryGreen dark:to-primaryBlue bg-clip-text text-transparent">
                    About Us
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-4xl mx-auto leading-relaxed">
                    Discover the story behind Bikolpo Live and our mission to revolutionize education in Bangladesh through innovative online testing technology.
                </p>
            </div>
        </div>
    </section>

    <!-- Born in Rangpur Section -->
    <section class="py-20 bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-primaryOrange/20 to-amber-400/20 rounded-3xl blur-xl"></div>
                    <div class="relative bg-gradient-to-br from-primaryOrange via-orange-500 to-amber-500 rounded-3xl p-10 shadow-2xl border border-white/20">
                        <div class="text-center text-white">
                            <div class="w-20 h-20 bg-white/20 rounded-3xl flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-map-marker-alt text-white text-3xl"></i>
                            </div>
                            <h3 class="text-3xl font-bold mb-4">Born in Rangpur</h3>
                            <p class="text-orange-100 mb-6 text-lg leading-relaxed">
                                Our roots run deep in the heart of Rangpur, where our journey began with a vision to transform education across Bangladesh.
                            </p>
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <div class="bg-white/20 rounded-2xl p-4">
                                    <div class="text-2xl font-bold">2019</div>
                                    <div class="text-orange-100 text-sm">Founded</div>
                                </div>
                                <div class="bg-white/20 rounded-2xl p-4">
                                    <div class="text-2xl font-bold">Rangpur</div>
                                    <div class="text-orange-100 text-sm">Origin</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="animate-slide-up">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-primaryOrange/10 text-primaryOrange text-sm font-medium mb-6 border border-primaryOrange/20">
                        <i class="fas fa-heart mr-2"></i>
                        Our Heritage
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                        Proudly Rangpur Born
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                        Bikolpo Live was conceived and born in the vibrant city of Rangpur, a place known for its rich cultural heritage and commitment to education. This northern city of Bangladesh has always been a hub of learning and innovation, making it the perfect birthplace for our educational technology revolution.
                    </p>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                        From our humble beginnings in Rangpur, we have grown to serve students and institutions across the entire country. Our connection to this historic city reminds us of our mission to bring quality education to every corner of Bangladesh, starting from the north and reaching every student nationwide.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <div class="bg-primaryOrange/10 rounded-lg px-4 py-2">
                            <span class="text-primaryOrange font-semibold">Northern Roots</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-2">Rangpur Heritage</span>
                        </div>
                        <div class="bg-amber-500/10 rounded-lg px-4 py-2">
                            <span class="text-amber-600 font-semibold">Cultural Pride</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-2">Local Values</span>
                        </div>
                        <div class="bg-yellow-500/10 rounded-lg px-4 py-2">
                            <span class="text-yellow-600 font-semibold">National Reach</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-2">Countrywide Impact</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="animate-slide-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                        Our Story
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                        Bikolpo Live was born from a simple yet powerful vision: to make quality education accessible to every student in Bangladesh. Founded by a team of passionate educators and technology experts, we recognized the need for a comprehensive, user-friendly online testing platform that could bridge the gap between traditional learning and modern technology.
                    </p>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                        Since our inception, we have been committed to providing cutting-edge educational solutions that empower both students and educators. Our platform combines advanced technology with pedagogical expertise to create an environment where learning thrives and success is inevitable.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <div class="bg-primaryGreen/10 rounded-lg px-4 py-2">
                            <span class="text-primaryGreen font-semibold">2019</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-2">Founded</span>
                        </div>
                        <div class="bg-primaryBlue/10 rounded-lg px-4 py-2">
                            <span class="text-primaryBlue font-semibold">2500+</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-2">Students</span>
                        </div>
                        <div class="bg-primaryPurple/10 rounded-lg px-4 py-2">
                            <span class="text-primaryPurple font-semibold">75+</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-2">Partners</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-primaryGreen to-green-600 rounded-3xl p-8 shadow-2xl">
                        <div class="text-center text-white">
                            <i class="fas fa-graduation-cap text-6xl mb-6"></i>
                            <h3 class="text-2xl font-bold mb-4">Empowering Education</h3>
                            <p class="text-green-100 leading-relaxed">
                                We believe that every student deserves access to quality education and assessment tools that help them reach their full potential.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    Our Mission & Vision
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Driving educational excellence through innovation and technology
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Mission -->
                <div class="group bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryGreen to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-bullseye text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Our Mission</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        To revolutionize education in Bangladesh by providing innovative, accessible, and comprehensive online testing solutions that empower students, educators, and institutions to achieve academic excellence and prepare for a successful future.
                    </p>
                </div>

                <!-- Vision -->
                <div class="group bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-eye text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Our Vision</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        To become the leading educational technology platform in Bangladesh, creating a future where every student has access to world-class learning tools and assessment systems that foster critical thinking, creativity, and lifelong learning.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    Our Core Values
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    The principles that guide everything we do
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Innovation -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryGreen to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-lightbulb text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Innovation</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        We continuously push the boundaries of educational technology to create cutting-edge solutions that enhance learning experiences.
                    </p>
                </div>

                <!-- Excellence -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-star text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Excellence</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        We strive for the highest standards in everything we do, from platform development to customer support and user experience.
                    </p>
                </div>

                <!-- Accessibility -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryPurple to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-universal-access text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Accessibility</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        We believe education should be accessible to everyone, regardless of location, background, or economic status.
                    </p>
                </div>

                <!-- Integrity -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryOrange to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Integrity</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        We maintain the highest ethical standards in all our operations, ensuring transparency, fairness, and trust in everything we do.
                    </p>
                </div>

                <!-- Collaboration -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Collaboration</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        We work closely with educators, students, and institutions to create solutions that truly meet their needs and challenges.
                    </p>
                </div>

                <!-- Growth -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-rose-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-seedling text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Growth</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        We are committed to continuous improvement and growth, both for our platform and for the educational community we serve.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    Our Team
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Meet the passionate individuals behind Bikolpo Live
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Team Member 1 -->
                <div class="group bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-primaryGreen to-green-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">CEO & Founder</h3>
                    <p class="text-primaryGreen font-semibold mb-4">Leadership Team</p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Leading the vision and strategic direction of Bikolpo Live with over 10 years of experience in educational technology.
                    </p>
                </div>

                <!-- Team Member 2 -->
                <div class="group bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-code text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">CTO</h3>
                    <p class="text-primaryBlue font-semibold mb-4">Technology Team</p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Overseeing the technical architecture and development of our cutting-edge educational platform.
                    </p>
                </div>

                <!-- Team Member 3 -->
                <div class="group bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-primaryPurple to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-graduation-cap text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Head of Education</h3>
                    <p class="text-primaryPurple font-semibold mb-4">Education Team</p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Ensuring our platform meets the highest educational standards and pedagogical best practices.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-primaryGreen via-green-600 to-emerald-600 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Ready to Join Our Educational Revolution?
            </h2>
            <p class="text-xl text-green-100 mb-8 max-w-3xl mx-auto">
                Be part of the future of education in Bangladesh. Start your journey with Bikolpo Live today.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-primaryGreen px-8 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transition-colors duration-200">
                    Get Started Free
                </a>
                <a href="{{ route('contact') }}" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-primaryGreen transition-colors duration-200">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    <x-footer />

    <script>
        // Dark Mode Toggle
        const darkToggle = document.getElementById('darkToggle');
        const html = document.documentElement;
        
        // Check for saved theme preference
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        }
        
        if (darkToggle) {
            darkToggle.addEventListener('click', () => {
                html.classList.toggle('dark');
                localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
            });
        }

        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Smooth Scrolling for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    <style>
        .bg-grid-pattern {
            background-image: 
                linear-gradient(rgba(0,0,0,0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,0,0,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
