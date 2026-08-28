<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageContact extends Model
{
    protected $table = 'messages_contact';
    protected $fillable = ['contactable_id', 'contactable_type', 'client_id', 'destinataire_id', 'telephone_client', 'message', 'lu'];
    protected $casts = ['lu' => 'boolean'];

    public function contactable() { return $this->morphTo(); }
    public function client() { return $this->belongsTo(User::class, 'client_id'); }
    public function destinataire() { return $this->belongsTo(User::class, 'destinataire_id'); }
}
