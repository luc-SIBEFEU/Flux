<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvisHotel;

class AvisController extends Controller
{
    public function index()
    {
        $avis = AvisHotel::where('statut', 'en_attente')
            ->when(request('note_min'), fn ($q, $v) => $q->where('note', '>=', $v))
            ->with(['client', 'hotel'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.avis.index', compact('avis'));
    }

    public function approuver(AvisHotel $avi)
    {
        $avi->update(['statut' => 'approuve']);
        $avi->hotel->recalculerNoteMoyenne();
        return back()->with('success', 'Avis approuvé.');
    }

    public function rejeter(AvisHotel $avi)
    {
        $avi->update(['statut' => 'rejete']);
        return back()->with('success', 'Avis rejeté.');
    }
}
