<?php

namespace App\Http\Controllers;

use App\Models\CategorieChambre;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create(CategorieChambre $categorieChambre)
    {
        abort_if(auth()->guest(), 403, 'Connectez-vous pour réserver.');

        $categorieChambre->load('hotel');

        return view('hotels.reserver', [
            'categorieChambre' => $categorieChambre,
            'hotel' => $categorieChambre->hotel,
        ]);
    }

    public function store(Request $request, CategorieChambre $categorieChambre)
    {
        abort_if(auth()->guest(), 403);

        $data = $request->validate([
            'telephone_client' => ['required', 'string', 'max:30'],
            'date_arrivee' => ['required', 'date', 'after_or_equal:today'],
            'date_depart' => ['required', 'date', 'after:date_arrivee'],
            'nombre_adultes' => ['required', 'integer', 'min:1', 'max:' . $categorieChambre->capacite_adultes],
            'nombre_enfants' => ['nullable', 'integer', 'min:0', 'max:' . $categorieChambre->capacite_enfants],
        ]);

        $nuits = \Carbon\Carbon::parse($data['date_arrivee'])->diffInDays($data['date_depart']);

        $reservation = Reservation::create([
            ...$data,
            'client_id' => auth()->id(),
            'hotel_id' => $categorieChambre->hotel_id,
            'categorie_chambre_id' => $categorieChambre->id,
            'nombre_enfants' => $data['nombre_enfants'] ?? 0,
            'prix_total' => $nuits * $categorieChambre->prix_nuit,
            'statut' => 'en_attente',
        ]);

        // Redirection vers le paiement (MTN MoMo / Orange Money via aangaraa-pay.com)
        return redirect()->route('paiements.formulaire', ['reservation', $reservation->id]);
    }
}
