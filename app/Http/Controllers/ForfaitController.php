<?php

namespace App\Http\Controllers;

use App\Models\Forfait;
use App\Services\ForfaitService;
use Illuminate\Http\Request;

/**
 * Commun aux hôteliers et aux bailleurs (mêmes règles free/pro), monté sous
 * /forfait avec le middleware role:hotelier,bailleur — pas de duplication
 * entre deux contrôleurs quasi identiques.
 */
class ForfaitController extends Controller
{
    public function __construct(private ForfaitService $forfaits)
    {
    }

    public function index()
    {
        $user = auth()->user()->load('forfait');

        return view('forfait.index', [
            'user' => $user,
            'offres' => $this->forfaits->offresPro(),
        ]);
    }

    public function demarrerEssai()
    {
        $this->forfaits->demarrerEssai(auth()->user());

        return redirect()->route('forfait.index')->with('success', 'Votre essai gratuit du forfait pro est activé !');
    }

    /** Crée la souscription puis redirige vers le paiement AangaraaPay existant. */
    public function souscrire(Request $request, Forfait $forfait)
    {
        $abonnement = $this->forfaits->souscrire(auth()->user(), $forfait);

        return redirect()->route('paiements.formulaire', ['abonnement', $abonnement->id]);
    }
}
