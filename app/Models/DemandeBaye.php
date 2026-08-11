<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandeBaye extends Model
{
    protected $fillable = [
        'client_id', 'logement_id', 'bailleur_id', 'telephone_client',
        'message', 'duree_souhaitee_mois', 'statut',
    ];

    public function client() { return $this->belongsTo(User::class, 'client_id'); }
    public function logement() { return $this->belongsTo(Logement::class); }
    public function bailleur() { return $this->belongsTo(User::class, 'bailleur_id'); }
    public function baye() { return $this->hasOne(Baye::class); }
}
