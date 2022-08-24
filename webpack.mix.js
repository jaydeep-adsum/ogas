const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.js('resources/js/app.js', 'public/js').vue();
mix.postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]);
mix.sass('resources/assets/sass/custom.scss', 'public/assets/css/style.css').version();
mix.copy('node_modules/intl-tel-input/build/css/intlTelInput.css',
    'public/assets/css/inttel/css/intlTelInput.css');
mix.copyDirectory('node_modules/intl-tel-input/build/img',
    'public/assets/css/inttel/img');
mix.babel('node_modules/intl-tel-input/build/js/intlTelInput.js',
    'public/assets/js/inttel/js/intlTelInput.min.js');
mix.babel('node_modules/intl-tel-input/build/js/utils.js',
    'public/assets/js/inttel/js/utils.min.js');

mix.js('resources/assets/js/custom/custom.js',
        'public/assets/js/custom/custom.js')
    .js('resources/assets/js/customer/customer.js',
    'public/assets/js/customer/customer.js')
    .js('resources/assets/js/driver/driver.js',
        'public/assets/js/driver/driver.js')
    .js('resources/assets/js/category/category.js',
        'public/assets/js/category/category.js')
    .js('resources/assets/js/product/product.js',
        'public/assets/js/product/product.js')
    .js('resources/assets/js/order/order.js',
        'public/assets/js/order/order.js')
    .js('resources/assets/js/complaint/complaint.js',
        'public/assets/js/complaint/complaint.js')
    .js('resources/assets/js/faq/faq.js',
        'public/assets/js/faq/faq.js')
    .js('resources/assets/js/notification/notification.js',
        'public/assets/js/notification/notification.js')
    .js('resources/assets/js/custom/phone-number-country-code.js',
        'public/assets/js/custom/phone-number-country-code.js').version();
