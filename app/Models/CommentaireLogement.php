<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentaireLogement extends Model
{
    protected $fillable = ['client_id', 'logement_id', 'commentaire', 'note'];

    public function client() { return $this->belongsTo(User::class, 'client_id'); }
    public function logement() { return $this->belongsTo(Logement::class); }
}
