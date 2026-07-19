<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $actualites = Actualite::enCours()->latest()->take(6)->get();

        $hotelsEnVogue = Hotel::valides()
            ->orderByDesc('note_moyenne')
            ->orderByDesc('nombre_avis')
            ->take(8)
            ->get();

        return view('public.home', compact('actualites', 'hotelsEnVogue'));
    }
}
