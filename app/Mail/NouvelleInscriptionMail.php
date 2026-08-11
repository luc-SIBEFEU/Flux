<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NouvelleInscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function build()
    {
        return $this->subject("Nouvelle inscription {$this->user->role} à valider — Flux")
            ->markdown('mail.nouvelle-inscription', ['user' => $this->user]);
    }
}
