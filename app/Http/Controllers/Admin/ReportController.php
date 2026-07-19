<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateDebut = $request->input('date_debut', now()->startOfMonth()->format('Y-m-d'));
        $dateFin = $request->input('date_fin', now()->endOfMonth()->format('Y-m-d'));

        $totalGeneral = Reservation::where('statut', 'confirmee')
            ->whereBetween('date_debut', [$dateDebut, $dateFin])
            ->sum('prix_total');

        $parHotel = Hotel::query()
            ->withSum(['reservations as total_confirme' => function ($q) use ($dateDebut, $dateFin) {
                $q->where('statut', 'confirmee')->whereBetween('date_debut', [$dateDebut, $dateFin]);
            }], 'prix_total')
            ->withCount(['reservations as nb_reservations' => function ($q) use ($dateDebut, $dateFin) {
                $q->where('statut', 'confirmee')->whereBetween('date_debut', [$dateDebut, $dateFin]);
            }])
            ->having('total_confirme', '>', 0)
            ->orderByDesc('total_confirme')
            ->get();

        return view('admin.reports', compact('totalGeneral', 'parHotel', 'dateDebut', 'dateFin'));
    }
}
