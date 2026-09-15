@php $playIcon = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3.6 2.3 13 12l-9.4 9.7c-.4-.2-.6-.6-.6-1.1V3.4c0-.5.2-.9.6-1.1zm11.1 11.4 2.6 2.6-11.2 6.4 8.6-9zm3.9-2.4 3 1.7c.9.5.9 1.6 0 2.1l-3 1.7-2.9-2.8 2.9-2.7zM6.1 1.3l11.2 6.4-2.6 2.6-8.6-9z"/></svg>'; @endphp
@if (config('kithara.play_live'))
    <a href="{{ config('kithara.play_store_url') }}" class="btn btn-primary">
        {!! $playIcon !!}
        Get it on Google Play
    </a>
@elseif (config('kithara.play_testing'))
    <a href="{{ config('kithara.play_test_url') }}" class="btn btn-primary" rel="noopener">
        {!! $playIcon !!}
        Join the test on Google Play
    </a>
@else
    <span class="btn btn-soon" role="status">
        <span class="soon-dot" aria-hidden="true"></span>
        {!! $playIcon !!}
        Coming soon to Google Play
    </span>
@endif
