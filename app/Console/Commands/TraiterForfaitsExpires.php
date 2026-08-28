<?php

namespace App\Console\Commands;

use App\Services\ForfaitService;
use Illuminate\Console\Command;

class TraiterForfaitsExpires extends Command
{
    protected $signature = 'flux:traiter-forfaits';
    protected $description = "Repasse en forfait free les comptes hôtelier/bailleur dont le forfait pro (payé ou essai) est arrivé à échéance sans renouvellement.";

    public function __construct(private ForfaitService $forfaits)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $nombre = $this->forfaits->traiterExpirations();
        $this->info("{$nombre} compte(s) repassé(s) en forfait free.");

        return self::SUCCESS;
    }
}
