<?php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Models\CommentaireLogement;

class CommentaireController extends Controller
{
    public function index()
    {
        $logementIds = auth()->user()->logements()->pluck('id');
        $commentaires = CommentaireLogement::whereIn('logement_id', $logementIds)
            ->when(request('logement_id'), fn ($q, $v) => $q->where('logement_id', $v))
            ->when(request('note_min'), fn ($q, $v) => $q->where('note', '>=', $v))
            ->with(['client', 'logement'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $logements = auth()->user()->logements;

        return view('bailleur.commentaires.index', compact('commentaires', 'logements'));
    }
}
