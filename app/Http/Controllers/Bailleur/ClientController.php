<?php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Models\Logement;

class ClientController extends Controller
{
    /** Consulter les clients d'un logement specifique. */
    public function parLogement(Logement $logement)
    {
        abort_unless($logement->bailleur_id === auth()->id(), 403);

        $baux = $logement->bayes()->with('client')->latest()->get();

        return view('bailleur.clients.par-logement', compact('logement', 'baux'));
    }
}
