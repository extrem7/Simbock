<?php

return [
    'debugbar_emails' => [env('DEBUGBAR_EMAIL')],
    'plans' => [
        [
            'stripe_plan' => 'price_1I1rLoJ7D6nBxczV6mD4eCSs',
            'name' => 'Starter',
            'price' => 11.50,
            'advantages' => [
                'Post 1 vacancy',
                '50 Resume view',
                '5 candidate recommendations'
            ],
            'limits' => [
                'vacancies' => 2,
                'volunteers' => 50,
                'recommendations' => 5
            ]
        ],
        [
            'stripe_plan' => 'price_1I1sB9J7D6nBxczVjId5w0U8',
            'name' => 'Standard',
            'price' => 19.50,
            'description' => 'Hire easily on a budget',
            'advantages' => [
                'Post up to 10 vacancies',
                'Up to 100 Resume views',
                'Up to 12 candidate recommendations',
                'Search the database'
            ],
            'limits' => [
                'vacancies' => 10,
                'volunteers' => 100,
                'recommendations' => 12
            ]
        ],
        [
            'stripe_plan' => 'price_1I3kv8J7D6nBxczVr5cYvrmK',
            'name' => 'Premium',
            'price' => 25.50,
            'description' => 'Find qualified candidates fast',
            'advantages' => [
                'Post up to 100 vacancies',
                'Up to 150 Resume views',
                'Up to 20 candidate recommendations',
                'Search the database'
            ],
            'limits' => [
                'vacancies' => 100,
                'volunteers' => 150,
                'recommendations' => 20
            ]
        ],
        [
            'stripe_plan' => 'price_1I3kvmJ7D6nBxczVo3jGGfiM',
            'name' => 'Enterprise',
            'price' => 65.50,
            'advantages' => [
                'Post unlimited vacancies',
                'Unlimited Resume views',
                'Unlimited candidate recommendations',
                'Unlimited Search through our and partner database'
            ],
            'limits' => [
                'vacancies' => -1,
                'volunteers' => -1,
                'recommendations' => -1
            ]
        ]
    ]
];
