@extends('layouts.public')

@section('title', 'Registration Successful - BikolpoLive')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
  <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden">
    <div class="p-8">
      <div class="text-center">
        <!-- Success Icon -->
        <div class="mx-auto flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full mb-6">
          <svg class="w-12 h-12 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        
        <!-- Success Message -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
          Registration Successful!
        </h1>
        
        <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
          Your account has been created successfully.
        </p>
        
        <!-- Action Buttons -->
        <div class="space-y-4 mb-8">
          <!-- Login Button -->
          <a href="{{ route('login') }}" 
             class="w-full inline-flex justify-center items-center py-4 px-6 bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-all duration-300 transform hover:-translate-y-0.5">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Sign In to Your Account
          </a>
          
          <!-- Home Button -->
          <a href="{{ route('landing') }}" 
             class="w-full inline-flex justify-center items-center py-4 px-6 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
            <i class="fas fa-home mr-2"></i>
            Back to Home
          </a>
        </div>
        
        <!-- Additional Info -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
          <div class="flex items-start space-x-3">
            <i class="fas fa-info-circle text-blue-500 mt-1"></i>
            <div class="text-left">
              <h4 class="font-semibold text-blue-800 dark:text-blue-200 mb-1">Next Steps</h4>
              <p class="text-sm text-blue-700 dark:text-blue-300">
                After signing in, you can configure your profile and start creating exams for your students.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection