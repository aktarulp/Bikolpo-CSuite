<x-guest-layout>
    <!-- Enhanced Register Form -->
    <div class="w-full max-w-md">
        <!-- Header Section -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                Create Account
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Join বিকল্প কম্পিউটার and start your learning journey
            </p>
        </div>

        <!-- Account Type Switch -->
        <div class="mb-6">
            <div class="flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-xl p-1">
                <button 
                    type="button" 
                    id="partnerRegisterBtn" 
                    class="flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 bg-primaryGreen text-white shadow-md text-sm"
                    onclick="switchRegisterType('partner')"
                >
                    <i class="fas fa-handshake mr-2"></i>
                    Partner
                </button>
                <button 
                    type="button" 
                    id="studentRegisterBtn" 
                    class="flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 text-sm"
                    onclick="switchRegisterType('student')"
                >
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Student
                </button>
            </div>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-4">
            @csrf
            <input type="hidden" name="register_type" id="registerType" value="partner">

            <!-- Name -->
            <div class="space-y-1" id="nameField">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Organization Name
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-building text-gray-400"></i>
                    </div>
                    <input 
                        id="name" 
                        type="text" 
                        name="name" 
                        :value="old('name')" 
                        required 
                        autofocus 
                        autocomplete="organization"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200"
                        placeholder="Enter your organization name"
                    />
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    <i class="fas fa-info-circle mr-1"></i>
                    Your Name if you are a Home Tutor
                </p>
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

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
                        autocomplete="username"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200"
                        placeholder="Enter your email address"
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
                        autocomplete="new-password"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200"
                        placeholder="Create a strong password"
                    />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-1">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Confirm Password
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
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent transition-all duration-200"
                        placeholder="Confirm your password"
                    />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <!-- Terms and Conditions -->
            <div class="flex items-start">
                <div class="flex items-center h-4">
                    <input 
                        id="terms" 
                        type="checkbox" 
                        required
                        class="w-4 h-4 text-primaryGreen bg-gray-100 border-gray-300 rounded focus:ring-primaryGreen focus:ring-2"
                    >
                </div>
                <div class="ml-2 text-xs">
                    <label for="terms" class="text-gray-600 dark:text-gray-400">
                        I agree to the 
                        <a href="#" class="text-primaryGreen hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 underline">
                            Terms and Conditions
                        </a>
                        and
                        <a href="#" class="text-primaryGreen hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 underline">
                            Privacy Policy
                        </a>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-2.5 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen"
            >
                <i class="fas fa-user-plus mr-2"></i>
                <span id="submitText">Create Partner Account</span>
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                    Already have an account?
                </span>
            </div>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <a 
                href="{{ route('login') }}" 
                class="inline-flex items-center justify-center w-full bg-white dark:bg-gray-800 border-2 border-primaryGreen text-primaryGreen hover:bg-primaryGreen hover:text-white font-semibold py-2.5 px-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02]"
            >
                <i class="fas fa-sign-in-alt mr-2"></i>
                Sign In
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
        function switchRegisterType(type) {
            const partnerBtn = document.getElementById('partnerRegisterBtn');
            const studentBtn = document.getElementById('studentRegisterBtn');
            const registerType = document.getElementById('registerType');
            const submitText = document.getElementById('submitText');
            const emailField = document.getElementById('emailField');
            const phoneField = document.getElementById('phoneField');
            const nameField = document.getElementById('nameField');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');
            const nameInput = document.getElementById('name');

            if (type === 'partner') {
                // Partner registration
                partnerBtn.className = 'flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 bg-primaryGreen text-white shadow-md text-sm';
                studentBtn.className = 'flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 text-sm';
                registerType.value = 'partner';
                submitText.textContent = 'Create Partner Account';
                
                // Show email field and name field, hide phone field
                emailField.classList.remove('hidden');
                phoneField.classList.add('hidden');
                nameField.classList.remove('hidden');
                
                // Set required attributes
                emailInput.required = true;
                phoneInput.required = false;
                nameInput.required = true;
                
                // Clear phone input when switching to partner
                phoneInput.value = '';
            } else {
                // Student registration
                studentBtn.className = 'flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 bg-primaryGreen text-white shadow-md text-sm';
                partnerBtn.className = 'flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 text-sm';
                registerType.value = 'student';
                submitText.textContent = 'Create Student Account';
                
                // Show phone field, hide email field and name field
                emailField.classList.add('hidden');
                phoneField.classList.remove('hidden');
                nameField.classList.add('hidden');
                
                // Set required attributes
                emailInput.required = false;
                phoneInput.required = true;
                nameInput.required = false;
                
                // Clear email and name inputs when switching to student
                emailInput.value = '';
                nameInput.value = '';
            }
        }

        // Initialize with partner registration selected
        document.addEventListener('DOMContentLoaded', function() {
            switchRegisterType('partner');
        });
    </script>
</x-guest-layout>
