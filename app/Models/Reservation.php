<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Reservation extends Model
{
    protected $fillable = [
        'client_id', 'hotel_id', 'room_category_id', 'telephone_client',
        'date_debut', 'date_fin', 'nombre_adultes', 'nombre_enfants',
        'prix_total', 'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
            'prix_total' => 'decimal:2',
        ];
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function scopeParStatut($query, ?string $statut)
    {
        return $query->when($statut && $statut !== 'tout', fn ($q) => $q->where('statut', $statut));
    }

    public function nombreNuits(): int
    {
        return (int) Carbon::parse($this->date_debut)->diffInDays(Carbon::parse($this->date_fin));
    }

    public static function calculerPrixTotal(RoomCategory $roomCategory, string $dateDebut, string $dateFin): float
    {
        $nuits = max(1, Carbon::parse($dateDebut)->diffInDays(Carbon::parse($dateFin)));

        return (float) $roomCategory->prix_nuit * $nuits;
    }
}
