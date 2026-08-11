<?php

namespace App\Mail;

use App\Models\Logement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LogementValideMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Logement $logement)
    {
    }

    public function build()
    {
        return $this->subject('Votre logement a été validé')
            ->markdown('mail.logement-valide', ['logement' => $this->logement]);
    }
}
