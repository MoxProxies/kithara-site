{{--
    Shared chrome for the feature and documentation pages.
    Child views set $title, $eyebrow, $intro, $description (meta) and optionally $pro (bool),
    then provide the body via @section('body'). Adds BreadcrumbList structured data.
--}}
@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@push('head')
<script type="application/ld+json">{!! json_encode([
    '@'.'context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Kithara', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $title, 'item' => url()->current()],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<section class="page-head">
    <div class="container">
        <nav class="crumbs" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Kithara</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">{{ $title }}</span>
        </nav>
        <span class="eyebrow">{{ $eyebrow }}@if (!empty($pro)) · Pro @endif</span>
        <h1>{{ $title }}</h1>
        <p>{{ $intro }}</p>
    </div>
</section>

<section class="section">
    <div class="container guide-grid">
        <article class="prose">
            @yield('body')
        </article>

        <aside class="guide-aside">
            @if (!empty($pro))
                <div class="info-card">
                    <h3>Part of Kithara Pro</h3>
                    <p>A one-time purchase through Google Play, not a subscription. <a href="{{ route('pro') }}">See what Pro includes</a>.</p>
                </div>
            @endif
            <div class="info-card">
                <h3>Get Kithara</h3>
                @if (config('kithara.play_live'))
                    <p>Free on Google Play for Android 8.0 and later.</p>
                    <div class="hero-actions" style="margin: 1rem 0 0;">@include('partials.store-buttons')</div>
                @else
                    <p>Kithara is not on Google Play yet. <a href="{{ route('home') }}#download">Leave your email</a> and we will tell you the day it lands.</p>
                @endif
            </div>
            <div class="info-card">
                <h3>More guides</h3>
                <ul class="guide-list">
                    @foreach (['audiobookshelf' => 'Audiobookshelf', 'transcripts' => 'Transcripts', 'formats' => 'Formats and chapters', 'android-auto' => 'Android Auto', 'sync-protocol' => 'Sync protocol', 'pro' => 'Kithara Pro', 'howto.audiobookshelf-setup' => 'Set up Audiobookshelf', 'howto.m4b-chapters' => 'Add chapters to an m4b', 'compare' => 'Comparisons', 'changelog' => 'Changelog'] as $name => $label)
                        @unless (request()->routeIs($name))
                            <li><a href="{{ route($name) }}">{{ $label }}</a></li>
                        @endunless
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
</section>
@endsection
