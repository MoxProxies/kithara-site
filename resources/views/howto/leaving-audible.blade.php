@extends('layouts.guide', [
    'title' => 'How to move your audiobook listening off Audible',
    'eyebrow' => 'How-to',
    'intro' => 'You can keep every book you bought on Audible, stop paying the subscription, and buy your next audiobooks as files you actually own. This is the practical plan: what happens to your Audible library when you cancel, where DRM-free audiobooks come from, and how to build a library that plays in any app, Kithara included.',
    'description' => 'A practical guide to leaving Audible without losing your books: what cancelling does to your library, how to use up credits, where to buy DRM-free audiobooks (Libro.fm, Downpour, Humble Bundle, LibriVox, publishers), and how to organise the files for Kithara or Audiobookshelf.',
])

@push('head')
<script type="application/ld+json">{!! json_encode([
    '@'.'context' => 'https://schema.org',
    '@type' => 'HowTo',
    'name' => 'How to move your audiobook listening off Audible',
    'description' => 'Keep the books you bought, stop the subscription, and build a DRM-free audiobook library that plays in any app.',
    'totalTime' => 'PT30M',
    'step' => [
        ['@type' => 'HowToStep', 'name' => 'Understand what you keep', 'text' => 'Books you bought on Audible stay in your Audible library after you cancel. They play only in Audible apps, and that does not change.', 'url' => url()->current().'#what-you-keep'],
        ['@type' => 'HowToStep', 'name' => 'Use your credits, then cancel', 'text' => 'Spend remaining credits before cancelling; unused credits are lost. Then cancel the membership from the account settings.', 'url' => url()->current().'#cancel'],
        ['@type' => 'HowToStep', 'name' => 'Buy DRM-free from now on', 'text' => 'Use shops that sell audiobooks as plain MP3 or M4B files you download and keep.', 'url' => url()->current().'#where-to-buy'],
        ['@type' => 'HowToStep', 'name' => 'Organise the files', 'text' => 'One folder per book inside one folder per author, with chapters embedded in the files.', 'url' => url()->current().'#organise'],
        ['@type' => 'HowToStep', 'name' => 'Listen in Kithara', 'text' => 'Point Kithara at the folder on the phone, or at an Audiobookshelf server holding the library.', 'url' => url()->current().'#listen'],
    ],
    'author' => ['@id' => url('/#organization')],
    'publisher' => ['@id' => url('/#organization')],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('body')
<h2 id="the-honest-part">The honest part first</h2>
<p>Audiobooks you bought on Audible are protected by DRM and play only in Audible's own apps. That does not change when you leave, and this page will not tell you how to change it: in Canada, the United States and much of Europe, breaking DRM is illegal even for personal use, and Kithara does not play Audible files. So the plan is not "move the books out"; it is "keep what you have where it is, and stop adding to it".</p>
<p>The good news is that everything you bought stays yours to listen to, and everything you buy from here on can be a file you own outright.</p>

<h2 id="what-you-keep">1. What you keep when you cancel</h2>
<ul>
    <li><strong>Every title you purchased or bought with a credit stays in your Audible library</strong>, and the Audible app keeps playing them, membership or not.</li>
    <li><strong>Audible Plus catalogue titles go away.</strong> Anything you were streaming from the included catalogue rather than buying is part of the membership.</li>
    <li><strong>Unused credits are forfeited</strong> when the membership ends. Spend them first (next step).</li>
    <li><strong>Your listening positions and wishlist</strong> stay in the Audible app. Export the wishlist by hand if you want it: it is the shopping list for step 3.</li>
</ul>

<h2 id="cancel">2. Use your credits, then cancel</h2>
<ol>
    <li>Spend every remaining credit on books you actually want. If you have more credits than wants, long books and box sets are the traditional answer.</li>
    <li>Go to the Audible website, <strong>Account details</strong>, and cancel the membership. Audible will offer a pause or a cheaper plan on the way out; a pause keeps your credits and costs nothing, so it is worth taking if you are undecided.</li>
    <li>Leave the Audible app installed. It is now the player for your Audible backlist, and only that.</li>
</ol>

<h2 id="where-to-buy">3. Buy DRM-free from now on</h2>
<p>A DRM-free audiobook is one you download as ordinary MP3 or M4B files and can copy, back up and play anywhere. These are the sources worth knowing, checked in September 2026:</p>
<ul>
    <li><strong><a href="https://libro.fm" rel="noopener">Libro.fm</a></strong>: the same catalogue as the big stores, sold as DRM-free MP3 downloads, with a credit membership similar to Audible's and a share of each sale going to an independent bookshop you choose. The most direct replacement.</li>
    <li><strong><a href="https://www.downpour.com" rel="noopener">Downpour</a></strong>: DRM-free MP3 and M4B downloads, with a rental option on some titles.</li>
    <li><strong><a href="https://www.humblebundle.com" rel="noopener">Humble Bundle</a></strong>: occasional audiobook bundles, DRM-free, at very low prices per book.</li>
    <li><strong>Publishers and authors directly</strong>: some sell DRM-free from their own sites, especially in science fiction, fantasy and independent publishing. Worth a search for any author you buy repeatedly.</li>
    <li><strong><a href="https://librivox.org" rel="noopener">LibriVox</a></strong>: free, volunteer-read recordings of public-domain books. Quality varies by reader; the best are excellent. <a href="{{ route('librivox') }}">Kithara has it built in</a>, so this one needs no downloading or organising at all.</li>
    <li><strong>CDs</strong>: second-hand audiobook CDs are cheap, and ripping a disc you own for your own use is legal in most places. A CD box set becomes a folder of files in an afternoon.</li>
</ul>
<p>Not on the list, deliberately: Google Play Books, Apple Books, Kobo, Audiobooks.com, Spotify and library apps such as Libby. They are fine services, but their audiobooks are locked to their apps in the same way Audible's are, so they do not solve the problem this page is about.</p>

<h2 id="organise">4. Organise the files</h2>
<p>A little structure now saves fixing metadata later, and it is the same layout Audiobookshelf expects:</p>
<pre><code>Audiobooks/
  Ann Leckie/
    Ancillary Justice/
      Ancillary Justice.m4b
  Ursula K. Le Guin/
    The Left Hand of Darkness/
      Part 01.mp3
      Part 02.mp3</code></pre>
<ul>
    <li><strong>One folder per book, inside one per author.</strong> A cover image named <code>cover.jpg</code> in the book folder is picked up by Kithara and by Audiobookshelf.</li>
    <li><strong>Prefer M4B where the shop offers it.</strong> One file, chapters embedded. If a book arrives as MP3s, that works too; Kithara plays a folder of numbered files as one book, one chapter per file.</li>
    <li><strong>If the chapter list is missing</strong>, <a href="{{ route('howto.m4b-chapters') }}">add chapters with ffmpeg</a>. Ten minutes, no re-encoding.</li>
    <li><strong>Back it up.</strong> The whole point of owning files is that they survive any company's business decisions. A second copy on an external drive or your NAS is enough.</li>
</ul>

<h2 id="listen">5. Listen in Kithara</h2>
<p>Two ways, and you can use both:</p>
<ul>
    <li><strong>On the phone.</strong> Copy the folder to the phone (or an SD card) and add it in Kithara as a library. Everything works offline, no account, no server.</li>
    <li><strong>From a home server.</strong> Run <a href="{{ route('howto.audiobookshelf-setup') }}">Audiobookshelf</a> on a NAS or spare PC, point it at the folder, and Kithara streams or downloads from it with your position kept across devices.</li>
</ul>
<p>Sleep timer, speed, bookmarks, Android Auto and the rest work the same for every file, whichever shop it came from.</p>

<h2 id="two-apps">Living with two apps for a while</h2>
<p>Most people who leave Audible end up with the Audible app for the backlist and Kithara for everything since. That is fine. The backlist shrinks as you finish books, and every new purchase is a file. The one cost is that Kithara's listening stats only count what Kithara plays, so the first few months look quieter than they are.</p>
<p>If a book you love is Audible-only and you want it as a file, the practical answer is to buy it again from a DRM-free shop when it is on sale; annoying, but it is the only route that does not involve breaking the law, and for a favourite it is usually worth it.</p>
@endsection
