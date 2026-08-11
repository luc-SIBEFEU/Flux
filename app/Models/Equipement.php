<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    protected $fillable = ['nom', 'icone', 'contexte'];

    public function categorieChambres() { return $this->belongsToMany(CategorieChambre::class, 'categorie_chambre_equipement'); }
    public function logements() { return $this->belongsToMany(Logement::class, 'logement_equipement'); }
}
