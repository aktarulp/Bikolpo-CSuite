/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Http/Controllers/**/*.php",
  ],
  safelist: [
    // Safelist dynamic color classes used in partner-settings.blade.php
    'bg-blue-50', 'bg-green-50', 'bg-purple-50', 'bg-orange-50',
    'bg-red-50', 'bg-yellow-50', 'bg-indigo-50', 'bg-pink-50',
    'text-blue-600', 'text-green-600', 'text-purple-600', 'text-orange-600',
    'text-red-600', 'text-yellow-600', 'text-indigo-600', 'text-pink-600',
    
    // Common dynamic badge colors
    'bg-green-100', 'bg-red-100', 'bg-yellow-100', 'bg-gray-100',
    'text-green-800', 'text-red-800', 'text-yellow-800', 'text-gray-800',
    'bg-green-500', 'bg-red-500', 'bg-yellow-500',
    
    // Question view dynamic classes
    'bg-blue-100', 'bg-purple-100',
    'text-blue-700', 'text-purple-700',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'Hind Siliguri', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
