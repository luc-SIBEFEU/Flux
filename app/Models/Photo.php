<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['photoable_id', 'photoable_type', 'chemin', 'est_couverture', 'ordre'];
    protected $casts = ['est_couverture' => 'boolean'];

    public function photoable() { return $this->morphTo(); }
}
