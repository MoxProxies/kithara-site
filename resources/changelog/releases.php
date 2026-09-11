<?php

/*
|--------------------------------------------------------------------------
| Release notes
|--------------------------------------------------------------------------
|
| Newest first. Add an entry when a build goes to Google Play; the changelog
| page, the RSS feed and the softwareVersion in the structured data all read
| from here. `date` is null until a version has shipped.
|
| Keys: version, date (Y-m-d or null), status ('coming soon' | 'released'),
|       summary (one sentence), changes (list of short lines).
|
*/

return [
    [
        'version' => '1.0.0',
        'date' => null,
        'status' => 'coming soon',
        'summary' => 'The first release: a player for the audiobook files you own, with Audiobookshelf and self-hosted server support, chapters read from the files, and on-device transcripts.',
        'changes' => [
            'Libraries: a folder on the device, an Audiobookshelf server, a server speaking the Kithara sync protocol, or LibriVox. Several at once, each with its own tab.',
            'LibriVox built in: search thousands of free public-domain audiobooks by title or author, add them, stream from the Internet Archive or download, one chapter per section. Free, no account.',
            'Formats: m4b, m4a, mp4, aac, mp3, ogg, oga, opus, flac, wav, wma, mka and 3gp. A folder of numbered files plays as one book on one timeline.',
            'Chapters read from m4b chpl atoms and QuickTime chapter tracks, ID3 CHAP frames, .cue sheets, or the server.',
            'Streaming over HTTP range requests, downloads that survive reboots, and a Wi-Fi-only switch.',
            'Position sync where unpushed local changes always win, so offline listening never rewinds you.',
            'Playback from 0.5x to 3.5x with pitch preserved, skip silence, configurable skip lengths, smart rewind on resume, and a five-second rewind after calls.',
            'Sleep timer with end-of-chapter mode, a 20-second fade, and shake to add time.',
            'Android Auto with a shallow browse tree, per-book progress and voice search. Bluetooth play resumes the last book with the app closed.',
            'Bookmarks with labels, search, filters, sort and pinning. Bookmarks sync both ways with Kithara servers.',
            'Listening stats with a daily goal, streaks, a 30-day chart and an "On the shelf" card per library, plus 56 achievements in seven groups (Pro).',
            'Transcripts: on-device Whisper speech-to-text per chapter, with read-along highlighting, tap to jump, and whole-book search (Pro).',
            'Themes: light, dark, accent colours and colours from your wallpaper (Pro).',
            'Languages: English, with French (Canada), Spanish, German, Portuguese (Brazil) and Italian in progress.',
        ],
    ],
];
