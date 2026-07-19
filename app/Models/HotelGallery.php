<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelGallery extends Model
{
    protected $fillable = ['hotel_id', 'image', 'ordre'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function imageUrl(): string
    {
        return asset('storage/' . $this->image);
    }
}
