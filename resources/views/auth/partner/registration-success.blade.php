<x-guest-layout>
    <div class="w-full max-w-md">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-3xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-check-circle text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Registration Successful!
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Welcome to বিকল্প কম্পিউটার
            </p>
        </div>

        <!-- Success Message -->
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-6 mb-6">
            <div class="text-center">
                <i class="fas fa-check-circle text-green-500 text-2xl mb-3"></i>
                <h3 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-2">
                    Account Created Successfully!
                </h3>
                <p class="text-green-700 dark:text-green-300 text-sm">
                    Your partner account has been created and verified. You can now access your dashboard.
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4">
            <a 
                href="{{ route('partner.dashboard') }}" 
                class="w-full bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 text-center inline-block"
            >
                <i class="fas fa-tachometer-alt mr-2"></i>
                Go to Dashboard
            </a>
            
            <a 
                href="{{ route('landing') }}" 
                class="w-full bg-white dark:bg-gray-800 border-2 border-primaryGreen text-primaryGreen hover:bg-primaryGreen hover:text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 text-center inline-block"
            >
                <i class="fas fa-home mr-2"></i>
                Back to Home
            </a>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
            <p>
                <i class="fas fa-info-circle mr-1"></i>
                You can now log in with your email and password
            </p>
        </div>
    </div>
</x-guest-layout>
