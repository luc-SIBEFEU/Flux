<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class ReseauSocialController extends Controller
{
    public function store(Request $request, Hotel $hotel)
    {
        abort_unless($hotel->hotelier_id === auth()->id(), 403);

        $data = $request->validate([
            'plateforme' => ['required', 'in:facebook,instagram,tiktok,whatsapp,x,web,autre'],
            'lien' => ['required', 'url'],
        ]);

        $hotel->reseauxSociaux()->create($data);

        return back()->with('success', 'Réseau social ajouté.');
    }

    public function destroy(Hotel $hotel, \App\Models\HotelReseauSocial $reseau)
    {
        abort_unless($hotel->hotelier_id === auth()->id(), 403);
        $reseau->delete();
        return back()->with('success', 'Réseau social supprimé.');
    }
}
