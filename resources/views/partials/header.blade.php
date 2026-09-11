<header class="site-header">
    <div class="container nav">
        <a href="{{ route('home') }}" class="brand" aria-label="Appollo home">
            @include('partials.logo')
            Appollo
        </a>

        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="nav-links" aria-label="Toggle menu" data-nav-toggle>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>

        <ul class="nav-links" id="nav-links">
            <li><a href="{{ route('home') }}#features" @if(request()->routeIs('home')) aria-current="page" @endif>Features</a></li>
            <li><a href="{{ route('contact') }}" @if(request()->routeIs('contact')) aria-current="page" @endif>Contact</a></li>
            <li><a href="{{ route('home') }}#download" class="btn btn-primary">Get the app</a></li>
        </ul>
    </div>
</header>
