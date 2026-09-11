<?php

namespace Tests\Feature;

use App\Http\Controllers\NotifyController;
use App\Mail\LaunchAnnouncement;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AnnounceLaunchTest extends TestCase
{
    private const URL = 'https://play.google.com/store/apps/details?id=com.kithara';

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Mail::fake();
        config(['kithara.play_live' => true, 'kithara.play_store_url' => self::URL]);
        Storage::disk('local')->put(NotifyController::LIST_FILE, implode("\n", [
            '2026-09-11T10:00:00+00:00,one@example.com',
            '2026-09-11T11:00:00+00:00,Two@Example.com',
            '2026-09-12T09:00:00+00:00,one@example.com',
        ]));
    }

    public function test_refuses_to_send_until_the_listing_is_live(): void
    {
        config(['kithara.play_live' => false]);

        $this->artisan('kithara:announce-launch --force')->assertFailed();

        Mail::assertNothingSent();
        Storage::disk('local')->assertExists(NotifyController::LIST_FILE);
    }

    public function test_dry_run_lists_unique_addresses_and_sends_nothing(): void
    {
        $this->artisan('kithara:announce-launch --dry-run')
            ->expectsOutputToContain('2 address(es)')
            ->expectsOutputToContain('two@example.com')
            ->assertSuccessful();

        Mail::assertNothingSent();
    }

    public function test_sends_one_email_per_address_and_deletes_the_list(): void
    {
        $this->artisan('kithara:announce-launch --force')->assertSuccessful();

        Mail::assertSent(LaunchAnnouncement::class, 2);
        Mail::assertSent(LaunchAnnouncement::class, fn (LaunchAnnouncement $m) => $m->hasTo('one@example.com') && $m->playStoreUrl === self::URL);
        Mail::assertSent(LaunchAnnouncement::class, fn (LaunchAnnouncement $m) => $m->hasTo('two@example.com'));
        Storage::disk('local')->assertMissing(NotifyController::LIST_FILE);
    }

    public function test_preview_sends_to_one_address_and_keeps_the_list(): void
    {
        config(['kithara.play_live' => false]); // preview works before launch

        $this->artisan('kithara:announce-launch --preview=me@example.com')->assertSuccessful();

        Mail::assertSent(LaunchAnnouncement::class, 1);
        Mail::assertSent(LaunchAnnouncement::class, fn (LaunchAnnouncement $m) => $m->hasTo('me@example.com'));
        Storage::disk('local')->assertExists(NotifyController::LIST_FILE);
    }
}
