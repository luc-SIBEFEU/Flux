<?php

namespace App\Mail;

use App\Models\MessageContact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public MessageContact $messageContact)
    {
    }

    public function build()
    {
        return $this->subject('Nouveau message client — Flux')
            ->markdown('mail.message-contact', ['messageContact' => $this->messageContact]);
    }
}
