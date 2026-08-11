<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BailleurContactPaiement extends Model
{
    protected $fillable = ['bailleur_id', 'type', 'numero', 'nom_titulaire'];

    public function bailleur() { return $this->belongsTo(User::class, 'bailleur_id'); }
}
