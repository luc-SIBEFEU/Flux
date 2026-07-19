<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $filtre = $request->input('filtre', 'en_attente');

        $reviews = Review::with(['client', 'hotel'])
            ->when($filtre !== 'tout', fn ($q) => $q->where('statut', $filtre))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.reviews', compact('reviews', 'filtre'));
    }

    public function approuver(Review $review)
    {
        $review->update(['statut' => 'approuve']);

        return back()->with('success', 'Avis approuvé.');
    }

    public function rejeter(Review $review)
    {
        $review->update(['statut' => 'rejete']);

        return back()->with('success', 'Avis rejeté.');
    }
}
