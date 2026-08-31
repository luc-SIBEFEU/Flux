<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodeVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function build()
    {
        return $this->locale($this->user->locale ?? 'fr')
            ->subject('Votre code de vérification Flux')
            ->markdown('mail.code-verification', ['user' => $this->user]);
    }
}
