@extends('layouts.app')
@section('titre', 'Paiement — Flux')

@section('contenu')


<div class="max-w-md mx-auto px-4 py-16">
    <h1 class="font-display text-3xl text-flux-noir mb-2">Paiement</h1>
    <p class="text-flux-noir/50 text-sm mb-8">
        @if($type === 'reservation')
            Réservation à {{ $payable->hotel->nom }}
        @elseif($type === 'abonnement')
            Forfait {{ $payable->forfait->nom }}
        @else
            Loyer de {{ \Carbon\Carbon::parse($payable->mois_concerne)->translatedFormat('F Y') }}
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
        <p class="text-xs text-flux-noir/40 uppercase tracking-wide">Montant à payer</p>
        <p class="font-display text-4xl text-flux-bleu mt-1">
            {{ number_format($montantAffiche, 0, ',', ' ') }} FCFA
        </p>
    </div>

    <form action="{{ route('paiements.initier', [$type, $payable->id]) }}" method="POST" class="bg-white border border-black/10 rounded-2xl p-6 space-y-4">
        @csrf
        <label class="text-xs font-medium text-flux-noir/50">Numéro Mobile Money (MTN ou Orange)</label>
        <div class="flex items-center gap-2 border border-black/10 rounded-lg px-3 py-2.5">
            <x-icon name="phone" class="w-4 h-4 text-flux-bleu shrink-0" />
            <input type="tel" name="telephone" required value="{{ $payable->telephone_client ?? auth()->user()->telephone }}" class="w-full outline-none text-sm">
        </div>
        <p class="text-xs text-flux-noir/40">L'opérateur (MTN ou Orange) est détecté automatiquement à partir du numéro.</p>

        <button type="submit" class="w-full bg-flux-or hover:bg-flux-or-vif text-flux-noir font-semibold py-3 rounded-lg transition-colors">
            Payer maintenant
        </button>
    </form>
</div>
@endsection
