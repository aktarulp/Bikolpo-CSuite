<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>যোগাযোগ করুন - Bikolpo LQ</title>
  <script src="https://cdn.tailwindcss.com"></script>
     <script>
         tailwind.config = {
             darkMode: 'class',
             theme: {
                 extend: {
                     fontFamily: {
                         bangla: ['"Hind Siliguri"', 'sans-serif']
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
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

 <body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 font-bangla">

         @include('navigation-layout');

  <!-- Hero Section -->
  <section class="relative bg-gradient-to-br from-primaryGreen/10 via-blue-50 to-indigo-100 dark:from-primaryGreen/20 dark:via-gray-800 dark:to-gray-900 py-16 lg:py-20">
      <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <div class="animate-fade-in">
              <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                  <span class="bg-gradient-to-r from-primaryGreen via-primaryBlue to-primaryPurple bg-clip-text text-transparent">
                      যোগাযোগ করুন
                  </span>
              </h1>
              <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-400 mb-8 max-w-3xl mx-auto leading-relaxed">
                  আমাদের সাথে যোগাযোগ করুন। আমরা আপনার প্রশ্নের উত্তর দিতে এবং সহায়তা করতে প্রস্তুত।
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
            <i class="fab fa-whatsapp text-white text-3xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">WhatsApp</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-6">দ্রুত যোগাযোগের জন্য WhatsApp ব্যবহার করুন</p>
                          <a href="https://wa.me/8801610800060?text=Hello! I would like to know more about Bikolpo LQ services." 
             target="_blank" 
             class="inline-flex items-center justify-center w-full bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
            <i class="fab fa-whatsapp mr-2"></i>
            WhatsApp এ মেসেজ করুন
          </a>
        </div>
      </div>

      <!-- Facebook Messenger -->
      <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 p-8 rounded-3xl shadow-lg border border-blue-200 dark:border-blue-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
        <div class="text-center">
          <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
            <i class="fab fa-facebook-messenger text-white text-3xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Facebook Messenger</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-6">Facebook Messenger এর মাধ্যমে আমাদের সাথে যোগাযোগ করুন</p>
          <a href="https://m.me/bikolpocomputer.rangpur" 
             target="_blank" 
             class="inline-flex items-center justify-center w-full bg-blue-500 hover:bg-blue-600 text-white font-bold px-6 py-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
            <i class="fab fa-facebook-messenger mr-2"></i>
            Messenger এ মেসেজ করুন
          </a>
        </div>
      </div>

      <!-- Phone Call -->
      <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/30 dark:to-orange-800/30 p-8 rounded-3xl shadow-lg border border-orange-200 dark:border-orange-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
        <div class="text-center">
          <div class="w-20 h-20 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
            <i class="fas fa-phone text-white text-3xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">ফোন কল</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-6">সরাসরি ফোনে কল করুন</p>
          <a href="tel:+8801610800060" 
             class="inline-flex items-center justify-center w-full bg-orange-500 hover:bg-orange-600 text-white font-bold px-6 py-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
            <i class="fas fa-phone mr-2"></i>
            +880 1610800060
          </a>
        </div>
      </div>
    </div>

    <!-- Contact Form and Info Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
      
      <!-- Contact Form -->
      <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
        <h2 class="text-3xl font-bold mb-8 text-primaryGreen text-center">যোগাযোগ ফরম</h2>
        <form action="#" method="POST" class="space-y-6">
          @csrf
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="name" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">
                <i class="fas fa-user mr-2 text-primaryGreen"></i>নাম
              </label>
              <input type="text" id="name" name="name" required
                class="w-full rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" 
                placeholder="আপনার নাম লিখুন" />
            </div>
            
            <div>
              <label for="email" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">
                <i class="fas fa-envelope mr-2 text-primaryGreen"></i>ইমেইল
              </label>
              <input type="email" id="email" name="email" required
                class="w-full rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" 
                placeholder="আপনার ইমেইল লিখুন" />
            </div>
          </div>

          <div>
            <label for="phone" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">
              <i class="fas fa-phone mr-2 text-primaryGreen"></i>ফোন নম্বর
            </label>
            <input type="tel" id="phone" name="phone"
              class="w-full rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" 
              placeholder="আপনার ফোন নম্বর লিখুন" />
          </div>

          <div>
            <label for="subject" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">
              <i class="fas fa-tag mr-2 text-primaryGreen"></i>বিষয়
            </label>
            <select id="subject" name="subject" required
              class="w-full rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200">
              <option value="">বিষয় নির্বাচন করুন</option>
              <option value="general">সাধারণ প্রশ্ন</option>
              <option value="technical">টেকনিক্যাল সাপোর্ট</option>
              <option value="partnership">পার্টনারশিপ</option>
              <option value="feedback">ফিডব্যাক</option>
              <option value="other">অন্যান্য</option>
            </select>
          </div>

          <div>
            <label for="message" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">
              <i class="fas fa-comment mr-2 text-primaryGreen"></i>মেসেজ
            </label>
            <textarea id="message" name="message" rows="5" required
              class="w-full rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primaryGreen focus:border-transparent dark:bg-gray-700 dark:text-white resize-none transition-all duration-200" 
              placeholder="আপনার মেসেজ লিখুন..."></textarea>
          </div>

          <button type="submit"
            class="w-full bg-gradient-to-r from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
            <i class="fas fa-paper-plane mr-2"></i>
            মেসেজ পাঠান
          </button>
        </form>
      </div>

      <!-- Contact Information -->
      <div class="space-y-8">
        
        <!-- Office Location -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
          <h3 class="text-2xl font-bold mb-6 text-primaryGreen flex items-center">
            <i class="fas fa-map-marker-alt mr-3 text-2xl"></i>
            অফিসের ঠিকানা
          </h3>
          <div class="space-y-4">
            <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
              <strong>উদ্ভাস কোচিং এর নিচ তলা</strong><br>
              কলেজ রোড, আলমনগর<br>
              রংপুর, বাংলাদেশ
            </p>
                         <a href="https://maps.app.goo.gl/FsgRXczVqRDAJBoT9" 
                target="_blank"
                class="inline-flex items-center justify-center w-full bg-red-500 hover:bg-red-600 text-white font-bold px-6 py-3 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105">
               <i class="fas fa-map-marked-alt mr-2"></i>
               Google Maps এ দেখুন
             </a>
          </div>
        </div>

        <!-- Contact Details -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
          <h3 class="text-2xl font-bold mb-6 text-primaryGreen flex items-center">
            <i class="fas fa-address-book mr-3 text-2xl"></i>
            যোগাযোগের তথ্য
          </h3>
          <div class="space-y-4">
            <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
              <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fab fa-whatsapp text-white text-xl"></i>
              </div>
              <div>
                <p class="font-semibold text-gray-900 dark:text-white">WhatsApp</p>
                <a href="https://wa.me/8801610800060" class="text-green-600 hover:text-green-700 dark:text-green-400">+880 1610800060</a>
              </div>
            </div>

            <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
              <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-envelope text-white text-xl"></i>
              </div>
              <div>
                <p class="font-semibold text-gray-900 dark:text-white">ইমেইল</p>
                <a href="mailto:bikolpo247@gmail.com" class="text-blue-600 hover:text-blue-700 dark:text-blue-400">bikolpo247@gmail.com</a>
              </div>
            </div>

            <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
              <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-phone text-white text-xl"></i>
              </div>
              <div>
                <p class="font-semibold text-gray-900 dark:text-white">ফোন</p>
                <a href="tel:+8801610800060" class="text-orange-600 hover:text-orange-700 dark:text-orange-400">+880 1610800060</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Social Media -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
          <h3 class="text-2xl font-bold mb-6 text-primaryGreen flex items-center">
            <i class="fas fa-share-alt mr-3 text-2xl"></i>
            সোশ্যাল মিডিয়া
          </h3>
          <div class="grid grid-cols-2 gap-4">
            <a href="https://m.me/BikolpoComputer.Rangpur" 
               target="_blank"
               class="flex items-center justify-center p-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
              <i class="fab fa-facebook-messenger text-2xl mr-3"></i>
              <span class="font-semibold">Messenger</span>
            </a>
            
            <a href="https://wa.me/8801610800060" 
               target="_blank"
               class="flex items-center justify-center p-4 bg-green-600 hover:bg-green-700 text-white rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
              <i class="fab fa-whatsapp text-2xl mr-3"></i>
              <span class="font-semibold">WhatsApp</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    
  </main>

     <!-- Footer -->
     <footer class="bg-gray-900 text-gray-200 py-5 mt-auto">
         <div class="max-w-6xl mx-auto px-3 sm:flex sm:justify-between sm:items-center">
             <!-- Logo & Name -->
             <div class="flex items-center space-x-4 mb-6 sm:mb-0">
               <x-brand-logo 
                 size="lg" 
                 variant="footer" 
                 :href="route('landing')" 
                 :show-tagline="true" 
               />
             </div>

             <!-- Contact Info -->
             <div class="text-sm space-y-1 mb-5 sm:mb-0 ">
                 <p>🏠 ঠিকানা: উদ্ভাস কোচিং এর নিচ তলা, কলেজ রোড, আলমনগর, রংপুর।</p>
                 <p>📞 ফোন: <a href="https://wa.me/8801610800060" class="hover:text-white">+880 1610800060</a></p>
                 <p>✉️ ইমেইল: <a href="mailto:bikolpo247@gmail.com" class="hover:text-white">bikolpo247@gmail.com</a></p>
             </div>

             <!-- Social Links -->
             <div class="flex space-x-5 text-white text-2xl">
                 <a href="https://m.me/BikolpoComputer.Rangpur" target="_blank" aria-label="Messenger" class="hover:text-blue-600 transition">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-7 h-7" viewBox="0 0 24 24">
                         <path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.464.099 2.797.143v3.24l-1.92.001c-1.506 0-1.798.716-1.798 1.767v2.317h3.594l-.468 3.622h-3.126V24h6.127c.73 0 1.323-.593 1.323-1.324V1.325C24 .593 23.407 0 22.675 0z"/>
                     </svg>
                 </a>
             </div>
         </div>

         <div class="mt-4 text-center text-s text-white">
             © 2025 Bikolpo LQ. All rights reserved.
         </div>
     </footer>

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
         const contactForm = document.querySelector('form');
         contactForm.addEventListener('submit', function(e) {
             e.preventDefault();
             
             // Get form data
             const formData = new FormData(this);
             const name = formData.get('name');
             const email = formData.get('email');
             const phone = formData.get('phone');
             const subject = formData.get('subject');
             const message = formData.get('message');
             
             // Show success message (you can replace this with actual form submission)
             alert(`ধন্যবাদ ${name}! আপনার মেসেজ সফলভাবে পাঠানো হয়েছে। আমরা শীঘ্রই আপনার সাথে যোগাযোগ করব।`);
             
             // Reset form
             this.reset();
         });
     </script>

     <style>
         .bg-grid-pattern {
             background-image: 
                 linear-gradient(rgba(0,0,0,0.1) 1px, transparent 1px),
                 linear-gradient(90deg, rgba(0,0,0,0.1) 1px, transparent 1px);
             background-size: 20px 20px;
         }
         
         @keyframes fadeIn {
             from { opacity: 0; transform: translateY(20px); }
             to { opacity: 1; transform: translateY(0); }
         }
         
         @keyframes slideUp {
             from { opacity: 0; transform: translateY(40px); }
             to { opacity: 1; transform: translateY(0); }
         }
     </style>
 </body>
 </html>
