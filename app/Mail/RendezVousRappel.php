<?php

namespace App\Mail;

use App\Models\RendezVous;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RendezVousRappel extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public RendezVous $rdv) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "⏰ Rappel : votre rendez-vous demain — L'ARTISTO",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rappel',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
