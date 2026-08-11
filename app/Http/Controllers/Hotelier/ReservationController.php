<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index()
    {
        $hotelIds = auth()->user()->hotels()->pluck('id');

        $reservations = Reservation::whereIn('hotel_id', $hotelIds)
            ->when(request('statut'), fn ($q, $v) => $q->where('statut', $v))
            ->with(['client', 'hotel', 'categorieChambre'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('hotelier.reservations.index', compact('reservations'));
    }

    public function confirmer(Reservation $reservation)
    {
        $this->authorizeHotelier($reservation);
        $reservation->update(['statut' => 'confirmee']);
        return back()->with('success', 'Réservation confirmée.');
    }

    public function annuler(Reservation $reservation)
    {
        $this->authorizeHotelier($reservation);
        $reservation->update(['statut' => 'annulee']);
        return back()->with('success', 'Réservation annulée.');
    }

    private function authorizeHotelier(Reservation $reservation): void
    {
        abort_unless($reservation->hotel->hotelier_id === auth()->id(), 403);
    }
}
