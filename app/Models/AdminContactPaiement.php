<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminContactPaiement extends Model
{
    protected $table = 'admin_contact_paiements';
    protected $fillable = ['admin_id', 'type', 'numero', 'nom_titulaire'];

    public function admin() { return $this->belongsTo(User::class, 'admin_id'); }
}
