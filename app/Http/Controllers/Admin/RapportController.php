<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Paiement;

class RapportController extends Controller
{
    public function index()
    {
        $totalGeneral = Paiement::where('statut', 'reussi')->sum('montant');

        $parHotel = Hotel::withSum(['reservations as revenus' => function ($q) {
                $q->join('paiements', function ($j) {
                    $j->on('paiements.payable_id', '=', 'reservations.id')
                      ->where('paiements.payable_type', \App\Models\Reservation::class)
                      ->where('paiements.statut', 'reussi');
                });
            }], 'prix_total')
            ->orderByDesc('revenus')
            ->get();

        // Camembert : repartition des revenus par ville
        // $parVille = Hotel::valides()
        //     ->join('reservations', 'reservations.hotel_id', '=', 'hotels.id')
        //     ->join('paiements', function ($j) {
        //         $j->on('paiements.payable_id', '=', 'reservations.id')
        //           ->where('paiements.payable_type', \App\Models\Reservation::class)
        //           ->where('paiements.statut', 'reussi');
        //     })
        //     ->selectRaw('hotels.ville, SUM(paiements.montant) as total')
        //     ->groupBy('hotels.ville')
        //     ->pluck('total', 'ville');
$parVille = Hotel::whereHas('reservations.paiement', function ($q) {
        $q->where('paiements.statut', 'reussi');
    })
    ->where('hotels.statut', 'valide')  // ← Qualify the column
    ->join('reservations', 'reservations.hotel_id', '=', 'hotels.id')
    ->join('paiements', function ($j) {
        $j->on('paiements.payable_id', '=', 'reservations.id')
          ->where('paiements.payable_type', \App\Models\Reservation::class)
          ->where('paiements.statut', 'reussi');
    })
    ->selectRaw('hotels.ville, SUM(paiements.montant) as total')
    ->groupBy('hotels.ville')
    ->pluck('total', 'ville');
        return view('admin.rapports.index', compact('totalGeneral', 'parHotel', 'parVille'));
    }
}
