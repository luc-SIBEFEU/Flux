@extends('layouts.dashboard')
@php $espaceRole = 'client'; @endphp
@section('titre_page', 'Mes réservations')
@section('titre', 'Mes réservations — Flux')

@section('contenu')

<div class="flex gap-2 mb-6 overflow-x-auto carte-scroll">
    @foreach(['tout'=>'Tout','en_attente'=>'En attente','confirmee'=>'Confirmées','annulee'=>'Annulées'] as $val=>$label)
        <a href="{{ route('client.reservations.index', ['statut'=>$val]) }}"
           class="shrink-0 px-4 py-2 rounded-full text-sm font-medium border
                  {{ $statut === $val ? 'bg-flux-bleu text-white border-flux-bleu' : 'bg-white text-flux-noir/60 border-black/10' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
    @forelse($reservations as $reservation)
        <div class="bg-white border border-black/10 rounded-2xl overflow-hidden">
            <img src="{{ asset('storage/'.$reservation->hotel->image_couverture) }}" class="w-full h-36 object-cover">
            <div class="p-5">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-medium">{{ $reservation->hotel->nom }}</h3>
                    @php
                        $badges = ['en_attente'=>'bg-flux-or/20 text-flux-or','confirmee'=>'bg-flux-bleu-pale text-flux-bleu','annulee'=>'bg-red-50 text-red-500','terminee'=>'bg-black/5 text-flux-noir/50'];
                    @endphp
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $badges[$reservation->statut] ?? '' }}">{{ ucfirst(str_replace('_',' ', $reservation->statut)) }}</span>
                </div>
                <p class="text-sm text-flux-noir/50">{{ $reservation->categorieChambre->nom }}</p>
                <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1">
                    <x-icon name="calendar" class="w-4 h-4" /> {{ $reservation->date_arrivee->format('d/m/Y') }} → {{ $reservation->date_depart->format('d/m/Y') }}
                </p>
                <p class="font-display text-lg text-flux-bleu mt-2">{{ number_format($reservation->prix_total,0,',',' ') }} FCFA</p>

                @php
                    $badgesPaiement = ['en_attente'=>'bg-flux-or/20 text-flux-or','reussi'=>'bg-green-50 text-green-600','echoue'=>'bg-red-50 text-red-500','rembourse'=>'bg-black/5 text-flux-noir/50'];
                @endphp
                <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full font-medium mt-2 {{ $badgesPaiement[$reservation->statut_paiement] ?? '' }}">
                    Paiement : {{ ucfirst(str_replace('_',' ', $reservation->statut_paiement)) }}
                </span>

                @if($reservation->peutReessayerPaiement())
                    <a href="{{ route('paiements.formulaire', ['reservation', $reservation->id]) }}"
                       class="mt-3 flex items-center justify-center gap-2 text-sm font-medium text-white bg-red-500 rounded-lg py-2">
                        Réessayer le paiement
                    </a>
                @endif

                @if($reservation->statut === 'confirmee')
                    <a href="{{ route('client.reservations.suivi', $reservation) }}" class="mt-3 inline-flex items-center gap-2 text-sm font-medium text-flux-bleu hover:underline">
                        Suivre mon séjour →
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16 text-flux-noir/40">
            <x-icon name="calendar" class="w-10 h-10 mx-auto mb-3" />
            Aucune réservation dans cette catégorie.
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $reservations->links() }}</div>
@endsection
