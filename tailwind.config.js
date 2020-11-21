const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: ['./storage/framework/views/*.php', './resources/views/**/*.blade.php'],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
        // extend: {
        //     scale: ['focus-within'],
        // }
    },

    plugins: [require('@tailwindcss/ui')],

    experimental: 'all',

    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: false,
    },
};
