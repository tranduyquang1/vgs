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

/* Backend */
mix.sass('resources/sass/backend/myStyle.scss', 'public/backend/css').options({processCssUrls: false});
mix.js('resources/js/backend/myScript.js', 'public/backend/js');

// FRONTEND OLD START //
/* Frontend */
// mix.sass('resources/sass/frontend/myStyle.scss', 'public/frontend/css').options({processCssUrls: false});
// mix.js('resources/js/frontend/myScript.js', 'public/frontend/js');

/* Combine css*/
// mix.combine([
//     'public/frontend/css/bootstrap.css',
//     'public/frontend/css/style.css',
//     'public/frontend/css/swiper.css',
//     'public/frontend/css/dark.css',
//     'public/frontend/css/animate.css',
//     'public/frontend/css/magnific-popup.css',
//     'public/frontend/css/custom.css'
// ], 'public/frontend/assets/css/combine-all-assets.min.css');

/* Combine javascript*/
// mix.combine([
//     'public/frontend/js/jquery.js',
//     'public/frontend/js/plugins.min.js',
//     'public/frontend/js/functions.js'
// ], 'public/frontend/assets/js/combine-all-assets.min.js');
// FRONTEND OLD END //

// FRONTEND NEW START //
mix.sass('resources/sass/frontend-new/myStyle.scss', 'public/frontend-new/css').options({processCssUrls: false});
mix.js('resources/js/frontend-new/myScript.js', 'public/frontend-new/js');

/* Combine css*/
mix.combine([
    'public/frontend-new/assets/fontawesome/css/all.min.css',
    'public/frontend-new/style/reset.css',
    'public/frontend-new/style/superfish.css',
    'public/frontend-new/style/prettyPhoto.css',
    'public/frontend-new/style/jquery.qtip.css',
    'public/frontend-new/style/style.css',
    'public/frontend-new/style/menu_styles.css',
    'public/frontend-new/style/animations.css',
    'public/frontend-new/style/responsive.css',
    'public/frontend-new/style/odometer-theme-default.css',
    'public/frontend-new/assets/owl-carousel2/assets/owl.carousel.min.css',
    'public/frontend-new/assets/owl-carousel2/assets/owl.theme.default.min.css',
    'public/frontend-new/assets/ResponsiveMultiLevelMenu/css/component.css'
], 'public/frontend-new/css/combine-all-assets.min.css');

/* Combine javascript*/
mix.scripts([
    'public/frontend-new/js/jquery-3.6.0.min.js',
    'public/frontend-new/js/jquery.ba-bbq.min.js',
    'public/frontend-new/js/jquery-ui-1.12.1.custom.min.js',
    'public/frontend-new/js/jquery.easing.1.4.1.min.js',
    'public/frontend-new/js/jquery.carouFredSel-6.2.1-packed.js',
    'public/frontend-new/js/jquery.touchSwipe.min.js',
    'public/frontend-new/js/jquery.transit.min.js',
    'public/frontend-new/js/jquery.sliderControl.js',
    'public/frontend-new/js/jquery.timeago.js',
    'public/frontend-new/js/jquery.hint.js',
    'public/frontend-new/js/jquery.prettyPhoto.js',
    'public/frontend-new/js/jquery.qtip.min.js',
    'public/frontend-new/js/jquery.blockUI.js',
    'public/frontend-new/js/jquery.imagesloaded-packed.js',
    'public/frontend-new/js/main.js',
    'public/frontend-new/js/odometer.min.js',
    'public/frontend-new/assets/owl-carousel2/owl.carousel.min.js',
    'public/frontend-new/assets/ResponsiveMultiLevelMenu/js/jquery.dlmenu.js'
], 'public/frontend-new/js/combine-all-assets.min.js');
// FRONTEND NEW END //

mix.disableNotifications();

if (!mix.inProduction()) {
    mix.webpackConfig({
        devtool: 'inline-source-map'
    })
        .sourceMaps()
}