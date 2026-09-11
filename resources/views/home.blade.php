@extends('layouts.app')

@section('content')
{{-- Hero --}}
<section class="hero">
    <div class="container hero-grid">
        <div>
            <h1>
                <span class="eyebrow">Kithara, the audiobook player for Android</span>
                <span class="display">Your library.<br>Your pace.<br><span class="type" data-type-cycle='["In your pocket.","In your car.","Where you left off.","On your terms.","Always with you."]'>In your pocket.</span></span>
            </h1>
            <p class="lead">Point Kithara at a folder on your phone, a server on your home network, or both. It finds your books, reads the chapters out of the files themselves, and keeps your place in step across devices.</p>
            <div class="hero-actions">
                @include('partials.store-buttons')
                <a href="#features" class="btn btn-ghost">See what it does</a>
            </div>
            <p class="hero-note">Free to listen, with no ads and no time limit. No account, no analytics, no telemetry.</p>
        </div>

        <div class="phone">
            <img src="{{ asset('img/screens/player.webp') }}" srcset="{{ asset('img/screens/player.webp') }} 1x, {{ asset('img/screens/player@2x.webp') }} 2x" width="540" height="1142" alt="Kithara playing The Cartographer's Daughter: chapter list, progress bar, 10 second skips, speed, sleep timer, bookmarks and transcript controls" fetchpriority="high">
        </div>
    </div>
</section>

{{-- Features --}}
<section class="section section-alt" id="features">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow">Features</span>
            <h2>Built for long books and real libraries</h2>
            <p>One player session shared by the screen, the notification, your car and your headphones, so nothing can disagree about where you are in a book.</p>
        </div>

        <div class="features" data-reveal-group>
            <article class="feature">
                <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16M4 12h16M4 18h10"/></svg></div>
                <h3>Real chapters, read from the file</h3>
                <p>Chapter lists come straight out of the file: m4b chapter atoms, QuickTime chapter tracks, ID3 chapter frames in mp3, or a .cue sheet beside the audio. A folder of numbered mp3s becomes one book on one timeline.</p>
            </article>
            <article class="feature">
                <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/></svg></div>
                <h3>Playback that respects your ears</h3>
                <p>Speed from 0.5× to 3.5× with pitch preserved and remembered per book. Skip silence. Configurable 5 to 60 second jumps that cross file boundaries, so skipping back at the start of part three lands you in part two.</p>
            </article>
            <article class="feature">
                <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg></div>
                <h3>A sleep timer that listens back</h3>
                <p>Count down or stop at the end of the chapter. The volume fades over the last twenty seconds instead of cutting dead, and a shake of the phone adds more time without opening your eyes.</p>
            </article>
            <article class="feature">
                <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5V2L8 6l4 4V7a5 5 0 1 1-5 5H5a7 7 0 1 0 7-7z"/></svg></div>
                <h3>Never lose the thread</h3>
                <p>Your position is saved every five seconds. A phone call or a navigation prompt hands back five seconds when it ends, and a smart rewind on resume scales from two seconds to thirty depending on how long you were away.</p>
            </article>
            <article class="feature">
                <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 17h14l-1.5-5h-11zM7 12l1.5-4h7L17 12M6 17v2m12-2v2"/></svg></div>
                <h3>Android Auto and Bluetooth</h3>
                <p>Browse by continue listening, author or library on the head unit, with voice search over title, author, narrator and series. A press of play on your headphones picks up your last book with no app open. <a href="{{ route('android-auto') }}">Kithara in the car</a>.</p>
            </article>
            <article class="feature">
                <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg></div>
                <h3>Bookmarks, search and sort</h3>
                <p>Label a moment and jump back to it later. Search, filter and sort your library, pin favourites, and let Kithara mark a book finished at 99% so it drops out of your way.</p>
            </article>
        </div>
    </div>
</section>

