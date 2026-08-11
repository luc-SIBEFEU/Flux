<?php

namespace App\Console\Commands;

use App\Mail\BayeTermineMail;
use App\Mail\ProformaBayeMail;
use App\Models\Baye;
use App\Services\ProformaService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TraiterBauxExpires extends Command
{
    protected $signature = 'flux:traiter-baux';
    protected $description = "Termine les baux dont le moratoire est écoulé (le logement redevient visible), et met à jour les retards de paiement des baux en cours.";

    public function __construct(private ProformaService $proforma)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $termines = 0;

        // 1) Baux dont le moratoire est écoulé : le logement est libéré.
        $bauxExpires = Baye::where('statut', 'en_cours')
            ->whereNotNull('date_fin_moratoire')
            ->where('date_fin_moratoire', '<', now())
            ->with(['logement', 'client', 'bailleur', 'loyers'])
            ->get();

        foreach ($bauxExpires as $baye) {
            $baye->update(['statut' => 'termine']);
            $this->proforma->genererBaye($baye);

            // Le logement redevient directement visible sur le site.
            $baye->logement->update(['statut' => 'disponible']);

            Mail::to($baye->bailleur->email)->send(new BayeTermineMail($baye));
            Mail::to($baye->client->email)->send(new ProformaBayeMail($baye->fresh(['loyers'])));

            $termines++;
            $this->info("Bail #{$baye->id} terminé, logement #{$baye->logement_id} de nouveau disponible.");
        }

        // 2) Baux en cours dont au moins un loyer est en retard : met à jour l'état de paiement.
        $bauxActifs = Baye::whereIn('statut', ['nouveau', 'en_cours'])->with('loyers')->get();
        foreach ($bauxActifs as $baye) {
            $enRetard = $baye->loyers->contains(fn ($l) => $l->statut !== 'paye' && $l->date_echeance->isPast());
            $etat = $enRetard ? 'en_retard' : ($baye->loyers->every(fn ($l) => $l->statut === 'paye') ? 'solde' : 'a_jour');
            if ($baye->etat_paiement !== $etat) {
                $baye->update(['etat_paiement' => $etat]);
            }
        }

        $this->info("{$termines} bail(s) terminé(s) et libéré(s).");

        return self::SUCCESS;
    }
}
