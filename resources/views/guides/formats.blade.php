@extends('layouts.guide', [
    'title' => 'Formats and chapters',
    'eyebrow' => 'Files, folders and metadata',
    'intro' => 'Kithara plays the audiobook files you already have and reads their chapters out of the files themselves. This page lists what it plays, how it turns a folder into a book, and why your chapter list shows up when other players leave it blank.',
    'description' => 'Which audio formats Kithara plays on Android (m4b, m4a, mp3, flac, ogg, opus and more), how a folder of files becomes one book, and how chapters are read from m4b atoms, ID3 tags and .cue sheets.',
])

@section('body')
<h2 id="formats">Supported formats</h2>
<div class="formats" style="margin: 0 0 1.25rem;">
    @foreach (['M4B', 'M4A', 'MP4', 'AAC', 'MP3', 'OGG', 'OGA', 'OPUS', 'FLAC', 'WAV', 'WMA', 'MKA', '3GP'] as $format)
        <span class="chip">{{ $format }}</span>
    @endforeach
</div>
<p>Anything Android's Media3 player can decode, in other words. <strong>Audible <code>.aax</code> files are DRM-protected and will not play</strong>; strip the DRM with a tool you are licensed to use before importing, or buy from a DRM-free shop.</p>

<h2 id="folders">How a folder becomes a book</h2>
<ul>
    <li><strong>A folder of numbered files is one book</strong> on one continuous timeline. Skip back ten seconds at the very start of part three and you land at the end of part two, not at 0:00.</li>
    <li><strong>Natural sort.</strong> "Track 2" comes before "Track 10", so books ripped without zero-padding still play in order.</li>
    <li><strong>Each .m4b is its own book</strong> by default. If your rips are split into "Part 1" and "Part 2" m4b files, a switch under Settings, Library &amp; sync treats the folder as one book instead.</li>
    <li><strong>Metadata from tags.</strong> Title, author, narrator, album and duration are read from the file tags, so a well-tagged library needs no renaming.</li>
    <li><strong>Cover art</strong> comes from embedded artwork first, then a <code>cover.jpg</code> or <code>folder.jpg</code> beside the files, then the server if there is one.</li>
    <li><strong>Rescans never lose your place.</strong> Books are identified by a stable id derived from where they live, so rescanning a folder updates them in place.</li>
</ul>
<p>Folders are chosen through Android's own folder picker, and the permission is kept across reboots. You can point Kithara at internal storage, an SD card, or a USB drive.</p>

<h2 id="chapters">Where chapters come from</h2>
<p>Most players hand chapter parsing to the platform, and Android's own metadata retriever does not expose chapter atoms at all. Kithara walks the container itself, which is why it finds chapters that other apps miss. In order of preference:</p>
<ol>
    <li><strong>The m4b <code>chpl</code> chapter atom</strong>, the flat Nero-style list written by ffmpeg, AudiobookBuilder, m4b-tool and most m4b tools.</li>
    <li><strong>The QuickTime chapter text track</strong>, referenced by <code>tref/chap</code>, with titles dug out of <code>mdat</code> via the sample tables. This is the layout Apple's tools write.</li>
    <li><strong>ID3v2 <code>CHAP</code> frames</strong> in mp3 files, both v2.3 and v2.4.</li>
    <li><strong>A <code>.cue</code> sheet</strong> beside a single large file.</li>
    <li><strong>The server's chapter list</strong>, for Audiobookshelf and sync-server libraries.</li>
    <li><strong>One chapter per file</strong>, as a fallback for multi-file books with no marks at all.</li>
</ol>
<p>Whichever source they come from, chapters are stored against the book-wide timeline. Chapter 14 behaves identically whether the book is one m4b, forty-two mp3s, or streamed in three parts from a server, and a chapter is allowed to span a file boundary.</p>

<h2 id="troubleshooting">"My chapters are not showing"</h2>
<p>If a single-file book shows no chapters, neither a <code>chpl</code> atom nor a chapter text track was found in it. Some sellers strip them, and some conversion tools drop them on the way to m4b. Two fixes, both walked through step by step in <a href="{{ route('howto.m4b-chapters') }}">How to add chapters to an m4b</a>:</p>
<ul>
    <li>Re-mux the file with chapters using ffmpeg, m4b-tool or AudiobookBuilder; these all write the <code>chpl</code> atom Kithara reads first.</li>
    <li>Put a <code>.cue</code> sheet next to the file with the same base name. Kithara will use it.</li>
</ul>
<p>Kithara does not re-parse a streamed file over the network for chapters; server libraries should supply them.</p>

<h2 id="playback">Playback details</h2>
<figure class="guide-figure guide-figure--narrow">
    <img src="{{ asset('img/mockups/speed-pixel.webp') }}" srcset="{{ asset('img/mockups/speed-pixel.webp') }} 1x, {{ asset('img/mockups/speed-pixel@2x.webp') }} 2x" width="520" height="646" alt="The playback speed sheet on a Pixel: a slider from 0.5x with preset chips for 0.8x to 2.5x, and a note that pitch is preserved and speed is remembered per book" loading="lazy">
</figure>
<ul>
    <li>Speed from 0.5x to 3.5x with pitch preserved, remembered per book. Skip silence is a separate switch.</li>
    <li>Skip intervals are configurable independently for back and forward: 5, 10, 15, 30 or 60 seconds.</li>
    <li>Your position is saved every five seconds and on every pause, seek and stop, and resumes with a short rewind scaled to how long you were away.</li>
    <li>"Previous chapter" restarts the current chapter if you are more than five seconds into it, the way a CD player does.</li>
</ul>
@endsection
