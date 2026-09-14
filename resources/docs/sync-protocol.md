A small HTTP+JSON contract between a Kithara client (Android today, Apple next) and a
server that holds a library and each user's listening state. Two clients that both
implement this document interoperate through any server that implements it, with no
knowledge of each other.

Anything that can serve JSON and honour HTTP range requests can be a Kithara server: a Go
binary, a Node app, nginx plus a little glue. The interesting logic: chapter parsing, the
combined timeline, offline queueing: lives in the clients.

The words **MUST**, **SHOULD** and **MAY** mean what they usually do. A server that does
only the MUSTs is complete; the SHOULDs make it pleasant; the MAYs are optional and a
client MUST work without them.

---

## 1. Conventions

- **Times are integer milliseconds.** Durations and positions are `ms` from the start of
  the book's combined timeline. Timestamps are Unix epoch milliseconds, UTC. No floats,
  no seconds, no ISO strings.
- **JSON, UTF-8**, `Content-Type: application/json` both ways.
- **Unknown fields are ignored.** Servers MAY add fields; clients MUST ignore fields they
  do not know. This is how the protocol grows without a version bump. Removing or
  re-typing a field is a version bump.
- **Authentication** is `Authorization: Bearer <token>` on every route except
  `/api/health` and `/api/auth`.
- **Ids are opaque strings** chosen by the server. They MUST be stable for the life of the
  item (survive renames, re-scans and restarts: derive them from a stored id, not from a
  file path) and unique within the server. Clients hash `(server, id)` for local storage
  and send the id back in URL paths **percent-encoded**, so any string works, but
  `[A-Za-z0-9._-]` keeps logs readable.
- **Errors** are any non-2xx. The body SHOULD be `{ "error": "human readable" }`. Clients
  treat status codes as follows and servers SHOULD pick accordingly:

  | Status | Meaning to the client |
  |---|---|
  | `401` | Token is no longer valid. Stop retrying; ask the user to sign in again. |
  | `404` on a book route | The book is gone. Drop the queued write. |
  | `409` | Rejected as stale (see §5). Not an error; adopt the body. |
  | `429`, `503` | Busy or reindexing. Retry later. Queued writes survive restarts. |
  | anything else non-2xx | Retry later; give up on a single write after repeated failures. |

- **Transport.** HTTPS SHOULD be used anywhere off a private network; the token is a
  bearer credential. Clients accept plain `http://` for home networks.
- **Users.** The token identifies one user. Everything under `/api/progress` and
  `/api/bookmarks` is that user's, and only that user's. The library MAY be shared
  between users or per user; the client does not care.

## 2. `GET /api/health`

Unauthenticated. Proves the address is a Kithara server before the user commits to it.

```json
{ "ok": true, "protocol": 1, "name": "Phil's shelf", "version": "0.3.1" }
```

- `protocol` (integer) is **this document's version**. A client compares it against the
  versions it implements: equal → proceed; server lower → proceed using only that
  version's routes; server higher → refuse with "server is newer than this app". Servers
  MUST send it. (A server that omits it is treated as protocol 1.)
- `name` MAY be shown as the default library name in the client.
- `version` is the server software's own version string, for display only.

## 3. `POST /api/auth`

```json
{ "username": "phil", "password": "…", "device": "Pixel 9" }
```

```json
{ "token": "long-lived-opaque-token", "user": "phil" }
```

- The client stores the token and forgets the password. Tokens SHOULD be long-lived;
  there is no refresh flow. When a token stops working the server answers `401` and the
  client asks for the password again.
- `device` is optional, for the server's own session list. `user` in the response is
  optional and cosmetic.
- Servers MAY support `POST /api/auth/logout` (bearer, empty body) to revoke the token.
  Clients MAY call it when a library is removed and MUST NOT depend on it.

## 4. `GET /api/library`

The whole catalogue. Called on a full sync, not on every launch.

