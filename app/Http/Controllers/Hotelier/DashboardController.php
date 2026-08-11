<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hotelIds = auth()->user()->hotels()->pluck('id');

        $stats = [
            'hotels' => $hotelIds->count(),
            'reservations_en_attente' => Reservation::whereIn('hotel_id', $hotelIds)->where('statut', 'en_attente')->count(),
            'reservations_confirmees' => Reservation::whereIn('hotel_id', $hotelIds)->where('statut', 'confirmee')->count(),
            'revenus_total' => Paiement::where('payable_type', Reservation::class)
                ->whereIn('payable_id', Reservation::whereIn('hotel_id', $hotelIds)->pluck('id'))
                ->where('statut', 'reussi')->sum('montant'),
        ];

        // Courbe : reservations des 6 derniers mois
        $reservationsParMois = Reservation::whereIn('hotel_id', $hotelIds)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mois, count(*) as total")
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('mois')->orderBy('mois')->pluck('total', 'mois');

        // Camembert : taux d'occupation par categorie de chambre
        // $reservationsParChambre = Reservation::whereIn('hotel_id', $hotelIds)
        //     ->join('categorie_chambres', 'categorie_chambres.id', '=', 'reservations.categorie_chambre_id')
        //     ->selectRaw('categorie_chambres.nom, count(*) as total')
        //     ->groupBy('categorie_chambres.nom')
        //     ->pluck('total', 'nom');

        $reservationsParChambre = Reservation::whereIn('reservations.hotel_id', $hotelIds)
    ->join('categorie_chambres', 'categorie_chambres.id', '=', 'reservations.categorie_chambre_id')
    ->selectRaw('categorie_chambres.nom, count(*) as total')
    ->groupBy('categorie_chambres.nom')
    ->pluck('total', 'nom');

        return view('hotelier.dashboard', compact('stats', 'reservationsParMois', 'reservationsParChambre'));
    }
}
