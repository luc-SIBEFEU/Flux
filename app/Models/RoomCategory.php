<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
    protected $fillable = [
        'hotel_id', 'nom', 'capacite_adultes', 'capacite_enfants',
        'prix_nuit', 'quantite_disponible', 'description', 'actif',
    ];

    protected function casts(): array
    {
        return [
            'prix_nuit' => 'decimal:2',
            'actif' => 'boolean',
        ];
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'amenity_room_category');
    }

    public function galeries()
    {
        return $this->hasMany(RoomGallery::class)->orderBy('ordre');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Vérifie la disponibilité pour une période donnée
     * (en tenant compte du nombre total d'unités de cette catégorie).
     */
    public function estDisponible(string $dateDebut, string $dateFin): bool
    {
        $reservationsChevauchantes = $this->reservations()
            ->where('statut', '!=', 'annulee')
            ->where('date_debut', '<', $dateFin)
            ->where('date_fin', '>', $dateDebut)
            ->count();

        return $reservationsChevauchantes < $this->quantite_disponible;
    }
}
