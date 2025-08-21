<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Partner Registration - বিকল্প কম্পিউটার</title>
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
                        primaryPurple: '#8b5cf6',
                        accent: '#f59e0b'
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out',
                        'fade-in-down': 'fadeInDown 0.6s ease-out',
                        'slide-in-right': 'slideInRight 0.6s ease-out',
                        'bounce-gentle': 'bounceGentle 2s infinite'
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        fadeInDown: {
                            '0%': { opacity: '0', transform: 'translateY(-30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideInRight: {
                            '0%': { opacity: '0', transform: 'translateX(30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' }
                        },
                        bounceGentle: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' }
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-blue-900 dark:to-indigo-900 text-gray-800 dark:text-gray-100 font-bangla min-h-screen">
    <!-- Background Pattern -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-primaryGreen/10 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-primaryBlue/10 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-accent/5 to-primaryPurple/5 rounded-full blur-3xl"></div>
    </div>

    <!-- Header -->
    <header class="relative bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-b border-white/20 dark:border-gray-700/50 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <a href="{{ route('landing') }}" class="flex items-center space-x-4 group">
                    <div class="relative">
                        <div class="w-14 h-14 bg-gradient-to-br from-primaryGreen via-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 transform group-hover:scale-105">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain" />
                        </div>
                        <div class="absolute -inset-1 bg-gradient-to-r from-primaryGreen to-green-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition-opacity duration-300"></div>
                    </div>
                    <div class="transform group-hover:translate-x-1 transition-transform duration-300">
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-primaryGreen to-green-600 bg-clip-text text-transparent">
                            বিকল্প কম্পিউটার
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Your Smart Exam Partner</p>
                    </div>
                </a>
                <a href="{{ route('partner.login') }}" class="group relative overflow-hidden bg-gradient-to-r from-primaryGreen to-green-600 text-white px-8 py-3 rounded-full font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <span class="relative z-10">Sign In</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-primaryGreen opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="relative z-10 py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="text-center mb-16 animate-fade-in-down">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-primaryGreen to-green-600 rounded-full shadow-2xl mb-8 animate-bounce-gentle">
                    <i class="fas fa-handshake text-white text-3xl"></i>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                    <span class="bg-gradient-to-r from-primaryGreen via-green-600 to-green-700 bg-clip-text text-transparent">
                        Partner Registration
                    </span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto leading-relaxed">
                    Join <span class="font-semibold text-primaryGreen">বিকল্প কম্পিউটার</span> as an educational partner and revolutionize the way students learn
                </p>
                <div class="flex items-center justify-center space-x-8 mt-8 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-check-circle text-primaryGreen"></i>
                        <span>Free to join</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-check-circle text-primaryGreen"></i>
                        <span>Instant access</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-check-circle text-primaryGreen"></i>
                        <span>24/7 support</span>
                    </div>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/50 overflow-hidden animate-fade-in-up">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-primaryGreen to-green-600 px-8 py-6 text-white">
                    <h2 class="text-2xl font-bold flex items-center space-x-3">
                        <i class="fas fa-user-plus text-2xl"></i>
                        <span>Create Your Partner Account</span>
                    </h2>
                    <p class="text-green-100 mt-2">Fill in the details below to get started</p>
                </div>

                <form action="{{ route('partner.register.store') }}" method="POST" class="p-8 space-y-8" id="partnerRegistrationForm">
                    @csrf
                    
                    <!-- Personal Information -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-primaryGreen to-green-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Personal Information</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label for="name" class="block mb-3 font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primaryGreen transition-colors duration-200">
                                    <i class="fas fa-user mr-2 text-primaryGreen"></i>Full Name *
                                </label>
                                <div class="relative">
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                        class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-gray-300" 
                                        placeholder="Enter your full name" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-user text-gray-400 group-hover:text-primaryGreen transition-colors duration-200"></i>
                                    </div>
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-2 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="group">
                                <label for="email" class="block mb-3 font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primaryGreen transition-colors duration-200">
                                    <i class="fas fa-envelope mr-2 text-primaryGreen"></i>Email Address *
                                </label>
                                <div class="relative">
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                        class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-gray-300" 
                                        placeholder="Enter your email address" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-envelope text-gray-400 group-hover:text-primaryGreen transition-colors duration-200"></i>
                                    </div>
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-2 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="group">
                                <label for="phone" class="block mb-3 font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primaryGreen transition-colors duration-200">
                                    <i class="fas fa-phone mr-2 text-primaryGreen"></i>Phone Number *
                                </label>
                                <div class="relative">
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                                        class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-gray-300" 
                                        placeholder="Enter your phone number" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-phone text-gray-400 group-hover:text-primaryGreen transition-colors duration-200"></i>
                                    </div>
                                </div>
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-2 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="group">
                                <label for="password" class="block mb-3 font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primaryGreen transition-colors duration-200">
                                    <i class="fas fa-lock mr-2 text-primaryGreen"></i>Password *
                                </label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" required
                                        class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-gray-300" 
                                        placeholder="Create a strong password" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-lock text-gray-400 group-hover:text-primaryGreen transition-colors duration-200"></i>
                                    </div>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-2 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="group">
                                <label for="password_confirmation" class="block mb-3 font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primaryGreen transition-colors duration-200">
                                    <i class="fas fa-shield-alt mr-2 text-primaryGreen"></i>Confirm Password *
                                </label>
                                <div class="relative">
                                    <input type="password" id="password_confirmation" name="password_confirmation" required
                                        class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-gray-300" 
                                        placeholder="Confirm your password" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-shield-alt text-gray-400 group-hover:text-primaryGreen transition-colors duration-200"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Organization Information -->
                    <div class="space-y-6 pt-8 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-building text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Organization Information</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label for="organization_name" class="block mb-3 font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primaryBlue transition-colors duration-200">
                                    <i class="fas fa-building mr-2 text-primaryBlue"></i>Organization Name *
                                </label>
                                <div class="relative">
                                    <input type="text" id="organization_name" name="organization_name" value="{{ old('organization_name') }}" required
                                        class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-primaryBlue focus:border-primaryBlue dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-gray-300" 
                                        placeholder="Enter organization name" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-building text-gray-400 group-hover:text-primaryBlue transition-colors duration-200"></i>
                                    </div>
                                </div>
                                @error('organization_name')
                                    <p class="text-red-500 text-sm mt-2 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="group">
                                <label for="organization_type" class="block mb-3 font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primaryBlue transition-colors duration-200">
                                    <i class="fas fa-graduation-cap mr-2 text-primaryBlue"></i>Organization Type *
                                </label>
                                <div class="relative">
                                    <select id="organization_type" name="organization_type" required
                                        class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-primaryBlue focus:border-primaryBlue dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-gray-300 appearance-none">
                                        <option value="">Select organization type</option>
                                        <option value="coaching_center" {{ old('organization_type') == 'coaching_center' ? 'selected' : '' }}>Coaching Center</option>
                                        <option value="school" {{ old('organization_type') == 'school' ? 'selected' : '' }}>School</option>
                                        <option value="college" {{ old('organization_type') == 'college' ? 'selected' : '' }}>College</option>
                                        <option value="university" {{ old('organization_type') == 'university' ? 'selected' : '' }}>University</option>
                                        <option value="training_institute" {{ old('organization_type') == 'training_institute' ? 'selected' : '' }}>Training Institute</option>
                                        <option value="other" {{ old('organization_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400 group-hover:text-primaryBlue transition-colors duration-200"></i>
                                    </div>
                                </div>
                                @error('organization_type')
                                    <p class="text-red-500 text-sm mt-2 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="space-y-6 pt-8 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-primaryOrange to-orange-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Address Information</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2 group">
                                <label for="address" class="block mb-3 font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primaryOrange transition-colors duration-200">
                                    <i class="fas fa-map-marker-alt mr-2 text-primaryOrange"></i>Full Address *
                                </label>
                                <div class="relative">
                                    <textarea id="address" name="address" rows="3" required
                                        class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-primaryOrange focus:border-primaryOrange dark:bg-gray-700 dark:text-white resize-none transition-all duration-200 group-hover:border-gray-300" 
                                        placeholder="Enter your complete address">{{ old('address') }}</textarea>
                                    <div class="absolute top-4 right-3">
                                        <i class="fas fa-map-marker-alt text-gray-400 group-hover:text-primaryOrange transition-colors duration-200"></i>
                                    </div>
                                </div>
                                @error('address')
                                    <p class="text-red-500 text-sm mt-2 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="group">
                                <label for="city" class="block mb-3 font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primaryOrange transition-colors duration-200">
                                    <i class="fas fa-city mr-2 text-primaryOrange"></i>City *
                                </label>
                                <div class="relative">
                                    <input type="text" id="city" name="city" value="{{ old('city') }}" required
                                        class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-primaryOrange focus:border-primaryOrange dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-gray-300" 
                                        placeholder="Enter city name" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-city text-gray-400 group-hover:text-primaryOrange transition-colors duration-200"></i>
                                    </div>
                                </div>
                                @error('city')
                                    <p class="text-red-500 text-sm mt-2 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="group">
                                <label for="state" class="block mb-3 font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primaryOrange transition-colors duration-200">
                                    <i class="fas fa-map mr-2 text-primaryOrange"></i>State/Province *
                                </label>
                                <div class="relative">
                                    <input type="text" id="state" name="state" value="{{ old('state') }}" required
                                        class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-primaryOrange focus:border-primaryOrange dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-gray-300" 
                                        placeholder="Enter state/province" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-map text-gray-400 group-hover:text-primaryOrange transition-colors duration-200"></i>
                                    </div>
                                </div>
                                @error('state')
                                    <p class="text-red-500 text-sm mt-2 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="group">
                                <label for="postal_code" class="block mb-3 font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primaryOrange transition-colors duration-200">
                                    <i class="fas fa-mail-bulk mr-2 text-primaryOrange"></i>Postal Code *
                                </label>
                                <div class="relative">
                                    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required
                                        class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-primaryOrange focus:border-primaryOrange dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-gray-300" 
                                        placeholder="Enter postal code" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-mail-bulk text-gray-400 group-hover:text-primaryOrange transition-colors duration-200"></i>
                                    </div>
                                </div>
                                @error('postal_code')
                                    <p class="text-red-500 text-sm mt-2 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="group">
                                <label for="country" class="block mb-3 font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primaryOrange transition-colors duration-200">
                                    <i class="fas fa-globe mr-2 text-primaryOrange"></i>Country *
                                </label>
                                <div class="relative">
                                    <input type="text" id="country" name="country" value="{{ old('country') }}" required
                                        class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-primaryOrange focus:border-primaryOrange dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-gray-300" 
                                        placeholder="Enter country name" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-globe text-gray-400 group-hover:text-primaryOrange transition-colors duration-200"></i>
                                    </div>
                                </div>
                                @error('country')
                                    <p class="text-red-500 text-sm mt-2 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center pt-8">
                        <button type="submit" 
                            class="group relative overflow-hidden bg-gradient-to-r from-primaryGreen via-green-600 to-green-700 text-white font-bold px-16 py-5 rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105 hover:from-green-600 hover:via-green-700 hover:to-green-800">
                            <span class="relative z-10 flex items-center space-x-3">
                                <i class="fas fa-rocket text-xl group-hover:animate-bounce"></i>
                                <span class="text-lg">Register as Partner</span>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-green-700 to-green-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center pt-6">
                        <p class="text-gray-600 dark:text-gray-400 text-lg">
                            Already have an account? 
                            <a href="{{ route('partner.login') }}" class="text-primaryGreen hover:text-green-600 font-semibold hover:underline transition-all duration-200">
                                Sign In here
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Features Section -->
            <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8 animate-fade-in-up">
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-primaryGreen to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Track Progress</h3>
                    <p class="text-gray-600 dark:text-gray-400">Monitor student performance and track learning outcomes with detailed analytics</p>
                </div>
                
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-primaryBlue to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Manage Students</h3>
                    <p class="text-gray-600 dark:text-gray-400">Easily manage your student database and organize them into batches</p>
                </div>
                
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-primaryPurple to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <i class="fas fa-file-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Create Content</h3>
                    <p class="text-gray-600 dark:text-gray-400">Build custom question sets and exams tailored to your curriculum</p>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Form debugging
        document.getElementById('partnerRegistrationForm').addEventListener('submit', function(e) {
            console.log('Form submitted');
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);
            
            // Log form data
            const formData = new FormData(this);
            for (let [key, value] of formData.entries()) {
                if (key !== '_token') { // Don't log CSRF token
                    console.log(key + ':', value);
                }
            }
        });

        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
