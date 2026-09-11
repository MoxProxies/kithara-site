@extends('layouts.guide', [
    'title' => 'The Kithara sync protocol, version 1',
    'eyebrow' => 'For self-hosters and developers',
    'intro' => 'A small HTTP and JSON contract between a Kithara client and a server that holds a library and each user\'s listening state. Anything that can serve JSON and honour HTTP range requests can be a Kithara server: a Go binary, a Node app, nginx plus a little glue. This exists so you are not locked to Audiobookshelf.',
    'description' => 'Version 1 of the open HTTP protocol Kithara speaks to self-hosted audiobook servers: health, auth, library, progress, two-way bookmarks and range-served audio. Millisecond timestamps, bearer tokens, server-side last-write-wins with 409, and a client rule that never rewinds you.',
])

@push('head')
<script type="application/ld+json">{!! json_encode([
    '@'.'context' => 'https://schema.org',
    '@type' => 'TechArticle',
    'headline' => 'The Kithara sync protocol, version 1',
    'description' => 'An HTTP and JSON contract for self-hosted audiobook servers that Kithara can stream from and sync progress and bookmarks to.',
    'url' => url()->current(),
    'author' => ['@id' => url('/#organization')],
    'publisher' => ['@id' => url('/#organization')],
    'about' => ['@id' => url('/#app')],
    'proficiencyLevel' => 'Expert',
    'inLanguage' => 'en',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('body')
@php
    $markdown = file_get_contents(resource_path('docs/sync-protocol.md'));
    // Strip the intro paragraphs; they are the page intro above
    $markdown = preg_replace('/^.*?\n---\n/s', '', $markdown, 1);
@endphp
<p>This is the frozen version 1 of the protocol, dated 11 September 2026. Kithara's Android client implements it today; the server is yours to write, and the interesting work (chapter parsing, the combined timeline, conflict resolution, offline queueing) already lives on the phone. Server libraries are a <a href="{{ route('pro') }}">Pro</a> feature.</p>
{!! Illuminate\Support\Str::markdown($markdown, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
<h2 id="questions">Questions</h2>
<p>Building a server and hit something the spec does not cover? <a href="{{ route('contact') }}">Get in touch</a>; we would rather fix the document than have you guess.</p>
@endsection
