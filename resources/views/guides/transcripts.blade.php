@extends('layouts.guide', [
    'title' => 'Transcripts',
    'eyebrow' => 'On-device speech to text',
    'pro' => true,
    'intro' => 'Turn any chapter into timed text. Read along with the line being spoken highlighted, tap a line to jump there, or search the whole book for that one sentence you half remember. All of it runs on the phone; nothing you listen to is uploaded anywhere.',
    'description' => 'Kithara transcribes audiobook chapters on your Android phone with Whisper, no cloud involved. Read along with the current line highlighted, tap to jump, and search the whole book. How it works, model sizes and privacy.',
])

@section('body')
<h2 id="what-it-does">What you can do with a transcript</h2>
<ul>
    <li><strong>Read along.</strong> The transcript follows playback, with the passage being spoken highlighted and kept in view.</li>
    <li><strong>Jump by tapping.</strong> Every passage knows exactly when it starts, so tapping one seeks the player there.</li>
    <li><strong>Search the whole book.</strong> Type a word or a phrase and every matching passage in every transcribed chapter comes up, with its timestamp.</li>
    <li><strong>Transcribe one chapter or the whole book.</strong> Chapters queue up and are worked through one at a time while you keep listening.</li>
</ul>

<h2 id="how-it-works">How it works</h2>
<p>Kithara uses OpenAI's Whisper models, run locally through the sherpa-onnx runtime. Whisper on its own only sees thirty seconds of audio at a time and returns words with no timing, so Kithara first runs a voice-activity detector over the chapter to cut it at silences into passages. Each passage starts exactly where speech began, and Whisper transcribes them in turn. That is where the precise timestamps come from.</p>
<p>A thirty-minute chapter is several minutes of sustained CPU work, so transcription runs as a foreground service with a notification that shows which chapter is in progress, how far along it is, and a cancel button. Android will not kill it when you leave the app.</p>
<p>When a chapter finishes, the transcript sheet shows how long the audio was, how long it took, and the speed relative to real time, so you can judge whether a bigger model is worth it on your phone.</p>

<h2 id="models">Choosing a model</h2>
<p>Models are not bundled with the app because of their size. The first time you transcribe, Kithara downloads the one you have chosen and verifies the file sizes, so a partial download is caught rather than trusted. Three English models are available:</p>
<div class="table-wrap">
    <table class="compare">
        <thead><tr><th>Model</th><th>Download</th><th>Character</th></tr></thead>
        <tbody>
            <tr><td>Whisper tiny</td><td>about 105 MB</td><td>The fastest, and it shows: it drops words and mangles names.</td></tr>
            <tr><td>Whisper base</td><td>about 160 MB</td><td>The sensible default. Clearly better than tiny, about twice as slow.</td></tr>
            <tr><td>Whisper small</td><td>about 360 MB</td><td>Close to what you would expect from a dictation app. Several times slower than base.</td></tr>
        </tbody>
    </table>
</div>
<p>You can change the model and the number of processor threads in <strong>Settings</strong>. More threads finish sooner and warm the phone more; plugging in for a whole-book run is a good idea. Downloaded models can be deleted from <strong>Settings, Storage</strong> at any time.</p>
<p>The models are English only for now. Transcription of other languages is not supported yet.</p>

<h2 id="privacy">Privacy</h2>
<p>Everything runs on the device. The only network requests involved are the one-time model downloads: the Whisper model from a public mirror maintained by the sherpa-onnx project on Hugging Face, and a small voice-activity model from the same project's releases on GitHub. Like any download, each shows that host your IP address and the file requested, and nothing else. Your audio, your transcripts and your searches never leave the phone. Details are in the <a href="{{ route('privacy') }}#app">privacy policy</a>.</p>

<h2 id="tips">Good to know</h2>
<ul>
    <li>Accuracy depends on the narrator and the recording. Clean single-narrator audio transcribes well; heavy accents, whispered dialogue and invented names are where tiny and base struggle.</li>
    <li>Transcripts are stored per chapter. If a run is interrupted the chapter is marked partial and can be transcribed again to finish.</li>
    <li>Transcripts do not sync between devices; they live with the phone that made them.</li>
</ul>
@endsection
