<?php

namespace App\Http\Controllers;

use App\Models\Logement;

class LogementController extends Controller
{
    public function index()
    {
        $tri = request('tri', 'recent');

        $logements = Logement::disponibles()
            ->when(request('type'), fn ($q, $v) => $q->where('type', $v))
            ->when(request('categorie'), fn ($q, $v) => $q->where('categorie', $v))
            ->when(request('ville'), fn ($q, $v) => $q->where('ville', 'like', "%{$v}%"))
            ->when(request('prix_max'), fn ($q, $v) => $q->where('prix_mois', '<=', $v))
            ->with('photos')
            ->when($tri === 'prix_asc', fn ($q) => $q->orderBy('prix_mois'))
            ->when($tri === 'prix_desc', fn ($q) => $q->orderByDesc('prix_mois'))
            ->when($tri === 'recent', fn ($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        // Villes réellement présentes en base parmi les logements disponibles.
        $villes = Logement::disponibles()->distinct()->orderBy('ville')->pluck('ville');

        return view('logements.index', compact('logements', 'villes'));
    }

    public function show(Logement $logement)
    {
        $logement->load(['photos', 'equipements', 'minicite', 'commentaires.client', 'bailleur']);

        return view('logements.show', compact('logement'));
    }
}
