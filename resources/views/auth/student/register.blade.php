<x-guest-layout>
    <!-- Enhanced Student Registration Form -->
    <div class="w-full max-w-md">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-user-graduate text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Student Registration
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Join বিকল্প কম্পিউটার and start your learning journey
            </p>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('student.register.store') }}" class="space-y-6">
            @csrf

            <!-- Full Name -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input 
                        id="name" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus 
                        autocomplete="name"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Enter your full name"
                    />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

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

            <!-- Phone Number -->
            <div class="space-y-2">
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Phone Number <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-phone text-gray-400"></i>
                    </div>
                    <input 
                        id="phone" 
                        type="tel" 
                        name="phone" 
                        value="{{ old('phone') }}" 
                        required 
                        autocomplete="tel"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Enter your phone number"
                    />
                </div>
                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
            </div>

            <!-- Date of Birth -->
            <div class="space-y-2">
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Date of Birth <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar text-gray-400"></i>
                    </div>
                    <input 
                        id="date_of_birth" 
                        type="date" 
                        name="date_of_birth" 
                        value="{{ old('date_of_birth') }}" 
                        required
                        max="{{ date('Y-m-d', strtotime('-1 day')) }}"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                    />
                </div>
                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-1" />
            </div>

            <!-- Gender -->
            <div class="space-y-2">
                <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Gender <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-venus-mars text-gray-400"></i>
                    </div>
                    <select 
                        id="gender" 
                        name="gender" 
                        required
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                    >
                        <option value="">Select gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <x-input-error :messages="$errors->get('gender')" class="mt-1" />
            </div>

            <!-- Address -->
            <div class="space-y-2">
                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Address
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                    </div>
                    <textarea 
                        id="address" 
                        name="address" 
                        rows="2"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Enter your address (optional)"
                    >{{ old('address') }}</textarea>
                </div>
                <x-input-error :messages="$errors->get('address')" class="mt-1" />
            </div>

            <!-- City -->
            <div class="space-y-2">
                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    City
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-city text-gray-400"></i>
                    </div>
                    <input 
                        id="city" 
                        type="text" 
                        name="city" 
                        value="{{ old('city') }}" 
                        autocomplete="address-level2"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Enter your city (optional)"
                    />
                </div>
                <x-input-error :messages="$errors->get('city')" class="mt-1" />
            </div>

            <!-- School/College -->
            <div class="space-y-2">
                <label for="school_college" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    School/College
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-graduation-cap text-gray-400"></i>
                    </div>
                    <input 
                        id="school_college" 
                        type="text" 
                        name="school_college" 
                        value="{{ old('school_college') }}" 
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Enter your school/college name (optional)"
                    />
                </div>
                <x-input-error :messages="$errors->get('school_college')" class="mt-1" />
            </div>

            <!-- Class/Grade -->
            <div class="space-y-2">
                <label for="class_grade" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Class/Grade
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-chalkboard text-gray-400"></i>
                    </div>
                    <input 
                        id="class_grade" 
                        type="text" 
                        name="class_grade" 
                        value="{{ old('class_grade') }}" 
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Enter your class/grade (optional)"
                    />
                </div>
                <x-input-error :messages="$errors->get('class_grade')" class="mt-1" />
            </div>

            <!-- Parent Name -->
            <div class="space-y-2">
                <label for="parent_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Parent/Guardian Name
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-users text-gray-400"></i>
                    </div>
                    <input 
                        id="parent_name" 
                        type="text" 
                        name="parent_name" 
                        value="{{ old('parent_name') }}" 
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Enter parent/guardian name (optional)"
                    />
                </div>
                <x-input-error :messages="$errors->get('parent_name')" class="mt-1" />
            </div>

            <!-- Parent Phone -->
            <div class="space-y-2">
                <label for="parent_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Parent/Guardian Phone
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-phone text-gray-400"></i>
                    </div>
                    <input 
                        id="parent_phone" 
                        type="tel" 
                        name="parent_phone" 
                        value="{{ old('parent_phone') }}" 
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Enter parent/guardian phone (optional)"
                    />
                </div>
                <x-input-error :messages="$errors->get('parent_phone')" class="mt-1" />
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
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
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
                <i class="fas fa-user-plus mr-2"></i>
                Create Student Account
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
