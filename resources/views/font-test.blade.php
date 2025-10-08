<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Font Test - Inter & Hind Siliguri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-display-box {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 24px;
            margin: 16px 0;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .unicode-info {
            font-size: 12px;
            color: #6b7280;
            font-family: 'Monaco', 'Consolas', monospace;
            margin-top: 8px;
        }
    </style>
</head>
<body class="bg-gray-50 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">
            Font Configuration Test
        </h1>
        
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Inter Font (English) -->
            <div class="font-display-box">
                <h2 class="text-2xl font-bold mb-4 text-blue-600">Inter Font (English)</h2>
                
                <div class="space-y-4">
                    <div class="font-english">
                        <p class="text-sm font-light">Light: The quick brown fox jumps over the lazy dog</p>
                        <p class="text-base font-normal">Regular: The quick brown fox jumps over the lazy dog</p>
                        <p class="text-lg font-medium">Medium: The quick brown fox jumps over the lazy dog</p>
                        <p class="text-xl font-semibold">SemiBold: The quick brown fox jumps over the lazy dog</p>
                        <p class="text-2xl font-bold">Bold: The quick brown fox jumps</p>
                    </div>
                    
                    <div class="unicode-info">
                        Font Family: Inter<br>
                        Unicode Range: U+0000-00FF, U+0100-024F, U+1E00-1EFF<br>
                        Format: WOFF2
                    </div>
                </div>
            </div>

            <!-- Hind Siliguri Font (Bangla) -->
            <div class="font-display-box">
                <h2 class="text-2xl font-bold mb-4 text-green-600">Hind Siliguri Font (বাংলা)</h2>
                
                <div class="space-y-4">
                    <div class="font-bangla">
                        <p class="text-sm font-light">হালকা: আমি বাংলায় গান গাই</p>
                        <p class="text-base font-normal">নিয়মিত: আমি বাংলায় গান গাই</p>
                        <p class="text-lg font-medium">মাঝারি: আমি বাংলায় গান গাই</p>
                        <p class="text-xl font-semibold">অর্ধ-গাঢ়: আমি বাংলায় গান গাই</p>
                        <p class="text-2xl font-bold">গাঢ়: আমি বাংলায় গান গাই</p>
                    </div>
                    
                    <div class="unicode-info">
                        Font Family: Hind Siliguri<br>
                        Unicode Range: U+0980-09FF, U+200C-200D, U+25CC<br>
                        Format: TrueType (TTF)
                    </div>
                </div>
            </div>
        </div>

        <!-- Mixed Content Test -->
        <div class="font-display-box">
            <h2 class="text-2xl font-bold mb-4 text-purple-600">Mixed Language Test (Default Behavior)</h2>
            
            <div class="space-y-4">
                <!-- This should automatically use Inter for English and Hind Siliguri for Bangla -->
                <p class="text-lg">
                    This is English text mixed with বাংলা টেক্সট in the same paragraph.
                </p>
                
                <p class="text-xl font-semibold">
                    Mixed Content: Welcome to আমাদের ওয়েবসাইট - Your Learning Platform
                </p>
                
                <p class="text-base">
                    Numbers and symbols: 123456789 ০১২৩৪৫৬৭৮৯ @#$%^&*()
                </p>
            </div>
            
            <div class="unicode-info">
                Automatic font selection based on Unicode ranges<br>
                Inter for Latin characters, Hind Siliguri for Bengali characters
            </div>
        </div>

        <!-- Utility Class Examples -->
        <div class="font-display-box">
            <h2 class="text-2xl font-bold mb-4 text-red-600">Utility Classes</h2>
            
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <h3 class="font-semibold mb-2">.font-english</h3>
                    <p class="font-english text-sm">
                        Forces Inter font even for mixed: আমি বাংলায় গান গাই English text
                    </p>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-2">.font-bangla</h3>
                    <p class="font-bangla text-sm">
                        Forces Hind Siliguri: আমি বাংলায় গান গাই English text
                    </p>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-2">.font-mixed</h3>
                    <p class="font-mixed text-sm">
                        Optimal fallback: আমি বাংলায় গান গাই English text
                    </p>
                </div>
            </div>
        </div>

        <!-- Technical Info -->
        <div class="font-display-box bg-gray-100">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Technical Configuration</h2>
            
            <div class="text-sm space-y-2">
                <p><strong>Default font stack:</strong> Inter, Hind Siliguri, ui-sans-serif, system-ui, sans-serif</p>
                <p><strong>Inter Unicode Range:</strong> U+0000-00FF, U+0100-024F, U+1E00-1EFF, U+2000-206F, U+20A0-20CF</p>
                <p><strong>Hind Siliguri Unicode Range:</strong> U+0980-09FF, U+200C-200D, U+25CC</p>
                <p><strong>Font Loading:</strong> Both fonts use font-display: swap for better performance</p>
                <p><strong>Available Weights:</strong> 200, 300, 400, 500, 600, 700, 800 (Inter), 300, 400, 500, 600, 700 (Hind Siliguri)</p>
            </div>
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('partner.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html>