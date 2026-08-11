<?php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactPaiementController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:mtn_momo,orange_money'],
            'numero' => ['required', 'string', 'max:30'],
            'nom_titulaire' => ['nullable', 'string', 'max:255'],
        ]);

        auth()->user()->bailleurContactsPaiement()->create($data);

        return back()->with('success', 'Contact de paiement ajouté.');
    }

    public function destroy(\App\Models\BailleurContactPaiement $contact)
    {
        abort_unless($contact->bailleur_id === auth()->id(), 403);
        $contact->delete();
        return back()->with('success', 'Contact supprimé.');
    }
}
