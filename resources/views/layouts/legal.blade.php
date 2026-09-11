{{--
    Shared chrome for legal documents.
    Child views set $title, $intro and $sections (id => heading) and provide the body via @section('document').
--}}
@extends('layouts.app')

@section('title', $title)

@section('content')
<section class="page-head">
    <div class="container">
        <span class="eyebrow">Legal</span>
        <h1>{{ $title }}</h1>
        <p>{{ $intro }}</p>
    </div>
</section>

<section class="section">
    <div class="container legal-grid">
        <nav class="toc" aria-label="On this page">
            <h4>On this page</h4>
            <ol>
                @foreach ($sections as $id => $heading)
                    <li><a href="#{{ $id }}">{{ $heading }}</a></li>
                @endforeach
            </ol>
        </nav>

        <article class="legal">
            <p class="updated">Last updated: {{ config('appollo.legal_updated') }}</p>
            @yield('document')
        </article>
    </div>
</section>
@endsection
