<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Baye extends Model
{
    protected $fillable = [
        'demande_baye_id', 'client_id', 'logement_id', 'bailleur_id',
        'date_debut', 'duree_mois', 'date_fin_prevue', 'date_fin_moratoire', 'statut', 'etat_paiement', 'proforma_pdf',
    ];
    protected $casts = ['date_debut' => 'date', 'date_fin_prevue' => 'date', 'date_fin_moratoire' => 'date'];

    public function demande() { return $this->belongsTo(DemandeBaye::class, 'demande_baye_id'); }
    public function client() { return $this->belongsTo(User::class, 'client_id'); }
    public function logement() { return $this->belongsTo(Logement::class); }
    public function bailleur() { return $this->belongsTo(User::class, 'bailleur_id'); }
    public function loyers() { return $this->hasMany(Loyer::class); }
    public function prolongations() { return $this->hasMany(Prolongation::class); }

    /** Le bail (moratoire inclus) est-il expiré ? */
    public function estExpireAvecMoratoire(): bool
    {
        return $this->date_fin_moratoire && now()->greaterThan($this->date_fin_moratoire);
    }
}
