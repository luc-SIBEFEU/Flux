@extends('layouts.hotelier')

@section('content')
<div class="p-6 max-w-lg">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Contacts de paiement</h1>
    <p class="text-sm text-gray-500 mb-6">Ces numéros reçoivent les notifications de paiement pour vos réservations (via MTN MoMo et Orange Money).</p>

    <form method="POST" action="{{ route('hotelier.payment-contacts.update') }}" class="bg-white rounded-xl shadow border border-gray-100 p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase">🟡 Numéro MTN MoMo</label>
            <input type="text" name="mtn_momo_numero" value="{{ old('mtn_momo_numero', $contact->mtn_momo_numero ?? '') }}" placeholder="ex: 6XX XXX XXX" class="w-full mt-1 rounded-lg border-gray-300">
        </div>
        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase">🟠 Numéro Orange Money</label>
            <input type="text" name="orange_money_numero" value="{{ old('orange_money_numero', $contact->orange_money_numero ?? '') }}" placeholder="ex: 6XX XXX XXX" class="w-full mt-1 rounded-lg border-gray-300">
        </div>
        <button type="submit" class="px-4 py-2 bg-violet-700 text-white rounded-lg font-semibold">Enregistrer</button>
    </form>
</div>
@endsection
