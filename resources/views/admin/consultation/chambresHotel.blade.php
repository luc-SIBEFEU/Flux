@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', $hotel->nom)
@section('titre', $hotel->nom . ' — Consultation admin')

@section('contenu')
<span class="text-sm text-flux-noir/50">consultation ></span>
<a href="{{ route('admin.consultation.hotels') }}" class="text-sm text-flux-noir/50 hover:text-flux-bleu">hotels ></a>
<a href="{{ route('admin.consultation.hotels.show', ['hotel'=>$hotel, 'action'=>$action='consultation']) }}" class="text-sm text-flux-noir/50 hover:text-flux-bleu">hotel {{ $hotel->nom }}</a> > {{ $chambre->nom }}

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h2 class="font-display text-2xl">{{ $hotel->nom }}</h2>
            <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="map-pin" class="w-4 h-4" /> {{ $hotel->ville }}, {{ $hotel->adresse }}</p>
            <p class="text-sm text-flux-noir/50 mt-2">{{ $hotel->description }}</p>
        </div>
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h2 class="font-display text-2xl">{{ $chambre->nom }}</h2>
            <p class="text-sm font-medium text-flux-bleu flex items-center gap-1 mt-1"> {{ number_format($chambre->prix_nuit,0,',',' ') }} FCFA/nuit</p>
            <p class="text-sm text-flux-noir/50 mt-2">{{ $chambre->capacite_adultes }} Adultes, {{ $chambre->capacite_enfants }} Enfants</p>
        </div>
        @if($hotel->statut == 'valide')
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-4">Dernières réservations ({{ $chambre->reservations->count() }})</h3>
            <div class="divide-y divide-black/5">
                @forelse($chambre->reservations->take(10) as $r)
                    <div class="flex items-center justify-between py-3 text-sm">
                        <span>{{ $r->client->nom }} — {{ $r->date_arrivee->format('d/m/Y') }}</span>
                        <span class="font-medium">{{ number_format($r->prix_total,0,',',' ') }} F</span>
                    </div>
                @empty
                    <p class="text-sm text-flux-noir/40 py-3">Aucune réservation.</p>
                @endforelse
            </div>
        </div>
        @endif
    </div>
    <div class="bg-white border border-black/10 rounded-2xl p-6">
    <h2 class="font-display text-2xl">Galerie Photo</h2>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-10 rounded-2xl overflow-hidden">
        @foreach($chambre->photos->take(4) as $photo)
            <img src="{{ asset('storage/'.$photo->chemin) }}" class="w-full h-full object-cover min-h-[105px]">
        @endforeach
    </div>
    </div>
</div>
@endsection
