@extends('layouts.app')

@section('content')
{{-- Hero --}}
<section class="hero">
    <div class="container hero-grid">
        <div>
            <span class="eyebrow">Audiobook player for Android</span>
            <h1>Your library.<br>Your pace.<br>Always in your pocket.</h1>
            <p class="lead">Point Appollo at a folder on your phone, an Audiobookshelf server, or both. It finds your books, reads the chapters out of the files themselves, and keeps your place in step across devices.</p>
            <div class="hero-actions">
                @include('partials.store-buttons')
                <a href="#features" class="btn btn-ghost">See what it does</a>
            </div>
            <p class="hero-note">Free to download. No account, no analytics, no telemetry.</p>
        </div>

        <div class="phone" aria-hidden="true">
            <div class="np-cover">The Long Road Home</div>
            <div>
                <p class="np-title">The Long Road Home</p>
                <p class="np-author">Narrated by Eleanor Vance</p>
                <p class="np-chapter">Chapter 12 · The Harbour</p>
            </div>
            <div>
                <div class="np-progress"><span></span></div>
                <div class="np-times"><span>4:12:36</span><span>−5:48:10</span></div>
            </div>
            <div class="np-controls">
                <span class="ctrl"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h10"/></svg></span>
                <span class="ctrl"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5V2L8 6l4 4V7a5 5 0 1 1-5 5H5a7 7 0 1 0 7-7z"/></svg></span>
                <span class="ctrl play"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg></span>
                <span class="ctrl"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5V2l4 4-4 4V7a5 5 0 1 0 5 5h2a7 7 0 1 1-7-7z"/></svg></span>
                <span class="ctrl"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 3a9 9 0 1 0 9 9M12 7v5l3 2"/></svg></span>
            </div>
            <div class="np-meta"><span>Sleep timer <b>End of chapter</b></span><span><b>Pinned</b></span></div>
        </div>
    </div>
</section>

{{-- Features --}}
<section class="section section-alt" id="features">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Features</span>
            <h2>Built for long books and real libraries</h2>
            <p>One player session shared by the screen, the notification, your car and your headphones, so nothing can disagree about where you are in a book.</p>
        </div>

        <div class="features">
            <article class="feature">
                <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16M4 12h16M4 18h10"/></svg></div>
                <h3>Real chapters, read from the file</h3>
                <p>Appollo parses chapter lists straight out of your m4b and mp3 files, including the layouts most players miss, so a 30-hour epic is easy to move around in.</p>
            </article>
            <article class="feature">
                <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 16a4 4 0 0 0 0-8h-1A6 6 0 0 0 4.5 9.6 3.5 3.5 0 0 0 5 16.5h12z"/></svg></div>
                <h3>Audiobookshelf built in</h3>
                <p>Connect your server with its address, username and password. Books stream by default; tap the cloud badge on a cover to pin one to the device for offline listening.</p>
            </article>
            <article class="feature">
                <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-2.6-6.4M21 3v6h-6"/></svg></div>
                <h3>Sync that gets offline right</h3>
                <p>Listen on the train with wifi off, then pick up on another device. Unpushed local changes win, so a stale timestamp from the server never rewinds you.</p>
            </article>
            <article class="feature">
                <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg></div>
                <h3>Sleep timer and call rewind</h3>
                <p>Drift off with a timer set to a duration or the end of the chapter. When a phone call interrupts, playback resumes five seconds back so you never lose the thread.</p>
            </article>
            <article class="feature">
                <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 17h14l-1.5-5h-11zM7 12l1.5-4h7L17 12M6 17v2m12-2v2"/></svg></div>
                <h3>Android Auto and Bluetooth</h3>
                <p>Every library gets its own node in Android Auto. Steering wheel and headphone buttons control the same session as the screen and the notification.</p>
            </article>
            <article class="feature">
                <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h4l3-8 4 16 3-8h4"/></svg></div>
                <h3>Multi-file books, one timeline</h3>
                <p>A book split across a dozen files behaves like a single recording. Skip back at the start of part three and you land at the end of part two, not at 0:00.</p>
            </article>
        </div>
    </div>
</section>

{{-- How it works --}}
<section class="section">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">How it works</span>
            <h2>Up and listening in under a minute</h2>
        </div>

        <div class="steps">
            <div class="step">
                <h3>Add a library</h3>
                <p>Pick a folder on the device, or sign in to your Audiobookshelf server. Add as many libraries as you like; each gets its own tab in the app and its own node in Android Auto.</p>
            </div>
            <div class="step">
                <h3>Press play</h3>
                <p>Appollo scans the files for tags, covers, duration and chapters. Playback keeps running in the background, in the notification, and in the car.</p>
            </div>
            <div class="step">
                <h3>Pick up anywhere</h3>
                <p>Your position is saved to the second and synced through your server when one is connected. Go offline for a week and it catches up when you are back.</p>
            </div>
        </div>

        <div class="section-head" style="margin-top: 3.5rem; margin-bottom: 0;">
            <h3>Plays the files you already have</h3>
            <p style="font-size: 1rem;">DRM-free audiobooks from any store, library rip, or your own recordings.</p>
        </div>
        <div class="formats">
            <span class="chip">M4B</span>
            <span class="chip">M4A / AAC</span>
            <span class="chip">MP3</span>
            <span class="chip">Audiobookshelf</span>
        </div>
    </div>
</section>

{{-- Privacy --}}
<section class="section section-alt">
    <div class="container">
        <div class="section-head" style="margin-bottom: 0;">
            <span class="eyebrow">Privacy</span>
            <h2>Your listening is nobody's business</h2>
            <p>The only network traffic Appollo makes is to servers you add yourself. No analytics, no accounts, no telemetry, no ads. Read the <a href="{{ route('privacy') }}">privacy policy</a>; it is short.</p>
        </div>
    </div>
</section>

{{-- Download CTA --}}
<section class="section" id="download">
    <div class="container">
        <div class="cta-band">
            <h2>Ready for your next chapter?</h2>
            <p>Download Appollo for Android and bring your whole library with you.</p>
            <div class="hero-actions">
                @include('partials.store-buttons')
            </div>
        </div>
    </div>
</section>
@endsection
