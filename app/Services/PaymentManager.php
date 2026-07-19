<?php

namespace App\Services;

use App\Models\Payment;

/**
 * Point d'entrée unique pour initier un paiement, quel que soit l'opérateur.
 *
 * - Si les identifiants API du service concerné (MTN MoMo / Orange Money)
 *   sont configurés dans .env → paiement réel via l'API officielle.
 * - Sinon → bascule automatique en mode MANUEL : le client paie lui-même au
 *   numéro de l'hôtelier et saisit une référence, que l'hôtelier confirme
 *   ensuite manuellement. Ça permet de mettre le site en ligne dès
 *   maintenant, en attendant l'obtention des clés API MTN/Orange.
 */
class PaymentManager
{
    public function __construct(
        protected MtnMomoService $mtnMomo,
        protected OrangeMoneyService $orangeMoney,
    ) {
    }

    /**
     * Initie le paiement pour une réservation. Renvoie un tableau avec :
     * - 'mode' : 'api' ou 'manuel'
     * - 'succes' : bool
     * - 'payment_url' : présent uniquement pour Orange Money en mode API (redirection)
     */
    public function initier(Payment $payment): array
    {
        $service = $payment->methode === 'mtn_momo' ? $this->mtnMomo : $this->orangeMoney;

        if (! $service->estConfigure()) {
            $payment->update(['mode' => 'manuel', 'statut' => 'initie']);

            return ['mode' => 'manuel', 'succes' => true];
        }

        $payment->update(['mode' => 'api']);

        $resultat = $service->initierPaiement($payment);

        return array_merge(['mode' => 'api'], $resultat);
    }

    /**
     * Enregistre la preuve de paiement saisie par le client en mode manuel
     * (référence de transaction reçue par SMS après son propre transfert).
     */
    public function soumettrePreuve(Payment $payment, string $preuve): void
    {
        $payment->update(['preuve_paiement' => $preuve]);
    }

    /**
     * Confirmation manuelle du paiement par l'hôtelier ou l'admin, après
     * avoir vérifié la réception des fonds sur son propre compte MoMo/Orange.
     */
    public function confirmerManuellement(Payment $payment, int $confirmateurId): void
    {
        $payment->update([
            'statut' => 'reussi',
            'confirme_par_id' => $confirmateurId,
            'confirme_le' => now(),
        ]);

        $payment->reservation->update(['statut' => 'confirmee']);
    }

    public function verifierStatut(Payment $payment): string
    {
        if ($payment->mode === 'manuel') {
            return $payment->statut; // nécessite une confirmation manuelle, pas d'appel API
        }

        $service = $payment->methode === 'mtn_momo' ? $this->mtnMomo : $this->orangeMoney;

        return $service->verifierStatut($payment);
    }
}
