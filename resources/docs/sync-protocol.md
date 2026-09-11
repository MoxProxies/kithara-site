Six routes. Anything that can serve JSON and honour HTTP range requests can be a Kithara
library: a Go binary, a Node app, an nginx config with a bit of glue.

This exists so you are not locked to Audiobookshelf. If you ever want a server that does
exactly what you need and nothing else, this is the contract to implement.

---

## Conventions

- All times are **integer milliseconds**. No floats, no seconds, no ambiguity.
- All timestamps are **Unix epoch milliseconds, UTC**.
- Auth is `Authorization: Bearer <token>` on every route except `/api/health` and `/api/auth`.
- Any non-2xx is treated as a failure and the client retries later. Queued writes survive
  restarts, so returning 503 while you reindex is safe.
- Ids are opaque strings. The client hashes them with the source id, so they only need to be
  stable and unique within your server.

## `GET /api/health`

Unauthenticated. Proves the address is a Kithara server before the user commits to it.

```json
{ "ok": true, "version": "1.0" }
```

## `POST /api/auth`

```json
{ "username": "phil", "password": "…" }
```

```json
{ "token": "long-lived-opaque-token" }
```

The client stores the token and forgets the password. Tokens should be long-lived; there is
no refresh flow. If a token stops working, the user is asked to sign in again.

## `GET /api/library`

The whole catalogue. Called on a full sync, not on every launch.

```json
{
  "books": [
    {
      "id": "the-hobbit",
      "title": "The Hobbit",
      "author": "J. R. R. Tolkien",
      "narrator": "Rob Inglis",
      "series": "Middle-earth",
      "seriesIndex": 1.0,
      "durationMs": 39600000,
      "coverUrl": "/covers/the-hobbit.jpg",
      "updatedAt": 1737000000000,
      "files": [
        {
          "index": 0,
          "name": "hobbit-part-1.m4b",
          "url": "/audio/the-hobbit/part-1.m4b",
          "durationMs": 19800000,
          "sizeBytes": 284000000
        },
        { "index": 1, "name": "hobbit-part-2.m4b", "url": "/audio/the-hobbit/part-2.m4b",
          "durationMs": 19800000, "sizeBytes": 281000000 }
      ],
      "chapters": [
        { "title": "An Unexpected Party", "startMs": 0,       "endMs": 2760000 },
        { "title": "Roast Mutton",        "startMs": 2760000, "endMs": 5100000 }
      ]
    }
  ]
}
```

Notes that matter:

- **`updatedAt` is the whole caching story.** The client keeps the last value it saw and skips
  any book whose `updatedAt` has not moved. Bump it whenever files, chapters or metadata
  change; a library of 500 books then re-syncs in one request.
- **`files` are ordered by `index` and concatenated into one timeline.** `chapters` are
  expressed against that combined timeline, not per file. A chapter may span a file boundary.
- **`chapters` may be empty.** With more than one file the client falls back to one chapter
  per file. With a single file it shows no chapters: it does *not* re-parse the container
  over the network.
- `url` may be relative (resolved against the server root) or absolute.
- `coverUrl` is optional; the image is fetched once and cached on the device.

## `GET /api/progress`

Where this user is in everything. Called on every app resume, so keep it cheap.

```json
{
  "progress": [
    { "bookId": "the-hobbit", "positionMs": 8130000, "updatedAt": 1737002000000, "finished": false }
  ]
}
```

## `PUT /api/progress/{bookId}`

```json
{ "bookId": "the-hobbit", "positionMs": 8130000, "updatedAt": 1737002000000, "finished": false }
```

**Store `updatedAt` exactly as sent: do not replace it with your own clock.** It is how
conflicts are settled, and rewriting it will lose positions.

### How conflicts are resolved

The device applies a server position only when *both* hold:

1. the server's `updatedAt` is **newer** than the device's, and
2. the device has **nothing queued** for that book.

Rule 2 is the one that matters in practice. Listen through a flight with no signal, land, open
the app: your device has three hours of newer listening and the server has a stale position
with a newer-looking timestamp from another device that synced yesterday. Without rule 2 you
would be silently rewound. The device pushes first, then pulls.

## `POST /api/bookmarks/{bookId}`

```json
{ "positionMs": 5100000, "label": "the riddle game", "createdAt": 1737001000000 }
```

Fire-and-forget. The client marks a bookmark synced on any 2xx and does not read bookmarks
back yet.

---

## Serving the audio

The `url` of each file is fetched with `Authorization: Bearer <token>` and must support:

- **HTTP range requests** (`Accept-Ranges: bytes`, `206 Partial Content`). Seeking into hour
  nine of an m4b is a range request; without this, seeking will re-download from the start.
- **A correct `Content-Length`.** Downloads show no progress without it.
- A sensible `Content-Type` (`audio/mp4`, `audio/mpeg`, …). ExoPlayer sniffs the container
  anyway, so a wrong type is survivable, but a right one is faster.

`nginx` does all three out of the box for static files.

## Minimum viable server

You do not need a database. A directory scanner that emits `/api/library` from the filesystem,
a JSON file for progress, and static file serving is a complete implementation. The interesting
work: chapter parsing, the combined timeline, conflict resolution, offline queueing: already
lives in the app.

The one thing worth getting right on day one is `updatedAt`: give every book a value derived
from its files' mtimes, and re-syncs stay fast forever.
