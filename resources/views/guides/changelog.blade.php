@extends('layouts.guide', [
    'title' => 'Changelog',
    'eyebrow' => 'What changed and when',
    'intro' => 'Every Kithara release, newest first. Subscribe to the feed to hear about updates without giving us an email address.',
    'description' => 'Release notes for Kithara, the Android audiobook player: every version with what changed, newest first, plus an RSS feed.',
])

@push('head')
<link rel="alternate" type="application/rss+xml" title="Kithara releases" href="{{ route('changelog.feed') }}">
@endpush

@section('body')
@foreach (\App\Support\Releases::all() as $release)
    @php $date = \App\Support\Releases::date($release); @endphp
    <article class="release" id="v{{ str_replace('.', '-', $release['version']) }}">
        <h2>
            <a href="#v{{ str_replace('.', '-', $release['version']) }}">{{ $release['version'] }}</a>
            @if ($release['status'] === 'released')
                <span class="plan-tag tag-quiet"><time datetime="{{ $date->toDateString() }}">{{ $date->format('j F Y') }}</time></span>
            @else
                <span class="plan-tag">{{ ucfirst($release['status']) }}</span>
            @endif
        </h2>
        <p>{{ $release['summary'] }}</p>
        <ul>
            @foreach ($release['changes'] as $change)
                <li>{{ $change }}</li>
            @endforeach
        </ul>
    </article>
@endforeach

<p class="muted" style="margin-top: 2.5rem;">Follow releases by <a href="{{ route('changelog.feed') }}">RSS</a>, or <a href="{{ route('home') }}#download">leave your email</a> for one message when the first version lands.</p>
@endsection
