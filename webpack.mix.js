const mix = require('laravel-mix')

// --- VOILER MIX ASSETS BEGIN ---
// Mix tailwind css
mix
    .postCss('resources/css/vendor/tailwind.css', 'public/css/tailwind.css', [ require('tailwindcss') ])
    .postCss('resources/css/vendor/tailwind-custom.css', 'public/css/tailwind-custom.css', [ require('tailwindcss') ])
    .postCss('resources/css/vendor/tailwind-vendor.css', 'public/css/tailwind-vendor.css', [require('tailwindcss')])
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

// --- VOILER MIX ASSETS END ---
