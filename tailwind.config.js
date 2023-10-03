const colors = require('tailwindcss/colors')

module.exports = {
    darkMode: 'class',
    content: [
        './resources/**/*.blade.php',
        './app/*.php',
        './vendor/filament/**/*.blade.php',
        './vendor/filament/**/*.css',

    ],
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
    theme: {
        fontFamily: {
            sans: [
                'Whitney SSm A',
                'Whitney SSm B',
                '-apple-system',
                'BlinkMacSystemFont',
                'Segoe UI',
                'Roboto',
                'Helvetica Neue',
                'Arial',
                'Noto Sans',
                'sans-serif',
                'Apple Color Emoji',
                'Segoe UI Emoji',
                'Segoe UI Symbol',
                'Noto Color Emoji',
            ],
            mono: [
                'Operator Mono SSm A',
                'Operator Mono SSm B',
                'Monaco',
                'Consolas',
                'Liberation Mono',
                'Courier New',
                'monospace',
            ],
        },
        extend: {
            colors: {
                danger: colors.rose,
                primary: colors.blue,
                success: colors.green,
                warning: colors.yellow,
            },
            borderWidth: {
                3: '3px',
                5: '5px',
            },
            fontSize: {
                xxs: '0.65rem',
            },
            lineHeight: {
                relaxed: 1.75,
            },
            spacing: {
                7: '1.75rem',
            },
            borderRadius: {
                xl: '12px',
                '2xl': '16px',
                '3xl': '24px',
            },
            rotate: {
                '-5': '-5deg',
            },
        },
    },
    variants: {
        borderColor: ['focus-within', 'hover', 'focus'],
        extend: {
            fontWeight: ['hover', 'focus']
        }
    },
};
