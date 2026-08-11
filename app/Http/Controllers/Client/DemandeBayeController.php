<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DemandeBaye;
use App\Models\Logement;
use Illuminate\Http\Request;

class DemandeBayeController extends Controller
{
    /** Bouton "Contacter le bailleur" sur la fiche logement. */
    public function store(Request $request, Logement $logement)
    {
        $data = $request->validate([
            'telephone_client' => ['required', 'string', 'max:30'],
            'message' => ['nullable', 'string', 'max:1000'],
            'duree_souhaitee_mois' => ['required', 'integer', "min:{$logement->duree_min_mois}"],
        ]);

        DemandeBaye::create([
            ...$data,
            'client_id' => auth()->id(),
            'logement_id' => $logement->id,
            'bailleur_id' => $logement->bailleur_id,
            'statut' => 'nouveau',
        ]);

        return back()->with('success', 'Votre demande a été envoyée au bailleur.');
    }
}
