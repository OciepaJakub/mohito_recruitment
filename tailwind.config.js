import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.tsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#2196F3',
                    dark: '#1976D2',
                },
                accent: {
                    DEFAULT: '#FF9800',
                    dark: '#F57C00',
                },
                neutral: {
                    light: '#F5F5F5',
                    DEFAULT: '#9E9E9E',
                    dark: '#212121',
                },
                border: {
                    DEFAULT: '#E0E0E0',
                },
                error: {
                    DEFAULT: '#E53935',
                },
            }
        },
    },

    plugins: [forms],
};
