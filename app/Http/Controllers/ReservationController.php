<?php

namespace App\Http\Controllers;

use App\Mail\ReservationProforma;
use App\Models\Hotel;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\RoomCategory;
use App\Services\PaymentManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function create(Request $request)
    {
        $hotel = Hotel::findOrFail($request->query('hotel'));
        $chambre = RoomCategory::where('hotel_id', $hotel->id)->findOrFail($request->query('chambre'));

        $dateDebut = $request->query('date_debut', now()->format('Y-m-d'));
        $dateFin = $request->query('date_fin', now()->addDay()->format('Y-m-d'));
        $adultes = (int) $request->query('adultes', 1);
        $enfants = (int) $request->query('enfants', 0);

        $prixTotal = ($dateFin > $dateDebut)
            ? Reservation::calculerPrixTotal($chambre, $dateDebut, $dateFin)
            : null;

        return view('public.reservations.create', compact(
            'hotel', 'chambre', 'dateDebut', 'dateFin', 'adultes', 'enfants', 'prixTotal'
        ));
    }

    public function store(Request $request, PaymentManager $paiements)
    {
        $hotel = Hotel::findOrFail($request->input('hotel_id'));
        $chambre = RoomCategory::where('hotel_id', $hotel->id)->findOrFail($request->input('room_category_id'));

        $data = $request->validate([
            'telephone_client' => 'required|string|max:20',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
            'adultes' => 'required|integer|min:1|max:' . $chambre->capacite_adultes,
            'enfants' => 'nullable|integer|min:0|max:' . $chambre->capacite_enfants,
            'methode_paiement' => 'required|in:mtn_momo,orange_money',
            'telephone_paiement' => 'required|string|max:20',
        ]);

        if (! $chambre->estDisponible($data['date_debut'], $data['date_fin'])) {
            return back()->withInput()->withErrors([
                'date_debut' => "Cette catégorie de chambre n'est plus disponible pour cette période.",
            ]);
        }

        $prixTotal = Reservation::calculerPrixTotal($chambre, $data['date_debut'], $data['date_fin']);

        $reservation = Reservation::create([
            'client_id' => Auth::id(),
            'hotel_id' => $hotel->id,
            'room_category_id' => $chambre->id,
            'telephone_client' => $data['telephone_client'],
            'date_debut' => $data['date_debut'],
            'date_fin' => $data['date_fin'],
            'nombre_adultes' => $data['adultes'],
            'nombre_enfants' => $data['enfants'] ?? 0,
            'prix_total' => $prixTotal,
            'statut' => 'en_attente',
        ]);

        $payment = Payment::create([
            'reservation_id' => $reservation->id,
            'methode' => $data['methode_paiement'],
            'telephone_paiement' => $data['telephone_paiement'],
            'montant' => $prixTotal,
            'statut' => 'initie',
        ]);

        // Envoie la facture pro-forma au client dès la validation de la réservation
        Mail::to(Auth::user()->email)->send(new ReservationProforma($reservation));

        // Bascule automatiquement entre API réelle (MTN/Orange) et mode manuel
        // selon que les clés API soient configurées ou non.
        $resultat = $paiements->initier($payment);

        // Orange Money en mode API redirige vers la page de paiement Orange
        if ($resultat['mode'] === 'api' && $payment->methode === 'orange_money' && ! empty($resultat['payment_url'])) {
            return redirect()->away($resultat['payment_url']);
        }

        // Mode manuel : on affiche les instructions + le formulaire de preuve de paiement
        if ($resultat['mode'] === 'manuel') {
            return redirect()->route('paiement.instructions', $payment)
                ->with('success', "Réservation créée. Un pro-forma vous a été envoyé par email. Suivez les instructions ci-dessous pour finaliser le paiement.");
        }

        // MTN MoMo en mode API : le client reçoit un prompt sur son téléphone
        return redirect()->route('client.reservations.index')
            ->with('success', 'Réservation créée. Un pro-forma vous a été envoyé par email. Confirmez le paiement reçu sur votre téléphone.');
    }
}
