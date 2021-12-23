<?php
return [
    // TODO Document
    '_logo' => [
        'route' => 'admin.index',
    ],
    '_pages' => [
        'Demo single page' => [
            'route' => 'admin.index',
            'can' => '',
        ],
        'Demo multiple pages' => [
            [
                'name' => 'Show all',
                'route' => 'admin.index',
                'can' => '',
            ],
            [
                'name' => 'Create new',
                'route' => 'admin.index',
                'can' => '',
            ],
            'can' => '',
            'direction' => 'direction-left-down'
        ],
        'Demo section' => [
            'Demo subsection' => [
                [
                    'name' => 'Show all',
                    'route' => 'admin.index',
                    'can' => '',
                ],
                [
                    'name' => 'Create new',
                    'route' => 'admin.index',
                    'can' => '',
                ],
                'can' => '',
                'direction' => 'direction-right-down'
            ],
            'can' => '',
        ],
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