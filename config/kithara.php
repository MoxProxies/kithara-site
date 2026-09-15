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

$config = [

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

    /*
    | Where the app is on Google Play. One of:
    |   soon     not on Play yet: coming-soon pills, notify-me list (default)
    |   testing  on Play as an internal/closed test: "join the test" buttons pointing at
    |            play_test_url, and the notify-me list doubles as the tester sign-up
    |   live     public listing: real store buttons, installUrl in the structured data,
    |            and kithara:announce-launch may run
    | KITHARA_PLAY_LIVE=true is kept as a synonym for KITHARA_PLAY_STAGE=live.
    */
    'play_stage' => in_array(env('KITHARA_PLAY_STAGE'), ['soon', 'testing', 'live'], true)
        ? env('KITHARA_PLAY_STAGE')
        : (filter_var(env('KITHARA_PLAY_LIVE', false), FILTER_VALIDATE_BOOL) ? 'live' : 'soon'),

    // Public listing URL, used only when the stage is live.
    'play_store_url' => env('KITHARA_PLAY_STORE_URL', '#'),

    // Internal/closed test opt-in URL (play.google.com/apps/internaltest/...), used only
    // when the stage is testing. Testers must be on the list in the Play Console first.
    'play_test_url' => env('KITHARA_PLAY_TEST_URL', '#'),

    // Date shown as "Last updated" on the Terms and Privacy pages.
    'legal_updated' => '10 September 2026',

];

$config['play_live'] = $config['play_stage'] === 'live';
$config['play_testing'] = $config['play_stage'] === 'testing';

return $config;
