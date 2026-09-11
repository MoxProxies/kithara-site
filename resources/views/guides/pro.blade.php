@extends('layouts.guide', [
    'title' => 'Kithara Pro',
    'eyebrow' => 'One-time purchase',
    'intro' => 'Everything you need to listen is free, forever, with no ads and no time limit. Pro is a single purchase through Google Play that turns Kithara from a player into a system: servers, sync, stats and transcripts.',
    'description' => 'Kithara Pro is a one-time purchase, not a subscription. It unlocks Audiobookshelf and sync-server libraries, streaming and downloads, cross-device sync, multiple libraries, listening stats, achievements, on-device transcripts and themes.',
])

@section('body')
<h2 id="compare">Free versus Pro</h2>
<div class="table-wrap">
    <table class="compare">
        <thead>
            <tr><th>Free, forever</th><th>Pro, one-time</th></tr>
        </thead>
        <tbody>
            <tr><td>Playback, chapters, speed 0.5x to 3.5x, skip silence</td><td>Server libraries: Audiobookshelf and the Kithara sync protocol</td></tr>
            <tr><td>Sleep timer with fade-out and shake to extend</td><td>Streaming, downloads and position sync across devices</td></tr>
            <tr><td>Android Auto, Bluetooth and notification controls</td><td>More than one library, each with its own tab</td></tr>
            <tr><td>Bookmarks, search, filters, sort and pinning</td><td>Listening stats and the 30-day chart</td></tr>
            <tr><td>One folder on the device</td><td>24 achievements</td></tr>
            <tr><td>Purple theme that follows the system</td><td>Theme mode, accent colours, colours from your wallpaper</td></tr>
            <tr><td></td><td>Transcripts: on-device speech-to-text for any chapter</td></tr>
        </tbody>
    </table>
</div>

<h2 id="how-it-works">How the purchase works</h2>
<ul>
    <li><strong>One payment, no renewal.</strong> Pro is an in-app purchase handled by Google Play Billing. The price is shown in Google Play before you buy and may vary by region.</li>
    <li><strong>Works offline.</strong> Google Play is the source of truth for ownership, and the result is cached on the device, so Pro keeps working with no connection.</li>
    <li><strong>Your history is already there.</strong> Listening stats and achievements are recorded whether or not you own Pro, so unlocking later shows everything from the day you installed the app.</li>
    <li><strong>Refunds</strong> go through Google Play under its refund policy. We cannot issue them directly, but we can point you to the right place; see <a href="{{ route('terms') }}#purchases">the Terms</a>.</li>
</ul>

<h2 id="why">Why these features and not others</h2>
<p>The split is simple: anything you need to press play on a file you already have is free. Pro covers the parts that make Kithara talk to a server, remember across devices, or do heavy work on the phone. The free tier is not a trial and does not expire.</p>

@if (config('kithara.play_live'))
<h2 id="get">Get it</h2>
<p>Install Kithara from Google Play and open <strong>Settings</strong> to unlock Pro.</p>
<div class="hero-actions">@include('partials.store-buttons')</div>
@else
<h2 id="get">Availability</h2>
<p>Kithara is in review with Google Play. The Pro price will appear in the listing once it is live. <a href="{{ route('home') }}#download">Leave your email</a> and we will send one message the day it lands.</p>
@endif
@endsection
