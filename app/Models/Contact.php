<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    protected $fillable = [
        'nom',
        'email',
        'type_demande',
        'sujet',
        'message',
        'piece_jointe',
        'reponse',
        'reponse_date',
        'repondu_par',
        'lu',
    ];

    protected $casts = [
        'reponse_date' => 'datetime',
        'lu' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function respondedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'repondu_par');
    }

    public function scopeNonLus($query)
    {
        return $query->where('lu', false);
    }

    public function scopeSansReponse($query)
    {
        return $query->whereNull('reponse');
    }
}
