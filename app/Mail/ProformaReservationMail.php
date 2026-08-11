<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

/** Envoyé au client à la fin du séjour, avec le pro-forma PDF en pièce jointe. */
class ProformaReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Reservation $reservation)
    {
    }

    public function build()
    {
        $mail = $this->subject('Votre pro-forma de séjour — Flux')
            ->markdown('mail.proforma-reservation', ['reservation' => $this->reservation]);

        if ($this->reservation->proforma_pdf) {
            $mail->attach(Storage::disk('public')->path($this->reservation->proforma_pdf), [
                'as' => 'proforma-reservation-' . $this->reservation->id . '.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
