<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loyer extends Model
{
    protected $fillable = ['baye_id', 'mois_concerne', 'montant', 'date_echeance', 'statut', 'date_paiement', 'paiement_initial'];
    protected $casts = ['mois_concerne' => 'date', 'date_echeance' => 'date', 'date_paiement' => 'datetime', 'paiement_initial' => 'boolean'];

    public function baye() { return $this->belongsTo(Baye::class); }
    public function paiement() { return $this->morphOne(Paiement::class, 'payable')->latestOfMany(); }
}
