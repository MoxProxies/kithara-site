@extends('layouts.guide', [
    'title' => 'Kithara for Audiobookshelf',
    'eyebrow' => 'Android client',
    'pro' => true,
    'intro' => 'Point Kithara at your Audiobookshelf server and your whole library shows up on the phone: streaming by default, downloads for the road, and a listening position that stays in step across every device you own.',
    'description' => 'Kithara is an Android client for Audiobookshelf: stream from your server, download books for offline listening, and sync your position across devices without ever losing your place. Setup guide and details.',
])

@section('body')
<figure class="guide-figure">
    <img src="{{ asset('img/mockups/library-isometric.webp') }}" srcset="{{ asset('img/mockups/library-isometric.webp') }} 1x, {{ asset('img/mockups/library-isometric@2x.webp') }} 2x" width="800" height="387" alt="An Android phone lying flat showing a Kithara library in grid view: covers with progress bars, filter chips, and the mini player" loading="lazy">
</figure>

<h2 id="what-you-get">What you get</h2>
<ul>
    <li><strong>Your library, as a tab.</strong> Titles, authors, narrators, series, covers and chapter lists come from the server. You can keep a local folder library open in another tab at the same time.</li>
    <li><strong>Streaming that seeks properly.</strong> Books stream over HTTP range requests, so jumping to hour nine of an m4b is a range request, not a re-download.</li>
    <li><strong>Downloads for offline listening.</strong> Tap the cloud badge on any cover to pin it to the phone. Downloads run in the background and survive reboots and dropped connections.</li>
    <li><strong>Position sync that gets offline right.</strong> Your position, finished state and bookmarks sync through the server. Listen on a flight with no signal and you will not be rewound when you land.</li>
    <li><strong>Android Auto.</strong> Your Audiobookshelf library gets its own node in the car, with voice search.</li>
</ul>

<h2 id="setup">Setting it up</h2>
<p>No server yet? Start with <a href="{{ route('howto.audiobookshelf-setup') }}">the full walkthrough</a>, from Docker to the phone. If Audiobookshelf is already running:</p>
<ol>
    <li>Open <strong>Library</strong>, tap the menu in the top corner, then <strong>Manage libraries</strong> and <strong>Add a library</strong>. (With no libraries yet, the library screen offers a folder, a server or LibriVox directly.) Choose <strong>Audiobookshelf server</strong>.</li>
    <li>Enter the address exactly as you would type it into a browser, including the port, for example <code>http://192.168.1.20:13378</code>. Plain <code>http</code> on your home network is fine and is assumed when you leave the scheme off. If you reach the server over the internet, use <code>https</code>.</li>
    <li>Enter your Audiobookshelf username and password. Kithara exchanges them for a long-lived token at sign-in and then discards the password; only the token is stored on the device.</li>
    <li>The first sync starts immediately and fetches every item's detail, so a large library takes a minute. Later syncs only fetch what changed.</li>
</ol>
<p>You can add several Audiobookshelf servers, or the same server twice with different accounts. Each becomes its own tab, and each can be paused from Settings without losing anything.</p>

<h2 id="offline">Streaming, downloads and Wi-Fi</h2>
<p>Streaming never writes to the download cache, so idly playing a 30-hour book cannot quietly fill the phone. Files land on disk only when you pin a book. Pinned books play with no network at all, and the player does not treat them any differently.</p>
<p>Each download shows its own progress, retries on failure, and can be unpinned to reclaim the space. Settings shows how much storage downloads are using, and there is a <strong>Wi-Fi only</strong> switch that covers both downloads and sync.</p>
<p>The auth token travels in a header rather than the URL, so rotating your token on the server never orphans a download that is already on the phone.</p>

<h2 id="sync">How position sync works</h2>
<p>Kithara pulls progress from the server when the app launches or comes back to the foreground, and pushes on every pause and stop. Writes made while offline are queued and drained on the next connection; a write that keeps failing is retired after eight attempts rather than blocking everything behind it. Settings shows how many changes are waiting.</p>
<p>When the server and the phone disagree, the server position wins only if <em>both</em> of these are true:</p>
<ol>
    <li>the server's timestamp is newer than the phone's, and</li>
    <li>the phone has nothing queued for that book.</li>
</ol>
<p>The second rule is the one that matters. It is what stops a stale position with a newer-looking timestamp from another device silently rewinding you after a few hours of offline listening. Kithara pushes first, then pulls.</p>

<h2 id="limits">What does not sync</h2>
<ul>
    <li><strong>Listening statistics and achievements</strong> stay on each device. Merging daily totals across phones needs more than last-write-wins, so it is deliberately not done yet.</li>
    <li><strong>Bookmarks are one-way with Audiobookshelf.</strong> Bookmarks you make on the phone reach the server; bookmarks made elsewhere do not appear in Kithara yet, and deleting one on the phone does not delete it on the server. (Kithara sync servers do both.)</li>
</ul>

<h2 id="compatibility">Compatibility</h2>
<p>Kithara is written against the Audiobookshelf v2 API. Audiobookshelf is an independent open-source project and is not affiliated with Kithara. If a call starts failing after a server upgrade, <a href="{{ route('contact') }}">let us know</a> which version you are running; the endpoints live in one place and are quick to adjust.</p>
<p>Prefer a server that does exactly what you need and nothing else? Kithara also speaks an <a href="{{ route('sync-protocol') }}">open sync protocol</a> you can implement in an afternoon.</p>
@endsection
