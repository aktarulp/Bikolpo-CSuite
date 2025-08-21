<x-guest-layout>
    <!-- OTP Verification Form -->
    <div class="w-full max-w-md">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-shield-alt text-3xl text-blue-600 dark:text-blue-400"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Verify OTP
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                We've sent a 6-digit verification code to your email. Please enter it below to continue.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-6" :status="session('status')" />

        <!-- OTP Verification Form -->
        <form method="POST" action="{{ route('password.verify-otp.store') }}" class="space-y-6">
            @csrf

            <!-- OTP Input -->
            <div class="space-y-2">
                <label for="otp" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Verification Code
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-key text-gray-400"></i>
                    </div>
                    <input 
                        id="otp" 
                        type="text" 
                        name="otp" 
                        :value="old('otp')" 
                        required 
                        autofocus
                        maxlength="6"
                        pattern="[0-9]{6}"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-center text-lg tracking-widest"
                        placeholder="000000"
                    />
                </div>
                <x-input-error :messages="$errors->get('otp')" class="mt-1" />
                <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                    Enter the 6-digit code sent to your email
                </p>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                <i class="fas fa-check mr-2"></i>
                Verify OTP
            </button>
        </form>

        <!-- Resend OTP -->
        <div class="text-center mt-6">
            <form method="POST" action="{{ route('password.resend-otp') }}" class="inline">
                @csrf
                <button 
                    type="submit"
                    class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-sm transition-colors duration-200"
                >
                    <i class="fas fa-redo mr-1"></i>
                    Didn't receive the code? Resend
                </button>
            </form>
        </div>

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

        <!-- Back to Forgot Password -->
        <div class="text-center">
            <a 
                href="{{ route('password.request') }}" 
                class="inline-flex items-center justify-center w-full bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-blue-500 hover:text-blue-600 dark:hover:text-blue-400 font-semibold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-[1.02]"
            >
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Forgot Password
            </a>
        </div>

        <!-- Back to Login -->
        <div class="text-center mt-4">
            <a 
                href="{{ route('login') }}" 
                class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200"
            >
                <i class="fas fa-sign-in-alt mr-1"></i>
                Back to Login
            </a>
        </div>
    </div>

    <!-- Auto-focus and formatting script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInput = document.getElementById('otp');
            
            // Auto-focus on OTP input
            otpInput.focus();
            
            // Format input to only allow numbers
            otpInput.addEventListener('input', function(e) {
                // Remove any non-numeric characters
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // Limit to 6 digits
                if (this.value.length > 6) {
                    this.value = this.value.slice(0, 6);
                }
            });
            
            // Auto-submit when 6 digits are entered
            otpInput.addEventListener('keyup', function(e) {
                if (this.value.length === 6) {
                    // Small delay to allow user to see the complete OTP
                    setTimeout(() => {
                        this.form.submit();
                    }, 500);
                }
            });
        });
    </script>
</x-guest-layout>
