<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quiz Start - {{ $exam->title }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --shadow-soft: 0 8px 32px rgba(31, 38, 135, 0.37);
            --shadow-strong: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        .font-mono {
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
        }
        
        .glass-effect {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-soft);
        }
        
        .gradient-text {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-section {
            background: var(--primary-gradient);
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            animation: float 20s ease-in-out infinite;
        }
        
        .timer-section {
            background: var(--danger-gradient);
            position: relative;
            overflow: hidden;
        }
        
        .info-section {
            background: var(--success-gradient);
        }
        
        .action-section {
            background: var(--warning-gradient);
        }
        
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-shape:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }
        
        .floating-shape:nth-child(3) {
            width: 100px;
            height: 100px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg); 
                opacity: 0.7;
            }
            50% { 
                transform: translateY(-20px) rotate(180deg); 
                opacity: 1;
            }
        }
        
        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }
        
        @keyframes pulseGlow {
            from { 
                box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
                transform: scale(1);
            }
            to { 
                box-shadow: 0 0 40px rgba(255, 255, 255, 0.6);
                transform: scale(1.05);
            }
        }
        
        .slide-up {
            animation: slideUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(30px);
        }
        
        .slide-up:nth-child(1) { animation-delay: 0.1s; }
        .slide-up:nth-child(2) { animation-delay: 0.2s; }
        .slide-up:nth-child(3) { animation-delay: 0.3s; }
        .slide-up:nth-child(4) { animation-delay: 0.4s; }
        
        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .progress-ring {
            transform: rotate(-90deg);
        }
        
        .progress-ring-circle {
            transition: stroke-dasharray 0.5s ease-in-out;
            stroke-linecap: round;
        }
        
        .info-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .info-card:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }
        
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
            animation: pulse 2s infinite;
        }
        
        .status-online {
            background: #10b981;
        }
        
        .status-ready {
            background: #f59e0b;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .instruction-item {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #10b981;
            transition: all 0.3s ease;
        }
        
        .instruction-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }
        
        .countdown-digit {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .geometric-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        
        .geometric-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }
        
        .text-shadow {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 1rem;
            }
            
            .countdown-digit {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 overflow-x-hidden">
    
    <!-- Geometric Background -->
    <div class="geometric-bg"></div>

    <div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-7xl w-full space-y-8">
            
            <!-- Hero Section -->
            <div class="hero-section rounded-3xl p-8 md:p-12 text-white relative overflow-hidden hover-lift">
                <!-- Floating Shapes -->
                <div class="floating-shape"></div>
                <div class="floating-shape"></div>
                <div class="floating-shape"></div>
                
                <!-- Main Content -->
                <div class="relative z-10 text-center">
                    <div class="mx-auto w-24 h-24 glass-effect rounded-3xl flex items-center justify-center mb-8 pulse-glow">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    
                    <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight text-shadow">
                        {{ $exam->title }}
                    </h1>
                    
                    <div class="inline-flex items-center px-6 py-3 glass-effect rounded-2xl border border-white/30 mb-8">
                        <span class="status-indicator status-online"></span>
                        <span class="text-lg font-medium">
                            Welcome, <span class="font-bold text-yellow-200">{{ $accessInfo['student_name'] }}</span>
                        </span>
                    </div>
                    
                    <p class="text-xl opacity-90 max-w-2xl mx-auto leading-relaxed">
                        Get ready to showcase your knowledge. The exam will begin shortly.
                    </p>
                </div>
            </div>

            <!-- Countdown Section -->
            <div class="timer-section rounded-3xl p-8 md:p-10 text-white text-center shadow-2xl hover-lift">
                <h2 class="text-3xl md:text-4xl font-bold mb-8 text-shadow">⏰ Exam Starts In</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
                    <div class="slide-up">
                        <div class="info-card rounded-2xl p-4 md:p-6">
                            <div class="countdown-digit text-3xl md:text-5xl mb-2" id="countdown-days">00</div>
                            <div class="text-sm md:text-lg font-medium opacity-90">Days</div>
                        </div>
                    </div>
                    <div class="slide-up">
                        <div class="info-card rounded-2xl p-4 md:p-6">
                            <div class="countdown-digit text-3xl md:text-5xl mb-2" id="countdown-hours">00</div>
                            <div class="text-sm md:text-lg font-medium opacity-90">Hours</div>
                        </div>
                    </div>
                    <div class="slide-up">
                        <div class="info-card rounded-2xl p-4 md:p-6">
                            <div class="countdown-digit text-3xl md:text-5xl mb-2" id="countdown-minutes">00</div>
                            <div class="text-sm md:text-lg font-medium opacity-90">Minutes</div>
                        </div>
                    </div>
                    <div class="slide-up">
                        <div class="info-card rounded-2xl p-4 md:p-6">
                            <div class="countdown-digit text-3xl md:text-5xl mb-2" id="countdown-seconds">00</div>
                            <div class="text-sm md:text-lg font-medium opacity-90">Seconds</div>
                        </div>
                    </div>
                </div>
                
                <!-- Circular Progress -->
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <svg class="w-24 h-24 md:w-32 md:h-32 progress-ring">
                            <circle class="text-white/20" stroke-width="6" stroke="currentColor" fill="transparent" r="40" cx="48" cy="48"></circle>
                            <circle class="progress-ring-circle text-white" stroke-width="6" stroke="currentColor" fill="transparent" r="40" cx="48" cy="48" 
                                    stroke-dasharray="251.2" stroke-dashoffset="0" id="progress-circle"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-lg md:text-2xl font-bold font-mono" id="progress-percentage">100%</span>
                        </div>
                    </div>
                </div>
                
                <div class="text-lg opacity-90 font-medium">Time Remaining</div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                
                <!-- Left Column: Exam Details -->
                <div class="xl:col-span-2 space-y-8">
                    
                    <!-- Exam Information Panel -->
                    <div class="info-section rounded-3xl p-6 md:p-8 text-white shadow-2xl hover-lift">
                        <h3 class="text-2xl md:text-3xl font-bold mb-8 flex items-center">
                            <div class="w-12 h-12 glass-effect rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            📋 Exam Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            <div class="space-y-4">
                                <div class="info-card rounded-xl p-4 md:p-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 glass-effect rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm opacity-80 font-medium">Duration</div>
                                            <div class="text-lg md:text-xl font-bold">{{ $exam->duration }} minutes</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="info-card rounded-xl p-4 md:p-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 glass-effect rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm opacity-80 font-medium">Questions</div>
                                            <div class="text-lg md:text-xl font-bold">{{ $exam->total_questions ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="info-card rounded-xl p-4 md:p-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 glass-effect rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm opacity-80 font-medium">Passing Marks</div>
                                            <div class="text-lg md:text-xl font-bold">{{ $exam->passing_marks }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="info-card rounded-xl p-4 md:p-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 glass-effect rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm opacity-80 font-medium">Start Time</div>
                                            <div class="text-lg md:text-xl font-bold font-mono">{{ $exam->start_time->format('M d, Y g:i A') }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="info-card rounded-xl p-4 md:p-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 glass-effect rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm opacity-80 font-medium">End Time</div>
                                            <div class="text-lg md:text-xl font-bold font-mono text-red-200">{{ $exam->end_time->format('M d, Y g:i A') }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="info-card rounded-xl p-4 md:p-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 glass-effect rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm opacity-80 font-medium">Current Time</div>
                                            <div class="text-lg md:text-xl font-bold font-mono" id="current-time">{{ now()->format('M d, Y g:i A') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Exam Description -->
                    @if($exam->description)
                    <div class="glass-card rounded-3xl p-6 md:p-8 shadow-2xl hover-lift">
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            📝 Exam Description
                        </h3>
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-6 border border-indigo-100">
                            <p class="text-gray-700 leading-relaxed text-lg">{{ $exam->description }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column: Instructions & Actions -->
                <div class="space-y-8">
                    
                    <!-- Instructions Panel -->
                    <div class="action-section rounded-3xl p-6 md:p-8 shadow-2xl hover-lift">
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            ⚠️ Important Instructions
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="instruction-item rounded-xl p-4 bg-white/20 backdrop-blur-sm">
                                <div class="flex items-start">
                                    <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-gray-700 font-medium">You have <strong class="text-green-600">{{ $exam->duration }} minutes</strong> to complete</span>
                                </div>
                            </div>
                            
                            <div class="instruction-item rounded-xl p-4 bg-white/20 backdrop-blur-sm">
                                <div class="flex items-start">
                                    <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-gray-700 font-medium">Timer starts immediately when you begin</span>
                                </div>
                            </div>
                            
                            <div class="instruction-item rounded-xl p-4 bg-white/20 backdrop-blur-sm">
                                <div class="flex items-start">
                                    <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-gray-700 font-medium">No pausing or restarting allowed</span>
                                </div>
                            </div>
                            
                            <div class="instruction-item rounded-xl p-4 bg-white/20 backdrop-blur-sm">
                                <div class="flex items-start">
                                    <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-gray-700 font-medium">Ensure stable internet connection</span>
                                </div>
                            </div>
                            
                            <div class="instruction-item rounded-xl p-4 bg-white/20 backdrop-blur-sm">
                                <div class="flex items-start">
                                    <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-gray-700 font-medium">Don't refresh or close browser</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-6">
                        <form method="POST" action="{{ route('public.quiz.start-quiz', $exam->id) }}">
                            @csrf
                            <button type="submit" 
                                    class="btn-primary w-full flex justify-center items-center py-4 md:py-5 px-8 rounded-2xl text-lg md:text-xl font-bold shadow-2xl">
                                <svg class="w-6 h-6 md:w-7 md:h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                🚀 Start Exam Now
                            </button>
                        </form>
                        
                        <a href="{{ route('public.quiz.access') }}" 
                           class="btn-secondary w-full flex justify-center items-center py-4 md:py-5 px-8 rounded-2xl text-lg md:text-xl font-medium shadow-lg">
                            <svg class="w-6 h-6 md:w-7 md:h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            ↩️ Go Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Professional Countdown Timer
        function updateCountdown() {
            const now = new Date();
            const examStart = new Date('{{ $exam->start_time }}');
            const timeDiff = examStart - now;
            
            if (timeDiff <= 0) {
                // Exam has started
                document.querySelectorAll('.slide-up').forEach(item => {
                    item.innerHTML = `
                        <div class="info-card rounded-2xl p-4 md:p-6">
                            <div class="countdown-digit text-3xl md:text-5xl mb-2">READY</div>
                            <div class="text-sm md:text-lg font-medium opacity-90">To Start</div>
                        </div>
                    `;
                });
                
                // Update circular progress
                const circle = document.getElementById('progress-circle');
                circle.style.strokeDasharray = '251.2';
                circle.style.strokeDashoffset = '251.2';
                document.getElementById('progress-percentage').textContent = '0%';
                return;
            }
            
            const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);
            
            // Update countdown display
            document.getElementById('countdown-days').textContent = days.toString().padStart(2, '0');
            document.getElementById('countdown-hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('countdown-minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('countdown-seconds').textContent = seconds.toString().padStart(2, '0');
            
            // Update circular progress
            const totalTime = examStart - new Date('{{ $exam->end_time }}');
            const remainingTime = examStart - now;
            const progress = Math.max(0, Math.min(100, (remainingTime / totalTime) * 100));
            
            const circle = document.getElementById('progress-circle');
            const circumference = 2 * Math.PI * 40; // r = 40
            const offset = circumference - (progress / 100) * circumference;
            circle.style.strokeDasharray = circumference;
            circle.style.strokeDashoffset = offset;
            
            document.getElementById('progress-percentage').textContent = Math.round(progress) + '%';
        }
        
        // Update current time every second
        function updateCurrentTime() {
            const now = new Date();
            const timeString = now.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            }) + ' ' + now.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });
            document.getElementById('current-time').textContent = timeString;
        }
        
        // Initialize countdown and time updates
        setInterval(updateCountdown, 1000);
        setInterval(updateCurrentTime, 1000);
        updateCountdown();
        updateCurrentTime();
        
        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';
        
        // Add loading animation for buttons
        document.querySelectorAll('button, a').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.type === 'submit' || this.tagName === 'A') {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                }
            });
        });
    </script>
</body>
</html>