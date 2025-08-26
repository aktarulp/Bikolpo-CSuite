<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Partner Registration</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

  <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">
    
    <!-- Title -->
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
      Partner Registration
    </h2>

    <!-- Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
      @csrf
      <input type="hidden" name="register_type" value="partner">
      
      <!-- Partner Name -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Partner Name</label>
        <input type="text" name="name" required 
          class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-green-400 focus:border-green-500" 
          placeholder="Enter your Institute Name"
          value="{{ old('name') }}">
        @error('name')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Type -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
        <select name="organization_type" required 
          class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-green-400 focus:border-green-500">
          <option value="" disabled selected>-- Select Type --</option>
          <option value="Coaching" {{ old('organization_type') == 'Coaching' ? 'selected' : '' }}>Coaching</option>
          <option value="School" {{ old('organization_type') == 'School' ? 'selected' : '' }}>School</option>
          <option value="College" {{ old('organization_type') == 'College' ? 'selected' : '' }}>College</option>
          <option value="Academy" {{ old('organization_type') == 'Academy' ? 'selected' : '' }}>Academy</option>
          <option value="Online" {{ old('organization_type') == 'Online' ? 'selected' : '' }}>Online</option>
        </select>
        @error('organization_type')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Email -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" required 
          class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-green-400 focus:border-green-500" 
          placeholder="Enter your email"
          value="{{ old('email') }}">
        @error('email')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Password -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" required 
          class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-green-400 focus:border-green-500" 
          placeholder="********">
        @error('password')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Confirm Password -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
        <input type="password" name="password_confirmation" required 
          class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-green-400 focus:border-green-500" 
          placeholder="********">
        @error('password_confirmation')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Submit -->
      <button type="submit" 
        class="w-full py-2 px-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition">
        Register
      </button>

      <!-- Already have account -->
      <p class="text-center text-sm text-gray-600 mt-4">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-green-600 hover:underline">Login</a>
      </p>
    </form>
  </div>

</body>
</html>
