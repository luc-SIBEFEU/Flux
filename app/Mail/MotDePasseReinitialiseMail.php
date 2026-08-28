<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MotDePasseReinitialiseMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $temporaryPassword)
    {
    }

    public function build()
    {
        return $this->subject('Votre nouveau mot de passe Flux')
            ->markdown('mail.mot-de-passe-reinitialise', [
                'user' => $this->user,
                'temporaryPassword' => $this->temporaryPassword,
            ]);
    }
}
