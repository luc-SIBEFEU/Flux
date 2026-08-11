<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/** Envoyé à l'hôtelier lorsqu'un séjour se termine. */
class ReservationTermineeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Reservation $reservation)
    {
    }

    public function build()
    {
        return $this->subject("Séjour terminé — {$this->reservation->hotel->nom}")
            ->markdown('mail.reservation-terminee', ['reservation' => $this->reservation]);
    }
}
