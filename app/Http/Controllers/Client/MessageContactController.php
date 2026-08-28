<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Logement;
use App\Models\MessageContact;
use App\Services\NotificationDashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageContactController extends Controller
{
    public function __construct(private NotificationDashboardService $notifications)
    {
    }

    /** Fiche hôtel : contacter l'hôtelier (hôtel non réservable en ligne, forfait free). */
    public function contacterHotel(Request $request, Hotel $hotel)
    {
        $this->enregistrer($request, $hotel, $hotel->hotelier_id);

        return back()->with('success', "Votre message a été envoyé à l'hôtelier.");
    }

    /** Fiche logement : contacter le bailleur (gestion des bayes non active, forfait free). */
    public function contacterLogement(Request $request, Logement $logement)
    {
        $this->enregistrer($request, $logement, $logement->bailleur_id);

        return back()->with('success', 'Votre message a été envoyé au bailleur.');
    }

    private function enregistrer(Request $request, $contactable, int $destinataireId): void
    {
        $data = $request->validate([
            'telephone_client' => ['required', 'string', 'max:30'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $message = MessageContact::create([
            'contactable_id' => $contactable->id,
            'contactable_type' => get_class($contactable),
            'client_id' => auth()->id(),
            'destinataire_id' => $destinataireId,
            'telephone_client' => $data['telephone_client'],
            'message' => $data['message'],
        ]);
        $message->load('client', 'destinataire', 'contactable');

        Mail::to($message->destinataire->email)->send(new \App\Mail\MessageContactMail($message));
        $this->notifications->messageContactRecu($message);
    }
}
