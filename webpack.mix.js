const mix = require('laravel-mix')

// --- VOILER MIX ASSETS BEGIN ---
// Mix tailwind css
mix
    .postCss('resources/css/vendor/tailwind.css', 'public/css/tailwind.css', [ require('tailwindcss') ])
    .postCss('resources/css/vendor/tailwind-custom.css', 'public/css/tailwind-custom.css', [ require('tailwindcss') ])
    .css('resources/css/vendor/tailwind-vendor.css', 'public/css/tailwind-vendor.css')
    .styles([
        'public/css/tailwind-custom.css',
        'public/css/tailwind-vendor.css',
    ], 'public/css/app.css')
    .version();

// Mix jQuery, blade components and datatables
mix
    .js('resources/js/vendor/bootstrap.js', 'public/js/bootstrap.js')
    .js('resources/js/vendor/tailwind.js', 'public/js/tailwind.js')
    .scripts([
        'public/js/bootstrap.js',
        'public/js/tailwind.js',
        'resources/js/vendor/toastr.min.js',
    ], 'public/js/app.js')
    .version();

// TODO Extract datatable assets
// TODO Separate blade-components dependencies

// Fullcalendar assets
// mix
//     .styles([
//         'resources/css/vendor/fullcalendar.css',
//         'resources/css/vendor/fullcalendar-custom.css',
//     ], 'public/css/fullcalendar.css')
//     .scripts([
//         'resources/js/vendor/moment.min.js',
//         'resources/js/vendor/fullcalendar.js',
//         'resources/js/vendor/mApp.min.js',
//     ], 'public/js/fullcalendar.js')
//     .version();

// --- VOILER MIX ASSETS END ---
