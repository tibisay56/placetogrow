<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceOverdue extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public string $reference;

    public float $amount;

    public function __construct(User $user, string $reference, float $amount)
    {
        $this->user = $user;
        $this->reference = $reference;
        $this->amount = $amount;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Today is the due date for your invoice',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.overdue',
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
