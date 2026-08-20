<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'hotelier_id', 'nom', 'nombre_etoiles', 'note_moyenne', 'ville', 'adresse',
        'map', 'image_couverture', 'description', 'statut', 'motif_rejet',
    ];

    public function hotelier() { return $this->belongsTo(User::class, 'hotelier_id'); }
    public function categorieChambres() { return $this->hasMany(CategorieChambre::class); }
    public function reseauxSociaux() { return $this->hasMany(HotelReseauSocial::class); }
    public function contactsPaiement() { return $this->hasMany(HotelContactPaiement::class); }
    public function avis() { return $this->hasMany(AvisHotel::class); }
    public function avisApprouves() { return $this->hasMany(AvisHotel::class)->where('statut', 'approuve'); }
    public function reservations() { return $this->hasMany(Reservation::class); }
    public function photos() { return $this->morphMany(Photo::class, 'photoable')->orderBy('ordre'); }

    public function scopeValides($query) { return $query->where('statut', 'valide'); }

    public function recalculerNoteMoyenne(): void
    {
        $this->update(['note_moyenne' => $this->avisApprouves()->avg('note') ?? 0]);
    }
}
