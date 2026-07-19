<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'nbClients' => User::where('role', 'client')->count(),
            'nbHoteliers' => User::where('role', 'hotelier')->count(),
            'nbHotels' => Hotel::count(),
            'nbHotelsEnAttente' => Hotel::where('statut', 'en_attente')->count(),
            'nbReservations' => Reservation::count(),
            'nbAvisEnAttente' => Review::where('statut', 'en_attente')->count(),
            'chiffreAffaires' => Reservation::where('statut', 'confirmee')->sum('prix_total'),
        ]);
    }
}
