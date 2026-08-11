<?php

namespace App\Mail;

use App\Models\Baye;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

/** Envoyé au client à la fin du bail, avec le pro-forma PDF en pièce jointe. */
class ProformaBayeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Baye $baye)
    {
    }

    public function build()
    {
        $mail = $this->subject('Votre pro-forma de location — Flux')
            ->markdown('mail.proforma-baye', ['baye' => $this->baye]);

        if ($this->baye->proforma_pdf) {
            $mail->attach(Storage::disk('public')->path($this->baye->proforma_pdf), [
                'as' => 'proforma-bail-' . $this->baye->id . '.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
