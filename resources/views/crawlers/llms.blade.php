# Kithara

> Kithara is a free audiobook player for Android that plays the files you own, from a folder on the phone, an Audiobookshelf server, or a self-hosted sync server. It reads chapters out of m4b and mp3 files, keeps your position in step across devices, and makes no network requests except to servers you add yourself. Published by {{ config('kithara.company_name') }}, Ontario, Canada.

## Key facts

- Platform: Android 8.0 or later. No iOS version.
- Price: free with no ads or time limits. Kithara Pro is a one-time in-app purchase through Google Play (not a subscription).
- Free: playback, chapters, speed, skip silence, sleep timer with fade and shake-to-extend, Android Auto, Bluetooth and notification controls, bookmarks, search, one folder on the device.
- Pro: Audiobookshelf and Kithara sync-server libraries, streaming, downloads, cross-device position sync, multiple libraries, listening stats, achievements, on-device Whisper transcripts, themes.
- Formats: m4b, m4a, mp4, aac, mp3, ogg, oga, opus, flac, wav, wma, mka, 3gp. Not Audible .aax (DRM).
- Chapters: read from m4b chpl atoms and QuickTime chapter tracks, ID3 CHAP frames, .cue sheets, or the server; multi-file books with no marks get one chapter per file.
- Privacy: no account, no analytics, no telemetry. Only network traffic is to servers the user adds, plus a one-time speech-model download if transcripts are enabled.
- Availability: {{ config('kithara.play_live') ? 'Google Play, '.config('kithara.play_store_url') : 'in review on Google Play; a notify-me list is on the home page' }}.

## Pages

- [Home]({{ route('home') }}): features, Pro, transcripts, FAQ
- [Contact]({{ route('contact') }}): support and press
- [Terms & Conditions]({{ route('terms') }})
- [Privacy Policy]({{ route('privacy') }})
