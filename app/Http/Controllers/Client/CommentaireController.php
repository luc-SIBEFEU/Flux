<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CommentaireLogement;
use App\Models\Logement;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    public function store(Request $request, Logement $logement)
    {
        $data = $request->validate([
            'commentaire' => ['nullable', 'string', 'max:1000'],
            'note' => ['required', 'integer', 'min:0', 'max:10'],
        ]);

        CommentaireLogement::create([...$data, 'client_id' => auth()->id(), 'logement_id' => $logement->id]);

        return back()->with('success', 'Commentaire publié.');
    }
}
