@extends('layouts.guide', [
    'title' => 'Android Auto',
    'eyebrow' => 'In the car',
    'intro' => 'Plug in, or connect wirelessly, and Kithara is on the dashboard: your libraries, what you were listening to, and the current book\'s chapters, all a tap or a voice command away. No setup, and it is part of the free app.',
    'description' => 'Kithara works with Android Auto out of the box: browse your libraries and chapters on the car screen, resume where you left off, use voice search, and skip with 10-second buttons. Bluetooth and headset controls too.',
])

@section('body')
<h2 id="browse">What you see on the car screen</h2>
<p>Kithara is a proper media app as far as Android Auto is concerned, so it appears in the car's app list the moment it is installed. The browse tree is deliberately shallow, because Android Auto refuses deep browsing while you drive:</p>
<ul>
    <li><strong>Continue listening</strong>, with a progress bar on every book.</li>
    <li><strong>All books</strong>, <strong>Recently added</strong> and <strong>Authors</strong>.</li>
    <li><strong>Libraries</strong>: each folder or server you have added is its own node, so a home Audiobookshelf and a folder of downloads sit side by side.</li>
    <li><strong>Chapters</strong> for the current book, two taps deep.</li>
</ul>
<p>Covers render as a grid and books as rows, and the ten-second skip buttons are on the head unit alongside play and pause.</p>

<h2 id="voice">Voice search</h2>
<p>"Play <em>Project Hail Mary</em>" works. Voice search matches against title, author, narrator and series, so "play the Rob Inglis one" is a stretch but "play Tolkien" is not.</p>

<h2 id="bluetooth">Bluetooth, headsets and the lock screen</h2>
<ul>
    <li><strong>Press play, and your last book resumes</strong>, even with the app closed. Bluetooth and wired headset buttons drive the same player session as the screen and the car.</li>
    <li><strong>Unplugging headphones pauses</strong> playback rather than broadcasting chapter nine to the bus.</li>
    <li><strong>Notification and lock-screen controls</strong> include the ten-second skips and a sleep timer button.</li>
</ul>

<h2 id="interruptions">Calls and other interruptions</h2>
<p>When a phone call, a navigation prompt or another app takes the audio, Kithara pauses. A short interruption resumes on its own with a five-second rewind so you do not miss the thread; a longer one rewinds the same five seconds the next time you press play. The rewind length is adjustable from 0 to 15 seconds.</p>
<p>This works off Android's audio focus rather than the telephony API, which is why Kithara does not ask for permission to read your phone state.</p>

<h2 id="one-player">One player, many screens</h2>
<p>The app screen, the notification, Android Auto and your headset buttons are all controllers on the same playback session. There is one position and one source of truth, so nothing can disagree about where you are in a book, and pausing from the steering wheel is exactly the same as pausing from the phone.</p>
@endsection
