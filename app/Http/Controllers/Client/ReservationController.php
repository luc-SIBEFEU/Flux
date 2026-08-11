<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    // Vue avec onglets : tout, en attente, confirmés, annulés (voir resources/views/client/reservations/index.blade.php)
    public function index()
    {
        $statut = request('statut', 'tout');

        $reservations = auth()->user()->reservations()
            ->when($statut !== 'tout', fn ($q) => $q->where('statut', $statut))
            ->with(['hotel', 'categorieChambre', 'paiement'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('client.reservations.index', compact('reservations', 'statut'));
    }

    /** Suivi du séjour une fois la réservation confirmée. */
    public function suivi(\App\Models\Reservation $reservation)
    {
        abort_unless($reservation->client_id === auth()->id(), 403);
        return view('client.reservations.suivi', compact('reservation'));
    }
}
