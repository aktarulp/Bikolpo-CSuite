import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                // Default: Inter for Latin; Hind Siliguri available for Bengali glyphs
                sans: ['"Inter"', '"Hind Siliguri"', ...defaultTheme.fontFamily.sans],
                // Utility: font-bangla
                bangla: ['"Hind Siliguri"', 'sans-serif'],
                brand: ['"Fredoka"', 'sans-serif'],
                modern: ['"Inter"', 'sans-serif'],
                display: ['"Space Grotesk"', 'sans-serif']
            },
            colors: {
                primaryGreen: '#16a34a',
                primaryOrange: '#f97316',
                primaryBlue: '#3b82f6',
                primaryPurple: '#8b5cf6',
                darkBlue: '#1a202c',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-up': 'slideUp 0.6s ease-out',
                'bounce-slow': 'bounce 2s infinite',
                'pulse-slow': 'pulse 3s infinite',
                float: 'float 8s infinite ease-in-out',
            },
            keyframes: {
                fadeIn: {
                    'from': { opacity: '0', transform: 'translateY(20px)' },
                    'to': { opacity: '1', transform: 'translateY(0)' }
                },
                slideUp: {
                    'from': { opacity: '0', transform: 'translateY(40px)' },
                    'to': { opacity: '1', transform: 'translateY(0)' }
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-20px)' },
                }
            }
        },
    },

    plugins: [
        forms,
        function({ addVariant }) {
            addVariant('peer-checked', '&:checked ~ * &');
        }
    ],
};
