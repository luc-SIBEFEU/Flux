<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = ['nom', 'icone'];

    public function roomCategories()
    {
        return $this->belongsToMany(RoomCategory::class, 'amenity_room_category');
    }
}
