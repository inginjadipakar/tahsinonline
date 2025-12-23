import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'islamic-navy': '#0F172A', // Deep Navy
                'islamic-navy-light': '#1E293B', // Lighter Navy for cards
                'islamic-gold': '#D4AF37', // Gold
                'islamic-gold-light': '#F4D03F', // Lighter Gold
                'islamic-emerald': '#10B981', // Emerald Green
                'islamic-emerald-dark': '#047857', // Darker Emerald
            },
            backgroundImage: {
                'islamic-pattern': "url('https://www.transparenttextures.com/patterns/arabesque.png')", // Subtle pattern
                'arabic-calligraphy': "url(\"data:image/svg+xml,%3Csvg width='200' height='200' viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Ctext x='50%25' y='50%25' font-family='serif' font-size='60' fill='%2310B981' fill-opacity='0.1' text-anchor='middle' dominant-baseline='middle' transform='rotate(-10, 100, 100)'%3Eاقرأ%3C/text%3E%3C/svg%3E\")",
            },
        },
    },

    plugins: [forms],
};
