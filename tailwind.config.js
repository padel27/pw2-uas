// tailwind.config.js

const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
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
            // Di sini kita mendefinisikan ulang warna utama
            colors: {
                // Ganti menjadi 'sky' untuk warna biru langit
                primary: colors.sky, // 'sky' adalah palet warna biru langit dari Tailwind
                gray: colors.neutral,
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
