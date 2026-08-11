<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Hotel;

class FavoriController extends Controller
{
    public function index()
    {
        $favoris = auth()->user()->favoris()
            ->when(request('ville'), fn ($q, $v) => $q->where('ville', 'like', "%{$v}%"))
            ->paginate(9)
            ->withQueryString();

        return view('client.favoris', compact('favoris'));
    }

    public function toggle(Hotel $hotel)
    {
        $user = auth()->user();

        if ($user->favoris()->where('hotel_id', $hotel->id)->exists()) {
            $user->favoris()->detach($hotel->id);
            $message = 'Retiré des favoris.';
        } else {
            $user->favoris()->attach($hotel->id);
            $message = 'Ajouté aux favoris.';
        }

        return back()->with('success', $message);
    }
}
