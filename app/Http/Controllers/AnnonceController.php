<?php

namespace App\Http\Controllers;

use App\Models\Annonce;

class AnnonceController extends Controller
{
    public function index()
    {
        $annonces = Annonce::visibles()
            ->with('auteur')
            ->when(request('ville'), fn ($q, $v) => $q->where('ville', $v))
            ->when(request('categorie'), fn ($q, $v) => $q->where('categorie', $v))
            ->when(request('role'), fn ($q, $v) => $q->whereHas('auteur', fn ($u) => $u->where('role', $v)))
            ->when(request('q'), fn ($q, $v) => $q->where(fn ($w) => $w->where('titre', 'like', "%{$v}%")->orWhere('contenu', 'like', "%{$v}%")))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        // Valeurs réellement présentes en base, pour des filtres qui reflètent le contenu existant.
        $villes = Annonce::visibles()->distinct()->orderBy('ville')->pluck('ville');

        return view('annonces.index', compact('annonces', 'villes'));
    }

    public function show(Annonce $annonce)
    {
        abort_unless($annonce->visible, 404);

        $annonce->load('auteur');

        return view('annonces.show', compact('annonce'));
    }
}
