@extends('layouts.app')

@section('title', 'Page not found')
@section('meta_description', 'That page is not here. Head back to the Kithara home page.')

@section('content')
<section class="page-head">
    <div class="container">
        <span class="eyebrow">404</span>
        <h1>That chapter does not exist</h1>
        <p>The page you were after has moved or never was. The library is this way.</p>
        <div class="hero-actions" style="margin-top: 1.5rem;">
            <a href="{{ route('home') }}" class="btn btn-primary">Back to Kithara</a>
            <a href="{{ route('contact') }}" class="btn btn-ghost">Report a broken link</a>
        </div>
    </div>
</section>
@endsection