{{-- Screens --}}
<section class="section">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow">Screens</span>
            <h2>Quiet, dark, and out of your way</h2>
        </div>
        <div class="screens" data-reveal-group>
            <figure class="screen">
                <img src="{{ asset('img/screens/library.webp') }}" srcset="{{ asset('img/screens/library.webp') }} 1x, {{ asset('img/screens/library@2x.webp') }} 2x" width="540" height="1142" alt="Library list with progress, time left and pinned books" loading="lazy">
                <figcaption>Library, with progress and time left at a glance</figcaption>
            </figure>
            <figure class="screen">
                <img src="{{ asset('img/screens/grid.webp') }}" srcset="{{ asset('img/screens/grid.webp') }} 1x, {{ asset('img/screens/grid@2x.webp') }} 2x" width="540" height="1142" alt="Library in cover grid view filtered to books in progress" loading="lazy">
                <figcaption>Cover grid, filtered to what you are reading</figcaption>
            </figure>
            <figure class="screen">
                <img src="{{ asset('img/screens/stats.webp') }}" srcset="{{ asset('img/screens/stats.webp') }} 1x, {{ asset('img/screens/stats@2x.webp') }} 2x" width="540" height="1142" alt="Listening stats: today, streak, this week, all time and a 30-day chart" loading="lazy">
                <figcaption>Stats with a daily goal, streak and 30-day chart</figcaption>
            </figure>
            <figure class="screen">
                <img src="{{ asset('img/screens/player.webp') }}" srcset="{{ asset('img/screens/player.webp') }} 1x, {{ asset('img/screens/player@2x.webp') }} 2x" width="540" height="1142" alt="Now playing screen with chapter, progress and controls" loading="lazy">
                <figcaption>Player with chapters, timer, bookmarks and transcript</figcaption>
            </figure>
        </div>
    </div>
</section>

{{-- Pro --}}
<section class="section" id="pro">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow">Kithara Pro</span>
            <h2>Everything you need to listen is free. Pro makes it a system.</h2>
            <p>Pro is a one-time unlock through Google Play. No subscription, no renewal. Stats and achievements are recorded from day one, so unlocking later shows your full history. <a href="{{ route('pro') }}">Everything Pro includes</a>.</p>
        </div>

        <div class="plans" data-reveal-group>
            <div class="plan">
                <h3>Free, forever</h3>
                <ul class="plan-list">
                    <li>Playback, chapters, speed and skip silence</li>
                    <li>Sleep timer with fade and shake-to-extend</li>
                    <li>Android Auto, Bluetooth and notification controls</li>
                    <li>Bookmarks, search, filters, sort and pinning</li>
                    <li>One folder on the device</li>
                    <li>Purple theme that follows the system</li>
                </ul>
            </div>
            <div class="plan plan-pro">
                <h3>Pro <span class="plan-tag">One-time purchase</span></h3>
                <ul class="plan-list">
                    <li><strong>Server libraries:</strong> <a href="{{ route('audiobookshelf') }}">Audiobookshelf</a> and the open <a href="{{ route('sync-protocol') }}">Kithara sync protocol</a></li>
                    <li><strong>Stream, download and sync</strong> your position across devices</li>
                    <li><strong>Several libraries</strong> at once, each with its own tab</li>
                    <li><strong>Transcripts:</strong> on-device speech-to-text for any chapter</li>
                    <li><strong>Listening stats</strong> with a daily goal, streaks and a 30-day chart</li>
                    <li><strong>56 achievements</strong> across time, books, streaks, feats, odd hours, style and your shelf</li>
                    <li><strong>Themes:</strong> light, dark, accent colours, or colours from your wallpaper</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- Transcripts --}}
<section class="section section-alt">
    <div class="container split">
        <div data-reveal>
            <span class="eyebrow">Transcripts · Pro</span>
            <h2>Read along, or find that one line</h2>
            <p class="muted">Kithara turns any chapter into timed text, entirely on your phone. Nothing is uploaded and nothing leaves the device. Tap a passage to jump there, or search the whole book for a phrase you half remember.</p>
            <p class="muted">Pick the speech model that suits your phone: tiny is fastest, small is closest to a dictation app. Models download once on first use and long chapters transcribe in the background with progress in the notification. <a href="{{ route('transcripts') }}">How transcripts work</a>.</p>
        </div>
        <div class="transcript-demo" aria-hidden="true" data-reveal data-transcribe>
            <div class="transcript-search">Search the whole book</div>
            <p class="transcript-line" data-line><span>41:12</span><span class="transcript-text" data-line-text>The harbour was empty by the time she reached it, the last boat a smudge against the grey.</span></p>
            <p class="transcript-line" data-line><span>41:20</span><span class="transcript-text" data-line-text>She did not call out. There was no one left who would have answered.</span></p>
            <p class="transcript-line" data-line><span>41:27</span><span class="transcript-text" data-line-text>Instead she sat on the wall, took out the letter, and read it again from the beginning.</span></p>
        </div>
    </div>
