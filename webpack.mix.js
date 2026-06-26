const mix = require('laravel-mix');

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

mix.js('resources/js/release_player.js', 'public/js/release_player.js')
    .js('resources/js/feedback_player.js', 'public/js/feedback_player.js')
    .js([
        'resources/js/global.js',
        'resources/js/admin.js',
    ], 'public/js/admin.js')
    .js([
        'resources/js/global.js',
        'resources/js/app.js'
    ], 'public/js/app.js')
    .sass('resources/sass/admin.scss', 'public/css/admin.css')
    .sass('resources/sass/app.scss', 'public/css/app.css')
    .version();
