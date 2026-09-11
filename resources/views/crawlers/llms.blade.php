# Kithara

> Kithara is a free audiobook player for Android that plays the files you own, from a folder on the phone, an Audiobookshelf server, or a self-hosted sync server. It reads chapters out of m4b and mp3 files, keeps your position in step across devices, and makes no network requests except to servers you add yourself. Published by {{ config('kithara.company_name') }}, Ontario, Canada.

## Key facts

- Platform: Android 8.0 or later. No iOS version.
- Price: free with no ads or time limits. Kithara Pro is a one-time in-app purchase through Google Play (not a subscription).
- Free: playback, chapters, speed, skip silence, sleep timer with fade and shake-to-extend, Android Auto, Bluetooth and notification controls, bookmarks, search, one folder on the device.
- Pro: Audiobookshelf and Kithara sync-server libraries, streaming, downloads, cross-device position sync (bookmarks too on Kithara servers), multiple libraries, listening stats with a per-library shelf card, 56 achievements, on-device Whisper transcripts, themes.
- Formats: m4b, m4a, mp4, aac, mp3, ogg, oga, opus, flac, wav, wma, mka, 3gp. Not Audible .aax (DRM).
- Chapters: read from m4b chpl atoms and QuickTime chapter tracks, ID3 CHAP frames, .cue sheets, or the server; multi-file books with no marks get one chapter per file.
- Privacy: no account, no analytics, no telemetry. Only network traffic is to servers the user adds, plus a one-time speech-model download if transcripts are enabled.
- Availability: {{ config('kithara.play_live') ? 'Google Play, '.config('kithara.play_store_url') : 'in review on Google Play; a notify-me list is on the home page' }}.

## Pages

- [Home]({{ route('home') }}): features, Pro, transcripts, FAQ
- [Kithara Pro]({{ route('pro') }}): free versus Pro, one-time purchase details
- [Audiobookshelf]({{ route('audiobookshelf') }}): setup, streaming, downloads, sync rules
- [Transcripts]({{ route('transcripts') }}): on-device Whisper, model sizes, privacy
- [Formats and chapters]({{ route('formats') }}): supported formats, folder conventions, chapter sources
- [Android Auto]({{ route('android-auto') }}): car screen, voice search, Bluetooth
- [Sync protocol]({{ route('sync-protocol') }}): version 1 of the HTTP spec for self-hosted servers
- [How to add chapters to an m4b]({{ route('howto.m4b-chapters') }}): ffmpeg commands to add, fix or merge chapters, plus the cue-sheet alternative
- [Comparisons]({{ route('compare') }}): Kithara vs [Smart AudioBook Player]({{ route('compare.smart-audiobook-player') }}), [the Audiobookshelf app]({{ route('compare.audiobookshelf-app') }}) and [Audible]({{ route('compare.audible') }})
- [Changelog]({{ route('changelog') }}): release notes, also as [RSS]({{ route('changelog.feed') }})
- [Contact]({{ route('contact') }}): support and press
- [Terms & Conditions]({{ route('terms') }})
- [Privacy Policy]({{ route('privacy') }})
