<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelContactPaiement extends Model
{
    protected $fillable = ['hotel_id', 'type', 'numero', 'nom_titulaire'];

    public function hotel() { return $this->belongsTo(Hotel::class); }
}
