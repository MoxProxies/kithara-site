@extends('layouts.legal', [
    'title' => 'Privacy Policy',
    'intro' => 'Kithara has no accounts, no analytics and no telemetry. It talks to the servers you add, and nothing else apart from a one-time speech model download if you use transcripts. This page explains what that means in practice, and what this website collects.',
    'sections' => [
        'summary' => '1. The short version',
        'app' => '2. Data in the app',
        'servers' => '3. Servers you connect to',
        'transcripts' => '4. Transcripts',
        'play' => '5. Google Play',
        'permissions' => '6. Android permissions',
        'site' => '7. This website',
        'retention' => '8. How long we keep it',
        'rights' => '9. Your rights',
        'children' => '10. Children',
        'security' => '11. Security',
        'cookies' => '12. Cookies',
        'changes' => '13. Changes to this policy',
        'contact' => '14. Contact us',
    ],
])

@php
    $company = config('kithara.company_name');
    $email = config('kithara.support_email');
@endphp

@section('document')
<p>This Privacy Policy explains how <strong>{{ $company }}</strong>, a company incorporated in {{ config('kithara.province') }}, Canada ("<strong>we</strong>", "<strong>us</strong>"), handles information in relation to the Kithara Android application (the "<strong>App</strong>") and this website (the "<strong>Site</strong>"). We follow Canada's Personal Information Protection and Electronic Documents Act (PIPEDA) and, where they apply to you, the GDPR, the UK GDPR and comparable laws. Where we act as a data controller, it is only for the small amount of data described in section 7.</p>

<h2 id="summary">1. The short version</h2>
<ul>
    <li>The App has no account system, no analytics and no telemetry, and shows no advertising.</li>
    <li>The App does not send us anything. Its network traffic is to servers you add yourself, plus a one-time download of a speech model if you turn on transcripts.</li>
    <li>Your audiobooks, listening positions, statistics and transcripts stay on your device, and on your own server if you connect one.</li>
    <li>The only personal data we hold is what you send us through the contact form or by email.</li>
</ul>

<h2 id="app">2. Data in the app</h2>
<p>The App stores the following on your device so that it can work. None of it is transmitted to us.</p>
<ul>
    <li><strong>Your library</strong>: file paths, titles, authors, covers, durations and chapter lists read from the audio files you point it at.</li>
    <li><strong>Listening data</strong>: your position in each book, bookmarks, listening statistics measured from time spent actually playing, and achievements.</li>
    <li><strong>Transcripts</strong>: text generated from chapters you choose to transcribe (see section 4), plus the downloaded speech model.</li>
    <li><strong>Pro status</strong>: whether Kithara Pro is owned, cached from Google Play so Pro keeps working offline.</li>
    <li><strong>Server credentials</strong>: if you connect a server, your password is exchanged for an access token at sign-in and then discarded. Only the token and the server address are stored.</li>
    <li><strong>Downloads</strong>: books you choose to pin for offline use are stored in the App's private storage.</li>
</ul>
<p>Uninstalling the App removes all of this from your device.</p>

<h2 id="servers">3. Servers you connect to</h2>
<p>You can connect the App to an Audiobookshelf server, or to a server implementing the Kithara sync protocol. When you do, the App sends that server your credentials at sign-in, and afterwards your listening positions and library requests, so that your progress stays in step across devices.</p>
<p>That server is operated by you or by whoever you got the login from, not by us. We have no access to it and no visibility of what it holds. How it handles your data is governed by its operator and, for Audiobookshelf, by that project's own documentation.</p>

<h2 id="transcripts">4. Transcripts</h2>
<p>Kithara Pro can turn a chapter into timed text so you can read along or search a book. <strong>Transcription runs entirely on your device.</strong> No audio, text or metadata is uploaded anywhere, and transcripts are stored only on the device alongside your other listening data.</p>
<p>Speech models are not bundled with the App because of their size (roughly 100 MB to 360 MB). The first time you use transcripts, the App downloads the model you choose from a public mirror maintained by the sherpa-onnx project on Hugging Face. That download is an ordinary HTTPS request and, like any web request, exposes your IP address and the file requested to Hugging Face under <a href="https://huggingface.co/privacy" rel="noopener">their privacy policy</a>. Nothing about you, your books or your listening is included. Once downloaded, the model stays on the device and no further requests are made.</p>

<h2 id="play">5. Google Play</h2>
<p>The App is distributed through Google Play, and Kithara Pro is sold as a one-time in-app purchase processed by Google Play Billing. Google collects information about your download, purchases and device under <a href="https://policies.google.com/privacy" rel="noopener">Google's privacy policy</a>. We receive purchase confirmations, and Google may share aggregated, anonymised crash and installation statistics with us through the Play Console. We never receive your payment details.</p>

