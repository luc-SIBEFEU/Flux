<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actualite extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'description', 'date_debut', 'date_fin', 'image', 'user_id',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
        ];
    }

    public function auteur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // actualité en cours de validité
    public function scopeEnCours($query)
    {
        return $query->where('date_debut', '<=', now())
            ->where('date_fin', '>=', now());
    }

    public function imageUrl(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
