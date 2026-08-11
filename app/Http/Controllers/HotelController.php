<?php

namespace App\Http\Controllers;

use App\Models\Hotel;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::valides()
            ->when(request('destination'), fn ($q, $v) => $q->where('ville', 'like', "%{$v}%"))
            ->when(request('etoiles'), fn ($q, $v) => $q->where('nombre_etoiles', '>=', $v))
            ->when(request('note_min'), fn ($q, $v) => $q->where('note_moyenne', '>=', $v))
            ->orderByDesc('note_moyenne')
            ->paginate(9)
            ->withQueryString();

        return view('hotels.index', compact('hotels'));
    }

    public function show(Hotel $hotel)
    {
        abort_unless($hotel->statut === 'valide', 404);

        $hotel->load(['photos', 'categorieChambres.equipements', 'categorieChambres.photos', 'avisApprouves.client', 'reseauxSociaux']);

        return view('hotels.show', compact('hotel'));
    }
}
