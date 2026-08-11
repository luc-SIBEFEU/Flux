<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AvisHotel;
use App\Models\Hotel;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    public function store(Request $request, Hotel $hotel)
    {
        $data = $request->validate([
            'commentaire' => ['nullable', 'string', 'max:1000'],
            'note' => ['required', 'integer', 'min:0', 'max:10'],
        ]);

        AvisHotel::updateOrCreate(
            ['client_id' => auth()->id(), 'hotel_id' => $hotel->id],
            [...$data, 'statut' => 'en_attente']
        );

        return back()->with('success', 'Avis envoyé, en attente de modération.');
    }
}
