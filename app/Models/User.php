<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom', 'email', 'password', 'role', 'avatar',
        'telephone', 'genre', 'actif',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'actif' => 'boolean',
        ];
    }

    // --- Rôles ---
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isHotelier(): bool
    {
        return $this->role === 'hotelier';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    // --- Relations ---
    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'hotelier_id');
    }

    public function actualites()
    {
        return $this->hasMany(Actualite::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class, 'client_id');
    }

    public function hotelsFavoris()
    {
        return $this->belongsToMany(Hotel::class, 'favoris', 'client_id', 'hotel_id')->withTimestamps();
    }

    public function paymentContact()
    {
        return $this->hasOne(PaymentContact::class, 'hotelier_id');
    }

    public function avatarUrl(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->nom) . '&background=6d28d9&color=fff';
    }
}
