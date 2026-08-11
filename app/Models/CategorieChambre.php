<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorieChambre extends Model
{
    protected $fillable = ['hotel_id', 'nom', 'capacite_adultes', 'capacite_enfants', 'prix_nuit', 'nombre_disponible', 'description'];

    public function hotel() { return $this->belongsTo(Hotel::class); }
    public function equipements() { return $this->belongsToMany(Equipement::class, 'categorie_chambre_equipement'); }
    public function reservations() { return $this->hasMany(Reservation::class); }
    public function photos() { return $this->morphMany(Photo::class, 'photoable')->orderBy('ordre'); }
}
