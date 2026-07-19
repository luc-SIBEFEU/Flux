<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\PaymentManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $statut = $request->input('statut', 'tout');
        $hotelIds = Auth::user()->hotels()->pluck('id');

        $reservations = Reservation::with(['client', 'hotel', 'roomCategory', 'payment'])
            ->whereIn('hotel_id', $hotelIds)
            ->parStatut($statut)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('hotelier.reservations.index', compact('reservations', 'statut'));
    }

    /**
     * L'hôtelier confirme manuellement avoir reçu le paiement sur son propre
     * numéro MoMo/Orange Money (mode manuel uniquement), après vérification
     * de la référence de transaction fournie par le client.
     */
    public function confirmerPaiement(Reservation $reservation, PaymentManager $paiements)
    {
        abort_unless($reservation->hotel->hotelier_id === Auth::id(), 403);

        $payment = $reservation->payment;

        abort_if(! $payment || $payment->mode !== 'manuel', 403, 'Cette réservation ne nécessite pas de confirmation manuelle.');

        $paiements->confirmerManuellement($payment, Auth::id());

        return back()->with('success', 'Paiement confirmé, la réservation est validée.');
    }
}
