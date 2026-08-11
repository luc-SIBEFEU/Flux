<?php

namespace App\Console\Commands;

use App\Mail\ProformaReservationMail;
use App\Mail\ReservationTermineeMail;
use App\Models\Reservation;
use App\Services\ProformaService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TerminerSejoursExpires extends Command
{
    protected $signature = 'flux:terminer-sejours';
    protected $description = "Clôture les réservations dont la date de départ est passée : génère le pro-forma, notifie l'hôtelier et envoie le pro-forma au client.";

    public function __construct(private ProformaService $proforma)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $reservations = Reservation::where('statut', 'confirmee')
            ->where('date_depart', '<=', now())
            ->with(['hotel.hotelier', 'client', 'categorieChambre'])
            ->get();

        foreach ($reservations as $reservation) {
            $reservation->update(['statut' => 'terminee']);
            $this->proforma->genererReservation($reservation);

            Mail::to($reservation->hotel->hotelier->email)->send(new ReservationTermineeMail($reservation));
            Mail::to($reservation->client->email)->send(new ProformaReservationMail($reservation->fresh()));

            $this->info("Réservation #{$reservation->id} clôturée.");
        }

        $this->info("{$reservations->count()} séjour(s) traité(s).");

        return self::SUCCESS;
    }
}
