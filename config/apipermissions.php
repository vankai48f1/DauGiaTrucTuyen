<?php

return [
    'configurable_routes' => [
        'admin_section' => [
            'user' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'api.admin.users.index',
                ],
            ],
        ],
        'user_section' => [
            'ticket' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'api.tickets.index',
                ],
            ],
        ],
    ],

    ROUTE_TYPE_ROLE_BASED => [
        USER_ROLE_ADMIN => [

        ],
        USER_ROLE_USER => [

        ]
    ],

    ROUTE_TYPE_AVOIDABLE_MAINTENANCE => [

    ],
    ROUTE_TYPE_AVOIDABLE_UNVERIFIED => [

    ],
    ROUTE_TYPE_AVOIDABLE_INACTIVE => [

    ],
    ROUTE_TYPE_FINANCIAL => [

    ],

    ROUTE_TYPE_GLOBAL => [

    ],
];
