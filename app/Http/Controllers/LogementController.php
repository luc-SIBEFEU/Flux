<?php

namespace App\Http\Controllers;

use App\Models\Logement;

class LogementController extends Controller
{
    public function index()
    {
        $logements = Logement::disponibles()
            ->when(request('type'), fn ($q, $v) => $q->where('type', $v))
            ->when(request('categorie'), fn ($q, $v) => $q->where('categorie', $v))
            ->when(request('ville'), fn ($q, $v) => $q->where('ville', 'like', "%{$v}%"))
            ->when(request('prix_max'), fn ($q, $v) => $q->where('prix_mois', '<=', $v))
            ->with('photos')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('logements.index', compact('logements'));
    }

    public function show(Logement $logement)
    {
        $logement->load(['photos', 'equipements', 'minicite', 'commentaires.client', 'bailleur']);

        return view('logements.show', compact('logement'));
    }
}
