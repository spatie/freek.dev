const mix = require('laravel-mix');

require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/js')

    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-easy-import')(),
        require('tailwindcss')('tailwind.js'),
    ])

    .options({
        processCssUrls: false,
    })

    .version()

    .webpackConfig({
        output: {
            chunkFilename: 'js/[name].js',
        },

        resolve: {
            alias: {
                vue$: 'vue',
            },
        },
    })

    .purgeCss({
        globs: [
            path.join(__dirname, 'node_modules/simplemde/**/*.js'),
            path.join(__dirname, 'node_modules/turbolinks/**/*.js'),
            path.join(__dirname, 'vendor/spatie/menu/**/*.php'),
            path.join(__dirname, 'vendor/scrivo/highlight.php/**/*.php'),
        ],
        whitelistPatterns: [/carbon/, /language/, /hljs/, /cm-/, /alert-/],
    });
