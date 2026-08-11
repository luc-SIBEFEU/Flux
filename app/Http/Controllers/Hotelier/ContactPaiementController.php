<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class ContactPaiementController extends Controller
{
    public function store(Request $request, Hotel $hotel)
    {
        abort_unless($hotel->hotelier_id === auth()->id(), 403);

        $data = $request->validate([
            'type' => ['required', 'in:mtn_momo,orange_money'],
            'numero' => ['required', 'string', 'max:30'],
            'nom_titulaire' => ['nullable', 'string', 'max:255'],
        ]);

        $hotel->contactsPaiement()->create($data);

        return back()->with('success', 'Contact de paiement ajouté.');
    }

    public function destroy(Hotel $hotel, \App\Models\HotelContactPaiement $contact)
    {
        abort_unless($hotel->hotelier_id === auth()->id(), 403);
        $contact->delete();
        return back()->with('success', 'Contact supprimé.');
    }
}
