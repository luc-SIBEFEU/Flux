<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'client_id', 'hotel_id', 'categorie_chambre_id', 'telephone_client',
        'date_arrivee', 'date_depart', 'nombre_adultes', 'nombre_enfants', 'prix_total', 'statut', 'proforma_pdf',
    ];
    protected $casts = ['date_arrivee' => 'date', 'date_depart' => 'date'];

    public function client() { return $this->belongsTo(User::class, 'client_id'); }
    public function hotel() { return $this->belongsTo(Hotel::class); }
    public function categorieChambre() { return $this->belongsTo(CategorieChambre::class); }
    public function paiement() { return $this->morphOne(Paiement::class, 'payable'); }
}