```json
{
  "updatedAt": 1737000000000,
  "books": [
    {
      "id": "the-hobbit",
      "title": "The Hobbit",
      "author": "J. R. R. Tolkien",
      "narrator": "Rob Inglis",
      "series": "Middle-earth",
      "seriesIndex": 1.0,
      "description": "Bilbo Baggins is a hobbit who enjoys a comfortable life…",
      "durationMs": 39600000,
      "coverUrl": "/covers/the-hobbit.jpg",
      "updatedAt": 1737000000000,
      "files": [
        { "index": 0, "name": "hobbit-part-1.m4b", "url": "/audio/the-hobbit/part-1.m4b",
          "durationMs": 19800000, "sizeBytes": 284000000, "mimeType": "audio/mp4" },
        { "index": 1, "name": "hobbit-part-2.m4b", "url": "/audio/the-hobbit/part-2.m4b",
          "durationMs": 19800000, "sizeBytes": 281000000, "mimeType": "audio/mp4" }
      ],
      "chapters": [
        { "title": "An Unexpected Party", "startMs": 0,       "endMs": 2760000 },
        { "title": "Roast Mutton",        "startMs": 2760000, "endMs": 5100000 }
      ]
    }
  ]
}
```

Required per book: `id`, `title`, `files` (at least one, each with `url` and
`durationMs`), `updatedAt`. Everything else is optional; `durationMs` defaults to the sum
of the files.

Semantics that matter:

- **The list is authoritative.** A book absent from the response has been removed from the
  server, and the client deletes its local copy (keeping nothing but downloaded audio
  until the user clears it). Do not omit books to save bandwidth.
- **`updatedAt` is the whole caching story.** The client keeps the last value it saw per
  book and skips any book whose `updatedAt` has not moved. Bump it whenever files,
  chapters, cover or metadata change; a library of 500 books then re-syncs in one cheap
  request. Deriving it from the newest file mtime is fine. The top-level `updatedAt` is
  optional and lets a client skip the whole body when nothing changed (`ETag` /
  `If-None-Match` on this route is also welcome and works the same way).
- **`files` are ordered by `index` and concatenated into one timeline.** Positions,
  bookmarks and `chapters` are all expressed against that combined timeline, never per
  file. A chapter MAY span a file boundary.
- **`chapters` MAY be empty.** With more than one file the client shows one chapter per
  file. With a single file it shows none: clients do *not* re-parse the container over the
  network. If your files have embedded chapters, parse them server-side once and send them.
- `url` and `coverUrl` MAY be relative (resolved against the server root) or absolute.
  Both are fetched with the bearer token.
- `mimeType` per file is optional; clients sniff the container regardless.
- Covers: JPEG or PNG, ideally 600–1200 px square. Fetched once per `updatedAt` and cached
  on the device.
- No pagination in version 1. Libraries in the low thousands of books are fine as one
  response; gzip helps.

## 5. Progress

One record per book per user. This is the part that makes two devices feel like one.

```json
{ "bookId": "the-hobbit", "positionMs": 8130000, "updatedAt": 1737002000000,
  "finished": false, "speed": 1.25 }
```

- `positionMs`: where the user is, on the combined timeline. Clamp to `[0, durationMs]`.
- `updatedAt`: **the client's clock at the moment the position was set**, not the time
  of the request. A position recorded offline on Monday and uploaded on Wednesday carries
  Monday's timestamp. This is what conflicts are settled on.
- `finished`: the user reached the end or marked it finished. Restarting a book sends
  `finished: false, positionMs: 0`.
- `speed`: optional playback-speed override for this book. Servers MUST store and echo
  it if sent and MAY ignore it otherwise. Clients MAY use it.

### `GET /api/progress`

Every record for this user, in one response. Called on every app resume and after every
pause, so keep it cheap: it is a small table scan.

```json
{ "progress": [ { …record… }, { …record… } ] }
```

### `PUT /api/progress/{bookId}`

Body is one record. The server applies **last-write-wins on `updatedAt`**:

- If the incoming `updatedAt` is **greater than or equal to** the stored one (or nothing
  is stored): store the record **exactly as sent**: do not replace `updatedAt` with the
  server clock: and answer `200` with the stored record.
- If the incoming `updatedAt` is **older** than the stored one: keep the stored record and
  answer **`409`** with the stored record in the body. The client treats this as "someone
  else got further" and applies the body under the rules below. This is not an error and
  MUST NOT be logged as one.

Answering `200` and storing the newer of the two also satisfies the contract; `409` just
lets the client learn the winner one round-trip sooner.

### How a client resolves conflicts

The device applies a server record only when *both* hold:

1. the server's `updatedAt` is **newer** than the device's for that book, and
2. the device has **nothing queued** for that book.

