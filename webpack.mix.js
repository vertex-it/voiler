const mix = require('laravel-mix')

mix
    .postCss('resources/css/tailwind.css', 'public/css/tailwind.css', [
        require('tailwindcss'),
    ])
    .css('resources/css/styles.css', 'public/css/styles.css')
    .js('resources/js/bootstrap.js', 'public/js/bootstrap.js')
    .styles([
        'public/css/tailwind.css',
        'public/css/styles.css',
        'resources/css/selectize-custom.css',
        'resources/css/datatables-custom.css',
        'resources/css/toastr.css',
        'resources/css/jquery-confirm.css',
    ], 'public/css/app.css')
    .scripts([
        'public/js/bootstrap.js',
        'resources/js/adminpanel.js',
        'resources/js/toastr.min.js',
        'resources/js/jquery-confirm.js',
    ], 'public/js/app.js')
    .version();

// Tinymce resources
mix.copyDirectory('node_modules/tinymce/icons', 'public/js/icons');
mix.copyDirectory('node_modules/tinymce/plugins', 'public/js/plugins');
mix.copyDirectory('node_modules/tinymce/skins', 'public/js/skins');
mix.copyDirectory('node_modules/tinymce/themes', 'public/js/themes');
