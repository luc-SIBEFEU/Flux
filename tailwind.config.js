/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/Livewire/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                // Palette du projet : bleu, blanc, violet, noir, or
                primary: {
                    DEFAULT: '#6d28d9', // violet
                    dark: '#4c1d95',
                },
                accent: {
                    DEFAULT: '#fbbf24', // or
                    dark: '#d97706',
                },
                bleu: {
                    DEFAULT: '#1d4ed8',
                },
                noir: '#0d0620',
            },
        },
    },
    plugins: [],
};
