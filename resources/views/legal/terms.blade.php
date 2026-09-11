@extends('layouts.legal', [
    'title' => 'Terms & Conditions',
    'intro' => 'The terms for using the Kithara Android app and this website: your licence, the files and servers you bring, Google Play purchases and refunds, and the limits of our liability under Ontario law.',
    'sections' => [
        'acceptance' => '1. Acceptance of these terms',
        'eligibility' => '2. Who can use Kithara',
        'licence' => '3. Your licence to use the app',
        'your-content' => '4. Your audiobooks and content',
        'servers' => '5. Servers you connect to',
        'acceptable-use' => '6. Acceptable use',
        'purchases' => '7. Purchases',
        'ip' => '8. Intellectual property',
        'third-party' => '9. Third-party services',
        'disclaimer' => '10. Disclaimers',
        'liability' => '11. Limitation of liability',
        'termination' => '12. Termination',
        'changes' => '13. Changes to these terms',
        'law' => '14. Governing law',
        'contact' => '15. Contact us',
    ],
])

@php
    $company = config('kithara.company_name');
    $email = config('kithara.support_email');
@endphp

@section('document')
<p>These Terms &amp; Conditions ("<strong>Terms</strong>") govern your use of the Kithara Android application (the "<strong>App</strong>") and the website at {{ request()->getHost() }} (the "<strong>Site</strong>"), together the "<strong>Service</strong>". The Service is provided by <strong>{{ $company }}</strong> ("<strong>we</strong>", "<strong>us</strong>", "<strong>our</strong>").</p>

<h2 id="acceptance">1. Acceptance of these terms</h2>
<p>By downloading, installing or using the App, or by browsing the Site, you agree to be bound by these Terms and our <a href="{{ route('privacy') }}">Privacy Policy</a>. If you do not agree, do not use the Service.</p>

<h2 id="eligibility">2. Who can use Kithara</h2>
<p>You must be at least 13 years old (or the minimum age required in your country to use an app without parental consent) to use the Service. If you are under 18, you confirm that a parent or guardian has reviewed and agreed to these Terms on your behalf.</p>

<h2 id="licence">3. Your licence to use the app</h2>
<p>Subject to these Terms, we grant you a limited, non-exclusive, non-transferable, revocable licence to install and use the App on Android devices you own or control, for your personal, non-commercial use. You may not:</p>
<ul>
    <li>copy, modify, distribute, sell or lease any part of the App;</li>
    <li>reverse-engineer, decompile or attempt to extract the source code of the App, except where the law expressly permits it;</li>
    <li>remove or alter any copyright, trademark or other proprietary notices; or</li>
    <li>use the App in any way that violates applicable laws or these Terms.</li>
</ul>
<p>The App is distributed through Google Play. Google's own terms also apply to your download and use of the App.</p>

<h2 id="your-content">4. Your audiobooks and content</h2>
<p>Kithara is a <strong>player</strong>. We do not sell, host or distribute audiobooks. You are solely responsible for the audio files you point the App at, whether they are in a folder on your device or on a server you connect to, and you represent that you have the legal right to possess and play them. You must not use the App to play content that infringes anyone's copyright or other rights.</p>
<p>We do not claim any ownership of your files, your listening positions, your bookmarks or your listening statistics. That data lives on your device and, where you choose, on servers you control.</p>

<h2 id="servers">5. Servers you connect to</h2>
<p>The App can connect to an Audiobookshelf server, or to a server implementing the Kithara sync protocol, that you or a third party operate. When you do:</p>
<ul>
    <li>you are responsible for that server, its availability, its security and its contents;</li>
    <li>you must have permission from whoever runs the server to use it;</li>
    <li>your credentials are exchanged for an access token that is stored on your device, and you are responsible for keeping your device and that server account secure; and</li>
    <li>we have no access to, and no responsibility for, data held on that server.</li>
</ul>
<p>Audiobookshelf is an independent open-source project and is not affiliated with us. Server APIs change; we make reasonable efforts to keep the App compatible but cannot guarantee it will work with every server version.</p>

<h2 id="acceptable-use">6. Acceptable use</h2>
<p>You agree not to:</p>
<ul>
    <li>use the Service for any unlawful purpose or in breach of any third party's rights;</li>
    <li>use the App to access a server without authorisation;</li>
    <li>interfere with or disrupt the Site or its infrastructure;</li>
    <li>use automated means to access the Site other than through interfaces we provide; or</li>
    <li>send malicious code or abusive content through the contact form or any other channel.</li>
</ul>

