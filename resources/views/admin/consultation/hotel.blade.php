@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', $hotel->nom)
@section('titre', $hotel->nom . ' — Consultation admin')

@section('contenu')
<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
        <span class="text-sm text-flux-noir/50">consultation ></span>
        <a href="{{ $action=='consultation' ? route('admin.consultation.hotels'): route('admin.hotels.index') }}" class="text-sm text-flux-noir/50 hover:text-flux-bleu">hotels ></a>hotel {{ $hotel->nom }}
    </div>
@if($hotel->statut=='en_attente')
    <div class="right-4 flex inline-flex items-center gap-2">
        <form class="right-4 flex inline-flex items-center gap-2" action="{{ route('admin.hotels.approuver', $hotel) }}" method="POST">
            @csrf
            <button class="inline-flex items-center gap-1.5 bg-flux-bleu text-white text-sm font-medium px-4 py-2 rounded-lg">
                <x-icon name="check-circle" class="w-4 h-4" /> Approuver
            </button>
        </form>
        <button @click="rejet = !rejet" class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 text-sm font-medium px-4 py-2 rounded-lg">
            <x-icon name="x-circle" class="w-4 h-4" /> Rejeter
        </button>
    </div>
@endif
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h2 class="font-display text-2xl">{{ $hotel->nom }}</h2>
            <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="map-pin" class="w-4 h-4" /> {{ $hotel->ville }}, {{ $hotel->adresse }}</p>
            <p class="text-sm text-flux-noir/50 mt-2">{{ $hotel->description }}</p>
        </div>

        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-4">Catégories de chambres ({{ $hotel->categorieChambres->count() }})</h3>
            <div class="divide-y divide-black/5">
                @foreach($hotel->categorieChambres as $chambre)
                <a href="{{ route('admin.consultation.hotels.chambre.show', ['hotel'=>$hotel,'chambre'=>$chambre]) }}" class="hover:border hover:border-black/10 ">
                    <div class="flex items-center justify-between py-3 text-sm">
                        <span>{{ $chambre->nom }}</span>
                        <span class="font-medium text-flux-bleu">{{ number_format($chambre->prix_nuit,0,',',' ') }} F/nuit</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @if($hotel->statut == 'valide')
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-4">Dernières réservations ({{ $hotel->reservations->count() }})</h3>
            <div class="divide-y divide-black/5">
                @forelse($hotel->reservations->take(10) as $r)
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

    <aside class="space-y-6">
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-3">Hôtelier</h3>
            <p class="text-sm">{{ $hotel->hotelier->nom }}</p>
            <p class="text-sm text-flux-noir/50">{{ $hotel->hotelier->email }}</p>
            <p class="text-sm text-flux-noir/50">{{ $hotel->hotelier->telephone }}</p>
        </div>
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-3">Contacts de paiement</h3>
            @forelse($hotel->contactsPaiement as $c)
                <p class="text-sm text-flux-noir/60">{{ $c->type === 'mtn_momo' ? 'MTN MoMo' : 'Orange Money' }} — {{ $c->numero }}</p>
            @empty
                <p class="text-sm text-flux-noir/40">Aucun contact renseigné.</p>
            @endforelse
        </div> 

        @if($hotel->map)
            <iframe class="bg-white border border-black/10 rounded-2xl w-full h-56" src="{{ $hotel->map }}" frameborder="0"></iframe>
        @endif
    </aside>
    <div class="bg-white border border-black/10 rounded-2xl p-6">
    <h2 class="font-display text-2xl">Galerie Photo</h2>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-10 rounded-2xl overflow-hidden">
        <img src="{{ asset('storage/'.$hotel->image_couverture) }}" class="col-span-2 row-span-2 w-full h-full object-cover min-h-[220px]">
        @foreach($hotel->photos->take(4) as $photo)
            <img src="{{ asset('storage/'.$photo->chemin) }}" class="w-full h-full object-cover min-h-[105px]">
        @endforeach
    </div>
    </div>
</div>
@endsection
