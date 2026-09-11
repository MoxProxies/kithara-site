<?php

/*
|--------------------------------------------------------------------------
| Kithara site settings
|--------------------------------------------------------------------------
|
| Business details used across the marketing site and legal pages. Set the
| real values in .env so nothing company-specific is committed to git.
|
*/

return [

    'company_name' => env('KITHARA_COMPANY_NAME', 'Charitou Multimedia Solutions Inc.'),

    // Leave empty until there is a real mailing address; the placeholder from older
    // .env files is ignored so it can never reach the legal pages or the structured data.
    'company_address' => str_contains((string) env('KITHARA_COMPANY_ADDRESS', ''), 'Example Street') ? '' : trim((string) env('KITHARA_COMPANY_ADDRESS', '')),

    // Canadian province whose law governs the Terms. Canada itself is assumed.
    'province' => env('KITHARA_PROVINCE', 'Ontario'),

    // Shown publicly on the contact page and in the legal documents.
    'support_email' => env('KITHARA_SUPPORT_EMAIL', 'support@example.com'),

    // Where contact form submissions are delivered.
    'contact_to' => env('KITHARA_CONTACT_TO', env('KITHARA_SUPPORT_EMAIL', 'support@example.com')),

    // Flip to true once the Play listing is approved. Until then every store button
    // renders as a "coming soon" pill and the download band changes copy.
    'play_live' => (bool) env('KITHARA_PLAY_LIVE', false),

    'play_store_url' => env('KITHARA_PLAY_STORE_URL', '#'),

    // Date shown as "Last updated" on the Terms and Privacy pages.
    'legal_updated' => '10 September 2026',

];
