import './bootstrap';
import Alpine from 'alpinejs';
import 'flowbite';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Import Tailwind CSS
import '../css/app.css';

// Initialize Tailwind config if not already defined
if (typeof window !== 'undefined' && !window.tailwind) {
    window.tailwind = {
        config: {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        bangla: ['"Nikosh"', '"Hind Siliguri"', 'sans-serif']
                    },
                    colors: {
                        primaryGreen: '#16a34a',
                        primaryOrange: '#f97316',
                        primaryBlue: '#3b82f6',
                        primaryPurple: '#8b5cf6'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'bounce-slow': 'bounce 2s infinite',
                    }
                }
            }
        }
    };
}