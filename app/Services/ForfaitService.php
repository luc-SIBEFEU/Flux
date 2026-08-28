<?php

namespace App\Services;

use App\Models\Abonnement;
use App\Models\Forfait;
use App\Models\User;

class ForfaitService
{
    public function __construct(private NotificationDashboardService $notifications)
    {
    }

    /** Formules pro actives, proposées à l'upgrade (admin en fixe le prix/la durée). */
    public function offresPro()
    {
        return Forfait::where('type', 'pro')->where('actif', true)->orderBy('prix')->get();
    }

    /**
     * Démarre l'essai gratuit pro (une seule fois par compte). L'essai s'appuie
     * sur la formule pro_mensuel pour la "forme" (mêmes fonctionnalités) mais sa
     * durée et son prix (gratuit) sont propres à l'essai.
     */
    public function demarrerEssai(User $user, int $jours = 14): Abonnement
    {
        abort_unless($user->peutDemarrerEssaiPro(), 403, 'Essai déjà utilisé ou forfait déjà actif.');

        $forfaitReference = Forfait::where('type', 'pro')->where('actif', true)->orderBy('prix')->firstOrFail();
        $dateFin = now()->addDays($jours)->toDateString();

        $abonnement = Abonnement::create([
            'user_id' => $user->id,
            'forfait_id' => $forfaitReference->id,
            'statut' => 'essai',
            'date_debut' => now()->toDateString(),
            'date_fin' => $dateFin,
        ]);

        $user->update([
            'forfait_id' => $forfaitReference->id,
            'forfait_expire_le' => $dateFin,
            'essai_pro_utilise' => true,
        ]);

        $this->notifications->essaiProDemarre($user, $jours);

        return $abonnement;
    }

    /** Crée la souscription en attente de paiement (redirigée ensuite vers le paiement AangaraaPay). */
    public function souscrire(User $user, Forfait $forfait): Abonnement
    {
        abort_unless($forfait->estPro() && $forfait->actif, 422, 'Formule indisponible.');

        return Abonnement::create([
            'user_id' => $user->id,
            'forfait_id' => $forfait->id,
            'statut' => 'en_attente',
            'date_debut' => now()->toDateString(),
        ]);
    }

    /** Appelé par PaiementController une fois le paiement AangaraaPay confirmé. */
    public function activer(Abonnement $abonnement): void
    {
        $forfait = $abonnement->forfait;
        $dateDebut = now()->toDateString();
        $dateFin = now()->addDays($forfait->duree_jours)->toDateString();

        $abonnement->update(['statut' => 'actif', 'date_debut' => $dateDebut, 'date_fin' => $dateFin]);

        $user = $abonnement->user;
        $user->update(['forfait_id' => $forfait->id, 'forfait_expire_le' => $dateFin]);

        $this->notifications->forfaitActive($user, $forfait);
    }

    /**
     * Job planifié quotidien : tout hôtelier/bailleur dont le forfait pro (payé
     * ou essai) est arrivé à échéance sans renouvellement repasse en free.
     * Les réservations/bayes déjà en cours ne sont PAS impactées, seules les
     * nouvelles sont bloquées (contrôlé au moment de leur création).
     */
    public function traiterExpirations(): int
    {
        $forfaitFree = Forfait::free();

        $expires = User::whereIn('role', ['hotelier', 'bailleur'])
            ->whereHas('forfait', fn ($q) => $q->where('type', 'pro'))
            ->whereNotNull('forfait_expire_le')
            ->where('forfait_expire_le', '<', now()->toDateString())
            ->get();

        foreach ($expires as $user) {
            $abonnement = $user->abonnements()->whereIn('statut', ['actif', 'essai'])->latest('date_debut')->first();
            $abonnement?->update(['statut' => 'expire']);

            $user->update(['forfait_id' => $forfaitFree->id, 'forfait_expire_le' => null]);
            $this->notifications->forfaitRepasseEnFree($user);
        }

        return $expires->count();
    }
}
