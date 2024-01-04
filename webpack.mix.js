const mix = require('laravel-mix')
const tailwindNesting = require('tailwindcss/nesting')
const tailwindcss = require('tailwindcss')

// --- VOILER MIX ASSETS BEGIN ---

// Setup webpack to be able to use vendor js and css files
mix.webpackConfig({
    resolve: {
        symlinks: false,
    },
})

// Mix tailwind css

mix.postCss('./vendor/vertex-it/voiler/resources/css/tailwind.css', 'public/css', [tailwindNesting, tailwindcss])
   .postCss('./vendor/vertex-it/voiler/resources/css/tailwind-vendor.css', 'public/css/tailwind-vendor.css', [tailwindcss])
   .postCss('./vendor/vertex-it/blade-components/resources/css/blade-components.css', 'public/css/blade-components.css', [tailwindcss])

mix.styles([
       'public/css/tailwind.css',
       'public/css/tailwind-vendor.css',
       'public/css/blade-components.css',
   ], 'public/css/app.css')
   .version()

// Mix jQuery, blade components and datatables
mix.js('./vendor/vertex-it/voiler/resources/js/voiler.js', 'public/js/voiler.js')
   .js('./vendor/vertex-it/voiler/resources/js/tailwind.js', 'public/js/tailwind.js')
   .js('./vendor/vertex-it/blade-components/resources/js/blade-components.js', 'public/js/blade-components.js')
   .js('./vendor/vertex-it/voiler/resources/js/datatables.js', 'public/js/datatables.js')

mix.scripts([
       'public/js/voiler.js',
       'public/js/tailwind.js',
       './vendor/vertex-it/voiler/resources/js/toastr.min.js',
   ], 'public/js/app.js')
   .version()

const fs = require('fs')
const tinyMCEResources = [
    'icons', 'plugins', 'skins', 'themes',
]

// Copy tinymce resources
for (i = 0; i < tinyMCEResources.length; i++) {
    if (! fs.existsSync(`public/js/${ tinyMCEResources[i] }`)) {
        mix.copyDirectory(`node_modules/tinymce/${ tinyMCEResources[i] }`, `public/js/${ tinyMCEResources[i] }`)
    }
}

// --- VOILER MIX ASSETS END ---
