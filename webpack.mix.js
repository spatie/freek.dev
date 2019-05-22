const mix = require('laravel-mix');

require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/js')

    .postCss('resources/css/app.css', 'public/css', [require('tailwindcss')('tailwind.config.js')])

    .options({
        processCssUrls: false,
    })

    .autoload({
        preact: 'preact',
    })

    .version()

    .babelConfig({
        plugins: [
            '@babel/plugin-syntax-dynamic-import',
            ['@babel/plugin-transform-react-jsx', { pragma: 'preact.h' }],
        ],
    })

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
