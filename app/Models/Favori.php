<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    protected $fillable = ['client_id', 'hotel_id'];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
