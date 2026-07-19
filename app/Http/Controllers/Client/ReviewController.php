<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Hotel $hotel)
    {
        $avisExistant = Review::where('client_id', Auth::id())->where('hotel_id', $hotel->id)->first();

        return view('client.review-form', compact('hotel', 'avisExistant'));
    }

    public function store(Request $request, Hotel $hotel)
    {
        $data = $request->validate([
            'note' => 'required|integer|min:0|max:10',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            ['client_id' => Auth::id(), 'hotel_id' => $hotel->id],
            ['note' => $data['note'], 'commentaire' => $data['commentaire'] ?? null, 'statut' => 'en_attente']
        );

        return redirect()->route('hotels.show', $hotel)
            ->with('success', 'Votre avis a été soumis et sera visible après modération.');
    }
}
