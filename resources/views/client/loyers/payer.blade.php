@extends('layouts.dashboard')
@php $espaceRole = 'client'; @endphp
@section('titre_page', 'Payer le loyer')
@section('titre', 'Paiement — Mon espace')

@section('contenu')

<div class="max-w-md">
    <div class="bg-white border border-black/10 rounded-2xl p-6 mb-6">
        <p class="text-xs text-flux-noir/40">Loyer de</p>
        <p class="font-medium">{{ \Carbon\Carbon::parse($loyer->mois_concerne)->translatedFormat('F Y') }} — {{ $loyer->baye->logement->quartier }}</p>
        <p class="font-display text-3xl text-flux-violet mt-2">{{ number_format($loyer->montant,0,',',' ') }} FCFA</p>
    </div>

    {{-- TODO: brancher l'API aangaraa-pay.com ; ce formulaire déclenche Client\LoyerController::payer --}}
    <form action="#" method="POST" class="bg-white border border-black/10 rounded-2xl p-6 space-y-4">
        @csrf
        <label class="text-xs font-medium text-flux-noir/50">Méthode de paiement</label>
        <div class="grid grid-cols-2 gap-3">
            <label>
                <input type="radio" name="methode" value="mtn_momo" class="peer sr-only" checked>
                <div class="text-center py-3 rounded-lg border border-black/10 peer-checked:bg-flux-violet peer-checked:text-white peer-checked:border-flux-violet cursor-pointer text-sm font-medium">MTN MoMo</div>
            </label>
            <label>
                <input type="radio" name="methode" value="orange_money" class="peer sr-only">
                <div class="text-center py-3 rounded-lg border border-black/10 peer-checked:bg-flux-violet peer-checked:text-white peer-checked:border-flux-violet cursor-pointer text-sm font-medium">Orange Money</div>
            </label>
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">Numéro</label>
            <input type="tel" name="numero" required placeholder="+237 6XX XXX XXX" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-violet">
        </div>
        <button type="submit" class="w-full bg-flux-or hover:bg-flux-or-vif text-flux-noir font-semibold py-3 rounded-lg transition-colors">
            Payer {{ number_format($loyer->montant,0,',',' ') }} FCFA
        </button>
    </form>
</div>
@endsection
