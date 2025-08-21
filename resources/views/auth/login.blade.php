<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Enhanced Login Form -->
    <div class="w-full max-w-md">
        <!-- Header Section -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                Welcome Back
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Sign in to your account to continue
            </p>
            @auth
            <p class="text-xs text-blue-600 dark:text-blue-400 mt-2">
                <i class="fas fa-info-circle mr-1"></i>
                You can log in with a different account or continue with your current session
            </p>
            @endauth
        </div>

        <!-- Logout Section for Authenticated Users -->
        @auth
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg">
            <div class="text-center">
                <p class="text-sm text-blue-700 dark:text-blue-300 mb-3">
                    <i class="fas fa-info-circle mr-2"></i>
                    You are currently logged in as <strong>{{ Auth::user()->name ?? 'User' }}</strong>
                </p>
                <div class="flex flex-col sm:flex-row gap-2 justify-center">
                    <a 
                        href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
                    >
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout Current Account
                    </a>
                    <a 
                        href="{{ Auth::user()->role === 'student' ? route('student.dashboard') : route('partner.dashboard') }}" 
                        class="inline-flex items-center justify-center bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
                    >
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Go to Dashboard
                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
        @endauth

        <!-- Login Type Switch -->
        <div class="mb-6">
            <div class="flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-xl p-1">
                <button 
                    type="button" 
                    id="partnerLoginBtn" 
                    class="flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 bg-primaryGreen text-white shadow-md text-sm"
                    onclick="switchLoginType('partner')"
                >
                    <i class="fas fa-handshake mr-2"></i>
                    Partner
                </button>
                <button 
                    type="button" 
                    id="studentLoginBtn" 
                    class="flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 text-sm"
                    onclick="switchLoginType('student')"
                >
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Student
                </button>
            </div>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-4">
            @csrf
            <input type="hidden" name="login_type" id="loginType" value="partner">

            <!-- Email Address (Partner) / Phone Number (Student) -->
            <div class="space-y-1" id="emailField">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Email Address
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        autofocus 
                        autocomplete="username"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200"
                        placeholder="Enter your email"
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Phone Number Field (Student) - Hidden by default -->
            <div class="space-y-1 hidden" id="phoneField">
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Phone Number
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-phone text-gray-400"></i>
                    </div>
                    <input 
                        id="phone" 
                        type="tel" 
                        name="phone" 
                        :value="old('phone')" 
                        autocomplete="tel"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200"
                        placeholder="01XXXXXXXXX (11 digits)"
                        pattern="01[3-9][0-9]{8}"
                        maxlength="11"
                    />
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Format: 01XXXXXXXXX (11 digits, starting with 01)
                </p>
                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="space-y-1">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Password
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
                        autocomplete="current-password"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200"
                        placeholder="Enter your password"
                    />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        name="remember"
                        class="w-4 h-4 text-primaryGreen bg-gray-100 border-gray-300 rounded focus:ring-primaryGreen focus:ring-2"
                    >
                    <span class="ml-2 text-xs text-gray-600 dark:text-gray-400">
                        Remember me
                    </span>
                </label>

                @if (Route::has('password.request'))
                    <a 
                        href="{{ route('password.request') }}" 
                        class="text-xs text-primaryGreen hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 transition-colors duration-200"
                    >
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-2.5 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen"
            >
                <i class="fas fa-sign-in-alt mr-2"></i>
                <span id="submitText">Sign In as Partner</span>
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                    New to বিকল্প কম্পিউটার?
                </span>
            </div>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <a 
                href="{{ route('partner.register') }}" 
                class="inline-flex items-center justify-center w-full bg-white dark:bg-gray-800 border-2 border-primaryGreen text-primaryGreen hover:bg-primaryGreen hover:text-white font-semibold py-2.5 px-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02]"
            >
                <i class="fas fa-user-plus mr-2"></i>
                Create Partner Account
            </a>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-4">
            <a 
                href="{{ route('landing') }}" 
                class="text-xs text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200"
            >
                <i class="fas fa-arrow-left mr-1"></i>
                Back to Home
            </a>
        </div>
    </div>

    <script>
        function switchLoginType(type) {
            const partnerBtn = document.getElementById('partnerLoginBtn');
            const studentBtn = document.getElementById('studentLoginBtn');
            const loginType = document.getElementById('loginType');
            const submitText = document.getElementById('submitText');
            const form = document.getElementById('loginForm');
            const emailField = document.getElementById('emailField');
            const phoneField = document.getElementById('phoneField');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');

            if (type === 'partner') {
                // Partner login
                partnerBtn.className = 'flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 bg-primaryGreen text-white shadow-md text-sm';
                studentBtn.className = 'flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 text-sm';
                loginType.value = 'partner';
                submitText.textContent = 'Sign In as Partner';
                form.action = '{{ route("login") }}';
                
                // Show email field, hide phone field
                emailField.classList.remove('hidden');
                phoneField.classList.add('hidden');
                
                // Set required attributes
                emailInput.required = true;
                phoneInput.required = false;
                
                // Clear phone input when switching to partner
                phoneInput.value = '';
            } else {
                // Student login
                studentBtn.className = 'flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 bg-primaryGreen text-white shadow-md text-sm';
                partnerBtn.className = 'flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 text-sm';
                loginType.value = 'student';
                submitText.textContent = 'Sign In as Student';
                form.action = '{{ route("login") }}';
                
                // Show phone field, hide email field
                emailField.classList.add('hidden');
                phoneField.classList.remove('hidden');
                
                // Set required attributes
                emailInput.required = false;
                phoneInput.required = true;
                
                // Clear email input when switching to student
                emailInput.value = '';
            }
        }

        // Initialize with partner login selected
        document.addEventListener('DOMContentLoaded', function() {
            switchLoginType('partner');
        });
    </script>
</x-guest-layout>
