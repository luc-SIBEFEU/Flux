<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Paiement;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'clients' => User::where('role', 'client')->count(),
            'hoteliers' => User::where('role', 'hotelier')->count(),
            'bailleurs' => User::where('role', 'bailleur')->count(),
            'hotels_en_attente' => Hotel::where('statut', 'en_attente')->count(),
            'hotels_valides' => Hotel::where('statut', 'valide')->count(),
            'reservations_mois' => Reservation::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        // Courbe : revenus des 6 derniers mois (paiements reussis)
        $revenusParMois = Paiement::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mois, SUM(montant) as total")
            ->where('statut', 'reussi')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('mois')
            ->orderBy('mois')
            ->pluck('total', 'mois');

        // Camembert : repartition des reservations par statut
        $reservationsParStatut = Reservation::select('statut', DB::raw('count(*) as total'))
            ->groupBy('statut')
            ->pluck('total', 'statut');

        return view('admin.dashboard', compact('stats', 'revenusParMois', 'reservationsParStatut'));
    }
}
