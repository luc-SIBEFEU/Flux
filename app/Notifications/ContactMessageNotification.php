<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * Notification dashboard envoyée à l'admin lorsqu'un nouveau message de contact arrive.
 */
class ContactMessageNotification extends Notification
{
    use Queueable;

    public function __construct(public Contact $contact)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'titre' => 'Nouveau message de contact',
            'message' => "{$this->contact->nom} a envoyé un message : \"{$this->contact->sujet}\"",
            'url' => route('admin.contacts.show', $this->contact),
            'icone' => 'mail',
        ];
    }
}
