<x-guest-layout>
    <!-- Password Reset Form -->
    <div class="w-full max-w-md">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-lock-open text-3xl text-green-600 dark:text-green-400"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Reset Password
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Enter your new password below to complete the reset process.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-6" :status="session('status')" />

        <!-- Password Reset Form -->
        <form method="POST" action="{{ route('password.reset.otp') }}" class="space-y-6">
            @csrf

            <!-- Email Address (Hidden) -->
            <input type="hidden" name="email" value="{{ $email }}">

            <!-- New Password -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    New Password
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
                        autofocus
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                        placeholder="Enter your new password"
                    />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Password must be at least 8 characters long
                </p>
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Confirm New Password
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                        placeholder="Confirm your new password"
                    />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <!-- Password Requirements -->
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Password Requirements:
                </h4>
                <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        At least 8 characters long
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Mix of uppercase and lowercase letters
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Include numbers and special characters
                    </li>
                </ul>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
            >
                <i class="fas fa-save mr-2"></i>
                Reset Password
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                    Need to go back?
                </span>
            </div>
        </div>

        <!-- Back to Login -->
        <div class="text-center">
            <a 
                href="{{ route('login') }}" 
                class="inline-flex items-center justify-center w-full bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-green-500 hover:text-green-600 dark:hover:text-green-400 font-semibold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-[1.02]"
            >
                <i class="fas fa-sign-in-alt mr-2"></i>
                Back to Login
            </a>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-4">
            <a 
                href="{{ route('landing') }}" 
                class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200"
            >
                <i class="fas fa-home mr-1"></i>
                Back to Home
            </a>
        </div>
    </div>
</x-guest-layout>
