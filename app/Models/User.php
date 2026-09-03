<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nom', 'email', 'password', 'telephone', 'avatar', 'genre', 'role', 'actif', 'locale',
        'code_verification', 'code_expire_a', 'statut_validation', 'motif_rejet_compte',
        'forfait_id', 'forfait_expire_le', 'essai_pro_utilise',
    ];
    protected $hidden = ['password', 'remember_token', 'code_verification'];
    protected $casts = [
        'actif' => 'boolean', 'email_verified_at' => 'datetime', 'code_expire_a' => 'datetime',
        'forfait_expire_le' => 'date', 'essai_pro_utilise' => 'boolean',
    ];

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
    public function adminContactsPaiement() { return $this->hasMany(AdminContactPaiement::class, 'admin_id'); }
    public function forfait() { return $this->belongsTo(Forfait::class); }
    public function abonnements() { return $this->hasMany(Abonnement::class); }
    public function messagesContactRecus() { return $this->hasMany(MessageContact::class, 'destinataire_id'); }
    public function transferts() { return $this->hasMany(Transfert::class, 'beneficiaire_id'); }
    public function annonces() { return $this->hasMany(Annonce::class); }

    /**
     * Uniquement pertinent pour hotelier/bailleur. Un utilisateur sans forfait_id
     * (comptes créés avant la migration, ou admin/client) est traité comme "free".
     */
    public function estEnForfaitPro(): bool
    {
        if (! $this->forfait || ! $this->forfait->estPro()) {
            return false;
        }

        // Pas de date de fin = anomalie -> on considère le forfait pro comme expiré
        // plutôt que de laisser un accès pro non borné.
        return $this->forfait_expire_le && now()->toDateString() <= $this->forfait_expire_le->toDateString();
    }

    public function estEnEssaiPro(): bool
    {
        if (! $this->estEnForfaitPro()) {
            return false;
        }

        $dernier = $this->abonnements()->latest('date_debut')->first();

        return $dernier && $dernier->statut === 'essai';
    }

    public function peutDemarrerEssaiPro(): bool
    {
        return ! $this->essai_pro_utilise && (! $this->forfait || $this->forfait->estFree());
    }

    /** Réservation en ligne / paiement / gestion des bayes : réservé au forfait pro. */
    public function peutUtiliserFonctionsPro(): bool
    {
        return $this->estEnForfaitPro();
    }
}
