{{-- One source for the visible FAQ and its FAQPage structured data. Answers follow FEATURES.md in the app repo. --}}
@php
    $faqs = [
        [
            'Is Kithara free?',
            'Yes. Everything you need to listen is free, with no ads and no time limit: playback, chapters, speed and skip silence, the sleep timer, Android Auto and Bluetooth controls, bookmarks, search and one folder on the device. Kithara Pro is a one-time purchase through Google Play, not a subscription. It unlocks server libraries, streaming and downloads, cross-device sync, more than one library, listening stats, achievements, transcripts and themes.',
        ],
        [
            'Does Kithara work with Audiobookshelf?',
            'Yes. Add your Audiobookshelf server with its address, username and password. Books stream by default, you can download any book for offline listening by tapping the cloud badge on its cover, and your position syncs across devices. Kithara is written against the Audiobookshelf v2 API. Server libraries are part of Kithara Pro. No server yet? This site has a step-by-step setup guide.',
        ],
        [
            'What audio formats does it play?',
            'm4b, m4a, mp4, aac, mp3, ogg, oga, opus, flac, wav, wma, mka and 3gp. A folder of numbered mp3s is treated as one book on one continuous timeline. Audible .aax files are DRM-protected and will not play.',
        ],
        [
            'Do I need an account?',
            'No. There is no Kithara account, no sign-up and no analytics. The only network requests the app makes are to servers you add yourself, such as your own Audiobookshelf.',
        ],
        [
            'How does Kithara find chapters?',
            'It reads them out of the files: the chpl chapter atom and QuickTime chapter track in m4b files, ID3 CHAP frames in mp3s, a .cue sheet beside a single large file, or the chapter list from your server. If a multi-file book has no chapter marks, each file becomes a chapter. Files with no chapters at all can be fixed in ten minutes with ffmpeg; see the how-to on this site.',
        ],
        [
            'Does Kithara come with any free audiobooks?',
            'Yes. Add LibriVox as a library and you can search thousands of free, volunteer-read public-domain audiobooks by title or author, add them to your library, stream them from the Internet Archive or download them for offline listening, with a chapter per section. It is part of the free app, not Pro, and needs no account.',
        ],
        [
            'What languages is Kithara available in?',
            'English, with French (Canada), Spanish, German, Portuguese (Brazil) and Italian in progress. Those translations are generated automatically and corrected as people report problems, so if a screen reads badly in your language, please tell us.',
        ],
        [
            'Is there an iPhone or iOS version?',
            'No. Kithara is Android only and runs on Android 8.0 or later.',
        ],
        [
            'Does it work with Android Auto?',
            'Yes. Your libraries, continue listening, recently added, authors and the current book\'s chapters all appear in the car, with voice search over title, author, narrator and series, and 10-second skip buttons on the head unit. Bluetooth play resumes your last book without opening the app.',
        ],
        [
            'Will my position sync between my phone and tablet?',
            'With a server library, yes: position and finished state sync through Audiobookshelf or a Kithara sync server, and unpushed local changes always win, so listening offline never rewinds you. Bookmarks sync both ways with a Kithara server and push one way to Audiobookshelf. Listening stats and achievements stay on each device.',
        ],
        [
            'What are transcripts?',
            'A Pro feature that turns a chapter into timed text using a Whisper speech-recognition model that runs entirely on your device. The first time you use it, Kithara downloads an English model of about 105 MB to 360 MB, depending on the size you choose. Nothing you listen to is sent anywhere.',
        ],
        [
            'Where do I get audiobooks for it?',
            'Kithara is a player, not a store. It plays DRM-free files you already own: purchases from DRM-free audiobook shops, rips of CDs you own, or anything in your Audiobookshelf library. It also has LibriVox built in: thousands of free public-domain audiobooks you can search, stream and download without an account. The how-to on leaving Audible lists the DRM-free shops.',
        ],
    ];

    $faqSchema = [
        '@'.'context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn ($qa) => [
            '@type' => 'Question',
            'name' => $qa[0],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $qa[1]],
        ], $faqs),
    ];
@endphp

@push('head')
<script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

<section class="section section-alt" id="faq">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow">Questions</span>
            <h2>Straight answers</h2>
        </div>

        <div class="faq" data-reveal-group>
            @foreach ($faqs as $i => [$question, $answer])
                <details class="faq-item" @if ($i === 0) open @endif>
                    <summary><h3>{{ $question }}</h3></summary>
                    <p>{{ $answer }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
