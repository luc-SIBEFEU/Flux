<?php

namespace App\Mail;

use App\Models\Baye;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/** Envoyé au bailleur lorsqu'un bail se termine (moratoire écoulé). */
class BayeTermineMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Baye $baye)
    {
    }

    public function build()
    {
        return $this->subject('Bail terminé — logement de nouveau disponible')
            ->markdown('mail.baye-terminee', ['baye' => $this->baye]);
    }
}
