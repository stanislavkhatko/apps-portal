const {mix} = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('Themes/apps_theme_1/assets/sass/apps_theme_1.scss', 'Themes/apps_theme_1/assets/css')
    .sass('Themes/apps_theme_2/assets/sass/apps_theme_2.scss', 'Themes/apps_theme_2/assets/css')
    .browserSync({
        proxy: 'adportal.test',
        notify: false
    });

if (mix.inProduction()) {
    mix.version();
}