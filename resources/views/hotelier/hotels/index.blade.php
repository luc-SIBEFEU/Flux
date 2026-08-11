@extends('layouts.dashboard')
@php $espaceRole = 'hotelier'; @endphp
@section('titre_page', 'Mes hôtels')
@section('titre', 'Mes hôtels — Hôtelier')

@section('contenu')

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <p class="text-sm text-flux-noir/50">{{ $hotels->count() }} hôtel(s)</p>
    <div class="flex gap-3">
        <form method="GET" class="flex gap-2">
            <select name="statut" onchange="this.form.submit()" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
                <option value="">Tous les statuts</option>
                <option value="en_attente" {{ request('statut')=='en_attente'?'selected':'' }}>En attente</option>
                <option value="valide" {{ request('statut')=='valide'?'selected':'' }}>Validés</option>
                <option value="rejete" {{ request('statut')=='rejete'?'selected':'' }}>Rejetés</option>
            </select>
        </form>
        <a href="{{ route('hotelier.hotels.create') }}" class="inline-flex items-center gap-2 bg-flux-bleu text-white text-sm font-medium px-4 py-2.5 rounded-lg">
            <x-icon name="plus" class="w-4 h-4" /> Ajouter un hôtel
        </a>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach($hotels as $hotel)
        <div class="bg-white border border-black/10 rounded-2xl overflow-hidden">
            <div class="relative">
                <img src="{{ asset('storage/'.$hotel->image_couverture) }}" class="w-full h-36 object-cover">
                @php
                    $badges = ['en_attente'=>'bg-flux-or/90 text-flux-noir','valide'=>'bg-flux-bleu text-white','rejete'=>'bg-red-500 text-white'];
                @endphp
                <span class="absolute top-3 left-3 text-xs font-semibold px-2.5 py-1 rounded-full {{ $badges[$hotel->statut] }}">
                    {{ ucfirst(str_replace('_',' ',$hotel->statut)) }}
                </span>
            </div>
            <div class="p-5">
                <h3 class="font-medium">{{ $hotel->nom }}</h3>
                <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="map-pin" class="w-3.5 h-3.5" /> {{ $hotel->ville }}</p>

                <div class="flex flex-wrap gap-3 mt-4">
                    <a href="{{ route('hotelier.hotels.edit', $hotel) }}" class="inline-flex items-center gap-1.5 text-sm text-flux-bleu font-medium">
                        <x-icon name="pencil" class="w-4 h-4" /> Modifier
                    </a>
                    <a href="{{ route('hotelier.hotels.chambres.index', $hotel) }}" class="inline-flex items-center gap-1.5 text-sm text-flux-noir/70 font-medium">
                        <x-icon name="key" class="w-4 h-4" /> Chambres
                    </a>
                    <form action="{{ route('hotelier.hotels.destroy', $hotel) }}" method="POST" onsubmit="return confirm('Supprimer cet hôtel ?')">
                        @csrf @method('DELETE')
                        <button class="inline-flex items-center gap-1.5 text-sm text-red-500 font-medium">
                            <x-icon name="trash" class="w-4 h-4" /> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
