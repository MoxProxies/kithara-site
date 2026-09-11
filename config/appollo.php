<?php

/*
|--------------------------------------------------------------------------
| Appollo site settings
|--------------------------------------------------------------------------
|
| Business details used across the marketing site and legal pages. Set the
| real values in .env so nothing company-specific is committed to git.
|
*/

return [

    'company_name' => env('APPOLLO_COMPANY_NAME', 'Charitou Multimedia Solutions Inc.'),

    'company_address' => env('APPOLLO_COMPANY_ADDRESS', ''),

    // Canadian province whose law governs the Terms. Canada itself is assumed.
    'province' => env('APPOLLO_PROVINCE', 'Ontario'),

    // Shown publicly on the contact page and in the legal documents.
    'support_email' => env('APPOLLO_SUPPORT_EMAIL', 'support@example.com'),

    // Where contact form submissions are delivered.
    'contact_to' => env('APPOLLO_CONTACT_TO', env('APPOLLO_SUPPORT_EMAIL', 'support@example.com')),

    'play_store_url' => env('APPOLLO_PLAY_STORE_URL', '#'),

    // Date shown as "Last updated" on the Terms and Privacy pages.
    'legal_updated' => '10 September 2026',

];
