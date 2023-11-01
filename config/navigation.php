<?php
return [
    // TODO Document
    '_logo' => [
        'route' => 'admin.index',
    ],
    '_pages' => [
        // VOILER GENERATED PAGES
    ],
    '_profile' => [
        'Settings' => [
            'pages' => [
                'Users' => [
                    [
                        'name' => 'Show all',
                        'route' => 'admin.users.index',
                    ],
                    [
                        'name' => 'Add user',
                        'route' => 'admin.users.create',
                        'can' => 'users create',
                    ],
                    'can' => 'users viewAny',
                ],
                'Roles' => [
                    [
                        'name' => 'Show all',
                        'route' => 'admin.roles.index',
                    ],
                    [
                        'name' => 'Add role',
                        'route' => 'admin.roles.create',
                        'can' => 'roles create',
                    ],
                    'can' => 'roles viewAny',
                ],
                'Permissions' => [
                    [
                        'name' => 'Show all',
                        'route' => 'admin.permissions.index',
                    ],
                    [
                        'name' => 'Add permission',
                        'route' => 'admin.permissions.create',
                        'can' => 'permissions create',
                    ],
                    'can' => 'permissions viewAny',
                ],
                'Activities' => [
                    [
                        'name' => 'Show all',
                        'route' => 'admin.activities.index',
                    ],
                    'can' => 'activities viewAny',
                ],
            ],
        ],
    ],
];