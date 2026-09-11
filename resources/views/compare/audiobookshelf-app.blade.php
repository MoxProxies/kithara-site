@extends('layouts.guide', [
    'title' => 'Kithara vs the Audiobookshelf app',
    'eyebrow' => 'Comparison',
    'intro' => 'If you run an Audiobookshelf server you already have a client: the official app, which is free, open source and maintained by the same project. Kithara is a second Android client with a different emphasis. Here is when each one makes sense.',
    'description' => 'The official Audiobookshelf app or Kithara as your Android client? The official app is free, open source and covers podcasts and ebooks. Kithara adds local folder libraries alongside the server, offline-safe sync rules, on-device transcripts and listening stats. An honest comparison.',
])

@section('body')
<h2 id="at-a-glance">At a glance</h2>
@include('partials.compare-table', ['other' => 'Audiobookshelf app', 'rows' => [
    ['Platform', 'Android 8.0 and later', 'Android and iOS'],
    ['Price', 'Free; Pro is a one-time purchase', 'Free and open source'],
    ['Audiobookshelf server', 'Yes: streaming, downloads, position sync (Pro)', 'Yes, it is the reference client'],
    ['Local folders as a library', 'Yes, alongside server tabs, without a server at all', 'Local playback is built around items downloaded from the server'],
    ['Other servers', 'Anything speaking the Kithara sync protocol', 'Audiobookshelf only'],
    ['Podcasts', 'No', 'Yes'],
    ['Ebooks', 'No', 'Yes, with a reader'],
    ['Position sync', 'Push first, then pull; unpushed local changes always win', 'Syncs progress with the server'],
    ['Chapters from the file', 'Read on the phone for local files; from the server otherwise', 'From the server'],
    ['Transcripts', 'On-device Whisper, read-along and search (Pro)', 'No'],
    ['Listening stats', 'On the device: goal, streaks, 30-day chart, achievements (Pro)', 'On the server, shown in the app'],
    ['Android Auto', 'Yes, with voice search', 'Yes'],
    ['Account required', 'No', 'A server login'],
]])

<h2 id="choose-official">Where the official app is the better choice</h2>
<ul>
    <li><strong>You listen to podcasts or read ebooks through Audiobookshelf.</strong> Kithara does neither; the official app does both.</li>
    <li><strong>You need iOS too.</strong> Kithara is Android only.</li>
    <li><strong>You want every server feature the moment it ships.</strong> Collections, playlists, series views and whatever comes next arrive in the official client first, by definition.</li>
    <li><strong>Free and open source matters to you.</strong> The official app is both. Kithara's server features are a paid unlock.</li>
</ul>

<h2 id="choose-kithara">Where Kithara is the better choice</h2>
<ul>
    <li><strong>You have files that are not on the server.</strong> A folder on the phone, an SD card or a USB stick is a full library in Kithara, with chapters read from the files, next to your server tab. No server needed to start.</li>
    <li><strong>You listen offline a lot.</strong> Kithara's sync rule is written for flights and dead zones: the phone pushes before it pulls, and a stale server timestamp can never rewind you.</li>
    <li><strong>You want transcripts.</strong> Search a book for a phrase, read along with the current line highlighted, tap to jump. All on the phone.</li>
    <li><strong>You like the stats on the device.</strong> Daily goal, streaks and achievements work with no server involved, and the history is kept from day one.</li>
    <li><strong>You might build your own server one day.</strong> Kithara also speaks a <a href="{{ route('sync-protocol') }}">six-route protocol</a> that a small script can implement.</li>
</ul>

<h2 id="both">Or use both</h2>
<p>Nothing stops you. Both clients sync progress through the same server, so you can keep the official app for podcasts and use Kithara for the books, and your position follows you either way.</p>
@endsection
