const mix = require('laravel-mix')

// --- VOILER MIX ASSETS BEGIN ---

// Mix tailwind css
mix
    .postCss("resources/css/vendor/tailwind.css", "public/css", [ require("tailwindcss") ])
    .postCss('resources/css/vendor/tailwind-vendor.css', 'public/css/tailwind-vendor.css', [require('tailwindcss')])
    .styles([
        'public/css/tailwind.css',
        'public/css/tailwind-vendor.css',
    ], 'public/css/app.css')
    .version();

// Mix jQuery, blade components and datatables
mix
    .js('resources/js/vendor/voiler.js', 'public/js/voiler.js')
    .js('resources/js/vendor/tailwind.js', 'public/js/tailwind.js')
    .scripts([
        'public/js/voiler.js',
        'public/js/tailwind.js',
        'resources/js/vendor/toastr.min.js',
    ], 'public/js/app.js')
    .version();

mix.copyDirectory('node_modules/tinymce/icons', 'public/js/icons');
mix.copyDirectory('node_modules/tinymce/plugins', 'public/js/plugins');
mix.copyDirectory('node_modules/tinymce/skins', 'public/js/skins');
mix.copyDirectory('node_modules/tinymce/themes', 'public/js/themes');

// --- VOILER MIX ASSETS END ---
