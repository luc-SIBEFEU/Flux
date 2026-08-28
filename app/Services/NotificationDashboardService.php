<?php

namespace App\Services;

use App\Models\Baye;
use App\Models\Forfait;
use App\Models\Hotel;
use App\Models\Logement;
use App\Models\MessageContact;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\DashboardNotification;

/**
 * Miroir "dashboard" des mails déjà envoyés par l'application : pour chaque
 * Mail::send(...) existant, on ajoute un appel à la méthode correspondante
 * ici, juste à côté, sans jamais retirer l'envoi du mail. Les notifications
 * sont stockées en base (table `notifications`) et lues via
 * $user->notifications dans la cloche du layout dashboard.
 */
class NotificationDashboardService
{
    public function hotelValide(Hotel $hotel): void
    {
        $hotel->hotelier->notify(new DashboardNotification(
            'Hôtel validé',
            "Votre hôtel « {$hotel->nom} » a été validé et est désormais visible sur Flux.",
            route('hotelier.dashboard'),
            'check-circle',
        ));
    }

    public function hotelRejete(Hotel $hotel): void
    {
        $hotel->hotelier->notify(new DashboardNotification(
            'Hôtel rejeté',
            "Votre hôtel « {$hotel->nom} » a été rejeté" . ($hotel->motif_rejet ? " : {$hotel->motif_rejet}" : '.'),
            route('hotelier.dashboard'),
            'x-circle',
        ));
    }

    public function logementValide(Logement $logement): void
    {
        $logement->bailleur->notify(new DashboardNotification(
            'Logement validé',
            "Votre logement « {$logement->nom} » a été validé et est désormais visible sur Flux.",
            route('bailleur.dashboard'),
            'check-circle',
        ));
    }

    public function logementRejete(Logement $logement): void
    {
        $logement->bailleur->notify(new DashboardNotification(
            'Logement rejeté',
            "Votre logement « {$logement->nom} » a été rejeté" . ($logement->motif_rejet ? " : {$logement->motif_rejet}" : '.'),
            route('bailleur.dashboard'),
            'x-circle',
        ));
    }

    public function compteValide(User $user): void
    {
        $user->notify(new DashboardNotification(
            'Compte validé',
            'Votre compte Flux a été validé, vous pouvez maintenant vous connecter.',
            route('login'),
            'check-circle',
        ));
    }

    public function compteRejete(User $user): void
    {
        $user->notify(new DashboardNotification(
            'Compte rejeté',
            'Votre demande de compte Flux a été rejetée' . ($user->motif_rejet_compte ? " : {$user->motif_rejet_compte}" : '.'),
            null,
            'x-circle',
        ));
    }

    public function nouvelleInscription(User $admin, User $nouvelUtilisateur): void
    {
        $admin->notify(new DashboardNotification(
            'Nouvelle inscription',
            "{$nouvelUtilisateur->nom} vient de s'inscrire en tant que {$nouvelUtilisateur->role}.",
            route('admin.users.en-attente'),
            'user',
        ));
    }

    public function nouveauLogementAValider(User $admin, Logement $logement): void
    {
        $admin->notify(new DashboardNotification(
            'Nouveau logement à valider',
            "Le logement « {$logement->nom} » attend votre validation.",
            route('admin.logements.index'),
            'building',
        ));
    }

    public function nouvelHotelAValider(User $admin, Hotel $hotel): void
    {
        $admin->notify(new DashboardNotification(
            'Nouvel hôtel à valider',
            "L'hôtel « {$hotel->nom} » attend votre validation.",
            route('admin.hotels.index'),
            'building',
        ));
    }

    public function sejourTermine(Reservation $reservation): void
    {
        $reservation->hotel->hotelier->notify(new DashboardNotification(
            'Séjour terminé',
            "Le séjour de {$reservation->client->nom} (réservation #{$reservation->id}) est terminé.",
            route('hotelier.reservations.index'),
            'calendar',
        ));
    }

    public function proformaReservationDisponible(Reservation $reservation): void
    {
        $reservation->client->notify(new DashboardNotification(
            'Proforma disponible',
            "La proforma de votre réservation #{$reservation->id} est disponible.",
            route('client.reservations.suivi', $reservation),
            'mail',
        ));
    }

    public function bailTermine(Baye $baye): void
    {
        $baye->bailleur->notify(new DashboardNotification(
            'Bail terminé',
            "Le bail de {$baye->client->nom} sur « {$baye->logement->nom} » est arrivé à son terme.",
            route('bailleur.bayes.index'),
            'key',
        ));
    }

    public function proformaBayeDisponible(Baye $baye): void
    {
        $baye->client->notify(new DashboardNotification(
            'Proforma disponible',
            'La proforma de votre location est disponible.',
            route('client.bayes.show', $baye),
            'mail',
        ));
    }

    public function paiementReservationReussi(Reservation $reservation): void
    {
        $reservation->client->notify(new DashboardNotification(
            'Paiement confirmé',
            "Votre paiement pour la réservation #{$reservation->id} a été confirmé.",
            route('client.reservations.suivi', $reservation),
            'check-circle',
        ));
        $reservation->hotel->hotelier->notify(new DashboardNotification(
            'Paiement reçu',
            "Le paiement de la réservation #{$reservation->id} ({$reservation->client->nom}) a été confirmé.",
            route('hotelier.reservations.index'),
            'coins',
        ));
    }

    public function paiementReservationEchoue(Reservation $reservation): void
    {
        $reservation->client->notify(new DashboardNotification(
            'Paiement échoué',
            "Le paiement de votre réservation #{$reservation->id} a échoué. Vous pouvez réessayer depuis votre espace.",
            route('client.reservations.suivi', $reservation),
            'x-circle',
        ));
    }

    public function messageContactRecu(MessageContact $message): void
    {
        $message->destinataire->notify(new DashboardNotification(
            'Nouveau message',
            "{$message->client->nom} souhaite être contacté au sujet de « {$message->contactable->nom} ».",
            null,
            'mail',
        ));
    }

    public function forfaitActive(User $user, Forfait $forfait): void
    {
        $user->notify(new DashboardNotification(
            'Forfait activé',
            "Votre forfait « {$forfait->nom} » est actif" . ($user->forfait_expire_le ? " jusqu'au {$user->forfait_expire_le->format('d/m/Y')}." : '.'),
            null,
            'sparkles',
        ));
    }

    public function forfaitRepasseEnFree(User $user): void
    {
        $user->notify(new DashboardNotification(
            'Forfait expiré',
            'Votre forfait pro est arrivé à échéance, votre compte est repassé en forfait free.',
            null,
            'x-circle',
        ));
    }

    public function essaiProDemarre(User $user, int $jours): void
    {
        $user->notify(new DashboardNotification(
            'Essai pro démarré',
            "Votre essai gratuit du forfait pro ({$jours} jours) est actif.",
            null,
            'sparkles',
        ));
    }
}
