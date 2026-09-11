@extends('layouts.guide', [
    'title' => 'How to add chapters to an m4b audiobook',
    'eyebrow' => 'How-to',
    'intro' => 'Your audiobook plays fine but the chapter list is empty, or you have a folder of mp3s and want one tidy m4b with real chapters. Both take one free tool, ffmpeg, and about ten minutes. This guide shows the commands, what they write into the file, and a no-re-mux alternative using a cue sheet.',
    'description' => 'Add or fix chapters in an m4b audiobook with ffmpeg: check what is there, write a chapter file, apply it without re-encoding, or merge a folder of mp3s into one m4b with chapters. Plus the cue-sheet alternative that needs no re-mux.',
])

@push('head')
<script type="application/ld+json">{!! json_encode([
    '@'.'context' => 'https://schema.org',
    '@type' => 'HowTo',
    'name' => 'How to add chapters to an m4b audiobook',
    'description' => 'Add or fix chapter markers in an m4b audiobook using ffmpeg, without re-encoding the audio.',
    'totalTime' => 'PT10M',
    'tool' => [['@type' => 'HowToTool', 'name' => 'ffmpeg (includes ffprobe)']],
    'supply' => [['@type' => 'HowToSupply', 'name' => 'The m4b file, or a folder of mp3 files']],
    'step' => [
        ['@type' => 'HowToStep', 'name' => 'Check what chapters the file already has', 'text' => 'Run ffprobe with -show_chapters on the m4b. If it prints nothing, the file has no chapter atom and no chapter track.', 'url' => url()->current().'#check'],
        ['@type' => 'HowToStep', 'name' => 'Write a chapter file', 'text' => 'Create a text file in ffmetadata format with one [CHAPTER] block per chapter, giving START and END in milliseconds and a title.', 'url' => url()->current().'#write'],
        ['@type' => 'HowToStep', 'name' => 'Apply it without re-encoding', 'text' => 'Run ffmpeg with the audio and the chapter file as inputs, -map_chapters 1 and -c copy, writing a new m4b. The audio is copied untouched.', 'url' => url()->current().'#apply'],
        ['@type' => 'HowToStep', 'name' => 'Verify and replace', 'text' => 'Run ffprobe on the new file to confirm the chapters, then replace the original.', 'url' => url()->current().'#verify'],
    ],
    'author' => ['@id' => url('/#organization')],
    'publisher' => ['@id' => url('/#organization')],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('body')
<h2 id="why">Why the chapter list is empty</h2>
<p>An m4b file can carry chapters in two places: the Nero <code>chpl</code> atom (a flat list of titles and start times) or a QuickTime chapter track (a text track referenced by <code>tref/chap</code>). Most tools write one or both. Some sellers strip them, and some converters drop them on the way from mp3 to m4b. If neither is present, no player can show chapters, because there is nothing in the file to show.</p>
<p>Kithara reads both layouts, plus ID3 <code>CHAP</code> frames in mp3s and <code>.cue</code> sheets. So once the chapters are in the file, they will appear. Everything below uses <a href="https://ffmpeg.org/download.html" rel="noopener">ffmpeg</a>, which is free, runs on Windows, macOS and Linux, and ships with <code>ffprobe</code>.</p>

<h2 id="check">1. Check what is already there</h2>
<pre><code>ffprobe -v error -show_chapters -of compact=p=0:nk=1 book.m4b</code></pre>
<p>One line per chapter means the chapters exist and the problem is elsewhere (see the last section). No output means the file has none. While you are here, grab the total length; you will need it for the last chapter's end time:</p>
<pre><code>ffprobe -v error -show_entries format=duration -of csv=p=0 book.m4b</code></pre>
<p>That prints seconds with decimals, for example <code>39600.128</code>.</p>

<h2 id="write">2. Write a chapter file</h2>
<p>ffmpeg takes chapters from a small text file in its <em>ffmetadata</em> format. Times are in the unit set by <code>TIMEBASE</code>; <code>1/1000</code> means milliseconds, which is easiest to reason about. Save this as <code>chapters.txt</code> next to the audio:</p>
<pre><code>;FFMETADATA1
title=The Hobbit
artist=J. R. R. Tolkien
album_artist=Rob Inglis

[CHAPTER]
TIMEBASE=1/1000
START=0
END=2760000
title=An Unexpected Party

[CHAPTER]
TIMEBASE=1/1000
START=2760000
END=5100000
title=Roast Mutton

[CHAPTER]
TIMEBASE=1/1000
START=5100000
END=39600128
title=A Short Rest</code></pre>
<p>Rules that trip people up:</p>
<ul>
    <li>The first line must be exactly <code>;FFMETADATA1</code>.</li>
    <li>Each chapter's <code>START</code> should equal the previous chapter's <code>END</code>. Gaps and overlaps produce odd behaviour in some players.</li>
    <li>The last <code>END</code> is the file's total duration in milliseconds (the seconds figure from step 1, times 1000, rounded).</li>
    <li>Titles are plain text. If a title contains <code>=</code>, <code>;</code>, <code>#</code> or <code>\</code>, escape it with a backslash.</li>
    <li>The tag lines at the top are optional. Leave them out and the file's existing tags are kept.</li>
</ul>
<p>Where do the timestamps come from? If you have a printed chapter list with running times, convert each to milliseconds. If you are merging a folder of files (next section), each file's duration gives you the boundaries. If you have nothing, scrub through the book in any player and note where chapters start; a handful of minutes of work for a book you will listen to for thirty hours.</p>

<h2 id="apply">3. Apply the chapters without re-encoding</h2>
<pre><code>ffmpeg -i book.m4b -i chapters.txt -map_metadata 1 -map_chapters 1 -c copy book-chaptered.m4b</code></pre>
<p>What each part does: the audio is input 0 and the chapter file is input 1; <code>-map_chapters 1</code> takes the chapter list from input 1; <code>-map_metadata 1</code> takes the tags from it too (drop this flag to keep the original tags exactly); <code>-c copy</code> copies the audio stream untouched, so the operation takes seconds and loses no quality. ffmpeg's MP4 muxer writes both the <code>chpl</code> atom and a QuickTime chapter track, so the result works in Kithara and in every other player that reads either layout.</p>
<p>If the original had cover art embedded, it is carried across. If it did not, add one at the same time:</p>
<pre><code>ffmpeg -i book.m4b -i chapters.txt -i cover.jpg -map 0:a -map 2 -map_metadata 1 -map_chapters 1 -c copy -disposition:v attached_pic book-chaptered.m4b</code></pre>

<h2 id="verify">4. Verify, then replace</h2>
<pre><code>ffprobe -v error -show_chapters -of compact=p=0:nk=1 book-chaptered.m4b</code></pre>
<p>You should see one line per chapter with the titles you wrote. Play the new file for a moment, then replace the original. On the phone, rescan the folder; Kithara identifies books by where they live, so your listening position survives the swap.</p>

<h2 id="merge">Merging a folder of mp3s into one m4b</h2>
<p>You do not need to do this for Kithara: a folder of numbered files already plays as one book on one timeline, and each file becomes a chapter. But a single m4b is tidier to store and share, and it lets you give the chapters real names. This step re-encodes the audio, so it takes a while and you should pick a bitrate you are happy with (64 kbps AAC is plenty for a single narrator).</p>
<p>First, list the files in order. ffmpeg's concat demuxer reads a plain text list:</p>
<pre><code>file 'Part 01.mp3'
file 'Part 02.mp3'
file 'Part 03.mp3'</code></pre>
<p>Get each file's duration in seconds to build the chapter boundaries:</p>
<pre><code>ffprobe -v error -show_entries format=duration -of csv=p=0 "Part 01.mp3"</code></pre>
<p>Write <code>chapters.txt</code> as in step 2, with one chapter per file (chapter 1 starts at 0 and ends at the first file's length; chapter 2 starts there; and so on). Then merge, encode and chapter in one go:</p>
<pre><code>ffmpeg -f concat -safe 0 -i list.txt -i chapters.txt -map_metadata 1 -map_chapters 1 -c:a aac -b:a 64k -vn book.m4b</code></pre>
<p>For dozens of books, <a href="https://github.com/sandreas/m4b-tool" rel="noopener">m4b-tool</a> automates exactly this (durations, chapter file, merge, tags) and is worth learning once.</p>

<h2 id="cue">The no-re-mux alternative: a cue sheet</h2>
<p>If you would rather not touch the audio at all, Kithara will read chapters from a <code>.cue</code> file sitting next to a single audio file. The cue must have the <strong>same base name</strong> as the audio (<code>book.m4b</code> and <code>book.cue</code>, case does not matter), and only three lines per track are read: <code>TRACK</code>, <code>TITLE</code> and <code>INDEX 01</code>.</p>
<pre><code>TITLE "The Hobbit"
PERFORMER "Rob Inglis"
FILE "book.m4b" MP4
  TRACK 01 AUDIO
    TITLE "An Unexpected Party"
    INDEX 01 00:00:00
  TRACK 02 AUDIO
    TITLE "Roast Mutton"
    INDEX 01 46:00:00
  TRACK 03 AUDIO
    TITLE "A Short Rest"
    INDEX 01 85:00:00</code></pre>
<p>Times are <code>minutes:seconds:frames</code> with 75 frames per second, the CD convention, and minutes can exceed 59 (<code>85:00:00</code> is one hour twenty-five). The cue is used only when the file itself has no chapters, so it is a fix for stripped files, not an override. Other players vary in whether they read cue sheets, which is why embedding is the better long-term answer.</p>

<h2 id="still-missing">Chapters exist but still do not show</h2>
<ul>
    <li><strong>Multi-file book, no chapter names.</strong> Kithara makes one chapter per file when the files carry no marks. To get names, either tag each mp3 with a title (ffmpeg's <code>-metadata title=</code> on each file) or merge into an m4b as above.</li>
    <li><strong>Streaming from a server.</strong> Kithara does not re-parse a streamed file over the network; it uses the chapter list the server sends. Audiobookshelf reads embedded chapters when it scans, so fix the file, then rescan the item on the server.</li>
    <li><strong>The mp3 has ID3v2.2 chapters.</strong> Only v2.3 and v2.4 <code>CHAP</code> frames are read. Re-save the tags with a modern tagger such as Mp3tag or Kid3.</li>
    <li><strong>Every chapter is called "Chapter 1".</strong> Some tools write the chapter track with empty or duplicated titles. Re-run step 3 with a proper <code>chapters.txt</code>; ffmpeg replaces the old list.</li>
</ul>
<p>Still stuck? <code>adb logcat -s Mp4Parser Id3ChapterReader MediaScanner</code> while rescanning prints exactly what Kithara found in the file, and <a href="{{ route('contact') }}">we are happy to look at a log</a>.</p>
@endsection
