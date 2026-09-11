<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
    <title>Kithara releases</title>
    <link>{{ route('changelog') }}</link>
    <atom:link href="{{ route('changelog.feed') }}" rel="self" type="application/rss+xml"/>
    <description>Release notes for Kithara, the Android audiobook player.</description>
    <language>en</language>
@foreach (\App\Support\Releases::all() as $release)
    @php $date = \App\Support\Releases::date($release); @endphp
    <item>
        <title>Kithara {{ $release['version'] }}@if ($release['status'] !== 'released') ({{ $release['status'] }})@endif</title>
        <link>{{ route('changelog') }}#v{{ str_replace('.', '-', $release['version']) }}</link>
        <guid isPermaLink="false">kithara-{{ $release['version'] }}</guid>
        @if ($date)<pubDate>{{ $date->toRfc2822String() }}</pubDate>@endif

        <description><![CDATA[<p>{{ $release['summary'] }}</p><ul>@foreach ($release['changes'] as $change)<li>{{ $change }}</li>@endforeach</ul>]]></description>
    </item>
@endforeach
</channel>
</rss>