Rule 2 is the one that matters in practice. Listen through a flight with no signal, land,
open the app: the device has three hours of newer listening and the server has a stale
position with a newer-looking timestamp from another device that synced yesterday. Without
rule 2 you would be silently rewound. The device therefore **pushes first, then pulls**.

Clock skew between devices is not handled beyond this. Two devices whose clocks disagree by
minutes will occasionally pick the wrong winner; that is acceptable for a home server and
not worth a vector-clock scheme. Servers SHOULD keep NTP time so at least their own
timestamps (library `updatedAt`) are sane.

### Cadence

Clients push when playback pauses or stops, when a book is finished/restarted, and on a
sync, not on a timer during playback. Expect a handful of PUTs per listening session, not
one per second. A server MAY answer `429` if a client misbehaves.

## 6. Bookmarks

Per user, per book, on the combined timeline. Version 1 adds read-back and deletion so a
bookmark made on one device appears on the other.

```json
{ "id": "bm_8f3a", "bookId": "the-hobbit", "positionMs": 5100000,
  "label": "the riddle game", "createdAt": 1737001000000 }
```

### `GET /api/bookmarks`

Every bookmark for this user, all books, one response:

```json
{ "bookmarks": [ { …bookmark… } ] }
```

### `POST /api/bookmarks/{bookId}`

Body: `{ "positionMs", "label", "createdAt" }`. Response `201` with the stored bookmark
including its server-assigned `id`. Servers MUST treat a repeated POST with the same
`(bookId, positionMs, createdAt)` as the same bookmark and return the existing one, so an
uncertain client can retry without creating duplicates.

### `DELETE /api/bookmarks/{bookId}/{id}`

`204` on success, `404` if already gone (which the client treats as success).

## 7. Serving the audio

The `url` of each file is fetched with `Authorization: Bearer <token>` and MUST support:

- **HTTP range requests** (`Accept-Ranges: bytes`, `206 Partial Content`). Seeking into
  hour nine of an m4b is a range request; without this, seeking re-downloads from the
  start.
- **A correct `Content-Length`.** Downloads show no progress without it.
- A sensible `Content-Type` (`audio/mp4`, `audio/mpeg`, …). Players sniff the container
  anyway, so a wrong type is survivable, but a right one starts faster.

`HEAD` on file URLs SHOULD work (clients use it to size a download before starting).
`nginx` does all of this out of the box for static files, including the bearer check with
`auth_request`.

## 8. What is deliberately not in version 1

- **Listening statistics and achievements** stay on the device. Cross-device stats are a
  candidate for version 2, as append-only listening sessions.
- **Library edits** (renaming, re-tagging, uploading): the server's own UI or filesystem
  does that.
- **Push notifications / real-time.** Clients poll on resume and after pauses; that is
  enough for one person moving between devices.
- **Multiple libraries per server.** One server, one catalogue. Run two servers if you
  want two.

## 9. Minimum viable server

You do not need a database. A directory scanner that emits `/api/library` from the
filesystem, a JSON file per user for progress and bookmarks, and static file serving is a
complete implementation.

The one thing to get right on day one is **stable ids**: assign each book an id when it is
first seen and persist it (a sidecar file, a small key-value store), so renaming a folder
does not turn one book into a new one and orphan its position.

## 10. Client conformance: Android

What the Android client implements today, so the next client knows where the spec runs
ahead of the code:

| Section | Status |
|---|---|
| §2 health, `protocol` check | implemented |
| §3 auth, `401` → sign-in required | implemented; `device`/`logout` not sent |
| §4 library, authoritative list, `updatedAt` skip | implemented; `ETag` not used |
| §5 progress push/pull, conflict rules | implemented; `409` body adopted; `speed` not sent |
| §6 bookmarks POST/GET/DELETE | implemented; deletions are tombstoned locally until the server confirms |
| §7 range playback, downloads | implemented |

## 11. Client conformance: Apple

The iOS client, in development, implements the same table as §10, plus `device` on `/api/auth`.
Its wire types and conflict rules are unit-tested against the samples in this document.

## Changelog

- **1** (2026-09-11): first frozen version. Relative to the earlier draft: `protocol`
  field in health; error-code table; percent-encoded ids; server-side last-write-wins with
  `409`; optional `speed`; `description` and `mimeType`; bookmark ids, read-back and
  deletion; authoritative library list stated explicitly; explicit non-goals.
