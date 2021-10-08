const mix = require('laravel-mix')

mix
    .postCss('resources/css/vendor/tailwind.css', 'public/css/tailwind.css', [
        require('tailwindcss'),
    ])
    .css('resources/css/vendor/styles.css', 'public/css/styles.css')
    .js('resources/js/vendor/bootstrap.js', 'public/js/bootstrap.js')
    .styles([
        'public/css/tailwind.css',
        'public/css/styles.css',
        'resources/css/vendor/selectize-custom.css',
        'resources/css/vendor/datatables-custom.css',
        'resources/css/vendor/toastr.css',
    ], 'public/css/app.css')
    .scripts([
        'public/js/bootstrap.js',
        'resources/js/vendor/adminpanel.js',
        'resources/js/vendor/modal.js',
        'resources/js/vendor/util.js',
        'resources/js/vendor/toastr.min.js',
    ], 'public/js/app.js')
    .version();

mix.styles([
    'resources/css/vendor/fullcalendar.css',
], 'public/css/calendar.css')
    .scripts([
        'resources/js/vendor/moment.min.js',
        'resources/js/vendor/fullcalendar.js',
        'resources/js/vendor/mApp.min.js',
    ], 'public/js/calendar.js')
    .version();

// Tinymce resources
mix.copyDirectory('node_modules/tinymce/icons', 'public/js/icons');
mix.copyDirectory('node_modules/tinymce/plugins', 'public/js/plugins');
mix.copyDirectory('node_modules/tinymce/skins', 'public/js/skins');
mix.copyDirectory('node_modules/tinymce/themes', 'public/js/themes');