</section>

{{-- How it works --}}
<section class="section">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow">How it works</span>
            <h2>Up and listening in under a minute</h2>
        </div>

        <div class="steps" data-reveal-group>
            <div class="step">
                <h3>Add a library</h3>
                <p>Pick a folder on the device, or sign in to your <a href="{{ route('audiobookshelf') }}">Audiobookshelf server</a>. Kithara reads titles, authors, narrators, covers and chapters from the files, and never loses your position on a rescan.</p>
            </div>
            <div class="step">
                <h3>Press play</h3>
                <p>Playback keeps running in the background, in the notification, on the lock screen and in the car. Downloads and sync can be limited to Wi-Fi.</p>
            </div>
            <div class="step">
                <h3>Pick up anywhere</h3>
                <p>With a server connected, your position, finished state and bookmarks follow you between devices. Listen offline for a week and your unpushed progress still wins when you reconnect.</p>
            </div>
        </div>

        <div class="section-head" style="margin-top: 3.5rem; margin-bottom: 0;" data-reveal>
            <h3>Plays the files you already have</h3>
            <p style="font-size: 1rem;">DRM-free audiobooks from any store, library rip, or your own recordings. Audible .aax files need their DRM removed first. <a href="{{ route('formats') }}">Formats and chapters in detail</a>.</p>
        </div>
        <div class="formats" data-reveal-group>
            <span class="chip">M4B</span>
            <span class="chip">M4A</span>
            <span class="chip">MP4</span>
            <span class="chip">AAC</span>
            <span class="chip">MP3</span>
            <span class="chip">OGG</span>
            <span class="chip">OPUS</span>
            <span class="chip">FLAC</span>
            <span class="chip">WAV</span>
            <span class="chip">WMA</span>
            <span class="chip">MKA</span>
            <span class="chip">3GP</span>
            <span class="chip">CUE sheets</span>
        </div>
    </div>
</section>

@include('partials.faq')

{{-- Privacy --}}
<section class="section">
    <div class="container">
        <div class="section-head" style="margin-bottom: 0;" data-reveal>
            <span class="eyebrow">Privacy</span>
            <h2>Your listening is nobody's business</h2>
            <p>No analytics, no accounts, no telemetry, no ads. Kithara talks to the servers you add and nothing else, apart from a one-time speech model download if you use transcripts. Read the <a href="{{ route('privacy') }}">privacy policy</a>; it is short.</p>
        </div>
    </div>
</section>

{{-- Download CTA --}}
<section class="section" id="download">
    <div class="container">
        <div class="cta-band" data-reveal>
            @if (config('kithara.play_live'))
                <h2>Ready for your next chapter?</h2>
                <p>Download Kithara for Android and bring your whole library with you.</p>
                <div class="hero-actions">
                    @include('partials.store-buttons')
                </div>
            @else
                <h2>Coming soon to Google Play</h2>
                <p>Kithara is in review with Google Play. Leave your email and we will send one message the day it lands, then forget you.</p>

                @if (session('notify_status'))
                    <p class="notify-status ok" role="status">{{ session('notify_status') }}</p>
                @else
                    <form class="notify" method="POST" action="{{ route('notify') }}" novalidate>
                        @csrf
                        <label for="notify-email" class="sr-only">Email address</label>
                        <input type="email" id="notify-email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required maxlength="255" @error('email') aria-invalid="true" aria-describedby="notify-error" @enderror>
                        <div class="hp" aria-hidden="true">
                            <label for="notify-website">Website</label>
                            <input type="text" id="notify-website" name="website" tabindex="-1" autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-primary">Notify me</button>
                    </form>
                    @error('email')<p class="notify-status err" id="notify-error" role="alert">{{ $message }}</p>@enderror
                    @error('website')<p class="notify-status err" role="alert">{{ $message }}</p>@enderror
                    <p class="notify-note">Want in early as a tester? <a href="{{ route('contact') }}">Get in touch</a> instead.</p>
                @endif
            @endif
        </div>
    </div>
</section>
@endsection
