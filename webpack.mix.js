let mix = require('laravel-mix');

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
