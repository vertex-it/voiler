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
];
