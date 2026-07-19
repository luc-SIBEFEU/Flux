@extends('layouts.hotelier')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Mes hôtels</h1>
        <a href="{{ route('hotelier.hotels.create') }}" class="px-4 py-2 bg-violet-700 text-white rounded-lg font-semibold">+ Ajouter un hôtel</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($hotels as $hotel)
        <div class="bg-white rounded-xl shadow border border-gray-100 p-5">
            <div class="flex gap-4">
                <img src="{{ $hotel->imageCouvertureUrl() ?? 'https://placehold.co/150x100?text=Hotel' }}" class="w-28 h-20 object-cover rounded-lg">
                <div class="flex-1">
                    <div class="flex items-center gap-2">
                        @if($hotel->logoUrl())
                            <img src="{{ $hotel->logoUrl() }}" class="w-6 h-6 rounded-full object-cover">
                        @endif
                        <h3 class="font-semibold text-gray-900">{{ $hotel->nom }}</h3>
                    </div>
                    <p class="text-sm text-gray-500">{{ $hotel->ville }} — {{ $hotel->nombre_etoiles }}★</p>
                    <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full
                        {{ $hotel->statut === 'valide' ? 'bg-green-100 text-green-700' : ($hotel->statut === 'rejete' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                        {{ ucfirst(str_replace('_', ' ', $hotel->statut)) }}
                    </span>
                </div>
            </div>
            <div class="flex flex-wrap gap-3 mt-3 text-sm">
                <a href="{{ route('hotelier.hotels.edit', $hotel) }}" class="text-violet-700 hover:underline">Modifier</a>
                <a href="{{ route('hotelier.rooms.index', $hotel) }}" class="text-violet-700 hover:underline">Chambres</a>
                <a href="{{ route('hotelier.gallery.index', $hotel) }}" class="text-violet-700 hover:underline">Galerie</a>
                <form method="POST" action="{{ route('hotelier.hotels.destroy', $hotel) }}" onsubmit="return confirm('Supprimer cet hôtel ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-gray-400 col-span-full text-center py-10">Vous n'avez pas encore ajouté d'hôtel.</p>
        @endforelse
    </div>
</div>
@endsection
