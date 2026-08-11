<?php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Models\Baye;
use App\Models\DemandeBaye;
use App\Models\Loyer;

class DemandeBayeController extends Controller
{
    public function index()
    {
        $demandes = auth()->user()->demandesBayeRecues()
            ->when(request('statut'), fn ($q, $v) => $q->where('statut', $v))
            ->with(['client', 'logement'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('bailleur.demandes.index', compact('demandes'));
    }

    /**
     * Valide la demande : crée le baye "nouveau", génère l'échéancier de loyers
     * (caution + durée minimum facturées ensemble comme paiement initial, le reste
     * en mensualités que le client règle à son rythme), et passe le logement en "loué".
     */
    public function valider(DemandeBaye $demande)
    {
        abort_unless($demande->bailleur_id === auth()->id(), 403);

        $logement = $demande->logement;
        $dureeMois = $demande->duree_souhaitee_mois ?? $logement->duree_min_mois;
        $dureeMin = $logement->duree_min_mois;
        $dateDebut = now();
        $dateFinPrevue = $dateDebut->copy()->addMonths($dureeMois);

        $baye = Baye::create([
            'demande_baye_id' => $demande->id,
            'client_id' => $demande->client_id,
            'logement_id' => $demande->logement_id,
            'bailleur_id' => $demande->bailleur_id,
            'date_debut' => $dateDebut,
            'duree_mois' => $dureeMois,
            'date_fin_prevue' => $dateFinPrevue,
            'date_fin_moratoire' => $dateFinPrevue->copy()->addDays($logement->moratoire_jours),
            'statut' => 'nouveau',
            'etat_paiement' => 'en_retard', // en attente du paiement initial (caution + durée minimum)
        ]);

        // Paiement initial obligatoire : caution + loyer des "duree_min_mois" premiers mois, en un bloc.
        Loyer::create([
            'baye_id' => $baye->id,
            'mois_concerne' => $dateDebut,
            'montant' => $logement->caution + ($logement->prix_mois * $dureeMin),
            'date_echeance' => $dateDebut,
            'statut' => 'en_attente',
            'paiement_initial' => true,
        ]);

        // Mensualités restantes : le client les règle à son rythme (fin de mois, tous les 2 mois, ...).
        for ($mois = $dureeMin; $mois < $dureeMois; $mois++) {
            Loyer::create([
                'baye_id' => $baye->id,
                'mois_concerne' => $dateDebut->copy()->addMonths($mois),
                'montant' => $logement->prix_mois,
                'date_echeance' => $dateDebut->copy()->addMonths($mois + 1),
                'statut' => 'en_attente',
                'paiement_initial' => false,
            ]);
        }

        $demande->update(['statut' => 'validee']);
        $logement->update(['statut' => 'loue']);

        // TODO: notifier le client par mail que sa demande est validée et qu'un paiement initial est attendu.

        return back()->with('success', 'Demande validée. Le client doit régler le paiement initial (caution + durée minimum) pour activer le bail.');
    }

    public function rejeter(DemandeBaye $demande)
    {
        abort_unless($demande->bailleur_id === auth()->id(), 403);
        $demande->update(['statut' => 'rejetee']);
        return back()->with('success', 'Demande rejetée.');
    }
}
