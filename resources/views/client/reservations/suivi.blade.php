@extends('layouts.dashboard')
@php $espaceRole = 'client'; @endphp
@section('titre_page', 'Suivi de séjour')
@section('titre', 'Mon séjour — Mon espace')

@section('contenu')

@php
    $etapes = ['confirmee' => 1, 'terminee' => 2];
    $etapeActuelle = $etapes[$reservation->statut] ?? 0;
@endphp

<div class="bg-white border border-black/10 rounded-2xl overflow-hidden max-w-3xl">
    <img src="{{ asset('storage/'.$reservation->hotel->image_couverture) }}" class="w-full h-52 object-cover">
    <div class="p-6">
        <h2 class="font-display text-2xl">{{ $reservation->hotel->nom }}</h2>
        <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="map-pin" class="w-4 h-4" /> {{ $reservation->hotel->ville }}</p>

        <div class="grid grid-cols-2 gap-4 mt-6">
            <div class="bg-flux-brume rounded-xl p-4">
                <p class="text-xs text-flux-noir/40">Chambre</p>
                <p class="font-medium">{{ $reservation->categorieChambre->nom }}</p>
            </div>
            <div class="bg-flux-brume rounded-xl p-4">
                <p class="text-xs text-flux-noir/40">Période</p>
                <p class="font-medium">{{ $reservation->date_arrivee->format('d/m/Y') }} → {{ $reservation->date_depart->format('d/m/Y') }}</p>
            </div>
        </div>

        <!-- Timeline du séjour -->
        <div class="mt-8">
            <div class="flex items-center">
                @foreach(['Réservation confirmée', "Séjour en cours", 'Séjour terminé'] as $i => $label)
                    <div class="flex-1 flex flex-col items-center text-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold
                                    {{ $i <= $etapeActuelle ? 'bg-flux-bleu text-white' : 'bg-black/10 text-flux-noir/40' }}">
                            {{ $i + 1 }}
                        </div>
                        <p class="text-xs mt-2 max-w-[100px] {{ $i <= $etapeActuelle ? 'text-flux-noir' : 'text-flux-noir/40' }}">{{ $label }}</p>
                    </div>
                    @if(!$loop->last)
                        <div class="flex-1 h-0.5 {{ $i < $etapeActuelle ? 'bg-flux-bleu' : 'bg-black/10' }} -mt-6"></div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="mt-8 flex items-center justify-between border-t border-black/5 pt-5">
            <span class="text-flux-noir/50 text-sm">Montant total</span>
            <span class="font-display text-xl text-flux-bleu">{{ number_format($reservation->prix_total,0,',',' ') }} FCFA</span>
        </div>
    </div>
</div>
@endsection
