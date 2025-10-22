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
    'bg-green-500', 'bg-red-500', 'bg-yellow-500', 'bg-blue-500',
    
    // Question view dynamic classes
    'bg-blue-100', 'bg-purple-100',
    'text-blue-700', 'text-purple-700',
    
    // Subjects index.blade.php - gradient and color classes
    'from-blue-500', 'to-cyan-400', 'from-purple-500', 'to-pink-400',
    'from-green-500', 'to-emerald-400', 'from-orange-500', 'to-yellow-400',
    'from-red-500', 'to-pink-400', 'from-indigo-500', 'to-purple-400',
    
    // Background colors with dark mode variants
    'bg-blue-50', 'bg-purple-50', 'bg-green-50', 'bg-orange-50', 'bg-red-50', 'bg-indigo-50',
    'dark:bg-blue-900/20', 'dark:bg-purple-900/20', 'dark:bg-green-900/20', 
    'dark:bg-orange-900/20', 'dark:bg-red-900/20', 'dark:bg-indigo-900/20',
    
    // Text colors with dark mode variants
    'text-blue-600', 'text-purple-600', 'text-green-600', 'text-orange-600', 
    'text-red-600', 'text-indigo-600',
    'dark:text-blue-400', 'dark:text-purple-400', 'dark:text-green-400', 
    'dark:text-orange-400', 'dark:text-red-400', 'dark:text-indigo-400',
    
    // Border colors
    'border-blue-200', 'border-purple-200', 'border-green-200', 
    'border-orange-200', 'border-red-200', 'border-indigo-200',
    'dark:border-blue-800', 'dark:border-purple-800', 'dark:border-green-800',
    'dark:border-orange-800', 'dark:border-red-800', 'dark:border-indigo-800',
    
    // Icon background colors
    'bg-blue-500', 'bg-purple-500', 'bg-green-500', 
    'bg-orange-500', 'bg-red-500', 'bg-indigo-500',
    
    // Hover states for group-hover
    'group-hover:text-blue-600', 'group-hover:text-purple-600', 'group-hover:text-green-600',
    'group-hover:text-orange-600', 'group-hover:text-red-600', 'group-hover:text-indigo-600',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'Hind Siliguri', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        bangla: ['"Hind Siliguri"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        brand: ['"Poppins"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        modern: ['"Inter"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        display: ['"Space Grotesk"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      colors: {
        primaryGreen: '#16a34a',
        primaryOrange: '#f97316',
        primaryBlue: '#3b82f6',
        primaryPurple: '#8b5cf6',
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'slide-up': 'slideUp 0.6s ease-out',
        'bounce-slow': 'bounce 2s infinite',
        'pulse-slow': 'pulse 3s infinite',
        'float': 'float 3s ease-in-out infinite',
        'shimmer': 'shimmer 3s ease-in-out infinite',
        'gradient-shift': 'gradientShift 4s ease infinite',
      },
      keyframes: {
        fadeIn: {
          'from': { opacity: '0', transform: 'translateY(20px)' },
          'to': { opacity: '1', transform: 'translateY(0)' },
        },
        slideUp: {
          'from': { opacity: '0', transform: 'translateY(40px)' },
          'to': { opacity: '1', transform: 'translateY(0)' },
        },
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-10px)' },
        },
        shimmer: {
          '0%': { transform: 'translateX(-100%)' },
          '100%': { transform: 'translateX(100%)' },
        },
        gradientShift: {
          '0%': { backgroundPosition: '0% 50%' },
          '50%': { backgroundPosition: '100% 50%' },
          '100%': { backgroundPosition: '0% 50%' },
        },
      },
      backgroundImage: {
        'grid-pattern': `
          linear-gradient(rgba(0,0,0,0.1) 1px, transparent 1px),
          linear-gradient(90deg, rgba(0,0,0,0.1) 1px, transparent 1px)
        `,
      },
      backgroundSize: {
        'grid': '20px 20px',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
