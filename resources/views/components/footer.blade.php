<!-- Footer -->
<footer class="bg-gradient-to-br from-slate-900 via-gray-900 to-slate-800 text-gray-300 relative overflow-hidden">
    <!-- Subtle Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 left-0 w-20 h-20 bg-primaryGreen rounded-full blur-2xl"></div>
        <div class="absolute bottom-0 right-0 w-24 h-24 bg-primaryBlue rounded-full blur-2xl"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-6">
            <!-- Brand & Social -->
            <div class="lg:col-span-1">
                <div class="flex items-center space-x-2 mb-3">
                    <x-brand-logo 
                        size="md" 
                        variant="minimal" 
                        :href="route('landing')" 
                        :show-tagline="false" 
                    />
                </div>
                <p class="text-gray-400 text-xs leading-relaxed mb-4">
                    Revolutionizing education in Bangladesh with cutting-edge online testing technology.
                </p>
                
                <!-- Social Media -->
                <div class="flex space-x-2">
                    <a href="https://www.facebook.com/BikolpoLive/" target="_blank" aria-label="Facebook" class="w-8 h-8 bg-white/10 hover:bg-primaryBlue rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                        </svg>
                    </a>
                    <a href="https://wa.me/8801610800060" target="_blank" aria-label="WhatsApp" class="w-8 h-8 bg-white/10 hover:bg-green-600 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </a>
                    <a href="mailto:bikolpo247@gmail.com" aria-label="Email" class="w-8 h-8 bg-white/10 hover:bg-primaryOrange rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white text-sm font-bold mb-3 flex items-center">
                    <svg class="w-3 h-3 text-primaryGreen mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5z"/>
                    </svg>
                    Quick Links
                </h3>
                <div class="grid grid-cols-2 gap-1">
                    <a href="{{ route('landing') }}" class="text-gray-400 hover:text-white transition-colors duration-300 text-xs py-1">Home</a>
                    <a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition-colors duration-300 text-xs py-1">About</a>
                    <a href="#features" class="text-gray-400 hover:text-white transition-colors duration-300 text-xs py-1">Features</a>
                    <a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition-colors duration-300 text-xs py-1">Contact</a>
                    <a href="{{ route('partner.features') }}" class="text-gray-400 hover:text-white transition-colors duration-300 text-xs py-1">Partners</a>
                    <a href="{{ route('student.features') }}" class="text-gray-400 hover:text-white transition-colors duration-300 text-xs py-1">Students</a>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="lg:col-span-2">
                <h3 class="text-white text-sm font-bold mb-3 flex items-center">
                    <svg class="w-3 h-3 text-primaryBlue mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 15.5c-1.25 0-2.45-.2-3.57-.57-.35-.11-.74-.03-1.02.24l-2.2 2.2c-2.83-1.44-5.15-3.75-6.59-6.59l2.2-2.21c.28-.26.36-.65.25-1C8.7 6.45 8.5 5.25 8.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1zM12 3v10l3-3h6V3h-9z"/>
                    </svg>
                    Contact Info
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="flex items-center space-x-2 p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                        <div class="w-6 h-6 bg-primaryGreen rounded flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-white text-xs font-medium">Address</p>
                            <p class="text-gray-400 text-xs">উদ্ভাস কোচিং এর নিচতলা, কলেজ রোড, আলমনগর, রংপুর।</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                        <div class="w-6 h-6 bg-primaryBlue rounded flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-white text-xs font-medium">Phone</p>
                            <a href="https://wa.me/8801610800060" class="text-gray-400 hover:text-white transition-colors duration-300 text-xs">+880 1610800060</a>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                        <div class="w-6 h-6 bg-primaryOrange rounded flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-white text-xs font-medium">Email</p>
                            <a href="mailto:bikolpo247@gmail.com" class="text-gray-400 hover:text-white transition-colors duration-300 text-xs truncate block">bikolpo247@gmail.com</a>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                        <div class="w-6 h-6 bg-primaryPurple rounded flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                                <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-white text-xs font-medium">Support</p>
                            <p class="text-gray-400 text-xs">24/7 Online</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-white/10 pt-4">
            <div class="flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
                <div class="text-white-400 text-s">
                    © 2025 <span class="text-primaryGreen font-semibold">Bikolpo Live</span>. All rights reserved.
                </div>
                <div class="flex flex-wrap justify-center sm:justify-end space-x-4 text-xs">
                    <a href="{{ route('privacy') }}" class="text-gray-400 hover:text-white transition-colors duration-300">Privacy</a>
                    <a href="{{ route('terms') }}" class="text-gray-400 hover:text-white transition-colors duration-300">Terms</a>
                    <a href="{{ route('cookies') }}" class="text-gray-400 hover:text-white transition-colors duration-300">Cookies</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button id="backToTop" class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-br from-primaryGreen to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 opacity-0 invisible border border-white/20 backdrop-blur-sm">
    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
        <path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6z"/>
    </svg>
</button>

<script>
    // Back to Top Button
    const backToTopBtn = document.getElementById('backToTop');
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTopBtn.classList.remove('opacity-0', 'invisible');
            backToTopBtn.classList.add('opacity-100', 'visible');
        } else {
            backToTopBtn.classList.add('opacity-0', 'invisible');
            backToTopBtn.classList.remove('opacity-100', 'visible');
        }
    });
    
    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>