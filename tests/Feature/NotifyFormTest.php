<?php

namespace Tests\Feature;

use App\Http\Controllers\NotifyController;
use App\Mail\NotifySignup;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NotifyFormTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Mail::fake();
        config(['kithara.play_live' => false]);
    }

    public function test_form_shows_only_while_the_listing_is_not_live(): void
    {
        $this->get('/')->assertOk()->assertSee('Notify me');

        config(['kithara.play_live' => true]);
        $this->get('/')->assertOk()->assertDontSee('Notify me');
    }

    public function test_signup_is_stored_lowercased_and_emailed(): void
    {
        $this->from('/')
            ->post('/notify', ['email' => 'Reader@Example.com'])
            ->assertRedirect('/#download')
            ->assertSessionHas('notify_status');

        Storage::disk('local')->assertExists(NotifyController::LIST_FILE);
        $this->assertStringEndsWith(',reader@example.com', Storage::disk('local')->get(NotifyController::LIST_FILE));

        Mail::assertSent(NotifySignup::class, fn (NotifySignup $mail) => $mail->email === 'reader@example.com'
            && $mail->hasTo(config('kithara.contact_to')));
    }

    public function test_duplicate_signup_is_ignored_but_still_thanked(): void
    {
        Storage::disk('local')->put(NotifyController::LIST_FILE, "2026-09-11T10:00:00+00:00,reader@example.com\n");

        $this->from('/')
            ->post('/notify', ['email' => 'reader@example.com'])
            ->assertRedirect('/#download')
            ->assertSessionHas('notify_status');

        $this->assertSame(1, substr_count(Storage::disk('local')->get(NotifyController::LIST_FILE), 'reader@example.com'));
        Mail::assertNothingSent();
    }

    public function test_invalid_email_and_honeypot_are_rejected(): void
    {
        $this->from('/')
            ->post('/notify', ['email' => 'nope'])
            ->assertRedirect('/')
            ->assertSessionHasErrors('email');

        $this->from('/')
            ->post('/notify', ['email' => 'bot@example.com', 'website' => 'http://spam.example'])
            ->assertSessionHasErrors('website');

        Storage::disk('local')->assertMissing(NotifyController::LIST_FILE);
        Mail::assertNothingSent();
    }
}
