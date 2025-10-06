@extends('layouts.public')

@section('title', 'Privacy Policy - Bikolpo Live')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-slate-900 via-gray-900 to-slate-800 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="text-primaryGreen">Privacy</span> Policy
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Your privacy is important to us. Learn how we collect, use, and protect your personal information.
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
                    <a href="#introduction" class="text-primaryBlue hover:text-primaryGreen transition-colors">Introduction</a>
                    <a href="#information-collection" class="text-primaryBlue hover:text-primaryGreen transition-colors">Information Collection</a>
                    <a href="#data-usage" class="text-primaryBlue hover:text-primaryGreen transition-colors">Data Usage</a>
                    <a href="#data-protection" class="text-primaryBlue hover:text-primaryGreen transition-colors">Data Protection</a>
                    <a href="#cookies" class="text-primaryBlue hover:text-primaryGreen transition-colors">Cookies</a>
                    <a href="#user-rights" class="text-primaryBlue hover:text-primaryGreen transition-colors">Your Rights</a>
                    <a href="#contact" class="text-primaryBlue hover:text-primaryGreen transition-colors">Contact Us</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="px-8 py-10">
                <div class="prose prose-lg max-w-none">
                    <!-- Introduction -->
                    <section id="introduction" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-shield-alt text-primaryGreen mr-3"></i>
                            Introduction
                        </h2>
                        <div class="bg-blue-50 border-l-4 border-primaryBlue p-6 mb-6">
                            <p class="text-gray-700 leading-relaxed">
                                Bikolpo Live ("we," "our," or "us") is committed to protecting your privacy and personal information. 
                                This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use 
                                our online examination platform and related services.
                            </p>
                        </div>
                        <p class="text-gray-700 leading-relaxed">
                            By using our services, you agree to the collection and use of information in accordance with this policy. 
                            If you do not agree with the terms of this Privacy Policy, please do not access or use our services.
                        </p>
                    </section>

                    <!-- Information Collection -->
                    <section id="information-collection" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-database text-primaryBlue mr-3"></i>
                            Information We Collect
                        </h2>
                        
                        <div class="grid md:grid-cols-2 gap-6 mb-8">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-green-800 mb-3 flex items-center">
                                    <i class="fas fa-user text-green-600 mr-2"></i>
                                    Personal Information
                                </h3>
                                <ul class="text-gray-700 space-y-2">
                                    <li>• Name and contact information</li>
                                    <li>• Email address and phone number</li>
                                    <li>• Educational institution details</li>
                                    <li>• Student ID and academic information</li>
                                    <li>• Profile pictures (optional)</li>
                                </ul>
                            </div>
                            
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-blue-800 mb-3 flex items-center">
                                    <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                                    Usage Information
                                </h3>
                                <ul class="text-gray-700 space-y-2">
                                    <li>• Exam performance and results</li>
                                    <li>• Login times and session data</li>
                                    <li>• Device and browser information</li>
                                    <li>• IP address and location data</li>
                                    <li>• Platform interaction patterns</li>
                                </ul>
                            </div>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-yellow-800 mb-3 flex items-center">
                                <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                                Sensitive Information
                            </h3>
                            <p class="text-gray-700 leading-relaxed">
                                We may collect sensitive information such as academic records, exam answers, and performance data. 
                                This information is collected solely for educational purposes and is handled with the highest level of security.
                            </p>
                        </div>
                    </section>

                    <!-- Data Usage -->
                    <section id="data-usage" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-cogs text-primaryOrange mr-3"></i>
                            How We Use Your Information
                        </h2>
                        
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-primaryGreen rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-graduation-cap text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Educational Services</h3>
                                    <p class="text-gray-700">Providing online examinations, tracking academic progress, and delivering educational content.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-primaryBlue rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user-shield text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Account Management</h3>
                                    <p class="text-gray-700">Creating and managing user accounts, authenticating users, and providing customer support.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-primaryOrange rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-chart-bar text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Analytics & Improvement</h3>
                                    <p class="text-gray-700">Analyzing usage patterns to improve our services and develop new features.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-primaryPurple rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-bell text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Communication</h3>
                                    <p class="text-gray-700">Sending important updates, exam notifications, and responding to inquiries.</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Data Protection -->
                    <section id="data-protection" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-lock text-primaryPurple mr-3"></i>
                            Data Protection & Security
                        </h2>
                        
                        <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                            <h3 class="text-xl font-semibold text-red-800 mb-3 flex items-center">
                                <i class="fas fa-shield-alt text-red-600 mr-2"></i>
                                Security Measures
                            </h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <ul class="text-gray-700 space-y-2">
                                    <li>• SSL/TLS encryption for data transmission</li>
                                    <li>• Secure database storage with encryption</li>
                                    <li>• Regular security audits and updates</li>
                                    <li>• Access controls and authentication</li>
                                </ul>
                                <ul class="text-gray-700 space-y-2">
                                    <li>• Regular data backups</li>
                                    <li>• Employee training on data protection</li>
                                    <li>• Incident response procedures</li>
                                    <li>• Compliance with security standards</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-green-800 mb-3 flex items-center">
                                <i class="fas fa-clock text-green-600 mr-2"></i>
                                Data Retention
                            </h3>
                            <p class="text-gray-700 leading-relaxed">
                                We retain your personal information only for as long as necessary to fulfill the purposes outlined in this Privacy Policy, 
                                unless a longer retention period is required or permitted by law. Academic records may be retained for extended periods 
                                as required by educational regulations.
                            </p>
                        </div>
                    </section>

                    <!-- Cookies -->
                    <section id="cookies" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-cookie-bite text-primaryOrange mr-3"></i>
                            Cookies and Tracking
                        </h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            We use cookies and similar tracking technologies to enhance your experience on our platform. 
                            For detailed information about our cookie usage, please refer to our 
                            <a href="{{ route('cookies') }}" class="text-primaryBlue hover:text-primaryGreen transition-colors">Cookies Policy</a>.
                        </p>
                    </section>

                    <!-- User Rights -->
                    <section id="user-rights" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-user-check text-primaryGreen mr-3"></i>
                            Your Rights
                        </h2>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-eye text-primaryBlue mt-1"></i>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Access</h3>
                                        <p class="text-gray-700 text-sm">Request access to your personal data</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-edit text-primaryGreen mt-1"></i>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Correction</h3>
                                        <p class="text-gray-700 text-sm">Request correction of inaccurate data</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-trash text-red-500 mt-1"></i>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Deletion</h3>
                                        <p class="text-gray-700 text-sm">Request deletion of your data</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-download text-primaryOrange mt-1"></i>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Portability</h3>
                                        <p class="text-gray-700 text-sm">Request data in a portable format</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-ban text-yellow-500 mt-1"></i>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Restriction</h3>
                                        <p class="text-gray-700 text-sm">Request restriction of processing</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-exclamation-triangle text-red-500 mt-1"></i>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Objection</h3>
                                        <p class="text-gray-700 text-sm">Object to certain processing activities</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Contact -->
                    <section id="contact" class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-envelope text-primaryBlue mr-3"></i>
                            Contact Us
                        </h2>
                        
                        <div class="bg-gradient-to-r from-primaryBlue to-primaryGreen rounded-lg p-8 text-white">
                            <h3 class="text-2xl font-bold mb-4">Questions About This Privacy Policy?</h3>
                            <p class="text-lg mb-6">
                                If you have any questions about this Privacy Policy or our data practices, 
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
