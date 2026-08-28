<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfert extends Model
{
    protected $fillable = [
        'paiement_id', 'beneficiaire_id', 'montant', 'type_contact',
        'numero_destinataire', 'statut', 'reference_retrait', 'traite_le', 'notes',
    ];
    protected $casts = ['montant' => 'decimal:2', 'traite_le' => 'datetime'];

    public function paiement() { return $this->belongsTo(Paiement::class); }
    public function beneficiaire() { return $this->belongsTo(User::class, 'beneficiaire_id'); }

    public function marquerEffectue(): void
    {
        $this->update(['statut' => 'effectue', 'traite_le' => now()]);
    }

    /** Aucun contact de paiement enregistré -> le retrait automatique n'a pas pu être tenté. */
    public function versementAutomatiquePossible(): bool
    {
        return (bool) $this->numero_destinataire;
    }
}
