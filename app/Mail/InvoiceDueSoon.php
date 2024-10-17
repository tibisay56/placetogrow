<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceDueSoon extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $email, public string $reference, public float $amount)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Due Soon',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.due-soon',
            with: [
                'reference' => $this->reference,
                'amount' => $this->amount,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
