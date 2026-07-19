<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $hotelIds = Auth::user()->hotels()->pluck('id');

        $nbHotels = $hotelIds->count();
        $nbReservations = Reservation::whereIn('hotel_id', $hotelIds)->count();
        $nbEnAttente = Reservation::whereIn('hotel_id', $hotelIds)->where('statut', 'en_attente')->count();
        $revenus = Reservation::whereIn('hotel_id', $hotelIds)->where('statut', 'confirmee')->sum('prix_total');

        return view('hotelier.dashboard', compact('nbHotels', 'nbReservations', 'nbEnAttente', 'revenus'));
    }
}
