<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-8 p-6 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-200 dark:border-green-700 rounded-2xl shadow-lg">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-green-800 dark:text-green-200 mb-2">
                        🎉 Registration Successful!
                    </h3>
                    <p class="text-green-700 dark:text-green-300 leading-relaxed">
                        {{ session('success') }}
                    </p>
                    <div class="mt-4 p-3 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-green-200 dark:border-green-600">
                        <p class="text-sm text-green-600 dark:text-green-400 font-medium">
                            <i class="fas fa-info-circle mr-2"></i>
                            You can now login with your email and password to access your partner dashboard.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Simple Login Container -->
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <div class="mx-auto h-12 w-12 bg-green-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-building text-white text-xl"></i>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                    Partner Login
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    Sign in to your partner account
                </p>
            </div>

            <form class="mt-8 space-y-6" method="POST" action="{{ route('partner.login') }}">
                @csrf

                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white dark:bg-gray-700 rounded-t-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" 
                               placeholder="Email address" 
                               value="{{ old('email') }}">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white dark:bg-gray-700 rounded-b-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" 
                               placeholder="Password">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" 
                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                            Remember me
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-green-600 hover:text-green-500 dark:text-green-400 dark:hover:text-green-300">
                                Forgot your password?
                            </a>
                        </div>
                    @endif
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-sign-in-alt text-green-500 group-hover:text-green-400"></i>
                        </span>
                        Sign in
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Don't have an account? 
                        <a href="{{ route('partner.register') }}" class="font-medium text-green-600 hover:text-green-500 dark:text-green-400 dark:hover:text-green-300">
                            Register here
                        </a>
                    </p>
                </div>

                <div class="text-center">
                    <a href="{{ route('landing') }}" class="text-sm text-gray-500 hover:text-gray-400 dark:text-gray-400 dark:hover:text-gray-300">
                        ← Back to Home
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
