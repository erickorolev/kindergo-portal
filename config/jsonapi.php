<?php

use Spatie\QueryBuilder\AllowedFilter;

return [
    'resources' => [
        'questions' => [
            'domain' => 'Users',
            'relationships' => [
                [
                    'type' => 'roles',
                    'method' => 'roles'
                ]
            ],
            'allowedSorts' => [
                'updated_at',
                'email'
            ],
            'allowedFilters' => [
                AllowedFilter::exact('confirmed')
            ]
        ],
        'listing_categories' => [
            'domain' => 'Listings',
            'relationships' => [
                [
                    'type' => 'listing_products',
                    'method' => 'listingProducts'
                ]
            ],
            'allowedSorts' => [
                'id',
                'name',
                'parent',
            ],
            'allowedFilters' => [
                'id',
                'name',
                'parent',
            ]
        ],
        'listing_products' => [
            'domain' => 'Listings',
            'relationships' => [
                [
                    'type' => 'listing_categories',
                    'method' => 'listingCategory'
                ]
            ],
            'allowedSorts' => [
                'id',
                'listing_category.name',
                'code',
                'part_no',
                'usage_unit',
                'show_on_website',
                'name',
                'weight_code',
            ],
            'allowedFilters' => [
                'id',
                'listing_category.name',
                'code',
                'part_no',
                'usage_unit',
                'name',
                'weight_code',
            ]
        ],
        'cities' => [
            'domain' => 'Storages',
            'relationships' => [
                [
                    'type' => 'cities',
                    'method' => 'city'
                ]
            ],
            'allowedSorts' => [
                'id',
                'name',
                'code',
            ],
            'allowedFilters' => [
                'id',
                'name',
                'code',
            ]
        ],
        'locations' => [
            'domain' => 'Storages',
            'relationships' => [
                [
                    'type' => 'cities',
                    'method' => 'city'
                ]
            ],
            'allowedSorts' => [
                'id',
                'address',
                'city.name',
            ],
            'allowedFilters' => [
                'id',
                'address',
                'city.name',
            ]
        ],
        'cell_types' => [
            'domain' => 'Storages',
            'relationships' => [
            ],
            'allowedSorts' => [
                'id',
                'name',
            ],
            'allowedFilters' => [
                'id',
                'name',
            ]
        ],
        'cells' => [
            'domain' => 'Storages',
            'relationships' => [
                [
                    'type' => 'locations',
                    'method' => 'location'
                ],
                [
                    'type' => 'cell_types',
                    'method' => 'cellType'
                ]
            ]
        ]
    ]
];
