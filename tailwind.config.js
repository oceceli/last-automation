const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './storage/framework/views/*.php', 
        './resources/views/**/*.blade.php',
        './app/Http/Livewire/**/*.php',
        './app/View/Components/**/*.php', // livewire ve laravvel components
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'smoke-darkest': 'rgba(0, 0, 0, 0.9)',
                'smoke-darker': 'rgba(0, 0, 0, 0.75)',
                'smoke-dark': 'rgba(0, 0, 0, 0.6)',
                'smoke': 'rgba(0, 0, 0, 0.5)',
                'smoke-light': 'rgba(0, 0, 0, 0.4)',
                'smoke-lighter': 'rgba(0, 0, 0, 0.25)',
                'smoke-lightest': 'rgba(0, 0, 0, 0.1)',
            }
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
        borderWidth: ['responsive', 'last', 'hover', 'focus'],

        // extend: {
        //     // scale: ['focus-within'],
        //     borderWidth: ['last'],
        // },
    },
    

    plugins: [require('@tailwindcss/ui')],

    experimental: 'all',

    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: false,
    },
};
