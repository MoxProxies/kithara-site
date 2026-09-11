@extends('layouts.guide', [
    'title' => 'Kithara vs Smart AudioBook Player',
    'eyebrow' => 'Comparison',
    'intro' => 'Smart AudioBook Player has been the default answer to "which audiobook app for Android" for a decade, and for a phone full of files it is still a fine one. Kithara is for the same listener a few years on, once the books live on a server as well as in a folder.',
    'description' => 'Smart AudioBook Player or Kithara for Android? Both play your own audiobook files. Kithara adds Audiobookshelf and self-hosted server libraries, cross-device sync and on-device transcripts; Smart AudioBook Player is cheaper and more mature. An honest comparison.',
])

@section('body')
<h2 id="at-a-glance">At a glance</h2>
@include('partials.compare-table', ['other' => 'Smart AudioBook Player', 'rows' => [
    ['Platform', 'Android 8.0 and later', 'Android'],
    ['Price', 'Free; Pro is a one-time purchase', 'Free trial, then a one-time purchase for the full version'],
    ['Local files', 'Yes, any folder you pick', 'Yes, any folder you pick'],
    ['Server libraries', 'Audiobookshelf and the open Kithara sync protocol (Pro)', 'No; the library lives on the phone'],
    ['Streaming and downloads', 'Yes, from your server (Pro)', 'Not applicable'],
    ['Position sync across devices', 'Through your server (Pro)', 'No'],
    ['Chapters from the file', 'chpl atoms, QuickTime tracks, ID3 CHAP, .cue sheets', 'Yes, from embedded chapters'],
    ['Playback speed', '0.5x to 3.5x, pitch preserved, skip silence', 'Adjustable, with silence skipping'],
    ['Sleep timer', 'Countdown or end of chapter, fade-out, shake to extend', 'Countdown, shake to extend'],
    ['Android Auto', 'Yes, with voice search', 'Yes'],
    ['Transcripts', 'On-device Whisper, read-along and search (Pro)', 'No'],
    ['Listening stats', 'Daily goal, streaks, 30-day chart, achievements (Pro)', 'Basic statistics'],
    ['Character notes', 'No', 'Yes, a per-book list of characters with notes'],
    ['Account required', 'No', 'No'],
]])

<h2 id="choose-sabp">Where Smart AudioBook Player is the better choice</h2>
<ul>
    <li><strong>You only ever listen on one phone, from files on it.</strong> Everything Kithara adds is about servers and sync. If that is not your setup, a mature app with a long track record is hard to argue with.</li>
    <li><strong>You want it cheaper.</strong> Its one-time unlock costs less than Kithara Pro, and its free tier is a full-featured trial.</li>
    <li><strong>Character notes matter to you.</strong> Its per-book list of who is who has no equivalent in Kithara.</li>
    <li><strong>You want the thing everyone has used for ten years.</strong> Bugs have been found and fixed; guides exist for every setting.</li>
</ul>

<h2 id="choose-kithara">Where Kithara is the better choice</h2>
<ul>
    <li><strong>Your books live on a server.</strong> Audiobookshelf, or anything you build against the six-route sync protocol, becomes a library tab next to your local folder. Stream, download, and pick up on another device.</li>
    <li><strong>You listen on more than one device.</strong> Position, finished state and bookmarks sync through your server, and offline listening never gets rewound by a stale timestamp.</li>
    <li><strong>You want to find a line again.</strong> On-device transcripts let you search a whole book for a phrase and jump straight to it. Nothing leaves the phone.</li>
    <li><strong>The free tier should be a real player, not a trial.</strong> Kithara's free features do not expire; Pro adds the server and sync layer on top.</li>
</ul>

<h2 id="bottom-line">The bottom line</h2>
<p>If your audiobooks are a folder on your phone and that is how you like it, Smart AudioBook Player is a good app and you do not need to switch. If you run Audiobookshelf, listen on a phone and a tablet, or want transcripts, Kithara is built for exactly that. Both play the same DRM-free files, so trying Kithara costs nothing.</p>
@endsection
