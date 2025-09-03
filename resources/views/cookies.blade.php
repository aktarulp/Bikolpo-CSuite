@extends('layouts.public')

@section('title', 'Cookies Policy - Bikolpo LQ')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-slate-900 via-gray-900 to-slate-800 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="text-primaryGreen">Cookies</span> Policy
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Learn about how we use cookies and similar technologies to enhance your experience.
                </p>
                <div class="mt-6 text-sm text-gray-400">
                    Last updated: {{ date('F d, Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Navigation -->
            <div class="bg-gray-50 px-8 py-6 border-b border-gray-200">
                <nav class="flex flex-wrap gap-4 text-sm">
                    <a href="#what-are-cookies" class="text-primaryBlue hover:text-primaryGreen transition-colors">What Are Cookies</a>
                    <a href="#how-we-use" class="text-primaryBlue hover:text-primaryGreen transition-colors">How We Use</a>
                    <a href="#types-of-cookies" class="text-primaryBlue hover:text-primaryGreen transition-colors">Types of Cookies</a>
                    <a href="#third-party" class="text-primaryBlue hover:text-primaryGreen transition-colors">Third Party</a>
                    <a href="#manage-cookies" class="text-primaryBlue hover:text-primaryGreen transition-colors">Manage Cookies</a>
                    <a href="#contact" class="text-primaryBlue hover:text-primaryGreen transition-colors">Contact</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="px-8 py-10">
                <div class="prose prose-lg max-w-none">
                    <!-- What Are Cookies -->
                    <section id="what-are-cookies" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-cookie-bite text-primaryOrange mr-3"></i>
                            What Are Cookies?
                        </h2>
                        <div class="bg-blue-50 border-l-4 border-primaryBlue p-6 mb-6">
                            <p class="text-gray-700 leading-relaxed">
                                Cookies are small text files that are stored on your device when you visit our website. 
                                They help us provide you with a better experience by remembering your preferences and 
                                enabling various website functions.
                            </p>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-green-800 mb-3 flex items-center">
                                    <i class="fas fa-info-circle text-green-600 mr-2"></i>
                                    How Cookies Work
                                </h3>
                                <ul class="text-gray-700 space-y-2 text-sm">
                                    <li>• Stored on your device's browser</li>
                                    <li>• Sent back to our server on future visits</li>
                                    <li>• Enable website functionality</li>
                                    <li>• Remember your preferences</li>
                                    <li>• Help us improve our services</li>
                                </ul>
                            </div>
                            
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-orange-800 mb-3 flex items-center">
                                    <i class="fas fa-shield-alt text-orange-600 mr-2"></i>
                                    Cookie Safety
                                </h3>
                                <ul class="text-gray-700 space-y-2 text-sm">
                                    <li>• Cannot access your personal files</li>
                                    <li>• Cannot spread viruses</li>
                                    <li>• Cannot access other websites</li>
                                    <li>• Can be deleted at any time</li>
                                    <li>• You control cookie settings</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <!-- How We Use -->
                    <section id="how-we-use" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-cogs text-primaryBlue mr-3"></i>
                            How We Use Cookies
                        </h2>
                        
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-primaryGreen rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Authentication & Security</h3>
                                    <p class="text-gray-700">Keep you logged in securely and protect your account from unauthorized access.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-primaryBlue rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-cog text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Preferences & Settings</h3>
                                    <p class="text-gray-700">Remember your language preferences, theme settings, and other customizations.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-primaryOrange rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-chart-line text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Analytics & Performance</h3>
                                    <p class="text-gray-700">Understand how you use our platform to improve performance and user experience.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-primaryPurple rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-graduation-cap text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Exam Functionality</h3>
                                    <p class="text-gray-700">Enable exam features like timer, auto-save, and progress tracking.</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Types of Cookies -->
                    <section id="types-of-cookies" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-list text-primaryGreen mr-3"></i>
                            Types of Cookies We Use
                        </h2>
                        
                        <div class="space-y-6">
                            <!-- Essential Cookies -->
                            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-red-800 mb-3 flex items-center">
                                    <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>
                                    Essential Cookies (Required)
                                </h3>
                                <p class="text-gray-700 leading-relaxed mb-4">
                                    These cookies are necessary for the website to function properly. They cannot be disabled and are set in response to actions you take.
                                </p>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">Session Management</h4>
                                        <ul class="text-gray-700 space-y-1 text-sm">
                                            <li>• Keep you logged in</li>
                                            <li>• Maintain exam sessions</li>
                                            <li>• Prevent unauthorized access</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">Security Features</h4>
                                        <ul class="text-gray-700 space-y-1 text-sm">
                                            <li>• CSRF protection</li>
                                            <li>• Form validation</li>
                                            <li>• Rate limiting</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Functional Cookies -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-blue-800 mb-3 flex items-center">
                                    <i class="fas fa-tools text-blue-600 mr-2"></i>
                                    Functional Cookies (Optional)
                                </h3>
                                <p class="text-gray-700 leading-relaxed mb-4">
                                    These cookies enable enhanced functionality and personalization. They may be set by us or third parties.
                                </p>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">User Preferences</h4>
                                        <ul class="text-gray-700 space-y-1 text-sm">
                                            <li>• Language settings</li>
                                            <li>• Theme preferences</li>
                                            <li>• Display options</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">Enhanced Features</h4>
                                        <ul class="text-gray-700 space-y-1 text-sm">
                                            <li>• Auto-save functionality</li>
                                            <li>• Progress tracking</li>
                                            <li>• Notification preferences</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Analytics Cookies -->
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-green-800 mb-3 flex items-center">
                                    <i class="fas fa-chart-bar text-green-600 mr-2"></i>
                                    Analytics Cookies (Optional)
                                </h3>
                                <p class="text-gray-700 leading-relaxed mb-4">
                                    These cookies help us understand how visitors interact with our website by collecting and reporting information anonymously.
                                </p>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">Usage Analytics</h4>
                                        <ul class="text-gray-700 space-y-1 text-sm">
                                            <li>• Page views and visits</li>
                                            <li>• User behavior patterns</li>
                                            <li>• Performance metrics</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">Improvement Data</h4>
                                        <ul class="text-gray-700 space-y-1 text-sm">
                                            <li>• Feature usage statistics</li>
                                            <li>• Error tracking</li>
                                            <li>• User feedback analysis</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Third Party -->
                    <section id="third-party" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-external-link-alt text-primaryPurple mr-3"></i>
                            Third-Party Cookies
                        </h2>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                            <h3 class="text-xl font-semibold text-yellow-800 mb-3 flex items-center">
                                <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
                                Third-Party Services
                            </h3>
                            <p class="text-gray-700 leading-relaxed">
                                We may use third-party services that set their own cookies. These services help us provide better functionality 
                                and analyze website performance. Each service has its own privacy policy and cookie practices.
                            </p>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-blue-800 mb-3">Analytics Services</h3>
                                <ul class="text-gray-700 space-y-2 text-sm">
                                    <li>• Google Analytics - Website traffic analysis</li>
                                    <li>• Performance monitoring tools</li>
                                    <li>• User experience tracking</li>
                                </ul>
                            </div>
                            
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-green-800 mb-3">Functional Services</h3>
                                <ul class="text-gray-700 space-y-2 text-sm">
                                    <li>• Content delivery networks</li>
                                    <li>• Security and monitoring services</li>
                                    <li>• Communication tools</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <!-- Manage Cookies -->
                    <section id="manage-cookies" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-sliders-h text-primaryOrange mr-3"></i>
                            Managing Your Cookie Preferences
                        </h2>
                        
                        <div class="space-y-6">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-blue-800 mb-3 flex items-center">
                                    <i class="fas fa-browser text-blue-600 mr-2"></i>
                                    Browser Settings
                                </h3>
                                <p class="text-gray-700 leading-relaxed mb-4">
                                    You can control cookies through your browser settings. Most browsers allow you to refuse cookies or delete them.
                                </p>
                                
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">Popular Browsers</h4>
                                        <ul class="text-gray-700 space-y-1 text-sm">
                                            <li>• <a href="#" class="text-primaryBlue hover:text-primaryGreen">Chrome</a> - Settings > Privacy</li>
                                            <li>• <a href="#" class="text-primaryBlue hover:text-primaryGreen">Firefox</a> - Options > Privacy</li>
                                            <li>• <a href="#" class="text-primaryBlue hover:text-primaryGreen">Safari</a> - Preferences > Privacy</li>
                                            <li>• <a href="#" class="text-primaryBlue hover:text-primaryGreen">Edge</a> - Settings > Cookies</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">Cookie Options</h4>
                                        <ul class="text-gray-700 space-y-1 text-sm">
                                            <li>• Accept all cookies</li>
                                            <li>• Block third-party cookies</li>
                                            <li>• Block all cookies</li>
                                            <li>• Delete existing cookies</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-green-800 mb-3 flex items-center">
                                    <i class="fas fa-exclamation-triangle text-green-600 mr-2"></i>
                                    Important Notice
                                </h3>
                                <p class="text-gray-700 leading-relaxed">
                                    <strong>Please note:</strong> Disabling certain cookies may affect the functionality of our website. 
                                    Essential cookies are required for the platform to work properly, and disabling them may prevent you 
                                    from accessing certain features or taking examinations.
                                </p>
                            </div>
                            
                            <!-- Cookie Consent Banner -->
                            <div class="bg-gradient-to-r from-primaryBlue to-primaryGreen rounded-lg p-6 text-white">
                                <h3 class="text-xl font-semibold mb-3">Cookie Consent</h3>
                                <p class="mb-4">
                                    When you first visit our website, you'll see a cookie consent banner. You can choose which types of cookies to accept.
                                </p>
                                <div class="flex flex-wrap gap-3">
                                    <button class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition-colors">
                                        Accept All
                                    </button>
                                    <button class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition-colors">
                                        Essential Only
                                    </button>
                                    <button class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition-colors">
                                        Customize
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Contact -->
                    <section id="contact" class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-envelope text-primaryBlue mr-3"></i>
                            Questions About Cookies?
                        </h2>
                        
                        <div class="bg-gradient-to-r from-primaryBlue to-primaryGreen rounded-lg p-8 text-white">
                            <h3 class="text-2xl font-bold mb-4">Contact Our Privacy Team</h3>
                            <p class="text-lg mb-6">
                                If you have any questions about our use of cookies or this Cookies Policy, 
                                please don't hesitate to contact us.
                            </p>
                            
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-semibold mb-2">Email</h4>
                                    <a href="mailto:bikolpo247@gmail.com" class="text-blue-200 hover:text-white transition-colors">
                                        bikolpo247@gmail.com
                                    </a>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2">Phone</h4>
                                    <a href="https://wa.me/8801610800060" class="text-blue-200 hover:text-white transition-colors">
                                        +880 1610800060
                                    </a>
                                </div>
                            </div>
                            
                            <div class="mt-6 bg-white/20 rounded-lg p-4">
                                <h4 class="font-semibold mb-2">Related Policies</h4>
                                <div class="flex flex-wrap gap-4 text-sm">
                                    <a href="{{ route('privacy') }}" class="text-blue-200 hover:text-white transition-colors">Privacy Policy</a>
                                    <a href="{{ route('terms') }}" class="text-blue-200 hover:text-white transition-colors">Terms of Service</a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
@endpush
