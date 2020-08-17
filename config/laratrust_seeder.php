<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadministrator' => [
            'users' => 'c,r,u,d,t,s',
            'roles' => 'c,r,u,d,t,s',
            'settings' => 'c,r,u,d,t,s',
            'learning_systems' => 'c,r,u,d,t,s',
            'countries' => 'c,r,u,d,t,s',
            'stages' => 'c,r,u,d,t,s',
            'ed_classes' => 'c,r,u,d,t,s',
            'courses' => 'c,r,u,d,t,s',
            'chapters' => 'c,r,u,d,t,s',
            'lessons' => 'c,r,u,d,t,s',

        ],
        'administrator' => [],
        'user' => []
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        's' => 'restore',
        't' => 'trash'
    ]
];
