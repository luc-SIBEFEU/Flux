<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $fillable = [
        'user_id', 'titre', 'contenu', 'image', 'ville', 'categorie', 'visible', 'expire_le',
    ];

    protected $casts = [
        'visible' => 'boolean',
        'expire_le' => 'date',
    ];

    public function auteur() { return $this->belongsTo(User::class, 'user_id'); }

    public function scopeVisibles($query)
    {
        return $query->where('visible', true)
            ->where(fn ($q) => $q->whereNull('expire_le')->orWhere('expire_le', '>=', now()->toDateString()));
    }

    public function estExpiree(): bool
    {
        return $this->expire_le !== null && $this->expire_le->isPast();
    }
}
