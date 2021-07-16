<?php

return [
    'domain' => env('APP_DOMAIN'),
    'emails_for_contacts' => parse_emails(env('CONTACT_EMAILS', '')),
    'vacancies_company_id' => env('VACANCIES_COMPANY_ID', 1),
    'social' => [
        'twitter' => env('SOCIAL_TWITTER'),
        'instagram' => env('SOCIAL_INSTAGRAM'),
        'linkedin' => env('SOCIAL_LINKEDIN'),
        'facebook' => env('SOCIAL_FACEBOOK'),
        'youtube' => env('SOCIAL_YOUTUBE'),
    ]
];
