<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forfait extends Model
{
    protected $fillable = ['code', 'nom', 'type', 'periodicite', 'duree_jours', 'prix', 'description', 'actif'];
    protected $casts = ['prix' => 'decimal:2', 'actif' => 'boolean'];

    public function abonnements() { return $this->hasMany(Abonnement::class); }
    public function utilisateurs() { return $this->hasMany(User::class); }

    public function estFree(): bool { return $this->type === 'free'; }
    public function estPro(): bool { return $this->type === 'pro'; }

    public static function free(): self
    {
        return static::where('code', 'free')->firstOrFail();
    }
}
