<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Compte admin par défaut
        User::updateOrCreate(
            ['email' => 'admin@hotelbooking.test'],
            [
                'nom' => 'Administrateur',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'actif' => true,
            ]
        );

        // Équipements de base pour les chambres
        $amenities = ['Wifi', 'Piscine', 'Climatisation', 'Parking', 'Petit-déjeuner inclus', 'Télévision', 'Room service', 'Salle de sport'];
        foreach ($amenities as $nom) {
            Amenity::firstOrCreate(['nom' => $nom]);
        }

        // Un hôtelier de démonstration
        User::updateOrCreate(
            ['email' => 'hotelier@hotelbooking.test'],
            [
                'nom' => 'Hôtelier Démo',
                'password' => Hash::make('password'),
                'role' => 'hotelier',
                'telephone' => '690000000',
                'actif' => true,
            ]
        );

        // Un client de démonstration
        User::updateOrCreate(
            ['email' => 'client@hotelbooking.test'],
            [
                'nom' => 'Client Démo',
                'password' => Hash::make('password'),
                'role' => 'client',
                'telephone' => '691111111',
                'actif' => true,
            ]
        );
    }
}
