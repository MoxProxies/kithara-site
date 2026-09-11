<?php

namespace Tests\Feature;

use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    public function test_contact_page_renders(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertSee('Send message');
    }

    public function test_valid_submission_sends_email_and_redirects_with_status(): void
    {
        Mail::fake();

        $this->from('/contact')
            ->post('/contact', [
                'name' => 'Ada Lovelace',
                'email' => 'ada@example.com',
                'topic' => 'feedback',
                'message' => 'Loving the sleep timer. Could you add a fade-in on resume?',
            ])
            ->assertRedirect('/contact')
            ->assertSessionHas('status');

        Mail::assertSent(ContactMessage::class, function (ContactMessage $mail) {
            return $mail->hasTo(config('kithara.contact_to'))
                && $mail->hasReplyTo('ada@example.com')
                && $mail->name === 'Ada Lovelace'
                && $mail->topic === 'Feature request or feedback';
        });
    }

    public function test_invalid_submission_returns_errors_and_sends_nothing(): void
    {
        Mail::fake();

        $this->from('/contact')
            ->post('/contact', [
                'name' => '',
                'email' => 'not-an-email',
                'topic' => 'bogus',
                'message' => 'short',
            ])
            ->assertRedirect('/contact')
            ->assertSessionHasErrors(['name', 'email', 'topic', 'message']);

        Mail::assertNothingSent();
    }

    public function test_honeypot_rejects_bots(): void
    {
        Mail::fake();

        $this->from('/contact')
            ->post('/contact', [
                'name' => 'Bot',
                'email' => 'bot@example.com',
                'topic' => 'other',
                'message' => 'Buy cheap things at my website now!!',
                'website' => 'http://spam.example',
            ])
            ->assertSessionHasErrors('website');

        Mail::assertNothingSent();
    }
}
