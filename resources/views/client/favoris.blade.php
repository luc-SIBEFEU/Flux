@extends('layouts.dashboard')
@php $espaceRole = 'client'; @endphp
@section('titre_page', 'Mes favoris')
@section('titre', 'Favoris — Mon espace')

@section('contenu')

<form method="GET" class="flex items-center gap-2 border border-black/10 rounded-lg px-3 py-2 bg-white mb-6 max-w-xs">
    <x-icon name="map-pin" class="w-4 h-4 text-flux-noir/40" />
    <input type="text" name="ville" value="{{ request('ville') }}" placeholder="Filtrer par ville..." class="outline-none text-sm w-full">
</form>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
    @forelse($favoris as $hotel)
        <a href="{{ route('hotels.show', $hotel) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-black/5 hover:shadow-lg transition-shadow">
            <div class="relative">
                <img src="{{ asset('storage/'.$hotel->image_couverture) }}" class="w-full h-40 object-cover">
                <span class="absolute top-3 left-3 flex items-center gap-1 bg-white/90 backdrop-blur px-2.5 py-1 rounded-full text-xs font-semibold">
                    <x-icon name="star-filled" class="w-3.5 h-3.5 text-flux-or" /> {{ number_format($hotel->note_moyenne,1) }}
                </span>
                <form action="{{ route('favoris.toggle', $hotel) }}" method="POST" class="absolute top-3 right-3" onclick="event.stopPropagation()">
                    @csrf
                    <button class="w-8 h-8 rounded-full bg-white/90 flex items-center justify-center">
                        <x-icon name="heart-filled" class="w-4 h-4 text-flux-violet" />
                    </button>
                </form>
            </div>
            <div class="p-4">
                <h3 class="font-medium">{{ $hotel->nom }}</h3>
                <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="map-pin" class="w-3.5 h-3.5" /> {{ $hotel->ville }}</p>
            </div>
        </a>
    @empty
        <div class="col-span-full text-center py-16 text-flux-noir/40">
            <x-icon name="heart" class="w-10 h-10 mx-auto mb-3" />
            Aucun hôtel en favori pour le moment.
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $favoris->links() }}</div>
@endsection
