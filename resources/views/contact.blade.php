<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Contact Us - Bikolpo Live</title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="{{ asset('images/BikolpoLive.svg') }}">
  <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('images/BikolpoLive.svg') }}">
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])
     <script>
         tailwind.config = {
             darkMode: 'class',
             theme: {
                 extend: {
                     fontFamily: {
                         bangla: ['"Nikosh"', '"Hind Siliguri"', 'sans-serif']
                     },
                     colors: {
                         primaryGreen: '#16a34a',
                         primaryOrange: '#f97316',
                         primaryBlue: '#3b82f6',
                         primaryPurple: '#8b5cf6'
                     },
                     animation: {
                         'fade-in': 'fadeIn 0.5s ease-in-out',
                         'slide-up': 'slideUp 0.6s ease-out',
                         'bounce-slow': 'bounce 2s infinite',
                         'pulse-slow': 'pulse 3s infinite'
                     }
                 }
             }
         }
     </script>

</head>

 <body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 font-sans">

         @include('navigation-layout');

  <!-- Hero Section -->
  <section class="relative bg-gradient-to-br from-primaryGreen/10 via-blue-50 to-indigo-100 dark:from-primaryGreen/20 dark:via-gray-800 dark:to-gray-900 py-16 lg:py-20">
      <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <div class="animate-fade-in">
              <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                  <span class="bg-gradient-to-r from-primaryGreen via-primaryBlue to-primaryPurple bg-clip-text text-transparent">
                      Contact Us
                  </span>
              </h1>
              <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-400 mb-8 max-w-3xl mx-auto leading-relaxed">
                  Get in touch with us. We are ready to answer your questions and provide assistance.
              </p>
          </div>
      </div>
  </section>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    <!-- Contact Methods Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
      
      <!-- WhatsApp Contact -->
      <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 p-8 rounded-3xl shadow-lg border border-green-200 dark:border-green-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
        <div class="text-center">
          <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">WhatsApp</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-6">Use WhatsApp for quick communication</p>
          <a href="https://wa.me/8801610800060?text=Hello! I would like to know more about Bikolpo Live services." 
             target="_blank" 
             class="inline-flex items-center justify-center w-full bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
            </svg>
            Message on WhatsApp
          </a>
        </div>
      </div>

      <!-- Facebook Messenger -->
      <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 p-8 rounded-3xl shadow-lg border border-blue-200 dark:border-blue-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
        <div class="text-center">
          <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.568 8.16l-1.61 7.592c-.12.566-.44.708-.89.44l-2.46-1.81-1.19 1.15c-.13.13-.24.24-.49.24l.18-2.56 4.57-4.12c.2-.18-.04-.28-.31-.1l-5.64 3.55-2.43-.76c-.53-.16-.54-.53.11-.79l9.57-3.69c.44-.16.83.1.68.79z"/>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Facebook Messenger</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-6">Contact us through Facebook Messenger</p>
          <a href="https://www.facebook.com/messages/t/bikolpolive" target="_blank" class="inline-flex items-center justify-center w-full bg-blue-500 hover:bg-blue-600 text-white font-bold px-6 py-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.568 8.16l-1.61 7.592c-.12.566-.44.708-.89.44l-2.46-1.81-1.19 1.15c-.13.13-.24.24-.49.24l.18-2.56 4.57-4.12c.2-.18-.04-.28-.31-.1l-5.64 3.55-2.43-.76c-.53-.16-.54-.53.11-.79l9.57-3.69c.44-.16.83.1.68.79z"/>
            </svg>
            Message on Messenger
          </a>
        </div>
      </div>

      <!-- Phone Call -->
      <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/30 dark:to-orange-800/30 p-8 rounded-3xl shadow-lg border border-orange-200 dark:border-orange-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
        <div class="text-center">
          <div class="w-20 h-20 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Phone Call</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-6">Call directly on phone</p>
          <a href="tel:+8801610800060" 
             class="inline-flex items-center justify-center w-full bg-orange-500 hover:bg-orange-600 text-white font-bold px-6 py-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
            </svg>
            +880 1610800060
          </a>
        </div>
      </div>
    </div>

    <!-- Contact Form and Info Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
      
      <!-- Contact Form -->
      <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
        <h2 class="text-3xl font-bold mb-8 text-primaryGreen text-center">Contact Form</h2>
        
        <!-- Success/Error Messages -->
        <div id="messageContainer" class="hidden mb-6">
            <div id="successMessage" class="hidden relative overflow-hidden bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-700 rounded-2xl shadow-lg">
                <div class="absolute inset-0 bg-gradient-to-r from-green-500/5 to-emerald-500/5"></div>
                <div class="relative p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-2">
                                Message Sent Successfully! 🎉
                            </h3>
                            <p id="successText" class="text-green-700 dark:text-green-300 leading-relaxed"></p>
                            <div class="mt-3 flex items-center text-sm text-green-600 dark:text-green-400">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                We'll get back to you within 24 hours
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="errorMessage" class="hidden relative overflow-hidden bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border border-red-200 dark:border-red-700 rounded-2xl shadow-lg">
                <div class="absolute inset-0 bg-gradient-to-r from-red-500/5 to-pink-500/5"></div>
                <div class="relative p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-pink-500 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2">
                                Oops! Something went wrong
                            </h3>
                            <p id="errorText" class="text-red-700 dark:text-red-300 leading-relaxed"></p>
                            <div class="mt-3 flex items-center text-sm text-red-600 dark:text-red-400">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.725-1.36 3.49 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Please try again or contact us directly
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <form id="contactForm" action="{{ route('contact.store') }}" method="POST" class="space-y-6">
          @csrf
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="name" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">
                <svg class="w-4 h-4 mr-2 text-primaryGreen" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>Name
              </label>
              <input type="text" id="name" name="name" required
                class="w-full rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" 
                placeholder="Enter your name" />
            </div>
            
            <div>
              <label for="email" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">
                <svg class="w-4 h-4 mr-2 text-primaryGreen" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                  <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                </svg>Email
              </label>
              <input type="email" id="email" name="email" required
                class="w-full rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" 
                placeholder="Enter your email" />
            </div>
          </div>

          <div>
            <label for="phone" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">
              <svg class="w-4 h-4 mr-2 text-primaryGreen" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
              </svg>Phone Number
            </label>
            <input type="tel" id="phone" name="phone"
              class="w-full rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" 
              placeholder="Enter your phone number" />
          </div>

          <div>
            <label for="subject" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">
              <svg class="w-4 h-4 mr-2 text-primaryGreen" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
              </svg>Subject
            </label>
            <select id="subject" name="subject" required
              class="w-full rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200">
              <option value="">Select a subject</option>
              <option value="general">General Question</option>
              <option value="technical">Technical Support</option>
              <option value="partnership">Partnership</option>
              <option value="feedback">Feedback</option>
              <option value="other">Other</option>
            </select>
          </div>

          <div>
            <label for="message" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">
              <svg class="w-4 h-4 mr-2 text-primaryGreen" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
              </svg>Message
            </label>
            <textarea id="message" name="message" rows="5" required
              class="w-full rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent dark:bg-gray-700 dark:text-white resize-none transition-all duration-200" 
              placeholder="Write your message..."></textarea>
          </div>

          <button type="submit"
            class="w-full bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
            </svg>
            Send Message
          </button>
        </form>
      </div>

      <!-- Contact Information -->
      <div class="space-y-8">
        
        <!-- Office Location -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
          <h3 class="text-2xl font-bold mb-6 text-primaryGreen flex items-center">
            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
            </svg>
            Office Address
          </h3>
          <div class="space-y-4">
            <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
              <strong>Ground Floor, Uddvas Coaching</strong><br>
              College Road, Alamnagar-5400<br>
              Rangpur, Bangladesh
            </p>
                         <a href="https://maps.app.goo.gl/FsgRXczVqRDAJBoT9" 
                target="_blank"
                class="inline-flex items-center justify-center w-full bg-red-500 hover:bg-red-600 text-white font-bold px-6 py-3 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105">
               <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                 <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
               </svg>
               View on Google Maps
             </a>
          </div>
        </div>

        <!-- Contact Details -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
          <h3 class="text-2xl font-bold mb-6 text-primaryGreen flex items-center">
            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
              <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
            </svg>
            Contact Information
          </h3>
          <div class="space-y-4">
            <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
              <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                </svg>
              </div>
              <div>
                <p class="font-semibold text-gray-900 dark:text-white">WhatsApp</p>
                <a href="https://wa.me/8801610800060" class="text-green-600 hover:text-green-700 dark:text-green-400">+880 1610800060</a>
              </div>
            </div>

            <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
              <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                  <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                </svg>
              </div>
              <div>
                <p class="font-semibold text-gray-900 dark:text-white">Email</p>
                <a href="mailto:bikolpo247@gmail.com" class="text-blue-600 hover:text-blue-700 dark:text-blue-400">bikolpo247@gmail.com</a>
              </div>
            </div>

            <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
              <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                </svg>
              </div>
              <div>
                <p class="font-semibold text-gray-900 dark:text-white">Phone</p>
                <a href="tel:+8801610800060" class="text-orange-600 hover:text-orange-700 dark:text-orange-400">+880 1610800060</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Social Media -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
          <h3 class="text-2xl font-bold mb-6 text-primaryGreen flex items-center">
            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3 3 0 000-2.38l4.94-2.47C13.456 7.68 14.19 8 15 8z"></path>
            </svg>
            Social Media
          </h3>
          <div class="grid grid-cols-2 gap-4">
            <a href="https://www.facebook.com/messages/t/bikolpolive" 
               target="_blank"
               class="flex items-center justify-center p-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
              <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.568 8.16l-1.61 7.592c-.12.566-.44.708-.89.44l-2.46-1.81-1.19 1.15c-.13.13-.24.24-.49.24l.18-2.56 4.57-4.12c.2-.18-.04-.28-.31-.1l-5.64 3.55-2.43-.76c-.53-.16-.54-.53.11-.79l9.57-3.69c.44-.16.83.1.68.79z"/>
              </svg>
              <span class="font-semibold">Messenger</span>
            </a>
            
            <a href="https://wa.me/8801610800060" 
               target="_blank"
               class="flex items-center justify-center p-4 bg-green-600 hover:bg-green-700 text-white rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
              <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
              </svg>
              <span class="font-semibold">WhatsApp</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    
  </main>

     <!-- Footer -->
     <x-footer />

     <script>
         // Dark Mode Toggle
         const darkToggle = document.getElementById('darkToggle');
         const html = document.documentElement;
         
         // Check for saved theme preference
         if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
             html.classList.add('dark');
         }
         
         darkToggle.addEventListener('click', () => {
             html.classList.toggle('dark');
             localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
         });

         // Mobile Menu Toggle
         const mobileMenuBtn = document.getElementById('mobileMenuBtn');
         const mobileMenu = document.getElementById('mobileMenu');
         
         mobileMenuBtn.addEventListener('click', () => {
             mobileMenu.classList.toggle('hidden');
         });

         // Header scroll effect
         const header = document.querySelector('header');
         window.addEventListener('scroll', () => {
             if (window.scrollY > 100) {
                 header.classList.add('shadow-lg', 'bg-white/95', 'dark:bg-gray-800/95');
             } else {
                 header.classList.remove('shadow-lg', 'bg-white/95', 'dark:bg-gray-800/95');
             }
         });

         // Form submission handling
         const contactForm = document.getElementById('contactForm');
         const messageContainer = document.getElementById('messageContainer');
         const successMessage = document.getElementById('successMessage');
         const errorMessage = document.getElementById('errorMessage');
         const successText = document.getElementById('successText');
         const errorText = document.getElementById('errorText');
         const submitButton = contactForm.querySelector('button[type="submit"]');
         
         contactForm.addEventListener('submit', function(e) {
             e.preventDefault();
             
             // Hide previous messages
             messageContainer.classList.add('hidden');
             successMessage.classList.add('hidden');
             errorMessage.classList.add('hidden');
             
             // Disable submit button and show loading state
             const originalButtonText = submitButton.innerHTML;
             submitButton.disabled = true;
             submitButton.innerHTML = `
                 <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                     <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                     <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                 </svg>
                 Sending...
             `;
             
             // Get form data
             const formData = new FormData(this);
             
             // Send AJAX request
             fetch(this.action, {
                 method: 'POST',
                 body: formData,
                 headers: {
                     'X-Requested-With': 'XMLHttpRequest',
                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token')
                 }
             })
             .then(response => response.json())
             .then(data => {
                 if (data.success) {
                     // Show success message
                     successText.textContent = data.message;
                     successMessage.classList.remove('hidden');
                     messageContainer.classList.remove('hidden');
                     
                     // Reset form
                     this.reset();
                     
                     // Scroll to message
                     messageContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                 } else {
                     // Show error message
                     errorText.textContent = data.message || 'An error occurred. Please try again.';
                     errorMessage.classList.remove('hidden');
                     messageContainer.classList.remove('hidden');
                     
                     // Scroll to message
                     messageContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                 }
             })
             .catch(error => {
                 console.error('Error:', error);
                 errorText.textContent = 'Network error. Please check your connection and try again.';
                 errorMessage.classList.remove('hidden');
                 messageContainer.classList.remove('hidden');
                 
                 // Scroll to message
                 messageContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
             })
             .finally(() => {
                 // Re-enable submit button
                 submitButton.disabled = false;
                 submitButton.innerHTML = originalButtonText;
             });
         });
     </script>

 </body>
 </html>
