<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Baye;
use App\Models\Prolongation;
use Illuminate\Http\Request;

class BayeController extends Controller
{
    public function index()
    {
        $bayes = auth()->user()->bayesLocataire()
            ->when(request('statut'), fn ($q, $v) => $q->where('statut', $v))
            ->with(['logement', 'loyers'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('client.bayes.index', compact('bayes'));
    }

    public function show(Baye $baye)
    {
        abort_unless($baye->client_id === auth()->id(), 403);
        $baye->load(['logement', 'loyers', 'prolongations']);
        return view('client.bayes.show', compact('baye'));
    }

    public function demanderProlongation(Request $request, Baye $baye)
    {
        abort_unless($baye->client_id === auth()->id(), 403);

        $data = $request->validate(['duree_supplementaire_mois' => ['required', 'integer', 'min:1']]);

        Prolongation::create([
            'baye_id' => $baye->id,
            'duree_supplementaire_mois' => $data['duree_supplementaire_mois'],
            'statut' => 'en_attente',
        ]);

        return back()->with('success', 'Demande de prolongation envoyée au bailleur.');
    }
}
