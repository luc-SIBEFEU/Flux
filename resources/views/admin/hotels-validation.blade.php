@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Validation des hôtels</h1>

    <div class="flex gap-2 mb-6">
        @foreach(['en_attente' => 'En attente', 'valide' => 'Validés', 'rejete' => 'Rejetés', 'tout' => 'Tous'] as $val => $label)
            <a href="{{ route('admin.hotels.validation', ['filtre' => $val]) }}"
               class="px-4 py-2 rounded-full text-sm font-medium {{ $filtre === $val ? 'bg-violet-700 text-white' : 'bg-white text-gray-600 border' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($hotels as $hotel)
        <div class="bg-white rounded-xl shadow border border-gray-100 p-5 flex gap-4">
            <img src="{{ $hotel->imageCouvertureUrl() ?? 'https://placehold.co/150x100?text=Hotel' }}" class="w-28 h-20 object-cover rounded-lg">
            <div class="flex-1">
                <div class="flex items-center gap-2">
                    @if($hotel->logoUrl())
                        <img src="{{ $hotel->logoUrl() }}" class="w-6 h-6 rounded-full object-cover">
                    @endif
                    <h3 class="font-semibold text-gray-900">{{ $hotel->nom }}</h3>
                </div>
                <p class="text-sm text-gray-500">{{ $hotel->ville }} — {{ $hotel->nombre_etoiles }}★</p>
                <p class="text-xs text-gray-400">Hôtelier : {{ $hotel->hotelier->nom }}</p>
                <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full
                    {{ $hotel->statut === 'valide' ? 'bg-green-100 text-green-700' : ($hotel->statut === 'rejete' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                    {{ ucfirst(str_replace('_', ' ', $hotel->statut)) }}
                </span>

                @if($hotel->statut === 'en_attente')
                <div class="mt-3 flex gap-2">
                    <form method="POST" action="{{ route('admin.hotels.valider', $hotel) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="px-3 py-1.5 bg-green-600 text-white text-sm rounded-lg">Valider</button>
                    </form>
                    <form method="POST" action="{{ route('admin.hotels.rejeter', $hotel) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-sm rounded-lg">Rejeter</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @empty
        <p class="text-gray-400 col-span-full text-center py-10">Aucun hôtel dans cette catégorie.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $hotels->links() }}</div>
</div>
@endsection
