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
                    <a href="https://facebook.com/bikolpocomputer.rangpur" target="_blank" aria-label="Facebook" class="w-8 h-8 bg-white/10 hover:bg-primaryBlue rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <i class="fab fa-facebook-f text-white text-xs"></i>
                    </a>
                    <a href="https://wa.me/8801610800060" target="_blank" aria-label="WhatsApp" class="w-8 h-8 bg-white/10 hover:bg-green-600 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <i class="fab fa-whatsapp text-white text-xs"></i>
                    </a>
                    <a href="mailto:bikolpo247@gmail.com" aria-label="Email" class="w-8 h-8 bg-white/10 hover:bg-primaryOrange rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <i class="fas fa-envelope text-white text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white text-sm font-bold mb-3 flex items-center">
                    <i class="fas fa-link text-primaryGreen mr-2 text-xs"></i>
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
                    <i class="fas fa-phone text-primaryBlue mr-2 text-xs"></i>
                    Contact Info
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="flex items-center space-x-2 p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                        <div class="w-6 h-6 bg-primaryGreen rounded flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-white text-xs"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-white text-xs font-medium">Address</p>
                            <p class="text-gray-400 text-xs">উদ্ভাস কোচিং এর নিচতলা, কলেজ রোড, আলমনগর, রংপুর।</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                        <div class="w-6 h-6 bg-primaryBlue rounded flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-white text-xs"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-white text-xs font-medium">Phone</p>
                            <a href="https://wa.me/8801610800060" class="text-gray-400 hover:text-white transition-colors duration-300 text-xs">+880 1610800060</a>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                        <div class="w-6 h-6 bg-primaryOrange rounded flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-white text-xs"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-white text-xs font-medium">Email</p>
                            <a href="mailto:bikolpo247@gmail.com" class="text-gray-400 hover:text-white transition-colors duration-300 text-xs truncate block">bikolpo247@gmail.com</a>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-300">
                        <div class="w-6 h-6 bg-primaryPurple rounded flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock text-white text-xs"></i>
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
    <i class="fas fa-arrow-up text-sm"></i>
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