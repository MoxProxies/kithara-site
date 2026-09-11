@extends('layouts.app')

@section('title', 'Contact')
@section('meta_description', 'Get in touch with the Appollo team for support, billing questions, feedback or press enquiries.')

@section('content')
<section class="page-head">
    <div class="container">
        <span class="eyebrow">Contact</span>
        <h1>We'd love to hear from you</h1>
        <p>Questions, bug reports, feature ideas, or just want to tell us what you're listening to. Send it our way.</p>
    </div>
</section>

<section class="section">
    <div class="container contact-grid">
        <form class="form" method="POST" action="{{ route('contact.send') }}" novalidate>
            @csrf

            @if (session('status'))
                <div class="form-status ok" role="status">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="form-status err" role="alert">Please fix the highlighted fields and try again.</div>
            @endif

            <div class="form-row">
                <div class="field">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="name" required maxlength="100" @error('name') aria-invalid="true" @enderror>
                    @error('name')<small class="field-error">{{ $message }}</small>@enderror
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required maxlength="255" @error('email') aria-invalid="true" @enderror>
                    @error('email')<small class="field-error">{{ $message }}</small>@enderror
                </div>
            </div>

            <div class="field">
                <label for="topic">What's this about?</label>
                <select id="topic" name="topic" required @error('topic') aria-invalid="true" @enderror>
                    @foreach ($topics as $value => $label)
                        <option value="{{ $value }}" @selected(old('topic', 'support') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('topic')<small class="field-error">{{ $message }}</small>@enderror
            </div>

            <div class="field">
                <label for="message">Message</label>
                <textarea id="message" name="message" required minlength="10" maxlength="5000" @error('message') aria-invalid="true" @enderror>{{ old('message') }}</textarea>
                @error('message')<small class="field-error">{{ $message }}</small>@enderror
            </div>

            {{-- Honeypot: hidden from humans, filled by bots --}}
            <div class="hp" aria-hidden="true">
                <label for="website">Website</label>
                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
            </div>

            <button type="submit" class="btn btn-primary">Send message</button>
        </form>

        <aside>
            <div class="info-card">
                <h3>Support</h3>
                <p>Having trouble with the app? Email <a href="mailto:{{ config('appollo.support_email') }}">{{ config('appollo.support_email') }}</a> and include your device model and app version if you can.</p>
            </div>
            <div class="info-card">
                <h3>Response time</h3>
                <p>We are a small team, but we read everything. Expect a reply within one business day.</p>
            </div>
            <div class="info-card">
                <h3>Billing &amp; refunds</h3>
                <p>Purchases are handled by Google Play. For refunds, request them through Google Play; we can help point you in the right direction.</p>
            </div>
            <div class="info-card">
                <h3>Legal</h3>
                <p>Read our <a href="{{ route('terms') }}">Terms &amp; Conditions</a> and <a href="{{ route('privacy') }}">Privacy Policy</a>.</p>
            </div>
        </aside>
    </div>
</section>
@endsection
