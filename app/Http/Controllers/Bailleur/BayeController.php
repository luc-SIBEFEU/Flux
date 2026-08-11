<?php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Models\Baye;
use App\Models\Prolongation;

class BayeController extends Controller
{
    public function index()
    {
        $bayes = auth()->user()->bayesBailleur()
            ->when(request('statut'), fn ($q, $v) => $q->where('statut', $v))
            ->with(['client', 'logement', 'loyers'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('bailleur.bayes.index', compact('bayes'));
    }

    public function approuverProlongation(Prolongation $prolongation)
    {
        $baye = $prolongation->baye;
        abort_unless($baye->bailleur_id === auth()->id(), 403);

        $nouvelleFin = $baye->date_fin_prevue->copy()->addMonths($prolongation->duree_supplementaire_mois);
        $nouvelleFinMoratoire = $nouvelleFin->copy()->addDays($baye->logement->moratoire_jours);

        $prolongation->update(['statut' => 'approuvee', 'nouvelle_date_fin_prevue' => $nouvelleFin]);
        $baye->update([
            'duree_mois' => $baye->duree_mois + $prolongation->duree_supplementaire_mois,
            'date_fin_prevue' => $nouvelleFin,
            'date_fin_moratoire' => $nouvelleFinMoratoire,
        ]);

        // Nouvelles mensualités pour les mois de la prolongation (paiement flexible).
        for ($i = 0; $i < $prolongation->duree_supplementaire_mois; $i++) {
            \App\Models\Loyer::create([
                'baye_id' => $baye->id,
                'mois_concerne' => $baye->date_fin_prevue->copy()->subMonths($prolongation->duree_supplementaire_mois - $i),
                'montant' => $baye->logement->prix_mois,
                'date_echeance' => $baye->date_fin_prevue->copy()->subMonths($prolongation->duree_supplementaire_mois - $i - 1),
                'statut' => 'en_attente',
                'paiement_initial' => false,
            ]);
        }

        return back()->with('success', 'Prolongation approuvée.');
    }
}
