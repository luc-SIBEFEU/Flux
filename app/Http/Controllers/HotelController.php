<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function index()
    {
        $tri = request('tri', 'note');

        $hotels = Hotel::valides()
            ->when(request('destination'), fn ($q, $v) => $q->where('ville', 'like', "%{$v}%"))
            ->when(request('etoiles'), fn ($q, $v) => $q->where('nombre_etoiles', '>=', $v))
            ->when(request('note_min'), fn ($q, $v) => $q->where('note_moyenne', '>=', $v))
            ->when(request('equipement'), fn ($q, $v) => $q->whereHas('equipements', fn ($e) => $e->where('equipements.id', $v)))
            ->with('equipements')
            ->when($tri === 'recent', fn ($q) => $q->latest())
            ->when($tri === 'etoiles', fn ($q) => $q->orderByDesc('nombre_etoiles'))
            ->when($tri === 'note', fn ($q) => $q->orderByDesc('note_moyenne'))
            ->paginate(12)
            ->withQueryString();

        // Valeurs réellement présentes en base plutôt qu'une liste figée : le filtre
        // ville ne propose jamais une destination sans aucun hôtel valide.
        $villes = Hotel::valides()->distinct()->orderBy('ville')->pluck('ville');
        $equipements = Equipement::whereIn('contexte', ['hotel', 'les_deux'])->orderBy('nom')->get();

        return view('hotels.index', compact('hotels', 'villes', 'equipements'));
    }

    public function show(Hotel $hotel)
    {
        abort_unless($hotel->statut === 'valide', 404);

        $hotel->load(['photos', 'categorieChambres', 'categorieChambres.photos', 'avisApprouves.client', 'reseauxSociaux', 'hotelier']);

        return view('hotels.show', compact('hotel'));
    }
}
