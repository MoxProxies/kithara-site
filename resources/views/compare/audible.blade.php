@extends('layouts.guide', [
    'title' => 'Kithara vs Audible',
    'eyebrow' => 'Comparison',
    'intro' => 'This is less a contest than a fork in the road. Audible is a store with a player attached; Kithara is a player for files you already own. Which one you want depends on where your audiobooks come from.',
    'description' => 'Audible or Kithara? Audible is a subscription store whose books only play in its own app. Kithara plays DRM-free audiobooks you own, from your phone or your own server, with no account. When each makes sense, and whether you can use both.',
])

@section('body')
<h2 id="at-a-glance">At a glance</h2>
@include('partials.compare-table', ['other' => 'Audible', 'rows' => [
    ['What it is', 'A player for your own files and servers', 'A store and subscription with its own player'],
    ['Price', 'Free; Pro is a one-time purchase', 'Monthly membership with credits, or buy titles outright'],
    ['Catalogue', 'LibriVox built in (free, public domain); otherwise you bring the books', 'The largest commercial audiobook catalogue'],
    ['Plays Audible purchases', 'No; Audible files are DRM-protected', 'Yes, only in the Audible app'],
    ['Plays your own files', 'Yes: m4b, mp3, flac, opus and more', 'No'],
    ['Server libraries', 'Audiobookshelf and the Kithara sync protocol (Pro)', 'No'],
    ['Position sync', 'Through your own server (Pro)', 'Through Audible\'s cloud, across its apps and Kindle'],
    ['Account required', 'No', 'Yes'],
    ['Data collection', 'None; no analytics or telemetry', 'Listening data tied to your Amazon account'],
    ['Transcripts', 'On-device, searchable (Pro)', 'No'],
    ['Android Auto', 'Yes', 'Yes'],
    ['Platforms', 'Android', 'Android, iOS, web, Alexa, Kindle'],
]])

<h2 id="choose-audible">Where Audible is the right choice</h2>
<ul>
    <li><strong>You want to browse and buy in one place.</strong> Audible's catalogue, exclusives and credit pricing are the reason most people use it. Kithara sells nothing.</li>
    <li><strong>Your library is already on Audible.</strong> Those files only play in Audible's apps. Kithara cannot open them, and this page is not going to tell you how to change that.</li>
    <li><strong>You listen on many kinds of device.</strong> Phone, tablet, web, smart speaker and Kindle all stay in sync through Audible's account.</li>
</ul>

<h2 id="choose-kithara">Where Kithara is the right choice</h2>
<ul>
    <li><strong>You own DRM-free audiobooks.</strong> From shops that sell them without DRM, from CDs you ripped, from LibriVox, from your own recordings. Kithara plays all of them with proper chapters and remembers your place.</li>
    <li><strong>You run a home server.</strong> Audiobookshelf turns a folder on a NAS into a library you can stream from anywhere, and Kithara is a client for it.</li>
    <li><strong>You do not want an account or a subscription.</strong> Kithara needs neither, collects nothing, and the free features do not expire.</li>
    <li><strong>You want to search inside a book.</strong> On-device transcripts find a line and jump to it.</li>
</ul>

<h2 id="both">Using both</h2>
<p>Plenty of people do: Audible for new releases and exclusives, Kithara for everything bought elsewhere and the backlist on the home server. Thinking of leaving? <a href="{{ route('howto.leaving-audible') }}">What you keep, and where to buy instead</a>. Listening stats and streaks in Kithara only count what Kithara plays, which is the one real cost of splitting your library.</p>
@endsection
