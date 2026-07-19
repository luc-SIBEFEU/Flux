<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'reservation_id', 'methode', 'mode', 'telephone_paiement', 'montant',
        'reference_transaction', 'preuve_paiement', 'statut', 'reponse_api',
        'confirme_par_id', 'confirme_le',
    ];

    protected function casts(): array
    {
        return [
            'montant' => 'decimal:2',
            'reponse_api' => 'array',
            'confirme_le' => 'datetime',
        ];
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function confirmePar()
    {
        return $this->belongsTo(User::class, 'confirme_par_id');
    }
}
