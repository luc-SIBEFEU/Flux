<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelValidationController extends Controller
{
    public function index(Request $request)
    {
        $filtre = $request->input('filtre', 'en_attente');

        $hotels = Hotel::with('hotelier')
            ->when($filtre !== 'tout', fn ($q) => $q->where('statut', $filtre))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.hotels-validation', compact('hotels', 'filtre'));
    }

    public function valider(Hotel $hotel)
    {
        $hotel->update(['statut' => 'valide']);

        return back()->with('success', 'Hôtel validé, il est désormais visible par les visiteurs.');
    }

    public function rejeter(Hotel $hotel)
    {
        $hotel->update(['statut' => 'rejete']);

        return back()->with('success', 'Hôtel rejeté.');
    }
}
