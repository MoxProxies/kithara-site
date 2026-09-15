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
            <tr><td>Bookmarks, search, filters, sort and pinning</td><td>Listening stats by day, week, month and year, and your shelf</td></tr>
            <tr><td>One folder on the device, plus LibriVox's free catalogue</td><td>56 achievements in seven groups</td></tr>
            <tr><td>Purple theme that follows the system</td><td>Theme mode, accent colours, wallpaper colours, eleven app icons</td></tr>
            <tr><td>Six languages with an in-app picker</td><td>Transcripts: on-device speech-to-text for any chapter</td></tr>
            <tr><td></td><td>Clear speech filter and up to 12 dB of volume boost</td></tr>
            <tr><td></td><td>Up-next queue, and chapter trims for intros, outros and credits</td></tr>
            <tr><td></td><td>Home-screen widgets and a shareable year in review</td></tr>
            <tr><td></td><td>Backup and restore to a file</td></tr>
        </tbody>
    </table>
</div>

<h2 id="how-it-works">One purchase, no strings</h2>
<ul>
    <li><strong>Pay once.</strong> Pro is an in-app purchase through Google Play, not a subscription. The price is shown in Google Play before you buy.</li>
    <li><strong>Works offline.</strong> Ownership is confirmed with Google Play and cached on the device, so Pro keeps working with no connection.</li>
    <li><strong>Your history is already there.</strong> Stats and achievements are recorded from the day you install, so unlocking later shows everything.</li>
</ul>

@if (config('kithara.play_live'))
<h2 id="get">Get it</h2>
<p>Install Kithara from Google Play and open <strong>Settings</strong> to unlock Pro.</p>
<div class="hero-actions">@include('partials.store-buttons')</div>
@elseif (config('kithara.play_testing'))
<h2 id="get">Availability</h2>
<p>Kithara is on Google Play as an internal test. Testers can install it now; the public listing and the Pro price follow when testing ends. <a href="{{ route('home') }}#download">Join the tester list</a> to get in early.</p>
@else
<h2 id="get">Availability</h2>
<p>Kithara is not on Google Play yet. The Pro price will appear in the listing once it is live. <a href="{{ route('home') }}#download">Leave your email</a> and we will send one message the day it lands.</p>
@endif
@endsection
