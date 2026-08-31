<?php

namespace App\Mail;

use App\Models\Logement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LogementRejeteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Logement $logement)
    {
    }

    public function build()
    {
        return $this->locale($this->logement->bailleur->locale ?? 'fr')
            ->subject("Votre logement n'a pas été validé")
            ->markdown('mail.logement-rejete', ['logement' => $this->logement]);
    }
}
