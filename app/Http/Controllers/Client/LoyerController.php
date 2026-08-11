<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Loyer;

class LoyerController extends Controller
{
    /** Redirige vers le paiement unifié (MTN MoMo / Orange Money via aangaraa-pay.com). */
    public function payer(Loyer $loyer)
    {
        abort_unless($loyer->baye->client_id === auth()->id(), 403);

        return redirect()->route('paiements.formulaire', ['loyer', $loyer->id]);
    }
}
