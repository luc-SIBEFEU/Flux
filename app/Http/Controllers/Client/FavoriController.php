<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Favori;
use Illuminate\Support\Facades\Auth;

class FavoriController extends Controller
{
    public function index()
    {
        $hotels = Auth::user()->hotelsFavoris()->with('hotelier')->get();

        return view('client.favoris', compact('hotels'));
    }

    public function destroy(int $hotelId)
    {
        Favori::where('client_id', Auth::id())->where('hotel_id', $hotelId)->delete();

        return back();
    }
}
