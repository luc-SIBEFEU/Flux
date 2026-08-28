<?php

namespace App\Console\Commands;

use App\Models\Transfert;
use App\Services\TransfertService;
use Illuminate\Console\Command;

class VerifierTransfertsEnCours extends Command
{
    protected $signature = 'flux:verifier-transferts';
    protected $description = "Interroge AangaraaPay pour les retraits (reversements hôtelier/bailleur) restés en attente côté opérateur.";

    public function __construct(private TransfertService $transferts)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $enCours = Transfert::where('statut', 'en_cours')->get();

        foreach ($enCours as $transfert) {
            $this->transferts->verifierStatut($transfert);
        }

        $this->info("{$enCours->count()} transfert(s) vérifié(s).");

        return self::SUCCESS;
    }
}
