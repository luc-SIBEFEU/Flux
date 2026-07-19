<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $onglet = $request->input('onglet', 'tout');

        $reservations = Reservation::with(['hotel', 'roomCategory', 'payment'])
            ->where('client_id', Auth::id())
            ->parStatut($onglet)
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('client.reservations.index', compact('reservations', 'onglet'));
    }

    public function annuler(Reservation $reservation)
    {
        abort_unless($reservation->client_id === Auth::id(), 403);

        if ($reservation->statut === 'en_attente') {
            $reservation->update(['statut' => 'annulee']);
        }

        return back()->with('success', 'Réservation annulée.');
    }
}
