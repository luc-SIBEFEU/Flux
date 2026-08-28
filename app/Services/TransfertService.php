<?php

namespace App\Services;

use App\Models\Paiement;
use App\Models\Transfert;
use App\Models\User;

class TransfertService
{
    public function __construct(private AangaraaPayService $aangaraaPay)
    {
    }

    /**
     * Crée la ligne de transfert due au bénéficiaire (hôtelier/bailleur) puis
     * tente immédiatement le versement automatique via /aangaraa-pay/withdrawal.
     */
    public function creerEtVerser(Paiement $paiement, User $beneficiaire, $contactPaiement): Transfert
    {
        $transfert = Transfert::create([
            'paiement_id' => $paiement->id,
            'beneficiaire_id' => $beneficiaire->id,
            'montant' => $paiement->montant,
            'type_contact' => $contactPaiement->type ?? null,
            'numero_destinataire' => $contactPaiement->numero ?? null,
            'statut' => 'a_traiter',
        ]);

        $this->tenterVersement($transfert);

        return $transfert;
    }

    /** Appelle l'API de retrait AangaraaPay pour ce transfert (création initiale ou nouvel essai). */
    public function tenterVersement(Transfert $transfert): void
    {
        if (! $transfert->versementAutomatiquePossible()) {
            $transfert->update(['notes' => "Aucun contact de paiement enregistré pour {$transfert->beneficiaire->nom} : versement manuel requis."]);
            return;
        }

        $operateur = $this->aangaraaPay->operateurDepuisType($transfert->type_contact);
        $resultat = $this->aangaraaPay->retirer(
            $transfert->numero_destinataire,
            (float) $transfert->montant,
            $operateur,
            $transfert->beneficiaire->nom
        );

        $transfert->update([
            'statut' => $resultat['statut'],
            'reference_retrait' => $resultat['reference'] ?? $transfert->reference_retrait,
            'traite_le' => $resultat['statut'] === 'effectue' ? now() : null,
            'notes' => $resultat['statut'] === 'echoue' ? ($resultat['message'] ?? 'Échec du retrait AangaraaPay.') : null,
        ]);
    }

    /** Interroge AangaraaPay pour un transfert resté "en_cours" (retrait PENDING chez l'opérateur). */
    public function verifierStatut(Transfert $transfert): void
    {
        if (! $transfert->reference_retrait) {
            return;
        }

        $operateur = $this->aangaraaPay->operateurDepuisType($transfert->type_contact);
        $verification = $this->aangaraaPay->verifierStatutRetrait($transfert->reference_retrait, $operateur);
        $statutDistant = strtoupper($verification['status'] ?? 'PENDING');

        if ($statutDistant === 'SUCCESSFUL') {
            $transfert->update(['statut' => 'effectue', 'traite_le' => now(), 'notes' => null]);
        } elseif ($statutDistant === 'FAILED') {
            $transfert->update(['statut' => 'echoue', 'notes' => $verification['details']['reason'] ?? 'Retrait échoué.']);
        }
        // PENDING / NOT_FOUND : on laisse "en_cours", l'admin pourra réessayer plus tard.
    }
}
