@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-900 mb-1">Finaliser votre paiement</h1>
    <p class="text-gray-500 mb-6">Réservation #{{ $payment->reservation_id }} — {{ $payment->reservation->hotel->nom }}</p>

    @php
        $contact = $payment->reservation->hotel->hotelier->paymentContact;
        $numero = $payment->methode === 'mtn_momo' ? $contact->mtn_momo_numero ?? null : $contact->orange_money_numero ?? null;
        $libelleOperateur = $payment->methode === 'mtn_momo' ? 'MTN Mobile Money' : 'Orange Money';
        $codeUssd = $payment->methode === 'mtn_momo' ? '*126#' : '#150#';
    @endphp

    <div class="bg-white rounded-xl shadow border border-gray-100 p-6 space-y-5">
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-sm text-amber-800">
            Le paiement automatique n'est pas encore actif pour cet hôtel. Merci d'effectuer
            le transfert vous-même, puis de renseigner la référence reçue par SMS ci-dessous.
        </div>

        <div class="text-center bg-gray-50 rounded-lg p-5">
            <p class="text-xs text-gray-500 uppercase mb-1">Montant à envoyer</p>
            <p class="text-3xl font-bold text-violet-700">{{ number_format($payment->montant, 0) }} FCFA</p>
        </div>

        <div class="space-y-2 text-sm text-gray-700">
            <p>1. Composez <span class="font-semibold">{{ $codeUssd }}</span> ({{ $libelleOperateur }}) sur votre téléphone.</p>
            <p>2. Envoyez le montant ci-dessus au numéro :
                <span class="font-semibold text-gray-900">{{ $numero ?? "non renseigné par l'hôtelier — contactez-le directement" }}</span>
            </p>
            <p>3. Vous recevrez un SMS de confirmation avec une référence de transaction.</p>
            <p>4. Renseignez cette référence ci-dessous pour que l'hôtelier valide votre réservation.</p>
        </div>

        @if($payment->preuve_paiement)
            <div class="bg-green-50 text-green-700 text-sm rounded-lg p-3">
                Référence déjà envoyée : <strong>{{ $payment->preuve_paiement }}</strong> — en attente de confirmation par l'hôtelier.
            </div>
        @else
        <form method="POST" action="{{ route('paiement.preuve', $payment) }}" class="space-y-3">
            @csrf
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Référence de transaction reçue par SMS</label>
                <input type="text" name="preuve_paiement" placeholder="ex: MP240719.1234.A56789" class="w-full mt-1 rounded-lg border-gray-300">
                @error('preuve_paiement') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="w-full py-3 bg-violet-700 hover:bg-violet-800 text-white font-semibold rounded-lg transition">
                Envoyer ma référence de paiement
            </button>
        </form>
        @endif

        <a href="{{ route('client.reservations.index') }}" class="block text-center text-sm text-violet-700 hover:underline">
            Retour à mes réservations
        </a>
    </div>
</div>
@endsection
