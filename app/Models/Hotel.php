<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotelier_id', 'nom', 'nombre_etoiles', 'note_moyenne', 'nombre_avis',
        'ville', 'latitude', 'longitude', 'adresse', 'description',
        'image_couverture', 'logo', 'statut',
    ];

    protected function casts(): array
    {
        return [
            'note_moyenne' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    // --- Relations ---
    public function hotelier()
    {
        return $this->belongsTo(User::class, 'hotelier_id');
    }

    public function galeries()
    {
        return $this->hasMany(HotelGallery::class)->orderBy('ordre');
    }

    public function roomCategories()
    {
        return $this->hasMany(RoomCategory::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reviewsApprouves()
    {
        return $this->hasMany(Review::class)->where('statut', 'approuve');
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }

    // --- Scopes ---
    public function scopeValides($query)
    {
        return $query->where('statut', 'valide');
    }

    public function scopeRechercher($query, ?string $ville, ?int $adultes, ?int $enfants)
    {
        return $query->when($ville, fn ($q) => $q->where('ville', 'like', "%{$ville}%"))
            ->when($adultes, function ($q) use ($adultes, $enfants) {
                $q->whereHas('roomCategories', function ($rq) use ($adultes, $enfants) {
                    $rq->where('capacite_adultes', '>=', $adultes)
                        ->where('capacite_enfants', '>=', $enfants ?? 0)
                        ->where('actif', true);
                });
            });
    }

    public function scopeFiltrerEtoiles($query, ?int $etoiles)
    {
        return $query->when($etoiles, fn ($q) => $q->where('nombre_etoiles', '>=', $etoiles));
    }

    public function scopeFiltrerNote($query, ?float $note)
    {
        return $query->when($note, fn ($q) => $q->where('note_moyenne', '>=', $note));
    }

    // --- Helpers ---
    public function imageCouvertureUrl(): ?string
    {
        return $this->image_couverture ? asset('storage/' . $this->image_couverture) : null;
    }

    public function logoUrl(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    /**
     * Recalcule la note moyenne à partir des avis approuvés.
     * À appeler après approbation/rejet/suppression d'un avis.
     */
    public function recalculerNote(): void
    {
        $stats = $this->reviewsApprouves()->selectRaw('AVG(note) as moyenne, COUNT(*) as total')->first();

        $this->update([
            'note_moyenne' => round($stats->moyenne ?? 0, 2),
            'nombre_avis' => $stats->total ?? 0,
        ]);
    }

    public function estFavoriDe(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->favoris()->where('client_id', $user->id)->exists();
    }
}
