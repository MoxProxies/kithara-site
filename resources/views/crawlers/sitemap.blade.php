<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@php $legal = \Carbon\Carbon::parse(config('kithara.legal_updated'))->toDateString(); @endphp
    <url><loc>{{ route('home') }}</loc><changefreq>weekly</changefreq><priority>1.0</priority></url>
    <url><loc>{{ route('contact') }}</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>
    <url><loc>{{ route('terms') }}</loc><lastmod>{{ $legal }}</lastmod><changefreq>yearly</changefreq><priority>0.2</priority></url>
    <url><loc>{{ route('privacy') }}</loc><lastmod>{{ $legal }}</lastmod><changefreq>yearly</changefreq><priority>0.2</priority></url>
</urlset>
