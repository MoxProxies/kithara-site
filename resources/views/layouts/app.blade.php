<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('title')@yield('title') · Appollo @else Appollo, an audiobook player for Android @endif</title>
    <meta name="description" content="@yield('meta_description', 'Appollo is an audiobook player for Android. Point it at a folder, an Audiobookshelf server, or both. It finds your books, reads the chapters out of the files, and keeps your position in step across devices.')">
    <meta name="theme-color" content="#0d0b13">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Appollo">
    <meta property="og:title" content="@yield('title', 'Appollo, an audiobook player for Android')">
    <meta property="og:description" content="@yield('meta_description', 'An audiobook player for Android that works with local folders and Audiobookshelf.')">
    <meta property="og:url" content="{{ url()->current() }}">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.header')

    <main id="main">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
