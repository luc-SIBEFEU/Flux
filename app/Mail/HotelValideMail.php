<?php

namespace App\Mail;

use App\Models\Hotel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HotelValideMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Hotel $hotel)
    {
    }

    public function build()
    {
        return $this->subject("Votre hôtel « {$this->hotel->nom} » a été validé")
            ->markdown('mail.hotel-valide', ['hotel' => $this->hotel]);
    }
}
