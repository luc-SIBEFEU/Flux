<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use App\Models\Hotel;

class HomeController extends Controller
{
    public function index()
    {
        // Carrousel du hero : actualités en cours, triées par ordre d'affichage
        $actualites = Actualite::enCours()->ordonnees()->take(5)->get();

        $hotelsEnVogue = Hotel::valides()
            ->withCount(['reservations' => fn ($q) => $q->where('created_at', '>=', now()->subDays(30))])
            ->orderByDesc('reservations_count')
            ->orderByDesc('note_moyenne')
            ->take(8)
            ->get();

        return view('home', compact('actualites', 'hotelsEnVogue'));
    }
}
