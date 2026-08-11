<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\AvisHotel;

class AvisController extends Controller
{
    public function index()
    {
        $hotelIds = auth()->user()->hotels()->pluck('id');
        $avis = AvisHotel::whereIn('hotel_id', $hotelIds)
            ->when(request('hotel_id'), fn ($q, $v) => $q->where('hotel_id', $v))
            ->when(request('note_min'), fn ($q, $v) => $q->where('note', '>=', $v))
            ->with(['client', 'hotel'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $hotels = auth()->user()->hotels;

        return view('hotelier.avis.index', compact('avis', 'hotels'));
    }
}
