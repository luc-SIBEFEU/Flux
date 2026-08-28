<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\HotelRejeteMail;
use App\Mail\HotelValideMail;
use App\Models\Hotel;
use App\Services\NotificationDashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HotelValidationController extends Controller
{
    public function __construct(private NotificationDashboardService $notifications)
    {
    }

    public function index()
    {
        $hotels = Hotel::where('statut', 'en_attente')->with('hotelier')->latest()->paginate(10);
        return view('admin.hotels.index', compact('hotels'));
    }

    public function approuver(Hotel $hotel)
    {
        $hotel->update(['statut' => 'valide', 'motif_rejet' => null]);
        Mail::to($hotel->hotelier->email)->send(new HotelValideMail($hotel));
        $this->notifications->hotelValide($hotel);

        return back()->with('success', "Hôtel « {$hotel->nom} » validé et visible sur le site.");
    }

    public function rejeter(Request $request, Hotel $hotel)
    {
        $data = $request->validate(['motif_rejet' => ['required', 'string', 'max:500']]);
        $hotel->update(['statut' => 'rejete', ...$data]);
        Mail::to($hotel->hotelier->email)->send(new HotelRejeteMail($hotel));
        $this->notifications->hotelRejete($hotel);

        return back()->with('success', "Hôtel « {$hotel->nom} » rejeté.");
    }
}
