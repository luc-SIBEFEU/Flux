<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prolongation extends Model
{
    protected $fillable = ['baye_id', 'duree_supplementaire_mois', 'nouvelle_date_fin_prevue', 'statut'];
    protected $casts = ['nouvelle_date_fin_prevue' => 'date'];

    public function baye() { return $this->belongsTo(Baye::class); }
}
