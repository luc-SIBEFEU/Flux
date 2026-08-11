<?php

namespace App\Mail;

use App\Models\Hotel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NouvelHotelMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Hotel $hotel)
    {
    }

    public function build()
    {
        return $this->subject("Nouvel hôtel à valider : {$this->hotel->nom}")
            ->markdown('mail.nouvel-hotel', ['hotel' => $this->hotel]);
    }
}
