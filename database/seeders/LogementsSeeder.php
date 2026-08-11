<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LogementsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        $bailleur = User::firstOrCreate(
            ['email' => 'bailleur-seeder@flux.test'],
            [
                'nom' => 'Bailleur Seeder',
                'password' => bcrypt('password'),
                'role' => 'bailleur',
                'actif' => true,
                'statut_validation' => 'valide',
                'email_verified_at' => now(),
            ]
        );

        $cities = [
            'Douala', 'Yaoundé', 'Bafoussam', 'Kribi', 'Limbe',
            'Garoua', 'Bertoua', 'Edea', 'Maroua', 'Ngaoundéré',
        ];

        $types = ['chambre', 'studio', 'appartement', 'villa'];
        $quartiers = [
            'Bastos', 'Bonapriso', 'Deido', 'Akwa', 'Lambare',
            'Melen', 'Nkolndongo', 'Biyem-Assi', 'Odza', 'Mokolo',
            'Bepanda', 'Makepe', 'Nyalla', 'Essos', 'Messa',
        ];

        $entries = [];

        for ($i = 1; $i <= 40; $i++) {
            $city = $faker->randomElement($cities);
            $type = $faker->randomElement($types);
            $categorie = $type === 'villa' ? 'meuble' : $faker->randomElement(['standard', 'meuble']);
            $quartier = $faker->randomElement($quartiers);
            $adresse = $faker->streetAddress() . ', ' . $quartier . ', ' . $city;
            $prixMois = $faker->numberBetween(30000, 250000);
            $caution = max(0, round($prixMois * $faker->randomFloat(2, 0.3, 0.9), 2));

            $entries[] = [
                'bailleur_id' => $bailleur->id,
                'minicite_id' => null,
                'logement_modele_id' => null,
                'type' => $type,
                'categorie' => $categorie,
                'ville' => $city,
                'quartier' => $quartier,
                'google_map_lien' => 'https://maps.google.com/?q=' . rawurlencode($adresse),
                'latitude' => null,
                'longitude' => null,
                'prix_mois' => $prixMois,
                'caution' => $caution,
                'duree_min_mois' => $faker->numberBetween(1, 3),
                'moratoire_jours' => 7,
                'info' => $faker->sentence(12),
                'statut' => 'disponible',
                'validation' => 'valide',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('logements')->insert($entries);
    }
}
