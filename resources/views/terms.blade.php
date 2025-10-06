@extends('layouts.public')

@section('title', 'Terms of Service - Bikolpo Live')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-slate-900 via-gray-900 to-slate-800 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="text-primaryGreen">Terms of</span> Service
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Please read these terms carefully before using our online examination platform.
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
                    <a href="#acceptance" class="text-primaryBlue hover:text-primaryGreen transition-colors">Acceptance</a>
                    <a href="#services" class="text-primaryBlue hover:text-primaryGreen transition-colors">Services</a>
                    <a href="#user-accounts" class="text-primaryBlue hover:text-primaryGreen transition-colors">User Accounts</a>
                    <a href="#conduct" class="text-primaryBlue hover:text-primaryGreen transition-colors">User Conduct</a>
                    <a href="#intellectual-property" class="text-primaryBlue hover:text-primaryGreen transition-colors">Intellectual Property</a>
                    <a href="#liability" class="text-primaryBlue hover:text-primaryGreen transition-colors">Liability</a>
                    <a href="#termination" class="text-primaryBlue hover:text-primaryGreen transition-colors">Termination</a>
                    <a href="#changes" class="text-primaryBlue hover:text-primaryGreen transition-colors">Changes</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="px-8 py-10">
                <div class="prose prose-lg max-w-none">
                    <!-- Acceptance -->
                    <section id="acceptance" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-handshake text-primaryGreen mr-3"></i>
                            Acceptance of Terms
                        </h2>
                        <div class="bg-blue-50 border-l-4 border-primaryBlue p-6 mb-6">
                            <p class="text-gray-700 leading-relaxed">
                                By accessing and using Bikolpo Live's online examination platform, you accept and agree to be bound by the terms 
                                and provision of this agreement. If you do not agree to abide by the above, please do not use this service.
                            </p>
                        </div>
                        <p class="text-gray-700 leading-relaxed">
                            These Terms of Service ("Terms") govern your use of our website and services operated by Bikolpo Live. 
                            Your use of our service is also subject to our Privacy Policy.
                        </p>
                    </section>

                    <!-- Services -->
                    <section id="services" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-graduation-cap text-primaryBlue mr-3"></i>
                            Description of Services
                        </h2>
                        
                        <div class="space-y-6">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-green-800 mb-3 flex items-center">
                                    <i class="fas fa-laptop text-green-600 mr-2"></i>
                                    Online Examination Platform
                                </h3>
                                <p class="text-gray-700 leading-relaxed">
                                    Bikolpo Live provides a comprehensive online examination platform that enables educational institutions 
                                    to conduct secure, reliable, and efficient online assessments for their students.
                                </p>
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-blue-800 mb-2">For Students</h3>
                                    <ul class="text-gray-700 space-y-1 text-sm">
                                        <li>• Take online examinations</li>
                                        <li>• View exam results and feedback</li>
                                        <li>• Access study materials</li>
                                        <li>• Track academic progress</li>
                                    </ul>
                                </div>
                                
                                <div class="bg-orange-50 border border-orange-200 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-orange-800 mb-2">For Institutions</h3>
                                    <ul class="text-gray-700 space-y-1 text-sm">
                                        <li>• Create and manage exams</li>
                                        <li>• Monitor student performance</li>
                                        <li>• Generate detailed reports</li>
                                        <li>• Manage student accounts</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- User Accounts -->
                    <section id="user-accounts" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-user-circle text-primaryOrange mr-3"></i>
                            User Accounts
                        </h2>
                        
                        <div class="space-y-6">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-yellow-800 mb-3 flex items-center">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                                    Account Responsibility
                                </h3>
                                <ul class="text-gray-700 space-y-2">
                                    <li>• You are responsible for maintaining the confidentiality of your account</li>
                                    <li>• You must provide accurate and complete information</li>
                                    <li>• You are responsible for all activities under your account</li>
                                    <li>• You must notify us immediately of any unauthorized use</li>
                                </ul>
                            </div>
                            
                            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-red-800 mb-3 flex items-center">
                                    <i class="fas fa-ban text-red-600 mr-2"></i>
                                    Prohibited Activities
                                </h3>
                                <ul class="text-gray-700 space-y-2">
                                    <li>• Creating multiple accounts for the same person</li>
                                    <li>• Sharing account credentials with others</li>
                                    <li>• Using accounts for fraudulent purposes</li>
                                    <li>• Attempting to gain unauthorized access</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <!-- User Conduct -->
                    <section id="conduct" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-gavel text-primaryPurple mr-3"></i>
                            User Conduct
                        </h2>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h3 class="text-xl font-semibold text-gray-900 mb-4">Acceptable Use</h3>
                                <div class="space-y-3">
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                        <p class="text-gray-700 text-sm">Use the platform for legitimate educational purposes</p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                        <p class="text-gray-700 text-sm">Respect other users and maintain professional conduct</p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                        <p class="text-gray-700 text-sm">Follow all examination rules and guidelines</p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                        <p class="text-gray-700 text-sm">Report any technical issues or concerns</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <h3 class="text-xl font-semibold text-gray-900 mb-4">Prohibited Conduct</h3>
                                <div class="space-y-3">
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-times-circle text-red-500 mt-1"></i>
                                        <p class="text-gray-700 text-sm">Cheating or attempting to cheat during examinations</p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-times-circle text-red-500 mt-1"></i>
                                        <p class="text-gray-700 text-sm">Sharing exam questions or answers</p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-times-circle text-red-500 mt-1"></i>
                                        <p class="text-gray-700 text-sm">Using unauthorized software or tools</p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-times-circle text-red-500 mt-1"></i>
                                        <p class="text-gray-700 text-sm">Harassment or inappropriate behavior</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Intellectual Property -->
                    <section id="intellectual-property" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-copyright text-primaryBlue mr-3"></i>
                            Intellectual Property Rights
                        </h2>
                        
                        <div class="space-y-6">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-blue-800 mb-3">Our Rights</h3>
                                <p class="text-gray-700 leading-relaxed mb-4">
                                    The Bikolpo Live platform, including its design, functionality, and content, is protected by intellectual property laws. 
                                    All rights, title, and interest in the platform remain with Bikolpo Live.
                                </p>
                                <ul class="text-gray-700 space-y-1">
                                    <li>• Platform software and code</li>
                                    <li>• User interface and design elements</li>
                                    <li>• Documentation and training materials</li>
                                    <li>• Trademarks and branding</li>
                                </ul>
                            </div>
                            
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-green-800 mb-3">Your Rights</h3>
                                <p class="text-gray-700 leading-relaxed">
                                    You retain ownership of content you create and submit through our platform, such as exam questions, 
                                    student responses, and other educational materials. By using our services, you grant us a license 
                                    to use this content for the purpose of providing our services.
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Liability -->
                    <section id="liability" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-shield-alt text-primaryPurple mr-3"></i>
                            Limitation of Liability
                        </h2>
                        
                        <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                            <h3 class="text-xl font-semibold text-red-800 mb-3 flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                                Disclaimer of Warranties
                            </h3>
                            <p class="text-gray-700 leading-relaxed">
                                Our services are provided "as is" without warranties of any kind. We do not guarantee that our services 
                                will be uninterrupted, error-free, or completely secure. While we strive to maintain high service quality, 
                                we cannot guarantee 100% uptime or absolute security.
                            </p>
                        </div>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-yellow-800 mb-3 flex items-center">
                                <i class="fas fa-balance-scale text-yellow-600 mr-2"></i>
                                Limitation of Damages
                            </h3>
                            <p class="text-gray-700 leading-relaxed">
                                To the maximum extent permitted by law, Bikolpo Live shall not be liable for any indirect, incidental, 
                                special, consequential, or punitive damages, including but not limited to loss of profits, data, or 
                                business opportunities, arising from your use of our services.
                            </p>
                        </div>
                    </section>

                    <!-- Termination -->
                    <section id="termination" class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-user-times text-red-500 mr-3"></i>
                            Account Termination
                        </h2>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-blue-800 mb-3">By You</h3>
                                <p class="text-gray-700 leading-relaxed mb-3">
                                    You may terminate your account at any time by contacting our support team. 
                                    Upon termination, your access to the platform will be revoked.
                                </p>
                                <p class="text-gray-700 text-sm">
                                    Note: Some data may be retained for legal or educational record-keeping purposes.
                                </p>
                            </div>
                            
                            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-red-800 mb-3">By Us</h3>
                                <p class="text-gray-700 leading-relaxed mb-3">
                                    We reserve the right to suspend or terminate accounts that violate these terms, 
                                    engage in fraudulent activities, or pose a security risk.
                                </p>
                                <p class="text-gray-700 text-sm">
                                    We will provide reasonable notice when possible, except in cases of serious violations.
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Changes -->
                    <section id="changes" class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-edit text-primaryGreen mr-3"></i>
                            Changes to Terms
                        </h2>
                        
                        <div class="bg-gradient-to-r from-primaryBlue to-primaryGreen rounded-lg p-8 text-white">
                            <h3 class="text-2xl font-bold mb-4">Updates to These Terms</h3>
                            <p class="text-lg mb-6">
                                We may update these Terms of Service from time to time. We will notify users of any material changes 
                                through email or platform notifications. Continued use of our services after changes constitutes 
                                acceptance of the updated terms.
                            </p>
                            
                            <div class="bg-white/20 rounded-lg p-4">
                                <h4 class="font-semibold mb-2">Contact Information</h4>
                                <p class="text-sm">
                                    If you have questions about these terms, please contact us at 
                                    <a href="mailto:bikolpo247@gmail.com" class="text-blue-200 hover:text-white transition-colors">
                                        bikolpo247@gmail.com
                                    </a>
                                </p>
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
