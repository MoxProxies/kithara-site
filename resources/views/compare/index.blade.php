@extends('layouts.guide', [
    'title' => 'How Kithara compares',
    'eyebrow' => 'Comparisons',
    'intro' => 'Kithara is not the right app for everyone, and these pages say so. Each one puts Kithara next to an app you might already use, lists where that app is the better pick, and lists where Kithara is.',
    'description' => 'Honest comparisons of Kithara with Smart AudioBook Player, the official Audiobookshelf app and Audible: prices, local files, server libraries, sync, transcripts and who each app is really for.',
])

@section('body')
<div class="compare-cards">
    <a class="feature" href="{{ route('compare.smart-audiobook-player') }}">
        <h3>vs Smart AudioBook Player</h3>
        <p>The long-time Android favourite for a phone full of files. Kithara adds servers, sync and transcripts; it stays cheaper and more mature.</p>
    </a>
    <a class="feature" href="{{ route('compare.audiobookshelf-app') }}">
        <h3>vs the Audiobookshelf app</h3>
        <p>The official client is free, open source and does podcasts and ebooks. Kithara adds local folders, offline-safe sync rules, stats and transcripts.</p>
    </a>
    <a class="feature" href="{{ route('compare.audible') }}">
        <h3>vs Audible</h3>
        <p>A store versus a player. If your books are on Audible, Kithara cannot play them; if you own DRM-free files or run a server, it can.</p>
    </a>
</div>

<h2 id="how-we-compare">How these are written</h2>
<p>Feature tables are checked against each app's own listing and documentation, with the date noted at the bottom of every table. Where an app is better at something, the page says so in plain words. If you spot a mistake, <a href="{{ route('contact') }}">tell us</a> and we will correct it rather than argue.</p>
@endsection
