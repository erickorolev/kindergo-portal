<?php

use Spatie\QueryBuilder\AllowedFilter;

return [
    'resources' => [
        'users' => [
            'domain' => 'Users',
            'relationships' => [
                [
                    'type' => 'roles',
                    'method' => 'roles'
                ],
                [
                    'type' => 'children',
                    'method' => 'children'
                ],
                [
                    'type' => 'timetables',
                    'method' => 'timetables'
                ],
                [
                    'type' => 'payments',
                    'method' => 'payments'
                ]
            ],
            'allowedSorts' => [
                'updated_at',
                'email'
            ],
            'allowedFilters' => [

            ]
        ],
        'children' => [
            'domain' => 'Children',
            'relationships' => [
                [
                    'type' => 'users',
                    'method' => 'users'
                ],
                [
                    'type' => 'timetables',
                    'method' => 'timetables'
                ],
                [
                    'type' => 'trips',
                    'method' => 'trips'
                ]
            ],
            'allowedSorts' => [
                'updated_at'
            ],
            'allowedFilters' => [

            ]
        ],
        'timetables' => [
            'domain' => 'Timetables',
            'relationships' => [
                [
                    'type' => 'user',
                    'method' => 'user'
                ],
                [
                    'type' => 'children',
                    'method' => 'children'
                ]
            ],
            'allowedSorts' => [
                'updated_at'
            ],
            'allowedFilters' => [

            ]
        ],
        'payments' => [
            'domain' => 'Payments',
            'relationships' => [
                [
                    'type' => 'users',
                    'method' => 'user'
                ]
            ],
            'allowedSorts' => [
                'updated_at'
            ],
            'allowedFilters' => [

            ]
        ],
        'trips' => [
            'domain' => 'Trips',
            'relationships' => [
                [
                    'type' => 'timetables',
                    'method' => 'timetable'
                ],
                [
                    'type' => 'children',
                    'method' => 'children'
                ]
            ],
            'allowedSorts' => [
                'updated_at'
            ],
            'allowedFilters' => [

            ]
        ],
        'attendants' => [
            'domain' => 'Attendants',
            'relationships' => [
                [
                    'type' => 'trips',
                    'method' => 'trips'
                ]
            ],
            'allowedSorts' => [
                'updated_at'
            ],
            'allowedFilters' => [

            ]
        ]
    ]
];
