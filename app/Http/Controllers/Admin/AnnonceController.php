<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;

class AnnonceController extends Controller
{
    public function index()
    {
        $annonces = Annonce::with('auteur')
            ->when(request('ville'), fn ($q, $v) => $q->where('ville', $v))
            ->when(request('statut') === 'visible', fn ($q) => $q->where('visible', true))
            ->when(request('statut') === 'masquee', fn ($q) => $q->where('visible', false))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $villes = Annonce::distinct()->orderBy('ville')->pluck('ville');

        return view('admin.annonces.index', compact('annonces', 'villes'));
    }

    public function masquer(Annonce $annonce)
    {
        $annonce->update(['visible' => false]);
        return back()->with('success', 'Annonce masquée.');
    }

    public function afficher(Annonce $annonce)
    {
        $annonce->update(['visible' => true]);
        return back()->with('success', 'Annonce de nouveau visible.');
    }
}
