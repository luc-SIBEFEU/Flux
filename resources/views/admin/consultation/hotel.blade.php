@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', $hotel->nom)
@section('titre', $hotel->nom . ' — Consultation admin')

@section('contenu')

<a href="{{ route('admin.consultation.hotels') }}" class="text-sm text-flux-noir/50 hover:text-flux-bleu">← Retour aux hôtels</a>

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
                    <div class="flex items-center justify-between py-3 text-sm">
                        <span>{{ $chambre->nom }}</span>
                        <span class="font-medium text-flux-bleu">{{ number_format($chambre->prix_nuit,0,',',' ') }} F/nuit</span>
                    </div>
                @endforeach
            </div>
        </div>

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
    </aside>
</div>
@endsection
