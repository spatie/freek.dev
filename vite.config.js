import laravel from 'laravel-vite-plugin'
import {defineConfig} from 'vite'

export default defineConfig({
    server: {
        https: true,
        host: 'localhost',
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
            ],
        }),
    ],
})

