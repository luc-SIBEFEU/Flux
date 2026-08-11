<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\LogementRejeteMail;
use App\Mail\LogementValideMail;
use App\Models\Logement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LogementValidationController extends Controller
{
    public function index()
    {
        $logements = Logement::where('validation', 'en_attente')->with('bailleur')->latest()->paginate(10);
        return view('admin.logements.index', compact('logements'));
    }

    public function approuver(Logement $logement)
    {
        $logement->update(['validation' => 'valide', 'motif_rejet' => null]);
        Mail::to($logement->bailleur->email)->send(new LogementValideMail($logement));

        return back()->with('success', 'Logement validé et visible sur le site.');
    }

    public function rejeter(Request $request, Logement $logement)
    {
        $data = $request->validate(['motif_rejet' => ['required', 'string', 'max:500']]);
        $logement->update(['validation' => 'rejete', ...$data]);
        Mail::to($logement->bailleur->email)->send(new LogementRejeteMail($logement));

        return back()->with('success', 'Logement rejeté.');
    }
}
