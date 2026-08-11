<?php

namespace App\Mail;

use App\Models\Logement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NouveauLogementMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Logement $logement)
    {
    }

    public function build()
    {
        return $this->subject('Nouveau logement à valider — Flux')
            ->markdown('mail.nouveau-logement', ['logement' => $this->logement]);
    }
}
