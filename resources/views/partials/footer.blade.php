<footer class="site-footer">
    <div class="container footer-grid">
        <a href="{{ route('home') }}" class="brand" aria-label="Kithara home">
            @include('partials.logo')
            Kithara
        </a>

        <nav class="footer-nav" aria-label="Footer">
            <div>
                <h4>Product</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}#features">Features</a></li>
                    <li><a href="{{ route('pro') }}">Kithara Pro</a></li>
                    <li><a href="{{ route('audiobookshelf') }}">Audiobookshelf</a></li>
                    <li><a href="{{ route('transcripts') }}">Transcripts</a></li>
                    <li><a href="{{ route('formats') }}">Formats and chapters</a></li>
                    <li><a href="{{ route('android-auto') }}">Android Auto</a></li>
                    <li><a href="{{ route('sync-protocol') }}">Sync protocol</a></li>
                    <li><a href="{{ route('howto.m4b-chapters') }}">Add chapters to an m4b</a></li>
                    <li><a href="{{ route('compare') }}">Comparisons</a></li>
                    <li><a href="{{ route('changelog') }}">Changelog</a></li>
                </ul>
            </div>
            <div>
                <h4>Company</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('terms') }}">Terms &amp; Conditions</a></li>
                    <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                </ul>
            </div>
        </nav>

        <p class="copyright">&copy; {{ date('Y') }} {{ rtrim(config('kithara.company_name'), '.') }}. All rights reserved.</p>
    </div>
</footer>
