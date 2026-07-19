<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $destination = $request->input('destination');
        $adultes = (int) $request->input('adultes', 1);
        $enfants = (int) $request->input('enfants', 0);
        $etoiles = $request->filled('etoiles') ? (int) $request->input('etoiles') : null;
        $noteMin = $request->filled('note_min') ? (float) $request->input('note_min') : null;

        $hotels = Hotel::query()
            ->valides()
            ->rechercher($destination, $adultes, $enfants)
            ->filtrerEtoiles($etoiles)
            ->filtrerNote($noteMin)
            ->orderByDesc('note_moyenne')
            ->paginate(9)
            ->withQueryString();

        return view('public.hotels.index', compact('hotels'));
    }

    public function show(Request $request, Hotel $hotel)
    {
        abort_unless($hotel->statut === 'valide', 404);

        $hotel->load([
            'galeries',
            'roomCategories' => fn ($q) => $q->where('actif', true)->with(['amenities', 'galeries']),
            'reviewsApprouves.client',
        ]);

        $estFavori = $hotel->estFavoriDe(Auth::user());

        // critères de recherche transmis pour pré-remplir le formulaire de réservation
        $criteres = $request->only(['date_debut', 'date_fin', 'adultes', 'enfants']);

        return view('public.hotels.show', compact('hotel', 'estFavori', 'criteres'));
    }

    public function basculerFavori(Request $request, Hotel $hotel)
    {
        $favori = Favori::where('client_id', Auth::id())->where('hotel_id', $hotel->id)->first();

        if ($favori) {
            $favori->delete();
        } else {
            Favori::create(['client_id' => Auth::id(), 'hotel_id' => $hotel->id]);
        }

        return back();
    }
}
