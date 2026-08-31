<?php

namespace App\Mail;

use App\Models\Hotel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HotelRejeteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Hotel $hotel)
    {
    }

    public function build()
    {
        return $this->locale($this->hotel->hotelier->locale ?? 'fr')
            ->subject("Votre hôtel « {$this->hotel->nom} » n'a pas été validé")
            ->markdown('mail.hotel-rejete', ['hotel' => $this->hotel]);
    }
}
