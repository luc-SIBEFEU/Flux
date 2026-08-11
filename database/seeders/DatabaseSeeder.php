<?php

namespace Database\Seeders;

use App\Models\Equipement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Compte admin — aucune vue publique ne permet de créer un admin,
        // ce seeder est le seul moyen d'en obtenir un. On marque l'e-mail comme
        // vérifié directement puisqu'il ne passe pas par le flux d'inscription.
        User::firstOrCreate(
            ['email' => 'admin@flux.cm'],
            [
                'nom' => 'Administrateur Flux',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'actif' => true,
                'statut_validation' => 'non_requis',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email'=> 'client@flux.test'],
            [
                'nom' => 'client test',
                'password' => Hash::make('password'),
                'role' => 'client',
                'actif' => true,
                'statut_validation'=> 'non_requis',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email'=> 'hotelier@flux.test'],
            [
                'nom' => 'hotelier test',
                'password' => Hash::make('password'),
                'role' => 'hotelier',
                'actif' => true,
                'statut_validation'=> 'non_requis',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email'=> 'bailleur@flux.test'],
            [
                'nom' => 'bailleur test',
                'password' => Hash::make('password'),
                'role' => 'bailleur',
                'actif' => true,
                'statut_validation'=> 'non_requis',
                'email_verified_at' => now(),
            ]
        );
        // Référentiel d'équipements partagé hôtels / logements
        $equipements = [
            ['nom' => 'Wifi', 'contexte' => 'les_deux'],
            ['nom' => 'Piscine', 'contexte' => 'hotel'],
            ['nom' => 'Climatisation', 'contexte' => 'les_deux'],
            ['nom' => 'Parking', 'contexte' => 'les_deux'],
            ['nom' => 'Petit-déjeuner inclus', 'contexte' => 'hotel'],
            ['nom' => 'Salle de sport', 'contexte' => 'hotel'],
            ['nom' => 'Douche interne', 'contexte' => 'logement'],
            ['nom' => 'Eau courante', 'contexte' => 'logement'],
            ['nom' => 'Cuisine équipée', 'contexte' => 'logement'],
            ['nom' => 'Gardiennage', 'contexte' => 'les_deux'],
            ['nom' => 'Groupe électrogène', 'contexte' => 'les_deux'],
            ['nom' => 'Meublé', 'contexte' => 'logement'],
        ];

        foreach ($equipements as $eq) {
            Equipement::firstOrCreate(['nom' => $eq['nom']], $eq);
        }
    }
}
