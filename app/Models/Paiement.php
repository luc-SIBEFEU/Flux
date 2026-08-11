<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'payable_id', 'payable_type', 'user_id', 'montant', 'methode',
        'numero_expediteur', 'reference_transaction', 'statut', 'reponse_api',
    ];
    protected $casts = ['reponse_api' => 'array'];

    public function payable() { return $this->morphTo(); }
    public function user() { return $this->belongsTo(User::class); }
}
