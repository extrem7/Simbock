<?php

return [
    'domain' => env('APP_DOMAIN'),
    'emails_for_contacts' => parse_emails(env('CONTACT_EMAILS'))
];
