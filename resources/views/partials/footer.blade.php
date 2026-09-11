<footer class="site-footer">
    <div class="container footer-grid">
        <a href="{{ route('home') }}" class="brand" aria-label="Appollo home">
            @include('partials.logo')
            Appollo
        </a>

        <ul class="footer-links">
            <li><a href="{{ route('home') }}#features">Features</a></li>
            <li><a href="{{ route('home') }}#pro">Pro</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
            <li><a href="{{ route('terms') }}">Terms &amp; Conditions</a></li>
            <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
        </ul>

        <p class="copyright">&copy; {{ date('Y') }} {{ config('appollo.company_name') }}. All rights reserved.</p>
    </div>
</footer>
