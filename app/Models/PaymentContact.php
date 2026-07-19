<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentContact extends Model
{
    protected $fillable = ['hotelier_id', 'mtn_momo_numero', 'orange_money_numero'];

    public function hotelier()
    {
        return $this->belongsTo(User::class, 'hotelier_id');
    }
}
