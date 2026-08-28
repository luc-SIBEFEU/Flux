<?php

namespace Database\Seeders;

use App\Models\Forfait;
use Illuminate\Database\Seeder;

class ForfaitsSeeder extends Seeder
{
    public function run(): void
    {
        Forfait::firstOrCreate(['code' => 'free'], [
            'nom' => 'Free',
            'type' => 'free',
            'periodicite' => 'aucune',
            'duree_jours' => null,
            'prix' => 0,
            'description' => "Ajoutez vos hôtels/logements et soyez visible sur Flux. Le client vous contacte directement (pas de réservation ni de paiement en ligne).",
            'actif' => true,
        ]);

        Forfait::firstOrCreate(['code' => 'pro_mensuel'], [
            'nom' => 'Pro mensuel',
            'type' => 'pro',
            'periodicite' => 'mensuel',
            'duree_jours' => 30,
            'prix' => 15000,
            'description' => 'Réservation et paiement en ligne (AangaraaPay), gestion des bayes, reversement automatique vers votre contact de paiement.',
            'actif' => true,
        ]);

        Forfait::firstOrCreate(['code' => 'pro_annuel'], [
            'nom' => 'Pro annuel',
            'type' => 'pro',
            'periodicite' => 'annuel',
            'duree_jours' => 365,
            'prix' => 150000,
            'description' => 'Toutes les fonctionnalités du forfait pro mensuel, facturées une fois par an (2 mois offerts).',
            'actif' => true,
        ]);
    }
}
