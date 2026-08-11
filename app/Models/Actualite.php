<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actualite extends Model
{
    protected $fillable = ['nom', 'description', 'date_debut', 'date_fin', 'image', 'cree_par', 'ordre'];
    protected $casts = ['date_debut' => 'date', 'date_fin' => 'date'];

    public function scopeEnCours($query)
    {
        return $query->where('date_debut', '<=', now())->where('date_fin', '>=', now());
    }

    public function scopeOrdonnees($query)
    {
        return $query->orderBy('ordre')->orderByDesc('date_debut');
    }
}
