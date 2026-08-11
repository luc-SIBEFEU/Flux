@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre_page', 'Hôtels à valider')
@section('titre', 'Validation des hôtels — Admin')

@section('contenu')

<p class="text-sm text-flux-noir/50 mb-6">{{ $hotels->total() }} hôtel(s) en attente de validation</p>

<div class="space-y-4">
    @forelse($hotels as $hotel)
        <div class="bg-white border border-black/10 rounded-2xl p-5 flex flex-col sm:flex-row gap-4" x-data="{ rejet: false }">
            <img src="{{ asset('storage/'.$hotel->image_couverture) }}" class="w-full sm:w-40 h-28 rounded-xl object-cover shrink-0">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    @for($i=0; $i<$hotel->nombre_etoiles; $i++)<x-icon name="star-filled" class="w-3.5 h-3.5 text-flux-or" />@endfor
                </div>
                <h3 class="font-medium">{{ $hotel->nom }}</h3>
                <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="map-pin" class="w-3.5 h-3.5" /> {{ $hotel->ville }}</p>
                <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="user" class="w-3.5 h-3.5" /> {{ $hotel->hotelier->nom }} — {{ $hotel->hotelier->email }}</p>

                <div class="flex flex-wrap gap-3 mt-4">
                    <form action="{{ route('admin.hotels.approuver', $hotel) }}" method="POST">
                        @csrf
                        <button class="inline-flex items-center gap-1.5 bg-flux-bleu text-white text-sm font-medium px-4 py-2 rounded-lg">
                            <x-icon name="check-circle" class="w-4 h-4" /> Approuver
                        </button>
                    </form>
                    <button @click="rejet = !rejet" class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 text-sm font-medium px-4 py-2 rounded-lg">
                        <x-icon name="x-circle" class="w-4 h-4" /> Rejeter
                    </button>
                </div>

                <form x-show="rejet" x-cloak action="{{ route('admin.hotels.rejeter', $hotel) }}" method="POST" class="mt-3 flex gap-2">
                    @csrf
                    <input type="text" name="motif_rejet" required placeholder="Motif du rejet" class="flex-1 border border-black/10 rounded-lg px-3 py-2 text-sm">
                    <button class="bg-red-500 text-white text-sm font-medium px-4 py-2 rounded-lg">Confirmer</button>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center py-16 text-flux-noir/40">
            <x-icon name="check-circle" class="w-10 h-10 mx-auto mb-3" />
            Aucun hôtel en attente. Tout est à jour !
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $hotels->links() }}</div>
@endsection
