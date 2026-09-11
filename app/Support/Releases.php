<?php

namespace App\Support;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/** Reads resources/changelog/releases.php for the changelog page, feed and schema. */
class Releases
{
    /** @return Collection<int, array{version: string, date: ?string, status: string, summary: string, changes: list<string>}> */
    public static function all(): Collection
    {
        return collect(require resource_path('changelog/releases.php'));
    }

    /** @return array{version: string, date: ?string, status: string, summary: string, changes: list<string>}|null */
    public static function latest(): ?array
    {
        return self::all()->first();
    }

    /** The most recent version that has actually shipped, for softwareVersion. */
    public static function latestReleased(): ?array
    {
        return self::all()->first(fn ($r) => $r['status'] === 'released');
    }

    public static function date(array $release): ?Carbon
    {
        return $release['date'] ? Carbon::parse($release['date']) : null;
    }
}
