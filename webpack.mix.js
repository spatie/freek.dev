const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')

    .postCss('resources/css/app.css', 'public/css', [require('tailwindcss')()])

    .options({
        processCssUrls: false,
    })

    .version()

    .webpackConfig({
        output: {
            chunkFilename: 'js/[name].js',
        },
    });
