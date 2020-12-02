<?php

return [
    'domain' => env('APP_DOMAIN'),
    'emails_for_contacts' => parse_emails(env('CONTACT_EMAILS', '')),
    'vacancies_company_id' => env('VACANCIES_COMPANY_ID', 1)
];
