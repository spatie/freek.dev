module.exports = {
    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true,
    },
    purge: {
        content: ['./resources/**/*.blade.php'],
        options: {
            whitelist: [
                'from-red-400',
                'to-red-700',
                'from-blue-500',
                'to-blue-800',
                'from-yellow-400',
                'to-orange-500',
                'from-gray-400',
                'to-gray-700'
            ],
        }
    },
    plugins: [require('@tailwindcss/custom-forms')],
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
    },
};
