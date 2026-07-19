<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\PaymentContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentContactController extends Controller
{
    public function edit()
    {
        $contact = Auth::user()->paymentContact;

        return view('hotelier.payment-contacts', compact('contact'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'mtn_momo_numero' => 'nullable|string|max:20',
            'orange_money_numero' => 'nullable|string|max:20',
        ]);

        PaymentContact::updateOrCreate(['hotelier_id' => Auth::id()], $data);

        return back()->with('success', 'Contacts de paiement enregistrés.');
    }
}
