<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminContactPaiement;
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

        auth()->user()->adminContactsPaiement()->create($data);

        return back()->with('success', 'Contact de paiement ajouté.');
    }

    public function destroy(AdminContactPaiement $contact)
    {
        abort_unless($contact->admin_id === auth()->id(), 403);
        $contact->delete();

        return back()->with('success', 'Contact supprimé.');
    }
}
