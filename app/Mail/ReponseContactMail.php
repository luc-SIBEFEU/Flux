<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Mail envoyé à l'auteur du message de contact lorsque l'admin répond.
 */
class ReponseContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Contact $contact)
    {
    }

    public function build()
    {
        return $this->subject("Réponse à votre message de contact — {$this->contact->sujet}")
            ->markdown('mail.reponse-contact', ['contact' => $this->contact]);
    }
}
