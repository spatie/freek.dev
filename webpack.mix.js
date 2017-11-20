let mix = require('laravel-mix');
const webpack = require('webpack');
let purgeCss = require('purgecss-webpack-plugin')
let glob = require('glob-all')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

var tailwindcss = require('tailwindcss');

/*
mix.js('resources/assets/js/app.js', 'public/js')
    .postCss('resources/assets/css/app.css', 'public/css', [
        tailwindcss('tailwind.js'),
    ])
    .version();
*/


mix.js('resources/assets/js/front/front.js', 'public/js')
    .js('resources/assets/js/back/back.js', 'public/js')
    .sass('resources/assets/css/front/front.scss', 'public/css')
    .sass('resources/assets/css/back/back.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('tailwind.js') ],
    })
    .version();


mix.webpackConfig({
    plugins: [
        new purgeCss({
            paths: glob.sync([
                path.join(__dirname, 'app/**/*.php'),
                path.join(__dirname, 'resources/views/**/*.blade.php'),
                path.join(__dirname, 'resources/assets/js/**/*.vue'),
                path.join(__dirname, 'node_modules/simplemde/**/*.js'),
                path.join(__dirname, 'vendor/spatie/menu/**/*.php'),
            ]),
            whitelistPatterns: [/carbon/],
            extractors: [
                {
                    extractor: class {
                        static extract(content) {
                            return content.match(/[A-z0-9-:\/]+/g)
                        }
                    },
                    extensions: ['html', 'js', 'php', 'vue'],
                }
            ]
        })
    ],
})
