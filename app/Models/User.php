<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nom', 'email', 'password', 'telephone', 'avatar', 'genre', 'role', 'actif',
        'code_verification', 'code_expire_a', 'statut_validation', 'motif_rejet_compte',
    ];
    protected $hidden = ['password', 'remember_token', 'code_verification'];
    protected $casts = ['actif' => 'boolean', 'email_verified_at' => 'datetime', 'code_expire_a' => 'datetime'];

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isHotelier(): bool { return $this->role === 'hotelier'; }
    public function isClient(): bool { return $this->role === 'client'; }
    public function isBailleur(): bool { return $this->role === 'bailleur'; }

    /** Un hôtelier/bailleur ne peut se connecter qu'une fois validé par l'admin ET actif. */
    public function peutSeConnecter(): bool
    {
        if (! $this->actif) {
            return false;
        }

        return $this->statut_validation === 'non_requis' || $this->statut_validation === 'valide';
    }

    public function hotels() { return $this->hasMany(Hotel::class, 'hotelier_id'); }
    public function reservations() { return $this->hasMany(Reservation::class, 'client_id'); }
    public function avisHotels() { return $this->hasMany(AvisHotel::class, 'client_id'); }
    public function favoris() { return $this->belongsToMany(Hotel::class, 'favoris', 'client_id', 'hotel_id'); }
    public function minicites() { return $this->hasMany(Minicite::class, 'bailleur_id'); }
    public function logements() { return $this->hasMany(Logement::class, 'bailleur_id'); }
    public function demandesBayeEnvoyees() { return $this->hasMany(DemandeBaye::class, 'client_id'); }
    public function demandesBayeRecues() { return $this->hasMany(DemandeBaye::class, 'bailleur_id'); }
    public function bayesLocataire() { return $this->hasMany(Baye::class, 'client_id'); }
    public function bayesBailleur() { return $this->hasMany(Baye::class, 'bailleur_id'); }
    public function bailleurContactsPaiement() { return $this->hasMany(BailleurContactPaiement::class, 'bailleur_id'); }
}
