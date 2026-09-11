{{-- Site-wide structured data: who publishes Kithara, what the site is, and what the app is. --}}
@php
    $org = [
        '@type' => 'Organization',
        '@id' => url('/#organization'),
        'name' => config('kithara.company_name'),
        'url' => url('/'),
        'logo' => asset('logo.svg'),
        'email' => config('kithara.support_email'),
    ];

    if (config('kithara.company_address')) {
        $org['address'] = ['@type' => 'PostalAddress', 'streetAddress' => config('kithara.company_address')];
    }

    $app = [
        '@type' => ['SoftwareApplication', 'MobileApplication'],
        '@id' => url('/#app'),
        'name' => 'Kithara',
        'url' => url('/'),
        'image' => asset('img/og.png'),
        'description' => 'A free audiobook player for Android that plays the files you own, from a folder on the phone, an Audiobookshelf server, or a self-hosted sync server. It reads chapters out of m4b and mp3 files, keeps your position in step across devices, and makes no network requests except to servers you add yourself.',
        'operatingSystem' => 'Android 8.0 or later',
        'applicationCategory' => 'MultimediaApplication',
        'applicationSubCategory' => 'Audiobook player',
        'isAccessibleForFree' => true,
        'offers' => [
            ['@type' => 'Offer', 'name' => 'Kithara', 'price' => '0', 'priceCurrency' => 'CAD', 'description' => 'Free to listen: playback, chapters, sleep timer, Android Auto, bookmarks, one folder on the device.'],
            ['@type' => 'Offer', 'name' => 'Kithara Pro', 'category' => 'One-time in-app purchase', 'description' => 'Server libraries (Audiobookshelf and the Kithara sync protocol), streaming, downloads, cross-device sync, multiple libraries, listening stats, achievements, on-device transcripts and themes.'],
        ],
        'featureList' => [
            'Plays m4b, m4a, mp4, aac, mp3, ogg, opus, flac, wav, wma, mka and 3gp files',
            'Reads chapters from m4b atoms, ID3 CHAP frames and .cue sheets',
            'Audiobookshelf client with streaming, downloads and position sync',
            'LibriVox built in: free public-domain audiobooks to search, stream and download',
            'Sleep timer with fade-out and shake to extend',
            'Android Auto with voice search',
            'On-device Whisper transcripts (Pro)',
            'Listening statistics and 56 achievements (Pro)',
            'No account, no analytics, no telemetry',
        ],
        'screenshot' => [
            asset('img/screens/player@2x.webp'),
            asset('img/screens/library@2x.webp'),
            asset('img/screens/stats@2x.webp'),
            asset('img/screens/transcript@2x.webp'),
            asset('img/screens/achievements@2x.webp'),
        ],
        'author' => ['@id' => url('/#organization')],
        'publisher' => ['@id' => url('/#organization')],
        'releaseNotes' => route('changelog'),
        'termsOfService' => route('terms'),
        'privacyPolicy' => route('privacy'),
    ];

    if ($released = \App\Support\Releases::latestReleased()) {
        $app['softwareVersion'] = $released['version'];
        $app['dateModified'] = $released['date'];
    }

    if (config('kithara.play_live')) {
        $app['installUrl'] = config('kithara.play_store_url');
        $app['downloadUrl'] = config('kithara.play_store_url');
    }

    $site = [
        '@type' => 'WebSite',
        '@id' => url('/#website'),
        'name' => 'Kithara',
        'url' => url('/'),
        'publisher' => ['@id' => url('/#organization')],
        'inLanguage' => 'en',
    ];

    $graph = ['@'.'context' => 'https://schema.org', '@graph' => [$org, $site, $app]];
@endphp
<script type="application/ld+json">{!! json_encode($graph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
