<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['client_id', 'hotel_id', 'note', 'commentaire', 'statut'];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    protected static function booted(): void
    {
        // recalcule automatiquement la note de l'hôtel après tout changement d'avis
        static::saved(fn (Review $review) => $review->hotel->recalculerNote());
        static::deleted(fn (Review $review) => $review->hotel->recalculerNote());
    }
}
