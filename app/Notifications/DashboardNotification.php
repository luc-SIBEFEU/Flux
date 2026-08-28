<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * Une seule classe de notification "dashboard" générique plutôt qu'une par
 * évènement : chaque appel (voir NotificationDashboardService) fournit son
 * titre / message / lien / icône. Stockée en base (table `notifications`)
 * et lue par la cloche du layout dashboard, en parallèle du mail déjà envoyé
 * pour le même évènement (le mail n'est jamais remplacé).
 */
class DashboardNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $titre,
        public string $message,
        public ?string $url = null,
        public string $icone = 'bell',
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'titre' => $this->titre,
            'message' => $this->message,
            'url' => $this->url,
            'icone' => $this->icone,
        ];
    }
}
