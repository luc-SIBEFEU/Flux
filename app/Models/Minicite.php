<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minicite extends Model
{
    protected $fillable = ['bailleur_id', 'nom', 'ville', 'quartier', 'google_map_lien', 'latitude', 'longitude', 'info'];

    public function bailleur() { return $this->belongsTo(User::class, 'bailleur_id'); }
    public function logements() { return $this->hasMany(Logement::class); }
    public function photos() { return $this->morphMany(Photo::class, 'photoable')->orderBy('ordre'); }
}
