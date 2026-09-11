@extends('layouts.guide', [
    'title' => 'LibriVox in Kithara',
    'eyebrow' => 'Free public-domain audiobooks',
    'intro' => 'Thousands of audiobooks, read by volunteers and free for anyone: Austen, Dickens, Verne, Twain, Doyle, Homer, the lot. LibriVox is built into Kithara as a library of its own. Search it, add the books you want, stream them or download them, and listen with the same chapters, sleep timer and stats as everything else. No account, and not part of Pro.',
    'description' => 'Kithara has LibriVox built in: search thousands of free public-domain audiobooks by title or author, add them to your library, stream from the Internet Archive or download for offline, with real chapters. No account, free, not part of Pro.',
])

@section('body')
<h2 id="what-it-is">What LibriVox is</h2>
<p><a href="https://librivox.org" rel="noopener">LibriVox</a> is a volunteer project that has been recording public-domain books since 2005. The recordings are free to use for any purpose, the catalogue runs to many thousands of titles, and the audio is hosted by the <a href="https://archive.org" rel="noopener">Internet Archive</a>. Quality varies with the reader; the best are as good as anything you would pay for, and the project's reader pages let you follow the ones you like.</p>

<h2 id="how-it-works">How it works in Kithara</h2>
<ol>
    <li>Open <strong>Library</strong>, then the menu, <strong>Manage libraries</strong>, <strong>Add a library</strong>, and choose <strong>LibriVox</strong>. It appears as its own tab.</li>
    <li>The tab opens a browse screen. Search <strong>by title</strong> or <strong>by author</strong> (the author's surname works best), or scroll the <strong>recently added to LibriVox</strong> shelf.</li>
    <li>Tap a result to see the description, the readers, and a link to its LibriVox page. Tap <strong>Add to library</strong>.</li>
    <li>The book joins your LibriVox tab. Tap the cover to stream; tap the cloud badge to download it for offline listening, exactly as with a server book.</li>
</ol>
<p>Only the books you add live in your library, so the tab stays as tidy as you keep it. Remove a book from its menu whenever you are done.</p>

<h2 id="chapters">Chapters and covers</h2>
<p>LibriVox publishes each book as numbered sections, one audio file per section. Kithara stitches those into one book on one timeline and makes each section a chapter, so a 40-section novel has a proper chapter list and the ten-second skips cross section boundaries as if it were one file. Cover art comes from the Internet Archive.</p>

<h2 id="offline">Streaming, downloads and data</h2>
<ul>
    <li><strong>Streaming</strong> comes straight from the Internet Archive over HTTP range requests, so seeking is instant.</li>
    <li><strong>Downloads</strong> go through the same download system as server books: background, resumable, per-book progress, and the Wi-Fi-only switch applies.</li>
    <li><strong>Catalogue lookups</strong> are cached on the phone for a day, so browsing does not hammer LibriVox and repeated searches are instant.</li>
</ul>

<h2 id="privacy">What this means for privacy</h2>
<p>Browsing and playing LibriVox books makes requests to <code>librivox.org</code> (the catalogue) and <code>archive.org</code> (covers and audio). Like any web request, those show the sites your IP address and what you asked for. Nothing else is sent, there is no account, and nothing about your listening goes back to either site. Your position, bookmarks and stats stay on the phone. Details are in the <a href="{{ route('privacy') }}#servers">privacy policy</a>.</p>

<h2 id="tips">Good to know</h2>
<ul>
    <li><strong>Free means free.</strong> LibriVox is in the free tier of Kithara. Pro is not required for any of it.</li>
    <li><strong>Try a few readers.</strong> Popular books often have several recordings; the browse results show who read each one. A book that does not grab you may be the reader rather than the book.</li>
    <li><strong>Public domain has an edge.</strong> LibriVox records works that are out of copyright in the United States, which in practice means published before the late 1920s. Newer books are not there, and that is by design.</li>
    <li><strong>Support the project.</strong> LibriVox is volunteer-run and the Internet Archive hosts the audio for nothing. Both take donations.</li>
</ul>
@endsection