<h2 id="permissions">6. Android permissions</h2>
<p>The App requests only what it needs to play audio:</p>
<ul>
    <li><strong>Notifications</strong>: to show playback controls. Playback works without it.</li>
    <li><strong>Foreground service and wake lock</strong>: to keep playing while the screen is off.</li>
    <li><strong>Internet</strong>: to talk to servers you add, to download a speech model for transcripts, and for Google Play Billing. Nothing else uses it.</li>
    <li><strong>Folder access</strong>: only for folders you explicitly pick when adding a library.</li>
</ul>
<p>The App does not request access to your location, contacts, camera, microphone or other apps. The App does not use the telephony permission; it detects interruptions such as calls through audio focus instead.</p>

<h2 id="site">7. This website</h2>
<p>The Site is the one place we collect personal data:</p>
<ul>
    <li><strong>Contact messages</strong>: your name, email address, chosen topic and message when you use the contact form or email us. We use these to reply to you and to refer back to previous support conversations. Legal basis: our legitimate interest in responding to enquiries.</li>
    <li><strong>Launch notifications</strong>: if you leave your email address on the "coming soon" form, we store it so we can send you one message when the App is released on Google Play. We do not use it for anything else, and we delete the list within 30 days of sending that message. Legal basis: your consent, which you can withdraw at any time by emailing us.</li>
    <li><strong>Server logs</strong>: our hosting provider records the IP address, browser and pages requested for each visit, for security and debugging. Legal basis: our legitimate interest in keeping the Site secure.</li>
</ul>
<p>We use a hosting provider and an email delivery provider to run the Site and the contact form. They process this data on our behalf under contract, and their servers may be located outside Canada, including in the United States and the European Union. Data held there is subject to the laws of that country and may be accessible to its authorities. We do not sell personal data and do not share it with anyone else, except where required by law.</p>

<h2 id="retention">8. How long we keep it</h2>
<ul>
    <li><strong>Contact messages</strong>: up to 2 years, so we can refer back to previous support conversations.</li>
    <li><strong>Launch notification emails</strong>: until 30 days after the release announcement is sent.</li>
    <li><strong>Server logs</strong>: up to 90 days.</li>
    <li><strong>App data</strong>: on your device until you delete it or uninstall the App. Transcripts and speech models can be deleted individually from within the App. We hold none of it.</li>
</ul>

<h2 id="rights">9. Your rights</h2>
<p>You have the right to ask what personal data we hold about you, to have it corrected, and to withdraw consent or ask for it to be deleted. Depending on where you live you may also have the right to receive a copy in a portable format, to object to or restrict certain processing, and to complain to a privacy regulator: in Canada, the <a href="https://www.priv.gc.ca" rel="noopener">Office of the Privacy Commissioner of Canada</a>; in the UK, the Information Commissioner's Office; in the EU, your national supervisory authority.</p>
<p>In practice, the only data we hold is contact correspondence. Email <a href="mailto:{{ $email }}">{{ $email }}</a> and we will respond within 30 days. We may ask you to verify your identity first.</p>
<p><strong>California residents:</strong> we do not sell or share personal information as defined by the CCPA/CPRA, and we do not discriminate against you for exercising your rights.</p>

<h2 id="children">10. Children</h2>
<p>The App and Site are not directed at children under 13, and we do not knowingly collect personal data from them. If you believe a child has sent us personal data, contact us and we will delete it.</p>

<h2 id="security">11. Security</h2>
<p>The Site is served over TLS, and the contact form is protected against automated abuse. Data on your device is protected by Android's app sandbox. If you connect a server, use a strong, unique password for it and prefer an <code>https</code> address when connecting over the internet rather than a home network.</p>

<h2 id="cookies">12. Cookies</h2>
<p>The Site uses only strictly necessary cookies: a session cookie and a CSRF token that protect the contact form. We do not use advertising or tracking cookies, so no consent banner is required. The App uses no cookies.</p>

<h2 id="changes">13. Changes to this policy</h2>
<p>We may update this policy from time to time. We will post the new version here and update the "last updated" date at the top.</p>

<h2 id="contact">14. Contact us</h2>
<p>Privacy questions or requests: <a href="mailto:{{ $email }}">{{ $email }}</a>, or use the <a href="{{ route('contact') }}">contact form</a>.</p>
@if (config('kithara.company_address'))
<p>{{ $company }}<br>{{ config('kithara.company_address') }}</p>
@endif
@endsection
