<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quiz Access - CSuite</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="min-h-screen bg-gray-50 font-bangla">
    @include('navigation-layout')
    
    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Simple Quiz Access Card -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <!-- Title -->
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Quiz Access</h2>
                    <p class="text-gray-600 mt-1">Enter your credentials to start</p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                            <div>
                                <h3 class="font-semibold text-red-800">Access Error</h3>
                                <ul class="mt-1 text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Simple Form -->
                <form method="POST" action="{{ route('public.quiz.process-access') }}" class="space-y-4">
                    @csrf
                    
                    <!-- Phone Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                               placeholder="01XXXXXXXXX"
                               pattern="01[3-9][0-9]{8}"
                               maxlength="11"
                               required>
                        <p class="mt-1 text-sm text-gray-500">11-digit Bangladeshi mobile number</p>
                    </div>

                    <!-- Access Code -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Access Code</label>
                        <input type="text" 
                               id="access_code" 
                               name="access_code" 
                               value="{{ old('access_code') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-center text-lg font-mono tracking-widest" 
                               placeholder="000000"
                               maxlength="6"
                               pattern="[0-9]{6}"
                               required>
                        <p class="mt-1 text-sm text-gray-500">6-digit access code from your teacher</p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full py-2 px-4 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Start Quiz
                    </button>

                    <!-- Multiple Exams Button -->
                    <div class="text-center pt-4">
                        <button type="button" 
                                onclick="handleMultipleExams()"
                                class="inline-block px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md border border-gray-300 text-sm">
                            View All Available Exams
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Simple JavaScript -->
    <script>
        // Phone number formatting
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 11) {
                value = value.substring(0, 11);
            }
            
            if (value.length >= 2 && value.substring(0, 2) !== '01') {
                value = '01' + value.substring(2);
            }
            
            if (value.length >= 3) {
                const secondDigit = parseInt(value.charAt(2));
                if (secondDigit < 3 || secondDigit > 9) {
                    value = value.substring(0, 2) + '3' + value.substring(3);
                }
            }
            
            e.target.value = value;
        });

        // Access code formatting
        document.getElementById('access_code').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });

        // Multiple exams handling
        function handleMultipleExams() {
            const phone = document.getElementById('phone').value;
            const accessCode = document.getElementById('access_code').value;
            
            if (!phone || !accessCode) {
                alert('Please enter both phone number and access code first.');
                return;
            }
            
            if (phone.length !== 11) {
                alert('Please enter a valid 11-digit phone number.');
                return;
            }
            
            if (accessCode.length !== 6) {
                alert('Please enter a valid 6-digit access code.');
                return;
            }
            
            // Create and submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("public.quiz.multiple-exams") }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            const phoneInput = document.createElement('input');
            phoneInput.type = 'hidden';
            phoneInput.name = 'phone';
            phoneInput.value = phone;
            form.appendChild(phoneInput);
            
            const accessCodeInput = document.createElement('input');
            accessCodeInput.type = 'hidden';
            accessCodeInput.name = 'access_code';
            accessCodeInput.value = accessCode;
            form.appendChild(accessCodeInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    </script>

</body>
</html>
