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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
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
            },
        },
    },

    plugins: [forms],
};
