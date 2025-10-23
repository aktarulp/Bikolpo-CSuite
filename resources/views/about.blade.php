<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>About Us - Bikolpo Live</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/BikolpoLive.svg') }}">
    <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('images/BikolpoLive.svg') }}">
    
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

</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 font-sans">
    
    @include('navigation-layout')

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-white via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12 lg:py-16">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-primaryGreen/5 via-transparent to-primaryBlue/5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <div class="inline-flex items-center px-6 py-3 rounded-full bg-primaryGreen/10 border border-primaryGreen/20 mb-8">
                    <svg class="w-5 h-5 text-primaryGreen mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
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
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
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
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                        </svg>
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
                            <svg class="w-16 h-16 mb-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                            </svg>
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
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 12a1 1 0 102 0V9a1 1 0 10-2 0v3zm1-8a1 1 0 00-1 1v1H8a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V5a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Our Mission</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        To revolutionize education in Bangladesh by providing innovative, accessible, and comprehensive online testing solutions that empower students, educators, and institutions to achieve academic excellence and prepare for a successful future.
                    </p>
                </div>

                <!-- Vision -->
                <div class="group bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                        </svg>
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
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 3a1 1 0 10-2 0v1a1 1 0 10-2 0V3a3 3 0 116 0v1a1 1 0 10-2 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.477.859h4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Innovation</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        We continuously push the boundaries of educational technology to create cutting-edge solutions that enhance learning experiences.
                    </p>
                </div>

                <!-- Excellence -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Excellence</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        We strive for the highest standards in everything we do, from platform development to customer support and user experience.
                    </p>
                </div>

                <!-- Accessibility -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryPurple to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Accessibility</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        We believe education should be accessible to everyone, regardless of location, background, or economic status.
                    </p>
                </div>

                <!-- Integrity -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-primaryOrange to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Integrity</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        We maintain the highest ethical standards in all our operations, ensuring transparency, fairness, and trust in everything we do.
                    </p>
                </div>

                <!-- Collaboration -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 8v1h-6v4a3 3 0 00-3 3v1h6.93zM6 8a5 5 0 0110 0v1H6V8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Collaboration</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        We work closely with educators, students, and institutions to create solutions that truly meet their needs and challenges.
                    </p>
                </div>

                <!-- Growth -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-rose-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                        </svg>
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
                    <div class="relative w-32 h-32 mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-br from-primaryGreen via-green-500 to-emerald-600 rounded-full p-1 shadow-2xl">
                            <div class="w-full h-full rounded-full overflow-hidden bg-white dark:bg-gray-800">
                                <img src="{{ asset('images/CEO.jpg') }}" alt="Atarur Kabir Pramanik" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-gradient-to-br from-primaryGreen to-green-600 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Ataur Kabir Pramanik</h3>
                    <p class="text-primaryGreen font-semibold mb-2">CEO & Founder</p>
                    <div class="space-y-1 mb-4 text-sm text-gray-600 dark:text-gray-400">
                        <p class="font-medium">B.Sc In EEE (DUET)</p>
                        <p>Asst. Engineer</p>
                        <p>Dhaka Power Distribution Company</p>
                        <p class="text-primaryGreen font-semibold">Member Institute of Engineers, Bangladesh (IEB)</p>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Leading the vision and strategic direction of Bikolpo Live with extensive engineering background and professional expertise.
                    </p>
                </div>

                <!-- Team Member 2 -->
                <div class="group bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 text-center">
                    <div class="relative w-32 h-32 mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-br from-primaryBlue via-blue-500 to-indigo-600 rounded-full p-1 shadow-2xl">
                            <div class="w-full h-full rounded-full overflow-hidden bg-white dark:bg-gray-800">
                                <img src="{{ asset('images/CTO.jpg') }}" alt="Md. Aktarul Pramanik" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Md. Aktarul Pramanik (Aktar)</h3>
                    <p class="text-primaryBlue font-semibold mb-2">CTO</p>
                    <div class="space-y-1 mb-4 text-sm text-gray-600 dark:text-gray-400">
                        <p class="font-medium">B.Sc in CSE (GUB)</p>
                        <p class="text-primaryBlue font-semibold">Oracle Certified Professional (OCP)</p>
                        <p class="text-primaryBlue font-semibold">15+ Years of Industrial Experience</p>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Overseeing the technical architecture and development of our cutting-edge educational platform with extensive industry expertise.
                    </p>
                </div>

                <!-- Team Member 3 -->
                <div class="group bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-primaryPurple to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                        </svg>
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

</body>
</html>
