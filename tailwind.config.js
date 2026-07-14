import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['"Cormorant Garamond"', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                agata: {
                    50: '#faf6f0',
                    100: '#f3ebdd',
                    200: '#e6d3b8',
                    300: '#d6b78d',
                    400: '#c39a63',
                    500: '#a97e48',
                    600: '#8a6338',
                    700: '#6d4c2c',
                    800: '#523823',
                    900: '#3a271a',
                },
                gold: {
                    400: '#cba368',
                    500: '#b5884b',
                    600: '#96703c',
                },
            },
        },
    },

    plugins: [forms],
};
