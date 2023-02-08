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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', '/var/www/admin/data/www/laravel.xn----7sbajlcc7cwa1af2d.xn--p1ai/image-hosting/public/css')
    .styles('resources/css/landing-page.min.css', '/var/www/admin/data/www/laravel.xn----7sbajlcc7cwa1af2d.xn--p1ai/image-hosting/public/css/landing-page.min.css')
    .js('resources/js/main.js', '/var/www/admin/data/www/laravel.xn----7sbajlcc7cwa1af2d.xn--p1ai/image-hosting/public/js/main.js')
    .js('resources/js/main.js', '/var/www/admin/data/www/laravel.xn----7sbajlcc7cwa1af2d.xn--p1ai/image-hosting/public/js/BigPicture.min.js');