<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    protected $fillable = ['user_id', 'forfait_id', 'statut', 'date_debut', 'date_fin'];
    protected $casts = ['date_debut' => 'date', 'date_fin' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
    public function forfait() { return $this->belongsTo(Forfait::class); }
    public function paiement() { return $this->morphOne(Paiement::class, 'payable')->latestOfMany(); }
}
