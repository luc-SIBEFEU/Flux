<?php

namespace App\Services;

use App\Models\Baye;
use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

/**
 * Génère les pro-formas PDF envoyés au client (et accessibles à l'hôtelier/bailleur)
 * une fois un séjour ou une location terminée.
 */
class ProformaService
{
    public function genererReservation(Reservation $reservation): string
    {
        $reservation->load(['hotel', 'categorieChambre', 'client']);

        $localeOriginale = app()->getLocale();
        app()->setLocale($reservation->client->locale ?? 'fr');

        $pdf = Pdf::loadView('pdf.proforma-reservation', ['reservation' => $reservation]);

        app()->setLocale($localeOriginale);

        $chemin = "proformas/reservation-{$reservation->id}.pdf";
        Storage::disk('public')->put($chemin, $pdf->output());

        $reservation->update(['proforma_pdf' => $chemin]);

        return $chemin;
    }

    public function genererBaye(Baye $baye): string
    {
        $baye->load(['logement', 'client', 'bailleur', 'loyers']);

        $localeOriginale = app()->getLocale();
        app()->setLocale($baye->client->locale ?? 'fr');

        $pdf = Pdf::loadView('pdf.proforma-baye', ['baye' => $baye]);

        app()->setLocale($localeOriginale);

        $chemin = "proformas/baye-{$baye->id}.pdf";
        Storage::disk('public')->put($chemin, $pdf->output());
        $baye->update(['proforma_pdf' => $chemin]);

        return $chemin;
    }
}