<h2 id="purchases">7. Purchases</h2>
<p>The App is free to download and everything needed to listen is free, with no advertising and no time limit. <strong>Kithara Pro</strong> is a one-time in-app purchase that unlocks additional features such as server libraries, downloads, cross-device sync, multiple libraries, transcripts, statistics, achievements and themes. Pro is processed by Google Play Billing; we never see or store your payment details.</p>
<ul>
    <li><strong>Pricing.</strong> The price is shown in Google Play before you buy and may vary by region. Taxes may be added.</li>
    <li><strong>One-time.</strong> Pro is not a subscription. It does not renew and there is nothing to cancel. Google Play is the record of ownership; the App caches the result so Pro keeps working offline.</li>
    <li><strong>Refunds.</strong> Refunds are handled by Google under the Google Play refund policy. We cannot issue refunds directly, but we are happy to help you find the right place to request one.</li>
    <li><strong>Changes.</strong> We may add features to Pro, change its price for new buyers, or offer additional purchases in future. Features you have already unlocked will not be removed from your purchase.</li>
</ul>
<p>Listening statistics and achievements are recorded whether or not Pro is owned, but they are stored per device and do not sync between devices.</p>

<h2 id="ip">8. Intellectual property</h2>
<p>The App, the Site, and all associated software, designs, logos, text and graphics are owned by {{ $company }} or our licensors and are protected by copyright, trademark and other laws. "Kithara" and the Kithara logo are trademarks of {{ rtrim($company, ".") }}. Nothing in these Terms gives you any right to use our branding without our prior written consent.</p>
<p>If you send us feedback or suggestions, you grant us a perpetual, royalty-free licence to use them without obligation to you.</p>

<h2 id="third-party">9. Third-party services and components</h2>
<p>The App integrates with services we do not control, including Google Play, Android Auto, and any Audiobookshelf or sync server you connect to. Your use of those services is governed by their own terms and privacy policies. We are not responsible for third-party services or content.</p>
<p>The transcripts feature uses open-source speech recognition components (Whisper models and the sherpa-onnx runtime) that run on your device under their own licences, and downloads model files from a public mirror on Hugging Face. Transcripts are generated automatically by a machine and will contain errors, especially with names, accents and background noise. They are provided for your personal convenience only and are not a substitute for the audio.</p>

<h2 id="disclaimer">10. Disclaimers</h2>
<p>The Service is provided "<strong>as is</strong>" and "<strong>as available</strong>". To the fullest extent permitted by law, we disclaim all warranties, express or implied, including warranties of merchantability, fitness for a particular purpose and non-infringement. We do not warrant that the Service will be uninterrupted, error-free, or compatible with every device, audio file or server.</p>
<p><strong>Please back up your files.</strong> While we take care with your data, we are not responsible for the loss of audio files, listening positions, statistics or transcripts, whether stored on your device or on a server you connect to.</p>

<h2 id="liability">11. Limitation of liability</h2>
<p>To the fullest extent permitted by law, {{ $company }} and its officers, employees and contractors will not be liable for any indirect, incidental, special, consequential or punitive damages, or for any loss of data, profits or goodwill, arising out of or relating to your use of the Service. Our total liability for any claim relating to the Service is limited to the greater of (a) the amount you paid us in the 12 months before the claim arose, or (b) CA$50 (or the equivalent in your local currency).</p>
<p>Nothing in these Terms excludes or limits liability that cannot be excluded by law, including liability for death or personal injury caused by negligence, or for fraud.</p>

<h2 id="termination">12. Termination</h2>
<p>You may stop using the Service at any time by uninstalling the App. We may suspend or terminate your access if you materially breach these Terms, and we may discontinue the Service (or any part of it) with reasonable notice. Sections 4, 8, 10, 11, 14 and any other provisions which by their nature should survive will survive termination.</p>

<h2 id="changes">13. Changes to these terms</h2>
<p>We may update these Terms from time to time. If we make material changes we will post the new version on the Site at least 14 days before they take effect. Continued use of the Service after that date means you accept the updated Terms.</p>

<h2 id="law">14. Governing law</h2>
<p>These Terms are governed by the laws of the Province of {{ config('kithara.province') }} and the federal laws of Canada applicable in it, without regard to conflict-of-law rules. You agree that the courts of {{ config('kithara.province') }} have exclusive jurisdiction over any dispute arising from the Service, without prejudice to any mandatory consumer-protection rights you have where you live. If you are a consumer in a jurisdiction whose law does not allow a clause in these Terms, that clause applies to you only to the extent permitted.</p>

<h2 id="contact">15. Contact us</h2>
<p>Questions about these Terms? Email us at <a href="mailto:{{ $email }}">{{ $email }}</a> or use the <a href="{{ route('contact') }}">contact form</a>.</p>
@if (config('kithara.company_address'))
<p>{{ $company }}<br>{{ config('kithara.company_address') }}</p>
@endif
@endsection
