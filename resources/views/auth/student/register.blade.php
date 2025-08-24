<x-guest-layout>
    <!-- Enhanced Student Registration Form -->
    <div class="w-full max-w-md">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-user-graduate text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Quick Student Registration
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Join বিকল্প কম্পিউটার in just 2 minutes
            </p>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('student.register.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="role_type" value="student">

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autocomplete="username"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Enter your email address"
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Create a strong password"
                    />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Confirm Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-shield-alt text-gray-400"></i>
                    </div>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Confirm your password"
                    />
                </div>
            </div>

            <!-- What Happens Next Section -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-4 border border-blue-200 dark:border-blue-700">
                <div class="flex items-center space-x-2 mb-3">
                    <i class="fas fa-info-circle text-blue-500 text-sm"></i>
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">What Happens Next?</h4>
                </div>
                <div class="space-y-2 text-xs text-gray-600 dark:text-gray-400">
                    <div class="flex items-start space-x-2">
                        <i class="fas fa-check-circle text-blue-500 mt-1 text-xs"></i>
                        <span>1. Verify your email address</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <i class="fas fa-check-circle text-blue-500 mt-1 text-xs"></i>
                        <span>2. Access your dashboard</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <i class="fas fa-check-circle text-blue-500 mt-1 text-xs"></i>
                        <span>3. Complete your profile later</span>
                    </div>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input 
                        id="terms" 
                        type="checkbox" 
                        required
                        class="w-4 h-4 text-blue-500 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                    >
                </div>
                <div class="ml-3 text-sm">
                    <label for="terms" class="text-gray-600 dark:text-gray-400">
                        I agree to the 
                        <a href="#" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 underline">
                            Terms and Conditions
                        </a>
                        and
                        <a href="#" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 underline">
                            Privacy Policy
                        </a>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                <i class="fas fa-rocket mr-2"></i>
                Start Learning Journey
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                    Already a student?
                </span>
            </div>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <a 
                href="{{ route('student.login') }}" 
                class="inline-flex items-center justify-center w-full bg-white dark:bg-gray-800 border-2 border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-[1.02]"
            >
                <i class="fas fa-sign-in-alt mr-2"></i>
                Student Login
            </a>
        </div>

        <!-- Account Type Selection -->
        <div class="text-center mt-6">
            <a 
                href="{{ route('landing') }}" 
                class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200"
            >
                <i class="fas fa-exchange-alt mr-1"></i>
                Different Account Type?
            </a>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-4">
            <a 
                href="{{ route('landing') }}" 
                class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200"
            >
                <i class="fas fa-arrow-left mr-1"></i>
                Back to Home
            </a>
        </div>
    </div>
</x-guest-layout>
