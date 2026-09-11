<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** The one email promised to everyone on the notify-me list. */
class LaunchAnnouncement extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $playStoreUrl) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Kithara is on Google Play');
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.launch');
    }
}
