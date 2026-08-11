<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class HotelsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fr_FR');
        $now = now();

        $hotelier = User::firstOrCreate(
            ['email' => 'hotelier@flux.test'],
            [
                'nom' => 'Hotelier Seed',
                'password' => bcrypt('password'),
                'role' => 'hotelier',
                'actif' => true,
                'statut_validation' => 'valide',
                'email_verified_at' => $now,
            ]
        );

        $hotelsData = [
            [
                'nom' => 'Hotel Luxury',
                'description' => 'Hôtel 5 étoiles avec spa, restaurant gastronomique et service de conciergerie 24h/24.',
                'adresse' => '123 Avenue des Champs-Élysées',
                'ville' => 'Paris',
                'nombre_etoiles' => 5,
                'note_moyenne' => 4.9,
                'image_couverture' => 'https://images.unsplash.com/photo-1501117716987-c8e9d8a2c18f?auto=format&fit=crop&w=1200&q=80',
                'statut' => 'valide',
                'categories' => [
                    ['nom' => 'Chambre Standard', 'capacite_adultes' => 2, 'capacite_enfants' => 0, 'prix_nuit' => 320, 'nombre_disponible' => 5, 'description' => 'Chambre élégante et lumineuse avec un grand lit double.'],
                    ['nom' => 'Chambre Supérieure', 'capacite_adultes' => 2, 'capacite_enfants' => 1, 'prix_nuit' => 420, 'nombre_disponible' => 4, 'description' => 'Plus d’espace, un coin salon et une vue partielle sur la ville.'],
                    ['nom' => 'Suite Deluxe', 'capacite_adultes' => 3, 'capacite_enfants' => 1, 'prix_nuit' => 610, 'nombre_disponible' => 3, 'description' => 'Suite spacieuse avec salon séparé et services premium.'],
                    ['nom' => 'Suite Familiale', 'capacite_adultes' => 4, 'capacite_enfants' => 2, 'prix_nuit' => 780, 'nombre_disponible' => 2, 'description' => 'Idéal pour les familles, avec deux chambres et un espace repas.'],
                ],
                'reseaux' => [
                    ['plateforme' => 'instagram', 'lien' => 'https://www.instagram.com/hotel_luxury'],
                    ['plateforme' => 'facebook', 'lien' => 'https://www.facebook.com/hotel_luxury'],
                ],
                'contacts' => [
                    ['type' => 'mtn_momo', 'numero' => '699123456', 'nom_titulaire' => 'Hotel Luxury'],
                    ['type' => 'orange_money', 'numero' => '650987654', 'nom_titulaire' => 'Hotel Luxury'],
                ],
            ],
            [
                'nom' => 'Hotel Confort',
                'description' => 'Hôtel 3 étoiles confortable et accessible, parfait pour un séjour d’affaires ou de tourisme.',
                'adresse' => '45 Rue de la Paix',
                'ville' => 'Lyon',
                'nombre_etoiles' => 3,
                'note_moyenne' => 4.5,
                'image_couverture' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80',
                'statut' => 'valide',
                'categories' => [
                    ['nom' => 'Chambre Standard', 'capacite_adultes' => 2, 'capacite_enfants' => 0, 'prix_nuit' => 140, 'nombre_disponible' => 8, 'description' => 'Chambre simple, propre et confortable.'],
                    ['nom' => 'Chambre Supérieure', 'capacite_adultes' => 2, 'capacite_enfants' => 1, 'prix_nuit' => 190, 'nombre_disponible' => 5, 'description' => 'Chambre plus spacieuse avec coin bureau.'],
                    ['nom' => 'Suite Familiale', 'capacite_adultes' => 4, 'capacite_enfants' => 2, 'prix_nuit' => 260, 'nombre_disponible' => 2, 'description' => 'Espace familial avec deux lits et rangement.'],
                ],
                'reseaux' => [
                    ['plateforme' => 'facebook', 'lien' => 'https://www.facebook.com/hotel_confort'],
                    ['plateforme' => 'site_web', 'lien' => 'https://hotelconfort.example.com'],
                ],
                'contacts' => [
                    ['type' => 'mtn_momo', 'numero' => '699223344', 'nom_titulaire' => 'Hotel Confort'],
                ],
            ],
            [
                'nom' => 'Hotel Budget',
                'description' => 'Hôtel économique avec les équipements essentiels pour un séjour pratique et sans surprise.',
                'adresse' => '789 Boulevard des Alpes',
                'ville' => 'Grenoble',
                'nombre_etoiles' => 2,
                'note_moyenne' => 4.2,
                'image_couverture' => 'https://images.unsplash.com/photo-1475855581690-80accde3ae2b?auto=format&fit=crop&w=1200&q=80',
                'statut' => 'valide',
                'categories' => [
                    ['nom' => 'Chambre Standard', 'capacite_adultes' => 2, 'capacite_enfants' => 0, 'prix_nuit' => 90, 'nombre_disponible' => 10, 'description' => 'Petit prix, bien situé et propre.'],
                    ['nom' => 'Chambre Supérieure', 'capacite_adultes' => 2, 'capacite_enfants' => 1, 'prix_nuit' => 120, 'nombre_disponible' => 6, 'description' => 'Plus d’espace et vue sur la ville.'],
                ],
                'reseaux' => [
                    ['plateforme' => 'whatsapp', 'lien' => 'https://wa.me/237699334455'],
                ],
                'contacts' => [
                    ['type' => 'orange_money', 'numero' => '670112233', 'nom_titulaire' => 'Hotel Budget'],
                ],
            ],
            [
                'nom' => 'Hotel Riviera',
                'description' => 'Hôtel bord de mer offrant une vue sur la Méditerranée et un accès direct à la plage.',
                'adresse' => '12 Promenade de la Croisette',
                'ville' => 'Cannes',
                'nombre_etoiles' => 4,
                'note_moyenne' => 4.7,
                'image_couverture' => 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?auto=format&fit=crop&w=1200&q=80',
                'statut' => 'valide',
                'categories' => [
                    ['nom' => 'Chambre Supérieure', 'capacite_adultes' => 2, 'capacite_enfants' => 1, 'prix_nuit' => 280, 'nombre_disponible' => 5, 'description' => 'Chambre avec balcon et vue mer.'],
                    ['nom' => 'Suite Deluxe', 'capacite_adultes' => 3, 'capacite_enfants' => 1, 'prix_nuit' => 420, 'nombre_disponible' => 3, 'description' => 'Suite avec salon, terrasse et vue sur la plage.'],
                ],
                'reseaux' => [
                    ['plateforme' => 'instagram', 'lien' => 'https://www.instagram.com/hotel_riviera'],
                    ['plateforme' => 'tiktok', 'lien' => 'https://www.tiktok.com/@hotel_riviera'],
                ],
                'contacts' => [
                    ['type' => 'mtn_momo', 'numero' => '699445566', 'nom_titulaire' => 'Hotel Riviera'],
                    ['type' => 'orange_money', 'numero' => '650556677', 'nom_titulaire' => 'Hotel Riviera'],
                ],
            ],
            [
                'nom' => 'Hotel Montagne',
                'description' => 'Hôtel de montagne idéal pour les amateurs de nature, avec espace détente et  randonnées à proximité.',
                'adresse' => '567 Chemin de la Vallée',
                'ville' => 'Chamonix',
                'nombre_etoiles' => 4,
                'note_moyenne' => 4.6,
                'image_couverture' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80',
                'statut' => 'valide',
                'categories' => [
                    ['nom' => 'Chambre Standard', 'capacite_adultes' => 2, 'capacite_enfants' => 1, 'prix_nuit' => 180, 'nombre_disponible' => 4, 'description' => 'Chambre cosy avec vue sur la montagne.'],
                    ['nom' => 'Suite Famille', 'capacite_adultes' => 4, 'capacite_enfants' => 2, 'prix_nuit' => 320, 'nombre_disponible' => 2, 'description' => 'Suite spacieuse pour les familles avec cheminée.'],
                ],
                'reseaux' => [
                    ['plateforme' => 'facebook', 'lien' => 'https://www.facebook.com/hotel_montagne'],
                ],
                'contacts' => [
                    ['type' => 'mtn_momo', 'numero' => '699778899', 'nom_titulaire' => 'Hotel Montagne'],
                ],
            ],
        ];

        foreach ($hotelsData as $hotelData) {
            $categories = $hotelData['categories'];
            $reseaux = $hotelData['reseaux'];
            $contacts = $hotelData['contacts'];

            unset($hotelData['categories'], $hotelData['reseaux'], $hotelData['contacts']);

            $hotel = Hotel::updateOrCreate(
                ['nom' => $hotelData['nom']],
                array_merge($hotelData, ['hotelier_id' => $hotelier->id])
            );

            DB::table('categorie_chambres')->where('hotel_id', $hotel->id)->delete();
            DB::table('hotel_reseaux_sociaux')->where('hotel_id', $hotel->id)->delete();
            DB::table('hotel_contact_paiements')->where('hotel_id', $hotel->id)->delete();

            $categoryRows = [];
            foreach ($categories as $category) {
                $categoryRows[] = array_merge($category, [
                    'hotel_id' => $hotel->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
            DB::table('categorie_chambres')->insert($categoryRows);

            $socialRows = [];
            foreach ($reseaux as $reseau) {
                $socialRows[] = array_merge($reseau, [
                    'hotel_id' => $hotel->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
            DB::table('hotel_reseaux_sociaux')->insert($socialRows);

            $contactRows = [];
            foreach ($contacts as $contact) {
                $contactRows[] = array_merge($contact, [
                    'hotel_id' => $hotel->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
            DB::table('hotel_contact_paiements')->insert($contactRows);
        }
    }
}
