@extends('layouts.app')
@section('titre', __('paiement.titre') . ' — Flux')

@section('contenu')


<div class="max-w-md mx-auto px-4 py-16">
    <h1 class="font-display text-3xl text-flux-noir mb-2">{{ __('paiement.titre') }}</h1>
    <p class="text-flux-noir/50 text-sm mb-8">
        @if($type === 'reservation')
            {{ __('paiement.reservation_a', ['hotel' => $payable->hotel->nom]) }}
        @elseif($type === 'abonnement')
            {{ __('paiement.forfait_x', ['nom' => $payable->forfait->nom]) }}
        @else
            {{ __('paiement.loyer_de', ['mois' => \Carbon\Carbon::parse($payable->mois_concerne)->translatedFormat('F Y')]) }}
        @endif
    </p>

    @php
        $montantAffiche = match($type) {
            'reservation' => $payable->prix_total,
            'abonnement' => $payable->forfait->prix,
            default => $payable->montant,
        };
    @endphp
    <div class="bg-white border border-black/10 rounded-2xl p-6 mb-6">
        <p class="text-xs text-flux-noir/40 uppercase tracking-wide">{{ __('paiement.montant_a_payer') }}</p>
        <p class="font-display text-4xl text-flux-bleu mt-1">
            {{ number_format($montantAffiche, 0, ',', ' ') }} FCFA
        </p>
    </div>

    <form action="{{ route('paiements.initier', [$type, $payable->id]) }}" method="POST" class="bg-white border border-black/10 rounded-2xl p-6 space-y-4">
        @csrf
        <label class="text-xs font-medium text-flux-noir/50">{{ __('paiement.numero_momo') }}</label>
        <div class="flex items-center gap-2 border border-black/10 rounded-lg px-3 py-2.5">
            <x-icon name="phone" class="w-4 h-4 text-flux-bleu shrink-0" />
            <input type="tel" name="telephone" required value="{{ $payable->telephone_client ?? auth()->user()->telephone }}" class="w-full outline-none text-sm">
        </div>
        <p class="text-xs text-flux-noir/40">{{ __('paiement.operateur_detecte') }}</p>

        <button type="submit" class="w-full bg-flux-or hover:bg-flux-or-vif text-flux-noir font-semibold py-3 rounded-lg transition-colors">
            {{ __('paiement.payer_maintenant') }}
        </button>
    </form>
</div>
@endsection
