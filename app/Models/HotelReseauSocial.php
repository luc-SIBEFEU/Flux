<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelReseauSocial extends Model
{
    protected $table = 'hotel_reseaux_sociaux';
    protected $fillable = ['hotel_id', 'plateforme', 'lien'];

    public function hotel() { return $this->belongsTo(Hotel::class); }
}
