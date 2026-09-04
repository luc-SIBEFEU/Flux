<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Baye;
use App\Models\Hotel;
use App\Models\Logement;
use App\Models\Reservation;
use App\Models\CategorieChambre;

/**
 * Vues de consultation pour l'admin : accès total en lecture, aucune modification
 * possible (pas de create/update/destroy ici, volontairement).
 */
class SupervisionController extends Controller
{
    public function hotels()
    {
        $hotels = Hotel::with('hotelier')
            ->when(request('statut'), fn ($q, $v) => $q->where('statut', $v))
            ->when(request('ville'), fn ($q, $v) => $q->where('ville', 'like', "%{$v}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $villes = Hotel::distinct()->orderBy('ville')->pluck('ville');

        return view('admin.consultation.hotels', compact('hotels', 'villes'));
    }

    public function hotel(Hotel $hotel, String $action)
    {
        $hotel->load(['hotelier', 'categorieChambres', 'reservations.client', 'avis.client', 'contactsPaiement']);
        return view('admin.consultation.hotel', compact('hotel','action'));
    }
    public function chambresHotel(Hotel $hotel, CategorieChambre $chambre){
        return view('admin.consultation.chambresHotel', compact('hotel','chambre'));
    }
    public function logements()
    {
        $logements = Logement::with('bailleur')
            ->when(request('validation'), fn ($q, $v) => $q->where('validation', $v))
            ->when(request('type'), fn ($q, $v) => $q->where('type', $v))
            ->when(request('ville'), fn ($q, $v) => $q->where('ville', 'like', "%{$v}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $villes = Logement::distinct()->orderBy('ville')->pluck('ville');

        return view('admin.consultation.logements', compact('logements', 'villes'));
    }

    public function logement(Logement $logement)
    {
        $logement->load(['bailleur', 'minicite', 'bayes.client', 'commentaires.client']);
        return view('admin.consultation.logement', compact('logement'));
    }

    public function bayes()
    {
        $bayes = Baye::with(['client', 'bailleur', 'logement'])
            ->when(request('statut'), fn ($q, $v) => $q->where('statut', $v))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.consultation.bayes', compact('bayes'));
    }

    public function baye(Baye $baye)
    {
        $baye->load(['client', 'bailleur', 'logement', 'loyers', 'prolongations']);
        return view('admin.consultation.baye', compact('baye'));
    }

    public function reservations()
    {
        $reservations = Reservation::with(['client', 'hotel', 'categorieChambre'])
            ->when(request('statut'), fn ($q, $v) => $q->where('statut', $v))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.consultation.reservations', compact('reservations'));
    }

    public function reservation(Reservation $reservation)
    {
        $reservation->load(['client', 'hotel', 'categorieChambre', 'paiement']);
        return view('admin.consultation.reservation', compact('reservation'));
    }
}
