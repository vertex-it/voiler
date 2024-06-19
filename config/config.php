<?php

return [
    'middleware' => [
        'web',
        'auth'
    ],

    'permission_types' => [
        'view',
        'create',
        'viewAny',
        'update',
        'delete',
        'restore',
        'forceDelete',
    ],

    'show_placeholder' => true,

    'login' => [

        // Supported keys for login
        'keys' => [
            'username', 'email',
        ],

        // Default key for login
        // Here can go any option from keys array
        // If you want all keys just set this option to all
        'default' => 'all',
    ],

    'media_library' => [
        'preserve_temp_files' => env('PRESERVE_TEMP_FILES', false),
    ],
];
