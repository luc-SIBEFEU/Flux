@extends('layouts.hotelier')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('hotelier.hotels.index') }}" class="text-sm text-violet-700">← Retour à mes hôtels</a>
            <h1 class="text-2xl font-bold text-gray-900">Chambres — {{ $hotel->nom }}</h1>
        </div>
        <a href="{{ route('hotelier.rooms.create', $hotel) }}" class="px-4 py-2 bg-violet-700 text-white rounded-lg font-semibold">+ Ajouter une catégorie</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($chambres as $chambre)
        <div class="bg-white rounded-xl shadow border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-900">{{ $chambre->nom }}</h3>
            <p class="text-sm text-gray-500">👤 {{ $chambre->capacite_adultes }} adultes · 🧒 {{ $chambre->capacite_enfants }} enfants</p>
            <p class="text-sm text-violet-700 font-semibold mt-1">{{ number_format($chambre->prix_nuit, 0) }} FCFA / nuit — {{ $chambre->quantite_disponible }} unité(s)</p>
            <div class="flex flex-wrap gap-1 mt-2">
                @foreach($chambre->amenities as $eq)
                    <span class="text-xs bg-violet-50 text-violet-700 px-2 py-0.5 rounded-full">{{ $eq->nom }}</span>
                @endforeach
            </div>
            <div class="flex gap-3 mt-3 text-sm">
                <a href="{{ route('hotelier.rooms.edit', [$hotel, $chambre]) }}" class="text-violet-700 hover:underline">Modifier</a>
                <a href="{{ route('hotelier.rooms.gallery.index', $chambre) }}" class="text-violet-700 hover:underline">Galerie</a>
                <form method="POST" action="{{ route('hotelier.rooms.destroy', [$hotel, $chambre]) }}" onsubmit="return confirm('Supprimer cette catégorie ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-gray-400 col-span-full text-center py-10">Aucune catégorie de chambre pour cet hôtel.</p>
        @endforelse
    </div>
</div>
@endsection
