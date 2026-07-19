<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationProforma extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Reservation $reservation)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre facture pro-forma — Réservation #' . $this->reservation->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-proforma',
            with: [
                'reservation' => $this->reservation->load(['hotel', 'roomCategory', 'client']),
            ],
        );
    }
}
