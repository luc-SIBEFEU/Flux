<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logement extends Model
{
    protected $fillable = [
        'bailleur_id', 'minicite_id', 'logement_modele_id', 'type', 'categorie', 'ville', 'quartier',
        'google_map_lien', 'latitude', 'longitude', 'prix_mois', 'caution', 'duree_min_mois',
        'moratoire_jours', 'info', 'statut', 'validation', 'motif_rejet',
    ];

    /** Une villa est toujours meublée, quel que soit ce qui a été soumis. */
    public function setCategorieAttribute($value): void
    {
        $this->attributes['categorie'] = ($this->type ?? $this->attributes['type'] ?? null) === 'villa' ? 'meuble' : $value;
    }

    public function setTypeAttribute($value): void
    {
        $this->attributes['type'] = $value;
        if ($value === 'villa') {
            $this->attributes['categorie'] = 'meuble';
        }
    }

    public function bailleur() { return $this->belongsTo(User::class, 'bailleur_id'); }
    public function minicite() { return $this->belongsTo(Minicite::class); }
    public function modele() { return $this->belongsTo(Logement::class, 'logement_modele_id'); }
    public function equipements() { return $this->belongsToMany(Equipement::class, 'logement_equipement'); }
    public function photos() { return $this->morphMany(Photo::class, 'photoable')->orderBy('ordre'); }
    public function demandesBaye() { return $this->hasMany(DemandeBaye::class); }
    public function bayes() { return $this->hasMany(Baye::class); }
    public function commentaires() { return $this->hasMany(CommentaireLogement::class); }

    /** Visible publiquement : disponible ET validé par l'admin. */
    public function scopeDisponibles($query)
    {
        return $query->where('statut', 'disponible')->where('validation', 'valide');
    }

    /** Genere $nombre exemplaires de ce logement (utilise pour les mini-cites). */
    public static function genererGroupe(array $donnees, int $nombre): \Illuminate\Support\Collection
    {
        $modele = static::create($donnees);
        $clones = collect([$modele]);
        for ($i = 1; $i < $nombre; $i++) {
            $clones->push(static::create(array_merge($donnees, ['logement_modele_id' => $modele->id])));
        }
        return $clones;
    }
}
