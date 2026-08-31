<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompteValideMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function build()
    {
        return $this->locale($this->user->locale ?? 'fr')
            ->subject('Votre compte Flux a été validé')
            ->markdown('mail.compte-valide', ['user' => $this->user]);
    }
}
