<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>document.documentElement.classList.add('js')</script>

    @php
        // yieldContent() returns escaped HTML; decode once so {{ }} below does not double-escape.
        $title = html_entity_decode(trim($__env->yieldContent('title')), ENT_QUOTES | ENT_HTML5);
        $pageTitle = match (true) {
            $title === '' => 'Kithara: Audiobook Player for Android with Audiobookshelf Sync',
            str_starts_with($title, 'Kithara') => $title,
            default => "{$title} · Kithara",
        };
        $description = html_entity_decode(trim($__env->yieldContent('meta_description', 'Kithara is a free audiobook player for Android. Point it at a folder on your phone, an Audiobookshelf server, or both. It reads chapters out of the files themselves and keeps your place in step across devices. No account, no analytics.')), ENT_QUOTES | ENT_HTML5);
        $ogImage = asset('img/og.png');
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="theme-color" content="#100b13">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Kithara">
    <meta property="og:locale" content="en_CA">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="The Kithara lyre-and-book mark on a magenta background with the tagline: Your audiobooks. Your files. Your server.">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    @include('partials.schema')
    @stack('head')

    {{ Vite::fonts() }}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="progress-bar" data-progress aria-hidden="true"></div>
    @include('partials.header')

    <main id="main">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
