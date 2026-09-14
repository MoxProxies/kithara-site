@extends('layouts.guide', [
    'title' => 'How to set up Audiobookshelf and listen on Android',
    'eyebrow' => 'How-to',
    'intro' => 'Audiobookshelf turns a folder of audiobooks on a home server, NAS or spare PC into a library you can stream anywhere, with your place kept across devices. This is the whole path: install the server, organise the files, create a user, reach it from outside the house, and connect Kithara on your phone. An hour, most of it waiting for a scan.',
    'description' => 'Step-by-step: install Audiobookshelf with Docker, organise your audiobook folders, add a library and a user, expose it safely over HTTPS or a VPN, then connect the Kithara Android app to stream, download and sync your position.',
])

@push('head')
<script type="application/ld+json">{!! json_encode([
    '@'.'context' => 'https://schema.org',
    '@type' => 'HowTo',
    'name' => 'How to set up Audiobookshelf and listen on Android',
    'description' => 'Install an Audiobookshelf server, organise a library, expose it safely, and connect the Kithara Android app.',
    'totalTime' => 'PT1H',
    'tool' => [
        ['@type' => 'HowToTool', 'name' => 'A home server, NAS or always-on PC with Docker'],
        ['@type' => 'HowToTool', 'name' => 'Kithara for Android'],
    ],
    'step' => [
        ['@type' => 'HowToStep', 'name' => 'Organise the audiobook folders', 'text' => 'Put each book in its own folder named after the book, inside a folder named after the author.', 'url' => url()->current().'#folders'],
        ['@type' => 'HowToStep', 'name' => 'Install Audiobookshelf with Docker', 'text' => 'Run the official container with your audiobooks, config and metadata folders mounted, on port 13378.', 'url' => url()->current().'#install'],
        ['@type' => 'HowToStep', 'name' => 'Create the admin, a library and a user', 'text' => 'Open the web app, set the root password, add an Audiobooks library pointing at /audiobooks, scan it, then create a normal user for the phone.', 'url' => url()->current().'#library'],
        ['@type' => 'HowToStep', 'name' => 'Reach it from outside the house', 'text' => 'Either put the server behind a VPN such as Tailscale, or publish it over HTTPS with a reverse proxy.', 'url' => url()->current().'#remote'],
        ['@type' => 'HowToStep', 'name' => 'Connect Kithara', 'text' => 'In Kithara, add a library, choose Audiobookshelf, enter the server address with its port, and sign in with the user you created.', 'url' => url()->current().'#kithara'],
    ],
    'author' => ['@id' => url('/#organization')],
    'publisher' => ['@id' => url('/#organization')],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('body')
<h2 id="what-you-need">What you need</h2>
<ul>
    <li><strong>Somewhere for the server to run</strong> that is on when you want to listen: a NAS (Synology, QNAP, Unraid, TrueNAS), a Raspberry Pi, a mini PC, or an old laptop. Audiobookshelf is light; anything that runs Docker is enough.</li>
    <li><strong>Your audiobook files</strong>, DRM-free. m4b with chapters is ideal; folders of mp3s work too. If a book has no chapters, <a href="{{ route('howto.m4b-chapters') }}">add them first</a>; the server reads them once at scan time.</li>
    <li><strong>Docker.</strong> Most NAS systems have it as an app (Container Manager on Synology, the Community Applications tab on Unraid). On a Pi or PC, <a href="https://docs.docker.com/engine/install/" rel="noopener">Docker's own installer</a> is a single script.</li>
</ul>
<p>Audiobookshelf also ships a Windows installer and a Debian package if you would rather not use Docker; the steps after installation are the same. The <a href="https://www.audiobookshelf.org/docs" rel="noopener">official docs</a> cover those.</p>

<h2 id="folders">1. Organise the folders</h2>
<p>Audiobookshelf reads author, title and series from the folder names, then refines them from the file tags. The layout it expects:</p>
<pre><code>audiobooks/
  J. R. R. Tolkien/
    The Hobbit/
      The Hobbit.m4b
    The Lord of the Rings/
      1 - The Fellowship of the Ring/
        Part 01.mp3
        Part 02.mp3
      2 - The Two Towers/
        The Two Towers.m4b</code></pre>
<p>One folder per book, inside one folder per author, with an optional series folder between them. A cover image named <code>cover.jpg</code> in the book folder is picked up; so is embedded art. Do this before the first scan and you will avoid fixing metadata by hand later.</p>

<h2 id="install">2. Install the server with Docker</h2>
<p>Create a folder for the server's own data, then save this as <code>docker-compose.yml</code> next to it, editing the four paths on the left to match your machine:</p>
<pre><code>services:
  audiobookshelf:
    image: ghcr.io/advplyr/audiobookshelf:latest
    container_name: audiobookshelf
    ports:
      - 13378:80
    volumes:
      - /srv/audiobooks:/audiobooks
      - /srv/podcasts:/podcasts
      - /srv/audiobookshelf/config:/config
      - /srv/audiobookshelf/metadata:/metadata
    environment:
      - TZ=America/Toronto
    restart: unless-stopped</code></pre>
<p>Then start it:</p>
<pre><code>docker compose up -d</code></pre>
<p>What the lines mean: <code>13378:80</code> publishes the server on port 13378 of the host (the number Audiobookshelf's docs use; any free port works). The four <code>volumes</code> lines mount your books, an optional podcasts folder, and two folders where the server keeps its database and cover cache; keep those two on the host so upgrades never lose anything. <code>TZ</code> sets the timezone for listening history. <code>restart: unless-stopped</code> brings it back after a reboot.</p>
<p>On a NAS with a Docker GUI, the same values go into the app's form: image name, port mapping, and the four folder mappings.</p>

<h2 id="library">3. Create the admin, a library and a user</h2>
<ol>
    <li>Open <code>http://your-server:13378</code> in a browser on the same network. The first visit asks you to create the <strong>root</strong> account. Use a long password; this account can do anything.</li>
    <li>Go to <strong>Settings, Libraries, Add Library</strong>. Name it, set the media type to <strong>Audiobooks</strong>, and add the folder <code>/audiobooks</code> (the path inside the container, not the host path).</li>
    <li>Save, then let the first scan finish. It reads every file's tags, chapters and cover, so a large library takes a while. Watch progress in the top bar.</li>
    <li>Go to <strong>Settings, Users, Add User</strong> and create a normal account for your phone, with access to the library. Signing in from devices with a non-root user means a lost phone never exposes the admin password.</li>
</ol>
<p>Spot-check a few books in the web app before moving on. If chapters or covers are wrong, fix the files (or the folder names) and use <strong>Quick Match</strong> or a rescan; getting this right on the server means every client gets it right.</p>

<h2 id="remote">4. Reach it from outside the house</h2>
<p>On your home Wi-Fi, the address from step 3 already works. To listen on the train you need one of two things. Pick one; do not open the port on your router without either.</p>
<h3>Option A: a VPN (simplest and safest)</h3>
<p><a href="https://tailscale.com" rel="noopener">Tailscale</a> or WireGuard puts your phone and the server on a private network wherever you are. Install it on both, and the server keeps its plain <code>http://</code> address, just with the VPN's IP or hostname instead of the LAN one. Nothing is exposed to the internet, so there is no certificate to manage.</p>
<h3>Option B: a reverse proxy with HTTPS</h3>
<p>If you want a public address like <code>https://books.example.com</code>, put a reverse proxy in front. <a href="https://caddyserver.com" rel="noopener">Caddy</a> gets a certificate automatically; the whole config is:</p>
<pre><code>books.example.com {
    reverse_proxy localhost:13378
}</code></pre>
<p>Point the domain's DNS at your public IP, forward ports 80 and 443 on the router to the proxy, and you are done. Nginx Proxy Manager does the same with a web form. Audiobookshelf's docs have examples for both. With a public address, use a strong password and consider enabling the server's rate limiting.</p>

<h2 id="kithara">5. Connect Kithara</h2>
<ol>
    <li>Install Kithara on your phone. Server libraries are part of <a href="{{ route('pro') }}">Kithara Pro</a>.</li>
    <li>Open <strong>Library</strong>. On a fresh install the library screen offers a folder, a server or LibriVox directly; otherwise open the menu in the top corner, then <strong>Manage libraries</strong> and <strong>Add a library</strong>. Choose <strong>Audiobookshelf server</strong>.</li>
    <li><strong>Server address</strong>: exactly what you type into the browser, including the port. On the LAN or a VPN that is something like <code>http://192.168.1.20:13378</code>. Behind a reverse proxy it is <code>https://books.example.com</code>. If you leave off the scheme, Kithara assumes <code>http://</code>.</li>
    <li><strong>Username</strong> and <strong>Password</strong>: the user you created in step 3. Kithara exchanges them for a token and discards the password. Give the library a name if you like, then tap <strong>Connect</strong>.</li>
    <li>The first sync fetches every book's details. After that, only what changed on the server is fetched.</li>
</ol>
<p>Your library now has its own tab. Tap a cover to stream; tap the cloud badge to download it for offline listening. Your position syncs on every pause, and if you listen offline the phone's newer position always wins when you reconnect. Details are in the <a href="{{ route('audiobookshelf') }}">Audiobookshelf guide</a>.</p>

<h2 id="troubleshooting">Troubleshooting</h2>
<ul>
    <li><strong>"Could not connect" on the phone.</strong> Open the same address in the phone's browser. If that fails too, the problem is the network (wrong IP, wrong port, phone on mobile data instead of Wi-Fi, VPN not connected), not Kithara.</li>
    <li><strong>Sign-in refused.</strong> Check the user exists and has access to the library. Root works but is not recommended on a phone.</li>
    <li><strong>Books missing after adding files.</strong> The server has not rescanned. Enable the library's automatic scan, or trigger one from its settings, then pull down in Kithara to sync.</li>
    <li><strong>No chapters on a book.</strong> The server sends what it found at scan time. Fix the file and rescan the item; see <a href="{{ route('howto.m4b-chapters') }}">adding chapters to an m4b</a>.</li>
    <li><strong>Seeking is slow over the internet.</strong> The proxy must pass HTTP range requests through unchanged; Caddy and Nginx Proxy Manager do by default. Downloading the book to the phone sidesteps the network entirely.</li>
</ul>
@endsection
