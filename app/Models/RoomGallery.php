<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomGallery extends Model
{
    protected $fillable = ['room_category_id', 'image', 'ordre'];

    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class);
    }

    public function imageUrl(): string
    {
        return asset('storage/' . $this->image);
    }
}
