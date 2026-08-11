<?php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Models\Baye;
use App\Models\Loyer;

class DashboardController extends Controller
{
    public function index()
    {
        $bailleurId = auth()->id();
        $logementIds = auth()->user()->logements()->pluck('id');

        $stats = [
            'logements' => $logementIds->count(),
            'logements_loues' => auth()->user()->logements()->where('statut', 'loue')->count(),
            'bayes_en_cours' => Baye::where('bailleur_id', $bailleurId)->where('statut', 'en_cours')->count(),
            'demandes_nouvelles' => auth()->user()->demandesBayeRecues()->where('statut', 'nouveau')->count(),
        ];

        // Courbe : revenus locatifs des 6 derniers mois (loyers payes)
        $revenusParMois = Loyer::whereIn('baye_id', Baye::where('bailleur_id', $bailleurId)->pluck('id'))
            ->where('statut', 'paye')
            ->selectRaw("DATE_FORMAT(mois_concerne, '%Y-%m') as mois, SUM(montant) as total")
            ->where('mois_concerne', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('mois')->orderBy('mois')->pluck('total', 'mois');

        // Camembert : repartition du parc de logements par type
        $logementsParType = auth()->user()->logements()
            ->selectRaw('type, count(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        return view('bailleur.dashboard', compact('stats', 'revenusParMois', 'logementsParType'));
    }
}
