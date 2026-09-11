<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@php $legal = \Carbon\Carbon::parse(config('kithara.legal_updated'))->toDateString(); @endphp
    <url><loc>{{ route('home') }}</loc><changefreq>weekly</changefreq><priority>1.0</priority></url>
@foreach (['pro', 'audiobookshelf', 'transcripts', 'formats', 'android-auto', 'librivox', 'sync-protocol', 'howto.m4b-chapters', 'howto.audiobookshelf-setup', 'howto.leaving-audible', 'compare', 'compare.smart-audiobook-player', 'compare.audiobookshelf-app', 'compare.audible'] as $name)
    <url><loc>{{ route($name) }}</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>
@endforeach
@php $releaseDate = \App\Support\Releases::latestReleased()['date'] ?? null; @endphp
    <url><loc>{{ route('changelog') }}</loc>@if ($releaseDate)<lastmod>{{ $releaseDate }}</lastmod>@endif<changefreq>weekly</changefreq><priority>0.6</priority></url>
    <url><loc>{{ route('contact') }}</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>
    <url><loc>{{ route('terms') }}</loc><lastmod>{{ $legal }}</lastmod><changefreq>yearly</changefreq><priority>0.2</priority></url>
    <url><loc>{{ route('privacy') }}</loc><lastmod>{{ $legal }}</lastmod><changefreq>yearly</changefreq><priority>0.2</priority></url>
</urlset>
