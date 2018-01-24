const glob = require('glob-all');
const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

require('laravel-mix-purgecss');

mix
    .js('resources/assets/js/front/front.js', 'public/js')
    .js('resources/assets/js/back/back.js', 'public/js')
    
    .sass('resources/assets/css/front/front.scss', 'public/css')
    .sass('resources/assets/css/back/back.scss', 'public/css')

    .options({
        processCssUrls: false,

        postCss: [
            tailwindcss('tailwind.js'),
        ],
    })

    .version()

    .webpackConfig({
        output: {
            chunkFilename: 'js/[name].js',
        },

        resolve: {
            alias: {
                'vue$': 'vue',
            },
        },
    })

    .purgeCss({
        globs: [
            path.join(__dirname, 'node_modules/simplemde/**/*.js'),
            path.join(__dirname, 'node_modules/turbolinks/**/*.js'),
            path.join(__dirname, 'vendor/spatie/menu/**/*.php'),
        ],
        whitelistPatterns: [/carbon/, /language/, /hljs/, /cm-/, /alert-/],
    });
