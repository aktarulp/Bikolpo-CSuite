<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Verify Your Partner Account</h2>
                <p class="text-gray-600">বিকল্প কম্পিউটার - Partner Portal</p>
            </div>

            <div class="mb-6 text-sm text-gray-600 text-center">
                <p class="mb-3">Thanks for registering as a partner with বিকল্প কম্পিউটার!</p>
                <p>Before you can access your partner dashboard, please verify your email address by clicking on the verification link we just sent to your email.</p>
            </div>

            @if (session('resent'))
                <div class="mb-4 font-medium text-sm text-green-600 text-center">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            @if (session('verified'))
                <div class="mb-4 font-medium text-sm text-green-600 text-center">
                    Your email has been verified successfully! You can now access your partner dashboard.
                </div>
            @endif

            <div class="mt-6 flex flex-col space-y-3">
                <form method="POST" action="{{ route('partner.verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Resend Verification Email
                    </button>
                </form>

                <div class="text-center">
                    <a href="{{ route('partner.onboarding') }}" class="text-sm text-blue-600 hover:text-blue-500">
                        Back to Login
                    </a>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="text-xs text-gray-500 text-center">
                    <p>Didn't receive the email? Check your spam folder or</p>
                    <p>contact support if you continue to have issues.</p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
